@extends('layouts.app')

@section('title', 'Data Jurusan')

@section('content')

<div class="container-fluid">
    <!-- JUDUL -->
    <h2 class="fw-bold mb-4">Data Jurusan</h2>

    <!-- INFO PAGINATION -->
    @if($jurusans->total() > 0)
        <p class="text-muted mb-3">
            Menampilkan {{ $jurusans->firstItem() }}-{{ $jurusans->lastItem() }} dari {{ $jurusans->total() }} jurusan
        </p>
    @endif

    <!-- FILTER + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <form action="{{ route('kurikulum.jurusan.index') }}" method="GET" class="d-flex">
            <div class="input-group" style="max-width: 280px;">
                <input type="text" name="search" class="form-control" placeholder="Cari jurusan" value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
        
        <a href="{{ route('kurikulum.jurusan.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i> Tambah Jurusan
        </a>
    </div>

    <!-- KARTU JURUSAN -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @forelse($jurusans as $jurusan)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold">{{ $jurusan->nama }}</h5>
                            <span class="badge bg-secondary">Kode: {{ $jurusan->kode }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <p class="mb-0 text-muted">Total Kelas: {{ $jurusan->kelas->count() }}</p>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kurikulum.jurusan.show', $jurusan->id) }}" 
                               class="btn btn-outline-primary btn-sm">
                                Detail
                            </a>
                            
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $jurusan->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Lebih
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $jurusan->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('kurikulum.jurusan.edit', $jurusan->id) }}">
                                            <i class="fa fa-edit me-2"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('kurikulum.jurusan.destroy', $jurusan->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fa fa-trash me-2"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Tidak ada data jurusan
                </div>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    @if($jurusans->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $jurusans->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>

@endsection