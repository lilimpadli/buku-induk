@extends('layouts.app')

@section('title', 'Manajemen Users')

@push('styles')
<style>
.page-header{
    background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
    border-radius: 28px;
    padding: 30px 28px;
    color: white;
    box-shadow: 0 24px 48px rgba(47,83,255,0.14);
    margin-bottom: 28px;
}

.page-title{
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 8px;
}

.page-subtitle{
    color: rgba(255,255,255,0.88);
    margin: 0;
    font-size: 0.98rem;
    line-height: 1.7;
}

.card-modern{
    background: #ffffff;
    border-radius: 28px;
    box-shadow: 0 24px 60px rgba(15,23,42,0.08);
    border: none;
    overflow: hidden;
}

.card-modern .card-body{
    padding: 28px;
}

.table-modern{
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 12px;
}

.table-modern thead th{
    background: #eef4ff;
    color: #475569;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    padding: 18px 18px;
    border: none;
    font-size: 0.82rem;
}

.table-modern tbody tr{
    background: white;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(15,23,42,0.04);
    transition: transform .25s ease, box-shadow .25s ease;
}

.table-modern tbody tr:hover{
    transform: translateY(-2px);
    box-shadow: 0 18px 38px rgba(47,83,255,0.1);
}

.table-modern td{
    padding: 18px;
    vertical-align: middle;
    border: none;
    color: #475569;
}

.badge-role{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 14px;
    border-radius: 999px;
    background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
    color: #fff;
    font-size: 0.78rem;
    font-weight: 700;
    box-shadow: 0 10px 24px rgba(47,83,255,0.12);
}

.btn-modern{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border: none;
    border-radius: 999px;
    padding: 12px 20px;
    min-height: 48px;
    font-weight: 700;
    color: white;
    transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
}

.btn-modern:hover{
    transform: translateY(-1px);
    box-shadow: 0 18px 40px rgba(47,83,255,0.15);
    text-decoration: none;
    color: white;
}

.btn-primary-modern{
    background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
}

.btn-info-modern{
    background: linear-gradient(135deg,#38BDF8 0%,#6366F1 100%);
}

.btn-warning-modern{
    background: linear-gradient(135deg,#F59E0B 0%,#FB923C 100%);
}

.btn-danger-modern{
    background: linear-gradient(135deg,#EF4444 0%,#DC2626 100%);
}

.pagination{
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 24px;
}

.page-link{
    border-radius: 14px;
    border: none;
    min-width: 42px;
    padding: 10px 14px;
    color: #475569;
    background: #f8fafc;
    transition: background .2s ease, transform .2s ease, color .2s ease;
}

.page-link:hover{
    background: rgba(102,126,234,0.12);
    color: #667eea;
}

.page-item.active .page-link{
    background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
    color: #fff;
    box-shadow: 0 12px 24px rgba(102,126,234,0.18);
}

.table-responsive{
    overflow-x: auto;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div>
                <h1 class="page-title">Daftar Users</h1>
                <p class="page-subtitle">Kelola hak akses, profil, dan peran pengguna di sistem.</p>
            </div>
            <a href="{{ route('super_admin.users.create') }}" class="btn-modern btn-primary-modern">
                <i class="fas fa-plus"></i>
                Tambah User
            </a>
        </div>
    </div>
    <div class="card-modern">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-modern">
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
                                    <span class="badge-role">{{ $user->role }}</span>
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
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('super_admin.users.show', $user->id) }}" class="btn-modern btn-info-modern">Lihat</a>
                                        <a href="{{ route('super_admin.users.edit', $user->id) }}" class="btn-modern btn-warning-modern">Edit</a>
                                        <form action="{{ route('super_admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-modern btn-danger-modern"
                                                    onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
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