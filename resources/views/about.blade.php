<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Umi Store</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS Utama & CSS Khusus About -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
</head>
<body>

    <!-- ================= NAVBAR ================= -->
    @include('partials.navbar')

    <!-- ================= HERO SECTION FULL WIDTH ================= -->
    <section class="about-hero-full">
        <div class="about-hero-inner">
            <span class="hero-badge-pill">Umi Store Official</span>
            <h1>Pusat Busana Berkualitas di Bululawang</h1>
            <p>
                Pusat perbelanjaan pakaian pria dan wanita terlengkap di Bululawang, Malang. Kami hadir untuk memenuhi kebutuhan busana harian keluarga Anda dengan produk berkualitas tinggi, nyaman, dan harga yang bersahabat.
            </p>
            <div class="hero-cta-group">
                <a href="#lokasi-toko" class="btn-hero-primary"><i class="fa-solid fa-location-dot"></i> Kunjungi Toko Kami</a>
                <a href="/katalog" class="btn-hero-secondary"><i class="fa-solid fa-shirt"></i> Lihat Katalog</a>
            </div>
        </div>
    </section>

    <!-- ================= KONTEN TANPA CARD (FLAT STYLE) ================= -->
    <main class="about-main-content" id="lokasi-toko">
        <div class="about-container">
            
            <!-- Grid Utama: Info Toko & Google Maps (Tanpa Pembungkus Card) -->
            <div class="flat-content-grid">
                
                <!-- Kolom Kiri: Informasi Toko -->
                <div class="flat-info-side">
                    
                    <h2 class="section-heading">Toko Pakaian Pria & Wanita Bu Umi</h2>
                    <p class="section-desc">
                        Datang dan temukan berbagai koleksi fashion harian terbaik langsung di toko offline kami. Dilayani oleh staf yang ramah dengan suasana toko yang nyaman.
                    </p>

                    <div class="flat-info-list">
                        <div class="flat-info-item">
                            <div class="icon-box"><i class="fa-solid fa-map-location-dot"></i></div>
                            <div>
                                <strong>Alamat Lengkap:</strong>
                                <p>Jl. Kenongo No.19, Krajan, Pringu, Kec. Bululawang, Kabupaten Malang, Jawa Timur 65171</p>
                            </div>
                        </div>

                        <div class="flat-info-item">
                            <div class="icon-box"><i class="fa-solid fa-clock"></i></div>
                            <div>
                                <strong>Jam Operasional Toko:</strong>
                                <p>Senin – Minggu: <strong>08.00 - 20.00 WIB</strong></p>
                            </div>
                        </div>

                        <div class="flat-info-item">
                            <div class="icon-box" style="background: #fef3c7; color: #d97706;"><i class="fa-solid fa-star"></i></div>
                            <div>
                                <strong>Reputasi & Ulasan:</strong>
                                <p>Rating 4.0 / 5.0 dari ratusan pelanggan di Google Maps</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Navigasi / Chat -->
                    <div class="flat-action-buttons">
                        <a href="https://maps.google.com/?q=Jl.+Kenongo+No.19,+Krajan,+Pringu,+Kec.+Bululawang,+Kabupaten+Malang" target="_blank" class="btn-flat-route">
                            <i class="fa-solid fa-diamond-turn-right"></i> Buka Rute Google Maps
                        </a>
                        <a href="https://wa.me/628xxxxxxxxxx" target="_blank" class="btn-flat-wa">
                            <i class="fa-brands fa-whatsapp"></i> Hubungi WhatsApp
                        </a>
                    </div>
                </div>

                <!-- Kolom Kanan: Peta Google Maps (Clean tanpa card putih) -->
                <div class="flat-map-side">
                    <div class="map-wrapper-clean">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3950.3524945371565!2d112.6395!3d-8.0375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6247c1234567%3A0x123456789abcdef!2sJl.%20Kenongo+No.19%2C%20Krajan%2C%20Pringu%2C%20Kec.%20Bululawang%2C%20Kabupaten%20Malang%2C%20Jawa%20Timur%2065171!5e0!3m2!1sid!2sid!4v1650000000000!5m2!1sid!2sid" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Umi Store Bululawang">
                        </iframe>
                    </div>
                </div>

            </div>

            <!-- Tambahan Section: Keunggulan Toko (Biar tidak sepi) -->
            <div class="store-features-section">
                <div class="feature-box">
                    <i class="fa-solid fa-tags"></i>
                    <div>
                        <h4>Harga Terjangkau</h4>
                        <p>Kualitas pakaian premium dengan harga grosir yang ramah di kantong.</p>
                    </div>
                </div>
                <div class="feature-box">
                    <i class="fa-solid fa-shirt"></i>
                    <div>
                        <h4>Bahan Nyaman</h4>
                        <p>Dipilih dari material katun dan linen pilihan yang adem dipakai harian.</p>
                    </div>
                </div>
                <div class="feature-box">
                    <i class="fa-solid fa-handshake-simple"></i>
                    <div>
                        <h4>Pelayanan Ramah</h4>
                        <p>Siap membantu Anda memilih ukuran dan model pakaian terbaik.</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- ================= FOOTER ================= -->
    @include('partials.footer')

    <script src="{{ asset('js/about.js') }}"></script>
</body>
</html>