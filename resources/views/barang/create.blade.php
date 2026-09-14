@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Tambah Barang Baru
        </h1>

        <p class="text-gray-500 mt-1">
            Tambahkan data barang baru ke dalam Master Barang.
        </p>
    </div>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
            <strong class="font-bold">Terjadi kesalahan!</strong>

            <ul class="mt-1 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <div class="bg-white shadow rounded-xl overflow-hidden">

        <div class="p-6 border-b bg-gray-50 flex justify-between items-center">

            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Data Barang
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Isi informasi barang yang akan ditambahkan.
                </p>
            </div>

            <a
                href="{{ route('barang.index') }}"
                class="text-sm text-blue-600 hover:underline font-semibold"
            >
                ← Kembali
            </a>

        </div>

        <form
            action="{{ route('barang.store') }}"
            method="POST"
            class="p-6 space-y-5"
        >

            @csrf

            {{-- KODE BARANG --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kode Barang
                </label>

                <input
                    type="text"
                    name="kode_barang"
                    value="{{ old('kode_barang') }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: BRS-001"
                >

                @error('kode_barang')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- NAMA BARANG --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Barang
                </label>

                <input
                    type="text"
                    name="nama_barang"
                    value="{{ old('nama_barang') }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: Beras Pandan Wangi"
                >

                @error('nama_barang')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- GOLONGAN --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Golongan
                </label>

                <select
                    name="golongan_id"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3"
                >
                    <option value="">
                        -- Pilih Golongan --
                    </option>

                    @foreach($golongans as $golongan)
                        <option
                            value="{{ $golongan->id }}"
                            {{ old('golongan_id') == $golongan->id ? 'selected' : '' }}
                        >
                            {{ $golongan->nama_golongan }}
                        </option>
                    @endforeach

                </select>

                @error('golongan_id')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- KATEGORI --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kategori
                </label>

                <select
                    name="kategori_id"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3"
                >
                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    @foreach($kategoris as $kategori)
                        <option
                            value="{{ $kategori->id }}"
                            {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}
                        >
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach

                </select>

                @error('kategori_id')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- SUPPLIER --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Supplier
                </label>

                <select
                    name="supplier_id"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3"
                >
                    <option value="">
                        -- Pilih Supplier --
                    </option>

                    @foreach($suppliers as $supplier)
                        <option
                            value="{{ $supplier->id }}"
                            {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}
                        >
                            {{ $supplier->nama_supplier }}
                        </option>
                    @endforeach

                </select>

                @error('supplier_id')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- STOK --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Stok
                </label>

                <input
                    type="number"
                    name="stok"
                    value="{{ old('stok', 0) }}"
                    min="0"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3"
                >

                @error('stok')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- MINIMUM STOK --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Minimum Stok
                </label>

                <input
                    type="number"
                    name="min_stok"
                    value="{{ old('min_stok', 10) }}"
                    min="0"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3"
                >

                @error('min_stok')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- SATUAN --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Satuan Barang
                </label>

                <select
                    name="satuan"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3"
                >
                    <option value="">-- Pilih Satuan --</option>

                    <option value="Dus" {{ old('satuan') == 'Dus' ? 'selected' : '' }}>
                        Dus
                    </option>

                    <option value="Pak" {{ old('satuan') == 'Pak' ? 'selected' : '' }}>
                        Pak
                    </option>

                    <option value="Pcs" {{ old('satuan') == 'Pcs' ? 'selected' : '' }}>
                        Pcs
                    </option>

                    <option value="Kg" {{ old('satuan') == 'Kg' ? 'selected' : '' }}>
                        Kg
                    </option>

                    <option value="Liter" {{ old('satuan') == 'Liter' ? 'selected' : '' }}>
                        Liter
                    </option>

                    <option value="Botol" {{ old('satuan') == 'Botol' ? 'selected' : '' }}>
                        Botol
                    </option>

                    <option value="Bungkus" {{ old('satuan') == 'Bungkus' ? 'selected' : '' }}>
                        Bungkus
                    </option>

                </select>

                @error('satuan')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- KETERANGAN --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3"
                    placeholder="Keterangan barang (opsional)"
                >{{ old('keterangan') }}</textarea>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-between pt-5 border-t">

                <a
                    href="{{ route('barang.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-5 rounded-lg"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow"
                >
                    Simpan Barang
                </button>

            </div>

        </form>

    </div>

</div>

@endsection