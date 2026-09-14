@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h2 class="text-3xl font-bold">
        Detail Invoice Pembelian
    </h2>

    <div class="flex gap-3">

        <a href="{{ route('invoice.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg">
            ← Kembali
        </a>

        <a href="{{ route('invoice.pdf', $pembelian->id) }}"
           target="_blank"
           class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">
            🖨 Cetak PDF
        </a>

    </div>

</div>


<div class="bg-white rounded-xl shadow p-6">

    <h2 class="text-3xl font-bold mb-6">
        Detail Invoice Pembelian
    </h2>


    <div class="grid grid-cols-2 gap-6 mb-8">

        <div>
            <p class="text-gray-500">No Invoice</p>

            <h3 class="font-bold">
                {{ $pembelian->no_invoice }}
            </h3>
        </div>


        <div>
            <p class="text-gray-500">Tanggal Invoice</p>

            <h3 class="font-bold">
                {{ $pembelian->tanggal_invoice }}
            </h3>
        </div>


        <div>
            <p class="text-gray-500">No Purchase Order</p>

            <h3 class="font-bold">
                {{ $pembelian->no_faktur }}
            </h3>
        </div>


        <div>
            <p class="text-gray-500">Supplier</p>

            <h3 class="font-bold">
                {{ $pembelian->supplier_nama }}
            </h3>
        </div>

    </div>

</div>


{{-- TABEL DETAIL INVOICE --}}
<table class="w-full border">

    <thead class="bg-gray-100">

        <tr>

            <th class="border p-3">
                Barang
            </th>

            <th class="border p-3 text-center">
                Qty
            </th>

            <th class="border p-3 text-center">
                Qty Masuk
            </th>

            <th class="border p-3 text-right">
                Harga
            </th>

            <th class="border p-3 text-right">
                Subtotal
            </th>

        </tr>

    </thead>


    <tbody>

    @foreach($pembelian->detailPembelians as $detail)

        <tr>

            {{-- BARANG --}}
            <td class="border p-3">
                {{ $detail->barang->nama_barang }}
            </td>


            {{-- QTY PESAN DARI PO --}}
            <td class="border p-3 text-center">
                {{ $detail->jumlah }}
            </td>


            {{-- QTY MASUK DARI GUDANG --}}
            <td class="border p-3 text-center">
                {{ $detail->qty_masuk }}
            </td>


            {{-- HARGA --}}
            <td class="border p-3 text-right">
                Rp {{ number_format($detail->harga_satuan,0,',','.') }}
            </td>


            {{-- SUBTOTAL --}}
            <td class="border p-3 text-right">
                Rp {{ number_format($detail->subtotal,0,',','.') }}
            </td>

        </tr>

    @endforeach

    </tbody>

</table>


{{-- TOTAL --}}
<div class="text-right mt-8">

    <h2 class="text-2xl font-bold">

        Total :
        Rp {{ number_format($pembelian->total_biaya,0,',','.') }}

    </h2>

</div>

@endsection
