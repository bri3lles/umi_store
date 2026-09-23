@extends('layouts.app')

@section('title', 'Beranda - UMI STORE')

@section('content')
  <!-- Hero Section Banner -->
  <main class="hero-main">
    <div class="container">
      <div class="hero-grid">

        <!-- Kolom Kiri: Teks & Informasi -->
        <div class="hero-copy">
          <h1 class="hero-title">Sentuhan Kemewahan untuk Momen Istimewa</h1>

          <p class="hero-desc">
            Paduan sempurna material katun sutra bernafas dan linen alami bermutu tinggi. Dirancang presisi untuk busana wanita dan pria yang mendambakan kenyamanan sejati dan keanggunan modern sepanjang hari.
          </p>

          <div class="hero-buttons">
            <a class="btn-primary" href="#katalog">
              <span>Beli Koleksi Terbaru</span>
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" viewBox="0 0 24 24">
                <line x1="5" x2="19" y1="12" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>

            <a class="btn-secondary" href="#kategori">
              <span>Lihat Kategori</span>
            </a>
          </div>

          <div class="hero-stats">
            <div>
              <div class="stat-value">15.000+</div>
              <div class="stat-label">Pelanggan Puas</div>
            </div>
            <div>
              <div class="stat-value">100%</div>
              <div class="stat-label">Serat Alami</div>
            </div>
            <div>
              <div class="stat-value">4.9 / 5.0</div>
              <div class="stat-label">Rating Butik</div>
            </div>
          </div>
        </div>

        <!-- Kolom Kanan: Display Banner Gambar -->
        <div class="hero-image-wrapper">
          <img src="{{ asset('images/bghero.jpg') }}" alt="Hero image" class="hero-image">
        </div>

      </div>
    </div>
  </main>

  <!-- Section Kategori Populer -->
<section class="section category-section" id="kategori">
  <div class="container">
    
    <!-- Header & Tombol Navigasi Slider -->
    <div class="category-header-wrapper">
      <div class="section-header">
        <h2 class="section-title">Kategori</h2>
      </div>
    </div>

    <!-- Category Slider -->
    <div class="category-slider" id="categorySlider">

      <!-- 1. Kaos -->
      <a href="{{ route('katalog') }}?category=kaos" class="category-card">
        <div class="category-icon-box">
          <img src="{{ asset('images/icon-kaos.png') }}" alt="Kaos" class="category-icon-img">
        </div>
        <p>Kaos</p>
      </a>

      <!-- 2. Kemeja -->
      <a href="{{ route('katalog') }}?category=kemeja" class="category-card">
        <div class="category-icon-box">
          <img src="{{ asset('images/icon-kemeja.png') }}" alt="Kemeja" class="category-icon-img">
        </div>
        <p>Kemeja</p>
      </a>

      <!-- 3. Celana -->
      <a href="{{ route('katalog') }}?category=celana" class="category-card">
        <div class="category-icon-box">
          <img src="{{ asset('images/icon-celana.png') }}" alt="Celana" class="category-icon-img">
        </div>
        <p>Celana</p>
      </a>

      <!-- 4. Rok -->
      <a href="{{ route('katalog') }}?category=rok" class="category-card">
        <div class="category-icon-box">
          <img src="{{ asset('images/icon-rok.png') }}" alt="Rok" class="category-icon-img">
        </div>
        <p>Rok</p>
      </a>

      <!-- 5. Dress -->
      <a href="{{ route('katalog') }}?category=dress" class="category-card">
        <div class="category-icon-box">
          <img src="{{ asset('images/icon-dress.png') }}" alt="Dress" class="category-icon-img">
        </div>
        <p>Dress</p>
      </a>

      <!-- 6. Sweater -->
      <a href="{{ route('katalog') }}?category=sweater" class="category-card">
        <div class="category-icon-box">
          <img src="{{ asset('images/icon-sweater.png') }}" alt="Sweater" class="category-icon-img">
        </div>
        <p>Sweater</p>
      </a>

      <!-- 7. Pakaian Muslim -->
      <a href="{{ route('katalog') }}?category=hoodie" class="category-card">
        <div class="category-icon-box">
          <img src="{{ asset('images/icon-hoodie.png') }}" alt="Hoodie" class="category-icon-img">
        </div>
        <p>Hoodie</p>
      </a>

    </div>
  </div>
</section>

  <!-- Produk Unggulan Section -->
  <section class="section" id="katalog">
    <div class="container">
      <h2 class="section-title">Koleksi Terpopuler</h2>

      <div class="product-grid">
        <!-- Card Produk 1 -->
        <div class="product-card">
          <div class="product-image-container">
            <img src="https://i.pinimg.com/1200x/5b/34/52/5b3452044a69aa056e6bb0b1c37e3ec3.jpg" alt="Kaos Polos Premium" class="product-image">
            <span class="badge-best">TERLARIS</span>
            <button type="button" class="btn-wishlist" aria-label="Tambah Wishlist">
              <i class="fa-regular fa-heart"></i>
            </button>
          </div>
          <div class="product-info">
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <span class="rating-count">(48)</span>
            </div>
            <h3 class="product-title">Kaos Polos Cotton Combed</h3>
            <p class="product-subtitle">Atasan Pria</p>
            <div class="product-bottom">
              <span class="product-price">Rp 89.000</span>
              <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
        </div>

        <!-- Card Produk 2 -->
        <div class="product-card">
          <div class="product-image-container">
            <img src="https://i.pinimg.com/1200x/10/0f/2f/100f2fa483fb9ee5212ccfee98e4de6c.jpg" alt="Celana Denim Slimfit" class="product-image">
            <button type="button" class="btn-wishlist" aria-label="Tambah Wishlist">
              <i class="fa-regular fa-heart"></i>
            </button>
          </div>
          <div class="product-info">
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-regular fa-star"></i>
              <span class="rating-count">(32)</span>
            </div>
            <h3 class="product-title">Celana Denim</h3>
            <p class="product-subtitle">Celana Wanita</p>
            <div class="product-bottom">
              <span class="product-price">Rp 249.000</span>
              <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
        </div>

        <!-- Card Produk 3 -->
        <div class="product-card">
          <div class="product-image-container">
            <img src="https://i.pinimg.com/736x/58/19/1a/58191a1cc713d7d3ef2cb7b785a6afc8.jpg" alt="Kemeja Linen Oversize" class="product-image">
            <span class="badge-best">BARU</span>
            <button type="button" class="btn-wishlist" aria-label="Tambah Wishlist">
              <i class="fa-regular fa-heart"></i>
            </button>
          </div>
          <div class="product-info">
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <span class="rating-count">(27)</span>
            </div>
            <h3 class="product-title">Kemeja Linen Oversize</h3>
            <p class="product-subtitle">Atasan Wanita</p>
            <div class="product-bottom">
              <span class="product-price">Rp 179.000</span>
              <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
        </div>

        <!-- Card Produk 4 -->
        <div class="product-card">
          <div class="product-image-container">
            <img src="https://i.pinimg.com/736x/70/06/e1/7006e11ad5e6663f5ccd2804a4248e54.jpg" alt="Celana Chino Relaxed Fit" class="product-image">
            <button type="button" class="btn-wishlist" aria-label="Tambah Wishlist">
              <i class="fa-regular fa-heart"></i>
            </button>
          </div>
          <div class="product-info">
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star-half-stroke"></i>
              <span class="rating-count">(53)</span>
            </div>
            <h3 class="product-title">Celana Chino Relaxed Fit</h3>
            <p class="product-subtitle">Celana Pria</p>
            <div class="product-bottom">
              <span class="product-price">Rp 219.000</span>
              <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
        </div>
      </div>
  </section>

  <!-- CTA Register & Shop Section -->
  <section class="cta-section">
    <div class="container">
      <div class="cta-card">
        
        <!-- Hiasan Lingkaran Latar Belakang (Glow Effects) -->
        <div class="cta-glow glow-1"></div>
        <div class="cta-glow glow-2"></div>

        <div class="cta-content">
          
          {{-- KONDISI 1: JIKA PENGUNJUNG BELUM LOGIN (GUEST) --}}
          @guest
            
            <h2 class="cta-title">Bergabung Sekarang Dan Nikmati Promo Spesial</h2>
            <p class="cta-desc">
              Buat akun UMI STORE kamu sekarang! Dapatkan voucher diskon khusus pembelian pertama, akses promo eksklusif, serta kemudahan melacak pesananmu.
            </p>

            <div class="cta-buttons">
              <a href="{{ url('/register') }}" class="btn-cta-primary">
                <i class="fa-solid fa-user-plus"></i>
                <span>Daftar Akun Sekarang</span>
              </a>

              <a href="#katalog" class="btn-cta-secondary">
                <span>Mulai Belanja</span>
                <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>

            <div class="cta-features">
              <div class="feature-item">
                <i class="fa-solid fa-check-circle"></i>
                <span>Pendaftaran Gratis</span>
              </div>
              <div class="feature-item">
                <i class="fa-solid fa-tags"></i>
                <span>Voucher Diskon</span>
              </div>
              <div class="feature-item">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Transaksi Aman</span>
              </div>
            </div>
          @endguest

          {{-- KONDISI 2: JIKA PENGUNJUNG SUDAH LOGIN (MEMBER) --}}
          @auth
            
            <h2 class="cta-title">Siap untuk Menambah Koleksi Busana Anda?</h2>
            <p class="cta-desc">
              Selamat datang kembali! Gunakan penawaran spesial member hari ini dan jelajahi koleksi busana terbaru yang siap melengkapi gaya harianmu.
            </p>

            <div class="cta-buttons">
              <a href="#katalog" class="btn-cta-primary">
                <i class="fa-solid fa-bag-shopping"></i>
                <span>Mulai Belanja Sekarang</span>
              </a>

              <a href="{{ url('profile/pesanan') }}" class="btn-cta-secondary">
                <span>Cek Pesanan Saya</span>
                <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>

            <div class="cta-features">
              <div class="feature-item">
                <i class="fa-solid fa-shield-heart"></i>
                <span>Garansi Kualitas 100%</span>
              </div>
              <div class="feature-item">
                <i class="fa-solid fa-bolt"></i>
                <span>Pengiriman Ekspres</span>
              </div>
              <div class="feature-item">
                <i class="fa-solid fa-headset"></i>
                <span>Dukungan Layanan Member</span>
              </div>
            </div>
          @endauth

        </div>

      </div>
    </div>
  </section>
@endsection