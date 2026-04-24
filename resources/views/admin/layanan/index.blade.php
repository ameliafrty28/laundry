@extends('layouts.app-admin')

@section('content')

<div class="card">
  <div class="card-body">

    <div class="d-flex justify-content-between mb-3">
      <h4>Data Layanan</h4>
      <a href="/admin/layanan/create" class="btn btn-primary">+ Tambah</a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Harga</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          @foreach($data as $d)
          <tr>
            <td>{{ $d->layanan_nama }}</td>
            <td>{{ $d->layanan_jenis }}</td>
            <td>Rp {{ number_format($d->layanan_harga) }}</td>
            <td>
              <a href="/admin/layanan/{{ $d->layanan_id }}/edit"
                 class="btn btn-warning btn-sm">Edit</a>

              <form action="/admin/layanan/{{ $d->layanan_id }}"
                    method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Hapus</button>
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