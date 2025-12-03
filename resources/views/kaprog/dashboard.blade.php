@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<h4 class="mb-3">Dashboard Program Keahlian</h4>

<p>Selamat Datang, <strong>Lili Muhammad Padli</strong></p>
<p class="text-muted">Berikut adalah ringkasan data penting untuk program keahlian Anda</p>

<div class="row g-3 mb-4">
    
    <div class="col-md-4">
        <div class="card card-info p-4 text-center shadow-sm">
            <span class="text-muted">Total Siswa Aktif</span>
            <h2>352</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-info p-4 text-center shadow-sm">
            <span class="text-muted">Jumlah Kelas</span>
            <h2>9</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-info p-4 text-center shadow-sm">
            <span class="text-muted">Tingkat Kelulusan</span>
            <h2>352</h2>
        </div>
    </div>

</div>

<!-- List siswa -->
<div class="card shadow-sm p-3">

    <div class="d-flex justify-content-between mb-3">
        <h5>Daftar Siswa</h5>
        <a href="#" class="text-primary fw-bold">Lihat Semua</a>
    </div>

    <ul class="list-group">

        <li class="list-group-item d-flex align-items-center">
            <img src="https://ui-avatars.com/api/?name=Aditya+Saputra"
                 class="rounded-circle me-3" width="45">
            Aditya Saputra Setiadi (XII RPL2)
        </li>

        <li class="list-group-item d-flex align-items-center">
            <img src="https://ui-avatars.com/api/?name=Raslina"
                 class="rounded-circle me-3" width="45">
            Raihani Salsabila Azzahra (XII RPL2)
        </li>

        <li class="list-group-item d-flex align-items-center">
            <img src="https://ui-avatars.com/api/?name=Fitri"
                 class="rounded-circle me-3" width="45">
            Fitri Dewi Lestari (XII PPLG 3)
        </li>

        <li class="list-group-item d-flex align-items-center">
            <img src="https://ui-avatars.com/api/?name=Ihsan"
                 class="rounded-circle me-3" width="45">
            Ihsan Nurfallah (XII PPLG 2)
        </li>

    </ul>

</div>

@endsection
