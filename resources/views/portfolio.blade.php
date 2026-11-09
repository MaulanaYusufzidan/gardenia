@extends('layouts.app')
@section('title', 'Portofolio Proyek — CV. Gardenia Setia Utama')

@section('styles')
<style>
.portfolio-hero {
    background: linear-gradient(135deg, #0f2b1d 0%, #183e2b 60%, #245c40 100%);
    color: #ffffff;
    padding: 4rem 0 3.5rem;
}
.unit-pill-btn {
    border: 1px solid var(--border-color);
    background: #ffffff;
    color: var(--text-main);
    font-weight: 500;
    font-size: 0.88rem;
    padding: 0.5rem 1.25rem;
    border-radius: var(--radius-sm);
    transition: all 0.2s ease;
}
.unit-pill-btn.active {
    background: var(--primary) !important;
    color: #ffffff !important;
    border-color: var(--primary) !important;
}
.spec-box {
    background: #ffffff;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-sm);
    padding: 0.85rem 1rem;
}
</style>
@endsection

@section('content')

{{-- HERO PROYEK SAMARA HILLS --}}
<section class="portfolio-hero">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-8">
        <nav aria-label="breadcrumb" class="mb-3">
          <ol class="breadcrumb small mb-0" style="--bs-breadcrumb-divider-color:rgba(255,255,255,.5);">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">Portofolio</li>
          </ol>
        </nav>
        <span class="badge bg-white/10 text-white border border-white/20 px-2.5 py-1 small mb-2 d-inline-block">
          KBLI 68110 · Real Estate & Arsitektur
        </span>
        <h1 class="display-5 fw-bold mb-2">Samara Hills Malang</h1>
        <p class="lead mb-4 text-white-50" style="font-size:1.05rem;">
          "Find our Nature Highland Paradise at your Home" — Kawasan hunian 2 lantai berkonsep modern resort pegunungan di Merjosari, Kota Malang.
        </p>
        
        <div class="d-flex flex-wrap gap-2">
          <a href="{{ route('contact') }}" class="btn-gardenia-gold">Konsultasi Proyek Serupa</a>
          <a href="{{ route('services') }}" class="btn-gardenia-outline" style="border-color:rgba(255,255,255,0.3);color:#fff !important;">Lihat Semua Layanan</a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- INFO SINGKAT PROYEK --}}
<section class="py-4 bg-white border-bottom">
  <div class="container">
    <div class="row g-3">
      <div class="col-6 col-md-3">
        <div class="p-3 rounded-2 bg-light border text-center h-100">
          <div class="text-muted small text-uppercase fw-semibold" style="font-size:0.7rem;letter-spacing:0.06em;">Lokasi</div>
          <div class="fw-bold small text-dark mt-1">Merjosari, Kota Malang</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-3 rounded-2 bg-light border text-center h-100">
          <div class="text-muted small text-uppercase fw-semibold" style="font-size:0.7rem;letter-spacing:0.06em;">Tipe Unit</div>
          <div class="fw-bold small text-dark mt-1">Maldives · Hawai · Okinawa</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-3 rounded-2 bg-light border text-center h-100">
          <div class="text-muted small text-uppercase fw-semibold" style="font-size:0.7rem;letter-spacing:0.06em;">Luas Bangunan</div>
          <div class="fw-bold small text-dark mt-1">65 m² – 92 m² (2 Lantai)</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-3 rounded-2 bg-light border text-center h-100">
          <div class="text-muted small text-uppercase fw-semibold" style="font-size:0.7rem;letter-spacing:0.06em;">Peran Gardenia</div>
          <div class="fw-bold small text-dark mt-1">Masterplan & Arsitektur</div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- GALERI VISUALISASI --}}
<section class="py-5">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-tagline">Dokumentasi Visual</span>
      <h2 class="section-heading mb-2">Galeri Desain Samara Hills</h2>
      <p class="text-muted small max-w-md mx-auto">Visualisasi fasad utama, gerbang kawasan, tipe unit, hingga rancangan masterplan komersial.</p>
    </div>

    <div class="row g-3">
      {{-- Gambar Utama --}}
      <div class="col-lg-8">
        <div class="rounded-3 overflow-hidden border shadow-sm" style="height: 420px; background: #000;">
          <img src="{{ asset('images/portfolio/samara-hills/hero.jpg') }}" alt="Samara Hills - Fasad Utama" class="w-100 h-100" style="object-fit:cover;" onerror="this.onerror=null;this.src='https://placehold.co/900x500/183e2b/ffffff?text=Fasad+Utama+Samara+Hills'">
        </div>
      </div>

      {{-- Gambar Samping --}}
      <div class="col-lg-4 d-flex flex-column gap-3">
        <div class="rounded-3 overflow-hidden border shadow-sm flex-fill" style="min-height: 200px; background: #000;">
          <img src="{{ asset('images/portfolio/samara-hills/entrance.jpg') }}" alt="Gerbang Kawasan" class="w-100 h-100" style="object-fit:cover;" onerror="this.onerror=null;this.src='https://placehold.co/500x250/245c40/ffffff?text=Main+Gate'">
        </div>
        <div class="rounded-3 overflow-hidden border shadow-sm flex-fill" style="min-height: 200px; background: #000;">
          <img src="{{ asset('images/portfolio/samara-hills/street.jpg') }}" alt="Area Komersial" class="w-100 h-100" style="object-fit:cover;" onerror="this.onerror=null;this.src='https://placehold.co/500x250/0f2b1d/ffffff?text=Commercial+Area'">
        </div>
      </div>

      {{-- Gambar Masterplan & Gallery --}}
      <div class="col-md-6">
        <div class="rounded-3 overflow-hidden border shadow-sm" style="height: 300px; background: #000;">
          <img src="{{ asset('images/portfolio/samara-hills/marketing-gallery.jpg') }}" alt="Marketing Gallery" class="w-100 h-100" style="object-fit:cover;" onerror="this.onerror=null;this.src='https://placehold.co/700x350/183e2b/ffffff?text=Marketing+Gallery'">
        </div>
      </div>
      <div class="col-md-6">
        <div class="rounded-3 overflow-hidden border shadow-sm" style="height: 300px; background: #000;">
          <img src="{{ asset('images/portfolio/samara-hills/masterplan.jpg') }}" alt="Masterplan Terpadu" class="w-100 h-100" style="object-fit:cover;" onerror="this.onerror=null;this.src='https://placehold.co/700x350/245c40/ffffff?text=Masterplan'">
        </div>
      </div>
    </div>
  </div>
</section>

{{-- TIPE UNIT TABS --}}
<section class="py-5 bg-light border-top border-bottom">
  <div class="container">
    <div class="text-center mb-4">
      <span class="section-tagline">Pilihan Denah</span>
      <h2 class="section-heading mb-2">Tipe Unit Hunian</h2>
      <p class="text-muted small">Rancangan tata ruang fungsional untuk kenyamanan keluarga modern.</p>
    </div>

    {{-- Tabs --}}
    <ul class="nav justify-content-center gap-2 mb-4" id="unitPills" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="unit-pill-btn active" id="pills-maldives-tab" data-bs-toggle="pill" data-bs-target="#pills-maldives" type="button" role="tab">
          Tipe Maldives (65/66)
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="unit-pill-btn" id="pills-hawai-tab" data-bs-toggle="pill" data-bs-target="#pills-hawai" type="button" role="tab">
          Tipe Hawai (72/72)
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="unit-pill-btn" id="pills-okinawa-tab" data-bs-toggle="pill" data-bs-target="#pills-okinawa" type="button" role="tab">
          Tipe Okinawa (80/84)
        </button>
      </li>
    </ul>

    <div class="tab-content" id="unitPillsContent">
      {{-- MALDIVES --}}
      <div class="tab-pane fade show active" id="pills-maldives" role="tabpanel">
        <div class="row g-4 align-items-center">
          <div class="col-lg-6">
            <div class="rounded-3 overflow-hidden border shadow-sm" style="height: 380px;">
              <img src="{{ asset('images/portfolio/samara-hills/maldives.jpg') }}" alt="Tipe Maldives" class="w-100 h-100" style="object-fit:cover;" onerror="this.onerror=null;this.src='https://placehold.co/700x400/183e2b/ffffff?text=Tipe+Maldives'">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card-clean p-4">
              <span class="badge-kbli mb-2 d-inline-block">2 Lantai · Compact Tropical</span>
              <h3 class="fw-bold fs-4 mb-3 text-dark">Tipe Maldives</h3>
              <p class="text-muted small mb-4" style="line-height: 1.7;">
                Dirancang untuk keluarga muda dinamis yang menginginkan hunian efisien dengan sirkulasi udara optimal dan pencahayaan alami maksimal.
              </p>
              
              <div class="row g-2 mb-4">
                <div class="col-6">
                  <div class="spec-box text-center">
                    <span class="text-muted" style="font-size:0.7rem;">Luas Tanah (LT)</span>
                    <div class="fw-bold text-dark fs-6">66 m²</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="spec-box text-center">
                    <span class="text-muted" style="font-size:0.7rem;">Luas Bangunan (LB)</span>
                    <div class="fw-bold text-dark fs-6">65 m²</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="spec-box text-center">
                    <span class="text-muted" style="font-size:0.7rem;">Kamar Tidur</span>
                    <div class="fw-bold text-dark fs-6">2 Ruang</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="spec-box text-center">
                    <span class="text-muted" style="font-size:0.7rem;">Kamar Mandi</span>
                    <div class="fw-bold text-dark fs-6">1 Ruang</div>
                  </div>
                </div>
              </div>

              <a href="{{ route('contact') }}" class="btn-gardenia w-100 text-center">Konsultasi Rencana Desain Ini</a>
            </div>
          </div>
        </div>
      </div>

      {{-- HAWAI --}}
      <div class="tab-pane fade" id="pills-hawai" role="tabpanel">
        <div class="row g-4 align-items-center">
          <div class="col-lg-6">
            <div class="rounded-3 overflow-hidden border shadow-sm" style="height: 380px;">
              <img src="{{ asset('images/portfolio/samara-hills/hawai.jpg') }}" alt="Tipe Hawai" class="w-100 h-100" style="object-fit:cover;" onerror="this.onerror=null;this.src='https://placehold.co/700x400/245c40/ffffff?text=Tipe+Hawai'">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card-clean p-4">
              <span class="badge-kbli mb-2 d-inline-block">2 Lantai · Deluxe Family</span>
              <h3 class="fw-bold fs-4 mb-3 text-dark">Tipe Hawai</h3>
              <p class="text-muted small mb-4" style="line-height: 1.7;">
                Menyediakan ruang keluarga yang lebih lega dengan 3 kamar tidur dan area servis terpisah untuk kenyamanan hidup yang lebih leluasa.
              </p>
              
              <div class="row g-2 mb-4">
                <div class="col-6">
                  <div class="spec-box text-center">
                    <span class="text-muted" style="font-size:0.7rem;">Luas Tanah (LT)</span>
                    <div class="fw-bold text-dark fs-6">72 m²</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="spec-box text-center">
                    <span class="text-muted" style="font-size:0.7rem;">Luas Bangunan (LB)</span>
                    <div class="fw-bold text-dark fs-6">72 m²</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="spec-box text-center">
                    <span class="text-muted" style="font-size:0.7rem;">Kamar Tidur</span>
                    <div class="fw-bold text-dark fs-6">3 Ruang</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="spec-box text-center">
                    <span class="text-muted" style="font-size:0.7rem;">Kamar Mandi</span>
                    <div class="fw-bold text-dark fs-6">2 Ruang</div>
                  </div>
                </div>
              </div>

              <a href="{{ route('contact') }}" class="btn-gardenia w-100 text-center">Konsultasi Rencana Desain Ini</a>
            </div>
          </div>
        </div>
      </div>

      {{-- OKINAWA --}}
      <div class="tab-pane fade" id="pills-okinawa" role="tabpanel">
        <div class="row g-4 align-items-center">
          <div class="col-lg-6">
            <div class="rounded-3 overflow-hidden border shadow-sm" style="height: 380px;">
              <img src="{{ asset('images/portfolio/samara-hills/okinawa.jpg') }}" alt="Tipe Okinawa" class="w-100 h-100" style="object-fit:cover;" onerror="this.onerror=null;this.src='https://placehold.co/700x400/0f2b1d/ffffff?text=Tipe+Okinawa'">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card-clean p-4">
              <span class="badge-kbli mb-2 d-inline-block">2 Lantai · Premium Grand</span>
              <h3 class="fw-bold fs-4 mb-3 text-dark">Tipe Okinawa</h3>
              <p class="text-muted small mb-4" style="line-height: 1.7;">
                Varian tipe terluas dengan aksen arsitektur modern oriental tropis, halaman samping asri, serta carport yang lega untuk dua kendaraan.
              </p>
              
              <div class="row g-2 mb-4">
                <div class="col-6">
                  <div class="spec-box text-center">
                    <span class="text-muted" style="font-size:0.7rem;">Luas Tanah (LT)</span>
                    <div class="fw-bold text-dark fs-6">84 m²</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="spec-box text-center">
                    <span class="text-muted" style="font-size:0.7rem;">Luas Bangunan (LB)</span>
                    <div class="fw-bold text-dark fs-6">80 m²</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="spec-box text-center">
                    <span class="text-muted" style="font-size:0.7rem;">Kamar Tidur</span>
                    <div class="fw-bold text-dark fs-6">3 Ruang</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="spec-box text-center">
                    <span class="text-muted" style="font-size:0.7rem;">Kamar Mandi</span>
                    <div class="fw-bold text-dark fs-6">2 Ruang</div>
                  </div>
                </div>
              </div>

              <a href="{{ route('contact') }}" class="btn-gardenia w-100 text-center">Konsultasi Rencana Desain Ini</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- SPESIFIKASI TEKNIS --}}
<section class="py-5">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-tagline">Standar Material</span>
      <h2 class="section-heading mb-2">Spesifikasi Teknis Bangunan</h2>
      <p class="text-muted small">Material berstandar SNI untuk menjamin ketahanan dan estetika jangka panjang.</p>
    </div>

    @php
    $specs = [
      ['Struktur', 'Beton Bertulang Standar SNI'],
      ['Dinding', 'Bata Ringan, Diplester, Diaci, & Finishing Cat Weatherproof'],
      ['Pintu & Kusen', 'Engineering Door & Kusen Aluminium Powder Coating'],
      ['Plafond', 'Gypsum Board / Rangka Hollow Galvanis'],
      ['Rangka Atap', 'Baja Ringan Zincalume'],
      ['Penutup Atap', 'Genteng Bitumen / Beton Flat Berkualitas'],
      ['Lantai Utama', 'Homogeneous Tile 60x60 cm'],
      ['Lantai Sanitair', 'Keramik Anti-Slip & Dinding Full Keramik'],
      ['Sanitair', 'Closet Duduk Monoblock & Shower Set'],
      ['Air Bersih', 'Instalasi PDAM & Tandon Cadangan'],
      ['Kelistrikan', 'PLN 2.200 VA Standar Instalasi Aman'],
    ];
    @endphp

    <div class="row g-3">
      @foreach($specs as $s)
      <div class="col-sm-6 col-lg-4">
        <div class="card-clean p-3 h-100">
          <div class="text-muted small fw-semibold text-uppercase" style="font-size:0.7rem;letter-spacing:0.04em;">{{ $s[0] }}</div>
          <div class="fw-medium small text-dark mt-1">{{ $s[1] }}</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

@endsection

