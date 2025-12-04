@extends('layouts.app')

@section('title', 'Laporan Nilai Raport')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Laporan Nilai Raport</h3>
        <div>
            <a href="{{ route('tu.dashboard') }}" class="btn btn-secondary me-2">Kembali</a>
            <button class="btn btn-success">Export Excel</button>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Nilai</th>
                            <th>Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nilaiRaports as $nilai)
                            <tr>
                                <td>{{ $nilai->siswa->nama_lengkap }}</td>
                                <td>{{ $nilai->siswa->kelas }}</td>
                                <td>{{ $nilai->mata_pelajaran }}</td>
                                <td>{{ $nilai->semester }}</td>
                                <td>{{ $nilai->tahun_ajaran }}</td>
                                <td>{{ $nilai->nilai_pengetahuan }}</td>
                                <td>{{ $nilai->predikat_pengetahuan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                {{ $nilaiRaports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection