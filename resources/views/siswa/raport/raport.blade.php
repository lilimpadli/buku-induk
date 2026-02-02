@extends('layouts.app')

@section('title', 'Daftar Raport')

@section('content')
<style>
    .report-container{max-width:1100px;margin:0 auto;padding:0 1rem;}
    .table td, .table th{word-wrap:break-word;white-space:normal;}
    .table-responsive{overflow-x:auto;}
    /* Desktop: 2x2 layout */
    .info-table{table-layout:auto;width:100%;}
    /* Mobile: stack into 4 compact rows */
    @media (max-width:768px){
        .report-container{padding:0 0.5rem;}
        .info-table{display:block; width:100%;}
        .info-table tr{display:flex;flex-wrap:wrap;margin-bottom:0.5rem;}
        .info-table th, .info-table td{flex:0 0 50%;padding:0.5rem 0.75rem !important;border:1px solid #e2e8f0;font-size:13px;}
        .info-table th:nth-child(1) { width:100%; order:1; flex-basis:100%; background-color:#f8fafc; }
        .info-table td:nth-child(2) { width:100%; order:2; flex-basis:100%; }
        .info-table th:nth-child(3) { width:100%; order:3; flex-basis:100%; background-color:#f8fafc; }
        .info-table td:nth-child(4) { width:100%; order:4; flex-basis:100%; }
    }
</style>

<div class="container-fluid mt-4">
    <div class="report-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Raport</h3>
    </div>

    <!-- Informasi Siswa -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Siswa</h5>
            <table class="table table-bordered info-table">
                <tr>
                    <th width="25%">Nama Lengkap</th>
                    <td width="25%">{{ $siswa->nama_lengkap }}</td>
                    <th width="25%">NISN</th>
                    <td width="25%">{{ $siswa->nisn }}</td>
                </tr>
                <tr>
                    <th width="25%">Kelas</th>
                    <td width="25%">{{ $siswa->rombel->nama ?? '-' }}</td>
                    <th width="25%">Jurusan</th>
                    <td width="25%">{{ $siswa->rombel->kelas->jurusan->nama ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    @if ($raports->count() > 0)
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tahun Ajaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($raports as $index => $raport)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $raport->tahun_ajaran }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#semesterModal{{ $index }}">
                                            <i class="fas fa-eye"></i> Lihat Raport
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Modal untuk pemilihan semester -->
                                <div class="modal fade" id="semesterModal{{ $index }}" tabindex="-1" aria-labelledby="semesterModalLabel{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="semesterModalLabel{{ $index }}">Pilih Semester</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Tahun Ajaran: <strong>{{ $raport->tahun_ajaran }}</strong></p>
                                                <p>Silakan pilih semester yang ingin dilihat:</p>
                                                <div class="d-grid gap-2">
                                                    <a href="{{ route('siswa.raport.show', ['semester' => 'Ganjil', 'tahun' => str_replace('/','-',$raport->tahun_ajaran)]) }}" class="btn btn-outline-primary">
                                                        <i class="fas fa-file-alt me-2"></i> Semester Ganjil
                                                    </a>
                                                    <a href="{{ route('siswa.raport.show', ['semester' => 'Genap', 'tahun' => str_replace('/','-',$raport->tahun_ajaran)]) }}" class="btn btn-outline-primary">
                                                        <i class="fas fa-file-alt me-2"></i> Semester Genap
                                                    </a>

                                                    <a href="{{ route('siswa.raport.pdf', ['semester' => 'Ganjil', 'tahun' => str_replace('/','-',$raport->tahun_ajaran)]) }}" class="btn btn-outline-danger" target="_blank">
                                                        <i class="bi bi-file-earmark-pdf me-2"></i> Cetak PDF Ganjil
                                                    </a>
                                                    <a href="{{ route('siswa.raport.pdf', ['semester' => 'Genap', 'tahun' => str_replace('/','-',$raport->tahun_ajaran)]) }}" class="btn btn-outline-danger" target="_blank">
                                                        <i class="bi bi-file-earmark-pdf me-2"></i> Cetak PDF Genap
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum Ada Data Raport</h5>
            <p class="text-muted">Data raport Anda belum tersedia. Silakan hubungi wali kelas untuk informasi lebih lanjut.</p>
        </div>
    @endif
    </div>
</div>
@endsection