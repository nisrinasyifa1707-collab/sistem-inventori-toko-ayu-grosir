<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SettingSupplierController extends Controller
{
    /**
     * Halaman Setting Supplier
     */
    public function index()
    {
        $suppliers = Supplier::with('barangs')->orderBy('nama_supplier')->get();

        $barangs = Barang::orderBy('nama_barang')->get();

        return view('setting-supplier.index', compact(
            'suppliers',
            'barangs'
        ));
    }

    /**
     * Simpan setting supplier dengan barang
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'barang_ids' => 'nullable|array',
            'barang_ids.*' => 'exists:barangs,id',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Bersihkan hubungan barang dengan supplier yang dipilih
        |--------------------------------------------------------------------------
        */

        Barang::where('supplier_id', $request->supplier_id)
            ->update([
                'supplier_id' => null
            ]);

        /*
        |--------------------------------------------------------------------------
        | Hubungkan barang dengan supplier
        |--------------------------------------------------------------------------
        */

        if ($request->filled('barang_ids')) {

            Barang::whereIn('id', $request->barang_ids)
                ->update([
                    'supplier_id' => $request->supplier_id
                ]);
        }

        return redirect()
            ->route('setting-supplier.index')
            ->with(
                'success',
                'Setting supplier dan barang berhasil disimpan.'
            );
    }
}