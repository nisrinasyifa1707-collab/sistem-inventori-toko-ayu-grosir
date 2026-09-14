<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'golongan_id',
        'nama_kategori',
    ];

    // Kategori milik satu Golongan
    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id');
    }

    // Kategori dipakai banyak Barang
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}