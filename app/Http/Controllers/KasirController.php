<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $barangs = Barang::when($search, function ($query, $search) {
            return $query->where('nama_barang', 'like', "%{$search}%")
                         ->orWhere('kode_barang', 'like', "%{$search}%");
        })->get();

        return view('kasir.index', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:Cash,QRIS',
            'total_harga' => 'required|numeric|min:0',
            'bayar' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:barangs,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            $bayar = $request->metode_pembayaran == 'QRIS'
                ? $request->total_harga
                : $request->bayar;

            $kembalian = $request->metode_pembayaran == 'QRIS'
                ? 0
                : max(0, $request->bayar - $request->total_harga);

            $tanggal = now()->format('Ymd');

            $jumlahHariIni = Penjualan::whereDate(
                'created_at',
                today()
            )->count() + 1;

            $noFaktur = 'INV-' . $tanggal . '-' .
                str_pad($jumlahHariIni, 4, '0', STR_PAD_LEFT);

            $penjualan = Penjualan::create([
                'no_faktur' => $noFaktur,
                'metode_pembayaran' => $request->metode_pembayaran,
                'total_harga' => $request->total_harga,
                'bayar' => $bayar,
                'kembalian' => $kembalian,
            ]);

            foreach ($request->items as $item) {

                $barang = Barang::findOrFail($item['id']);

                if ($barang->stok < $item['jumlah']) {
                    throw new \Exception(
                        "Stok {$barang->nama_barang} tidak mencukupi"
                    );
                }

                $hargaJual = $barang->harga_jual ?? 0;

                DetailPenjualan::create([
                       'penjualan_id' => $penjualan->id,
    'barang_id' => $barang->id,
    'jumlah' => $item['jumlah'],
    'harga_satuan' => $hargaJual,
    'harga_beli' => $barang->harga_beli ?? 0,
    'subtotal' => $item['jumlah'] * $hargaJual,
]);

                $barang->stok -= $item['jumlah'];
                $barang->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'penjualan_id' => $penjualan->id,
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function tambahStok(Request $request, $id)
    {
        $request->validate([
            'tambahan_stok' => 'required|integer|min:1'
        ]);

        try {

            $barang = Barang::findOrFail($id);

            $barang->stok += $request->tambahan_stok;
            $barang->save();

            return response()->json([
                'success' => true,
                'message' =>
                    "Stok {$barang->nama_barang} berhasil ditambahkan sebanyak {$request->tambahan_stok}!"
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambah stok: ' . $e->getMessage()
            ], 422);
        }
    }

    public function struk($id)
    {
        $penjualan = Penjualan::with(
            'detailPenjualans.barang'
        )->findOrFail($id);

        return view('kasir.struk', compact('penjualan'));
    }
}