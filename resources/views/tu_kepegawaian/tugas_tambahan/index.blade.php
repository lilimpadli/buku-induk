@extends('layouts.app')

@section('title', 'Daftar Tugas Tambahan')

@section('content')
<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Daftar Tugas Tambahan</h3>
        <a href="{{ route('tu_kepegawaian.tugas_tambahan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Tugas Tambahan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tu_kepegawaian.tugas_tambahan.index') }}" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label">Cari Guru</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama, NIP..." value="{{ $search ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tipe Tugas Tambahan</label>
                    <select name="tipe" class="form-select">
                        <option value="">Semua Tipe</option>
                        @foreach($tipeOptions as $key => $label)
                            <option value="{{ $key }}" {{ (isset($filterTipe) && $filterTipe == $key) ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button class="btn btn-secondary">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Guru</th>
                        <th>NIP</th>
                        <th>Tipe Tugas Tambahan</th>
                        <th>Tahun Ajaran</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tugasTambahans as $tugas)
                        <tr>
                            <td>{{ $loop->iteration + ($tugasTambahans->currentPage() - 1) * $tugasTambahans->perPage() }}</td>
                            <td>
                                <strong>{{ $tugas->guru->nama ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $tugas->guru->user?->name ?? '-' }}</small>
                            </td>
                            <td>{{ $tugas->guru->nip ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">{{ \App\Models\TugasTambahan::getTipeLabel($tugas->tipe_tugas) }}</span>
                            </td>
                            <td>{{ $tugas->tahun_ajaran ?? '-' }}</td>
                            <td>
                                <a href="{{ route('tu_kepegawaian.tugas_tambahan.show', $tugas->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('tu_kepegawaian.tugas_tambahan.edit', $tugas->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('tu_kepegawaian.tugas_tambahan.destroy', $tugas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tugas tambahan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mt-2">Tidak ada data tugas tambahan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($tugasTambahans->hasPages())
        <div class="mt-4">
            {{ $tugasTambahans->links() }}
        </div>
    @endif
</div>
@endsection
