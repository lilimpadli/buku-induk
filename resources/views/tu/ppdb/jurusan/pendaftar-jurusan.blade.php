@extends('layouts.app')

@section('title', 'PPDB - Semua Pendaftar ' . $jurusan->nama)

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Semua Pendaftar Jurusan: {{ $jurusan->nama }}</h5>
                <small class="text-muted">Total: {{ $pendaftars->count() }} pendaftar</small>
            </div>
            <div>
                <a href="{{ route('tu.ppdb.jurusan.show', $jurusan->id) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! session('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>NISN</th>
                            <th>Jenis Kelamin</th>
                            <th>Sesi</th>
                            <th>Jalur</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendaftars as $pendaftar)
                            <tr>
                                <td>{{ $pendaftar->nama_lengkap }}</td>
                                <td>{{ $pendaftar->nisn ?? '-' }}</td>
                                <td>{{ $pendaftar->jenis_kelamin }}</td>
                                <td>{{ optional($pendaftar->sesi)->tahun_ajaran ?? '-' }}</td>
                                <td>{{ optional($pendaftar->jalur)->nama_jalur ?? '-' }}</td>
                                <td>
                                    @if($pendaftar->status == 'diterima')
                                        <span class="badge bg-warning">Diterima</span>
                                    @elseif($pendaftar->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $pendaftar->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $pendaftar->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($pendaftar->status == 'diterima')
                                        <a href="{{ route('tu.ppdb.assign.form', $pendaftar->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-user-plus"></i> Assign Rombel
                                        </a>
                                    @else
                                        <span class="text-muted">Sudah diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada pendaftar untuk jurusan ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection