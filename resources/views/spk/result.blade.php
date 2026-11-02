@extends('layouts.app')
@section('title', 'Hasil Rekomendasi SAW — CV. Gardenia Setia Utama')

@section('styles')
<style>
.result-summary-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.18);
    border-radius: 999px;
    padding: 0.4rem 1rem;
    font-size: 0.82rem;
    color: rgba(255,255,255,0.92);
}
.result-summary-pill + .result-summary-pill { margin-left: 0.5rem; }
.result-summary-pill strong { color: #ffffff; font-weight: 700; }

.rank-badge-strip {
    padding: 0.65rem 1rem;
    text-align: center;
    font-size: 0.76rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
}
.rank-badge-strip.rank-1 { background: var(--primary); color: #ffffff; }
.rank-badge-strip.rank-2 { background: var(--accent-light); color: var(--accent-hover); border-bottom: 1px solid var(--accent-border); }
.rank-badge-strip.rank-3 { background: #f1f5f9; color: var(--text-muted); border-bottom: 1px solid var(--border-color); }

.package-card-highlight {
    border: 2px solid var(--primary) !important;
    box-shadow: var(--shadow-lg);
    transform: translateY(-4px);
}

.spec-mini-box {
    padding: 0.55rem;
    border-radius: var(--radius-sm);
    background: var(--bg-page);
    border: 1px solid var(--border-color);
    text-align: center;
}
.spec-mini-box .spec-label {
    font-size: 0.68rem;
    color: var(--text-light);
    display: block;
    margin-bottom: 0.15rem;
}
.spec-mini-box .spec-value {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--text-main);
}

.normalization-box {
    background: var(--bg-page);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-sm);
    padding: 0.85rem 1rem;
}
.normalization-row {
    display: flex;
    justify-content: space-between;
    padding: 0.3rem 0;
    font-size: 0.76rem;
}
.normalization-row + .normalization-row {
    border-top: 1px dashed var(--border-color);
}

.matrix-table thead th {
    vertical-align: middle;
}
.matrix-table tbody tr.top-rank td {
    background-color: var(--primary-soft);
}
.matrix-table tbody tr.top-rank td:first-child {
    border-left: 3px solid var(--primary);
}

.formula-block {
    background: var(--bg-page);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-sm);
    padding: 1rem 1.1rem;
    font-family: 'SFMono-Regular', Consolas, monospace;
    font-size: 0.8rem;
    line-height: 1.7;
}
.formula-block .formula-title {
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 0.15rem;
}

.input-param-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.65rem 0;
}
.input-param-row + .input-param-row {
    border-top: 1px solid var(--border-color);
}
.input-param-row .param-label {
    font-size: 0.82rem;
    color: var(--text-muted);
}
.input-param-row .param-value {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--text-main);
}

.section-intro { max-width: 560px; margin-left: auto; margin-right: auto; }
</style>
@endsection

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header-clean text-center">
  <div class="container">
    <span class="badge px-3 py-2 small mb-3 d-inline-block" style="background: rgba(255,255,255,0.1); color:#fff; border:1px solid rgba(255,255,255,0.2); border-radius:999px; font-weight:600; letter-spacing:0.04em;">
      Hasil Perhitungan SAW
    </span>
    <h1>Rekomendasi Paket Desain Terbaik</h1>
    <div class="mt-3">
      <span class="result-summary-pill">Budget <strong>Rp {{ number_format($input['budget'], 0, ',', '.') }}</strong></span>
      <span class="result-summary-pill">Luas <strong>{{ $input['area'] }} m²</strong></span>
      @if(!empty($input['style_preference']))
        <span class="result-summary-pill">Gaya <strong>{{ ucfirst($input['style_preference']) }}</strong></span>
      @endif
    </div>
  </div>
</section>

<div class="container py-5">

  {{-- TOP 3 REKOMENDASI --}}
  <div class="text-center mb-5">
    <span class="section-tagline">Pilihan Peringkat Teratas</span>
    <h2 class="section-heading mb-2">3 Alternatif Paket Paling Sesuai</h2>
    <p class="text-muted small section-intro">Diurutkan berdasarkan perolehan nilai preferensi (V<sub>i</sub>) tertinggi.</p>
  </div>

  <div class="row g-4 mb-5 justify-content-center">
    @foreach(array_slice($ranking, 0, 3) as $item)
    <div class="col-md-6 col-lg-4">
      <div class="card-clean p-0 h-100 d-flex flex-column overflow-hidden {{ $item['rank'] == 1 ? 'package-card-highlight' : '' }}">

        {{-- BADGE RANKING --}}
        <div class="rank-badge-strip rank-{{ $item['rank'] }}">
          @if($item['rank'] == 1)
            <i class="bi bi-trophy-fill"></i> REKOMENDASI UTAMA
          @elseif($item['rank'] == 2)
            <i class="bi bi-award-fill"></i> ALTERNATIF #2
          @else
            <i class="bi bi-award-fill"></i> ALTERNATIF #3
          @endif
        </div>

        <div class="p-4 d-flex flex-column flex-fill">
          <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
            <h3 class="fw-bold fs-5 mb-0 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $item['package']->name }}</h3>
            <span class="fs-6 fw-bold flex-shrink-0" style="color:var(--primary);">{{ $item['score_pct'] }}%</span>
          </div>

          <p class="text-muted small mb-3" style="min-height: 40px;">{{ $item['package']->description }}</p>

          {{-- SCORE PROGRESS BAR --}}
          <div class="mb-4">
            <div class="d-flex justify-content-between text-muted small mb-1" style="font-size:0.75rem;">
              <span>Skor Preferensi</span>
              <span class="fw-bold text-dark">{{ $item['score'] }}</span>
            </div>
            <div class="progress" style="height: 6px; background-color: var(--border-color);">
              <div class="progress-bar" role="progressbar" style="width: {{ $item['score_pct'] }}%; background-color: var(--primary);" aria-valuenow="{{ $item['score_pct'] }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>

          {{-- SPECS 2x2 --}}
          <div class="row g-2 mb-4">
            <div class="col-6">
              <div class="spec-mini-box">
                <span class="spec-label">Rentang Budget</span>
                <div class="spec-value">{{ number_format($item['package']->budget_min/1000000, 0, ',', '.') }}–{{ number_format($item['package']->budget_max/1000000, 0, ',', '.') }} Jt</div>
              </div>
            </div>
            <div class="col-6">
              <div class="spec-mini-box">
                <span class="spec-label">Luas Efektif</span>
                <div class="spec-value">{{ $item['package']->area_min }}–{{ $item['package']->area_max }} m²</div>
              </div>
            </div>
            <div class="col-6">
              <div class="spec-mini-box">
                <span class="spec-label">Durasi Kerja</span>
                <div class="spec-value">{{ $item['package']->duration_months }} Bulan</div>
              </div>
            </div>
            <div class="col-6">
              <div class="spec-mini-box">
                <span class="spec-label">Mulai Dari</span>
                <div class="spec-value">Rp {{ number_format($item['package']->price_start/1000000, 0, ',', '.') }} Jt</div>
              </div>
            </div>
          </div>

          {{-- NORMALISASI SINGKAT (C1 tidak ditampilkan, kode kriteria lain disembunyikan) --}}
          <div class="normalization-box mb-4">
            <div class="fw-semibold text-dark mb-1" style="font-size:0.78rem;">Nilai Normalisasi Kriteria</div>
            @foreach($criterias as $c)
            @continue($c->code === 'C1')
            <div class="normalization-row text-muted">
              <span>{{ $c->name }}</span>
              <span class="fw-medium text-dark">{{ number_format($item['normalized'][$c->code] ?? 0, 4) }}</span>
            </div>
            @endforeach
          </div>

          <div class="mt-auto">
            @auth
              <form action="{{ route('spk.orderPackage', $item['package']->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-gardenia w-100 py-2.5 text-center">
                  Pesan Paket Ini
                </button>
              </form>
              <div class="text-muted text-center mt-2" style="font-size:0.72rem;">Langsung dialihkan ke form checkout pesanan</div>
            @else
              <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="btn-gardenia w-100 py-2.5 text-center">
                Masuk untuk Memesan
              </a>
              <div class="text-muted text-center mt-2" style="font-size:0.72rem;">Masuk ke akun Anda untuk melanjutkan pesanan</div>
            @endauth
          </div>

        </div>

      </div>
    </div>
    @endforeach
  </div>

  {{-- MATRIKS KEPUTUSAN LENGKAP (C1 tidak ditampilkan, kode kriteria lain disembunyikan) --}}
  <div class="card-clean overflow-hidden mb-5">
    <div class="p-4 border-bottom bg-white">
      <h3 class="fw-bold fs-6 mb-1 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Matriks Keputusan & Normalisasi Lengkap</h3>
      <p class="text-muted small mb-0">Rincian data nilai matriks keputusan dan nilai normalisasi seluruh paket.</p>
    </div>

    <div class="table-responsive">
      <table class="table table-clean matrix-table mb-0 align-middle" style="font-size:0.8rem;">
        <thead>
          <tr>
            <th rowspan="2" class="text-center" style="width: 50px;">Rank</th>
            <th rowspan="2">Paket Desain</th>
            @foreach($criterias as $c)
            @continue($c->code === 'C1')
            <th colspan="2" class="text-center border-start border-end">
              {{ $c->name }} ({{ $c->weight }}%)
              <div class="fw-normal" style="font-size:0.7rem;">
                <span class="{{ $c->type == 'benefit' ? 'text-success' : 'text-danger' }}">
                  {{ $c->type == 'benefit' ? 'Benefit' : 'Cost' }}
                </span>
              </div>
            </th>
            @endforeach
            <th rowspan="2" class="text-center bg-light">Skor</th>
          </tr>
          <tr class="bg-light" style="font-size:0.72rem;">
            @foreach($criterias as $c)
            @continue($c->code === 'C1')
            <th class="text-center text-muted border-start">Nilai</th>
            <th class="text-center text-muted border-end">Normalisasi</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach($ranking as $item)
          <tr class="{{ $item['rank'] <= 3 ? 'top-rank' : '' }}">
            <td class="text-center fw-bold">#{{ $item['rank'] }}</td>
            <td><span class="fw-semibold text-dark">{{ $item['package']->name }}</span></td>
            @foreach($criterias as $c)
            @continue($c->code === 'C1')
            <td class="text-center text-muted border-start">{{ number_format($item['raw'][$c->code] ?? 0, 2) }}</td>
            <td class="text-center fw-medium text-dark border-end">{{ number_format($item['normalized'][$c->code] ?? 0, 4) }}</td>
            @endforeach
            <td class="text-center fw-bold bg-light" style="color:var(--primary);">
              {{ $item['score'] }}
              <div class="text-muted fw-normal" style="font-size:0.7rem;">({{ $item['score_pct'] }}%)</div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- FORMULASI MATEMATIKA SAW --}}
  <div class="row g-4 mb-5">
    <div class="col-md-6">
      <div class="card-clean p-4 h-100">
        <h4 class="fw-bold fs-6 mb-3 text-dark">Formulasi Perhitungan SAW</h4>
        <div class="formula-block mb-3">
          <div class="formula-title text-success">1. Kriteria Benefit (Keuntungan)</div>
          r<sub>ij</sub> = x<sub>ij</sub> / Max(x<sub>ij</sub>)
          <br><br>
          <div class="formula-title text-danger">2. Kriteria Cost (Biaya/Durasi)</div>
          r<sub>ij</sub> = Min(x<sub>ij</sub>) / x<sub>ij</sub>
          <br><br>
          <div class="formula-title text-dark">3. Nilai Preferensi Akhir</div>
          V<sub>i</sub> = &sum; (w<sub>j</sub> &times; r<sub>ij</sub>)
        </div>
        <span class="text-muted small" style="font-size:0.75rem;">Metode Simple Additive Weighting (SAW) mencari penjumlahan terbobot dari rating kinerja setiap alternatif.</span>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card-clean p-4 h-100">
        <h4 class="fw-bold fs-6 mb-3 text-dark">Parameter Input Anda</h4>
        <div>
          <div class="input-param-row">
            <span class="param-label">Alokasi Anggaran</span>
            <span class="param-value">Rp {{ number_format($input['budget'], 0, ',', '.') }}</span>
          </div>
          <div class="input-param-row">
            <span class="param-label">Luas Bangunan</span>
            <span class="param-value">{{ $input['area'] }} m²</span>
          </div>
          <div class="input-param-row">
            <span class="param-label">Target Durasi</span>
            <span class="param-value">{{ !empty($input['duration_pref']) ? 'Maks ' . $input['duration_pref'] . ' Bulan' : 'Fleksibel' }}</span>
          </div>
          <div class="input-param-row">
            <span class="param-label">Preferensi Konsep</span>
            <span class="param-value">{{ !empty($input['style_preference']) ? ucfirst($input['style_preference']) : 'Universal' }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- AKSI LANJUTAN --}}
  <div class="d-flex gap-3 justify-content-center flex-wrap">
    <a href="{{ route('spk.index') }}" class="btn-gardenia-outline">
      <i class="bi bi-arrow-left me-1"></i> Hitung Ulang Parameter
    </a>
    <a href="{{ route('services') }}" class="btn-gardenia">
      Lihat Seluruh Katalog Layanan
    </a>
    <a href="{{ route('contact') }}" class="btn-gardenia-outline">
      Konsultasi dengan Tim Arsitek
    </a>
  </div>

</div>

@endsection