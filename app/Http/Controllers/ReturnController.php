<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReturController extends Controller
{
    public function index($id = null)
    {
        $user = auth()->user();

        return view('retur.index', compact(
            'user',
            'id'
        ));
    }
}