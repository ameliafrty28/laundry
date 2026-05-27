@extends('layouts.app-kasir')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        {{-- ========================================= --}}
        {{-- HEADER --}}
        {{-- ========================================= --}}

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">

                    Data Layanan

                </h3>

                <p class="text-muted mb-0">

                    Kelola layanan laundry kasir

                </p>

            </div>

            <a
                href="/kasir/layanan/create"
                class="btn btn-primary px-4">

                + Tambah

            </a>

        </div>

    {{-- ========================================= --}}
    {{-- SEARCH & FILTER --}}
    {{-- ========================================= --}}

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

            <a
                href="/kasir/layanan"
                class="btn btn-secondary w-100">

                Reset

            </a>

        </div>

    </form>


        {{-- ========================================= --}}
        {{-- TABLE --}}
        {{-- ========================================= --}}

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th>
                            Nama Layanan
                        </th>

                        <th>
                            Jenis
                        </th>

                        <th>
                            Tipe
                        </th>

                        <th>
                            Harga
                        </th>

                        <th width="140">
                            Aksi
                        </th>

                    </tr>

                </thead>



                <tbody>

                    @forelse($data as $i => $d)

                    <tr>

                        {{-- NO --}}
                        <td>

                        {{ $data->firstItem() + $i }}


                        </td>



                        {{-- NAMA --}}
                        <td>

                            <div class="fw-semibold">

                                {{ $d->layanan_nama }}

                            </div>

                        </td>



                        {{-- JENIS --}}
                        <td>

                            <span class="badge bg-info px-3 py-2">

                                {{ $d->layanan_jenis }}

                            </span>

                        </td>



                        {{-- TIPE --}}
                        <td>

                            <span class="badge bg-secondary px-3 py-2">

                                {{ $d->layanan_tipe }}

                            </span>

                        </td>



                        {{-- HARGA --}}
                        <td>

                            <div class="fw-semibold text-success">

                                Rp {{ number_format($d->layanan_harga,0,',','.') }}

                            </div>

                        </td>



                        {{-- AKSI --}}
                        <td>

                            <a
                                href="/kasir/layanan/{{ $d->layanan_id }}/edit"
                                class="btn btn-warning btn-sm">

                                Edit

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center py-4 text-muted">

                            Tidak ada data layanan

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

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

</div>

@endsection