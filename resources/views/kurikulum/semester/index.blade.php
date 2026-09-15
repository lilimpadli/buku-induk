{{-- resources/views/kurikulum/semester/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Semester')

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
    .stat-card.purple { border-left-color: #8B5CF6; }
    .stat-card.warning { border-left-color: #F59E0B; }

    /* ============ TABLE CARD ============ */
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

    /* ============ TABLE ============ */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        min-width: 800px;
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

    /* Row yang sedang berjalan */
    .table tbody tr.berjalan {
        background-color: #f0fdf4;
    }

    .table tbody tr.berjalan:hover {
        background-color: #dcfce7;
    }

    /* ============ BADGES ============ */
    .badge-tahun {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(139,92,246,0.25);
        font-family: 'Courier New', monospace;
        letter-spacing: 0.5px;
    }

    .badge-status {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        letter-spacing: 0.3px;
    }

    .badge-status.active {
        background: linear-gradient(135deg, #10B981 0%, #34D399 100%);
        color: white;
        box-shadow: 0 3px 10px rgba(16,185,129,0.35);
    }

    .badge-status.inactive {
        background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
        color: #B91C1C;
        box-shadow: 0 3px 10px rgba(239,68,68,0.15);
    }

    .badge-semester-ganjil {
        background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
        color: #B45309;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(245,158,11,0.15);
    }

    .badge-semester-genap {
        background: linear-gradient(135deg, #DBEAFE 0%, #BFDBFE 100%);
        color: #1E40AF;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(59,130,246,0.15);
    }

    .periode-badge {
        background: #F1F5F9;
        color: #475569;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
        font-family: 'Courier New', monospace;
    }

    .periode-empty {
        color: #CBD5E1;
        font-size: 0.85rem;
        font-style: italic;
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

    /* Set Current - Aktif (Hijau) */
    .action-btn.set-current {
        background: linear-gradient(135deg, #10B981 0%, #34D399 100%);
        box-shadow: 0 3px 10px rgba(16, 185, 129, 0.35);
    }
    .action-btn.set-current:hover {
        background: linear-gradient(135deg, #059669 0%, #10B981 100%);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.5);
        color: white;
    }

    /* Set Current - Disabled (Abu-abu) */
    .action-btn.set-current-disabled {
        background: linear-gradient(135deg, #CBD5E1 0%, #94A3B8 100%);
        box-shadow: 0 3px 10px rgba(148, 163, 184, 0.25);
        cursor: not-allowed;
        opacity: 0.7;
    }

    /* Edit (Orange) */
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

    /* Delete (Merah) */
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

    /* ============ FADE IN ============ */
    .stat-card, .table-card, .page-header {
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
    @media (max-width: 768px) {
        .page-header { padding: 1.3rem 1.2rem; }
        .page-header h3 { font-size: 1.05rem; }
        .table { min-width: 700px; font-size: 0.78rem; }
        .stat-card .number { font-size: 1.5rem; }
        .action-btn { width: 32px; height: 32px; font-size: 12px; }
    }

    @media (max-width: 576px) {
        .table { min-width: 600px; font-size: 0.7rem; }
        .action-btn { width: 28px; height: 28px; font-size: 11px; }
        .badge-tahun, .badge-status, .badge-semester-ganjil, .badge-semester-genap { font-size: 0.65rem; padding: 3px 10px; }
    }
</style>

<div class="container-fluid px-3 px-md-4">
    <!-- HEADER -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h3><i class="fas fa-calendar-week"></i> Manajemen Semester</h3>
                <div class="text-muted">Kelola data semester yang tersedia di sekolah</div>
            </div>
            <a href="{{ route('kurikulum.semester.create') }}" class="btn-header">
                <i class="fas fa-plus"></i> Tambah Semester
            </a>
        </div>
    </div>

    <!-- STATISTIK -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card info">
                <div class="number">{{ $semesters->count() }}</div>
                <div class="label"><i class="fas fa-calendar-week me-1"></i> Total Semester</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card success">
                <div class="number">{{ $semesters->where('is_active', true)->count() }}</div>
                <div class="label"><i class="fas fa-check-circle me-1 text-success"></i> Aktif</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card purple">
                <div class="number">{{ $semesters->where('is_current', true)->count() }}</div>
                <div class="label"><i class="fas fa-flag me-1" style="color:#8B5CF6;"></i> Sedang Berjalan</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card warning">
                <div class="number">{{ $semesters->where('semester', '1')->count() }}</div>
                <div class="label"><i class="fas fa-sun me-1 text-warning"></i> Semester Ganjil</div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card table-card">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Daftar Semester</h5>
            <span class="badge bg-primary">{{ $semesters->count() }} Data</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Periode</th>
                            <th class="text-center">Status</th>
                            <th>Keterangan</th>
                            <th class="text-center" width="22%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semesters as $key => $semester)
                        <tr class="{{ $semester->is_current ? 'berjalan' : '' }}">
                            <td class="fw-semibold text-secondary">{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge-tahun">
                                    <i class="fas fa-calendar"></i>
                                    {{ $semester->tahunAjaran?->tahun ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @if($semester->semester == '1')
                                    <span class="badge-semester-ganjil">Ganjil</span>
                                @else
                                    <span class="badge-semester-genap">Genap</span>
                                @endif
                            </td>
                            <td>
                                @if($semester->tanggal_mulai || $semester->tanggal_selesai)
                                    <span class="periode-badge">
                                        {{ $semester->tanggal_mulai ? date('d/m/Y', strtotime($semester->tanggal_mulai)) : '-' }}
                                        →
                                        {{ $semester->tanggal_selesai ? date('d/m/Y', strtotime($semester->tanggal_selesai)) : '-' }}
                                    </span>
                                @else
                                    <span class="periode-empty">Belum diisi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($semester->is_active)
                                    <span class="badge-status active">
                                        <i class="fas fa-check-circle"></i> AKTIF
                                    </span>
                                @else
                                    <span class="badge-status inactive">
                                        <i class="fas fa-times-circle"></i> TIDAK AKTIF
                                    </span>
                                @endif
                            </td>
                            <td>{{ $semester->keterangan ?? '-' }}</td>
                            <td>
                                <div class="action-buttons">
                                    {{-- TOMBOL SET: SELALU MUNCUL, tapi disabled kalau udah berjalan --}}
                                    @if(!$semester->is_current)
                                        <form action="{{ route('kurikulum.semester.set-active', $semester->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="action-btn set-current" 
                                                    data-tooltip="Set Jadi Berjalan"
                                                    onclick="return confirmSetCurrent('{{ $semester->semester == '1' ? 'Ganjil' : 'Genap' }}', '{{ $semester->tahunAjaran?->tahun ?? '' }}')">
                                                <i class="fas fa-flag"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" 
                                                class="action-btn set-current-disabled" 
                                                data-tooltip="Sedang Berjalan"
                                                disabled>
                                            <i class="fas fa-flag-checkered"></i>
                                        </button>
                                    @endif

                                    {{-- TOMBOL EDIT --}}
                                    <a href="{{ route('kurikulum.semester.edit', $semester->id) }}" 
                                       class="action-btn edit" 
                                       data-tooltip="Edit Semester">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    {{-- TOMBOL HAPUS --}}
                                    <form action="{{ route('kurikulum.semester.destroy', $semester->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirmDelete(event, '{{ $semester->semester == '1' ? 'Ganjil' : 'Genap' }}', '{{ $semester->tahunAjaran?->tahun ?? '' }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="action-btn delete" 
                                                data-tooltip="Hapus Semester">
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
                                    <i class="fas fa-calendar-alt"></i>
                                    <h5 class="fw-bold text-muted mt-3">Belum Ada Data Semester</h5>
                                    <p class="text-muted mb-0">Silakan tambah data baru melalui tombol di atas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmSetCurrent(semester, tahun) {
        return confirm('Set semester "' + semester + ' ' + tahun + '" sebagai semester berjalan?\n\nSemester lain akan otomatis tidak berjalan.');
    }
    
    function confirmDelete(e, semester, tahun) {
        e.preventDefault();
        if (confirm('Yakin ingin menghapus semester "' + semester + ' ' + tahun + '"?\n\nTindakan ini tidak bisa dibatalkan!')) {
            e.target.submit();
        }
        return false;
    }
</script>
@endsection