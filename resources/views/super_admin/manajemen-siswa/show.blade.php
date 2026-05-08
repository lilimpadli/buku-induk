@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $siswa->nama_lengkap)

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Siswa</h2>
            <p class="text-muted mb-0">{{ $siswa->nama_lengkap }}</p>
        </div>
        <div>
            <a href="{{ route('super_admin.manajemen-siswa.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('super_admin.manajemen-siswa.edit', $siswa->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-4">Informasi Siswa</h5>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tbody>
                            <tr><th>NIS</th><td>{{ $siswa->nis }}</td></tr>
                            <tr><th>NISN</th><td>{{ $siswa->nisn }}</td></tr>
                            <tr><th>Nama Lengkap</th><td>{{ $siswa->nama_lengkap }}</td></tr>
                            <tr><th>Tempat, Tanggal Lahir</th><td>{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') : '-' }}</td></tr>
                            <tr><th>Jenis Kelamin</th><td>{{ $siswa->jenis_kelamin }}</td></tr>
                            <tr><th>Agama</th><td>{{ $siswa->agama }}</td></tr>
                            <tr><th>No HP</th><td>{{ $siswa->no_hp ?? '-' }}</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tbody>
                            <tr><th>Alamat</th><td>{{ $siswa->alamat_lengkap ?? (trim(sprintf('Dusun %s, RT/RW %s/%s, %s, %s, %s', $siswa->dusun, $siswa->rt, $siswa->rw, $siswa->kelurahan, $siswa->kecamatan, $siswa->kode_pos)) ?: '-') }}</td></tr>
                            <tr><th>Rombel</th><td>{{ $siswa->rombel->nama ?? '-' }}</td></tr>
                            <tr><th>Kelas</th><td>{{ $siswa->rombel->kelas->nama ?? '-' }}</td></tr>
                            <tr><th>Jurusan</th><td>{{ $siswa->rombel->kelas->jurusan->nama ?? '-' }}</td></tr>
                            <tr><th>Tanggal Diterima</th><td>{{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->format('d-m-Y') : '-' }}</td></tr>
                            <tr><th>Status</th><td>{{ $siswa->status ?? '-' }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="mb-4">Data Orang Tua / Wali</h5>
            <div class="row">
                <div class="col-md-4">
                    <strong>Ayah</strong>
                    <p class="mb-1">{{ $siswa->ayah->nama ?? '-' }}</p>
                    <p class="mb-1">{{ $siswa->ayah->pekerjaan ?? '-' }}</p>
                    <p class="mb-0">{{ $siswa->ayah->telepon ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Ibu</strong>
                    <p class="mb-1">{{ $siswa->ibu->nama ?? '-' }}</p>
                    <p class="mb-1">{{ $siswa->ibu->pekerjaan ?? '-' }}</p>
                    <p class="mb-0">{{ $siswa->ibu->telepon ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Wali</strong>
                    <p class="mb-1">{{ $siswa->wali->nama ?? '-' }}</p>
                    <p class="mb-1">{{ $siswa->wali->pekerjaan ?? '-' }}</p>
                    <p class="mb-0">{{ $siswa->wali->telepon ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
