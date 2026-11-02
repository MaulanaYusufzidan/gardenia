@extends('admin.layouts.app')
@section('title', $service->exists ? 'Edit Layanan' : 'Tambah Layanan')
@section('page-title', $service->exists ? 'Edit Layanan' : 'Tambah Layanan Baru')

@section('content')

<div class="mb-3">
  <a href="{{ route('admin.services.index') }}" class="btn-gardenia-outline-sm">
    ← Kembali ke Katalog Layanan
  </a>
</div>

<div class="card-clean p-4 p-md-5 mx-auto" style="max-width: 720px;">
  <h2 class="fw-bold fs-5 mb-4 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    {{ $service->exists ? 'Edit Data Layanan: ' . $service->name : 'Formulir Layanan Baru' }}
  </h2>

  <form method="POST"
        action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if($service->exists) 
      @method('PUT') 
    @endif

    <div class="mb-3">
      <label class="form-label fw-semibold text-dark">Nama Layanan <span class="text-danger">*</span></label>
      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name', $service->name) }}" placeholder="Contoh: Desain Arsitektur Premium 2 Lantai" required>
      @error('name')<div class="invalid-feedback small">{{ $message }}</div>@enderror
    </div>

    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <label class="form-label fw-semibold text-dark">Kategori Layanan <span class="text-danger">*</span></label>
        <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
               value="{{ old('category', $service->category) }}" placeholder="Contoh: Arsitektur, Interior, Konstruksi" required>
        @error('category')<div class="invalid-feedback small">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold text-dark">Klasifikasi KBLI</label>
        <input type="text" name="kbli_code" class="form-control"
               value="{{ old('kbli_code', $service->kbli_code) }}" placeholder="Contoh: 71101 / 41011">
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold text-dark">Deskripsi & Cakupan Kerja <span class="text-danger">*</span></label>
      <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                rows="4" placeholder="Jelaskan ruang lingkup layanan, gambar kerja, output konsultasi, dll." required>{{ old('description', $service->description) }}</textarea>
      @error('description')<div class="invalid-feedback small">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label class="form-label fw-semibold text-dark">Tarif / Harga Dasar (Rp) <span class="text-danger">*</span></label>
      <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
             value="{{ old('price', $service->price) }}" min="0" placeholder="Contoh: 15000000" required>
      @error('price')<div class="invalid-feedback small">{{ $message }}</div>@enderror
    </div>

    <div class="mb-4">
      <label class="form-label fw-semibold text-dark">Foto / Banner Layanan</label>
      @if($service->exists && $service->image)
      <div class="mb-2">
        <img src="{{ Storage::url($service->image) }}" alt="Foto Layanan" class="rounded border" style="height: 100px; object-fit: cover;">
        <div class="text-muted small mt-1" style="font-size:0.75rem;">Unggah gambar baru di bawah jika ingin mengganti gambar saat ini.</div>
      </div>
      @endif
      <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
      @error('image')<div class="invalid-feedback small">{{ $message }}</div>@enderror
    </div>

    <div class="mb-4 form-check">
      <input type="hidden" name="is_active" value="0">
      <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive"
             {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
      <label class="form-check-label small text-dark" for="isActive">Publikasikan layanan ini secara aktif di katalog website</label>
    </div>

    <div class="d-flex gap-2">
      <button type="submit" class="btn-gardenia px-4">
        {{ $service->exists ? 'Simpan Perubahan' : 'Tambah Layanan Baru' }}
      </button>
      <a href="{{ route('admin.services.index') }}" class="btn-gardenia-outline">Batal</a>
    </div>
  </form>
</div>

@endsection

