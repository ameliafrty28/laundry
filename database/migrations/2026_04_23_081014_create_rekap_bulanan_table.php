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
        Schema::create('rekap_bulanan', function (Blueprint $table) {
            $table->id('rekapbul_id');
            $table->month('rekapbul_bulan');
            $table->year('rekapbul_tahun');
            $table->integer('rekapbul_total_reguler')->default(0);
            $table->integer('rekapbul_total_ekspres')->default(0);
            $table->integer('rekapbul_total_satuan')->default(0);
            $table->decimal('rekapbul_total_berat', 10, 2)->default(0);
            $table->decimal('rekapbul_total_pendapatan', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_bulanan');
    }
};
