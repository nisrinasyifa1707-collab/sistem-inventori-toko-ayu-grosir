<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Golongan;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangController extends Controller

{
    public function index()
    {
        $barangs = Barang::with(['golongan', 'kategori', 'supplier'])->get();

        $golongans = Golongan::all();
        $kategoris = Kategori::all();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('barang.index', compact(
            'barangs',
            'golongans',
            'kategoris',
            'suppliers'
        ));
    }

    public function create()
    {
        $golongans = Golongan::all();
        $kategoris = Kategori::all();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('barang.create', compact(
            'golongans',
            'kategoris',
            'suppliers'
        ));
    }    


    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang',
            'nama_barang' => 'required',
            'golongan_id' => 'required|exists:golongans,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'stok' => 'required|numeric',
            'min_stok' => 'required|numeric',
            'satuan' => 'required',
        ]);

        Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'golongan_id' => $request->golongan_id,
            'kategori_id' => $request->kategori_id,
            'supplier_id' => $request->supplier_id,
            'stok' => $request->stok,
            'min_stok' => $request->min_stok,
            'satuan' => $request->satuan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);

        $golongans = Golongan::all();
        $kategoris = Kategori::all();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('barang.edit', compact(
            'barang',
            'golongans',
            'kategoris',
            'suppliers'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'golongan_id' => 'required|exists:golongans,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'harga_satuan' => 'required|numeric',
            'stok' => 'required|numeric',
            'min_stok' => 'required|numeric',
            'satuan' => 'required',
        ]);

        $barang = Barang::findOrFail($id);

        $barang->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'golongan_id' => $request->golongan_id,
            'kategori_id' => $request->kategori_id,
            'supplier_id' => $request->supplier_id,
            'harga' => $request->harga_satuan,
            'stok' => $request->stok,
            'min_stok' => $request->min_stok,
            'satuan' => $request->satuan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}