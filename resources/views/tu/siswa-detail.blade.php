@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Siswa: {{ $siswa->nama_lengkap }}</h3>
        <div>
            <a href="{{ route('tu.siswa.edit', $siswa->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i> Edit Data
            </a>
            <a href="{{ route('tu.siswa') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Informasi Pribadi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%">NIS</td>
                            <td>: {{ $siswa->nis }}</td>
                        </tr>
                        <tr>
                            <td>NISN</td>
                            <td>: {{ $siswa->nisn }}</td>
                        </tr>
                        <tr>
                            <td>Tempat Lahir</td>
                            <td>: {{ $siswa->tempat_lahir }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>: {{ $siswa->tanggal_lahir }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>: {{ $siswa->jenis_kelamin }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%">Agama</td>
                            <td>: {{ $siswa->agama }}</td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td>: {{ $siswa->kelas }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: {{ $siswa->alamat }}</td>
                        </tr>
                        <tr>
                            <td>No. HP</td>
                            <td>: {{ $siswa->no_hp }}</td>
                        </tr>
                        <tr>
                            <td>Sekolah Asal</td>
                            <td>: {{ $siswa->sekolah_asal }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Orang Tua -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Data Orang Tua</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Data Ayah</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%">Nama</td>
                            <td>: {{ $siswa->nama_ayah }}</td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>: {{ $siswa->pekerjaan_ayah }}</td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td>: {{ $siswa->telepon_ayah }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>Data Ibu</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%">Nama</td>
                            <td>: {{ $siswa->nama_ibu }}</td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>: {{ $siswa->pekerjaan_ibu }}</td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td>: {{ $siswa->telepon_ibu }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Nilai Raport -->
    <div class="card shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0">Nilai Raport</h5>
        </div>
        <div class="card-body">
            @if ($siswa->nilaiRaports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Semester</th>
                                <th>Tahun Ajaran</th>
                                <th>Mata Pelajaran</th>
                                <th>KKM</th>
                                <th>Nilai Pengetahuan</th>
                                <th>Nilai Keterampilan</th>
                                <th>Predikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa->nilaiRaports as $nilai)
                                <tr>
                                    <td>{{ $nilai->semester }}</td>
                                    <td>{{ $nilai->tahun_ajaran }}</td>
                                    <td>{{ $nilai->mata_pelajaran }}</td>
                                    <td>{{ $nilai->kkm }}</td>
                                    <td>{{ $nilai->nilai_pengetahuan }}</td>
                                    <td>{{ $nilai->nilai_keterampilan }}</td>
                                    <td>{{ $nilai->predikat_pengetahuan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    Belum ada data nilai raport untuk siswa ini.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection