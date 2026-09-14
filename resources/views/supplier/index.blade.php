@extends('layouts.app')

@section('content')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Master Supplier
            </h2>
        </div>

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-700 p-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Pesan error --}}
        @if($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-lg">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM TAMBAH SUPPLIER --}}
        <div class="bg-white rounded-xl shadow p-6 mb-6">

            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Tambah Supplier
            </h3>

            <form action="{{ route('supplier.store') }}" method="POST">
                @csrf

                {{-- Data Supplier --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Supplier
                        </label>

                        <input
                            type="text"
                            name="nama_supplier"
                            value="{{ old('nama_supplier') }}"
                            placeholder="Nama Supplier"
                            class="w-full border rounded-lg p-2"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat
                        </label>

                        <input
                            type="text"
                            name="alamat"
                            value="{{ old('alamat') }}"
                            placeholder="Alamat"
                            class="w-full border rounded-lg p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            No Telepon
                        </label>

                        <input
                            type="text"
                            name="telepon"
                            value="{{ old('telepon') }}"
                            placeholder="No Telepon"
                            class="w-full border rounded-lg p-2">
                    </div>

                </div>


                {{-- Barang yang disuplai --}}
                <div class="mt-6">

                    <div class="flex justify-between items-center mb-3">

                        <label class="block text-sm font-semibold text-gray-700">
                            Barang yang Disuplai
                        </label>

                        <button
                            type="button"
                            onclick="tambahBarang()"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">

                            + Tambah Barang

                        </button>

                    </div>


                    <div id="barang-container">

                        <div class="flex gap-2 mb-2 barang-row">

                            <select
                                name="barang_ids[]"
                                class="flex-1 border rounded-lg p-2">

                                <option value="">
                                    -- Pilih Barang --
                                </option>

                                @foreach($barangs as $barang)

                                    <option value="{{ $barang->id }}">
                                        {{ $barang->kode_barang }} -
                                        {{ $barang->nama_barang }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <p class="text-sm text-gray-500 mt-2">
                        Pilih satu atau lebih barang yang disuplai oleh supplier ini.
                    </p>

                </div>


                {{-- Tombol Simpan --}}
                <div class="mt-6">

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                        Simpan Supplier

                    </button>

                </div>

            </form>

        </div>


        {{-- DAFTAR SUPPLIER --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">

            <div class="p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    Daftar Supplier
                </h3>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="p-3 text-left">
                                No
                            </th>

                            <th class="p-3 text-left">
                                Supplier
                            </th>

                            <th class="p-3 text-left">
                                Alamat
                            </th>

                            <th class="p-3 text-left">
                                Telepon
                            </th>

                            <th class="p-3 text-left">
                                Barang yang Disuplai
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($suppliers as $supplier)

                        <tr class="border-t align-top">

                            <td class="p-3">
                                {{ $loop->iteration }}
                            </td>

                            <td class="p-3 font-medium">
                                {{ $supplier->nama_supplier }}
                            </td>

                            <td class="p-3">
                                {{ $supplier->alamat ?? '-' }}
                            </td>

                            <td class="p-3">
                                {{ $supplier->telepon ?? '-' }}
                            </td>

                            <td class="p-3">

                                @if($supplier->barangs->count())

                                    <div class="flex flex-wrap gap-2">

                                        @foreach($supplier->barangs as $barang)

                                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-md text-sm">
                                                {{ $barang->nama_barang }}
                                            </span>

                                        @endforeach

                                    </div>

                                @else

                                    <span class="text-gray-400">
                                        Belum ada barang
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center p-6 text-gray-400">

                                Belum ada supplier.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>


{{-- JavaScript tambah pilihan barang --}}
<script>

function tambahBarang() {

    const container = document.getElementById('barang-container');

    const row = document.createElement('div');

    row.className = 'flex gap-2 mb-2 barang-row';

    row.innerHTML = `
        <select
            name="barang_ids[]"
            class="flex-1 border rounded-lg p-2">

            <option value="">
                -- Pilih Barang --
            </option>

            @foreach($barangs as $barang)

                <option value="{{ $barang->id }}">
                    {{ $barang->kode_barang }} -
                    {{ $barang->nama_barang }}
                </option>

            @endforeach

        </select>

        <button
            type="button"
            onclick="this.parentElement.remove()"
            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">

            Hapus

        </button>
    `;

    container.appendChild(row);
}

</script>

@endsection