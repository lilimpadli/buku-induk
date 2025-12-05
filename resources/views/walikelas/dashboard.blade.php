@extends('layouts.app')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<div class="container mt-4">

    <h3 class="mb-1">Dashboard Wali Kelas</h3>
    <p class="text-muted">Selamat datang, {{ auth()->user()->name }}!</p>

    <div class="row mt-4">

        {{-- Daftar Siswa --}}
        <div class="col-md-3 mb-3">
            <a href="{{ route('walikelas.siswa.index') }}" class="text-decoration-none">
                <div class="card shadow-sm hover-card">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h6>Daftar Siswa</h6>
                    </div>
                </div>
            </a>
        </div>

        {{-- Input Nilai Raport --}}
        <div class="col-md-3 mb-3">
            <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="text-decoration-none">
                <div class="card shadow-sm hover-card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-edit fa-2x mb-2"></i>
                        <h6>Input Nilai Rapor</h6>
                    </div>
                </div>
            </a>
        </div>

        {{-- Input Ekstrakurikuler --}}
        <div class="col-md-3 mb-3">
            <a href="{{ route('walikelas.siswa.index') }}?menu=ekstra" class="text-decoration-none">
                <div class="card shadow-sm hover-card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-star fa-2x mb-2"></i>
                        <h6>Input Ekstrakurikuler</h6>
                    </div>
                </div>
            </a>
        </div>

        {{-- Input Kehadiran --}}
        <div class="col-md-3 mb-3">
            <a href="{{ route('walikelas.siswa.index') }}?menu=kehadiran" class="text-decoration-none">
                <div class="card shadow-sm hover-card bg-warning text-dark">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-check fa-2x mb-2"></i>
                        <h6>Input Kehadiran</h6>
                    </div>
                </div>
            </a>
        </div>

        {{-- Info Rapor --}}
        <div class="col-md-3 mb-3">
            <a href="{{ route('walikelas.siswa.index') }}?menu=info" class="text-decoration-none">
                <div class="card shadow-sm hover-card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <h6>Info Rapor</h6>
                    </div>
                </div>
            </a>
        </div>

        {{-- Review Rapor --}}
        <div class="col-md-3 mb-3">
            <a href="{{ route('walikelas.nilai_raport.index') }}" class="text-decoration-none">
                <div class="card shadow-sm hover-card bg-secondary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-eye fa-2x mb-2"></i>
                        <h6>Review Rapor</h6>
                    </div>
                </div>
            </a>
        </div>

        {{-- Cetak Rapor --}}
        <div class="col-md-3 mb-3">
            <a href="{{ route('walikelas.nilai_raport.index') }}" class="text-decoration-none">
                <div class="card shadow-sm hover-card bg-dark text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-file-pdf fa-2x mb-2"></i>
                        <h6>Cetak Rapor</h6>
                    </div>
                </div>
            </a>
        </div>

    </div>

</div>

<style>
    .hover-card:hover {
        transform: translateY(-5px);
        transition: .2s;
    }
</style>

@endsection
