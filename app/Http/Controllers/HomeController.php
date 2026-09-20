<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman beranda Umi Store.
     * Data produk di bawah ini contoh statis (dummy) — nanti tinggal
     * diganti dengan query dari model Product, mis:
     * Product::where('is_best_seller', true)->take(4)->get()
     */
    public function index()
    {
        $produkTerlaris = [
            [
                'nama'    => 'Celana Kulot Palma Tailored',
                'warna'   => 'Navy Classic Crepe',
                'harga'   => 479000,
                'terjual' => 98,
                'gambar'  => 'img/image.png',
            ],
            [
                'nama'    => 'Celana Kulot Palma Tailored',
                'warna'   => 'Navy Classic Crepe',
                'harga'   => 479000,
                'terjual' => 98,
                'gambar'  => 'img/produk-2.png',
            ],
            [
                'nama'    => 'Celana Kulot Palma Tailored',
                'warna'   => 'Navy Classic Crepe',
                'harga'   => 479000,
                'terjual' => 98,
                'gambar'  => 'img/produk-3.png',
            ],
            [
                'nama'    => 'Celana Kulot Palma Tailored',
                'warna'   => 'Navy Classic Crepe',
                'harga'   => 479000,
                'terjual' => 98,
                'gambar'  => 'img/produk-4.png',
            ],
        ];

        return view('home', compact('produkTerlaris'));
    }
}