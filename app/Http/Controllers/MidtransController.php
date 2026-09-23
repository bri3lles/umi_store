<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    public function getSnapToken(Request $request)
    {

        // 1. Setup konfigurasi Midtrans dari config/midtrans.php
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');

        // 2. Susun detail transaksi (order_id cukup unik, gak perlu disimpan ke DB)
        $params = [
            'transaction_details' => [
                'order_id'     => 'UMI-' . time() . '-' . strtoupper(uniqid()),
                'gross_amount' => (int) $request->input('gross_amount'),
            ],
            'customer_details' => [
                'first_name' => 'Pelanggan',
                'email'      => 'pelanggan@example.com',
            ],
        ];

        // 3. Minta Snap Token ke server Midtrans
        $snapToken = Snap::getSnapToken($params);

        // 4. Balikin token ke frontend sebagai JSON
        return response()->json(['snap_token' => $snapToken]);
    }
}