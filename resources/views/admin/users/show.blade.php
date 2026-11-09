@extends('admin.layouts.app')
@section('title', 'Detail Pengguna ' . $user->name)
@section('page-title', 'Profil Pengguna')

@section('content')

<div class="mb-3 d-flex gap-2">
  <a href="{{ route('admin.users.index') }}" class="btn-gardenia-outline-sm">
    ← Kembali ke Daftar Pengguna
  </a>
  <a href="{{ route('admin.users.edit', $user) }}" class="btn-gardenia-sm">
    Edit Akun
  </a>
</div>

<div class="row g-4">
  {{-- PROFIL PENGGUNA --}}
  <div class="col-lg-4">
    <div class="card-clean p-4 text-center">
      <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 fw-bold text-white fs-3"
           style="width: 72px; height: 72px; background: var(--primary);">
        {{ strtoupper(substr($user->name, 0, 1)) }}
      </div>
      <h1 class="fw-bold fs-5 mb-0 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $user->name }}</h1>
      <div class="text-muted small mb-2">{{ $user->email }}</div>
      
      <div class="mb-3">
        @if($user->role === 'admin')
          <span class="badge-status badge-status-cancelled">ADMINISTRATOR</span>
        @else
          <span class="badge-status badge-status-unpaid">KLIEN (USER)</span>
        @endif
      </div>

      <hr class="my-3">

      <div class="text-start small d-flex flex-column gap-2">
        <div>
          <span class="text-muted d-block" style="font-size:0.75rem;">No. Telepon / WhatsApp:</span>
          <span class="text-dark fw-medium">{{ $user->phone ?? '—' }}</span>
        </div>
        <div>
          <span class="text-muted d-block" style="font-size:0.75rem;">Alamat Domisili:</span>
          <span class="text-dark fw-medium">{{ $user->address ?? '—' }}</span>
        </div>
        <div>
          <span class="text-muted d-block" style="font-size:0.75rem;">Waktu Registrasi:</span>
          <span class="text-secondary">{{ $user->created_at->format('d M Y, H:i') }} WIB</span>
        </div>
      </div>
    </div>
  </div>

  {{-- RIWAYAT PESANAN --}}
  <div class="col-lg-8">
    <div class="card-clean overflow-hidden">
      <div class="p-3.5 px-4 border-bottom bg-white p-3">
        <h2 class="fw-bold fs-6 mb-0 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Riwayat Pesanan Klien</h2>
      </div>

      <div class="table-responsive">
        <table class="table table-clean mb-0 align-middle">
          <thead>
            <tr>
              <th>No. Order</th>
              <th>Nama Proyek</th>
              <th>Total Biaya</th>
              <th>Status</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            @forelse($user->orders as $order)
            <tr>
              <td>
                <a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none fw-semibold small" style="color:var(--primary)">
                  {{ $order->order_number }}
                </a>
              </td>
              <td><span class="small text-secondary">{{ Str::limit($order->project_name, 30) }}</span></td>
              <td><span class="fw-semibold small text-dark">Rp {{ number_format($order->total, 0, ',', '.') }}</span></td>
              <td>
                <span class="badge-status badge-status-{{ $order->status }}">
                  {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                </span>
              </td>
              <td><span class="small text-muted">{{ $order->created_at->format('d M Y') }}</span></td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center py-4 text-muted small">Klien ini belum memiliki riwayat pesanan.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

