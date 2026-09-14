<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-700 mb-6">Tambah Transaksi Barang</h2>
                
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    <!-- Pilih Barang -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Pilih Barang</label>
                        <select name="barang_id" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach(\App\Models\Barang::all() as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jenis Transaksi -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Jenis Transaksi</label>
                        <select name="jenis" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required>
                            <option value="Masuk">Barang Masuk</option>
                            <option value="Keluar">Barang Keluar</option>
                        </select>
                    </div>

                    <!-- Jumlah -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                        <input type="number" name="jumlah" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required>
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <textarea name="keterangan" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm"></textarea>
                    </div>

                    <!-- Tombol Simpan (Hanya satu) -->
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Simpan Transaksi
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>