<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    /**
     * Menampilkan halaman Gudang
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $barangs = Barang::when($search, function ($query, $search) {
            return $query->where('nama_barang', 'like', "%{$search}%")
                         ->orWhere('kode_barang', 'like', "%{$search}%");
        })->get();

        // Pembelian yang belum diterima
        $pembelians = Pembelian::where('status', 'Menunggu Barang')
            ->latest()
            ->get();

        // Statistik gudang
        $totalJenisBarang = Barang::count();

        // Total stok yang ada di gudang
        $totalStokFisik = Barang::sum('qty_gudang');

        // Barang hampir habis berdasarkan stok gudang
        $barangHampirHabis = Barang::where('qty_gudang', '<=', 5)
            ->count();

        // Riwayat barang masuk
        $riwayatBarangMasuk = Barang::latest()
            ->take(10)
            ->get();

        return view('gudang.index', compact(
            'barangs',
            'pembelians',
            'totalJenisBarang',
            'totalStokFisik',
            'barangHampirHabis',
            'search',
            'riwayatBarangMasuk'
        ));
    }


    /**
     * Update stok gudang dan stok Master Barang
     */
    public function updateStok(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Barang belum di-update
        |--------------------------------------------------------------------------
        */

        if ($barang->status_update == 0) {

            // QTY Awal mengambil stok dari Master Barang
            $qtyAwal = $barang->qty_awal ?? $barang->stok ?? 0;

            // QTY Masuk adalah jumlah barang yang diterima Gudang
            $qtyMasuk = $barang->qty_masuk ?? 0;

            // Simpan QTY Awal
            $barang->qty_awal = $qtyAwal;

            // Hitung QTY Stok Gudang
            $qtyStok = $qtyAwal + $qtyMasuk;

            // Simpan QTY Stok Gudang
            $barang->qty_gudang = $qtyStok;

            // Sinkronkan dengan stok Master Barang / Kasir
            $barang->stok = $qtyStok;

            // Tandai sudah di-update
            $barang->status_update = 1;

            $barang->save();

            return redirect()
                ->route('gudang.index')
                ->with(
                    'success',
                    'Stok gudang dan Master Barang berhasil diperbarui.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Jika sudah pernah di-update
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('gudang.index')
            ->with(
                'success',
                'Barang sudah diperbarui sebelumnya.'
            );
    }


    /**
     * Menampilkan halaman penerimaan barang
     */
    public function terimaBarang($id)
    {
        $pembelian = Pembelian::with('detailPembelians.barang')
            ->findOrFail($id);

        $detail = DetailPembelian::with('barang')
            ->where('pembelian_id', $id)
            ->get();

        return view('gudang.terima', compact(
            'pembelian',
            'detail'
        ));
    }


    /**
     * Menyimpan barang yang diterima
     */
    public function simpanBarangMasuk(Request $request, $id)
    {
        $pembelian = Pembelian::with('detailPembelians.barang')
            ->findOrFail($id);

        foreach ($pembelian->detailPembelians as $detail) {

            /*
            |--------------------------------------------------------------------------
            | Qty barang yang diterima
            |--------------------------------------------------------------------------
            */

            $qtyMasuk = isset($request->qty_masuk[$detail->id])
                ? (int) $request->qty_masuk[$detail->id]
                : 0;

            if ($qtyMasuk < 0) {
                $qtyMasuk = 0;
            }


            /*
            |--------------------------------------------------------------------------
            | Simpan Qty Masuk pada Detail Pembelian
            |--------------------------------------------------------------------------
            */

            $detail->qty_masuk = $qtyMasuk;

            $detail->keterangan =
                $request->keterangan[$detail->id] ?? null;

            $detail->save();


            /*
            |--------------------------------------------------------------------------
            | Simpan QTY Awal dan QTY Masuk pada Barang
            |--------------------------------------------------------------------------
            */

            $barang = $detail->barang;

            // QTY Awal = stok yang ada di Master Barang
            $barang->qty_awal = $barang->stok ?? 0;

            // QTY Masuk = barang yang benar-benar diterima
            $barang->qty_masuk = $qtyMasuk;

            /*
             * Jangan ubah stok Master Barang di sini.
             *
             * Stok Master Barang baru bertambah
             * ketika tombol "Update" ditekan.
             */

            // Belum dilakukan update stok
            $barang->status_update = 0;

            $barang->save();
        }


        /*
        |--------------------------------------------------------------------------
        | Ubah status Purchase Order
        |--------------------------------------------------------------------------
        */

        $pembelian->status = 'Selesai';

        $pembelian->tanggal_akhir = now();

        $pembelian->save();


        return redirect()
            ->route('gudang.index')
            ->with(
                'success',
                'Barang berhasil diterima. Silakan lakukan Update Stok.'
            );
    }
}