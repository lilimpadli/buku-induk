@extends('layouts.app')

@section('title', 'Mapping Wali Kelas')

@push('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
        --primary-soft: linear-gradient(135deg, #eef2ff 0%, #faf5ff 100%);
        --card-shadow: 0 4px 6px -1px rgba(0,0,0,0.04), 0 10px 25px -3px rgba(0,0,0,0.08);
        --card-shadow-hover: 0 20px 40px -5px rgba(99, 102, 241, 0.18), 0 10px 20px -5px rgba(0,0,0,0.08);
        --border-radius: 18px;
        --border-color: #eef0f4;
    }

    body {
        background: #f6f7fb;
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
    }

    .page-header h3 i {
        background: rgba(255,255,255,0.2);
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
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
        box-shadow: var(--card-shadow-hover);
    }

    .stat-card .number {
        font-size: 2rem;
        font-weight: 800;
        color: #1E293B;
        line-height: 1.2;
        letter-spacing: -0.5px;
        background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-card .label {
        font-size: 0.82rem;
        color: #64748B;
        margin-top: 6px;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .stat-card.warning { border-left-color: #F59E0B; }
    .stat-card.success { border-left-color: #10B981; }
    .stat-card.danger  { border-left-color: #EF4444; }
    .stat-card.info     { border-left-color: #3B82F6; }

    .stat-card.warning::after { background: radial-gradient(circle, rgba(245,158,11,0.1) 0%, transparent 70%); }
    .stat-card.danger::after  { background: radial-gradient(circle, rgba(239,68,68,0.1) 0%, transparent 70%); }
    .stat-card.success::after { background: radial-gradient(circle, rgba(16,185,129,0.1) 0%, transparent 70%); }

    /* ============ TABLE CARD ============ */
    .table-card {
        border-radius: var(--border-radius);
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        background: white;
    }

    .table-card .card-header {
        background: linear-gradient(to bottom, #ffffff 0%, #fafbfd 100%);
        border-bottom: 1px solid var(--border-color);
        padding: 1.1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .table-card .card-header h5 {
        font-weight: 700;
        color: #1e293b;
        font-size: 1rem;
    }

    .table-card .card-header h5 i {
        color: #6366f1;
    }

    /* ============ FILTER CARD ============ */
    .filter-card {
        border-radius: var(--border-radius);
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
        margin-bottom: 1.5rem;
        background: white;
    }

    .filter-card .form-label {
        font-weight: 600;
        font-size: 0.8rem;
        color: #475569;
        margin-bottom: 0.4rem;
        letter-spacing: 0.2px;
    }

    .filter-card .input-group-text {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-right: none;
        color: #94a3b8;
    }

    .filter-card .form-control,
    .filter-card .form-select {
        border: 1px solid #e2e8f0;
        padding: 0.55rem 0.85rem;
        font-size: 0.88rem;
        transition: all 0.2s;
        background-color: #fff;
    }

    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.12);
    }

    /* ============ TABLE ============ */
    .table th {
        font-weight: 700;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748B;
        background-color: #F8FAFC;
        border-bottom: 2px solid #eef0f4 !important;
        white-space: nowrap;
        padding: 0.9rem 0.85rem;
    }

    .table td {
        vertical-align: middle;
        padding: 0.85rem 0.85rem;
        color: #334155;
        font-size: 0.88rem;
        border-color: #f1f5f9;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table-hover tbody tr:hover {
        background-color: #f8faff;
    }

    .table tbody tr:hover td {
        color: #1e293b;
    }

    /* ============ STATUS BADGE ============ */
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        letter-spacing: 0.2px;
    }

    .status-badge.sudah {
        background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
        color: #047857;
        box-shadow: 0 2px 8px rgba(16,185,129,0.15);
    }

    .status-badge.belum {
        background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
        color: #B91C1C;
        box-shadow: 0 2px 8px rgba(239,68,68,0.15);
    }

    /* ============ BUTTONS ============ */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.3rem;
        border-radius: 11px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
        font-size: 0.88rem;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(99, 102, 241, 0.45);
        color: white;
    }

    .btn-gradient:active {
        transform: translateY(0);
    }

    .btn-outline-gradient {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(8px);
        border: 1.5px solid rgba(255,255,255,0.4);
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.1rem;
        border-radius: 11px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 0.88rem;
    }

    .btn-outline-gradient:hover {
        background: white;
        color: #6366f1;
        border-color: white;
        transform: translateY(-2px);
    }

    /* ============ TEACHER AVATAR ============ */
    .teacher-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--primary-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
        box-shadow: 0 3px 8px rgba(139, 92, 246, 0.3);
        border: 2px solid white;
    }

    /* ============ SELECT2 CUSTOM ============ */
    .select2-container--bootstrap-5 .select2-selection {
        min-height: 38px;
        border-radius: 9px !important;
        border: 1.5px solid #e2e8f0 !important;
        font-size: 0.85rem;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #8b5cf6 !important;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        color: #334155;
        padding-left: 0.6rem;
        line-height: 36px;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }

    .select2-container {
        min-width: 220px;
    }

    .select2-results__option--highlighted {
        background: var(--primary-gradient) !important;
    }

    .select2-search--dropdown .select2-search__field {
        border-radius: 8px !important;
        border: 1.5px solid #e2e8f0 !important;
        padding: 0.5rem 0.75rem !important;
        font-size: 0.85rem !important;
    }

    .select2-search--dropdown .select2-search__field:focus {
        border-color: #8b5cf6 !important;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15) !important;
    }

    /* ============ TOOLTIP KETERANGAN TOMBOL ============ */
    .btn-action-tooltip {
        position: relative;
    }

    .btn-action-tooltip::after {
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
        z-index: 10;
        pointer-events: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .btn-action-tooltip::before {
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
        z-index: 10;
    }

    .btn-action-tooltip:hover::after,
    .btn-action-tooltip:hover::before {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }

    /* Action button inside table */
    .table .btn-sm {
        border-radius: 8px;
        padding: 0.35rem 0.65rem;
        transition: all 0.2s;
    }

    .table .btn-primary {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border: none;
        box-shadow: 0 3px 8px rgba(99, 102, 241, 0.3);
    }

    .table .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 12px rgba(99, 102, 241, 0.4);
    }

    .table .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #f43f5e 100%);
        border: none;
        box-shadow: 0 3px 8px rgba(239, 68, 68, 0.3);
    }

    .table .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 12px rgba(239, 68, 68, 0.4);
    }

    /* ============ BADGES ============ */
    .badge.bg-secondary {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%) !important;
        padding: 5px 10px;
        border-radius: 8px;
        font-weight: 600;
    }

    .badge.bg-primary {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%) !important;
        padding: 5px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    /* ============ PAGINATION ============ */
    .pagination-wrapper {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border-color);
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

    /* ============ ALERTS ============ */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 0.9rem 1.2rem;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.15);
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    /* ============ EMPTY STATE ============ */
    .table-card .text-center i.fas {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: floatY 3s ease-in-out infinite;
    }

    @keyframes floatY {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    /* Fade-in animation */
    .stat-card, .filter-card, .table-card, .page-header {
        animation: fadeInUp 0.5s ease both;
    }

    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.1s; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ============ TOAST NOTIFICATION (VALIDASI) ============ */
    #toast-container {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .toast-item {
        background: linear-gradient(135deg, #ef4444, #f43f5e);
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
        font-size: 0.88rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        animation: toastIn 0.3s ease forwards;
    }

    @keyframes toastIn {
        from { opacity: 0; transform: translateX(100%); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes toastOut {
        to { opacity: 0; transform: translateX(100%); }
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 768px) {
        .stat-card .number {
            font-size: 1.5rem;
        }
        .guru-select {
            min-width: 150px;
            font-size: 0.8rem;
        }
        .table-responsive {
            font-size: 0.8rem;
        }
        .page-header {
            padding: 1.3rem 1.2rem;
        }
        .page-header h3 {
            font-size: 1.05rem;
        }
        .select2-container {
            min-width: 100%;
        }
    }
</style>

<!-- Container untuk Toast Notifikasi -->
<div id="toast-container"></div>

<div class="container-fluid px-3 px-md-4">
    <!-- HEADER -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-chalkboard-teacher me-2"></i> Mapping Wali Kelas</h3>
                <div style="color: rgba(255,255,255,0.85) !important; font-size: 0.9rem;">
                    Kelola penugasan wali kelas untuk setiap rombel
                </div>
            </div>
            <div class="mt-2 mt-sm-0">
                <a href="{{ route('kurikulum.guru.index') }}" class="btn-outline-gradient" style="border-color: rgba(255,255,255,0.5); color: white;">
                    <i class="fas fa-users me-1"></i> Manajemen Guru
                </a>
            </div>
        </div>
    </div>

    <!-- STATISTICS -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card info">
                <div class="number">{{ $statistics['total_rombels'] }}</div>
                <div class="label"><i class="fas fa-school me-1"></i> Total Rombel</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card success">
                <div class="number">{{ $statistics['total_wali_kelas'] }}</div>
                <div class="label"><i class="fas fa-check-circle me-1 text-success"></i> Sudah Ada Wali</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card danger">
                <div class="number">{{ $statistics['belum_wali_kelas'] }}</div>
                <div class="label"><i class="fas fa-exclamation-circle me-1 text-danger"></i> Belum Ada Wali</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card warning">
                <div class="number">
                    @if($statistics['belum_wali_kelas'] == 0)
                        <i class="fas fa-check-circle text-success" style="font-size:2rem;"></i>
                    @else
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size:2rem;"></i>
                    @endif
                </div>
                <div class="label">
                    @if($statistics['belum_wali_kelas'] == 0)
                        ✅ Semua lengkap
                    @else
                        ⚠️ {{ $statistics['belum_wali_kelas'] }} rombel perlu wali
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ALERT -->
    @if($statistics['belum_wali_kelas'] > 0)
    <div class="alert alert-warning d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-triangle me-2" style="font-size:1.2rem;"></i>
        <div>
            <strong>Perhatian!</strong> Ada <strong>{{ $statistics['belum_wali_kelas'] }}</strong> rombel yang belum memiliki wali kelas.
            <a href="{{ route('kurikulum.wali-kelas-mapping.index', ['status' => 'belum']) }}" class="alert-link ms-1">
                Lihat yang belum
            </a>
        </div>
    </div>
    @endif

    <!-- FILTER -->
    <div class="card filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('kurikulum.wali-kelas-mapping.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-search me-1"></i> Cari</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Nama rombel..." value="{{ $search ?? '' }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-building me-1"></i> Jurusan</label>
                    <select name="jurusan" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Jurusan</option>
                        @foreach($allJurusans as $j)
                            <option value="{{ $j->id }}" {{ $jurusan_id == $j->id ? 'selected' : '' }}>
                                {{ $j->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-filter me-1"></i> Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="sudah" {{ $status_filter == 'sudah' ? 'selected' : '' }}>✅ Sudah Ada Wali</option>
                        <option value="belum" {{ $status_filter == 'belum' ? 'selected' : '' }}>❌ Belum Ada Wali</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-gradient w-100 justify-content-center">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('kurikulum.wali-kelas-mapping.index') }}" class="btn-outline-gradient w-100 justify-content-center" style="background: #f1f5f9; color:#475569; border-color:#e2e8f0;">
                            <i class="fas fa-undo-alt me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card table-card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-table me-2"></i> Daftar Rombel & Wali Kelas</h5>
            <span class="badge bg-primary">{{ $rombels->total() }} Data</span>
        </div>
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3" id="successAlert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger m-3" id="errorAlert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Rombel</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Siswa</th>
                            <th>Status</th>
                            <th>Wali Kelas</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rombels as $key => $rombel)
                        <tr>
                            <td>{{ $rombels->firstItem() + $key }}</td>
                            <td>
                                <strong>{{ $rombel->display_name }}</strong>
                            </td>
                            <td>{{ optional($rombel->kelas)->tingkat ?? '-' }}</td>
                            <td>{{ optional(optional($rombel->kelas)->jurusan)->nama ?? '-' }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $rombel->siswa->count() }}</span>
                            </td>
                            <td>
                                @if($rombel->guru_id)
                                    <span class="status-badge sudah">
                                        <i class="fas fa-check-circle me-1"></i> Sudah
                                    </span>
                                @else
                                    <span class="status-badge belum">
                                        <i class="fas fa-exclamation-circle me-1"></i> Belum
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($rombel->guru)
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="teacher-avatar">
                                            {{ strtoupper(substr($rombel->guru->nama, 0, 1)) }}
                                        </div>
                                        <span>{{ $rombel->guru->nama }}</span>
                                    </div>
                                @else
                                    <span class="text-muted" style="font-size:0.85rem;">Belum ditentukan</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('kurikulum.wali-kelas-mapping.update') }}" method="POST" class="d-flex gap-2 align-items-center flex-wrap">
                                    @csrf
                                    <input type="hidden" name="rombel_id" value="{{ $rombel->id }}">
                                    
                                    {{-- SELECT2 DROPDOWN - SEARCHABLE BY NAMA / NIP --}}
                                    <select name="guru_id" class="form-select form-select-sm guru-select2" style="width: 100%;">
                                        <option value="">-- Pilih Wali Kelas --</option>
                                        @foreach($allGurus as $id => $nama)
                                            <option value="{{ $id }}" {{ $rombel->guru_id == $id ? 'selected' : '' }}>
                                                {{ $nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <!-- Tombol Simpan dengan Tooltip & Validasi -->
                                    <button type="submit" class="btn btn-sm btn-primary btn-action-tooltip" data-tooltip="Simpan Wali Kelas" onclick="return validateGuru(this)">
                                        <i class="fas fa-save"></i>
                                    </button>
                                    
                                    @if($rombel->guru_id)
                                        <!-- Tombol Hapus dengan Tooltip -->
                                        <button type="submit" class="btn btn-sm btn-danger btn-action-tooltip" data-tooltip="Hapus Wali Kelas" onclick="return confirm('Yakin hapus wali kelas ini?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="text-center py-5">
                                    <i class="fas fa-school" style="font-size:3rem;color:#CBD5E1;"></i>
                                    <h5 class="mt-3 text-muted">Belum ada data rombel</h5>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($rombels->hasPages())
            <div class="pagination-wrapper">
                {{ $rombels->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- 1. JQuery (WAJIB DIMUAT DULU) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- 2. Select2 JS (butuh JQuery) -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- 3. Inisialisasi -->
<script>
    $(document).ready(function() {
        console.log('✅ JQuery:', typeof $);
        console.log('✅ Select2:', typeof $.fn.select2);
        
        // Inisialisasi Select2 untuk semua dropdown guru
        $('.guru-select2').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Pilih Wali Kelas --',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "Guru tidak ditemukan";
                },
                searching: function() {
                    return "Mencari...";
                },
                inputTooShort: function() {
                    return "Ketik minimal 1 karakter";
                }
            }
        });
        
        console.log('✅ Select2 initialized');
    });

    // Validasi sebelum tombol simpan diklik
    function validateGuru(button) {
        const form = button.closest('form');
        const select = form.querySelector('select[name="guru_id"]');
        
        if (!select.value) {
            showToast('Harap pilih wali kelas terlebih dahulu!', 'warning');
            if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
                jQuery(select).select2('open');
            } else {
                select.focus();
            }
            return false;
        }
        return true;
    }

    // Fungsi Toast Notification
    function showToast(message, type = 'warning') {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.style.cssText = 'position:fixed;top:24px;right:24px;z-index:9999;';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'toast-item';
        
        let icon = 'fas fa-exclamation-circle';
        let bg = 'linear-gradient(135deg, #f59e0b, #f43f5e)';
        
        toast.style.background = bg;
        toast.innerHTML = `<i class="${icon}"></i> ${message}`;
        
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'toastOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Auto hide alert session
    setTimeout(function() {
        let alert = document.getElementById('successAlert');
        if(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() { alert.remove(); }, 500);
        }
        
        let errorAlert = document.getElementById('errorAlert');
        if(errorAlert) {
            errorAlert.style.transition = 'opacity 0.5s';
            errorAlert.style.opacity = '0';
            setTimeout(function() { errorAlert.remove(); }, 500);
        }
    }, 3000);
</script>
@endpush