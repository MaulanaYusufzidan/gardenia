@extends('layouts.app')
@section('title', 'Katalog Layanan — CV. Gardenia Setia Utama')

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header-clean text-center">
  <div class="container">
    <h1>Layanan Profesional</h1>
    <p>Solusi komprehensif mulai dari perencanaan arsitektur, desain interior, eksterior, hingga pemeliharaan lansekap.</p>
  </div>
</section>

{{-- SPK TEASER BANNER --}}
<div class="bg-light border-bottom py-3.5 py-md-4">
  <div class="container">
    <div class="row align-items-center justify-content-between g-3">
      <div class="col-lg-8">
        <div class="d-flex align-items-center gap-3">
          <div class="p-2.5 rounded bg-white border text-success d-none d-sm-block flex-shrink-0">
            <i class="bi bi-calculator fs-4"></i>
          </div>
          <div>
            <div class="fw-bold small text-dark">Butuh Bantuan Memilih Paket Desain?</div>
            <div class="text-muted small">Gunakan sistem rekomendasi otomatis berbasis SAW untuk mencocokkan anggaran dan luas bangunan Anda.</div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 text-lg-end">
        <a href="{{ route('spk.index') }}" class="btn-gardenia-gold btn-gardenia-sm">
          Cari Rekomendasi Paket →
        </a>
      </div>
    </div>
  </div>
</div>

<div class="container py-5">
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-between p-3 mb-4 rounded-3 border-0 bg-success-subtle text-success">
      <span class="small fw-medium">{{ session('success') }}</span>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
  @endif

  <div class="row g-4">
    @foreach($services as $service)
    <div class="col-md-6 col-lg-4">
      <div class="card-clean card-clean-hover h-100 p-4 d-flex flex-column justify-content-between">
        <div>
          <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
            <span class="badge-kbli">{{ $service->kbli_code }}</span>
            <span class="badge bg-light text-secondary border small">{{ $service->category }}</span>
          </div>
          
          <h3 class="fw-bold fs-5 mb-2 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $service->name }}</h3>
          <p class="text-muted small mb-4" style="line-height: 1.65;">{{ Str::limit($service->description, 120) }}</p>
        </div>

        <div class="pt-3 border-top">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted small">Biaya Mulai</span>
            @if($service->price)
              <span class="fw-bold" style="color:var(--primary); font-size:1.05rem;">Rp {{ number_format($service->price,0,',','.') }}</span>
            @else
              <span class="text-muted small fw-medium">Sesuai Scope Proyek</span>
            @endif
          </div>

          <div class="d-flex gap-2">
            <a href="{{ route('services.show', $service) }}" class="btn-gardenia-outline btn-gardenia-sm flex-fill text-center">
              Lihat Detail
            </a>
            @auth
            <form action="{{ route('cart.add') }}" method="POST" class="flex-fill">
              @csrf
              <input type="hidden" name="service_id" value="{{ $service->id }}">
              <button class="btn-gardenia btn-gardenia-sm w-100">
                <i class="bi bi-bag-plus"></i> Pesan
              </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="btn-gardenia btn-gardenia-sm flex-fill text-center">
              <i class="bi bi-bag-plus"></i> Pesan
            </a>
            @endauth
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <div class="mt-5 d-flex justify-content-center">
    {{ $services->links() }}
  </div>

</div>
@endsection
