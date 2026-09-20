<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function edit()
    {
        $user = Auth::user();
        return view('profile', compact('user')); // Mengarah ke resources/views/profile.blade.php
    }

    // Memproses update profil
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validasi dan simpan data di sini sesuai kebutuhan
        $user->nama = $request->input('nama');
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
