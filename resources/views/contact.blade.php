@extends('layouts.app')
@section('title', 'Kontak | CV. Gardenia Setia Utama')

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header-clean text-center">
  <div class="container">
    <h1>Hubungi Kami</h1>
    <p>Konsultasikan kebutuhan desain arsitektur, rancangan interior, atau proyek konstruksi Anda bersama tim ahli kami.</p>
  </div>
</section>

<div class="container py-5">
  <div class="row g-5 justify-content-center">
    
    {{-- INFORMASI KONTAK --}}
    <div class="col-lg-5">
      <span class="section-tagline">Informasi Kontak</span>
      <h2 class="section-heading mb-4 fs-3">Kantor & Layanan Pelanggan</h2>
      
      <div class="d-flex flex-column gap-3 mb-4">
        <div class="card-clean p-3.5 d-flex flex-row gap-3 align-items-start p-3">
          <div class="p-2 rounded bg-light text-success border">
            <i class="bi bi-geo-alt fs-5"></i>
          </div>
          <div>
            <div class="fw-semibold small text-dark">Alamat Kantor</div>
            <div class="text-muted small">Kabupaten Bogor, Jawa Barat, Indonesia</div>
          </div>
        </div>

        <div class="card-clean p-3.5 d-flex flex-row gap-3 align-items-start p-3">
          <div class="p-2 rounded bg-light text-success border">
            <i class="bi bi-telephone fs-5"></i>
          </div>
          <div>
            <div class="fw-semibold small text-dark">Telepon Kantor</div>
            <div class="text-muted small">(0251) 762-9881</div>
          </div>
        </div>

        <div class="card-clean p-3.5 d-flex flex-row gap-3 align-items-start p-3">
          <div class="p-2 rounded bg-light text-success border">
            <i class="bi bi-whatsapp fs-5"></i>
          </div>
          <div>
            <div class="fw-semibold small text-dark">WhatsApp Direct</div>
            <div class="text-muted small">0851-1920-8772</div>
          </div>
        </div>

        <div class="card-clean p-3.5 d-flex flex-row gap-3 align-items-start p-3">
          <div class="p-2 rounded bg-light text-success border">
            <i class="bi bi-envelope fs-5"></i>
          </div>
          <div>
            <div class="fw-semibold small text-dark">Email Resmi</div>
            <div class="text-muted small">gardeniasetiautama@gmail.com</div>
          </div>
        </div>
      </div>

      <a href="https://wa.me/62895351636200?text=Halo%20Gardenia,%20saya%20ingin%20konsultasi%20mengenai%20proyek" target="_blank" class="btn-gardenia w-100 py-2.5">
        <i class="bi bi-whatsapp"></i> Chat WhatsApp Langsung
      </a>
    </div>

    {{-- FORMULIR PESAN --}}
    <div class="col-lg-6">
      <div class="card-clean p-4 p-lg-5">
        <h3 class="fw-bold fs-5 mb-2 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Kirimkan Pesan atau Pertanyaan</h3>
        <p class="text-muted small mb-4">Isi formulir di bawah ini dan tim kami akan segera merespons dalam waktu 1x24 jam kerja.</p>

        <form onsubmit="event.preventDefault(); alert('Terima kasih! Pesan Anda telah terkirim.');">
          <div class="mb-3">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Contoh: Budi Santoso" required>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" placeholder="nama@email.com" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Perihal / Kategori Proyek</label>
            <input type="text" class="form-control" placeholder="Contoh: Desain Interior Rumah / Konsultasi Arsitektur">
          </div>

          <div class="mb-4">
            <label class="form-label">Pesan / Rincian Kebutuhan <span class="text-danger">*</span></label>
            <textarea class="form-control" rows="4" placeholder="Jelaskan kebutuhan rencana proyek Anda secara ringkas..." required></textarea>
          </div>

          <button type="submit" class="btn-gardenia w-100 py-2.5">
            Kirim Pesan
          </button>
        </form>
      </div>
    </div>

  </div>
</div>

@endsection

