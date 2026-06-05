@extends('layouts.app')

@section('title', 'Input Nilai Raport')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: #f7fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Page Header */
    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
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
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        position: relative;
        z-index: 1;
    }

    /* Search Card */
    .search-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        margin-bottom: 2rem;
        transition: var(--transition);
    }

    .search-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    /* Student Card */
    .student-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        cursor: pointer;
        text-decoration: none;
        display: block;
        height: 100%;
    }

    .student-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.2);
    }

    .student-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
    }

    .student-card:hover .student-avatar {
        transform: scale(1.05);
    }

    .student-avatar-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 700;
        background: var(--primary-gradient);
        color: white;
        margin: 0 auto;
    }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
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
        padding: 0.5rem 1rem;
        border-radius: 10px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }

    .rombel-header {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        padding-left: 1rem;
        border-left: 4px solid #667eea;
    }

    .rombel-header i {
        color: #667eea;
        margin-right: 8px;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    /* ==================== PAGINATION STYLES (SAMA DENGAN SISWA/INDEX) ==================== */
    .pagination {
        justify-content: center;
        margin-top: 1rem;
    }

    .page-link {
        border-radius: 8px;
        margin: 0 3px;
        color: #667eea;
        border: none;
        padding: 0.5rem 1rem;
        transition: var(--transition);
        background: white;
    }

    .page-link:hover {
        background: var(--primary-gradient);
        color: white;
        transform: translateY(-2px);
    }

    .page-item.active .page-link {
        background: var(--primary-gradient);
        border: none;
        color: white;
    }

    .page-item.disabled .page-link {
        color: #cbd5e1;
        background: #f1f5f9;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    /* Modal */
    .modal-content {
        border-radius: var(--border-radius);
        border: none;
    }

    .modal-header {
        background: var(--primary-gradient);
        color: white;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem 1rem;
        }
        
        .page-header h3 {
            font-size: 1.5rem;
        }
        
        .student-avatar, .student-avatar-placeholder {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }
        
        .btn-gradient, .btn-outline-gradient {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }
        
        .page-link {
            padding: 0.35rem 0.7rem;
            font-size: 0.75rem;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="page-header fade-in">
        <div>
            <h3 class="mb-1">
                <i class="fas fa-pen-alt me-2"></i> Input Nilai Raport
            </h3>
            <div class="text-muted">Pilih siswa untuk menginput atau mengedit nilai raport</div>
        </div>
    </div>

    <!-- Search & Action Bar -->
    <div class="card search-card fade-in">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">
                        <i class="fas fa-search me-1"></i> Cari Siswa
                    </label>
                    <form method="GET" class="d-flex gap-2">
                        <input type="text" name="q" value="{{ request('q', $search ?? '') }}" 
                               class="form-control" placeholder="Nama / NIS / NISN">
                        <button class="btn btn-gradient" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="btn btn-outline-gradient">
                            <i class="fas fa-undo-alt"></i> Reset
                        </a>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <button type="button" class="btn btn-outline-gradient" data-bs-toggle="modal" data-bs-target="#downloadTemplateModal">
                            <i class="fas fa-download"></i> Download Template
                        </button>
                        <button type="button" class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#importLegerModal">
                            <i class="fas fa-upload"></i> Import Leger
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') ?? 'Terjadi kesalahan, silakan cek kembali data Anda.' }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Student List -->
    @if(isset($siswas) && $siswas->count() > 0)
        @foreach($siswas as $rombel => $siswaList)
            <div class="fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="rombel-header">
                    <i class="fas fa-graduation-cap"></i> {{ $rombel }}
                    <span class="badge bg-primary ms-2">{{ $siswaList->count() }} Siswa</span>
                </div>
                <div class="row g-4 mb-5">
                    @foreach($siswaList as $siswa)
                        <div class="col-md-4 col-lg-3">
                            <a href="{{ route('walikelas.input_nilai_raport.create', $siswa->id) }}" class="student-card">
                                <div class="card h-100 text-center">
                                    <div class="card-body">
                                        @if($siswa->foto)
                                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}" class="student-avatar mb-3">
                                        @else
                                            <div class="student-avatar-placeholder mb-3">
                                                {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                            </div>
                                        @endif
                                        <h6 class="fw-bold mb-1">{{ $siswa->nama_lengkap }}</h6>
                                        <small class="text-muted">NIS: {{ $siswa->nis ?? '-' }}</small>
                                        <div class="mt-2">
                                            <span class="badge bg-primary px-3 py-2">
                                                <i class="fas fa-pen me-1"></i> Input Nilai
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- PAGINATION - SAMA DENGAN SISWA/INDEX -->
        @if(isset($queryResults) && $queryResults instanceof \Illuminate\Pagination\LengthAwarePaginator && $queryResults->hasPages())
            <div class="p-3 border-top">
                {{ $queryResults->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <i class="fas fa-clipboard-list"></i>
            <h5>Tidak ada data siswa</h5>
            <p class="text-muted">Belum ada siswa yang terdaftar di kelas Anda.</p>
        </div>
    @endif
</div>

<!-- Modal Download Template -->
<div class="modal fade" id="downloadTemplateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-download me-2"></i>Download Template Leger</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    Download template untuk rombel tertentu, isi data nilai siswa, kemudian import kembali.
                </div>
                <form id="downloadTemplateForm" method="POST" action="{{ route('walikelas.input_nilai_raport.download_template') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Rombel</label>
                        <select name="rombel_id" class="form-select" required>
                            <option value="">-- Pilih Rombel --</option>
                            @foreach($siswas as $rombelName => $siswaList)
                                @php $rombelObj = $siswaList->first()->rombel; @endphp
                                <option value="{{ $rombelObj->id }}">{{ $rombelName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Semester</label>
                            <select name="semester" class="form-select">
                                <option value="1">Semester 1</option>
                                <option value="2" selected>Semester 2</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" class="form-control" placeholder="2024/2025" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="downloadTemplateForm" class="btn btn-gradient">
                    <i class="fas fa-download me-2"></i>Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import Leger -->
<div class="modal fade" id="importLegerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-upload me-2"></i>Import Data Leger</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    Upload file Excel yang sudah diisi dengan data nilai siswa.
                </div>
                <form id="importLegerForm" method="POST" action="{{ route('walikelas.input_nilai_raport.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Rombel</label>
                        <select name="rombel_id" class="form-select" required>
                            <option value="">-- Pilih Rombel --</option>
                            @foreach($siswas as $rombelName => $siswaList)
                                @php $rombelObj = $siswaList->first()->rombel; @endphp
                                <option value="{{ $rombelObj->id }}">{{ $rombelName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Semester</label>
                            <select name="semester" class="form-select">
                                <option value="1">Semester 1</option>
                                <option value="2" selected>Semester 2</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" class="form-control" placeholder="2024/2025" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">File Excel</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                        <small class="text-muted">Format: .xlsx, .xls, atau .csv</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="importLegerForm" class="btn btn-gradient">
                    <i class="fas fa-upload me-2"></i>Import
                </button>
            </div>
        </div>
    </div>
</div>
@endsection