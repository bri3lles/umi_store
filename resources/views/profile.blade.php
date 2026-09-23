@extends('layouts.app')

@section('title', 'Profil Saya - Umi Store')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

{{-- Font Awesome --}}
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@endpush

@section('content')

<main class="profile-page">

    <div class="profile-container">

        {{-- =========================================================
     PROFILE HEADER
========================================================== --}}
<section class="profile-header">

    <div class="profile-info">

        <div class="profile-user">

            <div class="profile-avatar-wrapper">

                <img
                    src="{{ $user->foto_profil ?? 'https://i.pinimg.com/1200x/6b/ff/7a/6bff7ab751622668e3ef078064de7cfe.jpg' }}"
                    alt="Foto Profil"
                    class="profile-avatar"
                >

                <span class="profile-verified">
                    <i class="fa-solid fa-check"></i>
                </span>

            </div>

            <div class="profile-user-info">

                <h1>
                    {{ $user->nama ?? 'Siti Rahmawati' }}
                </h1>

                <p>
                    <i class="fa-regular fa-envelope"></i>
                    {{ $user->email ?? 'siti.rahmawati@email.com' }}
                </p>

            </div>

            <button
                type="button"
                class="profile-logout-btn"
                title="Keluar">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Keluar</span>
            </button>

        </div>

        {{-- TAB --}}
        <div class="profile-tabs-bar">

            <nav class="profile-tabs" aria-label="Navigasi profil">

                <button type="button"
                        class="profile-tab is-active"
                        data-tab="pesanan">

                    <i class="fa-solid fa-box-open"></i>

                    <span>Pesanan Saya</span>

                    <span class="tab-badge tab-badge--primary">6</span>

                </button>


                <button type="button"
                        class="profile-tab"
                        data-tab="wishlist">

                    <i class="fa-regular fa-heart"></i>

                    <span>Wishlist</span>

                    <span class="tab-badge">8</span>

                </button>


                <button type="button"
                        class="profile-tab"
                        data-tab="pengaturan">

                    <i class="fa-solid fa-gear"></i>

                    <span>Pengaturan Akun</span>

                </button>

            </nav>

        </div>

    </div>

</section>

            </div>

        </section>


        {{-- =========================================================
             TAB : PESANAN
        ========================================================== --}}
        <section
            id="tab-pesanan"
            class="profile-tab-content is-active">

            <div class="section-heading">

                <div>
                    <h2>Pesanan Saya</h2>
                    <p>
                        Lihat dan kelola semua pesanan kamu.
                    </p>
                </div>

                <div class="order-search">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="text"
                        id="orderSearch"
                        placeholder="Cari nomor pesanan atau produk..."
                    >

                </div>

            </div>


            {{-- FILTER --}}
            <div class="filter-bar">

                <div class="filter-pills">

                    <button
                        type="button"
                        class="filter-pill is-active"
                        data-filter="semua">
                        Semua <span>6</span>
                    </button>

                    <button
                        type="button"
                        class="filter-pill"
                        data-filter="menunggu">
                        Menunggu Pembayaran
                    </button>

                    <button
                        type="button"
                        class="filter-pill"
                        data-filter="diproses">
                        Diproses
                    </button>

                    <button
                        type="button"
                        class="filter-pill"
                        data-filter="dikirim">
                        Dikirim
                    </button>

                    <button
                        type="button"
                        class="filter-pill"
                        data-filter="selesai">
                        Selesai
                    </button>

                    <button
                        type="button"
                        class="filter-pill"
                        data-filter="pengembalian">
                        Pengembalian
                    </button>

                </div>

                <select class="sort-select">

                    <option>Terbaru</option>
                    <option>Total Terbesar</option>
                    <option>Total Terkecil</option>

                </select>

            </div>


            {{-- =====================================================
                 ORDER LIST
            ====================================================== --}}
            <div class="orders-grid" id="ordersGrid">


                {{-- ORDER 1 --}}
                <article
                    class="order-card"
                    data-status="menunggu"
                    data-search="ORD-98305 Silk Satin Floral Tunic Navy">

                    <div class="order-card-header">

                        <div class="order-id">

                            <i class="fa-solid fa-receipt"></i>

                            <div>
                                <strong>#ORD-98305</strong>
                                <small>24 Okt 2024, 09:15 WIB</small>
                            </div>

                        </div>

                        <span class="status-badge status-warning">
                            <i class="fa-regular fa-clock"></i>
                            Menunggu Pembayaran
                        </span>

                    </div>


                    <div class="order-product">

                        <img
                            src="https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=500&q=85"
                            alt="Silk Satin Floral Tunic Navy"
                        >

                        <div class="order-product-info">

                            <span class="product-category">
                                Atasan Silk
                            </span>

                            <h3>
                                Silk Satin Floral Tunic Navy
                            </h3>

                            <p>
                                Varian: L · 1 item
                            </p>

                            <strong>
                                Rp 389.000
                            </strong>

                        </div>

                    </div>


                    <div class="order-info-box">

                        <div>
                            <i class="fa-solid fa-building-columns"></i>
                            <span>
                                Menunggu Pembayaran (Midtrans)
                            </span>
                        </div>

                        <span class="countdown">
                            <i class="fa-solid fa-stopwatch"></i>
                            Bayar dalam 04:23:10
                        </span>

                    </div>


                    <div class="order-footer">

                        <div>
                            <small>Total Tagihan</small>
                            <strong>Rp 389.000</strong>
                        </div>

                        <div class="order-actions">

                            <button
                                class="btn btn-secondary"
                                onclick="openOrderDetailModal('#ORD-98305')">
                                Detail
                            </button>

                            <button
                                class="btn btn-danger-outline"
                                onclick="openCancelModal('#ORD-98305')">
                                Batalkan
                            </button>

                            <button class="btn btn-primary">
                                <i class="fa-solid fa-credit-card"></i>
                                Bayar
                            </button>

                        </div>

                    </div>

                </article>


                {{-- ORDER 2 --}}
                <article
                    class="order-card"
                    data-status="diproses"
                    data-search="ORD-97812 Premium Pleated Hijab Pashmina">

                    <div class="order-card-header">

                        <div class="order-id">

                            <i class="fa-solid fa-receipt"></i>

                            <div>
                                <strong>#ORD-97812</strong>
                                <small>23 Okt 2024, 14:20 WIB</small>
                            </div>

                        </div>

                        <span class="status-badge status-info">
                            <i class="fa-solid fa-box"></i>
                            Diproses
                        </span>

                    </div>


                    <div class="order-product">

                        <img
                            src="https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=500&q=85"
                            alt="Premium Pleated Hijab Pashmina"
                        >

                        <div class="order-product-info">

                            <span class="product-category">
                                Hijab & Scarf
                            </span>

                            <h3>
                                Premium Pleated Hijab Pashmina Dusty Pink
                            </h3>

                            <p>
                                Varian: All Size · 2 items
                            </p>

                            <strong>
                                Rp 198.000
                            </strong>

                        </div>

                    </div>


                    <div class="order-info-box">

                        <div>
                            <i class="fa-solid fa-store"></i>
                            Pesanan sedang dikemas di gudang Umi Store
                        </div>

                    </div>


                    <div class="order-footer">

                        <div>
                            <small>Total Pembayaran</small>
                            <strong>Rp 198.000</strong>
                        </div>

                        <div class="order-actions">

                            <button
                                class="btn btn-secondary"
                                onclick="openOrderDetailModal('#ORD-97812')">
                                Detail
                            </button>

                        </div>

                    </div>

                </article>


                {{-- ORDER 3 --}}
                <article
                    class="order-card"
                    data-status="dikirim"
                    data-search="ORD-96420 Linen Oversized Blazer Khaki">

                    <div class="order-card-header">

                        <div class="order-id">

                            <i class="fa-solid fa-receipt"></i>

                            <div>
                                <strong>#ORD-96420</strong>
                                <small>22 Okt 2024, 11:05 WIB</small>
                            </div>

                        </div>

                        <span class="status-badge status-shipping">
                            <i class="fa-solid fa-truck"></i>
                            Dikirim
                        </span>

                    </div>


                    <div class="order-product">

                        <img
                            src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=500&q=85"
                            alt="Linen Oversized Blazer Khaki"
                        >

                        <div class="order-product-info">

                            <span class="product-category">
                                Outerwear
                            </span>

                            <h3>
                                Linen Oversized Blazer Khaki
                            </h3>

                            <p>
                                Varian: M · 1 item
                            </p>

                            <strong>
                                Rp 549.000
                            </strong>

                        </div>

                    </div>


                    <div class="order-info-box">

                        <div>
                            <i class="fa-solid fa-truck"></i>
                            Sedang dikirim · JNE YES
                        </div>

                        <small>
                            Resi: JNE08231/11702
                        </small>

                    </div>


                    <div class="order-footer">

                        <div>
                            <small>Total Pembayaran</small>
                            <strong>Rp 549.000</strong>
                        </div>

                        <div class="order-actions">

                            <button
                                class="btn btn-secondary"
                                onclick="openOrderDetailModal('#ORD-96420')">
                                Detail
                            </button>

                        </div>

                    </div>

                </article>


                {{-- ORDER 4 --}}
                <article
                    class="order-card"
                    data-status="selesai"
                    data-search="ORD-95110 Gamis Rayon Viscose Bohemian Olive">

                    <div class="order-card-header">

                        <div class="order-id">

                            <i class="fa-solid fa-receipt"></i>

                            <div>
                                <strong>#ORD-95110</strong>
                                <small>18 Okt 2024, 16:40 WIB</small>
                            </div>

                        </div>

                        <span class="status-badge status-success">
                            <i class="fa-solid fa-circle-check"></i>
                            Selesai
                        </span>

                    </div>


                    <div class="order-product">

                        <img
                            src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=500&q=85"
                            alt="Gamis Rayon Viscose Bohemian Olive"
                        >

                        <div class="order-product-info">

                            <span class="product-category">
                                Gamis
                            </span>

                            <h3>
                                Gamis Rayon Viscose Bohemian Olive
                            </h3>

                            <p>
                                Varian: XL · 1 item
                            </p>

                            <strong>
                                Rp 420.000
                            </strong>

                        </div>

                    </div>


                    <div class="order-info-box success-box">

                        <div>
                            <i class="fa-solid fa-circle-check"></i>
                            Pesanan telah diterima
                        </div>

                        <span>
                            Yuk beri penilaian untuk produk ini.
                        </span>

                    </div>


                    <div class="order-footer">

                        <div>
                            <small>Total Transaksi</small>
                            <strong>Rp 420.000</strong>
                        </div>

                        <div class="order-actions">

                            <button
                                class="btn btn-secondary"
                                onclick="openOrderDetailModal('#ORD-95110')">
                                Detail
                            </button>

                            <button
                                class="btn btn-outline"
                                onclick="openReturnModal()">
                                <i class="fa-solid fa-rotate-left"></i>
                                Pengembalian
                            </button>

                            <button
                                class="btn btn-primary"
                                onclick="openReviewModal()">
                                <i class="fa-solid fa-star"></i>
                                Nilai
                            </button>

                        </div>

                    </div>

                </article>


                {{-- ORDER 5 --}}
                <article
                    class="order-card"
                    data-status="selesai"
                    data-search="ORD-94200 Basic Knit Cardigan Ivory">

                    <div class="order-card-header">

                        <div class="order-id">

                            <i class="fa-solid fa-receipt"></i>

                            <div>
                                <strong>#ORD-94200</strong>
                                <small>10 Okt 2024, 13:10 WIB</small>
                            </div>

                        </div>

                        <span class="status-badge status-success">
                            <i class="fa-solid fa-circle-check"></i>
                            Selesai
                        </span>

                    </div>


                    <div class="order-product">

                        <img
                            src="https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=500&q=85"
                            alt="Basic Knit Cardigan Ivory"
                        >

                        <div class="order-product-info">

                            <span class="product-category">
                                Knitwear
                            </span>

                            <h3>
                                Basic Knit Cardigan Ivory
                            </h3>

                            <p>
                                Varian: M · 1 item
                            </p>

                            <strong>
                                Rp 275.000
                            </strong>

                        </div>

                    </div>


                    <div class="order-info-box review-box">

                        <div class="stars">
                            ★★★★★
                        </div>

                        <span>
                            Ulasan telah diberikan
                        </span>

                    </div>


                    <div class="order-footer">

                        <div>
                            <small>Total Pembayaran</small>
                            <strong>Rp 275.000</strong>
                        </div>

                        <div class="order-actions">

                            <button
                                class="btn btn-secondary"
                                onclick="openOrderDetailModal('#ORD-94200')">
                                Detail
                            </button>

                            <button
                                class="btn btn-outline"
                                onclick="openViewReviewModal()">
                                <i class="fa-regular fa-eye"></i>
                                Lihat Ulasan
                            </button>

                        </div>

                    </div>

                </article>


                {{-- ORDER 6 --}}
                <article
                    class="order-card"
                    data-status="pengembalian"
                    data-search="ORD-93041 Midi Dress Katun Embroidery Terracotta">

                    <div class="order-card-header">

                        <div class="order-id">

                            <i class="fa-solid fa-receipt"></i>

                            <div>
                                <strong>#ORD-93041</strong>
                                <small>05 Okt 2024, 10:00 WIB</small>
                            </div>

                        </div>

                        <span class="status-badge status-purple">
                            <i class="fa-solid fa-rotate"></i>
                            Pengembalian
                        </span>

                    </div>


                    <div class="order-product">

                        <img
                            src="https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?auto=format&fit=crop&w=500&q=85"
                            alt="Midi Dress Katun Embroidery Terracotta"
                        >

                        <div class="order-product-info">

                            <span class="product-category">
                                Midi Dress
                            </span>

                            <h3>
                                Midi Dress Katun Embroidery Terracotta
                            </h3>

                            <p>
                                Varian: S · 1 item
                            </p>

                            <strong>
                                Rp 315.000
                            </strong>

                        </div>

                    </div>


                    <div class="order-info-box purple-box">

                        <div>
                            <i class="fa-solid fa-rotate"></i>
                            Pengembalian disetujui
                        </div>

                        <span>
                            Refund sedang diproses.
                        </span>

                    </div>


                    <div class="order-footer">

                        <div>
                            <small>Nilai Pengembalian</small>
                            <strong>Rp 315.000</strong>
                        </div>

                        <div class="order-actions">

                            <button
                                class="btn btn-secondary"
                                onclick="openOrderDetailModal('#ORD-93041')">
                                Detail
                            </button>

                            <button
                                class="btn btn-purple"
                                onclick="openReturnDetailModal()">
                                Detail Retur
                            </button>

                        </div>

                    </div>

                </article>

            </div>

            <div
                id="emptyOrders"
                class="empty-state"
                style="display:none;">

                <i class="fa-regular fa-folder-open"></i>

                <h3>Pesanan tidak ditemukan</h3>

                <p>
                    Belum ada pesanan yang sesuai dengan pencarian kamu.
                </p>

            </div>

        </section>


        {{-- =========================================================
             TAB : WISHLIST
        ========================================================== --}}
        <section
            id="tab-wishlist"
            class="profile-tab-content">

            <div class="section-heading">

                <div>
                    <h2>Wishlist</h2>
                    <p>
                        Produk yang kamu simpan untuk dibeli nanti.
                    </p>
                </div>

                <span class="wishlist-count">
                    8 Produk
                </span>

            </div>


            <div class="wishlist-grid">

                @php
                    $wishlist = [
                        ['name' => 'Basic Knit Cardigan Ivory', 'category' => 'Knitwear', 'price' => 'Rp 275.000'],
                        ['name' => 'Linen Oversized Blazer Khaki', 'category' => 'Outerwear', 'price' => 'Rp 549.000'],
                        ['name' => 'Premium Pashmina Dusty Pink', 'category' => 'Hijab & Scarf', 'price' => 'Rp 198.000'],
                        ['name' => 'Silk Satin Floral Tunic Navy', 'category' => 'Atasan', 'price' => 'Rp 389.000'],
                        ['name' => 'Gamis Rayon Olive', 'category' => 'Gamis', 'price' => 'Rp 420.000'],
                        ['name' => 'Midi Dress Terracotta', 'category' => 'Dress', 'price' => 'Rp 315.000'],
                        ['name' => 'Pleated Blouse Cream', 'category' => 'Atasan', 'price' => 'Rp 299.000'],
                        ['name' => 'Long Outer Linen', 'category' => 'Outerwear', 'price' => 'Rp 459.000'],
                    ];
                @endphp


                @foreach($wishlist as $item)

                    <article class="wishlist-card">

                        <div class="wishlist-image">

                            <img
                                src="https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=500&q=85"
                                alt="{{ $item['name'] }}"
                            >

                            <button
                                type="button"
                                class="wishlist-heart"
                                onclick="removeWishlist(this)"
                                title="Hapus dari wishlist">

                                <i class="fa-solid fa-heart"></i>

                            </button>

                        </div>


                        <div class="wishlist-info">

                            <span class="product-category">
                                {{ $item['category'] }}
                            </span>

                            <h3>
                                {{ $item['name'] }}
                            </h3>

                            <strong>
                                {{ $item['price'] }}
                            </strong>

                            <button
                                type="button"
                                class="btn btn-primary btn-full">

                                <i class="fa-solid fa-cart-shopping"></i>
                                Tambah ke Keranjang

                            </button>

                        </div>

                    </article>

                @endforeach

            </div>

        </section>


        {{-- =========================================================
             TAB : PENGATURAN
        ========================================================== --}}
        <section
            id="tab-pengaturan"
            class="profile-tab-content">

            <div class="section-heading">

                <div>
                    <h2>Pengaturan Akun</h2>
                    <p>
                        Kelola informasi profil dan keamanan akun kamu.
                    </p>
                </div>

            </div>


            <div class="settings-grid">


                {{-- PROFIL --}}
                <div class="settings-card">

                    <div class="settings-card-header">

                        <div class="settings-icon">
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <div>
                            <h3>Informasi Profil</h3>
                            <p>
                                Kelola informasi dasar akun kamu.
                            </p>
                        </div>

                    </div>


                    <form
                        class="settings-form"
                        action="{{ route('profile.update') }}"
                        method="POST">

                        @csrf
                        @method('PUT')


                        <div class="form-group">

                            <label>Nama Lengkap</label>

                            <div class="input-wrapper">

                                <i class="fa-regular fa-user"></i>

                                <input
                                    type="text"
                                    name="nama"
                                    value="{{ $user->nama ?? 'Siti Rahmawati' }}"
                                >

                            </div>

                        </div>


                        <div class="form-group">

                            <label>Username</label>

                            <div class="input-wrapper">

                                <i class="fa-solid fa-at"></i>

                                <input
                                    type="text"
                                    name="username"
                                    value="{{ $user->username ?? 'sitirahmawati' }}"
                                >

                            </div>

                        </div>


                        <div class="form-row">

                            <div class="form-group">

                                <label>Tanggal Lahir</label>

                                <input
                                    type="date"
                                    name="tanggal_lahir"
                                    value="{{ $user->tanggal_lahir ?? '1996-08-14' }}"
                                >

                            </div>


                            <div class="form-group">

                                <label>Jenis Kelamin</label>

                                <div class="gender-options">

                                    <label>
                                        <input
                                            type="radio"
                                            name="gender"
                                            value="perempuan"
                                            checked
                                        >
                                        Perempuan
                                    </label>

                                    <label>
                                        <input
                                            type="radio"
                                            name="gender"
                                            value="laki-laki"
                                        >
                                        Laki-laki
                                    </label>

                                </div>

                            </div>

                        </div>


                        <div class="verified-info">

                            <div>
                                <i class="fa-regular fa-envelope"></i>

                                <span>
                                    {{ $user->email ?? 'siti.rahmawati@email.com' }}
                                </span>
                            </div>

                            <span class="verified-badge">
                                <i class="fa-solid fa-check"></i>
                                Terverifikasi
                            </span>

                        </div>


                        <div class="verified-info">

                            <div>
                                <i class="fa-solid fa-phone"></i>

                                <span>
                                    {{ $user->telepon ?? '+62 812-8899-2341' }}
                                </span>
                            </div>

                            <span class="verified-badge">
                                <i class="fa-solid fa-check"></i>
                                Terverifikasi
                            </span>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary btn-full">

                            <i class="fa-solid fa-floppy-disk"></i>
                            Simpan Perubahan

                        </button>

                    </form>

                </div>


                {{-- KEAMANAN --}}
                <div class="settings-card">

                    <div class="settings-card-header">

                        <div class="settings-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>

                        <div>
                            <h3>Keamanan</h3>
                            <p>
                                Kelola password akun kamu.
                            </p>
                        </div>

                    </div>


                    <form
                        class="settings-form"
                        action="#"
                        method="POST"
                        onsubmit="event.preventDefault();">

                        <div class="form-group">

                            <label>Password Saat Ini</label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    id="currentPassword"
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-target="currentPassword">

                                    <i class="fa-regular fa-eye"></i>

                                </button>

                            </div>

                        </div>


                        <div class="form-group">

                            <label>Password Baru</label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    id="newPassword"
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-target="newPassword">

                                    <i class="fa-regular fa-eye"></i>

                                </button>

                            </div>

                            <small>
                                Minimal 8 karakter.
                            </small>

                        </div>


                        <div class="form-group">

                            <label>Konfirmasi Password Baru</label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    id="confirmPassword"
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-target="confirmPassword">

                                    <i class="fa-regular fa-eye"></i>

                                </button>

                            </div>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary btn-full">

                            <i class="fa-solid fa-key"></i>
                            Simpan Password

                        </button>

                    </form>

                </div>


                {{-- ALAMAT --}}
                <div class="settings-card settings-card--address">

                    <div class="settings-card-header">

                        <div class="settings-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>

                        <div>
                            <h3>Alamat Pengiriman</h3>
                            <p>
                                Alamat utama untuk pengiriman pesanan.
                            </p>
                        </div>

                    </div>


                    <div class="address-card">

                        <div class="address-top">

                            <div class="address-labels">

                                <span class="label-primary">
                                    Utama
                                </span>

                                <span class="label-muted">
                                    Rumah
                                </span>

                            </div>

                            <button
                                type="button"
                                class="text-button"
                                onclick="openEditAddressModal()">

                                <i class="fa-solid fa-pen"></i>
                                Ubah

                            </button>

                        </div>


                        <h4>
                            {{ $user->nama ?? 'Siti Rahmawati' }}
                        </h4>

                        <p>
                            +62 812-8899-2341
                        </p>

                        <p class="address-text">
                            Jl. Melati Raya No. 42,
                            RT 04/RW 08,
                            Cilandak Barat,
                            Cilandak,
                            Jakarta Selatan,
                            DKI Jakarta 12430
                        </p>


                        <div class="address-note">

                            <i class="fa-solid fa-note-sticky"></i>

                            Pagar warna hitam /
                            titip pos satpam

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

</main>


{{-- ==================== MODAL: LIHAT ULASAN ==================== --}}
<div class="modal-overlay" id="viewReviewModal">
    <div class="profile-modal profile-modal--review">

        <div class="profile-modal__header">
            <div class="profile-modal__heading">
                <div class="profile-modal__icon profile-modal__icon--blue">
                    <i class="fa-regular fa-star" aria-hidden="true"></i>
                </div>

                <div>
                    <span class="profile-modal__eyebrow">ULASAN PRODUK</span>
                    <h3>Lihat Ulasan</h3>
                    <p>Ulasan dari pembelian kamu</p>
                </div>
            </div>

            <button
                type="button"
                class="profile-modal__close"
                onclick="closeAllModals()"
                aria-label="Tutup">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

        <div class="profile-modal__body">

            <div class="review-product">
                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuD73MenRbLRkGwf0N6TrYDCNf76hSaaYB4lyIFx6FP5m_Hqt1D4zdK4ZVc6DaK7ids-U8b0u4PXG7WFubzqPpTH1epSK2jEq439ydK9cB5nOjXU6Ctta3FlHGZdnv-pD9xaIzCFmFx_Ej8-dloqlSasoawzb7Qg1EwPIlEqPgsdfRmGer2bDz2jBl7qGR_o5aaWvHPHGNnDxz236zrThNfYrYgQIfZGPJBeqXvswInGicukxYZKjI0fiw"
                    alt="Basic Knit Cardigan Ivory">

                <div class="review-product__info">
                    <span class="review-product__category">
                        Knitwear Eksklusif
                    </span>

                    <h4>Basic Knit Cardigan Ivory</h4>

                    <p>Varian M · 1 item</p>

                    <span class="review-product__order">
                        #ORD-94200
                    </span>
                </div>
            </div>

            <div class="review-score">
                <div class="review-score__number">5.0</div>

                <div>
                    <div class="review-stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>

                    <span class="review-score__label">
                        Sangat Memuaskan
                    </span>
                </div>
            </div>

            <div class="review-info">
                <div>
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Pembelian terverifikasi</span>
                </div>

                <span>11 Oktober 2024</span>
            </div>

            <div class="review-content">
                <span class="profile-modal__label">
                    Ulasan Kamu
                </span>

                <p>
                    Cardigan rajut ini lembut dan nyaman dipakai.
                    Warnanya juga sesuai dengan foto dan mudah
                    dipadukan dengan pakaian lain.
                </p>
            </div>

            <div class="review-photo-section">

                <span class="profile-modal__label">
                    Foto Produk
                </span>

                <div class="review-photo">
                    <img
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuD73MenRbLRkGwf0N6TrYDCNf76hSaaYB4lyIFx6FP5m_Hqt1D4zdK4ZVc6DaK7ids-U8b0u4PXG7WFubzqPpTH1epSK2jEq439ydK9cB5nOjXU6Ctta3FlHGZdnv-pD9xaIzCFmFx_Ej8-dloqlSasoawzb7Qg1EwPIlEqPgsdfRmGer2bDz2jBl7qGR_o5aaWvHPHGNnDxz236zrThNfYrYgQIfZGPJBeqXvswInGicukxYZKjI0fiw"
                        alt="Foto ulasan produk">
                </div>

            </div>

        </div>

        <div class="profile-modal__footer">
            <button
                type="button"
                class="profile-modal-btn profile-modal-btn--primary"
                onclick="closeAllModals()">
                Tutup
            </button>
        </div>

    </div>
</div>


{{-- ===============================================================
     MODAL BATALKAN
================================================================ --}}
<div
    class="modal-overlay"
    id="cancelModal">

    <div class="modal modal-small">

        <div class="modal-header">

            <div>

                <span class="modal-icon modal-icon--danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>

                <div>
                    <h3>Batalkan Pesanan?</h3>
                    <p id="cancelOrderTarget">
                        #ORD-98305
                    </p>
                </div>

            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeAllModals()">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>


        <div class="modal-body">

            <p>
                Apakah kamu yakin ingin membatalkan pesanan ini?
            </p>


            <div class="warning-box">

                <i class="fa-solid fa-circle-info"></i>

                <span>
                    Pembatalan pesanan masih berupa simulasi
                    karena website ini masih menggunakan data dummy.
                </span>

            </div>


            <label class="modal-label">
                Alasan pembatalan
            </label>

            <div class="reason-list">

                <label>
                    <input
                        type="radio"
                        name="cancel_reason"
                        checked>
                    Ingin mengubah alamat
                </label>

                <label>
                    <input
                        type="radio"
                        name="cancel_reason">
                    Ingin mengubah ukuran atau warna
                </label>

                <label>
                    <input
                        type="radio"
                        name="cancel_reason">
                    Ingin mengganti metode pembayaran
                </label>

                <label>
                    <input
                        type="radio"
                        name="cancel_reason">
                    Alasan lainnya
                </label>

            </div>

        </div>


        <div class="modal-footer">

            <button
                class="btn btn-secondary"
                onclick="closeAllModals()">
                Kembali
            </button>

            <button
                class="btn btn-danger"
                onclick="submitCancelModal()">
                Ya, Batalkan
            </button>

        </div>

    </div>

</div>


{{-- ==================== MODAL: BERI PENILAIAN ==================== --}}
<div class="modal-overlay" id="reviewModal">
    <div class="profile-modal profile-modal--rating">

        <div class="profile-modal__header">
            <div class="profile-modal__heading">
                <div class="profile-modal__icon profile-modal__icon--gold">
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                </div>

                <div>
                    <span class="profile-modal__eyebrow">PESANAN SELESAI</span>
                    <h3>Beri Penilaian</h3>
                    <p>Bagikan pengalaman kamu setelah menerima produk</p>
                </div>
            </div>

            <button
                type="button"
                class="profile-modal__close"
                onclick="closeAllModals()"
                aria-label="Tutup">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

        <div class="profile-modal__body">

            <div class="review-product">
                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjVoINOfx46tCwa-8JqV1OlFd609bCj1q9WF5ARMUhnC81Scn5RYKLizoiui4WtRGY8-EwV2QjmbajprrkDDQTyXJ50AKGQ9b897vwJANF2azHP2fklSZ3iMfRGRU89mp5-LxVpt11SmBiq9_q8ECRvIUoR1k4k-AFs1P1FfmjF59Vew_Q--X3hje2GGqNaMLXmqti7xnS8GLiG-Ei1hQr69CDCHBuM4AknymTHp-EV0EcfH1-tVTKXA"
                    alt="Gamis Rayon Viscose Bohemian Olive">

                <div class="review-product__info">
                    <span class="review-product__category">
                        Gamis Modern
                    </span>

                    <h4>Gamis Rayon Viscose Bohemian Olive</h4>

                    <p>Varian XL · 1 item</p>

                    <span class="review-product__order">
                        #ORD-95110
                    </span>
                </div>
            </div>

            <div class="rating-section">

                <div class="rating-section__title">
                    <span>Bagaimana pengalaman kamu?</span>
                    <small>Pilih jumlah bintang</small>
                </div>

                <div
                    class="rating-stars"
                    id="ratingStarContainer"
                    aria-label="Pilih rating">

                    <button type="button" onclick="setStarRating(1)">
                        <i class="fa-regular fa-star"></i>
                    </button>

                    <button type="button" onclick="setStarRating(2)">
                        <i class="fa-regular fa-star"></i>
                    </button>

                    <button type="button" onclick="setStarRating(3)">
                        <i class="fa-regular fa-star"></i>
                    </button>

                    <button type="button" onclick="setStarRating(4)">
                        <i class="fa-regular fa-star"></i>
                    </button>

                    <button type="button" onclick="setStarRating(5)">
                        <i class="fa-regular fa-star"></i>
                    </button>

                </div>

                <span
                    class="rating-selected-text"
                    id="starRatingText">
                    Pilih rating kamu
                </span>

            </div>

            <div class="profile-form-group">
                <label for="review-text">
                    Ceritakan pengalaman kamu
                </label>

                <textarea
                    id="review-text"
                    rows="4"
                    placeholder="Bagaimana kualitas bahan, ukuran, warna, dan kenyamanan produk?"></textarea>
            </div>

            <div class="review-upload">

                <div>
                    <span class="profile-modal__label">
                        Foto Produk
                    </span>

                    <p>
                        Tambahkan foto produk jika kamu mau.
                    </p>
                </div>

                <button
                    type="button"
                    class="review-upload__button"
                    onclick="alert('Membuka pemilih foto.')">

                    <i class="fa-regular fa-image"></i>
                    <span>Tambah Foto</span>

                </button>

            </div>

            <label class="review-anonymous">
                <input type="checkbox">

                <span>
                    <strong>Sembunyikan nama</strong>
                    <small>
                        Nama kamu tidak akan ditampilkan pada ulasan publik.
                    </small>
                </span>
            </label>

        </div>

        <div class="profile-modal__footer">

            <button
                type="button"
                class="profile-modal-btn profile-modal-btn--secondary"
                onclick="closeAllModals()">
                Batal
            </button>

            <button
                type="button"
                class="profile-modal-btn profile-modal-btn--primary"
                onclick="submitReviewModal()">

                <i class="fa-solid fa-paper-plane"></i>
                Kirim Ulasan

            </button>

        </div>

    </div>
</div>


{{-- ===============================================================
     MODAL RETURN
================================================================ --}}
<div
    class="modal-overlay"
    id="returnModal">

    <div class="modal modal-medium">

        <div class="modal-header">

            <div>

                <span class="modal-icon modal-icon--purple">
                    <i class="fa-solid fa-rotate-left"></i>
                </span>

                <div>
                    <h3>Ajukan Pengembalian</h3>
                    <p>
                        #ORD-95110
                    </p>
                </div>

            </div>

            <button
                class="modal-close"
                onclick="closeAllModals()">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>


        <div class="modal-body">

            <div class="form-group">

                <label>
                    Alasan Pengembalian
                </label>

                <select>

                    <option>
                        Produk rusak
                    </option>

                    <option>
                        Ukuran tidak sesuai
                    </option>

                    <option>
                        Barang tidak sesuai deskripsi
                    </option>

                    <option>
                        Salah varian
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>
                    Keterangan
                </label>

                <textarea
                    rows="4"
                    placeholder="Jelaskan alasan pengembalian..."></textarea>

            </div>


            <div class="upload-placeholder">

                <i class="fa-solid fa-cloud-arrow-up"></i>

                <strong>
                    Upload bukti
                </strong>

                <span>
                    JPG / PNG
                </span>

            </div>

        </div>


        <div class="modal-footer">

            <button
                class="btn btn-secondary"
                onclick="closeAllModals()">
                Batal
            </button>

            <button
                class="btn btn-purple"
                onclick="submitReturnModal()">
                Ajukan Pengembalian
            </button>

        </div>

    </div>

</div>


{{-- ==================== MODAL: DETAIL RETUR ==================== --}}
<div class="modal-overlay" id="returnDetailModal">
    <div class="profile-modal profile-modal--return">

        <div class="profile-modal__header">
            <div class="profile-modal__heading">
                <div class="profile-modal__icon profile-modal__icon--purple">
                    <i class="fa-solid fa-arrow-right-arrow-left"
                       aria-hidden="true"></i>
                </div>

                <div>
                    <span class="profile-modal__eyebrow">
                        PENGEMBALIAN
                    </span>

                    <h3>Detail Retur</h3>

                    <p>
                        Informasi proses pengembalian pesanan
                    </p>
                </div>
            </div>

            <button
                type="button"
                class="profile-modal__close"
                onclick="closeAllModals()"
                aria-label="Tutup">

                <i class="fa-solid fa-xmark" aria-hidden="true"></i>

            </button>
        </div>

        <div class="profile-modal__body">

            <div class="return-status">
                <div class="return-status__icon">
                    <i class="fa-solid fa-check"></i>
                </div>

                <div>
                    <strong>Pengembalian Disetujui</strong>
                    <span>
                        Barang sudah diterima dan diverifikasi oleh
                        Umi Store.
                    </span>
                </div>

                <strong class="return-status__amount">
                    Rp 315.000
                </strong>
            </div>

            <div class="return-order">

                <div>
                    <span>Nomor Pesanan</span>
                    <strong>#ORD-93041</strong>
                </div>

                <div>
                    <span>Produk</span>
                    <strong>Midi Dress Katun Embroidery Terracotta</strong>
                </div>

            </div>

            <div class="return-timeline-new">

                <div class="return-step is-complete">

                    <div class="return-step__icon">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <div>
                        <strong>Pengajuan disetujui</strong>
                        <span>
                            05 Okt 2024 · 11:20 WIB
                        </span>
                        <small>
                            Alasan: Salah ukuran
                        </small>
                    </div>

                </div>

                <div class="return-step is-complete">

                    <div class="return-step__icon">
                        <i class="fa-solid fa-box"></i>
                    </div>

                    <div>
                        <strong>Barang diterima gudang</strong>
                        <span>
                            06 Okt 2024 · 09:14 WIB
                        </span>
                        <small>
                            JNE · JNE9912003
                        </small>
                    </div>

                </div>

                <div class="return-step is-active">

                    <div class="return-step__icon">
                        <i class="fa-solid fa-wallet"></i>
                    </div>

                    <div>
                        <strong>Refund sedang diproses</strong>
                        <span>
                            Estimasi 1 × 24 jam
                        </span>
                        <small>
                            Refund melalui rekening BCA
                        </small>
                    </div>

                </div>

            </div>

            <div class="return-summary">

                <div>
                    <span>Nilai barang</span>
                    <strong>Rp 315.000</strong>
                </div>

                <div>
                    <span>Ongkos kirim retur</span>
                    <strong>Rp 0</strong>
                </div>

                <div class="return-summary__total">
                    <span>Total dana dikembalikan</span>
                    <strong>Rp 315.000</strong>
                </div>

            </div>

        </div>

        <div class="profile-modal__footer">

            <button
                type="button"
                class="profile-modal-btn profile-modal-btn--secondary"
                onclick="alert('Mengunduh tanda bukti pengembalian PDF.')">

                <i class="fa-regular fa-file-pdf"></i>
                Unduh Bukti

            </button>

            <button
                type="button"
                class="profile-modal-btn profile-modal-btn--purple"
                onclick="closeAllModals()">

                Tutup

            </button>

        </div>

    </div>
</div>


{{-- ===============================================================
     MODAL EDIT ALAMAT
================================================================ --}}
<div
    class="modal-overlay"
    id="address-edit-modal">

    <div class="modal modal-medium">

        <div class="modal-header">

            <div>

                <span class="modal-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </span>

                <div>
                    <h3>Ubah Alamat</h3>
                    <p>
                        Perbarui alamat pengiriman.
                    </p>
                </div>

            </div>

            <button
                class="modal-close"
                onclick="closeEditAddressModal()">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>


        <div class="modal-body">

            <form
                id="addressForm"
                onsubmit="event.preventDefault(); closeEditAddressModal();">

                <div class="form-group">

                    <label>
                        Label Alamat
                    </label>

                    <div class="address-label-options">

                        <label>
                            <input
                                type="radio"
                                name="address_label"
                                checked>
                            Rumah
                        </label>

                        <label>
                            <input
                                type="radio"
                                name="address_label">
                            Kantor
                        </label>

                        <label>
                            <input
                                type="radio"
                                name="address_label">
                            Lainnya
                        </label>

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label>
                            Nama Penerima
                        </label>

                        <input
                            type="text"
                            value="{{ $user->nama ?? 'Siti Rahmawati' }}">

                    </div>


                    <div class="form-group">

                        <label>
                            Nomor Handphone
                        </label>

                        <input
                            type="text"
                            value="+62 812-8899-2341">

                    </div>

                </div>


                <div class="form-group">

                    <label>
                        Alamat Lengkap
                    </label>

                    <textarea rows="4">Jl. Melati Raya No. 42, RT 04/RW 08, Cilandak Barat, Cilandak, Jakarta Selatan, DKI Jakarta 12430</textarea>

                </div>


                <div class="form-group">

                    <label>
                        Catatan untuk Kurir
                    </label>

                    <input
                        type="text"
                        value="Pagar warna hitam / titip pos satpam">

                </div>

            </form>

        </div>


        <div class="modal-footer">

            <button
                class="btn btn-secondary"
                onclick="closeEditAddressModal()">
                Batal
            </button>

            <button
                class="btn btn-primary"
                onclick="closeEditAddressModal()">

                <i class="fa-solid fa-floppy-disk"></i>
                Simpan

            </button>

        </div>

    </div>

</div>


</main>

@endsection

@push('scripts')
<script src="{{ asset('js/profile.js') }}"></script>
@endpush