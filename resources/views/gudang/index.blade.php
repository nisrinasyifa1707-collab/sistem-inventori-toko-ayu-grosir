@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">

            <div>

                <h2 class="text-2xl font-bold text-gray-800">
                    Stok Gudang
                </h2>

                <p class="text-sm text-gray-600">
                    Manajemen Stok Gudang dan Inventaris Toko
                </p>

            </div>

        </div>


        <!-- STATISTIK GUDANG -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

            <!-- Total Jenis Barang -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">

                <div class="text-sm font-semibold text-gray-500">
                    Total Jenis Barang
                </div>

                <div class="text-2xl font-bold text-gray-800 mt-1">
                    {{ $totalJenisBarang ?? count($barangs) }}
                </div>

            </div>


            <!-- Total Stok Fisik -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">

                <div class="text-sm font-semibold text-gray-500">
                    Total Stok Fisik
                </div>

                <div class="text-2xl font-bold text-gray-800 mt-1">
                    {{ $totalStokFisik ?? $barangs->sum('qty_gudang') }}
                </div>

            </div>


            <!-- Barang Hampir Habis -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">

                <div class="text-sm font-semibold text-gray-500">
                    Barang Hampir Habis
                </div>

                <div class="text-2xl font-bold text-red-600 mt-1">
                    {{ $barangHampirHabis ?? 0 }}
                </div>

            </div>

        </div>



        <!-- PO MENUNGGU BARANG -->
        <div class="bg-white shadow rounded-lg overflow-hidden mb-6">

            <div class="p-4 border-b bg-gray-50">

                <h3 class="font-semibold text-gray-700">
                    Purchase Order Menunggu Barang
                </h3>

                <p class="text-sm text-gray-500">
                    Daftar PO yang harus diterima oleh bagian Gudang.
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="px-4 py-3">
                                No PO
                            </th>

                            <th class="px-4 py-3">
                                Supplier
                            </th>

                            <th class="px-4 py-3">
                                Tanggal
                            </th>

                            <th class="px-4 py-3">
                                Status
                            </th>

                            <th class="px-4 py-3 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($pembelians as $po)

                            <tr>

                                <td class="px-4 py-3">
                                    {{ $po->no_faktur }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $po->supplier_nama }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $po->tanggal_pembelian }}
                                </td>

                                <td class="px-4 py-3">

                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">

                                        {{ $po->status }}

                                    </span>

                                </td>

                                <td class="px-4 py-3 text-center">

                                    <a
                                        href="{{ route('gudang.terima', $po->id) }}"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">

                                        Terima Barang

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center py-6 text-gray-400">

                                    Tidak ada Purchase Order.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>



        <!-- TABEL STOK GUDANG -->
        <div class="bg-white shadow rounded-lg overflow-hidden">

            <!-- HEADER TABEL -->
            <div class="p-4 border-b bg-gray-50 flex justify-between items-center">

                <h3 class="font-semibold text-gray-700">
                    Daftar Inventaris Stok Gudang
                </h3>


                <!-- SEARCH -->
                <form
                    method="GET"
                    action="{{ route('gudang.index') }}">

                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari barang gudang..."
                        onkeyup="this.form.submit()"
                        class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                </form>

            </div>


            <!-- TABLE -->
            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <!-- TABLE HEADER -->
                    <thead class="bg-gray-100">

                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kode Barang
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Barang
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga Satuan
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                QTY Awal
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                QTY Masuk
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                QTY Stok
                            </th>

                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>

                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Update / Aksi
                            </th>

                        </tr>

                    </thead>


                    <!-- TABLE BODY -->
                    <tbody class="bg-white divide-y divide-gray-200">

                        @forelse($barangs as $b)

                            <tr>

                                <!-- KODE BARANG -->
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-blue-600 font-semibold">

                                    {{ $b->kode_barang }}

                                </td>


                                <!-- NAMA BARANG -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">

                                    {{ $b->nama_barang }}

                                </td>


                                <!-- HARGA SATUAN -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">

                                    Rp {{ number_format($b->harga ?? 0, 0, ',', '.') }}

                                </td>


                                <!-- QTY AWAL -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">

                                    {{ $b->qty_awal ?? 0 }}

                                </td>


                                <!-- QTY MASUK -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">

                                    {{ $b->qty_masuk ?? 0 }}

                                </td>


                                <!-- QTY STOK -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">

                                    {{ $b->qty_gudang ?? 0 }}

                                </td>


                                <!-- STATUS -->
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">

                                    @if(($b->qty_gudang ?? 0) <= ($b->min_stok ?? 5))

                                        <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">

                                            Tidak Aman

                                        </span>

                                    @else

                                        <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">

                                            Aman

                                        </span>

                                    @endif

                                </td>


                                <!-- UPDATE / AKSI -->
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">

                                    @if($b->status_update == 0)

                                        <form
                                            action="{{ route('gudang.updateStok', $b->id) }}"
                                            method="POST">

                                            @csrf

                                            <button
                                                type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-1.5 px-4 rounded text-xs">

                                                Update

                                            </button>

                                        </form>

                                    @else

                                        <span class="text-green-600 font-semibold text-xs">

                                            Sudah Update

                                        </span>

                                    @endif

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td
                                    colspan="8"
                                    class="px-6 py-6 text-center text-sm text-gray-400 italic">

                                    Belum ada data barang di gudang.

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