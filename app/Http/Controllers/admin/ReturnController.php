<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ReturnController extends Controller
{
    // GET /admin/returns
    public function index(Request $request)
    {
        // TODO: $returns = ReturnRequest::with('order')->latest()->paginate(10);
        $returns = [];

        return view('admin.returns.index', compact('returns'));
    }

    // GET /admin/returns/{return}
    public function show(int $return)
    {
        // TODO: $return = ReturnRequest::with('order', 'evidence')->findOrFail($return);

        return view('admin.returns.show', compact('return'));
    }

    // POST /admin/returns/{return}/approve
    public function approve(int $return): RedirectResponse
    {
        // TODO: ReturnRequest::findOrFail($return)->update(['status' => 'disetujui']);

        return redirect()->route('admin.returns.index')->with('status', 'Pengajuan retur disetujui.');
    }

    // POST /admin/returns/{return}/reject
    public function reject(Request $request, int $return): RedirectResponse
    {
        $request->validate([
            'reason' => 'nullable|string|max:255',
        ]);

        // TODO: ReturnRequest::findOrFail($return)->update(['status' => 'ditolak']);

        return redirect()->route('admin.returns.index')->with('status', 'Pengajuan retur ditolak.');
    }
}