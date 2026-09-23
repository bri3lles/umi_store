{{-- Dipakai create & edit. $product = null saat tambah produk. --}}
@php
    $isEdit = ! is_null($product);
    $val = fn ($key, $default = '') => old($key, $product?->{$key} ?? $default);
    $money = function ($key) use ($product) {
        $old = old($key);
        if ($old !== null) return $old;
        $n = $product?->{$key} ?? null;
        return $n === null ? '' : number_format($n, 0, ',', '.');
    };
    $allSizes = ['S', 'M', 'L', 'XL', 'XXL', 'All Size'];
    $materials = ['Katun Rayon Twill', 'Crinkle Airflow', 'Ceruty Babydoll', 'Voal Ultrafine'];
    $couriersSel = old('couriers', $product->couriers ?? array_keys($couriers));
    $variantCfg = [
        'colors' => $product->colors ?? [],
        'sizes' => $product->sizes ?? [],
        'rows' => $product->variants ?? [],
        'palette' => $colorPalette,
    ];
@endphp

<form method="POST" enctype="multipart/form-data" novalidate data-product-form
      action="{{ $isEdit ? route('admin.products.update', $product->id) : route('admin.products.store') }}" class="form-fill">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="product-layout">
        {{-- ================= KOLOM KIRI ================= --}}
        <div class="product-col">

            {{-- 1. Informasi dasar --}}
            <section class="form-card">
                <header class="form-card__head">
                    <span class="step">1</span>
                    <div><h2>Informasi Dasar Produk</h2><p>Judul utama, deskripsi busana, kategori katalog, dan identifikasi stok.</p></div>
                    <span class="tag">Wajib Diisi</span>
                </header>
                <div class="stack">
                    <div class="field">
                        <div class="field__row">
                            <label class="field__label" for="name">Nama Produk Busana <i>*</i></label>
                            <span class="field__meta" data-name-count>0 / 100 karakter</span>
                        </div>
                        <input type="text" id="name" name="name" class="input @error('name') is-invalid @enderror" maxlength="100" required
                               value="{{ $val('name') }}" placeholder="Contoh: Gamis Silk Motif Floral Ayana Series">
                        <span class="field__hint">Sertakan jenis busana, bahan kain, dan nama model agar mudah dicari pelanggan.</span>
                        @error('name')<span class="field__error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-grid">
                        <div class="field">
                            <label class="field__label" for="category">Kategori Utama <i>*</i></label>
                            <select id="category" name="category" class="select @error('category') is-invalid @enderror" required>
                                <option value="" disabled @selected(! $val('category'))>Pilih kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}" @selected($val('category') === $cat)>{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category')<span class="field__error">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label class="field__label" for="material">Bahan / Material Kain</label>
                            <input type="text" id="material" name="material" class="input" value="{{ $val('material') }}" placeholder="Contoh: Silk Premium &amp; Furing Rayon">
                        </div>
                    </div>

                    <div class="chips-row">
                        <span>Rekomendasi bahan:</span>
                        @foreach ($materials as $m)
                            <button type="button" class="chip-btn" data-material="{{ $m }}">{{ $m }}</button>
                        @endforeach
                    </div>

                    <div class="form-grid">
                        <div class="field">
                            <div class="field__row">
                                <label class="field__label" for="sku">Kode Induk / SKU Toko <i>*</i></label>
                                <button type="button" class="field__link" data-sku-auto><x-admin.icon name="refresh" :size="13" /> Buat Otomatis</button>
                            </div>
                            <input type="text" id="sku" name="sku" class="input" required value="{{ $val('sku') }}" placeholder="UMI-GMS-AYN01">
                        </div>
                        <div class="field">
                            <label class="field__label" for="label">Label / Koleksi Toko</label>
                            <input type="text" id="label" name="label" class="input" value="{{ $val('label') }}" placeholder="Contoh: Edisi Ramadhan 2025, Best Seller">
                        </div>
                    </div>

                    <div class="field">
                        <div class="field__row">
                            <label class="field__label" for="description">Deskripsi Lengkap Busana <i>*</i></label>
                            <span class="field__meta">Gunakan panduan ukuran &amp; busui-friendly</span>
                        </div>
                        <div class="editor">
                            <div class="editor__bar">
                                <button type="button" data-fmt="**" title="Tebal" aria-label="Tebal"><b>B</b></button>
                                <button type="button" data-fmt="_" title="Miring" aria-label="Miring"><i>I</i></button>
                                <button type="button" data-fmt="__" title="Garis bawah" aria-label="Garis bawah"><u>U</u></button>
                                <button type="button" data-fmt="ul" title="Daftar poin" aria-label="Daftar poin">•</button>
                                <button type="button" data-fmt="ol" title="Daftar angka" aria-label="Daftar angka">1.</button>
                                <span class="editor__sep"></span>
                                <button type="button" class="editor__tpl" data-template>Pakai Format Standar Umi</button>
                            </div>
                            <textarea id="description" name="description" rows="9" required placeholder="Ceritakan keunggulan, bahan, dan detail busana...">{{ $val('description') }}</textarea>
                        </div>
                        @error('description')<span class="field__error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </section>

            {{-- 2. Foto & galeri --}}
            <section class="form-card" data-gallery data-initial="{{ json_encode($product->photos ?? []) }}">
                <header class="form-card__head">
                    <span class="step">2</span>
                    <div><h2>Foto &amp; Galeri Produk</h2><p>Upload foto asli busana dari sudut tampak depan, samping, dan detail serat kain.</p></div>
                    <span class="tag" data-gallery-count>0 / 5 Foto Terpasang</span>
                </header>
                <label class="dropzone" data-dropzone>
                    <input type="file" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple>
                    <span class="dropzone__icon"><x-admin.icon name="cloud-upload" :size="24" /></span>
                    <span>Tarik &amp; letakkan foto di sini, atau <u>klik untuk memilih file</u></span>
                    <small>Format didukung: JPG, PNG, WEBP (maksimal 5MB per berkas). Resolusi ideal 1200 × 1200 piksel (1:1).</small>
                </label>
                <span class="field__error" data-gallery-error></span>
                <div class="thumbs" data-gallery-grid></div>
            </section>

            {{-- 3. Varian --}}
            <section class="form-card">
                <header class="form-card__head">
                    <span class="step">3</span>
                    <div><h2>Varian Produk (Warna &amp; Ukuran)</h2><p>Atur kombinasi warna dan ukuran serta ketersediaan stok tiap varian.</p></div>
                    <label class="switch"><span>Aktifkan Varian</span>
                        <input type="checkbox" name="variants_enabled" value="1" data-variants-toggle @checked(old('variants_enabled', true))>
                        <span class="switch__track"></span>
                    </label>
                </header>

                <fieldset class="reset" data-variants-panel data-initial="{{ json_encode($variantCfg) }}">
                    <div class="field__row">
                        <h3 class="sub-title">1. Pilihan Warna Busana</h3>
                        <button type="button" class="field__link" data-add-color><x-admin.icon name="plus-circle" :size="14" /> Tambah Warna Baru</button>
                    </div>
                    <div class="color-form is-hidden" data-color-form>
                        <input type="text" class="input" data-color-name placeholder="Nama warna, mis. Mocca Warm" maxlength="30">
                        <input type="color" class="color-input" data-color-hex value="#8B6B5A" aria-label="Pilih warna">
                        <button type="button" class="btn btn--primary" data-color-submit>Tambah</button>
                    </div>
                    <div class="color-list" data-colors></div>

                    <h3 class="sub-title">2. Pilihan Ukuran (Size)</h3>
                    <div class="size-list">
                        @foreach ($allSizes as $size)
                            <button type="button" class="size-btn" data-size="{{ $size }}" aria-pressed="false">{{ $size }}</button>
                        @endforeach
                    </div>

                    <div class="table-wrap variant-wrap">
                        <table class="variant-table">
                            <thead><tr><th>Kombinasi Variasi</th><th>Harga Tambahan</th><th>Stok Awal</th><th>SKU Khusus Varian</th><th>Status</th></tr></thead>
                            <tbody data-variant-body></tbody>
                        </table>
                    </div>
                </fieldset>
            </section>
        </div>

        {{-- ================= KOLOM KANAN ================= --}}
        <div class="product-col">

            {{-- 4. Harga --}}
            <section class="form-card">
                <header class="form-card__head">
                    <span class="step">4</span>
                    <div><h2>Harga &amp; Keuntungan</h2><p>Tetapkan modal serta harga jual retail.</p></div>
                </header>
                <div class="stack">
                    <div class="field">
                        <label class="field__label" for="cost_price">Harga Modal / HPP Satuan</label>
                        <div class="prefix-input"><span>Rp</span><input type="text" inputmode="numeric" id="cost_price" name="cost_price" class="input" data-money value="{{ $money('cost_price') }}" placeholder="0"></div>
                        <span class="field__hint">Biaya jahit kain konveksi per helai.</span>
                    </div>
                    <div class="field">
                        <label class="field__label" for="price">Harga Jual Normal <i>*</i></label>
                        <div class="prefix-input prefix-input--accent"><span>Rp</span><input type="text" inputmode="numeric" id="price" name="price" class="input @error('price') is-invalid @enderror" data-money required value="{{ $money('price') }}" placeholder="0"></div>
                        @error('price')<span class="field__error">{{ $message }}</span>@enderror
                        <span class="field__hint field__hint--accent" data-margin></span>
                    </div>
                    <div class="field">
                        <label class="field__label" for="promo_price">Harga Coret / Promosi (Opsional)</label>
                        <div class="prefix-input"><span>Rp</span><input type="text" inputmode="numeric" id="promo_price" name="promo_price" class="input" data-money value="{{ $money('promo_price') }}" placeholder="0"></div>
                        <span class="field__hint">Akan ditampilkan dengan coretan untuk menarik minat pembeli.</span>
                    </div>
                </div>
            </section>

            {{-- 5. Inventaris --}}
            <section class="form-card">
                <header class="form-card__head">
                    <span class="step">5</span>
                    <div><h2>Inventaris &amp; Ketersediaan</h2><p>Kontrol batas minimum dan status PO.</p></div>
                </header>
                <div class="stack">
                    <div class="field">
                        <div class="field__row">
                            <label class="field__label" for="stock">Total Stok Terhitung</label>
                            <span class="tag" data-stock-mode>Otomatis dari varian</span>
                        </div>
                        <div class="suffix-input"><input type="number" min="0" id="stock" name="stock" class="input" data-stock-total value="{{ $val('stock', 0) }}"><span>Pcs</span></div>
                    </div>
                    <div class="field">
                        <label class="field__label" for="stock_alert">Peringatan Stok Menipis (Alarm)</label>
                        <div class="suffix-input"><input type="number" min="0" id="stock_alert" name="stock_alert" class="input" value="{{ $val('stock_alert', 5) }}"><span>Pcs</span></div>
                        <span class="field__hint">Umi akan menerima notifikasi jika sisa stok di bawah angka ini.</span>
                    </div>
                    <div class="field">
                        <span class="field__label">Status Kesiapan Produk</span>
                        <div class="seg">
                            <label class="seg__opt"><input type="radio" name="readiness" value="ready" @checked($val('readiness', 'ready') === 'ready')><span><b>Ready Stock</b><small>Siap Kirim</small></span></label>
                            <label class="seg__opt"><input type="radio" name="readiness" value="po" @checked($val('readiness', 'ready') === 'po')><span><b>Pre-Order (PO)</b><small>Estimasi 7–10 hari</small></span></label>
                        </div>
                    </div>
                </div>
            </section>

            {{-- 6. Berat & ekspedisi --}}
            <section class="form-card">
                <header class="form-card__head">
                    <span class="step">6</span>
                    <div><h2>Berat &amp; Ekspedisi</h2><p>Hitungan ongkos kirim kurir otomatis.</p></div>
                </header>
                <div class="stack">
                    <div class="field">
                        <label class="field__label" for="weight">Berat Paket Busana <i>*</i></label>
                        <div class="suffix-input"><input type="number" min="1" id="weight" name="weight" class="input @error('weight') is-invalid @enderror" required value="{{ $val('weight') }}" placeholder="0"><span>Gram</span></div>
                        <span class="field__hint">1 kg muat sekitar 2–3 potong gamis/tunik.</span>
                        @error('weight')<span class="field__error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <span class="field__label">Dimensi Paket (cm) <small class="text-muted">- Opsional</small></span>
                        <div class="dims">
                            <input type="number" min="0" name="length" class="input" value="{{ $val('length') }}" placeholder="P" aria-label="Panjang (cm)">
                            <input type="number" min="0" name="width" class="input" value="{{ $val('width') }}" placeholder="L" aria-label="Lebar (cm)">
                            <input type="number" min="0" name="height" class="input" value="{{ $val('height') }}" placeholder="T" aria-label="Tinggi (cm)">
                        </div>
                    </div>
                    <div class="field">
                        <span class="field__label">Pilihan Ekspedisi Aktif</span>
                        @foreach ($couriers as $key => [$label, $icon])
                            <label class="ship-opt">
                                <x-admin.icon :name="$icon" :size="20" />
                                <span>{{ $label }}</span>
                                <input type="checkbox" name="couriers[]" value="{{ $key }}" @checked(in_array($key, $couriersSel))>
                            </label>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- 7. Visibilitas --}}
            <section class="form-card">
                <header class="form-card__head">
                    <span class="step">7</span>
                    <div><h2>Visibilitas &amp; Promosi</h2><p>Tampilkan ke calon pembeli di etalase web.</p></div>
                </header>
                <div class="stack">
                    <div class="toggle-row">
                        <div><b>Tayangkan di Etalase</b><small>Langsung bisa dibeli pelanggan</small></div>
                        <label class="switch"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->active ?? true))><span class="switch__track"></span><span class="sr-only">Tayangkan di etalase</span></label>
                    </div>
                    <label class="feature-row">
                        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->featured ?? false))>
                        <span><b><x-admin.icon name="award" :size="15" /> Tandai Rekomendasi Beranda</b><small>Produk akan muncul pada carousel banner "Koleksi Favorit Pilihan Umi" di halaman depan toko.</small></span>
                    </label>
                </div>
            </section>

            <button type="submit" class="btn btn--primary btn--block"><x-admin.icon name="cloud-upload" :size="18" /> {{ $isEdit ? 'Simpan Perubahan' : 'Terbitkan Busana Sekarang' }}</button>
        </div>
    </div>
</form>