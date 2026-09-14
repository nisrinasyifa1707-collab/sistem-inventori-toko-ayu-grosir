@extends('layouts.app')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h2 class="text-2xl font-bold">
                Invoice Pembelian
            </h2>

            <p class="text-gray-500">
                Purchase Order yang sudah diterima gudang.
            </p>

        </div>

    </div>

    <table class="w-full border">

        <thead class="bg-gray-100">

            <tr>

                <th class="border p-3">No PO</th>
                <th class="border p-3">Supplier</th>
                <th class="border p-3">Tanggal</th>
                <th class="border p-3">Status Invoice</th>
                <th class="border p-3">Aksi</th>

            </tr>

        </thead>

        <tbody>

        @forelse($invoices as $item)

        <tr>

            <td class="border p-3">
                {{ $item->no_po  }}
            </td>

            <td class="border p-3">
                {{ $item->supplier_nama }}
            </td>

            <td class="border p-3">
                {{ $item->tanggal_pembelian }}
            </td>

            <td class="border p-3">

                @if($item->status_invoice == 'Belum Diisi')

                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                        Belum Diisi

                    </span>

                @else

                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                        Sudah Diisi

                    </span>

                @endif

            </td>

           <td class="border p-3">

    @if($item->status_invoice == 'Belum Diisi')

        <a href="{{ route('invoice.create', $item->id) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

            Isi Invoice

        </a>

    @else

        <a href="{{ route('invoice.show', $item->id) }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">

            Lihat Invoice

        </a>

    @endif

</td>
    </tr>

    @empty

    <tr>
        <td colspan="5" class="text-center py-5">
            Belum ada data.
        </td>
    </tr>

    @endforelse

    </tbody>

</table>

@endsection