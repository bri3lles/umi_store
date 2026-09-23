<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * TAHAP FRONTEND: data dummy. "Terverifikasi", "Aktif Sejak", dan status API kurir
 * di tahap backend berasal dari proses verifikasi email dan cek koneksi masing-masing pihak ketiga.
 */
class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.account', [
            'profile' => [
                'name' => 'Ibu Rahma Nurhaliza', 'role' => 'Owner & Pengambil Keputusan', 'since' => 'Akun Aktif Sejak Maret 2021',
                'email' => 'rahma.umistore@gmail.com', 'phone' => '+62 812-8821-9920', 'access' => 'Super Admin (Akses Penuh Seluruh Menu)',
            ],
            'store' => [
                'name' => 'Umi Store Busana Muslim & Hijab', 'open' => true,
                'open_time' => '08:00', 'close_time' => '17:00', 'tagline' => 'Busana Muslimah Anggun, Nyaman, dan Terjangkau',
                'address' => 'Jl. Riau No. 88, Citarum, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40115',
                'address_label' => 'Sentra Gudang Umi Store - Bandung Wetan',
            ],
            'couriers' => [
                ['key' => 'jnt', 'name' => 'J&T Express', 'desc' => 'Reguler, COD, & Pick-up Harian otomatis jam 15:00', 'active' => true, 'status' => 'API OK'],
                ['key' => 'sicepat', 'name' => 'SiCepat Ekspres', 'desc' => 'Layanan SiUntung & BEST (Pick up diantar kurir)', 'active' => true, 'status' => 'API OK'],
                ['key' => 'instant', 'name' => 'Instant / Same Day', 'desc' => 'GoSend & GrabExpress khusus area Kota Bandung', 'active' => true, 'status' => 'Radius 15km'],
            ],
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'store_name' => 'required|string|max:150',
            'open_time' => 'required',
            'close_time' => 'required',
            'tagline' => 'nullable|string|max:150',
            'address' => 'required|string|max:255',
        ]);

        return back()->with('success', 'Perubahan pengaturan akun & toko berhasil disimpan (data dummy, belum tersimpan).');
    }
}