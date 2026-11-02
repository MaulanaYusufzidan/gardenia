@extends('layouts.app')
@section('title', 'Checkout Pesanan — CV. Gardenia Setia Utama')

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header-clean text-center">
  <div class="container">
    <h1>Checkout Pesanan</h1>
    <p>Lengkapi rincian proyek dan pilih skema pembayaran untuk memproses kontrak pesanan Anda.</p>
  </div>
</section>

<div class="container py-5">
  @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show p-3 mb-4 rounded-3 border-0 bg-danger-subtle text-danger">
      <ul class="mb-0 small ps-3">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
  @endif

  <div class="row g-4 g-lg-5">
    
    {{-- FORM CHECKOUT --}}
    <div class="col-lg-7">
      <div class="card-clean p-4 p-md-5">
        <h2 class="fw-bold fs-5 mb-4 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Detail Informasi Proyek</h2>
        
        <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
          @csrf
          
          <div class="mb-3">
            <label class="form-label">Nama Proyek <span class="text-danger">*</span></label>
            <input type="text" name="project_name" class="form-control @error('project_name') is-invalid @enderror"
                   placeholder="Contoh: Renovasi Rumah Tinggal 2 Lantai" value="{{ old('project_name') }}" required>
            @error('project_name')<div class="invalid-feedback small">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Alamat Lengkap Lokasi Proyek <span class="text-danger">*</span></label>
            <textarea name="project_address" class="form-control @error('project_address') is-invalid @enderror"
                      rows="3" placeholder="Alamat jalan, kelurahan, kecamatan, kota/kabupaten..." required>{{ old('project_address') }}</textarea>
            @error('project_address')<div class="invalid-feedback small">{{ $message }}</div>@enderror
          </div>

          <div class="mb-4">
            <label class="form-label">Catatan Tambahan / Spesifikasi Khusus</label>
            <textarea name="notes" class="form-control" rows="2"
                      placeholder="Target waktu pelaksanaan atau kebutuhan teknis khusus (opsional)...">{{ old('notes') }}</textarea>
          </div>

          <hr class="my-4">

          {{-- SKEMA PEMBAYARAN --}}
          <h3 class="fw-bold fs-6 mb-3 text-dark">Rencana Skema Pembayaran</h3>
          
          <div class="d-flex flex-column gap-2.5 mb-3">
            <label class="card-clean p-3 d-flex gap-3 align-items-start cursor-pointer border" style="cursor:pointer;">
              <input type="radio" name="payment_plan" value="full" class="form-check-input mt-1" checked>
              <div>
                <div class="fw-semibold small text-dark">Pembayaran Penuh (100%)</div>
                <div class="text-muted small">Pembayaran penuh langsung diproses saat checkout.</div>
              </div>
            </label>

            <label class="card-clean p-3 d-flex gap-3 align-items-start cursor-pointer border" style="cursor:pointer;">
              <input type="radio" name="payment_plan" value="dp" class="form-check-input mt-1">
              <div>
                <div class="fw-semibold small text-dark">Uang Muka (DP 30%) + Pelunasan</div>
                <div class="text-muted small">Bayar 30% dari total sekarang. Sisa 70% ditagihkan setelah verifikasi DP.</div>
              </div>
            </label>
          </div>

          <div class="p-3 bg-light rounded-2 small text-muted mb-4 border" id="paymentPlanNotice">
            Pembayaran penuh (100%) akan dibebankan saat checkout.
          </div>

          <hr class="my-4">

          {{-- METODE PEMBAYARAN --}}
          <h3 class="fw-bold fs-6 mb-3 text-dark">Metode Pembayaran</h3>
          
          <div class="d-flex flex-column gap-2.5 mb-4">
            <label class="card-clean p-3 d-flex gap-3 align-items-start cursor-pointer border" style="cursor:pointer;">
              <input type="radio" name="payment_method" value="transfer" class="form-check-input mt-1" checked>
              <div>
                <div class="fw-semibold small text-dark">Transfer Bank Manual (BCA)</div>
                <div class="text-muted small">No. Rekening: <strong>1234567890</strong> a/n CV. Gardenia Setia Utama</div>
                <div class="text-muted" style="font-size:0.75rem;">Konfirmasi bukti bayar diverifikasi dalam 1x24 jam kerja.</div>
              </div>
            </label>

            <label class="card-clean p-3 d-flex gap-3 align-items-start cursor-pointer border" style="cursor:pointer;">
              <input type="radio" name="payment_method" value="midtrans" class="form-check-input mt-1">
              <div>
                <div class="fw-semibold small text-dark">Pembayaran Online (Payment Gateway)</div>
                <div class="text-muted small">Virtual Account, QRIS, GoPay, OVO, ShopeePay, Kartu Kredit</div>
              </div>
            </label>
          </div>

          <button type="submit" class="btn-gardenia w-100 py-3 text-center fw-semibold">
            Proses & Konfirmasi Pesanan
          </button>
        </form>
      </div>
    </div>

    {{-- RINGKASAN ORDER --}}
    <div class="col-lg-5">
      <div class="card-clean p-4 position-sticky" style="top: 90px;">
        <h3 class="fw-bold fs-5 mb-3 text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Ringkasan Pesanan</h3>
        
        <div class="d-flex flex-column gap-2 mb-3">
          @foreach($cart as $item)
          <div class="d-flex justify-content-between py-2 border-bottom">
            <div>
              <div class="fw-semibold small text-dark">{{ $item['name'] }}</div>
              <div class="text-muted" style="font-size:0.75rem;">Qty: {{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
            </div>
            <span class="small fw-semibold text-dark">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
          </div>
          @endforeach
        </div>

        <div class="d-flex flex-column gap-2 mb-3 small text-muted">
          <div class="d-flex justify-content-between">
            <span>Subtotal</span>
            <span class="text-dark fw-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
          </div>
          <div class="d-flex justify-content-between">
            <span>PPN (11%)</span>
            <span class="text-dark fw-medium">Rp {{ number_format($tax, 0, ',', '.') }}</span>
          </div>
        </div>

        <hr class="my-3">

        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <div class="fw-bold small text-dark">Total Biaya Pesanan</div>
            <div class="text-muted" style="font-size:0.72rem;">Sudah termasuk PPN</div>
          </div>
          <span class="fs-5 fw-bold" style="color:var(--primary)">Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>

        <div class="p-3 bg-light rounded-2 text-center border">
          <div class="fw-semibold small text-dark mb-1">Perlu Bantuan Teknis?</div>
          <div class="text-muted small mb-2">Konsultasikan kebutuhan proyek Anda via WhatsApp.</div>
          <a href="https://wa.me/6285119208772?text=Halo%20Gardenia,%20saya%20sedang%20melakukan%20checkout%20dan%20membutuhkan%20informasi" target="_blank" class="btn-gardenia-outline btn-gardenia-sm w-100">
            <i class="bi bi-whatsapp"></i> Chat WhatsApp
          </a>
        </div>
      </div>
    </div>

  </div>
</div>

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const totalAmount = {{ $total }};
    const noticeBox = document.getElementById('paymentPlanNotice');
    const planRadios = document.querySelectorAll('input[name="payment_plan"]');

    function updatePlanNotice() {
      const selected = document.querySelector('input[name="payment_plan"]:checked')?.value;
      if (selected === 'dp') {
        const dpVal = Math.round(totalAmount * 0.3);
        const formattedDp = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(dpVal);
        noticeBox.innerHTML = `Nominal DP 30% yang harus dibayarkan sekarang: <strong>${formattedDp}</strong>. Sisa 70% ditagihkan setelah verifikasi DP.`;
      } else {
        noticeBox.textContent = 'Pembayaran penuh (100%) akan dibebankan saat checkout.';
      }
    }

    planRadios.forEach(radio => radio.addEventListener('change', updatePlanNotice));
    updatePlanNotice();
  });
</script>
@endsection

@endsection

