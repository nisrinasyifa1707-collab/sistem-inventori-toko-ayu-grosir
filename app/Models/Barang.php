<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'golongan_id',
        'kategori_id',
        'supplier_id',
        'harga',
        'harga_beli',
        'harga_jual',
        'margin',
        'stok',
        'min_stok',
        'satuan',
        'keterangan',

        // Data Gudang
        'qty_awal',
        'qty_masuk',
        'status_update',
    ];


    // Relasi ke Golongan
    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }


    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }


    // Relasi ke Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}