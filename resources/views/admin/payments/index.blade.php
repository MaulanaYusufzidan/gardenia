@extends('admin.layouts.app')
@section('title', 'Verifikasi Pembayaran')
@section('page-title', 'Daftar Transaksi Pembayaran')

@section('content')

<div class="card-clean overflow-hidden">
  {{-- FILTER FORM --}}
  <div class="p-3.5 border-bottom bg-white p-3">
    <form class="row g-2 align-items-center">
      <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari kode transaksi, nomor order, nama klien...">
      </div>
      <div class="col-md-3">
        <select name="status" class="form-select form-select-sm">
          <option value="">Semua Status</option>
          @foreach(['unpaid','pending','paid','failed'] as $s)
          <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-auto d-flex gap-1.5">
        <button class="btn-gardenia-sm py-1">Filter</button>
        <a href="{{ route('admin.payments.index') }}" class="btn-gardenia-outline-sm py-1">Reset</a>
      </div>
    </form>
  </div>

  {{-- PAYMENTS TABLE --}}
  <div class="table-responsive">
    <table class="table table-clean mb-0 align-middle">
      <thead>
        <tr>
          <th>Kode Transaksi</th>
          <th>No. Order</th>
          <th>Klien</th>
          <th>Tahapan</th>
          <th>Metode</th>
          <th>Nominal</th>
          <th>Status</th>
          <th>Waktu</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($payments as $payment)
        <tr>
          <td><span class="fw-semibold small text-dark">{{ $payment->payment_code }}</span></td>
          <td><span class="small text-secondary">{{ $payment->order->order_number }}</span></td>
          <td><span class="small fw-medium text-dark">{{ $payment->order->user->name }}</span></td>
          <td>
            <span class="badge-kbli">
              {{ $payment->stage === 'dp' ? 'DP 30%' : ($payment->stage === 'final' ? 'Pelunasan' : 'Penuh') }}
            </span>
          </td>
          <td><span class="small text-muted">{{ strtoupper($payment->method) }}</span></td>
          <td><span class="fw-semibold small text-dark">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span></td>
          <td>
            <span class="badge-status badge-status-{{ $payment->status }}">
              {{ strtoupper($payment->status) }}
            </span>
          </td>
          <td><span class="small text-muted">{{ $payment->created_at->format('d M Y') }}</span></td>
          <td class="text-end">
            <a href="{{ route('admin.payments.show', $payment) }}" class="btn-gardenia-outline-sm py-0.5 px-2" style="font-size:0.75rem;">
              Detail
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="text-center py-5 text-muted small">Tidak ada data pembayaran yang ditemukan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($payments->hasPages())
  <div class="p-3 border-top bg-white d-flex justify-content-center">
    {{ $payments->links() }}
  </div>
  @endif
</div>

@endsection

