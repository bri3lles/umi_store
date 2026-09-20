<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    // GET /admin/orders
    public function index(Request $request)
    {
        // TODO: $orders = Order::with('buyer')->latest()->paginate(10);
        $orders = [];

        return view('admin.orders.index', compact('orders'));
    }

    // GET /admin/orders/{order}
    public function show(int $order)
    {
        // TODO: $order = Order::with('items', 'buyer')->findOrFail($order);

        return view('admin.orders.show', compact('order'));
    }

    // POST /admin/orders/{order}/process
    public function process(int $order): RedirectResponse
    {
        // TODO: Order::findOrFail($order)->update(['status' => 'dikirim']);

        return redirect()->route('admin.orders.index')->with('status', 'Pesanan diproses untuk dikirim.');
    }

    // GET /admin/orders/{order}/track
    public function track(int $order)
    {
        // TODO: $order = Order::findOrFail($order); ambil nomor resi & histori pengiriman

        return view('admin.orders.track', compact('order'));
    }
}