<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('barang')->latest();

        // Filter berdasarkan rentang tanggal
        if ($request->has('start_date') && $request->start_date && $request->has('end_date') && $request->end_date) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $transaksis = $query->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        return view('transaksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'jenis' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required',
        ]);

        Transaksi::create($request->all());

        $barang = Barang::findOrFail($request->barang_id);
        if ($request->jenis == 'Masuk') {
            $barang->stok += $request->jumlah;
        } else {
            $barang->stok -= $request->jumlah;
        }
        $barang->save();

        return redirect('/barang')->with('success', 'Transaksi berhasil dan stok terupdate!');
    }

    public function exportPdf(Request $request)
    {
        $query = Transaksi::with('barang')->latest();
        
        // Filter yang sama dengan index agar hasil PDF sesuai dengan tampilan
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }
        
        $transaksis = $query->get();
        $pdf = Pdf::loadView('transaksi.pdf', compact('transaksis'));
        return $pdf->stream('laporan-transaksi.pdf');
    }

    public function resetAll()
    {
        // Hapus semua data transaksi sekaligus
        Transaksi::truncate();

        return redirect()->back()->with('success', 'Semua riwayat transaksi berhasil dibersihkan!');
    }
}