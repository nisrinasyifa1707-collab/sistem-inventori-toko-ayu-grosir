<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_pembelians', function (Blueprint $table) {

            $table->decimal('harga_beli',15,2)->nullable()->after('qty_masuk');

           $table->integer('markup')->default(0)->after('harga_beli');

            $table->decimal('harga_jual',15,2)->nullable()->after('markup');

        });
    }

    public function down(): void
    {
        Schema::table('detail_pembelians', function (Blueprint $table) {

            $table->dropColumn([
                'harga_beli',
                'markup',
                'harga_jual'
            ]);

        });
    }
};