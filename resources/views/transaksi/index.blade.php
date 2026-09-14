@extends('layouts.app')

@section('content')
    <div class="py-12 px-6">
        <div class="max-w-5xl mx-auto bg-white shadow rounded-lg p-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Header dengan Form Filter -->
            <div class="mb-6">
                <h2 class="text-xl font-bold mb-4">Riwayat Transaksi</h2>
                
                <div class="flex flex-wrap gap-4 items-end justify-between bg-gray-50 p-4 rounded-lg">
                    
                    <!-- Form Filter Tanggal (Tersendiri) -->
                    <form action="{{ route('transaksi.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="border p-2 rounded">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="border p-2 rounded">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
                            <a href="{{ route('transaksi.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                        </div>
                    </form>

                    <!-- Tombol Cetak PDF & Tombol Reset Semua Riwayat (Form Terpisah) -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('transaksi.pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                           target="_blank" 
                           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                            Cetak PDF
                        </a>

                        @if($transaksis->isNotEmpty())
                        <form action="{{ route('transaksi.resetAll') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus SELURUH riwayat transaksi secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow transition">
                                Reset Semua Riwayat
                            </button>
                        </form>
                        @endif
                    </div>

                </div>
            </div>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 border">Tanggal</th>
                        <th class="p-3 border">Barang</th>
                        <th class="p-3 border">Jenis</th>
                        <th class="p-3 border">Jumlah</th>
                        <th class="p-3 border">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($transaksis as $t)
                    <tr class="hover:bg-gray-50 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                        <td class="p-3 border">{{ $t->tanggal }}</td>
                        <td class="p-3 border">{{ $t->barang->nama_barang ?? 'Barang Dihapus' }}</td>
                        <td class="p-3 border">
                            <span class="px-2 py-1 rounded text-sm font-semibold 
                                {{ $t->jenis == 'Masuk' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                {{ $t->jenis }}
                            </span>
                        </td>
                        <td class="p-3 border font-bold">{{ $t->jumlah }}</td>
                        <td class="p-3 border">{{ $t->keterangan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">Data transaksi tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection