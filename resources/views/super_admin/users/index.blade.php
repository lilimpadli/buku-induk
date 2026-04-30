@extends('layouts.app')

@section('title', 'Manajemen Users')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Users</h3>
        <a href="#" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Nomor Induk</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Guru/Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->nomor_induk }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $user->role }}</span>
                                </td>
                                <td>
                                    @if($user->guru)
                                        <small class="text-muted">{{ $user->guru->nama }}</small>
                                    @elseif($user->siswa)
                                        <small class="text-muted">{{ $user->siswa->nama_lengkap }}</small>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="#" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus user ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center">Belum ada users</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection