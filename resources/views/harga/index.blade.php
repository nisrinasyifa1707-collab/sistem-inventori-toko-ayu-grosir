@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="bg-white rounded-xl shadow p-6 mb-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        Penentuan Harga
                    </h1>

                    <p class="text-gray-500 mt-1">
                        Menentukan harga beli dan harga jual barang
                    </p>
                </div>

                {{-- SEARCH --}}
                <form action="{{ route('harga.index') }}" method="GET">

                    <div class="flex gap-2">

                        <input
                            type="text"
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="Cari barang..."
                            class="border border-gray-300 rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">

                            Cari

                        </button>

                    </div>

                </form>

            </div>

        </div>

        
        {{-- TABLE --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-100 border-b">

                        <tr>

                            <th class="px-4 py-4 text-left font-semibold text-gray-700">
                                Kode / Nama Barang
                            </th>

                            <th class="px-4 py-4 text-left font-semibold text-gray-700">
                                Golongan
                            </th>

                            <th class="px-4 py-4 text-left font-semibold text-gray-700">
                                Kategori
                            </th>

                            <th class="px-4 py-4 text-center font-semibold text-gray-700">
                                Stok Saat Ini
                            </th>

                            <th class="px-4 py-4 text-center font-semibold text-gray-700">
                                Min Stok
                            </th>

                            <th class="px-4 py-4 text-center font-semibold text-gray-700">
                                Status / Peringatan
                            </th>

                            <th class="px-4 py-4 text-right font-semibold text-gray-700">
                                Harga Beli
                            </th>

                            <th class="px-4 py-4 text-right font-semibold text-gray-700">
                                Harga Jual
                            </th>

                            <th class="px-4 py-4 text-right font-semibold text-gray-700">
                                  Margin
                            </th>

                            <th class="px-4 py-4 text-center font-semibold text-gray-700">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y">

                        @forelse($barangs as $barang)

                            <tr class="hover:bg-gray-50">

                                {{-- KODE / NAMA --}}
                                <td class="px-4 py-4">

                                    <div class="font-semibold text-gray-800">
                                        {{ $barang->kode_barang }}
                                    </div>

                                    <div class="text-gray-500">
                                        {{ $barang->nama_barang }}
                                    </div>

                                </td>

                                {{-- GOLONGAN --}}
                                <td class="px-4 py-4">

                                    {{ $barang->golongan->nama_golongan ?? '-' }}

                                </td>

                                {{-- KATEGORI --}}
                                <td class="px-4 py-4">

                                    {{ $barang->kategori->nama_kategori ?? '-' }}

                                </td>

                                {{-- STOK --}}
                                <td class="px-4 py-4 text-center font-semibold">

                                    {{ $barang->stok }}

                                </td>

                                {{-- MIN STOK --}}
                                <td class="px-4 py-4 text-center">

                                    {{ $barang->min_stok }}

                                </td>

                                {{-- STATUS --}}
                                <td class="px-4 py-4 text-center">

                                    @if($barang->stok <= $barang->min_stok)

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">

                                            ⚠️ Stok Menipis

                                        </span>

                                    @else

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">

                                            🟢 Aman

                                        </span>

                                    @endif

                                </td>

                                {{-- HARGA BELI --}}
                                <td class="px-4 py-4 text-right font-semibold text-gray-800">

                                    Rp {{ number_format($barang->harga_beli ?? 0, 0, ',', '.') }}

                                </td>

                                {{-- HARGA JUAL --}}
                                <td class="px-4 py-4 text-right font-semibold text-blue-600">

                                    Rp {{ number_format($barang->harga_jual ?? 0, 0, ',', '.') }}

                                </td>

{{-- MARGIN --}}
<td class="px-4 py-4 text-right font-semibold text-green-600">
    Rp {{ number_format($barang->margin ?? 0, 0, ',', '.') }}
</td>

                                {{-- AKSI --}}
                                <td class="px-4 py-4 text-center">

                                    <a
                                        href="{{ route('harga.edit', $barang->id) }}"
                                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold">

                                        Edit

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="10"
                                    class="px-4 py-10 text-center text-gray-500">

                                    Data barang tidak ditemukan.

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