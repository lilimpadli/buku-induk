@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('content')

<div class="container-fluid">

    <!-- JUDUL -->
    <h2 class="fw-bold mb-1">Manajemen Kelas</h2>
    <p class="text-muted mb-4">Kelola data kelas, jurusan, rombel, dan wali kelas.</p>

    <!-- STATISTIK -->
    <div class="d-flex gap-3 mb-4 flex-wrap">

        <div class="stat-card p-3 bg-white shadow-sm rounded flex-fill">
            <p class="stat-label mb-1">Total Kelas</p>
            <h2 class="stat-value mb-0">51</h2>
        </div>

        <div class="stat-card p-3 bg-white shadow-sm rounded flex-fill">
            <p class="stat-label mb-1">Total Jurusan</p>
            <h2 class="stat-value mb-0">7</h2>
        </div>

        <div class="stat-card p-3 bg-white shadow-sm rounded flex-fill">
            <p class="stat-label mb-1">Total Siswa</p>
            <h2 class="stat-value mb-0">850</h2>
        </div>

        <div class="stat-card p-3 bg-white shadow-sm rounded flex-fill">
            <p class="stat-label mb-1">Total Guru</p>
            <h2 class="stat-value mb-0">100</h2>
        </div>

    </div>

    <!-- FILTER + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

        <div class="input-group" style="max-width: 280px;">
            <input type="text" class="form-control" placeholder="Cari kelas">
            <span class="input-group-text bg-white">
                <i class="fa fa-search"></i>
            </span>
        </div>

        <div class="d-flex gap-2">
            <select class="form-select w-auto">
                <option selected disabled>Kelas</option>
            </select>

            <select class="form-select w-auto">
                <option selected disabled>Jurusan</option>
            </select>

            <select class="form-select w-auto">
                <option selected disabled>Rombel</option>
            </select>
        </div>

        <a href="#" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i> Tambah Kelas
        </a>

    </div>

    <!-- TABEL DATA -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Rombel</th>
                            <th>Wali Kelas</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @for ($i = 0; $i < 5; $i++)
                            <tr>
                                <td>X</td>
                                <td>DPIB</td>
                                <td>1</td>
                                <td>Suci Anggia S.Pd</td>
                                <td class="text-center">

                                    <!-- TOMBOL LIHAT - SUDAH TERSAMBUNG -->
                                    <a href=""
                                       class="text-dark me-3"
                                       title="Lihat">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <!-- TOMBOL EDIT - SUDAH ADA -->
                                    <a href="{{ route('kurikulum.kelas.edit', $i + 1) }}"
                                       class="text-dark me-3"
                                       title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                </td>
                            </tr>
                        @endfor
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection
