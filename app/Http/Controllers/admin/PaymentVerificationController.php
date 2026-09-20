<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PaymentVerificationController extends Controller
{
    // GET /admin/payments
    public function index(Request $request)
    {
        // TODO: ambil pesanan dengan status menunggu verifikasi, contoh:
        // $orders = Order::where('payment_status', 'menunggu_verifikasi')->paginate(10);
        $orders = [];

        return view('admin.payments.index', compact('orders'));
    }

    // GET /admin/payments/{order}
    public function show(int $order)
    {
        // TODO: $order = Order::with('items', 'buyer')->findOrFail($order);

        return view('admin.payments.show', compact('order'));
    }

    // POST /admin/payments/{order}/confirm
    public function confirm(int $order): RedirectResponse
    {
        // TODO: Order::findOrFail($order)->update(['payment_status' => 'lunas']);

        return redirect()->route('admin.payments.index')->with('status', 'Pembayaran dikonfirmasi.');
    }

    // POST /admin/payments/{order}/reject
    public function reject(Request $request, int $order): RedirectResponse
    {
        $request->validate([
            'reason' => 'nullable|string|max:255',
        ]);

        // TODO: Order::findOrFail($order)->update(['payment_status' => 'ditolak']);

        return redirect()->route('admin.payments.index')->with('status', 'Pembayaran ditolak.');
    }
}