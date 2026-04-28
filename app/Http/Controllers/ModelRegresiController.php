<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ModelRegresiController extends Controller
{
    public function train()
    {
        $data = DB::table('rekap_harian')->get();

        if ($data->count() < 5) {
            return "Data belum cukup untuk training";
        }

        $X = [];
        $Y = [];

        // ======================
        // DETEKSI MULTIKOLINEARITAS
        // ======================
        $isCollinear = true;

        foreach ($data as $d) {
            if ($d->rekap_total_berat != ($d->rekap_total_reguler + $d->rekap_total_ekspres)) {
                $isCollinear = false;
                break;
            }
        }

        // ======================
        // BUILD MATRIX
        // ======================
        foreach ($data as $d) {

            if ($isCollinear) {
                // 🔥 kondisi sekarang (hindari berat)
                $X[] = [
                    1,
                    $d->rekap_total_reguler,
                    $d->rekap_total_ekspres,
                    $d->rekap_total_satuan
                ];
            } else {
                // ✔ kondisi normal (pakai semua variabel)
                $X[] = [
                    1,
                    $d->rekap_total_reguler,
                    $d->rekap_total_ekspres,
                    $d->rekap_total_satuan,
                    $d->rekap_total_berat
                ];
            }

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

            for ($i = 0; $i < $n; $i++) {
                for ($j = 0; $j < $n; $j++) {
                    $identity[$i][$j] = ($i == $j) ? 1 : 0;
                }
            }

            for ($i = 0; $i < $n; $i++) {

                // 🔥 pivoting
                if ($m[$i][$i] == 0) {
                    for ($k = $i + 1; $k < $n; $k++) {
                        if ($m[$k][$i] != 0) {

                            $temp = $m[$i];
                            $m[$i] = $m[$k];
                            $m[$k] = $temp;

                            $temp = $identity[$i];
                            $identity[$i] = $identity[$k];
                            $identity[$k] = $temp;

                            break;
                        }
                    }
                }

                $factor = $m[$i][$i];

                if ($factor == 0) {
                    throw new \Exception("Matrix tidak bisa diinvers (multikolinearitas)");
                }

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

        try {
            $XtX_inv = inverse($XtX);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Model gagal dihitung. Periksa struktur data'
            ]);
        }

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
            'b_berat'   => $isCollinear ? 0 : ($beta[4][0] ?? 0),
            'tanggal_model' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return [
            'status' => 'Model berhasil dibuat',
            'collinear' => $isCollinear,
            'beta' => $beta
        ];
    }
}