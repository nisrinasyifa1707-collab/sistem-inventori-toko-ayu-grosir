@extends('layouts.app')

@section('content')

<div class="space-y-8">

    <!-- Header -->
    <div class="flex justify-between items-center">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Dashboard
            </h1>

            <p class="text-gray-500 mt-1">
                Selamat datang kembali, {{ Auth::user()->name }} 👋
            </p>

        </div>

        <div class="text-right">

            <p class="text-sm text-gray-500">
                {{ now()->format('d F Y') }}
            </p>

        </div>

    </div>


    <!-- Card Statistik -->

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-xl shadow p-6">

            <p class="text-gray-500 text-sm">
                Total Barang
            </p>

            <h2 class="text-4xl font-bold mt-3 text-blue-600">

                {{ $barangs->count() }}

            </h2>

        </div>

        <div class="bg-white rounded-xl shadow p-6">

            <p class="text-gray-500 text-sm">

                Total Stok

            </p>

            <h2 class="text-4xl font-bold mt-3 text-green-600">

                {{ $barangs->sum('stok') }}

            </h2>

        </div>

        <div class="bg-white rounded-xl shadow p-6">

            <p class="text-gray-500 text-sm">

                Barang Menipis

            </p>

            <h2 class="text-4xl font-bold mt-3 text-red-600">

                {{ $barangs->where('stok','<=',5)->count() }}

            </h2>

        </div>

        <div class="bg-white rounded-xl shadow p-6">

            <p class="text-gray-500 text-sm">

                Nilai Inventory

            </p>

            <h2 class="text-3xl font-bold mt-3 text-yellow-600">

                Rp {{ number_format($barangs->sum(fn($b)=>$b->stok*$b->harga),0,',','.') }}

            </h2>

        </div>

    </div>


    <!-- Barang Stok Menipis -->

    <div class="bg-white rounded-xl shadow">

        <div class="border-b px-6 py-4">

            <h3 class="font-bold text-lg">

                Barang dengan Stok Menipis

            </h3>

        </div>

        <table class="w-full">

            <thead class="bg-gray-50">

            <tr>

                <th class="text-left p-4">Nama Barang</th>

                <th class="text-left p-4">Kategori</th>

                <th class="text-left p-4">Stok</th>

                <th class="text-left p-4">Status</th>

            </tr>

            </thead>

            <tbody>

            @forelse($barangs->where('stok','<=',5) as $barang)

                <tr class="border-t">

                    <td class="p-4 font-semibold">

                        {{ $barang->nama_barang }}

                    </td>

                    <td class="p-4">

                    {{ $barang->kategori?->nama_kategori }}

                    </td>

                    <td class="p-4">

                        {{ $barang->stok }}

                    </td>

                    <td class="p-4">

                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs">

                            Menipis

                        </span>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="text-center p-8 text-gray-400">

                        Tidak ada stok menipis.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
