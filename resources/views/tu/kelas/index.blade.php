@extends('layouts.app')

@section('title', 'Data Rombel - TU')

@section('content')

<style>
    :root {
        --primary: #4F46E5;
        --primary-light: #6366F1;
        --secondary: #7C3AED;
        --success: #10B981;
        --danger: #EF4444;
        --warning: #F59E0B;
        --info: #3B82F6;
    }

    .hero-banner {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        border-radius: 28px;
        padding: 32px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .hero-title {
        font-size: 32px;
        font-weight: 800;
        color: white;
        margin-bottom: 8px;
    }

    .hero-subtitle {
        color: rgba(255,255,255,0.85);
        font-size: 14px;
    }

    .hero-stats {
        display: flex;
        gap: 20px;
        margin-top: 24px;
    }

    .hero-stat {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 12px 24px;
        text-align: center;
    }

    .hero-stat-value {
        font-size: 28px;
        font-weight: 800;
        color: white;
    }

    .hero-stat-label {
        font-size: 11px;
        color: rgba(255,255,255,0.7);
        text-transform: uppercase;
    }

    .filter-section {
        background: white;
        border-radius: 20px;
        padding: 20px 24px;
        margin-bottom: 24px;
        border: 1px solid #eef2ff;
    }

    .search-input, .select-modern {
        height: 48px;
        border-radius: 14px;
        border: 1.5px solid #e2e8f0;
        padding: 0 18px;
        width: 100%;
        font-size: 14px;
    }

    .search-input:focus, .select-modern:focus {
        outline: none;
        border-color: var(--primary);
    }

    .btn-modern {
        height: 48px;
        border-radius: 16px;
        padding: 0 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-weight: 700;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, color 0.2s ease;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid rgba(148,163,184,.18);
        background: #ffffff;
        color: #1f2937;
        box-shadow: 0 8px 20px rgba(15,23,42,.05);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        background: #f8fafc;
        box-shadow: 0 12px 26px rgba(15,23,42,.12);
    }

    .btn-modern:active,
    .btn-modern:focus-visible {
        transform: scale(.98);
        box-shadow: 0 6px 14px rgba(15,23,42,.08);
    }

    .btn-primary-modern {
        color: var(--primary);
        border-color: rgba(79,70,229,.15);
    }

    .btn-success-modern {
        color: var(--success);
        border-color: rgba(16,185,129,.15);
    }

    .btn-info-modern {
        color: var(--info);
        border-color: rgba(59,130,246,.15);
    }

    .btn-warning-modern {
        color: var(--warning);
        border-color: rgba(245,158,11,.15);
    }

    .btn-outline-modern {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        color: #334155;
    }

    .btn-outline-modern:hover {
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-2px);
    }

    .btn-sm-modern {
        height: 40px;
        padding: 0 18px;
        font-size: 13px;
    }

    .info-bar {
        background: white;
        border-radius: 20px;
        padding: 16px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid #eef2ff;
    }

    .info-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: rgba(79,70,229,0.1);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .class-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #eef2ff;
        transition: all 0.3s;
        height: 100%;
        position: relative;
    }

    .class-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 35px -10px rgba(0,0,0,0.12);
        border-color: rgba(79,70,229,0.3);
    }

    .class-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 24px 24px 0 0;
    }

    .card-header {
        padding: 20px 24px 0 24px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .card-title {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .card-subtitle {
        font-size: 13px;
        color: #64748b;
    }

    .badge-id {
        background: #f1f5f9;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
    }

    .card-body {
        padding: 20px 24px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
        font-size: 14px;
        color: #64748b;
    }

    .info-item i {
        color: var(--primary);
        width: 18px;
    }

    .info-item strong {
        color: #1e293b;
    }

    .card-footer {
        padding: 16px 24px 24px 24px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        gap: 12px;
        background: #fafcff;
    }

    .dropdown-premium {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle-premium {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        background: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .dropdown-toggle-premium:hover {
        border-color: var(--primary);
        background: #f8fafc;
    }

    .dropdown-menu-premium {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 8px;
        background: white;
        border-radius: 16px;
        min-width: 170px;
        padding: 8px;
        box-shadow: 0 20px 35px -10px rgba(0,0,0,0.15);
        border: 1px solid #eef2ff;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.2s;
        z-index: 1000;
    }

    .dropdown-premium.open .dropdown-menu-premium {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item-premium {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 12px;
        text-decoration: none;
        color: #1e293b;
        transition: all 0.2s;
        cursor: pointer;
        width: 100%;
        border: none;
        background: none;
        font-size: 14px;
    }

    .dropdown-item-premium:hover {
        background: #f1f5f9;
        color: var(--primary);
    }

    .dropdown-item-premium.danger:hover {
        background: #fef2f2;
        color: var(--danger);
    }

    .empty-state {
        background: white;
        border-radius: 24px;
        padding: 60px 20px;
        text-align: center;
    }

    .modal-modern .modal-content {
        border-radius: 24px;
        border: none;
        overflow: hidden;
    }

    .modal-modern .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        padding: 20px 24px;
    }

    .modal-modern .modal-header .btn-close {
        filter: brightness(0) invert(1);
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        padding: 8px;
    }

    .modal-modern .modal-title {
        font-weight: 700;
    }

    .modal-modern .modal-body {
        padding: 24px;
    }

    .modal-modern .modal-footer {
        border-top: 1px solid #eef2ff;
        padding: 16px 24px;
    }

    .pagination-wrapper {
        margin-top: 26px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        gap: 8px;
        display: flex;
        flex-wrap: wrap;
        padding-left: 0;
        list-style: none;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        min-width: 44px;
        height: 44px;
        border: none !important;
        border-radius: 14px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: var(--primary);
        background: white;
        box-shadow: 0 3px 10px rgba(15,23,42,.05);
        transition: all 0.2s;
        text-decoration: none;
    }

    .pagination .page-link:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        background: #f1f5f9;
        color: #94A3B8;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    @media (max-width: 768px) {
        .hero-stats { flex-wrap: wrap; }
        .hero-stat { flex: 1; min-width: calc(50% - 10px); padding: 10px; }
        .hero-stat-value { font-size: 20px; }
        .card-footer { flex-direction: column; }
        .btn-sm-modern { width: 100%; }
        .dropdown-menu-premium { right: auto; left: 0; }
    }
</style>

@php
    $rombels = $rombels ?? collect();
@endphp

<div class="container-fluid px-3 px-md-4 py-4">

    <!-- HERO BANNER -->
    <div class="hero-banner">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1 class="hero-title">
                    <i class="fas fa-school me-2"></i> Data Rombel
                </h1>
                <p class="hero-subtitle">
                    Kelola seluruh data rombel dan wali kelas dengan mudah
                </p>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ $rombels->total() }}</div>
                        <div class="hero-stat-label">Total Rombel</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ $rombels->count() }}</div>
                        <div class="hero-stat-label">Halaman Ini</div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <a href="{{ route('tu.kelas.exportAll') }}" class="btn-modern btn-success-modern">
                    <i class="fas fa-file-excel"></i> Export
                </a>
                <a href="{{ route('tu.kelas.template') }}" class="btn-modern btn-warning-modern ms-2">
                    <i class="fas fa-download"></i> Download Template
                </a>
                <button type="button" class="btn-modern btn-info-modern ms-2" data-bs-toggle="modal" data-bs-target="#kelasImportModal">
                    <i class="fas fa-upload"></i> Import
                </button>
            </div>
        </div>
    </div>

    <!-- FILTER SECTION -->
    <div class="filter-section">
        <form method="GET" id="filterForm">
            <div class="row g-3">
                <div class="col-md-6 col-12">
                    <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Cari nama rombel...">
                </div>
                <div class="col-md-4 col-12">
                    <select name="jurusan" class="select-modern" id="jurusanSelect">
                        <option value="">-- Semua Jurusan --</option>
                        @foreach(($allJurusans ?? collect()) as $j)
                            <option value="{{ $j->id }}" {{ request('jurusan') == $j->id ? 'selected' : '' }}>
                                {{ $j->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-12">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-modern btn-primary-modern flex-grow-1">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="{{ route('tu.kelas.index') }}" class="btn-modern btn-outline-modern">
                            <i class="fas fa-rotate-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- INFO BAR -->
    @if($rombels->total() > 0)
    <div class="info-bar">
        <div class="info-icon">
            <i class="fas fa-layer-group"></i>
        </div>
        <div>
            <div class="fw-bold">Total Data Rombel</div>
            <div class="text-muted small">
                Menampilkan {{ $rombels->firstItem() }} - {{ $rombels->lastItem() }} dari {{ $rombels->total() }} rombel
            </div>
        </div>
    </div>
    @endif

    <!-- CONTENT GRID -->
    <div class="row g-4">
        @forelse($rombels as $rombel)
        <div class="col-12 col-md-6 col-xl-4">
            <div class="class-card">
                <div class="card-header">
                    <div>
                        <h5 class="card-title">{{ $rombel->nama }}</h5>
                        <div class="card-subtitle">{{ $rombel->kelas->tingkat ?? '-' }} {{ $rombel->kelas->jurusan->nama ?? '-' }}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge-id">ID {{ $rombel->id }}</span>

                        <div class="dropdown-premium" data-dropdown>
                            <button type="button" class="dropdown-toggle-premium" data-dropdown-toggle>
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu-premium" data-dropdown-menu>
                                <a href="{{ route('tu.kelas.edit', $rombel->id) }}" class="dropdown-item-premium">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('tu.kelas.destroy', $rombel->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item-premium danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="info-item">
                        <i class="fas fa-graduation-cap"></i>
                        <span><strong>Kelas:</strong> {{ $rombel->kelas->tingkat ?? '-' }} {{ $rombel->kelas->jurusan->nama ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-user-tie"></i>
                        <span><strong>Wali Kelas:</strong> {{ $rombel->guru->nama ?? 'Belum ada wali kelas' }}</span>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('tu.kelas.show', $rombel->id) }}" class="btn-modern btn-outline-modern btn-sm-modern flex-grow-1">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    <a href="{{ route('tu.kelas.export', $rombel->id) }}" class="btn-modern btn-success-modern btn-sm-modern">
                        <i class="fas fa-file-excel"></i> Export
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h5 class="fw-bold">Belum Ada Data Rombel</h5>
                <p class="text-muted">Silakan tambah rombel terlebih dahulu</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    @if($rombels->hasPages())
    <div class="pagination-wrapper">
        {{ $rombels->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-4') }}
    </div>
    @endif

</div>

<!-- MODAL IMPORT -->
<div class="modal fade" id="kelasImportModal" tabindex="-1" aria-labelledby="kelasImportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-modern">
        <div class="modal-content">
            <form action="{{ route('tu.kelas.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="kelasImportModalLabel">Import Data Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kelasImportFile" class="form-label">Pilih file Excel</label>
                        <input type="file" class="form-control" id="kelasImportFile" name="file" accept=".xlsx,.xls" required>
                    </div>
                    <p class="text-muted small">
                        Gunakan template kelas untuk memudahkan import. File harus berformat .xlsx atau .xls.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modern btn-outline-modern" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modern btn-info-modern">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

// ========== DROPDOWN MENU ==========
document.addEventListener('DOMContentLoaded', function() {
    const dropdowns = document.querySelectorAll('[data-dropdown]');

    function closeAllDropdowns() {
        dropdowns.forEach(dropdown => {
            dropdown.classList.remove('open');
        });
    }

    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('[data-dropdown-toggle]');
        const menu = dropdown.querySelector('[data-dropdown-menu]');

        if (toggle && menu) {
            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdowns.forEach(d => {
                    if (d !== dropdown) d.classList.remove('open');
                });
                dropdown.classList.toggle('open');
            });

            menu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('[data-dropdown]')) {
            closeAllDropdowns();
        }
    });

    // ========== AUTO SUBMIT FILTER JURUSAN ==========
    const jurusanSelect = document.getElementById('jurusanSelect');
    if (jurusanSelect) {
        jurusanSelect.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    }

    // ========== PREVENT FORM SUBMIT ON ENTER IN SEARCH ==========
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('filterForm').submit();
            }
        });
    }
});
</script>

@endsection