@extends('profile.index')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/wishlist.css') }}">
@endpush

@section('profile-content')
<div class="wishlist-page">
    <div class="wishlist-heading">
        <div>
            <h1>Wishlist Saya</h1>
            <p>Produk yang kamu simpan untuk dibeli nanti.</p>
        </div>
    </div>

    <div class="wishlist-product-grid" id="wishlistGrid"></div>

    <div id="wishlistEmpty" style="display:none;text-align:center;padding:64px 20px;color:#64748b;">
        <i class="fa-regular fa-heart" style="font-size:42px;color:#002D72;margin-bottom:14px;"></i>
        <h3 style="color:#002D72;margin-bottom:7px;">Wishlist masih kosong</h3>
        <p>Tambahkan produk yang kamu suka dari halaman katalog.</p>
        <a href="{{ route('katalog') }}" style="display:inline-flex;margin-top:18px;padding:11px 18px;border-radius:10px;background:#002D72;color:#fff;text-decoration:none;font-weight:600;">Lihat Katalog</a>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/wishlist.js') }}"></script>
@endpush
