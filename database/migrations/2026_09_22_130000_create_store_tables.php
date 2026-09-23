<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('products', function(Blueprint $t){$t->id();$t->string('name');$t->string('slug')->unique();$t->string('sku')->unique();$t->string('category');$t->unsignedInteger('price');$t->unsignedInteger('stock')->default(0);$t->text('description')->nullable();$t->string('material')->nullable();$t->json('sizes')->nullable();$t->json('colors')->nullable();$t->string('image')->nullable();$t->boolean('active')->default(true);$t->boolean('featured')->default(false);$t->timestamps();});
  Schema::create('wishlists', function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->foreignId('product_id')->constrained()->cascadeOnDelete();$t->timestamps();$t->unique(['user_id','product_id']);});
  Schema::create('orders', function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->string('order_number')->unique();$t->unsignedInteger('subtotal');$t->unsignedInteger('shipping_cost')->default(0);$t->unsignedInteger('total');$t->string('shipping_method');$t->text('address')->nullable();$t->string('phone')->nullable();$t->string('payment_status')->default('pending');$t->string('status')->default('new');$t->string('midtrans_order_id')->nullable()->unique();$t->timestamp('paid_at')->nullable();$t->timestamp('received_at')->nullable();$t->timestamps();});
  Schema::create('order_items', function(Blueprint $t){$t->id();$t->foreignId('order_id')->constrained()->cascadeOnDelete();$t->foreignId('product_id')->constrained()->restrictOnDelete();$t->string('product_name');$t->string('size')->nullable();$t->string('color')->nullable();$t->unsignedInteger('price');$t->unsignedInteger('quantity');$t->timestamps();});
  Schema::create('reviews', function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->foreignId('product_id')->constrained()->cascadeOnDelete();$t->foreignId('order_id')->constrained()->cascadeOnDelete();$t->unsignedTinyInteger('rating');$t->text('comment')->nullable();$t->boolean('visible')->default(true);$t->timestamps();$t->unique(['user_id','product_id','order_id']);});
  Schema::create('returns', function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->foreignId('order_id')->constrained()->cascadeOnDelete();$t->foreignId('product_id')->constrained()->restrictOnDelete();$t->string('reason');$t->text('description');$t->string('photo')->nullable();$t->string('status')->default('pending');$t->unsignedInteger('refund_amount')->default(0);$t->timestamps();});
 }
 public function down(): void {foreach(['returns','reviews','order_items','orders','wishlists','products'] as $t) Schema::dropIfExists($t);}
};
