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

                    Data Transaksi

                </h3>

                <p class="text-muted mb-0">

                    Monitoring transaksi laundry pelanggan

                </p>

            </div>

            <a
                href="/kasir/transaksi/create"
                class="btn btn-primary px-4">

                + Transaksi

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
                placeholder="Cari pelanggan...">

        </div>

        {{-- FILTER STATUS --}}
        <div class="col-md-3">

            <select
                name="status"
                class="form-select">

                <option value="">
                    Semua Status
                </option>

                <option
                    value="lunas"
                    {{ request('status') == 'lunas' ? 'selected' : '' }}>

                    Lunas

                </option>

                <option
                    value="belum_lunas"
                    {{ request('status') == 'belum_lunas' ? 'selected' : '' }}>

                    Belum Lunas

                </option>

            </select>

        </div>

        {{-- BUTTON --}}
        <div class="col-md-2 d-flex gap-2">

            <button class="btn btn-primary w-100">

                Filter

            </button>

            <a
                href="/kasir/transaksi"
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
                            Pelanggan
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Dibayar
                        </th>

                        <th>
                            Sisa
                        </th>

                        <th>
                            Status Bayar
                        </th>

                        <th>
                            Status Pesanan
                        </th>

                        <th width="260">
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



                        {{-- PELANGGAN --}}
                        <td>

                            <div class="fw-semibold">

                                {{ $d->pelanggan->pelanggan_nama }}

                            </div>

                        </td>



                        {{-- TANGGAL --}}
                        <td>

                            {{ \Carbon\Carbon::parse($d->transaksi_tanggal)->format('d-m-Y') }}

                            <br>

                            <small class="text-muted">

                                {{ \Carbon\Carbon::parse($d->transaksi_tanggal)->format('H:i') }}

                            </small>

                        </td>



                        {{-- TOTAL --}}
                        <td>

                            <div class="fw-semibold text-dark">

                                Rp {{ number_format($d->transaksi_total,0,',','.') }}

                            </div>

                        </td>



                        {{-- DIBAYAR --}}
                        <td>

                            Rp {{ number_format($d->transaksi_dibayar,0,',','.') }}

                        </td>



                        {{-- SISA --}}
                        <td>

                            <span class="fw-semibold text-danger">

                                Rp {{ number_format($d->transaksi_sisa,0,',','.') }}

                            </span>

                        </td>



                        {{-- STATUS PEMBAYARAN --}}
                        <td>

                            @if($d->transaksi_status_pembayaran == 'lunas')

                                <span class="badge bg-success">

                                    Lunas

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Belum Lunas

                                </span>

                            @endif

                        </td>



                        {{-- STATUS PESANAN --}}
                        <td>

                            @if($d->transaksi_status_pesanan == 'proses')

                                <span class="badge bg-warning text-dark">

                                    Proses

                                </span>

                            @elseif($d->transaksi_status_pesanan == 'selesai')

                                <span class="badge bg-info">

                                    Selesai

                                </span>

                            @elseif($d->transaksi_status_pesanan == 'diambil')

                                <span class="badge bg-secondary">

                                    Diambil

                                </span>

                            @endif

                        </td>



                        {{-- AKSI --}}
                        <td>

                            <div class="d-flex flex-wrap gap-1">

                                {{-- DETAIL --}}
                                <a
                                    href="/kasir/transaksi/{{ $d->transaksi_id }}"
                                    class="btn btn-info btn-sm">

                                    Detail

                                </a>



                                {{-- EDIT --}}
                                @if($d->transaksi_status_pesanan != 'diambil')

                                <a
                                    href="/kasir/transaksi/{{ $d->transaksi_id }}/edit"
                                    class="btn btn-primary btn-sm">

                                    Edit

                                </a>

                                @endif



                                {{-- BAYAR --}}
                                @if($d->transaksi_status_pembayaran == 'belum_lunas')

                                <a
                                    href="/kasir/transaksi/{{ $d->transaksi_id }}/bayar"
                                    class="btn btn-warning btn-sm">

                                    Bayar

                                </a>

                                @endif



                                {{-- HAPUS --}}
                                <form
                                    action="/kasir/transaksi/{{ $d->transaksi_id }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus transaksi ini?')">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="9" class="text-center py-4 text-muted">

                            Tidak ada data transaksi

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

                    data transaksi

                </small>

                {{ $data->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </div>

</div>

@endsection