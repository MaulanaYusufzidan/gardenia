@extends('admin.layouts.app')
@section('title', 'Edit Pengguna ' . $user->name)
@section('page-title', 'Edit Data Pengguna')

@section('content')

<div class="mb-3">
  <a href="{{ route('admin.users.index') }}" class="btn-gardenia-outline-sm">
    ← Kembali ke Daftar Pengguna
  </a>
</div>

<div class="card-clean p-4 p-md-5 mx-auto" style="max-width: 680px;">
  <h2 class="fw-bold fs-5 mb-4 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    Edit Informasi Akun: {{ $user->name }}
  </h2>

  <form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf 
    @method('PUT')

    <div class="mb-3">
      <label class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name', $user->name) }}" required>
      @error('name')<div class="invalid-feedback small">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold text-dark">Alamat Email <span class="text-danger">*</span></label>
      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
             value="{{ old('email', $user->email) }}" required>
      @error('email')<div class="invalid-feedback small">{{ $message }}</div>@enderror
    </div>

    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <label class="form-label fw-semibold text-dark">Peran (Role) <span class="text-danger">*</span></label>
        <select name="role" class="form-select @error('role') is-invalid @enderror">
          <option value="user" @selected(old('role', $user->role) === 'user')>User (Klien)</option>
          <option value="admin" @selected(old('role', $user->role) === 'admin')>Administrator</option>
        </select>
        @error('role')<div class="invalid-feedback small">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold text-dark">No. Telepon / WhatsApp</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789">
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold text-dark">Alamat Domisili</label>
      <textarea name="address" class="form-control" rows="2" placeholder="Alamat lengkap...">{{ old('address', $user->address) }}</textarea>
    </div>

    <div class="mb-4 form-check">
      <input type="hidden" name="is_active" value="0">
      <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive"
             {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
      <label class="form-check-label small text-dark" for="isActive">Status Akun Aktif (diizinkan login)</label>
    </div>

    <hr class="my-4">
    
    <div class="p-3 bg-light rounded-2 mb-3 border">
      <div class="fw-semibold small text-dark mb-1">Pengaturan Password Baru</div>
      <div class="text-muted" style="font-size:0.75rem;">Kosongkan kolom password di bawah jika tidak bermaksud mengubah password pengguna saat ini.</div>
    </div>

    <div class="row g-3 mb-4">
      <div class="col-md-6">
        <label class="form-label fw-semibold text-dark">Password Baru</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
        @error('password')<div class="invalid-feedback small">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold text-dark">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control">
      </div>
    </div>

    <div class="d-flex gap-2">
      <button type="submit" class="btn-gardenia px-4">
        Simpan Perubahan
      </button>
      <a href="{{ route('admin.users.index') }}" class="btn-gardenia-outline">Batal</a>
    </div>
  </form>
</div>

@endsection

