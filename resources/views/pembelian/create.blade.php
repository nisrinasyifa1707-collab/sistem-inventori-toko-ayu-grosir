@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">

            <div>

                <h2 class="text-2xl font-bold text-gray-800">
                    Tambah Pembelian Baru
                </h2>

                <p class="text-sm text-gray-500">
                    Buat Purchase Order dengan satu supplier dan banyak barang.
                </p>

            </div>

            <a href="{{ route('pembelian.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg">

                Kembali

            </a>

        </div>


        {{-- ERROR --}}
        @if ($errors->any())

            <div class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-700 p-4">

                <strong>Terjadi kesalahan:</strong>

                <ul class="list-disc ml-5 mt-2">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="mb-4 rounded-lg bg-green-100 border border-green-400 text-green-700 p-4">

                {{ session('success') }}

            </div>

        @endif


        {{-- FORM --}}
        <form
            action="{{ route('pembelian.store') }}"
            method="POST"
            id="formPembelian">

            @csrf


            <div class="bg-white shadow rounded-lg p-6">


                {{-- INFORMASI PO --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">


                    {{-- NO PO --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">

                            No. PO / Referensi

                        </label>

                        <input
                            type="text"
                            name="no_po"
                            value="{{ $noPo }}"
                            readonly
                            class="w-full bg-gray-100 border border-gray-300 p-2 rounded-lg">

                    </div>


                    {{-- TANGGAL --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">

                            Tanggal Pembelian

                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            value="{{ old('tanggal', date('Y-m-d')) }}"
                            class="w-full border border-gray-300 p-2 rounded-lg"
                            required>

                    </div>


                    {{-- SUPPLIER --}}
                    <div class="md:col-span-2">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">

                            Supplier

                        </label>

                        <select
                            name="supplier_id"
                            id="supplier_id"
                            class="w-full border border-gray-300 p-2 rounded-lg"
                            required>

                            <option value="">
                                -- Pilih Supplier --
                            </option>

                            @php
                                $suppliers = \App\Models\Supplier::orderBy('nama_supplier')->get();
                            @endphp

                            @foreach($suppliers as $supplier)

                                <option
                                    value="{{ $supplier->id }}"
                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>

                                    {{ $supplier->nama_supplier }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- DAFTAR BARANG --}}
                <div class="border-t pt-6">

                    <div class="flex justify-between items-center mb-4">

                        <div>

                            <h3 class="font-semibold text-gray-700">
                                Barang yang Dipesan
                            </h3>

                            <p class="text-xs text-gray-500">
                                Barang otomatis mengikuti supplier yang dipilih.
                            </p>

                        </div>

                        <button
                            type="button"
                            id="tambahBarang"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">

                            + Tambah Barang

                        </button>

                    </div>


                    {{-- CONTAINER BARANG --}}
                    <div id="barangContainer">

                        {{-- BARIS BARANG PERTAMA --}}
                        <div class="barang-row border border-gray-200 rounded-lg p-4 mb-4">

                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">


                                {{-- BARANG --}}
                                <div class="md:col-span-2">

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">

                                        Barang

                                    </label>

                                    <select
                                        name="barang_id[]"
                                        class="barang-select w-full border border-gray-300 p-2 rounded-lg"
                                        required>

                                        <option value="">
                                            -- Pilih Barang --
                                        </option>

                                        @foreach($barangs as $barang)

                                            <option
                                                value="{{ $barang->id }}"
                                                data-supplier="{{ $barang->supplier_id }}"
                                                data-harga="{{ $barang->harga_beli ?? 0 }}"
                                                data-satuan="{{ $barang->satuan ?? '' }}">

                                                {{ $barang->kode_barang }}
                                                -
                                                {{ $barang->nama_barang }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                {{-- SATUAN --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">

                                        Satuan

                                    </label>

                                    <select
                                        name="satuan[]"
                                        class="satuan-select w-full border border-gray-300 p-2 rounded-lg"
                                        required>

                                        <option value="">
                                            -- Pilih --
                                        </option>

                                        <option value="Pcs">
                                            Pcs
                                        </option>

                                        <option value="Dus">
                                            Dus
                                        </option>

                                        <option value="Kg">
                                            Kg
                                        </option>

                                        <option value="Liter">
                                            Liter
                                        </option>

                                        <option value="Box">
                                            Box
                                        </option>

                                    </select>

                                </div>


                                {{-- QTY --}}
                                <div>

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">

                                        Qty

                                    </label>

                                    <input
                                        type="number"
                                        name="qty[]"
                                        min="1"
                                        value="1"
                                        class="qty-input w-full border border-gray-300 p-2 rounded-lg"
                                        required>

                                </div>
                                
                            {{-- HARGA --}}
                            <input
                                type="hidden"
                                class="harga-input"
                                value="0">


                            {{-- HAPUS --}}
                            <div class="flex justify-end mt-3">

                                <button
                                    type="button"
                                    class="hapus-barang bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">

                                    Hapus

                                </button>

                            </div>

                        </div>

                    </div>

                {{-- CATATAN --}}
                <div class="mt-6">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">

                        Catatan

                    </label>

                    <textarea
                        name="catatan"
                        rows="3"
                        class="w-full border border-gray-300 p-2 rounded-lg"
                        placeholder="Tambahkan catatan jika ada...">{{ old('catatan') }}</textarea>

                </div>


                {{-- BUTTON --}}
                <div class="flex justify-end mt-6">

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">

                        Simpan Purchase Order

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const supplierSelect =
        document.getElementById('supplier_id');

    const container =
        document.getElementById('barangContainer');

    const tambahButton =
        document.getElementById('tambahBarang');

    /*
    |--------------------------------------------------------------------------
    | FILTER BARANG SESUAI SUPPLIER
    |--------------------------------------------------------------------------
    */

    function filterBarang(select) {

        const supplierId =
            supplierSelect.value;

        const options =
            select.querySelectorAll('option');

        options.forEach(function (option) {

            if (!option.value) {

                option.hidden = false;

                return;

            }

            if (
                supplierId &&
                option.dataset.supplier == supplierId
            ) {

                option.hidden = false;

            } else {

                option.hidden = true;

            }

        });


        // Reset pilihan barang
        select.value = '';

    }

    /*
    |--------------------------------------------------------------------------
    | EVENT SUPPLIER
    |--------------------------------------------------------------------------
    */

    supplierSelect.addEventListener(
        'change',
        function () {

            document
                .querySelectorAll('.barang-select')
                .forEach(function (select) {

                    filterBarang(select);

                });

        }
    );


    /*
    |--------------------------------------------------------------------------
    | EVENT BARANG & QTY
    |--------------------------------------------------------------------------
    */

    function pasangEvent(row) {

        const barangSelect =
            row.querySelector('.barang-select');

        const qtyInput =
            row.querySelector('.qty-input');

        barangSelect.addEventListener(
            'change',
            function () {

                /*
                |--------------------------------------------------------------
                | Otomatis isi satuan dari Master Barang
                |--------------------------------------------------------------
                */

                const selected =
                    barangSelect.options[
                        barangSelect.selectedIndex
                    ];

                const satuan =
                    selected?.dataset.satuan || '';

                const satuanSelect =
                    row.querySelector('.satuan-select');

                if (satuan) {

                    satuanSelect.value = satuan;

                }

            }
        );


        qtyInput.addEventListener(
            'input',
            function () {

                updateRow(row);

            }
        );


        row
            .querySelector('.hapus-barang')
            .addEventListener(
                'click',
                function () {

                    const rows =
                        document.querySelectorAll('.barang-row');

                    if (rows.length > 1) {

                        row.remove()

                    } else {

                        alert(
                            'Minimal harus ada satu barang.'
                        );

                    }

                }
            );

    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAH BARANG
    |--------------------------------------------------------------------------
    */

    tambahButton.addEventListener(
        'click',
        function () {

            const pertama =
                document.querySelector('.barang-row');

            const row =
                pertama.cloneNode(true);


            // Reset barang
            row.querySelector('.barang-select').value = '';

            // Reset satuan
            row.querySelector('.satuan-select').value = '';

            // Reset qty
            row.querySelector('.qty-input').value = 1;

            // Reset harga
            row.querySelector('.harga-input').value = 0;

          // Reset harga
            row.querySelector('.harga-input').value = 0;

            container.appendChild(row);

            filterBarang(
                row.querySelector('.barang-select')
            );


            pasangEvent(row);

        }
    );


    /*
    |--------------------------------------------------------------------------
    | EVENT AWAL
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.barang-row')
        .forEach(function (row) {

            pasangEvent(row);

        });


    /*
    |--------------------------------------------------------------------------
    | FILTER AWAL
    |--------------------------------------------------------------------------
    */

    if (supplierSelect.value) {

        document
            .querySelectorAll('.barang-select')
            .forEach(function (select) {

                filterBarang(select);

            });

    }


});

</script>

@endsection