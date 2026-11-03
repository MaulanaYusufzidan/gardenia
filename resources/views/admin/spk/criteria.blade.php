@extends('admin.layouts.app')
@section('title', 'Kriteria SAW')
@section('page-title', 'Kriteria & Bobot SAW')

@section('content')
<div class="card-clean p-4 mx-auto" style="max-width:820px;">
  <p class="text-muted small">Total bobot kriteria <strong>aktif</strong> harus tepat 100%. Tipe kriteria dan rumus nilai (C1–C5) ditetapkan oleh sistem.</p>
  @error('criteria')<div class="alert alert-danger small border-0">{{ $message }}</div>@enderror
  <form method="POST" action="{{ route('admin.spk.criteria.update') }}">
    @csrf @method('PUT')
    <table class="table table-clean align-middle" style="font-size:0.85rem;">
      <thead><tr><th>Kode</th><th>Kriteria</th><th>Tipe</th><th style="width:130px;">Bobot (%)</th><th class="text-center">Aktif</th></tr></thead>
      <tbody>
        @foreach($criteria as $c)
        <tr>
          <td class="fw-bold">{{ $c->code }}</td>
          <td>{{ $c->name }}<div class="text-muted" style="font-size:0.72rem;">{{ $c->description }}</div></td>
          <td><span class="{{ $c->type === 'cost' ? 'text-danger' : 'text-success' }}">{{ ucfirst($c->type) }}</span></td>
          <td><input type="number" step="0.01" min="0" max="100" name="criteria[{{ $c->id }}][weight]" value="{{ old("criteria.{$c->id}.weight", $c->weight) }}" class="form-control form-control-sm"></td>
          <td class="text-center"><input type="checkbox" class="form-check-input" name="criteria[{{ $c->id }}][is_active]" value="1" {{ old("criteria.{$c->id}.weight") !== null ? (old("criteria.{$c->id}.is_active") ? 'checked' : '') : ($c->is_active ? 'checked' : '') }}></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <button class="btn-gardenia">Simpan Bobot</button>
  </form>
</div>
@endsection
