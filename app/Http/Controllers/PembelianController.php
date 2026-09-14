<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{
    /**
     * Menampilkan daftar pembelian
     */
    public function index()
    {
        $barangs = Barang::with('supplier')->get();

        $pembelians = Pembelian::with('details.barang')
            ->latest()
            ->get();

        return view('pembelian.index', compact(
            'barangs',
            'pembelians'
        ));
    }


    /**
     * Form tambah pembelian
     */
    public function create()
    {
        // Ambil barang beserta supplier
        $barangs = Barang::with('supplier')
            ->orderBy('nama_barang')
            ->get();

        // Nomor PO berikutnya
        $tanggal = now()->format('Y-m-d');

        $jumlahHariIni = Pembelian::whereDate(
            'tanggal_pembelian',
            $tanggal
        )->count();

        $noPo = 'PO-' . $tanggal . '-' . str_pad(
            $jumlahHariIni + 1,
            3,
            '0',
            STR_PAD_LEFT
        );

        return view('pembelian.create', compact(
            'barangs',
            'noPo'
        ));
    }


    /**
     * Menyimpan pembelian
     *
     * 1 Supplier
     * 1 PO
     * Banyak Barang
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',

            'barang_id' => 'required|array|min:1',

            'barang_id.*' => 'required|exists:barangs,id',

            'satuan' => 'required|array',

            'satuan.*' => 'required',

            'qty' => 'required|array',

            'qty.*' => 'required|integer|min:1',

            'tanggal' => 'required|date',

            'catatan' => 'nullable|string',
        ]);


        DB::transaction(function () use ($request) {

            /*
            |--------------------------------------------------------------------------
            | Ambil supplier
            |--------------------------------------------------------------------------
            */

            $supplier = \App\Models\Supplier::findOrFail(
                $request->supplier_id
            );


            /*
            |--------------------------------------------------------------------------
            | Nomor PO
            |--------------------------------------------------------------------------
            */

            $tanggal = $request->tanggal;

            $jumlahHariIni = Pembelian::whereDate(
                'tanggal_pembelian',
                $tanggal
            )->count();

            $noPo = 'PO-' . $tanggal . '-' . str_pad(
                $jumlahHariIni + 1,
                3,
                '0',
                STR_PAD_LEFT
            );


            /*
            |--------------------------------------------------------------------------
            | Nomor faktur
            |--------------------------------------------------------------------------
            */

            $noFaktur = 'INV-' . now()->format('YmdHis');


            /*
            |--------------------------------------------------------------------------
            | Hitung total pembelian
            |--------------------------------------------------------------------------
            */

            $totalBiaya = 0;

            foreach ($request->barang_id as $index => $barangId) {

                $barang = Barang::findOrFail($barangId);

                /*
                |--------------------------------------------------------------------------
                | Pastikan barang memang milik supplier yang dipilih
                |--------------------------------------------------------------------------
                */

                if ((int) $barang->supplier_id !== (int) $request->supplier_id) {

                    abort(
                        422,
                        'Barang ' . $barang->nama_barang .
                        ' tidak terdaftar pada supplier yang dipilih.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Harga beli dari Master Barang
                |--------------------------------------------------------------------------
                */

                $hargaBeli = (float) ($barang->harga_beli ?? 0);

                $qty = (int) $request->qty[$index];

                $subtotal = $hargaBeli * $qty;

                $totalBiaya += $subtotal;
            }


            /*
            |--------------------------------------------------------------------------
            | Simpan Header Pembelian
            |--------------------------------------------------------------------------
            */

            $pembelian = Pembelian::create([
                'no_po' => $noPo,

                'no_faktur' => $noFaktur,

                'supplier_nama' => $supplier->nama_supplier,

                'tanggal_pembelian' => $tanggal,

                'total_biaya' => $totalBiaya,

                'status' => 'Menunggu Barang',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Simpan Banyak Detail Barang
            |--------------------------------------------------------------------------
            */

            foreach ($request->barang_id as $index => $barangId) {

                $barang = Barang::findOrFail($barangId);

                $hargaBeli = (float) ($barang->harga_beli ?? 0);

                $qty = (int) $request->qty[$index];

                $subtotal = $hargaBeli * $qty;


                DetailPembelian::create([
                    'pembelian_id' => $pembelian->id,

                    'barang_id' => $barangId,

                    'satuan' => $request->satuan[$index],

                    'jumlah' => $qty,

                    'harga_satuan' => $hargaBeli,

                    'subtotal' => $subtotal,
                ]);
            }
        });


        return redirect()
            ->route('pembelian.index')
            ->with(
                'success',
                'Purchase Order berhasil dibuat.'
            );
    }


    /**
     * Cetak PO
     */
    public function cetakPO($id)
    {
        $pembelian = Pembelian::findOrFail($id);

        $detail = DetailPembelian::with('barang')
            ->where('pembelian_id', $id)
            ->get();

        return view('pembelian.po', compact(
            'pembelian',
            'detail'
        ));
    }


    /**
     * History pembelian
     */
    public function history(Request $request)
    {
        if (strtolower(Auth::user()->role) !== 'owner') {
            return redirect('/dashboard')
                ->with('error', 'Akses ditolak!');
        }

        $query = Pembelian::with('details.barang');

        if (
            $request->filled('start_date') &&
            $request->filled('end_date')
        ) {

            $query->whereBetween('tanggal_pembelian', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $pembelians = $query
            ->latest()
            ->get();

        return view(
            'pembelian.history',
            compact('pembelians')
        );
    }


    /**
     * Detail pembelian
     */
    public function show($id)
    {
        if (strtolower(Auth::user()->role) !== 'owner') {
            return redirect('/dashboard')
                ->with('error', 'Akses ditolak!');
        }

        $pembelian = Pembelian::with('details.barang')
            ->findOrFail($id);

        return view(
            'pembelian.show',
            compact('pembelian')
        );
    }


    /**
     * Reset semua pembelian
     */
    public function resetAll()
    {
        if (strtolower(Auth::user()->role) !== 'owner') {
            return redirect('/dashboard')
                ->with('error', 'Akses ditolak!');
        }

        DB::table('detail_pembelians')->delete();

        DB::table('pembelians')->delete();

        return redirect()
            ->back()
            ->with(
                'success',
                'Semua riwayat pembelian berhasil dibersihkan!'
            );
    }
}