@extends('layouts.app-kasir')

@section('content')

<div class="card">
  <div class="card-body">

    <h4 class="mb-3">Edit Layanan</h4>

    <form action="/kasir/layanan/{{ $layanan->layanan_id }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label>Nama Layanan</label>
        <input type="text" name="layanan_nama"
               value="{{ $layanan->layanan_nama }}"
               class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Jenis Layanan</label>
        <select name="layanan_jenis" class="form-control" required>

            <option value="Reguler"
            {{ $layanan->layanan_jenis == 'Reguler' ? 'selected' : '' }}>
            Reguler
            </option>

            <option value="Satuan"
            {{ $layanan->layanan_jenis == 'Satuan' ? 'selected' : '' }}>
            Satuan
            </option>

            <option value="Ekspres"
            {{ $layanan->layanan_jenis == 'Ekspres' ? 'selected' : '' }}>
            Ekspres
            </option>

        </select>
      </div>

      <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="layanan_harga"
               value="{{ $layanan->layanan_harga }}"
               class="form-control" required>
      </div>

      <button class="btn btn-primary">Update</button>
      <a href="/kasir/layanan" class="btn btn-secondary">Kembali</a>

    </form>

  </div>
</div>

@endsection