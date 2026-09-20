<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class StockController extends Controller
{
    // GET /admin/stock
    public function index(Request $request)
    {
        // TODO: ambil produk yang stoknya menipis/habis, contoh:
        // $products = Product::where('stock', '<=', 5)->paginate(10);
        $products = [];

        return view('admin.stock.index', compact('products'));
    }

    // GET /admin/stock/{product}/edit
    public function edit(int $product)
    {
        // TODO: $product = Product::findOrFail($product);

        return view('admin.stock.edit', compact('product'));
    }

    // PUT /admin/stock/{product}
    public function update(Request $request, int $product): RedirectResponse
    {
        $validated = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        // TODO: Product::findOrFail($product)->update(['stock' => $validated['stock']]);

        return redirect()->route('admin.stock.index')->with('status', 'Stok berhasil diperbarui.');
    }
}