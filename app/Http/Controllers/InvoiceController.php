<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Pembelian::where('status', 'Selesai')
                    ->latest()
                    ->get();

        return view('invoice.index', compact('invoices'));
    }


    public function create($id)
    {
        $pembelian = Pembelian::with('detailPembelians.barang')
                        ->findOrFail($id);

        return view('invoice.create', compact('pembelian'));
    }


    public function store(Request $request, $id)
    {
        $pembelian = Pembelian::with('detailPembelians')
                        ->findOrFail($id);

        $total = 0;

        foreach ($pembelian->detailPembelians as $detail) {

            // Ambil Qty Masuk dari form Invoice
            $qtyMasuk = isset($request->qty_masuk[$detail->id])
                ? (int) $request->qty_masuk[$detail->id]
                : (int) $detail->qty_masuk;

            // Minimal Qty Masuk adalah 1
            if ($qtyMasuk < 1) {
                $qtyMasuk = 1;
            }

            // Ambil harga dari form Invoice
            $harga = isset($request->harga[$detail->id])
                ? (float) $request->harga[$detail->id]
                : (float) $detail->harga_satuan;

            /*
             * PENTING:
             * jumlah = Qty Pesanan dari PO
             * qty_masuk = Qty barang yang masuk dari Gudang
             *
             * Jadi jumlah JANGAN diubah di sini.
             */

            // Simpan Qty Masuk
            $detail->qty_masuk = $qtyMasuk;

            // Simpan harga
            $detail->harga_satuan = $harga;

            // Hitung subtotal berdasarkan Qty Masuk
            $detail->subtotal = $qtyMasuk * $harga;

            $detail->save();

            // Hitung total invoice
            $total += $detail->subtotal;
        }


        // Simpan data invoice
        $pembelian->no_invoice = $request->no_invoice;
        $pembelian->tanggal_invoice = $request->tanggal_invoice;
        $pembelian->total_biaya = $total;
        $pembelian->status_invoice = 'Sudah Diisi';

        $pembelian->save();


        return redirect()
                ->route('invoice.index')
                ->with('success', 'Invoice berhasil disimpan.');
    }


    public function show($id)
    {
        $pembelian = Pembelian::with('detailPembelians.barang')
                        ->findOrFail($id);

        return view('invoice.show', compact('pembelian'));
    }


    public function pdf($id)
    {
        $pembelian = Pembelian::with('detailPembelians.barang')
                        ->findOrFail($id);

        $pdf = Pdf::loadView('invoice.pdf', compact('pembelian'));

        return $pdf->stream(
            'Invoice-'.$pembelian->no_invoice.'.pdf'
        );
    }
}