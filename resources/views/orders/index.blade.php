@extends('layouts.app')
@section('title', 'Pesanan Saya — CV. Gardenia Setia Utama')

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header-clean text-center">
  <div class="container">
    <h1>Pesanan Saya</h1>
    <p>Pantau status kontrak, proses verifikasi pembayaran, dan progres pengerjaan proyek Anda.</p>
  </div>
</section>

<div class="container py-5">
  @if($orders->isEmpty())
    <div class="card-clean p-5 text-center my-4">
      <div class="p-3 rounded-circle bg-light d-inline-flex mb-3 border">
        <i class="bi bi-clipboard-check fs-3 text-muted"></i>
      </div>
      <h3 class="fw-bold fs-5 mb-1 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Belum Ada Riwayat Pesanan</h3>
      <p class="text-muted small mb-4">Anda belum memiliki transaksi pesanan layanan atau paket desain aktif.</p>
      <div>
        <a href="{{ route('services') }}" class="btn-gardenia">Pilih Layanan Sekarang</a>
      </div>
    </div>
  @else
    <div class="card-clean overflow-hidden mb-4">
      <div class="table-responsive">
        <table class="table table-clean mb-0 align-middle">
          <thead>
            <tr>
              <th>No. Order</th>
              <th>Nama Proyek</th>
              <th>Total Biaya</th>
              <th>Status Bayar</th>
              <th>Status Proyek</th>
              <th>Tanggal</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            <tr>
              <td>
                <span class="fw-semibold small text-dark">{{ $order->order_number }}</span>
              </td>
              <td>
                <span class="small text-secondary">{{ Str::limit($order->project_name, 32) }}</span>
              </td>
              <td>
                <span class="fw-semibold small text-dark">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
              </td>
              <td>
                @php $ps = $order->payment?->status ?? 'unpaid'; @endphp
                <span class="badge-status badge-status-{{ $ps }}">
                  {{ strtoupper($ps) }}
                </span>
              </td>
              <td>
                <span class="badge-status badge-status-{{ $order->status }}">
                  {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                </span>
              </td>
              <td>
                <span class="small text-muted">{{ $order->created_at->format('d M Y') }}</span>
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
    </div>

    <div class="d-flex justify-content-center">
      {{ $orders->links() }}
    </div>
  @endif
</div>

@endsection

