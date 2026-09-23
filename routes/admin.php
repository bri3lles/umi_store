<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Di-include dari routes/web.php lewat: require __DIR__.'/admin.php';
| Semua route diberi middleware 'auth' + 'can:admin', prefix 'admin',
| dan name prefix 'admin.' (mis. route('admin.orders.index')).
*/

Route::middleware(['auth', 'can:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); // /admin

        // User dibuat lewat pendaftaran pelanggan, jadi admin hanya melihat, mengubah role, dan menghapus.
        Route::resource('users', UserController::class)->only(['index', 'show', 'destroy']);
        Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');

        Route::resource('products', ProductController::class);

        Route::get('stock', [StockController::class, 'index'])->name('stock.index');
        Route::post('stock/{item}/adjust', [StockController::class, 'adjust'])->name('stock.adjust');

        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('orders/{order}/ship', [OrderController::class, 'ship'])->name('orders.ship');
        Route::post('orders/{order}/accept', [OrderController::class, 'accept'])->name('orders.accept');
        Route::post('orders/{order}/reject', [OrderController::class, 'reject'])->name('orders.reject');
        Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

        Route::get('returns', [ReturnController::class, 'index'])->name('returns.index');
        Route::post('returns/{retur}/{action}', [ReturnController::class, 'act'])
            ->whereIn('action', ['reject', 'offer', 'approve', 'arrive', 'complete'])->name('returns.act');

        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::post('reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');
        Route::post('reviews/{review}/visibility', [ReviewController::class, 'toggleVisibility'])->name('reviews.visibility');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    });