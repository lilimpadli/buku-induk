@extends('layouts.app')

@section('title', 'Buku Induk Siswa')

@section('content')
<style>
    :root {
        --primary: #4F46E5;
        --secondary: #7C3AED;
        --dark: #1F2937;
        --gray: #6B7280;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in-up {
        animation: fadeInUp 0.5s ease forwards;
    }

    .hero-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 28px;
        padding: 32px;
        margin-bottom: 28px;
        overflow: visible !important;
        position: relative;
        z-index: 2;
        color: white;
    }

    .hero-title {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .hero-subtitle {
        color: rgba(255,255,255,0.95);
        font-size: 14px;
    }

    .hero-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
        overflow: visible;
    }

    .hero-stats {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 12px;
        overflow: visible;
        z-index: 1100;
    }

    .hero-actions .btn-modern {
        min-width: 180px;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease, color .2s ease;
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
        box-shadow: 0 6px 18px rgba(79,70,229,0.12);
        border-radius: 14px;
        padding: 12px 24px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
    }

    .hero-actions .btn-modern i {
        color: var(--primary);
    }

    .hero-actions .btn-modern:hover,
    .hero-actions .btn-modern:focus {
        transform: translateY(-3px);
        box-shadow: 0 22px 45px rgba(79,70,229,0.22);
        background: rgba(255,255,255,0.98);
        color: var(--primary);
    }

    .hero-actions .btn-modern.btn-modern-primary {
        background: white;
        color: var(--primary);
        border-color: var(--primary);
    }

    .hero-actions .dropdown-toggle {
        background: white;
        color: var(--primary);
        border-color: var(--primary);
    }

    .hero-actions .dropdown-toggle:hover,
    .hero-actions .dropdown-toggle:focus {
        background: rgba(79,70,229,0.1);
    }

    .hero-stat {
        background: rgba(255,255,255,0.15);
        border-radius: 20px;
        padding: 12px 24px;
        min-width: 110px;
    }

    .hero-stat-value {
        font-size: 28px;
        font-weight: 800;
    }

    .hero-stat-label {
        font-size: 11px;
        color: rgba(255,255,255,0.85);
        margin-top: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #eef2ff;
        padding: 24px;
        margin-bottom: 28px;
    }

    .filter-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-control-modern,
    .form-select-modern {
        width: 100%;
        height: 48px;
        border-radius: 14px;
        border: 1.5px solid #e2e8f0;
        font-size: 14px;
        padding: 0 14px;
        transition: all 0.2s ease;
    }

    .form-control-modern:focus,
    .form-select-modern:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
    }

    .btn-modern {
        border-radius: 14px;
        font-weight: 600;
        padding: 12px 24px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-modern-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .btn-modern-primary:hover,
    .btn-modern-primary:focus {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(79,70,229,0.2);
    }

    .btn-modern-outline {
        background: white;
        color: var(--dark);
        border: 1.5px solid #e2e8f0;
    }

    .btn-modern-outline:hover,
    .btn-modern-outline:focus {
        color: var(--primary);
        border-color: var(--primary);
    }

    .table-container {
        background: white;
        border-radius: 20px;
        border: 1px solid #eef2ff;
    }

    .table-modern {
        width: 100%;
        border-collapse: collapse;
    }

    .table-modern thead th {
        background: #f8faff;
        padding: 16px;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        border-bottom: 1px solid #eef2ff;
        text-align: left;
    }

    .table-modern tbody td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #334155;
    }

    .table-modern tbody tr:hover {
        background: #f8faff;
    }

    .student-avatar-modern {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 18px;
    }

    .student-avatar-modern img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 14px;
    }

    .badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-male { background: linear-gradient(135deg, #e0f2fe, #bae6fd); color: #0284c7; }
    .badge-female { background: linear-gradient(135deg, #fce7f3, #fbcfe8); color: #db2777; }
    .badge-active { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #059669; }
    .badge-rombel { background: #f1f5f9; color: #475569; }
    .badge-inactive { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #dc2626; }

    .action-group {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .action-btn-view { background: rgba(59,130,246,0.1); color: #3b82f6; }
    .action-btn-view:hover { background: #3b82f6; color: white; }
    .action-btn-edit { background: rgba(245,158,11,0.1); color: #f59e0b; }
    .action-btn-edit:hover { background: #f59e0b; color: white; }
    .action-btn-print { background: rgba(16,185,129,0.1); color: #10b981; }
    .action-btn-print:hover { background: #10b981; color: white; }

    .empty-state-modern {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .empty-icon i {
        font-size: 40px;
        color: #94a3b8;
    }

    .empty-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .empty-description {
        color: var(--gray);
        font-size: 14px;
    }

    .pagination-modern {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 24px;
        padding: 20px;
        flex-wrap: wrap;
    }

    .pagination-modern .page-link {
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        color: var(--gray);
        text-decoration: none;
        background: white;
    }

    /* DROPDOWN FIX - PASTI MUNCUL */
    .dropdown {
        position: static !important;
        overflow: visible !important;
        z-index: 99999 !important;
    }

    .hero-actions {
        position: relative;
        z-index: 10;
    }

    .hero-actions .dropdown {
        position: relative !important;
    }

    .dropdown-menu {
        position: absolute !important;
        top: 100% !important;
        left: 0 !important;
        right: auto !important;
        z-index: 999999 !important;
        min-width: 280px !important;
        border-radius: 16px !important;
        border: 1px solid rgba(79,70,229,0.18) !important;
        background: #ffffff !important;
        box-shadow: 0 24px 50px rgba(15, 23, 42, 0.16) !important;
        overflow: visible !important;
        padding: 8px !important;
        visibility: hidden !important;
        opacity: 0;
        transform: translateY(6px);
        transition: opacity 0.2s ease, transform 0.2s ease;
        white-space: nowrap;
    }

    .dropdown.show .dropdown-menu,
    .dropdown-menu.show {
        visibility: visible !important;
        display: block !important;
        opacity: 1 !important;
        transform: translateY(0) !important;
    }

    .hero-actions .dropdown-menu {
        z-index: 1000000 !important;
    }

    .dropdown-item {
        border-radius: 10px !important;
        padding: 10px 16px !important;
        transition: background-color 0.2s ease, color 0.2s ease !important;
        font-weight: 500 !important;
        font-size: 14px !important;
        color: #1F2937 !important;
    }

    .dropdown-item:hover {
        background-color: #f8faff !important;
        color: var(--primary) !important;
    }

    .dropdown-item i {
        margin-right: 10px !important;
        width: 20px !important;
        text-align: center !important;
    }

    /* FIX TOMBOL EXPORT/IMPORT/TEMPLATE */
    .hero-actions .btn-modern {
        background: white !important;
        color: var(--primary) !important;
        border: 2px solid var(--primary) !important;
        box-shadow: 0 6px 18px rgba(79,70,229,0.12) !important;
        min-width: 180px !important;
        padding: 12px 24px !important;
        border-radius: 14px !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
    }

    .hero-actions .btn-modern i {
        color: var(--primary) !important;
    }

    .hero-actions .btn-modern:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 22px 45px rgba(79,70,229,0.22) !important;
        background: var(--primary) !important;
        color: white !important;
    }

    .hero-actions .btn-modern:hover i {
        color: white !important;
    }

    .hero-actions .dropdown-toggle::after {
        margin-left: 8px !important;
    }

    /* OVERFLOW FIX SEMUA CONTAINER */
    .container-fluid,
    .hero-banner,
    .hero-top,
    .hero-actions,
    .filter-card,
    .table-container {
        overflow: visible !important;
    }

    @media (max-width: 768px) {
        .table-responsive-desktop { display: none; }
        .mobile-card-view { display: block; }
        .hero-banner { padding: 24px; }
        .hero-title { font-size: 22px; }
        .hero-top { flex-direction: column; align-items: stretch; }
        .hero-actions { justify-content: flex-start; margin-top: 16px; }
        .hero-actions .btn-modern { min-width: 100%; }
        .hero-stats { gap: 12px; }
        .filter-card { padding: 16px; }
    }

    @media (min-width: 769px) {
        .mobile-card-view { display: none; }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">
    <div class="hero-banner fade-in-up">
        <div class="hero-top">
            <div>
                <h1 class="hero-title"><i class="fas fa-book-open me-2"></i> Buku Induk Siswa</h1>
                <p class="hero-subtitle">Kelola dan lihat data lengkap buku induk seluruh siswa</p>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ $siswas->total() }}</div>
                        <div class="hero-stat-label">Total Siswa</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ $siswas->count() }}</div>
                        <div class="hero-stat-label">Halaman Ini</div>
                    </div>
                </div>
            </div>
            <div class="hero-actions">
                <!-- EXPORT DROPDOWN -->
                <div class="dropdown">
                    <button class="btn btn-modern btn-modern-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-file-export me-2"></i> Export
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('tu.buku-induk.export.siswa') }}"><i class="fas fa-user-graduate"></i> Data Siswa</a></li>
                        <li><a class="dropdown-item" href="{{ route('tu.buku-induk.export.nilai', ['jurusan_id' => request('jurusan_id')]) }}"><i class="fas fa-chart-bar"></i> Nilai Rapor</a></li>
                        <li><a class="dropdown-item" href="{{ route('tu.buku-induk.export.pkl') }}"><i class="fas fa-briefcase"></i> PKL & Ijazah</a></li>
                    </ul>
                </div>

                <!-- IMPORT DROPDOWN -->
                <div class="dropdown">
                    <button class="btn btn-modern btn-modern-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-file-import me-2"></i> Import
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importSiswaModal"><i class="fas fa-user-graduate"></i> Data Siswa</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importNilaiModal" data-jurusan-id="{{ request('jurusan_id') }}"><i class="fas fa-chart-bar"></i> Nilai Rapor</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importPklModal"><i class="fas fa-briefcase"></i> PKL & Ijazah</a></li>
                    </ul>
                </div>

                <!-- TEMPLATE DROPDOWN -->
                <div class="dropdown">
                    <button class="btn btn-modern btn-modern-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-file-download me-2"></i> Download Template
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('tu.buku-induk.template.siswa') }}"><i class="fas fa-user-graduate"></i> Template Data Siswa</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#downloadTemplateNilaiModal"><i class="fas fa-chart-bar"></i> Template Nilai Rapor</a></li>
                        <li><a class="dropdown-item" href="{{ route('tu.buku-induk.template.pkl') }}"><i class="fas fa-briefcase"></i> Template PKL & Ijazah</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- ALERT NOTIFICATIONS -->
    @if(session('success') || session('warning') || session('error') || session('import_errors'))
    <div class="alert-box fade-in-up mb-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('import_errors'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> Beberapa baris tidak berhasil diimport:
                <ul class="mb-0 mt-2">
                    @foreach(session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    @endif

    <!-- MODAL IMPORT SISWA -->
    <div class="modal fade" id="importSiswaModal" tabindex="-1" aria-labelledby="importSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-modern">
                <div class="modal-header modal-header-modern">
                    <h5 class="modal-title" id="importSiswaModalLabel"><i class="fas fa-user-graduate me-2"></i> Import Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tu.buku-induk.import.siswa') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body modal-body-modern">
                        <p class="text-muted">Pilih file Excel (.xlsx / .xls / .csv) berisi data siswa. Pastikan kolom sesuai dengan template.</p>
                        <div class="mb-3">
                            <label for="importSiswaFile" class="form-label fw-semibold">File Excel</label>
                            <input class="form-control" type="file" id="importSiswaFile" name="file" accept=".xlsx,.xls,.csv" required>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-modern">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-modern btn-modern-primary">Upload & Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL IMPORT NILAI -->
    <div class="modal fade" id="importNilaiModal" tabindex="-1" aria-labelledby="importNilaiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-modern">
                <div class="modal-header modal-header-modern">
                    <h5 class="modal-title" id="importNilaiModalLabel"><i class="fas fa-chart-bar me-2"></i> Import Nilai Rapor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tu.buku-induk.import.nilai') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body modal-body-modern">
                        <p class="text-muted">Pilih file Excel (.xlsx / .xls / .csv) berisi nilai rapor. Pastikan kolom sesuai dengan template.</p>
                        <div class="mb-3">
                            <label for="importNilaiFile" class="form-label fw-semibold">File Excel</label>
                            <input class="form-control" type="file" id="importNilaiFile" name="file" accept=".xlsx,.xls,.csv" required>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-modern">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-modern btn-modern-primary">Upload & Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL IMPORT PKL & IJAZAH -->
    <div class="modal fade" id="importPklModal" tabindex="-1" aria-labelledby="importPklModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-modern">
                <div class="modal-header modal-header-modern">
                    <h5 class="modal-title" id="importPklModalLabel"><i class="fas fa-briefcase me-2"></i> Import PKL & Ijazah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tu.buku-induk.import.pkl') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body modal-body-modern">
                        <p class="text-muted">Pilih file Excel (.xlsx / .xls / .csv) berisi data PKL & Ijazah. Pastikan kolom sesuai dengan template.</p>
                        <div class="mb-3">
                            <label for="importPklFile" class="form-label fw-semibold">File Excel</label>
                            <input class="form-control" type="file" id="importPklFile" name="file" accept=".xlsx,.xls,.csv" required>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-modern">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-modern btn-modern-primary">Upload & Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FILTER CARD -->
    <div class="filter-card fade-in-up">
        <div class="filter-title"><i class="fas fa-sliders-h"></i> Filter Data</div>
        <form method="GET" class="row g-3">
            <div class="col-md-5 col-12">
                <input type="text" name="search" class="form-control-modern" placeholder="Cari nama, NIS, atau NISN..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3 col-12">
                <select name="jurusan_id" class="form-select-modern">
                    <option value="">-- Semua Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-12">
                <select name="per_page" class="form-select-modern" style="max-width:100px;">
                    @foreach([15,25,50,100,200,500] as $size)
                        <option value="{{ $size }}" {{ request('per_page', 15) == $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-12">
                <button type="submit" class="btn btn-modern btn-modern-primary w-100"><i class="fas fa-search me-2"></i> Cari</button>
            </div>
        </form>
    </div>

    <!-- TABLE -->
    <div class="mb-3 text-muted">
        Menampilkan {{ $siswas->firstItem() }} - {{ $siswas->lastItem() }} dari {{ $siswas->total() }} data
    </div>
    <div class="table-container fade-in-up">
        <div class="table-responsive-desktop">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>NIS / NISN</th>
                        <th>Jenis Kelamin</th>
                        <th>Rombel</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $index => $siswa)
                    <tr>
                        <td>{{ $siswas->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="student-avatar-modern">
                                    @if($siswa->user && $siswa->user->photo)
                                        <img src="{{ Storage::url($siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}">
                                    @else
                                        {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $siswa->nama_lengkap }}</div>
                                    <small class="text-muted">{{ $siswa->nis ?? '-' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>{{ $siswa->nis ?? '-' }}</div>
                            <small class="text-muted">{{ $siswa->nisn ?? '-' }}</small>
                        </td>
                        <td>
                            @if($siswa->jenis_kelamin == 'Laki-laki')
                                <span class="badge-modern badge-male"><i class="fas fa-mars"></i> Laki-laki</span>
                            @elseif($siswa->jenis_kelamin == 'Perempuan')
                                <span class="badge-modern badge-female"><i class="fas fa-venus"></i> Perempuan</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($siswa->rombel)
                                <span class="badge-modern badge-rombel"><i class="fas fa-users"></i> {{ $siswa->rombel->nama }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $terminalStatuses = ['pindah', 'do', 'meninggal', 'lulus'];
                                $isTerminal = $siswa->mutasiTerakhir && in_array(strtolower($siswa->mutasiTerakhir->status ?? ''), $terminalStatuses);
                            @endphp
                            @if($isTerminal)
                                <span class="badge-modern badge-inactive"><i class="fas fa-exclamation-circle"></i> {{ ucfirst($siswa->mutasiTerakhir->status ?? 'Lulus') }}</span>
                            @else
                                <span class="badge-modern badge-active"><i class="fas fa-check-circle"></i> Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('tu.buku-induk.show', $siswa) }}" class="action-btn action-btn-view" data-bs-toggle="tooltip" title="Lihat Buku Induk"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('tu.buku-induk.edit', $siswa->id) }}" class="action-btn action-btn-edit" data-bs-toggle="tooltip" title="Edit Data Siswa"><i class="fas fa-pen"></i></a>
                                <a href="{{ route('tu.buku-induk.cetak', $siswa) }}" target="_blank" class="action-btn action-btn-print" data-bs-toggle="tooltip" title="Cetak Buku Induk"><i class="fas fa-print"></i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-state-modern">
                                <div class="empty-icon"><i class="fas fa-book-open"></i></div>
                                <div class="empty-title">Belum Ada Data</div>
                                <div class="empty-description">Belum ada siswa yang terdaftar di buku induk</div>
                                <a href="{{ route('tu.siswa.create') }}" class="btn btn-modern btn-modern-primary mt-3"><i class="fas fa-plus"></i> Tambah Siswa</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARD VIEW -->
        <div class="mobile-card-view">
            @forelse($siswas as $siswa)
            <div class="student-card-modern">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="student-avatar-modern">
                        @if($siswa->user && $siswa->user->photo)
                            <img src="{{ Storage::url($siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}">
                        @else
                            {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark fs-6">{{ $siswa->nama_lengkap }}</div>
                        <small class="text-muted">NIS: {{ $siswa->nis ?? '-' }}</small>
                    </div>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <small class="text-muted d-block">NISN</small>
                        <span class="fw-medium">{{ $siswa->nisn ?? '-' }}</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Jenis Kelamin</small>
                        @if($siswa->jenis_kelamin == 'Laki-laki')
                            <span class="badge-modern badge-male"><i class="fas fa-mars"></i> Laki-laki</span>
                        @elseif($siswa->jenis_kelamin == 'Perempuan')
                            <span class="badge-modern badge-female"><i class="fas fa-venus"></i> Perempuan</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Rombel</small>
                        @if($siswa->rombel)
                            <span class="badge-modern badge-rombel">{{ $siswa->rombel->nama }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Status</small>
                        @if($siswa->mutasiTerakhir && in_array(strtolower($siswa->mutasiTerakhir->status ?? ''), ['pindah','do','meninggal','lulus']))
                            <span class="badge-modern badge-inactive">{{ ucfirst($siswa->mutasiTerakhir->status ?? 'Lulus') }}</span>
                        @else
                            <span class="badge-modern badge-active">Aktif</span>
                        @endif
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('tu.buku-induk.show', $siswa) }}" class="btn btn-modern btn-modern-primary flex-grow-1"><i class="fas fa-eye"></i> Lihat</a>
                    <a href="{{ route('tu.buku-induk.edit', $siswa->id) }}" class="btn btn-modern btn-modern-outline"><i class="fas fa-pen"></i></a>
                    <a href="{{ route('tu.buku-induk.cetak', $siswa) }}" target="_blank" class="btn btn-modern btn-modern-outline"><i class="fas fa-print"></i></a>
                </div>
            </div>
            @empty
            <div class="empty-state-modern">
                <div class="empty-icon"><i class="fas fa-book-open"></i></div>
                <div class="empty-title">Belum Ada Data</div>
                <div class="empty-description">Belum ada siswa yang terdaftar di buku induk</div>
            </div>
            @endforelse
        </div>

        @if($siswas->hasPages())
        <div class="pagination-modern">
            {{ $siswas->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paginationLinks = document.querySelectorAll('.pagination-modern .page-link');
        paginationLinks.forEach(link => {
            if (link.textContent.trim() === '&laquo; Previous' || link.textContent.trim() === 'Previous') {
                link.textContent = '? Prev';
            }
            if (link.textContent.trim() === 'Next &raquo;' || link.textContent.trim() === 'Next') {
                link.textContent = 'Next ?';
            }
        });

        document.querySelectorAll('.pagination-modern a, .pagination a').forEach(link => {
            link.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
    <!-- MODAL DOWNLOAD TEMPLATE NILAI WITH FILTERS -->
    <div class="modal fade" id="downloadTemplateNilaiModal" tabindex="-1" aria-labelledby="downloadTemplateNilaiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-modern">
                <div class="modal-header modal-header-modern">
                    <h5 class="modal-title" id="downloadTemplateNilaiModalLabel"><i class="fas fa-file-download me-2"></i> Download Template Nilai Rapor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="downloadTemplateForm" method="POST" action="{{ route('tu.buku-induk.template.nilai.filtered') }}">
                    @csrf
                    <div class="modal-body modal-body-modern">
                        <p class="text-muted mb-3">Pilih filter untuk template yang akan diunduh:</p>

                        <!-- KURIKULUM FILTER -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2"><i class="fas fa-graduation-cap me-2"></i> Kurikulum</label>
                            <div class="checkbox-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="kurikulum_ids[]" value="1" id="kurikulum1">
                                    <label class="form-check-label" for="kurikulum1">
                                        MERDEKA
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="kurikulum_ids[]" value="2" id="kurikulum2">
                                    <label class="form-check-label" for="kurikulum2">
                                        BRIGHTERLY
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- JURUSAN FILTER -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2"><i class="fas fa-briefcase me-2"></i> Jurusan</label>
                            <div class="checkbox-group" style="max-height: 200px; overflow-y: auto;">
                                @foreach($jurusans as $jurusan)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="jurusan_ids[]" value="{{ $jurusan->id }}" id="jurusan{{ $jurusan->id }}">
                                    <label class="form-check-label" for="jurusan{{ $jurusan->id }}">
                                        {{ $jurusan->nama }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- TINGKAT FILTER -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2"><i class="fas fa-layer-group me-2"></i> Tingkat</label>
                            <div class="checkbox-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tingkat_levels[]" value="X" id="tingkat_x">
                                    <label class="form-check-label" for="tingkat_x">
                                        Kelas X
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tingkat_levels[]" value="XI" id="tingkat_xi">
                                    <label class="form-check-label" for="tingkat_xi">
                                        Kelas XI
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tingkat_levels[]" value="XII" id="tingkat_xii">
                                    <label class="form-check-label" for="tingkat_xii">
                                        Kelas XII
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tingkat_levels[]" value="10" id="tingkat_10">
                                    <label class="form-check-label" for="tingkat_10">
                                        Kelas 10
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-modern">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-modern btn-modern-primary"><i class="fas fa-download me-2"></i> Download Template</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .checkbox-group {
            background-color: #f8f9fa;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
        }

        .checkbox-group .form-check {
            margin-bottom: 8px;
        }

        .checkbox-group .form-check:last-child {
            margin-bottom: 0;
        }

        .checkbox-group .form-check-input {
            cursor: pointer;
            width: 18px;
            height: 18px;
        }

        .checkbox-group .form-check-label {
            cursor: pointer;
            margin-left: 6px;
            margin-bottom: 0;
        }
    </style>

@endpush

@endsection
