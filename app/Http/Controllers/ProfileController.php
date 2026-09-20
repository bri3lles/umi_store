<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('profile.index', compact('user'));
    }


    public function pesanan()
    {
        $user = auth()->user();

        return view('profile.pesanan', compact('user'));
    }


    public function wishlist()
    {
        $user = auth()->user();

        return view('profile.wishlist', compact('user'));
    }


    public function pengaturan()
    {
        $user = auth()->user();

        return view('profile.pengaturan', compact('user'));
    }
}