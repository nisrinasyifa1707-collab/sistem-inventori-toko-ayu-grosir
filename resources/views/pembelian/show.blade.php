<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Faktur: ') . $pembelian->no_faktur }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                
                <div class="mb-4">
                    <a href="{{ route('pembelian.history') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm">
                        &larr; Kembali ke Riwayat
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6 border-b pb-4">
                    <div>
                        <p class="text-sm text-gray-600">No. Faktur:</p>
                        <p class="font-bold text-lg">{{ $pembelian->no_faktur }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Pembelian:</p>
                        <p class="font-bold text-lg">{{ $pembelian->tanggal_pembelian }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nama Supplier:</p>
                        <p class="font-bold text-lg">{{ $pembelian->supplier_nama }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Biaya:</p>
                        <p class="font-bold text-lg text-green-600">Rp {{ number_format($pembelian->total_biaya, 0, ',', '.') }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-semibold mb-3">Daftar Barang yang Dibeli</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Satuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga Satuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pembelian->details as $index => $detail)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $detail->barang->nama_barang ?? 'Barang Dihapus' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detail->satuan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detail->jumlah }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>