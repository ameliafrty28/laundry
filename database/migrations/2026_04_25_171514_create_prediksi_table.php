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
        Schema::create('prediksi', function (Blueprint $table) {
            $table->id();

            // 🔥 tanggal prediksi
            $table->date('tanggal');

            // variabel X (opsional tapi disarankan)
            $table->integer('reguler');
            $table->integer('ekspres');
            $table->integer('satuan');
            $table->decimal('berat', 10, 2);

            // hasil prediksi
            $table->double('prediksi_pendapatan');

            // data aktual (untuk evaluasi)
            $table->double('aktual')->nullable();

            // error
            $table->double('mape')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediksi');
    }
};
