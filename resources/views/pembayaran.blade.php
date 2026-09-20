<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran - UMI STORE</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pembayaran.css') }}">
</head>
<body>

  @include('partials.navbar')

  <main>
    <div class="payment-header-flex">
      <h1 class="page-main-title">Pembayaran Pesanan</h1>
    </div>

    <div class="payment-layout">
      
      <!-- SISI KIRI: METODE PEMBAYARAN & UPLOAD BUKTI -->
      <div class="payment-left-section">
        
        <div class="card-section">
          <div class="section-top-label">METODE TERSEDIA</div>
          <h2 class="section-heading">Pilih Cara Pembayaran</h2>

          <div class="payment-tabs">
            <button type="button" class="pay-tab-btn active" data-tab="transfer">
              <i class="fa-solid fa-building-columns"></i> Transfer Bank
            </button>
            <button type="button" class="pay-tab-btn" data-tab="qris">
              <i class="fa-solid fa-qrcode"></i> QRIS Instan
            </button>
            <button type="button" class="pay-tab-btn" data-tab="ewallet">
              <i class="fa-solid fa-wallet"></i> E-Wallet
            </button>
          </div>

          <div class="tab-content active" id="content-transfer">
            <div class="bank-card-box">
              <div class="bank-card-header">
                <div class="bank-name-badge">
                  <span class="bank-code">BCA</span>
                  <div>
                    <div class="bank-title">Bank Central Asia (BCA)</div>
                    <div class="bank-subtitle">Transfer Manual / Mobile Banking</div>
                  </div>
                </div>
                <span class="badge-verif">Verifikasi Cepat</span>
              </div>

              <div class="rek-box">
                <div>
                  <div class="rek-label">Nomor Rekening Tujuan</div>
                  <div class="rek-number" id="rekNumberText">8290-1234-5678</div>
                  <div class="rek-holder">Atas Nama: <strong>PT Umi Busana Indonesia</strong></div>
                </div>
                <button type="button" class="btn-copy-rek" id="btnCopyRek" title="Salin Nomor Rekening">
                  <i class="fa-regular fa-copy"></i>
                </button>
              </div>

              <div class="instruction-box">
                <div class="inst-title">PETUNJUK SINGKAT:</div>
                <ul>
                  <li>Gunakan ATM BCA, KlikBCA, atau BCA Mobile untuk transfer.</li>
                  <li>Pastikan memasukkan jumlah persis <strong>Rp 515.245</strong> hingga 3 angka terakhir.</li>
                  <li>Simpan tangkapan layar atau foto bukti transfer resmi Anda.</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="tab-content" id="content-qris">
            <div class="qris-box-dummy">
              <i class="fa-solid fa-qrcode" style="font-size: 54px; color: var(--primary); margin-bottom: 12px;"></i>
              <h3 style="color: var(--primary);">Scan QRIS untuk Pembayaran Instan</h3>
              <p style="font-size: 13px; color: var(--text-muted); margin-top: 6px;">Buka aplikasi e-wallet atau mobile banking Anda lalu scan kode QR.</p>
            </div>
          </div>

          <div class="tab-content" id="content-ewallet">
            <div class="ewallet-box-dummy">
              <h3 style="color: var(--primary);">Pilih Akun E-Wallet</h3>
              <div class="ewallet-options">
                <div class="ewallet-item">GoPay</div>
                <div class="ewallet-item">OVO</div>
                <div class="ewallet-item">DANA</div>
                <div class="ewallet-item">ShopeePay</div>
              </div>
            </div>
          </div>

        </div>

        <!-- Unggah Bukti Transfer -->
        <div class="card-section upload-section-card">
          <div class="upload-header-row">
            <div>
              <h2 class="section-heading" style="margin-bottom: 2px;">Unggah Bukti Transfer</h2>
              <p class="section-sub">Konfirmasikan pembayaran dengan mengunggah slip transaksi</p>
            </div>
            <span class="badge-max-time"><i class="fa-regular fa-clock"></i> Maks. 5 Jam</span>
          </div>

          <div class="dropzone-area" id="dropzoneArea">
            <div class="dropzone-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
            <div class="dropzone-text">
              <strong>Tarik & lepas berkas bukti transfer ke sini</strong>
              <span>atau <a href="#" id="browseFileLink">pilih dari perangkat</a></span>
            </div>
            <div class="dropzone-info">Mendukung format JPG, PNG, atau PDF (Maksimal 5MB)</div>
            <input type="file" id="fileInput" accept=".jpg, .jpeg, .png, .pdf" style="display: none;">
          </div>

          <div class="uploaded-file-item" id="uploadedFileItem">
            <div class="file-info-left">
              <i class="fa-regular fa-file-lines file-icon"></i>
              <div>
                <div class="file-name" id="fileNameText">bukti_transfer_dimas.jpg</div>
                <div class="file-meta"><span id="fileSizeText">1.2 MB</span> • <i class="fa-solid fa-check" style="color:var(--primary);"></i> Terunggah</div>
              </div>
            </div>
            <div class="file-actions">
              <button type="button" class="btn-file-action" title="Lihat"><i class="fa-regular fa-eye"></i></button>
              <button type="button" class="btn-file-action delete" id="btnDeleteFile" title="Hapus"><i class="fa-regular fa-trash-can"></i></button>
            </div>
          </div>

          <div class="warning-note-box">
            <i class="fa-solid fa-circle-exclamation"></i> 
            <div>Unggah bukti transfer maksimal 5 jam setelah pesanan dibuat untuk menghindari pembatalan otomatis. Verifikasi manual dilakukan dalam 15-30 menit.</div>
          </div>
        </div>

      </div>

      <!-- SISI KANAN: SIDEBAR (COUNTDOWN + TUJUAN PENGIRIMAN + RINGKASAN) -->
      <aside class="sidebar-right">
        
        <!-- CARD WAKTU (Dipindah ke sini, terpisah di atas tujuan pengiriman) -->
        <div class="countdown-card-side">
          <div class="countdown-side-header">
            <i class="fa-regular fa-clock"></i>
            <span class="countdown-side-title">Batas Waktu Pembayaran</span>
          </div>
          <div class="countdown-side-desc">Selesaikan transfer dan konfirmasi bukti sebelum pesanan dibatalkan otomatis.</div>
          <div class="countdown-timer-side" id="countdownTimer">04 : 59 : 45</div>
        </div>

        <!-- CARD UTAMA SUMMARY -->
        <div class="summary-card">
          
          <!-- Tujuan Pengiriman -->
          <div class="summary-block">
            <div class="summary-block-header">
              <span class="block-title">TUJUAN PENGIRIMAN</span>
              <a href="{{ route('diantar') }}" class="edit-alamat-link">Edit Alamat</a>
            </div>
            <div class="address-box-mini">
              <i class="fa-solid fa-location-dot"></i>
              <div>
                <div class="addr-name">Dimas Satria (+62 812-3456-7890)</div>
                <div class="addr-detail">Jl. Pemuda No. 45, Embong Kaliasin, Kec. Genteng, Kota Surabaya, Jawa Timur 60271</div>
                <div class="addr-courier">J&T Express • Reguler (2-3 Hari)</div>
              </div>
            </div>
          </div>

          <!-- Produk Pesanan -->
          <div class="summary-block">
            <div class="summary-block-header">
              <span class="block-title">PRODUK PESANAN (2 BARANG)</span>
            </div>

            <div class="mini-prod-item">
              <img src="https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?auto=format&fit=crop&w=100&q=80" alt="Produk 1">
              <div class="mini-prod-details">
                <div class="mini-prod-title">Kemeja Oxford Pria Classic Fit</div>
                <div class="mini-prod-meta">Warna: Broken White • Ukuran: L</div>
                <div class="mini-prod-qty-price">1x Rp 349.000</div>
              </div>
              <div class="mini-prod-total">Rp 349.000</div>
            </div>

            <div class="mini-prod-item">
              <img src="https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=100&q=80" alt="Produk 2">
              <div class="mini-prod-details">
                <div class="mini-prod-title">Kaos Polos Katun Pima Signature</div>
                <div class="mini-prod-meta">Warna: Navy Blue • Ukuran: L</div>
                <div class="mini-prod-qty-price">1x Rp 198.000</div>
              </div>
              <div class="mini-prod-total">Rp 198.000</div>
            </div>
          </div>

          <!-- Rincian Pembayaran -->
          <div class="summary-block border-top">
            <div class="summary-block-header" style="margin-bottom: 14px;">
              <span class="block-title">RINCIAN PEMBAYARAN</span>
            </div>

            <div class="price-row">
              <span>Subtotal Produk</span>
              <span style="font-weight: 600; color: var(--primary);">Rp 547.000</span>
            </div>
            <div class="price-row discount">
              <span>Diskon Voucher <span class="badge-code-mini">ELEGANT50</span></span>
              <span>- Rp 50.000</span>
            </div>
            <div class="price-row">
              <span>Biaya Pengiriman</span>
              <span style="font-weight: 600; color: var(--primary);">Rp 18.000</span>
            </div>
            <div class="price-row">
              <span>Kode Unik Transaksi</span>
              <span style="font-weight: 600; color: var(--primary);">+ Rp 245</span>
            </div>

            <div class="total-row">
              <div>
                <div class="total-label">Total Tagihan</div>
                <div class="total-price">Rp 515.000</div>
                <div class="total-tax-note">Termasuk PPN 11% dan perlindungan transit</div>
              </div>
            </div>
          </div>

        </div>
      </aside>

    </div>

    <div class="bottom-action-bar">
      <a href="{{ route('diantar') }}" class="btn-back-link">
        <i class="fa-solid fa-arrow-left"></i> Ubah Metode Pengiriman
      </a>
      <a href="{{ route('bukti.pembayaran') }}" class="btn-confirm-pay" id="btnConfirmPayment">
  Selesaikan Pembayaran 
  <svg viewBox="0 0 24 24">
    <line x1="5" y1="12" x2="19" y2="12"></line>
    <polyline points="12 5 19 12 12 19"></polyline>
  </svg>
</a>
    </div>
  </main>

  @include('partials.footer')
  <script src="{{ asset('js/pembayaran.js') }}"></script>
</body>
</html>