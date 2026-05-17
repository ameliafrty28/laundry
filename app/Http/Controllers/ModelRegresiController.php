<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ModelRegresiController extends Controller
{
    public function train()
    {
        $data = DB::table('rekap_harian')->limit(57)->get(); // biar cocok dengan manual

        $n = count($data);

        if ($n < 5) {
            return "Data kurang";
        }

        // ======================
        // HITUNG Σ (SESUAI LAPORAN)
        // ======================

        $sumY = $sumX1 = $sumX2 = $sumX3 = $sumX4 = 0;
        $sumX1Y = $sumX2Y = $sumX3Y = $sumX4Y = 0;
        $sumX1_2 = $sumX2_2 = $sumX3_2 = $sumX4_2 = 0;
        $sumX1X2 = $sumX1X3 = $sumX1X4 = 0;
        $sumX2X3 = $sumX2X4 = $sumX3X4 = 0;

        foreach ($data as $d) {

            $x1 = (float)$d->rekap_reguler_kiloan;
            $x2 = (float)$d->rekap_ekspres_kiloan;
            $x3 = (float)$d->rekap_reguler_satuan;
            $x4 = (float)$d->rekap_ekspres_satuan;
            $y  = (float)$d->rekap_total_pendapatan;

            $sumY += $y;

            $sumX1 += $x1;
            $sumX2 += $x2;
            $sumX3 += $x3;
            $sumX4 += $x4;

            $sumX1Y += $x1 * $y;
            $sumX2Y += $x2 * $y;
            $sumX3Y += $x3 * $y;
            $sumX4Y += $x4 * $y;

            $sumX1_2 += $x1 * $x1;
            $sumX2_2 += $x2 * $x2;
            $sumX3_2 += $x3 * $x3;
            $sumX4_2 += $x4 * $x4;

            $sumX1X2 += $x1 * $x2;
            $sumX1X3 += $x1 * $x3;
            $sumX1X4 += $x1 * $x4;

            $sumX2X3 += $x2 * $x3;
            $sumX2X4 += $x2 * $x4;
            $sumX3X4 += $x3 * $x4;
        }

        // ======================
        // BENTUK PERSAMAAN NORMAL
        // ======================

        $A = [
            [$n, $sumX1, $sumX2, $sumX3, $sumX4],
            [$sumX1, $sumX1_2, $sumX1X2, $sumX1X3, $sumX1X4],
            [$sumX2, $sumX1X2, $sumX2_2, $sumX2X3, $sumX2X4],
            [$sumX3, $sumX1X3, $sumX2X3, $sumX3_2, $sumX3X4],
            [$sumX4, $sumX1X4, $sumX2X4, $sumX3X4, $sumX4_2],
        ];

        $B = [
            [$sumY],
            [$sumX1Y],
            [$sumX2Y],
            [$sumX3Y],
            [$sumX4Y],
        ];

        // ======================
        // ELIMINASI GAUSS
        // ======================

        function solve($A, $B)
        {
            $n = count($A);

            for ($i = 0; $i < $n; $i++) {
                $A[$i][] = $B[$i][0];
            }

            for ($i = 0; $i < $n; $i++) {

                for ($k = $i + 1; $k < $n; $k++) {
                    $factor = $A[$k][$i] / $A[$i][$i];

                    for ($j = $i; $j <= $n; $j++) {
                        $A[$k][$j] -= $factor * $A[$i][$j];
                    }
                }
            }

            $x = array_fill(0, $n, 0);

            for ($i = $n - 1; $i >= 0; $i--) {
                $x[$i] = $A[$i][$n];

                for ($j = $i + 1; $j < $n; $j++) {
                    $x[$i] -= $A[$i][$j] * $x[$j];
                }

                $x[$i] /= $A[$i][$i];
            }

            return $x;
        }

        $beta = solve($A, $B);

        // ======================
        // SIMPAN KE DATABASE
        // ======================

        DB::table('model_regresi')->insert([
            'konstanta' => round($beta[0], 2),
            'b_reguler_kiloan' => round($beta[1], 2),
            'b_ekspres_kiloan' => round($beta[2], 2),
            'b_reguler_satuan' => round($beta[3], 2),
            'b_ekspres_satuan' => round($beta[4], 2),
            'tanggal_model' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ======================
        // OUTPUT
        // ======================

        return [
            'a' => round($beta[0], 2),
            'b1' => round($beta[1], 2),
            'b2' => round($beta[2], 2),
            'b3' => round($beta[3], 2),
            'b4' => round($beta[4], 2),
        ];
    }
}