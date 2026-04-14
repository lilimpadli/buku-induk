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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada data TU.</td>
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