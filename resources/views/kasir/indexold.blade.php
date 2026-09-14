<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Ayu Grosir - POS & Inventory</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 font-sans flex h-screen overflow-hidden">

    <!-- SIDEBAR SESUAI GAMBAR YANG DIMINTA -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between hidden md:flex z-20 shrink-0">
        <div>
            <!-- Header Toko -->
            <div class="p-5 border-b border-gray-200">
                <h1 class="text-xl font-black text-gray-800 tracking-wide">Toko Ayu Grosir</h1>
            </div>

            <!-- Menu Navigasi -->
            <nav class="p-4 flex flex-col gap-1 text-sm overflow-y-auto max-h-[calc(100vh-120px)]">
                
                <!-- Dashboard -->
                <a href="#" onclick="gantiHalaman('dashboard')" id="menu-dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 font-semibold transition">
                    Dashboard
                </a>

                <!-- Kasir / Penjualan -->
                <a href="#" onclick="gantiHalaman('kasir')" id="menu-kasir" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-blue-50 text-blue-600 font-bold transition">
                    Kasir / Penjualan
                </a>

                <!-- DROPDOWN MASTER DATA -->
                <div class="flex flex-col">
                    <button onclick="toggleDropdown('submenu-master', 'arrow-master')" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 font-semibold transition w-full cursor-pointer">
                        <span>Master Data</span>
                        <svg id="arrow-master" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="submenu-master" class="hidden flex flex-col gap-1 pl-4 pt-1">
                        <a href="#" onclick="gantiHalaman('daftar-barang')" id="menu-daftar-barang" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-100 font-medium transition text-xs">
                            Daftar Barang
                        </a>
                    </div>
                </div>

                <!-- DROPDOWN PEMBELIAN -->
                <div class="flex flex-col">
                    <button onclick="toggleDropdown('submenu-pembelian', 'arrow-pembelian')" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 font-semibold transition w-full cursor-pointer">
                        <span>Pembelian</span>
                        <svg id="arrow-pembelian" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="submenu-pembelian" class="hidden flex flex-col gap-1 pl-4 pt-1">
                        <a href="#" onclick="gantiHalaman('riwayat-transaksi')" id="menu-riwayat-transaksi" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-100 font-medium transition text-xs">Riwayat Transaksi</a>
                        <a href="#" onclick="gantiHalaman('pembelian-supplier')" id="menu-pembelian-supplier" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-100 font-medium transition text-xs">Pembelian Supplier</a>
                    </div>
                </div>

                <!-- DROPDOWN GUDANG -->
                <div class="flex flex-col">
                    <button onclick="toggleDropdown('submenu-gudang', 'arrow-gudang')" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 font-semibold transition w-full cursor-pointer">
                        <span>Gudang</span>
                        <svg id="arrow-gudang" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="submenu-gudang" class="hidden flex flex-col gap-1 pl-4 pt-1">
                        <a href="#" onclick="gantiHalaman('stok-gudang')" id="menu-stok-gudang" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-100 font-medium transition text-xs">Stok Gudang</a>
                    </div>
                </div>

                <!-- Packing -->
                <a href="#" onclick="gantiHalaman('packing')" id="menu-packing" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 font-semibold transition">
                    Packing
                </a>

            </nav>
        </div>

        <div class="p-4 border-t border-gray-200 text-xs text-gray-400">
            Toko Ayu Grosir v1.0
        </div>
    </aside>

    <!-- KONTEN UTAMA DI SEBELAH KANAN -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- TOPBAR ATAS -->
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center shadow-xs z-10">
            <h2 id="judul-halaman" class="text-lg font-bold text-gray-800">Kasir POS</h2>
            <div class="flex items-center gap-4">
                <span class="text-sm font-semibold text-gray-600">Owner Ayu</span>
                <a href="#" class="text-sm font-bold text-red-600 hover:underline">Log Out</a>
            </div>
        </header>

        <!-- AREA KONTEN DINAMIS -->
        <main class="flex-1 overflow-y-auto bg-gray-50">
            
            <!-- 1. DASHBOARD -->
            <div id="page-dashboard" class="page-content hidden p-6">
                <h1 class="text-2xl font-black text-gray-800 mb-4">Dashboard</h1>
                <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200">
                    <p class="text-gray-600 text-sm">Selamat datang di panel Dashboard Toko Ayu Grosir.</p>
                </div>
            </div>

            <!-- 2. KASIR / PENJUALAN (DEFAULT) -->
            <div id="page-kasir" class="page-content flex flex-col md:flex-row gap-4 p-4 h-full">
                <div class="flex-1 bg-white p-4 rounded-xl shadow-xs border border-gray-200 flex flex-col">
                    <div class="flex justify-between items-center mb-4 border-b pb-3">
                        <h3 class="text-lg font-black text-gray-800">Daftar Barang & Produk</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 overflow-y-auto max-h-[500px] p-1 pb-10">
                        @foreach($barangs as $barang)
                        <div class="border border-gray-200 p-3 pb-4 min-h-[140px] rounded-lg shadow-xs flex flex-col justify-between bg-white relative">
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm">{{ $barang->nama_barang }}</h4>
                                <p class="text-xs text-gray-500">Stok: {{ $barang->stok }}</p>
                                <p class="text-blue-600 font-black text-sm mt-1">Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                            </div>
                            <div class="mt-auto pt-2 border-t border-gray-100">
                                <button onclick="tambahKeKeranjang({{ $barang->id }}, '{{ addslashes($barang->nama_barang) }}', {{ $barang->harga }}, {{ $barang->stok }})" 
                                        class="bg-green-500 text-white text-xs py-2 px-2 rounded hover:bg-green-600 w-full font-bold cursor-pointer text-center">
                                    + Beli
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- KERANJANG -->
                <div class="w-full md:w-96 bg-white p-4 rounded-xl shadow-xs border border-gray-200 flex flex-col justify-between">
                    <div>
                        <h3 class="text-base font-bold mb-3 text-gray-800 border-b pb-2">Keranjang Belanja</h3>
                        <div class="overflow-y-auto max-h-[220px] border-b border-gray-200 mb-4 pr-1">
                            <table class="w-full text-left text-sm">
                                <tbody id="tabel-keranjang">
                                    <tr><td colspan="3" class="text-center py-4 text-gray-400">Keranjang kosong</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-3 text-base font-bold bg-gray-50 p-3 rounded-lg border">
                            <span>Total:</span>
                            <span id="grand-total" class="text-blue-600 text-lg">Rp 0</span>
                        </div>
                        <button onclick="alert('Transaksi Berhasil!')" class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-bold hover:bg-blue-700 cursor-pointer text-sm">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- 3. DAFTAR BARANG -->
            <div id="page-daftar-barang" class="page-content hidden p-6">
                <h1 class="text-2xl font-black text-gray-800 mb-4">Master Data - Daftar Barang</h1>
                <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200">
                    <p class="text-gray-600 text-sm">Kelola daftar barang di sini.</p>
                </div>
            </div>

            <!-- 4. PEMBELIAN SUPPLIER (FORM TAMBAH TRANSAKSI) -->
            <div id="page-pembelian-supplier" class="page-content hidden p-6">
                <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200 max-w-2xl mx-auto">
                    <h3 class="text-lg font-bold mb-4 text-gray-800 border-b pb-2">Tambah Transaksi Barang</h3>
                    <form>
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Pilih Barang</label>
                            <select class="w-full border p-2 rounded-lg text-sm bg-white">
                                <option>-- Pilih Barang --</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Jenis Transaksi</label>
                            <select class="w-full border p-2 rounded-lg text-sm bg-white">
                                <option>Barang Masuk</option>
                                <option>Barang Keluar</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Jumlah</label>
                            <input type="number" class="w-full border p-2 rounded-lg text-sm" placeholder="Jumlah barang...">
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal</label>
                            <input type="date" class="w-full border p-2 rounded-lg text-sm" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Keterangan</label>
                            <textarea class="w-full border p-2 rounded-lg text-sm" rows="3" placeholder="Keterangan tambahan..."></textarea>
                        </div>
                        <button type="button" onclick="alert('Transaksi berhasil disimpan!')" class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-bold hover:bg-blue-700 cursor-pointer">
                            Simpan Transaksi
                        </button>
                    </form>
                </div>
            </div>

            <!-- 5. RIWAYAT TRANSAKSI -->
            <div id="page-riwayat-transaksi" class="page-content hidden p-6">
                <h1 class="text-2xl font-black text-gray-800 mb-4">Riwayat Transaksi</h1>
                <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200">
                    <p class="text-gray-600 text-sm">Daftar riwayat transaksi barang masuk/keluar.</p>
                </div>
            </div>

            <!-- 6. STOK GUDANG -->
            <div id="page-stok-gudang" class="page-content hidden p-6">
                <h1 class="text-2xl font-black text-gray-800 mb-4">Stok Gudang</h1>
                <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200">
                    <p class="text-gray-600 text-sm">Informasi stok gudang terkini.</p>
                </div>
            </div>

            <!-- 7. PACKING -->
            <div id="page-packing" class="page-content hidden p-6">
                <h1 class="text-2xl font-black text-gray-800 mb-4">Packing</h1>
                <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200">
                    <p class="text-gray-600 text-sm">Halaman manajemen packing barang.</p>
                </div>
            </div>

        </main>
    </div>

    <script>

let keranjang = [];

function tambahKeKeranjang(id, nama, harga, stok){

    let item = keranjang.find(x => x.id == id);

    if(item){

        if(item.jumlah >= stok){

            alert("Stok tidak mencukupi");
            return;

        }

        item.jumlah++;

    }else{

        keranjang.push({

            id:id,
            nama:nama,
            harga:harga,
            stok:stok,
            jumlah:1

        });

    }

    renderKeranjang();

}

function renderKeranjang(){

    let html = "";
    let total = 0;

    if(keranjang.length==0){

        html = `
            <p class="text-center text-gray-400">
                Belum ada barang
            </p>
        `;

    }else{

        keranjang.forEach((item,index)=>{

            let subtotal = item.harga * item.jumlah;

            total += subtotal;

            html += `

            <div class="border-b py-2 flex justify-between">

                <div>

                    <div class="font-semibold">
                        ${item.nama}
                    </div>

                    <div class="text-sm text-gray-500">

                        ${item.jumlah} x Rp ${item.harga.toLocaleString('id-ID')}

                    </div>

                </div>

                <div class="font-bold">

                    Rp ${subtotal.toLocaleString('id-ID')}

                </div>

            </div>

            `;

        });

    }

    document.getElementById("cartList").innerHTML = html;

    document.getElementById("grandTotal").innerHTML =
        "Rp " + total.toLocaleString("id-ID");

}

</script>
        function gantiHalaman(halaman) {
            $('.page-content').addClass('hidden');
            $('#page-' + halaman).removeClass('hidden');

            // Atur warna aktif menu sidebar
            $('nav a').removeClass('bg-blue-50 text-blue-600 font-bold').addClass('text-gray-700 hover:bg-gray-100');
            $('#menu-' + halaman).addClass('bg-blue-50 text-blue-600 font-bold').removeClass('text-gray-700 hover:bg-gray-100');

            // Ubah Judul Topbar
            let judul = {
                'dashboard': 'Dashboard',
                'kasir': 'Kasir POS',
                'daftar-barang': 'Daftar Barang',
                'riwayat-transaksi': 'Riwayat Transaksi',
                'pembelian-supplier': 'Pembelian Supplier',
                'stok-gudang': 'Stok Gudang',
                'packing': 'Packing'
            };
            $('#judul-halaman').text(judul[halaman] || 'Toko Ayu Grosir');
        }

        function tambahKeKeranjang(id, nama, harga, stok) {
            let item = keranjang.find(i => i.id === id);
            if (item) {
                if (item.jumlah + 1 > stok) { alert('Stok tidak cukup!'); return; }
                item.jumlah++;
            } else {
                keranjang.push({ id, nama, harga, jumlah: 1, stok });
            }
            renderKeranjang();
        }

        function renderKeranjang() {
            let tbody = $('#tabel-keranjang');
            tbody.empty();
            let total = 0;
            if (keranjang.length === 0) {
                tbody.html(`<tr><td colspan="3" class="text-center py-4 text-gray-400">Keranjang kosong</td></tr>`);
                $('#grand-total').text('Rp 0');
                return;
            }
            keranjang.forEach((item) => {
                let subtotal = item.harga * item.jumlah;
                total += subtotal;
                tbody.append(`
                    <tr class="border-b border-gray-100 text-sm">
                        <td class="py-2"><span class="font-bold text-gray-800 block">${item.nama}</span><span class="text-xs text-gray-500">Rp ${item.harga.toLocaleString('id-ID')} x ${item.jumlah}</span></td>
                        <td class="py-2 font-bold text-gray-700 text-right">Rp ${subtotal.toLocaleString('id-ID')}</td>
                    </tr>
                `);
            });
            $('#grand-total').text('Rp ' + total.toLocaleString('id-ID'));
        }
    </script>
</body>
</html>