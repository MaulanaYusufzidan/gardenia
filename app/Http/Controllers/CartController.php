<?php
namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Http\Request;

class CartController extends Controller {
    public function index() {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request) {
        $request->validate(['service_id' => 'required|exists:services,id']);
        $service = Service::findOrFail($request->service_id);
        $cart = session()->get('cart', []);
        if (isset($cart[$service->id])) {
            $cart[$service->id]['quantity'] += 1;
        } else {
            $cart[$service->id] = [
                'name'     => $service->name,
                'price'    => $service->price ?? 0,
                'quantity' => 1,
                'category' => $service->category,
                'kbli'     => $service->kbli_code,
            ];
        }
        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Layanan berhasil ditambahkan ke keranjang!');
    }

    public function remove($id) {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Layanan dihapus dari keranjang.');
    }

    public function clear() {
        session()->forget('cart');
        return redirect()->route('cart.index');
    }
}
