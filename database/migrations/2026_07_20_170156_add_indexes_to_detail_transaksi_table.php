<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {

            $table->index('transaksi_id', 'idx_detail_transaksi');

            $table->index('layanan_id', 'idx_detail_layanan');

        });
    }

    public function down(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {

            $table->dropIndex('idx_detail_transaksi');

            $table->dropIndex('idx_detail_layanan');

        });
    }
};