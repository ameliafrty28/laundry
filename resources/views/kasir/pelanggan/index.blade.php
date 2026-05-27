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

                    Data Pelanggan

                </h3>

                <p class="text-muted mb-0">

                    Kelola data pelanggan laundry

                </p>

            </div>

            <a
                href="/kasir/pelanggan/create"
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
                href="/kasir/pelanggan"
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

                        {{-- NO --}}
                        <td>

                            {{ $data->firstItem() + $i }}

                        </td>



                        {{-- NAMA --}}
                        <td>

                            <div class="fw-semibold">

                                {{ $d->pelanggan_nama }}

                            </div>

                        </td>



                        {{-- WHATSAPP --}}
                        <td>

                            {{ $d->pelanggan_wa }}

                        </td>



                        {{-- AKSI --}}
                        <td>

                            <div class="d-flex gap-1">

                                <a
                                    href="/kasir/pelanggan/{{ $d->pelanggan_id }}/edit"
                                    class="btn btn-warning btn-sm">

                                    Edit

                                </a>



                                <form
                                    action="/kasir/pelanggan/{{ $d->pelanggan_id }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4" class="text-center py-4 text-muted">

                            Tidak ada data pelanggan

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

                    data pelanggan

                </small>

                {{ $data->links('pagination::bootstrap-5') }}

            </div>
        </div>

    </div>

</div>

@endsection