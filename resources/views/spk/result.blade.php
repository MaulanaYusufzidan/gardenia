@extends('layouts.app')
@section('title', 'Hasil Rekomendasi | CV. Gardenia Setia Utama')

@section('styles')
<style>
.result-summary { color: rgba(255,255,255,0.85); font-size: 0.92rem; margin-top: 0.75rem; }
.result-summary strong { color: #fff; font-weight: 600; }

.package-card-top { border: 2px solid var(--primary) !important; }
.rank-label { font-size: 0.78rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.35rem; }
.package-card-top .rank-label { color: var(--primary); }

.spec-list { font-size: 0.8rem; margin: 0; }
.spec-list div { display: flex; justify-content: space-between; padding: 0.3rem 0; }
.spec-list div + div { border-top: 1px solid var(--border-color); }
.spec-list dt { font-weight: 400; color: var(--text-muted); }
.spec-list dd { margin: 0; font-weight: 600; color: var(--text-main); }

.score-table { width: 100%; font-size: 0.78rem; }
.score-table th { font-weight: 600; color: var(--text-muted); padding: 0.25rem 0; }
.score-table td { padding: 0.25rem 0; border-top: 1px solid var(--border-color); }
.score-table tfoot td { font-weight: 700; color: var(--primary); }

.fit-note { font-size: 0.78rem; color: var(--text-muted); margin-bottom: 0.15rem; }
.fit-note.warn { color: #b45309; }

.matrix-table tbody tr.top-rank td { background-color: var(--primary-soft); }

.formula-block {
    background: var(--bg-page);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-sm);
    padding: 1rem 1.1rem;
    font-size: 0.82rem;
    line-height: 1.7;
}
.formula-block .formula-title { font-weight: 700; font-size: 0.78rem; margin-top: 0.6rem; }
.formula-block .formula-title:first-child { margin-top: 0; }

.input-param-row { display: flex; justify-content: space-between; padding: 0.55rem 0; }
.input-param-row + .input-param-row { border-top: 1px solid var(--border-color); }
.input-param-row .param-label { font-size: 0.82rem; color: var(--text-muted); }
.input-param-row .param-value { font-size: 0.85rem; font-weight: 600; color: var(--text-main); }
</style>
@endsection

@section('content')
@php
  $rp   = fn($n) => 'Rp ' . number_format($n, 0, ',', '.');
  $crit = $calc['criteria'];
  $rank = $calc['ranking'];
  $st   = ['below' => ['warn','di bawah rentang'], 'within' => ['ok','dalam rentang'], 'above' => ['warn','di atas rentang']];
@endphp

<section class="page-header-clean text-center">
  <div class="container">
    <h1>Hasil Rekomendasi Paket Desain</h1>
    <div class="result-summary">
      Anggaran <strong>{{ $rp($result->budget_input) }}</strong>
      &nbsp;·&nbsp; Luas <strong>{{ $result->area_input }} m²</strong>
      @if($result->duration_pref)&nbsp;·&nbsp; Durasi <strong>maks. {{ $result->duration_pref }} bulan</strong>@endif
      @if($result->style_preference)&nbsp;·&nbsp; Konsep <strong>{{ $styles[$result->style_preference] ?? $result->style_preference }}</strong>@endif
    </div>
  </div>
</section>

<div class="container py-5">

  @foreach($calc['warnings'] as $w)
    <div class="alert alert-warning border-0 small mb-3">{{ $w }}</div>
  @endforeach

  <div class="mb-4 mt-3">
    <h2 class="fs-4 fw-bold mb-1">Tiga paket paling sesuai</h2>
    <p class="text-muted small mb-0">Diurutkan dari nilai preferensi V tertinggi. V bersifat relatif antar paket, bukan persentase kecocokan.</p>
  </div>

  <div class="row g-4 mb-5 justify-content-center">
    @foreach(array_slice($rank, 0, 3) as $item)
    @php $p = $item['package']; @endphp
    <div class="col-md-6 col-lg-4">
      <div class="card-clean p-4 h-100 d-flex flex-column {{ $item['rank'] == 1 ? 'package-card-top' : '' }}">
        <div class="rank-label">{{ $item['rank'] == 1 ? 'Rekomendasi utama' : 'Alternatif ' . $item['rank'] }}</div>
        <div class="d-flex justify-content-between align-items-baseline mb-2 gap-2">
          <h3 class="fw-bold fs-5 mb-0 text-dark">{{ $p['name'] }}</h3>
          <span class="small fw-bold flex-shrink-0" style="color:var(--primary);">V = {{ number_format($item['score'], 4) }}</span>
        </div>
        <p class="text-muted small mb-3">{{ $p['description'] }}</p>

        <div class="mb-3">
          <div class="fit-note {{ $item['budget_status'] === 'within' ? '' : 'warn' }}">Anggaran {{ $st[$item['budget_status']][1] }}</div>
          <div class="fit-note {{ $item['area_status'] === 'within' ? '' : 'warn' }}">Luas {{ $st[$item['area_status']][1] }}</div>
          @if($item['meets_duration'] === true)<div class="fit-note">Sesuai batas durasi</div>
          @elseif($item['meets_duration'] === false)<div class="fit-note warn">Melebihi batas durasi</div>@endif
        </div>

        <dl class="spec-list mb-3">
          <div><dt>Rentang anggaran</dt><dd>{{ number_format($p['budget_min']/1e6,0,',','.') }}–{{ number_format($p['budget_max']/1e6,0,',','.') }} jt</dd></div>
          <div><dt>Rentang luas</dt><dd>{{ $p['area_min'] }}–{{ $p['area_max'] }} m²</dd></div>
          <div><dt>Durasi</dt><dd>{{ $p['duration_months'] }} bulan</dd></div>
          <div><dt>Mulai dari</dt><dd>{{ $rp($p['price_start']) }}</dd></div>
        </dl>

        <table class="score-table mb-4">
          <thead><tr><th>Kriteria</th><th class="text-end">r</th><th class="text-end">w × r</th></tr></thead>
          <tbody>
            @foreach($crit as $c)
            <tr>
              <td>{{ $c['name'] }} <span class="text-muted">({{ round($c['weight_eff']*100,1) }}%)</span></td>
              <td class="text-end">{{ number_format($item['normalized'][$c['code']], 4) }}</td>
              <td class="text-end">{{ number_format($item['weighted'][$c['code']] ?? ($c['weight_eff'] * $item['normalized'][$c['code']]), 4) }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot><tr><td colspan="2">V</td><td class="text-end">{{ number_format($item['score'], 4) }}</td></tr></tfoot>
        </table>

        <div class="mt-auto">
          @auth
            @if(in_array($p['id'], $orderableIds))
            <form action="{{ route('spk.orderPackage', $p['id']) }}" method="POST">
              @csrf
              <input type="hidden" name="result" value="{{ $result->token }}">
              <button type="submit" class="btn-gardenia w-100 py-2 text-center">Pesan paket ini</button>
            </form>
            @else
            <div class="text-muted text-center small">Paket ini sudah tidak tersedia.</div>
            @endif
          @else
            <a href="{{ route('login', ['next' => url()->current()]) }}" class="btn-gardenia w-100 py-2 text-center">Masuk untuk memesan</a>
          @endauth
        </div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- MATRIKS LENGKAP: seluruh kriteria tampil agar skor dapat direproduksi --}}
  <div class="card-clean overflow-hidden mb-5">
    <div class="p-4 border-bottom">
      <h3 class="fw-bold fs-6 mb-1 text-dark">Matriks keputusan dan normalisasi</h3>
      <p class="text-muted small mb-0">Nilai x<sub>ij</sub> dan r<sub>ij</sub> untuk seluruh paket; V<sub>i</sub> = Σ (w<sub>j</sub> × r<sub>ij</sub>).</p>
    </div>
    <div class="table-responsive">
      <table class="table table-clean matrix-table mb-0 align-middle" style="font-size:0.8rem;">
        <thead>
          <tr>
            <th rowspan="2" class="text-center" style="width:50px;">Rank</th>
            <th rowspan="2">Paket Desain</th>
            @foreach($crit as $c)
            <th colspan="2" class="text-center border-start border-end">
              {{ $c['name'] }} ({{ round($c['weight_eff']*100,1) }}%)
              <div class="fw-normal" style="font-size:0.7rem;"><span class="{{ $c['type']==='benefit' ? 'text-success' : 'text-danger' }}">{{ $c['type']==='benefit' ? 'Benefit' : 'Cost' }}</span></div>
            </th>
            @endforeach
            <th rowspan="2" class="text-center">V<sub>i</sub></th>
          </tr>
          <tr style="font-size:0.72rem;">
            @foreach($crit as $c)
            <th class="text-center text-muted border-start">x</th><th class="text-center text-muted border-end">r</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach($rank as $item)
          <tr class="{{ $item['rank'] <= 3 ? 'top-rank' : '' }}">
            <td class="text-center fw-bold">#{{ $item['rank'] }}</td>
            <td><span class="fw-semibold text-dark">{{ $item['package']['name'] }}</span></td>
            @foreach($crit as $c)
            <td class="text-center text-muted border-start">{{ number_format($item['raw'][$c['code']], 2) }}</td>
            <td class="text-center fw-medium text-dark border-end">{{ number_format($item['normalized'][$c['code']], 4) }}</td>
            @endforeach
            <td class="text-center fw-bold" style="color:var(--primary);">{{ number_format($item['score'], 4) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="p-3 border-top text-muted" style="font-size:0.75rem;">
      @if(collect($crit)->contains(fn ($c) => ! empty($c['measurement'])))
        <div class="fw-semibold text-dark mb-2">Definisi Kriteria</div>
        <ul class="mb-0 ps-3">
          @foreach($crit as $c)
            <li class="mb-1"><strong>{{ $c['code'] }} · {{ $c['name'] }}</strong>
              ({{ $c['type'] === 'cost' ? 'Cost' : 'Benefit' }}@if(! empty($c['unit'])), {{ $c['unit'] }}@endif)
              @if(! empty($c['measurement'])): {{ $c['measurement'] }}@endif
            </li>
          @endforeach
        </ul>
      @else
        C1 dan C2 = 1 bila nilai Anda berada dalam rentang paket, makin kecil bila makin jauh di luar rentang. C3 = durasi (bulan). C4 dan C5 = skor 1–10.
      @endif
    </div>
  </div>

  <div class="row g-4 mb-5">
    <div class="col-md-6">
      <div class="card-clean p-4 h-100">
        <h4 class="fw-bold fs-6 mb-3 text-dark">Rumus yang dipakai</h4>
        <div class="formula-block mb-3">
          <div class="formula-title">Kecocokan C1 dan C2 (x)</div>
          x = 1 bila nilai Anda di dalam rentang paket<br>
          x = 1 &minus; jarak ke batas terdekat / batas terdekat, bila di luar rentang
          <div class="formula-title">Normalisasi benefit</div>
          r<sub>ij</sub> = x<sub>ij</sub> / Max(x<sub>j</sub>)
          <div class="formula-title">Normalisasi cost</div>
          r<sub>ij</sub> = Min(x<sub>j</sub>) / x<sub>ij</sub>
          <div class="formula-title">Nilai preferensi</div>
          V<sub>i</sub> = &sum; (w<sub>j</sub> &times; r<sub>ij</sub>)
        </div>
        <span class="text-muted" style="font-size:0.75rem;">Bobot w<sub>j</sub> dinormalisasi terhadap total bobot kriteria aktif sehingga V berada pada rentang 0–1.</span>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card-clean p-4 h-100">
        <h4 class="fw-bold fs-6 mb-3 text-dark">Input Anda</h4>
        <div class="input-param-row"><span class="param-label">Alokasi Anggaran</span><span class="param-value">{{ $rp($result->budget_input) }}</span></div>
        <div class="input-param-row"><span class="param-label">Luas Bangunan</span><span class="param-value">{{ $result->area_input }} m²</span></div>
        <div class="input-param-row"><span class="param-label">Batas Durasi</span><span class="param-value">{{ $result->duration_pref ? 'Maks ' . $result->duration_pref . ' Bulan' : 'Fleksibel' }}</span></div>
        <div class="input-param-row"><span class="param-label">Preferensi Konsep</span><span class="param-value">{{ $result->style_preference ? ($styles[$result->style_preference] ?? $result->style_preference) : 'Universal' }}</span></div>
        <div class="input-param-row"><span class="param-label">Dihitung pada</span><span class="param-value">{{ $result->created_at->format('d M Y, H:i') }}</span></div>
      </div>
    </div>
  </div>

  <div class="d-flex gap-3 justify-content-center flex-wrap">
    <a href="{{ route('spk.index', ['from' => $result->token]) }}" class="btn-gardenia-outline">Hitung ulang</a>
    <a href="{{ route('services') }}" class="btn-gardenia">Katalog layanan</a>
    <a href="{{ route('contact') }}" class="btn-gardenia-outline">Konsultasi dengan tim arsitek</a>
  </div>
</div>
@endsection
