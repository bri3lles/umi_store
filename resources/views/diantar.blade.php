@extends('layouts.app') <!-- Sesuaikan dengan layout utama Anda jika ada -->

@push('styles')
  <!-- PEMANGGILAN FILE CSS EKSTERNAL -->
  <link rel="stylesheet" href="{{ asset('css/diantar.css') }}">
@endpush

@section('content')
  <!-- KONTROL UTAMA CHECKOUT -->
  <div class="checkout-container">
    
    <!-- SISI KIRI -->
    <main>
      <h1 class="page-title">Alamat Pengirim</h1>

      <!-- Kartu Alamat Utama Aktif -->
      <div class="address-card" id="activeAddressCard">
        <div class="address-header">
          <div class="recipient-info">
            <i class="fa-solid fa-location-dot"></i>
            <span id="displayRecipient">Dimas Satria (+62 812-3456-7890)</span>
          </div>
        </div>
        <p class="address-detail" id="displayAddressText">
          Jl. Dharmahusada Indah Timur No. 42, Mulyorejo, Kota Surabaya, Jawa Timur 60115
        </p>
        <div class="address-note" id="displayNoteBox">
          <i class="fa-solid fa-circle-info"></i>
          <span id="displayNoteText">Catatan Pengirim: "Titipkan di pos satpam bila rumah kosong"</span>
        </div>
        <div class="address-actions">
          <button type="button" id="btnOpenUbahAlamat"><i class="fa-solid fa-pen"></i> Ubah Alamat</button>
        </div>
      </div>

      

      <!-- Pilihan Opsi Pengiriman -->
      <h3 class="shipping-section-title">Pilih opsi pengiriman</h3>

      <div class="shipping-option-card selected" onclick="selectShipping(this, 18000)">
        <div class="shipping-left">
          <input type="radio" name="shipping" checked>
          <div class="shipping-info">
            <h4>Reguler (J&T Express / SiCepat) <span class="badge-rekomendasi">Rekomendasi</span></h4>
            <p>Estimasi tiba dalam 2 - 3 hari kerja</p>
          </div>
        </div>
        <div class="shipping-price">Rp 18.000</div>
      </div>

      <div class="shipping-option-card" onclick="selectShipping(this, 12000)">
        <div class="shipping-left">
          <input type="radio" name="shipping">
          <div class="shipping-info">
            <h4>Kargo Hemat (J&T Cargo)</h4>
            <p>Estimasi tiba 4 - 6 hari kerja</p>
          </div>
        </div>
        <div class="shipping-price">Rp 12.000</div>
      </div>

      <!-- Navigasi Bawah -->
      <div class="checkout-nav-bottom">
        <a href="{{ route('keranjang') }}" class="btn-back-link">
          <i class="fa-solid fa-arrow-left"></i> Kembali ke Keranjang
        </a>
        <button type="button" class="btn-submit-checkout" onclick="window.location.href='{{ route('pembayaran') }}'">
          Lanjutkan ke Pembayaran <i class="fa-solid fa-arrow-right"></i>
        </button>
      </div>
    </main>

    <!-- SISI KANAN: RINGKASAN PESANAN -->
    <aside>
      <div class="summary-header">
        <h2>Ringkasan Pesanan</h2>
        <span class="summary-badge" id="summaryItemCountBadge">2 Busana</span>
      </div>

      <div class="summary-item-card">
        <img src="https://images.unsplash.com/photo-1598554747436-c9293d6a588f?w=100" alt="Kemeja Linen" class="summary-item-img">
        <div class="summary-item-details" style="flex: 1;">
          <h4>Kemeja Linen Relaxed Fit</h4>
          <p>Off-White • Size L • 1x</p>
          <div class="summary-item-price">Rp 349.000</div>
        </div>
      </div>

      <div class="summary-item-card">
        <img src="https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=100" alt="Kaos Supima" class="summary-item-img">
        <div class="summary-item-details" style="flex: 1;">
          <h4>Kaos Supima Basic Navy</h4>
          <p>Midnight Blue • Size M • 1x</p>
          <div class="summary-item-price">Rp 198.000</div>
        </div>
      </div>

      <div class="voucher-applied-box">
        <span><i class="fa-solid fa-ticket"></i> Voucher "ELEGANT50K" Terpasang</span>
      </div>

      <div class="price-row">
        <span>Subtotal Produk</span>
        <span id="subtotalDisplay">Rp 547.000</span>
      </div>
      <div class="price-row discount">
        <span>Diskon Voucher Belanja</span>
        <span>-Rp 50.000</span>
      </div>
      <div class="price-row">
        <span>Biaya Pengiriman</span>
        <span id="shippingFeeDisplay">Rp 18.000</span>
      </div>
      <div class="price-row free-ship">
        <span>Biaya Layanan & Asuransi</span>
        <span>GRATIS</span>
      </div>

      <hr class="divider-line">

      <div class="total-row">
        <span class="total-label">Total Tagihan</span>
        <span class="total-amount" id="grandTotalDisplay">Rp 515.000</span>
      </div>
      <div class="tax-note">Termasuk PPN 11% dan perlindungan transit</div>
    </aside>

  </div>

  <!-- MODAL 1: UBAH ALAMAT -->
  <div class="modal-overlay" id="modalUbahAlamat">
    <div class="modal-card">
      <div class="modal-header">
        <h3>Ubah Alamat Pengiriman</h3>
        <button class="modal-close" id="closeUbahModal"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="form-grid">
        <div class="form-group">
          <label>Nama Penerima</label>
          <input type="text" id="editName" class="form-control">
        </div>
        <div class="form-group">
          <label>Nomor Handphone</label>
          <input type="text" id="editPhone" class="form-control">
        </div>
        <div class="form-group full">
          <label>Alamat Lengkap</label>
          <input type="text" id="editStreet" class="form-control">
        </div>
        <div class="form-group full">
          <label>Catatan Pengirim</label>
          <input type="text" id="editNote" class="form-control">
        </div>
      </div>
      <button type="button" class="btn-save-address" id="btnSaveEditAddress" style="margin-top: 10px; width: 100%;">Simpan Perubahan</button>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/diantar.js') }}"></script>
@endpush