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
            $table->integer('rekap_total_reguler')->default(0);
            $table->integer('rekap_total_ekspres')->default(0);
            $table->integer('rekap_total_satuan')->default(0);
            $table->decimal('rekap_total_berat', 10, 2)->default(0);
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
