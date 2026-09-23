<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * TAHAP FRONTEND: semua angka masih data dummy. Akan dihitung dari database di tahap backend.
 */
class DashboardController extends Controller
{
    public function index()
    {
        $week = [
            ['l' => 'Sen', 'v' => 2100000], ['l' => 'Sel', 'v' => 1900000], ['l' => 'Rab', 'v' => 3200000],
            ['l' => 'Kam', 'v' => 3600000], ['l' => 'Jum', 'v' => 3500000], ['l' => 'Sab', 'v' => 3400000],
            ['l' => 'Min', 'v' => 3850000],
        ];
        $month = [
            ['l' => 'Mgg 1', 'v' => 18200000], ['l' => 'Mgg 2', 'v' => 21400000],
            ['l' => 'Mgg 3', 'v' => 19800000], ['l' => 'Mgg 4', 'v' => 24600000],
        ];

        return view('admin.dashboard', [
            'adminName' => auth()->user()->name ?? 'Ibu Rahma',
            'stats' => [
                ['label' => 'Pesanan Baru', 'value' => 14, 'unit' => 'Pesanan', 'note' => '8 perlu diproses', 'tone' => 'blue', 'icon' => 'bag', 'route' => 'admin.orders.index'],
                ['label' => 'Verifikasi Bayar', 'value' => 5, 'unit' => 'Bukti Transfer', 'note' => 'Perlu Konfirmasi', 'tone' => 'amber', 'icon' => 'receipt', 'route' => 'admin.payments.index'],
                ['label' => 'Stok Menipis', 'value' => 3, 'unit' => 'Produk', 'note' => 'Segera Restock', 'tone' => 'red', 'icon' => 'archive', 'route' => 'admin.stock.index'],
                ['label' => 'Pengajuan Retur', 'value' => 2, 'unit' => 'Pengajuan', 'note' => 'Cek Bukti', 'tone' => 'peach', 'icon' => 'return', 'route' => 'admin.returns.index'],
            ],
            'chart' => [
                'week' => ['growth' => '+18,5% mingguan', 'points' => $week],
                'month' => ['growth' => '+12,3% bulanan', 'points' => $month],
            ],
            'weekTotal' => array_sum(array_column($week, 'v')),
            'lowStock' => [
                ['name' => 'Gamis Linen Sage Green', 'variant' => 'Size L', 'sku' => 'GMS-NV-L', 'stock' => 2, 'color' => '#1E2A78'],
                ['name' => 'Hijab Segiempat Voal Olive', 'variant' => 'All Size', 'sku' => 'HJB-VO-OL', 'stock' => 0, 'color' => '#6B7A3A'],
                ['name' => 'Kulot Linen Pants', 'variant' => 'Size XL', 'sku' => 'KLT-LN-SD', 'stock' => 3, 'color' => '#E8D9B5'],
            ],
            'orders' => [
                ['no' => '#ORD-9821', 'buyer' => 'Siti Aisyah', 'city' => 'Bandung, Jawa Barat', 'product' => 'Gamis Linen Sage Green', 'qty' => 1, 'total' => 215000, 'status' => 'wait', 'status_label' => 'Menunggu Verifikasi', 'time' => 'Hari ini, 14:20', 'action' => 'check'],
                ['no' => '#ORD-9820', 'buyer' => 'Dian Pratiwi', 'city' => 'Surabaya, Jawa Timur', 'product' => 'Dress Floral Pastel M', 'qty' => 2, 'total' => 380000, 'status' => 'paid', 'status_label' => 'Lunas / Perlu Dikirim', 'time' => 'Hari ini, 13:45', 'action' => 'ship'],
                ['no' => '#ORD-9819', 'buyer' => 'Nurul Hasanah', 'city' => 'Jakarta Selatan, DKI', 'product' => 'Khimar Jumbo Cokelat', 'qty' => 1, 'total' => 120000, 'status' => 'ship', 'status_label' => 'Sedang Dikirim (J&T)', 'time' => 'Hari ini, 11:15', 'action' => 'track'],
                ['no' => '#ORD-9818', 'buyer' => 'Maya Anggraini', 'city' => 'Semarang, Jawa Tengah', 'product' => 'Tunic Denim Casual L', 'qty' => 1, 'total' => 195000, 'status' => 'done', 'status_label' => 'Selesai Diterima', 'time' => 'Hari ini, 09:30', 'action' => 'detail'],
                ['no' => '#ORD-9817', 'buyer' => 'Rina Kusuma', 'city' => 'Tangerang, Banten', 'product' => 'Kulot Linen Cream', 'qty' => 1, 'total' => 165000, 'status' => 'cancel', 'status_label' => 'Dibatalkan Pembeli', 'time' => 'Kemarin, 21:10', 'action' => 'detail-dim'],
            ],
        ]);
    }
}