<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    // Opsi tampilan (filter, dropdown, palet warna) — bukan data yang disimpan di DB.
    private const CATEGORIES = ['Gamis', 'Blouse', 'Hijab', 'Outer & Tunik', 'Celana & Rok'];
    private const STATUSES = ['active' => 'Aktif', 'off' => 'Nonaktif', 'out' => 'Stok Habis'];
    private const SORTS = [
        'newest' => 'Terbaru', 'name' => 'Nama A–Z', 'price_asc' => 'Harga Terendah',
        'price_desc' => 'Harga Tertinggi', 'stock_asc' => 'Stok Tersedikit',
    ];
    private const COLORS = [
        'Dusty Pink' => '#D98A9A', 'Sage Green' => '#8FA98A', 'Mocca Warm' => '#8B6B5A', 'Navy' => '#1E2A78',
        'Hitam Jetblack' => '#111827', 'Maroon' => '#7A1F2B', 'Olive' => '#6B7A3A', 'Cream' => '#E8D9B5',
    ];
    private const COURIERS = [
        'reguler' => ['J&T Express & JNE Reguler', 'truck'],
        'cargo' => ['SiCepat Cargo & Kargo Reguler', 'zap'],
        'instant' => ['Instant GoSend / Grab (Khusus Area Toko)', 'bike'],
    ];

    public function index(Request $request): View
    {
        $products = Product::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->q;
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%")
                        ->orWhere('sku', 'like', "%{$term}%")
                        ->orWhere('category', 'like', "%{$term}%");
                });
            })
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->category))
            ->when($request->filled('status'), function ($query) use ($request) {
                match ($request->status) {
                    'off' => $query->where('active', false),
                    'out' => $query->where('active', true)->where('stock', 0),
                    'active' => $query->where('active', true)->where('stock', '>', 0),
                    default => null,
                };
            });

        match ($request->sort) {
            'name' => $products->orderBy('name'),
            'price_asc' => $products->orderBy('price'),
            'price_desc' => $products->orderByDesc('price'),
            'stock_asc' => $products->orderBy('stock'),
            default => $products->orderByDesc('id'),
        };

        $products = $products->paginate(6)->withQueryString();

        return view('admin.products.list', $this->lookups() + compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.create', $this->lookups() + ['product' => null]);
    }

    public function show(Product $product): View
    {
        $product->load('productVariants', 'productPhotos');

        return view('admin.products.detail', $this->lookups() + compact('product'));
    }

    public function edit(Product $product): View
    {
        $product->load('productVariants', 'productPhotos');

        return view('admin.products.edit', $this->lookups() + compact('product'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $data = $this->mapToColumns($validated, $request);
        $data['slug'] = $this->uniqueSlug($validated['name']);

        $product = Product::create($data);

        $this->syncVariants($product, $validated['variants'] ?? []);
        $this->storePhotos($product, $request);
        $this->recalculateStock($product);

        return $this->done('Produk baru berhasil diterbitkan.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate($this->rules($product->id));

        $data = $this->mapToColumns($validated, $request);
        if ($validated['name'] !== $product->name) {
            $data['slug'] = $this->uniqueSlug($validated['name'], $product->id);
        }

        $product->update($data);

        $this->syncVariants($product, $validated['variants'] ?? []);
        $this->storePhotos($product, $request);
        $this->recalculateStock($product);

        return $this->done('Perubahan produk berhasil disimpan.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        foreach ($product->productPhotos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }

        $product->delete(); // varian & foto ikut terhapus lewat cascadeOnDelete di migration

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    /* ---------- Helper ---------- */

    private function done(string $message): RedirectResponse
    {
        return redirect()->route('admin.products.index')->with('success', $message);
    }

    private function lookups(): array
    {
        return [
            'categories' => self::CATEGORIES, 'statuses' => self::STATUSES, 'sorts' => self::SORTS,
            'colorPalette' => self::COLORS, 'couriers' => self::COURIERS,
        ];
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', Rule::in(self::CATEGORIES)],
            'material' => ['nullable', 'string', 'max:100'],
            'sku' => ['required', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($ignoreId)],
            'label' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string'],

            'cost_price' => ['nullable', 'string'],
            'price' => ['required', 'string'],
            'promo_price' => ['nullable', 'string'],

            'stock' => ['nullable', 'integer', 'min:0'],
            'stock_alert' => ['nullable', 'integer', 'min:0'],
            'readiness' => ['required', Rule::in(['ready', 'po'])],

            'weight' => ['required', 'integer', 'min:1'],
            'length' => ['nullable', 'integer', 'min:0'],
            'width' => ['nullable', 'integer', 'min:0'],
            'height' => ['nullable', 'integer', 'min:0'],
            'couriers' => ['nullable', 'array'],
            'couriers.*' => [Rule::in(array_keys(self::COURIERS))],

            'variants_enabled' => ['nullable', 'boolean'],
            'variants' => ['nullable', 'array'],
            'variants.*.color' => ['nullable', 'string', 'max:30'],
            'variants.*.size' => ['nullable', 'string', 'max:20'],
            'variants.*.sku' => ['nullable', 'string', 'max:80'],
            'variants.*.extra_price' => ['nullable', 'string'],
            'variants.*.stock' => ['nullable', 'integer', 'min:0'],

            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'mimes:jpeg,png,webp', 'max:5120'],

            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }

    private function mapToColumns(array $validated, Request $request): array
    {
        return [
            'name' => $validated['name'],
            'category' => $validated['category'],
            'material' => $validated['material'] ?? null,
            'sku' => $validated['sku'],
            'label' => $validated['label'] ?? null,
            'description' => $validated['description'],

            'colors' => $this->colorsFromVariants($validated['variants'] ?? []),
            'sizes' => $this->sizesFromVariants($validated['variants'] ?? []),
            'variants_enabled' => $request->boolean('variants_enabled'),

            'cost_price' => $this->toInt($validated['cost_price'] ?? null),
            'price' => $this->toInt($validated['price']) ?? 0,
            'promo_price' => $this->toInt($validated['promo_price'] ?? null),

            'stock' => $validated['stock'] ?? 0,
            'stock_alert' => $validated['stock_alert'] ?? 5,
            'readiness' => $validated['readiness'],

            'weight' => $validated['weight'],
            'length' => $validated['length'] ?? null,
            'width' => $validated['width'] ?? null,
            'height' => $validated['height'] ?? null,
            'couriers' => $validated['couriers'] ?? [],

            'active' => $request->boolean('is_active'),
            'featured' => $request->boolean('is_featured'),
        ];
    }

    // Ubah "225.000" (format id-ID dari data-money) jadi integer 225000.
    private function toInt(?string $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        $digits = preg_replace('/\D/', '', $value);

        return $digits === '' ? null : (int) $digits;
    }

    // Warna produk diambil dari nama warna yang dipakai di baris varian;
    // hex dicocokkan ke palet toko, jatuh ke abu-abu jika warna kustom.
    private function colorsFromVariants(array $variants): array
    {
        return collect($variants)
            ->pluck('color')
            ->filter()
            ->unique()
            ->map(fn ($name) => ['name' => $name, 'hex' => self::COLORS[$name] ?? '#94A3B8'])
            ->values()
            ->all();
    }

    private function sizesFromVariants(array $variants): array
    {
        return collect($variants)->pluck('size')->filter()->unique()->values()->all();
    }

    // slug wajib unik di tabel products (dipakai katalog toko), form admin tidak punya field ini.
    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'produk';
        $slug = $base;
        $i = 2;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    private function syncVariants(Product $product, array $variants): void
    {
        $product->productVariants()->delete();

        foreach ($variants as $row) {
            if (empty($row['color']) && empty($row['size'])) {
                continue;
            }

            $product->productVariants()->create([
                'color' => $row['color'] ?? null,
                'size' => $row['size'] ?? null,
                'sku' => $row['sku'] ?? null,
                'extra_price' => $this->toInt($row['extra_price'] ?? null) ?? 0,
                'stock' => (int) ($row['stock'] ?? 0),
            ]);
        }
    }

    // Foto baru yang diunggah ditambahkan ke galeri; foto lama (belum ada mekanisme hapus per-foto di form) dibiarkan.
    private function storePhotos(Product $product, Request $request): void
    {
        if (! $request->hasFile('photos')) {
            return;
        }

        $nextOrder = (int) $product->productPhotos()->max('sort_order') + 1;

        foreach ($request->file('photos') as $file) {
            $path = $file->store('products', 'public');

            $product->productPhotos()->create([
                'path' => $path,
                'label' => Str::of($file->getClientOriginalName())->beforeLast('.')->toString(),
                'sort_order' => $nextOrder++,
            ]);
        }

        // Kolom `image` (dipakai katalog toko) mengikuti foto pertama di galeri.
        if (! $product->image) {
            $first = $product->productPhotos()->orderBy('sort_order')->first();
            if ($first) {
                $product->update(['image' => $first->path]);
            }
        }
    }

    // Jika varian aktif, total stok = jumlah stok semua varian (konsisten dengan perilaku form di sisi klien).
    private function recalculateStock(Product $product): void
    {
        if ($product->variants_enabled && $product->productVariants()->exists()) {
            $product->update(['stock' => (int) $product->productVariants()->sum('stock')]);
        }
    }
}
