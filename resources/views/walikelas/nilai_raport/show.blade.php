@extends('layouts.app')

@section('title', 'Nilai Raport Siswa')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Nilai Raport: {{ $siswa->nama_lengkap }}</h3>
        <a href="{{ route('walikelas.nilai_raport.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    @if ($nilaiRaports->count() > 0)
        <div class="card shadow">
            <div class="card-body">
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nilaiRaports as $nilai)
                                <tr>
                                    <td>{{ $nilai->semester }}</td>
                                    <td>{{ $nilai->tahun_ajaran }}</td>
                                    <td>{{ $nilai->mata_pelajaran }}</td>
                                    <td>{{ $nilai->kkm }}</td>
                                    <td>
                                        Angka: {{ $nilai->nilai_pengetahuan }}<br>
                                        Predikat: {{ $nilai->predikat_pengetahuan }}
                                    </td>
                                    <td>
                                        Angka: {{ $nilai->nilai_keterampilan }}<br>
                                        Predikat: {{ $nilai->predikat_keterampilan }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Belum ada nilai raport untuk siswa ini.
        </div>
    @endif
</div>
@endsection