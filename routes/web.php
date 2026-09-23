<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController; // Pastikan controller ini ada jika ingin dipakai
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MidtransController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


Route::post('/midtrans/snap-token', [MidtransController::class, 'getSnapToken'])
    ->name('midtrans.snap');

// Saklar bahasa EN/ID. Disimpan ke session lalu dikembalikan ke halaman asal
// (dibaca oleh App\Http\Middleware\SetLocale di setiap request berikutnya).
Route::get('/lang/{locale}', function (string $locale) {
    abort_unless(in_array($locale, \App\Http\Middleware\SetLocale::SUPPORTED_LOCALES, true), 404);

    session(['locale' => $locale]);

    return back();
})->name('lang.switch');

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


// Menampilkan halaman login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    $request->session()->regenerate();

    if (Auth::user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->intended(route('profile.index'));
})->name('login.submit');


Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('beranda');
})->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'phone' => $validated['phone'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'customer',
    ]);

    Auth::login($user);

    $request->session()->regenerate();

    return redirect()->route('profile.index');
})->name('register.submit');

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

require __DIR__.'/admin.php';