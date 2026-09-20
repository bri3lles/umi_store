<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SalesReportController extends Controller
{
    // GET /admin/sales
    public function index(Request $request)
    {
        // TODO: hitung rekap penjualan per periode, contoh:
        // $sales = Order::where('status', 'selesai')
        //     ->whereBetween('created_at', [$request->from, $request->to])
        //     ->get();
        $sales = [];

        return view('admin.sales.index', compact('sales'));
    }

    // GET /admin/sales/export
    public function export(Request $request): StreamedResponse
    {
        // TODO: generate CSV/Excel export, misalnya pakai Laravel Excel (maatwebsite/excel)
        $filename = 'rekap-penjualan-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            echo "No,Tanggal,Total\n"; // TODO: isi baris data asli
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}