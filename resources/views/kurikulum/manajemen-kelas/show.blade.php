@extends('layouts.app')

@section('title', 'Detail Rombel: ' . $rombel->nama)

@section('content')
<div class="container-fluid">

    <!-- JUDUL DAN TOMBOL KEMBALI -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Rombel</h2>
            <p class="text-muted mb-0">{{ $rombel->nama }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('kurikulum.kelas.export', $rombel->id) }}" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i> Export Rombel
            </a>
            <a href="{{ request()->header('referer') ?: route('kurikulum.kelas.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <!-- INFO ROMBEL -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <p class="text-muted mb-1">Tingkat</p>
                    <h6 class="fw-bold">{{ $rombel->kelas->tingkat ?? '-' }}</h6>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <p class="text-muted mb-1">Jurusan</p>
                    <h6 class="fw-bold">{{ $rombel->kelas->jurusan->nama ?? '-' }}</h6>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">Wali Kelas</p>
                    <h6 class="fw-bold">{{ $rombel->guru->nama ?? '-' }}</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- DAFTAR SISWA -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 pt-4">
            <h5 class="fw-bold mb-0">Daftar Siswa</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">NO</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rombel->siswa as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->nama_lengkap }}</td>
                                <td>{{ $siswa->nis }}</td>
                                <td>{{ $siswa->jenis_kelamin ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Belum ada siswa di rombel ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection