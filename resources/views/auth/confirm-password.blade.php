<x-guest-layout>
    @section('title', 'Konfirmasi Kata Sandi')

    <h1 class="auth-title">Konfirmasi kata sandi</h1>
    <p class="auth-sub">Ini adalah area aman. Mohon konfirmasi kata sandi Anda sebelum melanjutkan.</p>

    <form method="POST" action="{{ route('password.confirm') }}" novalidate>
        @csrf

        <x-auth-password class="mb-4" id="password" name="password" label="Kata Sandi" autocomplete="current-password" />

        <button type="submit" class="btn-gardenia">Konfirmasi</button>
    </form>
</x-guest-layout>
