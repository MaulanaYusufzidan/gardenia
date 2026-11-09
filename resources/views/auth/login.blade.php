<x-guest-layout>
    @section('title', 'Masuk')

    <h1 class="auth-title">Selamat datang kembali</h1>
    <p class="auth-sub">Masuk untuk mengakses dashboard pesanan dan rekomendasi paket desain Anda.</p>

    @if (session('status'))
        <div class="auth-alert ok"><i class="bi bi-check-circle-fill"></i><span>{{ session('status') }}</span></div>
    @endif
    @if (session('error'))
        <div class="auth-alert err"><i class="bi bi-exclamation-circle-fill"></i><span>{{ session('error') }}</span></div>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   autocomplete="username" placeholder="nama@email.com"
                   class="form-control @error('email') is-invalid @enderror">
            @error('email')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <x-auth-password class="mb-3" id="password" name="password" label="Kata Sandi" autocomplete="current-password" />

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check mb-0">
                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label small text-secondary" for="remember_me">Ingat saya</label>
            </div>
            @if (Route::has('password.request'))
                <a class="text-link-muted" href="{{ route('password.request') }}">Lupa kata sandi?</a>
            @endif
        </div>

        <button type="submit" class="btn-gardenia">Masuk</button>

        <p class="text-center small text-secondary mt-4 mb-0">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
        </p>
    </form>
</x-guest-layout>
