@extends('layouts.app')

@section('title', 'Detail Alumni')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('tu.alumni.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle"></i> Detail Alumni: {{ $siswa->nama_lengkap }}
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Data Pribadi -->
                    <div class="mb-4">
                        <h6 class="mb-3">
                            <span class="badge bg-primary">Data Pribadi</span>
                        </h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>NIS:</strong></p>
                                <p class="text-secondary">{{ $siswa->nis }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>NISN:</strong></p>
                                <p class="text-secondary">{{ $siswa->nisn }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Jenis Kelamin:</strong></p>
                                <p class="text-secondary">{{ $siswa->jenis_kelamin }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Agama:</strong></p>
                                <p class="text-secondary">{{ $siswa->agama }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p class="mb-1"><strong>Tempat, Tanggal Lahir:</strong></p>
                                <p class="text-secondary">{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p class="mb-1"><strong>Alamat:</strong></p>
                                <p class="text-secondary">{{ $siswa->alamat }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p class="mb-1"><strong>No. HP:</strong></p>
                                <p class="text-secondary">{{ $siswa->no_hp ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Sekolah -->
                    <hr>
                    <div class="mb-4">
                        <h6 class="mb-3">
                            <span class="badge bg-info">Data Sekolah</span>
                        </h6>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p class="mb-1"><strong>Rombel Terakhir:</strong></p>
                                <p class="text-secondary">{{ optional($siswa->rombel)->nama ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p class="mb-1"><strong>Kelas:</strong></p>
                                <p class="text-secondary">{{ optional($siswa->rombel->kelas)->tingkat ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p class="mb-1"><strong>Jurusan:</strong></p>
                                <p class="text-secondary">{{ optional($siswa->rombel->kelas->jurusan)->nama ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    @if($siswa->ayah || $siswa->ibu || $siswa->wali)
                        <hr>
                        <div class="mb-4">
                            <h6 class="mb-3">
                                <span class="badge bg-success">Data Orang Tua / Wali</span>
                            </h6>

                            @if($siswa->ayah)
                                <div class="mb-3">
                                    <p class="mb-1"><strong>Ayah:</strong></p>
                                    <p class="text-secondary">{{ $siswa->ayah->nama }}</p>
                                    <p class="mb-1"><small><strong>Pekerjaan:</strong></small></p>
                                    <p class="text-secondary"><small>{{ $siswa->ayah->pekerjaan }}</small></p>
                                    <p class="mb-1"><small><strong>Telepon:</strong></small></p>
                                    <p class="text-secondary"><small>{{ $siswa->ayah->telepon ?? '-' }}</small></p>
                                </div>
                            @endif

                            @if($siswa->ibu)
                                <div class="mb-3">
                                    <p class="mb-1"><strong>Ibu:</strong></p>
                                    <p class="text-secondary">{{ $siswa->ibu->nama }}</p>
                                    <p class="mb-1"><small><strong>Pekerjaan:</strong></small></p>
                                    <p class="text-secondary"><small>{{ $siswa->ibu->pekerjaan }}</small></p>
                                    <p class="mb-1"><small><strong>Telepon:</strong></small></p>
                                    <p class="text-secondary"><small>{{ $siswa->ibu->telepon ?? '-' }}</small></p>
                                </div>
                            @endif

                            @if($siswa->wali)
                                <div class="mb-3">
                                    <p class="mb-1"><strong>Wali:</strong></p>
                                    <p class="text-secondary">{{ $siswa->wali->nama }}</p>
                                    <p class="mb-1"><small><strong>Pekerjaan:</strong></small></p>
                                    <p class="text-secondary"><small>{{ $siswa->wali->pekerjaan }}</small></p>
                                    <p class="mb-1"><small><strong>Telepon:</strong></small></p>
                                    <p class="text-secondary"><small>{{ $siswa->wali->telepon ?? '-' }}</small></p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if($siswa->foto)
                <div class="card shadow-sm">
                    <img src="{{ asset('storage/' . $siswa->foto) }}" class="card-img-top" alt="Foto {{ $siswa->nama_lengkap }}" style="height: 300px; object-fit: cover;">
                </div>
            @else
                <div class="card shadow-sm text-center py-5">
                    <i class="bi bi-image text-secondary" style="font-size: 4rem;"></i>
                    <p class="text-secondary mt-3">Foto tidak tersedia</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
