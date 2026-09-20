@extends('layouts.app')

@section('title', 'Katalog Produk - UMI STORE')

{{-- Memanggil CSS Khusus Halaman Katalog --}}
@push('styles')
  <link rel="stylesheet" href="{{ asset('css/katalog.css') }}">
@endpush

@section('content')
  <!-- Hero Section Katalog -->
  <section class="katalog-hero">
    <div class="container">
      <div class="katalog-hero-content">
        <span class="hero-badge">KOLEKSI EKSKLUSIF</span>
        <h1 class="katalog-hero-title">Temukan Koleksi <span>Terbaik Anda</span></h1>
        <p class="katalog-hero-desc">
          Jelajahi pilihan busana berkualitas tinggi mulai dari atasan, bawahan, hingga setelan elegan untuk menyempurnakan gaya harianmu.
        </p>

        <!-- Form Pencarian -->
        <form action="#" method="GET" class="search-box-wrapper" onsubmit="event.preventDefault();">
          <div class="search-input-group">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" id="searchInput" placeholder="Cari baju, celana, dress, outerwear..." autocomplete="off">
            <button type="submit" class="btn-search">Cari</button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Section Main Katalog -->
  <section class="section katalog-main-section">
    <div class="container">

      <!-- Filter Bar -->
      <div class="katalog-filter-bar">
        <div class="category-pills" id="categoryPills">
            <button class="pill-btn active" data-category="all">Semua Produk</button>
            <button class="pill-btn" data-category="atasan">Atasan</button>
            <button class="pill-btn" data-category="bawahan">Bawahan</button>
            <button class="pill-btn" data-category="dress">Dress</button>
            <button class="pill-btn" data-category="outerwear">Outerwear</button>
            <button class="pill-btn" data-category="muslim">Pakaian Muslim</button>
            <button class="pill-btn" data-category="setelan">Setelan</button>
        </div>

        <div class="katalog-sort">
          <select class="sort-select" id="sortSelect">
            <option value="featured">Urutkan: Unggulan</option>
            <option value="lowest">Harga: Terendah</option>
            <option value="highest">Harga: Tertinggi</option>
            <option value="newest">Terbaru</option>
          </select>
        </div>
      </div>

      <!-- Grid Produk -->
      <div class="product-grid" id="katalogGrid">
        
        <!-- 1. Bawahan -->
        <div class="product-card" data-category="bawahan">
          <div class="product-image-container">
            <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&q=80&w=600" alt="Celana Kulot Palma Tailored" class="product-image">
            <span class="badge-best">TERLARIS</span>
            <button type="button" class="btn-wishlist" aria-label="Tambah Wishlist"><i class="fa-regular fa-heart"></i></button>
          </div>
          <div class="product-info">
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <span class="rating-count">(98)</span>
            </div>
            <h3 class="product-title">Celana Kulot Palma Tailored</h3>
            <p class="product-subtitle">Navy Classic Crepe</p>
            <div class="product-bottom">
              <span class="product-price">Rp 479.000</span>
              <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
        </div>

        <!-- 2. Atasan -->
        <div class="product-card" data-category="atasan">
          <div class="product-image-container">
            <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&q=80&w=600" alt="Kemeja Linen Oversize" class="product-image">
            <span class="badge-best">BARU</span>
            <button type="button" class="btn-wishlist" aria-label="Tambah Wishlist"><i class="fa-regular fa-heart"></i></button>
          </div>
          <div class="product-info">
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <span class="rating-count">(45)</span>
            </div>
            <h3 class="product-title">Kemeja Linen Oversize White</h3>
            <p class="product-subtitle">Premium Linen Cotton</p>
            <div class="product-bottom">
              <span class="product-price">Rp 179.000</span>
              <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
        </div>

        <!-- 3. Outerwear -->
        <div class="product-card" data-category="outerwear">
          <div class="product-image-container">
            <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&q=80&w=600" alt="Blazer Casual Minimalis" class="product-image">
            <button type="button" class="btn-wishlist" aria-label="Tambah Wishlist"><i class="fa-regular fa-heart"></i></button>
          </div>
          <div class="product-info">
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star-half-stroke"></i>
              <span class="rating-count">(62)</span>
            </div>
            <h3 class="product-title">Blazer Casual Minimalis</h3>
            <p class="product-subtitle">Outerwear Formal</p>
            <div class="product-bottom">
              <span class="product-price">Rp 389.000</span>
              <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
        </div>

        <!-- 4. Dress -->
        <div class="product-card" data-category="dress">
          <div class="product-image-container">
            <img src="https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&q=80&w=600" alt="Midi Dress Silk Touch" class="product-image">
            <button type="button" class="btn-wishlist" aria-label="Tambah Wishlist"><i class="fa-regular fa-heart"></i></button>
          </div>
          <div class="product-info">
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <span class="rating-count">(29)</span>
            </div>
            <h3 class="product-title">Midi Dress Silk Touch</h3>
            <p class="product-subtitle">Soft Chiffon Material</p>
            <div class="product-bottom">
              <span class="product-price">Rp 299.000</span>
              <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
        </div>

        <!-- 5. Setelan -->
        <div class="product-card" data-category="setelan">
          <div class="product-image-container">
            <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&q=80&w=600" alt="Setelan Knit Two-Piece" class="product-image">
            <span class="badge-best">TERLARIS</span>
            <button type="button" class="btn-wishlist" aria-label="Tambah Wishlist"><i class="fa-regular fa-heart"></i></button>
          </div>
          <div class="product-info">
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <span class="rating-count">(112)</span>
            </div>
            <h3 class="product-title">Setelan Knit Two-Piece</h3>
            <p class="product-subtitle">Atasan + Bawahan Knit</p>
            <div class="product-bottom">
              <span class="product-price">Rp 349.000</span>
              <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
        </div>

        <!-- 6. Pakaian Muslim -->
        <div class="product-card" data-category="muslim">
          <div class="product-image-container">
            <img src="https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?auto=format&fit=crop&q=80&w=600" alt="Gamis Elegance Flowy" class="product-image">
            <button type="button" class="btn-wishlist" aria-label="Tambah Wishlist"><i class="fa-regular fa-heart"></i></button>
          </div>
          <div class="product-info">
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star-half-stroke"></i>
              <span class="rating-count">(78)</span>
            </div>
            <h3 class="product-title">Gamis Elegance Flowy</h3>
            <p class="product-subtitle">Pakaian Muslimah</p>
            <div class="product-bottom">
              <span class="product-price">Rp 329.000</span>
              <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
        </div>

        <!-- 7. Outerwear 2 -->
        <div class="product-card" data-category="outerwear">
          <div class="product-image-container">
            <img src="https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&q=80&w=600" alt="Cardigan Knit Premium" class="product-image">
            <button type="button" class="btn-wishlist" aria-label="Tambah Wishlist"><i class="fa-regular fa-heart"></i></button>
          </div>
          <div class="product-info">
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <span class="rating-count">(53)</span>
            </div>
            <h3 class="product-title">Cardigan Knit Premium</h3>
            <p class="product-subtitle">Soft Knit Material</p>
            <div class="product-bottom">
              <span class="product-price">Rp 219.000</span>
              <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
        </div>

        <!-- 8. Atasan 2 -->
        <div class="product-card" data-category="atasan">
          <div class="product-image-container">
            <img src="https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?auto=format&fit=crop&q=80&w=600" alt="Blouse Satin Elegant" class="product-image">
            <span class="badge-best">BARU</span>
            <button type="button" class="btn-wishlist" aria-label="Tambah Wishlist"><i class="fa-regular fa-heart"></i></button>
          </div>
          <div class="product-info">
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star-half-stroke"></i>
              <span class="rating-count">(18)</span>
            </div>
            <h3 class="product-title">Blouse Satin Elegant</h3>
            <p class="product-subtitle">Silk Matte Cream</p>
            <div class="product-bottom">
              <span class="product-price">Rp 259.000</span>
              <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
        </div>

        <!-- 9. Dress 2 -->
        <div class="product-card" data-category="dress">
          <div class="product-image-container">
            <img src="https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&q=80&w=600" alt="Floral Summer Maxi Dress" class="product-image">
            <button type="button" class="btn-wishlist" aria-label="Tambah Wishlist"><i class="fa-regular fa-heart"></i></button>
          </div>
          <div class="product-info">
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <span class="rating-count">(87)</span>
            </div>
            <h3 class="product-title">Floral Summer Maxi Dress</h3>
            <p class="product-subtitle">Lightweight Rayon</p>
            <div class="product-bottom">
              <span class="product-price">Rp 319.000</span>
              <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>
@endsection

{{-- Memanggil JS Khusus Halaman Katalog --}}
@push('scripts')
  <script src="{{ asset('js/katalog.js') }}"></script>
@endpush