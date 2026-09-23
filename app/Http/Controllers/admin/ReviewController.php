<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * TAHAP FRONTEND: data dummy. Di tahap backend, rating & ulasan dibuat pembeli setelah pesanan Selesai
 * (lihat use case "melihat riwayat dan status pesanan" -> extend "rating"/"ulasan" di sisi pembeli).
 * "toggleVisibility" menyembunyikan ulasan dari halaman produk tanpa menghapus datanya.
 */
class ReviewController extends Controller
{
    private const TABS = ['all' => 'Semua', 'unreplied' => 'Belum Dibalas', 'reported' => 'Dilaporkan', 'hidden' => 'Disembunyikan'];

    public function index(Request $request)
    {
        $all = $this->all();
        $counts = [
            'all' => $all->count(),
            'unreplied' => $all->where('reply', null)->where('hidden', false)->count(),
            'reported' => $all->where('reported', true)->count(),
            'hidden' => $all->where('hidden', true)->count(),
        ];
        $summary = [
            'avg' => round($all->avg('rating'), 1),
            'total' => $all->count(),
            'stars' => collect(range(5, 1))->map(fn ($s) => ['star' => $s, 'count' => $all->where('rating', $s)->count()]),
        ];

        $tab = array_key_exists($request->tab, self::TABS) ? $request->tab : 'all';
        $reviews = $all
            ->when($tab === 'unreplied', fn ($c) => $c->where('reply', null)->where('hidden', false))
            ->when($tab === 'reported', fn ($c) => $c->where('reported', true))
            ->when($tab === 'hidden', fn ($c) => $c->where('hidden', true))
            ->when($request->rating, fn ($c, $r) => $c->where('rating', (int) $r))
            ->when($request->q, fn ($c, $q) => $c->filter(
                fn ($r) => str_contains(strtolower($r['product'] . ' ' . $r['customer'] . ' ' . $r['comment']), strtolower($q))
            ))
            ->values();

        $perPage = 6;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $paged = new LengthAwarePaginator(
            $reviews->forPage($page, $perPage)->values(), $reviews->count(), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.reviews.list', ['tabs' => self::TABS] + compact('paged', 'counts', 'tab', 'summary'));
    }

    public function reply(Request $request, int $review)
    {
        $request->validate(['message' => 'required|string|max:500']);
        $row = $this->find($review);

        return back()->with('success', "Balasan untuk ulasan {$row['customer']} pada {$row['product']} berhasil dikirim (data dummy, belum tersimpan).");
    }

    public function toggleVisibility(int $review)
    {
        $row = $this->find($review);
        $action = $row['hidden'] ? 'ditampilkan kembali' : 'disembunyikan';

        return back()->with('success', "Ulasan {$row['customer']} pada {$row['product']} berhasil {$action} (data dummy, belum tersimpan).");
    }

    public function destroy(int $review)
    {
        $row = $this->find($review);

        return back()->with('success', "Ulasan {$row['customer']} pada {$row['product']} berhasil dihapus (data dummy, belum terhapus).");
    }

    private function find(int $id): array
    {
        return $this->all()->firstWhere('id', $id) ?? abort(404);
    }

    private function all()
    {
        $rows = [
            ['id' => 1, 'product' => 'Gamis Katun Rayon Zafira', 'variant' => 'Size L, Mustard', 'color' => '#D9A441', 'customer' => 'Siti Aisyah', 'order' => '#ORD-9812', 'rating' => 5, 'comment' => 'Bahannya adem banget dan jatuhnya bagus, cocok buat acara formal. Pengiriman juga cepat!', 'photos' => 2, 'time' => '2 jam lalu', 'reply' => null, 'reported' => false, 'hidden' => false],
            ['id' => 2, 'product' => 'Blouse Crinkle Lilac', 'variant' => 'Size M', 'color' => '#B39DDB', 'customer' => 'Dian Pratiwi', 'order' => '#ORD-9820', 'rating' => 4, 'comment' => 'Warnanya sedikit beda tipis dari foto, tapi bahannya nyaman dan jatuh bagus dipakai.', 'photos' => 1, 'time' => '5 jam lalu', 'reply' => null, 'reported' => false, 'hidden' => false],
            ['id' => 3, 'product' => 'Hijab Paris Voal Premium Olive', 'variant' => 'All Size', 'color' => '#6B7A3A', 'customer' => 'Nurul Hasanah', 'order' => '#ORD-9819', 'rating' => 5, 'comment' => 'Voalnya lembut, gampang dibentuk, ga gampang kusut. Repeat order pasti!', 'photos' => 0, 'time' => 'Kemarin, 16:40', 'reply' => 'Terima kasih banyak Kak Nurul! Senang bisa jadi bagian dari gaya hijab kakak 🤍', 'reported' => false, 'hidden' => false],
            ['id' => 4, 'product' => 'Tunik Brokat Pesta Maroon', 'variant' => 'Size XL', 'color' => '#7A1F2B', 'customer' => 'Maya Anggraini', 'order' => '#ORD-9818', 'rating' => 4, 'comment' => 'Bagus dan mewah, cuma ukurannya agak kebesaran sedikit dari biasanya.', 'photos' => 3, 'time' => 'Kemarin, 09:12', 'reply' => null, 'reported' => false, 'hidden' => false],
            ['id' => 5, 'product' => 'Celana Kulot Scuba Highwaist Black', 'variant' => 'All Size', 'color' => '#111827', 'customer' => 'Rina Kusuma', 'order' => '#ORD-9817', 'rating' => 3, 'comment' => 'Warnanya agak beda tipis dari foto, tapi ukurannya pas dan bahannya cukup nyaman.', 'photos' => 2, 'time' => '2 hari lalu', 'reply' => null, 'reported' => false, 'hidden' => false],
            ['id' => 6, 'product' => 'Dress Floral Pastel M', 'variant' => 'Size M', 'color' => '#D98A9A', 'customer' => 'Fatimah Zahra', 'order' => '#ORD-9825', 'rating' => 5, 'comment' => 'Cantik banget motifnya, jahitannya rapi. Recommended seller!', 'photos' => 1, 'time' => '3 hari lalu', 'reply' => 'Makasih Kak Fatimah, ditunggu order selanjutnya ya 🌸', 'reported' => false, 'hidden' => false],
            ['id' => 7, 'product' => 'Kulot Linen Pants', 'variant' => 'Size XL, Cream', 'color' => '#E8D9B5', 'customer' => 'Anisa Rahmadani', 'order' => '#ORD-9826', 'rating' => 3, 'comment' => 'Lumayan, tapi resletingnya agak seret. Bahan oke.', 'photos' => 0, 'time' => '4 hari lalu', 'reply' => null, 'reported' => false, 'hidden' => false],
            ['id' => 8, 'product' => 'Hijab Segiempat Voal Olive', 'variant' => 'All Size', 'color' => '#6B7A3A', 'customer' => 'Dewi Lestari', 'order' => '#ORD-9827', 'rating' => 3, 'comment' => 'Pengiriman agak lebih lama dari perkiraan, tapi produknya sesuai deskripsi.', 'photos' => 0, 'time' => '5 hari lalu', 'reply' => null, 'reported' => false, 'hidden' => false],
            ['id' => 9, 'product' => 'Khimar Jumbo Cokelat', 'variant' => 'All Size', 'color' => '#8B6B5A', 'customer' => 'Laila Fitri', 'order' => '#ORD-9808', 'rating' => 4, 'comment' => 'Ukurannya jumbo beneran, nutup dada dengan baik. Warnanya sesuai.', 'photos' => 1, 'time' => '1 minggu lalu', 'reply' => null, 'reported' => false, 'hidden' => false],
            ['id' => 10, 'product' => 'Gamis Linen Sage Green', 'variant' => 'Size L', 'color' => '#8FA98A', 'customer' => 'Yuni Astuti', 'order' => '#ORD-9805', 'rating' => 5, 'comment' => 'Adem dan ga nerawang meski warnanya terang. Puas banget belanja disini.', 'photos' => 2, 'time' => '1 minggu lalu', 'reply' => 'Terima kasih Kak Yuni atas ulasannya! 🙏', 'reported' => false, 'hidden' => false],
        ];

        return collect($rows)->map(fn ($r) => $r + [
            'reply_url' => route('admin.reviews.reply', $r['id']),
            'visibility_url' => route('admin.reviews.visibility', $r['id']),
            'delete_url' => route('admin.reviews.destroy', $r['id']),
        ]);
    }
}