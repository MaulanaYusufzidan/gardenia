@extends('layouts.app')
@section('title', 'Beranda | CV. Gardenia Setia Utama')

@section('styles')
<style>
/* HERO SECTION */
.hero-wrapper {
    position: relative;
    min-height: 88vh;
    display: flex;
    align-items: center;
    background: url("{{ asset('images/hero/hero-bg.jpg') }}") center/cover no-repeat;
    color: #ffffff;
    padding: 5rem 0;
}
.hero-tag {
    display: inline-block;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--accent-light);
    border-bottom: 1px solid var(--accent);
    padding-bottom: 2px;
}
.hero-headline {
    font-size: clamp(2.4rem, 5.5vw, 4.2rem);
    font-weight: 700;
    line-height: 1.12;
    letter-spacing: -0.02em;
    margin-bottom: 1.25rem;
}
.hero-description {
    font-size: 1.05rem;
    color: rgba(255, 255, 255, 0.82);
    line-height: 1.7;
    max-width: 520px;
    font-weight: 400;
}
.hero-stats-bar {
    display: flex;
    gap: 2.5rem;
    margin-top: 3.5rem;
    padding-top: 1.75rem;
    border-top: 1px solid rgba(255, 255, 255, 0.15);
    max-width: 520px;
}
.hero-stat-value {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
    color: #ffffff;
}
.hero-stat-label {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.65);
    margin-top: 0.35rem;
    letter-spacing: 0.02em;
}

/* SECTION LABELS */
.section-tagline {
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--primary);
    display: block;
    margin-bottom: 0.4rem;
}
.section-heading {
    font-size: clamp(1.8rem, 3vw, 2.4rem);
    font-weight: 700;
    color: var(--text-main);
    letter-spacing: -0.01em;
}

/* SERVICE CARD */
.service-item-card {
    background: #ffffff;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    overflow: hidden;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.service-item-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary-border);
}
.service-thumb {
    height: 200px;
    overflow: hidden;
    position: relative;
    background: #f1f5f9;
}
.service-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.service-item-card:hover .service-thumb img {
    transform: scale(1.04);
}
.service-price-tag {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--primary);
}

/* SPK HIGHLIGHT CARD */
.spk-showcase-box {
    background: linear-gradient(135deg, #0f2b1d 0%, #183e2b 60%, #1e5239 100%);
    border-radius: var(--radius-lg);
    padding: 3rem;
    color: #ffffff;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.08);
}
.spk-criteria-list {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-sm);
    padding: 1rem 1.25rem;
}
.spk-criteria-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.84rem;
    padding: 0.35rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}
.spk-criteria-row:last-child {
    border-bottom: none;
}

/* PORTFOLIO GRID */
.portfolio-item {
    position: relative;
    border-radius: var(--radius-md);
    overflow: hidden;
    background: #000;
    aspect-ratio: 4 / 3;
}
.portfolio-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.35s ease, opacity 0.35s ease;
    opacity: 0.94;
}
.portfolio-item:hover img {
    transform: scale(1.05);
    opacity: 0.85;
}
.portfolio-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1.25rem;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, transparent 100%);
    color: #ffffff;
}

/* TESTIMONIAL */
.testimonial-card {
    background: #ffffff;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: 2rem;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.quote-mark {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    line-height: 1;
    color: var(--accent);
    margin-bottom: 0.5rem;
}
.avatar-initial {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: var(--primary-soft);
    color: var(--primary);
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    flex-shrink: 0;
}
</style>
@endsection

@section('content')

{{-- HERO SECTION --}}
<section class="hero-wrapper">
  <div class="container position-relative">
    <div class="row align-items-center">
      <div class="col-lg-8 col-xl-7">
        <div class="hero-tag mb-3">Est. 2009 · Kabupaten Bogor, Jawa Barat</div>
        <h1 class="hero-headline">Wujudkan Ruang & Proyek Impian Anda</h1>
        <p class="hero-description mb-4">
          CV. Gardenia Setia Utama menyediakan solusi arsitektur, rancang bangun interior, dan konstruksi terintegrasi dengan standar mutu profesional.
        </p>
        <div class="d-flex flex-wrap gap-3">
          <a href="{{ route('services') }}" class="btn-gardenia btn-gardenia-lg">Lihat Layanan Kami</a>
          <a href="{{ route('spk.index') }}" class="btn-gardenia-outline btn-gardenia-lg" style="background:rgba(255,255,255,0.08);border-color:rgba(255,255,255,0.3);color:#fff !important;">Rekomendasi Paket SAW</a>
        </div>
        <div class="hero-stats-bar">
          <div>
            <div class="hero-stat-value">15+</div>
            <div class="hero-stat-label">Tahun Pengalaman</div>
          </div>
          <div>
            <div class="hero-stat-value">100+</div>
            <div class="hero-stat-label">Proyek Selesai</div>
          </div>
          <div>
            <div class="hero-stat-value">50+</div>
            <div class="hero-stat-label">Klien Puas</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- SERVICES PREVIEW --}}
<section class="py-5 my-3">
  <div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
      <div>
        <span class="section-tagline">Solusi Ruang & Konstruksi</span>
        <h2 class="section-heading mb-0">Layanan Unggulan Kami</h2>
      </div>
      <a href="{{ route('services') }}" class="btn-gardenia-outline btn-gardenia-sm align-self-start align-self-md-auto">
        Lihat Semua Layanan →
      </a>
    </div>

    @php
    $svcImages = [
      asset('images/services/arsitektur.jpeg'),
      asset('images/services/interior.jpeg'),
      asset('images/services/konstruksi.jpeg'),
      asset('images/services/lansekap.jpeg'),
    ];
    @endphp

    <div class="row g-4">
      @foreach($services->take(4) as $i => $service)
      <div class="col-sm-6 col-lg-3">
        <div class="service-item-card">
          <div class="service-thumb">
            <img src="{{ $svcImages[$i % 4] }}" alt="{{ $service->name }}" loading="lazy">
          </div>
          <div class="p-4 d-flex flex-column flex-grow-1">
            <div class="d-flex gap-1 mb-2 flex-wrap">
              <span class="badge-kbli">{{ $service->kbli_code }}</span>
              <span class="badge bg-light text-secondary border text-xs" style="font-size:0.7rem;">{{ $service->category }}</span>
            </div>
            <h3 class="fw-bold mb-2" style="font-size: 1.05rem; font-family: 'Plus Jakarta Sans', sans-serif;">{{ $service->name }}</h3>
            <p class="text-muted small mb-3 flex-grow-1" style="line-height: 1.6;">{{ Str::limit($service->description, 80) }}</p>
            
            <div class="pt-2 border-top d-flex align-items-center justify-content-between">
              @if($service->price)
                <span class="service-price-tag">Rp {{ number_format($service->price,0,',','.') }}</span>
              @else
                <span class="text-muted small">Sesuai Scope</span>
              @endif
              <a href="{{ route('services.show', $service) }}" class="btn-gardenia-outline btn-gardenia-sm">Detail</a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- SPK SAW FEATURE SHOWCASE --}}
<section class="py-4">
  <div class="container">
    <div class="spk-showcase-box">
      <div class="row align-items-center g-4 g-lg-5">
        <div class="col-lg-6">
          <span class="hero-tag mb-2" style="color:var(--accent-light);border-color:var(--accent);">Sistem Pendukung Keputusan</span>
          <h2 class="fw-bold text-white mb-3" style="font-size:clamp(1.7rem, 3.2vw, 2.3rem);">Bingung Memilih Paket Desain yang Sesuai?</h2>
          <p style="color: rgba(255,255,255,0.8); line-height: 1.7; font-size: 0.92rem;" class="mb-4">
            Gunakan sistem kalkulasi cerdas berbasis metode <strong>Simple Additive Weighting (SAW)</strong> untuk mendapatkan rekomendasi paket desain terbaik berdasarkan 5 parameter kebutuhan Anda.
          </p>
          
          <div class="spk-criteria-list mb-4">
            <div class="spk-criteria-row">
              <span class="text-white-50">Budget Anggaran</span>
              <span class="fw-semibold text-white">Bobot 30% (Benefit)</span>
            </div>
            <div class="spk-criteria-row">
              <span class="text-white-50">Luas Bangunan</span>
              <span class="fw-semibold text-white">Bobot 25% (Benefit)</span>
            </div>
            <div class="spk-criteria-row">
              <span class="text-white-50">Target Durasi</span>
              <span class="fw-semibold" style="color: #fca5a5;">Bobot 20% (Cost)</span>
            </div>
            <div class="spk-criteria-row">
              <span class="text-white-50">Kelengkapan Fitur</span>
              <span class="fw-semibold text-white">Bobot 15% (Benefit)</span>
            </div>
          </div>

          <a href="{{ route('spk.index') }}" class="btn-gardenia-gold btn-gardenia-lg">
            Hitung Rekomendasi Sekarang →
          </a>
        </div>

        <div class="col-lg-6">
          <div class="position-relative p-2 p-sm-3 bg-white/5 rounded-3 border border-white/10">
            <img src="{{ asset('images/services/konstruksi.jpeg') }}" alt="Ilustrasi Desain Arsitektur" class="img-fluid rounded-2 w-100" style="object-fit:cover; max-height:360px;">
            <div class="p-3 bg-white text-slate-800 rounded shadow-sm mt-3 d-flex align-items-center justify-content-between">
              <div>
                <div class="text-xs text-muted fw-bold text-uppercase" style="font-size:0.7rem;letter-spacing:0.06em;">Skor Preferensi Tertinggi</div>
                <div class="fw-bold text-success fs-5">Nilai V = 0.9247</div>
              </div>
              <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 small fw-semibold">
                Paket Rekomendasi Utama
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- PORTFOLIO SHOWCASE --}}
<section class="py-5 my-3">
  <div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
      <div>
        <span class="section-tagline">Portofolio</span>
        <h2 class="section-heading mb-0">Dokumentasi Proyek Pilihan</h2>
      </div>
      <a href="{{ route('portfolio') }}" class="btn-gardenia-outline btn-gardenia-sm align-self-start align-self-md-auto">
        Lihat Semua Portofolio →
      </a>
    </div>

    <div class="row g-3">
      <div class="col-sm-6 col-lg-4">
        <div class="portfolio-item">
          <img src="{{ asset('images/portfolio/Pertamanan.jpeg') }}" alt="Taman Kampus Modern" loading="lazy">
          <div class="portfolio-caption">
            <div class="fw-bold small">Taman Kampus Modern</div>
            <div class="text-white-50" style="font-size:0.75rem;">Lansekap & Pertamanan</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="portfolio-item">
          <img src="{{ asset('images/portfolio/bb.jpeg') }}" alt="Sport Center" loading="lazy">
          <div class="portfolio-caption">
            <div class="fw-bold small">Sport Center</div>
            <div class="text-white-50" style="font-size:0.75rem;">Konstruksi & Fasilitas Olahraga</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="portfolio-item">
          <img src="{{ asset('images/portfolio/aa.jpeg') }}" alt="Gedung GOR Sport Center" loading="lazy">
          <div class="portfolio-caption">
            <div class="fw-bold small">Gedung GOR Sport Center</div>
            <div class="text-white-50" style="font-size:0.75rem;">Desain Eksterior & Konstruksi</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-8">
        <div class="portfolio-item" style="aspect-ratio: 16 / 9;">
          <img src="{{ asset('images/portfolio/Lapangan.jpeg') }}" alt="Master Plan Lapangan Sepak Bola" loading="lazy">
          <div class="portfolio-caption">
            <div class="fw-bold small">Lapangan Sepak Bola Skala Standar</div>
            <div class="text-white-50" style="font-size:0.75rem;">Master Plan & Pekerjaan Struktur Lapangan</div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="portfolio-item" style="aspect-ratio: 16 / 9;">
          <img src="{{ asset('images/portfolio/Rumah.jpeg') }}" alt="Perumahan Modern Bogor" loading="lazy">
          <div class="portfolio-caption">
            <div class="fw-bold small">Perumahan Modern Bogor</div>
            <div class="text-white-50" style="font-size:0.75rem;">Arsitektur & Konstruksi Hunian</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- VISI & MISI STRIP --}}
<section class="py-5 bg-white border-top border-bottom">
  <div class="container">
    <div class="row g-4 g-lg-5 align-items-center">
      <div class="col-lg-5">
        <span class="section-tagline">Landasan Perusahaan</span>
        <h2 class="section-heading mb-3">Visi & Komitmen Gardenia</h2>
        <p class="text-muted small" style="line-height: 1.7;">
          Sejak 2009, kami konsisten membangun kepercayaan klien dengan kejujuran teknis, ketepatan estimasi, dan pengawasan mutu pengerjaan yang ketat.
        </p>
        <div class="p-3.5 rounded-3 bg-slate-50 border p-3 mt-3">
          <div class="fw-bold small text-dark mb-1">Visi Utama:</div>
          <p class="text-muted small mb-0" style="line-height: 1.6;">
            Menjadi perusahaan perdagangan dan jasa skala nasional dengan berkarya secara profesional, bertanggung jawab, dan terpercaya di seluruh penjuru nusantara.
          </p>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="d-flex flex-column gap-3">
          @foreach([
            ['Misi 1', 'Memberikan pelayanan dan produk jasa yang berkualitas tinggi di setiap lini pengerjaan.'],
            ['Misi 2', 'Berpartisipasi aktif dalam kegiatan pembangunan fisik dan lingkungan berskala daerah hingga nasional.'],
            ['Misi 3', 'Menciptakan iklim usaha dan persaingan yang sehat, transparan, dan bertanggung jawab.'],
            ['Misi 4', 'Menjadi mitra strategis yang teruji, kompeten, dan selalu siap memberikan solusi teknis terbaik.'],
          ] as $m)
          <div class="p-3 rounded-2 border bg-white d-flex gap-3 align-items-center">
            <span class="badge bg-dark-subtle text-dark border px-2.5 py-1 small fw-semibold flex-shrink-0">{{ $m[0] }}</span>
            <span class="small text-secondary">{{ $m[1] }}</span>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

{{-- TESTIMONIALS --}}
<section class="py-5 my-3">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-tagline">Testimoni Klien</span>
      <h2 class="section-heading mb-2">Kepercayaan Klien Kami</h2>
      <p class="text-muted small max-w-md mx-auto">Pengalaman nyata dari para mitra dan pemilik proyek yang telah bekerja sama dengan kami.</p>
    </div>

    <div class="row g-4">
      @foreach([
        ['name'=>'Budi Santoso','role'=>'Pemilik Villa, Bogor','text'=>'Tim Gardenia sangat profesional dan hasil pengerjaannya presisi sesuai rancangan teknis. Komunikasi selama pengerjaan sangat jelas.'],
        ['name'=>'Sari Dewi','role'=>'Direktur PT. Maju Bersama','text'=>'Sistem rekomendasi paket SAW-nya sangat membantu kami menentukan scope desain sesuai alokasi anggaran proyek.'],
        ['name'=>'Hendra Wijaya','role'=>'Pengembang Hunian','text'=>'Sudah mengerjakan beberapa proyek bersama Gardenia. Selalu disiplin waktu, mutu material terjamin, dan transparan.'],
      ] as $t)
      <div class="col-md-4">
        <div class="testimonial-card">
          <div class="quote-mark">&ldquo;</div>
          <p class="text-muted small flex-grow-1 mb-4" style="line-height: 1.65;">{{ $t['text'] }}</p>
          <div class="d-flex align-items-center gap-3 pt-3 border-top">
            <div class="avatar-initial">{{ mb_substr($t['name'], 0, 1) }}</div>
            <div>
              <div class="fw-semibold small text-dark">{{ $t['name'] }}</div>
              <div class="text-muted" style="font-size:0.75rem;">{{ $t['role'] }}</div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- FINAL CTA --}}
<section class="py-5 bg-light border-top">
  <div class="container text-center py-3">
    <span class="section-tagline">Mulai Sekarang</span>
    <h2 class="section-heading mb-3">Siap Mendiskusikan Proyek Anda?</h2>
    <p class="text-muted small mx-auto mb-4" style="max-width: 460px;">
      Hubungi kami untuk konsultasi teknis awal atau gunakan kalkulator SPK SAW untuk memilih paket desain yang paling ideal.
    </p>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <a href="{{ route('contact') }}" class="btn-gardenia btn-gardenia-lg">Hubungi Kami</a>
      <a href="{{ route('spk.index') }}" class="btn-gardenia-outline btn-gardenia-lg">Kalkulator SAW</a>
    </div>
  </div>
</section>

@endsection