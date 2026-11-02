@extends('layouts.app')
@section('title', 'Sistem Pendukung Keputusan (SPK) SAW — CV. Gardenia Setia Utama')

@section('styles')
<style>
.spk-head { padding: 3.5rem 0 3rem; border-bottom: 1px solid var(--line); }
.spk-head h1 { font-size: clamp(2.8rem, 7vw, 5.5rem); font-weight: 300; max-width: 13ch; margin: 0 0 1.5rem; }
.spk-head .lead-text { max-width: 520px; color: var(--paper-dim); line-height: 1.75; margin: 0 0 .75rem; }
.spk-head .method { font-size: .8rem; color: var(--paper-faint); margin: 0; }

/* Judul kecil memakai font isi agar tetap tajam */
.h-label { font-family: var(--font-body); text-transform: none; font-weight: 500; letter-spacing: 0; font-size: 1.05rem; line-height: 1.3; }

/* Lembar parameter */
.param { display: grid; grid-template-columns: 1fr; gap: .9rem 3rem; padding: 2rem 0; border-top: 1px solid var(--line); }
.param:first-of-type { border-top: 0; }
.param-name { font-weight: 500; font-size: 1.05rem; line-height: 1.3; margin: 0 0 .35rem; }
.param-name .req { color: #f0a0a0; margin-left: .15rem; }
.param-weight { font-size: .82rem; color: var(--paper-dim); margin: 0; }
.param-weight .w { color: var(--lamp); }
.param-weight .w.cost { color: #f0a0a0; }
.param-hint { font-size: .82rem; color: var(--paper-faint); line-height: 1.6; margin: 0; }
@media (min-width: 992px) {
    .param { grid-template-columns: 15rem minmax(0, 1fr) 14rem; align-items: start; }
}

.input-group-text { background: var(--ink-3); color: var(--paper-dim); border: 1px solid var(--line); border-radius: 0; }
.chips { display: flex; flex-wrap: wrap; gap: .5rem; margin-top: .75rem; }
.chip { background: transparent; color: var(--paper-dim); border: 1px solid var(--line); border-radius: 0; padding: .35rem .8rem; font-size: .8rem; font-family: var(--font-body); cursor: pointer; transition: color .15s ease, border-color .15s ease; }
.chip:hover { color: var(--paper); border-color: var(--lamp); }

.submit-row { display: flex; flex-wrap: wrap; align-items: center; gap: 1.5rem; padding-top: 2rem; border-top: 1px solid var(--line); }
.submit-row p { margin: 0; font-size: .82rem; color: var(--paper-faint); max-width: 38ch; }

/* Urutan tahapan: ini memang urutan, jadi diberi nomor */
.steps { display: grid; grid-template-columns: 1fr; border-top: 1px solid var(--line); }
.step { padding: 1.5rem 0; border-bottom: 1px solid var(--line-soft); display: grid; grid-template-columns: 3.5rem 1fr; gap: 1rem; }
.step .n { font-family: var(--font-display); font-size: 2rem; font-weight: 300; line-height: 1; color: var(--lamp); }
.step .t { font-weight: 500; margin-bottom: .25rem; }
.step .d { font-size: .85rem; color: var(--paper-dim); line-height: 1.6; }
@media (min-width: 992px) {
    .steps { grid-template-columns: repeat(5, 1fr); }
    .step { display: block; padding: 1.5rem 1.5rem 1.5rem 0; border-bottom: 0; }
    .step + .step { padding-left: 1.5rem; border-left: 1px solid var(--line-soft); }
    .step .n { margin-bottom: 1rem; }
}
.crit td.benefit { color: var(--lamp); }
.crit td.cost { color: #f0a0a0; }
</style>
@endsection

@section('content')

{{-- HEADER --}}
<section class="spk-head">
  <div class="container">
    <h1>Kalkulator rekomendasi paket desain</h1>
    <p class="lead-text">Dapatkan rekomendasi paket rancangan arsitektur dan konstruksi terbaik yang dihitung secara presisi berdasarkan parameter kebutuhan dan anggaran Anda.</p>
    <p class="method">Metode Simple Additive Weighting (SAW)</p>
  </div>
</section>

{{-- FORM --}}
<section class="py-5">
  <div class="container">
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show p-3 mb-4 border-0 bg-danger-subtle text-danger">
        <span class="small">{{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
      </div>
    @endif

    <form action="{{ route('spk.calculate') }}" method="POST">
      @csrf

      {{-- Budget --}}
      <div class="param">
        <div>
          <h2 class="param-name">Alokasi anggaran<span class="req" aria-hidden="true">*</span></h2>
          <p class="param-weight"><span class="w">Bobot 30%</span> · Benefit</p>
        </div>
        <div>
          <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" name="budget" class="form-control @error('budget') is-invalid @enderror"
                   placeholder="Contoh: 350000000" value="{{ old('budget') }}" min="1000000" step="1000000" required>
          </div>
          <div class="chips">
            <button type="button" class="chip budget-btn" data-val="200000000">200 Juta</button>
            <button type="button" class="chip budget-btn" data-val="350000000">350 Juta</button>
            <button type="button" class="chip budget-btn" data-val="500000000">500 Juta</button>
            <button type="button" class="chip budget-btn" data-val="800000000">800 Juta</button>
            <button type="button" class="chip budget-btn" data-val="1500000000">1,5 Miliar</button>
          </div>
          @error('budget')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
        </div>
        <p class="param-hint">Estimasi total dana konstruksi & perancangan.</p>
      </div>

      {{-- Luas Bangunan --}}
      <div class="param">
        <div>
          <h2 class="param-name">Luas bangunan rencana<span class="req" aria-hidden="true">*</span></h2>
          <p class="param-weight"><span class="w">Bobot 25%</span> · Benefit</p>
        </div>
        <div>
          <div class="input-group">
            <input type="number" name="area" class="form-control @error('area') is-invalid @enderror"
                   placeholder="Contoh: 120" value="{{ old('area') }}" min="20" max="2000" required>
            <span class="input-group-text">m²</span>
          </div>
          <div class="chips">
            <button type="button" class="chip area-btn" data-val="60">60 m²</button>
            <button type="button" class="chip area-btn" data-val="100">100 m²</button>
            <button type="button" class="chip area-btn" data-val="150">150 m²</button>
            <button type="button" class="chip area-btn" data-val="250">250 m²</button>
            <button type="button" class="chip area-btn" data-val="400">400 m²</button>
          </div>
          @error('area')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
        </div>
        <p class="param-hint">Isi antara 20 dan 2.000 m².</p>
      </div>

      {{-- Durasi Pengerjaan --}}
      <div class="param">
        <div>
          <h2 class="param-name">Target durasi pengerjaan</h2>
          <p class="param-weight"><span class="w cost">Bobot 20%</span> · Cost</p>
        </div>
        <div>
          <select name="duration_pref" class="form-select">
            <option value="">Tidak ada batasan waktu spesifik</option>
            <option value="3" {{ old('duration_pref')=='3' ? 'selected':'' }}>Maksimal 3 bulan</option>
            <option value="5" {{ old('duration_pref')=='5' ? 'selected':'' }}>Maksimal 5 bulan</option>
            <option value="7" {{ old('duration_pref')=='7' ? 'selected':'' }}>Maksimal 7 bulan</option>
            <option value="10" {{ old('duration_pref')=='10' ? 'selected':'' }}>Maksimal 10 bulan</option>
            <option value="18" {{ old('duration_pref')=='18' ? 'selected':'' }}>Fleksibel (>12 bulan)</option>
          </select>
        </div>
        <p class="param-hint">Kriteria cost: durasi lebih efisien menghasilkan nilai normalisasi lebih optimal.</p>
      </div>

      {{-- Gaya Desain --}}
      <div class="param">
        <div>
          <h2 class="param-name">Preferensi konsep desain</h2>
          <p class="param-weight"><span class="w">Bobot 25%</span> · Fitur & Material</p>
        </div>
        <div>
          <select name="style_preference" class="form-select">
            <option value="">Pilih konsep desain...</option>
            <option value="minimalis" {{ old('style_preference')=='minimalis' ? 'selected':'' }}>Minimalis Modern</option>
            <option value="klasik" {{ old('style_preference')=='klasik' ? 'selected':'' }}>Klasik Elegan</option>
            <option value="tropis" {{ old('style_preference')=='tropis' ? 'selected':'' }}>Tropis Kontemporer</option>
            <option value="industrial" {{ old('style_preference')=='industrial' ? 'selected':'' }}>Industrial Modern</option>
            <option value="mediteran" {{ old('style_preference')=='mediteran' ? 'selected':'' }}>Mediterania Resort</option>
            <option value="bebas" {{ old('style_preference')=='bebas' ? 'selected':'' }}>Universal / Semua Gaya</option>
          </select>
        </div>
        <p class="param-hint">Mempengaruhi evaluasi kelengkapan gambar kerja dan spesifikasi material.</p>
      </div>

      <div class="submit-row">
        <button type="submit" class="btn-gardenia-gold btn-gardenia-lg">Hitung rekomendasi paket →</button>
        <p>Hasil berupa tiga paket teratas beserta nilai preferensinya.</p>
      </div>
    </form>
  </div>
</section>

{{-- TAHAPAN SAW --}}
<section class="py-5" style="border-top:1px solid var(--line);">
  <div class="container py-3">
    <h2 class="mb-4" style="font-size:clamp(2rem,4vw,3rem);font-weight:300;">Cara hasilnya dihitung</h2>

    @php
    $sawSteps = [
      ['1', 'Pengumpulan variabel', 'Data budget, luas, durasi, dan konsep dipetakan ke dalam matriks alternatif.'],
      ['2', 'Matriks keputusan (X)', 'Menyusun nilai riil setiap paket desain terhadap 5 kriteria penilaian.'],
      ['3', 'Normalisasi (R)', 'Normalisasi matriks: benefit (r=x/max) dan cost (r=min/x).'],
      ['4', 'Pembobotan (V)', 'Mengalikan matriks ternormalisasi dengan bobot preferensi (W).'],
      ['5', 'Perankingan', 'Mengurutkan nilai akhir Vi untuk menentukan 3 alternatif paket teratas.'],
    ];
    @endphp

    <div class="steps">
      @foreach($sawSteps as $st)
      <div class="step">
        <div class="n">{{ $st[0] }}</div>
        <div>
          <div class="t">{{ $st[1] }}</div>
          <div class="d">{{ $st[2] }}</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- MATRIKS KRITERIA --}}
<section class="pb-5">
  <div class="container pb-3">
    <div class="row g-4 g-lg-5">
      <div class="col-lg-4">
        <h2 class="h-label mb-2">Matriks kriteria & bobot</h2>
        <p class="small mb-3" style="color:var(--paper-dim);line-height:1.7;">Bobot setiap kriteria yang dipakai pada tahap pembobotan.</p>
        @auth
          <a href="{{ route('spk.history') }}" class="small">Lihat riwayat perhitungan Anda →</a>
        @endauth
      </div>

      <div class="col-lg-8">
        <div class="table-responsive">
          <table class="table table-clean crit mb-0">
            <thead>
              <tr>
                <th>Kriteria</th>
                <th>Tipe</th>
                <th class="text-end">Bobot</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Luas Bangunan</td>
                <td class="benefit">Benefit</td>
                <td class="text-end fw-semibold">25%</td>
              </tr>
              <tr>
                <td>Durasi Kerja</td>
                <td class="cost">Cost</td>
                <td class="text-end fw-semibold">20%</td>
              </tr>
              <tr>
                <td>Fitur Desain</td>
                <td class="benefit">Benefit</td>
                <td class="text-end fw-semibold">15%</td>
              </tr>
              <tr>
                <td>Material Spek</td>
                <td class="benefit">Benefit</td>
                <td class="text-end fw-semibold">10%</td>
              </tr>
              <tr class="fw-bold">
                <td colspan="2">Total Bobot</td>
                <td class="text-end">100%</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

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
