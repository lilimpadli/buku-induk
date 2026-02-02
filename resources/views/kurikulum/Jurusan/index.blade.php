@extends('layouts.app')

@section('title', 'Data Jurusan')

@section('content')
<style>
    /* ===================== STYLE DATA JURUSAN - RESPONSIVE ===================== */
    
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
    }

    /* Page Title */
    h2.fw-bold {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 1.5rem !important;
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

    /* Info Text */
    .text-muted {
        color: #64748B !important;
        font-size: 14px;
    }

    /* Filter Section */
    .filter-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 12px;
    }

    .search-form {
        display: flex;
        flex: 1;
        min-width: 280px;
        max-width: 400px;
    }

    .input-group {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .input-group .form-control {
        border: 1px solid #E2E8F0;
        border-right: none;
        padding: 10px 16px;
    }

    .input-group .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: none;
    }

    .input-group .btn {
        border: 1px solid #E2E8F0;
        border-left: none;
        background: white;
        color: #64748B;
        padding: 10px 16px;
    }

    .input-group .btn:hover {
        background: var(--light-bg);
        color: var(--primary-color);
    }

    /* Add Button */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 83, 255, 0.4);
    }

    /* Card Grid */
    .row.g-3 {
        --bs-gutter-x: 1rem;
        --bs-gutter-y: 1rem;
    }

    /* Department Cards */
    .jurusan-card {
        border-radius: 12px;
        border: none;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        height: 100%;
        overflow: hidden;
    }

    .jurusan-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--hover-shadow);
    }

    .jurusan-card .card-body {
        padding: 1.5rem;
    }

    .jurusan-card .card-title {
        font-weight: 600;
        font-size: 18px;
        color: #1E293B;
        margin-bottom: 0.5rem;
    }

    .jurusan-card .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 12px;
        background-color: #F1F5F9 !important;
        color: #475569 !important;
    }

    .jurusan-card .text-muted {
        font-size: 14px;
        color: #64748B;
        margin-bottom: 1rem;
    }

    /* Card Actions */
    .card-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        margin-top: 1rem;
    }

    .btn-outline-primary {
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .btn-outline-primary:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-secondary {
        border: 1px solid #CBD5E1;
        color: #64748B;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .btn-outline-secondary:hover {
        background: #F1F5F9;
        border-color: #94A3B8;
        color: #475569;
    }

    /* Dropdown Menu */
    .dropdown-menu {
        border-radius: 8px;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        padding: 0.5rem 0;
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 14px;
        color: #334155;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: #F8FAFC;
        color: var(--primary-color);
    }

    .dropdown-item.text-danger:hover {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger-color) !important;
    }

    .dropdown-divider {
        border-top: 1px solid #E2E8F0;
        margin: 0.5rem 0;
    }

    /* Alert */
    .alert-info {
        background-color: rgba(14, 165, 233, 0.1);
        border: 1px solid rgba(14, 165, 233, 0.2);
        color: #075985;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
    }

    /* Pagination */
    .pagination {
        margin-top: 2rem;
    }

    .page-link {
        border: 1px solid #E2E8F0;
        color: #64748B;
        padding: 0.5rem 0.75rem;
        margin: 0 0.25rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .page-link:hover {
        background-color: var(--light-bg);
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-color: var(--primary-color);
        color: white;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .jurusan-card {
        animation: fadeIn 0.4s ease-out;
    }

    .jurusan-card:nth-child(1) { animation-delay: 0.05s; }
    .jurusan-card:nth-child(2) { animation-delay: 0.1s; }
    .jurusan-card:nth-child(3) { animation-delay: 0.15s; }
    .jurusan-card:nth-child(4) { animation-delay: 0.2s; }
    .jurusan-card:nth-child(5) { animation-delay: 0.25s; }
    .jurusan-card:nth-child(6) { animation-delay: 0.3s; }

    /* ===================== RESPONSIVE STYLES ===================== */

    /* Tablet (max-width: 991px) */
    @media (max-width: 991px) {
        h2.fw-bold {
            font-size: 24px;
        }

        .jurusan-card .card-title {
            font-size: 17px;
        }

        .jurusan-card .card-body {
            padding: 1.25rem;
        }
    }

    /* Mobile (max-width: 767px) */
    @media (max-width: 767px) {
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Page Title */
        h2.fw-bold {
            font-size: 22px;
            padding-left: 12px;
            margin-bottom: 1.25rem !important;
        }

        h2.fw-bold::before {
            width: 4px;
        }

        /* Info Text */
        .text-muted {
            font-size: 13px;
            margin-bottom: 1rem !important;
        }

        /* Filter Section */
        .filter-section {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .search-form {
            max-width: 100%;
        }

        .input-group {
            width: 100%;
        }

        .btn-primary {
            width: 100%;
            justify-content: center;
        }

        /* Card Grid */
        .row.g-3 {
            --bs-gutter-x: 0.75rem;
            --bs-gutter-y: 0.75rem;
        }

        /* Department Cards */
        .jurusan-card .card-body {
            padding: 1rem;
        }

        .jurusan-card .card-title {
            font-size: 16px;
        }

        .jurusan-card .badge {
            font-size: 11px;
            padding: 5px 10px;
        }

        .jurusan-card .text-muted {
            font-size: 13px;
        }

        /* Card Actions */
        .card-actions {
            flex-wrap: wrap;
        }

        .btn-outline-primary,
        .btn-outline-secondary {
            font-size: 13px;
            padding: 6px 12px;
        }

        /* Pagination */
        .pagination {
            margin-top: 1.5rem;
            font-size: 14px;
        }

        .page-link {
            padding: 0.4rem 0.6rem;
            margin: 0 0.15rem;
        }
    }

    /* Small Mobile (max-width: 480px) */
    @media (max-width: 480px) {
        h2.fw-bold {
            font-size: 20px;
        }

        .jurusan-card .card-body {
            padding: 0.875rem;
        }

        .jurusan-card .card-title {
            font-size: 15px;
        }

        .jurusan-card .badge {
            font-size: 10px;
            padding: 4px 8px;
        }

        .jurusan-card .text-muted {
            font-size: 12px;
        }

        .btn-outline-primary,
        .btn-outline-secondary {
            font-size: 12px;
            padding: 5px 10px;
        }

        .dropdown-item {
            font-size: 13px;
        }
    }

    /* Desktop (min-width: 1200px) */
    @media (min-width: 1200px) {
        .container-fluid {
            max-width: 1400px;
            margin: 0 auto;
        }

        h2.fw-bold {
            font-size: 30px;
        }

        .jurusan-card .card-body {
            padding: 1.75rem;
        }

        .jurusan-card .card-title {
            font-size: 19px;
        }

        .search-form {
            max-width: 450px;
        }
    }

    /* Print Styles */
    @media print {
        .filter-section,
        .card-actions,
        .pagination {
            display: none !important;
        }

        .jurusan-card {
            box-shadow: none;
            border: 1px solid #ddd;
            page-break-inside: avoid;
        }

        .jurusan-card:hover {
            transform: none;
        }
    }
</style>

<div class="container-fluid">
    <!-- JUDUL -->
    <h2 class="fw-bold mb-4">Data Jurusan</h2>

    <!-- INFO PAGINATION -->
    @if($jurusans->total() > 0)
        <p class="text-muted mb-3">
            Menampilkan {{ $jurusans->firstItem() }}-{{ $jurusans->lastItem() }} dari {{ $jurusans->total() }} jurusan
        </p>
    @endif

    <!-- FILTER + BUTTON -->
    <div class="filter-section">
        <form action="{{ route('kurikulum.jurusan.index') }}" method="GET" class="search-form">
            <div class="input-group">
                <input type="text" 
                       name="search" 
                       class="form-control" 
                       placeholder="Cari jurusan" 
                       value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
        
        <a href="{{ route('kurikulum.jurusan.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i> Tambah Jurusan
        </a>
    </div>

    <!-- KARTU JURUSAN -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @forelse($jurusans as $jurusan)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 jurusan-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold">{{ $jurusan->nama }}</h5>
                            <span class="badge bg-secondary">Kode: {{ $jurusan->kode }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <p class="mb-0 text-muted">Total Kelas: {{ $jurusan->kelas->count() }}</p>
                        </div>
                        
                        <div class="card-actions">
                            <a href="{{ route('kurikulum.jurusan.show', $jurusan->id) }}" 
                               class="btn btn-outline-primary btn-sm">
                                Detail
                            </a>
                            
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" 
                                        type="button" 
                                        id="dropdownMenuButton{{ $jurusan->id }}" 
                                        data-bs-toggle="dropdown" 
                                        aria-expanded="false">
                                    Lebih
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $jurusan->id }}">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('kurikulum.jurusan.edit', $jurusan->id) }}">
                                            <i class="fa fa-edit me-2"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('kurikulum.jurusan.destroy', $jurusan->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="dropdown-item text-danger" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                    Tidak ada data jurusan
                </div>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    @if($jurusans->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $jurusans->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>

@endsection