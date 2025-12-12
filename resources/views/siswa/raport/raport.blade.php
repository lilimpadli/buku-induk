@extends('layouts.app')

@section('title', 'Daftar Raport')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Raport</h3>
    </div>

    <!-- Informasi Siswa -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Siswa</h5>
            <table class="table table-bordered">
                <tr>
                    <th width="20%">Nama Lengkap</th>
                    <td width="30%">{{ $siswa->nama_lengkap }}</td>
                    <th width="20%">NISN</th>
                    <td width="30%">{{ $siswa->nisn }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $siswa->rombel->nama ?? '-' }}</td>
                    <th>Jurusan</th>
                    <td>{{ $siswa->rombel->kelas->jurusan->nama ?? '-' }}</td>
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
@endsection