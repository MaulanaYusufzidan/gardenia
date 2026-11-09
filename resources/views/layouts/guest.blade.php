<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Masuk') — CV. Gardenia Setia Utama</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
      --text-main: #1e293b;
      --text-muted: #64748b;
      --border-color: #e2e8f0;
    }
    html, body { height: 100%; }
    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
      color: var(--text-main);
      background: #fbfcfb;
      -webkit-font-smoothing: antialiased;
    }
    .auth-shell { min-height: 100vh; display: flex; }

    /* Panel merek (kiri) */
    .auth-brand {
      position: relative;
      flex: 0 0 46%;
      max-width: 46%;
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 3rem 3.5rem;
      background:
        linear-gradient(160deg, rgba(15,43,29,.94) 0%, rgba(24,62,43,.90) 55%, rgba(15,43,29,.96) 100%),
        url("{{ asset('images/hero/hero-bg.jpg') }}") center/cover no-repeat;
      overflow: hidden;
    }
    .auth-brand::after {
      content: ""; position: absolute; right: -90px; bottom: -90px;
      width: 320px; height: 320px; border-radius: 50%;
      border: 1px solid rgba(196,151,59,.35);
      box-shadow: 0 0 0 40px rgba(196,151,59,.05), 0 0 0 90px rgba(196,151,59,.03);
      pointer-events: none;
    }
    .auth-brand .brand-logo { height: 54px; width: auto; filter: brightness(0) invert(1); }
    .auth-brand h2 {
      font-family: 'Playfair Display', Georgia, serif;
      font-size: 2.1rem; line-height: 1.25; font-weight: 700; letter-spacing: -.01em;
      margin: 0 0 1rem;
    }
    .auth-brand .lead-text { color: rgba(255,255,255,.72); font-size: .95rem; max-width: 420px; line-height: 1.7; }
    .auth-brand .gold-rule { width: 48px; height: 3px; background: var(--accent); border-radius: 2px; margin-bottom: 1.25rem; }
    .auth-points { list-style: none; padding: 0; margin: 2rem 0 0; display: grid; gap: .9rem; }
    .auth-points li { display: flex; gap: .75rem; align-items: flex-start; font-size: .88rem; color: rgba(255,255,255,.85); }
    .auth-points .ico {
      flex: 0 0 32px; height: 32px; border-radius: 8px; display: grid; place-items: center;
      background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14); color: var(--accent);
    }
    .auth-brand .foot { font-size: .75rem; color: rgba(255,255,255,.5); position: relative; z-index: 1; }
    .auth-brand > * { position: relative; z-index: 1; }

    /* Panel formulir (kanan) */
    .auth-main { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem 1.25rem; }
    .auth-card { width: 100%; max-width: 420px; }
    .auth-mobile-logo { display: none; height: 44px; width: auto; margin: 0 auto 1.5rem; }
    .auth-title { font-size: 1.5rem; font-weight: 700; color: var(--primary-dark); margin: 0 0 .35rem; letter-spacing: -.01em; }
    .auth-sub { font-size: .85rem; color: var(--text-muted); margin-bottom: 1.75rem; }

    .form-label { font-size: .8rem; font-weight: 600; color: #334155; margin-bottom: .35rem; }
    .form-control {
      padding: .65rem .85rem; font-size: .9rem; border-radius: 8px; border: 1px solid var(--border-color);
    }
    .form-control:focus { border-color: var(--primary-light); box-shadow: 0 0 0 .2rem rgba(24,62,43,.12); }
    .input-group .form-control { border-right: 0; }
    .input-group .toggle-pass {
      border: 1px solid var(--border-color); border-left: 0; background: #fff; color: var(--text-muted);
      border-radius: 0 8px 8px 0; padding: 0 .85rem;
    }
    .input-group .toggle-pass:hover { color: var(--primary); }
    .input-group:focus-within .toggle-pass, .input-group:focus-within .form-control { border-color: var(--primary-light); }
    .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }
    .form-check-input:focus { box-shadow: 0 0 0 .2rem rgba(24,62,43,.12); border-color: var(--primary-light); }

    .btn-gardenia {
      background: var(--primary); color: #fff; border: 1px solid var(--primary); font-weight: 600; font-size: .9rem;
      padding: .7rem 1.25rem; border-radius: 8px; width: 100%; transition: all .18s ease;
    }
    .btn-gardenia:hover { background: var(--primary-hover); border-color: var(--primary-hover); color: #fff; box-shadow: 0 4px 12px rgba(15,43,29,.18); }
    .auth-link { color: var(--primary); font-weight: 600; text-decoration: none; }
    .auth-link:hover { color: var(--primary-dark); text-decoration: underline; }
    .text-link-muted { color: var(--text-muted); text-decoration: none; font-size: .8rem; }
    .text-link-muted:hover { color: var(--primary); }
    .auth-alert { font-size: .83rem; border-radius: 8px; border: 1px solid; padding: .7rem .9rem; margin-bottom: 1.1rem; display: flex; gap: .55rem; align-items: flex-start; }
    .auth-alert.ok { background: var(--primary-soft); border-color: var(--primary-border); color: #166534; }
    .auth-alert.err { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
    .field-error { color: #b91c1c; font-size: .78rem; margin-top: .3rem; }
    .auth-footer { margin-top: 2rem; text-align: center; font-size: .78rem; color: #94a3b8; }

    @media (max-width: 991.98px) {
      .auth-brand { display: none; }
      .auth-mobile-logo { display: block; }
      .auth-shell { background: linear-gradient(180deg, var(--primary-soft) 0, #fbfcfb 220px); }
    }
  </style>
</head>
<body>
  <div class="auth-shell">
    <aside class="auth-brand">
      <a href="{{ route('home') }}" aria-label="Gardenia's — Beranda">
        <img src="{{ asset('images/logo/gardenia-logo.png') }}" alt="Gardenia's — CV. Gardenia Setia Utama" class="brand-logo">
      </a>

      <div>
        <div class="gold-rule"></div>
        <h2>Merancang ruang,<br>membangun kepercayaan.</h2>
        <p class="lead-text">Portal klien CV. Gardenia Setia Utama untuk memantau pesanan, pembayaran, dan rekomendasi paket desain yang sesuai kebutuhan proyek Anda.</p>
        <ul class="auth-points">
          <li><span class="ico"><i class="bi bi-clipboard-check"></i></span><span>Pantau status pesanan proyek secara real-time</span></li>
          <li><span class="ico"><i class="bi bi-calculator"></i></span><span>Rekomendasi paket desain berbasis perhitungan SAW</span></li>
          <li><span class="ico"><i class="bi bi-shield-check"></i></span><span>Pembayaran dan dokumen proyek tercatat dengan aman</span></li>
        </ul>
      </div>

      <div class="foot">&copy; {{ date('Y') }} CV. Gardenia Setia Utama. Hak cipta dilindungi.</div>
    </aside>

    <main class="auth-main">
      <div class="auth-card">
        <a href="{{ route('home') }}" class="d-block text-center">
          <img src="{{ asset('images/logo/gardenia-logo.png') }}" alt="Gardenia's" class="auth-mobile-logo">
        </a>

        {{ $slot }}

        <div class="auth-footer">
          <a href="{{ route('home') }}" class="text-link-muted"><i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda</a>
        </div>
      </div>
    </main>
  </div>

  <script>
    document.querySelectorAll('.toggle-pass').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var input = document.getElementById(btn.dataset.target);
        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        btn.querySelector('i').className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
      });
    });
  </script>
</body>
</html>
