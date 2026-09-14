<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        if ($role == 'owner') return redirect()->route('dashboard'); // Owner ke semua
        if ($role == 'gudang') return redirect()->route('barang.index'); // Gudang ke logistik
        if ($role == 'kasir') return redirect()->route('transaksi.create'); // Kasir ke transaksi
        
        return redirect()->route('dashboard');
    }
}