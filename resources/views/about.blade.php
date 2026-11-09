@extends('layouts.app')
@section('title', 'Tentang Kami — CV. Gardenia Setia Utama')

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header-clean text-center">
  <div class="container">
    <h1>Tentang Kami</h1>
    <p>Profil perusahaan, legalitas resmi, dan komitmen profesional dalam setiap karya arsitektur dan konstruksi.</p>
  </div>
</section>

<div class="container py-5">
  {{-- PROFIL & LEGALITAS --}}
  <div class="row g-5 align-items-center mb-5 pb-4 border-bottom">
    <div class="col-lg-6">
      <span class="section-tagline">Profil & Legalitas</span>
      <h2 class="section-heading mb-3">CV. Gardenia Setia Utama</h2>
      <p class="text-muted" style="line-height: 1.7; font-size: 0.92rem;">
        <strong>CV. GARDENIA SETIA UTAMA (Gardenia's Studio)</strong> didirikan secara resmi pada tanggal <strong>23 Mei 2009</strong> di Kabupaten Bogor, di hadapan Notaris <strong>Muljani Sjafei, SH</strong>.
      </p>
      <p class="text-muted" style="line-height: 1.7; font-size: 0.92rem;">
        Perusahaan telah mengalami penyesuaian perubahan anggaran dasar terakhir pada tanggal <strong>26 Juli 2021</strong> di hadapan Notaris <strong>Hatopan Kristien Simorangkir, SH, M.Kn</strong>.
      </p>
      <p class="text-muted" style="line-height: 1.7; font-size: 0.92rem;">
        Seiring perkembangan otonomi daerah dan akselerasi pembangunan nasional, CV. Gardenia Setia Utama senantiasa memperluas jangkauan layanan untuk berkontribusi aktif dalam berbagai proyek fisik dan rancang bangun di seluruh wilayah Indonesia.
      </p>
    </div>

    <div class="col-lg-6">
      <div class="card-clean p-4 p-lg-5">
        <h3 class="fw-bold fs-5 mb-4 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Informasi Entitas Perusahaan</h3>
        
        <div class="d-flex flex-column gap-3">
          <div class="d-flex justify-content-between pb-2 border-bottom">
            <span class="text-muted small">Nama Entitas</span>
            <span class="fw-semibold small text-dark">CV. Gardenia Setia Utama</span>
          </div>
          <div class="d-flex justify-content-between pb-2 border-bottom">
            <span class="text-muted small">Nama Komersial</span>
            <span class="fw-semibold small text-dark">Gardenia's Studio</span>
          </div>
          <div class="d-flex justify-content-between pb-2 border-bottom">
            <span class="text-muted small">Tahun Berdiri</span>
            <span class="fw-semibold small text-dark">23 Mei 2009</span>
          </div>
          <div class="d-flex justify-content-between pb-2 border-bottom">
            <span class="text-muted small">Domisili Hukum</span>
            <span class="fw-semibold small text-dark">Kabupaten Bogor, Jawa Barat</span>
          </div>
          <div class="d-flex justify-content-between">
            <span class="text-muted small">Notaris Terakhir</span>
            <span class="fw-semibold small text-dark text-end">Hatopan Kristien Simorangkir, SH, M.Kn</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- BIDANG USAHA & KBLI --}}
  <div class="mb-5">
    <div class="text-center mb-5">
      <span class="section-tagline">Klasifikasi Baku Lapangan Usaha Indonesia</span>
      <h2 class="section-heading mb-2">Bidang Layanan & Klasifikasi KBLI</h2>
      <p class="text-muted small max-w-md mx-auto">Lisensi dan klasifikasi resmi bidang usaha yang dijalankan oleh CV. Gardenia Setia Utama.</p>
    </div>

    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="card-clean p-4 h-100">
          <span class="badge-kbli mb-3 d-inline-block">KBLI 71101</span>
          <h4 class="fw-bold fs-6 mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">Aktivitas Arsitektur</h4>
          <p class="text-muted small mb-0" style="line-height: 1.6;">Perancangan gedung, master plan kawasan, gambar kerja terinci, dan pengawasan berkala estetika bangunan.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card-clean p-4 h-100">
          <span class="badge-kbli mb-3 d-inline-block">KBLI 74100</span>
          <h4 class="fw-bold fs-6 mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">Perancangan Khusus</h4>
          <p class="text-muted small mb-0" style="line-height: 1.6;">Desain interior eksklusif, visualisasi 3D rendering photorealistic, dan perencanaan tata ruang fungsional.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card-clean p-4 h-100">
          <span class="badge-kbli mb-3 d-inline-block">KBLI 43305</span>
          <h4 class="fw-bold fs-6 mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">Dekorasi Eksterior</h4>
          <p class="text-muted small mb-0" style="line-height: 1.6;">Fasad modern, finishing eksterior arsitektural, elemen pelindung cuaca, dan dekorasi lanskap luar bangunan.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card-clean p-4 h-100">
          <span class="badge-kbli mb-3 d-inline-block">KBLI 81300</span>
          <h4 class="fw-bold fs-6 mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">Perawatan Taman</h4>
          <p class="text-muted small mb-0" style="line-height: 1.6;">Penataan lansekap hijau, pemeliharaan berkala tanaman hias, instalasi irigasi, dan peremajaan taman publik/privat.</p>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

