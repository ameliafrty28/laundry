@extends('layouts.app-admin')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

<h4 class="mb-3">Input Transaksi</h4>

<form action="/admin/transaksi/proses" method="POST">
@csrf

<!-- PILIH PELANGGAN -->
<div class="mb-3">
    <label>Pelanggan</label>

    <div class="mb-3">
        <label>Tanggal Transaksi</label>
        <input type="date" name="transaksi_tanggal" 
            class="form-control @error('transaksi_tanggal') is-invalid @enderror"
            value="{{ old('transaksi_tanggal') }}" required>

        @error('transaksi_tanggal')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="d-flex gap-2">
        <select name="pelanggan_id" class="form-control select2" required>
            <option value="">-- Pilih atau ketik nama pelanggan --</option>

            @foreach($pelanggan as $p)
            <option value="{{ $p->pelanggan_id }}"
                {{ (isset($selectedPelanggan) && $selectedPelanggan == $p->pelanggan_id) ? 'selected' : '' }}>
                {{ $p->pelanggan_nama }}
                {{ $p->pelanggan_wa ? ' - '.$p->pelanggan_wa : '' }}
            </option>
            @endforeach
        </select>

        <!-- tombol tambah pelanggan -->
        <a href="/admin/pelanggan/create?redirect=transaksi" class="btn btn-success">
            +
        </a>
    </div>
</div>

<!-- TABEL LAYANAN -->
<div class="table-responsive">
<table class="table table-bordered align-middle">
<thead class="table-light">
<tr>
<th width="40%">Layanan</th>
<th>Qty</th>
<th>Berat (Kg)</th>
<th width="10%">Aksi</th>
</tr>
</thead>

<tbody id="body">
<tr>
<td>
<select name="layanan_id[]" class="form-control">
@foreach($layanan as $l)
<option value="{{ $l->layanan_id }}">
{{ $l->layanan_nama }} - Rp {{ number_format($l->layanan_harga) }}
</option>
@endforeach
</select>
</td>

<td><input type="number" name="qty[]" class="form-control"></td>
<td><input type="number" step="0.1" name="berat[]" class="form-control"></td>

<td class="text-center">
<button type="button" class="btn btn-danger btn-sm" onclick="hapus(this)">
    🗑
</button>
</td>
</tr>
</tbody>
</table>
</div>

<button type="button" onclick="tambah()" class="btn btn-success btn-sm mb-3">
    + Tambah Layanan
</button>

<hr>

<button class="btn btn-primary">
    Lanjut Pembayaran →
</button>

<a href="/admin/transaksi" class="btn btn-secondary">Kembali</a>

</form>

</div>
</div>

@endsection


@section('scripts')

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SELECT2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "-- Pilih atau ketik pelanggan --",
        allowClear: true,
        width: '100%'
    });
});

// tambah baris layanan
function tambah(){
    let row = document.querySelector('#body tr').cloneNode(true);

    row.querySelectorAll('input').forEach(i => i.value = '');

    document.getElementById('body').appendChild(row);
}

// hapus baris
function hapus(btn){
    if(document.querySelectorAll('#body tr').length > 1){
        btn.closest('tr').remove();
    }
}
</script>

@endsection