@extends('layouts.app-kasir')

@section('content')

<div class="container">

    <h3 class="mb-4">Tambah Data Pelanggan</h3>

    <div class="card p-4 shadow-sm">

        <form action="/kasir/pelanggan" method="POST">
            @csrf

            <!-- NAMA -->
            <div class="mb-3">
                <label>Nama Pelanggan</label>
                <input type="text" name="pelanggan_nama" 
                       class="form-control @error('pelanggan_nama') is-invalid @enderror"
                       value="{{ old('pelanggan_nama') }}">

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
                       value="{{ old('pelanggan_wa') }}">

                @error('pelanggan_wa')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- BUTTON -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('kasir.transaksi.index') }}" class="btn btn-secondary">Kembali</a>                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            
            <input type="hidden" name="redirect" value="{{ request('redirect') }}">
        </form>

    </div>

</div>

@endsection