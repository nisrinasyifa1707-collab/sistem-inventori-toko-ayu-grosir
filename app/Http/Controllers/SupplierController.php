<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Barang;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::with('barangs')
            ->latest()
            ->get();

        $barangs = Barang::orderBy('nama_barang')->get();

        return view('supplier.index', compact('suppliers', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'alamat' => 'nullable',
            'telepon' => 'nullable',
            'barang_ids' => 'nullable|array',
            'barang_ids.*' => 'exists:barangs,id',
        ]);

        $supplier = Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        // Menghubungkan barang dengan supplier
        if ($request->filled('barang_ids')) {
            Barang::whereIn('id', $request->barang_ids)
                ->update([
                    'supplier_id' => $supplier->id
                ]);
        }

        return back()->with(
            'success',
            'Supplier dan barang berhasil ditambahkan.'
        );
    }

    public function edit($id)
    {
        $supplier = Supplier::with('barangs')->findOrFail($id);

        $barangs = Barang::orderBy('nama_barang')->get();

        return view('supplier.edit', compact('supplier', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'alamat' => 'nullable',
            'telepon' => 'nullable',
            'barang_ids' => 'nullable|array',
            'barang_ids.*' => 'exists:barangs,id',
        ]);

        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        // Hapus hubungan barang lama
        Barang::where('supplier_id', $supplier->id)
            ->update([
                'supplier_id' => null
            ]);

        // Simpan hubungan barang yang baru
        if ($request->filled('barang_ids')) {
            Barang::whereIn('id', $request->barang_ids)
                ->update([
                    'supplier_id' => $supplier->id
                ]);
        }

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        // Lepaskan barang dari supplier sebelum supplier dihapus
        Barang::where('supplier_id', $supplier->id)
            ->update([
                'supplier_id' => null
            ]);

        $supplier->delete();

        return back()->with(
            'success',
            'Supplier berhasil dihapus.'
        );
    }
}