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

                    Data User

                </h3>

                <p class="text-muted mb-0">

                    Kelola akun admin dan kasir sistem laundry

                </p>

            </div>

            <button
                class="btn btn-primary px-4"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah">

                + Tambah User

            </button>

        </div>



        {{-- ========================================= --}}
        {{-- ALERT --}}
        {{-- ========================================= --}}

        @if(session('success'))

            <div class="alert alert-success border-0 shadow-sm">

                {{ session('success') }}

            </div>

        @endif



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
                            Nama User
                        </th>

                        <th>
                            Username
                        </th>

                        <th>
                            Role
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

                                {{ $d->user_nama }}

                            </div>

                        </td>



                        {{-- USERNAME --}}
                        <td>

                            {{ $d->user_username }}

                        </td>



                        {{-- ROLE --}}
                        <td>

                            @if($d->user_role == 'admin')

                                <span class="badge bg-primary px-3 py-2">

                                    Admin

                                </span>

                            @else

                                <span class="badge bg-success px-3 py-2">

                                    Kasir

                                </span>

                            @endif

                        </td>



                        {{-- AKSI --}}
                        <td>

                            <div class="d-flex gap-1">

                                {{-- EDIT --}}
                                <button
                                    class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $d->user_id }}">

                                    Edit

                                </button>



                                {{-- HAPUS --}}
                                <form
                                    action="{{ route('admin.user.destroy', $d->user_id) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus user ini?')">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>



                    {{-- ========================================= --}}
                    {{-- MODAL EDIT --}}
                    {{-- ========================================= --}}

                    <div
                        class="modal fade"
                        id="editModal{{ $d->user_id }}"
                        tabindex="-1">

                        <div class="modal-dialog">

                            <div class="modal-content border-0 shadow">

                                <form
                                    action="{{ route('admin.user.update', $d->user_id) }}"
                                    method="POST">

                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">

                                        <h5 class="modal-title">

                                            Edit User

                                        </h5>

                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal">

                                        </button>

                                    </div>



                                    <div class="modal-body">

                                        <div class="mb-3">

                                            <label class="form-label">

                                                Nama

                                            </label>

                                            <input
                                                type="text"
                                                name="user_nama"
                                                class="form-control"
                                                value="{{ $d->user_nama }}"
                                                required>

                                        </div>



                                        <div class="mb-3">

                                            <label class="form-label">

                                                Username

                                            </label>

                                            <input
                                                type="text"
                                                name="user_username"
                                                class="form-control"
                                                value="{{ $d->user_username }}"
                                                required>

                                        </div>



                                        <div class="mb-3">

                                            <label class="form-label">

                                                Password Baru

                                            </label>

                                            <input
                                                type="password"
                                                name="user_password"
                                                class="form-control">

                                            <small class="text-muted">

                                                Kosongkan jika tidak ingin mengganti password

                                            </small>

                                        </div>



                                        <div class="mb-3">

                                            <label class="form-label">

                                                Role

                                            </label>

                                            <select
                                                name="user_role"
                                                class="form-select"
                                                required>

                                                <option
                                                    value="admin"
                                                    {{ $d->user_role == 'admin' ? 'selected' : '' }}>

                                                    Admin

                                                </option>

                                                <option
                                                    value="kasir"
                                                    {{ $d->user_role == 'kasir' ? 'selected' : '' }}>

                                                    Kasir

                                                </option>

                                            </select>

                                        </div>

                                    </div>



                                    <div class="modal-footer">

                                        <button
                                            type="button"
                                            class="btn btn-light"
                                            data-bs-dismiss="modal">

                                            Batal

                                        </button>

                                        <button
                                            type="submit"
                                            class="btn btn-primary">

                                            Update

                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                    @empty

                    <tr>

                        <td colspan="5" class="text-center py-4 text-muted">

                            Tidak ada data user

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>



{{-- ========================================= --}}
{{-- MODAL TAMBAH --}}
{{-- ========================================= --}}

<div
    class="modal fade"
    id="modalTambah"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content border-0 shadow">

            <form
                action="{{ route('admin.user.store') }}"
                method="POST">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">

                        Tambah User

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">

                    </button>

                </div>



                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">

                            Nama

                        </label>

                        <input
                            type="text"
                            name="user_nama"
                            class="form-control"
                            required>

                    </div>



                    <div class="mb-3">

                        <label class="form-label">

                            Username

                        </label>

                        <input
                            type="text"
                            name="user_username"
                            class="form-control"
                            required>

                    </div>



                    <div class="mb-3">

                        <label class="form-label">

                            Password

                        </label>

                        <input
                            type="password"
                            name="user_password"
                            class="form-control"
                            required>

                    </div>



                    <div class="mb-3">

                        <label class="form-label">

                            Role

                        </label>

                        <select
                            name="user_role"
                            class="form-select"
                            required>

                            <option value="admin">

                                Admin

                            </option>

                            <option value="kasir">

                                Kasir

                            </option>

                        </select>

                    </div>

                </div>



                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection