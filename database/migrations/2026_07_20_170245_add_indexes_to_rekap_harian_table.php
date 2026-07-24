<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rekap_harian', function (Blueprint $table) {

            $table->index('rekap_tanggal', 'idx_rekap_tanggal');

        });
    }

    public function down(): void
    {
        Schema::table('rekap_harian', function (Blueprint $table) {

            $table->dropIndex('idx_rekap_tanggal');

        });
    }
};