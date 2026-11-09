@extends('admin.layouts.app')
@section('title', 'Kriteria SAW')
@section('page-title', 'Kriteria & Bobot SAW')

@section('content')
<div class="card-clean p-4 mx-auto" style="max-width:1000px;">
  <p class="text-muted small mb-1">Total bobot kriteria <strong>aktif</strong> harus tepat 100%. Jenis kriteria, satuan, dan rumus nilai (C1–C5) ditetapkan oleh sistem; yang dapat diubah hanya bobot dan status aktif.</p>
  <p class="text-muted small">Skor C4 dan C5 pada <a href="{{ route('admin.spk.packages') }}">Paket Desain</a> harus mengikuti rubrik pada kolom <em>Definisi Operasional</em> agar penilaian konsisten antar paket.</p>
  @error('criteria')<div class="alert alert-danger small border-0">{{ $message }}</div>@enderror
  <form method="POST" action="{{ route('admin.spk.criteria.update') }}">
    @csrf @method('PUT')
    <div class="table-responsive">
    <table class="table table-clean align-top" style="font-size:0.85rem;">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Kriteria &amp; Definisi Operasional</th>
          <th>Jenis</th>
          <th style="width:120px;">Bobot (%)</th>
          <th class="text-center">Aktif</th>
        </tr>
      </thead>
      <tbody>
        @foreach($criteria as $c)
        <tr>
          <td class="fw-bold">{{ $c->code }}</td>
          <td>
            <div class="fw-semibold">{{ $c->name }}</div>
            <div class="text-muted mb-2" style="font-size:0.78rem;">{{ $c->description }}</div>
            <dl class="mb-0" style="font-size:0.75rem;">
              @if($c->unit)<div class="d-flex gap-2"><dt class="text-muted fw-medium" style="min-width:92px;">Satuan</dt><dd class="mb-1">{{ $c->unit }}</dd></div>@endif
              @if($c->data_source)<div class="d-flex gap-2"><dt class="text-muted fw-medium" style="min-width:92px;">Sumber data</dt><dd class="mb-1">{{ $c->data_source }}</dd></div>@endif
              @if($c->measurement)<div class="d-flex gap-2"><dt class="text-muted fw-medium" style="min-width:92px;">Pengukuran</dt><dd class="mb-1">{{ $c->measurement }}</dd></div>@endif
              @if($c->rationale)<div class="d-flex gap-2"><dt class="text-muted fw-medium" style="min-width:92px;">Dasar bobot</dt><dd class="mb-0">{{ $c->rationale }}</dd></div>@endif
            </dl>
          </td>
          <td><span class="fw-medium {{ $c->type === 'cost' ? 'text-danger' : 'text-success' }}">{{ $c->type === 'cost' ? 'Cost' : 'Benefit' }}</span>
              <div class="text-muted" style="font-size:0.7rem;">{{ $c->type === 'cost' ? 'makin kecil makin baik' : 'makin besar makin baik' }}</div></td>
          <td><input type="number" step="0.01" min="0" max="100" name="criteria[{{ $c->id }}][weight]" value="{{ old("criteria.{$c->id}.weight", $c->weight) }}" class="form-control form-control-sm weight-input"></td>
          <td class="text-center"><input type="checkbox" class="form-check-input active-input" name="criteria[{{ $c->id }}][is_active]" value="1" {{ old("criteria.{$c->id}.weight") !== null ? (old("criteria.{$c->id}.is_active") ? 'checked' : '') : ($c->is_active ? 'checked' : '') }}></td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr class="fw-bold bg-light">
          <td colspan="3" class="text-end">Total bobot kriteria aktif</td>
          <td colspan="2"><span id="weight-total">-</span></td>
        </tr>
      </tfoot>
    </table>
    </div>
    <button class="btn-gardenia">Simpan Bobot</button>
  </form>
</div>

<script>
  (function () {
    var rows = document.querySelectorAll('tbody tr');
    var out = document.getElementById('weight-total');
    function update() {
      var total = 0;
      rows.forEach(function (r) {
        var w = r.querySelector('.weight-input'), a = r.querySelector('.active-input');
        if (w && a && a.checked) total += parseFloat(w.value) || 0;
      });
      total = Math.round(total * 100) / 100;
      out.textContent = total + '%' + (total === 100 ? ' ✓' : ' (harus 100%)');
      out.className = total === 100 ? 'text-success' : 'text-danger';
    }
    document.querySelectorAll('.weight-input, .active-input').forEach(function (el) {
      el.addEventListener('input', update); el.addEventListener('change', update);
    });
    update();
  })();
</script>
@endsection
