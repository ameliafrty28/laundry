@extends('layouts.app-admin')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-body p-4">

        {{-- ========================================= --}}
        {{-- HEADER --}}
        {{-- ========================================= --}}

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">

                    Data Pelanggan

                </h3>

                <p class="text-muted mb-0">

                    Kelola data pelanggan laundry

                </p>

            </div>

            <a
                href="/admin/pelanggan/create"
                class="btn btn-primary px-4">

                + Tambah

            </a>

        </div>


        {{-- ========================================= --}}
        {{-- SEARCH --}}
        {{-- ========================================= --}}

        <form method="GET" class="row g-3 mb-4">

            <div class="col-md-5">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Cari nama / WhatsApp pelanggan...">

            </div>

            <div class="col-md-2 d-flex gap-2">

                <button class="btn btn-primary w-100">

                    Search

                </button>

                <a
                    href="/admin/pelanggan"
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
                            Nama Pelanggan
                        </th>

                        <th>
                            No WhatsApp
                        </th>

                        <th width="180">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $i => $d)

                    <tr>

                        <td>

                            {{ $data->firstItem() + $i }}

                        </td>

                        <td>

                            <div class="fw-semibold">

                                {{ $d->pelanggan_nama }}

                            </div>

                        </td>

                        <td>

                            {{ $d->pelanggan_wa }}

                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <a
                                    href="/admin/pelanggan/{{ $d->pelanggan_id }}/edit"
                                    class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <form
                                    action="/admin/pelanggan/{{ $d->pelanggan_id }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Hapus data pelanggan?')"
                                        class="btn btn-danger btn-sm">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4"
                            class="text-center text-muted py-4">

                            Tidak ada data pelanggan

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- ========================================= --}}
        {{-- PAGINATION --}}
        {{-- ========================================= --}}

        <div class="d-flex justify-content-between align-items-center mt-4">

            <small class="text-muted">

                Menampilkan

                {{ $data->firstItem() ?? 0 }}

                -

                {{ $data->lastItem() ?? 0 }}

                dari

                {{ $data->total() }}

                data pelanggan

            </small>

            {{ $data->links('pagination::bootstrap-5') }}

        </div>

    </div>

</div>

@endsection