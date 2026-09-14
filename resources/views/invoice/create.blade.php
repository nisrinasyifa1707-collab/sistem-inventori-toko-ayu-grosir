@extends('layouts.app')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    <h2 class="text-3xl font-bold mb-6">
        Isi Invoice Pembelian
    </h2>

    <form action="{{ route('invoice.store',$pembelian->id) }}" method="POST">

        @csrf

        <div class="grid grid-cols-2 gap-6 mb-6">

            <div>
                <label class="font-semibold">No PO</label>

                <input
                    type="text"
                    class="w-full border rounded-lg p-2 mt-1 bg-gray-100"
                    value="{{ $pembelian->no_po }}"
                    readonly>
            </div>

            <div>
                <label class="font-semibold">No Invoice</label>

                <input
                    type="text"
                    name="no_invoice"
                    class="w-full border rounded-lg p-2 mt-1"
                    value="INV-{{ date('Ymd') }}-{{ $pembelian->id }}">
            </div>

            <div>
                <label class="font-semibold">Supplier</label>

                <input
                    type="text"
                    class="w-full border rounded-lg p-2 mt-1 bg-gray-100"
                    value="{{ $pembelian->supplier_nama }}"
                    readonly>
            </div>

            <div>
                <label class="font-semibold">Tanggal Invoice</label>

                <input
                    type="date"
                    name="tanggal_invoice"
                    value="{{ date('Y-m-d') }}"
                    class="w-full border rounded-lg p-2 mt-1">
            </div>

        </div>


        <table class="w-full border">

            <thead class="bg-gray-100">

                <tr>

                    <th class="border p-3">Barang</th>

                    <th class="border p-3">Qty</th>

                    <th class="border p-3">Qty Masuk</th>

                    <th class="border p-3">Harga</th>

                    <th class="border p-3">Subtotal</th>

                </tr>

            </thead>


            <tbody>

            @foreach($pembelian->detailPembelians as $detail)

                <tr>

                    {{-- BARANG --}}
                    <td class="border p-3">
                        {{ $detail->barang->nama_barang }}
                    </td>


                    {{-- QTY PESAN --}}
                    <td class="border p-3 text-center">

                        <input
                            type="number"
                            value="{{ $detail->jumlah }}"
                            class="w-24 border rounded p-2 text-center bg-gray-100"
                            readonly>

                    </td>


                    {{-- QTY MASUK --}}
                    <td class="border p-3 text-center">

                        <input
                            type="number"
                            name="qty_masuk[{{ $detail->id }}]"
                            value="{{ $detail->qty_masuk }}"
                            min="1"
                            data-detail="{{ $detail->id }}"
                            class="qty-masuk w-24 border rounded p-2 text-center">

                    </td>


                    {{-- HARGA --}}
                    <td class="border p-3">

                        <input
                            type="number"
                            name="harga[{{ $detail->id }}]"
                            value="{{ $detail->harga_satuan }}"
                            data-detail="{{ $detail->id }}"
                            class="harga w-full border rounded p-2">

                    </td>


                    {{-- SUBTOTAL --}}
                    <td class="border p-3">

                        <span
                            class="subtotal"
                            data-detail="{{ $detail->id }}">

                            Rp {{ number_format(
                                $detail->qty_masuk * ($detail->harga_satuan ?? 0),
                                0,
                                ',',
                                '.'
                            ) }}

                        </span>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>


        {{-- GRAND TOTAL --}}
        <div class="text-right mt-6 text-xl font-bold">

            Total :
            <span id="grand-total">
                Rp 0
            </span>

        </div>


        {{-- BUTTON --}}
        <div class="text-right mt-6">

            <button
                type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

                Simpan Invoice

            </button>

        </div>

    </form>

</div>


{{-- JAVASCRIPT --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    function formatRupiah(angka) {

        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);

    }


    function hitungSubtotal() {

        let grandTotal = 0;


        document.querySelectorAll('.qty-masuk').forEach(function (qtyInput) {

            let detailId = qtyInput.dataset.detail;

            let hargaInput = document.querySelector(
                '.harga[data-detail="' + detailId + '"]'
            );

            let subtotalElement = document.querySelector(
                '.subtotal[data-detail="' + detailId + '"]'
            );


            if (!hargaInput || !subtotalElement) {
                return;
            }


            let qty = parseFloat(qtyInput.value) || 0;

            let harga = parseFloat(hargaInput.value) || 0;


            // Minimal Qty Masuk adalah 1
            if (qty < 1) {

                qty = 1;

                qtyInput.value = 1;

            }


            // Hitung subtotal
            let subtotal = qty * harga;


            // Tampilkan subtotal
            subtotalElement.textContent =
                formatRupiah(subtotal);


            // Tambahkan ke grand total
            grandTotal += subtotal;

        });


        // Tampilkan grand total
        document.getElementById('grand-total').textContent =
            formatRupiah(grandTotal);

    }


    // Jika Qty Masuk diubah
    document.querySelectorAll('.qty-masuk').forEach(function (input) {

        input.addEventListener('input', hitungSubtotal);

        input.addEventListener('change', hitungSubtotal);

    });


    // Jika Harga diubah
    document.querySelectorAll('.harga').forEach(function (input) {

        input.addEventListener('input', hitungSubtotal);

        input.addEventListener('change', hitungSubtotal);

    });


    // Hitung saat halaman pertama kali dibuka
    hitungSubtotal();

});

</script>

@endsection