@extends('profile.index')

@section('title', 'Pengaturan Akun - Umi Store')

@php
    $profileUser = $user ?? auth()->user();

    $nama = $profileUser->nama ?? 'Reva';
    $email = $profileUser->email ?? 'siti.rahmawati@email.com';
    $telepon = $profileUser->telepon ?? '0812-3456-7890';
    $username = $profileUser->username ?? 'reva.aulia';
    $tanggalLahir = $profileUser->tanggal_lahir ?? '2005-05-12';
    $jenisKelamin = $profileUser->jenis_kelamin ?? 'Perempuan';

    $foto = $profileUser->foto_profil
        ?? 'https://i.pinimg.com/1200x/6b/ff/7a/6bff7ab751622668e3ef078064de7cfe.jpg';
@endphp

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700&display=swap"
          rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
          rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/pengaturan.css') }}">
@endpush


@section('profile-content')

<div class="settings-page">


    {{-- PAGE HEADER --}}
        <div class="setting-heading">
        <div>
            <h1>Pengaturan Profil</h1>
            <p>Kelola data identitas personal, preferensi komunikasi belanja, dan proteksi akun Umi Store Anda.</p>
        </div>
    </div>


    {{-- CONTENT GRID --}}
    <div class="settings-grid">


        {{-- ===================================================== --}}
        {{-- INFORMASI PROFIL --}}
        {{-- ===================================================== --}}
        <section class="settings-card profile-settings-card">

            <div class="settings-card-header">

                <div class="settings-title-wrapper">

                    <div class="settings-icon-box">
                        <span class="material-symbols-outlined">badge</span>
                    </div>

                    <div>
                        <h3>Informasi Profil & Kontak</h3>
                        <p>Data ini digunakan untuk proses pesanan dan komunikasi.</p>
                    </div>

                </div>

            </div>


            {{-- FOTO PROFIL --}}
            <div class="profile-photo-section">

                <div class="profile-photo-wrapper">

                    <img
                        id="profilePreview"
                        src="{{ $foto }}"
                        alt="Foto profil"
                    >

                </div>


                <div class="profile-photo-actions">

                    <input
                        type="file"
                        id="profilePhotoInput"
                        accept="image/jpeg,image/png,image/webp"
                        hidden
                    >

                    <div class="photo-buttons">

                        <button
                            type="button"
                            class="btn-outline"
                            data-photo-upload
                        >
                            <span class="material-symbols-outlined">upload</span>
                            Unggah Foto Baru
                        </button>

                        <button
                            type="button"
                            class="btn-danger-outline"
                            data-photo-delete
                        >
                            Hapus
                        </button>

                    </div>

                    <p>
                        Format JPG, PNG atau WEBP maks. 2.0 MB.
                        Disarankan resolusi 1:1 persegi.
                    </p>

                </div>

            </div>


            <form class="settings-form" data-profile-form>

                @csrf

                {{-- NAMA --}}
                <div class="form-group">

                    <label for="nama">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ $nama }}"
                        placeholder="Masukkan nama lengkap"
                    >

                </div>


                {{-- USERNAME --}}
                <div class="form-group">

                    <label for="username">
                        Username Publik
                    </label>

                    <div class="input-with-prefix">

                        <span>@</span>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ $username }}"
                            placeholder="username"
                        >

                    </div>

                    <small>
                        Username digunakan untuk identitas publik Anda.
                    </small>

                </div>


                {{-- TANGGAL LAHIR --}}
                <div class="form-group">

                    <label for="tanggal_lahir">
                        Tanggal Lahir
                    </label>

                    <input
                        type="date"
                        id="tanggal_lahir"
                        name="tanggal_lahir"
                        value="{{ $tanggalLahir }}"
                    >

                </div>


                {{-- JENIS KELAMIN --}}
                <div class="form-group">

                    <label>
                        Jenis Kelamin
                    </label>

                    <div class="radio-group">

                        <label class="radio-option">
                            <input
                                type="radio"
                                name="jenis_kelamin"
                                value="Laki-laki"
                                {{ $jenisKelamin === 'Laki-laki' ? 'checked' : '' }}
                            >
                            <span>Laki-laki</span>
                        </label>

                        <label class="radio-option">
                            <input
                                type="radio"
                                name="jenis_kelamin"
                                value="Perempuan"
                                {{ $jenisKelamin === 'Perempuan' ? 'checked' : '' }}
                            >
                            <span>Perempuan</span>
                        </label>

                    </div>

                </div>


                {{-- EMAIL --}}
                <div class="verified-contact">

                    <div class="contact-icon">
                        <span class="material-symbols-outlined">mail</span>
                    </div>

                    <div class="contact-info">

                        <div class="contact-title">
                            <strong>Email</strong>
                        </div>

                        <p>{{ $email }}</p>

                    </div>

                    <button
    type="button"
    class="contact-change-btn"
    data-open-email-modal
>
    Ubah Email
</button>

                </div>


                {{-- NOMOR TELEPON --}}
                <div class="verified-contact">

                    <div class="contact-icon">
                        <span class="material-symbols-outlined">phone</span>
                    </div>

                    <div class="contact-info">

                        <div class="contact-title">

                            <strong>Nomor Telepon</strong>

                        </div>

                        <p>{{ $telepon }}</p>

                    </div>

                    <button
    type="button"
    class="contact-change-btn"
    data-open-phone-modal
>
    Ubah Nomor
</button>

                </div>


                {{-- CARD FOOTER --}}
                <div class="settings-card-footer">

                    <div class="secure-note">

                        <span class="material-symbols-outlined">
                            lock
                        </span>

                        <span>
                            Data Anda terlindungi 
                        </span>

                    </div>

                    <button
                        type="button"
                        class="btn-primary"
                        data-save-profile
                    >
                        <span class="material-symbols-outlined">save</span>
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </section>



        {{-- ===================================================== --}}
        {{-- KOLOM KANAN --}}
        {{-- ===================================================== --}}
        <div class="settings-right-column">


            {{-- KEAMANAN --}}
            <section class="settings-card security-card">

                <div class="settings-card-header">

                    <div class="settings-title-wrapper">

                        <div class="settings-icon-box">
                            <span class="material-symbols-outlined">
                                security
                            </span>
                        </div>

                        <div>
                            <h3>Keamanan & Kata Sandi</h3>
                            <p>Pastikan akun Anda tetap aman.</p>
                        </div>

                    </div>

                </div>


                <div class="security-content">

    <div class="security-summary">
        <div class="security-summary-icon">
            <span class="material-symbols-outlined">
                lock
            </span>
        </div>

        <div>
            <strong>Kata Sandi</strong>
            <p>
                Gunakan kata sandi yang kuat dan jangan bagikan kepada siapa pun.
            </p>
        </div>
    </div>

    <button
        type="button"
        class="security-change-btn"
        data-open-password-modal
    >
        <span class="material-symbols-outlined">
            lock_reset
        </span>
        Ubah Kata Sandi
    </button>

</div>

            </section>



            {{-- ================================================= --}}
            {{-- ALAMAT --}}
            {{-- ================================================= --}}
            <section class="settings-card address-card">

                <div class="settings-card-header">

                    <div class="settings-title-wrapper">

                        <div class="settings-icon-box">
                            <span class="material-symbols-outlined">
                                location_on
                            </span>
                        </div>

                        <div>
                            <h3>Alamat Pengiriman</h3>
                            <p>Digunakan untuk proses pengiriman pesanan.</p>
                        </div>

                    </div>

                </div>


                <div class="address-box">

                    <div class="address-top">

                        <button
                            type="button"
                            class="address-edit-btn"
                            data-open-address-modal
                        >
                            <span class="material-symbols-outlined">
                                edit
                            </span>
                            Ubah Alamat
                        </button>

                    </div>


                    <div class="address-user">

                        <strong>Reva</strong>

                        <span>0812-3456-7890</span>

                    </div>


                    <p class="address-text">
                        Jl. Contoh No. 123, RT 02/RW 04,
                        Kelurahan Lowokwaru, Kecamatan Lowokwaru,
                        Kota Malang, Jawa Timur 65141
                    </p>


                    <div class="courier-note">

                        <span class="material-symbols-outlined">
                            local_shipping
                        </span>

                        <span>
                            Catatan kurir: Rumah pagar putih,
                            dekat minimarket.
                        </span>

                    </div>

                </div>

            </section>

        </div>

    </div>

</div>



{{-- ============================================================= --}}
{{-- MODAL UBAH ALAMAT --}}
{{-- ============================================================= --}}
<div
    class="address-modal-overlay"
    id="addressModal"
    aria-hidden="true"
>

    <div
        class="address-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="addressModalTitle"
    >

        <div class="modal-header">

            <div>
                <h3 id="addressModalTitle">
                    Ubah Alamat Pengiriman
                </h3>

                <p>
                    Pastikan alamat yang Anda masukkan sudah benar.
                </p>
            </div>

        </div>


        <form class="address-form" data-address-form>

            <div class="modal-body">


                <div class="form-row">

                    <div class="form-group">

                        <label for="address_name">
                            Nama Penerima
                        </label>

                        <input
                            type="text"
                            id="address_name"
                            value="Siti Rahmawati"
                            placeholder="Nama penerima"
                        >

                    </div>

                    <div class="form-group">

                        <label for="address_phone">
                            Nomor Telepon
                        </label>

                        <input
                            type="text"
                            id="address_phone"
                            value="0812-3456-7890"
                            placeholder="Nomor telepon"
                        >

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label for="province">
                            Provinsi
                        </label>

                        <select id="province">
                            <option>Jawa Timur</option>
                            <option>Jawa Tengah</option>
                            <option>Jawa Barat</option>
                            <option>DKI Jakarta</option>
                        </select>

                    </div>

                    <div class="form-group">

                        <label for="city">
                            Kota / Kabupaten
                        </label>

                        <select id="city">
                            <option>Kota Malang</option>
                            <option>Kabupaten Malang</option>
                            <option>Kota Batu</option>
                        </select>

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label for="district">
                            Kecamatan
                        </label>

                        <input
                            type="text"
                            id="district"
                            value="Lowokwaru"
                            placeholder="Kecamatan"
                        >

                    </div>

                    <div class="form-group">

                        <label for="postcode">
                            Kode Pos
                        </label>

                        <input
                            type="text"
                            id="postcode"
                            value="65141"
                            placeholder="Kode pos"
                        >

                    </div>

                </div>


                <div class="form-group">

                    <label for="full_address">
                        Alamat Lengkap
                    </label>

                    <textarea
                        id="full_address"
                        rows="4"
                        placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan..."
                    >Jl. Contoh No. 123, RT 02/RW 04, Kelurahan Lowokwaru</textarea>

                </div>


                <div class="form-group">

                    <label for="courier_note">
                        Catatan untuk Kurir
                    </label>

                    <textarea
                        id="courier_note"
                        rows="3"
                        placeholder="Contoh: Rumah pagar putih, dekat minimarket."
                    >Rumah pagar putih, dekat minimarket.</textarea>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn-modal-cancel"
                    data-close-address-modal
                >
                    Batal
                </button>

                <button type="submit" class="account-modal-save-btn">
    Simpan Perubahan
</button>

            </div>

        </form>

    </div>

</div>

{{-- ============================================================= --}}
{{-- MODAL UBAH KATA SANDI --}}
{{-- ============================================================= --}}

<div
    class="account-modal-overlay"
    id="passwordModal"
    aria-hidden="true"
>
    <div
        class="account-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="passwordModalTitle"
    >

        <div class="account-modal-header">

            <div>
                <h3 id="passwordModalTitle">
                    Ubah Kata Sandi
                </h3>

                <p>
                    Gunakan kata sandi baru untuk menjaga keamanan akun Anda.
                </p>
            </div>

        </div>


        <form
            class="account-modal-form"
            data-password-form
        >

            @csrf

            <div class="account-modal-body">

                {{-- PASSWORD SAAT INI --}}
                <div class="form-group">

                    <label for="modal_current_password">
                        Kata Sandi Saat Ini
                    </label>

                    <div class="password-input">

    <input
        type="password"
        id="modal_current_password"
        name="current_password"
        placeholder="Masukkan kata sandi saat ini"
    >

    <button
        type="button"
        data-password-toggle
        data-target="modal_current_password"
    >
        <span class="material-symbols-outlined">
            visibility
        </span>
    </button>

</div>

                </div>


                {{-- PASSWORD BARU --}}
                <div class="form-group">

                    <label for="modal_new_password">
                        Kata Sandi Baru
                    </label>

                    <div class="password-input">

    <input
        type="password"
        id="modal_new_password"
        name="new_password"
        placeholder="Masukkan kata sandi baru"
    >

    <button
        type="button"
        data-password-toggle
        data-target="modal_new_password"
    >
        <span class="material-symbols-outlined">
            visibility
        </span>
    </button>

</div>

                    <small>
                        Gunakan minimal 8 karakter dengan kombinasi huruf dan angka.
                    </small>

                </div>


                {{-- KONFIRMASI --}}
                <div class="form-group">

                    <label for="modal_password_confirmation">
                        Konfirmasi Kata Sandi Baru
                    </label>

                    <div class="password-input">

    <input
        type="password"
        id="modal_password_confirmation"
        name="password_confirmation"
        placeholder="Ulangi kata sandi baru"
    >

    <button
        type="button"
        data-password-toggle
        data-target="modal_password_confirmation"
    >
        <span class="material-symbols-outlined">
            visibility
        </span>
    </button>

</div>

                </div>


                <div class="password-modal-note">
                    <span class="material-symbols-outlined">
                        info
                    </span>

                    <span>
                        Setelah kata sandi diubah, gunakan kata sandi baru
                        untuk login berikutnya.
                    </span>
                </div>

            </div>


            <div class="account-modal-footer">

                <button
                    type="button"
                    class="btn-modal-cancel"
                    data-close-account-modal
                >
                    Batal
                </button>

                <button type="submit" class="account-modal-save-btn">
    Simpan Kata Sandi
</button>

            </div>

        </form>

    </div>
</div>

{{-- ============================================================= --}}
{{-- MODAL UBAH EMAIL --}}
{{-- ============================================================= --}}

<div
    class="account-modal-overlay"
    id="emailModal"
    aria-hidden="true"
>
    <div
        class="account-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="emailModalTitle"
    >

        <div class="account-modal-header">

            <div>
                <h3 id="emailModalTitle">
                    Ubah Email
                </h3>

                <p>
                    Masukkan alamat email baru yang ingin digunakan.
                </p>
            </div>

        </div>


        <form class="account-modal-form">

            <div class="account-modal-body">

                <div class="form-group">

                    <label>
                        Email Saat Ini
                    </label>

                    <input
                        type="email"
                        value="{{ $email }}"
                        disabled
                    >

                </div>


                <div class="form-group">

                    <label for="new_email">
                        Email Baru
                    </label>

                    <input
                        type="email"
                        id="new_email"
                        name="new_email"
                        placeholder="Masukkan email baru"
                    >

                    <small>
                        Pastikan email baru masih aktif dan dapat menerima pesan verifikasi.
                    </small>

                </div>


                <div class="form-group">

                    <label for="email_password">
                        Kata Sandi
                    </label>

                    <div class="password-input">

                        <input
                            type="password"
                            id="email_password"
                            placeholder="Masukkan kata sandi untuk konfirmasi"
                        >

                        <button
                            type="button"
                            data-password-toggle
                            data-target="email_password"
                        >
                            <span class="material-symbols-outlined">
                                visibility
                            </span>
                        </button>

                    </div>

                </div>


                <div class="account-modal-note">
                    <span class="material-symbols-outlined">
                        mail
                    </span>

                    <span>
                        Setelah email diubah, verifikasi akan dikirim ke email baru.
                    </span>
                </div>

            </div>


            <div class="account-modal-footer">

                <button
                    type="button"
                    class="btn-modal-cancel"
                    data-close-account-modal
                >
                    Batal
                </button>

                <button type="submit" class="account-modal-save-btn">
    Simpan Email
</button>
            </div>

        </form>

    </div>
</div>

{{-- ============================================================= --}}
{{-- MODAL UBAH NOMOR TELEPON --}}
{{-- ============================================================= --}}

<div
    class="account-modal-overlay"
    id="phoneModal"
    aria-hidden="true"
>
    <div
        class="account-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="phoneModalTitle"
    >

        <div class="account-modal-header">

            <div>
                <h3 id="phoneModalTitle">
                    Ubah Nomor Telepon
                </h3>

                <p>
                    Masukkan nomor telepon baru yang ingin digunakan.
                </p>
            </div>

        </div>


        <form class="account-modal-form">

            <div class="account-modal-body">

                <div class="form-group">

                    <label>
                        Nomor Telepon Saat Ini
                    </label>

                    <input
                        type="text"
                        value="{{ $telepon }}"
                        disabled
                    >

                </div>


                <div class="form-group">

                    <label for="new_phone">
                        Nomor Telepon Baru
                    </label>

                    <input
                        type="tel"
                        id="new_phone"
                        name="new_phone"
                        placeholder="Contoh: 081234567890"
                    >

                    <small>
                        Gunakan nomor telepon yang aktif dan dapat menerima kode verifikasi.
                    </small>

                </div>


                <div class="account-modal-note">
                    <span class="material-symbols-outlined">
                        phone
                    </span>

                    <span>
                        Kode verifikasi akan dikirim ke nomor telepon baru.
                    </span>
                </div>

            </div>


            <div class="account-modal-footer">

                <button
                    type="button"
                    class="btn-modal-cancel"
                    data-close-account-modal
                >
                    Batal
                </button>

                <button type="submit" class="account-modal-save-btn">
    Simpan Nomor
</button>

            </div>

        </form>

    </div>
</div>


@push('scripts')
    <script src="{{ asset('js/pengaturan.js') }}"></script>
@endpush

@endsection