<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CV. Gardenia Setia Utama')</title>
    <script>document.documentElement.classList.add('js')</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Antonio:wght@300;400;500;600&family=Hanken+Grotesk:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            /* Palet: beton malam + cahaya lampu interior */
            --ink: #09110b;            /* latar utama */
            --ink-2: #0f1a12;          /* permukaan */
            --ink-3: #16241a;          /* permukaan terangkat */
            --line: rgba(150,220,150,.16);
            --line-soft: rgba(150,220,150,.09);
            --paper: #e8f0e6;          /* teks utama */
            --paper-dim: #9fb09f;      /* teks sekunder */
            --paper-faint: #66786a;

            --lamp: #46b341;           /* aksen: cahaya hangat */
            --lamp-hover: #67cc62;

            /* Alias lama agar halaman lain tetap terbaca */
            --primary-dark: var(--ink);
            --primary: var(--paper);
            --primary-hover: #ffffff;
            --primary-light: var(--paper);
            --primary-soft: var(--ink-3);
            --primary-border: var(--line);
            --accent: var(--lamp);
            --accent-hover: var(--lamp-hover);
            --accent-light: var(--lamp);
            --accent-border: rgba(70,179,65,.4);
            --gold: var(--lamp);
            --bg-page: var(--ink);
            --surface: var(--ink-2);
            --text-main: var(--paper);
            --text-muted: var(--paper-dim);
            --text-light: var(--paper-faint);
            --border-color: var(--line);
            --border-light: var(--line-soft);
            --shadow-xs: none; --shadow-sm: none; --shadow-md: none; --shadow-lg: none;
            --radius-sm: 0; --radius-md: 0; --radius-lg: 0;

            --font-display: 'Antonio', 'Arial Narrow', Impact, sans-serif;
            --font-body: 'Hanken Grotesk', -apple-system, BlinkMacSystemFont, sans-serif;

            --bs-body-bg: var(--ink);
            --bs-body-color: var(--paper);
            --bs-body-font-family: var(--font-body);
            --bs-border-color: var(--line);
            --bs-secondary-color: var(--paper-dim);
            --bs-tertiary-bg: var(--ink-2);
            --bs-link-color: var(--lamp);
            --bs-link-hover-color: var(--lamp-hover);
        }

        * { box-sizing: border-box; }
        body {
            font-family: var(--font-body);
            font-weight: 400;
            text-rendering: optimizeLegibility;
            color: var(--paper);
            background-color: var(--ink);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        h1, h2, h3, h4, .font-serif {
            font-family: var(--font-display);
            font-weight: 400;
            letter-spacing: .01em;
            text-transform: uppercase;
            line-height: 1.04;
        }
        h5, h6 { font-family: var(--font-body); font-weight: 500; }
        a { color: var(--lamp); text-decoration: none; }
        a:hover { color: var(--lamp-hover); }
        :focus-visible { outline: 2px solid var(--lamp); outline-offset: 3px; }

        /* Utilitas Bootstrap yang di-hardcode terang di halaman lain */
        .bg-white, .bg-light { background-color: var(--ink-2) !important; }
        .text-dark, .text-body { color: var(--paper) !important; }
        .text-muted, .text-secondary { color: var(--paper-dim) !important; }
        .border, .border-top, .border-bottom { border-color: var(--line) !important; }
        .card, .modal-content, .list-group-item, .dropdown-menu { background-color: var(--ink-2); border-color: var(--line); border-radius: 0; }
        .rounded, .rounded-2, .rounded-3 { border-radius: 0 !important; }
        .alert { border-radius: 0; }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1030;
            padding: 1.25rem 0;
            background: transparent;
            border-bottom: 1px solid transparent;
            transition: padding .35s ease, background-color .35s ease, border-color .35s ease, backdrop-filter .35s ease;
        }
        .navbar.scrolled {
            padding: .6rem 0;
            background: rgba(9,17,11,.38);
            backdrop-filter: blur(18px) saturate(1.2);
            -webkit-backdrop-filter: blur(18px) saturate(1.2);
            border-bottom-color: var(--line-soft);
        }
        .navbar.menu-open {
            background: rgba(9,17,11,.82);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }
        .navbar.menu-open { padding: .9rem 0; }
        .navbar:not(.scrolled):not(.menu-open)::before {
            content: ''; position: absolute; inset: 0; z-index: -1; pointer-events: none;
            background: linear-gradient(180deg, rgba(9,17,11,.55), transparent);
        }
        body:not(.has-hero) main { padding-top: 76px; }
        .navbar-brand { padding: 0; margin-right: 2rem; }
        .navbar-brand img {
            height: 44px; width: auto; display: block;
            filter: brightness(1.75) saturate(.95);
            transition: height .35s ease;
        }
        .navbar.scrolled .navbar-brand img { height: 38px; }
        .navbar-nav .nav-link {
            font-size: .72rem;
            font-weight: 400;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--paper-dim) !important;
            padding: .5rem .85rem !important;
            transition: color .15s ease;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.fw-bold { color: var(--paper) !important; font-weight: 500 !important; }
        .navbar-nav .nav-link.fw-bold { box-shadow: inset 0 -1px 0 var(--lamp); }
        .cart-badge {
            position: absolute; top: 2px; right: -6px;
            background: var(--lamp); color: var(--ink);
            font-size: 10px; font-weight: 600;
            min-width: 16px; height: 16px; line-height: 16px;
            text-align: center; padding: 0 3px;
        }
        .navbar .dropdown-menu { padding: .4rem; margin-top: .75rem; min-width: 220px; }
        .navbar .dropdown-item { padding: .55rem .9rem; font-size: .85rem; color: var(--paper); }
        .navbar .dropdown-item:hover { background: var(--ink-3); }
        .navbar .dropdown-menu { background: rgba(12,22,15,.92); backdrop-filter: blur(14px); }
        .navbar .btn-outline-success,
        .navbar .btn-success {
            border-radius: 0; font-size: .7rem; letter-spacing: .14em; text-transform: uppercase;
            padding: .55rem 1.1rem; font-weight: 400;
            background: transparent !important; color: var(--paper) !important;
            border: 1px solid rgba(255,255,255,.4) !important;
        }
        .navbar .btn-success { background: var(--lamp) !important; color: #06100a !important; border-color: var(--lamp) !important; font-weight: 500; }
        .navbar .btn-outline-success:hover { border-color: var(--lamp) !important; color: var(--lamp) !important; }
        .navbar .btn-success:hover { background: var(--lamp-hover) !important; border-color: var(--lamp-hover) !important; }
        .navbar-toggler { border: 1px solid var(--line); border-radius: 0; padding: .4rem .6rem; }
        .navbar-toggler:focus { box-shadow: none; outline: 2px solid var(--lamp); }
        @media (max-width: 991.98px) {
            .navbar-collapse { margin-top: .9rem; padding-top: .9rem; border-top: 1px solid var(--line); }
            .navbar-nav .nav-link.fw-bold { box-shadow: none; color: var(--lamp) !important; }
            .navbar .btn-outline-success, .navbar .btn-success { width: 100%; padding: .7rem 1rem; }
        }

        /* ===== TOMBOL ===== */
        .btn-gardenia, .btn-gardenia-outline, .btn-gardenia-gold {
            display: inline-flex; align-items: center; justify-content: center; gap: .6rem;
            font-family: var(--font-body);
            font-size: .72rem; font-weight: 400;
            letter-spacing: .16em; text-transform: uppercase;
            padding: .8rem 1.5rem;
            border-radius: 0; text-decoration: none;
            transition: background .2s ease, color .2s ease, border-color .2s ease;
        }
        .btn-gardenia { background: transparent; color: var(--paper) !important; border: 1px solid rgba(255,255,255,.55); }
        .btn-gardenia:hover { background: var(--paper); color: var(--ink) !important; border-color: var(--paper); }
        .btn-gardenia-outline { background: transparent; color: var(--paper-dim) !important; border: 1px solid var(--line); }
        .btn-gardenia-outline:hover { color: var(--paper) !important; border-color: var(--paper); background: transparent; }
        .btn-gardenia-gold { background: var(--lamp); color: var(--ink) !important; border: 1px solid var(--lamp); font-weight: 500; }
        .btn-gardenia-gold:hover { background: var(--lamp-hover); border-color: var(--lamp-hover); }
        .btn-gardenia-sm { font-size: .66rem; padding: .5rem 1rem; }
        .btn-gardenia-lg { padding: 1rem 2rem; }

        /* ===== PERMUKAAN ===== */
        .card-clean { background: var(--ink-2); border: 1px solid var(--line); transition: border-color .2s ease; }
        .card-clean-hover:hover { border-color: rgba(255,255,255,.35); }

        .badge-kbli {
            background: transparent; color: var(--paper-dim);
            font-size: .68rem; font-weight: 400; letter-spacing: .1em;
            padding: .2rem .5rem; border: 1px solid var(--line);
        }
        .badge-status { font-size: .68rem; font-weight: 500; letter-spacing: .06em; padding: .28rem .65rem; display: inline-flex; align-items: center; border: 1px solid transparent; }
        .badge-status-pending     { background: rgba(230,190,90,.12); color: #e8c98c; border-color: rgba(230,190,90,.35); }
        .badge-status-confirmed   { background: rgba(110,190,140,.12); color: #8fd3a8; border-color: rgba(110,190,140,.35); }
        .badge-status-in_progress { background: rgba(130,150,235,.12); color: #a9b8f2; border-color: rgba(130,150,235,.35); }
        .badge-status-completed   { background: rgba(80,200,160,.12);  color: #7fdcc0; border-color: rgba(80,200,160,.35); }
        .badge-status-cancelled   { background: rgba(230,110,110,.12); color: #f0a0a0; border-color: rgba(230,110,110,.35); }
        .badge-status-paid        { background: rgba(110,190,140,.12); color: #8fd3a8; border-color: rgba(110,190,140,.35); }
        .badge-status-unpaid      { background: rgba(255,255,255,.05); color: var(--paper-dim); border-color: var(--line); }

        .page-header-clean {
            background: var(--ink-2);
            border-bottom: 1px solid var(--line);
            color: var(--paper);
            padding: 5.5rem 0 3rem;
        }
        .page-header-clean h1 { font-size: clamp(2.4rem, 6vw, 4.5rem); font-weight: 300; margin-bottom: .6rem; }
        .page-header-clean p { color: var(--paper-dim); font-size: 1rem; max-width: 600px; margin: 0 auto; }

        .cart-indicator {
            position: absolute; top: -4px; right: -4px;
            background: var(--lamp); color: var(--ink); font-size: 10px; font-weight: 600;
            width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;
        }

        /* ===== FOTO LAYANAN ===== */
        .svc-photo { position: relative; flex: none; width: 100%; aspect-ratio: 4 / 3; overflow: hidden; background: var(--ink-3); }
        .svc-photo img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; filter: saturate(.85); transition: transform .5s ease; }
        .card-clean:hover .svc-photo img { transform: scale(1.03); }

        /* ===== TABEL ===== */
        .table-clean { margin-bottom: 0; border-collapse: separate; border-spacing: 0; --bs-table-bg: transparent; --bs-table-color: var(--paper); }
        .table-clean thead th {
            background: var(--ink-2); color: var(--paper-dim);
            font-size: .68rem; font-weight: 400; text-transform: uppercase; letter-spacing: .14em;
            padding: .9rem 1.15rem; border-bottom: 1px solid var(--line); border-top: none;
        }
        .table-clean tbody td { padding: 1rem 1.15rem; font-size: .88rem; border-bottom: 1px solid var(--line-soft); vertical-align: middle; color: var(--paper); background: transparent; }
        .table-clean tbody tr:last-child td { border-bottom: none; }
        .table-clean tbody tr:hover td { background: var(--ink-2); }

        /* ===== FORM ===== */
        .input-group-text { background: var(--ink-3); color: var(--paper-dim); border-color: var(--line); border-radius: 0; }
        .form-control, .form-select {
            background-color: var(--ink-2); color: var(--paper);
            border: 1px solid var(--line); border-radius: 0;
            padding: .7rem .9rem; font-size: .9rem; font-weight: 300;
        }
        .form-control::placeholder { color: var(--paper-faint); }
        .form-control:focus, .form-select:focus {
            background-color: var(--ink-2); color: var(--paper);
            border-color: var(--lamp); box-shadow: none; outline: none;
        }
        .form-label { font-size: .72rem; font-weight: 400; letter-spacing: .12em; text-transform: uppercase; color: var(--paper-dim); margin-bottom: .4rem; }
        .form-check-input:checked { background-color: var(--lamp); border-color: var(--lamp); }

        /* ===== FOOTER ===== */
        footer { background: linear-gradient(180deg, var(--ink) 0%, #0c2314 100%); color: var(--paper); border-top: 1px solid var(--line); }
        footer a { color: var(--paper-dim); transition: color .15s ease; }
        footer a:hover { color: var(--paper); }
        .footer-heading { font-size: .68rem; font-weight: 400; letter-spacing: .18em; text-transform: uppercase; color: var(--paper-faint); margin-bottom: 1rem; }
        .footer-logo-img { height: 48px; width: auto; filter: brightness(1.75) saturate(.95); }

        /* ===== ANIMASI (hanya jika perangkat mengizinkan; default: semua terlihat) ===== */
        @keyframes rise { from { opacity: 0; transform: translateY(36px); } to { opacity: 1; transform: none; } }
        @keyframes draw { from { transform: scaleX(0); } to { transform: scaleX(1); } }
        @keyframes fade { from { opacity: 0; } to { opacity: 1; } }
        @media (prefers-reduced-motion: no-preference) {
            .js .reveal { opacity: 0; transform: translateY(28px); transition: opacity .9s cubic-bezier(.2,.7,.2,1), transform .9s cubic-bezier(.2,.7,.2,1); transition-delay: var(--d, 0s); }
            .js .reveal.in { opacity: 1; transform: none; }
        }
        </style>
    @yield('styles')
</head>
<body class="@yield('body_class')">

{{-- ===== MAIN NAVBAR ===== --}}
<nav class="navbar navbar-expand-lg" id="mainNavbar">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
      <img src="{{ asset('images/logo/gardenia-logo.png') }}" alt="Gardenia's — CV. Gardenia Setia Utama">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Buka Menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'fw-bold' : '' }}" href="{{ route('home') }}">Beranda</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'fw-bold' : '' }}" href="{{ route('about') }}">Tentang</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('services*') ? 'fw-bold' : '' }}" href="{{ route('services') }}">Layanan</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('portfolio') ? 'fw-bold' : '' }}" href="{{ route('portfolio') }}">Portofolio</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('spk*') ? 'fw-bold' : '' }}" href="{{ route('spk.index') }}">Rekomendasi Paket</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'fw-bold' : '' }}" href="{{ route('contact') }}">Kontak</a></li>
      </ul>

      <ul class="navbar-nav align-items-lg-center gap-lg-2 gap-1">
        @auth
          <li class="nav-item position-relative">
            <a class="nav-link" href="{{ route('cart.index') }}">
              <i class="bi bi-bag me-1"></i>Keranjang
              @php $cartCount = count(session()->get('cart',[])); @endphp
              @if($cartCount > 0)
                <span class="cart-badge">{{ $cartCount }}</span>
              @endif
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard Akun</a></li>
              <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-receipt me-2"></i>Pesanan Saya</a></li>
              <li><a class="dropdown-item" href="{{ route('spk.history') }}"><i class="bi bi-clock-history me-2"></i>Riwayat Rekomendasi</a></li>
              @if(auth()->user()->role === 'admin')
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item fw-semibold" style="color:var(--lamp);" href="{{ route('admin.dashboard') }}"><i class="bi bi-shield-check me-2"></i>Panel Admin</a></li>
              @endif
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item text-danger" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item"><a class="btn btn-sm btn-outline-success" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="btn btn-sm btn-success" href="{{ route('register') }}">Daftar</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

{{-- MAIN CONTENT --}}
<main>
  @yield('content')
</main>

{{-- FOOTER --}}
<footer class="pt-5 pb-4">
  <div class="container">
    <div class="row g-4 g-lg-5">
      <div class="col-lg-4 col-md-6">
        <div class="mb-3">
          <img src="{{ asset('images/logo/gardenia-logo.png') }}" alt="Gardenia's" class="footer-logo-img">
        </div>
        <p style="color:var(--paper-dim);font-size:.88rem;line-height:1.7;max-width:340px;">
          Penyedia jasa arsitektur, rancangan desain interior, dan konstruksi terpercaya sejak 2009 di Kabupaten Bogor dengan standar mutu profesional.
        </p>
      </div>

      <div class="col-lg-2 col-6">
        <div class="footer-heading">Navigasi</div>
        <ul class="list-unstyled mb-0" style="font-size:.88rem;line-height:2;">
          <li><a href="{{ route('home') }}">Beranda</a></li>
          <li><a href="{{ route('about') }}">Tentang Kami</a></li>
          <li><a href="{{ route('services') }}">Layanan</a></li>
          <li><a href="{{ route('portfolio') }}">Portofolio</a></li>
          <li><a href="{{ route('contact') }}">Kontak</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-6">
        <div class="footer-heading">Layanan Unggulan</div>
        <ul class="list-unstyled mb-0" style="font-size:.88rem;line-height:2;">
          <li><a href="{{ route('services') }}">Aktivitas Arsitektur</a></li>
          <li><a href="{{ route('services') }}">Perancangan Khusus</a></li>
          <li><a href="{{ route('services') }}">Dekorasi Eksterior</a></li>
          <li><a href="{{ route('services') }}">Perawatan Taman</a></li>
          <li><a href="{{ route('spk.index') }}" style="color:var(--lamp);">Rekomendasi Paket SAW</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="footer-heading">Kantor & Kontak</div>
        <ul class="list-unstyled mb-0" style="font-size:.88rem;line-height:1.9;color:var(--paper-dim);">
          <li>Kabupaten Bogor, Jawa Barat</li>
          <li>Telepon: (0251) 762-9881</li>
          <li>WhatsApp: 0851-1920-8772</li>
          <li>Email: gardeniasetiautama@gmail.com</li>
          <li>Senin – Jumat, 08.00 – 17.00 WIB</li>
        </ul>
      </div>
    </div>

    <hr class="my-4" style="border-color:var(--line);opacity:1;">

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2" style="font-size:.76rem;color:var(--paper-faint);">
      <span>© {{ date('Y') }} CV. Gardenia Setia Utama. Seluruh hak cipta dilindungi.</span>
      <span>Notaris: Hatopan Kristien Simorangkir, SH, M.Kn</span>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  (function () {
    var nav = document.getElementById('mainNavbar');
    var menu = document.getElementById('nav');
    function onScroll() { nav.classList.toggle('scrolled', window.scrollY > 24); }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
    menu.addEventListener('show.bs.collapse', function () { nav.classList.add('menu-open'); });
    menu.addEventListener('hidden.bs.collapse', function () { nav.classList.remove('menu-open'); });
  })();
</script>
@yield('scripts')
</body>
</html>
