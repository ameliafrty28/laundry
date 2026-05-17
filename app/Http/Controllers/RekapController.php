<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    public function generateRekapHarian()
    {
        $data = DB::table('transaksi as t')
            ->join('detail_transaksi as d', 't.transaksi_id', '=', 'd.transaksi_id')
            ->join('layanan as l', 'd.layanan_id', '=', 'l.layanan_id')
            ->select(
                DB::raw('DATE(t.transaksi_tanggal) as tanggal'),

                // 🔥 TOTAL TRANSAKSI
                DB::raw('COUNT(DISTINCT t.transaksi_id) as total_transaksi'),

                // 🔥 REGULER KILOAN
                DB::raw('COUNT(DISTINCT CASE 
                    WHEN l.layanan_jenis = "Reguler" 
                    AND l.layanan_tipe = "Kiloan"
                    THEN t.transaksi_id END) as reguler_kiloan'),

                // 🔥 EKSPRES KILOAN
                DB::raw('COUNT(DISTINCT CASE 
                    WHEN l.layanan_jenis = "Expres" 
                    AND l.layanan_tipe = "Kiloan"
                    THEN t.transaksi_id END) as ekspres_kiloan'),

                // 🔥 REGULER SATUAN
                DB::raw('COUNT(DISTINCT CASE 
                    WHEN l.layanan_jenis = "Reguler" 
                    AND l.layanan_tipe = "Satuan"
                    THEN t.transaksi_id END) as reguler_satuan'),

                // 🔥 EKSPRES SATUAN
                DB::raw('COUNT(DISTINCT CASE 
                    WHEN l.layanan_jenis = "Expres" 
                    AND l.layanan_tipe = "Satuan"
                    THEN t.transaksi_id END) as ekspres_satuan'),

                // 🔥 TOTAL PENDAPATAN (AMAN)
                DB::raw('SUM(t.transaksi_total) as total_pendapatan')
            )
            ->groupBy(DB::raw('DATE(t.transaksi_tanggal)'))
            ->get();

        foreach ($data as $row) {
            DB::table('rekap_harian')->updateOrInsert(
                ['rekap_tanggal' => $row->tanggal],
                [
                    'rekap_reguler_kiloan' => $row->reguler_kiloan,
                    'rekap_ekspres_kiloan' => $row->ekspres_kiloan,
                    'rekap_reguler_satuan' => $row->reguler_satuan,
                    'rekap_ekspres_satuan' => $row->ekspres_satuan,
                    'rekap_total_transaksi' => $row->total_transaksi,
                    'rekap_total_pendapatan' => $row->total_pendapatan,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        return "Rekap harian berhasil diperbarui (FIX 4 variabel)";
    }
}