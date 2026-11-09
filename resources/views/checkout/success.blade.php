@extends('layouts.app')
@section('title', 'Pesanan Berhasil | CV. Gardenia Setia Utama')

@section('content')
<div class="container py-5">
  <div class="card-clean mx-auto p-4 p-md-5" style="max-width: 620px;">
    
    <div class="text-center mb-4">
      <div class="p-3 rounded-circle bg-success-subtle text-success d-inline-flex mb-3 border border-success-subtle">
        <i class="bi bi-check-lg fs-2"></i>
      </div>
      <h1 class="fw-bold fs-3 text-dark mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pesanan Berhasil Dibuat</h1>
      <p class="text-muted small">Terima kasih. Pesanan Anda telah tercatat dalam sistem kami.</p>
    </div>

    {{-- DETAIL PESANAN SINGKAT --}}
    <div class="p-3.5 bg-light rounded-3 mb-4 border p-3">
      <div class="d-flex flex-column gap-2 small">
        <div class="d-flex justify-content-between pb-2 border-bottom">
          <span class="text-muted">Nomor Order</span>
          <span class="fw-bold text-dark">{{ $order->order_number }}</span>
        </div>
        <div class="d-flex justify-content-between pb-2 border-bottom">
          <span class="text-muted">Nama Proyek</span>
          <span class="text-dark fw-medium">{{ $order->project_name }}</span>
        </div>
        <div class="d-flex justify-content-between pb-2 border-bottom">
          <span class="text-muted">Total Kontrak Pesanan</span>
          <span class="text-dark">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
        </div>
        <div class="d-flex justify-content-between pb-2 border-bottom">
          <span class="text-muted">Tagihan Saat Ini</span>
          <span class="fw-bold text-success fs-6">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</span>
        </div>
        <div class="d-flex justify-content-between pb-2 border-bottom">
          <span class="text-muted">Skema Pembayaran</span>
          <span class="text-dark fw-medium">{{ $order->payment->stage === 'dp' ? 'Uang Muka (DP 30%)' : 'Pembayaran Penuh (100%)' }}</span>
        </div>
        <div class="d-flex justify-content-between">
          <span class="text-muted">Metode</span>
          <span class="text-dark fw-medium">{{ $order->payment->method === 'transfer' ? 'Transfer Bank BCA' : 'Pembayaran Online' }}</span>
        </div>
      </div>
    </div>

    {{-- INSTRUKSI PEMBAYARAN --}}
    @if($order->payment->method === 'transfer')
      <div class="p-3.5 rounded-3 mb-4 border bg-white p-3">
        <div class="fw-bold small text-dark mb-2">Instruksi Pembayaran Manual:</div>
        <ol class="mb-0 small text-muted ps-3 d-flex flex-column gap-1.5">
          <li>Transfer ke rekening: <strong>BCA 1234567890</strong> a/n <strong>CV Gardenia Setia Utama</strong></li>
          <li>Nominal transfer tepat: <strong>Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</strong></li>
          <li>Unggah bukti transfer Anda di halaman <strong>Pesanan Saya</strong></li>
          <li>Verifikasi pembayaran diproses maksimal dalam <strong>1x24 jam kerja</strong></li>
        </ol>
      </div>
    @else
      <div class="p-3.5 rounded-3 mb-4 border bg-white p-3 small text-muted">
        Tim kami akan mengonfirmasi status pembayaran online Anda dalam 1x2 jam kerja. Anda dapat memantau status secara berkala di dashboard.
      </div>
    @endif

    <div class="d-flex gap-2 justify-content-center">
      <a href="{{ route('orders.show', $order) }}" class="btn-gardenia flex-fill text-center">
        Lihat Detail Pesanan
      </a>
      <a href="{{ route('home') }}" class="btn-gardenia-outline flex-fill text-center">
        Kembali ke Beranda
      </a>
    </div>

  </div>
</div>
@endsection

