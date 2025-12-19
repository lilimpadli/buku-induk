@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')

<h5 class="fw-bold mb-2">Detail Siswa</h5>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <h6 class="fw-semibold">{{ $siswa->nama_lengkap ?? ($siswa->nama ?? 'Nama tidak tersedia') }}</h6>
        <p class="mb-1"><strong>NIS:</strong> {{ $siswa->nis ?? '-' }}</p>
        <p class="mb-1"><strong>Kelas:</strong> {{ $siswa->kelas ?? ($siswa->rombel->nama ?? '-') }}</p>
        <p class="mb-1"><strong>Jenis Kelamin:</strong> {{ $siswa->jenis_kelamin ?? '-' }}</p>
        <p class="mb-1"><strong>Alamat:</strong> {{ $siswa->alamat ?? '-' }}</p>
        <a href="{{ route('kaprog.dashboard') }}" class="btn btn-sm btn-outline-secondary mt-3">Kembali</a>
    </div>
</div>

@endsection
