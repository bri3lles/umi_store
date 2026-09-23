@extends('profile.index')

@section('profile-content')

<link rel="stylesheet" href="{{ asset('css/pesanan.css') }}">

<div class="orders-page">

    <!-- HEADER PESANAN -->
    <div class="section-heading">
        <div>
            <h1>Pesanan Saya</h1>
            <p>Kelola dan pantau seluruh pesanan kamu di Umi Store.</p>
        </div>
    </div>

    <div class="order-toolbar">



    {{-- FILTER STATUS - TENGAH --}}
    <div class="filter-pills">

        <button type="button" class="filter-pill active" data-filter="all">
            Semua Status (6)
        </button>

        <button type="button" class="filter-pill" data-filter="menunggu">
            Menunggu Pembayaran
        </button>

        <button type="button" class="filter-pill" data-filter="diproses">
            Diproses
        </button>

        <button type="button" class="filter-pill" data-filter="dikirim">
            Dikirim
        </button>

        <button type="button" class="filter-pill" data-filter="selesai">
            Selesai
        </button>

        <button type="button" class="filter-pill" data-filter="pengembalian">
            Pengembalian
        </button>

    </div>


    {{-- SEARCH - PALING KANAN --}}
    <div class="order-search">

        <i class="fa-solid fa-magnifying-glass"></i>

        <input
            type="text"
            id="orderSearch"
            placeholder="Cari nomor pesanan atau nama produk..."
        >

    </div>

</div>

    </div>


    <!-- ==================== PESANAN ==================== -->
    <div class="orders-grid" id="ordersGrid">


        <!-- ================= CARD 1 ================= -->
        <article
            class="order-card"
            data-status="menunggu"
            data-order="ORD-98305"
            data-product="Silk Satin Floral Tunic Navy"
            data-date="2024-10-24"
            data-total="389000">

            <div class="order-card-header">

                <div class="order-heading">
                    <i class="fa-solid fa-receipt"></i>

                    <strong>#ORD-98305</strong>

                    <span class="order-date">
                        · 24 Okt 2024, 09:15 WIB
                    </span>
                </div>

                <span class="status-badge status-warning">
                    <i class="fa-solid fa-clock"></i>
                    Menunggu Pembayaran
                </span>

            </div>


            <div class="order-product">

                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjp2mqVSp0Y2156-tDJWby3jWqJmgPSWBs-37Ys4xkEHAy8wx56qKz9C5VuN8ZomWqpFBY2IDDhzz3hFuJWYNeWr4PktY41lVreanWHRd3ztjaO7n1TvXxajXPOjw33RhT6tY9sr8VZesvaOKGh8w8DyUlpHB1ew_NRRl4YZ1vffLWzahOBFPonncu3ExIoWiBTVhD8H815GvEgmOQ0kOXVvvC7TUk6Le9KDsGtRBUv9Nm3yRzRdLAPA"
                    alt="Silk Satin Floral Tunic Navy">

                <div class="order-product-info">

                    <span class="product-category">
                        Atasan Silk
                    </span>

                    <h2>
                        Silk Satin Floral Tunic Navy
                    </h2>

                    <p>
                        Varian: L · 1 item
                    </p>

                    <strong>
                        Rp 389.000
                    </strong>

                </div>

            </div>


            <div class="order-info-box warning-info">

                <div>
                    <i class="fa-solid fa-building-columns"></i>

                    Menunggu Pembayaran (Midtrans)
                </div>

                <span class="countdown">
                    <i class="fa-solid fa-stopwatch"></i>
                    Bayar dalam 04:23:10
                </span>

            </div>


            <div class="order-footer">

                <div class="order-total">
                    <span>Total Tagihan</span>
                    <strong>Rp 389.000</strong>
                </div>

                <div class="order-actions">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="openOrderDetailModal('ORD-98305')">
                        Lihat Detail
                    </button>

                    <button
                        type="button"
                        class="btn btn-danger-outline"
                        onclick="openCancelModal('ORD-98305')">
                        Batalkan
                    </button>

                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="openPaymentModal('ORD-98305')">
                        <i class="fa-solid fa-credit-card"></i>
                        Bayar Sekarang
                    </button>

                </div>

            </div>

        </article>


        <!-- ================= CARD 2 ================= -->
        <article
            class="order-card"
            data-status="diproses"
            data-order="ORD-97812"
            data-product="Premium Pleated Hijab Pashmina Dusty Pink"
            data-date="2024-10-23"
            data-total="198000">

            <div class="order-card-header">

                <div class="order-heading">
                    <i class="fa-solid fa-receipt"></i>

                    <strong>#ORD-97812</strong>

                    <span class="order-date">
                        · 23 Okt 2024, 14:20 WIB
                    </span>
                </div>

                <span class="status-badge status-info">
                    <i class="fa-solid fa-hourglass-half"></i>
                    Diproses
                </span>

            </div>


            <div class="order-product">

                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCDX5buo7pDOTEIPSGjA_PBq_3-56-AdeB50SeRVI4Y6J765Xh4tdfDcmYcm_6x5ueE4sxW11BgLSv78EtoJhcumclSUQ-8p9nPSNYCJydqeU5yA10KEPTCeFZe0APDB0B7AKzR99oLHAzaTsyRruGILwTELIy5GqVUDizifxxnjCuIxz9q7AHp4fMDMo5LNya71XJAD4-N556fxSAEFTkhu8k0QErOWFdxVuvE4PByHQQS7hM__wcklA"
                    alt="Premium Pleated Hijab">

                <div class="order-product-info">

                    <span class="product-category">
                        Hijab & Scarf
                    </span>

                    <h2>
                        Premium Pleated Hijab Pashmina Dusty Pink
                    </h2>

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

                <div class="order-total">
                    <span>Total Pembayaran</span>
                    <strong>Rp 198.000</strong>
                </div>

                <div class="order-actions">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="openOrderDetailModal('ORD-97812')">
                        Lihat Detail
                    </button>

                </div>

            </div>

        </article>


        <!-- ================= CARD 3 ================= -->
        <article
            class="order-card"
            data-status="dikirim"
            data-order="ORD-96420"
            data-product="Linen Oversized Blazer Khaki"
            data-date="2024-10-22"
            data-total="549000">

            <div class="order-card-header">

                <div class="order-heading">
                    <i class="fa-solid fa-receipt"></i>

                    <strong>#ORD-96420</strong>

                    <span class="order-date">
                        · 22 Okt 2024, 11:05 WIB
                    </span>
                </div>

                <span class="status-badge status-shipping">
                    <i class="fa-solid fa-truck"></i>
                    Dikirim
                </span>

            </div>


            <div class="order-product">

                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuB-o6GvX1CaflB3E3rjzBSu49l9rwx5cbAHlQPthWqaa-zDR6-x9imWr6rOqD2XuqifOd2lm_OG-ctenUWy3vKVB9j32fpOWNIshE_3SGEa4IfObw9Pmptxk7z86LIM0B87xjtnwClZk18cq9arkZzo5kJG02CRG6Y5YUXzuAXsWSgL86d-LVWYhoErqStq-eiN8MSyvc03vps-GRe6qCJgxZDTBR6rs72agVR1WA7HACeJJsEjrnd_wQ"
                    alt="Linen Oversized Blazer">

                <div class="order-product-info">

                    <span class="product-category">
                        Outerwear Pilihan
                    </span>

                    <h2>
                        Linen Oversized Blazer Khaki
                    </h2>

                    <p>
                        Varian: M · 1 item
                    </p>

                    <strong>
                        Rp 549.000
                    </strong>

                </div>

            </div>


            <div class="order-info-box shipping-info">

                <div>
                    <i class="fa-solid fa-truck status-icon"></i>

                    Sedang Dikirim · JNE YES
                </div>

                <p>
                    Resi: JNE08231/11702
                </p>

                <small>
                    Estimasi tiba hari ini sebelum jam 18:00
                </small>

            </div>


            <div class="order-footer">

                <div class="order-total">
                    <span>Total Pembayaran</span>
                    <strong>Rp 549.000</strong>
                </div>

                <div class="order-actions">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="openOrderDetailModal('ORD-96420')">
                        Lihat Detail
                    </button>

                </div>

            </div>

        </article>


        <!-- ================= CARD 4 ================= -->
        <article
            class="order-card"
            data-status="selesai"
            data-order="ORD-95110"
            data-product="Gamis Rayon Viscose Bohemian Olive"
            data-date="2024-10-18"
            data-total="420000">

            <div class="order-card-header">

                <div class="order-heading">
                    <i class="fa-solid fa-receipt"></i>

                    <strong>#ORD-95110</strong>

                    <span class="order-date">
                        · 18 Okt 2024, 16:40 WIB
                    </span>
                </div>

                <span class="status-badge status-success">
                    <i class="fa-solid fa-circle-check status-icon"></i>
                    Pesanan Selesai
                </span>

            </div>


            <div class="order-product">

                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjVoINOfx46tCwa-8JqV1OlFd609bCj1q9WF5ARMUhnC81Scn5RYKLizoiui4WtRGY8-EwV2QjmbajprrkDDQTyXJ50AKGQ9b897vwJANF2azHP2fklSZ3iMfRGRU89mp5-LxVpt11SmBiq9_q8ECRvIUoR1k4k-AFs1P1FfmjF59Vew_Q--X3hje2GGqNaMLXmqti7xnS8GLiG-Ei1hQr69CDCHBuM4AknymTHp-EV0EcfH1-tVTKXA"
                    alt="Gamis Rayon Viscose">

                <div class="order-product-info">

                    <span class="product-category">
                        Gamis Modern
                    </span>

                    <h2>
                        Gamis Rayon Viscose Bohemian Olive
                    </h2>

                    <p>
                        Varian: XL · 1 item
                    </p>

                    <strong>
                        Rp 420.000
                    </strong>

                </div>

            </div>


            <div class="order-info-box success-info">

                <div>
                    <i class="fa-solid fa-shield-halved"></i>

                    Diterima oleh Siti Rahmawati
                </div>

                <p>
                    Ditunggu ulasan kamu!
                </p>

            </div>


            <div class="order-footer">

                <div class="order-total">
                    <span>Total Transaksi</span>
                    <strong>Rp 420.000</strong>
                </div>

                <div class="order-actions">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="openOrderDetailModal('ORD-95110')">
                        Lihat Detail
                    </button>

                    <a
    href="{{ route('retur.index', ['order' => 'ORD-95110']) }}"
    class="btn btn-outline"
>
    <i class="fa-solid fa-rotate-left"></i>
    Ajukan Pengembalian
</a>

                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="openReviewModal('ORD-95110')">
                        <i class="fa-solid fa-star"></i>
                        Beri Penilaian
                    </button>

                </div>

            </div>

        </article>


        <!-- ================= CARD 5 ================= -->
        <article
            class="order-card"
            data-status="selesai"
            data-order="ORD-94200"
            data-product="Basic Knit Cardigan Ivory"
            data-date="2024-10-10"
            data-total="275000">

            <div class="order-card-header">

                <div class="order-heading">
                    <i class="fa-solid fa-receipt"></i>

                    <strong>#ORD-94200</strong>

                    <span class="order-date">
                        · 10 Okt 2024, 13:10 WIB
                    </span>
                </div>

                <span class="status-badge status-success">
                    <i class="fa-solid fa-circle-check status-icon"></i>
                    Selesai
                </span>

            </div>


            <div class="order-product">

                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuD73MenRbLRkGwf0N6TrYDCNf76hSaaYB4lyIFx6FP5m_Hqt1D4zdK4ZVc6DaK7ids-U8b0u4PXG7WFubzqPpTH1epSK2jEq439ydK9cB5nOjXU6Ctta3FlHGZdnv-pD9xaIzCFmFx_Ej8-dloqlSasoawzb7Qg1EwPIlEqPgsdfRmGer2bDz2jBl7qGR_o5aaWvHPHGNnDxz236zrThNfYrYgQIfZGPJBeqXvswInGicukxYZKjI0fiw"
                    alt="Basic Knit Cardigan Ivory">

                <div class="order-product-info">

                    <span class="product-category">
                        Knitwear Eksklusif
                    </span>

                    <h2>
                        Basic Knit Cardigan Ivory
                    </h2>

                    <p>
                        Varian: M · 1 item
                    </p>

                    <strong>
                        Rp 275.000
                    </strong>

                </div>

            </div>


            <div class="order-info-box review-info">

                <div class="review-stars">
                    ★★★★★
                </div>

                <p>
                    Ulasan telah diberikan (5 Bintang) · Terima kasih!
                </p>

            </div>


            <div class="order-footer">

                <div class="order-total">
                    <span>Total Pembayaran</span>
                    <strong>Rp 275.000</strong>
                </div>

                <div class="order-actions">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="openOrderDetailModal('ORD-94200')">
                        Lihat Detail
                    </button>

                    <button
                        type="button"
                        class="btn btn-outline"
                        onclick="openViewReviewModal('ORD-94200')">
                        <i class="fa-regular fa-eye"></i>
                        Lihat Ulasan
                    </button>

                </div>

            </div>

        </article>


        <!-- ================= CARD 6 ================= -->
        <article
            class="order-card"
            data-status="pengembalian"
            data-order="ORD-93041"
            data-product="Midi Dress Katun Embroidery Terracotta"
            data-date="2024-10-05"
            data-total="315000">

            <div class="order-card-header">

                <div class="order-heading">
                    <i class="fa-solid fa-receipt"></i>

                    <strong>#ORD-93041</strong>

                    <span class="status-badge status-purple">
                        <i class="fa-solid fa-circle-check status-icon"></i>
                        Pengembalian Disetujui
                    </span>

                </div>

                <span class="order-date">
                    · 05 Okt 2024, 10:00 WIB
                </span>

            </div>


            <div class="order-product">

                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDra_ZMYt3MWl2FbZCklsAJc5m3DEzw6tQnqpYu1u_soyOtqds0lT3WmdGl9q7Jxc9Rq9PoM-4-zLsiypC-hX-lsQ8oolabpOiqt5nCn1JOU0ruc9AZ0Rn_Jz0jIK4VZHuAglLVKPnL4XcVj8WvYeqMn-VbLaOnMBOe-M9KRkQRjCvp0p7p-zPKtoQL7Z7aHxdxcYdaoXqPadgRl5YwpkKAXMNxGD-f_GvpUi094yHDrC8T9LtUI4jVaQ"
                    alt="Midi Dress Terracotta">

                <div class="order-product-info">

                    <span class="product-category">
                        Midi Dress
                    </span>

                    <h2>
                        Midi Dress Katun Embroidery Terracotta
                    </h2>

                    <p>
                        Varian: S · 1 item
                    </p>

                    <strong>
                        Rp 315.000
                    </strong>

                </div>

            </div>


            <div class="order-info-box return-info">

                <div>
                    <i class="fa-solid fa-rotate-left"></i>

                    Barang telah diterima di Gudang Umi Store
                </div>

                <p>
                    Refund diproses 1×24 jam
                </p>

                <strong>
                    Total Pengembalian: Rp 315.000
                </strong>

            </div>


            <div class="order-footer">

                <div class="order-total">
                    <span>Nilai Pengembalian</span>
                    <strong class="purple-text">
                        Rp 315.000
                    </strong>
                </div>

                <div class="order-actions">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="openOrderDetailModal('ORD-93041')">
                        Lihat Detail
                    </button>

                    <!-- DETAIL RETUR SUDAH JADI HALAMAN -->
                    <button
    type="button"
    class="btn btn-purple"
    onclick="openReturnDetailModal('ORD-93041')"
>
    <i class="fa-solid fa-arrows-rotate"></i>
    Detail Retur
</button>

                </div>

            </div>

        </article>

    </div>


    <!-- EMPTY -->
    <div
        class="empty-state"
        id="emptyOrders"
        style="display:none;">

        <span class="material-symbols-outlined">
            folder_open
        </span>

        <h3>Pesanan tidak ditemukan</h3>

        <p>
            Belum ada pesanan yang sesuai dengan pencarian kamu.
        </p>

    </div>

</div>


<!-- =====================================================
     MODAL : BATALKAN
===================================================== -->

<div class="profile-modal-overlay" id="cancelModal">

    <div class="profile-modal profile-modal-small">

        <div class="profile-modal-header">

            <div class="modal-title-group danger-title">

                <i class="fa-solid fa-triangle-exclamation"></i>

                <h3>Batalkan Pesanan?</h3>

            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeAllModals()">
                ×
            </button>

        </div>


        <div class="profile-modal-body">

            <p>
                Apakah kamu yakin ingin membatalkan pesanan
                <strong id="cancelOrderTarget">#ORD-98305</strong>?
            </p>

            <div class="modal-notice warning-notice">

                <i class="fa-solid fa-circle-info"></i>

                <span>
                    Voucher atau promo yang digunakan akan dikembalikan
                    sesuai ketentuan Umi Store.
                </span>

            </div>

            <label class="form-label">
                Alasan Pembatalan
            </label>

            <div class="radio-list">

                <label>
                    <input type="radio" name="cancel_reason" value="alamat" checked>
                    Ingin mengubah alamat pengiriman
                </label>

                <label>
                    <input type="radio" name="cancel_reason" value="varian">
                    Ingin mengubah warna / ukuran
                </label>

                <label>
                    <input type="radio" name="cancel_reason" value="promo">
                    Menemukan promo yang lebih hemat
                </label>

                <label>
                    <input type="radio" name="cancel_reason" value="metode">
                    Ingin mengganti metode pembayaran
                </label>

                <label>
                    <input type="radio" name="cancel_reason" value="lainnya">
                    Lainnya / perubahan rencana
                </label>

            </div>

        </div>


        <div class="profile-modal-footer">

            <button
                type="button"
                class="btn btn-secondary"
                onclick="closeAllModals()">
                Kembali
            </button>

            <button
                type="button"
                class="btn btn-danger"
                onclick="submitCancelModal()">
                Ya, Batalkan
            </button>

        </div>

    </div>

</div>


<!-- =====================================================
     MODAL : DETAIL PESANAN
===================================================== -->

<div class="profile-modal-overlay" id="orderDetailModal">

    <div class="profile-modal profile-modal-large">

        <div class="profile-modal-header">

            <div class="modal-title-group">

                <span class="modal-icon">
                    <i class="fa-solid fa-receipt"></i>
                </span>

                <div>
                    <h3 id="detailModalTitle">
                        Detail Pesanan
                    </h3>

                    <p id="detailModalSubtitle">
                        Informasi pesanan
                    </p>
                </div>

            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeAllModals()">
                ×
            </button>

        </div>


        <div class="profile-modal-body">

            <div class="modal-info-card">

                <div class="modal-card-heading">

                    <i class="fa-solid fa-location-dot"></i>

                    <h4>Alamat Pengiriman</h4>

                </div>

                <strong>
                    Siti Rahmawati
                </strong>

                <p>
                    (+62 812-3456-7890)
                </p>

                <p>
                    Jl. Gandaria Tengah III No. 18,
                    Kebayoran Baru, Jakarta Selatan,
                    DKI Jakarta 12130
                </p>

            </div>


            <div class="modal-info-card">

                <div class="modal-card-heading">

                    <i class="fa-solid fa-bag-shopping"></i>

                    <h4>Rincian Produk</h4>

                </div>

                <div class="modal-product">

                    <div>
                        <strong id="detailProductName">
                            Produk
                        </strong>

                        <p>
                            Varian: M · 1 pcs
                        </p>
                    </div>

                    <strong id="detailProductPrice">
                        Rp 0
                    </strong>

                </div>

            </div>


            <div class="price-summary">

                <div>
                    <span>Subtotal Produk</span>
                    <strong id="detailSubtotal">
                        Rp 0
                    </strong>
                </div>

                <div>
                    <span>Ongkos Kirim</span>
                    <strong>Rp 24.000</strong>
                </div>

                <div class="discount">
                    <span>Diskon Ongkir</span>
                    <strong>-Rp 24.000</strong>
                </div>

                <div class="total">
                    <span>Total Pembayaran</span>
                    <strong id="detailTotal">
                        Rp 0
                    </strong>
                </div>

            </div>

        </div>


        <div class="profile-modal-footer">

            <button
                type="button"
                class="btn btn-secondary"
                onclick="closeAllModals()">
                Tutup
            </button>

        </div>

    </div>

</div>


<!-- =====================================================
     MODAL : PEMBAYARAN
===================================================== -->

<div class="profile-modal-overlay" id="paymentModal">

    <div class="profile-modal profile-modal-small">

        <div class="profile-modal-header">

            <div class="modal-title-group">

                <span class="modal-icon">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </span>

                <h3>Konfirmasi Pembayaran</h3>

            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeAllModals()">
                ×
            </button>

        </div>


        <div class="profile-modal-body">

            <div class="payment-order">

                <span>Nomor Pesanan</span>
                <strong id="paymentOrderTarget">
                    #ORD-98305
                </strong>

            </div>

            <div class="payment-total">

                <span>Total yang harus dibayar</span>

                <strong id="paymentTotal">
                    Rp 389.000
                </strong>

            </div>


            <label class="form-label">
                Metode Pembayaran
            </label>

            <select class="form-input">
                <option>Transfer Virtual Account BCA</option>
                <option>Transfer Virtual Account BNI</option>
                <option>Transfer Virtual Account BRI</option>
                <option>QRIS</option>
            </select>

        </div>


        <div class="profile-modal-footer">

            <button
                type="button"
                class="btn btn-secondary"
                onclick="closeAllModals()">
                Batal
            </button>

            <button
                type="button"
                class="btn btn-primary"
                onclick="submitPaymentModal()">
                Lanjut Pembayaran
            </button>

        </div>

    </div>

</div>


<!-- =====================================================
     MODAL : BERI PENILAIAN
===================================================== -->

<div class="profile-modal-overlay" id="reviewModal">

    <div class="profile-modal profile-modal-review">

        <div class="profile-modal-header">

            <div class="modal-title-group">

                <i class="fa-solid fa-star"></i>

                <h3>Beri Penilaian Produk</h3>

            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeAllModals()">
                ×
            </button>

        </div>


        <div class="profile-modal-body">

            <div class="review-product">

                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjVoINOfx46tCwa-8JqV1OlFd609bCj1q9WF5ARMUhnC81Scn5RYKLizoiui4WtRGY8-EwV2QjmbajprrkDDQTyXJ50AKGQ9b897vwJANF2azHP2fklSZ3iMfRGRU89mp5-LxVpt11SmBiq9_q8ECRvIUoR1k4k-AFs1P1FfmjF59Vew_Q--X3hje2GGqNaMLXmqti7xnS8GLiG-Ei1hQr69CDCHBuM4AknymTHp-EV0EcfH1-tVTKXA"
                    alt="Gamis">

                <div>
                    <strong>
                        Gamis Rayon Viscose Bohemian Olive
                    </strong>

                    <p>
                        Varian XL · Pesanan #ORD-95110
                    </p>
                </div>

            </div>


            <div class="rating-box">

                <p>
                    Bagaimana kualitas produk ini?
                </p>

                <div
                    class="rating-stars"
                    id="ratingStarContainer">

                    @for ($i = 1; $i <= 5; $i++)
                        <button
                            type="button"
                            onclick="setStarRating({{ $i }})"
                            data-rating="{{ $i }}">
                            ★
                        </button>
                    @endfor

                </div>

                <strong id="starRatingText">
                    5 Bintang · Sangat Memuaskan
                </strong>

            </div>


            <div class="form-group">

                <label class="form-label">
                    Tulis Ulasan
                </label>

                <textarea
                    id="reviewText"
                    class="form-textarea"
                    rows="4"
                    placeholder="Ceritakan kualitas bahan, kerapian jahitan, dan kenyamanan saat dipakai..."></textarea>

            </div>


            <!-- UPLOAD FOTO / VIDEO -->
            <div class="form-group">

                <label class="form-label">
                    Foto / Video Produk
                    <span class="optional-label">
                        Opsional
                    </span>
                </label>

                <input
                    type="file"
                    id="reviewMedia"
                    accept="image/*,video/*"
                    multiple
                    hidden>

                <button
                    type="button"
                    class="upload-media-button"
                    onclick="document.getElementById('reviewMedia').click()">

                    <i class="fa-solid fa-camera"></i>

                    <span>
                        Tambah Foto / Video
                    </span>

                    <small>
                        Maksimal 5 foto dan 1 video
                    </small>

                </button>


                <div
                    class="media-preview"
                    id="reviewMediaPreview">
                </div>

            </div>

        </div>


        <div class="profile-modal-footer">

            <button
                type="button"
                class="btn btn-secondary"
                onclick="closeAllModals()">
                Batal
            </button>

            <button
                type="button"
                class="btn btn-primary"
                onclick="submitReviewModal()">
                Kirim Ulasan
            </button>

        </div>

    </div>

</div>


<!-- =====================================================
     MODAL : LIHAT ULASAN
===================================================== -->

<div class="profile-modal-overlay" id="viewReviewModal">

    <div class="profile-modal profile-modal-review">

        <div class="profile-modal-header">

            <div class="modal-title-group">

                <span class="modal-icon star-icon">
                    <i class="fa-solid fa-comment-dots"></i>
                </span>

                <h3>Rincian Ulasan</h3>

            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeAllModals()">
                ×
            </button>

        </div>


        <div class="profile-modal-body">

            <div class="review-product">

                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuD73MenRbLRkGwf0N6TrYDCNf76hSaaYB4lyIFx6FP5m_Hqt1D4zdK4ZVc6DaK7ids-U8b0u4PXG7WFubzqPpTH1epSK2jEq439ydK9cB5nOjXU6Ctta3FlHGZdnv-pD9xaIzCFmFx_Ej8-dloqlSasoawzb7Qg1EwPIlEqPgsdfRmGer2bDz2jBl7qGR_o5aaWvHPHGNnDxz236zrThNfYrYgQIfZGPJBeqXvswInGicukxYZKjI0fiw"
                    alt="Cardigan">

                <div>
                    <strong>
                        Basic Knit Cardigan Ivory
                    </strong>

                    <p>
                        Varian M · Pesanan #ORD-94200
                    </p>
                </div>

            </div>


            <div class="existing-rating">

                <div class="existing-stars">
                    ★★★★★
                </div>

                <strong>
                    5.0 / 5.0
                </strong>

            </div>


            <div class="review-content">

                <span>
                    ULASAN TESTIMONI
                </span>

                <p>
                    Cardigan rajutnya lembut dan nyaman digunakan.
                    Warnanya juga mudah dipadukan dengan pakaian lain.
                    Pengiriman cepat dan kemasannya rapi.
                </p>

            </div>


            <!-- DOKUMENTASI DARI PEMBELI -->
            <div class="buyer-media">

                <span>
                    FOTO DARI PEMBELI
                </span>

                <div class="buyer-media-grid">

                    <div class="buyer-media-item">
                        <img
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuD73MenRbLRkGwf0N6TrYDCNf76hSaaYB4lyIFx6FP5m_Hqt1D4zdK4ZVc6DaK7ids-U8b0u4PXG7WFubzqPpTH1epSK2jEq439ydK9cB5nOjXU6Ctta3FlHGZdnv-pD9xaIzCFmFx_Ej8-dloqlSasoawzb7Qg1EwPIlEqPgsdfRmGer2bDz2jBl7qGR_o5aaWvHPHGNnDxz236zrThNfYrYgQIfZGPJBeqXvswInGicukxYZKjI0fiw"
                            alt="Dokumentasi pembeli">
                    </div>

                </div>

            </div>

        </div>


        <div class="profile-modal-footer">

            <button
                type="button"
                class="btn btn-secondary"
                onclick="closeAllModals()">
                Tutup
            </button>

        </div>

    </div>

</div>

<!-- =====================================================
     MODAL : DETAIL RETUR
===================================================== -->

<div
    class="profile-modal-overlay"
    id="returnDetailModal"
>

    <div class="profile-modal profile-modal-large">

        <!-- HEADER -->
        <div class="profile-modal-header">

            <div class="modal-title-group">

                <span
                    class="modal-icon"
                    style="background:#f1eaff;color:#7c3aed;"
                >
                    <i class="fa-solid fa-arrows-rotate"></i>
                </span>

                <div>

                    <h3>
                        Detail Retur
                    </h3>

                    <p id="returnDetailSubtitle">
                        #ORD-93041 · Pengembalian
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="modal-close"
                onclick="closeAllModals()"
            >
                ×
            </button>

        </div>


        <!-- BODY -->
        <div class="profile-modal-body">

            <!-- STATUS -->
            <div class="return-detail-status">

                <div class="return-status-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <div>

                    <strong>
                        Pengembalian Disetujui
                    </strong>

                    <p>
                        Pengajuan retur kamu telah disetujui oleh Umi Store.
                    </p>

                </div>

            </div>

            <!-- PRODUK -->
            <div class="modal-info-card">

                <div class="modal-card-heading">

                    <i class="fa-solid fa-box-open"></i>

                    <h4>
                        Produk yang Dikembalikan
                    </h4>

                </div>


                <div class="return-product">

                    <div>

                        <span class="product-category">
                            Midi Dress
                        </span>

                        <h4>
                            Midi Dress Katun Embroidery Terracotta
                        </h4>

                        <p>
                            Varian: S · 1 item
                        </p>

                        <strong>
                            Rp 315.000
                        </strong>

                    </div>

                </div>

            </div>


            <!-- INFORMASI -->
            <div class="return-detail-grid">

                <div class="modal-info-card">

                    <div class="modal-card-heading">

                        <i class="fa-solid fa-circle-info"></i>

                        <h4>
                            Informasi Retur
                        </h4>

                    </div>


                    <div class="return-info-row">
                        <span>Nomor Pesanan</span>
                        <strong>#ORD-93041</strong>
                    </div>

                    <div class="return-info-row">
                        <span>Tanggal Pengajuan</span>
                        <strong>05 Okt 2024</strong>
                    </div>

                    <div class="return-info-row">
                        <span>Alasan</span>
                        <strong>Produk rusak / jahitan cacat</strong>
                    </div>

                    <div class="return-info-row">
                        <span>Status</span>
                        <strong class="return-purple-text">
                            Pengembalian Disetujui
                        </strong>
                    </div>

                </div>


                <div class="modal-info-card">

                    <div class="modal-card-heading">

                        <i class="fa-solid fa-money-bill-wave"></i>

                        <h4>
                            Pengembalian Dana
                        </h4>

                    </div>


                    <div class="refund-total">

                        <span>
                            Total Pengembalian
                        </span>

                        <strong>
                            Rp 315.000
                        </strong>

                    </div>


                    <div class="refund-account-detail">

                        <span>
                            Rekening Pengembalian
                        </span>

                        <strong>
                            BCA ···· 8912
                        </strong>

                        <small>
                            Siti Rahmawati · Terverifikasi
                        </small>

                    </div>

                </div>

            </div>

        </div>


        <!-- FOOTER -->
        <div class="profile-modal-footer">

            <button
                type="button"
                class="btn btn-secondary"
                onclick="closeAllModals()"
            >
                Tutup
            </button>

        </div>

    </div>

</div>

<script src="{{ asset('js/pesanan.js') }}"></script>

@endsection