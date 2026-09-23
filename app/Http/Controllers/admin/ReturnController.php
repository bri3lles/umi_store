<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * TAHAP FRONTEND: data dummy. Alur status di backend:
 * review -> (approve) awaiting -> (arrive) ready -> (complete) done, atau review -> (reject) rejected.
 * "arrive" menambah stok kembali bila kondisi barang layak jual; "complete" mencatat refund / kirim pengganti.
 */
class ReturnController extends Controller
{
    private const STORE_ADDRESS = 'Jl. Riau No. 88, Citarum, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40115';
    private const TABS = [
        'review' => 'Menunggu Review', 'awaiting' => 'Menunggu Barang Sampai', 'ready' => 'Siap Refund / Ganti',
        'done' => 'Selesai', 'rejected' => 'Ditolak',
    ];
    private const STATUS = [
        'review' => ['Menunggu Review', 'red'], 'awaiting' => ['Menunggu Barang Sampai', 'amber'],
        'ready' => ['Barang Tiba di Toko', 'blue'], 'done' => ['Selesai', 'green'], 'rejected' => ['Ditolak', 'gray'],
    ];
    private const REASONS = [
        'defect' => 'Cacat Jahitan / Bahan', 'size' => 'Tukar Ukuran', 'wrong_item' => 'Salah Kirim Barang / Warna',
        'not_as_described' => 'Tidak Sesuai Deskripsi / Foto', 'shipping_damage' => 'Rusak Saat Pengiriman',
    ];
    private const REJECT_REASONS = [
        'evidence' => 'Bukti foto/video tidak cukup', 'expired' => 'Melewati batas waktu pengajuan',
        'used' => 'Barang sudah dipakai / dicuci', 'policy' => 'Tidak sesuai kebijakan retur',
    ];

    public function index(Request $request)
    {
        $all = $this->all();
        $counts = [];
        foreach (array_keys(self::TABS) as $key) {
            $counts[$key] = $all->where('status', $key)->count();
        }

        $tab = array_key_exists($request->tab, self::TABS) ? $request->tab : 'review';
        $cases = $all->where('status', $tab)
            ->when(array_key_exists($request->reason, self::REASONS), fn ($c) => $c->where('reason_key', $request->reason))
            ->when($request->q, fn ($c, $q) => $c->filter(
                fn ($r) => str_contains(strtolower($r['no'] . ' ' . $r['order'] . ' ' . $r['customer']), strtolower($q))
            ))
            ->values();

        return view('admin.returns.cases', [
            'tabs' => self::TABS, 'reasons' => self::REASONS,
            'config' => [
                'store_address' => self::STORE_ADDRESS,
                'reject_reasons' => self::REJECT_REASONS,
                'resolutions' => ['exchange' => 'Kirim barang pengganti', 'refund' => 'Refund dana'],
                'costs' => ['shop' => 'Ditanggung Toko', 'buyer' => 'Ditanggung Pembeli'],
                'offer_types' => ['discount' => 'Diskon (%)', 'voucher' => 'Voucher (Rp)'],
                'qc' => ['ok' => 'Sesuai — kondisi mulus, tag lengkap', 'minor' => 'Cacat ringan — masih bisa dijual ulang', 'bad' => 'Tidak sesuai — tidak dapat dijual ulang'],
            ],
        ] + compact('cases', 'counts', 'tab'));
    }

    public function act(Request $request, int $retur, string $action)
    {
        $row = $this->all()->firstWhere('id', $retur) ?? abort(404);
        $note = 'nullable|string|max:255';

        $request->validate(match ($action) {
            'reject' => ['reason' => 'required|in:' . implode(',', array_keys(self::REJECT_REASONS)), 'note' => $note],
            'offer' => ['type' => 'required|in:discount,voucher', 'value' => 'required|integer|min:1', 'note' => $note],
            'approve' => ['resolution' => 'required|in:exchange,refund', 'cost' => 'required|in:shop,buyer', 'note' => $note],
            'arrive' => ['qc' => 'required|in:ok,minor,bad', 'note' => $note],
            'complete' => ['reference' => 'nullable|string|max:60'],
        });

        $message = match ($action) {
            'reject' => "Pengajuan {$row['no']} ditolak.",
            'offer' => "Penawaran diskon/voucher untuk {$row['no']} dikirim ke pembeli.",
            'approve' => "Retur {$row['no']} disetujui. Alamat pengembalian dikirim ke pembeli.",
            'arrive' => "Barang retur {$row['no']} ditandai sudah tiba di toko.",
            'complete' => "Retur {$row['no']} ditandai selesai.",
        };

        return back()->with('success', $message . ' (data dummy, belum tersimpan).');
    }

    private function all()
    {
        $rows = [
            ['id' => 89, 'no' => '#RET-2024-089', 'order' => '#ORD-9812', 'status' => 'review', 'submitted' => 'Diajukan 2 jam yang lalu', 'customer' => 'Ibu Wardah', 'phone' => '0812-9981-xxxx', 'area' => 'Lowokwaru, Kota Malang', 'address' => 'Jl. Soekarno Hatta No. 20, Lowokwaru, Malang 65141', 'product' => 'Gamis Katun Rayon Zafira - Emerald Green', 'color' => '#2F7D5B', 'variant_line' => 'Varian: Size L (1 Pcs) • Rp 189.000', 'reason' => 'defect', 'resolution' => 'refund', 'price' => 189000, 'media' => [['photo', 'Bukti Unboxing', '#5B7C99'], ['photo', 'Detail Robekan', '#B8A99A']], 'note' => 'Terdapat robekan kecil di bagian keliman bawah lengan kanan saat pertama kali buka paket unboxing. Benang tampak tertarik parah tidak layak pakai.'],
            ['id' => 90, 'no' => '#RET-2024-090', 'order' => '#ORD-9806', 'status' => 'review', 'submitted' => 'Diajukan 5 jam yang lalu', 'customer' => 'Farah Nabila', 'phone' => '0857-2211-xxxx', 'area' => 'Klojen, Kota Malang', 'address' => 'Jl. Kawi No. 7, Klojen, Malang 65119', 'product' => 'Blouse Crinkle Lilac', 'color' => '#B39DDB', 'variant_line' => 'Varian: Size M (1 Pcs) • Rp 145.000', 'reason' => 'not_as_described', 'resolution' => 'refund', 'price' => 145000, 'media' => [['video', 'Video Unboxing', '#6B7280'], ['photo', 'Warna Berbeda', '#B39DDB']], 'note' => 'Warna yang diterima lebih pucat dan tidak sama dengan foto di katalog. Saya minta refund.'],
            ['id' => 87, 'no' => '#RET-2024-087', 'order' => '#ORD-9790', 'status' => 'awaiting', 'submitted' => 'Diajukan kemarin, 10:15 WIB', 'customer' => 'Ratna Sari', 'phone' => '0813-4400-xxxx', 'area' => 'Sukun, Kota Malang', 'address' => 'Jl. Ki Ageng Gribig No. 30, Sukun, Malang 65147', 'product' => 'Dress Floral Pastel M', 'color' => '#D98A9A', 'variant_line' => 'Varian Asal: Size M • Minta Ganti: Size L', 'reason' => 'size', 'reason_label' => 'Tukar Ukuran (Kekecilan)', 'resolution' => 'exchange', 'exchange_to' => 'Size L', 'price' => 190000, 'courier' => 'SiCepat Reguler', 'resi_back' => '00398211077', 'cost' => 'buyer', 'shipped' => 'Dikirim balik kemarin, 14:20 WIB'],
            ['id' => 86, 'no' => '#RET-2024-086', 'order' => '#ORD-9788', 'status' => 'awaiting', 'submitted' => 'Diajukan 2 hari yang lalu', 'customer' => 'Winda Astuti', 'phone' => '0878-1200-xxxx', 'area' => 'Cicendo, Kota Bandung', 'address' => 'Jl. Pasirkaliki No. 12, Cicendo, Bandung 40171', 'product' => 'Hijab Segiempat Voal Olive', 'color' => '#6B7A3A', 'variant_line' => 'Varian Asal: Olive • Minta Ganti: Sage Green', 'reason' => 'wrong_item', 'resolution' => 'exchange', 'exchange_to' => 'Sage Green', 'price' => 110000, 'courier' => 'J&T Express Regular', 'resi_back' => '90123774', 'cost' => 'shop', 'shipped' => 'Dikirim balik 2 hari lalu, 09:05 WIB'],
            ['id' => 84, 'no' => '#RET-2024-084', 'order' => '#ORD-9781', 'status' => 'awaiting', 'submitted' => 'Diajukan 3 hari yang lalu', 'customer' => 'Kartika Dewi', 'phone' => '0821-9090-xxxx', 'area' => 'Tebet, Jakarta Selatan', 'address' => 'Jl. Tebet Utara No. 4, Jakarta Selatan 12820', 'product' => 'Tunik Floral Cotton Mint', 'color' => '#7FD1B9', 'variant_line' => 'Varian: Size XL (1 Pcs) • Rp 175.000', 'reason' => 'shipping_damage', 'resolution' => 'refund', 'price' => 175000, 'courier' => 'J&T Express Regular', 'resi_back' => '90123001', 'cost' => 'shop', 'shipped' => 'Dikirim balik 3 hari lalu, 16:40 WIB'],
            ['id' => 85, 'no' => '#RET-2024-085', 'order' => '#ORD-9799', 'status' => 'ready', 'submitted' => 'Diajukan 4 hari yang lalu', 'customer' => 'Dwi Rahayu', 'phone' => '0812-7755-xxxx', 'area' => 'Cipondoh, Kota Tangerang', 'address' => 'Jl. KH. Hasyim Ashari No. 9, Cipondoh, Tangerang 15148', 'product' => 'Celana Kulot Scuba Highwaist Black', 'color' => '#111827', 'variant_line' => 'Varian Asal: Size XL • Minta Ganti: Size L', 'reason' => 'size', 'reason_label' => 'Tukar Ukuran (Kebesaran)', 'resolution' => 'exchange', 'exchange_to' => 'Size L', 'price' => 135000, 'courier' => 'J&T Express Regular', 'resi_back' => '90123891', 'cost' => 'buyer', 'arrived' => 'Paket diterima hari ini, 09:30 WIB', 'qc' => 'Paket telah diverifikasi tim QC gudang toko. Tag produk lengkap, kondisi mulus, bersih & siap kirim pengganti.'],
            ['id' => 80, 'no' => '#RET-2024-080', 'order' => '#ORD-9760', 'status' => 'done', 'submitted' => 'Diajukan 6 hari yang lalu', 'customer' => 'Salma Nur', 'phone' => '0838-6600-xxxx', 'area' => 'Lowokwaru, Kota Malang', 'address' => 'Jl. Veteran No. 3, Malang 65145', 'product' => 'Kulot Linen Pants', 'color' => '#E8D9B5', 'variant_line' => 'Varian: Size XL (1 Pcs) • Rp 165.000', 'reason' => 'defect', 'resolution' => 'refund', 'price' => 165000, 'courier' => 'SiCepat Reguler', 'resi_back' => '00397100455', 'cost' => 'shop', 'decision' => 'Refund dana Rp 165.000 ditransfer ke rekening pembeli (Ref: TRF-88120).'],
            ['id' => 78, 'no' => '#RET-2024-078', 'order' => '#ORD-9742', 'status' => 'done', 'submitted' => 'Diajukan 9 hari yang lalu', 'customer' => 'Tika Amelia', 'phone' => '0856-3300-xxxx', 'area' => 'Blimbing, Kota Malang', 'address' => 'Jl. Borobudur No. 15, Blimbing, Malang 65126', 'product' => 'Blouse Katun Motif', 'color' => '#C48A8A', 'variant_line' => 'Varian Asal: Size S • Minta Ganti: Size M', 'reason' => 'size', 'reason_label' => 'Tukar Ukuran (Kekecilan)', 'resolution' => 'exchange', 'exchange_to' => 'Size M', 'price' => 95000, 'courier' => 'J&T Express Regular', 'resi_back' => '90122011', 'cost' => 'buyer', 'decision' => 'Barang pengganti Size M sudah dikirim (resi JT700455123).'],
            ['id' => 81, 'no' => '#RET-2024-081', 'order' => '#ORD-9755', 'status' => 'rejected', 'submitted' => 'Diajukan 7 hari yang lalu', 'customer' => 'Mira Handayani', 'phone' => '0819-1212-xxxx', 'area' => 'Kedungkandang, Kota Malang', 'address' => 'Jl. Ki Ageng Gribig No. 88, Malang 65137', 'product' => 'Gamis Linen Sage Green', 'color' => '#8FA98A', 'variant_line' => 'Varian: Size L (1 Pcs) • Rp 215.000', 'reason' => 'not_as_described', 'resolution' => 'refund', 'price' => 215000, 'decision' => 'Bukti foto/video tidak cukup menunjukkan cacat produk. Pembeli dapat mengajukan ulang dengan bukti yang jelas.'],
        ];

        $steps = ['Pengajuan diterima', 'Retur disetujui', 'Barang tiba di toko', 'Selesai'];
        $reached = ['review' => 1, 'awaiting' => 2, 'ready' => 3, 'done' => 4];

        return collect($rows)->map(function ($r) use ($steps, $reached) {
            $r += ['media' => [], 'note' => null, 'courier' => null, 'resi_back' => null, 'cost' => null, 'arrived' => null, 'shipped' => null, 'qc' => null, 'decision' => null, 'exchange_to' => null];
            $created = Carbon::create(2025, 5, 18, 9, 0)->subDays($r['id'] % 9 + 1);
            $labels = $r['status'] === 'rejected' ? ['Pengajuan diterima', 'Pengajuan ditolak'] : array_slice($steps, 0, $reached[$r['status']]);
            [$statusLabel, $tone] = self::STATUS[$r['status']];
            $costLabel = $r['cost'] ? ['shop' => 'Ditanggung Toko', 'buyer' => 'Ditanggung Pembeli'][$r['cost']] : null;

            return array_merge($r, [
                'reason_key' => $r['reason'], 'reason' => $r['reason_label'] ?? self::REASONS[$r['reason']],
                'status_label' => $statusLabel, 'tone' => $tone,
                'price_label' => 'Rp ' . number_format($r['price'], 0, ',', '.'),
                'resolution_label' => ['exchange' => 'Kirim barang pengganti', 'refund' => 'Refund dana'][$r['resolution']],
                'cost_label' => $costLabel,
                'media' => array_map(fn ($m) => ['type' => $m[0], 'label' => $m[1], 'color' => $m[2]], $r['media']),
                'timeline' => collect($labels)->map(fn ($l, $k) => [
                    'label' => $l, 'time' => $created->copy()->addHours($k * 20)->locale('id')->translatedFormat('d M Y, H:i'),
                ])->all(),
                'act_url' => preg_replace('#/reject$#', '', route('admin.returns.act', [$r['id'], 'reject'])),
            ]);
        });
    }
}