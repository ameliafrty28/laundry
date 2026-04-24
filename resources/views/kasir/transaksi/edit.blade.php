@extends('layouts.app-kasir')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

<h4>Edit Transaksi</h4>

<form action="/kasir/transaksi/{{ $data->transaksi_id }}" method="POST">
@csrf
@method('PUT')

<!-- PELANGGAN -->
<div class="mb-3">
<label>Pelanggan</label>
<input type="text" class="form-control" 
value="{{ $data->pelanggan->pelanggan_nama }}" readonly>
</div>

<!-- TOTAL -->
<div class="mb-3">
<label>Total</label>
<input type="text" class="form-control" 
value="Rp {{ number_format($data->transaksi_total) }}" readonly>
</div>

<!-- SUDAH DIBAYAR -->
<div class="mb-3">
<label>Sudah Dibayar</label>
<input type="number" name="dibayar" 
value="{{ $data->transaksi_dibayar }}" class="form-control">
</div>

<!-- SISA -->
<div class="mb-3">
<label>Sisa</label>
<input type="text" 
value="Rp {{ number_format($data->transaksi_sisa) }}" 
class="form-control" readonly>
</div>

<!-- STATUS PESANAN -->
<div class="mb-3">
<label>Status Pesanan</label>
<select name="status_pesanan" class="form-control">

<option value="proses" 
{{ $data->transaksi_status_pesanan == 'proses' ? 'selected' : '' }}>
Proses
</option>

<option value="selesai" 
{{ $data->transaksi_status_pesanan == 'selesai' ? 'selected' : '' }}>
Selesai
</option>

<option value="diambil" 
{{ $data->transaksi_status_pesanan == 'diambil' ? 'selected' : '' }}>
Diambil
</option>

</select>
</div>

<button class="btn btn-primary">Update</button>
<a href="/kasir/transaksi" class="btn btn-secondary">Kembali</a>

</form>

</div>
</div>

@endsection