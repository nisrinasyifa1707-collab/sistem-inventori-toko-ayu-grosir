@extends('layouts.app')

@section('content')

<div class="py-8">

    <div class="container mx-auto px-6 max-w-7xl">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6 bg-white p-6 rounded-xl shadow-sm">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Dashboard Staff Packing
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Kelola status pengemasan dan pesanan pelanggan yang siap dikirim.
                </p>
            </div>

            <div class="flex gap-2">

                <a href="{{ route('gudang.index') }}"
                   class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 transition">

                    ← Ke Gudang

                </a>

                <a href="{{ route('kasir.index') }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">

                    Ke Kasir →

                </a>

            </div>

        </div>


        {{-- INFO --}}
        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 mb-6">

            <div class="flex items-center gap-3">

                <span class="text-2xl">
                    📦
                </span>

                <div>

                    <p class="font-semibold text-indigo-800">
                        Antrean Packing
                    </p>

                    <p class="text-sm text-indigo-600">
                        Menampilkan pesanan yang masih Pending atau sedang dalam proses packing.
                    </p>

                </div>

            </div>

        </div>


        {{-- TABEL --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">

            <div class="p-6 border-b">

                <h2 class="text-lg font-bold text-gray-800">
                    Daftar Antrean Packing Pesanan
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Pesanan yang sudah selesai dikirim tidak ditampilkan dalam antrean aktif.
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead>

                        <tr class="bg-gray-50 text-gray-600 border-b">

                            <th class="p-4">
                                No. Faktur
                            </th>

                            <th class="p-4">
                                Waktu Transaksi
                            </th>

                            <th class="p-4">
                                Detail Barang
                            </th>

                            <th class="p-4 text-center">
                                Total Harga
                            </th>

                            <th class="p-4 text-center">
                                Status Packing
                            </th>

                            <th class="p-4 text-center">
                                Update Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($transaksis as $transaksi)

                        @php
                            $status = $transaksi->status_packing ?? 'Pending';
                        @endphp

                        <tr class="border-b hover:bg-gray-50 align-top">

                            {{-- NO FAKTUR --}}
                            <td class="p-4">

                                <span class="font-mono text-xs font-semibold text-gray-700">

                                    {{ $transaksi->no_faktur }}

                                </span>

                            </td>


                            {{-- WAKTU --}}
                            <td class="p-4 text-xs text-gray-500">

                                {{ $transaksi->created_at
                                    ? $transaksi->created_at->format('d-m-Y H:i:s')
                                    : '-' }}

                            </td>


                            {{-- DETAIL BARANG --}}
                            <td class="p-4">

                                <ul class="space-y-1">

                                    @foreach($transaksi->detailPenjualans as $detail)

                                        <li class="text-xs text-gray-700">

                                            • {{ $detail->barang->nama_barang ?? 'Barang Dihapus' }}

                                            <span class="font-bold">
                                                ({{ $detail->jumlah }}x)
                                            </span>

                                        </li>

                                    @endforeach

                                </ul>

                            </td>


                            {{-- TOTAL --}}
                            <td class="p-4 text-center">

                                <span class="font-bold text-gray-800">

                                    Rp {{ number_format(
                                        $transaksi->total_harga,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </span>

                            </td>


                            {{-- STATUS --}}
                            <td class="p-4 text-center">

                                @if($status == 'Pending')

                                    <span class="inline-block bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-semibold">

                                        🕐 Pending

                                    </span>

                                @elseif($status == 'Proses Packing')

                                    <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">

                                        📦 Sedang Dipacking

                                    </span>

                                @endif

                            </td>


                            {{-- UPDATE STATUS --}}
                            <td class="p-4 text-center">

                                <select
                                    onchange="updateStatus('{{ $transaksi->id }}', this.value)"
                                    class="border border-gray-300 rounded-lg px-3 py-2 text-xs bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">

                                    <option value="" disabled>
                                        Ubah Status...
                                    </option>

                                    <option value="Pending"
                                        {{ $status == 'Pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>

                                    <option value="Proses Packing"
                                        {{ $status == 'Proses Packing' ? 'selected' : '' }}>
                                        Proses Packing
                                    </option>

                                    <option value="Selesai / Dikirim">
                                        Selesai / Dikirim
                                    </option>

                                </select>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center p-10">

                                <div class="text-4xl mb-3">
                                    📦
                                </div>

                                <p class="font-semibold text-gray-600">
                                    Tidak ada antrean packing
                                </p>

                                <p class="text-sm text-gray-400 mt-1">
                                    Semua pesanan sudah selesai diproses.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>

function updateStatus(id, statusBaru) {

    if (!statusBaru) {
        return;
    }

    Swal.fire({

        title: 'Perbarui Status Packing?',

        text: 'Ubah status pesanan menjadi "' + statusBaru + '"?',

        icon: 'question',

        showCancelButton: true,

        confirmButtonText: 'Ya, Ubah',

        cancelButtonText: 'Batal',

        confirmButtonColor: '#4f46e5'

    }).then((result) => {

        if (result.isConfirmed) {

            fetch(`/packing/update-status/${id}`, {

                method: 'POST',

                headers: {

                    'Content-Type': 'application/json',

                    'X-CSRF-TOKEN': '{{ csrf_token() }}',

                    'Accept': 'application/json'

                },

                body: JSON.stringify({

                    status_packing: statusBaru

                })

            })

            .then(response => {

                if (!response.ok) {
                    throw new Error('Gagal memperbarui status');
                }

                return response.json();

            })

            .then(data => {

                if (data.success) {

                    Swal.fire({

                        icon: 'success',

                        title: 'Berhasil!',

                        text: data.message,

                        timer: 1200,

                        showConfirmButton: false

                    }).then(() => {

                        location.reload();

                    });

                }

            })

            .catch(error => {

                console.error(error);

                Swal.fire({

                    icon: 'error',

                    title: 'Gagal!',

                    text: 'Terjadi kesalahan saat memperbarui status.'

                });

            });

        }

    });

}

</script>

@endsection