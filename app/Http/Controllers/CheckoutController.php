<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller {
    public function index() {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        $tax      = $subtotal * 0.11;
        $total    = $subtotal + $tax;
        $prefill = session()->get('checkout_prefill', []);
        return view('checkout.index', compact('cart', 'subtotal', 'tax', 'total', 'prefill'));
    }

    public function store(Request $request) {
        $request->validate([
            'project_name'    => 'required|string|max:255',
            'project_address' => 'required|string',
            'payment_method'  => 'required|in:transfer',
            'payment_plan'    => 'required|in:full,dp',
            'notes'           => 'nullable|string',
        ]);

        $cart     = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart.index');

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        $tax      = $subtotal * 0.11;
        $total    = $subtotal + $tax;
        $stage    = $request->payment_plan === 'dp' ? 'dp' : 'full';
        $amount   = $stage === 'dp' ? round($total * 0.3, 2) : $total;

        $order = DB::transaction(function () use ($request, $cart, $subtotal, $tax, $total, $stage, $amount) {
            $order = Order::create([
                'user_id'         => auth()->id(),
                'order_number'    => 'GSU-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5)),
                'project_name'    => $request->project_name,
                'project_address' => $request->project_address,
                'notes'           => $request->notes,
                'subtotal'        => $subtotal,
                'tax'             => $tax,
                'total'           => $total,
                'status'          => 'pending',
            ]);

            foreach ($cart as $cartKey => $item) {
        // Ambil service_id dari dalam item jika ada (null untuk paket SPK).
        // Jika tidak ada field service_id, pakai cart key sebagai integer.
        $serviceId = array_key_exists('service_id', $item)
            ? $item['service_id']
            : (is_numeric($cartKey) ? (int) $cartKey : null);

        $order->items()->create([
            'service_id' => $serviceId,
            'name'       => $item['name'],
            'price'      => $item['price'],
            'quantity'   => $item['quantity'],
            'subtotal'   => $item['price'] * $item['quantity'],
        ]);
    }

            Payment::create([
                'order_id'     => $order->id,
                'payment_code' => 'PAY-' . strtoupper(uniqid()),
                'method'       => $request->payment_method,
                'stage'        => $stage,
                'amount'       => $amount,
                'status'       => 'unpaid',
            ]);

            return $order;
        });

        session()->forget(['cart', 'checkout_prefill']);
        return redirect()->route('checkout.success', $order)->with('success', 'Pesanan berhasil dibuat!');
    }

    public function success(Order $order) {
        abort_unless($order->user_id === auth()->id(), 403);
        $order->load('items', 'payment');
        return view('checkout.success', compact('order'));
    }
}
