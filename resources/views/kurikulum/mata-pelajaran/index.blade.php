@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@section('content')
<style>
    /* ===================== STYLE MATA PELAJARAN ===================== */
    
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

    .card-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 20px 24px;
        border-bottom: none;
    }

    .card-header h5 {
        margin: 0;
        font-weight: 700;
        font-size: 20px;
    }

    .card-body {
        padding: 24px;
    }

    /* Alert Styles */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 16px 20px;
        font-weight: 500;
    }

    .alert-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    /* Filter Section */
    .filter-section {
        background-color: #F8FAFC;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .form-select {
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.2s;
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
    }

    /* Button Group */
    .btn-group {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        overflow: hidden;
    }

    .btn-group .btn {
        border: none;
        padding: 10px 16px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn-group .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-group .btn-outline-secondary {
        background-color: white;
        color: #64748B;
    }

    .btn-group .btn-outline-secondary:hover {
        background-color: #F1F5F9;
    }

    /* Regular Buttons */
    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 83, 255, 0.4);
    }

    .btn-outline-secondary {
        background-color: white;
        color: #64748B;
        border: 1px solid #E2E8F0;
    }

    .btn-outline-secondary:hover {
        background-color: #F8FAFC;
        color: #475569;
    }

    .btn-sm {
        padding: 6px 14px;
        font-size: 13px;
    }

    .btn-warning {
        background-color: var(--warning-color);
        color: white;
    }

    .btn-warning:hover {
        background-color: #D97706;
        transform: translateY(-1px);
    }

    .btn-danger {
        background-color: var(--danger-color);
        color: white;
    }

    .btn-danger:hover {
        background-color: #DC2626;
        transform: translateY(-1px);
    }

    /* Table Styles */
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background-color: #F8FAFC;
        color: #475569;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px 20px;
        border-bottom: 2px solid #E2E8F0;
    }

    .table tbody td {
        padding: 16px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #F1F5F9;
        color: #1E293B;
        font-size: 14px;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(248, 250, 252, 0.5);
    }

    /* Mobile Menu Toggle */
    .mobile-filter-toggle {
        display: none;
    }

    .mobile-filter-content {
        display: block;
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

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* ===================== RESPONSIVE STYLES ===================== */

    /* Tablet (768px - 991px) */
    @media (max-width: 991px) {
        .card-header h5 {
            font-size: 18px;
        }

        .btn-group .btn {
            padding: 8px 12px;
            font-size: 13px;
        }
    }

    /* Mobile (max 767px) */
    @media (max-width: 767px) {
        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }

        /* Card Header */
        .card-header {
            padding: 16px;
            flex-direction: column;
            gap: 12px;
            align-items: flex-start !important;
        }

        .card-header h5 {
            font-size: 16px;
            width: 100%;
        }

        .card-header .btn {
            width: 100%;
            justify-content: center;
        }

        .card-body {
            padding: 16px;
        }

        /* Filter Section */
        .filter-section {
            padding: 12px;
        }

        .mobile-filter-toggle {
            display: block;
            width: 100%;
            margin-bottom: 12px;
        }

        .mobile-filter-content {
            display: none;
        }

        .mobile-filter-content.show {
            display: block;
        }

        /* Filter Form - Stack Vertically */
        .mb-3 form {
            flex-direction: column !important;
            gap: 12px !important;
        }

        .form-select {
            width: 100% !important;
            font-size: 14px;
        }

        /* Button Group - Stack on Mobile */
        .btn-group {
            width: 100%;
            display: flex;
            flex-direction: column;
            border-radius: 8px;
        }

        .btn-group .btn {
            width: 100%;
            border-radius: 0 !important;
            text-align: left;
            padding: 12px 16px;
            border-bottom: 1px solid #E2E8F0;
        }

        .btn-group .btn:first-child {
            border-radius: 8px 8px 0 0 !important;
        }

        .btn-group .btn:last-child {
            border-radius: 0 0 8px 8px !important;
            border-bottom: none;
        }

        /* Filter Buttons */
        .mb-3 form > .btn {
            width: 100%;
            padding: 12px;
            font-size: 14px;
        }

        /* Table - Horizontal Scroll */
        .table-responsive {
            margin: 0 -16px;
            border-radius: 0;
        }

        .table {
            font-size: 12px;
        }

        .table thead th {
            padding: 10px 8px;
            font-size: 10px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 10px 8px;
            font-size: 12px;
        }

        /* Hide some columns on mobile */
        .table thead th:nth-child(3),
        .table tbody td:nth-child(3),
        .table thead th:nth-child(5),
        .table tbody td:nth-child(5) {
            display: none;
        }

        /* Action buttons stack */
        .table .d-flex {
            flex-direction: column !important;
            gap: 6px !important;
        }

        .table .d-flex .btn {
            width: 100%;
        }

        .table .d-flex form {
            width: 100%;
        }

        .table .d-flex form button {
            width: 100%;
        }

        /* Alert */
        .alert {
            font-size: 13px;
            padding: 12px 14px;
        }
    }

    /* Mobile Small (max 575px) */
    @media (max-width: 575px) {
        .card-header h5 {
            font-size: 15px;
        }

        .btn {
            font-size: 13px;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 11px;
        }

        /* Hide more columns on very small screens */
        .table thead th:nth-child(4),
        .table tbody td:nth-child(4) {
            display: none;
        }

        .table {
            font-size: 11px;
        }

        .table thead th {
            padding: 8px 6px;
            font-size: 9px;
        }

        .table tbody td {
            padding: 8px 6px;
            font-size: 11px;
        }
    }

    /* Desktop Large (1200px+) */
    @media (min-width: 1200px) {
        .card-header h5 {
            font-size: 22px;
        }

        .table thead th {
            font-size: 14px;
            padding: 18px 24px;
        }

        .table tbody td {
            font-size: 15px;
            padding: 18px 24px;
        }
    }

    /* Improve gap spacing on mobile */
    @media (max-width: 767px) {
        .d-flex.gap-2 {
            gap: 8px !important;
        }
    }
</style>

<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Mata Pelajaran</h5>
            <a href="{{ route('kurikulum.mata-pelajaran.create') }}" class="btn btn-sm btn-light">
                <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">Tambah</span>
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <!-- Filter Section -->
            <div class="filter-section">
                <!-- Mobile Toggle Button -->
                <button class="btn btn-outline-secondary mobile-filter-toggle w-100" type="button" onclick="toggleMobileFilter()">
                    <i class="fas fa-filter me-2"></i> Filter & Pencarian
                    <i class="fas fa-chevron-down float-end" id="filterChevron"></i>
                </button>

                <!-- Filter Content -->
                <div class="mobile-filter-content" id="mobileFilterContent">
                    <form method="GET" class="d-flex gap-2 align-items-center flex-wrap" action="{{ route('kurikulum.mata-pelajaran.index') }}">
                        <!-- Jurusan Select -->
                        <select name="jurusan" class="form-select" style="width:220px">
                            <option value="">Semua Jurusan</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}" {{ (string)($jurusan ?? '') === (string)$j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                            @endforeach
                        </select>

                        <!-- Tingkat Filter -->
                        <div class="btn-group" role="group" aria-label="Tingkat filter">
                            <a href="{{ route('kurikulum.mata-pelajaran.index', array_filter(['jurusan' => $jurusan])) }}" class="btn {{ empty($tingkat) ? 'btn-primary' : 'btn-outline-secondary' }}">
                                Semua
                            </a>
                            <a href="{{ route('kurikulum.mata-pelajaran.index', array_merge(array_filter(['jurusan' => $jurusan]), ['tingkat' => 10])) }}" class="btn {{ (string)($tingkat ?? '') === '10' ? 'btn-primary' : 'btn-outline-secondary' }}">
                                Kelas 10
                            </a>
                            <a href="{{ route('kurikulum.mata-pelajaran.index', array_merge(array_filter(['jurusan' => $jurusan]), ['tingkat' => 11])) }}" class="btn {{ (string)($tingkat ?? '') === '11' ? 'btn-primary' : 'btn-outline-secondary' }}">
                                Kelas 11
                            </a>
                            <a href="{{ route('kurikulum.mata-pelajaran.index', array_merge(array_filter(['jurusan' => $jurusan]), ['tingkat' => 12])) }}" class="btn {{ (string)($tingkat ?? '') === '12' ? 'btn-primary' : 'btn-outline-secondary' }}">
                                Kelas 12
                            </a>
                        </div>

                        <!-- Action Buttons -->
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-check"></i> Terapkan
                        </button>
                        <a href="{{ route('kurikulum.mata-pelajaran.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kelompok</th>
                            <th>Jurusan</th>
                            <th>Tingkat</th>
                            <th>Urutan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mapels as $m)
                        <tr>
                            <td><strong>{{ $m->nama }}</strong></td>
                            <td>
                                <span class="badge bg-secondary">{{ $m->kelompok }}</span>
                            </td>
                            <td>{{ optional($m->jurusan)->nama ?? '-' }}</td>
                            <td>{{ ($m->tingkats ?? collect())->pluck('tingkat')->implode(', ') }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $m->urutan }}</span>
                            </td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <a href="{{ route('kurikulum.mata-pelajaran.edit', $m->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> <span class="d-none d-lg-inline">Edit</span>
                                    </a>
                                    <form action="{{ route('kurikulum.mata-pelajaran.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus mata pelajaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> <span class="d-none d-lg-inline">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-book"></i>
                                    <p>Belum ada mata pelajaran.</p>
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
function toggleMobileFilter() {
    const filterContent = document.getElementById('mobileFilterContent');
    const chevron = document.getElementById('filterChevron');
    
    filterContent.classList.toggle('show');
    
    if (filterContent.classList.contains('show')) {
        chevron.classList.remove('fa-chevron-down');
        chevron.classList.add('fa-chevron-up');
    } else {
        chevron.classList.remove('fa-chevron-up');
        chevron.classList.add('fa-chevron-down');
    }
}
</script>
@endsection