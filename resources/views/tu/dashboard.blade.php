@extends('layouts.app')

@section('title', 'Dashboard Tata Usaha')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Dashboard Tata Usaha</h1>
        
        <!-- Tombol Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">
                Logout
            </button>
        </form>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalSiswa }}</h4>
                            <p>Total Siswa</p>
                        </div>
                        <div>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalWaliKelas }}</h4>
                            <p>Wali Kelas</p>
                        </div>
                        <div>
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalKelas }}</h4>
                            <p>Total Kelas</p>
                        </div>
                        <div>
                            <i class="fas fa-school fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalNilai }}</h4>
                            <p>Nilai Terinput</p>
                        </div>
                        <div>
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Siswa Baru -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Siswa Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIS</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswaBaru as $siswa)
                                    <tr>
                                        <td>{{ $siswa->nama_lengkap }}</td>
                                        <td>{{ $siswa->nis }}</td>
                                        <td>{{ $siswa->kelas }}</td>
                                        <td>
                                            <a href="{{ route('tu.siswa.detail', $siswa->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('tu.siswa.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nilai Raport Terbaru -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Nilai Raport Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th>Mapel</th>
                                    <th>Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nilaiTerbaru as $nilai)
                                    <tr>
                                        <td>{{ $nilai->siswa->nama_lengkap }}</td>
                                        <td>{{ $nilai->mata_pelajaran }}</td>
                                        <td>{{ $nilai->nilai_pengetahuan }}</td>
                                        <td>
                                            <a href="{{ route('tu.siswa.detail', $nilai->siswa->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('tu.laporan.nilai') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Wali Kelas dan Kelas -->
    <div class="row">
        <!-- Ringkasan Wali Kelas -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ringkasan Wali Kelas</h5>
                    <a href="{{ route('tu.wali-kelas') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Nomor Induk</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($waliKelasLimit as $wk)
                                    <tr>
                                        <td>{{ $wk->name }}</td>
                                        <td>{{ $wk->nomor_induk }}</td>
                                        <td>{{ $wk->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan Kelas -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ringkasan Kelas</h5>
                    <a href="{{ route('tu.kelas.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tingkat</th>
                                    <th>Jurusan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelasLimit as $k)
                                    <tr>
                                        <td>{{ $k->tingkat }}</td>
                                        <td>{{ $k->jurusan->nama }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection