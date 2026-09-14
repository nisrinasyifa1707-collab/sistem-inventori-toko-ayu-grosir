<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $table = 'detail_pembelians';

    protected $fillable = [
        'pembelian_id',
        'barang_id',
        'satuan',
        'jumlah',
        'qty_masuk',
        'harga_satuan',
        'subtotal',
        'keterangan'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
}