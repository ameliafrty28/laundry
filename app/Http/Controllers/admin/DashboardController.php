<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data rekap
        $data = DB::table('rekap_harian')
            ->orderBy('rekap_tanggal')
            ->get();

        // DEBUG (opsional, aktifkan kalau perlu)
        // dd($data);

        // Format tanggal biar rapi di chart
        $tanggal = $data->pluck('rekap_tanggal')->map(function ($date) {
            return Carbon::parse($date)->format('y-m-d');
        });

        // Pastikan numeric (penting untuk chart)
        $pendapatan = $data->pluck('rekap_total_pendapatan')->map(fn($v) => (float)$v);
        $reguler = $data->pluck('rekap_total_reguler')->map(fn($v) => (int)$v);
        $ekspres = $data->pluck('rekap_total_ekspres')->map(fn($v) => (int)$v);
        $satuan = $data->pluck('rekap_total_satuan')->map(fn($v) => (int)$v);

        // Summary
        $totalPendapatan = (float) $data->sum('rekap_total_pendapatan');
        $totalBerat = (float) $data->sum('rekap_total_berat');

        return view('admin.dashboard.index', compact(
            'tanggal',
            'pendapatan',
            'reguler',
            'ekspres',
            'satuan',
            'totalPendapatan',
            'totalBerat'
        ));
    }
}