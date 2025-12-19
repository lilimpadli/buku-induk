@extends('layouts.app')

@section('title', 'View Data Wali Kelas')

@section('content')

<h3 class="fw-bold mb-4">View Data Wali Kelas</h3>

{{-- CARD PROFILE --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body d-flex align-items-center">

        <i class="bi bi-person-circle text-secondary" style="font-size: 80px;"></i>

        <div class="ms-3">
            <h4 class="fw-bold mb-1">{{ $data->nama ?? '-' }}</h4>
            <div class="text-muted">NIP: {{ $data->nip ?? '-' }}</div>
            <div class="text-muted">
                {{ $data->kelas->nama_kelas ?? $data->kelas ?? '-' }}
            </div>
        </div>

        <div class="ms-auto">
            <a href="{{ route('kaprog.walikelas.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="#" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
        </div>
    </div>
</div>

{{-- INFORMASI PRIBADI --}}
<div class="card shadow-sm border-0">
    <div class="card-body">

        <h5 class="fw-bold mb-4">Informasi Pribadi</h5>

        <div class="row">

            <div class="col-md-6 mb-3">
                <div class="text-muted small">Nama Lengkap</div>
                <div class="fw-semibold">{{ $data->nama_lengkap ?? '-' }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="text-muted small">Jenis Kelamin</div>
                <div class="fw-semibold">{{ $data->jenis_kelamin ?? '-' }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="text-muted small">Tanggal Lahir</div>
                <div class="fw-semibold">{{ $data->tgl_lahir ?? '-' }}</div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="text-muted small">Agama</div>
                <div class="fw-semibold">{{ $data->agama ?? '-' }}</div>
            </div>

            <div class="col-12 mb-3">
                <div class="text-muted small">Alamat</div>
                <div class="fw-semibold">{{ $data->alamat ?? '-' }}</div>
            </div>

        </div>

    </div>
</div>

@endsection
