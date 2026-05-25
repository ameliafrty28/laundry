@extends('layouts.app-admin')

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
                href="{{ route('admin.transaksi.create') }}"
                class="btn btn-primary px-4">

                + Transaksi

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
                            Pelanggan
                        </th>

                        <th>
                            Petugas
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

                    <tr class="{{ $d->deleted_at ? 'table-danger' : '' }}">

                        {{-- NO --}}
                        <td>

                            {{ $i + 1 }}

                        </td>



                        {{-- PELANGGAN --}}
                        <td>

                            <div class="fw-semibold">

                                {{ $d->pelanggan->pelanggan_nama ?? '-' }}

                            </div>

                        </td>



                        {{-- PETUGAS --}}
                        <td>

                            <div class="fw-semibold mb-1">

                                {{ $d->user->user_nama ?? '-' }}

                            </div>

                            @if($d->user)

                                @if($d->user->user_role == 'admin')

                                    <span class="badge bg-primary">

                                        Admin

                                    </span>

                                @else

                                    <span class="badge bg-success">

                                        Kasir

                                    </span>

                                @endif

                            @endif

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



                        {{-- STATUS BAYAR --}}
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
                                    href="{{ route('admin.transaksi.show', $d->transaksi_id) }}"
                                    class="btn btn-info btn-sm">

                                    Detail

                                </a>



                                {{-- EDIT --}}
                                @if(!$d->deleted_at && $d->transaksi_status_pesanan != 'diambil')

                                <a
                                    href="{{ route('admin.transaksi.edit', $d->transaksi_id) }}"
                                    class="btn btn-primary btn-sm">

                                    Edit

                                </a>

                                @endif



                                {{-- BAYAR --}}
                                @if(!$d->deleted_at && $d->transaksi_status_pembayaran == 'belum_lunas')

                                <a
                                    href="{{ route('admin.transaksi.bayar', $d->transaksi_id) }}"
                                    class="btn btn-warning btn-sm">

                                    Bayar

                                </a>

                                @endif



                                {{-- HAPUS --}}
                                @if(!$d->deleted_at)

                                <form
                                    action="{{ route('admin.transaksi.destroy', $d->transaksi_id) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus transaksi ini?')">

                                        Hapus

                                    </button>

                                </form>

                                @endif



                                {{-- RESTORE --}}
                                @if($d->deleted_at)

                                <form
                                    action="{{ route('admin.transaksi.restore', $d->transaksi_id) }}"
                                    method="POST">

                                    @csrf

                                    <button class="btn btn-success btn-sm">

                                        Restore

                                    </button>

                                </form>



                                {{-- FORCE DELETE --}}
                                <form
                                    action="{{ route('admin.transaksi.forceDelete', $d->transaksi_id) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-dark btn-sm"
                                        onclick="return confirm('Hapus permanen data ini?')">

                                        Permanent

                                    </button>

                                </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="10" class="text-center py-4 text-muted">

                            Tidak ada data transaksi

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection