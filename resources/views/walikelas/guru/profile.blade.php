@extends('layouts.app')

@section('title', 'Profil Guru')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="mb-3">
                        @if(isset($user) && $user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" style="width:120px;height:120px;color:white;font-size:28px;font-weight:700;">
                                {{ $guru && $guru->nama ? strtoupper(substr($guru->nama,0,1)) : 'G' }}
                            </div>
                        @endif
                    </div>

                    <h5 class="mb-0">{{ $guru->nama ?? '-' }}</h5>
                    <p class="text-muted mb-1">NIP: {{ $guru->nip ?? '-' }}</p>
                    <p class="text-muted small">{{ $guru->email ?? '' }}</p>

                    <div class="mt-3">
                        <a href="{{ route('guru.profile.edit') }}" class="btn btn-primary btn-sm">Edit Profil</a>
                    </div>
                </div>
            </div>

            <div class="card mt-3 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Informasi Singkat</h6>
                    <p class="mb-1"><strong>Tempat, Tgl Lahir:</strong> {{ $guru->tempat_lahir ?? '-' }}, {{ $guru->tanggal_lahir ?? '-' }}</p>
                    <p class="mb-1"><strong>Jenis Kelamin:</strong> {{ $guru->jenis_kelamin ?? '-' }}</p>
                    <p class="mb-0"><strong>Alamat:</strong> {{ $guru->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Detail Profil</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr><th>Nama</th><td>{{ $guru->nama ?? '-' }}</td></tr>
                                <tr><th>NIP</th><td>{{ $guru->nip ?? '-' }}</td></tr>
                                <tr><th>Email</th><td>{{ $guru->email ?? '-' }}</td></tr>
                                <tr><th>Tempat Lahir</th><td>{{ $guru->tempat_lahir ?? '-' }}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr><th>Tanggal Lahir</th><td>{{ $guru->tanggal_lahir ?? '-' }}</td></tr>
                                <tr><th>Jenis Kelamin</th><td>{{ $guru->jenis_kelamin ?? '-' }}</td></tr>
                                <tr><th>Alamat</th><td>{{ $guru->alamat ?? '-' }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
