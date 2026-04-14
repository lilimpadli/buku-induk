@extends('layouts.app')

@section('title', 'Daftar Guru TU Kepegawaian')

@section('content')
<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Daftar Guru TU Kepegawaian</h3>
        <a href="{{ route('tu_kepegawaian.guru.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Guru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tu_kepegawaian.guru.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Cari Guru</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama, NIP, email..." value="{{ $search ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jurusan</label>
                    <select name="jurusan" class="form-select">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id }}" {{ (isset($jurusan_id) && $jurusan_id == $j->id) ? 'selected' : '' }}>{{ $j->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
                        @foreach($roleOptions as $key => $label)
                            <option value="{{ $key }}" {{ (isset($role_filter) && $role_filter == $key) ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-grid">
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
                        <th>#</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Email</th>
                        <th>Jurusan</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gurus as $guru)
                        <tr>
                            <td>{{ $loop->iteration + ($gurus->currentPage() - 1) * $gurus->perPage() }}</td>
                            <td>{{ $guru->nama }}</td>
                            <td>{{ $guru->nip }}</td>
                            <td>{{ $guru->email ?? '-' }}</td>
                            <td>{{ optional($guru->jurusan)->nama ?? '-' }}</td>
                            <td>{{ optional($guru->user)->role ? ucfirst(optional($guru->user)->role) : '-' }}</td>
                            <td>
                                <a href="{{ route('tu_kepegawaian.guru.show', $guru->id) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('tu_kepegawaian.guru.edit', $guru->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('tu_kepegawaian.guru.destroy', $guru->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus guru ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Belum ada guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $gurus->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection