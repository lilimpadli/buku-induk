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

    /* Header with Menu Icon */
    .page-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }

    .menu-toggle {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .menu-toggle:hover {
        background: var(--light-bg);
        border-color: var(--primary-color);
    }

    .menu-toggle i {
        color: #64748B;
        font-size: 18px;
    }

    h1.h3 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 0 !important;
        flex: 1;
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

    h1.h3 i {
        margin-right: 8px;
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
        border: none;
    }

    .btn-primary {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
    }

    .btn-primary:hover {
        background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(47, 83, 255, 0.3);
    }

    .btn-secondary {
        background-color: #64748B;
    }

    .btn-secondary:hover {
        background-color: #475569;
        transform: translateY(-2px);
    }

    .btn-outline-primary {
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
        background: white;
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-outline-success {
        border: 1px solid var(--success-color);
        color: var(--success-color);
        background: white;
    }

    .btn-outline-success:hover {
        background-color: var(--success-color);
        color: white;
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
        background-color: #F8FAFC;
        border-bottom: 2px solid #E2E8F0;
        padding: 15px;
        vertical-align: middle;
        text-align: center;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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

    /* Card List View for Mobile */
    .card-list-view {
        display: none;
    }

    .student-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary-color);
    }

    .student-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateX(4px);
    }

    .student-card-header {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
        align-items: center;
    }

    .student-card-body {
        display: grid;
        gap: 8px;
    }

    .student-info-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        border-bottom: 1px solid #F1F5F9;
    }

    .student-info-row:last-child {
        border-bottom: none;
    }

    .student-info-label {
        color: #64748B;
        font-size: 12px;
        font-weight: 600;
    }

    .student-info-value {
        color: #1E293B;
        font-size: 14px;
        font-weight: 500;
    }

    .student-card-actions {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #F1F5F9;
        display: flex;
        gap: 8px;
    }

    /* ===================== RESPONSIVE STYLES ===================== */

    /* Tablet (768px - 991px) */
    @media (max-width: 991px) {
        h1.h3 {
            font-size: 24px;
        }

        .table thead th {
            font-size: 11px;
            padding: 12px 8px;
        }

        .table tbody td {
            font-size: 13px;
            padding: 12px 8px;
        }

        .student-avatar {
            width: 45px;
            height: 45px;
            font-size: 18px;
        }
    }

    /* Mobile (max 767px) */
    @media (max-width: 767px) {
        .container {
            padding-left: 12px;
            padding-right: 12px;
        }

        /* Header Section */
        .page-header {
            gap: 10px;
            margin-bottom: 15px;
        }

        .menu-toggle {
            width: 36px;
            height: 36px;
        }

        .menu-toggle i {
            font-size: 16px;
        }

        h1.h3 {
            font-size: 18px;
            padding-left: 12px;
        }

        h1.h3::before {
            width: 4px;
        }

        h1.h3 i {
            font-size: 16px;
        }

        .header-actions {
            flex-direction: column;
            gap: 12px;
            align-items: stretch !important;
            width: 100%;
        }

        .btn-secondary {
            width: 100%;
            justify-content: center;
            display: flex;
            align-items: center;
        }

        /* Filter Card */
        .card-body {
            padding: 16px !important;
        }

        .row.g-3 {
            gap: 12px !important;
        }

        .col-md-4 {
            padding: 0 !important;
        }

        .form-control, .form-select {
            font-size: 14px;
        }

        /* Hide Table, Show Card List */
        .table-responsive {
            display: none !important;
        }

        .card-list-view {
            display: block;
            padding: 12px;
        }

        .student-avatar {
            width: 55px;
            height: 55px;
            font-size: 22px;
        }

        .badge {
            font-size: 11px;
            padding: 4px 10px;
        }

        .student-card-actions .btn {
            flex: 1;
            font-size: 13px;
        }

        /* Empty State */
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

        /* Pagination */
        .pagination {
            font-size: 14px;
        }

        .pagination .page-link {
            padding: 6px 10px;
        }
    }

    /* Mobile Small (max 575px) */
    @media (max-width: 575px) {
        h1.h3 {
            font-size: 16px;
        }

        .student-avatar {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .student-info-label {
            font-size: 11px;
        }

        .student-info-value {
            font-size: 13px;
        }

        .student-card-actions .btn {
            font-size: 12px;
            padding: 8px 12px;
        }
    }

    /* Desktop (min 768px) - Show table */
    @media (min-width: 768px) {
        .card-list-view {
            display: none !important;
        }

        .table-responsive {
            display: block !important;
        }

        .menu-toggle {
            display: none;
        }
    }

    /* Desktop Large (1200px+) */
    @media (min-width: 1200px) {
        .container {
            max-width: 1140px;
        }

        h1.h3 {
            font-size: 30px;
        }

        .table thead th {
            font-size: 14px;
            padding: 18px;
        }

        .table tbody td {
            font-size: 15px;
            padding: 18px;
        }

        .student-avatar {
            width: 55px;
            height: 55px;
            font-size: 22px;
        }
    }
</style>

<div class="container mt-4">
    <!-- Header with Menu Toggle -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="page-header">
          
            
            <h1 class="h3">
                <i class="fas fa-book text-primary"></i> Buku Induk Siswa
            </h1>
        </div>
        
        <a href="{{ route('kurikulum.siswa.index') }}" class="btn btn-secondary d-none d-md-flex">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Back Button for Mobile -->
    <div class="d-md-none mb-3">
        <a href="{{ route('kurikulum.siswa.index') }}" class="btn btn-secondary w-100">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4 col-12">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, NIS, atau NISN..." 
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

    <!-- Desktop/Tablet View: Table -->
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
                        <th>JK</th>
                        <th>Rombel</th>
                        <th>Status</th>
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
                            <td><strong>{{ $siswa->nama_lengkap }}</strong></td>
                            <td>
                                @if($siswa->jenis_kelamin == 'L')
                                    <span class="badge bg-info">L</span>
                                @elseif($siswa->jenis_kelamin == 'P')
                                    <span class="badge bg-danger">P</span>
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
                                    <a href="{{ route('kurikulum.buku-induk.show', $siswa) }}" class="btn btn-outline-primary" 
                                        data-bs-toggle="tooltip" title="Lihat Buku Induk">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kurikulum.buku-induk.cetak', $siswa) }}" target="_blank" class="btn btn-outline-success" 
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

        <!-- Mobile View: Card List -->
        <div class="card-list-view">
            @forelse($siswas as $index => $siswa)
                <div class="student-card">
                    <div class="student-card-header">
                        <div class="student-avatar">
                            @if($siswa->user && $siswa->user->photo)
                                <img src="{{ Storage::url($siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}">
                            @else
                                {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <strong style="font-size: 16px; color: #1E293B; display: block;">{{ $siswa->nama_lengkap }}</strong>
                            <small style="color: #64748B;">{{ $siswa->nis }} • {{ $siswa->nisn ?? '-' }}</small>
                        </div>
                    </div>
                    
                    <div class="student-card-body">
                        <div class="student-info-row">
                            <span class="student-info-label">Jenis Kelamin</span>
                            <span class="student-info-value">
                                @if($siswa->jenis_kelamin == 'L')
                                    <span class="badge bg-info">Laki-laki</span>
                                @elseif($siswa->jenis_kelamin == 'P')
                                    <span class="badge bg-danger">Perempuan</span>
                                @else
                                    {{ $siswa->jenis_kelamin }}
                                @endif
                            </span>
                        </div>
                        
                        <div class="student-info-row">
                            <span class="student-info-label">Rombel</span>
                            <span class="student-info-value">
                                @if($siswa->rombel)
                                    <span class="badge bg-primary">{{ $siswa->rombel->nama }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </span>
                        </div>
                        
                        <div class="student-info-row">
                            <span class="student-info-label">Status</span>
                            <span class="student-info-value">
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
                        <a href="{{ route('kurikulum.buku-induk.show', $siswa) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i> Lihat
                        </a>
                        <a href="{{ route('kurikulum.buku-induk.cetak', $siswa) }}" target="_blank" class="btn btn-outline-success btn-sm">
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

        <!-- Pagination -->
        @if($siswas->hasPages())
            <div class="p-3">
                {{ $siswas->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
@endsection