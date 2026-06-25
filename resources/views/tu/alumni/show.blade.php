@extends('layouts.app')

@section('title', 'Alumni - ' . ($siswa->nama_lengkap ?? 'Detail'))

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                <div>
                    <h1 class="h3 mb-1">Detail Alumni</h1>
                    <p class="text-muted mb-0">Data alumni lengkap untuk siswa terpilih.</p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('tu.alumni.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('tu.alumni.buku-induk.show', $siswa->id) }}" class="btn btn-primary">
                        <i class="bi bi-book"></i> Buku Induk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" class="rounded-circle mb-3" style="width: 140px; height: 140px; object-fit: cover;" alt="{{ $siswa->nama_lengkap }}">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mb-3" style="width: 140px; height: 140px; font-size: 48px; color: white;">
                            {{ strtoupper(substr($siswa->nama_lengkap ?? 'A', 0, 1)) }}
                        </div>
                    @endif
                    <h4 class="card-title mb-1">{{ $siswa->nama_lengkap ?? 'Nama tidak tersedia' }}</h4>
                    <p class="text-muted mb-1">NIS: {{ $siswa->nis ?? '-' }}</p>
                    <p class="text-muted mb-3">NISN: {{ $siswa->nisn ?? '-' }}</p>

                    <div class="d-grid gap-2">
                        <div class="badge bg-primary">{{ optional(optional($siswa->rombel)->kelas)->tingkat ?? '-' }}</div>
                        <div class="badge bg-info text-dark">{{ optional($siswa->rombel)->nama ?? 'Rombel tidak tersedia' }}</div>
                        <div class="badge bg-secondary">{{ optional(optional($siswa->rombel)->kelas)->jurusan->nama ?? 'Jurusan tidak tersedia' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="row gx-3 gy-3">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Informasi Pribadi</h5>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-sm-4">Tanggal Lahir</dt>
                                <dd class="col-sm-8">{{ optional($siswa)->tempat_lahir ? $siswa->tempat_lahir . ', ' : '' }}{{ optional($siswa)->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') : '-' }}</dd>

                                <dt class="col-sm-4">Jenis Kelamin</dt>
                                <dd class="col-sm-8">{{ $siswa->jenis_kelamin ?? '-' }}</dd>

                                <dt class="col-sm-4">Agama</dt>
                                <dd class="col-sm-8">{{ $siswa->agama ?? '-' }}</dd>

                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8">{{ $siswa->alamat ?? '-' }}</dd>

                                <dt class="col-sm-4">Nomor Telepon</dt>
                                <dd class="col-sm-8">{{ $siswa->telepon ?? ($siswa->hp ?? '-') }}</dd>

                                <dt class="col-sm-4">Status Alumni</dt>
                                <dd class="col-sm-8">Lulus</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Ayah</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Nama:</strong> {{ optional($siswa->ayah)->nama ?? '-' }}</p>
                            <p class="mb-1"><strong>Pekerjaan:</strong> {{ optional($siswa->ayah)->pekerjaan ?? '-' }}</p>
                            <p class="mb-1"><strong>Telepon:</strong> {{ optional($siswa->ayah)->hp ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Ibu</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Nama:</strong> {{ optional($siswa->ibu)->nama ?? '-' }}</p>
                            <p class="mb-1"><strong>Pekerjaan:</strong> {{ optional($siswa->ibu)->pekerjaan ?? '-' }}</p>
                            <p class="mb-1"><strong>Telepon:</strong> {{ optional($siswa->ibu)->hp ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Wali</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Nama:</strong> {{ optional($siswa->wali)->nama ?? '-' }}</p>
                            <p class="mb-1"><strong>Hubungan:</strong> {{ optional($siswa->wali)->hubungan ?? '-' }}</p>
                            <p class="mb-1"><strong>Telepon:</strong> {{ optional($siswa->wali)->hp ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
