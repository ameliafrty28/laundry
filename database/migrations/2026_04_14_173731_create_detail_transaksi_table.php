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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id('detail_id');
            // Foreign key ke tabel transaksi
            $table->unsignedBigInteger('transaksi_id');
            $table->foreign('transaksi_id')->references('transaksi_id')->on('transaksi')->onDelete('restrict');
            // Foreign key ke tabel layanan
            $table->unsignedBigInteger('layanan_id');
            $table->foreign('layanan_id')->references('layanan_id')->on('layanan')->onDelete('restrict');
           
            $table->integer('detail_qty')->nullable(); // jumlah layanan / item
            $table->decimal('detail_berat', 10, 2)->nullable(); // hanya untuk kg
            $table->decimal('detail_subtotal', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
