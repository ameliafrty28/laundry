<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ModelRegresiController extends Controller
{
    public function train()
    {
        $data = DB::table('rekap_harian')->get();

        $n = count($data);

        if ($n == 0) {
            return "Data kosong";
        }

        // ambil variabel
        $X1 = $X2 = $X3 = $X4 = $Y = [];

        foreach ($data as $d) {
            $X1[] = $d->rekap_total_reguler;
            $X2[] = $d->rekap_total_ekspres;
            $X3[] = $d->rekap_total_satuan;
            $X4[] = $d->rekap_total_berat;
            $Y[]  = $d->rekap_total_pendapatan;
        }

        // rata-rata
        $meanY = array_sum($Y) / $n;
        $meanX1 = array_sum($X1) / $n;
        $meanX2 = array_sum($X2) / $n;
        $meanX3 = array_sum($X3) / $n;
        $meanX4 = array_sum($X4) / $n;

        // =========================
        // KOEFISIEN (APPROX METHOD)
        // =========================

        $b1 = $meanY / ($meanX1 ?: 1);
        $b2 = $meanY / ($meanX2 ?: 1);
        $b3 = $meanY / ($meanX3 ?: 1);
        $b4 = $meanY / ($meanX4 ?: 1);

        $b0 = $meanY - (
            ($b1 * $meanX1) +
            ($b2 * $meanX2) +
            ($b3 * $meanX3) +
            ($b4 * $meanX4)
        );

        // =========================
        // SIMPAN KE DATABASE
        // =========================

        DB::table('model_regresi')->insert([
            'konstanta' => $b0,
            'b_reguler' => $b1,
            'b_ekspres' => $b2,
            'b_satuan'  => $b3,
            'b_berat'   => $b4,
            'tanggal_model' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return [
            'konstanta' => $b0,
            'b1' => $b1,
            'b2' => $b2,
            'b3' => $b3,
            'b4' => $b4
        ];
    }
}