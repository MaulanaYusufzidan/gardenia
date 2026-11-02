@extends('admin.layouts.app')
@section('title', 'Detail Pesanan #' . $order->order_number)
@section('page-title', 'Detail Pesanan Proyek')

@section('content')

<div class="mb-3">
  <a href="{{ route('admin.orders.index') }}" class="btn-gardenia-outline-sm">
    ← Kembali ke Daftar Pesanan
  </a>
</div>

<div class="row g-4">
  {{-- INFO PESANAN & ITEM --}}
  <div class="col-lg-8">
    <div class="card-clean p-4 mb-4">
      <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center pb-3 mb-4 border-bottom gap-2">
        <div>
          <span class="text-muted small">Nomor Kontrak Order</span>
          <h1 class="fw-bold fs-5 mb-0 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $order->order_number }}</h1>
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
        
        <div class="col-sm-4 text-muted">Waktu Masuk:</div>
        <div class="col-sm-8 text-secondary">{{ $order->created_at->format('d M Y, H:i') }} WIB</div>
      </div>

      <h3 class="fw-bold fs-6 mb-3 text-dark">Rincian Item Layanan:</h3>

      <div class="table-responsive border rounded-2 mb-2">
        <table class="table table-clean mb-0 align-middle">
          <thead>
            <tr>
              <th>Layanan</th>
              <th>Kategori</th>
              <th class="text-end">Harga Satuan</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->items as $item)
            <tr>
              <td><span class="fw-medium small text-dark">{{ $item->service->name ?? $item->name }}</span></td>
              <td><span class="badge-kbli">{{ $item->service->category ?? 'Layanan' }}</span></td>
              <td class="text-end small fw-semibold text-dark">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot class="bg-light">
            <tr>
              <td colspan="2" class="text-end small text-muted">Subtotal</td>
              <td class="text-end small fw-medium text-dark">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td colspan="2" class="text-end small text-muted">PPN (11%)</td>
              <td class="text-end small fw-medium text-dark">Rp {{ number_format($order->tax, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td colspan="2" class="text-end fw-bold small text-dark">Total Kontrak</td>
              <td class="text-end fw-bold small" style="color:var(--primary)">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    {{-- UBAH STATUS PESANAN --}}
    <div class="card-clean p-4">
      <h3 class="fw-bold fs-6 mb-3 text-dark">Perbarui Status Proyek</h3>
      <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="d-flex gap-2 align-items-center flex-wrap">
        @csrf 
        @method('PATCH')
        <select name="status" class="form-select form-select-sm" style="width: auto; min-width: 200px;">
          @foreach(['pending','confirmed','in_progress','completed','cancelled'] as $s)
          <option value="{{ $s }}" @selected($order->status===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
          @endforeach
        </select>
        <button class="btn-gardenia-sm py-1.5 px-3">Simpan Perubahan</button>
      </form>
    </div>
  </div>

  {{-- SIDEBAR INFORMASI KLIEN & PEMBAYARAN --}}
  <div class="col-lg-4">
    {{-- DATA KLIEN --}}
    <div class="card-clean p-4 mb-4">
      <h3 class="fw-bold fs-6 mb-3 text-dark">Profil Klien</h3>
      <div class="fw-semibold text-dark">{{ $order->user->name }}</div>
      <div class="text-muted small mb-2">{{ $order->user->email }}</div>
      @if($order->user->phone)
      <div class="text-muted small mb-3">{{ $order->user->phone }}</div>
      @endif
      <a href="{{ route('admin.users.show', $order->user) }}" class="btn-gardenia-outline-sm w-100 justify-content-center">
        Lihat Detail Pengguna
      </a>
    </div>

    {{-- INFO PEMBAYARAN --}}
    <div class="card-clean p-4">
      <h3 class="fw-bold fs-6 mb-3 text-dark">Status Pembayaran</h3>
      @if($order->payment)
        <div class="d-flex flex-column gap-2 small mb-3">
          <div class="d-flex justify-content-between pb-1.5 border-bottom">
            <span class="text-muted">Kode Transaksi</span>
            <span class="fw-semibold text-dark">{{ $order->payment->payment_code }}</span>
          </div>
          <div class="d-flex justify-content-between pb-1.5 border-bottom">
            <span class="text-muted">Metode</span>
            <span class="text-dark">{{ strtoupper($order->payment->method) }}</span>
          </div>
          <div class="d-flex justify-content-between pb-1.5 border-bottom">
            <span class="text-muted">Status</span>
            <span class="badge-status badge-status-{{ $order->payment->status }}">{{ strtoupper($order->payment->status) }}</span>
          </div>
          <div class="d-flex justify-content-between pb-1.5">
            <span class="text-muted">Nominal Ditagih</span>
            <span class="fw-bold text-dark fs-6">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</span>
          </div>
        </div>

        @if($order->payment->proof)
          <a href="{{ Storage::url($order->payment->proof) }}" target="_blank" class="btn-gardenia-outline-sm w-100 justify-content-center mb-2">
            Lihat Bukti Bayar
          </a>
        @endif

        @if($order->payment->status === 'pending')
          <a href="{{ route('admin.payments.show', $order->payment) }}" class="btn-gardenia-sm w-100 justify-content-center">
            Verifikasi Pembayaran
          </a>
        @endif
      @else
        <div class="text-muted small text-center py-3">Belum ada catatan pembayaran.</div>
      @endif
    </div>
  </div>
</div>

@endsection