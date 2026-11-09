<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
      <span style="color:var(--gold);font-size:1.4rem;">🌿</span>
      <span>Gardenia <small class="fw-normal text-muted" style="font-size:.7rem;">Setia Utama</small></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'fw-bold' : '' }}" href="{{ route('home') }}">Beranda</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'fw-bold' : '' }}" href="{{ route('about') }}">Tentang</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('services*') ? 'fw-bold' : '' }}" href="{{ route('services') }}">Layanan</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('portfolio') ? 'fw-bold' : '' }}" href="{{ route('portfolio') }}">Portofolio</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'fw-bold' : '' }}" href="{{ route('contact') }}">Kontak</a></li>
      </ul>
      <ul class="navbar-nav align-items-center gap-2">
        @auth
          <li class="nav-item position-relative">
            <a class="nav-link" href="{{ route('cart.index') }}">
              🛒 Keranjang
              @php $cartCount = count(session()->get('cart',[])); @endphp
              @if($cartCount > 0)
                <span class="cart-badge">{{ $cartCount }}</span>
              @endif
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              👤 {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('orders.index') }}"> Pesanan Saya</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item text-danger" type="submit"> Logout</button>
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
