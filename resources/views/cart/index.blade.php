@extends('layouts.app')
@section('title', 'Keranjang Layanan | CV. Gardenia Setia Utama')

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header-clean text-center">
  <div class="container">
    <h1>Keranjang Layanan</h1>
    <p>Periksa kembali daftar layanan dan paket desain pilihan Anda sebelum melanjutkan ke proses pemesanan.</p>
  </div>
</section>

<div class="container py-5">
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-between p-3 mb-4 rounded-3 border-0 bg-success-subtle text-success">
      <span class="small fw-medium">{{ session('success') }}</span>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
  @endif

  @if(empty($cart))
    <div class="card-clean p-5 text-center my-4">
      <div class="p-3 rounded-circle bg-light d-inline-flex mb-3 border">
        <i class="bi bi-bag fs-3 text-muted"></i>
      </div>
      <h3 class="fw-bold fs-5 mb-1 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Keranjang Anda Masih Kosong</h3>
      <p class="text-muted small mb-4">Pilih layanan arsitektur atau paket rekomendasi yang Anda butuhkan.</p>
      <div>
        <a href="{{ route('services') }}" class="btn-gardenia">Jelajahi Katalog Layanan</a>
      </div>
    </div>
  @else
    <div class="row g-4">
      
      {{-- DAFTAR ITEM KERANJANG --}}
      <div class="col-lg-8">
        <div class="card-clean overflow-hidden mb-3">
          <div class="table-responsive">
            <table class="table table-clean mb-0 align-middle">
              <thead>
                <tr>
                  <th>Layanan</th>
                  <th>Tarif</th>
                  <th class="text-center">Kuantitas</th>
                  <th>Subtotal</th>
                  <th class="text-end">Hapus</th>
                </tr>
              </thead>
              <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                @php 
                  $sub = $item['price'] * $item['quantity']; 
                  $total += $sub; 
                @endphp
                <tr>
                  <td>
                    <div class="fw-semibold small text-dark">{{ $item['name'] }}</div>
                    <div class="text-muted" style="font-size:0.75rem;">
                      {{ $item['category'] }} @if(!empty($item['kbli'])) · <span class="badge-kbli">{{ $item['kbli'] }}</span> @endif
                    </div>
                  </td>
                  <td>
                    <span class="small text-muted">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                  </td>
                  <td class="text-center">
                    <span class="small fw-semibold text-dark">{{ $item['quantity'] }}</span>
                  </td>
                  <td>
                    <span class="small fw-bold text-dark">Rp {{ number_format($sub, 0, ',', '.') }}</span>
                  </td>
                  <td class="text-end">
                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                      @csrf 
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2.5" title="Hapus Item" style="font-size:0.78rem;">
                        Hapus
                      </button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
          <a href="{{ route('services') }}" class="btn-gardenia-outline btn-gardenia-sm">
            ← Tambah Layanan Lain
          </a>
          <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan semua item di keranjang?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger">Kosongkan Keranjang</button>
          </form>
        </div>
      </div>

      {{-- RINGKASAN BIAYA --}}
      <div class="col-lg-4">
        <div class="card-clean p-4 position-sticky" style="top: 90px;">
          <h3 class="fw-bold fs-5 mb-3 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Ringkasan Biaya</h3>
          
          @php $tax = $total * 0.11; @endphp
          
          <div class="d-flex flex-column gap-2 mb-3">
            <div class="d-flex justify-content-between text-muted small">
              <span>Subtotal Layanan</span>
              <span class="fw-medium text-dark">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between text-muted small">
              <span>PPN (11%)</span>
              <span class="fw-medium text-dark">Rp {{ number_format($tax, 0, ',', '.') }}</span>
            </div>
          </div>

          <hr class="my-3">

          <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="fw-semibold small text-dark">Total Tagihan</span>
            <span class="fs-5 fw-bold" style="color:var(--primary)">Rp {{ number_format($total + $tax, 0, ',', '.') }}</span>
          </div>

          <a href="{{ route('checkout.index') }}" class="btn-gardenia w-100 py-2.5 text-center">
            Lanjut ke Checkout →
          </a>
          
          <div class="mt-3 text-center">
            <span class="text-muted" style="font-size:0.75rem;">Termasuk opsi DP 30% pada halaman checkout</span>
          </div>
        </div>
      </div>

    </div>
  @endif
</div>

@endsection

