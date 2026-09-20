<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController; // Pastikan controller ini ada jika ingin dipakai
use App\Http\Controllers\ProfileController;


require __DIR__.'/admin.php';

// 1. Route Beranda
Route::get('/', function () {
    return view('beranda');
})->name('beranda');

// 2. Route Katalog
Route::get('/katalog', function () {
    return view('katalog');
})->name('katalog');

// 3. Route Tentang
Route::get('/about', function () {
    return view('about');
})->name('about');

// 4. Route Detail Produk (Menggunakan data dummy yang lengkap)
Route::get('/detail', function () {
    $product = (object) [
        'name' => 'Kaos Polos Cotton Combed',
        'price' => 149000,
    ];

    return view('detail', compact('product'));
})->name('detail');

Route::get('/keranjang', function () {
    return view('keranjang');
})->name('keranjang');

// 6. Route Diantar
Route::get('/diantar', function () {
    return view('diantar');
})->name('diantar');

Route::get('/pembayaran', function () {
    return view('pembayaran');
})->name('pembayaran');

Route::get('/bukti-pembayaran', function () {
    return view('bukti-pembayaran');
})->name('bukti.pembayaran');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.settings');

Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

// Menampilkan halaman login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Memproses login dummy
Route::post('/login', function (Request $request) {

    $email = $request->email;
    $password = $request->password;

    // Data login dummy
    if ($email === 'coba@gmail.com' && $password === '1') {
        return redirect()->route('profile.settings');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);

})->name('login.submit');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile.index');

Route::get('/profile/pesanan', [ProfileController::class, 'pesanan'])
    ->name('profile.pesanan');

Route::get('/profile/wishlist', [ProfileController::class, 'wishlist'])
    ->name('profile.wishlist');

Route::get('/profile/pengaturan', [ProfileController::class, 'pengaturan'])
    ->name('profile.pengaturan');

Route::get('/retur', function () {
    return view('retur.index');
})->name('retur.index');