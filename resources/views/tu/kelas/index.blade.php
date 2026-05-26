@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<style>
    /* ===================== MODERN STYLES DATA KELAS ===================== */
    
    :root {
        --primary-color: #4F46E5;
        --primary-light: #6366F1;
        --secondary-color: #7C3AED;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --info-color: #3B82F6;
        --light-bg: #F9FAFB;
        --card-bg: #FFFFFF;
        --text-primary: #111827;
        --text-secondary: #6B7280;
        --border-color: #E5E7EB;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background: linear-gradient(135deg, #F9FAFB 0%, #F3F4F6 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        min-height: 100vh;
    }

    /* Header Styles */
    .page-header {
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 36px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .page-title::after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
        margin-top: 12px;
    }

    /* Search & Action Bar */
    .action-bar {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
    }

    .search-section {
        display: grid;
            grid-template-columns: 1fr auto auto;
            gap: 12px;
            align-items: end;
        }

    @media (max-width: 768px) {
        .search-section {
            grid-template-columns: 1fr;
        }
    }

    /* Filter Card */
    .filter-card {
        background: var(--card-bg);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        padding: 16px;
        transition: var(--transition);
    }

    .filter-card:hover {
        box-shadow: var(--shadow-md);
    }

    /* Form Controls */
    .form-control-modern {
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        transition: var(--transition);
        background: var(--card-bg);
    }

    .form-control-modern:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

    .form-select-modern {
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        transition: var(--transition);
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 40px;
        background-color: var(--card-bg);
    }

    .form-select-modern:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

    /* Button Styles */
    .btn-modern {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 500;
        transition: var(--transition);
        border: none;
        display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
        }

    .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

    .btn-primary-modern {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
        }

    .btn-success-modern {
            background: linear-gradient(135deg, var(--success-color), #34D399);
            color: white;
        }

    .btn-info-modern {
            background: linear-gradient(135deg, var(--info-color), #60A5FA);
            color: white;
        }

    .btn-secondary-modern {
            background: var(--light-bg);
            color: var(--text-primary);
            border: 2px solid var(--border-color);
        }

    .btn-secondary-modern:hover {
            background: var(--border-color);
            color: var(--text-primary);
        }

    /* Class Cards */
    .class-card {
        background: var(--card-bg);
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: var(--transition);
        height: 100%;
        border: 1px solid var(--border-color);
        position: relative;
    }

    .class-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

    .class-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

    .class-card:hover::before {
            opacity: 1;
        }

    /* Special Card Style for ID 5 */
    .class-card.special {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

    .class-card.special::before {
            display: none;
        }

    .class-card.special .card-body {
            background: transparent;
        }

    .class-card.special .card-title,
    .class-card.special .card-text,
    .class-card.special .badge,
    .class-card.special .btn-light {
            color: white;
        }

    .class-card.special .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
        }

    .class-card.special .btn-outline-primary,
    .class-card.special .btn-outline-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
        }

    .class-card.special .btn-outline-primary:hover,
    .class-card.special .btn-outline-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

    /* Card Header */
    .card-header-modern {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(124, 58, 237, 0.05));
        position: relative;
        overflow: hidden;
    }

    .card-header-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
    }

    /* Card Body */
    .card-body-modern {
        padding: 24px;
    }

    /* Card Title */
    .card-title-modern {
        font-size: 20px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 16px;
    }

    /* Info Items */
    .info-item {
        display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            color: var(--text-secondary);
            font-size: 14px;
        }

    .info-item i {
            color: var(--primary-color);
            font-size: 16px;
        }

    /* Badge Styles */
    .badge-modern {
        padding: 6px 12px;
        border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
            border: 1px solid rgba(79, 70, 229, 0.2);
        }

    /* Action Buttons */
    .action-buttons {
            display: flex;
            gap: 8px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

    .btn-sm-modern {
            padding: 8px 16px;
            font-size: 13px;
            border-radius: 6px;
        }

    /* Dropdown */
    .dropdown-modern {
            position: relative;
        }

    .dropdown-toggle-modern {
            padding: 8px 12px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            background: var(--card-bg);
            cursor: pointer;
            transition: var(--transition);
        }

    .dropdown-toggle-modern:hover {
            border-color: var(--primary-color);
            background: rgba(79, 70, 229, 0.05);
        }

    .dropdown-menu-modern {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            background: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            padding: 8px;
            min-width: 180px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
        }

    .dropdown-modern.show .dropdown-menu-modern {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

    .dropdown-item-modern {
            padding: 10px 12px;
            border-radius: 8px;
            transition: var(--transition);
            color: var(--text-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

    .dropdown-item-modern:hover {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
        }

    .dropdown-item-modern.danger:hover {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

    /* Info Bar */
    .info-bar {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-sm);
        }

    .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(99, 102, 241, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
        }

    /* Empty State */
    .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
        }

    .empty-icon {
            font-size: 64px;
            color: var(--primary-color);
            opacity: 0.2;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }

    @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

    /* Pagination */
    .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 32px;
        }

    .pagination-modern {
            display: flex;
            gap: 4px;
            background: var(--card-bg);
            padding: 8px;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
        }

    .page-link-modern {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: var(--text-secondary);
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

    .page-link-modern:hover {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
        }

    .page-item.active .page-link-modern {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
        }

    /* Modal Styles */
    .modal-content-modern {
            border-radius: 16px;
            border: none;
            overflow: hidden;
        }

    .modal-header-modern {
            padding: 24px;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(124, 58, 237, 0.05));
        }

    .modal-body-modern {
            padding: 24px;
        }

    .modal-footer-modern {
            padding: 20px 24px;
            border-top: 1px solid var(--border-color);
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.02), rgba(124, 58, 237, 0.02));
        }

    /* Alert Styles */
    .alert-modern {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
            box-shadow: var(--shadow-sm);
        }

    .alert-info-modern {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(96, 165, 250, 0.1));
            color: var(--info-color);
        }

    /* Loading Spinner */
    .spinner-modern {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

    @keyframes spin {
            to { transform: rotate(360deg); }
        }

    /* Responsive */
    @media (max-width: 768px) {
        .page-title {
            font-size: 28px;
        }

        .action-bar {
            padding: 16px;
        }

        .card-body-modern {
            padding: 16px;
        }

        .class-card {
            margin-bottom: 16px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-sm-modern {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Data Rombel</h1>
    </div>

    <!-- Search & Action Bar -->
    <div class="action-bar">
        <div class="search-section">
            <form method="GET" class="d-flex gap-2 flex-fill">
                <div class="input-group" style="flex: 1;">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search', $search ?? '') }}" 
                           class="form-control border-start-0" placeholder="Cari nama rombel, tingkat...">
                </div>
                <button type="submit" class="btn-modern btn-primary-modern">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="{{ route('tu.kelas.index') }}" class="btn-modern btn-secondary-modern">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </form>
        </div>
        
        <div class="row g-3 mt-3">
            <div class="col-md-6">
                <div class="filter-card">
                    <label class="form-label fw-semibold">Filter Jurusan</label>
                    <select name="jurusan" class="form-select-modern" onchange="this.form.submit()">
                        <option value="">-- Semua Jurusan --</option>
                        @foreach(($allJurusans ?? collect()) as $j)
                            <option value="{{ $j->id }}" {{ (isset($jurusan_id) && $jurusan_id == $j->id) ? 'selected' : '' }}>
                                {{ $j->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6 d-flex gap-2 justify-content-md-end">
                <button type="button" class="btn-modern btn-success-modern" data-bs-toggle="modal" data-bs-target="#downloadTemplateModal">
                    <i class="fas fa-download"></i> Download Template
                </button>
                <button type="button" class="btn-modern btn-info-modern" data-bs-toggle="modal" data-bs-target="#importLegerModal">
                    <i class="fas fa-upload"></i> Import Leger
                </button>
            </div>
        </div>
    </div>

    <!-- Info Bar -->
    @if($rombels->total() > 0)
        <div class="info-bar">
            <div class="info-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <div class="fw-semibold">Informasi Data</div>
                <div class="text-muted mb-0">
                    Menampilkan {{ $rombels->firstItem() }}-{{ $rombels->lastItem() }} dari {{ $rombels->total() }} rombel
                </div>
            </div>
        </div>
    @endif

    <!-- Class Cards Grid -->
    <div class="row g-3 g-md-4">
        @forelse($rombels as $rombel)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="class-card {{ $rombel->id == 5 ? 'special' : '' }}">
                    <div class="card-body-modern">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title-modern mb-0">
                                {{ $rombel->nama }}
                            </h5>
                            <span class="badge-modern">ID: {{ $rombel->id }}</span>
                        </div>
                        
                        <div class="mb-4">
                            <div class="info-item">
                                <i class="fas fa-school"></i>
                                <span>Kelas: {{ $rombel->kelas->tingkat ?? '-' }} {{ $rombel->kelas->jurusan->nama ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-user-tie"></i>
                                <span>Wali: {{ $rombel->guru->nama ?? '-' }}</span>
                            </div>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="{{ route('tu.kelas.show', $rombel->id) }}" 
                               class="btn-modern btn-secondary-modern btn-sm-modern {{ $rombel->id == 5 ? 'btn-light' : '' }}">
                                <i class="fas fa-info-circle"></i> Detail
                            </a>

                            <a href="{{ route('tu.kelas.export', $rombel->id) }}" class="btn-modern btn-success-modern btn-sm-modern">
                                <i class="fas fa-file-excel"></i> Export
                            </a>

                            <div class="dropdown-modern">
                                <button class="dropdown-toggle-modern btn-sm-modern {{ $rombel->id == 5 ? 'btn-light' : 'btn-secondary-modern' }}" 
                                        type="button" 
                                        id="dropdownMenuButton{{ $rombel->id }}">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu-modern" aria-labelledby="dropdownMenuButton{{ $rombel->id }}">
                                    <a class="dropdown-item-modern" href="{{ route('tu.kelas.edit', $rombel->id) }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <hr class="my-2">
                                    <form action="{{ route('tu.kelas.destroy', $rombel->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item-modern danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-graduation-cap empty-icon"></i>
                    <h3 class="fw-semibold mb-2">Tidak ada data rombel</h3>
                    <p class="text-muted">Belum ada rombel yang terdaftar.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($rombels->hasPages())
        <div class="pagination-container">
            <div class="pagination-modern">
                {{ $rombels->links('pagination::bootstrap-4') }}
            </div>
        </div>
    @endif
</div>

<!-- Modal Download Template -->
<div class="modal fade" id="downloadTemplateModal" tabindex="-1" aria-labelledby="downloadTemplateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern">
                <h5 class="modal-title" id="downloadTemplateLabel">
                    <i class="fas fa-download text-success me-2"></i>Download Template Leger
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-modern">
                <div class="alert alert-info-modern">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Panduan:</strong> Download template untuk rombel tertentu, isi data nilai siswa, kemudian import kembali.
                </div>
                <form id="downloadTemplateForm" method="POST" action="{{ route('tu.kelas.download_template') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Rombel</label>
                        <select name="rombel_id" class="form-select-modern" required>
                            <option value="">-- Pilih Rombel --</option>
                            @foreach($allRombels as $rombel)
                                <option value="{{ $rombel->id }}">{{ $rombel->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Semester</label>
                        <select name="semester" class="form-select-modern" required>
                            <option value="1">Semester 1 (Ganjil)</option>
                            <option value="2">Semester 2 (Genap)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control-modern" placeholder="2024/2025" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer modal-footer-modern">
                <button type="button" class="btn-modern btn-secondary-modern" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="downloadTemplateForm" class="btn-modern btn-success-modern">
                    <i class="fas fa-download me-2"></i>Download Template
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import Leger -->
<div class="modal fade" id="importLegerModal" tabindex="-1" aria-labelledby="importLegerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern">
                <h5 class="modal-title" id="importLegerLabel">
                    <i class="fas fa-upload text-info me-2"></i>Import Leger Nilai
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-modern">
                <div class="alert alert-info-modern">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Panduan:</strong> Upload file Excel (.xlsx, .xls, .csv) yang telah diisi dengan data nilai siswa. Pastikan format sesuai dengan template.
                </div>
                <form id="importLegerForm" method="POST" action="{{ route('tu.kelas.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Rombel</label>
                        <select name="rombel_id" class="form-select-modern" required>
                            <option value="">-- Pilih Rombel --</option>
                            @foreach($allRombels as $rombel)
                                <option value="{{ $rombel->id }}">{{ $rombel->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Semester</label>
                        <select name="semester" class="form-select-modern" required>
                            <option value="1">Semester 1 (Ganjil)</option>
                            <option value="2">Semester 2 (Genap)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control-modern" placeholder="2024/2025" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">File Leger</label>
                        <input type="file" name="file" class="form-control-modern" accept=".xlsx,.xls,.csv" required>
                        <div class="form-text">Format yang didukung: .xlsx, .xls, .csv</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer modal-footer-modern">
                <button type="button" class="btn-modern btn-secondary-modern" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="importLegerForm" class="btn-modern btn-info-modern">
                    <i class="fas fa-upload me-2"></i>Import Leger
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dropdowns
    const dropdowns = document.querySelectorAll('.dropdown-modern');
    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle-modern');
        
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Close other dropdowns
            dropdowns.forEach(d => {
                if (d !== dropdown) {
                    d.classList.remove('show');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('show');
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-modern')) {
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }
    });

    // Form submission handling
    const downloadForm = document.getElementById('downloadTemplateForm');
    const importForm = document.getElementById('importLegerForm');

    if (downloadForm) {
        downloadForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-modern"></span> Downloading...';
        });
    }

    if (importForm) {
        importForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-modern"></span> Importing...';
        });
    }
});
</script>
@endsection