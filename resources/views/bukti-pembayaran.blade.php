<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bukti Pembayaran Berhasil - UMI STORE</title>
  
  <!-- Google Fonts & Material Symbols -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

  <!-- CSS Utama & CSS Halaman -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/bukti-pembayaran.css') }}" />
</head>
<body>

  <!-- Navbar Partials -->
  @include('partials.navbar')

  <!-- Content -->
  <main>
    <div class="success-banner">
      <div class="status-badge">
        <span class="material-symbols-outlined">schedule</span>
        Menunggu Verifikasi Admin
      </div>
      <h1 class="success-title">Bukti Pembayaran Berhasil Diunggah!</h1>
      <p class="success-desc">
        Terima kasih, pembayaran untuk pesanan <strong>#UMI-20250520-1405</strong> sedang divalidasi oleh tim kami (15 – 30 menit).
      </p>
    </div>

    <!-- Layout Utama Berbentuk Single Receipt Card yang Luas & Rapi -->
    <div class="receipt-card">
      
      <div class="receipt-grid">
        <!-- Kolom Kiri: Rincian Pembayaran & Bukti File -->
        <div>
          <div class="section-title">
            <span class="material-symbols-outlined" style="font-size: 20px;">receipt_long</span>
            Rincian Pembayaran
          </div>

          <div class="info-row">
            <span class="info-label">Nomor Pesanan</span>
            <span class="info-value">#UMI-20250520-1405</span>
          </div>
          <div class="info-row">
            <span class="info-label">Waktu Unggah</span>
            <span class="info-value">21 Mei 2025, 14:20</span>
          </div>
          <div class="info-row">
            <span class="info-label">Rekening Tujuan</span>
            <span class="info-value">BCA • 8290123456</span>
          </div>

          <div class="total-box">
            <span class="info-label" style="font-weight:600">Total Ditransfer</span>
            <span class="total-amount">Rp 515.000</span>
          </div>

          <div style="margin-top: 20px;">
            <p style="font-size:0.75rem; color:var(--text-muted); font-weight:700; letter-spacing: 0.5px; margin-bottom:6px;">BERKAS BUKTI TRANSFER</p>
            <div class="file-box">
              <div class="file-info">
                <span class="material-symbols-outlined" style="color:var(--primary)">image</span>
                <div>
                  <p style="font-size:0.78rem; font-weight:700">bukti_transfer.jpg</p>
                  <p style="font-size:0.68rem; color:var(--text-muted)">1.2 MB • Terenkripsi</p>
                </div>
              </div>
              <button class="btn-view" id="openModalBtn" type="button">
                <span class="material-symbols-outlined" style="font-size:15px">visibility</span>
                Lihat
              </button>
            </div>
          </div>
        </div>

        <!-- Kolom Kanan: Pengiriman & Ringkasan Produk -->
        <div>
          <div class="section-title">
            <span class="material-symbols-outlined" style="font-size: 20px;">local_shipping</span>
            Pengiriman & Item
          </div>

          <div class="address-box">
            <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
              <strong>Dimas Satria</strong>
              <span style="color:var(--text-muted); font-size:0.8rem">+62 812-3456</span>
            </div>
            <p style="color:var(--text-muted); line-height:1.4; font-size:0.8rem;">
              Jl. Pemuda No. 45, Genteng, Kota Surabaya
            </p>
          </div>

          <div class="item-row">
            <div class="item-img"><span class="material-symbols-outlined" style="font-size: 20px;">checkroom</span></div>
            <div class="item-details">
              <div class="item-title">Kemeja Oxford Pria Classic Fit</div>
              <div class="item-meta">Broken White, L • 1x</div>
            </div>
            <div class="item-price">Rp 349.000</div>
          </div>

          <div class="item-row">
            <div class="item-img"><span class="material-symbols-outlined" style="font-size: 20px;">apparel</span></div>
            <div class="item-details">
              <div class="item-title">Kaos Polos Katun Pima Signature</div>
              <div class="item-meta">Navy Blue, L • 1x</div>
            </div>
            <div class="item-price">Rp 198.000</div>
          </div>
        </div>
      </div>

      <hr class="section-divider" />

      <!-- Rincian Biaya Bawah (Full Width di dalam Card) -->
      <div style="max-width: 400px; margin-left: auto;">
        <div class="info-row" style="padding:4px 0">
          <span class="info-label">Subtotal Produk</span>
          <span style="font-weight: 500;">Rp 547.000</span>
        </div>
        <div class="info-row" style="padding:4px 0">
          <span class="info-label">Diskon Voucher</span>
          <span style="color:var(--accent-red); font-weight: 500;">-Rp 50.000</span>
        </div>
        <div class="info-row" style="padding:4px 0">
          <span class="info-label">Biaya Pengiriman</span>
          <span style="font-weight: 500;">Rp 18.000</span>
        </div>
        <div class="info-row" style="padding:4px 0">
          <span class="info-label">Kode Unik</span>
          <span style="font-weight: 500;">+Rp 245</span>
        </div>
      </div>

    </div>

    <!-- Bottom Button -->
    <div class="action-container">
      <button class="btn-action" type="button" onclick="goToHistory()">
        <span class="material-symbols-outlined">format_list_bulleted</span>
        Lihat Status di Riwayat Pesanan
      </button>
    </div>
  </main>

  <!-- Modal Preview -->
  <div class="modal" id="previewModal">
    <div class="modal-content">
      <h3>Bukti Transfer Terunggah</h3>
      <img src="https://via.placeholder.com/300x400?text=Bukti+Transfer+Dimas" alt="Bukti Transfer" class="modal-img" />
      <button class="btn-close" id="closeModalBtn" type="button">Tutup</button>
    </div>
  </div>

  <!-- Footer Partials -->
  @include('partials.footer')

  <!-- JavaScript Eksternal -->
  <script src="{{ asset('js/bukti-pembayaran.js') }}"></script>
</body>
</html>