@extends('admin.layouts.app')
@section('title', 'Detail Pembayaran ' . $payment->payment_code)
@section('page-title', 'Verifikasi Transaksi Pembayaran')

@section('content')

<div class="mb-3">
  <a href="{{ route('admin.payments.index') }}" class="btn-gardenia-outline-sm">
    ← Kembali ke Daftar Pembayaran
  </a>
</div>

<div class="row g-4">
  {{-- INFO DETAIL PEMBAYARAN --}}
  <div class="col-lg-6">
    <div class="card-clean p-4 mb-4">
      <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
        <div>
          <span class="text-muted small">Kode Pembayaran</span>
          <h1 class="fw-bold fs-5 mb-0 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $payment->payment_code }}</h1>
        </div>
        <span class="badge-status badge-status-{{ $payment->status }}">
          {{ strtoupper($payment->status) }}
        </span>
      </div>

      <div class="d-flex flex-column gap-2.5 small">
        <div class="d-flex justify-content-between pb-1.5 border-bottom">
          <span class="text-muted">Nomor Pesanan:</span>
          <a href="{{ route('admin.orders.show', $payment->order) }}" class="text-decoration-none fw-semibold" style="color:var(--primary)">
            {{ $payment->order->order_number }}
          </a>
        </div>
        <div class="d-flex justify-content-between pb-1.5 border-bottom">
          <span class="text-muted">Klien:</span>
          <span class="text-dark fw-medium">{{ $payment->order->user->name }}</span>
        </div>
        <div class="d-flex justify-content-between pb-1.5 border-bottom">
          <span class="text-muted">Tahapan:</span>
          <span class="badge-kbli">
            {{ $payment->stage === 'dp' ? 'Uang Muka (DP 30%)' : ($payment->stage === 'final' ? 'Pelunasan (70%)' : 'Pembayaran Penuh (100%)') }}
          </span>
        </div>
        <div class="d-flex justify-content-between pb-1.5 border-bottom">
          <span class="text-muted">Metode Pembayaran:</span>
          <span class="text-dark fw-semibold">{{ strtoupper($payment->method) }}</span>
        </div>
        <div class="d-flex justify-content-between pb-1.5 border-bottom">
          <span class="text-muted">Nominal Pembayaran:</span>
          <span class="fw-bold text-dark fs-6">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
        </div>
        @if($payment->paid_at)
        <div class="d-flex justify-content-between pb-1.5 border-bottom">
          <span class="text-muted">Waktu Diverifikasi:</span>
          <span class="text-secondary">{{ $payment->paid_at->format('d M Y, H:i') }} WIB</span>
        </div>
        @endif
        <div class="d-flex justify-content-between">
          <span class="text-muted">Waktu Masuk:</span>
          <span class="text-secondary">{{ $payment->created_at->format('d M Y, H:i') }} WIB</span>
        </div>
      </div>
    </div>

    {{-- BUKTI PEMBAYARAN --}}
    <div class="card-clean p-4">
      <h3 class="fw-bold fs-6 mb-3 text-dark">Lampiran Bukti Transfer</h3>
      <div class="text-center">
        @if($payment->proof)
          <img src="{{ Storage::url($payment->proof) }}" alt="Bukti Transfer" class="img-fluid rounded border mb-3" style="max-height: 320px; object-fit: contain;">
          <div>
            <a href="{{ Storage::url($payment->proof) }}" target="_blank" class="btn-gardenia-outline-sm">
              Lihat Ukuran Penuh
            </a>
          </div>
        @else
          <div class="py-5 text-muted small bg-light rounded-2 border">
            Belum ada lampiran berkas bukti transfer yang diunggah oleh klien.
          </div>
        @endif
      </div>
    </div>
  </div>

  {{-- ITEM PESANAN & AKSI VERIFIKASI --}}
  <div class="col-lg-6">
    {{-- ITEM LAYANAN --}}
    <div class="card-clean p-4 mb-4">
      <h3 class="fw-bold fs-6 mb-3 text-dark">Item Pesanan Terkait</h3>
      <div class="table-responsive border rounded-2 mb-2">
        <table class="table table-clean mb-0 align-middle">
          <thead>
            <tr>
              <th>Layanan</th>
              <th class="text-end">Tarif</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payment->order->items as $item)
            <tr>
              <td><span class="fw-medium small text-dark">{{ $item->service->name ?? $item->name }}</span></td>
              <td class="text-end small fw-semibold text-dark">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot class="bg-light">
            <tr>
              <td class="fw-bold small text-dark">Total Tagihan Transaksi Ini</td>
              <td class="fw-bold text-end small" style="color:var(--primary)">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    {{-- AKSI VERIFIKASI ADMIN --}}
    @if($payment->status === 'pending')
      <div class="card-clean p-4 border-warning">
        <div class="d-flex align-items-center gap-2 mb-2">
          <span class="badge bg-warning text-dark">Tindakan Admin</span>
          <h3 class="fw-bold fs-6 mb-0 text-dark">Verifikasi Pembayaran</h3>
        </div>
        <p class="text-muted small mb-4">Tinjau kesesuaian nominal dan rekening pengirim pada bukti transfer sebelum memverifikasi.</p>

        <div class="d-flex gap-2">
          <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" class="flex-fill">
            @csrf 
            @method('PATCH')
            <button type="submit" class="btn-gardenia w-100 py-2.5 justify-content-center" onclick="return confirm('Konfirmasi dan verifikasi pembayaran ini?')">
              Setujui (Verifikasi Lunas)
            </button>
          </form>

          <form method="POST" action="{{ route('admin.payments.reject', $payment) }}">
            @csrf 
            @method('PATCH')
            <button type="submit" class="btn btn-outline-danger py-2.5 px-3" onclick="return confirm('Tolak bukti pembayaran ini?')">
              Tolak
            </button>
          </form>
        </div>

        <div class="p-3 bg-light rounded-2 mt-3 small text-muted border" style="font-size:0.75rem;">
          Setelah disetujui, sistem akan secara otomatis memperbarui status pesanan menjadi <strong>Confirmed</strong> atau <strong>In Progress</strong>.
        </div>
      </div>
    @elseif($payment->status === 'paid')
      <div class="alert alert-success d-flex align-items-center gap-2 p-3 mb-0 rounded-3 border-0 bg-success-subtle text-success small">
        <i class="bi bi-check-circle fs-5"></i>
        <span>Pembayaran telah <strong>Diverifikasi & Lunas</strong>.</span>
      </div>
    @elseif($payment->status === 'failed')
      <div class="alert alert-danger d-flex align-items-center gap-2 p-3 mb-0 rounded-3 border-0 bg-danger-subtle text-danger small">
        <i class="bi bi-x-circle fs-5"></i>
        <span>Pembayaran ini telah <strong>Ditolak</strong>.</span>
      </div>
    @endif
  </div>
</div>

@endsection

