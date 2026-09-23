<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * TAHAP FRONTEND: data dummy. Di tahap backend, setiap perubahan stok dicatat ke tabel riwayat (stock_movements).
 */
class StockController extends Controller
{
    private const ALERT = 5;
    private const REASONS = [
        'restock' => 'Restock / barang masuk',
        'damaged' => 'Barang rusak',
        'lost' => 'Barang hilang',
        'correction' => 'Koreksi hasil cek fisik',
    ];

    public function index(Request $request)
    {
        $all = $this->all();
        $counts = [
            'all' => $all->count(),
            'low' => $all->where('level', 'low')->count(),
            'out' => $all->where('level', 'out')->count(),
        ];

        $filtered = $all
            ->when($request->q, fn ($c, $q) => $c->filter(
                fn ($i) => str_contains(strtolower($i->name . ' ' . $i->variant . ' ' . $i->category), strtolower($q))
            ))
            ->when(in_array($request->status, ['low', 'out'], true), fn ($c) => $c->where('level', $request->status))
            ->values();

        $perPage = 6;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $items = new LengthAwarePaginator(
            $filtered->forPage($page, $perPage)->values(), $filtered->count(), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.stock.manage', ['reasons' => self::REASONS] + compact('items', 'counts'));
    }

    public function adjust(Request $request, int $item)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:0',
            'reason' => 'required|in:' . implode(',', array_keys(self::REASONS)),
            'note' => 'nullable|string|max:255',
        ]);
        $row = $this->all()->firstWhere('id', $item) ?? abort(404);

        return back()->with('success', "Stok {$row->name} ({$row->variant}) diubah menjadi {$data['quantity']} pcs (data dummy, belum tersimpan).");
    }

    private function all()
    {
        return collect([
            [1, 'Gamis Katun Rayon Zafira', 'Warna: Mustard • Size L', 'Gamis', 2, '15 menit lalu', '#D9A441'],
            [2, 'Blouse Crinkle Lilac', 'Warna: Lilac • Size M', 'Blouse', 3, '2 jam lalu', '#B39DDB'],
            [3, 'Celana Kulot Scuba Black', 'Warna: Hitam • All Size', 'Celana', 0, 'Kemarin', '#111827'],
            [4, 'Hijab Voal Waterproof Mocca', 'Warna: Mocca • Reguler (115×115)', 'Hijab', 65, '3 hari lalu', '#8B6B5A'],
            [5, 'Tunik Floral Cotton Mint', 'Warna: Mint Green • Size XL', 'Tunik', 1, '4 jam lalu', '#7FD1B9'],
            [6, 'Mukena Silk Rayon White', 'Warna: Broken White • Dewasa Jumbo', 'Perlengkapan Sholat', 14, '1 hari lalu', '#CFC6AE'],
            [7, 'Kulot Linen Pants', 'Warna: Cream • Size XL', 'Celana', 3, '5 jam lalu', '#E8D9B5'],
            [8, 'Hijab Segiempat Voal Olive', 'Warna: Olive • All Size', 'Hijab', 0, '2 hari lalu', '#6B7A3A'],
            [9, 'Dress Floral Pastel', 'Warna: Dusty Pink • Size M', 'Gamis', 9, '6 hari lalu', '#D98A9A'],
            [10, 'Khimar Jumbo Cokelat', 'Warna: Mocca • All Size', 'Hijab', 40, '1 minggu lalu', '#8B6B5A'],
        ])->map(function ($r) {
            [$id, $name, $variant, $category, $stock, $updated, $color] = $r;

            return (object) [
                'id' => $id, 'name' => $name, 'variant' => $variant, 'category' => $category,
                'stock' => $stock, 'updated' => $updated, 'color' => $color,
                'level' => $stock === 0 ? 'out' : ($stock <= self::ALERT ? 'low' : 'ok'),
                'history' => [
                    ['date' => '18 Mei 2025, 09:12', 'qty' => -1, 'after' => $stock, 'reason' => 'Pesanan #ORD-9830', 'by' => 'Sistem'],
                    ['date' => '16 Mei 2025, 15:40', 'qty' => -2, 'after' => $stock + 1, 'reason' => 'Pesanan #ORD-9812', 'by' => 'Sistem'],
                    ['date' => '02 Mei 2025, 10:05', 'qty' => $stock + 3, 'after' => $stock + 3, 'reason' => 'Stok awal produk', 'by' => 'Ibu Rahma'],
                ],
            ];
        });
    }
}