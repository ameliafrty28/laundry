<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PrediksiController extends Controller
{
    public function index(Request $request)
    {
        // =====================================
        // INPUT JUMLAH HARI
        // =====================================

        $hari = $request->input('hari', 7);

        // =====================================
        // AMBIL DATA HISTORIS
        // 30 HARI TERAKHIR
        // =====================================

        $historis = DB::table('rekap_harian')
            ->orderByDesc('rekap_tanggal')
            ->limit(30)
            ->get()
            ->reverse()
            ->values();

        if ($historis->count() == 0) {

            return back()->with(
                'error',
                'Data rekap harian belum tersedia'
            );
        }

        // =====================================
        // AMBIL MODEL REGRESI
        // =====================================

        $model = DB::table('model_regresi')
            ->orderByDesc('tanggal_model')
            ->first();

        if (!$model) {

            return back()->with(
                'error',
                'Model regresi belum tersedia'
            );
        }

        // =====================================
        // SIMPAN DATA HISTORIS
        // UNTUK ROLLING FORECAST
        // =====================================

        $rollingData = $historis->map(function ($item) {

            return [

                'reguler_kiloan' =>
                    $item->rekap_reguler_kiloan,

                'ekspres_kiloan' =>
                    $item->rekap_ekspres_kiloan,

                'reguler_satuan' =>
                    $item->rekap_reguler_satuan,

                'ekspres_satuan' =>
                    $item->rekap_ekspres_satuan,

                'pendapatan' =>
                    $item->rekap_total_pendapatan
            ];
        })->toArray();

        // =====================================
        // FORECAST MULTI HARI
        // RECURSIVE FORECASTING
        // =====================================

        $hasilPrediksi = [];

        $totalPrediksi = 0;

        $lastDate = Carbon::parse(
            $historis->last()->rekap_tanggal
        );

        for ($i = 1; $i <= $hari; $i++) {

            // =================================
            // HITUNG RATA-RATA
            // DARI DATA ROLLING TERBARU
            // =================================

            $x1 =
                collect($rollingData)
                ->avg('reguler_kiloan');

            $x2 =
                collect($rollingData)
                ->avg('ekspres_kiloan');

            $x3 =
                collect($rollingData)
                ->avg('reguler_satuan');

            $x4 =
                collect($rollingData)
                ->avg('ekspres_satuan');

            // =================================
            // HITUNG REGRESI
            // =================================

            $forecast =
                $model->konstanta +
                ($model->b_reguler_kiloan * $x1) +
                ($model->b_ekspres_kiloan * $x2) +
                ($model->b_reguler_satuan * $x3) +
                ($model->b_ekspres_satuan * $x4);

            $forecast =
                max(0, $forecast);

            // =================================
            // SIMPAN HASIL FORECAST
            // =================================

            $hasilPrediksi[] = [

                'tanggal' => $lastDate
                    ->copy()
                    ->addDays($i)
                    ->format('d M Y'),

                'prediksi' =>
                    round($forecast, 2)
            ];

            // =================================
            // TOTAL PREDIKSI
            // =================================

            $totalPrediksi += $forecast;

            // =================================
            // UPDATE DATA ROLLING
            // UNTUK HARI BERIKUTNYA
            // =================================

            array_shift($rollingData);

            $rollingData[] = [

                // asumsi pola layanan
                // mengikuti rata-rata terbaru

                'reguler_kiloan' => $x1,

                'ekspres_kiloan' => $x2,

                'reguler_satuan' => $x3,

                'ekspres_satuan' => $x4,

                'pendapatan' => $forecast
            ];
        }

        // =====================================
        // PREDIKSI HARI PERTAMA
        // =====================================

        $prediksiHarian =
            $hasilPrediksi[0]['prediksi'];

        // =====================================
        // EVALUASI MODEL
        // =====================================

        $allData = DB::table('rekap_harian')
            ->orderByDesc('rekap_tanggal')
            ->limit(180)
            ->get();

        $totalErrorKuadrat = 0;

        $totalAPE = 0;

        foreach ($allData as $d) {

            $y_asli =
                $d->rekap_total_pendapatan;

            $y_pred =
                $model->konstanta +
                ($model->b_reguler_kiloan * $d->rekap_reguler_kiloan) +
                ($model->b_ekspres_kiloan * $d->rekap_ekspres_kiloan) +
                ($model->b_reguler_satuan * $d->rekap_reguler_satuan) +
                ($model->b_ekspres_satuan * $d->rekap_ekspres_satuan);

            $error =
                $y_asli - $y_pred;

            $totalErrorKuadrat +=
                pow($error, 2);

            if ($y_asli != 0) {

                $totalAPE +=
                    abs($error / $y_asli);
            }
        }

        // =====================================
        // HITUNG MSE
        // =====================================

        $mse =
            count($allData) > 0
            ? $totalErrorKuadrat / count($allData)
            : 0;

        // =====================================
        // HITUNG RMSE
        // =====================================

        $rmse =
            sqrt($mse);

        // =====================================
        // HITUNG MAPE
        // =====================================

        $mape =
            count($allData) > 0
            ? ($totalAPE / count($allData)) * 100
            : 0;

        // =====================================
        // HITUNG AKURASI
        // =====================================

        $akurasi =
            max(0, 100 - $mape);

        // =====================================
        // STATUS MODEL
        // =====================================

        if ($akurasi >= 90) {

            $statusModel =
                'Sangat Baik';

        } elseif ($akurasi >= 80) {

            $statusModel =
                'Baik';

        } elseif ($akurasi >= 70) {

            $statusModel =
                'Cukup';

        } else {

            $statusModel =
                'Kurang Baik';
        }

        // =====================================
        // DATA GRAFIK
        // =====================================

        $chartData = DB::table('rekap_harian')
            ->orderByDesc('rekap_tanggal')
            ->limit(30)
            ->get()
            ->reverse()
            ->values();

        $tanggalChart = $chartData
            ->pluck('rekap_tanggal')
            ->map(function ($tanggal) {

                return Carbon::parse($tanggal)
                    ->format('d M');
            })
            ->toArray();

        $aktual = $chartData
            ->pluck('rekap_total_pendapatan')
            ->map(fn($v) => (float)$v)
            ->toArray();

        $prediksiChart = $chartData
            ->map(function ($d) use ($model) {

                return
                    $model->konstanta +
                    ($model->b_reguler_kiloan * $d->rekap_reguler_kiloan) +
                    ($model->b_ekspres_kiloan * $d->rekap_ekspres_kiloan) +
                    ($model->b_reguler_satuan * $d->rekap_reguler_satuan) +
                    ($model->b_ekspres_satuan * $d->rekap_ekspres_satuan);

            })
            ->toArray();

        // =====================================
        // RETURN VIEW
        // =====================================

        return view(
            'admin.prediksi.index',
            [

                'hari' => $hari,

                'x1' => $x1,
                'x2' => $x2,
                'x3' => $x3,
                'x4' => $x4,

                'hasilPrediksi' =>
                    $hasilPrediksi,

                'prediksiHarian' =>
                    round($prediksiHarian, 2),

                'prediksiTotal' =>
                    round($totalPrediksi, 2),

                'mse' =>
                    round($mse, 2),

                'rmse' =>
                    round($rmse, 2),

                'mape' =>
                    round($mape, 2),

                'akurasi' =>
                    round($akurasi, 2),

                'statusModel' =>
                    $statusModel,

                'tanggalChart' =>
                    $tanggalChart,

                'aktual' =>
                    $aktual,

                'prediksiChart' =>
                    $prediksiChart
            ]
        );
    }
}