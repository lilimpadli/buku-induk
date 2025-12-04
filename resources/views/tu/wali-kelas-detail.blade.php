@extends('layouts.app')

@section('title', 'Detail Wali Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Wali Kelas: {{ $waliKelas->name }}</h3>
        <a href="{{ route('tu.wali-kelas') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Informasi Wali Kelas</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%">Nama</td>
                            <td>: {{ $waliKelas->name }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Induk</td>
                            <td>: {{ $waliKelas->nomor_induk }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>: {{ $waliKelas->email }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%">Role</td>
                            <td>: {{ $waliKelas->role }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Dibuat</td>
                            <td>: {{ $waliKelas->created_at->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td>Total Siswa</td>
                            <td>: {{ $siswaCount }} siswa</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Aksi Cepat -->
    <div class="card shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0">Aksi Cepat</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-3x text-primary mb-3"></i>
                            <h5>Lihat Daftar Siswa</h5>
                            <a href="{{ route('tu.siswa') }}" class="btn btn-primary">Lihat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line fa-3x text-success mb-3"></i>
                            <h5>Lihat Laporan Nilai</h5>
                            <a href="{{ route('tu.laporan.nilai') }}" class="btn btn-success">Lihat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <i class="fas fa-file-export fa-3x text-info mb-3"></i>
                            <h5>Export Data</h5>
                            <button class="btn btn-info">Export</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection