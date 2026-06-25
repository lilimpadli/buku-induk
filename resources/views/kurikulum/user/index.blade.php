@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body { background-color: #f7fafc; font-family: 'Inter', sans-serif; }

    main {
        padding: 20px 15px !important;
        overflow-x: auto !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 10px !important;
        overflow-x: auto !important;
    }

    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(100px, -100px);
        pointer-events: none;
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1.3rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.4rem 1rem;
        border-radius: 8px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        white-space: nowrap;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 1px solid #667eea;
        color: #667eea;
        font-weight: 600;
        padding: 0.3rem 0.8rem;
        border-radius: 8px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        white-space: nowrap;
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
    }

    .btn-edit {
        background: #F59E0B;
        border: none;
        color: white;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.65rem;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        white-space: nowrap;
    }

    .btn-edit:hover {
        background: #D97706;
        color: white;
    }

    .btn-delete {
        background: #EF4444;
        border: none;
        color: white;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.65rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 3px;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: #DC2626;
        color: white;
    }

    .btn-reset {
        background: #6B7280;
        border: none;
        color: white;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.65rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 3px;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-reset:hover {
        background: #4B5563;
        color: white;
    }

    .filter-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: var(--transition);
        width: 100%;
    }

    .filter-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .filter-card .card-body {
        padding: 1rem 1.5rem;
    }

    .filter-card .form-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: #64748B;
        margin-bottom: 2px;
    }

    .filter-card .form-control,
    .filter-card .form-select {
        font-size: 0.8rem;
        padding: 0.3rem 0.7rem;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        height: 36px;
    }

    .filter-card .input-group-text {
        font-size: 0.8rem;
        padding: 0.3rem 0.7rem;
        background: white;
        border: 1px solid #E2E8F0;
    }

    .table-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        width: 100%;
    }

    .table-card .card-header {
        background: white;
        border-bottom: 1px solid #E2E8F0;
        padding: 0.7rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .table-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 0.95rem;
    }

    .table-card .card-header h5 i {
        color: #667eea;
        margin-right: 6px;
    }

    .table-card .card-header .badge {
        font-size: 0.7rem;
        padding: 3px 10px;
        white-space: nowrap;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        min-width: 650px;
        margin-bottom: 0;
        font-size: 0.85rem;
    }

    .table th {
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #64748B;
        padding: 0.6rem 0.8rem;
        white-space: nowrap;
        background-color: #F8FAFC;
        border-bottom: none;
    }

    .table td {
        padding: 0.6rem 0.8rem;
        vertical-align: middle;
        border-color: #E2E8F0;
    }

    .table tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.03);
    }

    .badge-role {
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 0.6rem;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-role.siswa { background: #DBEAFE; color: #2563EB; }
    .badge-role.guru { background: #D1FAE5; color: #059669; }
    .badge-role.walikelas { background: #FEF3C7; color: #D97706; }
    .badge-role.kaprog { background: #FCE7F3; color: #DB2777; }
    .badge-role.tu { background: #E2E8F0; color: #475569; }
    .badge-role.kurikulum { background: #FEE2E2; color: #DC2626; }
    .badge-role.super_admin { background: #F3E8FF; color: #7C3AED; }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: nowrap;
        white-space: nowrap;
    }

    .action-buttons form {
        margin: 0;
        padding: 0;
        display: inline;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #CBD5E1;
        display: block;
        margin-bottom: 0.5rem;
    }

    .pagination-wrapper {
        padding: 0.6rem 1.5rem;
        border-top: 1px solid #E2E8F0;
    }

    @media (max-width: 992px) {
        .filter-card .row {
            gap: 8px;
        }
        .filter-card .col-md-4,
        .filter-card .col-md-3 {
            width: 100%;
        }
        .filter-card .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1rem;
        }
        .page-header h3 {
            font-size: 1.05rem;
        }
        .page-header .text-muted {
            font-size: 0.75rem;
        }

        .table-card .card-header {
            flex-wrap: wrap;
        }
        .table-card .card-header .btn-gradient {
            width: 100%;
            justify-content: center;
        }

        .table {
            min-width: 550px;
            font-size: 0.75rem;
        }
        .table th,
        .table td {
            padding: 0.4rem 0.5rem;
        }
        .btn-edit,
        .btn-delete,
        .btn-reset {
            padding: 2px 6px;
            font-size: 0.55rem;
        }
        .action-buttons {
            flex-wrap: wrap;
            gap: 3px;
        }
    }

    @media (max-width: 576px) {
        .table {
            min-width: 450px;
            font-size: 0.65rem;
        }
        .table th,
        .table td {
            padding: 0.3rem 0.4rem;
        }
        .btn-edit,
        .btn-delete,
        .btn-reset {
            padding: 1px 5px;
            font-size: 0.5rem;
        }
        .badge-role {
            font-size: 0.5rem;
            padding: 1px 6px;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-users-cog me-2"></i> Manajemen User</h3>
                <div class="text-muted">Kelola akun pengguna</div>
            </div>
            <div class="mt-2 mt-sm-0">
                <a href="{{ route('kurikulum.user.create') }}" class="btn-gradient">
                    <i class="fas fa-plus"></i> Tambah User
                </a>
            </div>
        </div>
    </div>

    <div class="card filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('kurikulum.user.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label"><i class="fas fa-search me-1"></i> Cari</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Nama / Email / NIP" value="{{ $search ?? '' }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-user-tag me-1"></i> Role</label>
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
                        @foreach($roles as $key => $label)
                            <option value="{{ $key }}" {{ $role == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn-gradient" style="flex:1; justify-content:center; padding:0.3rem 0.8rem; font-size:0.75rem;">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                        <a href="{{ route('kurikulum.user.index') }}" class="btn-outline-gradient" style="flex:1; justify-content:center; padding:0.3rem 0.8rem; font-size:0.75rem;">
                            <i class="fas fa-undo-alt"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card table-card">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Daftar User</h5>
            <span class="badge bg-primary">{{ $users->total() }}</span>
        </div>
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3" id="successAlert" style="font-size:0.8rem; padding:0.5rem 1rem;">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger m-3" style="font-size:0.8rem; padding:0.5rem 1rem;">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIP</th>
                            <th>Role</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $key => $u)
                        <tr>
                            <td>{{ $users->firstItem() + $key }}</td>
                            <td><span class="fw-semibold">{{ $u->name }}</span></td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->nomor_induk ?? '-' }}</td>
                            <td>
                                <span class="badge-role {{ $u->role }}">
                                    {{ $roles[$u->role] ?? $u->role }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('kurikulum.user.edit', $u->id) }}" class="btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kurikulum.user.reset-password', $u->id) }}" method="POST" onsubmit="return confirm('Reset password user ini menjadi 12345678?')">
                                        @csrf
                                        <button type="submit" class="btn-reset">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('kurikulum.user.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" {{ $u->id == auth()->id() ? 'disabled' : '' }}>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h5 class="fw-bold text-muted">Belum ada data user</h5>
                                    <p class="text-muted">Silakan tambah data baru melalui tombol di atas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
            <div class="pagination-wrapper">
                {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        let alert = document.getElementById('successAlert');
        if(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() { alert.remove(); }, 500);
        }
    }, 3000);
</script>
@endsection