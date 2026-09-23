@extends('layouts.app')

@section('title', 'Detail Produk - ' . ($product->name ?? 'Kaos Polos Cotton Combed'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/detail-produk.css') }}">
@endpush

@section('content')
<div class="shop-container">

    {{-- Top Section: Showcase & Main Info --}}
    <section class="product-main-grid">
        
       {{-- GALERI FOTO (KIRI) --}}
       <div class="gallery-wrapper">
           <div class="featured-image-card">
               <img id="mainImage" src="https://i.pinimg.com/1200x/5b/34/52/5b3452044a69aa056e6bb0b1c37e3ec3.jpg" alt="Main View">
           </div>
           
           <div class="thumb-grid">
                <img src="https://i.pinimg.com/1200x/5b/34/52/5b3452044a69aa056e6bb0b1c37e3ec3.jpg" 
                    class="thumb-card active" 
                    onclick="switchImage(this)"> 

               <img src="https://i.pinimg.com/1200x/0f/28/f3/0f28f30ca398ad2522b6252ed6694abb.jpg" 
                    id="thumb-putih"
                    class="thumb-card" 
                    data-color-id="putih"
                    data-color-name="Putih"
                    onclick="switchImage(this)">

               <img src="https://i.pinimg.com/1200x/a0/18/68/a01868ff860ca1bd135010918e357cb3.jpg" 
                    id="thumb-biru-tua"
                    class="thumb-card" 
                    data-color-id="biru-tua"
                    data-color-name="Biru Tua"
                    onclick="switchImage(this)">

               <img src="https://i.pinimg.com/1200x/b0/fb/ed/b0fbed717f158de89f4d907bae72ccac.jpg" 
                    id="thumb-hitam"
                    class="thumb-card" 
                    data-color-id="hitam"
                    data-color-name="Hitam"
                    onclick="switchImage(this)">

                <img src="https://i.pinimg.com/1200x/60/43/5a/60435a6b464bf0eefc74b0c1d4f83c96.jpg" 
                    id="thumb-abu-tua"
                    class="thumb-card" 
                    data-color-id="abu-tua"
                    data-color-name="Abu Tua"
                    onclick="switchImage(this)">
           </div>
       </div>

        {{-- Details Right --}}
        <div class="summary-wrapper">
            <span class="badge-tag">Koleksi Pakaian</span>
            <h1 class="item-title">{{ $product->name ?? 'Kaos Polos Cotton Combed' }}</h1>
            
            <div class="rating-inline">
                <div class="stars">★★★★★</div>
                <span class="score">4.9</span>
                <span class="count">(48 Ulasan)</span>
                <span class="dot">•</span>
                <span class="sold">Terjual 500+ pcs</span>
            </div>

            <div class="price-container">
                <span class="price-active">Rp {{ number_format($product->price ?? 149000, 0, ',', '.') }}</span>
                <span class="price-strike">Rp 199.000</span>
                <span class="price-badge">25% OFF</span>
            </div>

            {{-- VARIAN WARNA --}}
            <div class="variant-box">
                <div class="variant-label">Warna: <span id="colorName">Pilih warna</span></div>
                <div class="chip-group">
                    <button type="button" class="chip-btn has-thumb" data-color-id="putih" data-color-name="Putih" onclick="selectColor(this)">
                        <img src="https://i.pinimg.com/1200x/0f/28/f3/0f28f30ca398ad2522b6252ed6694abb.jpg" class="color-thumb" alt="Putih">
                        <span>Putih</span>
                    </button>
                    <button type="button" class="chip-btn has-thumb" data-color-id="biru-tua" data-color-name="Biru Tua" onclick="selectColor(this)">
                        <img src="https://i.pinimg.com/1200x/a0/18/68/a01868ff860ca1bd135010918e357cb3.jpg" class="color-thumb" alt="Biru Tua">
                        <span>Biru Tua</span>
                    </button>
                    <button type="button" class="chip-btn has-thumb" data-color-id="hitam" data-color-name="Hitam" onclick="selectColor(this)">
                        <img src="https://i.pinimg.com/1200x/b0/fb/ed/b0fbed717f158de89f4d907bae72ccac.jpg" class="color-thumb" alt="Hitam">
                        <span>Hitam</span>
                    </button>
                    <button type="button" class="chip-btn has-thumb" data-color-id="abu-tua" data-color-name="Abu Tua" onclick="selectColor(this)">
                        <img src="https://i.pinimg.com/1200x/60/43/5a/60435a6b464bf0eefc74b0c1d4f83c96.jpg" class="color-thumb" alt="Abu Tua">
                        <span>Abu Tua</span>
                    </button>
                </div>
            </div>

            {{-- Size Selection --}}
            <div class="variant-box">
    <div class="variant-header">
        <span class="variant-label">Ukuran: <strong id="selectedSizeLabel">Pilih ukuran</strong></span>
        <button type="button" class="btn-link-modal" onclick="toggleModal(true)">Panduan Ukuran</button>
    </div>

    <div class="chip-group size-chip-group">
        <button type="button" class="chip-btn" data-size="S" onclick="selectSize(this)">S</button>
        <button type="button" class="chip-btn" data-size="M" onclick="selectSize(this)">M</button>
        <button type="button" class="chip-btn" data-size="L" onclick="selectSize(this)">L</button>
        <button type="button" class="chip-btn" data-size="XL" onclick="selectSize(this)">XL</button>
        <button type="button" class="chip-btn disabled" data-size="XXL" disabled>XXL</button>
    </div>
</div>

            {{-- Actions --}}
            <div class="cart-action-group">
                <div class="stepper">
                    <button type="button" onclick="adjustQty(-1)">-</button>
                    <input type="number" id="quantity" value="1" readonly>
                    <button type="button" onclick="adjustQty(1)">+</button>
                </div>
                <button type="button" class="btn-outline-action" id="btnAddToCart">Masukkan Keranjang</button>
                <button type="button" class="btn-solid-action" id="btnBuyNow">Beli Sekarang</button>
            </div>

        </div>
    </section>

    {{-- Detail & Description --}}
    <section class="description-section">
    <h2 class="section-title">Deskripsi & Detail Produk</h2>
    
    <div class="read-more-wrapper" id="descWrapper">
        <div class="description-content">
            <p class="lead-text">
                Sempurnakan gaya kasual harianmu dengan <strong>Kaos Polos Cotton Combed Premium</strong>. Dirancang khusus menggunakan material katun bermutu tinggi untuk busana yang mendambakan kenyamanan sejati dan keanggunan modern sepanjang hari.
            </p>

            <div class="specs-grid">
                <div class="spec-card">
                    <span class="spec-label">Bahan Utama</span>
                    <span class="spec-value">100% Cotton Combed 30s</span>
                </div>
                <div class="spec-card">
                    <span class="spec-label">Potongan</span>
                    <span class="spec-value">Oversized Fit Modern</span>
                </div>
                <div class="spec-card">
                    <span class="spec-label">Ketebalan</span>
                    <span class="spec-value">Sedang (Gramasi 150-160 gsm)</span>
                </div>
                <div class="spec-card">
                    <span class="spec-label">Gaya Jahitan</span>
                    <span class="spec-value">Jahitan Rantai Standar Distro</span>
                </div>
            </div>

            <div class="info-block">
                <h4>Keunggulan Produk:</h4>
                <ul>
                    <li>Tekstur kain sangat halus, dingin, dan menyerap keringat dengan baik.</li>
                    <li>Warna tidak mudah pudar meskipun dicuci berulang kali.</li>
                    <li>Sangat cocok untuk pemakaian sehari-hari maupun *layering outfit*.</li>
                </ul>
            </div>

            <div class="info-block">
                <h4>Instruksi Perawatan:</h4>
                <ul>
                    <li>Cuci dengan air dingin dan warna yang sejenis.</li>
                    <li>Gunakan detergen lembut dan hindari pemutih pakaian.</li>
                    <li>Setrika dengan suhu sedang dari bagian dalam kain.</li>
                </ul>
            </div>
        </div>
        
        <!-- Gradasi fade bawah yang halus -->
        <div class="read-more-fade" id="descFade"></div>
    </div>

    <!-- Tombol Baca Selengkapnya -->
    <div class="read-more-action">
        <button type="button" class="btn-read-more" id="btnReadMore" onclick="toggleReadMore()">
            <span>Baca Selengkapnya</span>
            <i class="fa-solid fa-chevron-down" id="iconReadMore"></i>
        </button>
    </div>
</section>

    {{-- Ulasan Pembeli --}}
    <section class="section-block">
        <h2 class="block-title">Ulasan Pembeli</h2>
        
        <div class="reviews-3col-wrapper">
            <div class="rating-stat-card">
                <div class="score-display">
                    <span class="num">4.9</span>
                    <span class="scale">/ 5.0</span>
                </div>
                <div class="stars-large">★★★★★</div>
                <p class="stat-subtitle">100% Pembeli Merasa Puas</p>
                
                <div class="bars-stack">
                    <div class="bar-row"><span>5★</span><div class="track"><div class="fill" style="width: 90%;"></div></div><span>115</span></div>
                    <div class="bar-row"><span>4★</span><div class="track"><div class="fill" style="width: 8%;"></div></div><span>10</span></div>
                    <div class="bar-row"><span>3★</span><div class="track"><div class="fill" style="width: 2%;"></div></div><span>3</span></div>
                </div>
            </div>

            <div class="reviews-feed">
                <div class="feed-grid" id="reviewsGrid">
                    <div class="review-post">
                        <div class="post-header">
                            <img src="{{ asset('images/user.png') }}" class="avatar" alt="User">
                            <div>
                                <h4 class="username">Anindya Putri</h4>
                                <div class="stars-small">★★★★★</div>
                            </div>
                        </div>
                        <p class="comment">Bahan katunnya beneran halus dan gak panas. Jahitannya sangat rapi, warna Navy Dark-nya mewah banget!</p>
                        <div class="photo-attach">
                            <img src="{{ asset('images/v91_66306.png') }}" alt="Review Photo">
                            <img src="{{ asset('images/v91_66373.png') }}" alt="Review Photo">
                        </div>
                        <span class="meta-info">Varian: XL, Navy Dark</span>
                    </div>

                    <div class="review-post">
                        <div class="post-header">
                            <img src="{{ asset('images/user.png') }}" class="avatar" alt="User">
                            <div>
                                <h4 class="username">Rian Pratama</h4>
                                <div class="stars-small">★★★★★</div>
                            </div>
                        </div>
                        <p class="comment">Pengiriman lumayan cepat, barang sesuai gambar. Ukuran XL di aku fit-nya pas banget oversize-nya dapet.</p>
                        <span class="meta-info">Varian: XL, Black</span>
                    </div>

                    <div class="review-post extra-review is-hidden">
                        <div class="post-header">
                            <img src="{{ asset('images/user.png') }}" class="avatar" alt="User">
                            <div>
                                <h4 class="username">Budi Santoso</h4>
                                <div class="stars-small">★★★★★</div>
                            </div>
                        </div>
                        <p class="comment">Kualitas kainnya juara, mirip baju-baju butik mahal. Sangat recommended!</p>
                        <div class="photo-attach">
                            <img src="{{ asset('images/v91_66490.png') }}" alt="Review Photo">
                        </div>
                        <span class="meta-info">Varian: L, White</span>
                    </div>

                    <div class="review-post extra-review is-hidden">
                        <div class="post-header">
                            <img src="{{ asset('images/user.png') }}" class="avatar" alt="User">
                            <div>
                                <h4 class="username">Siti Maya</h4>
                                <div class="stars-small">★★★★★</div>
                            </div>
                        </div>
                        <p class="comment">Suka banget sama teksturnya, adem dipakai seharian di luar ruangan.</p>
                        <span class="meta-info">Varian: S, Navy Dark</span>
                    </div>
                </div>

                <div class="reviews-expand-action">
    <button type="button" class="btn-text-expand" id="btnToggleReviews" onclick="toggleReviews()">
        <span>Lihat Semua Ulasan</span>
        <i class="fa-solid fa-chevron-down"></i>
    </button>
</div>
            </div>
        </div>
    </section>

    <!-- Section Produk Serupa (Tanpa wrapper .container internal) -->
    <section class="section-block" id="produk-serupa">
        <h2 class="block-title">Produk Serupa</h2>

        <div class="product-grid">
          <!-- Card Produk 1 -->
          <div class="product-card">
            <div class="product-image-container">
              <img src="{{ asset('images/v91_66306.png') }}" alt="Kemeja Linen Premium" class="product-image">
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
                <span class="rating-count">(42)</span>
              </div>
              <h3 class="product-title">Kemeja Linen Premium</h3>
              <p class="product-subtitle">Atasan Wanita</p>
              <div class="product-bottom">
                <span class="product-price">Rp 179.000</span>
                <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
              </div>
            </div>
          </div>

          <!-- Card Produk 2 -->
          <div class="product-card">
            <div class="product-image-container">
              <img src="{{ asset('images/bghero.jpg') }}" alt="Blouse Sutra Soft" class="product-image">
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
                <span class="rating-count">(28)</span>
              </div>
              <h3 class="product-title">Blouse Sutra Soft</h3>
              <p class="product-subtitle">Atasan Wanita</p>
              <div class="product-bottom">
                <span class="product-price">Rp 189.000</span>
                <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
              </div>
            </div>
          </div>

          <!-- Card Produk 3 -->
          <div class="product-card">
            <div class="product-image-container">
              <img src="{{ asset('images/v91_66373.png') }}" alt="Outer Oversize Casual" class="product-image">
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
                <i class="fa-solid fa-star-half-stroke"></i>
                <span class="rating-count">(50)</span>
              </div>
              <h3 class="product-title">Outer Oversize Casual</h3>
              <p class="product-subtitle">Outerwear</p>
              <div class="product-bottom">
                <span class="product-price">Rp 210.000</span>
                <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
              </div>
            </div>
          </div>

          <!-- Card Produk 4 -->
          <div class="product-card">
            <div class="product-image-container">
              <img src="{{ asset('images/bghero.jpg') }}" alt="Kaos Cotton Premium" class="product-image">
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
                <span class="rating-count">(35)</span>
              </div>
              <h3 class="product-title">Kaos Cotton Premium</h3>
              <p class="product-subtitle">Atasan Wanita</p>
              <div class="product-bottom">
                <span class="product-price">Rp 149.000</span>
                <a href="{{ route('detail') }}" class="btn-detail">Lihat Detail</a>
              </div>
            </div>
          </div>
        </div>
    </section>

</div>

{{-- Size Chart Modal --}}
<div id="sizeModal" class="modal-backdrop">
    <div class="modal-card">
        <div class="modal-head">
            <h3>Panduan Ukuran (Size Chart)</h3>
            <button type="button" class="btn-close" onclick="toggleModal(false)">&times;</button>
        </div>
        <div class="modal-body">
            <table class="size-table">
                <thead>
                    <tr>
                        <th>Ukuran</th>
                        <th>Lingkar Dada</th>
                        <th>Panjang Baju</th>
                        <th>Rekomendasi BB</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>S</td><td>96 cm</td><td>68 cm</td><td>45 - 55 kg</td></tr>
                    <tr><td>M</td><td>102 cm</td><td>70 cm</td><td>55 - 65 kg</td></tr>
                    <tr><td>L</td><td>108 cm</td><td>72 cm</td><td>65 - 75 kg</td></tr>
                    <tr><td>XL</td><td>114 cm</td><td>74 cm</td><td>75 - 85 kg</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>window.umiRoutes={cart:@json(route('keranjang')),shipping:@json(route('diantar'))};</script>
    <script src="{{ asset('js/detail-produk.js') }}"></script>
@endpush