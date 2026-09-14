<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    // Kolom yang diizinkan untuk diisi (mass assignment)
    protected $fillable = ['barang_id', 'jenis', 'jumlah', 'tanggal', 'keterangan'];

    // Relasi ke model Barang
    // Fungsi ini wajib ada agar kita bisa menampilkan nama barang di Riwayat Transaksi
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}