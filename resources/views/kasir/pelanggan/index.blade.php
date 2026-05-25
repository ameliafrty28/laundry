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

                            {{ $i + 1 }}

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

        </div>

    </div>

</div>

@endsection