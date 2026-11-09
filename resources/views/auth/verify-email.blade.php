<x-guest-layout>
    @section('title', 'Verifikasi Email')

    <h1 class="auth-title">Verifikasi email Anda</h1>
    <p class="auth-sub">Terima kasih telah mendaftar. Silakan klik tautan verifikasi yang kami kirim ke email Anda. Belum menerima email? Kami dapat mengirim ulang.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="auth-alert ok"><i class="bi bi-check-circle-fill"></i><span>Tautan verifikasi baru telah dikirim ke alamat email Anda.</span></div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
        @csrf
        <button type="submit" class="btn-gardenia">Kirim Ulang Email Verifikasi</button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="text-center">
        @csrf
        <button type="submit" class="btn btn-link text-link-muted p-0">Keluar</button>
    </form>
</x-guest-layout>
