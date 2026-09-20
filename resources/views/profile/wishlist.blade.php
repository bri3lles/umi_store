@extends('profile.index')

<link rel="stylesheet" href="{{ asset('css/wishlist.css') }}">

@section('profile-content')

<div class="wishlist-page">
    <div class="wishlist-heading">
        <div>
            <h1>Wishlist Saya</h1>
            <p>Produk yang kamu simpan untuk dibeli nanti.</p>
        </div>
    </div>


    <!-- PRODUCT GRID -->
    <div class="wishlist-product-grid">

        <!-- PRODUK 1 -->
        <div class="wishlist-product-card">

            <div class="wishlist-image-container">

                <img
                    src="https://i.pinimg.com/1200x/5b/34/52/5b3452044a69aa056e6bb0b1c37e3ec3.jpg"
                    alt="Kaos Polos Cotton Combed"
                    class="wishlist-product-image"
                >

                <span class="wishlist-badge">
                    TERLARIS
                </span>

                <button
                    type="button"
                    class="wishlist-btn active"
                    aria-label="Hapus dari Wishlist"
                >
                    <i class="fa-solid fa-heart"></i>
                </button>

            </div>

            <div class="wishlist-product-info">

                <div class="wishlist-rating">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>

                    <span>(48)</span>
                </div>

                <h3 class="wishlist-product-title">
                    Kaos Polos Cotton Combed
                </h3>

                <p class="wishlist-product-subtitle">
                    Atasan Pria
                </p>

                <div class="wishlist-product-bottom">

                    <span class="wishlist-product-price">
                        Rp 89.000
                    </span>

                    <a
                        href="{{ route('detail') }}"
                        class="wishlist-detail-btn"
                    >
                        Lihat Detail
                    </a>

                </div>

            </div>

        </div>


        <!-- PRODUK 2 -->
        <div class="wishlist-product-card">

            <div class="wishlist-image-container">

                <img
                    src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&q=80&w=600"
                    alt="Celana Kulot Palma Tailored"
                    class="wishlist-product-image"
                >

                <span class="wishlist-badge">
                    TERLARIS
                </span>

                <button
                    type="button"
                    class="wishlist-btn active"
                    aria-label="Hapus dari Wishlist"
                >
                    <i class="fa-solid fa-heart"></i>
                </button>

            </div>

            <div class="wishlist-product-info">

                <div class="wishlist-rating">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>

                    <span>(98)</span>
                </div>

                <h3 class="wishlist-product-title">
                    Celana Kulot Palma Tailored
                </h3>

                <p class="wishlist-product-subtitle">
                    Navy Classic Crepe
                </p>

                <div class="wishlist-product-bottom">

                    <span class="wishlist-product-price">
                        Rp 479.000
                    </span>

                    <a
                        href="{{ route('detail') }}"
                        class="wishlist-detail-btn"
                    >
                        Lihat Detail
                    </a>

                </div>

            </div>

        </div>


        <!-- PRODUK 3 -->
        <div class="wishlist-product-card">

            <div class="wishlist-image-container">

                <img
                    src="https://images.unsplash.com/photo-1603252110481-7ba873bf42ab?auto=format&fit=crop&q=80&w=600"
                    alt="Kemeja Linen Oversize"
                    class="wishlist-product-image"
                >

                <span class="wishlist-badge">
                    BARU
                </span>

                <button
                    type="button"
                    class="wishlist-btn active"
                    aria-label="Hapus dari Wishlist"
                >
                    <i class="fa-solid fa-heart"></i>
                </button>

            </div>

            <div class="wishlist-product-info">

                <div class="wishlist-rating">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>

                    <span>(27)</span>
                </div>

                <h3 class="wishlist-product-title">
                    Kemeja Linen Oversize
                </h3>

                <p class="wishlist-product-subtitle">
                    Atasan Wanita
                </p>

                <div class="wishlist-product-bottom">

                    <span class="wishlist-product-price">
                        Rp 179.000
                    </span>

                    <a
                        href="{{ route('detail') }}"
                        class="wishlist-detail-btn"
                    >
                        Lihat Detail
                    </a>

                </div>

            </div>

        </div>


        <!-- PRODUK 4 -->
        <div class="wishlist-product-card">

            <div class="wishlist-image-container">

                <img
                    src="https://images.unsplash.com/photo-1610652492500-ded49ceeb378?auto=format&fit=crop&q=80&w=600"
                    alt="Celana Chino Relaxed Fit"
                    class="wishlist-product-image"
                >

                <button
                    type="button"
                    class="wishlist-btn active"
                    aria-label="Hapus dari Wishlist"
                >
                    <i class="fa-solid fa-heart"></i>
                </button>

            </div>

            <div class="wishlist-product-info">

                <div class="wishlist-rating">

                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>

                    <span>(53)</span>

                </div>

                <h3 class="wishlist-product-title">
                    Celana Chino Relaxed Fit
                </h3>

                <p class="wishlist-product-subtitle">
                    Celana Pria
                </p>

                <div class="wishlist-product-bottom">

                    <span class="wishlist-product-price">
                        Rp 219.000
                    </span>

                    <a
                        href="{{ route('detail') }}"
                        class="wishlist-detail-btn"
                    >
                        Lihat Detail
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="{{ asset('js/wishlist.js') }}"></script>

@endsection