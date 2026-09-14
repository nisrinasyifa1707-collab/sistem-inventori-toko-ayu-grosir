@extends('layouts.app')

@section('content')

{{-- HEADER KASIR --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">

    <div class="flex justify-between">

        <div>

            <h1 class="text-3xl font-bold">
                Kasir Penjualan
            </h1>

            <p class="text-gray-500">
                Melayani transaksi pelanggan
            </p>

        </div>

        <div class="text-right">

            <p class="text-sm text-gray-500">
                Tanggal Transaksi
            </p>

            <h2 class="font-bold">
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
            </h2>

            <p>
                {{ now()->format('H:i') }} WIB
            </p>

            <p class="mt-2">
                Kasir :
                <b>{{ Auth::user()->name }}</b>
            </p>

        </div>

    </div>

</div>

{{-- KONTEN --}}
<div class="grid grid-cols-3 gap-6">

    {{-- KIRI --}}
    <div class="col-span-2">

        {{-- SEARCH --}}
        <div class="bg-white rounded-xl shadow p-4 mb-4">

            <form method="GET" action="{{ route('kasir.index') }}">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Cari kode atau nama barang..."
        class="w-full border rounded-lg p-3"
        onkeydown="if(event.key==='Enter'){this.form.submit();}">
</form>

        </div>

        {{-- DAFTAR BARANG --}}
        <div class="grid md:grid-cols-3 gap-4">

            @foreach($barangs as $barang)

            <div class="bg-white rounded-xl shadow p-4">

                <h2 class="font-bold">

                    {{ $barang->nama_barang }}

                </h2>

                <p class="text-sm text-gray-500">

                    {{ $barang->kode_barang }}

                </p>

                <p class="text-blue-600 font-bold mt-3">

                  Rp {{ number_format($barang->harga_jual ?? 0, 0, ',', '.') }}

                </p>

                <p class="text-sm">

                    Stok :

                    {{ $barang->stok }}

                </p>

                <button
                    onclick="tambahKeKeranjang(
    {{ $barang->id }},
    '{{ addslashes($barang->nama_barang) }}',
    {{ $barang->harga_jual ?? 0 }},
    {{ $barang->stok }}
)"
                    class="mt-4 w-full bg-blue-600 text-white rounded-lg py-2">

                    Tambah

                </button>

            </div>

            @endforeach

        </div>

    </div>

    {{-- KANAN --}}
    <div>

        <div class="bg-white rounded-xl shadow p-5">

            <h2 class="font-bold text-xl">

                Keranjang

            </h2>

            <hr class="my-4">

            <div id="cartList">

                Belum ada barang

            </div>

            <hr class="my-4">

            <div class="flex justify-between">

                <span>Total</span>

                <span id="grandTotal">

                    Rp 0

                </span>

            </div>

         <div class="mt-5">

    <label>
        Metode Pembayaran
    </label>

    <select
        id="metode"
        class="w-full border rounded-lg p-3 mt-2">

        <option value="Cash">
            Cash
        </option>

        <option value="QRIS">
            QRIS
        </option>

    </select>

    <div id="qrSection" class="hidden mt-4 text-center">

        <img
            src="{{ asset('images/qr-dummy.png') }}"
            alt="QRIS"
            class="mx-auto w-56 rounded-lg border shadow">

        <p class="text-sm text-gray-500 mt-2">
            Scan QRIS untuk melakukan pembayaran
        </p>

    </div>

</div>
<div id="cashSection" class="mt-4">
<label>
    Bayar
</label>

<input
    type="number"
    id="bayar"
    placeholder="Masukkan nominal bayar"
    class="w-full border rounded-lg p-3">
    </div>
            <div id="kembalianSection" class="mt-4">
    <label>
        Kembalian
    </label>

                <input
                    id="kembalian"
                    readonly
                    class="w-full bg-gray-100 rounded-lg p-3">

            </div>

            <button
                id="btnBayar"
                class="mt-6 w-full bg-green-600 text-white rounded-lg p-3 font-bold">

                BAYAR

            </button>

        </div>

    </div>

</div>
<script>
let cart = [];

const metode = document.getElementById("metode");
const qrSection = document.getElementById("qrSection");
const cashSection = document.getElementById("cashSection");
const kembalianSection = document.getElementById("kembalianSection");

function toggleMetode(){

    if(metode.value=="QRIS"){

        qrSection.classList.remove("hidden");
        cashSection.classList.add("hidden");
        kembalianSection.classList.add("hidden");

    }else{

        qrSection.classList.add("hidden");
        cashSection.classList.remove("hidden");
        kembalianSection.classList.remove("hidden");

    }

}

metode.addEventListener("change",toggleMetode);
toggleMetode();

function tambahKeKeranjang(id,nama,harga,stok){

    let item = cart.find(x=>x.id==id);

    if(item){

        if(item.jumlah>=stok){

            alert("Stok tidak mencukupi");
            return;

        }

        item.jumlah++;

    }else{

        cart.push({
            id:id,
            nama:nama,
            harga:harga,
            stok:stok,
            jumlah:1
        });

    }

    renderCart();

}

function tambah(index){

    if(cart[index].jumlah>=cart[index].stok){

        alert("Stok habis");
        return;

    }

    cart[index].jumlah++;
    renderCart();

}

function kurang(index){

    cart[index].jumlah--;

    if(cart[index].jumlah<=0){

        cart.splice(index,1);

    }

    renderCart();

}

function renderCart(){

    let html="";
    let total=0;

    cart.forEach((item,index)=>{

        const subtotal=item.harga*item.jumlah;
        total+=subtotal;

        html+=`
        <div class="border-b py-3">

            <b>${item.nama}</b>

            <div class="flex justify-between items-center mt-2">

                <button onclick="kurang(${index})"
                class="px-2 bg-gray-200 rounded">-</button>

                <span>${item.jumlah}</span>

                <button onclick="tambah(${index})"
                class="px-2 bg-gray-200 rounded">+</button>

            </div>

            <div class="mt-2 font-semibold">

                Rp ${subtotal.toLocaleString('id-ID')}

            </div>

        </div>
        `;

    });

    if(cart.length==0){

        html="Belum ada barang";

    }

    document.getElementById("cartList").innerHTML=html;
    document.getElementById("grandTotal").innerHTML="Rp "+total.toLocaleString("id-ID");

    hitungKembalian();

}

document.getElementById("bayar").addEventListener("keyup",hitungKembalian);

function hitungKembalian(){

    let total=0;

    cart.forEach(item=>{

        total+=item.harga*item.jumlah;

    });

    const bayar=parseInt(document.getElementById("bayar").value)||0;

    document.getElementById("kembalian").value=(bayar-total).toLocaleString("id-ID");

}

document.getElementById("btnBayar").addEventListener("click",function(){

    if(cart.length===0){

        alert("Keranjang kosong");
        return;

    }

    let total=0;

    cart.forEach(item=>{

        total+=item.harga*item.jumlah;

    });

    fetch("{{ route('kasir.store') }}",{

        method:"POST",

        headers:{
            "Content-Type":"application/json",
            "Accept":"application/json",
            "X-CSRF-TOKEN":"{{ csrf_token() }}"
        },

        body:JSON.stringify({

            metode_pembayaran:metode.value,
            bayar:parseInt(document.getElementById("bayar").value)||0,
            total_harga:total,
            items:cart

        })

    })

    .then(async response=>{

        const data=await response.json();

        if(!response.ok){

            throw data;

        }

        return data;

    })

    .then(data=>{

        window.location.href="/kasir/struk/"+data.penjualan_id;

    })

    .catch(err=>{

        console.log(err);

        alert(err.message??"Terjadi kesalahan");

    });

});
</script>
@endsection