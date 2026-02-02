@extends('layouts.app')

@section('title', 'Mutasi Siswa')

@section('content')
<style>
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
    }

    h1.h3 {
        font-size: clamp(18px, 4vw, 24px);
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 0;
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

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        gap: 15px;
        flex-wrap: wrap;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        white-space: nowrap;
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

    .btn-info {
        background-color: var(--info-color);
        border: none;
        color: white;
    }

    .btn-info:hover {
        background-color: #2563EB;
        transform: translateY(-2px);
        color: white;
    }

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
        background-color: #F8FAFC;
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

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: clamp(10px, 2vw, 12px);
        font-weight: 600;
    }

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

    /* Mobile Card View */
    .mobile-card-view {
        display: none;
    }

    .mutasi-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary-color);
    }

    .mutasi-card:hover {
        box-shadow: var(--hover-shadow);
        transform: translateY(-2px);
    }

    .mutasi-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #F1F5F9;
    }

    .mutasi-card-title {
        flex: 1;
    }

    .mutasi-card-name {
        font-weight: 600;
        font-size: 15px;
        color: #1E293B;
        margin-bottom: 4px;
    }

    .mutasi-card-nis {
        font-size: 12px;
        color: #64748B;
    }

    .mutasi-card-body {
        display: grid;
        gap: 8px;
        margin-bottom: 12px;
    }

    .mutasi-card-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .mutasi-card-label {
        font-size: 11px;
        color: #64748B;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .mutasi-card-value {
        font-size: 13px;
        color: #1E293B;
        font-weight: 500;
        text-align: right;
    }

    .mutasi-card-actions {
        display: flex;
        gap: 8px;
        padding-top: 12px;
        border-top: 1px solid #F1F5F9;
    }

    .mutasi-card-actions .btn {
        flex: 1;
        font-size: 13px;
        padding: 8px 10px;
    }

    .mutasi-card-actions form {
        flex: 1;
    }

    .mutasi-card-actions form .btn {
        width: 100%;
    }

    /* Responsive Styles */
    @media (max-width: 767px) {
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }

        h1.h3 {
            font-size: 16px;
            padding-left: 12px;
        }

        h1.h3 i {
            display: none;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .action-buttons {
            width: 100%;
        }

        .action-buttons .btn {
            flex: 1;
            font-size: 13px;
            padding: 8px 12px;
        }

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

        /* Hide table, show mobile cards */
        .table-responsive {
            display: none !important;
        }

        .mobile-card-view {
            display: block;
        }

        .card-footer {
            padding: 12px;
        }

        .pagination {
            font-size: 14px;
        }

        .page-link {
            padding: 6px 12px;
        }
    }

    /* Tablet Styles */
    @media (min-width: 768px) and (max-width: 991px) {
        .table thead th, 
        .table tbody td {
            padding: 12px 10px;
            font-size: 13px;
        }

        .btn-group-sm .btn {
            padding: 6px 8px;
            font-size: 12px;
        }

        h1.h3 {
            font-size: 20px;
        }

        .action-buttons .btn {
            font-size: 13px;
            padding: 8px 14px;
        }
    }

    /* Desktop Styles */
    @media (min-width: 992px) {
        .table thead th, 
        .table tbody td {
            padding: 15px;
        }

        .mobile-card-view {
            display: none !important;
        }
    }

    /* Large Desktop */
    @media (min-width: 1200px) {
        .container-fluid {
            max-width: 1140px;
        }
    }

    /* Extra Large Screens */
    @media (min-width: 1400px) {
        .container-fluid {
            max-width: 1320px;
        }
    }

    /* Landscape on Mobile */
    @media (max-width: 767px) and (orientation: landscape) {
        .mutasi-card {
            padding: 12px;
        }

        .mutasi-card-header {
            margin-bottom: 10px;
            padding-bottom: 10px;
        }
    }

    /* Print Styles */
    @media print {
        .page-header .action-buttons,
        .card-body form,
        .btn-group,
        .mutasi-card-actions {
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

<div class="container-fluid mt-4">
    <div class="page-header">
        <h1 class="h3">
            <i class="fas fa-exchange-alt text-primary"></i> Data Mutasi Siswa
        </h1>
        <div class="action-buttons">
            <a href="{{ route('tu.mutasi.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Mutasi
            </a>
            <a href="{{ route('tu.mutasi.laporan') }}" class="btn btn-info btn-sm">
                <i class="fas fa-file-pdf me-1"></i> Laporan
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card">
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
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Desktop Table View -->
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
                            <td class="text-center">{{ $mutasis->firstItem() + $index }}</td>
                            <td class="text-center"><strong>{{ $mutasi->siswa->nis }}</strong></td>
                            <td>{{ $mutasi->siswa->nama_lengkap }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $mutasi->status_color }}">
                                    {{ $mutasi->status_label }}
                                </span>
                            </td>
                            <td class="text-center">{{ $mutasi->tanggal_mutasi->format('d M Y') }}</td>
                            <td>
                                @if($mutasi->keterangan)
                                    <small class="text-muted">{{ Str::limit($mutasi->keterangan, 30) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('tu.mutasi.show', $mutasi) }}" class="btn btn-outline-primary" 
                                        data-bs-toggle="tooltip" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tu.mutasi.edit', $mutasi) }}" class="btn btn-outline-warning" 
                                        data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tu.mutasi.destroy', $mutasi) }}" method="POST" 
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
                                    <p class="mt-3 mb-0">Belum ada data mutasi siswa</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($mutasis->hasPages())
            <div class="card-footer">
                {{ $mutasis->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>

    <!-- Mobile Card View -->
    <div class="mobile-card-view">
        @forelse($mutasis as $mutasi)
            <div class="mutasi-card">
                <div class="mutasi-card-header">
                    <div class="mutasi-card-title">
                        <div class="mutasi-card-name">{{ $mutasi->siswa->nama_lengkap }}</div>
                        <div class="mutasi-card-nis">NIS: {{ $mutasi->siswa->nis }}</div>
                    </div>
                    <span class="badge bg-{{ $mutasi->status_color }}">
                        {{ $mutasi->status_label }}
                    </span>
                </div>

                <div class="mutasi-card-body">
                    <div class="mutasi-card-row">
                        <span class="mutasi-card-label">Tanggal Mutasi</span>
                        <span class="mutasi-card-value">{{ $mutasi->tanggal_mutasi->format('d M Y') }}</span>
                    </div>

                    @if($mutasi->keterangan)
                        <div class="mutasi-card-row">
                            <span class="mutasi-card-label">Keterangan</span>
                            <span class="mutasi-card-value text-muted" style="font-size: 12px;">
                                {{ Str::limit($mutasi->keterangan, 40) }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="mutasi-card-actions">
                    <a href="{{ route('tu.mutasi.show', $mutasi) }}" class="btn btn-primary">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>
                    <a href="{{ route('tu.mutasi.edit', $mutasi) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('tu.mutasi.destroy', $mutasi) }}" method="POST" 
                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p class="mt-3">Belum ada data mutasi siswa</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($mutasis->hasPages())
        <div class="mt-3">
            {{ $mutasis->links() }}
        </div>
    @endif
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