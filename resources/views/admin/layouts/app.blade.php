<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Panel Admin') | CV. Gardenia Setia Utama</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --sidebar-w: 264px;
      --primary: #183e2b;
      --primary-dark: #0f2b1d;
      --primary-hover: #133323;
      --primary-light: #245c40;
      --primary-soft: #f0f7f3;
      --primary-border: #d4e7dc;
      --accent: #c4973b;
      --bg-page: #f6f8f7;
      --card-bg: #ffffff;
      --text-main: #1e293b;
      --text-muted: #64748b;
      --border-color: #e2e8f0;
      --radius-sm: 8px;
      --radius-md: 12px;
      --shadow-xs: 0 1px 2px rgba(15,43,29,.04);
      --shadow-sm: 0 1px 3px rgba(15,43,29,.07), 0 1px 2px rgba(15,43,29,.04);
    }

    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
      background: var(--bg-page);
      color: var(--text-main);
      font-size: 0.9rem;
      min-height: 100vh;
      -webkit-font-smoothing: antialiased;
    }
    a { color: var(--primary); }
    a:hover { color: var(--primary-dark); }

    /* ───────── Sidebar ───────── */
    #sidebar {
      width: var(--sidebar-w);
      position: fixed; inset: 0 auto 0 0;
      z-index: 1040;
      background: linear-gradient(180deg, #0f2b1d 0%, #0c2217 100%);
      border-right: 1px solid rgba(255,255,255,0.05);
      transition: transform .25s ease;
      display: flex; flex-direction: column;
    }
    #sidebar .brand {
      padding: 1.25rem 1.4rem 1.1rem;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    #sidebar .brand a { display: inline-block; }
    #sidebar .brand img { height: 42px; width: auto; display: block; filter: brightness(0) invert(1); }
    #sidebar .brand .role {
      display: inline-flex; align-items: center; gap: .4rem; margin-top: .65rem;
      font-size: .66rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
      color: var(--accent);
    }
    #sidebar .brand .role::before { content: ""; width: 14px; height: 2px; background: var(--accent); border-radius: 2px; }

    #sidebar .nav-scroll { flex: 1; overflow-y: auto; padding: .4rem 0 1rem; }
    #sidebar .nav-scroll::-webkit-scrollbar { width: 6px; }
    #sidebar .nav-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 3px; }
    #sidebar .nav-section {
      color: rgba(255,255,255,0.38);
      font-size: 0.66rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
      padding: 1.15rem 1.5rem .4rem;
    }
    #sidebar .nav-link {
      position: relative;
      color: rgba(255,255,255,0.72);
      border-radius: var(--radius-sm);
      margin: .12rem .8rem;
      padding: .55rem .85rem;
      display: flex; align-items: center; gap: .75rem;
      font-size: .87rem; font-weight: 500;
      transition: background .15s ease, color .15s ease;
    }
    #sidebar .nav-link i { font-size: 1.02rem; width: 1.1rem; text-align: center; opacity: .8; }
    #sidebar .nav-link:hover { background: rgba(255,255,255,0.07); color: #fff; }
    #sidebar .nav-link.active { background: rgba(255,255,255,0.1); color: #fff; font-weight: 600; }
    #sidebar .nav-link.active::before {
      content: ""; position: absolute; left: -.8rem; top: 20%; bottom: 20%;
      width: 3px; border-radius: 0 3px 3px 0; background: var(--accent);
    }
    #sidebar .nav-link.active i { color: var(--accent); opacity: 1; }
    #sidebar .nav-link .count {
      margin-left: auto; background: var(--accent); color: #1b1405; font-size: .68rem; font-weight: 700;
      padding: .1rem .45rem; border-radius: 999px;
    }

    #sidebar .side-foot { padding: .9rem; border-top: 1px solid rgba(255,255,255,0.08); }
    #sidebar .side-foot .btn-logout {
      width: 100%; display: flex; align-items: center; gap: .6rem; justify-content: center;
      background: rgba(255,255,255,0.06); color: rgba(255,255,255,.8); border: 1px solid rgba(255,255,255,.1);
      border-radius: var(--radius-sm); padding: .55rem; font-size: .84rem; font-weight: 500; transition: all .15s ease;
    }
    #sidebar .side-foot .btn-logout:hover { background: rgba(220,38,38,.18); border-color: rgba(248,113,113,.4); color: #fecaca; }
    #sidebar-backdrop { display: none; position: fixed; inset: 0; background: rgba(15,43,29,.5); z-index: 1035; }

    /* ───────── Main ───────── */
    #main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
    .topbar {
      background: rgba(255,255,255,.92);
      backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
      border-bottom: 1px solid var(--border-color);
      padding: .7rem 1.75rem;
      display: flex; align-items: center; justify-content: space-between;
      position: sticky; top: 0; z-index: 1000;
      min-height: 64px;
    }
    .topbar .crumb { font-size: .72rem; color: var(--text-muted); letter-spacing: .02em; line-height: 1.2; }
    .topbar .crumb a { color: var(--text-muted); text-decoration: none; }
    .topbar .crumb a:hover { color: var(--primary); }
    .topbar .page-title { font-size: 1.05rem; font-weight: 700; color: var(--primary-dark); line-height: 1.3; margin: 0; }
    .topbar .today { font-size: .78rem; color: var(--text-muted); }
    .user-chip {
      display: flex; align-items: center; gap: .6rem; background: none; border: 1px solid transparent;
      padding: .25rem .5rem .25rem .3rem; border-radius: 999px; transition: all .15s ease;
    }
    .user-chip:hover, .user-chip[aria-expanded="true"] { background: var(--primary-soft); border-color: var(--primary-border); }
    .avatar {
      width: 34px; height: 34px; border-radius: 50%; display: grid; place-items: center;
      background: var(--primary); color: #fff; font-weight: 700; font-size: .82rem;
      box-shadow: 0 0 0 2px #fff, 0 0 0 3px var(--primary-border);
    }
    .user-chip .meta { text-align: left; line-height: 1.2; }
    .user-chip .meta strong { display: block; font-size: .82rem; color: var(--text-main); }
    .user-chip .meta span { font-size: .68rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .06em; }
    .dropdown-menu { border-radius: 10px; border: 1px solid var(--border-color); box-shadow: 0 10px 30px rgba(15,43,29,.12); font-size: .85rem; padding: .4rem; }
    .dropdown-item { border-radius: 6px; padding: .5rem .75rem; }
    .dropdown-item:active { background: var(--primary); }

    .content-area { padding: 1.75rem; flex: 1; }
    .admin-footer { padding: 1rem 1.75rem 1.5rem; font-size: .75rem; color: #94a3b8; text-align: center; }

    /* ───────── Komponen ───────── */
    .card-clean {
      background: var(--card-bg);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-xs);
    }
    .table-clean { --bs-table-bg: transparent; margin-bottom: 0; }
    .table-clean thead th {
      background: #f8faf9; color: var(--text-muted); font-weight: 600; font-size: .72rem;
      text-transform: uppercase; letter-spacing: .06em; padding: .75rem 1rem;
      border-bottom: 1px solid var(--border-color); white-space: nowrap;
    }
    .table-clean tbody td { padding: .85rem 1rem; border-bottom: 1px solid #eef2f0; color: var(--text-main); }
    .table-clean tbody tr:last-child td { border-bottom: 0; }
    .table-clean tbody tr:hover > td { background: #fafcfb; }

    .form-label { font-size: .8rem; font-weight: 600; color: #334155; }
    .form-control, .form-select { border-radius: var(--radius-sm); border-color: var(--border-color); font-size: .88rem; }
    .form-control:focus, .form-select:focus { border-color: var(--primary-light); box-shadow: 0 0 0 .2rem rgba(24,62,43,.12); }
    .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }
    .form-check-input:focus { border-color: var(--primary-light); box-shadow: 0 0 0 .2rem rgba(24,62,43,.12); }

    .badge-status { display: inline-block; padding: .25rem .65rem; border-radius: 999px; font-weight: 600; font-size: .7rem; letter-spacing: .02em; }
    .badge-status-pending      { background: #fef3c7; color: #92400e; padding: .25rem .65rem; border-radius: 999px; font-weight: 600; font-size: .7rem; }
    .badge-status-confirmed    { background: #dcfce7; color: #166534; padding: .25rem .65rem; border-radius: 999px; font-weight: 600; font-size: .7rem; }
    .badge-status-in_progress  { background: #e0f2fe; color: #075985; padding: .25rem .65rem; border-radius: 999px; font-weight: 600; font-size: .7rem; }
    .badge-status-completed    { background: #dcfce7; color: #166534; padding: .25rem .65rem; border-radius: 999px; font-weight: 600; font-size: .7rem; }
    .badge-status-cancelled    { background: #fee2e2; color: #991b1b; padding: .25rem .65rem; border-radius: 999px; font-weight: 600; font-size: .7rem; }
    .badge-status-paid         { background: #dcfce7; color: #166534; padding: .25rem .65rem; border-radius: 999px; font-weight: 600; font-size: .7rem; }
    .badge-status-unpaid       { background: #f1f5f9; color: #475569; padding: .25rem .65rem; border-radius: 999px; font-weight: 600; font-size: .7rem; }
    .badge-status-failed       { background: #fee2e2; color: #991b1b; padding: .25rem .65rem; border-radius: 999px; font-weight: 600; font-size: .7rem; }
    .badge-kbli { background: var(--primary-soft); color: var(--primary); font-size: .72rem; font-weight: 600; padding: .25rem .55rem; border-radius: 6px; border: 1px solid var(--primary-border); }

    .btn-gardenia, .btn-gardenia-sm, .btn-gardenia-outline, .btn-gardenia-outline-sm {
      display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
      font-weight: 600; text-decoration: none; cursor: pointer;
      border-radius: var(--radius-sm); transition: all .15s ease;
    }
    .btn-gardenia, .btn-gardenia-sm { background: var(--primary); color: #fff !important; border: 1px solid var(--primary); }
    .btn-gardenia:hover, .btn-gardenia-sm:hover { background: var(--primary-hover); border-color: var(--primary-hover); box-shadow: 0 3px 10px rgba(15,43,29,.18); }
    .btn-gardenia-outline, .btn-gardenia-outline-sm { background: #fff; color: var(--primary) !important; border: 1px solid var(--border-color); }
    .btn-gardenia-outline:hover, .btn-gardenia-outline-sm:hover { background: var(--primary-soft); border-color: var(--primary-border); }
    .btn-gardenia, .btn-gardenia-outline { font-size: .86rem; padding: .5rem 1.15rem; }
    .btn-gardenia-sm, .btn-gardenia-outline-sm { font-size: .78rem; padding: .35rem .8rem; font-weight: 500; }

    .alert-flash {
      display: flex; align-items: flex-start; gap: .6rem; border-radius: 10px; border: 1px solid;
      padding: .75rem 1rem; font-size: .85rem; margin-bottom: .5rem;
    }
    .alert-flash.success { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
    .alert-flash.error   { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
    .alert-flash .btn-close { margin-left: auto; font-size: .7rem; }

    @media (max-width: 991.98px) {
      #sidebar { transform: translateX(-100%); box-shadow: none; }
      #sidebar.open { transform: translateX(0); box-shadow: 0 0 40px rgba(0,0,0,.35); }
      #sidebar-backdrop.show { display: block; }
      #main { margin-left: 0; }
      .topbar, .content-area { padding-left: 1rem; padding-right: 1rem; }
    }
  </style>
  @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<nav id="sidebar" aria-label="Navigasi admin">
  <div class="brand">
    <a href="{{ route('admin.dashboard') }}" aria-label="Dashboard Admin">
      <img src="{{ asset('images/logo/gardenia-logo.png') }}" alt="Gardenia's, CV. Gardenia Setia Utama">
    </a>
    <div class="role">Panel Admin</div>
  </div>

  <div class="nav-scroll">
    <div class="nav-section">Ringkasan</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="bi bi-grid-1x2"></i> Dashboard
    </a>

    <div class="nav-section">Transaksi &amp; Layanan</div>
    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
      <i class="bi bi-clipboard-check"></i> Pesanan Proyek
    </a>
    <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
      <i class="bi bi-credit-card"></i> Pembayaran
    </a>
    <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
      <i class="bi bi-layers"></i> Katalog Layanan
    </a>

    <div class="nav-section">SPK Rekomendasi</div>
    <a href="{{ route('admin.spk.packages') }}" class="nav-link {{ request()->routeIs('admin.spk.packages*') ? 'active' : '' }}">
      <i class="bi bi-box-seam"></i> Paket Desain
    </a>
    <a href="{{ route('admin.spk.criteria') }}" class="nav-link {{ request()->routeIs('admin.spk.criteria*') ? 'active' : '' }}">
      <i class="bi bi-sliders"></i> Kriteria &amp; Bobot
    </a>

    <div class="nav-section">Pengguna</div>
    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
      <i class="bi bi-people"></i> Manajemen Akun
    </a>

    <div class="nav-section">Situs Publik</div>
    <a href="{{ route('home') }}" class="nav-link" target="_blank" rel="noopener">
      <i class="bi bi-box-arrow-up-right"></i> Buka Website
    </a>
  </div>

  <div class="side-foot">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-left"></i> Keluar</button>
    </form>
  </div>
</nav>
<div id="sidebar-backdrop"></div>

{{-- MAIN --}}
<div id="main">
  <header class="topbar">
    <div class="d-flex align-items-center gap-3">
      <button class="btn btn-sm btn-light border d-lg-none" id="sidebarToggle" aria-label="Buka menu"><i class="bi bi-list fs-5"></i></button>
      <div>
        <div class="crumb"><a href="{{ route('admin.dashboard') }}">Admin</a> &nbsp;/&nbsp; @yield('title', 'Dashboard')</div>
        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
      </div>
    </div>

    <div class="d-flex align-items-center gap-3">
      <span class="today d-none d-md-inline"><i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('l, d F Y') }}</span>
      <div class="dropdown">
        <button class="user-chip" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="avatar">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
          <span class="meta d-none d-sm-block"><strong>{{ \Illuminate\Support\Str::limit(auth()->user()->name, 22) }}</strong><span>Administrator</span></span>
          <i class="bi bi-chevron-down small text-muted d-none d-sm-inline"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li class="px-3 py-2 small text-muted">{{ auth()->user()->email }}</li>
          <li><hr class="dropdown-divider my-1"></li>
          <li><a class="dropdown-item" href="{{ route('home') }}" target="_blank" rel="noopener"><i class="bi bi-box-arrow-up-right me-2"></i>Buka Website</a></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-left me-2"></i>Keluar</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </header>

  {{-- Flash Messages --}}
  @if(session('success') || session('error'))
  <div class="px-4 pt-3 pb-0">
    @if(session('success'))
      <div class="alert-flash success alert alert-dismissible fade show mb-0" role="alert">
        <i class="bi bi-check-circle-fill"></i><span>{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert-flash error alert alert-dismissible fade show mb-0" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i><span>{{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
      </div>
    @endif
  </div>
  @endif

  <main class="content-area">
    @yield('content')
  </main>

  <footer class="admin-footer">&copy; {{ date('Y') }} CV. Gardenia Setia Utama &middot; Panel Admin</footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  (function () {
    var sidebar = document.getElementById('sidebar');
    var backdrop = document.getElementById('sidebar-backdrop');
    function toggle(open) {
      sidebar.classList.toggle('open', open);
      backdrop.classList.toggle('show', open);
    }
    document.getElementById('sidebarToggle')?.addEventListener('click', function () { toggle(!sidebar.classList.contains('open')); });
    backdrop.addEventListener('click', function () { toggle(false); });
  })();
</script>
@stack('scripts')
</body>
</html>
