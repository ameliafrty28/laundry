@extends('layouts.app-admin')

@section('content')



    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}

    <div class="dashboard-header mb-4">

        <div>

            <h2 class="fw-bold text-white mb-1">

                <i class="bi bi-bar-chart-line-fill me-2"></i>

                Business Intelligence Analytics

            </h2>

            <p class="text-white opacity-75 mb-0">

                Analisis historis dan insight pendapatan usaha laundry

            </p>

        </div>

        <div>

            <span class="badge bg-light text-dark px-3 py-2 rounded-pill">

                <i class="bi bi-cpu me-1"></i>

                Smart Analytics

            </span>

        </div>

    </div>



    {{-- ===================================================== --}}
    {{-- FILTER SECTION --}}
    {{-- ===================================================== --}}

    <div class="card dashboard-card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <form method="GET">

                <div class="row g-3 align-items-end">

                    {{-- START DATE --}}
                    <div class="col-xl-3 col-md-6">

                        <label class="form-label fw-semibold">
                            Tanggal Awal
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            value="{{ $start }}"
                            class="form-control custom-input">

                    </div>


                    {{-- END DATE --}}
                    <div class="col-xl-3 col-md-6">

                        <label class="form-label fw-semibold">
                            Tanggal Akhir
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            value="{{ $end }}"
                            class="form-control custom-input">

                    </div>


                    {{-- QUICK FILTER --}}
                    <div class="col-xl-3 col-md-6">

                        <label class="form-label fw-semibold">
                            Quick Filter
                        </label>

                        <select
                            class="form-select custom-input"
                            onchange="window.location.href=this.value">

                            <option>
                                Quick Filter
                            </option>

                            <option
                                value="?start_date={{ now()->subDays(7)->format('Y-m-d') }}&end_date={{ now()->format('Y-m-d') }}">
                                7 Hari
                            </option>

                            <option
                                value="?start_date={{ now()->subDays(30)->format('Y-m-d') }}&end_date={{ now()->format('Y-m-d') }}">
                                30 Hari
                            </option>

                            <option
                                value="?start_date={{ now()->subMonths(3)->format('Y-m-d') }}&end_date={{ now()->format('Y-m-d') }}">
                                3 Bulan
                            </option>

                        </select>

                    </div>


                    {{-- BUTTON FILTER --}}
                    <div class="col-xl-3 col-md-6">

                        <button class="btn btn-dashboard w-100">

                            <i class="bi bi-funnel-fill me-2"></i>

                            Filter Analytics

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>



    {{-- ===================================================== --}}
    {{-- KPI SECTION --}}
    {{-- ===================================================== --}}

    <div class="row mt-3 mb-4">

        {{-- TOTAL PENDAPATAN --}}
        <div class="col-xl-3 col-md-6">

            <div class="kpi-card revenue-card">

                <div class="kpi-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>

                <div class="kpi-content">

                    <p class="kpi-label">
                        Total Pendapatan
                    </p>

                    <h3 class="kpi-value">
                        Rp {{ number_format($sumPendapatan,0,',','.') }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- TOTAL TRANSAKSI --}}
        <div class="col-xl-3 col-md-6">

            <div class="kpi-card transaksi-card">

                <div class="kpi-icon">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>

                <div class="kpi-content">

                    <p class="kpi-label">
                        Total Transaksi
                    </p>

                    <h3 class="kpi-value">
                        {{ number_format($sumTransaksi) }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- RATA-RATA PENDAPATAN --}}
        <div class="col-xl-3 col-md-6">

            <div class="kpi-card avg-card">

                <div class="kpi-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>

                <div class="kpi-content">

                    <p class="kpi-label">
                        Rata-rata Pendapatan
                    </p>

                    <h3 class="kpi-value">
                        Rp {{ number_format($rataPendapatan,0,',','.') }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- AKURASI MODEL --}}
        <div class="col-xl-3 col-md-6">

            <div class="kpi-card akurasi-card">

                <div class="kpi-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <div class="kpi-content">

                    <p class="kpi-label">
                        Akurasi Model
                    </p>

                    <h3 class="kpi-value">
                        {{ number_format($akurasi,2) }}%
                    </h3>

                </div>

            </div>

        </div>



    {{-- ===================================================== --}}
{{-- MINI KPI SECTION --}}
{{-- ===================================================== --}}

<div class="row g-4 mb-5">

    {{-- REGULER KILOAN --}}
    <div class="col-xl-3 col-md-6">

        <div class="mini-kpi">

            <p>Reguler Kiloan</p>

            <h4>{{ number_format($totalTransaksiRegKilo) }}</h4>

            <small class="text-muted">
                {{ number_format($sumRegulerKiloan,2) }} Kg
            </small>

        </div>

    </div>


    {{-- EKSPRES KILOAN --}}
    <div class="col-xl-3 col-md-6">

        <div class="mini-kpi">

            <p>Ekspres Kiloan</p>

            <h4>{{ number_format($totalTransaksiExpKilo) }}</h4>

            <small class="text-muted">
                {{ number_format($sumEkspresKiloan,2) }} Kg
            </small>

        </div>

    </div>


    {{-- REGULER SATUAN --}}
    <div class="col-xl-3 col-md-6">

        <div class="mini-kpi">

            <p>Reguler Satuan</p>

            <h4>{{ number_format($totalTransaksiRegSat) }}</h4>

            <small class="text-muted">
                {{ number_format($sumRegulerSatuan) }} Item
            </small>

        </div>

    </div>


    {{-- EKSPRES SATUAN --}}
    <div class="col-xl-3 col-md-6">

        <div class="mini-kpi">

            <p>Ekspres Satuan</p>

            <h4>{{ number_format($totalTransaksiExpSat) }}</h4>

            <small class="text-muted">
                {{ number_format($sumEkspresSatuan) }} Item
            </small>

        </div>

    </div>

</div> 

{{-- ===================================================== --}}
{{-- BUSINESS INSIGHT SECTION --}}
{{-- ===================================================== --}}

<div class="row g-3 mt-2 mb-4">

    {{-- MODEL --}}
    <div class="col-xl-6">

        <div class="insight-card insight-success">

            <div class="insight-icon">

                <i class="bi bi-cpu-fill"></i>

            </div>

            <div class="insight-content">

                <span class="insight-badge">

                    Evaluasi Model

                </span>

                <h5 class="insight-title">

                    {{ number_format($akurasi,2) }}%

                </h5>

                <p class="insight-desc">

                    Model regresi memiliki performa

                    <b>{{ $statusModel }}</b>

                    berdasarkan evaluasi MAPE.

                </p>

            </div>

        </div>

    </div>



    {{-- PENDAPATAN --}}
    <div class="col-xl-6">

        <div class="insight-card insight-warning">

            <div class="insight-icon">

                <i class="bi bi-cash-coin"></i>

            </div>

            <div class="insight-content">

                <span class="insight-badge">

                    Pendapatan Tertinggi

                </span>

                <h5 class="insight-title">

                    Rp {{ number_format($pendapatanTertinggi,0,',','.') }}

                </h5>

                <p class="insight-desc">

                    Pendapatan tertinggi tercatat pada

                    <b>{{ $tanggalPendapatanTertinggi }}</b>

                </p>

            </div>

        </div>

    </div>

{{-- ===================================================== --}}
{{-- EXECUTIVE SUMMARY --}}
{{-- ===================================================== --}}

<div class="row g-3 mt-2 mb-4">

    <div class="col-12">

        <div class="analytics-card p-4">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>

                    <span class="summary-badge">

                        Executive Summary

                    </span>

                    <h3 class="fw-bold mt-2 mb-0">

                        Business Intelligence Overview

                    </h3>

                </div>

                <div class="summary-icon">

                    <i class="bi bi-bar-chart-line-fill"></i>

                </div>

            </div>


            {{-- DESKRIPSI --}}
            <div class="summary-content mb-4">

                Pada periode

                <b>{{ $periodeAwal }}</b>

                sampai

                <b>{{ $periodeAkhir }}</b>,

                total pendapatan laundry mencapai

                <b>Rp {{ number_format($sumPendapatan,0,',','.') }}</b>

                dengan total

                <b>{{ number_format($sumTransaksi) }}</b>

                transaksi.

                Layanan

                <b>
                    {{ $layananTerlaris }}
                </b>

                menjadi layanan paling dominan.

                Trend pendapatan menunjukkan kondisi

                <b class="{{ $trendPendapatan == 'Meningkat' ? 'text-success' : 'text-danger' }}">
                    {{ $trendPendapatan }}
                </b>

                dengan tingkat akurasi model prediksi sebesar

                <b>
                    {{ number_format($akurasi,2) }}%
                </b>.

            </div>


            <hr class="mb-4">


            {{-- INSIGHT CARD --}}
            <div class="row g-3 mt-2 mb-4">

                <div class="col-lg-3 col-md-6">

                    <div class="mini-summary-card">

                        <div class="text-muted mb-2">

                            Pendapatan Tertinggi

                        </div>

                        <h5 class="fw-bold text-primary">

                            Rp {{ number_format($pendapatanTertinggi,0,',','.') }}

                        </h5>

                        <small>

                            {{ $tanggalPendapatanTertinggi }}

                        </small>

                    </div>

                </div>


                <div class="col-lg-3 col-md-6">

                    <div class="mini-summary-card">

                        <div class="text-muted mb-2">

                            Hari Teramai

                        </div>

                        <h5 class="fw-bold text-danger">

                            {{ $namaHariTeramai }}

                        </h5>

                        <small>

                            Aktivitas transaksi tertinggi

                        </small>

                    </div>

                </div>


                <div class="col-lg-3 col-md-6">

                    <div class="mini-summary-card">

                        <div class="text-muted mb-2">

                            Growth Tertinggi

                        </div>

                        <h5 class="fw-bold text-success">

                            {{ number_format($growthTertinggi,2) }}%

                        </h5>

                        <small>

                            Pertumbuhan pendapatan

                        </small>

                    </div>

                </div>


                <div class="col-lg-3 col-md-6">

                    <div class="mini-summary-card">

                        <div class="text-muted mb-2">

                            Status Model

                        </div>

                        <h5 class="fw-bold text-warning">

                            {{ $statusModel }}

                        </h5>

                        <small>

                            Akurasi {{ number_format($akurasi,2) }}%

                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ===================================================== --}}
{{-- AKTUAL VS PREDIKSI TABLE --}}
{{-- ===================================================== --}}
<div class="row mb-5">

    <div class="col-12">

        <div class="analytics-card p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h5 class="fw-bold mb-1">

                        Perbandingan Aktual vs Prediksi

                    </h5>

                    <p class="text-muted mb-0">

                        Evaluasi performa model regresi

                    </p>

                </div>

                <i class="bi bi-table fs-2 text-primary"></i>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>Tanggal</th>
                            
                            <th>Prediksi</th>

                            <th>Aktual</th>

                            <th>Selisih</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($perbandinganPrediksi as $item)

                        <tr>

                            <td>

                                {{ $item['tanggal'] }}

                            </td>

                            <td>

                                Rp {{ number_format($item['prediksi'],0,',','.') }}

                            </td>

                            <td>

                                Rp {{ number_format($item['aktual'],0,',','.') }}

                            </td>

                            <td>

                                Rp {{ number_format($item['selisih'],0,',','.') }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center text-muted py-4">

                                Tidak ada data

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-end mt-3">

                {{ $perbandinganPrediksi->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </div>

</div>

    {{-- CHART --}}
<div class="row g-4 mb-4">

    {{-- HERO CHART --}}
    <div class="col-12">

        <div class="analytics-card hero-card">

            <div class="card-header-custom">

                <div>

                    <h4 class="chart-title">
                        Grafik Pendapatan
                    </h4>

                    <p class="chart-subtitle">
                        Analisis tren pendapatan laundry
                    </p>

                </div>

                <span class="badge bg-success px-3 py-2">
                    Business Intelligence
                </span>

            </div>

            <div class="chart-hero">

                <canvas id="chartPendapatan"></canvas>

            </div>

        </div>

    </div>

</div>



{{-- ===================================================== --}}
{{-- ROW 2 --}}
{{-- ===================================================== --}}

<div class="row g-4 mb-4">

    {{-- TRANSAKSI --}}
    <div class="col-xl-8">

        <div class="analytics-card h-100">

            <div class="card-header-custom">

                <div>

                    <h5 class="chart-title">
                        Grafik Transaksi
                    </h5>

                    <p class="chart-subtitle">
                        Aktivitas transaksi laundry
                    </p>

                </div>

            </div>

            <div class="chart-medium">

                <canvas id="chartTransaksi"></canvas>

            </div>

        </div>

    </div>


    {{-- PIE --}}
    <div class="col-xl-4">

        <div class="analytics-card h-100">

            <div class="card-header-custom">

                <div>

                    <h5 class="chart-title">
                        Komposisi Layanan
                    </h5>

                    <p class="chart-subtitle">
                        Distribusi layanan laundry
                    </p>

                </div>

            </div>

            <div class="chart-donut">

                <canvas id="chartPie"></canvas>

            </div>

        </div>

    </div>

</div>



{{-- ===================================================== --}}
{{-- ROW 3 --}}
{{-- ===================================================== --}}

<div class="row g-4 mb-4">

    {{-- TREND --}}
    <div class="col-xl-6">

        <div class="analytics-card h-100">

            <div class="card-header-custom">

                <div>

                    <h5 class="chart-title">
                        Trend Layanan
                    </h5>

                    <p class="chart-subtitle">
                        Pergerakan layanan laundry
                    </p>

                </div>

            </div>

            <div class="chart-secondary">

                <canvas id="chartLayanan"></canvas>

            </div>

        </div>

    </div>


    {{-- PREDIKSI --}}
    <div class="col-xl-6">

        <div class="analytics-card h-100">

            <div class="card-header-custom">

                <div>

                    <h5 class="chart-title">
                        Aktual vs Prediksi
                    </h5>

                    <p class="chart-subtitle">
                        Analisis forecasting regresi linear
                    </p>

                </div>

                <span class="badge bg-primary px-3 py-2">

                    Regresi Linear

                </span>

            </div>

            <div class="chart-secondary">

                <canvas id="chartPrediksi"></canvas>

            </div>

        </div>

    </div>

</div>



{{-- ===================================================== --}}
{{-- ROW 4 --}}
{{-- ===================================================== --}}

<div class="row g-4 mb-4">

    {{-- GROWTH --}}
    <div class="col-xl-6">

        <div class="analytics-card h-100">

            <div class="card-header-custom">

                <div>

                    <h5 class="chart-title">
                        Pertumbuhan Pendapatan
                    </h5>

                    <p class="chart-subtitle">
                        Analisis growth pendapatan
                    </p>

                </div>

            </div>

            <div class="chart-secondary">

                <canvas id="chartGrowth"></canvas>

            </div>

        </div>

    </div>


    {{-- TOP LAYANAN --}}
    <div class="col-xl-6">

        <div class="analytics-card h-100">

            <div class="card-header-custom">

                <div>

                    <h5 class="chart-title">
                        Top Layanan
                    </h5>

                    <p class="chart-subtitle">
                        Layanan paling dominan
                    </p>

                </div>

            </div>

            <div class="chart-secondary">

                <canvas id="chartTopLayanan"></canvas>

            </div>

        </div>

    </div>

</div>



{{-- ===================================================== --}}
{{-- ROW 5 --}}
{{-- ===================================================== --}}

<div class="row g-4 mb-4">

    <div class="col-12">

        <div class="analytics-card">

            <div class="card-header-custom">

                <div>

                    <h5 class="chart-title">
                        Analisis Hari Teramai
                    </h5>

                    <p class="chart-subtitle">
                        Pola transaksi berdasarkan hari
                    </p>

                </div>

                <span class="badge bg-danger px-3 py-2">

                    Analytics

                </span>

            </div>

            <div class="chart-large">

                <canvas id="chartHariRamai"></canvas>

            </div>

        </div>

    </div>

</div>



{{-- ===================================================== --}}
{{-- MODAL --}}
{{-- ===================================================== --}}

<div class="modal fade" id="chartModal" tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <div class="modal-header border-0">

                <h5 class="modal-title fw-bold">
                    Detail Grafik
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <canvas id="modalCanvas"></canvas>

            </div>

        </div>

    </div>

</div>
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>

/* =========================================================
   GLOBAL
========================================================= */

body {

    background: #f4f7fb;
}



/* =========================================================
   DASHBOARD HEADER
========================================================= */

.dashboard-header {

    background: linear-gradient(135deg, #1e3c72, #2a5298);

    border-radius: 24px;

    padding: 30px;

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 24px;
}



/* =========================================================
   CARD
========================================================= */

.analytics-card,
.dashboard-card {

   background: #ffffff;

    border: none;

    border-radius: 24px;

    overflow: hidden;

    box-shadow: 0 4px 20px rgba(0,0,0,0.04);

    transition: 0.3s;

    height: 100%;

    padding: 20px;
}

.analytics-card:hover,
.dashboard-card:hover {

    transform: translateY(-4px);

    box-shadow: 0 10px 28px rgba(0,0,0,0.08);
}



/* =========================================================
   CARD HEADER
========================================================= */

.card-header-custom {

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

    margin-bottom: 24px;
}

.chart-title {

    font-size: 20px;

    font-weight: 700;

    color: #111827;

    margin-bottom: 4px;
}

.chart-subtitle {

    font-size: 14px;

    color: #6b7280;

    margin: 0;
}



/* =========================================================
   INPUT & BUTTON
========================================================= */

.custom-input {

    height: 55px;

    border-radius: 14px;

    border: 1px solid #dee2e6;

    padding: 0 16px;
}

.custom-input:focus {

    border-color: #2563eb;

    box-shadow: 0 0 0 0.15rem rgba(37,99,235,0.15);
}

.btn-dashboard {

    height: 55px;

    border: none;

    border-radius: 14px;

    background: linear-gradient(135deg, #1e3c72, #2a5298);

    color: #ffffff;

    font-weight: 600;

    transition: 0.3s;
}

.btn-dashboard:hover {

    opacity: 0.95;

    color: #ffffff;

    transform: translateY(-1px);
}



/* =========================================================
   KPI CARD
========================================================= */

.kpi-card {

    position: relative;

    overflow: hidden;

    border-radius: 22px;

    padding: 22px;

    min-height: 150px;

    color: white;

    display: flex;

    flex-direction: column;

    justify-content: space-between;

    transition: 0.3s;
}

.kpi-card:hover {

    transform: translateY(-3px);
}

/* =========================================================
   KPI COLOR
========================================================= */

.revenue-card {

    background: linear-gradient(135deg, #10b981, #34d399);
}

.transaksi-card {

    background: linear-gradient(135deg, #2563eb, #3b82f6);
}

.avg-card {

    background: linear-gradient(135deg, #f59e0b, #fbbf24);
}

.akurasi-card {

    background: linear-gradient(135deg, #7c3aed, #9333ea);
}

.hari-card {

    background: linear-gradient(135deg, #ef4444, #fb7185);
}



/* =========================================================
   KPI CONTENT
========================================================= */

.kpi-label {

    font-size: 14px;

    font-weight: 500;

    opacity: 0.92;

    margin-bottom: 10px;
}

.kpi-value {

    font-size: 28px;

    font-weight: 700;

    line-height: 1.2;

    margin: 0;
}

.kpi-small {

    font-size: 13px;

    opacity: 0.88;
}



/* =========================================================
   KPI ICON
========================================================= */

.kpi-icon {

    position: absolute;

    top: 18px;

    right: 18px;

    font-size: 42px;

    opacity: 0.14;
}



/* =========================================================
   MINI KPI
========================================================= */
.mini-kpi {

    background: white;

    border-radius: 20px;

    padding: 18px;

    height: 100%;

    box-shadow: 0 4px 18px rgba(0,0,0,.04);

    transition: 0.3s;
}

.mini-kpi:hover {

    transform: translateY(-2px);
}

.mini-kpi p {

    color: #6b7280;

    font-size: 13px;

    margin-bottom: 8px;
}

.mini-kpi h4 {

    font-size: 24px;

    font-weight: 700;

    margin: 0;

    color: #111827;
}
.executive-summary{
    background: #fff;
    border-radius: 30px;
    padding: 30px;
    margin-top: 30px;     /* tambahkan ini */
}
/* =========================================================
   INSIGHT CARD
========================================================= */

.insight-card {

    position: relative;

    overflow: hidden;

    border-radius: 24px;

    padding: 26px;

    height: 100%;

    display: flex;

    align-items: flex-start;

    gap: 20px;

    background: white;

    box-shadow: 0 4px 20px rgba(0,0,0,.04);

    transition: .3s;
}

.insight-card:hover {

    transform: translateY(-3px);

    box-shadow: 0 10px 28px rgba(0,0,0,.08);
}



/* =========================================================
   INSIGHT COLOR
========================================================= */

.insight-primary {

    border-left: 5px solid #2563eb;
}

.insight-success {

    border-left: 5px solid #10b981;
}

.insight-warning {

    border-left: 5px solid #f59e0b;
}

.insight-danger {

    border-left: 5px solid #ef4444;
}



/* =========================================================
   ICON
========================================================= */

.insight-icon {

    width: 60px;

    height: 60px;

    border-radius: 18px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 24px;

    flex-shrink: 0;

    background: rgba(37,99,235,.08);

    color: #2563eb;
}

.insight-success .insight-icon {

    background: rgba(16,185,129,.08);

    color: #10b981;
}

.insight-warning .insight-icon {

    background: rgba(245,158,11,.10);

    color: #f59e0b;
}

.insight-danger .insight-icon {

    background: rgba(239,68,68,.10);

    color: #ef4444;
}



/* =========================================================
   CONTENT
========================================================= */

.insight-badge {

    display: inline-block;

    padding: 6px 12px;

    border-radius: 999px;

    background: #f3f4f6;

    color: #374151;

    font-size: 12px;

    font-weight: 600;

    margin-bottom: 12px;
}

.insight-title {

    font-size: 28px;

    font-weight: 700;

    color: #111827;

    margin-bottom: 10px;
}

.insight-desc {

    color: #6b7280;

    font-size: 14px;

    line-height: 1.7;

    margin-bottom: 0;
}

/* =========================================================
   CHART SIZE
========================================================= */

.chart-hero {

    position: relative;

    height: 430px;
}

.chart-medium {

    position: relative;

    height: 340px;
}

.chart-secondary {

    position: relative;

    height: 320px;
}

.chart-large {

    position: relative;

    height: 400px;
}

.chart-donut {

    position: relative;

    height: 320px;

    max-width: 320px;

    margin: auto;
}



/* =========================================================
   CANVAS
========================================================= */

canvas {

    width: 100% !important;

    height: 100% !important;
}



/* =========================================================
   BADGE
========================================================= */

.badge {

    border-radius: 12px;

    font-weight: 600;

    padding: 10px 14px;
}



/* =========================================================
   MODAL
========================================================= */

.modal-content {

    border: none;

    border-radius: 24px;
}

#modalCanvas {

    height: 70vh !important;
}



/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {

    .dashboard-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 16px;
    }

    .chart-hero {

        height: 300px;
    }

    .chart-large {

        height: 300px;
    }

    .chart-medium,
    .chart-secondary {

        height: 260px;
    }

    .chart-donut {

        height: 260px;
    }

    .kpi-value {

        font-size: 32px;
    }

    .mini-kpi h4 {

        font-size: 26px;
    }
}

</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>Chart.register(ChartDataLabels);</script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    // =====================================================
    // DATA SOURCE
    // =====================================================

    const tanggal           = @json($tanggal);

    const pendapatan        = @json($pendapatan);

    const transaksi         = @json($totalTransaksi);

    const regulerKiloan     = @json($regulerKiloan);

    const ekspresKiloan     = @json($ekspresKiloan);

    const regulerSatuan     = @json($regulerSatuan);

    const ekspresSatuan     = @json($ekspresSatuan);

    const ma7               = @json($ma7);

    const prediksi          = @json($prediksi);

    const growthPendapatan  = @json($growthPendapatan);

    const hariLabels        = @json($hariLabels);

    const hariValues        = @json($hariValues);

    const transaksiRegKilo = @json($transaksiRegKilo);
    
    const transaksiExpKilo = @json($transaksiExpKilo);
    
    const transaksiRegSat  = @json($transaksiRegSat);
    
    const transaksiExpSat  = @json($transaksiExpSat);

    // =====================================================
    // COLOR PALETTE
    // =====================================================

    const colors = {

        primary     : '#2563eb',

        success     : '#10b981',

        warning     : '#f59e0b',

        danger      : '#ef4444',

        purple      : '#8b5cf6',

        pink        : '#ec4899',

        cyan        : '#06b6d4',

        gray        : '#6b7280'
    };



    // =====================================================
    // GLOBAL OPTIONS
    // =====================================================

    const globalOptions = {

        responsive: true,

        maintainAspectRatio: false,

        interaction: {

            intersect: false,

            mode: 'index'
        },

        plugins: {
            datalabels: {
                display: false
            },
            legend: {

                position: 'top',

                labels: {

                    usePointStyle: true,

                    padding: 18,

                    font: {

                        size: 12
                    }
                }
            }
        },

        scales: {

            x: {

                grid: {

                    display: false
                },

                ticks: {

                    color: colors.gray
                }
            },

            y: {

                beginAtZero: true,

                grid: {

                    color: 'rgba(0,0,0,0.05)'
                },

                ticks: {

                    color: colors.gray
                }
            }
        }
    };



    // =====================================================
    // MODAL ZOOM
    // =====================================================

    const modal =
        new bootstrap.Modal(
            document.getElementById('chartModal')
        );

    let modalChart = null;



    function enableChartZoom(chart, type) {

        chart.canvas.onclick = function () {

            modal.show();

            const ctx =
                document
                    .getElementById('modalCanvas')
                    .getContext('2d');

            if (modalChart) {

                modalChart.destroy();
            }

            modalChart = new Chart(ctx, {

                type: type,

                data: chart.data,

                options: {

                    responsive: true,

                    maintainAspectRatio: false
                }
            });
        };
    }



    // =====================================================
    // HELPER
    // =====================================================

    function createChart(id, config, type) {

        const chart = new Chart(

            document.getElementById(id),

            config
        );

        enableChartZoom(chart, type);

        return chart;
    }



    // =====================================================
    // 1. GRAFIK PENDAPATAN
    // =====================================================

    createChart('chartPendapatan', {

        type: 'line',

        data: {

            labels: tanggal,

            datasets: [

                {

                    label: 'Pendapatan',

                    data: pendapatan,

                    borderColor: colors.success,

                    backgroundColor:
                        'rgba(16,185,129,.12)',

                    borderWidth: 3,

                    tension: 0.4,

                    fill: true,

                    pointRadius: 3
                },

                {

                    label: 'Moving Average 7 Hari',

                    data: ma7,

                    borderColor: colors.danger,

                    borderDash: [6,6],

                    borderWidth: 2,

                    tension: 0.4,

                    pointRadius: 0
                }
            ]
        },

        options: globalOptions

    }, 'line');



    // =====================================================
    // 2. GRAFIK TRANSAKSI
    // =====================================================

    createChart('chartTransaksi', {

        type: 'bar',

        data: {

            labels: tanggal,

            datasets: [

                {

                    label: 'Total',

                    data: transaksi,

                    backgroundColor: colors.primary,

                    borderRadius: 10
                },

                {

                    label: 'Reg Kilo',

                    data: transaksiRegKilo,

                    backgroundColor: colors.success,

                    borderRadius: 10
                },

                {

                    label: 'Exp Kilo',

                    data: transaksiExpKilo,

                    backgroundColor: colors.warning,

                    borderRadius: 10
                },

                {

                    label: 'Reg Sat',

                    data: transaksiRegSat,

                    backgroundColor: colors.purple,

                    borderRadius: 10
                },

                {

                    label: 'Exp Sat',

                    data: transaksiExpSat,

                    backgroundColor: colors.pink,

                    borderRadius: 10
                }
            ]
        },

        options: globalOptions

    }, 'bar');



    // =====================================================
// 3. KOMPOSISI LAYANAN
// =====================================================

createChart('chartPie', {

    type: 'doughnut',

    data: {

        labels: [
            'Reg Kilo',
            'Exp Kilo',
            'Reg Sat',
            'Exp Sat'
        ],

        datasets: [

            {

                data: [

                    {{ $sumRegulerKiloan }},
                    {{ $sumEkspresKiloan }},
                    {{ $sumRegulerSatuan }},
                    {{ $sumEkspresSatuan }}

                ],

                backgroundColor: [

                    colors.primary,
                    colors.success,
                    colors.warning,
                    colors.purple

                ],

                borderWidth: 0

            }

        ]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        cutout: '60%',

        plugins: {

            legend: {

                position: 'bottom'

            },
            datalabels: {

        display: true,

        color: '#fff',

        font: {

            weight: 'bold',

            size: 13

        },

        formatter: function(value, context) {

            const data = context.chart.data.datasets[0].data;

            const total = data.reduce((a, b) => a + b, 0);

            return ((value / total) * 100).toFixed(1) + "%";

        }

    },

            tooltip: {

                callbacks: {

                    label: function(context) {

                        return context.label + ': ' + context.raw;

                        // Jika ingin menambahkan satuan:
                        // return context.label + ': ' + context.raw + ' Kg';
                        // atau
                        // return context.label + ': ' + context.raw + ' Item';

                    }

                }

            },

            datalabels: {

                color: '#ffffff',

                font: {

                    weight: 'bold',

                    size: 13

                },

                formatter: function(value, context) {

                    const data = context.chart.data.datasets[0].data;

                    const total = data.reduce((sum, current) => sum + current, 0);

                    const percentage = ((value / total) * 100).toFixed(1);

                    return percentage + '%';

                }

            }

        }

    }

}, 'doughnut');


    // =====================================================
    // 4. TREND LAYANAN
    // =====================================================

    createChart('chartLayanan', {

        type: 'line',

        data: {

            labels: tanggal,

            datasets: [

                {

                    label: 'Reg Kilo',

                    data: regulerKiloan,

                    borderColor: colors.primary,

                    tension: 0.4
                },

                {

                    label: 'Exp Kilo',

                    data: ekspresKiloan,

                    borderColor: colors.success,

                    tension: 0.4
                },

                {

                    label: 'Reg Sat',

                    data: regulerSatuan,

                    borderColor: colors.warning,

                    tension: 0.4
                },

                {

                    label: 'Exp Sat',

                    data: ekspresSatuan,

                    borderColor: colors.purple,

                    tension: 0.4
                }
            ]
        },

        options: globalOptions

    }, 'line');



    // =====================================================
    // 5. AKTUAL VS PREDIKSI
    // =====================================================

    createChart('chartPrediksi', {

        type: 'line',

        data: {

            labels: tanggal,

            datasets: [

                {

                    label: 'Aktual',

                    data: pendapatan,

                    borderColor: colors.primary,

                    backgroundColor:
                        'rgba(37,99,235,.10)',

                    borderWidth: 3,

                    tension: 0.4,

                    fill: true
                },

                {

                    label: 'Prediksi',

                    data: prediksi,

                    borderColor: colors.danger,

                    borderDash: [6,6],

                    borderWidth: 3,

                    tension: 0.4
                }
            ]
        },

        options: globalOptions

    }, 'line');



    // =====================================================
    // 6. GROWTH PENDAPATAN
    // =====================================================

    createChart('chartGrowth', {

        type: 'line',

        data: {

            labels: tanggal,

            datasets: [

                {

                    label: 'Growth %',

                    data: growthPendapatan,

                    borderColor: colors.cyan,

                    backgroundColor:
                        'rgba(6,182,212,.12)',

                    fill: true,

                    tension: 0.4,

                    borderWidth: 3
                }
            ]
        },

        options: globalOptions

    }, 'line');



   // =====================================================
    // 7. TOP LAYANAN
    // =====================================================

    createChart('chartTopLayanan', {

        type: 'polarArea',

        data: {

            labels: [

                'Reg Kilo',
                'Exp Kilo',
                'Reg Sat',
                'Exp Sat'
            ],

            datasets: [

                {

                    data: [

                        {{ $totalTransaksiRegKilo }},
                        {{ $totalTransaksiExpKilo }},
                        {{ $totalTransaksiRegSat }},
                        {{ $totalTransaksiExpSat }}
                    ],

                    backgroundColor: [

                        colors.primary,
                        colors.success,
                        colors.warning,
                        colors.pink
                    ]
                }
            ]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false
        }

    }, 'polarArea');
    
    // =====================================================
    // 8. HARI TERAMAI
    // =====================================================

    createChart('chartHariRamai', {

        type: 'radar',

        data: {

            labels: hariLabels,

            datasets: [

                {

                    label: 'Jumlah Transaksi',

                    data: hariValues,

                    borderColor: colors.pink,

                    backgroundColor:
                        'rgba(236,72,153,.2)',

                    borderWidth: 2,

                    pointBackgroundColor:
                        colors.pink
                }
            ]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            scales: {

                r: {

                    beginAtZero: true,

                    grid: {

                        color:
                            'rgba(0,0,0,.08)'
                    }
                }
            }
        }

    }, 'radar');

});

</script>
@endsection