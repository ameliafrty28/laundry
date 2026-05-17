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
        Schema::create('rekap_harian', function (Blueprint $table) {
            $table->id('rekap_id');
            $table->date('rekap_tanggal');

            // 🔥 4 VARIABEL UNTUK REGRESI
            $table->integer('rekap_reguler_kiloan')->default(0);
            $table->integer('rekap_ekspres_kiloan')->default(0);
            $table->integer('rekap_reguler_satuan')->default(0);
            $table->integer('rekap_ekspres_satuan')->default(0);

            // total transaksi
            $table->integer('rekap_total_transaksi')->default(0);

            // pendapatan
            $table->decimal('rekap_total_pendapatan', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_harian');
    }
};
