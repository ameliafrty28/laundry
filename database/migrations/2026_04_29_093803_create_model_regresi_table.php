<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_regresi', function (Blueprint $table) {
            $table->id();

            // konstanta (β0)
            $table->double('konstanta');

            // koefisien regresi (β1 - β4)
            $table->double('b_reguler_kiloan');
            $table->double('b_ekspres_kiloan');
            $table->double('b_reguler_satuan');
            $table->double('b_ekspres_satuan');

            // tanggal model dibuat
            $table->date('tanggal_model');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_regresi');
    }
};