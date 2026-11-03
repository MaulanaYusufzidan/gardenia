@extends('admin.layouts.app')
@section('title', $package->exists ? 'Edit Paket' : 'Tambah Paket')
@section('page-title', $package->exists ? 'Edit Paket Desain' : 'Tambah Paket Desain')

@section('content')
@php
  $field = function ($name, $label, $type = 'number', $extra = '') use ($package, $errors) {
    $err = $errors->first($name);
    return '<div class="col-md-6"><label class="form-label fw-semibold text-dark">'.$label.'</label>'
      .'<input type="'.$type.'" name="'.$name.'" '.$extra.' class="form-control '.($err ? 'is-invalid' : '').'" value="'.e(old($name, $package->$name)).'" required>'
      .($err ? '<div class="invalid-feedback">'.e($err).'</div>' : '').'</div>';
  };
@endphp
<div class="mb-3"><a href="{{ route('admin.spk.packages') }}" class="btn-gardenia-outline-sm">← Kembali</a></div>
<div class="card-clean p-4 p-md-5 mx-auto" style="max-width:760px;">
  <form method="POST" action="{{ $package->exists ? route('admin.spk.packages.update', $package) : route('admin.spk.packages.store') }}">
    @csrf @if($package->exists) @method('PUT') @endif
    <div class="row g-3">
      {!! $field('name', 'Nama Paket', 'text') !!}
      {!! $field('category', 'Kategori', 'text') !!}
      {!! $field('budget_min', 'Anggaran Minimum (Rp)', 'number', 'min="0" step="1000000"') !!}
      {!! $field('budget_max', 'Anggaran Maksimum (Rp)', 'number', 'min="0" step="1000000"') !!}
      {!! $field('area_min', 'Luas Minimum (m²)', 'number', 'min="0"') !!}
      {!! $field('area_max', 'Luas Maksimum (m²)', 'number', 'min="0"') !!}
      {!! $field('duration_months', 'Durasi Pengerjaan (bulan) — kriteria cost', 'number', 'min="1" max="60"') !!}
      {!! $field('price_start', 'Harga Mulai Dari (Rp)', 'number', 'min="0"') !!}
      {!! $field('feature_score', 'Skor Fitur Desain (1–10)', 'number', 'min="1" max="10" step="0.1"') !!}
      {!! $field('material_score', 'Skor Kualitas Material (1–10)', 'number', 'min="1" max="10" step="0.1"') !!}
      <div class="col-12"><label class="form-label fw-semibold text-dark">Deskripsi</label>
        <textarea name="description" rows="3" class="form-control">{{ old('description', $package->description) }}</textarea></div>
      <div class="col-12"><label class="form-label fw-semibold text-dark">Yang Termasuk</label>
        <textarea name="includes" rows="2" class="form-control">{{ old('includes', $package->includes) }}</textarea></div>
      <div class="col-12"><div class="form-check">
        <input type="checkbox" class="form-check-input" id="act" name="is_active" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
        <label class="form-check-label" for="act">Aktif (ikut perhitungan SPK & dapat dipesan)</label></div></div>
    </div>
    <button class="btn-gardenia mt-4">Simpan Paket</button>
  </form>
</div>
@endsection
