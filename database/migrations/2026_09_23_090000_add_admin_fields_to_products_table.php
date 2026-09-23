<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tabel `products` sudah ada (dibuat di create_store_tables.php) dan sudah dipakai
    // oleh wishlists/orders/order_items/reviews/returns lewat foreign key product_id.
    // Migration ini hanya MENAMBAH kolom yang dipakai form admin, tidak membuat ulang tabel.
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'label')) {
                $table->string('label')->nullable()->after('category');
            }
            if (! Schema::hasColumn('products', 'cost_price')) {
                $table->unsignedInteger('cost_price')->nullable()->after('price');
            }
            if (! Schema::hasColumn('products', 'promo_price')) {
                $table->unsignedInteger('promo_price')->nullable()->after('cost_price');
            }
            if (! Schema::hasColumn('products', 'stock_alert')) {
                $table->unsignedInteger('stock_alert')->default(5)->after('stock');
            }
            if (! Schema::hasColumn('products', 'readiness')) {
                $table->enum('readiness', ['ready', 'po'])->default('ready')->after('stock_alert');
            }
            if (! Schema::hasColumn('products', 'weight')) {
                $table->unsignedInteger('weight')->default(0)->after('readiness');
            }
            if (! Schema::hasColumn('products', 'length')) {
                $table->unsignedInteger('length')->nullable()->after('weight');
            }
            if (! Schema::hasColumn('products', 'width')) {
                $table->unsignedInteger('width')->nullable()->after('length');
            }
            if (! Schema::hasColumn('products', 'height')) {
                $table->unsignedInteger('height')->nullable()->after('width');
            }
            if (! Schema::hasColumn('products', 'couriers')) {
                $table->json('couriers')->nullable()->after('height');
            }
            if (! Schema::hasColumn('products', 'variants_enabled')) {
                $table->boolean('variants_enabled')->default(true)->after('couriers');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'label', 'cost_price', 'promo_price', 'stock_alert', 'readiness',
                'weight', 'length', 'width', 'height', 'couriers', 'variants_enabled',
            ]);
        });
    }
};
