@extends('layouts.app')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<div class="container mt-4">
    <div class="row mb-3 align-items-center">
        <div class="col-md-8">
            <h3 class="mb-0">Dashboard Wali Kelas</h3>
            <small class="text-muted">Ringkasan cepat data siswa dan aksi cepat</small>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-outline-primary">Kelola Siswa</a>
            <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="btn btn-primary">Input Nilai Raport</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Total Siswa</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="mb-0">{{ number_format($total ?? 0) }}</h2>
                            <small class="text-muted">Jumlah keseluruhan siswa</small>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Distribusi Jenis Kelamin</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1"><strong>Laki-laki:</strong> {{ $byGender['Laki-laki'] ?? 0 }}</p>
                            <p class="mb-0"><strong>Perempuan:</strong> {{ $byGender['Perempuan'] ?? 0 }}</p>
                        </div>
                        <div>
                            <i class="fas fa-venus-mars fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Aksi Cepat</h6>
                    <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-sm btn-outline-primary mb-2">Lihat Semua Siswa</a>
                    <a href="{{ route('walikelas.nilai_raport.index') }}" class="btn btn-sm btn-outline-success mb-2">Input Nilai</a>
                    <a href="#" class="btn btn-sm btn-outline-secondary">Cetak Laporan</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">Siswa Terbaru</h6>
                    @if(!empty($recent) && $recent->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Daftar</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent as $r)
                                        <tr>
                                            <td>{{ $r->nama_lengkap }}</td>
                                            <td>{{ $r->nis }}</td>
                                            <td>{{ $r->kelas ?? '-' }}</td>
                                            <td>{{ $r->jenis_kelamin ?? '-' }}</td>
                                            <td>{{ $r->created_at ? $r->created_at->format('Y-m-d') : '-' }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('walikelas.siswa.show', $r->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Belum ada siswa baru.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .hover-card:hover { transform: translateY(-5px); transition: .2s; }
</style>
