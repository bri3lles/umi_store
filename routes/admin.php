<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\PaymentVerificationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\SalesReportController;
use App\Http\Controllers\Admin\AccountSettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Taruh file ini sebagai routes/admin.php, lalu di routes/web.php tambahkan:
|
|   require __DIR__.'/admin.php';
|
| Atau salin blok Route::group di bawah ini langsung ke routes/web.php.
| Semua route diberi middleware 'auth' + 'can:admin' (sesuaikan dengan
| middleware/role yang sudah kamu pakai, misal 'role:admin' kalau pakai
| Spatie Permission).
*/

Route::middleware(['auth', 'can:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Toggle status buka/tutup toko (dipanggil dari sidebar)
        Route::post('/status/toggle', [AdminDashboardController::class, 'toggleStatus'])->name('status.toggle');

        // Manajemen Produk
        Route::resource('products', ProductController::class);

        // Manajemen Stok
        Route::get('stock', [StockController::class, 'index'])->name('stock.index');
        Route::get('stock/{product}/edit', [StockController::class, 'edit'])->name('stock.edit');
        Route::put('stock/{product}', [StockController::class, 'update'])->name('stock.update');

        // Verifikasi Pembayaran
        Route::get('payments', [PaymentVerificationController::class, 'index'])->name('payments.index');
        Route::get('payments/{order}', [PaymentVerificationController::class, 'show'])->name('payments.show');
        Route::post('payments/{order}/confirm', [PaymentVerificationController::class, 'confirm'])->name('payments.confirm');
        Route::post('payments/{order}/reject', [PaymentVerificationController::class, 'reject'])->name('payments.reject');

        // Manajemen Pesanan
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/process', [OrderController::class, 'process'])->name('orders.process');
        Route::get('orders/{order}/track', [OrderController::class, 'track'])->name('orders.track');

        // Manajemen Retur
        Route::get('returns', [ReturnController::class, 'index'])->name('returns.index');
        Route::get('returns/{return}', [ReturnController::class, 'show'])->name('returns.show');
        Route::post('returns/{return}/approve', [ReturnController::class, 'approve'])->name('returns.approve');
        Route::post('returns/{return}/reject', [ReturnController::class, 'reject'])->name('returns.reject');

        // Rekap Penjualan
        Route::get('sales', [SalesReportController::class, 'index'])->name('sales.index');
        Route::get('sales/export', [SalesReportController::class, 'export'])->name('sales.export');

        // Pengaturan Akun
        Route::get('account', [AccountSettingController::class, 'index'])->name('account.index');
        Route::put('account', [AccountSettingController::class, 'update'])->name('account.update');
    });