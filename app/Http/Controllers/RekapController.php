<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function generateRekapHarian()
{
    // 🔹 1. Ambil pendapatan (TANPA JOIN)
    $pendapatan = DB::table('transaksi')
        ->selectRaw('
            DATE(transaksi_tanggal) as tanggal,
            SUM(transaksi_total) as total_pendapatan
        ')
        ->groupBy(DB::raw('DATE(transaksi_tanggal)'))
        ->get()
        ->keyBy('tanggal');

    // 🔹 2. Ambil layanan + berat
    $detail = DB::table('detail_transaksi as d')
        ->join('layanan as l', 'd.layanan_id', '=', 'l.layanan_id')
        ->join('transaksi as t', 'd.transaksi_id', '=', 't.transaksi_id')
        ->select(
            DB::raw('DATE(t.transaksi_tanggal) as tanggal'),
            DB::raw('SUM(CASE WHEN l.layanan_jenis = "Reguler" THEN 1 ELSE 0 END) as total_reguler'),
            DB::raw('SUM(CASE WHEN l.layanan_jenis = "Expres" THEN 1 ELSE 0 END) as total_ekspres'),
            DB::raw('SUM(CASE WHEN l.layanan_jenis = "Satuan" THEN 1 ELSE 0 END) as total_satuan'),
            DB::raw('SUM(d.detail_berat) as total_berat')
        )
        ->groupBy(DB::raw('DATE(t.transaksi_tanggal)'))
        ->get();

    foreach ($detail as $row) {

        $totalPendapatan = $pendapatan[$row->tanggal]->total_pendapatan ?? 0;

        DB::table('rekap_harian')->updateOrInsert(
            ['rekap_tanggal' => $row->tanggal],
            [
                'rekap_total_reguler' => $row->total_reguler,
                'rekap_total_ekspres' => $row->total_ekspres,
                'rekap_total_satuan' => $row->total_satuan,
                'rekap_total_berat' => $row->total_berat,
                'rekap_total_pendapatan' => $totalPendapatan,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }

    return "Rekap harian sudah diperbaiki";
}
}
