@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
       <h2 class="text-dark fw-bold">Daftar Penugasan Guru</h2>
        <a href="{{ route('tu_kepegawaian.penugasan.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Penugasan
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Guru</th>
                            <th>Kategori</th>
                            <th>Mapel</th>
                            <th>Tahun Ajaran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penugasans as $p)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $p->guru->nama ?? '-' }}</td>
                            <td><span class="badge bg-info text-dark">{{ $p->kategori }}</span></td>
                            <td>{{ $p->mapel->nama_mapel ?? '-' }}</td>
                            <td>{{ $p->tahun_ajaran }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data yang tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection