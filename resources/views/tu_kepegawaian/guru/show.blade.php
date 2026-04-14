@extends('layouts.app')

@section('title', 'Detail Guru: ' . $guru->nama)

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Guru</h3>
        <div>
            <a href="{{ route('tu_kepegawaian.guru.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('tu_kepegawaian.guru.edit', $guru->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-md-6">
                    <strong>Nama</strong>
                    <div>{{ $guru->nama }}</div>
                </div>
                <div class="col-md-6">
                    <strong>NIP</strong>
                    <div>{{ $guru->nip }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Nomor Induk</strong>
                    <div>{{ optional($guru->user)->nomor_induk ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Email</strong>
                    <div>{{ $guru->email ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Telepon</strong>
                    <div>{{ $guru->telepon ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Jenis Kelamin</strong>
                    <div>{{ $guru->jenis_kelamin === 'L' ? 'Laki-laki' : ($guru->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Tempat Lahir</strong>
                    <div>{{ $guru->tempat_lahir ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Tanggal Lahir</strong>
                    <div>{{ $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d/m/Y') : '-' }}</div>
                </div>
                <div class="col-12">
                    <strong>Alamat</strong>
                    <div>{{ $guru->alamat ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Jurusan</strong>
                    <div>{{ optional($guru->jurusan)->nama ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Role</strong>
                    <div>{{ optional($guru->user)->role ? ucfirst(optional($guru->user)->role) : '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($guru->rombels && $guru->rombels->count())
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Rombel yang Diampu</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Rombel</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guru->rombels as $rombel)
                                <tr>
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