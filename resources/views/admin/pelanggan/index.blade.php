@extends('layouts.app-admin')

@section('content')
<div class="container">

    <h3>Data Pelanggan</h3>

    <a href="/admin/pelanggan/create" class="btn btn-primary mb-3">Tambah</a>

    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <th>No HP</th>
            <th>Aksi</th>
        </tr>

        @foreach($data as $d)
        <tr>
            <td>{{ $d->pelanggan_nama }}</td>
            <td>{{ $d->pelanggan_wa }}</td>
            <td>
                <a href="/admin/pelanggan/{{ $d->pelanggan_id }}/edit" class="btn btn-warning btn-sm">Edit</a>

                <form action="/admin/pelanggan/{{ $d->pelanggan_id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>

</div>
@endsection