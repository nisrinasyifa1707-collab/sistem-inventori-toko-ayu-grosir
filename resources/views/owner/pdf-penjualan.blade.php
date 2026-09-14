<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Penjualan
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

        <h2>LAPORAN PENJUALAN</h2>

        <p>
            Laporan transaksi penjualan
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


    {{-- TABEL PENJUALAN --}}

    <table class="laporan">

        <thead>

            <tr>

                <th width="5%">
                    No
                </th>

                <th width="15%">
                    No Faktur
                </th>

                <th width="13%">
                    Tanggal
                </th>

                <th width="17%">
                    Metode Pembayaran
                </th>

                <th width="15%">
                    Status Pembayaran
                </th>

                <th width="15%">
                    Status Packing
                </th>

                <th width="20%">
                    Total
                </th>

            </tr>

        </thead>


        <tbody>

        @forelse($penjualans as $index => $item)

            <tr>

                <td class="center">
                    {{ $index + 1 }}
                </td>

                <td>
                    {{ $item->no_faktur ?? '-' }}
                </td>

                <td class="center">

                    {{ optional($item->created_at)->format('d-m-Y') ?? '-' }}

                </td>

                <td>
                    {{ $item->metode_pembayaran ?? '-' }}
                </td>

                <td class="center">
                    {{ $item->status_pembayaran ?? '-' }}
                </td>

                <td class="center">
                    {{ $item->status_packing ?? '-' }}
                </td>

                <td class="right">

                    Rp
                    {{ number_format(
                        $item->total_harga ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="7"
                    class="center">

                    Belum ada transaksi penjualan.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>


    {{-- TOTAL --}}

    <table class="total">

        <tr>

            <td width="80%" class="right">
                <strong>Total Penjualan</strong>
            </td>

            <td width="20%" class="right">

                <strong>

                    Rp
                    {{ number_format(
                        $totalPenjualan ?? 0,
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