<header class="bg-white border-b border-slate-200 px-8 py-5 flex items-center justify-between shadow-sm">

    <div>

        <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
            @yield('title','Dashboard')
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Selamat datang kembali 👋
        </p>

    </div>

    <div class="flex items-center gap-5">

        {{-- Profile --}}
        <div class="flex items-center gap-3">

            <div
                class="w-11 h-11 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">

                {{ strtoupper(substr(Auth::user()->name,0,1)) }}

            </div>

            <div>

                <p class="font-semibold text-slate-800">
                    {{ Auth::user()->name }}
                </p>

                <p class="text-xs text-slate-500 capitalize">
                    {{ Auth::user()->role }}
                </p>

            </div>

        </div>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                class="bg-red-500 hover:bg-red-600 transition-all duration-200 text-white px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg">

                Logout

            </button>

        </form>

    </div>

</header>