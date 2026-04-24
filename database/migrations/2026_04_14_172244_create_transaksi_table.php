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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('transaksi_id');
            // Foreign key ke tabel users
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('restrict');
            // Foreign key ke tabel pelanggan
            $table->unsignedBigInteger('pelanggan_id');
            $table->foreign('pelanggan_id')->references('pelanggan_id')->on('pelanggan')->onDelete('restrict');

            $table->dateTime('transaksi_tanggal');
            $table->decimal('transaksi_total', 10,2); // yang harus d bayarkan
            $table->decimal('transaksi_dibayar', 15, 2)->default(0); // uang masuk
            $table->decimal('transaksi_sisa', 15, 2)->default(0); // sisa pembayaran

            $table->enum('transaksi_status_pembayaran', ['belum_lunas','lunas'])->default('belum_lunas');

            $table->enum('transaksi_metode_pembayaran', ['cash','transfer','qris'])->nullable();

            $table->enum('transaksi_status_pesanan', ['proses','selesai','diambil'])->default('proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
