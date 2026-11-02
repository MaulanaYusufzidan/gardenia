<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-4 text-center">
        <h2 class="text-xl font-bold text-slate-800">Masuk ke Akun Anda</h2>
        <p class="text-xs text-slate-500 mt-1">Akses dashboard pesanan dan kalkulasi rancangan proyek</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Kata Sandi" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-[#183e2b] shadow-sm focus:ring-[#183e2b]" name="remember">
                <span class="ml-2 text-xs text-slate-600">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs text-slate-500 hover:text-slate-800 rounded-md focus:outline-none" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-2.5">
                Masuk Sekarang
            </x-primary-button>
        </div>

        <div class="mt-4 text-center">
            <span class="text-xs text-slate-500">Belum memiliki akun?</span>
            <a href="{{ route('register') }}" class="text-xs font-semibold text-[#183e2b] hover:underline ml-1">
                Daftar Akun Baru
            </a>
        </div>
    </form>
</x-guest-layout>

