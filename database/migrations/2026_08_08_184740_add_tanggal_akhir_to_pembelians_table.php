<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembelians', function (Blueprint $table) {

            $table->date('tanggal_akhir')->nullable()->after('tanggal_pembelian');

        });
    }

    public function down(): void
    {
        Schema::table('pembelians', function (Blueprint $table) {

            $table->dropColumn('tanggal_akhir');

        });
    }
};