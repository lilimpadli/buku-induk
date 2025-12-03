@extends('layouts.app')

@section('title', 'Raport Siswa')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Raport Siswa</h3>
        <a href="{{ route('siswa.export.pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>

    @if ($siswa->nilaiRaports->count() > 0)
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
                                <th>Predikat</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa->nilaiRaports->groupBy(['tahun_ajaran', 'semester']) as $tahunAjaran => $semesters)
                                @foreach ($semesters as $semester => $nilais)
                                    <tr>
                                        <td colspan="8" class="table-active text-center fw-bold">
                                            Tahun Ajaran {{ $tahunAjaran }} - Semester {{ $semester }}
                                        </td>
                                    </tr>
                                    @foreach ($nilais as $nilai)
                                        <tr>
                                            <td>{{ $semester }}</td>
                                            <td>{{ $tahunAjaran }}</td>
                                            <td>{{ $nilai->mata_pelajaran }}</td>
                                            <td>{{ $nilai->kkm }}</td>
                                            <td>{{ $nilai->nilai_pengetahuan }}</td>
                                            <td>{{ $nilai->nilai_keterampilan }}</td>
                                            <td>{{ $nilai->predikat_pengetahuan }}</td>
                                            <td>{{ $nilai->deskripsi_pengetahuan }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <div class="text-center py-5">
                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Data Raport</h5>
                <p class="text-muted">Data raport Anda belum tersedia. Silakan hubungi wali kelas untuk informasi lebih lanjut.</p>
            </div>
        </div>
    @endif
</div>
@endsection