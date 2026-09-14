<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {

            $table->foreignId('golongan_id')
                  ->nullable()
                  ->after('nama_barang')
                  ->constrained('golongans')
                  ->nullOnDelete();

            $table->foreignId('kategori_id')
                  ->nullable()
                  ->after('golongan_id')
                  ->constrained('kategoris')
                  ->nullOnDelete();

            $table->dropColumn('kategori');

        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {

            $table->string('kategori')->nullable();

            $table->dropForeign(['golongan_id']);
            $table->dropForeign(['kategori_id']);

            $table->dropColumn([
                'golongan_id',
                'kategori_id'
            ]);

        });
    }
};