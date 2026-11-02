<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Gardenia') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased bg-[#fbfcfb]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-8 sm:pt-0 px-4">
            <div class="text-center mb-6">
                <a href="/" class="inline-flex items-center gap-2.5 text-decoration-none group">
                    <div class="w-10 h-10 bg-[#183e2b] text-white rounded-lg flex items-center justify-center font-bold text-lg font-serif transition group-hover:scale-105">
                        G
                    </div>
                    <div class="text-left">
                        <span class="block font-serif text-xl font-bold text-[#0f2b1d] leading-none">Gardenia</span>
                        <span class="block text-[10px] text-slate-400 font-semibold tracking-wider uppercase mt-0.5">Setia Utama</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md bg-white border border-slate-200/80 shadow-sm rounded-xl p-6 sm:p-8">
                {{ $slot }}
            </div>
            
            <div class="mt-6 text-center text-xs text-slate-400">
                <a href="/" class="hover:text-[#183e2b] transition">← Kembali ke Beranda</a>
            </div>
        </div>
    </body>
</html>

