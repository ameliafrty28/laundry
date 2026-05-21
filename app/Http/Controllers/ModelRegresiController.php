<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ModelRegresiController extends Controller
{
    public function train()
    {
        // =====================================
        // AMBIL SELURUH DATA TRAINING
        // =====================================

        $data = DB::table('rekap_harian')
            ->orderBy('rekap_tanggal')
            ->get();

        // =====================================
        // VALIDASI MINIMAL DATA
        // =====================================

        if ($data->count() < 5) {

            return back()->with(
                'error',
                'Minimal data training adalah 5 data'
            );
        }

        // =====================================
        // TOTAL DATA
        // =====================================

        $n = $data->count();

        // =====================================
        // INISIALISASI SIGMA
        // =====================================

        $sumY = 0;

        $sumX1 = 0;
        $sumX2 = 0;
        $sumX3 = 0;
        $sumX4 = 0;

        $sumX1Y = 0;
        $sumX2Y = 0;
        $sumX3Y = 0;
        $sumX4Y = 0;

        $sumX1_2 = 0;
        $sumX2_2 = 0;
        $sumX3_2 = 0;
        $sumX4_2 = 0;

        $sumX1X2 = 0;
        $sumX1X3 = 0;
        $sumX1X4 = 0;

        $sumX2X3 = 0;
        $sumX2X4 = 0;

        $sumX3X4 = 0;

        // =====================================
        // PERHITUNGAN SIGMA
        // =====================================

        foreach ($data as $d) {

            $x1 = (float)
                $d->rekap_reguler_kiloan;

            $x2 = (float)
                $d->rekap_ekspres_kiloan;

            $x3 = (float)
                $d->rekap_reguler_satuan;

            $x4 = (float)
                $d->rekap_ekspres_satuan;

            $y = (float)
                $d->rekap_total_pendapatan;

            // =========================
            // SIGMA DASAR
            // =========================

            $sumY += $y;

            $sumX1 += $x1;
            $sumX2 += $x2;
            $sumX3 += $x3;
            $sumX4 += $x4;

            // =========================
            // SIGMA XiY
            // =========================

            $sumX1Y += $x1 * $y;
            $sumX2Y += $x2 * $y;
            $sumX3Y += $x3 * $y;
            $sumX4Y += $x4 * $y;

            // =========================
            // SIGMA Xi²
            // =========================

            $sumX1_2 += $x1 * $x1;
            $sumX2_2 += $x2 * $x2;
            $sumX3_2 += $x3 * $x3;
            $sumX4_2 += $x4 * $x4;

            // =========================
            // SIGMA XiXj
            // =========================

            $sumX1X2 += $x1 * $x2;
            $sumX1X3 += $x1 * $x3;
            $sumX1X4 += $x1 * $x4;

            $sumX2X3 += $x2 * $x3;
            $sumX2X4 += $x2 * $x4;

            $sumX3X4 += $x3 * $x4;
        }

        // =====================================
        // NORMAL EQUATION MATRIX
        // =====================================

        $A = [

            [$n, $sumX1, $sumX2, $sumX3, $sumX4],

            [
                $sumX1,
                $sumX1_2,
                $sumX1X2,
                $sumX1X3,
                $sumX1X4
            ],

            [
                $sumX2,
                $sumX1X2,
                $sumX2_2,
                $sumX2X3,
                $sumX2X4
            ],

            [
                $sumX3,
                $sumX1X3,
                $sumX2X3,
                $sumX3_2,
                $sumX3X4
            ],

            [
                $sumX4,
                $sumX1X4,
                $sumX2X4,
                $sumX3X4,
                $sumX4_2
            ]
        ];

        // =====================================
        // MATRIX B
        // =====================================

        $B = [

            [$sumY],

            [$sumX1Y],

            [$sumX2Y],

            [$sumX3Y],

            [$sumX4Y]
        ];

        // =====================================
        // ELIMINASI GAUSS
        // =====================================

        function solveGauss($A, $B)
        {
            $n = count($A);

            // =========================
            // GABUNG MATRIX
            // =========================

            for ($i = 0; $i < $n; $i++) {

                $A[$i][] = $B[$i][0];
            }

            // =========================
            // FORWARD ELIMINATION
            // =========================

            for ($i = 0; $i < $n; $i++) {

                // validasi pembagi nol

                if ($A[$i][$i] == 0) {

                    throw new \Exception(
                        'Matrix singular atau tidak dapat diselesaikan'
                    );
                }

                for ($k = $i + 1; $k < $n; $k++) {

                    $factor =
                        $A[$k][$i]
                        / $A[$i][$i];

                    for ($j = $i; $j <= $n; $j++) {

                        $A[$k][$j] -=
                            $factor * $A[$i][$j];
                    }
                }
            }

            // =========================
            // BACK SUBSTITUTION
            // =========================

            $x = array_fill(0, $n, 0);

            for ($i = $n - 1; $i >= 0; $i--) {

                $x[$i] = $A[$i][$n];

                for ($j = $i + 1; $j < $n; $j++) {

                    $x[$i] -=
                        $A[$i][$j]
                        * $x[$j];
                }

                $x[$i] /=
                    $A[$i][$i];
            }

            return $x;
        }

        // =====================================
        // HITUNG KOEFISIEN
        // =====================================

        try {

            $beta =
                solveGauss($A, $B);

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }

        // =====================================
        // SIMPAN MODEL
        // =====================================

        DB::table('model_regresi')->insert([

            'konstanta' =>
                round($beta[0], 2),

            'b_reguler_kiloan' =>
                round($beta[1], 2),

            'b_ekspres_kiloan' =>
                round($beta[2], 2),

            'b_reguler_satuan' =>
                round($beta[3], 2),

            'b_ekspres_satuan' =>
                round($beta[4], 2),

            'tanggal_model' => now(),

            'created_at' => now(),

            'updated_at' => now()
        ]);

        // =====================================
        // RETURN
        // =====================================

        return [

            'status' => 'success',

            'total_data_training' => $n,

            'konstanta' =>
                round($beta[0], 2),

            'b1_reguler_kiloan' =>
                round($beta[1], 2),

            'b2_ekspres_kiloan' =>
                round($beta[2], 2),

            'b3_reguler_satuan' =>
                round($beta[3], 2),

            'b4_ekspres_satuan' =>
                round($beta[4], 2)
        ];
    }
}