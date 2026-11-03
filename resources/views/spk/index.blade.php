@extends('layouts.app')
@section('title', 'Sistem Pendukung Keputusan (SPK) SAW — CV. Gardenia Setia Utama')

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header-clean text-center">
  <div class="container">
    <span class="badge px-3 py-2 small mb-2 d-inline-block" style="background: rgba(255,255,255,0.1); color:#fff; border:1px solid rgba(255,255,255,0.2); border-radius:999px; font-weight:600; letter-spacing:0.04em;">
      Metode Simple Additive Weighting (SAW)
    </span>
    <h1>Kalkulator Rekomendasi Paket Desain</h1>
    <p>Dapatkan rekomendasi paket rancangan arsitektur dan konstruksi terbaik yang dihitung secara presisi berdasarkan parameter kebutuhan dan anggaran Anda.</p>
  </div>
</section>

<div class="container py-5">
  <div class="row g-4 g-lg-5 justify-content-center">

    {{-- FORM INPUT KRITERIA --}}
    <div class="col-lg-7">
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show p-3 mb-4 rounded-3 border-0 bg-danger-subtle text-danger">
          <span class="small">{{ session('error') }}</span>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
      @endif

      <div class="card-clean p-4 p-md-5">
        <h2 class="fw-bold fs-5 mb-4 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Parameter Kebutuhan Proyek</h2>

        <form action="{{ route('spk.calculate') }}" method="POST">
          @csrf

          {{-- Budget --}}
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="form-label mb-0 fw-semibold text-dark">
                Alokasi Anggaran (Budget) <span class="text-danger">*</span>
              </label>
              <span class="badge-status badge-status-completed" style="font-size:0.7rem;">{{ isset($weights['C1']) ? round($weights['C1']*100,1).'%' : '—' }} · Benefit</span>
            </div>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted small fw-medium">Rp</span>
              <input type="number" name="budget" class="form-control @error('budget') is-invalid @enderror"
                     placeholder="Contoh: 350000000" value="{{ old('budget', $prefill['budget'] ?? '') }}" min="1000000" step="1000000" required>
            </div>
            <div class="d-flex flex-wrap gap-1.5 mt-2">
              <button type="button" class="btn btn-sm btn-light border budget-btn py-1 px-2.5" data-val="200000000" style="font-size:0.78rem;">200 Juta</button>
              <button type="button" class="btn btn-sm btn-light border budget-btn py-1 px-2.5" data-val="350000000" style="font-size:0.78rem;">350 Juta</button>
              <button type="button" class="btn btn-sm btn-light border budget-btn py-1 px-2.5" data-val="500000000" style="font-size:0.78rem;">500 Juta</button>
              <button type="button" class="btn btn-sm btn-light border budget-btn py-1 px-2.5" data-val="800000000" style="font-size:0.78rem;">800 Juta</button>
              <button type="button" class="btn btn-sm btn-light border budget-btn py-1 px-2.5" data-val="1500000000" style="font-size:0.78rem;">1,5 Miliar</button>
            </div>
            @error('budget')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
            <div class="text-muted small mt-1" style="font-size:0.75rem;">Estimasi total dana konstruksi & perancangan.</div>
          </div>

          {{-- Luas Bangunan --}}
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="form-label mb-0 fw-semibold text-dark">
                Luas Bangunan Rencana <span class="text-danger">*</span>
              </label>
              <span class="badge-status badge-status-completed" style="font-size:0.7rem;">{{ isset($weights['C2']) ? round($weights['C2']*100,1).'%' : '—' }} · Benefit</span>
            </div>
            <div class="input-group">
              <input type="number" name="area" class="form-control @error('area') is-invalid @enderror"
                     placeholder="Contoh: 120" value="{{ old('area', $prefill['area'] ?? '') }}" min="20" max="5000" required>
              <span class="input-group-text bg-light text-muted small fw-medium">m²</span>
            </div>
            <div class="d-flex flex-wrap gap-1.5 mt-2">
              <button type="button" class="btn btn-sm btn-light border area-btn py-1 px-2.5" data-val="60" style="font-size:0.78rem;">60 m²</button>
              <button type="button" class="btn btn-sm btn-light border area-btn py-1 px-2.5" data-val="100" style="font-size:0.78rem;">100 m²</button>
              <button type="button" class="btn btn-sm btn-light border area-btn py-1 px-2.5" data-val="150" style="font-size:0.78rem;">150 m²</button>
              <button type="button" class="btn btn-sm btn-light border area-btn py-1 px-2.5" data-val="250" style="font-size:0.78rem;">250 m²</button>
              <button type="button" class="btn btn-sm btn-light border area-btn py-1 px-2.5" data-val="400" style="font-size:0.78rem;">400 m²</button>
            </div>
            @error('area')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
          </div>

          {{-- Durasi Pengerjaan --}}
          @php $dp = old('duration_pref', $prefill['duration_pref'] ?? ''); @endphp
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="form-label mb-0 fw-semibold text-dark">Batas Durasi Pengerjaan</label>
              <span class="badge-status badge-status-cancelled" style="font-size:0.7rem;">Batasan</span>
            </div>
            <select name="duration_pref" class="form-select @error('duration_pref') is-invalid @enderror">
              <option value="">Tidak ada batasan waktu spesifik</option>
              @foreach([3,5,7,10] as $m)
                <option value="{{ $m }}" {{ (string)$dp === (string)$m ? 'selected' : '' }}>Maksimal {{ $m }} bulan</option>
              @endforeach
              <option value="18" {{ (string)$dp === '18' ? 'selected' : '' }}>Fleksibel (&gt;12 bulan)</option>
            </select>
            <div class="text-muted small mt-1" style="font-size:0.75rem;">Paket yang melebihi batas ini diurutkan setelah paket yang memenuhi. Pada penilaian SAW, durasi paket tetap menjadi kriteria cost (makin singkat makin baik).</div>
          </div>

          {{-- Gaya Desain --}}
          @php $sp = old('style_preference', $prefill['style_preference'] ?? ''); @endphp
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="form-label mb-0 fw-semibold text-dark">Preferensi Konsep Desain</label>
              <span class="badge-status badge-status-unpaid" style="font-size:0.7rem;">Brief desain</span>
            </div>
            <select name="style_preference" class="form-select">
              <option value="">Pilih konsep desain...</option>
              @foreach($styles as $key => $label)
                <option value="{{ $key }}" {{ $sp === $key ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
            <div class="text-muted small mt-1" style="font-size:0.75rem;">Tidak memengaruhi nilai SAW (semua paket dapat dikerjakan dalam berbagai konsep). Dicatat sebagai brief untuk tim arsitek.</div>
          </div>

          <button type="submit" class="btn-gardenia w-100 py-3 text-center fw-semibold">
            Hitung Rekomendasi Paket
          </button>
        </form>
      </div>
    </div>

    {{-- SIDEBAR PENJELASAN SAW --}}
    <div class="col-lg-5">
      <div class="card-clean p-4 mb-4">
        <h3 class="fw-bold fs-6 mb-3 text-dark">Tahapan Perhitungan SAW</h3>

        @php
        $sawSteps = [
          ['1', 'Pengumpulan Variabel', 'Data budget, luas, durasi, dan konsep dipetakan ke dalam matriks alternatif.'],
          ['2', 'Matriks Keputusan (X)', 'Menyusun nilai riil setiap paket desain terhadap 5 kriteria penilaian.'],
          ['3', 'Normalisasi (R)', 'Normalisasi matriks: benefit (r=x/max) dan cost (r=min/x).'],
          ['4', 'Pembobotan (V)', 'Mengalikan matriks ternormalisasi dengan bobot preferensi (W).'],
          ['5', 'Perankingan', 'Mengurutkan nilai akhir Vi; 3 paket teratas ditampilkan sebagai rekomendasi.'],
        ];
        @endphp

        <div class="d-flex flex-column gap-3">
          @foreach($sawSteps as $st)
          <div class="d-flex gap-3 align-items-start">
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold text-white small" style="width:28px;height:28px;background:var(--primary);font-size:0.75rem;">
              {{ $st[0] }}
            </div>
            <div>
              <div class="fw-semibold small text-dark">{{ $st[1] }}</div>
              <div class="text-muted" style="font-size:0.75rem;">{{ $st[2] }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- KRITERIA TABLE (dinamis dari database) --}}
      <div class="card-clean p-4">
        <h3 class="fw-bold fs-6 mb-3 text-dark">Matriks Kriteria & Bobot</h3>
        <div class="table-responsive">
          <table class="table table-clean mb-0" style="font-size:0.8rem;">
            <thead><tr><th>Kriteria</th><th>Tipe</th><th class="text-end">Bobot</th></tr></thead>
            <tbody>
              @foreach($criteria as $c)
              <tr>
                <td>{{ $c->name }}</td>
                <td><span class="{{ $c->type === 'cost' ? 'text-danger' : 'text-success' }} fw-medium">{{ $c->type === 'cost' ? 'Cost' : 'Benefit' }}</span></td>
                <td class="text-end fw-bold">{{ round(($weights[$c->code] ?? 0) * 100, 1) }}%</td>
              </tr>
              @endforeach
              <tr class="fw-bold bg-light"><td colspan="2">Total Bobot</td><td class="text-end">{{ round(array_sum($weights) * 100) }}%</td></tr>
            </tbody>
          </table>
        </div>

        @auth
        <div class="mt-3 pt-3 border-top text-center">
          <a href="{{ route('spk.history') }}" class="text-decoration-none small fw-medium" style="color:var(--primary)">
            Lihat Riwayat Perhitungan Anda →
          </a>
        </div>
        @endauth
      </div>
    </div>

  </div>
</div>

@endsection

@section('scripts')
<script>
  document.querySelectorAll('.budget-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelector('[name="budget"]').value = btn.dataset.val;
    });
  });
  document.querySelectorAll('.area-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelector('[name="area"]').value = btn.dataset.val;
    });
  });
</script>
@endsection
