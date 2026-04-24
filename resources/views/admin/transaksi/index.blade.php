@extends('layouts.app-admin')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

<h4 class="mb-3">Data Transaksi</h4>

<a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary mb-3">
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
<th>Status Pesanan</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
@forelse($data as $i => $d)
<tr class="{{ $d->deleted_at ? 'table-danger' : '' }}">

<td>{{ $i+1 }}</td>

<td>{{ $d->pelanggan->pelanggan_nama ?? '-' }}</td>

<td>
{{ \Carbon\Carbon::parse($d->transaksi_tanggal)->format('d-m-Y H:i') }}
</td>

<td>Rp {{ number_format($d->transaksi_total,0,',','.') }}</td>
<td>Rp {{ number_format($d->transaksi_dibayar,0,',','.') }}</td>
<td>Rp {{ number_format($d->transaksi_sisa,0,',','.') }}</td>

<!-- STATUS PEMBAYARAN -->
<td>
@if($d->transaksi_status_pembayaran == 'lunas')
    <span class="badge bg-success">Lunas</span>
@else
    <span class="badge bg-danger">Belum Lunas</span>
@endif
</td>

<!-- STATUS PESANAN -->
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

@if($d->deleted_at)
    <span class="badge bg-danger">Dihapus</span>
@endif

<!-- DETAIL -->
<a href="{{ route('admin.transaksi.show', $d->transaksi_id) }}" class="btn btn-info btn-sm">
    Detail
</a>

<!-- EDIT -->
@if(!$d->deleted_at && $d->transaksi_status_pesanan != 'diambil')
<a href="{{ route('admin.transaksi.edit', $d->transaksi_id) }}" class="btn btn-primary btn-sm">
    Edit
</a>
@endif

<!-- 🔥 BAYAR (TETAP ADA) -->
@if(!$d->deleted_at && $d->transaksi_status_pembayaran == 'belum_lunas')
<a href="{{ route('admin.transaksi.bayar', $d->transaksi_id) }}" class="btn btn-warning btn-sm">
    Bayar
</a>
@endif

<!-- HAPUS (SOFT DELETE) -->
@if(!$d->deleted_at)
<form action="{{ route('admin.transaksi.destroy', $d->transaksi_id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-sm"
        onclick="return confirm('Yakin hapus transaksi ini?')">
        Hapus
    </button>
</form>
@endif

<!-- RESTORE -->
@if($d->deleted_at)
<form action="{{ route('admin.transaksi.restore', $d->transaksi_id) }}" method="POST" class="d-inline">
    @csrf
    <button class="btn btn-success btn-sm">
        Restore
    </button>
</form>

<!-- FORCE DELETE -->
<form action="{{ route('admin.transaksi.forceDelete', $d->transaksi_id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button class="btn btn-dark btn-sm"
        onclick="return confirm('Hapus permanen data ini?')">
        Hapus Permanen
    </button>
</form>
@endif

</td>

</tr>

@empty
<tr>
<td colspan="9" class="text-center">Tidak ada data</td>
</tr>
@endforelse
</tbody>

</table>
</div>

</div>
</div>

@endsection