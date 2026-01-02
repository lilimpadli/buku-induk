@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')

<div class="container-fluid">
    <!-- JUDUL -->
    <h2 class="fw-bold mb-4">Data Rombel</h2>

    <!-- INFO PAGINATION -->
    @if($rombels->total() > 0)
        <p class="text-muted mb-3">
            Menampilkan {{ $rombels->firstItem() }}-{{ $rombels->lastItem() }} dari {{ $rombels->total() }} rombel
        </p>
    @endif

    <!-- FILTER + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <form action="{{ route('kurikulum.kelas.index') }}" method="GET" class="d-flex">
            <div class="input-group" style="max-width: 280px;">
                <input type="text" name="search" class="form-control" placeholder="Cari rombel" value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
        
        <a href="{{ route('kurikulum.kelas.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i> Tambah Rombel
        </a>
    </div>

    <!-- KARTU KELAS -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @forelse($rombels as $rombel)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 {{ $rombel->id == 5 ? 'bg-primary text-white' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold {{ $rombel->id == 5 ? 'text-white' : '' }}">{{ $rombel->nama }}</h5>
                            <span class="badge bg-secondary">ID: {{ $rombel->id }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <p class="mb-1 {{ $rombel->id == 5 ? 'text-white-50' : 'text-muted' }}">Kelas: {{ $rombel->kelas->tingkat ?? '-' }} {{ $rombel->kelas->jurusan->nama ?? '-' }}</p>
                            <p class="mb-0 {{ $rombel->id == 5 ? 'text-white-50' : 'text-muted' }}">Wali Rombel: {{ $rombel->guru->nama ?? '-' }}</p>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kurikulum.kelas.show', $rombel->id) }}" 
                               class="btn {{ $rombel->id == 5 ? 'btn-light' : 'btn-outline-primary' }} btn-sm">
                                Detail
                            </a>
                            
                            <div class="dropdown">
                                <button class="btn {{ $rombel->id == 5 ? 'btn-light' : 'btn-outline-secondary' }} btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $rombel->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Lebih
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $rombel->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('kurikulum.kelas.edit', $rombel->id) }}">
                                            <i class="fa fa-edit me-2"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('kurikulum.kelas.destroy', $rombel->id) }}" method="POST">
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
                    Tidak ada data rombel
                </div>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    @if($rombels->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $rombels->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>

@endsection