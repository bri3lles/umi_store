<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * TAHAP FRONTEND: data dummy. Di tahap backend, angka dihitung dari tabel pesanan (omzet),
 * harga modal produk (HPP), dan status pembayaran/pesanan per rentang tanggal yang dipilih.
 */
class ReportController extends Controller
{
    private const RANGES = ['today' => 'Hari Ini', 'week' => '7 Hari Terakhir', 'month' => 'Bulan Ini (Mei 2025)', 'year' => 'Tahun Ini'];

    public function index(Request $request)
    {
        $range = array_key_exists($request->range, self::RANGES) ? $request->range : 'month';

        $daily = collect([
            ['d' => 11, 'label' => '11 Mei', 'omzet' => 2450000, 'laba' => 980000],
            ['d' => 12, 'label' => '12 Mei', 'omzet' => 2180000, 'laba' => 870000],
            ['d' => 13, 'label' => '13 Mei', 'omzet' => 3020000, 'laba' => 1150000],
            ['d' => 14, 'label' => '14 Mei', 'omzet' => 2870000, 'laba' => 1080000],
            ['d' => 15, 'label' => '15 Mei', 'omzet' => 3600000, 'laba' => 1550000],
            ['d' => 16, 'label' => '16 Mei', 'omzet' => 2950000, 'laba' => 1240000],
            ['d' => 17, 'label' => '17 Mei (Sabtu)', 'omzet' => 4920000, 'laba' => 2120000],
            ['d' => 18, 'label' => '18 Mei (Minggu)', 'omzet' => 3850000, 'laba' => 1640000],
        ]);
        $peak = $daily->firstWhere('omzet', $daily->max('omzet'));

        $charts = [
            'today' => ['label' => ['09:00', '11:00', '13:00', '15:00', '17:00', '19:00'], 'omzet' => [320000, 610000, 540000, 780000, 690000, 910000], 'laba' => [120000, 260000, 210000, 330000, 290000, 380000]],
            'week' => ['label' => $daily->pluck('label')->all(), 'omzet' => $daily->pluck('omzet')->all(), 'laba' => $daily->pluck('laba')->all()],
            'month' => ['label' => $daily->pluck('label')->all(), 'omzet' => $daily->pluck('omzet')->all(), 'laba' => $daily->pluck('laba')->all()],
            'year' => ['label' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'], 'omzet' => [58000000, 63500000, 71200000, 68900000, 76300000], 'laba' => [22000000, 24800000, 28100000, 26500000, 30700000]],
        ];

        $categories = [
            ['name' => 'Gamis & Dress Muslim', 'percent' => 46, 'value' => 22425000],
            ['name' => 'Blouse & Tunik Cantik', 'percent' => 28, 'value' => 13650000],
            ['name' => 'Celana & Kulot Santai', 'percent' => 16, 'value' => 7800000],
            ['name' => 'Hijab & Voal Segiempat', 'percent' => 10, 'value' => 4875000],
        ];

        return view('admin.reports.summary', [
            'ranges' => self::RANGES, 'range' => $range,
            'chart' => $charts[$range], 'peak' => $peak,
            'categories' => $categories, 'topProduct' => ['name' => 'Gamis Rayon Twill Premium', 'sold' => 88],
            'daily' => $daily->reverse()->values(),
            'totals' => [
                'orders' => $daily->count() * 15, 'qty' => $daily->count() * 24,
                'omzet' => $daily->sum('omzet'), 'hpp' => (int) round($daily->sum('omzet') * .575),
                'laba' => $daily->sum('laba'),
            ],
        ]);
    }
}