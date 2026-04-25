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
        Schema::create('model_regresi', function (Blueprint $table) {
            $table->id();

            // 🔥 koefisien regresi
            $table->double('konstanta');      // a / β0
            $table->double('b_reguler');      // β1
            $table->double('b_ekspres');      // β2
            $table->double('b_satuan');       // β3
            $table->double('b_berat');        // β4

            // kapan model dibuat
            $table->date('tanggal_model');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_regresi');
    }
};
