@props([
    'id' => 'password',
    'name' => 'password',
    'label' => 'Kata Sandi',
    'placeholder' => '••••••••',
    'autocomplete' => 'current-password',
])
<div {{ $attributes->only('class') }}>
  <label for="{{ $id }}" class="form-label">{{ $label }}</label>
  <div class="input-group">
    <input id="{{ $id }}" type="password" name="{{ $name }}" required
           class="form-control @error($name) is-invalid @enderror"
           placeholder="{{ $placeholder }}" autocomplete="{{ $autocomplete }}">
    <button type="button" class="toggle-pass" data-target="{{ $id }}" tabindex="-1" aria-label="Tampilkan / sembunyikan kata sandi"><i class="bi bi-eye"></i></button>
  </div>
  @error($name)<div class="field-error">{{ $message }}</div>@enderror
</div>
