@extends('layouts.app')

@section('title', 'Detail Guru: ' . $guru->nama)

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Guru</h3>
        <div>
            <a href="{{ route('tu_kepegawaian.guru.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('tu_kepegawaian.guru.edit', $guru->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row gy-3">
                <!-- Nama -->
                <div class="col-md-6">
                    <strong>Nama</strong>
                    <div class="fs-5">{{ $guru->nama }}</div>
                </div>

                <!-- NIP -->
                <div class="col-md-6">
                    <strong>NIP</strong>
                    <div>{{ $guru->nip ?? '-' }}</div>
                </div>

                <!-- Status Kepegawaian -->
                <div class="col-md-6">
                    <strong>Status Kepegawaian</strong>
                    <div>
                        @php
                            $statusColors = [
                                'PNS' => 'primary',
                                'PPPK' => 'info',
                                'Honorer' => 'warning',
                                'Guru Tetap Yayasan' => 'success',
                                'Guru Tidak Tetap' => 'secondary'
                            ];
                            $color = $statusColors[$guru->status_kepegawaian] ?? 'secondary';
                        @endphp
                        @if($guru->status_kepegawaian)
                            <span class="badge bg-{{ $color }} text-white">{{ $guru->status_kepegawaian }}</span>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <!-- Pendidikan -->
                <div class="col-md-6">
                    <strong>Pendidikan Terakhir</strong>
                    <div>
                        @if($guru->pendidikan)
                            <span class="badge bg-secondary">{{ $guru->pendidikan }}</span>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <!-- Gelar Depan -->
                <div class="col-md-6">
                    <strong>Gelar Depan</strong>
                    <div>{{ $guru->gelar_depan ?? '-' }}</div>
                </div>

                <!-- Gelar Belakang -->
                <div class="col-md-6">
                    <strong>Gelar Belakang</strong>
                    <div>{{ $guru->gelar_belakang ?? '-' }}</div>
                </div>

                <!-- Nomor Induk -->
                <div class="col-md-6">
                    <strong>Nomor Induk</strong>
                    <div>{{ optional($guru->user)->nomor_induk ?? '-' }}</div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <strong>Email</strong>
                    <div>{{ $guru->email ?? '-' }}</div>
                </div>

                <!-- Telepon -->
                <div class="col-md-6">
                    <strong>Telepon</strong>
                    <div>{{ $guru->telepon ?? '-' }}</div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="col-md-6">
                    <strong>Jenis Kelamin</strong>
                    <div>
                        @if($guru->jenis_kelamin === 'L')
                            <i class="fas fa-mars text-primary"></i> Laki-laki
                        @elseif($guru->jenis_kelamin === 'P')
                            <i class="fas fa-venus text-danger"></i> Perempuan
                        @else
                            -
                        @endif
                    </div>
                </div>

                <!-- Tempat Lahir -->
                <div class="col-md-6">
                    <strong>Tempat Lahir</strong>
                    <div>{{ $guru->tempat_lahir ?? '-' }}</div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="col-md-6">
                    <strong>Tanggal Lahir</strong>
                    <div>{{ $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d/m/Y') : '-' }}</div>
                </div>

                <!-- Alamat -->
                <div class="col-12">
                    <strong>Alamat</strong>
                    <div>{{ $guru->alamat ?? '-' }}</div>
                </div>

                <!-- Jurusan -->
                <div class="col-md-6">
                    <strong>Jurusan</strong>
                    <div>{{ optional($guru->jurusan)->nama ?? '-' }}</div>
                </div>

                <!-- Role -->
                <div class="col-md-6">
                    <strong>Role</strong>
                    <div>{{ optional($guru->user)->role ? ucfirst(optional($guru->user)->role) : '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rombel yang Diampu -->
    @if($guru->rombels && $guru->rombels->count())
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-users me-2"></i> Rombel yang Diampu
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Rombel</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guru->rombels as $rombel)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rombel->nama }}</td>
                                    <td>{{ optional($rombel->kelas)->tingkat ?? '-' }}</td>
                                    <td>{{ optional(optional($rombel->kelas)->jurusan)->nama ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection