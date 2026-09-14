<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class HargaController extends Controller
{
    private function cekAkses()
    {
        if (!auth()->check()) {
            abort(403);
        }

        if (!in_array(strtolower(auth()->user()->role), ['admin', 'owner'])) {
            abort(403, 'Anda tidak memiliki akses ke menu Penentuan Harga.');
        }
    }

    /**
     * Menampilkan daftar barang pada halaman Penentuan Harga.
     */
    public function index(Request $request)
    {
        $this->cekAkses();

        $search = $request->input('search');

        $barangs = Barang::with(['golongan', 'kategori'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%")
                      ->orWhere('kode_barang', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('harga.index', compact('barangs', 'search'));
    }

    /**
     * Menampilkan form edit harga barang.
     */
    public function edit($id)
    {
        $this->cekAkses();

        $barang = Barang::with(['golongan', 'kategori'])
            ->findOrFail($id);

        return view('harga.edit', compact('barang'));
    }

    /**
     * Menyimpan harga beli dan harga jual.
     */
    public function update(Request $request, $id)
    {
        $this->cekAkses();

        $request->validate([
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ], [
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_beli.numeric' => 'Harga beli harus berupa angka.',
            'harga_jual.required' => 'Harga jual wajib diisi.',
            'harga_jual.numeric' => 'Harga jual harus berupa angka.',
        ]);

        $barang = Barang::findOrFail($id);

        $hargaBeli = (float) $request->harga_beli;
$hargaJual = (float) $request->harga_jual;

$margin = $hargaJual - $hargaBeli;

$barang->update([
    'harga' => $hargaJual,
    'harga_beli' => $hargaBeli,
    'harga_jual' => $hargaJual,
    'margin' => $margin,
]);
        
        return redirect()
            ->route('harga.index')
            ->with('success', 'Harga barang berhasil diperbarui!');
    }
}