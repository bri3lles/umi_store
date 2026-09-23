# Umi Store

Laravel 13 e-commerce apparel untuk Umi Store.

## Fitur utama
- Katalog produk: pencarian, kategori, sort, pagination, stok.
- Detail produk: pilihan ukuran/warna, cart dan wishlist.
- Cart persisten selama session.
- Checkout: dikirim atau ambil di toko.
- Pembayaran Midtrans Snap (Sandbox/Production melalui `.env`).
- Pesanan dan riwayat pembelian di Profil.
- Retur maksimal 3 hari setelah diterima, wajib alasan, deskripsi dan foto.
- Admin: user, produk, stok, pesanan, retur, ulasan, laporan, pengaturan.
- Bahasa Indonesia / English melalui switcher.

## Instalasi
1. `composer install`
2. Salin `.env.example` menjadi `.env` lalu isi `APP_KEY` dan kredensial Midtrans.
3. Pastikan PHP memiliki extension `pdo_sqlite` jika menggunakan SQLite.
4. `php artisan key:generate`
5. `php artisan migrate --seed`
6. `php artisan serve`

## Akun admin seed
- Email: `admin@umistore.test`
- Password: `admin12345`

Ganti kredensial admin sebelum deployment nyata.
