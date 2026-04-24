@extends('layouts.app-kasir')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

<h4 class="mb-3">Data Transaksi</h4>

<a href="/kasir/transaksi/create" class="btn btn-primary mb-3">
    + Transaksi
</a>

<div class="table-responsive">
<table class="table table-bordered align-middle">
<thead class="table-light">
<tr>
<th>No</th>
<th>Pelanggan</th>
<th>Tanggal</th>
<th>Total</th>
<th>Dibayar</th>
<th>Sisa</th>
<th>Status Bayar</th>
<th>Status Pesanan</th> <!-- 🔥 TAMBAHAN -->
<th>Aksi</th>
</tr>
</thead>

<tbody>
@foreach($data as $i => $d)
<tr>
<td>{{ $i+1 }}</td>

<td>{{ $d->pelanggan->pelanggan_nama }}</td>

<td>
{{ \Carbon\Carbon::parse($d->transaksi_tanggal)->format('d-m-Y H:i') }}
</td>

<td>Rp {{ number_format($d->transaksi_total) }}</td>
<td>Rp {{ number_format($d->transaksi_dibayar) }}</td>
<td>Rp {{ number_format($d->transaksi_sisa) }}</td>

<!-- STATUS PEMBAYARAN -->
<td>
@if($d->transaksi_status_pembayaran == 'lunas')
<span class="badge bg-success">Lunas</span>
@else
<span class="badge bg-danger">Belum Lunas</span>
@endif
</td>

<!-- 🔥 STATUS PESANAN -->
<td>
@if($d->transaksi_status_pesanan == 'proses')
<span class="badge bg-warning text-dark">Proses</span>
@elseif($d->transaksi_status_pesanan == 'selesai')
<span class="badge bg-info">Selesai</span>
@elseif($d->transaksi_status_pesanan == 'diambil')
<span class="badge bg-secondary">Diambil</span>
@endif
</td>

<td>

<!-- DETAIL -->
<a href="/kasir/transaksi/{{ $d->transaksi_id }}" class="btn btn-info btn-sm">
    Detail
</a>

<!-- 🔥 EDIT (TAMBAHAN BARU) -->
@if($d->transaksi_status_pesanan != 'diambil')
<a href="/kasir/transaksi/{{ $d->transaksi_id }}/edit" class="btn btn-primary btn-sm">
    Edit
</a>
@endif

<!-- BAYAR -->
@if($d->transaksi_status_pembayaran == 'belum_lunas')
<a href="/kasir/transaksi/{{ $d->transaksi_id }}/bayar" class="btn btn-warning btn-sm">
    Bayar
</a>
@endif

<!-- HAPUS -->
<form action="/kasir/transaksi/{{ $d->transaksi_id }}" method="POST" class="d-inline">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm">
    Hapus
</button>
</form>

</td>

</tr>
@endforeach
</tbody>

</table>
</div>

</div>
</div>

@endsection