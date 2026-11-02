<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('order.user')->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where('payment_code', 'like', '%'.$request->search.'%')
                  ->orWhereHas('order', fn($q) => $q->where('order_number', 'like', '%'.$request->search.'%'))
                  ->orWhereHas('order.user', fn($q) => $q->where('name', 'like', '%'.$request->search.'%'));
        }

        $payments = $query->paginate(15)->withQueryString();
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('order.user', 'order.items.service');
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Payment $payment)
    {
        $payment->update([
            'status'  => 'paid',
            'paid_at' => now(),
        ]);

        if ($payment->stage === 'dp') {
            $remaining = round($payment->order->total - $payment->amount, 2);
            if ($remaining > 0 && ! $payment->order->payments()->where('stage', 'final')->exists()) {
                $payment->order->payments()->create([
                    'payment_code' => 'PAY-' . strtoupper(uniqid()),
                    'method'       => $payment->method,
                    'stage'        => 'final',
                    'amount'       => $remaining,
                    'status'       => 'unpaid',
                ]);
            }
        } else {
            $payment->order->update(['status' => 'confirmed']);
        }

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function reject(Payment $payment)
    {
        $payment->update(['status' => 'failed']);
        return back()->with('success', 'Pembayaran ditolak.');
    }
}
