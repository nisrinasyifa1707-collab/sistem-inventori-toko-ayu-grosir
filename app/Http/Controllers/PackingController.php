<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;

class PackingController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil transaksi yang masih membutuhkan proses packing
        |--------------------------------------------------------------------------
        | Transaksi dengan status "Selesai / Dikirim" tidak ditampilkan
        | karena sudah selesai diproses oleh staff packing.
        */

        $transaksis = Penjualan::with('detailPenjualans.barang')
            ->where(function ($query) {
                $query->whereNull('status_packing')
                      ->orWhere('status_packing', 'Pending')
                      ->orWhere('status_packing', 'Proses Packing');
            })
            ->latest()
            ->get();

        return view('packing.index', compact('transaksis'));
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_packing' => 'required|in:Pending,Proses Packing,Selesai / Dikirim'
        ]);

        $penjualan = Penjualan::findOrFail($id);

        $penjualan->status_packing = $request->status_packing;

        $penjualan->save();

        return response()->json([
            'success' => true,
            'message' => 'Status packing berhasil diperbarui!'
        ]);
    }
}