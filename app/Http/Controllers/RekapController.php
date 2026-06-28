<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    public function generateRekapHarian()
    {
        // Hapus seluruh data rekap lama
        DB::table('rekap_harian')->truncate();
        // =========================
        // DATA JUMLAH LAYANAN
        // =========================
        $data = DB::table('transaksi as t')
            ->join('detail_transaksi as d', 't.transaksi_id', '=', 'd.transaksi_id')
            ->join('layanan as l', 'd.layanan_id', '=', 'l.layanan_id')
            ->select(
                DB::raw('DATE(t.transaksi_tanggal) as tanggal'),

                DB::raw('COUNT(DISTINCT t.transaksi_id) as total_transaksi'),

                DB::raw('SUM(CASE
                    WHEN l.layanan_jenis = "Reguler"
                    AND l.layanan_tipe = "Kiloan"
                    THEN d.detail_berat
                    ELSE 0 END) as reguler_kiloan'),

                DB::raw('SUM(CASE
                    WHEN l.layanan_jenis = "Expres"
                    AND l.layanan_tipe = "Kiloan"
                    THEN d.detail_berat
                    ELSE 0 END) as ekspres_kiloan'),

                DB::raw('SUM(CASE
                    WHEN l.layanan_jenis = "Reguler"
                    AND l.layanan_tipe = "Satuan"
                    THEN d.detail_qty
                    ELSE 0 END) as reguler_satuan'),

                DB::raw('SUM(CASE
                    WHEN l.layanan_jenis = "Expres"
                    AND l.layanan_tipe = "Satuan"
                    THEN d.detail_qty
                    ELSE 0 END) as ekspres_satuan'),
            )
            ->groupBy(DB::raw('DATE(t.transaksi_tanggal)'))
            ->get();

        foreach ($data as $row) {

            // =========================
            // TOTAL PENDAPATAN PER HARI
            // =========================
            $totalPendapatan = DB::table('transaksi')
                ->whereDate('transaksi_tanggal', $row->tanggal)
                ->sum('transaksi_total');

            DB::table('rekap_harian')->updateOrInsert(

                [
                    'rekap_tanggal' => $row->tanggal
                ],

                [
                    'rekap_reguler_kiloan' => $row->reguler_kiloan,
                    'rekap_ekspres_kiloan' => $row->ekspres_kiloan,
                    'rekap_reguler_satuan' => $row->reguler_satuan,
                    'rekap_ekspres_satuan' => $row->ekspres_satuan,

                    'rekap_total_transaksi' => $row->total_transaksi,

                    'rekap_total_pendapatan' => $totalPendapatan,

                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        return "Rekap harian berhasil diperbarui";
    }
}