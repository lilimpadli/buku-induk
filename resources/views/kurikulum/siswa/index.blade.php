@extends('layouts.app')

@section('title', 'Manajemen Siswa')

@section('content')

<div class="container-fluid">

    <!-- JUDUL -->
    <h2 class="fw-bold mb-1">Manajemen Data Siswa</h2>
    <p class="text-muted mb-4">Kelola data siswa dengan mudah. Anda dapat menambah, mengubah, dan menghapus data.</p>

    <!-- BUTTON AKSI -->
    <div class="d-flex gap-2 mb-4">

        {{-- Hindari error jika route belum dibuat --}}
        <a href="" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i> Input Data Siswa
        </a>

        <a href="" class="btn btn-primary">
            <i class="fa fa-user-plus me-2"></i> Tambah Siswa Baru
        </a>

    </div>

    <!-- CARD FILTER + TABEL -->
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body">

            <!-- SEARCH -->
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 me-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari Berdasarkan NIS">
                        <span class="input-group-text bg-white">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>

            <!-- FILTER -->
            <div class="d-flex gap-2 mb-4 flex-wrap">

                <select class="form-select w-auto">
                    <option selected disabled>Kelas</option>
                </select>

                <select class="form-select w-auto">
                    <option selected disabled>Jurusan</option>
                </select>

                <select class="form-select w-auto">
                    <option selected disabled>Rombel</option>
                </select>

                <select class="form-select w-auto">
                    <option selected disabled>Angkatan</option>
                </select>

            </div>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>NISN</th>
                            <th>NIS</th>
                            <th>Nama Lengkap</th>
                            <th>Kelas</th>
                            <th>Angkatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @for($i = 0; $i < 6; $i++)
                        <tr>
                            <td>1234</td>
                            <td>1234</td>
                            <td>LILI</td>
                            <td>XII RPL 1</td>
                            <td>2025/2026</td>

                            <td class="text-center">

                                <a href="#" class="text-dark me-2" title="Lihat">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a href="#" class="text-dark me-2" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="#" class="text-danger" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </a>

                            </td>
                        </tr>
                        @endfor

                    </tbody>

                </table>
            </div>

            <!-- BUTTON LIHAT SEMUA -->
            <div class="text-end mt-3">
                <a href="#" class="btn btn-primary px-4">Lihat Semua</a>
            </div>

        </div>
    </div>

</div>

@endsection
