<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;

    protected $table = 'golongans';

    protected $fillable = [
        'nama_golongan',
    ];

    // Satu Golongan memiliki banyak Kategori
    public function kategoris()
    {
        return $this->hasMany(Kategori::class, 'golongan_id');
    }

    // Satu Golongan memiliki banyak Barang
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'golongan_id');
    }
}