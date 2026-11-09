@extends('admin.layouts.app')
@section('title', 'Kelola Pesanan Proyek')
@section('page-title', 'Daftar Pesanan Proyek')

@section('content')

<div class="card-clean overflow-hidden">
  {{-- FILTER FORM --}}
  <div class="p-3.5 border-bottom bg-white p-3">
    <form class="row g-2 align-items-center">
      <div class="col-md-5">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari nomor pesanan, proyek, klien...">
      </div>
      <div class="col-md-3">
        <select name="status" class="form-select form-select-sm">
          <option value="">Semua Status</option>
          @foreach(['pending','confirmed','in_progress','completed','cancelled'] as $s)
          <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-auto d-flex gap-1.5">
        <button class="btn-gardenia-sm py-1">Filter</button>
        <a href="{{ route('admin.orders.index') }}" class="btn-gardenia-outline-sm py-1">Reset</a>
      </div>
    </form>
  </div>

  {{-- ORDERS TABLE --}}
  <div class="table-responsive">
    <table class="table table-clean mb-0 align-middle">
      <thead>
        <tr>
          <th>No. Order</th>
          <th>Klien</th>
          <th>Nama Proyek</th>
          <th>Total Biaya</th>
          <th>Pembayaran</th>
          <th>Status</th>
          <th>Tanggal</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
        <tr>
          <td><span class="fw-semibold small text-dark">{{ $order->order_number }}</span></td>
          <td>
            <div class="fw-semibold small text-dark">{{ $order->user->name }}</div>
            <div class="text-muted" style="font-size:0.75rem;">{{ $order->user->email }}</div>
          </td>
          <td><span class="small text-secondary">{{ Str::limit($order->project_name, 28) }}</span></td>
          <td><span class="fw-semibold small text-dark">Rp {{ number_format($order->total, 0, ',', '.') }}</span></td>
          <td>
            @if($order->payment)
              <span class="badge-status badge-status-{{ $order->payment->status }}">
                {{ strtoupper($order->payment->status) }}
              </span>
            @else
              <span class="text-muted small">-</span>
            @endif
          </td>
          <td>
            <span class="badge-status badge-status-{{ $order->status }}">
              {{ strtoupper(str_replace('_', ' ', $order->status)) }}
            </span>
          </td>
          <td><span class="small text-muted">{{ $order->created_at->format('d M Y') }}</span></td>
          <td class="text-end">
            <a href="{{ route('admin.orders.show', $order) }}" class="btn-gardenia-outline-sm py-0.5 px-2" style="font-size:0.75rem;">
              Detail
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center py-5 text-muted small">Tidak ada pesanan yang sesuai dengan filter.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($orders->hasPages())
  <div class="p-3 border-top bg-white d-flex justify-content-center">
    {{ $orders->links() }}
  </div>
  @endif
</div>

@endsection

