@extends('layouts.app')

@section('title', 'Ajukan Retur - Umi Store')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/retur.css') }}">
@endpush

@section('content')

<main class="return-page">
    <div class="return-container">

        <div class="return-header">
            <div class="return-title">
                <a href="{{ route('profile.pesanan') }}" class="return-back" aria-label="Kembali ke pesanan">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <div>
                    <h1>Ajukan Retur</h1>
                    <p>Lengkapi formulir di bawah ini untuk mengajukan pengembalian produk atau dana.</p>
                </div>
            </div>

            <div class="return-order-info">
                <div>
                    <span>Nomor Pesanan</span>
                    <strong>#ORD-95110</strong>
                </div>

                <div class="return-info-divider"></div>

                <div>
                    <span>Waktu Diterima</span>
                    <strong>18 Okt 2024, 16:40 WIB</strong>
                </div>

                <div class="return-info-divider"></div>

                <div class="return-deadline">
                    <i class="fa-regular fa-clock"></i>
                    Sisa Waktu Retur: <strong>1 Hari Lagi</strong>
                </div>
            </div>
        </div>

        <div class="return-layout">

            <div class="return-main">

                <section class="return-card">
                    <div class="return-card-title">
                        <div class="step-number">1</div>
                        <div>
                            <h2>Produk yang Akan Diretur</h2>
                            <p>Produk berikut akan diproses dalam pengajuan retur ini</p>
                        </div>
                    </div>

                    <div class="return-products">
                        <div class="return-product" data-price="420000" data-name="Gamis Rayon Viscose Bohemia Olive">
                            <img src="https://www.gstatic.com/labs-code/stitch/stitch-placeholder-300x300.svg" alt="Gamis Rayon">
                            <div class="return-product-info">
                                <span class="product-label">Gamis Modern</span>
                                <h3>Gamis Rayon Viscose Bohemia Olive</h3>
                                <p>Variant: XL . Warna: Olive Forest</p>
                                <div class="return-product-bottom">
                                    <span>Jumlah: 1x</span>
                                    <strong>Rp 420.000</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="return-card">
                    <div class="return-card-title">
                        <div class="step-number">2</div>
                        <div>
                            <h2>Alasan Pengembalian Barang</h2>
                            <p>Pilih alasan utama pengembalian.</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="return-reason">Kategori Alasan Retur <span>*</span></label>
                        <select id="return-reason">
                            <option value="">Pilih alasan pengembalian</option>
                            <option value="rusak">Barang rusak / jahitan cacat / sobek</option>
                            <option value="ukuran">Salah ukuran / tidak sesuai size chart</option>
                            <option value="deskripsi">Produk tidak sesuai deskripsi / foto</option>
                            <option value="keliru">Salah kirim barang / warna keliru</option>
                            <option value="kurang">Komponen atau aksesoris tidak lengkap</option>
                            <option value="lainnya">Alasan lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="label-row">
                            <label for="return-description">Penjelasan Tambahan <span>*</span></label>
                            <small>Minimal 15 karakter</small>
                        </div>

                        <textarea
                            id="return-description"
                            rows="5"
                            maxlength="500"
                            placeholder="Jelaskan kendala produk..."></textarea>

                        <div class="textarea-counter">
                            <span>Jelaskan secara detail agar proses verifikasi lebih cepat.</span>
                            <span id="description-count">0 / 500</span>
                        </div>
                    </div>
                </section>

                <section class="return-card">
                    <div class="return-card-title">
                        <div class="step-number">3</div>
                        <div>
                            <h2>Upload Bukti Foto Produk</h2>
                            <p>Upload foto barang yang bermasalah.</p>
                        </div>
                    </div>

                    <div class="upload-grid" id="upload-preview">
                        <label class="upload-box">
                            <input
                                type="file"
                                id="return-images"
                                accept="image/jpeg,image/png"
                                multiple
                                hidden>

                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <strong>Tambah Foto</strong>
                            <span>JPG, PNG · Maks. 5MB</span>
                        </label>
                    </div>

                    <div class="return-tip">
                        <i class="fa-solid fa-lightbulb"></i>
                        <p>
                            <strong>Tips Bukti Valid:</strong>
                            Ambil foto dengan pencahayaan terang dan tunjukkan bagian produk yang bermasalah.
                        </p>
                    </div>
                </section>

                <section class="return-card">
                    <div class="return-card-title">
                        <div class="step-number">4</div>
                        <div>
                            <h2>Rekening Pengembalian Dana</h2>
                            <p>Dana refund akan dikirim ke rekening ini.</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="bank-name">Nama Bank</label>
                            <select id="bank-name">
                                <option>BCA</option>
                                <option>Bank Mandiri</option>
                                <option>BNI</option>
                                <option>BRI</option>
                                <option>BSI</option>
                                <option>CIMB Niaga</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="account-number">Nomor Rekening</label>
                            <input type="text" id="account-number" placeholder="Masukkan nomor rekening">
                        </div>

                        <div class="form-group full">
                            <label for="account-holder">Nama Pemilik Rekening</label>
                            <input
                                type="text"
                                id="account-holder"
                                value="{{ $user->nama ?? 'SITI RAHMAWATI' }}"
                                readonly>
                        </div>
                    </div>

                    <div class="shipping-method">
                        <label>Metode Pengiriman Paket Retur</label>

                        <div class="shipping-options">
                            <label class="shipping-option active">
                                <input type="radio" name="shipping_method" value="pickup" checked>
                                <div>
                                    <strong>Penjemputan Kurir</strong>
                                    <span class="free-badge">GRATIS</span>
                                    <p>Kurir akan menjemput paket setelah retur disetujui.</p>
                                </div>
                            </label>

                            <label class="shipping-option">
                                <input type="radio" name="shipping_method" value="dropoff">
                                <div>
                                    <strong>Drop-Off</strong>
                                    <p>Antar paket ke gerai ekspedisi.</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </section>

            </div>

            <aside class="return-sidebar">

                <section class="summary-card">
                    <div class="summary-header">
                        <h3>Ringkasan Pengajuan</h3>
                        <span></span>
                    </div>

                    <div id="selected-items-mini" class="selected-items">
                        <p class="empty-summary">Belum ada produk.</p>
                    </div>

                    <div class="summary-detail">
                        <div>
                            <span>Subtotal Produk</span>
                            <strong id="summary-subtotal">Rp 0</strong>
                        </div>

                        <div>
                            <span>Biaya Retur</span>
                            <strong class="free-text">GRATIS</strong>
                        </div>

                        <div>
                            <span>Metode Refund</span>
                            <strong>Transfer Bank</strong>
                        </div>
                    </div>

                    <div class="refund-total">
                        <span>Estimasi Nilai Refund</span>
                        <strong id="summary-total-refund">Rp 0</strong>
                    </div>

                    <label class="agreement">
                        <input type="checkbox" id="agreement">
                        <span>
                            Saya menyatakan bahwa data yang saya masukkan benar dan produk masih memenuhi ketentuan retur.
                        </span>
                    </label>

                    <button type="button" id="btn-submit-return" class="btn-submit-return" disabled>
                        <i class="fa-solid fa-paper-plane"></i>
                        Submit Pengajuan Retur
                    </button>

                    <a href="{{ route('profile.pesanan') }}" class="btn-cancel">Batal & Kembali</a>
                </section>

                <section class="process-card">
                    <h3>
                        <i class="fa-solid fa-diagram-project"></i>
                        Tahapan Setelah Mengajukan
                    </h3>

                    <div class="process-step">
                        <span>1</span>
                        <div>
                            <strong>Peninjauan Tim QC</strong>
                            <p>Admin memverifikasi pengajuan retur.</p>
                        </div>
                    </div>

                    <div class="process-step">
                        <span>2</span>
                        <div>
                            <strong>Penjemputan Paket</strong>
                            <p>Paket dijemput oleh kurir.</p>
                        </div>
                    </div>

                    <div class="process-step">
                        <span>3</span>
                        <div>
                            <strong>Pencairan Dana</strong>
                            <p>Dana refund dikirim ke rekening.</p>
                        </div>
                    </div>
                </section>

            </aside>
        </div>
    </div>
</main>

@endsection

@push('scripts')
<script src="{{ asset('js/retur.js') }}"></script>
@endpush
