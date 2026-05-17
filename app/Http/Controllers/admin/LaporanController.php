<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // ========================
        // FILTER TANGGAL
        // ========================

        $start = $request->start_date;
        $end = $request->end_date;

        // ========================
        // QUERY DATA
        // ========================

        if ($start && $end) {

            // FILTER AKTIF
            $data = DB::table('rekap_harian')
                ->whereDate('rekap_tanggal', '>=', $start)
                ->whereDate('rekap_tanggal', '<=', $end)
                ->orderBy('rekap_tanggal')
                ->get();

        } else {

            // DEFAULT = SEMUA DATA
            $data = DB::table('rekap_harian')
                ->orderBy('rekap_tanggal')
                ->get();
        }

        // ========================
        // VALIDASI DATA
        // ========================

        if ($data->count() == 0) {

            return back()->with('error', 'Data kosong');
        }

        // ========================
        // FORMAT DATA
        // ========================

        $tanggal = $data->pluck('rekap_tanggal')
            ->map(fn($d) => Carbon::parse($d)->format('d M'))
            ->toArray();

        $pendapatan = $data->pluck('rekap_total_pendapatan')
            ->map(fn($v) => (float)$v)
            ->toArray();

        $totalTransaksi = $data->pluck('rekap_total_transaksi')
            ->map(fn($v) => (int)$v)
            ->toArray();

        $regulerKiloan = $data->pluck('rekap_reguler_kiloan')
            ->map(fn($v) => (int)$v)
            ->toArray();

        $ekspresKiloan = $data->pluck('rekap_ekspres_kiloan')
            ->map(fn($v) => (int)$v)
            ->toArray();

        $regulerSatuan = $data->pluck('rekap_reguler_satuan')
            ->map(fn($v) => (int)$v)
            ->toArray();

        $ekspresSatuan = $data->pluck('rekap_ekspres_satuan')
            ->map(fn($v) => (int)$v)
            ->toArray();

        // ========================
        // SUMMARY
        // ========================

        $sumPendapatan = array_sum($pendapatan);
        $sumTransaksi = array_sum($totalTransaksi);

        $sumRegulerKiloan = array_sum($regulerKiloan);
        $sumEkspresKiloan = array_sum($ekspresKiloan);

        $sumRegulerSatuan = array_sum($regulerSatuan);
        $sumEkspresSatuan = array_sum($ekspresSatuan);

        // ========================
        // RATA-RATA
        // ========================

        $rataPendapatan = count($pendapatan) > 0
            ? array_sum($pendapatan) / count($pendapatan)
            : 0;

        $rataTransaksi = count($totalTransaksi) > 0
            ? array_sum($totalTransaksi) / count($totalTransaksi)
            : 0;

        // ========================
        // MOVING AVERAGE 7 HARI
        // ========================

        $ma7 = [];

        for ($i = 0; $i < count($pendapatan); $i++) {

            if ($i < 6) {

                $ma7[] = null;

            } else {

                $ma7[] =
                    array_sum(array_slice($pendapatan, $i - 6, 7)) / 7;
            }
        }

        // ========================
        // MODEL REGRESI
        // ========================

        $model = DB::table('model_regresi')
            ->orderByDesc('tanggal_model')
            ->first();

        $prediksi = [];
        $error = [];

        if ($model) {

            foreach ($data as $d) {

                $y_pred =
                    $model->konstanta +
                    ($model->b_reguler_kiloan * $d->rekap_reguler_kiloan) +
                    ($model->b_ekspres_kiloan * $d->rekap_ekspres_kiloan) +
                    ($model->b_reguler_satuan * $d->rekap_reguler_satuan) +
                    ($model->b_ekspres_satuan * $d->rekap_ekspres_satuan);

                $prediksi[] = (float)$y_pred;

                $error[] =
                    $d->rekap_total_pendapatan - $y_pred;
            }
        }

        // ========================
        // PERTUMBUHAN PENDAPATAN
        // ========================

        $growthPendapatan = [];

        for ($i = 0; $i < count($pendapatan); $i++) {

            if ($i == 0) {

                $growthPendapatan[] = 0;

            } else {

                $prev = $pendapatan[$i - 1];
                $curr = $pendapatan[$i];

                if ($prev != 0) {

                    $growth =
                        (($curr - $prev) / $prev) * 100;

                    $growthPendapatan[] =
                        round($growth, 2);

                } else {

                    $growthPendapatan[] = 0;
                }
            }
        }

        // ========================
// HARI TERAMAI
// ========================

$hariMap = [

    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];

$hariRamai = [

    'Senin' => 0,
    'Selasa' => 0,
    'Rabu' => 0,
    'Kamis' => 0,
    'Jumat' => 0,
    'Sabtu' => 0,
    'Minggu' => 0
];

foreach ($data as $d) {

    $hari =
        Carbon::parse($d->rekap_tanggal)
            ->format('l');

    $hariIndonesia =
        $hariMap[$hari] ?? null;

    if ($hariIndonesia) {

        $hariRamai[$hariIndonesia] +=
            $d->rekap_total_transaksi;
    }
}

// ========================
// FORMAT CHART HARI
// ========================

$hariLabels = array_keys($hariRamai);

$hariValues = array_values($hariRamai);


// ========================
// HARI PALING RAMAI
// ========================

$maxHari = max($hariRamai);

$namaHariTeramai =
    array_search($maxHari, $hariRamai);


// ========================
// MAPE & AKURASI
// ========================

$totalPersenError = 0;

$totalDataError = 0;

foreach ($data as $index => $d) {

    $y_asli =
        $d->rekap_total_pendapatan;

    $y_pred =
        $prediksi[$index] ?? 0;

    if ($y_asli != 0) {

        $persenError =
            abs(
                ($y_asli - $y_pred)
                / $y_asli
            );

        $totalPersenError +=
            $persenError;

        $totalDataError++;
    }
}

$mape = $totalDataError > 0
    ? ($totalPersenError / $totalDataError) * 100
    : 0;

$akurasi = 100 - $mape;


// ========================
// STATUS MODEL
// ========================

$statusModel = 'Buruk';

if ($mape < 10) {

    $statusModel = 'Sangat Baik';

} elseif ($mape < 20) {

    $statusModel = 'Baik';

} elseif ($mape < 50) {

    $statusModel = 'Cukup';
}


// ========================
// PENDAPATAN TERTINGGI
// ========================

$pendapatanTertinggi =
    max($pendapatan);

$indexPendapatanTertinggi =
    array_search(
        $pendapatanTertinggi,
        $pendapatan
    );

$tanggalPendapatanTertinggi =
    $tanggal[
        $indexPendapatanTertinggi
    ] ?? '-';


// ========================
// GROWTH TERTINGGI
// ========================

$growthTertinggi =
    count($growthPendapatan) > 0
    ? max($growthPendapatan)
    : 0;
        // ========================
        // RETURN VIEW
        // ========================

        return view('admin.laporan.index', compact(

    'start',
    'end',

    'tanggal',
    'pendapatan',
    'totalTransaksi',

    'regulerKiloan',
    'ekspresKiloan',

    'regulerSatuan',
    'ekspresSatuan',

    'sumPendapatan',
    'sumTransaksi',

    'sumRegulerKiloan',
    'sumEkspresKiloan',

    'sumRegulerSatuan',
    'sumEkspresSatuan',

    'rataPendapatan',
    'rataTransaksi',

    'ma7',

    'prediksi',
    'error',

    'growthPendapatan',

    'hariRamai',
    'hariLabels',
    'hariValues',

    'maxHari',
    'namaHariTeramai',

    'mape',
    'akurasi',

    'statusModel',

    'pendapatanTertinggi',
    'tanggalPendapatanTertinggi',

    'growthTertinggi'
));    
}
}