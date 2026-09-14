@extends('layouts.app')

@section('content')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Laporan Pembelian
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Laporan transaksi pembelian berdasarkan Purchase Order.
                </p>
            </div>

            <a
                href="{{ route('owner.laporan') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                ← Kembali

            </a>

        </div>


        {{-- FILTER --}}
        <div class="bg-white rounded-xl shadow p-5 mb-6">

            <form method="GET">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Dari Tanggal
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            value="{{ request('start_date') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2">

                    </div>


                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Sampai Tanggal
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            value="{{ request('end_date') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2">

                    </div>


                    <div class="flex gap-2">

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                            Filter

                        </button>

                        <a
                            href="{{ route('owner.laporan.pembelian') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>


        {{-- RINGKASAN --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

            <div class="bg-white rounded-xl shadow p-5">

                <p class="text-gray-500">
                    Total Pembelian
                </p>

                <h2 class="text-2xl font-bold text-red-600 mt-1">

                    Rp {{ number_format(
                        $totalPembelian ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}

                </h2>

            </div>


            <div class="bg-white rounded-xl shadow p-5">

                <p class="text-gray-500">
                    Jumlah Purchase Order
                </p>

                <h2 class="text-2xl font-bold text-blue-600 mt-1">

                    {{ $pembelians->count() }}

                </h2>

            </div>

        </div>


        {{-- TABEL --}}
        <div class="bg-white rounded-xl shadow p-6">

            <div class="flex justify-between items-center mb-5">

                <div>

                    <h2 class="text-xl font-bold text-gray-800">
                        Data Pembelian
                    </h2>

                    <p class="text-sm text-gray-500">
                        Daftar Purchase Order yang dibuat kepada supplier.
                    </p>

                </div>


                <a
                    href="{{ route('owner.pdf.pembelian', request()->query()) }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">

                    Export PDF

                </a>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full border border-gray-200">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="border px-4 py-3 text-center">
                                No
                            </th>

                            <th class="border px-4 py-3">
                                No PO
                            </th>

                            <th class="border px-4 py-3">
                                Supplier
                            </th>

                            <th class="border px-4 py-3">
                                Tanggal PO
                            </th>

                            <th class="border px-4 py-3 text-right">
                                Total Pembelian
                            </th>

                            <th class="border px-4 py-3 text-center">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($pembelians as $index => $item)

                        <tr class="border-b hover:bg-gray-50">

                            <td class="border px-4 py-3 text-center">
                                {{ $index + 1 }}
                            </td>


                            <td class="border px-4 py-3 font-medium">

                                {{ $item->no_po ?? '-' }}

                            </td>


                            <td class="border px-4 py-3">

                                {{ $item->supplier_nama ?? '-' }}

                            </td>


                            <td class="border px-4 py-3">

                                {{ $item->tanggal_pembelian
                                    ? \Carbon\Carbon::parse(
                                        $item->tanggal_pembelian
                                    )->format('d-m-Y')
                                    : '-'
                                }}

                            </td>


                            <td class="border px-4 py-3 text-right font-semibold">

                                Rp {{ number_format(
                                    $item->total_biaya ?? 0,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            <td class="border px-4 py-3 text-center">

                                @if($item->status == 'Selesai')

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">

                                        Selesai

                                    </span>

                                @else

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">

                                        {{ $item->status ?? 'Menunggu Barang' }}

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-8 text-gray-500">

                                Belum ada transaksi pembelian.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>


                    @if($pembelians->count())

                    <tfoot>

                        <tr class="bg-gray-50">

                            <td
                                colspan="4"
                                class="border px-4 py-3 text-right font-bold">

                                Total Pembelian

                            </td>

                            <td
                                class="border px-4 py-3 text-right font-bold text-red-600">

                                Rp {{ number_format(
                                    $totalPembelian ?? 0,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>

                            <td class="border"></td>

                        </tr>

                    </tfoot>

                    @endif

                </table>

            </div>

        </div>

    </div>
</div>

@endsection