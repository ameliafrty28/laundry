@extends('layouts.app-admin')

@section('content')

    {{-- ===================================== --}}
    {{-- HEADER DASHBOARD --}}
    {{-- ===================================== --}}

    <div class="dashboard-header">

        <div>

            <h2 class="fw-bold text-white mb-1">
                <i class="bi bi-bar-chart-line-fill me-2"></i>
                Dashboard Business Intelligence
            </h2>

            <p class="text-white opacity-75 mb-0">
                Monitoring dan Analisis Pendapatan Usaha Laundry
            </p>

        </div>

        <div class="text-end">

            <span class="badge bg-light text-dark px-3 py-2 rounded-pill">

                <i class="bi bi-cpu me-1"></i>
                Smart BI Analytics

            </span>

        </div>

    </div>


    {{-- ===================================== --}}
    {{-- KPI CARD --}}
    {{-- ===================================== --}}

    <div class="row g-4 mb-4">

        {{-- TOTAL PENDAPATAN --}}

        <div class="col-xl-3 col-md-6">

            <div class="kpi-card revenue-card">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="kpi-title">
                            Total Pendapatan
                        </p>

                        <h3>
                            Rp {{ number_format($totalPendapatan,0,',','.') }}
                        </h3>

                    </div>

                    <div class="kpi-icon">

                        <i class="bi bi-cash-stack"></i>

                    </div>

                </div>

            </div>

        </div>


        {{-- TOTAL TRANSAKSI --}}

        <div class="col-xl-3 col-md-6">

            <div class="kpi-card transaksi-card">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="kpi-title">
                            Total Transaksi
                        </p>

                        <h3>
                            {{ number_format($totalTransaksi) }}
                        </h3>

                    </div>

                    <div class="kpi-icon">

                        <i class="bi bi-receipt"></i>

                    </div>

                </div>

            </div>

        </div>


        {{-- RATA RATA HARIAN --}}

        <div class="col-xl-3 col-md-6">

            <div class="kpi-card avg-card">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="kpi-title">
                            Rata-rata Harian
                        </p>

                        <h3>
                            Rp {{ number_format($rataPendapatan,0,',','.') }}
                        </h3>

                    </div>

                    <div class="kpi-icon">

                        <i class="bi bi-graph-up-arrow"></i>

                    </div>

                </div>

            </div>

        </div>


        {{-- TOTAL DATA --}}

        <div class="col-xl-3 col-md-6">

            <div class="kpi-card data-card">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <p class="kpi-title">
                            Total Data Historis
                        </p>

                        <h3>
                            {{ $jumlahData }}
                        </h3>

                    </div>

                    <div class="kpi-icon">

                        <i class="bi bi-database-fill"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ===================================== --}}
{{-- FILTER DASHBOARD --}}
{{-- ===================================== --}}

<div class="card dashboard-card border-0 shadow-sm mb-4">

    <div class="card-body p-4">

        <form method="GET" action="{{ url('/admin/dashboard') }}">

            <div class="row g-3 align-items-end">

                {{-- TANGGAL AWAL --}}

                <div class="col-xl-3 col-md-6">

                    <label class="form-label fw-semibold">

                        Tanggal Awal

                    </label>

                    <input
                        type="date"
                        name="tanggal_awal"
                        value="{{ request('tanggal_awal') }}"
                        class="form-control custom-input">

                </div>


                {{-- TANGGAL AKHIR --}}

                <div class="col-xl-3 col-md-6">

                    <label class="form-label fw-semibold">

                        Tanggal Akhir

                    </label>

                    <input
                        type="date"
                        name="tanggal_akhir"
                        value="{{ request('tanggal_akhir') }}"
                        class="form-control custom-input">

                </div>


                {{-- QUICK FILTER --}}

                <div class="col-xl-3 col-md-6">

                    <label class="form-label fw-semibold">

                        Quick Filter

                    </label>

                    <select
                        name="range"
                        class="form-select custom-input">

                        <option value="">

                            Semua Data

                        </option>

                        <option value="7"
                            {{ request('range') == '7' ? 'selected' : '' }}>

                            7 Hari

                        </option>

                        <option value="30"
                            {{ request('range') == '30' ? 'selected' : '' }}>

                            30 Hari

                        </option>

                        <option value="90"
                            {{ request('range') == '90' ? 'selected' : '' }}>

                            90 Hari

                        </option>

                    </select>

                </div>


                {{-- BUTTON --}}

                <div class="col-xl-3 col-md-6">

                    <button
                        class="btn btn-dashboard w-100">

                        <i class="bi bi-funnel-fill me-2"></i>

                        Filter Dashboard

                    </button>

                </div>

            </div>

        </form>

    </div>


{{-- ===================================== --}}
{{-- GRAFIK --}}
{{-- ===================================== --}}

<div class="row g-4 mb-4">

    {{-- GRAFIK PENDAPATAN --}}

    <div class="col-xl-8">

        <div class="card dashboard-card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Grafik Tren Pendapatan
                        </h5>

                        <p class="text-muted mb-0">
                            Visualisasi pendapatan harian laundry
                        </p>

                    </div>

                </div>

                <div class="chart-container chart-container-large">

                    <canvas id="pendapatanChart"></canvas>

                </div>

            </div>

        </div>

    </div>


    {{-- KOMPOSISI LAYANAN --}}

    <div class="col-xl-4">

        <div class="card dashboard-card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="mb-4">

                    <h5 class="fw-bold mb-1">
                        Komposisi Layanan
                    </h5>

                    <p class="text-muted mb-0">
                        Distribusi jenis layanan laundry
                    </p>

                </div>

                <div class="chart-container">

                    <canvas id="layananChart"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ===================================== --}}
{{-- GRAFIK TRANSAKSI --}}
{{-- ===================================== --}}

<div class="row g-4 mb-4">

    <div class="col-xl-6">

        <div class="card dashboard-card border-0 shadow-sm">

            <div class="card-body p-4">

                <div class="mb-4">

                    <h5 class="fw-bold mb-1">
                        Grafik Transaksi
                    </h5>

                    <p class="text-muted mb-0">
                        Total transaksi harian laundry
                    </p>

                </div>

                <div class="chart-container">

                    <canvas id="transaksiChart"></canvas>

                </div>

            </div>

        </div>

    </div>


    <div class="col-xl-6">

        <div class="card dashboard-card border-0 shadow-sm">

            <div class="card-body p-4">

                <div class="mb-4">

                    <h5 class="fw-bold mb-1">
                        Hari Teramai
                    </h5>

                    <p class="text-muted mb-0">
                        Analisis transaksi berdasarkan hari
                    </p>

                </div>

                <div class="chart-container">

                    <canvas id="hariChart"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>


    {{-- ===================================== --}}
    {{-- TABEL DATA --}}
    {{-- ===================================== --}}

    <div class="card dashboard-card border-0 shadow-sm">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h5 class="fw-bold mb-1">
                        Data Historis Pendapatan
                    </h5>

                    <p class="text-muted mb-0">
                        Rekap transaksi dan pendapatan laundry
                    </p>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table align-middle modern-table">

                    <thead>

                        <tr>

                            <th>Tanggal</th>
                            <th>Pendapatan</th>
                            <th>Transaksi</th>
                            <th>Reg Kilo</th>
                            <th>Exp Kilo</th>
                            <th>Reg Satuan</th>
                            <th>Exp Satuan</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($rekap as $r)

                        <tr>

                            <td>
                                {{ \Carbon\Carbon::parse($r->rekap_tanggal)->format('d M Y') }}
                            </td>

                            <td class="fw-bold text-success">

                                Rp {{ number_format($r->rekap_total_pendapatan,0,',','.') }}

                            </td>

                            <td>
                                {{ $r->rekap_total_transaksi }}
                            </td>

                            <td>
                                {{ $r->rekap_reguler_kiloan }}
                            </td>

                            <td>
                                {{ $r->rekap_ekspres_kiloan }}
                            </td>

                            <td>
                                {{ $r->rekap_reguler_satuan }}
                            </td>

                            <td>
                                {{ $r->rekap_ekspres_satuan }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>



{{-- ===================================== --}}
{{-- CSS --}}
{{-- ===================================== --}}

<style>

.dashboard-header {

    background: linear-gradient(135deg,#1e3c72,#2a5298);

    border-radius: 20px;

    padding: 20px;

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 10px;
}

.dashboard-card {

    border-radius: 20px;

    overflow: hidden;
}

.kpi-card {

    border-radius: 20px;

    padding: 25px;

    color: white;

    min-height: 140px;

    position: relative;

    overflow: hidden;
}

.revenue-card {

    background: linear-gradient(135deg,#11998e,#38ef7d);
}

.transaksi-card {

    background: linear-gradient(135deg,#396afc,#2948ff);
}

.avg-card {

    background: linear-gradient(135deg,#f7971e,#ffd200);
}

.data-card {

    background: linear-gradient(135deg,#8e2de2,#4a00e0);
}

.kpi-title {

    font-size: 14px;

    opacity: .9;

    margin-bottom: 10px;
}

.kpi-icon {

    font-size: 32px;

    opacity: .25;
}

.modern-table thead {

    background: #f8f9fa;
}

.modern-table th {

    border: none;

    font-weight: 700;
}

.modern-table td {

    vertical-align: middle;

    border-color: #f1f1f1;
}
.chart-container {

    position: relative;

    height: 350px;

    width: 100%;
}

.chart-container-large {

    height: 420px;
}

canvas {

    width: 100% !important;

    height: 100% !important;
}

.card-body {

    position: relative;
}

.custom-input {

    height: 55px;

    border-radius: 14px;

    border: 1px solid #dee2e6;
}

.btn-dashboard {

    height: 55px;

    border-radius: 14px;

    background: linear-gradient(135deg,#1e3c72,#2a5298);

    color: white;

    border: none;

    font-weight: 600;
}

.btn-dashboard:hover {

    color: white;

    opacity: .95;
}
</style>



{{-- ===================================== --}}
{{-- CHART JS --}}
{{-- ===================================== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    // =====================================
    // GRAFIK PENDAPATAN
    // =====================================

    new Chart(document.getElementById('pendapatanChart'), {

        type: 'line',

        data: {

            labels: @json($tanggalChart),

            datasets: [{

                label: 'Pendapatan',

                data: @json($pendapatanChart),

                borderColor: '#396afc',

                backgroundColor: 'rgba(57,106,252,0.1)',

                fill: true,

                tension: 0.4,

                borderWidth: 3

            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false
        }
    });


    // =====================================
    // KOMPOSISI LAYANAN
    // =====================================

    new Chart(document.getElementById('layananChart'), {

        type: 'doughnut',

        data: {

            labels: [

                'Reguler Kiloan',
                'Ekspres Kiloan',
                'Reguler Satuan',
                'Ekspres Satuan'

            ],

            datasets: [{

                data: [

                    {{ $regKilo }},
                    {{ $expKilo }},
                    {{ $regSatuan }},
                    {{ $expSatuan }}

                ]

            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false
        }
    });


    // =====================================
    // GRAFIK TRANSAKSI
    // =====================================

    new Chart(document.getElementById('transaksiChart'), {

        type: 'bar',

        data: {

            labels: @json($tanggalChart),

            datasets: [{

                label: 'Transaksi',

                data: @json($transaksiChart),

                borderRadius: 10

            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false
        }
    });


    // =====================================
    // HARI TERAMAI
    // =====================================

    new Chart(document.getElementById('hariChart'), {

        type: 'polarArea',

        data: {

            labels: @json($hariLabels),

            datasets: [{

                data: @json($hariData)

            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false
        }
    });

});

</script>

@endsection