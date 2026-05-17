@extends('layouts.app-kasir')

@section('content')

<div class="card">
  <div class="card-body">

    <h4 class="mb-3">Tambah Layanan</h4>

    <form action="/kasir/layanan" method="POST">
      @csrf

      <div class="mb-3">
        <label>Nama Layanan</label>
        <input type="text" name="layanan_nama" class="form-control" required>
      </div>

      <div class="mb-3">
          <label>Jenis Layanan</label>
            <select name="layanan_jenis" class="form-control" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="Reguler">Reguler</option>
                <option value="Expres">Expres</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Tipe Layanan</label>
            <select name="layanan_tipe" class="form-control" required>
                <option value="">-- Pilih Tipe --</option>
                <option value="Kiloan">Kiloan</option>
                <option value="Satuan">Satuan</option>
            </select>
        </div>
      <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="layanan_harga" class="form-control" required>
      </div>

      <button class="btn btn-primary">Simpan</button>
      <a href="/kasir/layanan" class="btn btn-secondary">Kembali</a>

    </form>

  </div>
</div>

@endsection