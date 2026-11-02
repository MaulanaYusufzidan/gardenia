@extends('layouts.app')
@section('title', 'Beranda — CV. Gardenia Setia Utama')
@section('body_class', 'has-hero')

@section('styles')
<style>
/* HERO */
.hero-wrapper {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    background:
        linear-gradient(90deg, rgba(9,17,11,.92) 0%, rgba(9,17,11,.55) 48%, rgba(9,17,11,.15) 100%),
        linear-gradient(180deg, rgba(9,17,11,.7) 0%, transparent 28%, transparent 70%, var(--ink) 100%),
        url("{{ asset('images/hero/hero-bg.jpg') }}") center/cover no-repeat;
    padding: 8rem 0 5rem;
}
@media (prefers-reduced-motion: no-preference) {
    .hero-seq > * { animation: rise 1s cubic-bezier(.2,.7,.2,1) both; }
    .hero-seq > :nth-child(1) { animation-delay: .15s; }
    .hero-seq > :nth-child(2) { animation-delay: .3s; }
    .hero-seq > :nth-child(4) { animation-delay: .65s; }
    .hero-seq > :nth-child(5) { animation-delay: .8s; }
    .hero-seq > :nth-child(6) { animation-delay: .95s; }
    .hero-seq > .hero-rule { animation: draw 1s .55s cubic-bezier(.2,.7,.2,1) both; transform-origin: left; }
    .hero-wrapper { animation: fade 1.4s ease both; }
}
.hero-tag { font-size: .72rem; letter-spacing: .2em; text-transform: uppercase; color: var(--paper-dim); }
.hero-headline {
    font-size: clamp(3.4rem, 10vw, 8rem);
    font-weight: 300;
    line-height: .95;
    margin: 1.25rem 0 0;
}
.hero-rule { width: 56px; height: 1px; background: var(--paper-dim); margin: 1.75rem 0; }
.hero-description { font-size: 1.05rem; color: var(--paper); line-height: 1.7; max-width: 440px; }
.hero-stats-bar { display: flex; gap: 3rem; margin-top: 4rem; }
.hero-stat-value { font-family: var(--font-display); font-size: 2.4rem; font-weight: 300; line-height: 1; }
.hero-stat-label { font-size: .72rem; color: var(--paper-dim); margin-top: .4rem; letter-spacing: .06em; }

/* BAR JUDUL SEKSI */
.section-bar { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2.25rem; font-size: .72rem; letter-spacing: .18em; text-transform: uppercase; }
.section-bar .rule { flex: 1; height: 1px; background: var(--line); }
.section-bar a { color: var(--paper); }
.section-bar a:hover { color: var(--lamp); }
.section-heading { font-size: clamp(2.2rem, 5vw, 3.6rem); font-weight: 300; }

/* LAYANAN */
.service-item-card { display: flex; flex-direction: column; height: 100%; }
.service-thumb { position: relative; flex: none; aspect-ratio: 4 / 5; overflow: hidden; background: var(--ink-3); }
.service-thumb img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; filter: saturate(.85); transition: transform .5s ease; }
.service-item-card:hover .service-thumb img { transform: scale(1.03); }
.service-name { font-size: 1.6rem; font-weight: 300; margin: 1.1rem 0 .5rem; }
.service-meta { font-size: .78rem; color: var(--paper-dim); letter-spacing: .04em; }
.service-price-tag { font-size: .9rem; color: var(--lamp); font-weight: 400; }
.service-foot { margin-top: auto; padding-top: 1rem; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--line-soft); }
.link-arrow { font-size: .7rem; letter-spacing: .16em; text-transform: uppercase; color: var(--paper); }
.link-arrow:hover { color: var(--lamp); }

/* SPK */
.spk-showcase-box { border: 1px solid var(--line); background: var(--ink-2); padding: clamp(1.75rem, 4vw, 3.5rem); }
.spk-criteria-list { border-top: 1px solid var(--line); }
.spk-criteria-row { display: flex; justify-content: space-between; align-items: center; font-size: .86rem; padding: .7rem 0; border-bottom: 1px solid var(--line-soft); }
.spk-score { border: 1px solid var(--line); padding: 1rem 1.25rem; margin-top: 1rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; }

/* PORTOFOLIO */
.portfolio-item { position: relative; aspect-ratio: 4 / 3; overflow: hidden; background: var(--ink-2); }
.portfolio-item img { width: 100%; height: 100%; object-fit: cover; filter: saturate(.85); transition: transform .5s ease; }
.portfolio-cell:hover .portfolio-item img { transform: scale(1.03); }
.portfolio-title { font-family: var(--font-display); text-transform: uppercase; font-size: 1.5rem; font-weight: 300; margin: 1rem 0 .25rem; }
.portfolio-sub { font-size: .78rem; color: var(--paper-dim); }

/* VISI */
.mission-row { display: grid; grid-template-columns: 7rem 1fr; gap: 1rem; padding: 1.1rem 0; border-top: 1px solid var(--line); font-size: .92rem; }
.mission-row:last-child { border-bottom: 1px solid var(--line); }
.mission-row .k { font-size: .72rem; letter-spacing: .16em; text-transform: uppercase; color: var(--lamp); padding-top: .2rem; }
.vision-box { border-left: 1px solid var(--lamp); padding: .25rem 0 .25rem 1.25rem; margin-top: 1.75rem; }

/* TESTIMONI */
.testimonial-col { padding: 0 2rem; border-left: 1px solid var(--line); height: 100%; display: flex; flex-direction: column; }
.testimonial-col p { font-size: 1rem; line-height: 1.75; color: var(--paper); flex-grow: 1; }
.testimonial-name { font-family: var(--font-display); text-transform: uppercase; font-size: 1.25rem; font-weight: 300; }

/* CTA */
.cta-band {
    position: relative;
    padding: clamp(5rem, 12vw, 9rem) 0;
    background:
        linear-gradient(90deg, rgba(9,17,11,.9) 0%, rgba(9,17,11,.45) 70%, rgba(9,17,11,.2) 100%),
        url("{{ asset('images/portfolio/Rumah.jpeg') }}") center/cover no-repeat;
    border-top: 1px solid var(--line);
}
.cta-band h2 { font-size: clamp(2.8rem, 8vw, 6rem); font-weight: 300; line-height: .98; max-width: 11ch; }

@media (max-width: 767.98px) {
    .hero-wrapper { min-height: 92vh; padding-top: 7rem; }
    .hero-stats-bar { gap: 1.75rem; margin-top: 3rem; }
    .testimonial-col { padding: 1.25rem 0 1.25rem 1.25rem; }
    .mission-row { grid-template-columns: 1fr; gap: .25rem; }
}
</style>
@endsection

@section('content')

{{-- HERO --}}
<section class="hero-wrapper">
  <div class="container position-relative hero-seq">
    <div class="hero-tag">Est. 2009 · Kabupaten Bogor, Jawa Barat</div>
    <h1 class="hero-headline">Wujudkan<br>Ruang & Proyek<br>Impian Anda.</h1>
    <div class="hero-rule"></div>
    <p class="hero-description mb-4">
      CV. Gardenia Setia Utama menyediakan solusi arsitektur, rancang bangun interior, dan konstruksi terintegrasi dengan standar mutu profesional.
    </p>
    <div class="d-flex flex-wrap gap-3">
      <a href="{{ route('services') }}" class="btn-gardenia btn-gardenia-lg">Lihat Layanan Kami <span aria-hidden="true">→</span></a>
      <a href="{{ route('spk.index') }}" class="btn-gardenia-outline btn-gardenia-lg" style="color:var(--paper) !important;">Rekomendasi Paket SAW</a>
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
</section>

{{-- LAYANAN --}}
<section class="py-5">
  <div class="container py-4">
    <div class="section-bar reveal">
      <span>Layanan Unggulan Kami</span>
      <span class="rule"></span>
      <a href="{{ route('services') }}">Lihat Semua Layanan →</a>
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
      <div class="col-sm-6 col-lg-3 reveal" style="--d: {{ $i * 0.1 }}s">
        <div class="service-item-card">
          <div class="service-thumb">
            <img src="{{ $service->image ? asset('storage/'.$service->image) : $svcImages[$i % 4] }}" alt="{{ $service->name }}" loading="lazy">
          </div>
          <h3 class="service-name">{{ $service->name }}</h3>
          <div class="service-meta mb-2">{{ $service->kbli_code }} &nbsp;/&nbsp; {{ $service->category }}</div>
          <p class="small mb-3" style="color:var(--paper-dim);line-height:1.65;">{{ Str::limit($service->description, 80) }}</p>
          <div class="service-foot">
            @if($service->price)
              <span class="service-price-tag">Rp {{ number_format($service->price,0,',','.') }}</span>
            @else
              <span class="service-meta">Sesuai Scope</span>
            @endif
            <a href="{{ route('services.show', $service) }}" class="link-arrow">Detail →</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- SPK SAW --}}
<section class="pb-5">
  <div class="container">
    <div class="spk-showcase-box reveal">
      <div class="row align-items-center g-4 g-lg-5">
        <div class="col-lg-6">
          <div class="hero-tag mb-3">Sistem Pendukung Keputusan</div>
          <h2 class="mb-3" style="font-size:clamp(2.2rem,4.5vw,3.4rem);font-weight:300;">Bingung memilih paket desain yang sesuai?</h2>
          <p style="color:var(--paper-dim);line-height:1.75;font-size:.95rem;" class="mb-4">
            Gunakan sistem kalkulasi berbasis metode <strong style="color:var(--paper);font-weight:500;">Simple Additive Weighting (SAW)</strong> untuk mendapatkan rekomendasi paket desain terbaik berdasarkan 5 parameter kebutuhan Anda.
          </p>

          <div class="spk-criteria-list mb-4">
            <div class="spk-criteria-row">
              <span style="color:var(--paper-dim);">Budget Anggaran</span>
              <span>Bobot 30% (Benefit)</span>
            </div>
            <div class="spk-criteria-row">
              <span style="color:var(--paper-dim);">Luas Bangunan</span>
              <span>Bobot 25% (Benefit)</span>
            </div>
            <div class="spk-criteria-row">
              <span style="color:var(--paper-dim);">Target Durasi</span>
              <span style="color:#f0a0a0;">Bobot 20% (Cost)</span>
            </div>
            <div class="spk-criteria-row">
              <span style="color:var(--paper-dim);">Kelengkapan Fitur</span>
              <span>Bobot 15% (Benefit)</span>
            </div>
          </div>

          <a href="{{ route('spk.index') }}" class="btn-gardenia-gold btn-gardenia-lg">Hitung Rekomendasi Sekarang →</a>
        </div>

        <div class="col-lg-6">
          <img src="{{ asset('images/services/konstruksi.jpeg') }}" alt="Ilustrasi Desain Arsitektur" class="w-100" style="object-fit:cover;max-height:380px;filter:saturate(.85);">
          <div class="spk-score">
            <div>
              <div class="hero-tag" style="font-size:.66rem;">Skor Preferensi Tertinggi</div>
              <div style="font-family:var(--font-display);font-size:1.9rem;font-weight:300;color:var(--lamp);">Nilai V = 0.9247</div>
            </div>
            <span class="badge-kbli">Paket Rekomendasi Utama</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- PORTOFOLIO --}}
<section class="py-5">
  <div class="container py-4">
    <div class="section-bar reveal">
      <span>Dokumentasi Proyek Pilihan</span>
      <span class="rule"></span>
      <a href="{{ route('portfolio') }}">Lihat Semua Portofolio →</a>
    </div>

    <div class="row g-4">
      @foreach([
        ['Pertamanan.jpeg', 'Taman Kampus Modern', 'Lansekap & Pertamanan'],
        ['bb.jpeg', 'Sport Center', 'Konstruksi & Fasilitas Olahraga'],
        ['aa.jpeg', 'Gedung GOR Sport Center', 'Desain Eksterior & Konstruksi'],
        ['Lapangan.jpeg', 'Lapangan Sepak Bola Skala Standar', 'Master Plan & Pekerjaan Struktur Lapangan'],
        ['Rumah.jpeg', 'Perumahan Modern Bogor', 'Arsitektur & Konstruksi Hunian'],
      ] as $p)
      <div class="col-sm-6 col-lg-4 portfolio-cell reveal" style="--d: {{ ($loop->index % 3) * 0.1 }}s">
        <div class="portfolio-item">
          <img src="{{ asset('images/portfolio/'.$p[0]) }}" alt="{{ $p[1] }}" loading="lazy">
        </div>
        <div class="portfolio-title">{{ $p[1] }}</div>
        <div class="portfolio-sub">{{ $p[2] }}</div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- VISI & MISI --}}
<section class="py-5" style="border-top:1px solid var(--line);">
  <div class="container py-4">
    <div class="row g-5 align-items-start">
      <div class="col-lg-5">
        <h2 class="section-heading mb-3">Visi & Komitmen Gardenia</h2>
        <p style="color:var(--paper-dim);line-height:1.75;font-size:.95rem;">
          Sejak 2009, kami konsisten membangun kepercayaan klien dengan kejujuran teknis, ketepatan estimasi, dan pengawasan mutu pengerjaan yang ketat.
        </p>
        <div class="vision-box">
          <div class="fw-semibold small mb-1">Visi Utama</div>
          <p class="small mb-0" style="color:var(--paper-dim);line-height:1.7;">
            Menjadi perusahaan perdagangan dan jasa skala nasional dengan berkarya secara profesional, bertanggung jawab, dan terpercaya di seluruh penjuru nusantara.
          </p>
        </div>
      </div>

      <div class="col-lg-7">
        @foreach([
          ['Misi 1', 'Memberikan pelayanan dan produk jasa yang berkualitas tinggi di setiap lini pengerjaan.'],
          ['Misi 2', 'Berpartisipasi aktif dalam kegiatan pembangunan fisik dan lingkungan berskala daerah hingga nasional.'],
          ['Misi 3', 'Menciptakan iklim usaha dan persaingan yang sehat, transparan, dan bertanggung jawab.'],
          ['Misi 4', 'Menjadi mitra strategis yang teruji, kompeten, dan selalu siap memberikan solusi teknis terbaik.'],
        ] as $m)
        <div class="mission-row reveal" style="--d: {{ $loop->index * 0.08 }}s">
          <span class="k">{{ $m[0] }}</span>
          <span>{{ $m[1] }}</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

{{-- TESTIMONI --}}
<section class="py-5" style="border-top:1px solid var(--line);">
  <div class="container py-4">
    <h2 class="section-heading mb-2">Kepercayaan Klien Kami</h2>
    <p class="mb-5" style="color:var(--paper-dim);max-width:520px;">Pengalaman nyata dari para mitra dan pemilik proyek yang telah bekerja sama dengan kami.</p>

    <div class="row g-4">
      @foreach([
        ['name'=>'Budi Santoso','role'=>'Pemilik Villa, Bogor','text'=>'Tim Gardenia sangat profesional dan hasil pengerjaannya presisi sesuai rancangan teknis. Komunikasi selama pengerjaan sangat jelas.'],
        ['name'=>'Sari Dewi','role'=>'Direktur PT. Maju Bersama','text'=>'Sistem rekomendasi paket SAW-nya sangat membantu kami menentukan scope desain sesuai alokasi anggaran proyek.'],
        ['name'=>'Hendra Wijaya','role'=>'Pengembang Hunian','text'=>'Sudah mengerjakan beberapa proyek bersama Gardenia. Selalu disiplin waktu, mutu material terjamin, dan transparan.'],
      ] as $t)
      <div class="col-md-4 reveal" style="--d: {{ $loop->index * 0.12 }}s">
        <div class="testimonial-col">
          <p class="mb-4">{{ $t['text'] }}</p>
          <div>
            <div class="testimonial-name">{{ $t['name'] }}</div>
            <div class="small" style="color:var(--paper-dim);">{{ $t['role'] }}</div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- CTA --}}
<section class="cta-band">
  <div class="container">
    <h2 class="mb-4 reveal">Siap mendiskusikan proyek Anda?</h2>
    <p class="mb-4" style="max-width:460px;color:var(--paper);line-height:1.7;">
      Hubungi kami untuk konsultasi teknis awal atau gunakan kalkulator SPK SAW untuk memilih paket desain yang paling ideal.
    </p>
    <div class="d-flex flex-wrap gap-3">
      <a href="{{ route('contact') }}" class="btn-gardenia btn-gardenia-lg">Hubungi Kami →</a>
      <a href="{{ route('spk.index') }}" class="btn-gardenia-outline btn-gardenia-lg" style="color:var(--paper) !important;">Kalkulator SAW</a>
    </div>
  </div>
</section>

@endsection

@section('scripts')
<script>
  (function () {
    var els = document.querySelectorAll('.reveal');
    if (!('IntersectionObserver' in window)) { els.forEach(function (e) { e.classList.add('in'); }); return; }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
    els.forEach(function (e) { io.observe(e); });
  })();
</script>
@endsection
