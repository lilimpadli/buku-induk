@extends('layouts.app')

@section('title', 'Daftar TU')

@section('content')
<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Daftar TU</h3>
        <a href="{{ route('tu_kepegawaian.tu.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah TU
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Filter Form -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('tu_kepegawaian.tu.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="role_filter" class="form-label">Filter Role</label>
                    <select name="role" id="role_filter" class="form-select">
                        <option value="">Semua Role</option>
                        <option value="tu" {{ request('role') == 'tu' ? 'selected' : '' }}>TU</option>
                        <option value="tu_kepegawaian" {{ request('role') == 'tu_kepegawaian' ? 'selected' : '' }}>TU Kepegawaian</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Nama</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Cari nama...">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary me-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('tu_kepegawaian.tu.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Reset
                    </a>
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
                        <th>Nomor Induk</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tu as $user)
                        <tr>
                            <td>{{ $loop->iteration + ($tu->currentPage() - 1) * $tu->perPage() }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nomor_induk }}</td>
                            <td>{{ $user->email ?? '-' }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('tu_kepegawaian.tu.edit', $user->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('tu_kepegawaian.tu.destroy', $user->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus TU ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Belum ada data TU.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $tu->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection