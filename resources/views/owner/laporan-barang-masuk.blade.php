@extends('layouts.app')

@section('content')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Laporan Barang Masuk
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Laporan penerimaan barang dari supplier.
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
                            href="{{ route('owner.laporan.barang.masuk') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>


        {{-- RINGKASAN --}}
        <div class="bg-white rounded-xl shadow p-5 mb-6">

            <p class="text-gray-500">
                Total Barang Masuk
            </p>

            <h2 class="text-2xl font-bold text-green-600 mt-1">
                {{ $totalBarangMasuk }}
            </h2>

        </div>


        {{-- TABEL --}}
        <div class="bg-white rounded-xl shadow p-6">

            <div class="flex justify-between items-center mb-5">

                <div>

                    <h2 class="text-xl font-bold text-gray-800">
                        Data Barang Masuk
                    </h2>

                    <p class="text-sm text-gray-500">
                        Daftar barang yang diterima dari supplier.
                    </p>

                </div>


                <a
                    href="{{ route('owner.pdf.barang.masuk', request()->query()) }}"
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
                                Barang
                            </th>

                            <th class="border px-4 py-3 text-center">
                                Qty Pesan
                            </th>

                            <th class="border px-4 py-3 text-center">
                                Qty Masuk
                            </th>

                            <th class="border px-4 py-3 text-center">
                                Status
                            </th>

                            <th class="border px-4 py-3">
                                Keterangan
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($barangMasuk as $index => $item)

                        <tr class="border-b hover:bg-gray-50">

                            <td class="border px-4 py-3 text-center">
                                {{ $index + 1 }}
                            </td>


                            <td class="border px-4 py-3">

                                {{ $item->pembelian->no_po ?? '-' }}

                            </td>


                            <td class="border px-4 py-3">

                                {{ $item->pembelian->supplier_nama ?? '-' }}

                            </td>


                            <td class="border px-4 py-3">

                                {{ $item->barang->nama_barang ?? '-' }}

                            </td>


                            <td class="border px-4 py-3 text-center">

                                {{ $item->jumlah ?? 0 }}

                            </td>


                            <td class="border px-4 py-3 text-center font-semibold">

                                {{ $item->qty_masuk ?? $item->jumlah ?? 0 }}

                            </td>


                            <td class="border px-4 py-3 text-center">

                                @if(($item->pembelian->status ?? '') == 'Selesai')

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">

                                        Selesai

                                    </span>

                                @else

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">

                                        {{ $item->pembelian->status ?? 'Menunggu Barang' }}

                                    </span>

                                @endif

                            </td>


                            <td class="border px-4 py-3">

                                {{ $item->keterangan ?? '-' }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center py-8 text-gray-500">

                                Belum ada data barang masuk.

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