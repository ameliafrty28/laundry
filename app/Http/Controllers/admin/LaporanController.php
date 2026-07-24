<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator; 


class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // FILTER TANGGAL
        // ========================

        $start = $request->start_date;
        $end = $request->end_date;

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

        // VALIDASI DATA
        // ========================

        if ($data->count() == 0) {

            return back()->with('error', 'Data kosong');
        }

        // PERIODE ANALISIS
        // ========================

        $periodeAwal =
            Carbon::parse(
                $data->first()->rekap_tanggal
            )
            ->locale('id')
            ->translatedFormat('d F Y');

        $periodeAkhir =
            Carbon::parse(
                $data->last()->rekap_tanggal
            )
            ->locale('id')
            ->translatedFormat('d F Y');

        // FORMAT DATA
        // ========================

        $tanggal = $data->pluck('rekap_tanggal')
            ->map(fn($d) => Carbon::parse($d)->format('d M Y'))
            ->toArray();

        $pendapatan = $data->pluck('rekap_total_pendapatan')
            ->map(fn($v) => (float)$v)
            ->toArray();

        $totalTransaksi = $data->pluck('rekap_total_transaksi')
            ->map(fn($v) => (int)$v)
            ->toArray();

        $regulerKiloan = $data->pluck('rekap_reguler_kiloan')
            ->map(fn($v) => (float)$v)
            ->toArray();

        $ekspresKiloan = $data->pluck('rekap_ekspres_kiloan')
            ->map(fn($v) => (float)$v)
            ->toArray();

        $regulerSatuan = $data->pluck('rekap_reguler_satuan')
            ->map(fn($v) => (int)$v)
            ->toArray();

        $ekspresSatuan = $data->pluck('rekap_ekspres_satuan')
            ->map(fn($v) => (int)$v)
            ->toArray();

        // TRANSAKSI PER LAYANAN (UNTUK GRAFIK TRANSAKSI)
        // ========================

        $transaksiRegKilo = [];
        $transaksiExpKilo = [];
        $transaksiRegSat  = [];
        $transaksiExpSat  = [];

        // SUMMARY
        // ========================

        $sumPendapatan = array_sum($pendapatan);
        $sumTransaksi = array_sum($totalTransaksi);

        $sumRegulerKiloan = array_sum($regulerKiloan);
        $sumEkspresKiloan = array_sum($ekspresKiloan);

        $sumRegulerSatuan = array_sum($regulerSatuan);
        $sumEkspresSatuan = array_sum($ekspresSatuan);

        // JUMLAH TRANSAKSI PER LAYANAN
        // =====================================================

        $queryTransaksi = DB::table('transaksi as t')
            ->join('detail_transaksi as d', 't.transaksi_id', '=', 'd.transaksi_id')
            ->join('layanan as l', 'd.layanan_id', '=', 'l.layanan_id');

        if ($start && $end) {

            $queryTransaksi->whereDate('t.transaksi_tanggal', '>=', $start)
                        ->whereDate('t.transaksi_tanggal', '<=', $end);
        }


        // Reguler Kiloan
        $totalTransaksiRegKilo = (clone $queryTransaksi)
            ->where('l.layanan_jenis', 'Reguler')
            ->where('l.layanan_tipe', 'Kiloan')
            ->distinct('t.transaksi_id')
            ->count('t.transaksi_id');


        // Ekspres Kiloan
        $totalTransaksiExpKilo = (clone $queryTransaksi)
            ->where('l.layanan_jenis', 'Expres')
            ->where('l.layanan_tipe', 'Kiloan')
            ->distinct('t.transaksi_id')
            ->count('t.transaksi_id');


        // Reguler Satuan
        $totalTransaksiRegSat = (clone $queryTransaksi)
            ->where('l.layanan_jenis', 'Reguler')
            ->where('l.layanan_tipe', 'Satuan')
            ->distinct('t.transaksi_id')
            ->count('t.transaksi_id');


        // Ekspres Satuan
        $totalTransaksiExpSat = (clone $queryTransaksi)
            ->where('l.layanan_jenis', 'Expres')
            ->where('l.layanan_tipe', 'Satuan')
            ->distinct('t.transaksi_id')
            ->count('t.transaksi_id');
        
        // DATA GRAFIK TRANSAKSI PER HARI
        // =====================================================

        foreach ($data as $d) {

            $queryHarian = DB::table('transaksi as t')
                ->join('detail_transaksi as dt', 't.transaksi_id', '=', 'dt.transaksi_id')
                ->join('layanan as l', 'dt.layanan_id', '=', 'l.layanan_id')
                ->whereDate('t.transaksi_tanggal', $d->rekap_tanggal);

            // Reguler Kiloan
            $transaksiRegKilo[] =
                (clone $queryHarian)
                ->where('l.layanan_jenis', 'Reguler')
                ->where('l.layanan_tipe', 'Kiloan')
                ->distinct()
                ->count('t.transaksi_id');

            // Ekspres Kiloan
            $transaksiExpKilo[] =
                (clone $queryHarian)
                ->where('l.layanan_jenis', 'Expres')
                ->where('l.layanan_tipe', 'Kiloan')
                ->distinct()
                ->count('t.transaksi_id');

            // Reguler Satuan
            $transaksiRegSat[] =
                (clone $queryHarian)
                ->where('l.layanan_jenis', 'Reguler')
                ->where('l.layanan_tipe', 'Satuan')
                ->distinct()
                ->count('t.transaksi_id');

            // Ekspres Satuan
            $transaksiExpSat[] =
                (clone $queryHarian)
                ->where('l.layanan_jenis', 'Expres')
                ->where('l.layanan_tipe', 'Satuan')
                ->distinct()
                ->count('t.transaksi_id');
        }
        
        // RATA-RATA
        // ========================

        $rataPendapatan = count($pendapatan) > 0
            ? array_sum($pendapatan) / count($pendapatan)
            : 0;

       
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

    // FORMAT CHART HARI
    // ========================

    $hariLabels = array_keys($hariRamai);

    $hariValues = array_values($hariRamai);


    // HARI PALING RAMAI
    // ========================

    $maxHari = max($hariRamai);

    $namaHariTeramai =
        array_search($maxHari, $hariRamai);


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


    // PENDAPATAN TERTINGGI
    // ========================

    $dataPendapatanTertinggi =

        $data->sortByDesc(
            'rekap_total_pendapatan'
        )->first();


    $pendapatanTertinggi =

        $dataPendapatanTertinggi
            ->rekap_total_pendapatan ?? 0;
    $tanggalPendapatanTertinggi =

        isset($dataPendapatanTertinggi)

        ? Carbon::parse(

            $dataPendapatanTertinggi
                ->rekap_tanggal

        )

        ->locale('id')

        ->translatedFormat('d F Y')

        : '-';


    // GROWTH TERTINGGI
    // ========================

    $growthTertinggi =
        count($growthPendapatan) > 0
        ? max($growthPendapatan)
        : 0;


    // TOTAL LAYANAN
    // =====================================================

    $totalRegKilo =
        array_sum($regulerKiloan);

    $totalExpKilo =
        array_sum($ekspresKiloan);

    $totalRegSatuan =
        array_sum($regulerSatuan);

    $totalExpSatuan =
        array_sum($ekspresSatuan);


    // TOP LAYANAN BERDASARKAN JUMLAH TRANSAKSI
    // =====================================================

    $layananList = [

        'Reguler Kiloan' => $totalTransaksiRegKilo,

        'Ekspres Kiloan' => $totalTransaksiExpKilo,

        'Reguler Satuan' => $totalTransaksiRegSat,

        'Ekspres Satuan' => $totalTransaksiExpSat,
    ];


    $maxLayanan = max($layananList);


    $layananTerlaris =
        array_search(
            $maxLayanan,
            $layananList
        );

        

    // =====================================================
// TREND PENDAPATAN BERDASARKAN MOVING AVERAGE 7 HARI
// =====================================================

$trendPendapatan = 'Stabil';

// Ambil hanya nilai Moving Average yang valid (bukan null)
$maValid = array_values(
    array_filter($ma7, function ($nilai) {
        return $nilai !== null;
    })
);

// Jika data MA minimal 2 titik
if (count($maValid) >= 2) {

    $awal = $maValid[0];
    $akhir = end($maValid);

    if ($akhir > $awal) {

        $trendPendapatan = 'Meningkat';

    } elseif ($akhir < $awal) {

        $trendPendapatan = 'Menurun';

    } else {

        $trendPendapatan = 'Stabil';
    }

} elseif (count($pendapatan) >= 2) {

    // Jika data kurang dari 7 hari, gunakan data pendapatan langsung
    $awal = $pendapatan[0];
    $akhir = end($pendapatan);

    if ($akhir > $awal) {

        $trendPendapatan = 'Meningkat';

    } elseif ($akhir < $awal) {

        $trendPendapatan = 'Menurun';
    }
}



    // =====================================================
    // JUMLAH HARI FILTER
    // =====================================================

    $jumlahHari =
        count($pendapatan);



 
    // =====================================================
    // PERBANDINGAN PREDIKSI
    // =====================================================

    $perbandinganPrediksi = [];

    foreach ($tanggal as $index => $tgl) {

        $aktual =
            $pendapatan[$index] ?? 0;

        $pred =
            $prediksi[$index] ?? 0;

        $selisih =
            abs($aktual - $pred);

        $perbandinganPrediksi[] = [

            'tanggal'  => $tgl,

            'aktual'   => $aktual,

            'prediksi' => $pred,

            'selisih'  => $selisih,
        ];
    }


    // PAGINATION TABLE
    // =====================================================

    $currentPage =
        LengthAwarePaginator::resolveCurrentPage();

    $collection =
        collect($perbandinganPrediksi);

    $perPage = 10;

    $currentItems =
        $collection
            ->slice(
                ($currentPage - 1) * $perPage,
                $perPage
            )
            ->values();

    $perbandinganPrediksi =
        new LengthAwarePaginator(

            $currentItems,

            $collection->count(),

            $perPage,

            $currentPage,

            [

                'path' => request()->url(),

                'query' => request()->query()
            ]
        );


    
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
            
            'periodeAwal',
            'periodeAkhir',

            'growthTertinggi',

            'layananTerlaris',
            'trendPendapatan',
            'perbandinganPrediksi',
            'totalTransaksiRegKilo',
            'totalTransaksiExpKilo',

            'totalTransaksiRegSat',
            'totalTransaksiExpSat',
            'transaksiRegKilo',
            'transaksiExpKilo',
            'transaksiRegSat',
            'transaksiExpSat',
        ));    
    }
}