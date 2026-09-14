<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembelian extends Model
{
    protected $fillable = [
        'no_po',
        'no_faktur',
        'no_invoice',
        'supplier_id',
        'supplier_nama',
        'tanggal_pembelian',
        'tanggal_akhir',
        'tanggal_invoice',
        'total_biaya',
        'status',
        'status_invoice',
    ];

    public function detailPembelians()
    {
        return $this->hasMany(DetailPembelian::class);
    }

    public function details()
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id');
    }
}