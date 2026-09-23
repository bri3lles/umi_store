<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    // name => hex, dipakai juga oleh ProductController (harus sama persis).
    private const COLORS = [
        'Dusty Pink' => '#D98A9A', 'Sage Green' => '#8FA98A', 'Mocca Warm' => '#8B6B5A', 'Navy' => '#1E2A78',
        'Hitam Jetblack' => '#111827', 'Maroon' => '#7A1F2B', 'Olive' => '#6B7A3A', 'Cream' => '#E8D9B5',
    ];

    public function run(): void
    {
        Storage::disk('public')->makeDirectory('products');

        collect($this->products())->each(function (array $data) {
            $product = Product::create([
                'name' => $data['name'],
                'slug' => \Illuminate\Support\Str::slug($data['name']),
                'category' => $data['category'],
                'material' => $data['material'],
                'sku' => $data['sku'],
                'label' => $data['label'],
                'description' => $data['description'],
                'colors' => collect($data['colors'])->map(fn ($c) => ['name' => $c, 'hex' => self::COLORS[$c]])->all(),
                'sizes' => $data['sizes'],
                'variants_enabled' => true,
                'cost_price' => (int) round($data['price'] * 0.55, -3),
                'price' => $data['price'],
                'promo_price' => $data['promo_price'] ?? null,
                'stock' => 0, // dihitung ulang dari varian di bawah
                'stock_alert' => 5,
                'readiness' => $data['readiness'] ?? 'ready',
                'weight' => $data['weight'],
                'length' => 28,
                'width' => 20,
                'height' => 4,
                'couriers' => $data['couriers'] ?? ['reguler', 'cargo'],
                'active' => $data['active'] ?? true,
                'featured' => $data['featured'] ?? false,
            ]);

            $totalStock = 0;
            foreach ($data['colors'] as $color) {
                foreach ($data['sizes'] as $size) {
                    $stock = $data['stock_override'] ?? random_int(0, 40);
                    $totalStock += $stock;

                    $product->productVariants()->create([
                        'color' => $color,
                        'size' => $size,
                        'sku' => $data['sku'].'-'.strtoupper(substr(str_replace(' ', '', $color), 0, 3)).'-'.strtoupper(str_replace(' ', '', $size)),
                        'extra_price' => 0,
                        'stock' => $stock,
                    ]);
                }
            }
            $product->update(['stock' => $totalStock]);

            $mainHex = self::COLORS[$data['colors'][0]];
            foreach (['Tampak Depan', 'Tampak Belakang', 'Detail Serat Kain'] as $i => $label) {
                $path = $this->makePhoto($product->sku.'-'.($i + 1), $mainHex, $data['name']);

                $product->productPhotos()->create([
                    'path' => $path,
                    'label' => $label,
                    'sort_order' => $i,
                ]);
            }

            $firstPhoto = $product->productPhotos()->orderBy('sort_order')->first();
            $product->update(['image' => $firstPhoto?->path]);
        });
    }

    private function products(): array
    {
        return [
            [
                'name' => 'Gamis Katun Rayon Zafira', 'sku' => 'GMS-ZF-01', 'category' => 'Gamis',
                'material' => 'Katun Rayon Twill', 'label' => 'Koleksi Ramadhan 2025',
                'description' => "✨ GAMIS KATUN RAYON ZAFIRA BY UMI STORE ✨\n\nAnggun, adem, dan nyaman dipakai. Cocok untuk acara pengajian, silaturahmi keluarga, maupun pesta formal.\n\nKeunggulan Produk:\n• Bahan lembut dan tidak mudah kusut\n• Busui friendly\n• Jahitan rapi dan kuat",
                'colors' => ['Dusty Pink', 'Sage Green'], 'sizes' => ['M', 'L'],
                'price' => 225000, 'promo_price' => 245000, 'weight' => 380, 'featured' => true,
            ],
            [
                'name' => 'Blouse Crinkle Premium Dusty Pink', 'sku' => 'BLS-CK-04', 'category' => 'Blouse',
                'material' => 'Crinkle Airflow', 'label' => 'Best Seller',
                'description' => "✨ BLOUSE CRINKLE PREMIUM BY UMI STORE ✨\n\nAtasan kekinian berbahan crinkle airflow yang ringan dan tidak menerawang. Cocok untuk kerja maupun santai.\n\nKeunggulan Produk:\n• Bahan adem dan jatuh\n• Model longgar nyaman dipakai seharian",
                'colors' => ['Dusty Pink'], 'sizes' => ['M', 'L', 'XL'],
                'price' => 145000, 'weight' => 220,
            ],
            [
                'name' => 'Hijab Paris Voal Premium Olive', 'sku' => 'HJB-PV-12', 'category' => 'Hijab',
                'material' => 'Voal Ultrafine', 'label' => null,
                'description' => "✨ HIJAB PARIS VOAL PREMIUM BY UMI STORE ✨\n\nBahan voal premium yang ringan, adem, dan mudah dibentuk. Tersedia dalam berbagai pilihan warna kalem.\n\nKeunggulan Produk:\n• Tidak mudah kusut\n• Jahitan tepi rapi anti serabut",
                'colors' => ['Olive', 'Sage Green'], 'sizes' => ['All Size'],
                'price' => 45000, 'weight' => 80,
            ],
            [
                'name' => 'Tunik Brokat Pesta Maroon', 'sku' => 'TNK-BR-08', 'category' => 'Outer & Tunik',
                'material' => 'Ceruty Babydoll', 'label' => 'Edisi Pesta',
                'description' => "✨ TUNIK BROKAT PESTA MAROON BY UMI STORE ✨\n\nTunik brokat mewah untuk acara formal dan pesta keluarga. Kombinasi ceruty babydoll dan detail brokat premium.\n\nKeunggulan Produk:\n• Detail brokat rapi\n• Dalaman ceruty tidak menerawang",
                'colors' => ['Maroon'], 'sizes' => ['M', 'L'],
                'price' => 285000, 'weight' => 420, 'readiness' => 'po',
            ],
            [
                'name' => 'Celana Kulot Scuba Highwaist Black', 'sku' => 'KLT-SC-02', 'category' => 'Celana & Rok',
                'material' => 'Scuba Highwaist', 'label' => null,
                'description' => "✨ CELANA KULOT SCUBA HIGHWAIST BY UMI STORE ✨\n\nCelana kulot bahan scuba tebal, tidak transparan, dengan pinggang highwaist yang nyaman.\n\nKeunggulan Produk:\n• Bahan jatuh dan tidak mudah kusut\n• Pinggang karet full lingkar",
                'colors' => ['Hitam Jetblack'], 'sizes' => ['All Size'],
                'price' => 135000, 'weight' => 300,
            ],
            [
                'name' => 'Kaftan Lebaran Silk Cream', 'sku' => 'KFT-SL-01', 'category' => 'Gamis',
                'material' => 'Silk Premium', 'label' => 'Edisi Lebaran',
                'description' => "✨ KAFTAN LEBARAN SILK CREAM BY UMI STORE ✨\n\nKaftan mewah bahan silk premium, cocok untuk momen lebaran dan open house keluarga.\n\nKeunggulan Produk:\n• Jatuh anggun dan berkilau lembut\n• Nyaman dipakai seharian",
                'colors' => ['Cream'], 'sizes' => ['L', 'XL'],
                'price' => 320000, 'weight' => 400, 'active' => false, // contoh produk nonaktif
            ],
            [
                'name' => 'Rok Plisket Premium Mocca', 'sku' => 'RKP-PL-05', 'category' => 'Celana & Rok',
                'material' => 'Voal Ultrafine', 'label' => null,
                'description' => "✨ ROK PLISKET PREMIUM BY UMI STORE ✨\n\nRok plisket dengan motif lipit rapi, tampilan formal namun tetap nyaman untuk kegiatan harian.\n\nKeunggulan Produk:\n• Lipit tidak mudah kusut\n• Bahan ringan dan adem",
                'colors' => ['Mocca Warm'], 'sizes' => ['All Size'],
                'price' => 115000, 'weight' => 260,
            ],
            [
                'name' => 'Khimar Jumbo Cokelat', 'sku' => 'KHM-JB-03', 'category' => 'Hijab',
                'material' => 'Crinkle Airflow', 'label' => null,
                'description' => "✨ KHIMAR JUMBO BY UMI STORE ✨\n\nKhimar syar'i model jumbo, menutup dada dengan sempurna, cocok dipakai harian maupun formal.\n\nKeunggulan Produk:\n• Ukuran jumbo menutup lebih sempurna\n• Bahan ringan tidak panas",
                'colors' => ['Mocca Warm'], 'sizes' => ['All Size'],
                'price' => 120000, 'weight' => 150, 'stock_override' => 0, // contoh produk stok habis
            ],
        ];
    }

    // Bikin foto placeholder JPG solid warna produk (dipakai karena tidak ada aset foto asli).
    private function makePhoto(string $name, string $hex, string $label): string
    {
        $width = 800;
        $height = 800;
        $image = imagecreatetruecolor($width, $height);

        [$r, $g, $b] = sscanf($hex, '#%02x%02x%02x');
        $bg = imagecolorallocate($image, $r, $g, $b);
        imagefill($image, 0, 0, $bg);

        $text = $label;
        $textColor = imagecolorallocate($image, 255, 255, 255);
        $font = 5;
        $textWidth = imagefontwidth($font) * strlen($text);
        imagestring($image, $font, (int) (($width - $textWidth) / 2), (int) ($height / 2), $text, $textColor);

        ob_start();
        imagejpeg($image, null, 80);
        $contents = ob_get_clean();
        imagedestroy($image);

        $path = 'products/'.\Illuminate\Support\Str::slug($name).'.jpg';
        Storage::disk('public')->put($path, $contents);

        return $path;
    }
}
