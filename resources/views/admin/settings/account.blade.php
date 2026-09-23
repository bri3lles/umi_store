@extends('admin.layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Pengaturan Akun &amp; Toko</h1>
            <p class="page-subtitle">Kelola profil pemilik toko, informasi operasional Umi Store, rekening pembayaran, dan integrasi kurir pengiriman.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert--danger" role="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" class="form-fill" data-settings-form novalidate>
        @csrf
        @method('PUT')

        <div class="settings-grid">
            {{-- Profil pemilik --}}
            <section class="form-card">
                <header class="form-card__head">
                    <div><h2><x-admin.icon name="settings" :size="18" class="head-ico" /> Profil Pemilik Toko</h2></div>
                    <span class="tag">Super Admin</span>
                </header>

                <div class="profile-strip">
                    <div class="avatar-edit">
                        <x-admin.avatar :name="$profile['name']" :size="64" />
                        <button type="button" class="avatar-edit__btn" title="Ganti foto" aria-label="Ganti foto profil"><x-admin.icon name="camera" :size="14" /></button>
                    </div>
                    <div>
                        <b class="profile-strip__name">{{ $profile['name'] }}</b>
                        <span class="profile-strip__role">{{ $profile['role'] }}</span>
                        <span class="profile-strip__since"><i></i> {{ $profile['since'] }}</span>
                    </div>
                </div>

                <div class="stack">
                    <div class="field">
                        <label class="field__label" for="name">Nama Lengkap Pemilik</label>
                        <div class="prefix-input prefix-input--icon"><x-admin.icon name="award" :size="16" /><input type="text" id="name" name="name" class="input" value="{{ old('name', $profile['name']) }}"></div>
                    </div>
                    <div class="field">
                        <div class="field__row"><label class="field__label" for="email">Email Administrator</label><span class="verified-tag"><x-admin.icon name="check-circle" :size="13" /> Terverifikasi</span></div>
                        <div class="prefix-input prefix-input--icon"><x-admin.icon name="mail" :size="16" /><input type="email" id="email" name="email" class="input" value="{{ old('email', $profile['email']) }}"></div>
                    </div>
                    <div class="field">
                        <div class="field__row"><label class="field__label" for="phone">No. Handphone / WhatsApp Utama</label><span class="verified-tag verified-tag--muted">Tersinkronisasi CS</span></div>
                        <div class="prefix-input prefix-input--icon"><x-admin.icon name="phone" :size="16" /><input type="text" id="phone" name="phone" class="input" value="{{ old('phone', $profile['phone']) }}"></div>
                    </div>
                </div>
            </section>

            {{-- Operasional & alamat --}}
            <section class="form-card">
                <header class="form-card__head">
                    <div><h2><x-admin.icon name="store" :size="18" class="head-ico" /> Operasional &amp; Alamat Toko</h2></div>
                    <label class="switch switch--sm"><span>Toko {{ $store['open'] ? 'Buka' : 'Tutup' }}</span>
                        <input type="checkbox" name="is_open" value="1" data-store-open @checked($store['open'])><span class="switch__track"></span>
                    </label>
                </header>
                <div class="stack">
                    <div class="form-grid">
                        <div class="field">
                            <label class="field__label" for="store_name">Nama Resmi Toko</label>
                            <input type="text" id="store_name" name="store_name" class="input" value="{{ old('store_name', $store['name']) }}">
                        </div>
                        <div class="field">
                            <span class="field__label">Jam Layanan &amp; Pick-Up Pengiriman</span>
                            <div class="time-range">
                                <input type="time" name="open_time" class="input" value="{{ old('open_time', $store['open_time']) }}">
                                <span>–</span>
                                <input type="time" name="close_time" class="input" value="{{ old('close_time', $store['close_time']) }}">
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="field__label" for="tagline">Slogan / Tagline Promosi</label>
                        <input type="text" id="tagline" name="tagline" class="input" value="{{ old('tagline', $store['tagline']) }}">
                    </div>
                    <div class="field">
                        <div class="field__row"><label class="field__label" for="address">Alamat Gudang Utama / Titik Asal Ekspedisi</label><span class="verified-tag"><x-admin.icon name="check-circle" :size="13" /> Pin Point Terverifikasi</span></div>
                        <textarea id="address" name="address" rows="2" class="input textarea">{{ old('address', $store['address']) }}</textarea>
                    </div>
                    <div class="map-box">
                        <div class="map-box__fake"><x-admin.icon name="map-pin" :size="26" /></div>
                        <span class="map-box__pin"><x-admin.icon name="map-pin" :size="14" /> {{ $store['address_label'] }}</span>
                    </div>
                </div>
            </section>
        </div>

        <div class="settings-actions">
            <button type="reset" class="btn btn--secondary">Batalkan Perubahan</button>
            <button type="submit" class="btn btn--primary"><x-admin.icon name="check" :size="17" /> Simpan Semua Perubahan</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/settings.js') }}" defer></script>
@endpush