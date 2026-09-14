<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    // Menampilkan data
    public function index(Request $request)
    {
        $search = $request->search;

        $golongans = Golongan::when($search, function ($query) use ($search) {
            $query->where('nama_golongan', 'like', '%' . $search . '%');
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('golongan.index', compact('golongans'));
    }

    // Form create (sementara belum dipakai)
    public function create()
    {
        return redirect()->route('golongan.index');
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'nama_golongan' => 'required|unique:golongans,nama_golongan'
        ]);

        Golongan::create([
            'nama_golongan' => $request->nama_golongan
        ]);

        return redirect()->route('golongan.index')
            ->with('success', 'Golongan berhasil ditambahkan.');
    }

    // Form edit (sementara belum dipakai)
    public function edit($id)
    {
        return redirect()->route('golongan.index');
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_golongan' => 'required|unique:golongans,nama_golongan,' . $id
        ]);

        $golongan = Golongan::findOrFail($id);

        $golongan->update([
            'nama_golongan' => $request->nama_golongan
        ]);

        return redirect()->route('golongan.index')
            ->with('success', 'Golongan berhasil diubah.');
    }

    // Hapus data
    public function destroy($id)
    {
        $golongan = Golongan::findOrFail($id);

        $golongan->delete();

        return redirect()->route('golongan.index')
            ->with('success', 'Golongan berhasil dihapus.');
    }
}