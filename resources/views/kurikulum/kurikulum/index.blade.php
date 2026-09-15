@extends('layouts.app')

@section('title', 'Manajemen Kurikulum')

@section('content')
<style>
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

    /* ============ HEADER ============ */
    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.8rem 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: 0 15px 35px -8px rgba(139, 92, 246, 0.45);
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .page-header::before,
    .page-header::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.12);
        pointer-events: none;
    }

    .page-header::before {
        top: -60px;
        right: -40px;
        width: 220px;
        height: 220px;
    }

    .page-header::after {
        bottom: -90px;
        right: 120px;
        width: 160px;
        height: 160px;
        background: rgba(255,255,255,0.08);
    }

    .page-header h3 {
        font-weight: 700;
        letter-spacing: -0.3px;
        position: relative;
        z-index: 1;
        margin-bottom: 0.25rem;
        font-size: 1.4rem;
    }

    .page-header h3 i {
        background: rgba(255,255,255,0.2);
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        margin-right: 8px;
    }

    .page-header .text-muted {
        color: rgba(255,255,255,0.85) !important;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .btn-header {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 1.5px solid rgba(255,255,255,0.3);
        color: white;
        font-weight: 600;
        padding: 0.55rem 1.3rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 0.88rem;
        position: relative;
        z-index: 2;
    }

    .btn-header:hover {
        background: white;
        color: #6366f1;
        border-color: white;
        transform: translateY(-2px);
    }

    /* ============ STAT CARD ============ */
    .stat-card {
        background: white;
        border-radius: 14px;
        padding: 1.3rem 1.5rem;
        box-shadow: var(--card-shadow);
        border-left: 4px solid #667eea;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 80px;
        height: 80px;
        background: radial-gradient(circle, rgba(102,126,234,0.06) 0%, transparent 70%);
        pointer-events: none;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--card-hover-shadow);
    }

    .stat-card .number {
        font-size: 2rem;
        font-weight: 800;
        color: #1E293B;
        line-height: 1.2;
        letter-spacing: -0.5px;
    }

    .stat-card .label {
        font-size: 0.82rem;
        color: #64748B;
        margin-top: 6px;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .stat-card.info { border-left-color: #3B82F6; }
    .stat-card.success { border-left-color: #10B981; }
    .stat-card.warning { border-left-color: #F59E0B; }
    .stat-card.purple { border-left-color: #8B5CF6; }

    /* ============ FILTER ============ */
    .filter-card {
        border-radius: var(--border-radius);
        border: 1px solid #eef0f4;
        box-shadow: var(--card-shadow);
        margin-bottom: 1.5rem;
        background: white;
    }

    .filter-card .card-body {
        padding: 1.2rem 1.5rem;
    }

    .filter-card .form-label {
        font-weight: 600;
        font-size: 0.8rem;
        color: #475569;
        margin-bottom: 0.4rem;
        letter-spacing: 0.2px;
    }

    .filter-card .form-control {
        border: 1px solid #e2e8f0;
        padding: 0.55rem 0.85rem;
        font-size: 0.88rem;
        border-radius: 10px;
        transition: all 0.2s;
        height: 42px;
    }

    .filter-card .form-control:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.12);
    }

    .filter-card .input-group-text {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-right: none;
        color: #94a3b8;
        border-radius: 10px 0 0 10px;
    }

    /* ============ BUTTONS ============ */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.55rem 1.3rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
        font-size: 0.88rem;
        height: 42px;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(99, 102, 241, 0.45);
        color: white;
    }

    .btn-outline-gradient {
        background: white;
        border: 1.5px solid #e2e8f0;
        color: #64748b;
        font-weight: 600;
        padding: 0.5rem 1.1rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.88rem;
        height: 42px;
    }

    .btn-outline-gradient:hover {
        background: #f1f5f9;
        color: #334155;
        border-color: #cbd5e1;
    }

    /* ============ TABLE ============ */
    .table-card {
        border-radius: var(--border-radius);
        border: 1px solid #eef0f4;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        background: white;
    }

    .table-card .card-header {
        background: linear-gradient(to bottom, #ffffff 0%, #fafbfd 100%);
        border-bottom: 1px solid #eef0f4;
        padding: 1.1rem 1.5rem;
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
    }

    .table-card .card-header h5 i {
        color: #667eea;
        margin-right: 6px;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        min-width: 700px;
        margin-bottom: 0;
        font-size: 0.88rem;
    }

    .table th {
        font-weight: 700;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748B;
        padding: 0.9rem 0.85rem;
        white-space: nowrap;
        background-color: #F8FAFC;
        border-bottom: 2px solid #eef0f4 !important;
    }

    .table td {
        padding: 0.85rem 0.85rem;
        vertical-align: middle;
        border-color: #f1f5f9;
        color: #334155;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8faff;
    }

    /* ============ BADGE ============ */
    .badge-mapel {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        color: white;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(16,185,129,0.25);
    }

    .badge-date {
        background: #F1F5F9;
        color: #475569;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
        font-family: 'Courier New', monospace;
    }

    /* ============ ACTION BUTTONS ============ */
    .action-buttons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .action-buttons form {
        margin: 0;
        padding: 0;
        display: inline-flex;
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
        padding: 0;
    }

    .action-btn.view {
        background: linear-gradient(135deg, #3B82F6 0%, #60A5FA 100%);
        box-shadow: 0 3px 10px rgba(59, 130, 246, 0.35);
    }
    .action-btn.view:hover {
        background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.5);
        color: white;
    }

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

    /* Tooltip */
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

    /* ============ EMPTY STATE ============ */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #CBD5E1;
        display: block;
        margin-bottom: 0.5rem;
        animation: floatY 3s ease-in-out infinite;
    }

    @keyframes floatY {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    /* ============ PAGINATION ============ */
    .pagination-wrapper {
        padding: 1rem 1.5rem;
        border-top: 1px solid #eef0f4;
        background: #fafbfd;
    }

    .pagination .page-link {
        border: none;
        color: #6366f1;
        margin: 0 3px;
        border-radius: 8px !important;
        padding: 0.45rem 0.8rem;
        font-weight: 600;
        transition: all 0.2s;
    }

    .pagination .page-item.active .page-link {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 3px 8px rgba(99, 102, 241, 0.3);
    }

    .pagination .page-link:hover {
        background: #eef2ff;
        color: #4f46e5;
    }

    /* ============ FADE IN ============ */
    .stat-card, .filter-card, .table-card, .page-header {
        animation: fadeInUp 0.5s ease both;
    }

    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.1s; }
    .stat-card:nth-child(3) { animation-delay: 0.15s; }
    .stat-card:nth-child(4) { animation-delay: 0.2s; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 992px) {
        .filter-card .row { gap: 10px; }
        .filter-card .col-md-4,
        .filter-card .col-md-6,
        .filter-card .col-md-8 {
            width: 100%;
        }
        .filter-card .btn { width: 100%; justify-content: center; }
    }

    @media (max-width: 768px) {
        .page-header { padding: 1.3rem 1.2rem; }
        .page-header h3 { font-size: 1.05rem; }
        .table { min-width: 600px; font-size: 0.78rem; }
        .stat-card .number { font-size: 1.5rem; }
        .action-btn { width: 32px; height: 32px; font-size: 12px; }
    }

    @media (max-width: 576px) {
        .table { min-width: 500px; font-size: 0.7rem; }
        .action-btn { width: 28px; height: 28px; font-size: 11px; }
        .badge-mapel, .badge-date { font-size: 0.6rem; padding: 3px 10px; }
    }
</style>

<div class="container-fluid px-3 px-md-4">
    <!-- HEADER -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h3><i class="fas fa-book"></i> Manajemen Kurikulum</h3>
                <div class="text-muted">Kelola data kurikulum yang digunakan di sekolah</div>
            </div>
            @if(Route::has('kurikulum.kurikulum.create'))
                <a href="{{ route('kurikulum.kurikulum.create') }}" class="btn-header">
                    <i class="fas fa-plus"></i> Tambah Kurikulum
                </a>
            @endif
        </div>
    </div>

    <!-- STATISTIK -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card info">
                <div class="number">{{ $kurikulum->total() ?? $kurikulum->count() }}</div>
                <div class="label"><i class="fas fa-book me-1"></i> Total Kurikulum</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card success">
                <div class="number">
                    {{ $kurikulum->sum(function($k) { return $k->mata_pelajarans_count ?? 0; }) }}
                </div>
                <div class="label"><i class="fas fa-book-open me-1 text-success"></i> Total Mapel</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card purple">
                <div class="number">
                    {{ $kurikulum->filter(function($k) { return ($k->mata_pelajarans_count ?? 0) > 0; })->count() }}
                </div>
                <div class="label"><i class="fas fa-check-circle me-1" style="color:#8B5CF6;"></i> Aktif</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card warning">
                <div class="number">
                    {{ $kurikulum->filter(function($k) { return ($k->mata_pelajarans_count ?? 0) == 0; })->count() }}
                </div>
                <div class="label"><i class="fas fa-exclamation-circle me-1 text-warning"></i> Tanpa Mapel</div>
            </div>
        </div>
    </div>

    <!-- FILTER -->
    <div class="card filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('kurikulum.kurikulum.index') }}" class="row g-2 align-items-end">
                <div class="col-md-8">
                    <label class="form-label"><i class="fas fa-search me-1"></i> Cari Kurikulum</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Nama kurikulum..." value="{{ $search ?? '' }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-gradient" style="flex:1; justify-content:center;">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="{{ route('kurikulum.kurikulum.index') }}" class="btn-outline-gradient" style="flex:0 0 auto;">
                            <i class="fas fa-undo-alt"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card table-card">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Daftar Kurikulum</h5>
            <span class="badge bg-primary">{{ $kurikulum->total() }} Data</span>
        </div>
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3" id="successAlert" style="font-size:0.85rem; padding:0.6rem 1rem; border-radius:10px;">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger m-3" style="font-size:0.85rem; padding:0.6rem 1rem; border-radius:10px;">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Kurikulum</th>
                            <th class="text-center" width="18%">Mata Pelajaran</th>
                            <th class="text-center" width="18%">Dibuat</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kurikulum as $key => $k)
                        <tr>
                            <td class="fw-semibold text-secondary">{{ $kurikulum->firstItem() + $key }}</td>
                            <td>
                                <div class="fw-bold" style="color:#1e293b; font-size:0.95rem;">
                                    {{ $k->nama_kurikulum }}
                                </div>
                            </td>
                            <td class="text-center">
                                @if(($k->mata_pelajarans_count ?? 0) > 0)
                                    <span class="badge-mapel">
                                        <i class="fas fa-book-open"></i>
                                        {{ $k->mata_pelajarans_count }} Mapel
                                    </span>
                                @else
                                    <span class="badge bg-secondary" style="font-size:0.7rem;">
                                        <i class="fas fa-minus-circle me-1"></i> Belum ada mapel
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $k->created_at->format('d/m/Y') }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    {{-- LIHAT --}}
                                    @if(Route::has('kurikulum.kurikulum.show'))
                                        <a href="{{ route('kurikulum.kurikulum.show', $k->id) }}" 
                                           class="action-btn view" 
                                           data-tooltip="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif

                                    {{-- EDIT --}}
                                    @if(Route::has('kurikulum.kurikulum.edit'))
                                        <a href="{{ route('kurikulum.kurikulum.edit', $k->id) }}" 
                                           class="action-btn edit" 
                                           data-tooltip="Edit Kurikulum">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    @endif

                                    {{-- HAPUS --}}
                                    @if(Route::has('kurikulum.kurikulum.destroy'))
                                        <form action="{{ route('kurikulum.kurikulum.destroy', $k->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirmDelete(event, '{{ addslashes($k->nama_kurikulum) }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="action-btn delete" 
                                                    data-tooltip="Hapus Kurikulum">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-book"></i>
                                    <h5 class="fw-bold text-muted mt-3">Belum Ada Data Kurikulum</h5>
                                    <p class="text-muted mb-0">Silakan tambah data baru melalui tombol di atas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($kurikulum->hasPages())
            <div class="pagination-wrapper">
                {{ $kurikulum->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    function confirmDelete(e, nama) {
        e.preventDefault();
        if (confirm('Yakin ingin menghapus kurikulum "' + nama + '"?\n\nTindakan ini tidak bisa dibatalkan!')) {
            e.target.submit();
        }
        return false;
    }
    
    // Auto hide alert
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