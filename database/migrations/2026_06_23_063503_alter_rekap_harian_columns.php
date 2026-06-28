<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rekap_harian', function (Blueprint $table) {

            $table->decimal('rekap_reguler_kiloan', 10, 2)
                ->default(0)
                ->change();

            $table->decimal('rekap_ekspres_kiloan', 10, 2)
                ->default(0)
                ->change();

            $table->integer('rekap_reguler_satuan')
                ->default(0)
                ->change();

            $table->integer('rekap_ekspres_satuan')
                ->default(0)
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('rekap_harian', function (Blueprint $table) {

            $table->integer('rekap_reguler_kiloan')
                ->default(0)
                ->change();

            $table->integer('rekap_ekspres_kiloan')
                ->default(0)
                ->change();
        });
    }
};