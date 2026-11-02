@extends('admin.layouts.app')
@section('title', 'Katalog Layanan')
@section('page-title', 'Manajemen Katalog Layanan')

@section('content')

<div class="card-clean overflow-hidden">
  {{-- TOP FILTER & TAMBAH BUTTON --}}
  <div class="p-3.5 border-bottom bg-white p-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
    <form class="row g-2 align-items-center flex-fill">
      <div class="col-md-6 col-lg-5">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari nama layanan, kategori...">
      </div>
      <div class="col-auto d-flex gap-1.5">
        <button class="btn-gardenia-sm py-1">Cari</button>
        <a href="{{ route('admin.services.index') }}" class="btn-gardenia-outline-sm py-1">Reset</a>
      </div>
    </form>
    <div>
      <a href="{{ route('admin.services.create') }}" class="btn-gardenia-sm py-1.5">
        + Tambah Layanan Baru
      </a>
    </div>
  </div>

  {{-- SERVICES TABLE --}}
  <div class="table-responsive">
    <table class="table table-clean mb-0 align-middle">
      <thead>
        <tr>
          <th>Nama Layanan</th>
          <th>Kategori</th>
          <th>KBLI</th>
          <th>Tarif</th>
          <th>Status</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($services as $service)
        <tr>
          <td>
            <div class="d-flex align-items-center gap-2.5">
              @if($service->image)
                <img src="{{ Storage::url($service->image) }}" class="rounded border" style="width:36px;height:36px;object-fit:cover;">
              @else
                <div class="rounded bg-light border d-flex align-items-center justify-content-center text-muted" style="width:36px;height:36px;font-size:0.75rem;">
                  <i class="bi bi-image"></i>
                </div>
              @endif
              <span class="fw-semibold small text-dark">{{ $service->name }}</span>
            </div>
          </td>
          <td><span class="badge-kbli">{{ $service->category }}</span></td>
          <td><span class="small text-muted">{{ $service->kbli_code ?? '—' }}</span></td>
          <td><span class="fw-semibold small text-dark">Rp {{ number_format($service->price, 0, ',', '.') }}</span></td>
          <td>
            @if($service->is_active)
              <span class="badge-status badge-status-completed">AKTIF</span>
            @else
              <span class="badge-status badge-status-unpaid">NONAKTIF</span>
            @endif
          </td>
          <td class="text-end">
            <div class="d-flex gap-1 justify-content-end align-items-center">
              <a href="{{ route('admin.services.edit', $service) }}" class="btn-gardenia-outline-sm py-0.5 px-2" style="font-size:0.75rem;">
                Edit
              </a>
              <form method="POST" action="{{ route('admin.services.toggle', $service) }}">
                @csrf 
                @method('PATCH')
                <button type="submit" class="btn btn-sm py-0.5 px-2 border {{ $service->is_active ? 'btn-light text-muted' : 'btn-light text-success' }}" style="font-size:0.75rem;">
                  {{ $service->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
              </form>
              <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Hapus layanan ini secara permanen?')">
                @csrf 
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger py-0.5 px-2" style="font-size:0.75rem;" title="Hapus Layanan">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-5 text-muted small">Belum ada layanan yang ditambahkan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($services->hasPages())
  <div class="p-3 border-top bg-white d-flex justify-content-center">
    {{ $services->links() }}
  </div>
  @endif
</div>

@endsection

