<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {

            $table->index('user_id', 'idx_transaksi_user');

            $table->index('pelanggan_id', 'idx_transaksi_pelanggan');

            $table->index('transaksi_tanggal', 'idx_transaksi_tanggal');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {

            $table->dropIndex('idx_transaksi_user');

            $table->dropIndex('idx_transaksi_pelanggan');

            $table->dropIndex('idx_transaksi_tanggal');

        });
    }
};