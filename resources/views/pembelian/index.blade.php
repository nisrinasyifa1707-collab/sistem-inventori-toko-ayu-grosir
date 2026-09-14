@extends('layouts.app')

@section('content')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4">

        <div class="bg-white rounded-xl shadow p-6">

            <div class="flex justify-between items-center mb-6">

                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        Data Pembelian
                    </h2>
                    <p class="text-gray-500 text-sm">
                        Daftar seluruh transaksi pembelian dari supplier.
                    </p>
                </div>

                <a href="{{ route('pembelian.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg">
                    + Tambah Pembelian
                </a>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full border border-gray-200">

                   <thead class="bg-gray-100">

    <tr>

        <th class="border px-4 py-2">No PO</th>
        <th class="border px-4 py-2">Supplier</th>
        <th class="border px-4 py-2">Kode Barang</th>
        <th class="border px-4 py-2">Nama Barang</th>
        <th class="border px-4 py-2 text-center">Qty</th>
        <th class="border px-4 py-2">Tanggal Masuk</th>
        <th class="border px-4 py-2 text-center">Status</th>
        <th class="border px-4 py-2 text-center">Aksi</th>

    </tr>

</thead>

                    <tbody>

@forelse($pembelians as $p)

@php
    $detail = $p->detailPembelians->first();
@endphp

<tr>

    <td class="border px-4 py-2">
        {{ $p->no_po }}
    </td>

    <td class="border px-4 py-2">
        {{ $p->supplier_nama }}
    </td>

    <td class="border px-4 py-2">
        {{ $detail->barang->kode_barang ?? '-' }}
    </td>

    <td class="border px-4 py-2">
        {{ $detail->barang->nama_barang ?? '-' }}
    </td>

    <td class="border px-4 py-2 text-center">
        {{ $detail->jumlah ?? 0 }}
    </td>

    <td class="border px-4 py-2">
        {{ $p->tanggal_pembelian }}
    </td>

    <td class="border px-4 py-2 text-center">

        @if($p->status == 'Menunggu Barang')

            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                Menunggu
            </span>

        @else

            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                Selesai
            </span>

        @endif

    </td>

    <td class="border px-4 py-2 text-center">
<a href="{{ route('pembelian.po',$p->id) }}"
   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded whitespace-nowrap">

    Cetak PO

</a>

    </td>

</tr>

@empty

<tr>

    <td colspan="8" class="text-center py-6 text-gray-500">

        Belum ada data pembelian.

    </td>

</tr>

@endforelse

</tbody>

                </table>

            </div>

        </div>

    </div>
</div>

@endsection