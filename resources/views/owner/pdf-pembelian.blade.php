<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Pembelian
    </title>

    <style>

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
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
            border: none;
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
            padding: 5px;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
        }

        .signature {
            margin-top: 60px;
        }

    </style>

</head>

<body>

    {{-- HEADER --}}

    <div class="header">

        <h1>TOKO AYU GROSIR</h1>

        <h2>LAPORAN PEMBELIAN</h2>

        <p>
            Laporan transaksi pembelian berdasarkan Purchase Order
        </p>

    </div>


    {{-- INFORMASI PERIODE --}}

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


    {{-- TABEL PEMBELIAN --}}

    <table class="laporan">

        <thead>

            <tr>

                <th width="5%">
                    No
                </th>

                <th width="18%">
                    No PO
                </th>

                <th width="22%">
                    Supplier
                </th>

                <th width="15%">
                    Tanggal PO
                </th>

                <th width="20%">
                    Total Pembelian
                </th>

                <th width="20%">
                    Status
                </th>

            </tr>

        </thead>


        <tbody>

        @forelse($pembelians as $index => $item)

            <tr>

                <td class="center">
                    {{ $index + 1 }}
                </td>


                <td>
                    {{ $item->no_po ?? '-' }}
                </td>


                <td>
                    {{ $item->supplier_nama ?? '-' }}
                </td>


                <td class="center">

                    @if($item->tanggal_pembelian)

                        {{ \Carbon\Carbon::parse(
                            $item->tanggal_pembelian
                        )->format('d-m-Y') }}

                    @else

                        -

                    @endif

                </td>


                <td class="right">

                    Rp
                    {{ number_format(
                        $item->total_biaya ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}

                </td>


                <td class="center">

                    {{ $item->status ?? 'Menunggu Barang' }}

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="6"
                    class="center">

                    Belum ada transaksi pembelian.

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
                    Total Pembelian
                </strong>
            </td>

            <td width="20%" class="right">

                <strong>

                    Rp
                    {{ number_format(
                        $totalPembelian ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}

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