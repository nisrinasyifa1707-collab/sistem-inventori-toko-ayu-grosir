<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Notifikasi Error Validasi -->
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Terjadi kesalahan!</strong>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Edit Data Barang</h2>
                    <a href="{{ route('barang.index') }}" class="text-sm text-blue-600 hover:underline font-semibold">&larr; Kembali ke Daftar Barang</a>
                </div>

                <form action="{{ route('barang.update', $barang->id) }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Kode Barang -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kode Barang</label>
                        <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" required 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            placeholder="Contoh: BRS-001">
                    </div>

                    <!-- Nama Barang -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            placeholder="Contoh: Beras Ramos Super">
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                        <select name="kategori" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Sembako" {{ old('kategori', $barang->kategori ?? '') == 'Sembako' ? 'selected' : '' }}>Sembako</option>
                            <option value="Rokok" {{ old('kategori', $barang->kategori ?? '') == 'Rokok' ? 'selected' : '' }}>Rokok</option>
                            <option value="Minuman" {{ old('kategori', $barang->kategori ?? '') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Snack" {{ old('kategori', $barang->kategori ?? '') == 'Snack' ? 'selected' : '' }}>Snack</option>
                            <option value="Sabun" {{ old('kategori', $barang->kategori ?? '') == 'Sabun' ? 'selected' : '' }}>Sabun</option>
                            <option value="Kebersihan" {{ old('kategori', $barang->kategori ?? '') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                            <option value="Lainnya" {{ old('kategori', $barang->kategori ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', $barang->stok) }}" required min="0" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Minimal Stok -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Minimal Stok (Peringatan)</label>
                        <input type="number" name="min_stok" value="{{ old('min_stok', $barang->min_stok ?? 10) }}" min="0" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Satuan</label>
                        <input type="text" name="satuan" value="{{ old('satuan', $barang->satuan) }}" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            placeholder="Contoh: KG, Liter, Pcs, Dus">
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                        <input type="number" name="harga" value="{{ old('harga', $barang->harga) }}" required min="0" step="any" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <a href="{{ route('barang.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded-lg text-sm transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg text-sm shadow transition">
                            Update Barang
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>