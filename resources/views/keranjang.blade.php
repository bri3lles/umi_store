<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang Belanja - UMI STORE</title>
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Hubungkan CSS Utama & CSS Khusus Keranjang -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/keranjang.css') }}">
</head>
<body>

  <!-- ================= NAVBAR ================= -->
  @include('partials.navbar')

  <!-- ================= KONTEN UTAMA KERANJANG ================= -->
  <main>
    <div class="cart-layout">
      
      <!-- SISI KIRI: DAFTAR PRODUK -->
      <div class="cart-items-section">
        <div class="cart-header-row">
          <h1 class="page-main-title">Keranjang Belanja Saya</h1>
          <span class="item-count-badge-text">(3 Item)</span>
        </div>

        <!-- Bar Pilih Semua -->
<div class="select-all-box">
  <div class="checkbox-wrapper">
    <input type="checkbox" id="selectAll" checked>
    <label for="selectAll">Pilih Semua (<span id="selectAllCount">3</span> Item)</label>
  </div>
  <button type="button" class="btn-delete-selected"><i class="fa-regular fa-trash-can"></i> Hapus Terpilih</button>
</div>

        <!-- Item 1 -->
        <div class="cart-item-card">
          <div class="cart-item-checkbox">
            <input type="checkbox" checked class="item-checkbox">
          </div>
          <img src="https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?auto=format&fit=crop&w=150&q=80" alt="Produk 1">
          <div class="cart-item-details">
            <div class="cart-item-title">Kemeja Katun Oxford Slim Fit - Putih</div>
            <div class="cart-item-meta-row">
              <span class="meta-badge">Ukuran: M</span>
              <span class="meta-color"><span class="dot-color" style="background:#fff; border:1px solid #cbd5e1;"></span> Putih</span>
            </div>
            <div class="cart-item-unit-price">Rp 249.000 / pcs</div>
          </div>
          <div class="cart-item-right-content">
            <div class="cart-item-total-price">Rp 249.000</div>
            <div class="cart-item-actions-row">
              <button type="button" class="btn-delete" title="Hapus"><i class="fa-regular fa-trash-can"></i></button>
              <div class="qty-control">
                <button type="button" class="qty-btn">−</button>
                <span class="qty-number">1</span>
                <button type="button" class="qty-btn">+</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Item 2 -->
        <div class="cart-item-card">
          <div class="cart-item-checkbox">
            <input type="checkbox" checked class="item-checkbox">
          </div>
          <img src="https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=150&q=80" alt="Produk 2">
          <div class="cart-item-details">
            <div class="cart-item-title">Kaos Polos Katun Pima Premium - Navy</div>
            <div class="cart-item-meta-row">
              <span class="meta-badge">Ukuran: L</span>
              <span class="meta-color"><span class="dot-color" style="background:#1e3a8a;"></span> Navy</span>
            </div>
            <div class="cart-item-unit-price">Rp 149.000 / pcs</div>
          </div>
          <div class="cart-item-right-content">
            <div class="cart-item-total-price">Rp 298.000</div>
            <div class="cart-item-actions-row">
              <button type="button" class="btn-delete" title="Hapus"><i class="fa-regular fa-trash-can"></i></button>
              <div class="qty-control">
                <button type="button" class="qty-btn">−</button>
                <span class="qty-number">2</span>
                <button type="button" class="qty-btn">+</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Item 3 (Stok Habis) -->
        <div class="cart-item-card out-of-stock">
          <div class="cart-item-checkbox">
            <input type="checkbox" disabled>
          </div>
          <div class="img-container-out">
            <img src="https://images.unsplash.com/photo-1479064555552-3ef4979f8908?auto=format&fit=crop&w=150&q=80" alt="Produk 3">
            <span class="badge-out-stock">STOK HABIS</span>
          </div>
          <div class="cart-item-details">
            <div class="cart-item-title" style="color: var(--text-muted);">Celana Chino Tapered Fit - Khaki</div>
            <div class="cart-item-meta-row">
              <span class="meta-badge">Ukuran: 32</span>
              <span class="meta-color">Khaki</span>
            </div>
            <div class="out-warning"><i class="fa-solid fa-circle-exclamation"></i> Produk ini sedang tidak tersedia</div>
          </div>
          <div class="cart-item-right-content">
            <button type="button" class="btn-wishlist"><i class="fa-regular fa-heart"></i> Pindahkan ke Wishlist</button>
            <button type="button" class="btn-delete" title="Hapus"><i class="fa-regular fa-trash-can"></i></button>
          </div>
        </div>

      </div>

      <!-- SISI KANAN: RINGKASAN PESANAN -->
      <aside>
        <div class="card summary-card">
          <div class="summary-header-row">
            <h2>Ringkasan Pesanan</h2>
            <span class="summary-item-badge">2 Item</span>
          </div>

          <div class="price-row">
            <span>Subtotal Produk (2 item terpilih)</span>
            <span style="font-weight: 600; color: var(--text-main);">Rp 547.000</span>
          </div>
          <div class="price-row">
            <span>Estimasi Pajak & Biaya <i class="fa-regular fa-circle-question"></i></span>
            <span style="font-weight: 600; color: var(--text-main);">Termasuk</span>
          </div>

          <div class="total-row">
            <div>
              <div class="total-label">TOTAL TAGIHAN</div>
              <div class="total-price">Rp 497.000</div>
              <div class="total-tax-note">Termasuk semua pajak</div>
            </div>
          </div>

          <!-- Tombol Lanjut ke Pembayaran Memunculkan Pop-up -->
          <button type="button" class="btn-next" id="btnOpenPopup">
            Lanjut ke Pembayaran 
            <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </button>

          <div class="security-benefits">
            <div class="benefit-item"><i class="fa-solid fa-shield-halved"></i> 100% Pembayaran Aman & Terenkripsi</div>
            <div class="benefit-item"><i class="fa-solid fa-rotate-left"></i> Jaminan Garansi Retur 7 Hari Bebas Repot</div>
            <div class="benefit-item"><i class="fa-solid fa-truck-fast"></i> Pengiriman Cepat Kurir Terpercaya</div>
          </div>

          <div class="payment-logos-text">
            <span>BCA</span> • <span>Mandiri</span> • <span>QRIS</span> • <span>GoPay / OVO</span>
          </div>
        </div>
      </aside>

    </div>
  </main>

  <!-- ================= POP-UP METODE PENGIRIMAN ================= -->
  <div class="modal-overlay" id="shippingModal">
    <div class="modal-card">
      <h3 class="modal-title">Pilih Metode Pengiriman</h3>
      
      <div class="modal-options-stack">
        <!-- Opsi 1: Dikirim ke Alamat -->
        <label class="modal-option-card selected" id="modalOptDiantar">
          <div class="modal-opt-left">
            <input type="radio" name="shipping_method" value="diantar" checked>
            <div>
              <div class="modal-opt-header-row">
                <span class="modal-opt-title"><i class="fa-solid fa-truck"></i> Dikirim ke Alamat</span>
                <span class="badge-rek">Rekomendasi</span>
              </div>
              <p class="modal-opt-desc">Estimasi tiba dalam 2-4 hari kerja menggunakan jaringan ekspedisi terpercaya (JNE, SiCepat, atau J&T Express).</p>
              <div class="modal-opt-footer-info">
                <span><i class="fa-solid fa-tag"></i> Tarif mulai <strong>Rp 15.000</strong></span>
                <span><i class="fa-solid fa-location-dot"></i> Seluruh Indonesia</span>
              </div>
            </div>
          </div>
        </label>

        <!-- Opsi 2: Ambil di Toko -->
        <label class="modal-option-card" id="modalOptAmbil">
          <div class="modal-opt-left">
            <input type="radio" name="shipping_method" value="ambil">
            <div>
              <div class="modal-opt-header-row">
                <span class="modal-opt-title"><i class="fa-solid fa-store"></i> Ambil di Toko</span>
                <span class="badge-free">Bebas Ongkir</span>
              </div>
              <p class="modal-opt-desc">Ambil langsung di butik Umi Store tanpa biaya pengiriman tambahan. Siap diambil dalam 2 jam operasional toko setelah order terverifikasi.</p>
              <div class="modal-opt-footer-info">
                <span><i class="fa-regular fa-clock"></i> Siap dalam 2 Jam</span>
                <span><i class="fa-solid fa-shield"></i> Biaya Rp 0 (Gratis)</span>
              </div>
            </div>
          </div>
        </label>
      </div>

      <div class="modal-bottom-actions">
        <button type="button" class="modal-btn-back" id="btnCloseModal">
          <i class="fa-solid fa-arrow-left"></i> Kembali ke Keranjang
        </button>
        <button type="button" class="modal-btn-submit" id="btnSubmitShipping">
          Lanjutkan <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </button>
      </div>
    </div>
  </div>

  <!-- ================= MODAL KONFIRMASI HAPUS ================= -->
<div class="modal-overlay" id="deleteConfirmModal">
  <div class="modal-card" style="max-width: 450px; text-align: center;">
    <div style="font-size: 40px; color: var(--accent-red); margin-bottom: 15px;">
      <i class="fa-solid fa-triangle-exclamation"></i>
    </div>
    <h3 class="modal-title" style="font-size: 18px; margin-bottom: 10px;">Hapus Produk dari Keranjang?</h3>
    <p class="modal-opt-desc" style="margin-bottom: 24px;">Produk yang dipilih akan dihapus dari daftar keranjang belanja Anda.</p>
    
    <div class="modal-bottom-actions" style="justify-content: center; gap: 15px;">
      <button type="button" class="modal-btn-back" id="btnCloseDeleteModal" style="border: 1px solid var(--border); padding: 10px 20px; border-radius: 30px;">
        Batal
      </button>
      <button type="button" class="modal-btn-submit" id="btnConfirmDelete" style="background: var(--accent-red);">
        Ya, Hapus
      </button>
    </div>
  </div>
</div>

  <!-- ================= FOOTER ================= -->
  @include('partials.footer')

  <!-- JavaScript Eksternal -->
  <script>
    // Menyediakan route Laravel secara aman ke JS
    window.routeDiantar = "{{ route('diantar') }}";
    window.routePembayaran = "{{ route('pembayaran') }}";
  </script>
  <script src="{{ asset('js/keranjang.js') }}"></script>
</body>
</html>