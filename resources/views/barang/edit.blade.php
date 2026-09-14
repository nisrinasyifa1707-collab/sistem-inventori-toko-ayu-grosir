@extends('layouts.app')

@section('content')

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-xl shadow border border-gray-200">

                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    Edit Barang
                </h2>

                @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 p-4 mb-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <form action="{{ route('barang.update', $barang->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Kode Barang --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kode Barang
                        </label>
                        <input
                            type="text"
                            name="kode_barang"
                            value="{{ old('kode_barang', $barang->kode_barang) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    {{-- Nama Barang --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Barang
                        </label>
                        <input
                            type="text"
                            name="nama_barang"
                            value="{{ old('nama_barang', $barang->nama_barang) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                  {{-- Golongan --}}
<div class="mb-4">
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Golongan
    </label>

    <select
        name="golongan_id"
        class="w-full border border-gray-300 rounded-lg px-3 py-2"
        required>

        @foreach($golongans as $golongan)
            <option
                value="{{ $golongan->id }}"
                {{ $barang->golongan_id == $golongan->id ? 'selected' : '' }}>
                {{ $golongan->nama_golongan }}
            </option>
        @endforeach

    </select>
</div>

{{-- Kategori --}}
<div class="mb-4">
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Kategori
    </label>

    <select
        name="kategori_id"
        class="w-full border border-gray-300 rounded-lg px-3 py-2"
        required>

        @foreach($kategoris as $kategori)
            <option
                value="{{ $kategori->id }}"
                {{ $barang->kategori_id == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama_kategori }}
            </option>
        @endforeach

    </select>
</div>

{{-- Supplier --}}
<div class="mb-4">
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Supplier
    </label>

    <select
        name="supplier_id"
        class="w-full border border-gray-300 rounded-lg px-3 py-2"
        required>

        <option value="">-- Pilih Supplier --</option>

        @foreach($suppliers as $supplier)
            <option
                value="{{ $supplier->id }}"
                {{ $barang->supplier_id == $supplier->id ? 'selected' : '' }}>
                {{ $supplier->nama_supplier }}
            </option>
        @endforeach

    </select>
</div>

                   {{-- Harga --}}
<div class="mb-4">
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Harga Satuan
    </label>

    <input
        type="number"
        name="harga_satuan"
        value="{{ old('harga_satuan', $barang->harga) }}"
        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        required>
</div>

{{-- Stok --}}
<div class="mb-4">
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Stok
    </label>

    <input
        type="number"
        name="stok"
        value="{{ old('stok', $barang->stok) }}"
        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        required>
</div>

{{-- Satuan --}}
<div class="mb-4">
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Satuan
    </label>

    <input
        type="text"
        name="satuan"
        value="{{ old('satuan', $barang->satuan) }}"
        class="w-full border border-gray-300 rounded-lg px-3 py-2"
        required>
</div>
                    {{-- Minimal Stok --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Minimal Stok
                        </label>
                        <input
                            type="number"
                            name="min_stok"
                            value="{{ old('min_stok', $barang->min_stok) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div class="mb-4">
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Keterangan
    </label>

    <textarea
        name="keterangan"
        rows="3"
        class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old('keterangan', $barang->keterangan) }}</textarea>
</div>
                    {{-- Tombol --}}
                    <div class="flex justify-end gap-3">

                        <a href="{{ route('barang.index') }}"
                           class="px-5 py-2 bg-gray-300 text-black rounded-lg hover:bg-gray-400 font-semibold">
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2 bg-blue-600 text-black rounded-lg hover:bg-blue-700 font-semibold">
                            Perbarui
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection