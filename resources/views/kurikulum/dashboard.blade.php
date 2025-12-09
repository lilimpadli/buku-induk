@extends('layouts.app')

@section('title','Dashboard Kurikulum')

@section('content')

<div class="dashboard-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="page-title">Dashboard Kurikulum</h1>
        <p class="text-muted">Ringkasan data dari sistem buku induk siswa</p>
    </div>

    <div class="search-and-actions d-flex align-items-center gap-3">
        <div class="search-box">
            <input type="text" class="form-control" placeholder="Cari Data Siswa">
        </div>
        <button class="btn btn-primary btn-add">
            Tambah Siswa Baru <i class="fa fa-plus ms-1"></i>
        </button>
    </div>
</div>

{{-- STATISTIK --}}
<div class="stats-row mb-4 d-flex gap-3">

    <div class="stat-card p-3 bg-white shadow-sm rounded flex-fill">
        <p class="stat-label mb-1">Total Siswa Aktif</p>
        <h2 class="stat-value mb-0">{{ $totalSiswa ?? 0 }}</h2>
    </div>

    <div class="stat-card p-3 bg-white shadow-sm rounded flex-fill">
        <p class="stat-label mb-1">Total Guru</p>
        <h2 class="stat-value mb-0">{{ $totalGuru ?? 0 }}</h2>
    </div>

    <div class="stat-card p-3 bg-white shadow-sm rounded flex-fill">
        <p class="stat-label mb-1">Total Kelas</p>
        <h2 class="stat-value mb-0">{{ $totalKelas ?? 0 }}</h2>
    </div>

</div>

{{-- AKTIVITAS TERBARU --}}
<div class="activity-card card">
    <div class="card-body p-0">

        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
            <h5 class="m-0 fw-semibold">Aktivitas Terbaru</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Aktivitas</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($aktivitas as $a)
                    <tr>
                        <td class="fw-medium">{{ $a['nama'] }}</td>
                        <td>{{ $a['kelas'] }}</td>
                        <td>{{ $a['aktivitas'] }}</td>
                        <td class="text-muted">{{ $a['waktu'] }}</td>
                        <td><a href="#" class="link-primary small">Lihat Detail</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            Tidak ada aktivitas terbaru.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
