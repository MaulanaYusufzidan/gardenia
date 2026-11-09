@extends('layouts.app')
@section('title', $service->name . ' | CV. Gardenia Setia Utama')

@section('content')

{{-- BREADCRUMB & HEADER --}}
<div class="bg-light border-bottom py-3">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 small">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('services') }}" class="text-decoration-none text-muted">Layanan</a></li>
        <li class="breadcrumb-item active text-dark fw-medium" aria-current="page">{{ $service->name }}</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-5">
  <div class="row g-5">
    
    {{-- DETAIL LAYANAN --}}
    <div class="col-lg-8">
      <div class="d-flex gap-2 mb-3">
        <span class="badge-kbli">{{ $service->kbli_code }}</span>
        <span class="badge bg-light text-secondary border small">{{ $service->category }}</span>
      </div>

      <h1 class="fw-bold mb-3 fs-2 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $service->name }}</h1>
      <p class="text-muted mb-4" style="line-height: 1.8; font-size: 0.95rem;">{{ $service->description }}</p>

      <div class="card-clean p-4 mb-4">
        <h4 class="fw-bold fs-6 mb-3 text-dark">Ruang Lingkup & Cakupan Kerja</h4>
        <ul class="list-unstyled mb-0 d-flex flex-column gap-2.5 small text-muted">
          <li class="d-flex align-items-center gap-2">
            <i class="bi bi-check2 text-success fw-bold"></i>
            <span>Konsultasi awal dan perumusan kebutuhan ruang atau struktur fisik proyek.</span>
          </li>
          <li class="d-flex align-items-center gap-2">
            <i class="bi bi-check2 text-success fw-bold"></i>
            <span>Penyusunan gambar konsep teknis, spesifikasi material, dan timeline pengerjaan.</span>
          </li>
          <li class="d-flex align-items-center gap-2">
            <i class="bi bi-check2 text-success fw-bold"></i>
            <span>Pengawasan mutu dan kepatuhan standar teknis konstruksi/arsitektur di lapangan.</span>
          </li>
        </ul>
      </div>
    </div>

    {{-- KARTU PEMESANAN --}}
    <div class="col-lg-4">
      <div class="card-clean p-4 position-sticky" style="top: 90px;">
        <h3 class="fw-bold fs-5 mb-2 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pesan Layanan</h3>
        <p class="text-muted small mb-3">Tambahkan ke keranjang pesanan untuk memulai proses konsultasi & kontrak pengerjaan.</p>
        
        <div class="p-3 bg-light rounded-3 mb-4">
          <span class="text-muted small d-block mb-1">Estimasi Tarif Mulai</span>
          @if($service->price)
            <div class="fs-4 fw-bold" style="color:var(--primary)">Rp {{ number_format($service->price,0,',','.') }}</div>
            <span class="text-muted" style="font-size:0.75rem;">*Tarif final disesuaikan dengan volume/luas proyek</span>
          @else
            <div class="fs-5 fw-bold text-dark">Sesuai Scope Proyek</div>
            <span class="text-muted" style="font-size:0.75rem;">Estimasi dihitung berdasarkan kebutuhan teknis</span>
          @endif
        </div>

        <div class="d-flex flex-column gap-2">
          @auth
            <form action="{{ route('cart.add') }}" method="POST">
              @csrf
              <input type="hidden" name="service_id" value="{{ $service->id }}">
              <button type="submit" class="btn-gardenia w-100 py-2.5">
                <i class="bi bi-bag-plus"></i> Tambah ke Keranjang
              </button>
            </form>
          @else
            <a href="{{ route('login') }}" class="btn-gardenia w-100 py-2.5 text-center">
              Masuk untuk Memesan
            </a>
          @endauth

          <a href="{{ route('contact') }}" class="btn-gardenia-outline w-100 py-2.5 text-center">
            Konsultasi Teknis
          </a>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

