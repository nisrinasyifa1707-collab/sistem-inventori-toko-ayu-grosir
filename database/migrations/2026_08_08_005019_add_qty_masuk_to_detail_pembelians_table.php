<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_pembelians', function (Blueprint $table) {

            $table->integer('qty_masuk')
                  ->nullable()
                  ->after('jumlah');

            $table->string('keterangan')
                  ->default('Sesuai')
                  ->after('qty_masuk');

        });
    }

    public function down(): void
    {
        Schema::table('detail_pembelians', function (Blueprint $table) {

            $table->dropColumn([
                'qty_masuk',
                'keterangan'
            ]);

        });
    }
};