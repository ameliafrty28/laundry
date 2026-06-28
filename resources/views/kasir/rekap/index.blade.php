@extends('layouts.app-kasir')

@section('content')

<style>

/* =========================================================
   PAGE HEADER
========================================================= */

.dashboard-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 28px;
}

.dashboard-title {

    font-size: 32px;

    font-weight: 700;

    color: #111827;

    margin-bottom: 6px;
}

.dashboard-subtitle {

    color: #6b7280;

    margin: 0;
}



/* =========================================================
   CARD
========================================================= */

.analytics-card {

    background: white;

    border-radius: 24px;

    border: none;

    box-shadow:
        0 4px 20px rgba(0,0,0,.04);
}



/* =========================================================
   KPI CARD
========================================================= */

.kpi-card {

    border-radius: 24px;

    padding: 28px;

    color: white;

    height: 100%;

    box-shadow:
        0 10px 30px rgba(0,0,0,.06);
}

.revenue-card {

    background:
        linear-gradient(
            135deg,
            #10b981,
            #34d399
        );
}

.transaksi-card {

    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #2563eb
        );
}

.avg-card {

    background:
        linear-gradient(
            135deg,
            #f59e0b,
            #facc15
        );
}



/* =========================================================
   KPI TEXT
========================================================= */

.kpi-label {

    font-size: 14px;

    opacity: .9;

    margin-bottom: 12px;
}

.kpi-value {

    font-size: 34px;

    font-weight: 700;

    margin: 0;
}



/* =========================================================
   FILTER
========================================================= */

.form-control {

    height: 52px;

    border-radius: 14px;

    border: 1px solid #e5e7eb;
}

.form-control:focus {

    box-shadow: none;

    border-color: #2563eb;
}



/* =========================================================
   BUTTON
========================================================= */

.btn-filter {

    height: 52px;

    border: none;

    border-radius: 14px;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #3b82f6
        );

    color: white;

    font-weight: 600;

    transition: .3s;
}

.btn-filter:hover {

    transform: translateY(-2px);

    color: white;
}



/* =========================================================
   TABLE
========================================================= */

.table thead th {

    background: #f9fafb;

    border: none;

    padding: 18px;

    color: #374151;

    font-weight: 700;

    white-space: nowrap;
}

.table tbody td {

    padding: 18px;

    vertical-align: middle;

    border-color: #f3f4f6;
}

.table tbody tr:hover {

    background: #f9fafb;
}



/* =========================================================
   BADGE
========================================================= */

.badge {

    padding: 8px 12px;

    border-radius: 10px;

    font-size: 12px;
}



/* =========================================================
   EMPTY DATA
========================================================= */

.empty-data {

    padding: 40px;

    text-align: center;

    color: #9ca3af;
}



/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:768px){

    .dashboard-header {

        flex-direction: column;

        align-items: start;

        gap: 12px;
    }

    .dashboard-title {

        font-size: 24px;
    }

    .kpi-value {

        font-size: 26px;
    }
}

</style>

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}

    <div class="dashboard-header">

        <div>

            <h2 class="dashboard-title">

                Rekap Harian Laundry

            </h2>

            <p class="dashboard-subtitle">

                Monitoring histori transaksi dan pendapatan laundry

            </p>

        </div>

    </div>



    {{-- ===================================================== --}}
    {{-- FILTER --}}
    {{-- ===================================================== --}}

    <div class="analytics-card p-4 mb-4">

        <form method="GET">

            <div class="row g-3 align-items-end">

                {{-- START DATE --}}
                <div class="col-md-4">

                    <label class="form-label fw-semibold">

                        Tanggal Awal

                    </label>

                    <input
                        type="date"
                        name="start_date"
                        value="{{ request('start_date') }}"
                        class="form-control">

                </div>



                {{-- END DATE --}}
                <div class="col-md-4">

                    <label class="form-label fw-semibold">

                        Tanggal Akhir

                    </label>

                    <input
                        type="date"
                        name="end_date"
                        value="{{ request('end_date') }}"
                        class="form-control">

                </div>



                {{-- BUTTON --}}
                <div class="col-md-4">

                    <button class="btn btn-filter w-100">

                        <i class="ti ti-filter me-2"></i>

                        Filter Data

                    </button>

                </div>
                <a
                    href="{{ route('admin.rekap.pdf',
                    [
                        'start_date' => request('start_date'),
                        'end_date' => request('end_date')
                    ]) }}"

                    class="btn btn-danger">

                    <i class="bi bi-file-earmark-pdf"></i>

                    Cetak PDF

                </a>

            </div>

        </form>

    </div>



    {{-- ===================================================== --}}
    {{-- SUMMARY --}}
    {{-- ===================================================== --}}

    <div class="row g-4 mb-4">

        {{-- TOTAL PENDAPATAN --}}
        <div class="col-xl-4 col-md-6">

            <div class="kpi-card revenue-card">

                <p class="kpi-label">

                    Total Pendapatan

                </p>

                <h3 class="kpi-value">

                    Rp {{ number_format($totalPendapatan,0,',','.') }}

                </h3>

            </div>

        </div>



        {{-- TOTAL TRANSAKSI --}}
        <div class="col-xl-4 col-md-6">

            <div class="kpi-card transaksi-card">

                <p class="kpi-label">

                    Total Transaksi

                </p>

                <h3 class="kpi-value">

                    {{ number_format($totalTransaksi) }}

                </h3>

            </div>

        </div>



        {{-- RATA-RATA --}}
        <div class="col-xl-4 col-md-6">

            <div class="kpi-card avg-card">

                <p class="kpi-label">

                    Rata-rata Pendapatan

                </p>

                <h3 class="kpi-value">

                    Rp {{ number_format($rataPendapatan,0,',','.') }}

                </h3>

            </div>

        </div>

    </div>



    {{-- ===================================================== --}}
    {{-- TABLE --}}
    {{-- ===================================================== --}}

    <div class="analytics-card p-4">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Tanggal</th>

                        <th>Reg Kilo</th>

                        <th>Exp Kilo</th>

                        <th>Reg Sat</th>

                        <th>Exp Sat</th>

                        <th>Total</th>

                        <th>Pendapatan</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($rekap as $item)

                    <tr>

                        <td>

                            {{ $rekap->firstItem() + $loop->index }}


                        </td>

                        <td>

                            {{ \Carbon\Carbon::parse($item->rekap_tanggal)->format('d M Y') }}

                        </td>

                        <td>

                            <span class="badge bg-primary">

                                {{ $item->rekap_reguler_kiloan }}

                            </span>

                        </td>

                        <td>

                            <span class="badge bg-success">

                                {{ $item->rekap_ekspres_kiloan }}

                            </span>

                        </td>

                        <td>

                            <span class="badge bg-warning text-dark">

                                {{ $item->rekap_reguler_satuan }}

                            </span>

                        </td>

                        <td>

                            <span class="badge bg-danger">

                                {{ $item->rekap_ekspres_satuan }}

                            </span>

                        </td>

                        <td>

                            <b>

                                {{ $item->rekap_total_transaksi }}

                            </b>

                        </td>

                        <td>

                            <b class="text-success">

                                Rp {{ number_format($item->rekap_total_pendapatan,0,',','.') }}

                            </b>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="8"
                            class="empty-data">

                            Tidak ada data rekap harian

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>
         
            <div class="d-flex justify-content-between align-items-center mt-4">

                <small class="text-muted">

                    Menampilkan

                    {{ $rekap->firstItem() ?? 0 }}

                    -

                    {{ $rekap->lastItem() ?? 0 }}

                    dari

                    {{ $rekap->total() }}

                    data rekap

                </small>

                {{ $rekap->links('pagination::bootstrap-5') }}

            </div>


        </div>

    </div>



@endsection