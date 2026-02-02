@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('content')
<style>
    /* ===================== STYLE DAFTAR SISWA - RESPONSIVE ===================== */
    
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

    /* Header Styles */
    h3.page-title {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 0 !important;
    }

    h3.page-title::before {
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
    }

    /* Filter Button Styles */
    .filter-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-buttons .btn {
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 14px;
        padding: 8px 16px;
    }

    .filter-buttons .btn:hover {
        transform: translateY(-2px);
    }

    /* Search Form Styles */
    .search-card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
    }

    .search-card .card-body {
        background-color: #F8FAFC;
        padding: 20px;
    }

    .input-group-text {
        background: white;
        border: 1px solid #E2E8F0;
        border-right: none;
    }

    .form-control, .form-select {
        border: 1px solid #E2E8F0;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(47, 83, 255, 0.1);
    }

    /* List Group Styles */
    .list-group {
        border-radius: 16px;
    }

    .list-group-flush > .list-group-item {
        border-width: 0 0 1px;
        border-color: #E2E8F0;
        padding: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .list-group-flush > .list-group-item:last-child {
        border-bottom: none;
    }

    .list-group-flush > .list-group-item::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        transform: scaleY(0);
        transition: transform 0.3s ease;
        border-radius: 0 4px 4px 0;
    }

    .list-group-flush > .list-group-item:hover {
        background-color: rgba(47, 83, 255, 0.03);
        padding-left: 25px;
    }

    .list-group-flush > .list-group-item:hover::before {
        transform: scaleY(1);
    }

    /* Student Info */
    .student-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .student-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 20px;
        flex-shrink: 0;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .list-group-item:hover .student-avatar {
        transform: scale(1.1);
    }

    .student-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .student-details {
        flex: 1;
        min-width: 150px;
    }

    .student-details strong {
        font-size: 16px;
        font-weight: 600;
        color: #1E293B;
        display: block;
        margin-bottom: 4px;
    }

    .student-details small {
        color: #64748B;
        font-size: 14px;
    }

    .student-class {
        background-color: rgba(47, 83, 255, 0.1);
        color: var(--primary-color);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Action Buttons */
    .student-actions {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .student-actions .btn {
        min-width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748B;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .empty-state h5 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .list-group-item {
        animation: fadeIn 0.5s ease-out;
    }

    /* Alert Styles */
    .alert {
        border-radius: 12px;
        border: none;
    }

    /* ===================== RESPONSIVE STYLES ===================== */

    /* Tablet (768px - 991px) */
    @media (max-width: 991px) {
        h3.page-title {
            font-size: 24px;
        }

        .filter-buttons .btn {
            font-size: 13px;
            padding: 7px 14px;
        }
    }

    /* Mobile (max-width: 767px) */
    @media (max-width: 767px) {
        /* Container padding */
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Header */
        h3.page-title {
            font-size: 22px;
            padding-left: 12px;
        }

        h3.page-title::before {
            width: 4px;
        }

        /* Header buttons */
        .header-section {
            flex-direction: column;
            align-items: stretch !important;
            gap: 12px;
        }

        .header-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .header-buttons .btn {
            width: 100%;
            justify-content: center;
        }

        /* Filter buttons */
        .filter-buttons {
            gap: 6px;
        }

        .filter-buttons .btn {
            flex: 1;
            min-width: calc(50% - 3px);
            font-size: 12px;
            padding: 8px 10px;
        }

        /* Search form */
        .search-card .card-body {
            padding: 15px;
        }

        .search-form .col-md-6,
        .search-form .col-md-4,
        .search-form .col-md-2 {
            margin-bottom: 10px;
        }

        .search-form .d-flex {
            flex-direction: column;
            gap: 8px;
        }

        .search-form .btn {
            width: 100%;
        }

        /* Student list item */
        .list-group-flush > .list-group-item {
            padding: 15px;
        }

        .list-group-flush > .list-group-item:hover {
            padding-left: 20px;
        }

        .student-info {
            gap: 12px;
        }

        .student-avatar {
            width: 45px;
            height: 45px;
            font-size: 18px;
        }

        .student-details {
            flex: 1 1 100%;
            min-width: auto;
        }

        .student-details strong {
            font-size: 15px;
        }

        .student-details small {
            font-size: 13px;
        }

        .student-class {
            order: 3;
            margin-top: -8px;
            font-size: 11px;
            padding: 5px 10px;
        }

        .student-actions {
            order: 4;
            width: 100%;
            justify-content: flex-start;
            margin-top: 8px;
            gap: 6px;
        }

        .student-actions .btn {
            min-width: 40px;
            height: 34px;
            font-size: 14px;
        }

        /* Pagination */
        .pagination {
            font-size: 14px;
        }

        .pagination .page-link {
            padding: 6px 12px;
        }

        /* Empty state */
        .empty-state {
            padding: 40px 15px;
        }

        .empty-state i {
            font-size: 40px;
        }

        .empty-state h5 {
            font-size: 16px;
        }

        .empty-state p {
            font-size: 14px;
        }
    }

    /* Small Mobile (max-width: 480px) */
    @media (max-width: 480px) {
        h3.page-title {
            font-size: 20px;
        }

        .filter-buttons .btn {
            font-size: 11px;
            padding: 7px 8px;
        }

        .student-avatar {
            width: 40px;
            height: 40px;
            font-size: 16px;
            border: 2px solid white;
        }

        .student-details strong {
            font-size: 14px;
        }

        .student-details small {
            font-size: 12px;
        }

        .student-class {
            font-size: 10px;
            padding: 4px 8px;
        }

        .student-actions .btn {
            min-width: 36px;
            height: 32px;
            font-size: 13px;
        }
    }

    /* Desktop (min-width: 1200px) */
    @media (min-width: 1200px) {
        .container {
            max-width: 1140px;
        }

        h3.page-title {
            font-size: 30px;
        }

        .student-info {
            gap: 20px;
        }

        .student-avatar {
            width: 55px;
            height: 55px;
            font-size: 22px;
        }

        .student-details strong {
            font-size: 17px;
        }
    }

    /* Print Styles */
    @media print {
        .header-buttons,
        .filter-buttons,
        .search-card,
        .student-actions,
        .pagination {
            display: none !important;
        }

        .card {
            box-shadow: none;
            border: 1px solid #ddd;
        }

        .list-group-item {
            page-break-inside: avoid;
        }
    }
</style>

<div class="container mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 header-section">
        <h3 class="page-title">Daftar Siswa</h3>
        <div class="header-buttons">
            <a href="{{ route('kurikulum.data-siswa.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Siswa
            </a>
            <a href="{{ route('kurikulum.siswa.import.form') }}" class="btn btn-outline-secondary">
                <i class="fas fa-file-import me-1"></i> Import Excel
            </a>
        </div>
    </div>

    <!-- Filter Buttons -->
    <div class="mb-3">
        @php $currentTingkat = request()->query('tingkat', ''); @endphp
        <div class="filter-buttons">
            <a href="{{ request()->fullUrlWithQuery(['tingkat' => 'X', 'page' => 1]) }}" 
               class="btn btn-sm {{ $currentTingkat == 'X' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Kelas X
            </a>
            <a href="{{ request()->fullUrlWithQuery(['tingkat' => 'XI', 'page' => 1]) }}" 
               class="btn btn-sm {{ $currentTingkat == 'XI' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Kelas XI
            </a>
            <a href="{{ request()->fullUrlWithQuery(['tingkat' => 'XII', 'page' => 1]) }}" 
               class="btn btn-sm {{ $currentTingkat == 'XII' ? 'btn-primary' : 'btn-outline-secondary' }}">
                Kelas XII
            </a>
            <a href="{{ route('kurikulum.siswa.index') }}" 
               class="btn btn-sm btn-outline-secondary">
                Semua
            </a>
        </div>
    </div>

    <!-- Search Form -->
    <div class="card mb-3 search-card">
        <div class="card-body">
            <form method="GET" action="{{ route('kurikulum.siswa.index') }}" class="row g-2 search-form">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Cari nama, NIS, atau NISN..." 
                               value="{{ $search ?? '' }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <select name="rombel" class="form-select">
                        <option value="">-- Semua Rombel --</option>
                        @foreach(($allRombels ?? collect()) as $r)
                            @php
                                $rombelNama = $r->nama ?? null;
                                $tingkatVal = optional($r->kelas)->tingkat ?? null;
                                $rombelWithoutTingkat = $rombelNama ? preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama) : null;
                                $rombelWithoutTingkat = $rombelWithoutTingkat ? trim($rombelWithoutTingkat) : null;
                                $formattedRombel = $rombelWithoutTingkat ? preg_replace('/(\D+)(\d+)/', '$1 $2', $rombelWithoutTingkat) : ($rombelNama ?? '');
                            @endphp
                            <option value="{{ $r->id }}" {{ (isset($filterRombel) && $filterRombel == $r->id) ? 'selected' : '' }}>
                                {{ $tingkatVal ? $tingkatVal . ' ' . $formattedRombel : $formattedRombel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex">
                    <button type="submit" class="btn btn-primary me-2">Cari</button>
                    <a href="{{ route('kurikulum.siswa.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Student List -->
    <div class="card shadow">
        @if($siswas->count() > 0)
            <div class="list-group list-group-flush">
                @foreach ($siswas as $siswa)
                    <div class="list-group-item">
                        <div class="student-info">
                            <div class="student-avatar">
                                @if($siswa->foto)
                                    <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                                @else
                                    {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                @endif
                            </div>
                            <div class="student-details">
                                <strong>{{ $siswa->nama_lengkap }}</strong>
                                <small>NIS: {{ $siswa->nis }}</small>
                                @if(config('app.debug'))
                                    <br><small class="text-muted">ID: {{ $siswa->id }}</small>
                                @endif
                            </div>
                         
                            @php
                                $rombel = $siswa->rombel ?? null;
                                $rombelNama = $rombel->nama ?? null;
                                $tingkatVal = optional($rombel->kelas)->tingkat ?? null;
                                $rombelWithoutTingkat = $rombelNama ? preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama) : null;
                                $rombelWithoutTingkat = $rombelWithoutTingkat ? trim($rombelWithoutTingkat) : null;
                                $formatted = $rombelWithoutTingkat ? preg_replace('/(\D+)(\d+)/', '$1 $2', $rombelWithoutTingkat) : null;
                            @endphp
                            @if($rombel)
                                <div class="student-class">
                                    @if($tingkatVal)
                                        {{ $tingkatVal }} {{ $formatted }}
                                    @else
                                        {{ $formatted }}
                                    @endif
                                </div>
                            @endif
                            <div class="student-actions">
                                <a href="{{ route('kurikulum.data-siswa.show', $siswa->id) }}" 
                                   class="btn btn-sm btn-info" 
                                   title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('kurikulum.data-siswa.edit', $siswa->id) }}" class="btn btn-sm btn-warning" title="Edit Data Diri">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('kurikulum.siswa.edit', $siswa->id) }}" class="btn btn-sm btn-secondary" title="Ubah Password">
                                    <i class="fas fa-key"></i>
                                </a>
                                <form action="{{ route('kurikulum.data-siswa.destroy', $siswa->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3 p-3">
                {{ $siswas->links('pagination::bootstrap-4') }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-user-graduate"></i>
                <h5>Tidak ada data siswa</h5>
                <p>Belum ada siswa yang terdaftar.</p>
            </div>
        @endif
    </div>
</div>
@endsection