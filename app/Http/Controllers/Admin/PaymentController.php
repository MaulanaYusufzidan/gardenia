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
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('payment_code', 'like', "%{$term}%")
                  ->orWhereHas('order', fn ($o) => $o->where('order_number', 'like', "%{$term}%"))
                  ->orWhereHas('order.user', fn ($u) => $u->where('name', 'like', "%{$term}%"));
            });
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
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Hanya pembayaran berstatus menunggu verifikasi yang dapat diverifikasi.');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($payment) {
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

        });

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function reject(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Hanya pembayaran berstatus menunggu verifikasi yang dapat ditolak.');
        }

        $payment->update(['status' => 'failed']);
        return back()->with('success', 'Pembayaran ditolak.');
    }
}
