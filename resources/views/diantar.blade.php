@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/diantar.css') }}">
@endpush

@section('content')
<div class="checkout-container">
    <main>
        <h1 class="page-title">Alamat Pengiriman</h1>

        <div class="address-card" id="activeAddressCard">
            <div class="address-header">
                <div class="recipient-info">
                    <i class="fa-solid fa-location-dot"></i>
                    <span id="displayRecipient">Memuat alamat...</span>
                </div>
            </div>
            <p class="address-detail" id="displayAddressText">Memuat alamat...</p>
            <div class="address-note" id="displayNoteBox">
                <i class="fa-solid fa-circle-info"></i>
                <span id="displayNoteText"></span>
            </div>
            <div class="address-actions">
                <button type="button" id="btnOpenUbahAlamat">
                    <i class="fa-solid fa-pen"></i> Ubah Alamat
                </button>
            </div>
        </div>

        <h3 class="shipping-section-title">Pilih metode pengiriman</h3>

        <div class="shipping-option-card selected" data-shipping-type="delivery" onclick="selectShipping(this, 18000, 'delivery')">
            <div class="shipping-left">
                <input type="radio" name="shipping_method" value="delivery" checked>
                <div class="shipping-info">
                    <h4>Dikirim <span class="badge-rekomendasi">Reguler</span></h4>
                    <p>Reguler — J&amp;T Express / SiCepat</p>
                    <p>Estimasi tiba dalam 2–3 hari kerja</p>
                </div>
            </div>
            <div class="shipping-price">Rp 18.000</div>
        </div>

        <div class="shipping-option-card" data-shipping-type="pickup" onclick="selectShipping(this, 0, 'pickup')">
            <div class="shipping-left">
                <input type="radio" name="shipping_method" value="pickup">
                <div class="shipping-info">
                    <h4>Ambil di Toko</h4>
                    <p>Ambil pesanan langsung di Umi Store</p>
                    <p>Biaya pengambilan Rp 0</p>
                </div>
            </div>
            <div class="shipping-price">GRATIS</div>
        </div>

        <div class="store-pickup-info" id="storePickupInfo" style="display:none;">
            <div class="store-pickup-header">
                <i class="fa-solid fa-store"></i>
                <div>
                    <h4>Lokasi Pengambilan</h4>
                    <p>Umi Store</p>
                </div>
            </div>
            <div class="store-pickup-detail">
                <div><i class="fa-solid fa-location-dot"></i><span>Umi Store</span></div>
                <div><i class="fa-regular fa-clock"></i><span>Senin–Sabtu, 09.00–20.00 WIB</span></div>
            </div>
            <div class="pickup-time-group">
                <label for="pickupTime">Waktu Pengambilan <span>(opsional)</span></label>
                <select id="pickupTime" class="form-control">
                    <option value="">Pilih waktu pengambilan</option>
                    <option value="09:00-12:00">09.00–12.00 WIB</option>
                    <option value="12:00-15:00">12.00–15.00 WIB</option>
                    <option value="15:00-18:00">15.00–18.00 WIB</option>
                    <option value="18:00-20:00">18.00–20.00 WIB</option>
                </select>
            </div>
        </div>

        <div class="checkout-nav-bottom">
            <a href="{{ route('keranjang') }}" class="btn-back-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Keranjang</a>
            <button type="button" class="btn-submit-checkout" id="btnLanjutBayar">Lanjutkan ke Pembayaran <i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </main>

    <aside>
        <div class="summary-header">
            <h2>Ringkasan Pesanan</h2>
            <span class="summary-badge" id="summaryItemCountBadge">0 Produk</span>
        </div>
        <div id="summaryItemsContainer">
            <div class="summary-empty" id="summaryEmptyState" style="display:none;">
                <i class="fa-solid fa-bag-shopping"></i>
                <p>Belum ada produk dalam pesanan.</p>
            </div>
        </div>
        <div class="price-row"><span>Subtotal Produk</span><span id="subtotalDisplay">Rp 0</span></div>
        <div class="price-row discount" id="discountRow" style="display:none;"><span>Diskon Voucher Belanja</span><span id="discountDisplay">-Rp 0</span></div>
        <div class="price-row"><span>Biaya Pengiriman</span><span id="shippingFeeDisplay">Rp 18.000</span></div>
        <div class="price-row free-ship"><span>Biaya Layanan &amp; Asuransi</span><span>GRATIS</span></div>
        <hr class="divider-line">
        <div class="total-row"><span class="total-label">Total Tagihan</span><span class="total-amount" id="grandTotalDisplay">Rp 0</span></div>
        <div class="tax-note">Termasuk PPN dan perlindungan transit</div>
    </aside>
</div>

<div class="modal-overlay" id="modalUbahAlamat" style="display:none;">
    <div class="modal-card">
        <div class="modal-header">
            <h3>Ubah Alamat Pengiriman</h3>
            <button type="button" class="modal-close" id="closeUbahModal"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="form-grid">
            <div class="form-group"><label for="editName">Nama Penerima</label><input type="text" id="editName" class="form-control"></div>
            <div class="form-group"><label for="editPhone">Nomor Handphone</label><input type="tel" id="editPhone" class="form-control"></div>
            <div class="form-group full"><label for="editStreet">Alamat Lengkap</label><textarea id="editStreet" class="form-control" rows="3"></textarea></div>
            <div class="form-group full"><label for="editNote">Catatan Pengiriman <span>(opsional)</span></label><input type="text" id="editNote" class="form-control"></div>
        </div>
        <button type="button" class="btn-save-address" id="btnSaveEditAddress">Simpan Perubahan</button>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
window.umiCheckoutConfig = {
    routes: { cart: @json(route('keranjang')), paymentToken: @json(route('midtrans.snap')), profile: @json(route('profile.pesanan')) },
    csrfToken: @json(csrf_token())
};
</script>
<script src="{{ asset('js/diantar.js') }}"></script>
@endpush
