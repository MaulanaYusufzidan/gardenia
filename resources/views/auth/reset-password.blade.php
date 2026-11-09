<x-guest-layout>
    @section('title', 'Reset Kata Sandi')

    <h1 class="auth-title">Buat kata sandi baru</h1>
    <p class="auth-sub">Pilih kata sandi yang kuat dan belum pernah Anda gunakan sebelumnya.</p>

    <form method="POST" action="{{ route('password.store') }}" novalidate>
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                   autocomplete="username" class="form-control @error('email') is-invalid @enderror">
            @error('email')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <x-auth-password class="mb-3" id="password" name="password" label="Kata Sandi Baru"
                         placeholder="Minimal 8 karakter" autocomplete="new-password" />
        <x-auth-password class="mb-4" id="password_confirmation" name="password_confirmation"
                         label="Konfirmasi Kata Sandi" placeholder="Ulangi kata sandi" autocomplete="new-password" />

        <button type="submit" class="btn-gardenia">Simpan Kata Sandi Baru</button>
    </form>
</x-guest-layout>
