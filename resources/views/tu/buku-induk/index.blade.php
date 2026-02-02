@extends('layouts.app')

@section('title', 'Daftar Buku Induk Siswa')

@section('content')
<style>
    /* ===================== STYLE DAFTAR BUKU INDUK SISWA ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --info-color: #3B82F6;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    h1.h3 {
        font-size: clamp(20px, 5vw, 28px);
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 25px !important;
    }

    h1.h3::before {
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

    /* Button Styles */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(47, 83, 255, 0.3);
    }

    .btn-secondary {
        background-color: #64748B;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #475569;
        transform: translateY(-2px);
    }

    /* Form Styles */
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
    }

    /* Table Styles */
    .table {
        margin-bottom: 0;
    }

    .table thead th {
        font-weight: 600;
        color: #1E293B;
        border-bottom: 2px solid #E2E8F0;
        padding: 15px;
        vertical-align: middle;
        text-align: center;
        white-space: nowrap;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        position: relative;
    }

    .table tbody tr::before {
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

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
    }

    .table tbody tr:hover::before {
        transform: scaleY(1);
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-top: 1px solid #F1F5F9;
    }

    /* Align text center for certain columns */
    .table tbody td:nth-child(1),
    .table tbody td:nth-child(2),
    .table tbody td:nth-child(3),
    .table tbody td:nth-child(4),
    .table tbody td:nth-child(6),
    .table tbody td:nth-child(7),
    .table tbody td:nth-child(8),
    .table tbody td:nth-child(9) {
        text-align: center;
    }

    .table tbody td:nth-child(5) {
        text-align: left;
    }

    /* Student Avatar */
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
        margin: 0 auto;
    }

    .table tbody tr:hover .student-avatar {
        transform: scale(1.1);
    }

    .student-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    /* Badge Styles */
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
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

    .table tbody tr {
        animation: fadeIn 0.5s ease-out;
    }

    /* Header Section */
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        gap: 15px;
        flex-wrap: wrap;
    }

    /* Mobile Card View */
    .mobile-card-view {
        display: none;
    }

    .student-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
    }

    .student-card:hover {
        box-shadow: var(--hover-shadow);
        transform: translateY(-2px);
    }

    .student-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #F1F5F9;
    }

    .student-card-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 24px;
        flex-shrink: 0;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .student-card-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .student-card-info {
        flex: 1;
    }

    .student-card-name {
        font-weight: 600;
        font-size: 16px;
        color: #1E293B;
        margin-bottom: 5px;
    }

    .student-card-nis {
        font-size: 13px;
        color: #64748B;
    }

    .student-card-body {
        display: grid;
        gap: 10px;
    }

    .student-card-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
    }

    .student-card-label {
        font-size: 12px;
        color: #64748B;
        font-weight: 500;
    }

    .student-card-value {
        font-size: 14px;
        color: #1E293B;
        font-weight: 500;
    }

    .student-card-actions {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #F1F5F9;
        display: flex;
        gap: 10px;
    }

    .student-card-actions .btn {
        flex: 1;
        font-size: 14px;
    }

    /* Responsive Styles */
    /* Mobile First - Small devices */
    @media (max-width: 767px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }

        h1.h3 {
            font-size: 18px;
            padding-left: 12px;
        }

        h1.h3 i {
            display: none;
        }

        .header-section {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-secondary {
            width: 100%;
            justify-content: center;
        }

        /* Hide table, show mobile cards */
        .table-responsive {
            display: none !important;
        }

        .mobile-card-view {
            display: block;
        }

        /* Filter Form */
        .card-body .row {
            gap: 10px;
        }

        .card-body .col-md-4 {
            padding-left: 0;
            padding-right: 0;
        }

        .form-control, .form-select {
            font-size: 14px;
            padding: 8px 12px;
        }

        .btn-primary {
            padding: 10px;
            font-size: 14px;
        }

        .badge {
            font-size: 11px;
            padding: 4px 10px;
        }

        /* Pagination */
        .pagination {
            font-size: 14px;
        }

        .page-link {
            padding: 6px 12px;
        }
    }

    /* Tablet devices */
    @media (min-width: 768px) and (max-width: 991px) {
        .table thead th, 
        .table tbody td {
            padding: 12px 10px;
            font-size: 13px;
        }

        .student-avatar {
            width: 45px;
            height: 45px;
            font-size: 18px;
        }

        .btn-group-sm .btn {
            padding: 6px 10px;
            font-size: 13px;
        }

        h1.h3 {
            font-size: 24px;
        }
    }

    /* Desktop devices */
    @media (min-width: 992px) {
        .table thead th, 
        .table tbody td {
            padding: 15px;
        }

        .mobile-card-view {
            display: none !important;
        }
    }

    /* Large desktop */
    @media (min-width: 1200px) {
        .container {
            max-width: 1140px;
        }
    }

    /* Extra large screens */
    @media (min-width: 1400px) {
        .container {
            max-width: 1320px;
        }
    }

    /* Landscape orientation on mobile */
    @media (max-width: 767px) and (orientation: landscape) {
        .student-card {
            padding: 12px;
        }

        .student-card-header {
            margin-bottom: 12px;
            padding-bottom: 12px;
        }

        .student-card-avatar {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }
    }

    /* Print styles */
    @media print {
        .btn, .header-section .btn-secondary, .card-body form {
            display: none !important;
        }

        .card {
            box-shadow: none;
            border: 1px solid #ddd;
        }

        .table tbody tr:hover {
            background-color: transparent;
        }
    }
</style>

<div class="container mt-4">
    <div class="header-section">
        <h1 class="h3 mb-0">
            <i class="fas fa-book text-primary"></i> Daftar Buku Induk Siswa
        </h1>
        <a href="{{ route('tu.siswa.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4 col-12">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, NIS, atau NISN siswa..." 
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-4 col-12">
                    <select name="jurusan_id" class="form-select">
                        <option value="">-- Semua Jurusan --</option>
                        @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 col-12">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="card shadow">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 70px;">Foto</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Rombel</th>
                        <th>Status Terakhir</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $index => $siswa)
                        <tr>
                            <td>{{ $siswas->firstItem() + $index }}</td>
                            <td>
                                <div class="student-avatar" data-bs-toggle="tooltip" title="{{ $siswa->nama_lengkap }}">
                                    @if($siswa->user && $siswa->user->photo)
                                        <img src="{{ Storage::url($siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}">
                                    @else
                                        {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                    @endif
                                </div>
                            </td>
                            <td><strong>{{ $siswa->nis }}</strong></td>
                            <td>{{ $siswa->nisn ?? '-' }}</td>
                            <td>{{ $siswa->nama_lengkap }}</td>
                            <td>
                                @if($siswa->jenis_kelamin == 'L')
                                    <span class="badge bg-info">Laki-laki</span>
                                @elseif($siswa->jenis_kelamin == 'P')
                                    <span class="badge bg-danger">Perempuan</span>
                                @else
                                    {{ $siswa->jenis_kelamin }}
                                @endif
                            </td>
                            <td>
                                @if($siswa->rombel)
                                    <span class="badge bg-primary">{{ $siswa->rombel->nama }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($siswa->mutasiTerakhir)
                                    <span class="badge bg-{{ $siswa->mutasiTerakhir->status_color }}">
                                        {{ $siswa->mutasiTerakhir->status_label }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('tu.buku-induk.show', $siswa) }}" class="btn btn-outline-primary" 
                                        data-bs-toggle="tooltip" title="Lihat Buku Induk">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tu.buku-induk.cetak', $siswa) }}" target="_blank" class="btn btn-outline-success" 
                                        data-bs-toggle="tooltip" title="Cetak">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <h5>Tidak ada data siswa</h5>
                                    <p>Belum ada siswa yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($siswas->hasPages())
            <div class="p-3">
                {{ $siswas->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>

    <!-- Mobile Card View -->
    <div class="mobile-card-view">
        @forelse($siswas as $siswa)
            <div class="student-card">
                <div class="student-card-header">
                    <div class="student-card-avatar">
                        @if($siswa->user && $siswa->user->photo)
                            <img src="{{ Storage::url($siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}">
                        @else
                            {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                        @endif
                    </div>
                    <div class="student-card-info">
                        <div class="student-card-name">{{ $siswa->nama_lengkap }}</div>
                        <div class="student-card-nis">NIS: {{ $siswa->nis }} | NISN: {{ $siswa->nisn ?? '-' }}</div>
                    </div>
                </div>

                <div class="student-card-body">
                    <div class="student-card-row">
                        <span class="student-card-label">Jenis Kelamin</span>
                        <span class="student-card-value">
                            @if($siswa->jenis_kelamin == 'L')
                                <span class="badge bg-info">Laki-laki</span>
                            @elseif($siswa->jenis_kelamin == 'P')
                                <span class="badge bg-danger">Perempuan</span>
                            @else
                                {{ $siswa->jenis_kelamin }}
                            @endif
                        </span>
                    </div>

                    <div class="student-card-row">
                        <span class="student-card-label">Rombel</span>
                        <span class="student-card-value">
                            @if($siswa->rombel)
                                <span class="badge bg-primary">{{ $siswa->rombel->nama }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </span>
                    </div>

                    <div class="student-card-row">
                        <span class="student-card-label">Status</span>
                        <span class="student-card-value">
                            @if($siswa->mutasiTerakhir)
                                <span class="badge bg-{{ $siswa->mutasiTerakhir->status_color }}">
                                    {{ $siswa->mutasiTerakhir->status_label }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Aktif</span>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="student-card-actions">
                    <a href="{{ route('tu.buku-induk.show', $siswa) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>
                    <a href="{{ route('tu.buku-induk.cetak', $siswa) }}" target="_blank" class="btn btn-success btn-sm">
                        <i class="fas fa-print me-1"></i> Cetak
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h5>Tidak ada data siswa</h5>
                <p>Belum ada siswa yang terdaftar.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination - Single location at bottom -->
    @if($siswas->hasPages())
        <div class="mt-3">
            {{ $siswas->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
@endsection