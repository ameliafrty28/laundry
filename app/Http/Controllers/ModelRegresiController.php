<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ModelRegresiController extends Controller
{
    public function train()
    {
        $data = DB::table('rekap_harian')->get();

        $X = [];
        $Y = [];

        foreach ($data as $d) {
            $X[] = [
                1, // konstanta
                $d->rekap_total_reguler,
                $d->rekap_total_ekspres,
                $d->rekap_total_satuan,
                $d->rekap_total_berat
            ];

            $Y[] = [$d->rekap_total_pendapatan];
        }

        // ======================
        // MATRIX FUNCTION
        // ======================

        function transpose($m) {
            return array_map(null, ...$m);
        }

        function multiply($a, $b) {
            $result = [];
            for ($i = 0; $i < count($a); $i++) {
                for ($j = 0; $j < count($b[0]); $j++) {
                    $sum = 0;
                    for ($k = 0; $k < count($b); $k++) {
                        $sum += $a[$i][$k] * $b[$k][$j];
                    }
                    $result[$i][$j] = $sum;
                }
            }
            return $result;
        }

        function inverse($m) {
            $n = count($m);
            $identity = [];

            // buat identity matrix
            for ($i = 0; $i < $n; $i++) {
                for ($j = 0; $j < $n; $j++) {
                    $identity[$i][$j] = ($i == $j) ? 1 : 0;
                }
            }

            // Gauss-Jordan
            for ($i = 0; $i < $n; $i++) {
                $factor = $m[$i][$i];
                for ($j = 0; $j < $n; $j++) {
                    $m[$i][$j] /= $factor;
                    $identity[$i][$j] /= $factor;
                }

                for ($k = 0; $k < $n; $k++) {
                    if ($k != $i) {
                        $factor = $m[$k][$i];
                        for ($j = 0; $j < $n; $j++) {
                            $m[$k][$j] -= $factor * $m[$i][$j];
                            $identity[$k][$j] -= $factor * $identity[$i][$j];
                        }
                    }
                }
            }

            return $identity;
        }

        // ======================
        // OLS
        // ======================

        $Xt = transpose($X);
        $XtX = multiply($Xt, $X);
        $XtX_inv = inverse($XtX);
        $XtY = multiply($Xt, $Y);
        $beta = multiply($XtX_inv, $XtY);

        // ======================
        // SIMPAN
        // ======================

        DB::table('model_regresi')->insert([
            'konstanta' => $beta[0][0],
            'b_reguler' => $beta[1][0],
            'b_ekspres' => $beta[2][0],
            'b_satuan'  => $beta[3][0],
            'b_berat'   => $beta[4][0],
            'tanggal_model' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $beta;
    }
}