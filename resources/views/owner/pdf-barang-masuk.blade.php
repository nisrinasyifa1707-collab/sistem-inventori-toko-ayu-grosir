<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Barang Masuk
    </title>

    <style>

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 16px;
        }

        .header p {
            margin: 3px 0;
            font-size: 10px;
        }

        .info {
            margin-bottom: 15px;
        }

        .info table {
            width: 100%;
        }

        .info td {
            border: none;
            padding: 3px;
        }

        table.laporan {
            width: 100%;
            border-collapse: collapse;
        }

        table.laporan th {
            background: #eeeeee;
            font-weight: bold;
            text-align: center;
        }

        table.laporan th,
        table.laporan td {
            border: 1px solid #999;
            padding: 7px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .total {
            margin-top: 15px;
            width: 100%;
        }

        .total td {
            border: none;
            padding: 5px;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }

        .signature {
            margin-top: 50px;
        }

    </style>

</head>

<body>

    {{-- HEADER --}}

    <div class="header">

        <h1>TOKO AYU GROSIR</h1>

        <h2>LAPORAN BARANG MASUK</h2>

        <p>
            Laporan penerimaan barang dari supplier
        </p>

    </div>


    {{-- INFORMASI --}}

    <div class="info">

        <table>

            <tr>

                <td width="20%">
                    Tanggal Cetak
                </td>

                <td>
                    : {{ $tanggalCetak }}
                </td>

            </tr>

            <tr>

                <td>
                    Periode
                </td>

                <td>

                    :

                    @if(request('start_date') && request('end_date'))

                        {{ request('start_date') }}
                        s/d
                        {{ request('end_date') }}

                    @else

                        Semua Periode

                    @endif

                </td>

            </tr>

        </table>

    </div>


    {{-- TABEL BARANG MASUK --}}

    <table class="laporan">

        <thead>

            <tr>

                <th width="5%">
                    No
                </th>

                <th width="15%">
                    No PO
                </th>

                <th width="18%">
                    Supplier
                </th>

                <th width="20%">
                    Barang
                </th>

                <th width="10%">
                    Qty Pesan
                </th>

                <th width="10%">
                    Qty Masuk
                </th>

                <th width="12%">
                    Status
                </th>

                <th width="15%">
                    Keterangan
                </th>

            </tr>

        </thead>


        <tbody>

        @forelse($barangMasuk as $index => $item)

            <tr>

                <td class="center">
                    {{ $index + 1 }}
                </td>


                <td>
                    {{ $item->pembelian->no_po ?? '-' }}
                </td>


                <td>
                    {{ $item->pembelian->supplier_nama ?? '-' }}
                </td>


                <td>
                    {{ $item->barang->nama_barang ?? '-' }}
                </td>


                <td class="center">
                    {{ $item->jumlah ?? 0 }}
                </td>


                <td class="center">

                    {{ $item->qty_masuk ?? $item->jumlah ?? 0 }}

                </td>


                <td class="center">

                    {{ $item->pembelian->status ?? 'Menunggu Barang' }}

                </td>


                <td>
                    {{ $item->keterangan ?? '-' }}
                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="8"
                    class="center">

                    Belum ada data barang masuk.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>


    {{-- TOTAL --}}

    <table class="total">

        <tr>

            <td width="80%" class="right">

                <strong>
                    Total Barang Masuk
                </strong>

            </td>

            <td width="20%" class="right">

                <strong>

                    {{ $totalBarangMasuk }}

                    Barang

                </strong>

            </td>

        </tr>

    </table>


    {{-- TANDA TANGAN --}}

    <div class="footer">

        <p>
            Bandung, {{ $tanggalCetak }}
        </p>

        <div class="signature">

            <p>
                Mengetahui,
            </p>

            <br>
            <br>
            <br>

            <strong>
                Owner
            </strong>

            <br>

            Toko Ayu Grosir

        </div>

    </div>

</body>

</html>