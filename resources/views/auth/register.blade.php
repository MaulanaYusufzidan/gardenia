<x-guest-layout>
    @section('title', 'Daftar Akun')

    <h1 class="auth-title">Buat akun baru</h1>
    <p class="auth-sub">Mulai konsultasi dan kelola pesanan proyek arsitektur & konstruksi Anda.</p>

    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   autocomplete="name" placeholder="Nama Anda"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   autocomplete="username" placeholder="nama@email.com"
                   class="form-control @error('email') is-invalid @enderror">
            @error('email')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <x-auth-password class="mb-3" id="password" name="password" label="Kata Sandi"
                         placeholder="Minimal 8 karakter" autocomplete="new-password" />
        <x-auth-password class="mb-4" id="password_confirmation" name="password_confirmation"
                         label="Konfirmasi Kata Sandi" placeholder="Ulangi kata sandi" autocomplete="new-password" />

        <button type="submit" class="btn-gardenia">Daftar Akun</button>

        <p class="text-center small text-secondary mt-4 mb-0">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
