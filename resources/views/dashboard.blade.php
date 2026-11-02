@extends('layouts.app')
@section('title', 'Dashboard Akun — CV. Gardenia Setia Utama')

@section('content')

{{-- WELCOME BANNER --}}
<section class="page-header-clean text-center text-md-start py-4">
  <div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
      <div>
        <h1 class="fs-3 mb-1">Selamat Datang, {{ auth()->user()->name }}</h1>
        <p class="text-white-50 small mb-0">Kelola riwayat pesanan, status verifikasi pembayaran, dan rancangan proyek Anda.</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('services') }}" class="btn-gardenia-gold btn-gardenia-sm">Pesan Layanan Baru</a>
        <a href="{{ route('spk.index') }}" class="btn-gardenia-outline btn-gardenia-sm" style="border-color:rgba(255,255,255,0.3);color:#fff !important;">Kalkulator SAW</a>
      </div>
    </div>
  </div>
</section>

<div class="container py-5">
  
  {{-- METRIC STATS CARDS --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="card-clean p-3 text-center">
        <div class="text-muted small text-uppercase fw-semibold" style="font-size:0.7rem;letter-spacing:0.04em;">Total Pesanan</div>
        <div class="fs-4 fw-bold text-dark mt-1">{{ \App\Models\Order::where('user_id', auth()->id())->count() }}</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card-clean p-3 text-center">
        <div class="text-muted small text-uppercase fw-semibold" style="font-size:0.7rem;letter-spacing:0.04em;">Menunggu Konfirmasi</div>
        <div class="fs-4 fw-bold text-warning mt-1">{{ \App\Models\Order::where('user_id', auth()->id())->where('status','pending')->count() }}</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card-clean p-3 text-center">
        <div class="text-muted small text-uppercase fw-semibold" style="font-size:0.7rem;letter-spacing:0.04em;">Sedang Dikerjakan</div>
        <div class="fs-4 fw-bold text-primary mt-1">{{ \App\Models\Order::where('user_id', auth()->id())->where('status','in_progress')->count() }}</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card-clean p-3 text-center">
        <div class="text-muted small text-uppercase fw-semibold" style="font-size:0.7rem;letter-spacing:0.04em;">Proyek Selesai</div>
        <div class="fs-4 fw-bold text-success mt-1">{{ \App\Models\Order::where('user_id', auth()->id())->where('status','completed')->count() }}</div>
      </div>
    </div>
  </div>

  {{-- PESANAN TERBARU TABLE --}}
  <div class="card-clean mb-4 overflow-hidden">
    <div class="p-3.5 px-4 border-bottom bg-white d-flex justify-content-between align-items-center p-3">
      <div>
        <h2 class="fw-bold fs-6 mb-0 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pesanan Terbaru</h2>
        <span class="text-muted small">5 transaksi pemesanan terakhir Anda</span>
      </div>
      <a href="{{ route('orders.index') }}" class="btn-gardenia-outline btn-gardenia-sm">Lihat Semua Pesanan</a>
    </div>

    <div class="p-0">
      @if($orders->isEmpty())
        <div class="text-center py-5">
          <div class="text-muted small mb-3">Belum ada aktivitas transaksi pesanan.</div>
          <a href="{{ route('services') }}" class="btn-gardenia btn-gardenia-sm">Mulai Pesan Layanan</a>
        </div>
      @else
        <div class="table-responsive">
          <table class="table table-clean mb-0 align-middle">
            <thead>
              <tr>
                <th>No. Order</th>
                <th>Nama Proyek</th>
                <th>Total Biaya</th>
                <th>Status</th>
                <th class="text-end">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
              <tr>
                <td><span class="fw-semibold small text-dark">{{ $order->order_number }}</span></td>
                <td><span class="small text-secondary">{{ Str::limit($order->project_name, 35) }}</span></td>
                <td><span class="fw-semibold small text-dark">Rp {{ number_format($order->total, 0, ',', '.') }}</span></td>
                <td>
                  <span class="badge-status badge-status-{{ $order->status }}">
                    {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                  </span>
                </td>
                <td class="text-end">
                  <a href="{{ route('orders.show', $order) }}" class="btn-gardenia-outline btn-gardenia-sm py-1 px-2.5" style="font-size:0.78rem;">
                    Detail
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>

  {{-- PINTASAN CEPAT --}}
  <div class="row g-3">
    <div class="col-md-4">
      <a href="{{ route('services') }}" class="card-clean card-clean-hover p-4 d-block text-decoration-none text-dark h-100">
        <div class="fw-semibold mb-1">Katalog Layanan</div>
        <p class="text-muted small mb-0">Eksplorasi layanan arsitektur, interior, konstruksi, dan lansekap.</p>
      </a>
    </div>
    <div class="col-md-4">
      <a href="{{ route('cart.index') }}" class="card-clean card-clean-hover p-4 d-block text-decoration-none text-dark h-100">
        <div class="fw-semibold mb-1">Keranjang Layanan</div>
        <p class="text-muted small mb-0">Lihat item layanan yang siap Anda ajukan untuk checkout.</p>
      </a>
    </div>
    <div class="col-md-4">
      <a href="{{ route('spk.history') }}" class="card-clean card-clean-hover p-4 d-block text-decoration-none text-dark h-100">
        <div class="fw-semibold mb-1">Riwayat Rekomendasi SAW</div>
        <p class="text-muted small mb-0">Lihat riwayat kalkulasi paket desain yang pernah Anda simpan.</p>
      </a>
    </div>
  </div>

</div>

@endsection

