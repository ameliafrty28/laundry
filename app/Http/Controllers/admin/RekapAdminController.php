<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;



class RekapAdminController extends Controller
{

    // =====================================================
    // INDEX
    // =====================================================

    public function index(Request $request)
    {

        // =====================================================
        // QUERY
        // =====================================================

        $query = DB::table('rekap_harian');



        // =====================================================
        // FILTER TANGGAL
        // =====================================================

        if (

            $request->start_date &&

            $request->end_date

        ) {

            $query->whereBetween(

                'rekap_tanggal',

                [

                    $request->start_date,

                    $request->end_date
                ]
            );
        }



        // =====================================================
        // DATA REKAP
        // =====================================================
    $rekap =

        (clone $query)

        ->orderByDesc('rekap_tanggal')

        ->paginate(10)

        ->withQueryString();




        // =====================================================
        // SUMMARY
        // =====================================================

        $totalPendapatan =

            (clone $query)->sum(

                'rekap_total_pendapatan'
            );



        $totalTransaksi =

            (clone $query)->sum(

                'rekap_total_transaksi'
            );



        $rataPendapatan =

            (clone $query)->avg(

                'rekap_total_pendapatan'
            );



        // =====================================================
        // TOTAL LAYANAN
        // =====================================================

        $totalRegKilo =

            (clone $query)->sum(

                'rekap_reguler_kiloan'
            );



        $totalExpKilo =

            (clone $query)->sum(

                'rekap_ekspres_kiloan'
            );



        $totalRegSatuan =

            (clone $query)->sum(

                'rekap_reguler_satuan'
            );



        $totalExpSatuan =

            (clone $query)->sum(

                'rekap_ekspres_satuan'
            );



        // =====================================================
        // CHART DATA
        // =====================================================

        $chartData =

            (clone $query)

            ->orderBy('rekap_tanggal')

            ->get();



        $tanggal =

            $chartData->pluck(

                'rekap_tanggal'
            );



        $pendapatan =

            $chartData->pluck(

                'rekap_total_pendapatan'
            );



        $transaksi =

            $chartData->pluck(

                'rekap_total_transaksi'
            );



        // =====================================================
        // HARI TERAMAI
        // =====================================================

        $hariTeramai =

            (clone $query)

            ->select(

                DB::raw(

                    'DAYNAME(rekap_tanggal) as hari'
                ),

                DB::raw(

                    'SUM(rekap_total_transaksi) as total'
                )
            )

            ->groupBy('hari')

            ->orderByDesc('total')

            ->first();



        $namaHariTeramai =

            $hariTeramai->hari ?? '-';



        $jumlahHariTeramai =

            $hariTeramai->total ?? 0;



        // =====================================================
        // PENDAPATAN TERTINGGI
        // =====================================================

        $pendapatanTertinggi =

            (clone $query)

            ->orderByDesc(

                'rekap_total_pendapatan'
            )

            ->first();



        // =====================================================
        // RETURN VIEW
        // =====================================================

        return view(

            'admin.rekap.index',

            compact(

                'rekap',

                'totalPendapatan',

                'totalTransaksi',

                'rataPendapatan',

                'totalRegKilo',

                'totalExpKilo',

                'totalRegSatuan',

                'totalExpSatuan',

                'tanggal',

                'pendapatan',

                'transaksi',

                'namaHariTeramai',

                'jumlahHariTeramai',

                'pendapatanTertinggi'
            )
        );
    }
}