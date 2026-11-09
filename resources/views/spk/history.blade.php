@extends('layouts.app')
@section('title', 'Riwayat Perhitungan SAW | CV. Gardenia Setia Utama')

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header-clean text-center">
  <div class="container">
    <h1>Riwayat Kalkulasi SAW</h1>
    <p>Perhitungan rekomendasi paket desain yang pernah Anda jalankan.</p>
  </div>
</section>

<div class="container py-5">
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
    <div>
      <h2 class="fw-bold fs-5 mb-0 text-dark">Daftar Riwayat Perhitungan</h2>
      <span class="text-muted small">Hasil perhitungan yang pernah Anda simpan.</span>
    </div>
    <a href="{{ route('spk.index') }}" class="btn-gardenia btn-gardenia-sm">
      Hitung baru
    </a>
  </div>

  @if($histories->isEmpty())
    <div class="card-clean p-5 text-center my-4">
      <h3 class="fw-bold fs-5 mb-1 text-dark">Belum Ada Riwayat Kalkulasi</h3>
      <p class="text-muted small mb-4">Anda belum pernah melakukan perhitungan rekomendasi paket desain dengan metode SAW.</p>
      <div>
        <a href="{{ route('spk.index') }}" class="btn-gardenia">Mulai Hitung Rekomendasi</a>
      </div>
    </div>
  @else
    <div class="card-clean overflow-hidden mb-4">
      <div class="table-responsive">
        <table class="table table-clean mb-0 align-middle">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">No</th>
              <th>Waktu Kalkulasi</th>
              <th>Anggaran Input</th>
              <th>Luas Bangunan</th>
              <th>Konsep Desain</th>
              <th>Rekomendasi Terbaik</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($histories as $h)
            <tr>
              <td class="text-center text-muted small">{{ $histories->firstItem() + $loop->index }}</td>
              <td>
                <div class="fw-medium small text-dark">{{ $h->created_at->format('d M Y') }}</div>
                <div class="text-muted" style="font-size:0.75rem;">{{ $h->created_at->format('H:i') }} WIB</div>
              </td>
              <td>
                <span class="fw-semibold small text-dark">Rp {{ number_format($h->budget_input, 0, ',', '.') }}</span>
              </td>
              <td>
                <span class="small text-dark">{{ $h->area_input }} m²</span>
              </td>
              <td>
                @if($h->style_preference)
                  <span class="small text-dark">{{ $styles[$h->style_preference] ?? ucfirst($h->style_preference) }}</span>
                @else
                  <span class="text-muted small">-</span>
                @endif
              </td>
              <td>
                @if($h->recommendedPackage)
                  <span class="small fw-semibold text-dark">{{ $h->recommendedPackage->name }}</span>
                @else
                  <span class="text-muted small">-</span>
                @endif
              </td>
              <td class="text-end">
                @if($h->calculation)
                <a href="{{ route('spk.show', $h) }}" class="btn-gardenia btn-gardenia-sm py-1 px-2.5" style="font-size:0.78rem;">Lihat Hasil</a>
                @endif
                <a href="{{ route('spk.index', ['from' => $h->token]) }}" class="btn-gardenia-outline btn-gardenia-sm py-1 px-2.5" style="font-size:0.78rem;">Hitung Ulang</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div class="d-flex justify-content-center">
      {{ $histories->links() }}
    </div>
  @endif
</div>

@endsection

