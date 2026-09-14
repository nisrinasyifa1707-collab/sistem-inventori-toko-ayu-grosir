<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\DetailPembelian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class OwnerController extends Controller
{
    /**
     * =========================================================
     * LAPORAN OWNER
     * =========================================================
     *
     * Laporan terdiri dari:
     * 1. Penjualan
     * 2. Pembelian / Purchase Order
     * 3. Barang Masuk
     *
     * Filter:
     * start_date
     * end_date
     */
  public function laporan(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL
    |--------------------------------------------------------------------------
    */

    $startDate = $request->input('start_date');
    $endDate   = $request->input('end_date');


    /*
    |--------------------------------------------------------------------------
    | PENJUALAN
    |--------------------------------------------------------------------------
    */

    $penjualanQuery = Penjualan::with([
        'detailPenjualans.barang'
    ]);

    /*
    | Jika tanggal dipilih, filter berdasarkan created_at
    */
    if ($startDate && $endDate) {

        $penjualanQuery->whereBetween('created_at', [
            $startDate . ' 00:00:00',
            $endDate . ' 23:59:59'
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DATA PENJUALAN UNTUK TABEL
    |--------------------------------------------------------------------------
    */

    $penjualans = (clone $penjualanQuery)
        ->latest('created_at')
        ->take(10)
        ->get();


    /*
    |--------------------------------------------------------------------------
    | SEMUA PENJUALAN DALAM PERIODE
    |--------------------------------------------------------------------------
    */

    $semuaPenjualan = (clone $penjualanQuery)
        ->get();


    /*
    |--------------------------------------------------------------------------
    | TOTAL PENJUALAN
    |--------------------------------------------------------------------------
    */

    $totalPenjualan = $semuaPenjualan->sum('total_harga');


    /*
    |--------------------------------------------------------------------------
    | TOTAL MODAL
    |--------------------------------------------------------------------------
    */

    $totalModal = 0;

    foreach ($semuaPenjualan as $penjualan) {

        foreach ($penjualan->detailPenjualans as $detail) {

            $hargaBeli = (float) ($detail->harga_beli ?? 0);

            $jumlah = (int) ($detail->jumlah ?? 0);

            $totalModal += $hargaBeli * $jumlah;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | PROFIT
    |--------------------------------------------------------------------------
    */

    $profit = $totalPenjualan - $totalModal;


    /*
    |--------------------------------------------------------------------------
    | PEMBELIAN
    |--------------------------------------------------------------------------
    */

    $pembelianQuery = Pembelian::query();

    /*
    | Filter tanggal pembelian
    */
    if ($startDate && $endDate) {

        $pembelianQuery
            ->whereDate('tanggal_pembelian', '>=', $startDate)
            ->whereDate('tanggal_pembelian', '<=', $endDate);
    }


    /*
    |--------------------------------------------------------------------------
    | SEMUA PEMBELIAN DALAM PERIODE
    |--------------------------------------------------------------------------
    */

    $semuaPembelian = (clone $pembelianQuery)
        ->latest('tanggal_pembelian')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | TOTAL PEMBELIAN
    |--------------------------------------------------------------------------
    */

    $totalPembelian = $semuaPembelian->sum('total_biaya');


    /*
    |--------------------------------------------------------------------------
    | PURCHASE ORDER
    |--------------------------------------------------------------------------
    |
    | Jika satu nomor PO memiliki lebih dari satu record pembelian,
    | tampilkan satu kali saja pada laporan.
    |
    */

    $purchaseOrders = $semuaPembelian
        ->groupBy('no_faktur')
        ->map(function ($items) {

            $po = $items->first();

            /*
            | Jumlahkan nilai pembelian jika satu PO
            | terdiri dari beberapa record.
            */
            $po->total_biaya = $items->sum(function ($item) {
                return (float) ($item->total_biaya ?? 0);
            });

            return $po;
        })
        ->values()
        ->take(10);


    /*
    |--------------------------------------------------------------------------
    | BARANG MASUK
    |--------------------------------------------------------------------------
    */

    $barangMasukQuery = DetailPembelian::with([
        'barang',
        'pembelian'
    ]);


    /*
    | Filter barang masuk mengikuti tanggal pembelian
    */
    if ($startDate && $endDate) {

        $barangMasukQuery->whereHas(
            'pembelian',
            function ($query) use ($startDate, $endDate) {

                $query
                    ->whereDate(
                        'tanggal_pembelian',
                        '>=',
                        $startDate
                    )
                    ->whereDate(
                        'tanggal_pembelian',
                        '<=',
                        $endDate
                    );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DATA BARANG MASUK
    |--------------------------------------------------------------------------
    */

    $barangMasuk = $barangMasukQuery
        ->latest()
        ->take(10)
        ->get();


    /*
    |--------------------------------------------------------------------------
    | DATA BARANG
    |--------------------------------------------------------------------------
    */

    $barangs = Barang::orderBy('nama_barang')
        ->get();

    $totalBarang = Barang::count();


    /*
    |--------------------------------------------------------------------------
    | TANGGAL CETAK
    |--------------------------------------------------------------------------
    */

    Carbon::setLocale('id');

    $tanggalCetak = Carbon::now()
        ->translatedFormat('d F Y');


    /*
    |--------------------------------------------------------------------------
    | RETURN VIEW
    |--------------------------------------------------------------------------
    */

    return view(
        'owner.laporan',
        compact(
            'penjualans',
            'purchaseOrders',
            'barangMasuk',
            'barangs',
            'totalPenjualan',
            'totalPembelian',
            'totalBarang',
            'totalModal',
            'profit',
            'tanggalCetak',
            'startDate',
            'endDate'
        )
    );
}
/**
 * =========================================================
 * EXPORT PDF LAPORAN OWNER
 * =========================================================
 */
public function exportPdf(Request $request)
{
    // =====================================================
    // FILTER TANGGAL
    // =====================================================

    $startDate = $request->input('start_date');
    $endDate   = $request->input('end_date');

    // =====================================================
    // TANGGAL CETAK
    // =====================================================

    Carbon::setLocale('id');

    $tanggalCetak = Carbon::now()
        ->translatedFormat('d F Y');

    $penanggungJawab = $request->input(
        'penanggung_jawab',
        '________________________'
    );

    // =====================================================
    // 1. PENJUALAN
    // =====================================================

    $penjualanQuery = Penjualan::with([
        'detailPenjualans.barang'
    ]);

    if ($startDate && $endDate) {

        $penjualanQuery->whereBetween('created_at', [
            $startDate . ' 00:00:00',
            $endDate . ' 23:59:59'
        ]);
    }

    // SEMUA TRANSAKSI PENJUALAN
    $penjualans = $penjualanQuery
        ->latest('created_at')
        ->get();

    // TOTAL PENJUALAN
    $totalPenjualan = $penjualans->sum('total_harga');

    // =====================================================
    // TOTAL MODAL
    // =====================================================

    $totalModal = 0;

    foreach ($penjualans as $penjualan) {

        foreach ($penjualan->detailPenjualans as $detail) {

            $hargaBeli = (float) ($detail->harga_beli ?? 0);

            $jumlah = (int) ($detail->jumlah ?? 0);

            $totalModal += $hargaBeli * $jumlah;
        }
    }

    // =====================================================
    // PROFIT
    // =====================================================

    $profit = $totalPenjualan - $totalModal;


    // =====================================================
    // 2. PEMBELIAN / PURCHASE ORDER
    // =====================================================

    $pembelianQuery = Pembelian::query();

    if ($startDate && $endDate) {

        $pembelianQuery
            ->whereDate(
                'tanggal_pembelian',
                '>=',
                $startDate
            )
            ->whereDate(
                'tanggal_pembelian',
                '<=',
                $endDate
            );
    }

    // SEMUA PEMBELIAN SESUAI PERIODE
    $semuaPembelian = $pembelianQuery
        ->latest('tanggal_pembelian')
        ->get();

    // =====================================================
    // TOTAL PEMBELIAN
    // =====================================================

    $totalPembelian = $semuaPembelian->sum('total_biaya');

    // =====================================================
    // PURCHASE ORDER
    //
    // SATU NO PO = SATU BARIS
    // =====================================================

    $purchaseOrders = $semuaPembelian
        ->groupBy('no_faktur')
        ->map(function ($items) {

            $po = $items->first();

            // Kalau satu PO punya beberapa transaksi,
            // totalnya dijumlahkan
            $po->total_biaya = $items->sum(function ($item) {
                return (float) ($item->total_biaya ?? 0);
            });

            return $po;
        })
        ->values();


    // =====================================================
    // 3. BARANG MASUK
    // =====================================================

    $barangMasukQuery = DetailPembelian::with([
        'barang',
        'pembelian'
    ]);

    if ($startDate && $endDate) {

        $barangMasukQuery->whereHas(
            'pembelian',
            function ($query) use ($startDate, $endDate) {

                $query
                    ->whereDate(
                        'tanggal_pembelian',
                        '>=',
                        $startDate
                    )
                    ->whereDate(
                        'tanggal_pembelian',
                        '<=',
                        $endDate
                    );
            }
        );
    }

    // SEMUA BARANG MASUK SESUAI PERIODE
    $barangMasuk = $barangMasukQuery
        ->latest()
        ->get();


    // =====================================================
    // 4. DATA BARANG
    // =====================================================

    $barangs = Barang::orderBy('nama_barang')
        ->get();

    $totalBarang = Barang::count();


    // =====================================================
    // 5. LOAD PDF
    // =====================================================

    $pdf = Pdf::loadView(
        'owner.pdf',
        compact(
            'penjualans',
            'purchaseOrders',
            'barangMasuk',
            'barangs',
            'totalPenjualan',
            'totalPembelian',
            'totalBarang',
            'totalModal',
            'profit',
            'tanggalCetak',
            'penanggungJawab',
            'startDate',
            'endDate'
        )
    );

    // =====================================================
    // 6. FORMAT PDF
    // =====================================================

    $pdf->setPaper('A4', 'landscape');

    // =====================================================
    // 7. DOWNLOAD
    // =====================================================

    return $pdf->download(
        'Laporan-Operasional-Toko-Ayu-' .
        Carbon::now()->format('Y-m-d') .
        '.pdf'
    );
}
}