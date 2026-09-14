<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';

    protected $fillable = [
        'no_faktur',
        'tanggal',
        'total_harga',
        'metode_pembayaran',
        'bayar',
        'kembalian',
        'status_pembayaran',
        'status_packing',
        'user_id',
    ];

    public function detailPenjualans()
    {
        return $this->hasMany(
            DetailPenjualan::class,
            'penjualan_id'
        );
    }
}