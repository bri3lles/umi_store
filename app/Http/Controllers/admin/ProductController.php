<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    // GET /admin/products
    public function index(Request $request)
    {
        // TODO: ambil data produk asli, contoh: Product::latest()->paginate(10)
        $products = [];

        return view('admin.products.index', compact('products'));
    }

    // GET /admin/products/create
    public function create()
    {
        return view('admin.products.create');
    }

    // POST /admin/products
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            // TODO: lengkapi aturan validasi sesuai kolom tabel products
        ]);

        // TODO: Product::create($validated);

        return redirect()->route('admin.products.index')->with('status', 'Produk berhasil ditambahkan.');
    }

    // GET /admin/products/{product}
    public function show(int $product)
    {
        // TODO: $product = Product::findOrFail($product);

        return view('admin.products.show', compact('product'));
    }

    // GET /admin/products/{product}/edit
    public function edit(int $product)
    {
        // TODO: $product = Product::findOrFail($product);

        return view('admin.products.edit', compact('product'));
    }

    // PUT /admin/products/{product}
    public function update(Request $request, int $product): RedirectResponse
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        // TODO: Product::findOrFail($product)->update($validated);

        return redirect()->route('admin.products.index')->with('status', 'Produk berhasil diperbarui.');
    }

    // DELETE /admin/products/{product}
    public function destroy(int $product): RedirectResponse
    {
        // TODO: Product::findOrFail($product)->delete();

        return redirect()->route('admin.products.index')->with('status', 'Produk berhasil dihapus.');
    }
}