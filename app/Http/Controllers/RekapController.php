<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function generateRekapHarian()
{
    $data = DB::table('transaksi as t')
    ->join('detail_transaksi as d', 't.transaksi_id', '=', 'd.transaksi_id')
    ->join('layanan as l', 'd.layanan_id', '=', 'l.layanan_id')
    ->select(
        DB::raw('DATE(t.transaksi_tanggal) as tanggal'),
        DB::raw('SUM(CASE WHEN l.layanan_jenis = "reguler" THEN 1 ELSE 0 END) as total_reguler'),
        DB::raw('SUM(CASE WHEN l.layanan_jenis = "ekspres" THEN 1 ELSE 0 END) as total_ekspres'),
        DB::raw('SUM(CASE WHEN l.layanan_jenis = "satuan" THEN 1 ELSE 0 END) as total_satuan'),
        DB::raw('SUM(d.detail_berat) as total_berat'),
        DB::raw('SUM(t.transaksi_total) as total_pendapatan')
    )
    ->groupBy(DB::raw('DATE(t.transaksi_tanggal)'))
    ->get();

    foreach ($data as $row) {
        DB::table('rekap_harian')->updateOrInsert(
            ['rekap_tanggal' => $row->tanggal],
            [
                'rekap_total_reguler' => $row->total_reguler,
                'rekap_total_ekspres' => $row->total_ekspres,
                'rekap_total_satuan' => $row->total_satuan,
                'rekap_total_berat' => $row->total_berat,
                'rekap_total_pendapatan' => $row->total_pendapatan,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    return "Rekap berhasil dibuat";
}
}
