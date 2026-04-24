@extends('layouts.app-admin')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

<h4>Detail Transaksi</h4>

<hr>

<!-- INFO UTAMA -->
<div class="row mb-3">
<div class="col-md-6">
    <strong>Pelanggan:</strong><br>
    {{ $data->pelanggan->pelanggan_nama }}
</div>

<div class="col-md-6">
    <strong>Tanggal:</strong><br>
    {{ \Carbon\Carbon::parse($data->transaksi_tanggal)->format('d-m-Y H:i') }}
</div>
</div>

<div class="row mb-3">
<div class="col-md-6">
    <strong>Status Pembayaran:</strong><br>
    @if($data->transaksi_status_pembayaran == 'lunas')
        <span class="badge bg-success">Lunas</span>
    @else
        <span class="badge bg-danger">Belum Lunas</span>
    @endif
</div>

<div class="col-md-6">
    <strong>Status Pesanan:</strong><br>
    <span class="badge bg-secondary">
        {{ ucfirst($data->transaksi_status_pesanan) }}
    </span>
</div>
</div>

<hr>

<!-- DETAIL LAYANAN -->
<h5>Detail Layanan</h5>

<div class="table-responsive">
<table class="table table-bordered">
<thead class="table-light">
<tr>
<th>No</th>
<th>Layanan</th>
<th>Qty</th>
<th>Berat</th>
<th>Subtotal</th>
</tr>
</thead>

<tbody>
@foreach($data->detail as $i => $d)
<tr>
<td>{{ $i+1 }}</td>
<td>{{ $d->layanan->layanan_nama }}</td>
<td>{{ $d->detail_qty ?? '-' }}</td>
<td>{{ $d->detail_berat ?? '-' }}</td>
<td>Rp {{ number_format($d->detail_subtotal) }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>

<hr>

<!-- RINGKASAN -->
<div class="row">

<div class="col-md-4">
    <strong>Total</strong><br>
    Rp {{ number_format($data->transaksi_total) }}
</div>

<div class="col-md-4">
    <strong>Dibayar</strong><br>
    Rp {{ number_format($data->transaksi_dibayar) }}
</div>

<div class="col-md-4">
    <strong>Sisa</strong><br>
    Rp {{ number_format($data->transaksi_sisa) }}
</div>

</div>

<hr>

<a href="/admin/transaksi" class="btn btn-secondary">Kembali</a>

</div>
</div>

@endsection