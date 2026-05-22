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

.filter-box{
    background:#f8fafc;
    border-radius:24px;
    padding:20px;
    margin-bottom:24px;
}

.form-control-modern,
.form-select-modern{
    border:none;
    border-radius:16px;
    padding:14px 18px;
    background:white;
    box-shadow:0 4px 14px rgba(15,23,42,0.05);
    font-size:.95rem;
    transition: .3s ease;
}

.form-control-modern:focus,
.form-select-modern:focus{
    outline:none;
    box-shadow:0 0 0 4px rgba(102,126,234,.15);
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
    padding: 18px;
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
    transition: transform .25s ease, box-shadow .25s ease;
    text-decoration: none;
}

.btn-modern:hover{
    transform: translateY(-1px);
    color:white;
}

.btn-primary-modern{
    background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
    box-shadow: 0 14px 30px rgba(102,126,234,.18);
}

.action-buttons{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.action-btn{
    width:44px;
    height:44px;
    border-radius:16px;
    border:none;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    text-decoration:none;
}

.action-btn.view{
    background:linear-gradient(135deg,#06B6D4,#3B82F6);
}

.action-btn.edit{
    background:linear-gradient(135deg,#F59E0B,#FB923C);
}

.action-btn.delete{
    background:linear-gradient(135deg,#EF4444,#DC2626);
}

.pagination{
    justify-content:center;
}

.table-responsive{
    overflow-x:auto;
}

.empty-state{
    padding:60px 20px;
    text-align:center;
    color:#64748b;
}

.empty-state i{
    font-size:48px;
    margin-bottom:14px;
    opacity:.3;
}
</style>

@endpush

@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="page-header">

        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">

            <div>

                <h1 class="page-title">
                    Daftar Users
                </h1>

                <p class="page-subtitle">
                    Kelola hak akses, profil, dan role pengguna sistem.
                </p>

            </div>

            <a href="{{ route('super_admin.users.create') }}"
               class="btn-modern btn-primary-modern">

                <i class="fas fa-plus"></i>
                Tambah User

            </a>

        </div>

    </div>

    <!-- CARD -->
    <div class="card-modern">

        <div class="card-body">

            <!-- SEARCH -->
            <div class="filter-box">

                <form method="GET"
                      action="{{ route('super_admin.users.index') }}">

                    <div class="row g-3">

                        <!-- SEARCH INPUT -->
                        <div class="col-md-6">

                            <input type="text"
                                   name="search"
                                   class="form-control-modern w-100"
                                   placeholder="Cari nama, email, nomor induk..."
                                   value="{{ request()->get('search') }}">

                        </div>

                        <!-- ROLE FILTER -->
                        <div class="col-md-4">

                            <select name="role"
                                    class="form-select-modern w-100">

                                <option value="">Semua Role</option>

                                <option value="super_admin"
                                    {{ request()->get('role') == 'super_admin' ? 'selected' : '' }}>
                                    Super Admin
                                </option>

                                <option value="guru"
                                    {{ request()->get('role') == 'guru' ? 'selected' : '' }}>
                                    Guru
                                </option>

                                <option value="siswa"
                                    {{ request()->get('role') == 'siswa' ? 'selected' : '' }}>
                                    Siswa
                                </option>

                            </select>

                        </div>

                        <!-- BUTTON -->
                        <div class="col-md-2 d-grid">

                            <button type="submit"
                                    class="btn-modern btn-primary-modern w-100">

                                <i class="fas fa-search"></i>
                                Cari

                            </button>

                        </div>

                    </div>

                </form>

            </div>

            <!-- TABLE -->
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

                            <td>
                                {{ $users->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>{{ $user->name }}</strong>
                            </td>

                            <td>
                                {{ $user->nomor_induk }}
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>

                                <span class="badge-role">
                                    {{ ucfirst($user->role) }}
                                </span>

                            </td>

                            <td>

                                @if($user->guru)

                                    <small class="text-muted">
                                        {{ $user->guru->nama }}
                                    </small>

                                @elseif($user->siswa)

                                    <small class="text-muted">
                                        {{ $user->siswa->nama_lengkap }}
                                    </small>

                                @else

                                    -

                                @endif

                            </td>

                            <td>

                                <div class="action-buttons">

                                    <a href="{{ route('super_admin.users.show', $user->id) }}"
                                       class="action-btn view">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                    <a href="{{ route('super_admin.users.edit', $user->id) }}"
                                       class="action-btn edit">

                                        <i class="fas fa-edit"></i>

                                    </a>

                                    <form action="{{ route('super_admin.users.destroy', $user->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="action-btn delete">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7">

                                <div class="empty-state">

                                    <i class="fas fa-users"></i>

                                    <h5>Tidak ada data users</h5>

                                    <p>
                                        Data user yang kamu cari tidak ditemukan.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <!-- PAGINATION -->
            @if($users->hasPages())

                <div class="mt-4">

                    {{ $users->withQueryString()->links('pagination::bootstrap-4') }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection 