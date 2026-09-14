<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'nama_supplier',
        'alamat',
        'telepon'
    ];

    /**
     * Satu supplier dapat menyediakan banyak barang
     */
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'supplier_id');
    }
}