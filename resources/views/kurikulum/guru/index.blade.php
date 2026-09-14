@extends('layouts.app')

@section('title', 'Manajemen Guru')

@section('content')
<style>
    /* ===================== STYLE MANAJEMEN GURU ===================== */
    
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: #f7fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* ===== OVERRIDE LAYOUT ===== */
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

    /* ===== HEADER ===== */
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

    /* ===== BUTTON ===== */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        font-weight: 600;
        padding: 0.4rem 1rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }

    /* ===== TOMBOL AKSI - REDESIGN ===== */
    .action-buttons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        font-size: 14px;
        position: relative;
        color: white;
        flex-shrink: 0;
    }

    /* Tombol Detail (Eye) - Biru */
    .action-btn.detail {
        background: linear-gradient(135deg, #3B82F6 0%, #60A5FA 100%);
        box-shadow: 0 3px 10px rgba(59, 130, 246, 0.35);
    }
    .action-btn.detail:hover {
        background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.5);
        color: white;
    }

    /* Tombol Edit (Pencil) - Orange */
    .action-btn.edit {
        background: linear-gradient(135deg, #F59E0B 0%, #FBBF24 100%);
        box-shadow: 0 3px 10px rgba(245, 158, 11, 0.35);
    }
    .action-btn.edit:hover {
        background: linear-gradient(135deg, #D97706 0%, #F59E0B 100%);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 16px rgba(245, 158, 11, 0.5);
        color: white;
    }

    /* Tombol Delete (Trash) - Merah */
    .action-btn.delete {
        background: linear-gradient(135deg, #EF4444 0%, #F87171 100%);
        box-shadow: 0 3px 10px rgba(239, 68, 68, 0.35);
    }
    .action-btn.delete:hover {
        background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.5);
        color: white;
    }

    /* Tooltip untuk tombol aksi */
    .action-btn[data-tooltip]::before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 130%;
        left: 50%;
        transform: translateX(-50%) translateY(4px);
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.25s ease;
        z-index: 100;
        pointer-events: none;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        font-weight: 600;
    }

    .action-btn[data-tooltip]::after {
        content: "";
        position: absolute;
        bottom: 110%;
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid transparent;
        border-top-color: #1e293b;
        opacity: 0;
        visibility: hidden;
        transition: all 0.25s ease;
        z-index: 100;
    }

    .action-btn[data-tooltip]:hover::before,
    .action-btn[data-tooltip]:hover::after {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }

    /* ===== FILTER ===== */
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
        box-shadow: var(--card-hover-shadow);
    }

    .filter-card .card-body {
        padding: 1.2rem 1.5rem;
    }

    .filter-card .form-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748B;
        margin-bottom: 4px;
    }

    .filter-card .form-control,
    .filter-card .form-select {
        font-size: 0.85rem;
        padding: 0.4rem 0.7rem;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
    }

    .filter-card .input-group-text {
        font-size: 0.85rem;
        background: white;
        border: 1px solid #E2E8F0;
    }

    /* ===== TABLE CARD ===== */
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
        padding: 0.8rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .table-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 1rem;
        white-space: nowrap;
    }

    .table-card .card-header h5 i {
        color: #667eea;
        margin-right: 6px;
    }

    .table-card .card-header .badge {
        font-size: 0.75rem;
        padding: 4px 12px;
        white-space: nowrap;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        min-width: 900px;
        margin-bottom: 0;
        font-size: 0.85rem;
    }

    .table th {
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #64748B;
        padding: 0.7rem 0.8rem;
        white-space: nowrap;
        background-color: #F8FAFC;
        border-bottom: none;
    }

    .table td {
        padding: 0.7rem 0.8rem;
        vertical-align: middle;
        border-color: #E2E8F0;
    }

    .table tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.03);
    }

    .teacher-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }

    .teacher-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .badge-role {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-role.guru {
        background: #DBEAFE;
        color: #2563EB;
    }

    .badge-role.walikelas {
        background: #D1FAE5;
        color: #059669;
    }

    .badge-role.kaprog {
        background: #FEF3C7;
        color: #D97706;
    }

    .badge-role.tu {
        background: #E2E8F0;
        color: #475569;
    }

    .badge-role.kurikulum {
        background: #FCE7F3;
        color: #DB2777;
    }

    .badge-role.super_admin {
        background: #FEE2E2;
        color: #DC2626;
    }

    .badge-class {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-block;
        margin: 2px;
        white-space: nowrap;
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
        padding: 0.8rem 1.5rem;
        border-top: 1px solid #E2E8F0;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .filter-card .row {
            gap: 10px;
        }
        .filter-card .col-md-3,
        .filter-card .col-md-4,
        .filter-card .col-md-2 {
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
            font-size: 1.1rem;
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
            min-width: 700px;
            font-size: 0.75rem;
        }
        .table th,
        .table td {
            padding: 0.5rem 0.5rem;
        }
        .action-btn {
            width: 32px;
            height: 32px;
            font-size: 12px;
        }
    }

    @media (max-width: 576px) {
        .table {
            min-width: 600px;
            font-size: 0.65rem;
        }
        .table th,
        .table td {
            padding: 0.3rem 0.4rem;
        }
        .action-btn {
            width: 28px;
            height: 28px;
            font-size: 11px;
        }
        .teacher-avatar {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }
        .badge-role {
            font-size: 0.6rem;
            padding: 2px 8px;
        }
        .badge-class {
            font-size: 0.6rem;
            padding: 2px 6px;
        }
    }
</style>

<div class="container-fluid px-4">
    <!-- Header -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-chalkboard-teacher me-2"></i> Manajemen Guru</h3>
                <div class="text-muted">Kelola data guru dan wali kelas</div>
            </div>
            <div class="mt-2 mt-sm-0 d-flex gap-2 flex-wrap">
                <a href="{{ route('kurikulum.guru.export', request()->only(['search','jurusan'])) }}" class="btn-gradient" style="padding:0.5rem 1.1rem; font-size:0.85rem;">
                    <i class="fas fa-file-export"></i> Export
                </a>
                <a href="{{ route('kurikulum.guru.importForm') }}" class="btn-gradient" style="padding:0.5rem 1.1rem; font-size:0.85rem;">
                    <i class="fas fa-file-import"></i> Import
                </a>
                <a href="{{ route('kurikulum.guru.manage.create') }}" class="btn-gradient" style="padding:0.5rem 1.1rem; font-size:0.85rem;">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('kurikulum.guru.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label"><i class="fas fa-search me-1"></i> Cari</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Nama / NIP / Email" value="{{ $search ?? '' }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-building me-1"></i> Jurusan</label>
                    <select name="jurusan" class="form-select">
                        <option value="">Semua Jurusan</option>
                        @foreach(($allJurusans ?? collect()) as $j)
                            <option value="{{ $j->id }}" {{ (isset($jurusan_id) && $jurusan_id == $j->id) ? 'selected' : '' }}>
                                {{ $j->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-user-tag me-1"></i> Role</label>
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
                        @foreach(($allRoles ?? collect()) as $r)
                            <option value="{{ $r }}" {{ (isset($role) && $role == $r) ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $r)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-gradient" style="padding:0.5rem 1.2rem; width:100%; justify-content:center;">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                        <a href="{{ route('kurikulum.guru.index') }}" class="btn-outline-gradient" style="padding:0.5rem 1.2rem; width:100%; justify-content:center;">
                            <i class="fas fa-undo-alt me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card table-card">
        <div class="card-header">
            <h5><i class="fas fa-table"></i> Daftar Guru</h5>
            <span class="badge bg-primary">{{ $gurus->count() }} Data</span>
        </div>
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3" id="successAlert" style="font-size:0.85rem; padding:0.6rem 1rem; border-radius:10px;">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Rombel</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $key => $g)
                        <tr>
                            <td class="fw-semibold text-secondary">{{ $key + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="teacher-avatar">
                                        @if($g->foto)
                                            <img src="{{ asset('storage/' . $g->foto) }}" alt="{{ $g->nama }}">
                                        @else
                                            {{ strtoupper(substr($g->nama, 0, 1)) }}
                                        @endif
                                    </div>
                                    <span class="fw-semibold">{{ $g->nama }}</span>
                                </div>
                            </td>
                            <td class="text-secondary">{{ $g->nip ?? '-' }}</td>
                            <td class="text-secondary">{{ $g->email ?? '-' }}</td>
                            <td>
                                @php
                                    $role = optional($g->user)->role ?? '-';
                                    $roleClass = match($role) {
                                        'guru' => 'guru',
                                        'walikelas' => 'walikelas',
                                        'kaprog' => 'kaprog',
                                        'tu' => 'tu',
                                        'kurikulum' => 'kurikulum',
                                        'super_admin' => 'super_admin',
                                        default => ''
                                    };
                                @endphp
                                @if($role != '-')
                                    <span class="badge-role {{ $roleClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $role)) }}
                                    </span>
                                @else
                                    <span style="font-size:0.7rem; color:#94A3B8;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($g->rombels && $g->rombels->count() > 0)
                                    @foreach($g->rombels as $r)
                                        <span class="badge-class">{{ $r->nama }}</span>
                                    @endforeach
                                @else
                                    <span style="font-size:0.7rem; color:#94A3B8;">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('kurikulum.guru.manage.show', $g->id) }}" 
                                       class="action-btn detail" 
                                       data-tooltip="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kurikulum.guru.manage.edit', $g->id) }}" 
                                       class="action-btn edit" 
                                       data-tooltip="Edit Data">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('kurikulum.guru.manage.destroy', $g->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus guru ini?')"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="action-btn delete" 
                                                data-tooltip="Hapus Data">
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
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    <h5 class="fw-bold text-muted">Belum ada data guru</h5>
                                    <p class="text-muted">Silakan tambah data baru melalui tombol di atas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($gurus, 'links') && $gurus->hasPages())
            <div class="pagination-wrapper">
                {{ $gurus->appends(request()->query())->links('pagination::bootstrap-4') }}
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