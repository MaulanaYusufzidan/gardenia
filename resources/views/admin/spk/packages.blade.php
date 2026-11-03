@extends('admin.layouts.app')
@section('title', 'Paket Desain SPK')
@section('page-title', 'Paket Desain (Alternatif SPK)')

@section('content')
<div class="card-clean overflow-hidden">
  <div class="p-3 border-bottom bg-white d-flex justify-content-between align-items-center">
    <span class="small text-muted">Hanya paket aktif yang ikut dihitung dan dapat dipesan.</span>
    <a href="{{ route('admin.spk.packages.create') }}" class="btn-gardenia-sm py-1.5">+ Tambah Paket</a>
  </div>
  <div class="table-responsive">
    <table class="table table-clean mb-0 align-middle" style="font-size:0.82rem;">
      <thead><tr><th>Paket</th><th>Anggaran (Jt)</th><th>Luas (m²)</th><th>Durasi</th><th>Fitur</th><th>Material</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
      <tbody>
        @forelse($packages as $p)
        <tr>
          <td><div class="fw-semibold text-dark">{{ $p->name }}</div><div class="text-muted" style="font-size:0.72rem;">mulai Rp {{ number_format($p->price_start, 0, ',', '.') }}</div></td>
          <td>{{ number_format($p->budget_min/1e6, 0, ',', '.') }}–{{ number_format($p->budget_max/1e6, 0, ',', '.') }}</td>
          <td>{{ $p->area_min }}–{{ $p->area_max }}</td>
          <td>{{ $p->duration_months }} bln</td>
          <td>{{ $p->feature_score }}</td>
          <td>{{ $p->material_score }}</td>
          <td>@if($p->is_active)<span class="badge-status badge-status-completed">AKTIF</span>@else<span class="badge-status badge-status-unpaid">NONAKTIF</span>@endif</td>
          <td class="text-end">
            <div class="d-flex gap-1 justify-content-end">
              <a href="{{ route('admin.spk.packages.edit', $p) }}" class="btn-gardenia-outline-sm py-0.5 px-2" style="font-size:0.75rem;">Edit</a>
              <form method="POST" action="{{ route('admin.spk.packages.toggle', $p) }}">@csrf @method('PATCH')
                <button class="btn btn-sm btn-light border py-0.5 px-2" style="font-size:0.75rem;">{{ $p->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
              <form method="POST" action="{{ route('admin.spk.packages.destroy', $p) }}" onsubmit="return confirm('Hapus paket ini permanen?')">@csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger py-0.5 px-2" style="font-size:0.75rem;"><i class="bi bi-trash"></i></button></form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center py-5 text-muted small">Belum ada paket desain.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
