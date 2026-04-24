@extends('layouts.app-admin')

@section('content')

<div class="container">

    <h3 class="mb-4">Edit Data Pelanggan</h3>

    <div class="card p-4 shadow-sm">

        <form action="/admin/pelanggan/{{ $pelanggan->pelanggan_id }}" method="POST">
            @csrf
            @method('PUT')

            <!-- NAMA -->
            <div class="mb-3">
                <label>Nama Pelanggan</label>
                <input type="text" name="pelanggan_nama" 
                       class="form-control @error('pelanggan_nama') is-invalid @enderror"
                       value="{{ old('pelanggan_nama', $pelanggan->pelanggan_nama) }}">

                @error('pelanggan_nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- WHATSAPP -->
            <div class="mb-3">
                <label>No WhatsApp</label>
                <input type="text" name="pelanggan_wa" 
                       class="form-control @error('pelanggan_wa') is-invalid @enderror"
                       value="{{ old('pelanggan_wa', $pelanggan->pelanggan_wa) }}">

                @error('pelanggan_wa')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- BUTTON -->
            <div class="d-flex justify-content-between">
                <a href="/admin/pelanggan" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-warning">Update</button>
            </div>

        </form>

    </div>

</div>

@endsection