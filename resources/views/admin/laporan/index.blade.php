@extends('layouts.app-admin')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Laporan Business Intelligence
            </h2>

            <p class="text-muted mb-0">
                Dashboard analisis pendapatan dan prediksi laundry
            </p>
        </div>

    </div>


    {{-- FILTER --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <label class="form-label">
                            Tanggal Awal
                        </label>

                        <input type="date"
                               name="start_date"
                               value="{{ $start }}"
                               class="form-control">

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            Tanggal Akhir
                        </label>

                        <input type="date"
                               name="end_date"
                               value="{{ $end }}"
                               class="form-control">

                    </div>

                    <div class="col-md-4 d-flex align-items-end">

                        <button class="btn btn-primary w-100">
                            Filter Data
                        </button>

                    </div>

                </div>

            </form>

            {{-- QUICK FILTER --}}
            <div class="mt-3">

                <a href="?start_date={{ now()->subDays(7)->format('Y-m-d') }}&end_date={{ now()->format('Y-m-d') }}"
                   class="btn btn-outline-primary btn-sm">
                    7 Hari
                </a>

                <a href="?start_date={{ now()->subDays(30)->format('Y-m-d') }}&end_date={{ now()->format('Y-m-d') }}"
                   class="btn btn-outline-success btn-sm">
                    30 Hari
                </a>

                <a href="?start_date={{ now()->subMonths(3)->format('Y-m-d') }}&end_date={{ now()->format('Y-m-d') }}"
                   class="btn btn-outline-warning btn-sm">
                    3 Bulan
                </a>

                <a href="?start_date={{ now()->subYear()->format('Y-m-d') }}&end_date={{ now()->format('Y-m-d') }}"
                   class="btn btn-outline-dark btn-sm">
                    1 Tahun
                </a>

            </div>

        </div>

    </div>


    {{-- SUMMARY --}}
    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">

                    <h6>Total Pendapatan</h6>

                    <h4>
                        Rp {{ number_format($sumPendapatan,0,',','.') }}
                    </h4>

                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">

                    <h6>Total Transaksi</h6>

                    <h4>{{ number_format($sumTransaksi) }}</h4>

                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-warning text-white">
                <div class="card-body">

                    <h6>Rata-rata Pendapatan</h6>

                    <h4>
                        Rp {{ number_format($rataPendapatan,0,',','.') }}
                    </h4>

                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-dark text-white">
                <div class="card-body">

                    <h6>Akurasi Model</h6>

                    <h4>
                        {{ number_format($akurasi,2) }}%
                    </h4>

                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">

    <div class="card border-0 shadow-sm bg-danger text-white">

        <div class="card-body">

            <h6>Hari Teramai</h6>

            <h4>
                {{ $namaHariTeramai }}
            </h4>

            <small>
                {{ number_format($maxHari) }} transaksi
            </small>

        </div>

    </div>

</div>
    </div>

    {{-- LAYANAN --}}
    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body">

                    <h6>Reguler Kiloan</h6>

                    <h4>{{ number_format($sumRegulerKiloan) }}</h4>

                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-danger text-white">
                <div class="card-body">

                    <h6>Ekspres Kiloan</h6>

                    <h4>{{ number_format($sumEkspresKiloan) }}</h4>

                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-secondary text-white">
                <div class="card-body">

                    <h6>Reguler Satuan</h6>

                    <h4>{{ number_format($sumRegulerSatuan) }}</h4>

                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">

                    <h6>Ekspres Satuan</h6>

                    <h4>{{ number_format($sumEkspresSatuan) }}</h4>

                </div>
            </div>
        </div>

    </div>

    {{-- ========================================= --}}
{{-- INSIGHT BUSINESS INTELLIGENCE --}}
{{-- ========================================= --}}

<div class="row mb-4">

    {{-- INSIGHT HARI TERAMAI --}}
    <div class="col-md-6 mb-3">

        <div class="alert alert-primary border-0 shadow-sm">

            <h6 class="fw-bold mb-2">
                Insight Hari Teramai
            </h6>

            Hari dengan aktivitas pelanggan tertinggi adalah

            <b>{{ $namaHariTeramai }}</b>

            dengan total

            <b>
                {{ number_format($maxHari) }}
            </b>

            transaksi.

        </div>

    </div>

    {{-- INSIGHT MODEL --}}
    <div class="col-md-6 mb-3">

        <div class="alert alert-success border-0 shadow-sm">

            <h6 class="fw-bold mb-2">
                Evaluasi Model Prediksi
            </h6>

            Model regresi memiliki tingkat akurasi

            <b>
                {{ number_format($akurasi,2) }}%
            </b>

            dengan status

            <span class="badge bg-success">

                {{ $statusModel }}

            </span>

        </div>

    </div>

    {{-- PENDAPATAN TERTINGGI --}}
    <div class="col-md-6 mb-3">

        <div class="alert alert-warning border-0 shadow-sm">

            <h6 class="fw-bold mb-2">
                Pendapatan Tertinggi
            </h6>

            Pendapatan tertinggi terjadi pada

            <b>
                {{ $tanggalPendapatanTertinggi }}
            </b>

            sebesar

            <b>
                Rp {{ number_format($pendapatanTertinggi,0,',','.') }}
            </b>

        </div>

    </div>

    {{-- GROWTH --}}
    <div class="col-md-6 mb-3">

        <div class="alert alert-danger border-0 shadow-sm">

            <h6 class="fw-bold mb-2">
                Pertumbuhan Pendapatan
            </h6>

            Pertumbuhan pendapatan tertinggi mencapai

            <b>
                {{ number_format($growthTertinggi,2) }}%
            </b>

            dibandingkan hari sebelumnya.

        </div>

    </div>

</div>

    {{-- CHART --}}
    <div class="row">

        {{-- PENDAPATAN --}}
        <div class="col-md-6 mb-4">

        <div class="dashboard-card"
                 onclick="openChart('chartPendapatan')">

                <div class="card-body">

                    <h5 class="mb-3">
                        Grafik Pendapatan
                    </h5>

                    <div class="chart-container">

                        <canvas id="chartPendapatan"></canvas>

                    </div>
                </div>

            </div>

        </div>

        {{-- TRANSAKSI --}}
        <div class="col-md-6 mb-4">
            <div class="dashboard-card"
                 onclick="openChart('chartTransaksi')">

                <div class="card-body">

                    <h5 class="mb-3">
                        Grafik Transaksi
                    </h5>
                    <div class="chart-container">
                        <canvas id="chartTransaksi"></canvas>
                    </div>
                </div>

            </div>

        </div>

        {{-- PIE --}}
        <div class="col-md-6 mb-4">

            <div class="dashboard-card"
                 onclick="openChart('chartPie')">

                <div class="card-body">

                    <h5 class="mb-3">
                        Komposisi Layanan
                    </h5>
                    <div class="chart-container">
                        <canvas id="chartPie"></canvas>
                    </div>
                </div>

            </div>

        </div>

        {{-- TREND --}}
        <div class="col-md-6 mb-4">

            <div class="dashboard-card"
                 onclick="openChart('chartLayanan')">

                <div class="card-body">

                    <h5 class="mb-3">
                        Trend Layanan
                    </h5>
                    <div class="chart-container">
                        <canvas id="chartLayanan"></canvas>
                    </div>
                </div>

            </div>

        </div>

       {{-- AKTUAL VS PREDIKSI --}}
<div class="col-md-6 mb-4">

    <div class="dashboard-card"
         onclick="openChart('chartPrediksi')">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-0">
                    Aktual vs Prediksi
                </h5>

                <span class="badge bg-success">
                    Regresi Linear
                </span>

            </div>
            <div class="chart-container">
                <canvas id="chartPrediksi"
                    height="120"></canvas>
            </div>
        </div>

    </div>

</div>

{{-- PERTUMBUHAN PENDAPATAN --}}
<div class="col-md-6 mb-4">

    <div class="dashboard-card"
         onclick="openChart('chartGrowth')">

        <div class="card-body">

            <h5 class="mb-3">
                Grafik Pertumbuhan Pendapatan
            </h5>
            <div class="chart-container">
                <canvas id="chartGrowth"></canvas>
            </div>
        </div>

    </div>

</div>

{{-- TOP LAYANAN --}}
<div class="col-md-6 mb-4">

    <div class="dashboard-card"
         onclick="openChart('chartTopLayanan')">

        <div class="card-body">

            <h5 class="mb-3">
                Top Layanan Paling Laris
            </h5>
            <div class="chart-container">
                <canvas id="chartTopLayanan"></canvas>
            </div>
        </div>

    </div>

</div>

{{-- HARI TERAMAI --}}
<div class="col-md-6 mb-4">

    <div class="dashboard-card"
         onclick="openChart('chartHariRamai')">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-0">
                    Analisis Hari Teramai
                </h5>

                <span class="badge bg-danger">
                    Business Intelligence
                </span>

            </div>

            <div class="chart-container">

                <canvas id="chartHariRamai"></canvas>

            </div>

        </div>

    </div>

</div>

{{-- MODAL --}}
<div class="modal fade"
     id="chartModal"
     tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
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

body{
    background:#f4f6f9;
}

/* ======================================
   CARD
====================================== */

.dashboard-card{

    border:none;

    border-radius:18px;

    background:white;

    overflow:hidden;

    box-shadow:0 2px 10px rgba(0,0,0,0.05);

    transition:0.3s;

    cursor:pointer;
}

.dashboard-card:hover{

    transform:translateY(-3px);

    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

/* ======================================
   CHART
====================================== */

.chart-container{

    position:relative;

    height:320px;

    width:100%;
}

/* ======================================
   MODAL
====================================== */

#modalCanvas{

    height:70vh !important;
}

.modal-content{

    border:none;

    border-radius:20px;
}

</style>

<script>

// ========================
// DATA
// ========================

const tanggal = @json($tanggal);

const pendapatan = @json($pendapatan);

const transaksi = @json($totalTransaksi);

const regulerKiloan = @json($regulerKiloan);

const ekspresKiloan = @json($ekspresKiloan);

const regulerSatuan = @json($regulerSatuan);

const ekspresSatuan = @json($ekspresSatuan);

const ma7 = @json($ma7);

const prediksi = @json($prediksi);

const growthPendapatan = @json($growthPendapatan);

const hariLabels = @json($hariLabels);

const hariValues = @json($hariValues);

// ========================
// OPTION GLOBAL
// ========================

const globalOptions = {

    responsive:true,

    maintainAspectRatio:false,

    interaction:{

        intersect:false,

        mode:'index'
    },

    plugins:{

        legend:{

            position:'top',

            labels:{

                usePointStyle:true,

                padding:15
            }
        }
    },

    scales:{

        x:{

            grid:{
                display:false
            },

            ticks:{

                autoSkip:true,

                maxTicksLimit:8
            }
        },

        y:{

            beginAtZero:true,

            grid:{

                color:'rgba(0,0,0,0.05)'
            }
        }
    }
};

// ========================
// GRAFIK PENDAPATAN
// ========================

new Chart(document.getElementById('chartPendapatan'), {

    type: 'line',

    data: {

        labels: tanggal,

        datasets: [

            {
                label: 'Pendapatan',

                data: pendapatan,

                borderColor: '#198754',

                backgroundColor: 'rgba(25,135,84,0.1)',

                borderWidth: 3,

                tension: 0.4,

                fill: true
            },

            {
                label: 'Moving Average 7 Hari',

                data: ma7,

                borderColor: '#dc3545',

                borderDash: [5,5],

                borderWidth: 2,

                tension: 0.4
            }

        ]
    },

    options: globalOptions
});

// ========================
// GRAFIK TRANSAKSI
// ========================

new Chart(document.getElementById('chartTransaksi'), {

    type: 'bar',

    data: {

        labels: tanggal,

        datasets: [

            {
                label: 'Total',

                data: transaksi
            },

            {
                label: 'Reg Kilo',

                data: regulerKiloan
            },

            {
                label: 'Exp Kilo',

                data: ekspresKiloan
            },

            {
                label: 'Reg Sat',

                data: regulerSatuan
            },

            {
                label: 'Exp Sat',

                data: ekspresSatuan
            }

        ]
    },

    options: globalOptions
});

// ========================
// KOMPOSISI LAYANAN
// ========================

new Chart(document.getElementById('chartPie'), {

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
                ]
            }

        ]
    },

    options: {

        responsive: true,

        maintainAspectRatio: true
    }
});

// ========================
// TREND LAYANAN
// ========================

new Chart(document.getElementById('chartLayanan'), {

    type: 'line',

    data: {

        labels: tanggal,

        datasets: [

            {
                label: 'Reg Kilo',

                data: regulerKiloan,

                tension: 0.4
            },

            {
                label: 'Exp Kilo',

                data: ekspresKiloan,

                tension: 0.4
            },

            {
                label: 'Reg Sat',

                data: regulerSatuan,

                tension: 0.4
            },

            {
                label: 'Exp Sat',

                data: ekspresSatuan,

                tension: 0.4
            }

        ]
    },

    options: globalOptions
});

// ========================
// AKTUAL VS PREDIKSI
// ========================

new Chart(document.getElementById('chartPrediksi'), {

    type: 'line',

    data: {

        labels: tanggal,

        datasets: [

            {
                label: 'Aktual',

                data: pendapatan,

                borderColor: '#0d6efd',

                backgroundColor: 'rgba(13,110,253,0.1)',

                borderWidth: 3,

                tension: 0.4,

                fill: true
            },

            {
                label: 'Prediksi',

                data: prediksi,

                borderColor: '#198754',

                borderDash: [5,5],

                borderWidth: 3,

                tension: 0.4
            }

        ]
    },

    options: globalOptions
});

// ========================
// PERTUMBUHAN PENDAPATAN
// ========================

new Chart(document.getElementById('chartGrowth'), {

    type:'bar',

    data:{

        labels:tanggal,

        datasets:[

            {
                label:'Growth %',

                data:growthPendapatan,

                backgroundColor:
                    growthPendapatan.map(v =>
                        v >= 0
                        ? '#198754'
                        : '#dc3545'
                    )
            }
        ]
    },

    options:{

        responsive:true,

        maintainAspectRatio:false,

        plugins:{

            tooltip:{

                callbacks:{

                    label:function(context){

                        return context.raw + '%';
                    }
                }
            }
        },

        scales:{

            y:{

                ticks:{

                    callback:function(value){

                        return value + '%';
                    }
                }
            }
        }
    }
});

// ========================
// TOP LAYANAN
// ========================

new Chart(document.getElementById('chartTopLayanan'), {

    type:'bar',

    data:{

        labels:[

            'Reguler Kiloan',
            'Ekspres Kiloan',
            'Reguler Satuan',
            'Ekspres Satuan'
        ],

        datasets:[

            {
                label:'Total Layanan',

                data:[

                    {{ $sumRegulerKiloan }},
                    {{ $sumEkspresKiloan }},
                    {{ $sumRegulerSatuan }},
                    {{ $sumEkspresSatuan }}
                ],

                backgroundColor:[

                    '#0d6efd',
                    '#198754',
                    '#ffc107',
                    '#dc3545'
                ],

                borderRadius:8
            }
        ]
    },

    options:{

        responsive:true,

        maintainAspectRatio:false,

        indexAxis:'y',

        plugins:{

            legend:{
                display:false
            }
        },

        scales:{

            x:{

                beginAtZero:true
            }
        }
    }
});
// ========================
// HARI TERAMAI
// ========================

new Chart(document.getElementById('chartHariRamai'), {

    type:'polarArea',

    data:{

        labels:hariLabels,

        datasets:[

            {
                label:'Total Transaksi',

                data:hariValues,

                backgroundColor:[

                    '#0d6efd',
                    '#198754',
                    '#ffc107',
                    '#dc3545',
                    '#6610f2',
                    '#fd7e14',
                    '#20c997'
                ]
            }
        ]
    },

    options:{

        responsive:true,

        maintainAspectRatio:false,

        plugins:{

            legend:{

                position:'right'
            }
        }
    }
});

// ========================
// MODAL ZOOM
// ========================
let modalChart = null;

function openChart(chartId)
{
    const originalChart =
        Chart.getChart(chartId);

    if (!originalChart) return;

    const modal =
        new bootstrap.Modal(
            document.getElementById('chartModal')
        );

    modal.show();

    setTimeout(() => {

        const ctx =
            document.getElementById('modalCanvas');

        if (modalChart)
        {
            modalChart.destroy();
        }

        modalChart = new Chart(ctx, {

            type:originalChart.config.type,

            data:JSON.parse(
                JSON.stringify(originalChart.config.data)
            ),

            options:{

                ...originalChart.config.options,

                responsive:true,

                maintainAspectRatio:false
            }
        });

    },300);
}

</script>

@endsection