<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'category', 'material', 'sku', 'label', 'description', 'image',
        'colors', 'sizes', 'variants_enabled',
        'cost_price', 'price', 'promo_price',
        'stock', 'stock_alert', 'readiness',
        'weight', 'length', 'width', 'height', 'couriers',
        'active', 'featured',
    ];

    protected function casts(): array
    {
        return [
            'colors' => 'array',
            'sizes' => 'array',
            'couriers' => 'array',
            'variants_enabled' => 'boolean',
            'active' => 'boolean',
            'featured' => 'boolean',
            'cost_price' => 'integer',
            'price' => 'integer',
            'promo_price' => 'integer',
            'stock' => 'integer',
            'stock_alert' => 'integer',
            'weight' => 'integer',
            'length' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
        ];
    }

    /* ---------- Relasi ---------- */

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function productPhotos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class)->orderBy('sort_order');
    }

    /* ---------- Accessor: bentuk data disesuaikan dengan view yang sudah ada ---------- */

    // Dipakai di _form.blade & detail.blade: array assoc [color, size, extra, stock, sku]
    protected function variants(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->productVariants->map(fn ($v) => [
                'color' => $v->color,
                'size' => $v->size,
                'extra' => $v->extra_price,
                'stock' => $v->stock,
                'sku' => $v->sku,
            ])->all(),
        );
    }

    // Dipakai di detail.blade: array assoc [label, color]
    protected function photos(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->productPhotos->map(fn ($p) => [
                'label' => $p->label,
                'color' => $this->color,
            ])->all(),
        );
    }

    // Warna utama untuk thumbnail (x-admin.product-thumb)
    protected function color(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->colors[0]['hex'] ?? '#94A3B8',
        );
    }

    // out / low / ok, dipakai untuk class "pill--{stock_level}"
    protected function stockLevel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->stock === 0 ? 'out' : ($this->stock <= $this->stock_alert ? 'low' : 'ok'),
        );
    }

    protected function stockLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                $level = $this->stock_level;
                $suffix = $level === 'low' ? ' (Menipis)' : ($level === 'out' ? ' (Habis)' : '');

                return $this->stock.' pcs'.$suffix;
            },
        );
    }

    // active / out / off, dipakai untuk badge status & filter status
    protected function statusKey(): Attribute
    {
        return Attribute::make(
            get: fn () => ! $this->active ? 'off' : ($this->stock === 0 ? 'out' : 'active'),
        );
    }
}
