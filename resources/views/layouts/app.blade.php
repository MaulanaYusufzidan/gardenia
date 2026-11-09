<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CV. Gardenia Setia Utama')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #0f2b1d;
            --primary: #183e2b;
            --primary-hover: #133323;
            --primary-light: #245c40;
            --primary-soft: #f0f7f3;
            --primary-border: #d4e7dc;

            --accent: #c4973b;
            --accent-hover: #b0842f;
            --accent-light: #fbf5e8;
            --accent-border: #f0debb;
            --gold: #c4973b;

            --bg-page: #fbfcfb;
            --surface: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            --border-light: #f1f5f9;

            --shadow-xs: 0 1px 2px rgba(0,0,0,0.04);
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.03);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.06), 0 4px 10px rgba(0,0,0,0.04);
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-main);
            background-color: var(--bg-page);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        h1, h2, h3, .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
            letter-spacing: -0.01em;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            padding: 0.6rem 0;
            transition: box-shadow 0.25s ease, padding 0.25s ease;
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .navbar.scrolled {
            box-shadow: 0 6px 20px rgba(15, 43, 29, 0.08) !important;
            padding: 0.4rem 0;
        }
        .navbar-brand {
            padding: 0;
            margin-right: 1.5rem;
        }
        .navbar-brand img {
            height: 40px;
            width: auto;
            display: block;
            transition: height 0.25s ease;
        }
        .navbar.scrolled .navbar-brand img {
            height: 32px;
        }
        .navbar-nav .nav-link {
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--text-muted) !important;
            padding: 0.55rem 0.9rem !important;
            position: relative;
            transition: color 0.15s ease;
        }
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            left: 0.9rem;
            right: 0.9rem;
            bottom: 0.35rem;
            height: 2px;
            background: var(--gold);
            border-radius: 2px;
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.2s ease;
        }
        .navbar-nav .nav-link:hover {
            color: var(--primary) !important;
        }
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.fw-bold::after {
            transform: scaleX(1);
        }
        .navbar-nav .nav-link.fw-bold {
            color: var(--primary-dark) !important;
            font-weight: 600 !important;
        }
        .cart-badge {
            position: absolute;
            top: 2px;
            right: -4px;
            background: var(--gold);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            min-width: 16px;
            height: 16px;
            line-height: 16px;
            text-align: center;
            border-radius: 50%;
            padding: 0 3px;
        }
        .navbar .dropdown-menu {
            border: none;
            box-shadow: 0 8px 24px rgba(15, 43, 29, 0.12);
            border-radius: var(--radius-md);
            padding: 0.5rem;
            margin-top: 0.5rem;
            min-width: 200px;
        }
        .navbar .dropdown-item {
            border-radius: var(--radius-sm);
            padding: 0.55rem 0.9rem;
            font-size: 0.87rem;
            transition: background 0.15s ease;
        }
        .navbar .dropdown-item:hover {
            background: var(--primary-soft);
        }
        .navbar .btn-outline-success {
            border-radius: var(--radius-sm);
            font-weight: 500;
            font-size: 0.85rem;
            padding: 0.45rem 1.1rem;
            color: var(--primary) !important;
            border-color: var(--primary-border) !important;
        }
        .navbar .btn-outline-success:hover {
            background: var(--primary-soft) !important;
            border-color: var(--primary) !important;
            color: var(--primary-dark) !important;
        }
        .navbar .btn-success {
            border-radius: var(--radius-sm);
            font-weight: 500;
            font-size: 0.85rem;
            padding: 0.45rem 1.1rem;
            background: var(--primary) !important;
            border-color: var(--primary) !important;
        }
        .navbar .btn-success:hover {
            background: var(--primary-hover) !important;
            border-color: var(--primary-hover) !important;
        }
        .navbar-toggler {
            border: 1px solid var(--border-color);
            padding: 0.4rem 0.6rem;
            border-radius: var(--radius-sm);
        }
        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(24, 62, 43, 0.1);
        }
        @media (max-width: 991.98px) {
            .navbar-collapse {
                margin-top: 0.75rem;
                padding-top: 0.9rem;
                border-top: 1px solid var(--border-color);
            }
            .navbar-nav .nav-link::after { display: none; }
            .navbar-nav .nav-link {
                padding: 0.65rem 0.9rem !important;
                border-radius: var(--radius-sm);
            }
            .navbar-nav .nav-link:hover,
            .navbar-nav .nav-link.fw-bold {
                background: var(--primary-soft);
            }
            .navbar-nav.align-items-lg-center {
                margin-top: 0.75rem;
                padding-top: 0.75rem;
                border-top: 1px solid var(--border-color);
                gap: 0.5rem !important;
            }
            .navbar .btn-outline-success,
            .navbar .btn-success {
                width: 100%;
                padding: 0.6rem 1rem;
            }
        }

        /* BUTTON SYSTEM */
        .btn-gardenia {
            background-color: var(--primary);
            color: #ffffff !important;
            border: 1px solid var(--primary);
            font-size: 0.88rem;
            font-weight: 500;
            padding: 0.55rem 1.25rem;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            text-decoration: none;
        }
        .btn-gardenia:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }
        .btn-gardenia-outline {
            background-color: transparent;
            color: var(--primary) !important;
            border: 1px solid var(--primary-border);
            font-size: 0.88rem;
            font-weight: 500;
            padding: 0.55rem 1.25rem;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            text-decoration: none;
        }
        .btn-gardenia-outline:hover {
            background-color: var(--primary-soft);
            border-color: var(--primary);
            color: var(--primary-dark) !important;
        }
        .btn-gardenia-gold {
            background-color: var(--accent);
            color: #ffffff !important;
            border: 1px solid var(--accent);
            font-size: 0.88rem;
            font-weight: 600;
            padding: 0.55rem 1.25rem;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            text-decoration: none;
        }
        .btn-gardenia-gold:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
            transform: translateY(-1px);
        }
        .btn-gardenia-sm {
            font-size: 0.8rem;
            padding: 0.35rem 0.85rem;
        }
        .btn-gardenia-lg {
            font-size: 0.95rem;
            padding: 0.75rem 1.75rem;
            border-radius: var(--radius-md);
        }

        /* CARDS & SURFACES */
        .card-clean {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-xs);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .card-clean-hover:hover {
            border-color: var(--primary-border);
            box-shadow: var(--shadow-md);
        }

        /* BADGES */
        .badge-kbli {
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.25rem 0.55rem;
            border-radius: 4px;
            border: 1px solid var(--primary-border);
            letter-spacing: 0.02em;
        }
        .badge-status {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.28rem 0.65rem;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
        }
        .badge-status-pending     { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .badge-status-confirmed   { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .badge-status-in_progress { background: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }
        .badge-status-completed   { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .badge-status-cancelled   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .badge-status-paid        { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .badge-status-unpaid      { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

        /* HEADER BANNER */
        .page-header-clean {
            background: var(--primary-dark);
            color: #ffffff;
            padding: 3.5rem 0 3rem;
            position: relative;
        }
        .page-header-clean h1 {
            font-size: clamp(1.8rem, 3.5vw, 2.5rem);
            font-weight: 700;
            margin-bottom: 0.4rem;
        }
        .page-header-clean p {
            color: rgba(255,255,255,0.8);
            font-size: 0.95rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* CART BADGE (legacy alias, kept for compatibility) */
        .cart-indicator {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--accent);
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
        }

        /* TABLES */
        .table-clean {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }
        .table-clean thead th {
            background: #f8fafc;
            color: var(--text-muted);
            font-size: 0.76rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.85rem 1.15rem;
            border-bottom: 1px solid var(--border-color);
            border-top: none;
        }
        .table-clean tbody td {
            padding: 1rem 1.15rem;
            font-size: 0.88rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }
        .table-clean tbody tr:last-child td {
            border-bottom: none;
        }
        .table-clean tbody tr:hover td {
            background-color: #f8faf9;
        }

        /* FORMS */
        .form-control, .form-select {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 0.6rem 0.9rem;
            font-size: 0.88rem;
            color: var(--text-main);
            background-color: #ffffff;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(24, 62, 43, 0.1);
            outline: none;
        }
        .form-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 0.35rem;
        }

        /* FOOTER */
        footer {
            background: #0d2217;
            color: #ffffff;
            border-top: 1px solid rgba(255,255,255,0.06);
        }
        footer a {
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            transition: color 0.15s ease;
        }
        footer a:hover {
            color: var(--accent-light);
        }
        .footer-heading {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.45);
            margin-bottom: 1rem;
        }
        .footer-logo-img {
            height: 38px;
            width: auto;
            background: #ffffff;
            padding: 6px 10px;
            border-radius: var(--radius-sm);
        }
    </style>
    @yield('styles')
</head>
<body>

{{-- ===== MAIN NAVBAR ===== --}}
<nav class="navbar navbar-expand-lg navbar-light sticky-top shadow-sm" id="mainNavbar">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
      <img src="{{ asset('images/logo/gardenia-logo.png') }}" alt="Gardenia's, CV. Gardenia Setia Utama">
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
                <li><a class="dropdown-item text-success fw-semibold" href="{{ route('admin.dashboard') }}"><i class="bi bi-shield-check me-2"></i>Panel Admin</a></li>
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
<footer class="pt-5 pb-4 mt-5">
  <div class="container">
    <div class="row g-4 g-lg-5">
      <div class="col-lg-4 col-md-6">
        <div class="d-flex align-items-center gap-2 mb-3">
          <img src="{{ asset('images/logo/gardenia-logo.png') }}" alt="Gardenia's" class="footer-logo-img">
        </div>
        <p style="color:rgba(255,255,255,0.65);font-size:0.85rem;line-height:1.65;max-width:340px;">
          Penyedia jasa arsitektur, rancangan desain interior, dan konstruksi terpercaya sejak 2009 di Kabupaten Bogor dengan standar mutu profesional.
        </p>
      </div>

      <div class="col-lg-2 col-6">
        <div class="footer-heading">Navigasi</div>
        <ul class="list-unstyled mb-0" style="font-size:0.85rem;line-height:2;">
          <li><a href="{{ route('home') }}">Beranda</a></li>
          <li><a href="{{ route('about') }}">Tentang Kami</a></li>
          <li><a href="{{ route('services') }}">Layanan</a></li>
          <li><a href="{{ route('portfolio') }}">Portofolio</a></li>
          <li><a href="{{ route('contact') }}">Kontak</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-6">
        <div class="footer-heading">Layanan Unggulan</div>
        <ul class="list-unstyled mb-0" style="font-size:0.85rem;line-height:2;">
          <li><a href="{{ route('services') }}">Aktivitas Arsitektur</a></li>
          <li><a href="{{ route('services') }}">Perancangan Khusus</a></li>
          <li><a href="{{ route('services') }}">Dekorasi Eksterior</a></li>
          <li><a href="{{ route('services') }}">Perawatan Taman</a></li>
          <li><a href="{{ route('spk.index') }}" style="color:var(--accent-light);">Rekomendasi Paket SAW</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="footer-heading">Kantor & Kontak</div>
        <ul class="list-unstyled mb-0" style="font-size:0.85rem;line-height:1.8;color:rgba(255,255,255,0.65);">
          <li class="mb-1">Kabupaten Bogor, Jawa Barat</li>
          <li class="mb-1">Telepon: (0251) 762-9881</li>
          <li class="mb-1">WhatsApp: 0851-1920-8772</li>
          <li class="mb-1">Email: gardeniasetiautama@gmail.com</li>
          <li>Senin – Jumat, 08.00 – 17.00 WIB</li>
        </ul>
      </div>
    </div>

    <hr class="my-4" style="border-color:rgba(255,255,255,0.08);">

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2" style="font-size:0.78rem;color:rgba(255,255,255,0.45);">
      <span>© {{ date('Y') }} CV. Gardenia Setia Utama. Seluruh hak cipta dilindungi.</span>
      <span>Notaris: Hatopan Kristien Simorangkir, SH, M.Kn</span>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  window.addEventListener('scroll', function () {
    document.getElementById('mainNavbar').classList.toggle('scrolled', window.scrollY > 12);
  });
</script>
@yield('scripts')
</body>
</html>