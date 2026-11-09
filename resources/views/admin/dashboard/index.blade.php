@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Ringkasan Dashboard')

@section('content')

{{-- SAPAAN --}}
<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
  <div>
    <h2 class="fw-bold fs-5 mb-1 text-dark" style="color:var(--primary-dark)!important;">Selamat datang, {{ \Illuminate\Support\Str::before(auth()->user()->name, ' ') }}</h2>
    <p class="text-muted small mb-0">Ringkasan aktivitas pesanan, pembayaran, dan layanan CV. Gardenia Setia Utama.</p>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.payments.index') }}?status=pending" class="btn-gardenia-outline-sm"><i class="bi bi-credit-card"></i> Verifikasi Pembayaran</a>
    <a href="{{ route('admin.orders.index') }}" class="btn-gardenia-sm"><i class="bi bi-clipboard-check"></i> Kelola Pesanan</a>
  </div>
</div>

{{-- STAT METRICS CARDS --}}
<div class="row g-3 mb-4">
  @php
  $cards = [
    ['label'=>'Total Pesanan',      'value'=>$stats['total_orders'],    'icon'=>'bi-clipboard-check', 'color'=>'#183e2b'],
    ['label'=>'Pesanan Pending',    'value'=>$stats['pending_orders'],  'icon'=>'bi-hourglass-split', 'color'=>'#d97706'],
    ['label'=>'Pembayaran Menunggu','value'=>$stats['pending_payments'],'icon'=>'bi-credit-card',     'color'=>'#2563eb'],
    ['label'=>'Total Pengguna',     'value'=>$stats['total_users'],     'icon'=>'bi-people',          'color'=>'#7c3aed'],
    ['label'=>'Layanan Aktif',      'value'=>$stats['total_services'],  'icon'=>'bi-layers',          'color'=>'#059669'],
    ['label'=>'Total Pendapatan',   'value'=>'Rp '.number_format($stats['total_revenue'], 0, ',', '.'), 'icon'=>'bi-wallet2', 'color'=>'#183e2b'],
  ];
  @endphp
  
  @foreach($cards as $c)
  <div class="col-sm-6 col-lg-4">
    <div class="card-clean p-3 h-100" style="border-left:3px solid {{ $c['color'] }};">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small text-uppercase fw-semibold" style="font-size:0.7rem;letter-spacing:0.04em;">{{ $c['label'] }}</span>
          <div class="fw-bold fs-5 text-dark mt-1">{{ $c['value'] }}</div>
        </div>
        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:{{ $c['color'] }}14;color:{{ $c['color'] }};border:1px solid {{ $c['color'] }}26;">
          <i class="bi {{ $c['icon'] }} fs-5"></i>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

<div class="row g-4">
  {{-- PESANAN TERBARU --}}
  <div class="col-lg-7">
    <div class="card-clean overflow-hidden h-100">
      <div class="p-3.5 px-4 border-bottom bg-white d-flex justify-content-between align-items-center p-3">
        <div>
          <h2 class="fw-bold fs-6 mb-0 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pesanan Terbaru</h2>
          <span class="text-muted" style="font-size:0.75rem;">Transaksi proyek terbaru yang masuk</span>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn-gardenia-outline-sm">Semua Pesanan</a>
      </div>

      <div class="table-responsive">
        <table class="table table-clean mb-0 align-middle">
          <thead>
            <tr>
              <th>No. Order</th>
              <th>Klien</th>
              <th>Total</th>
              <th>Status</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recent_orders as $order)
            <tr>
              <td><span class="fw-semibold small text-dark">{{ $order->order_number }}</span></td>
              <td><span class="small text-secondary">{{ Str::limit($order->user->name, 18) }}</span></td>
              <td><span class="fw-semibold small text-dark">Rp {{ number_format($order->total, 0, ',', '.') }}</span></td>
              <td>
                <span class="badge-status badge-status-{{ $order->status }}">
                  {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                </span>
              </td>
              <td class="text-end">
                <a href="{{ route('admin.orders.show', $order) }}" class="btn-gardenia-outline-sm py-0.5 px-2" style="font-size:0.75rem;">
                  Detail
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4 small">Belum ada transaksi pesanan.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- PEMBAYARAN MENUNGGU VERIFIKASI --}}
  <div class="col-lg-5">
    <div class="card-clean overflow-hidden h-100">
      <div class="p-3.5 px-4 border-bottom bg-white d-flex justify-content-between align-items-center p-3">
        <div>
          <h2 class="fw-bold fs-6 mb-0 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pembayaran Pending</h2>
          <span class="text-muted" style="font-size:0.75rem;">Perlu verifikasi admin</span>
        </div>
        <a href="{{ route('admin.payments.index') }}?status=pending" class="btn-gardenia-outline-sm">Semua</a>
      </div>

      <div class="table-responsive">
        <table class="table table-clean mb-0 align-middle">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Klien</th>
              <th>Nominal</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recent_payments as $payment)
            <tr>
              <td><span class="fw-semibold small text-dark">{{ $payment->payment_code }}</span></td>
              <td><span class="small text-secondary">{{ Str::limit($payment->order->user->name, 14) }}</span></td>
              <td><span class="fw-semibold small text-dark">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span></td>
              <td class="text-end">
                <a href="{{ route('admin.payments.show', $payment) }}" class="btn-gardenia-sm py-0.5 px-2" style="font-size:0.75rem;">
                  Verifikasi
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center text-muted py-4 small">Tidak ada pembayaran menunggu verifikasi.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

