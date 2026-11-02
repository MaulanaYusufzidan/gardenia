@extends('admin.layouts.app')
@section('title', 'Manajemen Pengguna')
@section('page-title', 'Daftar Akun Pengguna')

@section('content')

<div class="card-clean overflow-hidden">
  {{-- FILTER FORM --}}
  <div class="p-3.5 border-bottom bg-white p-3">
    <form class="row g-2 align-items-center">
      <div class="col-md-5">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari nama lengkap atau email pengguna...">
      </div>
      <div class="col-md-3">
        <select name="role" class="form-select form-select-sm">
          <option value="">Semua Peran (Role)</option>
          <option value="user" @selected(request('role')==='user')>User (Klien)</option>
          <option value="admin" @selected(request('role')==='admin')>Administrator</option>
        </select>
      </div>
      <div class="col-auto d-flex gap-1.5">
        <button class="btn-gardenia-sm py-1">Cari</button>
        <a href="{{ route('admin.users.index') }}" class="btn-gardenia-outline-sm py-1">Reset</a>
      </div>
    </form>
  </div>

  {{-- USERS TABLE --}}
  <div class="table-responsive">
    <table class="table table-clean mb-0 align-middle">
      <thead>
        <tr>
          <th>Nama Pengguna</th>
          <th>Email</th>
          <th>Peran</th>
          <th>Total Pesanan</th>
          <th>Status</th>
          <th>Bergabung</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr>
          <td>
            <div class="d-flex align-items-center gap-2.5">
              <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white small" style="width:32px;height:32px;background:var(--primary);font-size:0.75rem;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
              </div>
              <span class="fw-semibold small text-dark">{{ $user->name }}</span>
            </div>
          </td>
          <td><span class="small text-muted">{{ $user->email }}</span></td>
          <td>
            @if($user->role === 'admin')
              <span class="badge-status badge-status-cancelled">ADMIN</span>
            @else
              <span class="badge-status badge-status-unpaid">USER</span>
            @endif
          </td>
          <td><span class="small fw-semibold text-dark">{{ $user->orders_count }}</span></td>
          <td>
            @if($user->is_active)
              <span class="badge-status badge-status-completed">AKTIF</span>
            @else
              <span class="badge-status badge-status-unpaid">NONAKTIF</span>
            @endif
          </td>
          <td><span class="small text-muted">{{ $user->created_at->format('d M Y') }}</span></td>
          <td class="text-end">
            <div class="d-flex gap-1 justify-content-end align-items-center">
              <a href="{{ route('admin.users.show', $user) }}" class="btn-gardenia-outline-sm py-0.5 px-2" style="font-size:0.75rem;">
                Detail
              </a>
              <a href="{{ route('admin.users.edit', $user) }}" class="btn-gardenia-outline-sm py-0.5 px-2" style="font-size:0.75rem;">
                Edit
              </a>
              @if($user->id !== auth()->id())
              <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                @csrf 
                @method('PATCH')
                <button type="submit" class="btn btn-sm py-0.5 px-2 border {{ $user->is_active ? 'btn-light text-muted' : 'btn-light text-success' }}" style="font-size:0.75rem;">
                  {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
              </form>
              <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini secara permanen?')">
                @csrf 
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger py-0.5 px-2" style="font-size:0.75rem;" title="Hapus Pengguna">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center py-5 text-muted small">Tidak ada akun pengguna yang ditemukan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($users->hasPages())
  <div class="p-3 border-top bg-white d-flex justify-content-center">
    {{ $users->links() }}
  </div>
  @endif
</div>

@endsection

