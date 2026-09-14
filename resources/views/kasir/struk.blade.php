<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - POS</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 58mm; /* Ukuran standard kertas thermal kasir */
            margin: 0 auto;
            padding: 10px;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .flex { display: flex; justify-content: space-between; }
        hr { border: dashed 1px #000; margin: 8px 0; }
        table { width: 100%; font-size: 12px; border-collapse: collapse; }
        th, td { padding: 4px 0; text-align: left; }
        .btn-action {
            display: block;
            width: 100%;
            padding: 8px;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 8px;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            font-size: 12px;
        }
        .btn-print { background: #2563eb; }
        .btn-back { background: #4b5563; }
        @media print {
            .btn-action { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="text-center">
    <h3 style="margin: 0;">TOKO AYU GROSIR</h3>
    <p style="font-size: 11px; margin: 2px 0;">Jl. Raya Kasir No. 123</p>
    <p style="font-size: 11px; margin: 2px 0;">Telp: 081234567890</p>
</div>

<hr>

<div style="font-size: 11px;">
    <p style="margin: 2px 0;">
        No Transaksi : #{{ $penjualan->id }}
    </p>

    <p style="margin: 2px 0;">
        Tanggal : {{ $penjualan->created_at }}
    </p>

    <p style="margin: 2px 0;">
        Kasir : Administrator
    </p>

    <p style="margin: 2px 0;">
        Metode : {{ $penjualan->metode_pembayaran }}
    </p>
</div>

<hr>

<table>
    @foreach($penjualan->detailPenjualans as $detail)

        <tr>
            <td colspan="2">
                <strong>
                    {{ $detail->barang->nama_barang ?? 'Barang' }}
                </strong>
            </td>
        </tr>

        <tr>
            <td>
                {{ $detail->jumlah }}
                x
                {{ number_format($detail->harga_satuan, 0, ',', '.') }}
            </td>

            <td class="text-right">
                Rp
                {{ number_format(
                    $detail->jumlah * $detail->harga_satuan,
                    0,
                    ',',
                    '.'
                ) }}
            </td>
        </tr>

    @endforeach
</table>

<hr>

<div style="font-size: 12px;">

    <div class="flex">
        <span>Total :</span>

        <strong>
            Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}
        </strong>
    </div>

    <div class="flex">
        <span>Bayar :</span>

        <span>
            Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}
        </span>
    </div>

    <div class="flex">
        <span>Kembalian :</span>

        <span>
            Rp {{ number_format(
                $penjualan->bayar - $penjualan->total_harga,
                0,
                ',',
                '.'
            ) }}
        </span>
    </div>

</div>

<hr>

<div
    class="text-center"
    style="font-size: 11px; margin-top: 10px;"
>
    <p style="margin: 0;">
        Terima Kasih Telah Berbelanja
    </p>

    <p style="margin: 2px 0;">
        Barang yang sudah dibeli tidak dapat ditukar
    </p>
</div>

<!-- Tombol Aksi -->
<button
    onclick="window.print()"
    class="btn-action btn-print"
>
    Cetak Lagi
</button>

<a
    href="{{ url('/kasir') }}"
    class="btn-action btn-back"
>
    Kembali ke Kasir
</a>
</body>
</html>