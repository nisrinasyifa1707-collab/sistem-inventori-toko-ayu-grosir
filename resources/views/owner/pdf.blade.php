<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>Laporan Operasional Toko Ayu Grosir</title>

    <style>
        @page {
            margin: 30px 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin: 0;
        }

        h2 {
            font-size: 14px;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }

        h3 {
            font-size: 12px;
            margin-bottom: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header p {
            margin: 4px 0;
        }

        .info {
            margin-bottom: 15px;
        }

        .info table {
            width: 100%;
            border: none;
            margin: 0;
        }

        .info td {
            border: none;
            padding: 3px;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .summary td {
            border: 1px solid #000;
            padding: 7px;
        }

        .summary .label {
            font-weight: bold;
            width: 70%;
        }

        .summary .value {
            text-align: right;
            font-weight: bold;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 20px;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 5px;
        }

        table.data th {
            background-color: #eeeeee;
            text-align: center;
            font-weight: bold;
        }

        table.data td {
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .page-break {
            page-break-before: always;
        }

        .signature {
            width: 100%;
            margin-top: 50px;
        }

        .signature td {
            width: 50%;
            text-align: center;
            border: none;
        }

        .signature-space {
            height: 70px;
        }

        .small {
            font-size: 9px;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="header">

        <h1>LAPORAN OPERASIONAL TOKO AYU GROSIR</h1>

        <p>
            <strong>LAPORAN SEMUA OPERASIONAL</strong>
        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- INFORMASI LAPORAN --}}
    {{-- ========================================================= --}}

    <div class="info">

        <table>

            <tr>
                <td width="20%">
                    <strong>Tanggal Cetak</strong>
                </td>

                <td>
                    : {{ $tanggalCetak }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Periode</strong>
                </td>

                <td>
                    :
                    @if(request('start_date') && request('end_date'))
                        {{ request('start_date') }}
                        s/d
                        {{ request('end_date') }}
                    @else
                        Semua Transaksi
                    @endif
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Penanggung Jawab Lapangan</strong>
                </td>

                <td>
                    : {{ $penanggungJawab }}
                </td>
            </tr>

        </table>

    </div>


    {{-- ========================================================= --}}
    {{-- RINGKASAN --}}
    {{-- ========================================================= --}}

    <h2>RINGKASAN OPERASIONAL</h2>

    <table class="summary">

        <tr>
            <td class="label">
                Total Data Barang
            </td>

            <td class="value">
                {{ $totalBarang }}
            </td>
        </tr>

        <tr>
            <td class="label">
                Total Pembelian
            </td>

            <td class="value">
                Rp {{ number_format($totalPembelian, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td class="label">
                Total Penjualan
            </td>

            <td class="value">
                Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td class="label">
                Total Modal
            </td>

            <td class="value">
                Rp {{ number_format($totalModal, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td class="label">
                Profit
            </td>

            <td class="value">
                Rp {{ number_format($profit, 0, ',', '.') }}
            </td>
        </tr>

    </table>


    {{-- ========================================================= --}}
    {{-- 1. LAPORAN DATA BARANG --}}
    {{-- ========================================================= --}}

    <h2>1. LAPORAN DATA BARANG</h2>

    <table class="data">

        <thead>

            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Barang</th>
                <th>Nama Barang</th>
                <th width="15%">Harga Satuan</th>
                <th width="10%">QTY Gudang</th>
                <th width="12%">Status</th>
            </tr>

        </thead>

        <tbody>

            @forelse($barangs as $i => $barang)

                <tr>

                    <td class="text-center">
                        {{ $i + 1 }}
                    </td>

                    <td>
                        {{ $barang->kode_barang }}
                    </td>

                    <td>
                        {{ $barang->nama_barang }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($barang->harga ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-center">
                        {{ $barang->qty_gudang ?? 0 }}
                    </td>

                    <td class="text-center">

                        @if(($barang->qty_gudang ?? 0) <= ($barang->min_stok ?? 5))
                            Tidak Aman
                        @else
                            Aman
                        @endif

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="text-center">
                        Tidak ada data barang.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ========================================================= --}}
    {{-- 2. LAPORAN PEMBELIAN / PURCHASE ORDER --}}
    {{-- ========================================================= --}}

    <div class="page-break"></div>

    <h2>2. LAPORAN PEMBELIAN / PURCHASE ORDER</h2>

    <table class="data">

        <thead>

            <tr>
                <th width="5%">No</th>
                <th>No PO / Faktur</th>
                <th>Supplier</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Total Pembelian</th>
            </tr>

        </thead>

        <tbody>

            @forelse($purchaseOrders as $i => $po)

                <tr>

                    <td class="text-center">
                        {{ $i + 1 }}
                    </td>

                    <td>
                        {{ $po->no_faktur ?? '-' }}
                    </td>

                    <td>
                        {{ $po->supplier_nama ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $po->tanggal_pembelian ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $po->status ?? '-' }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($po->total_biaya ?? 0, 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="text-center">
                        Tidak ada data pembelian.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ========================================================= --}}
    {{-- 3. LAPORAN BARANG MASUK --}}
    {{-- ========================================================= --}}

    <div class="page-break"></div>

    <h2>3. LAPORAN BARANG MASUK</h2>

    <table class="data">

        <thead>

            <tr>
                <th width="5%">No</th>
                <th>No PO / Faktur</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>QTY Masuk</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>

        </thead>

        <tbody>

            @forelse($barangMasuk as $i => $detail)

                <tr>

                    <td class="text-center">
                        {{ $i + 1 }}
                    </td>

                    <td>
                        {{ $detail->pembelian->no_faktur ?? '-' }}
                    </td>

                    <td>
                        {{ $detail->barang->kode_barang ?? '-' }}
                    </td>

                    <td>
                        {{ $detail->barang->nama_barang ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $detail->qty_masuk ?? 0 }}
                    </td>

                    <td class="text-center">
                        {{ $detail->pembelian->tanggal_pembelian ?? '-' }}
                    </td>

                    <td>
                        {{ $detail->keterangan ?? '-' }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center">
                        Tidak ada data barang masuk.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ========================================================= --}}
    {{-- 4. LAPORAN PENJUALAN --}}
    {{-- ========================================================= --}}

    <div class="page-break"></div>

    <h2>4. LAPORAN PENJUALAN</h2>

    <table class="data">

        <thead>

            <tr>
                <th width="5%">No</th>
                <th>No Faktur</th>
                <th>Metode Pembayaran</th>
                <th>Status Pembayaran</th>
                <th>Total</th>
            </tr>

        </thead>

        <tbody>

            @forelse($penjualans as $i => $item)

                <tr>

                    <td class="text-center">
                        {{ $i + 1 }}
                    </td>

                    <td>
                        {{ $item->no_faktur ?? '-' }}
                    </td>

                    <td>
                        {{ $item->metode_pembayaran ?? '-' }}
                    </td>

                    <td>
                        {{ $item->status_pembayaran ?? '-' }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center">
                        Tidak ada transaksi penjualan.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ========================================================= --}}
    {{-- REKAP PENJUALAN --}}
    {{-- ========================================================= --}}

    <table class="summary">

        <tr>

            <td class="label">
                Total Penjualan
            </td>

            <td class="value">
                Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
            </td>

        </tr>

        <tr>

            <td class="label">
                Total Modal
            </td>

            <td class="value">
                Rp {{ number_format($totalModal, 0, ',', '.') }}
            </td>

        </tr>

        <tr>

            <td class="label">
                Profit
            </td>

            <td class="value">
                Rp {{ number_format($profit, 0, ',', '.') }}
            </td>

        </tr>

    </table>


    {{-- ========================================================= --}}
    {{-- 5. LAPORAN STOK GUDANG --}}
    {{-- ========================================================= --}}

    <div class="page-break"></div>

    <h2>5. LAPORAN STOK GUDANG</h2>

    <table class="data">

        <thead>

            <tr>
                <th width="5%">No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga Satuan</th>
                <th>QTY Awal</th>
                <th>QTY Masuk</th>
                <th>QTY Stok</th>
                <th>Status</th>
            </tr>

        </thead>

        <tbody>

            @forelse($barangs as $i => $barang)

                <tr>

                    <td class="text-center">
                        {{ $i + 1 }}
                    </td>

                    <td>
                        {{ $barang->kode_barang }}
                    </td>

                    <td>
                        {{ $barang->nama_barang }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($barang->harga ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-center">
                        {{ $barang->qty_awal ?? 0 }}
                    </td>

                    <td class="text-center">
                        {{ $barang->qty_masuk ?? 0 }}
                    </td>

                    <td class="text-center total">
                        {{ $barang->qty_gudang ?? 0 }}
                    </td>

                    <td class="text-center">

                        @if(($barang->qty_gudang ?? 0) <= ($barang->min_stok ?? 5))
                            Tidak Aman
                        @else
                            Aman
                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="text-center">
                        Tidak ada data stok gudang.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ========================================================= --}}
    {{-- TANDA TANGAN --}}
    {{-- ========================================================= --}}

    <div class="page-break"></div>

    <div class="header">

        <h1>LAPORAN OPERASIONAL TOKO AYU GROSIR</h1>

        <p>
            <strong>LEMBAR PENGESAHAN LAPORAN</strong>
        </p>

    </div>

    <table class="info">

        <tr>
            <td>
                Tanggal Cetak
            </td>

            <td>
                : {{ $tanggalCetak }}
            </td>
        </tr>

        <tr>
            <td>
                Penanggung Jawab Lapangan
            </td>

            <td>
                : {{ $penanggungJawab }}
            </td>
        </tr>

    </table>


    <table class="signature">

        <tr>

            <td>
                Mengetahui,<br>
                Owner
            </td>

            <td>
                Penanggung Jawab Lapangan
            </td>

        </tr>

        <tr>

            <td class="signature-space">
            </td>

            <td class="signature-space">
            </td>

        </tr>

        <tr>

            <td>
                (________________________)
            </td>

            <td>
                ({{ $penanggungJawab }})
            </td>

        </tr>

    </table>


    <p class="small" style="margin-top: 30px; text-align: center;">
        Dokumen ini merupakan laporan operasional Toko Ayu Grosir.
    </p>

</body>
</html>