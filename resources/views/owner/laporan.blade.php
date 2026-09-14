@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-7xl mx-auto px-4">

        {{-- ========================================================= --}}
        {{-- JUDUL --}}
        {{-- ========================================================= --}}

        <div class="mb-6">

            <h1 class="text-3xl font-bold text-gray-800">
                Laporan Owner
            </h1>

            <p class="text-gray-500 mt-1">
                Laporan operasional berdasarkan periode transaksi.
            </p>

        </div>


        {{-- ========================================================= --}}
        {{-- STATISTIK --}}
        {{-- ========================================================= --}}

        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">

            {{-- TOTAL PENJUALAN --}}
            <div class="bg-white rounded-xl shadow p-5">

                <p class="text-gray-500">
                    Total Penjualan
                </p>

                <h2 class="text-2xl font-bold text-green-600 mt-2">
                    Rp {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}
                </h2>

            </div>


            {{-- TOTAL PEMBELIAN --}}
            <div class="bg-white rounded-xl shadow p-5">

                <p class="text-gray-500">
                    Total Pembelian
                </p>

                <h2 class="text-2xl font-bold text-red-600 mt-2">
                    Rp {{ number_format($totalPembelian ?? 0, 0, ',', '.') }}
                </h2>

            </div>


            {{-- JUMLAH BARANG --}}
            <div class="bg-white rounded-xl shadow p-5">

                <p class="text-gray-500">
                    Jumlah Barang
                </p>

                <h2 class="text-2xl font-bold text-gray-800 mt-2">
                    {{ $totalBarang ?? 0 }}
                </h2>

            </div>


            {{-- PROFIT --}}
            <div class="bg-white rounded-xl shadow p-5">

                <p class="text-gray-500">
                    Profit
                </p>

                <h2 class="text-2xl font-bold text-blue-600 mt-2">
                    Rp {{ number_format($profit ?? 0, 0, ',', '.') }}
                </h2>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- FILTER TANGGAL --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-xl shadow p-5 mb-6">

            <form
                method="GET"
                action="{{ route('owner.laporan') }}"
                class="flex flex-wrap items-end gap-4"
            >

                {{-- DARI --}}
                <div>

                    <label class="block text-sm text-gray-600 mb-1">
                        Dari
                    </label>

                    <input
                        type="date"
                        name="start_date"
                        value="{{ request('start_date') }}"
                        class="border border-gray-300 rounded-lg px-4 py-2"
                    >

                </div>


                {{-- SAMPAI --}}
                <div>

                    <label class="block text-sm text-gray-600 mb-1">
                        Sampai
                    </label>

                    <input
                        type="date"
                        name="end_date"
                        value="{{ request('end_date') }}"
                        class="border border-gray-300 rounded-lg px-4 py-2"
                    >

                </div>


                {{-- FILTER --}}
                <div>

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg"
                    >
                        Filter
                    </button>

                </div>


                {{-- RESET --}}
                <div>

                    <a
                        href="{{ route('owner.laporan') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg inline-block"
                    >
                        Reset
                    </a>

                </div>


                {{-- EXPORT PDF --}}
                <div>

                    <a
                        href="{{ route('owner.pdf', request()->only(['start_date','end_date'])) }}"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-lg inline-block"
                    >
                        Export PDF
                    </a>

                </div>

            </form>

        </div>


        {{-- ========================================================= --}}
        {{-- GRAFIK PENJUALAN --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-xl shadow p-6 mb-8">

            <h2 class="text-xl font-bold text-gray-800 mb-5">
                Grafik Penjualan
            </h2>

            <div style="height:300px;">

                <canvas id="chartPenjualan"></canvas>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- 1. LAPORAN PENJUALAN --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-xl shadow p-6 mb-8">

            <div class="flex justify-between items-center mb-5">

                <div>

                    <h2 class="text-2xl font-bold text-gray-800">
                        Laporan Penjualan
                    </h2>

                    <p class="text-sm text-gray-500">
                        Daftar transaksi penjualan berdasarkan periode yang dipilih.
                    </p>

                </div>

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
                                Metode
                            </th>

                            <th class="border px-4 py-3 text-center">
                                Pembayaran
                            </th>

                            <th class="border px-4 py-3 text-center">
                                Packing
                            </th>

                            <th class="border px-4 py-3 text-center">
                                Status
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
                                    {{ $item->metode_pembayaran ?? '-' }}
                                </td>


                                <td class="border px-4 py-3 text-center">

                                    @if(($item->status_pembayaran ?? '') == 'Lunas')

                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Lunas
                                        </span>

                                    @else

                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Belum Lunas
                                        </span>

                                    @endif

                                </td>


                                <td class="border px-4 py-3 text-center">
                                    {{ $item->status_packing ?? '-' }}
                                </td>


                                <td class="border px-4 py-3 text-center">

                                    @if(($item->status_packing ?? '') == 'Pending')

                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Pending
                                        </span>

                                    @elseif(($item->status_packing ?? '') == 'Dipacking')

                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Dipacking
                                        </span>

                                    @elseif(($item->status_packing ?? '') == 'Selesai')

                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Selesai
                                        </span>

                                    @else

                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">
                                            -

                                        </span>

                                    @endif

                                </td>


                                <td class="border px-4 py-3 text-right font-bold whitespace-nowrap">

                                    Rp {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-8 text-gray-500"
                                >
                                    Belum ada transaksi penjualan pada periode ini.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- 2. LAPORAN PEMBELIAN --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-xl shadow p-6 mb-8">

            <div class="mb-5">

                <h2 class="text-2xl font-bold text-gray-800">
                    Laporan Pembelian
                </h2>

                <p class="text-sm text-gray-500">
                    Daftar Purchase Order dan transaksi pembelian dari supplier.
                </p>

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
                                Tanggal Pembelian
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

                        @forelse($purchaseOrders as $index => $po)

                            <tr class="border-b hover:bg-gray-50">

                                <td class="border px-4 py-3 text-center">
                                    {{ $index + 1 }}
                                </td>


                                <td class="border px-4 py-3 font-semibold">
                                    {{ $po->no_po ?? $po->no_faktur ?? '-' }}
                                </td>


                                <td class="border px-4 py-3">
                                    {{ $po->supplier_nama ?? '-' }}
                                </td>


                                <td class="border px-4 py-3">
                                    {{ $po->tanggal_pembelian ?? '-' }}
                                </td>


                                <td class="border px-4 py-3 text-right font-bold whitespace-nowrap">

                                    Rp {{ number_format($po->total_biaya ?? 0, 0, ',', '.') }}

                                </td>


                                <td class="border px-4 py-3 text-center">

                                    @if(($po->status ?? '') == 'Selesai')

                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Selesai
                                        </span>

                                    @else

                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ $po->status ?? 'Menunggu Barang' }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-8 text-gray-500"
                                >
                                    Belum ada transaksi pembelian pada periode ini.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- 3. LAPORAN BARANG MASUK --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-xl shadow p-6 mb-8">

            <div class="mb-5">

                <h2 class="text-2xl font-bold text-gray-800">
                    Laporan Barang Masuk
                </h2>

                <p class="text-sm text-gray-500">
                    Daftar barang yang diterima dari supplier berdasarkan transaksi pembelian.
                </p>

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
                                Tanggal
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


                                <td class="border px-4 py-3 font-semibold">

                                    {{ $item->pembelian->no_po
                                        ?? $item->pembelian->no_faktur
                                        ?? '-' }}

                                </td>


                                <td class="border px-4 py-3">

                                    {{ $item->barang->nama_barang ?? '-' }}

                                </td>


                                <td class="border px-4 py-3 text-center">

                                    {{ $item->jumlah ?? 0 }}

                                </td>


                                <td class="border px-4 py-3 text-center">

                                    {{ $item->qty_masuk ?? $item->jumlah ?? 0 }}

                                </td>


                                <td class="border px-4 py-3 text-center">

                                    @if(($item->pembelian->status ?? '') == 'Selesai')

                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Selesai
                                        </span>

                                    @else

                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ $item->pembelian->status ?? 'Menunggu Barang' }}
                                        </span>

                                    @endif

                                </td>


                                <td class="border px-4 py-3">

                                    {{ $item->pembelian->tanggal_pembelian ?? '-' }}

                                </td>


                                <td class="border px-4 py-3">

                                    {{ $item->keterangan ?? '-' }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center py-8 text-gray-500"
                                >
                                    Belum ada data barang masuk pada periode ini.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- DATA BARANG --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-xl shadow p-6 mb-8">

            <div class="mb-5">

                <h2 class="text-2xl font-bold text-gray-800">
                    Data Barang
                </h2>

                <p class="text-sm text-gray-500">
                    Data stok barang saat ini.
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full border border-gray-200">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="border px-4 py-3 text-center">
                                No
                            </th>

                            <th class="border px-4 py-3">
                                Kode Barang
                            </th>

                            <th class="border px-4 py-3">
                                Nama Barang
                            </th>

                            <th class="border px-4 py-3 text-right">
                                Harga Jual
                            </th>

                            <th class="border px-4 py-3 text-center">
                                Stok
                            </th>

                            <th class="border px-4 py-3 text-center">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($barangs as $index => $barang)

                            <tr class="border-b hover:bg-gray-50">

                                <td class="border px-4 py-3 text-center">
                                    {{ $index + 1 }}
                                </td>


                                <td class="border px-4 py-3">
                                    {{ $barang->kode_barang ?? '-' }}
                                </td>


                                <td class="border px-4 py-3">
                                    {{ $barang->nama_barang ?? '-' }}
                                </td>


                                <td class="border px-4 py-3 text-right">
                                    Rp {{ number_format($barang->harga_jual ?? 0, 0, ',', '.') }}
                                </td>


                                <td class="border px-4 py-3 text-center font-semibold">
                                    {{ $barang->stok ?? 0 }}
                                </td>


                                <td class="border px-4 py-3 text-center">

                                    @if(($barang->stok ?? 0) <= ($barang->stok_minimum ?? 0))

                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Stok Menipis
                                        </span>

                                    @else

                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Aman
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-8 text-gray-500"
                                >
                                    Belum ada data barang.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- CHART JS --}}
{{-- ========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('chartPenjualan');

    if (!canvas) {
        return;
    }

    new Chart(canvas, {

        type: 'bar',

        data: {

            labels: [

                @foreach($penjualans as $item)

                    "{{ optional($item->created_at)->format('d/m') }}",

                @endforeach

            ],

            datasets: [

                {

                    label: 'Penjualan',

                    data: [

                        @foreach($penjualans as $item)

                            {{ $item->total_harga ?? 0 }},

                        @endforeach

                    ],

                    borderWidth: 1,

                    borderRadius: 8

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        callback: function(value) {

                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);

                        }

                    }

                }

            },

            plugins: {

                legend: {

                    display: false

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return 'Rp ' +
                                new Intl.NumberFormat('id-ID')
                                .format(context.raw);

                        }

                    }

                }

            }

        }

    });

});

</script>

@endsection