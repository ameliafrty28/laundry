@extends('layouts.app-admin')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">Dashboard Business Intelligence</h2>

    {{-- CARD SUMMARY --}}
    <div style="display:flex; gap:20px; margin-bottom:30px;">
        <div style="padding:20px; background:#4CAF50; color:white; border-radius:10px;">
            <h4>Total Pendapatan</h4>
            <h2>Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h2>
        </div>

        <div style="padding:20px; background:#2196F3; color:white; border-radius:10px;">
            <h4>Total Berat</h4>
            <h2>{{ $totalBerat ?? 0 }} Kg</h2>
        </div>
    </div>

    {{-- CHART --}}
    <div style="background:white; padding:20px; border-radius:10px; margin-bottom:30px;">
        <h4>Grafik Pendapatan Harian</h4>
        <canvas id="chartPendapatan"></canvas>
    </div>

    <div style="background:white; padding:20px; border-radius:10px;">
        <h4>Grafik Layanan</h4>
        <canvas id="chartLayanan"></canvas>
    </div>

</div>

@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const tanggal = @json($tanggal ?? []);
    const pendapatan = @json($pendapatan ?? []);
    const reguler = @json($reguler ?? []);
    const ekspres = @json($ekspres ?? []);
    const satuan = @json($satuan ?? []);

    // Chart Pendapatan
    new Chart(document.getElementById('chartPendapatan'), {
        type: 'line',
        data: {
            labels: tanggal,
            datasets: [{
                label: 'Pendapatan Harian',
                data: pendapatan,
                borderWidth: 2,
                fill: false
            }]
        }
    });

    // Chart Layanan
    new Chart(document.getElementById('chartLayanan'), {
        type: 'bar',
        data: {
            labels: tanggal,
            datasets: [
                {
                    label: 'Reguler',
                    data: reguler
                },
                {
                    label: 'Ekspres',
                    data: ekspres
                },
                {
                    label: 'Satuan',
                    data: satuan
                }
            ]
        }
    });

</script>

@endsection