<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<style>

body{
    font-family: DejaVu Sans;
    font-size:12px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid #000;
    padding:8px;
}

h2{
    margin-bottom:5px;
}

</style>

</head>

<body>

<h2 align="center">
TOKO AYU GROSIR
</h2>

<h3 align="center">
INVOICE PEMBELIAN
</h3>

<hr>

<table border="0" style="border:none">

<tr>

<td style="border:none;">
<b>No Invoice</b><br>
{{ $pembelian->no_invoice }}
</td>

<td style="border:none;">
<b>Tanggal Invoice</b><br>
{{ $pembelian->tanggal_invoice }}
</td>

</tr>

<tr>

<td style="border:none;">
<b>No PO</b><br>
{{ $pembelian->no_faktur }}
</td>

<td style="border:none;">
<b>Supplier</b><br>
{{ $pembelian->supplier_nama }}
</td>

</tr>

</table>

<br>

<table>

<thead>

<tr>

<th>Barang</th>
<th>Qty</th>
<th>Harga</th>
<th>Subtotal</th>

</tr>

</thead>

<tbody>

@foreach($pembelian->detailPembelians as $item)

<tr>

<td>{{ $item->barang->nama_barang }}</td>

<td align="center">
{{ $item->qty_masuk }}
</td>

<td align="right">
Rp {{ number_format($item->harga_satuan,0,',','.') }}
</td>

<td align="right">
Rp {{ number_format($item->subtotal,0,',','.') }}
</td>

</tr>

@endforeach

</tbody>

</table>

<h2 align="right">

Total :
Rp {{ number_format($pembelian->total_biaya,0,',','.') }}

</h2>

<br><br>

<div align="right">

Bandung,
{{ date('d M Y') }}

<br><br><br>

_____________________

</div>

</body>

</html>