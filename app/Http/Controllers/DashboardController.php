<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        $transaksis = Transaksi::latest()->take(10)->get();

        // Siapkan variabel awal dengan nilai 0
        $totalPenjualan = 0;
        $totalPembelian = 0;

        // Hanya hitung jika user adalah owner
        if (Auth::user()->role === 'owner') {
            // Ubah bagian ini:
$totalPenjualan = Transaksi::where('jenis', 'Keluar')->sum('jumlah');
$totalPembelian = Transaksi::where('jenis', 'Masuk')->sum('jumlah');
        }

        return view('dashboard', compact('barangs', 'transaksis', 'totalPenjualan', 'totalPembelian'));
    }
}