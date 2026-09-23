<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * TAHAP FRONTEND: data dummy. Di tahap backend, status berpindah otomatis:
 * Midtrans konfirmasi pembayaran -> new (menunggu konfirmasi admin) -> admin terima -> to_pack,
 * "Atur Pengiriman" -> ready, kurir menjemput -> shipping, diterima -> done.
 * Admin juga bisa menolak pesanan baru (new -> cancelled) atau mengubah status pesanan
 * secara manual kapan saja lewat "Ubah Status".
 */
class OrderController extends Controller
{
    private const COURIERS = ['jnt' => 'J&T Express', 'sicepat' => 'SiCepat Reguler', 'gosend' => 'Instant Gosend'];
    private const TABS = [
        'all' => 'Semua Pesanan', 'new' => 'Pesanan Baru', 'to_pack' => 'Perlu Diproses', 'ready' => 'Siap Dikirim',
        'shipping' => 'Dikirim', 'done' => 'Selesai', 'cancelled' => 'Dibatalkan',
    ];
    private const DATES = ['today' => 'Hari Ini', 'yesterday' => 'Kemarin', 'week' => '7 Hari Terakhir', 'month' => '30 Hari Terakhir'];
    private const STATUS = [
        'new' => ['Menunggu Konfirmasi', 'new'], 'to_pack' => ['Perlu Dikemas', 'wait'], 'ready' => ['Siap Dikirim', 'paid'], 'shipping' => ['Sedang Dikirim', 'ship'],
        'done' => ['Selesai', 'done'], 'cancelled' => ['Dibatalkan', 'cancel'],
    ];
    private const REJECT_REASONS = [
        'stock' => 'Stok produk habis / tidak tersedia',
        'address' => 'Alamat pengiriman tidak lengkap / tidak valid',
        'suspect' => 'Pesanan mencurigakan / terindikasi spam',
        'request' => 'Permintaan pembatalan dari pembeli',
        'other' => 'Lainnya',
    ];

    public function index(Request $request)
    {
        $all = $this->all();
        $counts = ['all' => $all->count()];
        foreach (array_keys(self::STATUS) as $key) {
            $counts[$key] = $all->where('status', $key)->count();
        }

        $tab = array_key_exists($request->tab, self::TABS) ? $request->tab : 'all';
        $days = ['today' => [0, 0], 'yesterday' => [1, 1], 'week' => [0, 6], 'month' => [0, 29]][$request->date] ?? null;

        $filtered = $all
            ->when($tab !== 'all', fn ($c) => $c->where('status', $tab))
            ->when(array_key_exists($request->courier, self::COURIERS), fn ($c) => $c->where('courier_key', $request->courier))
            ->when($days, fn ($c) => $c->filter(fn ($o) => $o['day_offset'] >= $days[0] && $o['day_offset'] <= $days[1]))
            ->when($request->q, fn ($c, $q) => $c->filter(
                fn ($o) => str_contains(strtolower($o['no'] . ' ' . $o['buyer'] . ' ' . $o['resi']), strtolower($q))
            ))
            ->values();

        $perPage = 6;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $orders = new LengthAwarePaginator(
            $filtered->forPage($page, $perPage)->values(), $filtered->count(), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.orders.board', [
            'tabs' => self::TABS, 'couriers' => self::COURIERS, 'dates' => self::DATES,
            'rejectReasons' => self::REJECT_REASONS,
            'statusOptions' => collect(self::STATUS)->except('new')->map(fn ($s) => $s[0])->all(),
        ] + compact('orders', 'counts', 'tab'));
    }

    public function ship(Request $request, int $order)
    {
        $data = $request->validate([
            'courier' => 'required|in:' . implode(',', array_keys(self::COURIERS)),
            'resi' => 'nullable|string|max:40',
        ]);
        $row = $this->find($order);

        return back()->with('success', "Pengiriman {$row['no']} diatur via " . self::COURIERS[$data['courier']] . " dan ditandai Siap Dikirim (data dummy, belum tersimpan).");
    }

    public function accept(int $order)
    {
        $row = $this->find($order);

        return back()->with('success', "Pesanan {$row['no']} diterima dan dipindahkan ke status \"Perlu Dikemas\" (data dummy, belum tersimpan).");
    }

    public function reject(Request $request, int $order)
    {
        $data = $request->validate([
            'reason' => 'required|in:' . implode(',', array_keys(self::REJECT_REASONS)),
            'note' => 'nullable|string|max:255',
        ]);
        $row = $this->find($order);

        return back()->with('success', "Pesanan {$row['no']} ditolak: " . self::REJECT_REASONS[$data['reason']] . " (data dummy, belum tersimpan, dana belum benar-benar dikembalikan).");
    }

    public function updateStatus(Request $request, int $order)
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(self::STATUS)),
        ]);
        // 'new' hanya bisa dicapai lewat alur pembayaran otomatis, bukan lewat pengubahan status manual.
        if ($data['status'] === 'new') {
            return back()->withErrors(['status' => 'Status "Menunggu Konfirmasi" tidak bisa diatur secara manual.']);
        }
        $row = $this->find($order);

        return back()->with('success', "Status pesanan {$row['no']} diubah menjadi \"" . self::STATUS[$data['status']][0] . "\" (data dummy, belum tersimpan).");
    }

    private function find(int $id): array
    {
        return $this->all()->firstWhere('id', $id) ?? abort(404);
    }

    private function all()
    {
        $rows = [
            // id, pembeli, telepon, wilayah, alamat, item[nama, varian, qty, harga], ongkir, metode, kurir, resi, status, waktu, hari lalu, warna
            [9834, 'Salma Rahayu', '0812-4455-xxxx', 'Klojen, Kota Malang', 'Jl. Ijen Boulevard No. 9, Klojen, Kota Malang, Jawa Timur 65119', [['Setelan Muslimah Syar\'i Dusty Rose', 'M', 1, 265000]], 15000, 'QRIS Instant', 'sicepat', null, 'new', '5 Menit lalu', 0, '#C48A8A'],
            [9833, 'Windy Oktaviani', '0857-6600-xxxx', 'Menteng, Jakarta Pusat', 'Jl. HOS Cokroaminoto No. 15, Menteng, Jakarta Pusat, DKI Jakarta 10310', [['Rok Plisket Denim Biru', 'L', 2, 115000]], 10000, 'BCA Transfer', 'jnt', null, 'new', '10 Menit lalu', 0, '#6B7A3A'],
            [9830, 'Siti Fatimah', '0812-3345-xxxx', 'Bandung Wetan, Kota Bandung', 'Jl. Riau No. 88, Bandung Wetan, Kota Bandung, Jawa Barat 40115', [['Gamis Katun Rayon Zafira', 'L', 2, 225000]], 0, 'BCA Transfer', 'jnt', null, 'to_pack', '25 Menit lalu', 0, '#D9A441'],
            [9831, 'Aulia Rahma', '0857-1010-xxxx', 'Coblong, Kota Bandung', 'Jl. Dipati Ukur No. 21, Coblong, Kota Bandung, Jawa Barat 40132', [['Blouse Crinkle Lilac', 'M', 1, 145000]], 12000, 'QRIS Instant', 'jnt', null, 'to_pack', '40 Menit lalu', 0, '#B39DDB'],
            [9832, 'Retno Wulandari', '0813-7788-xxxx', 'Sukolilo, Surabaya', 'Jl. Keputih Tegal No. 5, Sukolilo, Surabaya, Jawa Timur 60111', [['Hijab Paris Voal Olive', 'Reguler', 3, 45000]], 15000, 'Mandiri VA', 'sicepat', null, 'to_pack', '1 Jam lalu', 0, '#6B7A3A'],
            [9828, 'Nadhira Putri', '0821-7766-xxxx', 'Cilandak, Jakarta Selatan', 'Jl. Cilandak KKO No. 12, Cilandak, Jakarta Selatan, DKI Jakarta 12560', [['Blouse Katun Motif', 'M', 2, 95000]], 0, 'QRIS Instant', 'sicepat', '00412891203', 'ready', '1 Jam lalu', 0, '#C48A8A'],
            [9827, 'Dewi Lestari', '0878-4455-xxxx', 'Cicendo, Kota Bandung', 'Jl. Pasirkaliki No. 40, Cicendo, Kota Bandung, Jawa Barat 40171', [['Abaya Basic Hitam Jetblack', 'All Size', 4, 105000]], 0, 'BSI Mobile', 'jnt', 'JT771230984', 'ready', '2 Jam lalu', 0, '#111827'],
            [9825, 'Rina Kusuma', '0812-9000-xxxx', 'Wonokromo, Surabaya', 'Jl. Wonokromo No. 77, Wonokromo, Surabaya, Jawa Timur 60243', [['Celana Kulot Scuba Black', 'All Size', 1, 135000]], 0, 'Mandiri VA', 'jnt', 'JT889102456', 'shipping', '3 Jam lalu', 0, '#111827'],
            [9824, 'Anisa Rahmadani', '0813-9933-xxxx', 'Tebet, Jakarta Selatan', 'Jl. Tebet Barat Dalam No. 9, Tebet, Jakarta Selatan, DKI Jakarta 12810', [['Tunik Katun Bordir Dusty Pink', 'L', 1, 185500]], 0, 'QRIS Instant', 'sicepat', '00412770145', 'shipping', 'Kemarin, 15:10', 1, '#D98A9A'],
            [9823, 'Fatimah Zahra', '0856-1122-xxxx', 'Beji, Depok', 'Jl. Margonda Raya No. 3, Beji, Depok, Jawa Barat 16424', [['Khimar Ceruty', 'XL', 1, 145000], ['Pashmina Voal', 'All Size', 2, 97500]], 0, 'Mandiri VA', 'jnt', 'JT771230001', 'shipping', 'Kemarin, 09:20', 1, '#8B6B5A'],
            [9821, 'Maya Anggraini', '0857-3300-xxxx', 'Banyumanik, Semarang', 'Jl. Setiabudi No. 55, Banyumanik, Semarang, Jawa Tengah 50264', [['Tunik Brokat Pesta Maroon', 'XL', 1, 285000]], 0, 'BSI Mobile', 'gosend', 'GS-99081231-JK', 'done', 'Kemarin, 16:30', 1, '#7A1F2B'],
            [9819, 'Nurul Hasanah', '0813-2200-xxxx', 'Kebayoran Baru, Jakarta Selatan', 'Jl. Senopati No. 18, Kebayoran Baru, Jakarta Selatan, DKI Jakarta 12190', [['Khimar Jumbo Cokelat', 'All Size', 1, 120000]], 0, 'Mandiri VA', 'jnt', 'JT700122987', 'done', '3 Hari lalu', 3, '#8B6B5A'],
            [9816, 'Laila Fitri', '0852-1188-xxxx', 'Lowokwaru, Kota Malang', 'Jl. Soekarno Hatta No. 20, Lowokwaru, Malang, Jawa Timur 65141', [['Hijab Segiempat Voal Olive', 'All Size', 3, 55000]], 0, 'QRIS Instant', 'sicepat', '00412555013', 'done', '4 Hari lalu', 4, '#6B7A3A'],
            [9815, 'Yuni Astuti', '0838-5522-xxxx', 'Cimahi Tengah, Kota Cimahi', 'Jl. Jend. H. Amir Machmud No. 14, Cimahi Tengah, Cimahi, Jawa Barat 40521', [['Gamis Linen Sage Green', 'L', 1, 215000]], 0, 'Mandiri VA', 'jnt', null, 'cancelled', '5 Hari lalu', 5, '#8FA98A'],
        ];
        $rp = fn ($n) => 'Rp ' . number_format($n, 0, ',', '.');
        $steps = ['Pesanan dibuat', 'Pembayaran diverifikasi', 'Pesanan dikonfirmasi penjual', 'Pesanan dikemas', 'Diserahkan ke kurir', 'Pesanan diterima pelanggan'];
        $reached = ['new' => 2, 'to_pack' => 3, 'ready' => 4, 'shipping' => 5, 'done' => 6];

        return collect($rows)->map(function ($r) use ($rp, $steps, $reached) {
            [$id, $buyer, $phone, $area, $address, $items, $shipping, $method, $courier, $resi, $status, $ago, $offset, $color] = $r;
            $subtotal = array_sum(array_map(fn ($i) => $i[2] * $i[3], $items));
            $created = Carbon::create(2025, 5, 18, 10, 0)->subDays($offset)->subHours(3);
            $labels = $status === 'cancelled' ? ['Pesanan dibuat', 'Pesanan dibatalkan'] : array_slice($steps, 0, $reached[$status]);

            return [
                'id' => $id, 'no' => "#ORD-{$id}", 'ago' => $ago, 'day_offset' => $offset, 'color' => $color,
                'buyer' => $buyer, 'phone' => $phone, 'area' => $area, 'address' => $address,
                'items' => array_map(fn ($i) => ['name' => $i[0], 'variant' => $i[1], 'qty' => $i[2], 'price_label' => $rp($i[3] * $i[2])], $items),
                'first' => $items[0][0], 'first_variant' => $items[0][1], 'qty' => array_sum(array_column($items, 2)), 'more' => count($items) - 1,
                'subtotal_label' => $rp($subtotal), 'shipping_label' => $shipping ? $rp($shipping) : 'Gratis', 'total' => $subtotal + $shipping, 'total_label' => $rp($subtotal + $shipping),
                'method' => $method, 'verified' => $status !== 'cancelled',
                'courier_key' => $courier, 'courier' => self::COURIERS[$courier], 'resi' => $resi,
                'status' => $status, 'status_label' => self::STATUS[$status][0], 'status_tone' => self::STATUS[$status][1],
                'timeline' => collect($labels)->map(fn ($l, $k) => [
                    'label' => $l, 'time' => $created->copy()->addMinutes($k * 70)->locale('id')->translatedFormat('d M Y, H:i'),
                ])->all(),
                'ship_url' => route('admin.orders.ship', $id),
                'accept_url' => route('admin.orders.accept', $id),
                'reject_url' => route('admin.orders.reject', $id),
                'status_url' => route('admin.orders.status', $id),
            ];
        });
    }
}