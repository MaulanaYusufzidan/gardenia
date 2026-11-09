<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller {
    public function upload(Request $request, Order $order) {
        abort_unless($order->user_id === auth()->id(), 403);
        $currentPayment = $order->payment;

        if (! $currentPayment || ! in_array($currentPayment->status, ['unpaid', 'failed'], true)) {
            return back()->with('error', 'Tidak ada pembayaran aktif yang bisa diupload bukti.');
        }

        $request->validate(['proof' => 'required|image|mimes:jpg,jpeg,png|max:2048']);
        if ($currentPayment->proof) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($currentPayment->proof);
        }
        $path = $request->file('proof')->store('payment-proofs', 'public');
        $currentPayment->update(['proof' => $path, 'status' => 'pending']);

        return redirect()->route('orders.show', $order)->with('success', 'Bukti transfer berhasil diupload! Kami akan mengkonfirmasi dalam 1x24 jam.');
    }
}
