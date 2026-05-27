<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $tanggalAwal =
            request('tanggal_awal');

        $tanggalAkhir =
            request('tanggal_akhir');

        $range =
            request('range');

        $query = DB::table('rekap_harian');

        if ($tanggalAwal && $tanggalAkhir) {

            $query->whereBetween(
                'rekap_tanggal',
                [$tanggalAwal, $tanggalAkhir]
            );
        }

        if ($range) {

            $query->where(
                'rekap_tanggal',
                '>=',
                now()->subDays($range)
            );
        }
        // =========================================
        // TOTAL KPI
        // =========================================

        $totalPendapatan = (clone $query)
            ->sum('rekap_total_pendapatan');

        $totalTransaksi = (clone $query)
            ->sum('rekap_total_transaksi');

        $jumlahData = (clone $query)
            ->count();

        $rataPendapatan = (clone $query)
            ->avg('rekap_total_pendapatan');

        // =========================================
        // DATA TERBARU
        // =========================================

        $latest = (clone $query)
            ->latest('rekap_tanggal')
            ->first();

        // =========================================
        // PREDIKSI BESOK
        // =========================================

        $model = DB::table('model_regresi')
            ->latest('tanggal_model')
            ->first();

        $data7Hari = (clone $query)
            ->latest('rekap_tanggal')
            ->limit(7)
            ->get();

        $x1 = $data7Hari->avg('rekap_reguler_kiloan');
        $x2 = $data7Hari->avg('rekap_ekspres_kiloan');
        $x3 = $data7Hari->avg('rekap_reguler_satuan');
        $x4 = $data7Hari->avg('rekap_ekspres_satuan');

        $prediksiBesok = 0;

        if ($model) {

            $prediksiBesok =
                $model->konstanta +
                ($model->b_reguler_kiloan * $x1) +
                ($model->b_ekspres_kiloan * $x2) +
                ($model->b_reguler_satuan * $x3) +
                ($model->b_ekspres_satuan * $x4);

            $prediksiBesok = max(0, $prediksiBesok);
        }

        // =========================================
        // DATA GRAFIK PENDAPATAN
        // =========================================

        $chartData = (clone $query)
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

        $pendapatanChart = $chartData
            ->pluck('rekap_total_pendapatan')
            ->map(fn($v) => (float)$v)
            ->toArray();

        $transaksiChart = $chartData
            ->pluck('rekap_total_transaksi')
            ->map(fn($v) => (int)$v)
            ->toArray();

        // =========================================
        // KOMPOSISI LAYANAN
        // =========================================

        $regKilo = (clone $query)
            ->sum('rekap_reguler_kiloan');

        $expKilo = (clone $query)
            ->sum('rekap_ekspres_kiloan');

        $regSatuan = (clone $query)
            ->sum('rekap_reguler_satuan');

        $expSatuan = (clone $query)
            ->sum('rekap_ekspres_satuan');

        // =========================================
        // HARI TERAMAI
        // =========================================

        $hariRamai = DB::table('transaksi')
            ->select(
                DB::raw('DAYNAME(transaksi_tanggal) as hari'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('hari')
            ->get();

        $hariLabels = $hariRamai
            ->pluck('hari');

        $hariData = $hariRamai
            ->pluck('total');

        // =========================================
        // EVALUASI MODEL
        // =========================================

        $allData = (clone $query)
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

        $mse =
            count($allData) > 0
            ? $totalErrorKuadrat / count($allData)
            : 0;

        $rmse = sqrt($mse);

        $mape =
            count($allData) > 0
            ? ($totalAPE / count($allData)) * 100
            : 0;

        $akurasi =
            max(0, 100 - $mape);

// =========================================
// DATA HISTORIS TABLE
// =========================================

$rekap = DB::table('rekap_harian')

    // FILTER JIKA TANGGAL DIPILIH
    ->when(

        $tanggalAwal && $tanggalAkhir,

        function ($query) use (
            $tanggalAwal,
            $tanggalAkhir
        ) {

            $query->whereBetween(
                'rekap_tanggal',
                [
                    $tanggalAwal,
                    $tanggalAkhir
                ]
            );
        }
    )

    // URUTKAN DATA TERBARU
    ->orderByDesc('rekap_tanggal')

    // PAGINATION
    ->paginate(10)

    ->withQueryString();


        // =========================================
        // RETURN VIEW
        // =========================================

        return view('admin.dashboard.index', [

            'totalPendapatan' => $totalPendapatan,
            'totalTransaksi' => $totalTransaksi,
            'jumlahData' => $jumlahData,
            'rataPendapatan' => $rataPendapatan,

            'prediksiBesok' => $prediksiBesok,

            'tanggalChart' => $tanggalChart,
            'pendapatanChart' => $pendapatanChart,
            'transaksiChart' => $transaksiChart,

            'regKilo' => $regKilo,
            'expKilo' => $expKilo,
            'regSatuan' => $regSatuan,
            'expSatuan' => $expSatuan,

            'hariLabels' => $hariLabels,
            'hariData' => $hariData,

            'rmse' => round($rmse,2),
            'mape' => round($mape,2),
            'akurasi' => round($akurasi,2),

            'rekap' => $rekap,
            'latest' => $latest
        ]);
    }
}