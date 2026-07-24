@extends('layouts.app-admin')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="fw-bold mb-1">

                    Data Layanan

                </h4>

                <p class="text-muted mb-0">

                    Manajemen layanan laundry

                </p>

            </div>

            <a href="/admin/layanan/create"
               class="btn btn-primary">

                + Tambah Layanan

            </a>

        </div>

        {{-- SEARCH & FILTER --}}
        <form method="GET" class="row g-3 mb-4">

            {{-- SEARCH --}}
            <div class="col-md-4">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Cari layanan...">

            </div>

            {{-- FILTER JENIS --}}
            <div class="col-md-3">

                <select
                    name="jenis"
                    class="form-select">

                    <option value="">
                        Semua Jenis
                    </option>

                    <option
                        value="Reguler"
                        {{ request('jenis') == 'Reguler' ? 'selected' : '' }}>

                        Reguler

                    </option>

                    <option
                        value="Expres"
                        {{ request('jenis') == 'Expres' ? 'selected' : '' }}>

                        Expres

                    </option>

                </select>

            </div>

            {{-- FILTER TIPE --}}
            <div class="col-md-3">

                <select
                    name="tipe"
                    class="form-select">

                    <option value="">
                        Semua Tipe
                    </option>

                    <option
                        value="Kiloan"
                        {{ request('tipe') == 'Kiloan' ? 'selected' : '' }}>

                        Kiloan

                    </option>

                    <option
                        value="Satuan"
                        {{ request('tipe') == 'Satuan' ? 'selected' : '' }}>

                        Satuan

                    </option>

                </select>

            </div>

            {{-- BUTTON --}}
            <div class="col-md-2 d-flex gap-2">

                <button class="btn btn-primary w-100">

                    Filter

                </button>

                <a href="/admin/layanan"
                   class="btn btn-secondary w-100">

                    Reset

                </a>

            </div>

        </form>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th width="180">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $i => $d)

                    <tr>

                        <td>

                            {{ $data->firstItem() + $i }}

                        </td>

                        <td class="fw-semibold">

                            {{ $d->layanan_nama }}

                        </td>

                        <td>

                                {{ $d->layanan_jenis }}
        
                        </td>

                        <td>

                                {{ $d->layanan_tipe }}

                        </td>

                        <td class="fw-bold text-success">

                            Rp {{ number_format($d->layanan_harga,0,',','.') }}

                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <a href="/admin/layanan/{{ $d->layanan_id }}/edit"
                                   class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <form
                                    action="/admin/layanan/{{ $d->layanan_id }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Hapus data layanan?')"
                                        class="btn btn-danger btn-sm">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6"
                            class="text-center text-muted py-4">

                            Tidak ada data layanan

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-between align-items-center mt-4">

            <small class="text-muted">

                Menampilkan

                {{ $data->firstItem() ?? 0 }}

                -

                {{ $data->lastItem() ?? 0 }}

                dari

                {{ $data->total() }}

                data layanan

            </small>

            {{ $data->links('pagination::bootstrap-5') }}

        </div>

    </div>

</div>

@endsection