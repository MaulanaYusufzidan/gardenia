<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Panel Admin') — CV. Gardenia Setia Utama</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  
  <style>
    :root {
      --sidebar-w: 260px;
      --primary: #183e2b;
      --primary-dark: #0f2b1d;
      --accent: #c4973b;
      --bg-page: #f8faf9;
      --card-bg: #ffffff;
      --text-main: #1e293b;
      --text-muted: #64748b;
      --border-color: #e2e8f0;
      --radius-sm: 8px;
      --radius-md: 12px;
    }
    
    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
      background: var(--bg-page);
      color: var(--text-main);
      font-size: 0.9rem;
      letter-spacing: -0.01em;
      min-height: 100vh;
    }

    /* Sidebar */
    #sidebar {
      width: var(--sidebar-w);
      min-height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
      background: #0f251a;
      border-right: 1px solid rgba(255,255,255,0.06);
      transition: transform 0.25s ease;
      display: flex;
      flex-direction: column;
    }
    #sidebar .brand {
      padding: 1.35rem 1.25rem 1.1rem;
      border-bottom: 1px solid rgba(255,255,255,0.08);
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    #sidebar .brand-mark {
      width: 32px;
      height: 32px;
      background: #183e2b;
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      color: #c4973b;
      font-size: 1.1rem;
    }
    #sidebar .brand-text h6 {
      color: #ffffff;
      font-weight: 700;
      font-size: 0.95rem;
      margin: 0;
      line-height: 1.2;
    }
    #sidebar .brand-text small {
      color: rgba(255,255,255,0.45);
      font-size: 0.72rem;
      letter-spacing: 0.02em;
    }
    #sidebar .nav-section {
      color: rgba(255,255,255,0.35);
      font-size: 0.68rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      padding: 1rem 1.25rem 0.35rem;
    }
    #sidebar .nav-link {
      color: rgba(255,255,255,0.7);
      border-radius: var(--radius-sm);
      margin: 0.15rem 0.75rem;
      padding: 0.55rem 0.85rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-size: 0.88rem;
      font-weight: 500;
      transition: all 0.18s ease;
    }
    #sidebar .nav-link:hover {
      background: rgba(255,255,255,0.08);
      color: #ffffff;
    }
    #sidebar .nav-link.active {
      background: #183e2b;
      color: #ffffff;
      font-weight: 600;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    #sidebar .nav-link i {
      font-size: 1.05rem;
      opacity: 0.85;
    }

    /* Main Container */
    #main {
      margin-left: var(--sidebar-w);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .topbar {
      background: #ffffff;
      border-bottom: 1px solid var(--border-color);
      padding: 0.75rem 1.75rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 999;
    }
    .content-area {
      padding: 1.75rem;
      flex: 1;
    }

    /* Cards & Components */
    .card-clean {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }
    .table-clean {
      --bs-table-bg: transparent;
      margin-bottom: 0;
    }
    .table-clean thead th {
      background: #f8faf9;
      color: var(--text-muted);
      font-weight: 600;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      padding: 0.75rem 1rem;
      border-bottom: 1px solid var(--border-color);
    }
    .table-clean tbody td {
      padding: 0.85rem 1rem;
      border-bottom: 1px solid var(--border-color);
      color: var(--text-main);
    }

    /* Badges */
    .badge-status-pending      { background: #fef3c7; color: #92400e; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.72rem; }
    .badge-status-confirmed    { background: #dcfce7; color: #166534; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.72rem; }
    .badge-status-in_progress  { background: #e0f2fe; color: #075985; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.72rem; }
    .badge-status-completed    { background: #dcfce7; color: #166534; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.72rem; }
    .badge-status-cancelled    { background: #fee2e2; color: #991b1b; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.72rem; }
    .badge-status-paid         { background: #dcfce7; color: #166534; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.72rem; }
    .badge-status-unpaid       { background: #f1f5f9; color: #475569; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.72rem; }
    .badge-status-failed       { background: #fee2e2; color: #991b1b; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.72rem; }

    .btn-gardenia-sm {
      background: var(--primary);
      color: #ffffff;
      font-size: 0.8rem;
      font-weight: 500;
      padding: 0.35rem 0.85rem;
      border-radius: var(--radius-sm);
      border: 1px solid var(--primary);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      transition: all 0.2s ease;
    }
    .btn-gardenia-sm:hover {
      background: var(--primary-dark);
      color: #ffffff;
    }
    .btn-gardenia-outline-sm {
      background: transparent;
      color: var(--text-main);
      font-size: 0.8rem;
      font-weight: 500;
      padding: 0.35rem 0.85rem;
      border-radius: var(--radius-sm);
      border: 1px solid var(--border-color);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      transition: all 0.2s ease;
    }
    .btn-gardenia-outline-sm:hover {
      background: #f1f5f9;
      color: var(--text-main);
    }

    @media(max-width:768px){
      #sidebar { transform: translateX(-100%); }
      #sidebar.open { transform: translateX(0); }
      #main { margin-left: 0; }
    }
  </style>
  @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<nav id="sidebar">
  <div class="brand">
    <div class="brand-mark">G</div>
    <div class="brand-text">
      <h6>Gardenia Admin</h6>
      <small>CV. Gardenia Setia Utama</small>
    </div>
  </div>

  <div class="pt-2 pb-3 flex-fill overflow-y-auto">
    <div class="nav-section">Ringkasan</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="bi bi-grid-1x2"></i> Dashboard
    </a>

    <div class="nav-section">Transaksi & Layanan</div>
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
      <i class="bi bi-sliders"></i> Kriteria & Bobot
    </a>

    <div class="nav-section">Pengguna</div>
    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
      <i class="bi bi-people"></i> Manajemen Akun
    </a>

    <div class="nav-section">Situs Publik</div>
    <a href="{{ route('home') }}" class="nav-link" target="_blank">
      <i class="bi bi-box-arrow-up-right"></i> Buka Website
    </a>
  </div>

  <div class="p-3 border-top border-white/10">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn btn-sm w-100 text-start nav-link border-0 text-white-50 p-2">
        <i class="bi bi-box-arrow-left me-2"></i> Keluar (Logout)
      </button>
    </form>
  </div>
</nav>

{{-- MAIN --}}
<div id="main">
  {{-- Topbar --}}
  <div class="topbar">
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-sm btn-light border d-md-none" id="sidebarToggle"><i class="bi bi-list fs-5"></i></button>
      <span class="fw-semibold text-dark fs-6">@yield('page-title', 'Dashboard')</span>
    </div>
    <div class="d-flex align-items-center gap-3">
      <div class="d-flex align-items-center gap-2">
        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white small" style="width:32px;height:32px;background:var(--primary);font-size:0.8rem;">
          {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <span class="small fw-semibold text-dark d-none d-sm-inline">{{ auth()->user()->name }}</span>
      </div>
    </div>
  </div>

  {{-- Flash Messages --}}
  <div class="px-4 pt-3 pb-0">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show p-3 mb-0 rounded-3 border-0 bg-success-subtle text-success small" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show p-3 mb-0 rounded-3 border-0 bg-danger-subtle text-danger small" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
  </div>

  <div class="content-area">
    @yield('content')
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('sidebarToggle')?.addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('open');
  });
</script>
@stack('scripts')
</body>
</html>

