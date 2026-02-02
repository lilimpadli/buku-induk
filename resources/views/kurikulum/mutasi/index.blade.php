@extends('layouts.app')

@section('title', 'Mutasi Siswa')

@section('content')
<style>
    /* ===================== STYLE MUTASI SISWA ===================== */
    
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

    /* Header Styles */
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

    .btn-info {
        background-color: var(--info-color);
        color: white;
    }

    .btn-info:hover {
        background-color: #2563EB;
        transform: translateY(-2px);
        color: white;
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

    .btn-outline-warning {
        border: 1px solid var(--warning-color);
        color: var(--warning-color);
        background: white;
    }

    .btn-outline-warning:hover {
        background-color: var(--warning-color);
        color: white;
    }

    .btn-outline-danger {
        border: 1px solid var(--danger-color);
        color: var(--danger-color);
        background: white;
    }

    .btn-outline-danger:hover {
        background-color: var(--danger-color);
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

    .table tbody td:nth-child(1),
    .table tbody td:nth-child(2),
    .table tbody td:nth-child(4),
    .table tbody td:nth-child(5),
    .table tbody td:nth-child(7) {
        text-align: center;
    }

    .table tbody td:nth-child(3),
    .table tbody td:nth-child(6) {
        text-align: left;
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

    /* Card List View for Mobile */
    .card-list-view {
        display: none;
    }

    .mutasi-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary-color);
    }

    .mutasi-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateX(4px);
    }

    .mutasi-card-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #F1F5F9;
    }

    .mutasi-card-title {
        flex: 1;
    }

    .mutasi-card-title h6 {
        font-size: 16px;
        font-weight: 600;
        color: #1E293B;
        margin-bottom: 4px;
    }

    .mutasi-card-title small {
        color: #64748B;
        font-size: 13px;
    }

    .mutasi-card-body {
        display: grid;
        gap: 8px;
        margin-bottom: 12px;
    }

    .mutasi-info-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        border-bottom: 1px solid #F8FAFC;
    }

    .mutasi-info-row:last-child {
        border-bottom: none;
    }

    .mutasi-info-label {
        color: #64748B;
        font-size: 12px;
        font-weight: 600;
    }

    .mutasi-info-value {
        color: #1E293B;
        font-size: 14px;
        font-weight: 500;
        text-align: right;
    }

    .mutasi-card-actions {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #F1F5F9;
        display: flex;
        gap: 8px;
    }

    /* Action Buttons Container */
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
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
    }

    /* Mobile (max 767px) */
    @media (max-width: 767px) {
        .container-fluid {
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

        /* Action Buttons */
        .action-buttons {
            width: 100%;
            margin-top: 12px;
        }

        .action-buttons .btn {
            flex: 1;
            font-size: 14px;
        }

        /* Row restructure */
        .row.mb-4 {
            flex-direction: column;
        }

        .row.mb-4 .col-md-6 {
            width: 100%;
        }

        .row.mb-4 .col-md-6.text-end {
            text-align: left !important;
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

        .badge {
            font-size: 11px;
            padding: 4px 10px;
        }

        .mutasi-card-actions .btn {
            flex: 1;
            font-size: 12px;
            padding: 8px 10px;
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

        .card-footer {
            padding: 12px;
        }
    }

    /* Mobile Small (max 575px) */
    @media (max-width: 575px) {
        h1.h3 {
            font-size: 16px;
        }

        .mutasi-card-title h6 {
            font-size: 15px;
        }

        .mutasi-info-label {
            font-size: 11px;
        }

        .mutasi-info-value {
            font-size: 13px;
        }

        .mutasi-card-actions .btn {
            font-size: 11px;
            padding: 6px 8px;
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
    }
</style>

<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="page-header">
                <!-- Menu Toggle (Mobile Only) -->
                <button class="menu-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                
                <h1 class="h3">
                    <i class="fas fa-exchange-alt text-primary"></i> Data Mutasi Siswa
                </h1>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <div class="action-buttons">
                <a href="{{ route('kurikulum.mutasi.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Mutasi
                </a>
                <a href="{{ route('kurikulum.mutasi.laporan') }}" class="btn btn-info">
                    <i class="fas fa-file-pdf"></i> Laporan
                </a>
            </div>
        </div>
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
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 col-12">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Desktop/Tablet View: Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Status Mutasi</th>
                        <th>Tanggal Mutasi</th>
                        <th>Keterangan</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mutasis as $index => $mutasi)
                        <tr>
                            <td>{{ $mutasis->firstItem() + $index }}</td>
                            <td><strong>{{ $mutasi->siswa->nis }}</strong></td>
                            <td>{{ $mutasi->siswa->nama_lengkap }}</td>
                            <td>
                                <span class="badge bg-{{ $mutasi->status_color }}">
                                    {{ $mutasi->status_label }}
                                </span>
                            </td>
                            <td>{{ $mutasi->tanggal_mutasi->format('d M Y') }}</td>
                            <td>
                                @if($mutasi->keterangan)
                                    <small class="text-muted">{{ Str::limit($mutasi->keterangan, 30) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('kurikulum.mutasi.show', $mutasi) }}" class="btn btn-outline-primary" 
                                        data-bs-toggle="tooltip" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kurikulum.mutasi.edit', $mutasi) }}" class="btn btn-outline-warning" 
                                        data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kurikulum.mutasi.destroy', $mutasi) }}" method="POST" 
                                        style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" 
                                            data-bs-toggle="tooltip" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <h5>Tidak ada data mutasi</h5>
                                    <p>Belum ada data mutasi siswa</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View: Card List -->
        <div class="card-list-view">
            @forelse($mutasis as $index => $mutasi)
                <div class="mutasi-card">
                    <div class="mutasi-card-header">
                        <div class="mutasi-card-title">
                            <h6>{{ $mutasi->siswa->nama_lengkap }}</h6>
                            <small>{{ $mutasi->siswa->nis }}</small>
                        </div>
                        <span class="badge bg-{{ $mutasi->status_color }}">
                            {{ $mutasi->status_label }}
                        </span>
                    </div>
                    
                    <div class="mutasi-card-body">
                        <div class="mutasi-info-row">
                            <span class="mutasi-info-label">Tanggal Mutasi</span>
                            <span class="mutasi-info-value">{{ $mutasi->tanggal_mutasi->format('d M Y') }}</span>
                        </div>
                        
                        <div class="mutasi-info-row">
                            <span class="mutasi-info-label">Keterangan</span>
                            <span class="mutasi-info-value">
                                @if($mutasi->keterangan)
                                    <small class="text-muted">{{ Str::limit($mutasi->keterangan, 40) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <div class="mutasi-card-actions">
                        <a href="{{ route('kurikulum.mutasi.show', $mutasi) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i> Lihat
                        </a>
                        <a href="{{ route('kurikulum.mutasi.edit', $mutasi) }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <form action="{{ route('kurikulum.mutasi.destroy', $mutasi) }}" method="POST" 
                            style="flex: 1; display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h5>Tidak ada data mutasi</h5>
                    <p>Belum ada data mutasi siswa</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($mutasis->hasPages())
            <div class="card-footer">
                {{ $mutasis->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
@endsection