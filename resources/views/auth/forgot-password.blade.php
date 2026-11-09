<x-guest-layout>
    @section('title', 'Lupa Kata Sandi')

    <h1 class="auth-title">Lupa kata sandi?</h1>
    <p class="auth-sub">Masukkan email akun Anda. Kami akan mengirim tautan untuk membuat kata sandi baru.</p>

    @if (session('status'))
        <div class="auth-alert ok"><i class="bi bi-check-circle-fill"></i><span>{{ session('status') }}</span></div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="nama@email.com" class="form-control @error('email') is-invalid @enderror">
            @error('email')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn-gardenia">Kirim Tautan Reset</button>

        <p class="text-center small text-secondary mt-4 mb-0">
            Ingat kata sandi Anda? <a href="{{ route('login') }}" class="auth-link">Kembali masuk</a>
        </p>
    </form>
</x-guest-layout>
