@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="mb-6">

            <h1 class="text-2xl font-bold text-gray-800">
                Penentuan Harga
            </h1>

            <p class="text-gray-500 mt-1">
                Tentukan harga beli dan harga jual barang
            </p>

        </div>


        {{-- FORM --}}
        <div class="bg-white rounded-xl shadow p-6">

            <form
                action="{{ route('harga.update', $barang->id) }}"
                method="POST"
            >

                @csrf
                @method('PUT')


                {{-- KODE BARANG --}}
                <div class="mb-5">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kode Barang
                    </label>

                    <input
                        type="text"
                        value="{{ $barang->kode_barang }}"
                        readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-gray-100 text-gray-600"
                    >

                </div>


                {{-- NAMA BARANG --}}
                <div class="mb-5">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Barang
                    </label>

                    <input
                        type="text"
                        value="{{ $barang->nama_barang }}"
                        readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-gray-100 text-gray-600"
                    >

                </div>


                {{-- GOLONGAN --}}
                <div class="mb-5">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Golongan
                    </label>

                    <input
                        type="text"
                        value="{{ $barang->golongan->nama_golongan ?? '-' }}"
                        readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-gray-100 text-gray-600"
                    >

                </div>


                {{-- KATEGORI --}}
                <div class="mb-5">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori
                    </label>

                    <input
                        type="text"
                        value="{{ $barang->kategori->nama_kategori ?? '-' }}"
                        readonly
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-gray-100 text-gray-600"
                    >

                </div>


                {{-- HARGA BELI --}}
                <div class="mb-5">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Harga Beli
                    </label>

                    <input
                        type="number"
                        name="harga_beli"
                        id="harga_beli"
                        value="{{ old('harga_beli', $barang->harga_beli ?? 0) }}"
                        min="0"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                    @error('harga_beli')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- HARGA JUAL --}}
                <div class="mb-6">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Harga Jual
                    </label>

                    <input
                        type="number"
                        name="harga_jual"
                        id="harga_jual"
                        value="{{ old('harga_jual', $barang->harga_jual ?? 0) }}"
                        min="0"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                    @error('harga_jual')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- MARGIN --}}
<div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-5">

    <div class="flex items-center justify-between">

        <div>
            <p class="text-sm font-semibold text-gray-700">
                Margin Keuntungan
            </p>

            <p class="text-xs text-gray-500 mt-1">
                Harga jual dikurangi harga beli
            </p>
        </div>

        <div class="text-right">

            <p id="margin_nominal"
               class="text-xl font-bold text-blue-600">
                Rp 0
            </p>

            <p id="margin_persen"
               class="text-sm font-semibold text-blue-500">
                0%
            </p>

        </div>

    </div>

</div>

                {{-- BUTTON --}}
                <div class="flex items-center justify-between">

                    <a
                        href="{{ route('harga.index') }}"
                        class="px-5 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold"
                    >
                        Kembali
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold"
                    >
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
<script>

    function hitungMargin() {

        const hargaBeli =
            parseFloat(document.getElementById('harga_beli').value) || 0;

        const hargaJual =
            parseFloat(document.getElementById('harga_jual').value) || 0;

        const margin = hargaJual - hargaBeli;

        let persen = 0;

        if (hargaBeli > 0) {
            persen = (margin / hargaBeli) * 100;
        }

        document.getElementById('margin_nominal').innerText =
            'Rp ' + new Intl.NumberFormat('id-ID').format(margin);

        document.getElementById('margin_persen').innerText =
            persen.toFixed(2) + '%';
    }


    document.getElementById('harga_beli')
        .addEventListener('input', hitungMargin);

    document.getElementById('harga_jual')
        .addEventListener('input', hitungMargin);


    hitungMargin();

</script>
@endsection