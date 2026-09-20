<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // TODO: ganti dengan query asli begitu tabel produk/pesanan/retur sudah siap.

        $summary = [
            'pesananBaru'          => 14,
            'pesananPerluDiproses' => 8,
            'verifikasiBayar'      => 5,
            'stokMenipis'          => 3,
            'pengajuanRetur'       => 2,
        ];

        $chart = [
            'total'         => 24600000,
            'growthPercent' => 18.5,
            'labels'        => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            'values'        => [2.1, 1.9, 3.2, 3.9, 4.1, 3.6, 3.8], // dalam juta rupiah
        ];

        $lowStock = [
            [
                'id'      => 1,
                'name'    => 'Gamis Rayon Premium',
                'variant' => 'Size L',
                'sku'     => 'GMS-NV-L',
                'qty'     => 2,
                'image'   => null,
            ],
            [
                'id'      => 2,
                'name'    => 'Hijab Segiempat',
                'variant' => 'All Size',
                'sku'     => 'HJB-VO-OL',
                'qty'     => 0,
                'image'   => null,
            ],
            [
                'id'      => 3,
                'name'    => 'Kulot Linen Pants',
                'variant' => 'Size XL',
                'sku'     => 'KLT-LN-SD',
                'qty'     => 3,
                'image'   => null,
            ],
        ];

        $recentOrders = [
            [
                'no'            => '#ORD-9821',
                'initials'      => 'SA',
                'name'          => 'Siti Aisyah',
                'city'          => 'Bandung, Jawa Barat',
                'product'       => 'Gamis Linen Sage Green',
                'qty'           => 1,
                'total'         => 215000,
                'statusClass'   => 'menunggu',
                'statusLabel'   => 'Menunggu Verifikasi',
                'time'          => 'Hari ini, 14:20',
                'actionLabel'   => 'Periksa Bukti',
                'actionVariant' => 'primary',
                'actionUrl'     => route('admin.payments.show', 1),
            ],
            [
                'no'            => '#ORD-9820',
                'initials'      => 'DP',
                'name'          => 'Dian Pratiwi',
                'city'          => 'Surabaya, Jawa Timur',
                'product'       => 'Dress Floral Pastel M',
                'qty'           => 2,
                'total'         => 380000,
                'statusClass'   => 'lunas',
                'statusLabel'   => 'Lunas / Perlu Dikirim',
                'time'          => 'Hari ini, 13:45',
                'actionLabel'   => 'Proses Kirim',
                'actionVariant' => 'primary',
                'actionUrl'     => route('admin.orders.process', 2),
            ],
            [
                'no'            => '#ORD-9819',
                'initials'      => 'NH',
                'name'          => 'Nurul Hasanah',
                'city'          => 'Jakarta Selatan, DKI',
                'product'       => 'Khimar Jumbo Cokelat',
                'qty'           => 1,
                'total'         => 120000,
                'statusClass'   => 'dikirim',
                'statusLabel'   => 'Sedang Dikirim (J&T)',
                'time'          => 'Hari ini, 11:15',
                'actionLabel'   => 'Lacak Resi',
                'actionVariant' => 'outline',
                'actionUrl'     => route('admin.orders.track', 3),
            ],
            [
                'no'            => '#ORD-9818',
                'initials'      => 'MA',
                'name'          => 'Maya Anggraini',
                'city'          => 'Semarang, Jawa Tengah',
                'product'       => 'Tunic Denim Casual L',
                'qty'           => 1,
                'total'         => 195000,
                'statusClass'   => 'selesai',
                'statusLabel'   => 'Selesai Diterima',
                'time'          => 'Hari ini, 09:30',
                'actionLabel'   => 'Detail',
                'actionVariant' => 'outline',
                'actionUrl'     => route('admin.orders.show', 4),
            ],
            [
                'no'            => '#ORD-9817',
                'initials'      => 'RK',
                'name'          => 'Rina Kusuma',
                'city'          => 'Tangerang, Banten',
                'product'       => 'Kulot Linen Cream',
                'qty'           => 1,
                'total'         => 165000,
                'statusClass'   => 'dibatalkan',
                'statusLabel'   => 'Dibatalkan Pembeli',
                'time'          => 'Kemarin, 21:10',
                'actionLabel'   => 'Detail',
                'actionVariant' => 'outline',
                'actionUrl'     => route('admin.orders.show', 5),
            ],
        ];

        // Ganti dengan kolom asli di tabel toko, misal Toko::first()->is_open
        $tokoBuka = $request->session()->get('toko_buka', true);

        return view('admin.dashboard', compact(
            'summary',
            'chart',
            'lowStock',
            'recentOrders',
            'tokoBuka'
        ));
    }

    public function toggleStatus(Request $request): RedirectResponse
    {
        $current = $request->session()->get('toko_buka', true);

        // TODO: ganti session ini dengan update kolom is_open di tabel toko/settings
        $request->session()->put('toko_buka', ! $current);

        return back()->with('status', 'Status operasional toko diperbarui.');
    }
}