@extends('layouts.app-admin')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

<h4>Pembayaran</h4>

<form action="/admin/transaksi/{{ $data->transaksi_id }}/bayar" method="POST">
@csrf

<div class="mb-3">
<label>Pelanggan</label>
<input type="text" class="form-control" 
value="{{ $data->pelanggan->pelanggan_nama }}" readonly>
</div>

<div class="mb-3">
<label>Total</label>
<input type="text" class="form-control" 
value="Rp {{ number_format($data->transaksi_total) }}" readonly>
</div>

<div class="mb-3">
<label>Sudah Dibayar</label>
<input type="text" class="form-control" 
value="Rp {{ number_format($data->transaksi_dibayar) }}" readonly>
</div>

<div class="mb-3">
<label>Sisa</label>
<input type="text" class="form-control" 
value="Rp {{ number_format($data->transaksi_sisa) }}" readonly>
</div>

<div class="mb-3">
<label>Bayar Sekarang</label>
<input type="number" name="dibayar" class="form-control" required>
</div>

<div class="mb-3">
<label>Metode</label>
<select name="metode" class="form-control">
<option value="cash">Cash</option>
<option value="transfer">Transfer</option>
<option value="qris">QRIS</option>
</select>
</div>

<button class="btn btn-success">Bayar</button>
<a href="/admin/transaksi" class="btn btn-secondary">Kembali</a>

</form>

</div>
</div>

@endsection