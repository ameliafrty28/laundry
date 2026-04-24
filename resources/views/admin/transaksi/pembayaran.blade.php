@extends('layouts.app-admin')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

<h4 class="mb-3">Pembayaran</h4>

<form action="{{ route('admin.transaksi.store') }}" method="POST">
@csrf

<input type="hidden" name="transaksi_tanggal" value="{{ $transaksi_tanggal }}">
<input type="hidden" name="pelanggan_id" value="{{ $pelanggan_id }}">
<input type="hidden" name="total" value="{{ $total }}">

<!-- DETAIL TRANSAKSI -->
<div class="table-responsive">
<table class="table table-bordered">
<thead class="table-light">
<tr>
<th>Layanan</th>
<th>Qty / Berat</th>
<th>Subtotal</th>
</tr>
</thead>

<tbody>
@foreach($detail as $d)
<tr>
<td>{{ $d['nama'] }}</td>
<td>{{ $d['qty'] ?: $d['berat'] }}</td>
<td>Rp {{ number_format($d['subtotal']) }}</td>
</tr>

<input type="hidden" name="layanan_id[]" value="{{ $d['layanan_id'] }}">
<input type="hidden" name="qty[]" value="{{ $d['qty'] }}">
<input type="hidden" name="berat[]" value="{{ $d['berat'] }}">
<input type="hidden" name="subtotal[]" value="{{ $d['subtotal'] }}">
@endforeach
</tbody>
</table>
</div>

<!-- TOTAL -->
<div class="alert alert-primary">
    <h5 class="mb-0">Total: Rp {{ number_format($total) }}</h5>
</div>

<!-- MODE PEMBAYARAN -->
<div class="mb-3">
    <label class="form-label">Mode Pembayaran</label>
    <select name="mode_bayar" id="mode" class="form-control">
        <option value="sekarang">Bayar Sekarang</option>
        <option value="nanti">Bayar Nanti</option>
    </select>
</div>

<!-- AREA BAYAR -->
<div id="bayar">

<div class="row">
<div class="col-md-4">
    <label>Dibayar</label>
    <input type="number" name="dibayar" id="dibayar" class="form-control">
</div>

<div class="col-md-4">
    <label>Kembalian</label>
    <input type="text" id="kembalian" class="form-control" readonly>
</div>

<div class="col-md-4">
    <label>Metode</label>
    <select name="metode" class="form-control">
        <option value="cash">Cash</option>
        <option value="transfer">Transfer</option>
        <option value="qris">QRIS</option>
    </select>
</div>
</div>

</div>

<br>

<button class="btn btn-success">
    Simpan Transaksi
</button>

<a href="/admin/transaksi/create" class="btn btn-secondary">
    Kembali
</a>

</form>

</div>
</div>

<script>
let total = {{ $total }};

document.getElementById('dibayar').addEventListener('input', function(){
    let bayar = this.value || 0;
    document.getElementById('kembalian').value = bayar - total;
});

document.getElementById('mode').addEventListener('change', function(){
    document.getElementById('bayar').style.display =
        this.value === 'nanti' ? 'none' : 'block';
});
</script>

@endsection