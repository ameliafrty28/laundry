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

                            {{ $i + 1 }}

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

        </div>

    </div>

</div>

@endsection