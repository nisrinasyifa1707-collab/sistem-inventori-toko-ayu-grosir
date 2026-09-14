<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Toko Ayu Grosir</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 font-sans flex h-screen overflow-hidden">

    <!-- SIDEBAR UTAMA (BERSIH TANPA GUDANG & PACKING) -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between hidden md:flex z-20">
        <div>
            <!-- Header Toko -->
            <div class="p-5 border-b border-gray-200">
                <h1 class="text-xl font-black text-gray-800 tracking-wide">Toko Ayu Grosir</h1>
            </div>

            <!-- Menu Navigasi -->
            <nav class="p-4 flex flex-col gap-1 text-sm">
                <a href="{{ route('kasir.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 font-semibold transition">
                    Dashboard
                </a>

                <div class="py-1">
                    <span class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Master Data</span>
                </div>

                <a href="{{ route('kasir.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 font-semibold transition">
                    Kasir (POS)
                </a>

                <div class="py-1 mt-2">
                    <span class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Transaksi</span>
                </div>
                <!-- Menu Laporan Aktif -->
                <a href="{{ route('kasir.laporan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-blue-50 text-blue-600 font-bold transition">
                    Laporan Penjualan
                </a>
            </nav>
        </div>

        <!-- Footer Sidebar -->
        <div class="p-4 border-t border-gray-200 text-xs text-gray-400">
            Toko Ayu Grosir v1.0
        </div>
    </aside>

    <!-- KONTEN UTAMA DI SEBELAH KANAN -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- TOPBAR ATAS -->
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center shadow-xs z-10">
            <h2 class="text-lg font-bold text-gray-800">Laporan Penjualan</h2>
            <div class="flex items-center gap-4">
                <span class="text-sm font-semibold text-gray-600">Owner Ayu</span>
                <a href="#" class="text-sm font-bold text-red-600 hover:underline">Log Out</a>
            </div>
        </header>

        <!-- AREA KONTEN LAPORAN -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
            
            <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div>
                        <h3 class="text-xl font-black text-gray-800">Laporan Riwayat Penjualan</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Total Omset Periode Ini: <span class="font-bold text-green-600">Rp {{ number_format($totalOmset ?? 0, 0, ',', '.') }}</span></p>
                    </div>
                    
                    <a href="{{ route('kasir.index') }}" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-900 transition">
                        Kembali ke Kasir
                    </a>
                </div>

                <!-- Form Filter Tanggal -->
                <form method="GET" action="{{ route('kasir.laporan') }}" class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6 flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Dari Tanggal</label>
                        <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}" class="border border-gray-300 bg-white p-2 rounded-lg text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Sampai Tanggal</label>
                        <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}" class="border border-gray-300 bg-white p-2 rounded-lg text-xs">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-blue-700 cursor-pointer">Filter</button>
                        <a href="{{ route('kasir.laporan') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-300 flex items-center">Reset</a>
                    </div>
                </form>

                <!-- Tabel Riwayat Penjualan -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-500 text-xs bg-gray-50">
                                <th class="p-3">No Faktur / ID</th>
                                <th class="p-3">Tanggal</th>
                                <th class="p-3">Metode</th>
                                <th class="p-3">Total Harga</th>
                                <th class="p-3">Bayar</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penjualans ?? [] as $p)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="p-3 font-semibold text-blue-600 text-xs">{{ $p->no_faktur }}</td>
                                <td class="p-3 text-xs text-gray-600">{{ $p->created_at }}</td>
                                <td class="p-3 text-xs">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $p->metode_pembayaran == 'QRIS' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $p->metode_pembayaran }}
                                    </span>
                                </td>
                                <td class="p-3 font-bold text-gray-800 text-xs">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td class="p-3 text-xs text-gray-600">Rp {{ number_format($p->bayar, 0, ',', '.') }}</td>
                                <td class="p-3 text-center">
                                    <a href="{{ route('kasir.struk', $p->id) }}" target="_blank" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-700 transition">
                                        Cetak Struk
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-400 text-xs">Belum ada data transaksi penjualan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </main>
    </div>

</body>
</html>