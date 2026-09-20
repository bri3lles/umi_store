<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class CartController extends Controller
{
    public function index()
    {
        // Simulasi data keranjang belanja
        $carts = [
            [
                'id' => 'item-1',
                'title' => 'Kemeja Katun Oxford Slim Fit - Putih',
                'size' => 'M',
                'color' => 'Putih',
                'price' => 249000,
                'quantity' => 1,
                'image' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?q=80&w=300&auto=format&fit=crop',
                'is_out_of_stock' => false,
            ],
            [
                'id' => 'item-2',
                'title' => 'Kaos Polos Katun Pima Premium - Navy',
                'size' => 'L',
                'color' => 'Navy',
                'price' => 149000,
                'quantity' => 2,
                'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=300&auto=format&fit=crop',
                'is_out_of_stock' => false,
            ],
            [
                'id' => 'item-3',
                'title' => 'Celana Chino Tapered Fit - Khaki',
                'size' => '32',
                'color' => 'Khaki',
                'price' => 189000,
                'quantity' => 1,
                'image' => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?q=80&w=300&auto=format&fit=crop',
                'is_out_of_stock' => true,
            ],
        ];

        return view('keranjang', compact('carts'));
    }
}