@extends('layouts.app-admin')

@section('content')

<div class="container-fluid py-4">

    {{-- ===================================== --}}
    {{-- HEADER --}}
    {{-- ===================================== --}}

    <div class="prediksi-header mb-4">

        <div>

           <h2 class="fw-bold mb-1 text-white">
                <i class="bi bi-graph-up-arrow me-2"></i>
                Prediksi Pendapatan Laundry
            </h2>

            <p class="mb-0 text-white opacity-75">
                Menggunakan regresi Linear Berganda
            </p>

        </div>
        <div class="text-end">

            <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                <i class="bi bi-cpu me-1"></i>
                Auto Retraining Model
            </span>

        </div>
    </div>



    {{-- ===================================== --}}
    {{-- INFO MODEL --}}
    {{-- ===================================== --}}

    <div class="card dashboard-card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <h5 class="fw-bold mb-2">
                        Informasi Model Prediksi
                    </h5>

                    <p class="text-muted mb-0">
                        Sistem menggunakan metode
                        <b>Regresi Linear Berganda</b>
                        dengan proses training otomatis menggunakan
                        <b>seluruh data historis transaksi</b>
                        yang tersimpan pada sistem.
                    </p>

                </div>

                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">

                    <div class="d-flex justify-content-lg-end gap-2 flex-wrap">

                        <span class="badge bg-success px-3 py-2 rounded-pill">
                            Auto ETL
                        </span>

                        <span class="badge bg-primary px-3 py-2 rounded-pill">
                            Dynamic Model
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ===================================== --}}
    {{-- INPUT PREDIKSI --}}
    {{-- ===================================== --}}

    <div class="card dashboard-card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h5 class="fw-bold mb-1">
                        Forecasting Pendapatan
                    </h5>

                    <p class="text-muted mb-0">
                        Prediksi pendapatan berdasarkan pola historis transaksi laundry
                    </p>

                </div>

            </div>

            <form method="GET" action="/admin/prediksi">

                <div class="row g-3 align-items-end">

                    <div class="col-lg-9">

                        <label class="form-label fw-semibold">
                            Jumlah Hari Prediksi
                        </label>

                        <input type="number"
                            name="hari"
                            value="{{ $hari }}"
                            min="1"
                            class="form-control custom-input">

                    </div>

                    <div class="col-lg-3">

                        <button class="btn btn-dashboard w-100 py-3">

                            <i class="bi bi-bar-chart-line-fill me-2"></i>
                            Generate Forecast

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ===================================== --}}
    {{-- VARIABEL --}}
    {{-- ===================================== --}}

    <div class="card dashboard-card mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h5 class="fw-bold mb-1">
                        Rata-rata Variabel
                    </h5>

                    <p class="text-muted mb-0">
                        Berdasarkan 7 hari terakhir
                    </p>

                </div>

            </div>

            <div class="row g-4">

                <div class="col-xl-3 col-md-6">

                    <div class="mini-card">

                        <h6>Reguler Kiloan</h6>

                        <h4>
                            {{ $hasilPrediksi[0]['x1'] }}
                        </h4>

                    </div>

                </div>

                <div class="col-xl-3 col-md-6">

                    <div class="mini-card">

                        <h6>Ekspres Kiloan</h6>

                        <h4>
                            {{ $hasilPrediksi[0]['x2'] }}
                        </h4>

                    </div>

                </div>

                <div class="col-xl-3 col-md-6">

                    <div class="mini-card">

                        <h6>Reguler Satuan</h6>

                        <h4>
                            {{ $hasilPrediksi[0]['x3'] }}
                        </h4>

                    </div>

                </div>

                <div class="col-xl-3 col-md-6">

                    <div class="mini-card">

                        <h6>Ekspres Satuan</h6>

                        <h4>
                            {{ $hasilPrediksi[0]['x4'] }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ===================================== --}}
    {{-- HASIL PREDIKSI --}}
    {{-- ===================================== --}}

    <div class="row g-4 mb-4">

        <div class="col-xl-6 col-md-6">

            <div class="summary-card bg-success">

                <div class="card-body">

                    <h6>Prediksi Hari Pertama</h6>

                    <h3>
                        Rp {{ number_format($prediksiHarian,0,',','.') }}
                    </h3>

                </div>

            </div>

        </div>

        <div class="col-xl-6 col-md-6">

            <div class="summary-card bg-primary">

                <div class="card-body">

                    <h6>Total Prediksi {{ $hari }} Hari</h6>

                    <h3>
                        Rp {{ number_format($prediksiTotal,0,',','.') }}
                    </h3>

                </div>

            </div>

        </div>

    </div>



    {{-- ===================================== --}}
    {{-- EVALUASI MODEL --}}
    {{-- ===================================== --}}

    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="mini-card">

                <h6>RMSE</h6>

                <h4>
                    {{ number_format($rmse,0,',','.') }}
                </h4>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="mini-card">

                <h6>MAPE</h6>

                <h4>
                    {{ number_format($mape,2) }}%
                </h4>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="mini-card">

                <h6>Akurasi</h6>

                <h4>
                    {{ number_format($akurasi,2) }}%
                </h4>

            </div>

        </div>

    </div>



    {{-- ===================================== --}}
    {{-- TABEL HASIL PREDIKSI --}}
    {{-- ===================================== --}}

    <div class="card dashboard-card mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h5 class="fw-bold mb-1">
                        Hasil Forecasting Harian
                    </h5>

                    <p class="text-muted mb-0">
                        Prediksi pendapatan beberapa hari ke depan
                    </p>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="10%">
                                No
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Prediksi Pendapatan
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($hasilPrediksi as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item['tanggal'] }}
                            </td>

                            <td>

                                <span class="badge bg-success px-3 py-2">

                                    Rp {{ number_format($item['prediksi'],0,',','.') }}

                                </span>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    {{-- ===================================== --}}
    {{-- GRAFIK --}}
    {{-- ===================================== --}}

    <div class="card dashboard-card">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h5 class="fw-bold mb-1">
                        Grafik Aktual vs Prediksi
                    </h5>

                    <p class="text-muted mb-0">
                        Visualisasi hasil model regresi
                    </p>

                </div>

            </div>

            <div class="chart-container">

                <canvas id="chartPrediksi"></canvas>

            </div>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

.prediksi-header{

    background:linear-gradient(
        135deg,
        #0f172a,
        #1e293b
    );

    border-radius:24px;

    padding:32px;

    color:white;

    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.dashboard-card{

    border:none;

    border-radius:22px;

    background:white;

    box-shadow:0 2px 12px rgba(0,0,0,0.05);

    transition:0.3s;
}

.dashboard-card:hover{

    transform:translateY(-3px);

    box-shadow:0 12px 25px rgba(0,0,0,0.08);
}

.dashboard-card .card-body{

    padding:24px;
}

.summary-card{

    border:none;

    border-radius:22px;

    color:white;

    overflow:hidden;

    box-shadow:0 2px 12px rgba(0,0,0,0.06);
}

.summary-card .card-body{

    padding:24px;
}

.summary-card h6{

    opacity:0.9;

    margin-bottom:12px;
}

.summary-card h3{

    font-size:30px;

    font-weight:700;
}

.mini-card{

    background:white;

    border-radius:20px;

    padding:22px;

    height:100%;

    box-shadow:0 2px 12px rgba(0,0,0,0.05);
}

.mini-card h6{

    color:#64748b;

    margin-bottom:12px;

    font-size:14px;
}

.mini-card h4{

    font-size:24px;

    font-weight:700;
}

.custom-input{

    height:48px;

    border-radius:12px;
}

.btn-dashboard{

    height:48px;

    border:none;

    border-radius:12px;

    background:#0f766e;

    color:white;

    font-weight:600;
}

.btn-dashboard:hover{

    background:#115e59;

    color:white;
}

.chart-container{

    position:relative;

    width:100%;

    height:420px;
}

.table{

    vertical-align:middle;
}

@media(max-width:768px){

    .chart-container{

        height:300px;
    }
}

</style>

<script>

// =====================================
// DATA
// =====================================

const tanggal = @json($tanggalChart);

const aktual = @json($aktual);

const prediksi = @json($prediksiChart);

// =====================================
// CHART
// =====================================

new Chart(document.getElementById('chartPrediksi'), {

    type:'line',

    data:{

        labels:tanggal,

        datasets:[

            {
                label:'Pendapatan Aktual',

                data:aktual,

                borderColor:'#0d6efd',

                backgroundColor:'rgba(13,110,253,0.1)',

                borderWidth:3,

                tension:0.4,

                fill:true
            },

            {
                label:'Prediksi Regresi',

                data:prediksi,

                borderColor:'#198754',

                backgroundColor:'rgba(25,135,84,0.1)',

                borderDash:[5,5],

                borderWidth:3,

                tension:0.4
            }

        ]
    },

    options:{

        responsive:true,

        maintainAspectRatio:false,

        interaction:{

            intersect:false,

            mode:'index'
        },

        plugins:{

            legend:{

                position:'top'
            }
        },

        scales:{

            x:{

                ticks:{

                    autoSkip:true,

                    maxTicksLimit:10
                },

                grid:{

                    display:false
                }
            },

            y:{

                beginAtZero:true,

                grid:{

                    color:'rgba(0,0,0,0.05)'
                }
            }
        }
    }
});

</script>

@endsection