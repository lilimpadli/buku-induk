@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<style>
    /* ===================== STYLE DATA KELAS ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    h2.fw-bold {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 25px !important;
    }

    h2.fw-bold::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 3px;
    }

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
        transform: translateY(-5px);
    }

    /* Special Card Style for ID 5 */
    .card.bg-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
    }

    /* Button Styles */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(47, 83, 255, 0.3);
    }

    .btn-outline-primary {
        border-color: var(--primary-color);
        color: var(--primary-color);
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        transform: translateY(-2px);
    }

    .btn-outline-secondary {
        border-color: #E2E8F0;
        color: #64748B;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background-color: #F1F5F9;
        transform: translateY(-2px);
    }

    .btn-light {
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        transform: translateY(-2px);
    }

    /* Input Group Styles */
    .input-group {
        border-radius: 8px;
        overflow: hidden;
    }

    .form-control, .form-select {
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 8px 12px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
    }

    .input-group-text {
        background: white;
        border: 1px solid #E2E8F0;
        border-right: none;
    }

    .input-group .form-control {
        border-left: none;
    }

    /* Badge Styles */
    .badge.bg-secondary {
        background-color: rgba(100, 116, 139, 0.2) !important;
        color: #475569 !important;
        font-weight: 600;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 6px;
    }

    /* Dropdown Styles */
    .dropdown-menu {
        border-radius: 12px;
        border: none;
        box-shadow: var(--hover-shadow);
        padding: 8px;
    }

    .dropdown-item {
        border-radius: 8px;
        padding: 8px 12px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: rgba(47, 83, 255, 0.1);
        color: var(--primary-color);
    }

    .dropdown-item.text-danger:hover {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    .dropdown-divider {
        margin: 8px 0;
        border-color: #E2E8F0;
    }

    /* Empty State */
    .alert-info {
        background-color: rgba(47, 83, 255, 0.1);
        border: none;
        border-radius: 12px;
        color: var(--primary-color);
        font-weight: 500;
        padding: 20px;
    }

    /* Pagination Styles */
    .pagination {
        border-radius: 8px;
    }

    .page-link {
        border: none;
        margin: 0 2px;
        border-radius: 8px;
        color: #64748B;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background-color: rgba(47, 83, 255, 0.1);
        color: var(--primary-color);
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        box-shadow: 0 4px 8px rgba(47, 83, 255, 0.3);
    }

    /* Filter Card */
    .filter-card {
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        background-color: white;
    }

    .filter-card .card-body {
        background-color: #F8FAFC;
        padding: 1.25rem;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .col {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 992px) {
        h2.fw-bold {
            font-size: 26px;
        }
    }

    @media (max-width: 768px) {
        h2.fw-bold {
            font-size: 24px;
            padding-left: 12px;
        }

        h2.fw-bold::before {
            width: 4px;
        }

        .filter-card .card-body {
            padding: 1rem;
        }

        .form-label {
            font-size: 13px !important;
            margin-bottom: 0.4rem !important;
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            font-size: 1.1rem;
        }

        .badge {
            font-size: 10px !important;
        }
    }

    @media (max-width: 576px) {
        h2.fw-bold {
            font-size: 20px;
            padding-left: 10px;
        }

        .filter-card .card-body {
            padding: 0.875rem;
        }

        .form-label {
            font-size: 12px !important;
        }

        .form-control, .form-select {
            font-size: 0.875rem;
            padding: 6px 10px;
        }

        .input-group-text {
            padding: 6px 10px;
            font-size: 0.875rem;
        }

        .btn {
            font-size: 0.875rem;
            padding: 6px 12px;
        }

        .card-body {
            padding: 0.875rem;
        }

        .card-title {
            font-size: 1rem;
        }

        .card-text, .card p {
            font-size: 0.875rem;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 0.35rem 0.65rem;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <!-- JUDUL -->
    <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
        <h2 class="fw-bold mb-0">Data Rombel</h2>
    </div>

    <!-- INFO PAGINATION -->
    @if($rombels->total() > 0)
        <p class="text-muted mb-3 small">
            <i class="fas fa-info-circle me-1"></i>
            Menampilkan {{ $rombels->firstItem() }}-{{ $rombels->lastItem() }} dari {{ $rombels->total() }} rombel
        </p>
    @endif

    <!-- FILTER + BUTTON -->
    <div class="card filter-card mb-3 mb-md-4">
        <div class="card-body">
            <form action="{{ route('tu.kelas.index') }}" method="GET" class="row g-2 g-md-3 align-items-end">
                <!-- Search -->
                <div class="col-12 col-md-5">
                    <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Cari Rombel</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Nama rombel, tingkat..." value="{{ $search ?? '' }}">
                    </div>
                </div>

                <!-- Filter Jurusan -->
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Jurusan</label>
                    <select name="jurusan" class="form-select">
                        <option value="">-- Semua Jurusan --</option>
                        @foreach(($allJurusans ?? collect()) as $j)
                            <option value="{{ $j->id }}" {{ (isset($jurusan_id) && $jurusan_id == $j->id) ? 'selected' : '' }}>
                                {{ $j->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-12 col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-search"></i> 
                            <span class="d-none d-sm-inline">Cari</span>
                        </button>
                        <a href="{{ route('tu.kelas.index') }}" class="btn btn-outline-secondary flex-fill">
                            <i class="bi bi-arrow-counterclockwise"></i> 
                            <span class="d-none d-sm-inline">Reset</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    

    <!-- KARTU KELAS -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-2 g-md-3">
        @forelse($rombels as $rombel)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 {{ $rombel->id == 5 ? 'bg-primary text-white' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2 mb-md-3">
                            <h5 class="card-title fw-bold mb-0 {{ $rombel->id == 5 ? 'text-white' : '' }}">
                                {{ $rombel->nama }}
                            </h5>
                            <span class="badge bg-secondary ms-2">ID: {{ $rombel->id }}</span>
                        </div>
                        
                        <div class="mb-2 mb-md-3">
                            <p class="mb-1 small {{ $rombel->id == 5 ? 'text-white-50' : 'text-muted' }}">
                                <i class="fas fa-school me-1 me-md-2"></i> 
                                Kelas: {{ $rombel->kelas->tingkat ?? '-' }} {{ $rombel->kelas->jurusan->nama ?? '-' }}
                            </p>
                            <p class="mb-0 small {{ $rombel->id == 5 ? 'text-white-50' : 'text-muted' }}">
                                <i class="fas fa-user-tie me-1 me-md-2"></i> 
                                Wali: {{ $rombel->guru->nama ?? '-' }}
                            </p>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <div class="d-flex gap-2">
                                <a href="{{ route('tu.kelas.show', $rombel->id) }}" 
                                   class="btn {{ $rombel->id == 5 ? 'btn-light' : 'btn-outline-primary' }} btn-sm">
                                    <i class="fas fa-info-circle me-1"></i> Detail
                                </a>

                                <a href="{{ route('tu.kelas.export', $rombel->id) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-file-excel me-1"></i> Export
                                </a>
                            </div>

                            <div class="dropdown">
                                <button class="btn {{ $rombel->id == 5 ? 'btn-light' : 'btn-outline-secondary' }} btn-sm dropdown-toggle" 
                                        type="button" 
                                        id="dropdownMenuButton{{ $rombel->id }}" 
                                        data-bs-toggle="dropdown" 
                                        aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $rombel->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('tu.kelas.edit', $rombel->id) }}">
                                            <i class="fa fa-edit me-2"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('tu.kelas.destroy', $rombel->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fa fa-trash me-2"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i> Tidak ada data rombel
                </div>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    @if($rombels->hasPages())
        <div class="d-flex justify-content-center mt-3 mt-md-4">
            {{ $rombels->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>

@endsection