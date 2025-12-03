@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Dashboard Wali Kelas</h1>

        <!-- Tombol Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">
                Logout
            </button>
        </form>
    </div>

    <p>Selamat datang di dashboard wali kelas.</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h5>Daftar Siswa</h5>
                    <p class="text-muted">Kelola data siswa</p>
                    <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-primary">Lihat</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-3x text-success mb-3"></i>
                    <h5>Nilai Raport</h5>
                    <p class="text-muted">Lihat nilai raport siswa</p>
                    <a href="{{ route('walikelas.nilai_raport.index') }}" class="btn btn-success">Lihat Nilai</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <i class="fas fa-edit fa-3x text-warning mb-3"></i>
                    <h5>Input Nilai Raport</h5>
                    <p class="text-muted">Input nilai raport siswa</p>
                    <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="btn btn-warning">Input Nilai</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection