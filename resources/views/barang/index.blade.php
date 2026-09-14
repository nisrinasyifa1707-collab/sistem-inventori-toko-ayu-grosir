@extends('layouts.app')

@section('content')
    <div class="py-6" x-data="{ modalTambah: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

           <div class="bg-white rounded-xl shadow p-6 mb-6">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">

                📦 Master Barang

            </h1>

            <p class="text-gray-500 mt-1">

                Kelola seluruh data barang Toko Ayu Grosir.

            </p>

        </div>
<a href="{{ route('barang.create') }}"
   class="bg-blue-600 text-white px-5 py-3 rounded-lg font-semibold">
    + Tambah Barang
</a>
</a>

    </div>

</div>

            <!-- MODAL TAMBAH BARANG -->
            <div x-show="modalTambah" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" style="display: none;" x-cloak>
                <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg" @click.outside="modalTambah = false">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Tambah Barang Baru</h3>
                    
                    <form action="{{ route('barang.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="block text-xs font-semibold text-gray-600 mb-1">
            Kode Barang
        </label>
        <input
            type="text"
            name="kode_barang"
            class="w-full border p-2 rounded-lg text-sm"
            placeholder="Contoh : BRG001"
            required>
    </div>

    <div class="mb-3">
        <label class="block text-xs font-semibold text-gray-600 mb-1">
            Nama Barang
        </label>
        <input
            type="text"
            name="nama_barang"
            class="w-full border p-2 rounded-lg text-sm"
            placeholder="Contoh : Beras Ramos"
            required>
    </div>

    <div class="mb-3">
        <label class="block text-xs font-semibold text-gray-600 mb-1">
            Golongan
        </label>

        <select
            name="golongan_id"
            class="w-full border p-2 rounded-lg text-sm"
            required>

            <option value="">-- Pilih Golongan --</option>

            @foreach($golongans as $golongan)
                <option value="{{ $golongan->id }}">
                    {{ $golongan->nama_golongan }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="mb-3">
        <label class="block text-xs font-semibold text-gray-600 mb-1">
            Kategori
        </label>

        <select
            name="kategori_id"
            class="w-full border p-2 rounded-lg text-sm"
            required>

            <option value="">-- Pilih Kategori --</option>

            @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}">
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="mb-3">
        <label class="block text-xs font-semibold text-gray-600 mb-1">
            Harga Satuan (Rp)
        </label>

        <input
            type="number"
            name="harga_satuan"
            class="w-full border p-2 rounded-lg text-sm"
            placeholder="15000"
            required>
    </div>

    <div class="mb-3">
        <label class="block text-xs font-semibold text-gray-600 mb-1">
            Stok Awal
        </label>

        <input
            type="number"
            name="stok"
            class="w-full border p-2 rounded-lg text-sm"
            placeholder="0"
            required>
    </div>

    <div class="mb-3">
        <label class="block text-xs font-semibold text-gray-600 mb-1">
            Minimal Stok
        </label>

        <input
            type="number"
            name="min_stok"
            class="w-full border p-2 rounded-lg text-sm"
            placeholder="5"
            required>
    </div>

    <div class="mb-3">
        <label class="block text-xs font-semibold text-gray-600 mb-1">
            Satuan
        </label>

        <input
            type="text"
            name="satuan"
            class="w-full border p-2 rounded-lg text-sm"
            placeholder="Contoh : Pcs, Kg, Dus"
            required>
    </div>

    <div class="mb-4">
        <label class="block text-xs font-semibold text-gray-600 mb-1">
            Keterangan
        </label>

        <textarea
            name="keterangan"
            rows="3"
            class="w-full border p-2 rounded-lg text-sm"
            placeholder="Opsional"></textarea>
    </div>

    <div class="flex justify-end gap-2">
        <button
            type="button"
            @click="modalTambah = false"
            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-400">

            Batal

        </button>

        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-blue-700">

            Simpan

        </button>
    </div>
</form>
                </div>
            </div>

            <!-- Tabel Daftar Barang -->
           <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-700">Semua Inventaris Barang</h3>
                    <form method="GET" action="{{ route('barang.index') }}">
<input
    type="text"
    name="search"
    value="{{ request('search') }}"
    placeholder="🔍 Cari kode atau nama barang..."
    class="w-72 border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode / Nama Barang</th>
                             <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
    Golongan
</th>

<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
    Kategori
</th>

<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
    Harga
</th>  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Saat Ini</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status / Peringatan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($barangs as $b)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-blue-600 font-semibold">{{ $b->kode_barang }}</div>
                                    <div class="text-sm font-bold text-gray-900">{{ $b->nama_barang }}</div>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
    {{ optional($b->golongan)->nama_golongan }}
</td>

<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
    {{ optional($b->kategori)->nama_kategori }}
</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    Rp {{ number_format($b->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $b->stok <= ($b->min_stok ?? 5) ? 'text-red-600' : 'text-gray-800' }}">
                                    {{ $b->stok }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $b->min_stok ?? 5 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">

    @if($b->stok <= ($b->min_stok ?? 5))

<a href="{{ route('pembelian.create', ['barang' => $b->id]) }}"
   class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold hover:bg-red-200">

    🔴 Perlu Restok

</a>

@else

<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">

🟢 Aman

</span>

@endif

</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
    <div class="flex justify-center items-center gap-4">

        <a href="{{ route('barang.edit', $b->id) }}"
           class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
            Edit
        </a>

        <form action="{{ route('barang.destroy', $b->id) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus barang ini?')">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="text-red-600 hover:text-red-800 font-semibold text-sm">
                Hapus
            </button>

        </form>

    </div>
</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-6 text-center text-sm text-gray-400 italic">
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