@extends('layouts.app')

@section('content')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Laporan Penjualan
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Laporan transaksi penjualan berdasarkan periode.
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
                            href="{{ route('owner.laporan.penjualan') }}"
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
                Total Penjualan
            </p>

            <h2 class="text-2xl font-bold text-green-600 mt-1">
                Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
            </h2>

        </div>


        {{-- TABEL --}}
        <div class="bg-white rounded-xl shadow p-6">

            <div class="flex justify-between items-center mb-5">

                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Data Transaksi Penjualan
                    </h2>

                    <p class="text-sm text-gray-500">
                        Menampilkan transaksi sesuai periode yang dipilih.
                    </p>
                </div>

                <a
                    href="{{ route('owner.pdf.penjualan', request()->query()) }}"
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
                                No Faktur
                            </th>

                            <th class="border px-4 py-3">
                                Tanggal
                            </th>

                            <th class="border px-4 py-3">
                                Metode Pembayaran
                            </th>

                            <th class="border px-4 py-3">
                                Status Pembayaran
                            </th>

                            <th class="border px-4 py-3">
                                Status Packing
                            </th>

                            <th class="border px-4 py-3 text-right">
                                Total
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($penjualans as $index => $item)

                        <tr class="border-b hover:bg-gray-50">

                            <td class="border px-4 py-3 text-center">
                                {{ $index + 1 }}
                            </td>

                            <td class="border px-4 py-3">
                                {{ $item->no_faktur ?? '-' }}
                            </td>

                            <td class="border px-4 py-3">
                                {{ optional($item->created_at)->format('d-m-Y') ?? '-' }}
                            </td>

                            <td class="border px-4 py-3">
                                {{ $item->metode_pembayaran ?? '-' }}
                            </td>

                            <td class="border px-4 py-3">

                                @if($item->status_pembayaran == 'Lunas')

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                        Lunas
                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                        Belum Lunas
                                    </span>

                                @endif

                            </td>


                            <td class="border px-4 py-3">

                                @if($item->status_packing == 'Pending')

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                        Pending
                                    </span>

                                @elseif($item->status_packing == 'Dipacking')

                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                                        Dipacking
                                    </span>

                                @else

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                        Selesai
                                    </span>

                                @endif

                            </td>


                            <td class="border px-4 py-3 text-right font-semibold whitespace-nowrap">

                                Rp {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-8 text-gray-500">

                                Belum ada transaksi penjualan.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>


                    @if($penjualans->count())

                    <tfoot>

                        <tr class="bg-gray-50">

                            <td
                                colspan="6"
                                class="border px-4 py-3 text-right font-bold">

                                Total Penjualan

                            </td>

                            <td
                                class="border px-4 py-3 text-right font-bold text-green-600">

                                Rp {{ number_format($totalPenjualan, 0, ',', '.') }}

                            </td>

                        </tr>

                    </tfoot>

                    @endif

                </table>

            </div>

        </div>

    </div>
</div>

@endsection