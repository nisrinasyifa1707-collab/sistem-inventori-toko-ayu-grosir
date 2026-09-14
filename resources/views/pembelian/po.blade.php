<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Purchase Order - {{ $pembelian->no_po }}</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 30px;
            color: #111827;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .btn {
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-print {
            background: #16a34a;
            color: white;
        }

        .btn-back {
            background: #6b7280;
            color: white;
        }

        .paper {
            background: white;
            padding: 45px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 3px solid #111827;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .company h1 {
            margin: 0 0 6px;
            font-size: 26px;
        }

        .company p {
            margin: 3px 0;
            color: #4b5563;
            font-size: 13px;
        }

        .po-title {
            text-align: right;
        }

        .po-title h2 {
            margin: 0 0 8px;
            font-size: 24px;
        }

        .po-title p {
            margin: 3px 0;
            font-size: 13px;
        }

        .info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .info-box {
            border: 1px solid #d1d5db;
            padding: 15px;
            border-radius: 6px;
        }

        .info-box h3 {
            margin: 0 0 10px;
            font-size: 14px;
            text-transform: uppercase;
        }

        .info-box p {
            margin: 5px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background: #f3f4f6;
            font-weight: bold;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 10px;
            font-size: 13px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .catatan {
            margin-top: 25px;
            border: 1px solid #d1d5db;
            padding: 15px;
            min-height: 80px;
        }

        .catatan h3 {
            margin-top: 0;
            font-size: 14px;
        }

        .signature {
            margin-top: 60px;
            display: flex;
            justify-content: flex-end;
        }

        .signature-box {
            width: 200px;
            text-align: center;
        }

        .signature-space {
            height: 80px;
        }

        .footer {
            margin-top: 35px;
            padding-top: 15px;
            border-top: 1px solid #d1d5db;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
        }

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .toolbar {
                display: none;
            }

            .paper {
                box-shadow: none;
                padding: 20px;
            }

            @page {
                size: A4;
                margin: 15mm;
            }

        }

    </style>
</head>

<body>

<div class="container">

    {{-- TOOLBAR --}}
    <div class="toolbar">

        <a href="{{ route('pembelian.index') }}"
           class="btn btn-back">
            ← Kembali
        </a>

        <button
            onclick="window.print()"
            class="btn btn-print">
            🖨 Cetak Purchase Order
        </button>

    </div>


    {{-- KERTAS PO --}}
    <div class="paper">

        {{-- HEADER --}}
        <div class="header">

            <div class="company">

                <h1>TOKO AYU GROSIR</h1>

                <p>Purchase Order Barang</p>

                <p>Dokumen Pemesanan Barang kepada Supplier</p>

            </div>

            <div class="po-title">

                <h2>PURCHASE ORDER</h2>

                <p>
                    <strong>No. PO:</strong>
                    {{ $pembelian->no_po }}
                </p>

                <p>
                    <strong>Tanggal:</strong>
                    {{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('d/m/Y') }}
                </p>

            </div>

        </div>


        {{-- INFORMASI --}}
        <div class="info">

            <div class="info-box">

                <h3>Supplier</h3>

                <p>
                    <strong>
                        {{ $pembelian->supplier_nama }}
                    </strong>
                </p>

                @php
                    $supplier = \App\Models\Supplier::where(
                        'nama_supplier',
                        $pembelian->supplier_nama
                    )->first();
                @endphp

                @if($supplier)

                    <p>
                        Alamat:
                        {{ $supplier->alamat ?? '-' }}
                    </p>

                    <p>
                        Telepon:
                        {{ $supplier->telepon ?? '-' }}
                    </p>

                @endif

            </div>


            <div class="info-box">

                <h3>Informasi Pesanan</h3>

                <p>
                    <strong>No. PO:</strong>
                    {{ $pembelian->no_po }}
                </p>

                <p>
                    <strong>Status:</strong>
                    {{ $pembelian->status }}
                </p>

            </div>

        </div>


        {{-- DETAIL BARANG --}}
        <h3>Daftar Barang yang Dipesan</h3>

        <table>

            <thead>

                <tr>

                    <th width="5%">
                        No
                    </th>

                    <th width="18%">
                        Kode Barang
                    </th>

                    <th>
                        Nama Barang
                    </th>

                    <th width="12%">
                        Satuan
                    </th>

                    <th width="10%">
                        Qty
                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($detail as $item)

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->barang->kode_barang ?? '-' }}
                    </td>

                    <td>
                        {{ $item->barang->nama_barang ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $item->satuan }}
                    </td>

                    <td class="text-center">
                        {{ $item->jumlah }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="5"
                        class="text-center">

                        Tidak ada detail barang.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>


        {{-- CATATAN --}}
        <div class="catatan">

            <h3>Catatan</h3>

            @if(!empty($pembelian->catatan))

                <p>
                    {{ $pembelian->catatan }}
                </p>

            @else

                <p>
                    Mohon barang dikirim sesuai dengan jumlah dan spesifikasi
                    yang tercantum pada Purchase Order ini.
                </p>

            @endif

        </div>


        {{-- TANDA TANGAN --}}
        <div class="signature">

            <div class="signature-box">

                <p>
                    Hormat kami,
                </p>

                <div class="signature-space"></div>

                <strong>
                    Owner
                </strong>

                <p>
                    Toko Ayu Grosir
                </p>

            </div>

        </div>


        <div class="footer">

            Dokumen ini merupakan Purchase Order resmi
            dari Toko Ayu Grosir kepada supplier.

        </div>

    </div>

</div>

</body>

</html>