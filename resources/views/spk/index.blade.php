@extends('layouts.app')
@section('title', 'Rekomendasi Paket Desain | CV. Gardenia Setia Utama')

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header-clean text-center">
  <div class="container">
    <h1>Rekomendasi Paket Desain</h1>
    <p>Masukkan anggaran dan luas bangunan. Sistem membandingkan paket desain kami dengan metode SAW dan mengurutkannya dari yang paling sesuai.</p>
  </div>
</section>

<div class="container py-4">
  <div class="row g-4 justify-content-center align-items-start">

    {{-- FORM INPUT KRITERIA --}}
    <div class="col-lg-5">
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show p-3 mb-4 rounded-3 border-0 bg-danger-subtle text-danger">
          <span class="small">{{ session('error') }}</span>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
      @endif

      <div class="card-clean p-4">
        <h2 class="fw-bold fs-5 mb-3 text-dark">Kebutuhan proyek</h2>

        <form action="{{ route('spk.calculate') }}" method="POST">
          @csrf

          {{-- Budget --}}
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="form-label mb-0 fw-semibold text-dark">
                Anggaran <span class="text-danger">*</span>
              </label>
              <span class="text-muted small">Bobot {{ isset($weights['C1']) ? round($weights['C1']*100,1).'%' : '-' }}</span>
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
            <div class="text-muted small mt-1" style="font-size:0.75rem;">Perkiraan total dana untuk konstruksi dan perancangan.</div>
          </div>

          {{-- Luas Bangunan --}}
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="form-label mb-0 fw-semibold text-dark">
                Luas bangunan <span class="text-danger">*</span>
              </label>
              <span class="text-muted small">Bobot {{ isset($weights['C2']) ? round($weights['C2']*100,1).'%' : '-' }}</span>
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
              <label class="form-label mb-0 fw-semibold text-dark">Batas durasi pengerjaan</label>
              <span class="text-muted small">Opsional</span>
            </div>
            <select name="duration_pref" class="form-select @error('duration_pref') is-invalid @enderror">
              <option value="">Tidak ada batasan waktu spesifik</option>
              @foreach([3,5,7,10] as $m)
                <option value="{{ $m }}" {{ (string)$dp === (string)$m ? 'selected' : '' }}>Maksimal {{ $m }} bulan</option>
              @endforeach
              <option value="18" {{ (string)$dp === '18' ? 'selected' : '' }}>Fleksibel (&gt;12 bulan)</option>
            </select>
            <div class="text-muted small mt-1" style="font-size:0.75rem;">Paket yang melebihi batas ini diurutkan setelah paket yang memenuhi. Durasi paket tetap ikut dinilai sebagai kriteria cost.</div>
          </div>

          {{-- Gaya Desain --}}
          @php $sp = old('style_preference', $prefill['style_preference'] ?? ''); @endphp
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="form-label mb-0 fw-semibold text-dark">Konsep desain</label>
              <span class="text-muted small">Opsional</span>
            </div>
            <select name="style_preference" class="form-select">
              <option value="">Pilih konsep desain...</option>
              @foreach($styles as $key => $label)
                <option value="{{ $key }}" {{ $sp === $key ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
            <div class="text-muted small mt-1" style="font-size:0.75rem;">Tidak memengaruhi nilai. Semua paket bisa dikerjakan dalam berbagai konsep; pilihan Anda dicatat sebagai brief untuk tim arsitek.</div>
          </div>

          <button type="submit" class="btn-gardenia w-100 py-3 text-center fw-semibold">
            Hitung rekomendasi
          </button>
        </form>
      </div>
    </div>

    {{-- SIDEBAR --}}
    <div class="col-lg-7">
      {{-- PAKET YANG DIBANDINGKAN (data nyata dari database) --}}
      <div class="card-clean p-4 mb-3">
        <h3 class="fw-bold fs-6 mb-1 text-dark">Paket yang dibandingkan</h3>
        <p class="text-muted small mb-2">Anggaran dan luas Anda dicocokkan dengan rentang tiap paket.</p>
        <div class="table-responsive">
          <table class="table table-clean table-sm text-nowrap mb-0" style="font-size:0.8rem;">
            <thead><tr><th>Paket</th><th>Anggaran</th><th>Luas</th><th class="text-end">Durasi</th></tr></thead>
            <tbody>
              @foreach($packages as $pkg)
              <tr>
                <td class="fw-semibold">{{ $pkg->name }}</td>
                <td>{{ number_format($pkg->budget_min / 1e6, 0, ',', '.') }}–{{ number_format($pkg->budget_max / 1e6, 0, ',', '.') }} jt</td>
                <td>{{ $pkg->area_min }}–{{ $pkg->area_max }} m²</td>
                <td class="text-end">{{ $pkg->duration_months }} bln</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      {{-- KRITERIA TABLE (dinamis dari database) --}}
      <div class="card-clean p-4 mb-3">
        <h3 class="fw-bold fs-6 mb-2 text-dark">Kriteria dan bobot</h3>
        <div class="table-responsive">
          <table class="table table-clean table-sm text-nowrap mb-0" style="font-size:0.8rem;">
            <thead><tr><th>Kode</th><th>Kriteria</th><th>Jenis</th><th class="text-end">Bobot</th></tr></thead>
            <tbody>
              @foreach($criteria as $c)
              <tr>
                <td class="fw-bold">{{ $c->code }}</td>
                <td>
                  {{ $c->name }}
                  @if($c->unit)<span class="text-muted">({{ $c->unit }})</span>@endif
                </td>
                <td><span class="{{ $c->type === 'cost' ? 'text-danger' : 'text-success' }} fw-medium">{{ $c->type === 'cost' ? 'Cost' : 'Benefit' }}</span></td>
                <td class="text-end fw-bold">{{ round(($weights[$c->code] ?? 0) * 100, 1) }}%</td>
              </tr>
              @endforeach
              <tr class="fw-bold"><td colspan="3">Total bobot</td><td class="text-end">{{ round(array_sum($weights) * 100) }}%</td></tr>
            </tbody>
          </table>
        </div>

      </div>

      <div class="card-clean p-3">
        <h3 class="fw-bold fs-6 mb-2 text-dark">Cara menghitung</h3>
        <ol class="text-muted small mb-0 ps-3">
          <li class="mb-1">Tiap paket dinilai pada lima kriteria (matriks keputusan).</li>
          <li class="mb-1">Nilai dinormalisasi: benefit r = x / max, cost r = min / x.</li>
          <li class="mb-1">Nilai akhir V = jumlah bobot × r.</li>
          <li>Paket diurutkan dari V tertinggi; tiga teratas ditampilkan.</li>
        </ol>
        @auth
        <a href="{{ route('spk.history') }}" class="d-inline-block mt-3 small fw-medium text-decoration-none" style="color:var(--primary)">Lihat riwayat perhitungan</a>
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
