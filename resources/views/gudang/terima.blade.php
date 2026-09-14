@extends('layouts.app')

@section('content')

<h2 class="text-3xl font-bold mb-6">
    Terima Barang
</h2>

<div class="bg-white rounded-xl shadow p-6">

    <div class="grid grid-cols-2 gap-4 mb-6">

        <div>
            <b>No PO</b><br>
            {{ $pembelian->no_faktur }}
        </div>

        <div>
            <b>Supplier</b><br>
            {{ $pembelian->supplier_nama }}
        </div>

        <div>
            <b>Tanggal</b><br>
            {{ $pembelian->tanggal_pembelian }}
        </div>

        <div>
            <b>Status</b><br>

            <span class="bg-yellow-100 px-3 py-1 rounded">
                {{ $pembelian->status }}
            </span>

        </div>

    </div>

    <form action="{{ route('gudang.simpan', $pembelian->id) }}" method="POST">

        @csrf

        <table class="w-full border">

            <thead class="bg-gray-100">

                <tr>

                     <th class="border p-3">Kode Barang</th>
                     <th class="border p-3">Nama Barang</th>
                     <th class="border p-3 text-center">Qty Pesan</th>
                     <th class="border p-3 text-center">Qty Masuk</th>
                     <th class="border p-3 text-center">Keterangan</th>
                </tr>

            </thead>

           <tbody>

@foreach($pembelian->detailPembelians as $detail)

<tr>

    <td class="border p-3">
        {{ $detail->barang->kode_barang }}
    </td>

    <td class="border p-3">
        {{ $detail->barang->nama_barang }}
    </td>

    <td class="border p-3 text-center">
        {{ $detail->jumlah }}
    </td>

    <td class="border p-3">
      <input
    type="number"
    name="qty_masuk[{{ $detail->id }}]"
    value="{{ $detail->qty_masuk ?? $detail->jumlah }}"
    min="0"
    max="{{ $detail->jumlah }}"
    class="w-24 border rounded px-2 py-1 text-center">

    <td class="border p-3">
        <select
            name="keterangan[{{ $detail->id }}]"
            class="border rounded px-2 py-1">

            <option value="Sesuai">Sesuai</option>
            <option value="Kurang">Kurang</option>
            <option value="Lebih">Lebih</option>
            <option value="Rusak">Rusak</option>

        </select>
    </td>

</tr>

@endforeach

</tbody>
        </table>

        <button
            class="mt-6 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

            Terima Barang

        </button>

    </form>

</div>

@endsection