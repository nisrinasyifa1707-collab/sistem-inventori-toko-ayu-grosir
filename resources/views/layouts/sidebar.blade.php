@php
    $role = auth()->user()->role;
@endphp

<aside class="w-72 shrink-0 bg-gradient-to-b from-indigo-700 via-indigo-800 to-slate-900 text-white flex flex-col justify-between min-h-screen shadow-2xl">

    <div>

        {{-- Logo --}}
        <div class="px-6 py-7 border-b border-white/10">
            <h1 class="text-2xl font-bold tracking-wide">
                🛒 Toko Ayu Grosir
            </h1>

            <p class="text-indigo-200 text-sm mt-1 capitalize">
                {{ $role }}
            </p>
        </div>

        {{-- Navigation --}}
        <nav class="p-5 space-y-2">

            {{-- Dashboard --}}
            @if($role == 'owner' || $role == 'admin')
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('dashboard')
                        ? 'bg-white text-indigo-700 shadow-lg font-semibold'
                        : 'hover:bg-white/10 text-indigo-100' }}">
                    <span class="text-lg">🏠</span>
                    <span>Dashboard</span>
                </a>
            @endif

            {{-- Barang --}}
            @if($role == 'admin' || $role == 'owner')
                <a href="{{ route('barang.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('barang.*')
                        ? 'bg-white text-indigo-700 shadow-lg font-semibold'
                        : 'hover:bg-white/10 text-indigo-100' }}">
                    <span class="text-lg">📦</span>
                    <span>Master Barang</span>
                </a>
            @endif

            {{-- Supplier --}}
            @if($role == 'admin' || $role == 'owner')
                <a href="{{ route('supplier.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('supplier.*')
                        ? 'bg-white text-indigo-700 shadow-lg font-semibold'
                        : 'hover:bg-white/10 text-indigo-100' }}">
                    <span class="text-lg">🚚</span>
                    <span>Master Supplier</span>
                </a>
            @endif

            {{-- Pembelian --}}
            @if($role == 'admin' || $role == 'owner')
                <a href="{{ route('pembelian.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('pembelian.*')
                        ? 'bg-white text-indigo-700 shadow-lg font-semibold'
                        : 'hover:bg-white/10 text-indigo-100' }}">
                    <span class="text-lg">🛒</span>
                    <span>Pembelian</span>
                </a>
            @endif

            {{-- Gudang --}}
            @if($role == 'admin' || $role == 'gudang')
                <a href="{{ route('gudang.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('gudang.*')
                        ? 'bg-white text-indigo-700 shadow-lg font-semibold'
                        : 'hover:bg-white/10 text-indigo-100' }}">
                    <span class="text-lg">🏬</span>
                    <span>Gudang</span>
                </a>
            @endif

            {{-- Invoice --}}
            @if($role == 'admin' || $role == 'owner')
                <a href="{{ route('invoice.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('invoice.*')
                        ? 'bg-white text-indigo-700 shadow-lg font-semibold'
                        : 'hover:bg-white/10 text-indigo-100' }}">
                    <span class="text-lg">🧾</span>
                    <span>Invoice</span>
                </a>
            @endif

            {{-- Kasir --}}
            @if($role == 'admin' || $role == 'kasir')
                <a href="{{ route('kasir.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('kasir.*')
                        ? 'bg-white text-indigo-700 shadow-lg font-semibold'
                        : 'hover:bg-white/10 text-indigo-100' }}">
                    <span class="text-lg">💰</span>
                    <span>Kasir</span>
                </a>
            @endif

            {{-- Packing --}}
            @if($role == 'admin' || $role == 'packing')
                <a href="{{ route('packing.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('packing.*')
                        ? 'bg-white text-indigo-700 shadow-lg font-semibold'
                        : 'hover:bg-white/10 text-indigo-100' }}">
                    <span class="text-lg">📦</span>
                    <span>Packing</span>
                </a>
            @endif

            {{-- Penentuan Harga --}}
            @if($role == 'admin' || $role == 'owner')
                <a href="{{ route('harga.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('harga.*')
                        ? 'bg-white text-indigo-700 shadow-lg font-semibold'
                        : 'hover:bg-white/10 text-indigo-100' }}">
                    <span class="text-lg">💵</span>
                    <span>Penentuan Harga</span>
                </a>
            @endif

            {{-- Laporan --}}
            @if($role == 'admin' || $role == 'owner')
                <a href="{{ route('owner.laporan') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('owner.laporan')
                        ? 'bg-white text-indigo-700 shadow-lg font-semibold'
                        : 'hover:bg-white/10 text-indigo-100' }}">
                    <span class="text-lg">📈</span>
                    <span>Laporan</span>
                </a>
            @endif

        </nav>
    </div>

    {{-- Footer Sidebar --}}
    <div class="border-t border-white/10 p-5">
        <div class="rounded-xl bg-white/10 p-4 text-center">
            <p class="text-sm text-indigo-200">
                Toko Ayu Grosir
            </p>

            <p class="text-xs text-indigo-300 mt-1">
                Version 1.0
            </p>
        </div>
    </div>

</aside>