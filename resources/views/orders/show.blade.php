@extends('layouts.app')
@section('title', 'Detail Pesanan #' . $order->order_number . ' | CV. Gardenia Setia Utama')

@section('content')

{{-- BREADCRUMB --}}
<div class="bg-light border-bottom py-3">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 small">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" class="text-decoration-none text-muted">Pesanan Saya</a></li>
        <li class="breadcrumb-item active text-dark fw-medium" aria-current="page">{{ $order->order_number }}</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-5">
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-between p-3 mb-4 rounded-3 border-0 bg-success-subtle text-success">
      <span class="small fw-medium">{{ session('success') }}</span>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
  @endif

  <div class="row g-4 g-lg-5">
    
    {{-- DETAIL PROYEK & ITEM --}}
    <div class="col-lg-8">
      <div class="card-clean p-4 p-md-5 mb-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center pb-3 mb-4 border-bottom gap-2">
          <div>
            <span class="text-muted small">Nomor Kontrak Order</span>
            <h1 class="fw-bold fs-4 mb-0 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $order->order_number }}</h1>
          </div>
          <span class="badge-status badge-status-{{ $order->status }} align-self-start align-self-sm-auto">
            Status: {{ strtoupper(str_replace('_', ' ', $order->status)) }}
          </span>
        </div>

        <div class="row g-3 mb-4 small">
          <div class="col-sm-4 text-muted">Nama Proyek:</div>
          <div class="col-sm-8 fw-semibold text-dark">{{ $order->project_name }}</div>
          
          <div class="col-sm-4 text-muted">Alamat Lokasi:</div>
          <div class="col-sm-8 text-secondary">{{ $order->project_address }}</div>
          
          <div class="col-sm-4 text-muted">Catatan Khusus:</div>
          <div class="col-sm-8 text-secondary">{{ $order->notes ?? '-' }}</div>
          
          <div class="col-sm-4 text-muted">Tanggal Dibuat:</div>
          <div class="col-sm-8 text-secondary">{{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</div>
        </div>

        <h3 class="fw-bold fs-6 mb-3 text-dark">Rincian Item Layanan:</h3>
        
        <div class="table-responsive border rounded-2 mb-3">
          <table class="table table-clean mb-0 align-middle">
            <thead>
              <tr>
                <th>Layanan</th>
                <th>Harga Satuan</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order->items as $item)
              <tr>
                <td><span class="fw-medium small text-dark">{{ $item->name }}</span></td>
                <td><span class="small text-muted">Rp {{ number_format($item->price, 0, ',', '.') }}</span></td>
                <td class="text-center"><span class="small text-dark">{{ $item->quantity }}</span></td>
                <td class="text-end"><span class="small fw-semibold text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span></td>
              </tr>
              @endforeach
            </tbody>
            <tfoot class="bg-light">
              <tr>
                <td colspan="3" class="text-end small text-muted">Subtotal</td>
                <td class="text-end small fw-medium text-dark">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
              </tr>
              <tr>
                <td colspan="3" class="text-end small text-muted">PPN (11%)</td>
                <td class="text-end small fw-medium text-dark">Rp {{ number_format($order->tax, 0, ',', '.') }}</td>
              </tr>
              <tr>
                <td colspan="3" class="text-end fw-bold small text-dark">Total Kontrak</td>
                <td class="text-end fw-bold small" style="color:var(--primary)">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

    {{-- STATUS & VERIFIKASI PEMBAYARAN --}}
    <div class="col-lg-4">
      <div class="card-clean p-4 position-sticky" style="top: 90px;">
        <h3 class="fw-bold fs-5 mb-3 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Tahapan Pembayaran</h3>
        
        @if($order->payments->isNotEmpty())
          <div class="d-flex flex-column gap-3 mb-4">
            @foreach($order->payments as $payment)
            <div class="p-3 rounded-2 border bg-light">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold small text-dark">
                  {{ strtoupper($payment->stage === 'dp' ? 'Uang Muka (DP 30%)' : ($payment->stage === 'final' ? 'Pelunasan (70%)' : 'Pembayaran Penuh')) }}
                </span>
                <span class="badge-status badge-status-{{ $payment->status }}">
                  {{ strtoupper($payment->status) }}
                </span>
              </div>
              <div class="d-flex justify-content-between align-items-center text-muted small mt-2">
                <span>Kode: {{ $payment->payment_code }}</span>
                <span class="fw-bold text-dark fs-6">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
              </div>
            </div>
            @endforeach
          </div>
        @endif

        {{-- JIKA BUTUH UPLOAD BUKTI TRANSFER --}}
        @if($order->payment && $order->payment->status === 'unpaid' && $order->payment->method === 'transfer')
          <div class="p-3 rounded-2 border bg-white mb-3">
            <div class="fw-bold small text-dark mb-1">Rekening Tujuan:</div>
            <div class="text-muted small mb-2">
              BCA <strong>1234567890</strong><br>
              a/n CV Gardenia Setia Utama<br>
              Nominal: <strong class="text-success">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</strong>
            </div>

            <form action="{{ route('payment.upload', $order) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <label class="form-label small">Unggah Bukti Transfer</label>
              <input type="file" name="proof" class="form-control form-control-sm mb-3" accept="image/*" required>
              <button type="submit" class="btn-gardenia btn-gardenia-sm w-100 py-2">
                Kirim Bukti Pembayaran
              </button>
            </form>
          </div>
        @elseif($order->payment && $order->payment->proof)
          <div class="p-3 rounded-2 border bg-light text-center mb-3">
            <div class="text-muted small mb-2">Bukti Transfer Terunggah:</div>
            <img src="{{ asset('storage/'.$order->payment->proof) }}" alt="Bukti Transfer" class="img-fluid rounded border shadow-xs" style="max-height: 160px; object-fit: cover;">
          </div>
        @endif

        <div class="d-grid gap-2">
          <a href="{{ route('orders.index') }}" class="btn-gardenia-outline btn-gardenia-sm text-center">
            ← Kembali ke Pesanan Saya
          </a>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

