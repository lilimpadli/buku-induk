@extends('layouts.app')

@section('title', 'PPDB - Pendaftar ' . $jurusan->nama . ' - Jalur ' . $jalur->nama_jalur)

@section('content')
<style>
    /* PPDB Jalur Pendaftar Styles */
    .ppdb-jalur-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 15px 15px 0 0;
    }

    .ppdb-jalur-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        overflow: hidden;
    }

    .jalur-badge {
        background-color: rgba(255, 255, 255, 0.2);
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        display: inline-block;
        margin-top: 0.5rem;
    }

    .pendaftar-table {
        margin-bottom: 0;
    }

    .pendaftar-table thead {
        background-color: #f8f9fa;
    }

    .pendaftar-table thead th {
        font-weight: 600;
        color: #2d3748;
        border-bottom: 2px solid #e2e8f0;
        padding: 1rem 0.75rem;
        font-size: 0.9rem;
    }

    .pendaftar-table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        color: #4a5568;
    }

    .pendaftar-table tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.03);
    }

    .badge {
        padding: 0.4rem 0.75rem;
        font-weight: 500;
        font-size: 0.8rem;
    }

    /* Mobile Card View */
    .mobile-card-view {
        display: none;
    }

    .pendaftar-mobile-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        background: white;
        transition: all 0.3s ease;
    }

    .pendaftar-mobile-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .pendaftar-mobile-card .card-title {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
        font-size: 1rem;
        display: flex;
        align-items: start;
        gap: 0.5rem;
    }

    .pendaftar-mobile-card .info-row {
        display: flex;
        justify-content: space-between;
        padding: 0.4rem 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.875rem;
        gap: 1rem;
    }

    .pendaftar-mobile-card .info-row:last-child {
        border-bottom: none;
    }

    .pendaftar-mobile-card .info-label {
        color: #64748b;
        font-weight: 500;
        flex-shrink: 0;
    }

    .pendaftar-mobile-card .info-value {
        color: #2d3748;
        text-align: right;
        flex-grow: 1;
    }

    .pendaftar-mobile-card .action-section {
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 2px solid #f1f5f9;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #64748b;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
        color: #667eea;
    }

    @media (max-width: 992px) {
        .table-responsive {
            display: none !important;
        }

        .mobile-card-view {
            display: block !important;
        }
    }

    @media (max-width: 768px) {
        .ppdb-jalur-header {
            padding: 1.25rem 1rem;
        }

        .ppdb-jalur-header h5 {
            font-size: 1rem;
            margin-bottom: 0.35rem;
        }

        .ppdb-jalur-header small {
            font-size: 0.85rem;
        }

        .jalur-badge {
            font-size: 0.8rem;
            padding: 0.35rem 0.7rem;
            margin-top: 0.4rem;
        }

        .header-actions .btn {
            font-size: 0.85rem;
            padding: 0.45rem 0.75rem;
        }

        .pendaftar-mobile-card {
            padding: 0.875rem;
        }

        .pendaftar-mobile-card .card-title {
            font-size: 0.95rem;
        }

        .pendaftar-mobile-card .info-row {
            font-size: 0.825rem;
        }

        .empty-state {
            padding: 2rem 1rem;
        }

        .empty-state i {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 576px) {
        .ppdb-jalur-header {
            border-radius: 10px 10px 0 0;
            padding: 1rem 0.875rem;
        }

        .ppdb-jalur-header h5 {
            font-size: 0.95rem;
            margin-bottom: 0.3rem;
        }

        .ppdb-jalur-header small {
            font-size: 0.8rem;
        }

        .jalur-badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }

        .header-actions {
            width: 100%;
            margin-top: 0.75rem;
        }

        .header-actions .btn {
            width: 100%;
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }

        .pendaftar-mobile-card {
            padding: 0.75rem;
            margin-bottom: 0.65rem;
        }

        .pendaftar-mobile-card .card-title {
            font-size: 0.9rem;
            margin-bottom: 0.6rem;
            flex-direction: column;
            gap: 0.25rem;
        }

        .pendaftar-mobile-card .info-row {
            font-size: 0.8rem;
            padding: 0.35rem 0;
            flex-direction: column;
            gap: 0.2rem;
        }

        .pendaftar-mobile-card .info-label {
            font-weight: 600;
        }

        .pendaftar-mobile-card .info-value {
            text-align: left;
        }

        .pendaftar-mobile-card .badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }

        .pendaftar-mobile-card .btn-sm {
            font-size: 0.8rem;
            padding: 0.4rem 0.75rem;
        }

        .empty-state {
            padding: 1.5rem 0.75rem;
        }

        .empty-state i {
            font-size: 2rem;
        }

        .empty-state h5 {
            font-size: 0.95rem;
        }

        .empty-state p {
            font-size: 0.85rem;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="card ppdb-jalur-card">
        <div class="ppdb-jalur-header">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="flex-grow-1">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2"></i>
                        Pendaftar Jurusan: {{ $jurusan->nama }}
                    </h5>
                    <small class="d-block mt-1">
                        <i class="fas fa-route me-1"></i>
                        Jalur: {{ $jalur->nama_jalur }}
                    </small>
                    <div class="jalur-badge">
                        <i class="fas fa-user-check me-1"></i>
                        {{ $pendaftars->count() }} Pendaftar
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('tu.ppdb.jurusan.show', $jurusan->id) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        <span class="d-none d-sm-inline">Kembali</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body p-3 p-md-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {!! session('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Desktop Table View -->
            <div class="table-responsive">
                <table class="table table-striped table-hover pendaftar-table">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>NISN</th>
                            <th>Jenis Kelamin</th>
                            <th>Sesi</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendaftars as $pendaftar)
                            <tr>
                                <td>
                                    <strong>{{ $pendaftar->nama_lengkap }}</strong>
                                </td>
                                <td>{{ $pendaftar->nisn ?? '-' }}</td>
                                <td>{{ $pendaftar->jenis_kelamin }}</td>
                                <td>{{ optional($pendaftar->sesi)->tahun_ajaran ?? '-' }}</td>
                                <td>
                                    @if($pendaftar->status == 'diterima')
                                        <span class="badge bg-warning text-dark">Diterima</span>
                                    @elseif($pendaftar->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($pendaftar->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $pendaftar->created_at->format('d/m/Y') }}</small>
                                </td>
                                <td>
                                    @if($pendaftar->status == 'diterima')
                                        <a href="{{ route('tu.ppdb.assign.form', $pendaftar->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-user-plus me-1"></i>Assign
                                        </a>
                                    @else
                                        <span class="text-muted small">Sudah diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h5>Tidak ada pendaftar</h5>
                                        <p class="mb-0">Belum ada pendaftar untuk jurusan dan jalur ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="mobile-card-view">
                @forelse ($pendaftars as $pendaftar)
                    <div class="pendaftar-mobile-card">
                        <div class="card-title">
                            <i class="fas fa-user-graduate text-primary"></i>
                            <span>{{ $pendaftar->nama_lengkap }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">NISN</span>
                            <span class="info-value">{{ $pendaftar->nisn ?? '-' }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Jenis Kelamin</span>
                            <span class="info-value">{{ $pendaftar->jenis_kelamin }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Sesi</span>
                            <span class="info-value">{{ optional($pendaftar->sesi)->tahun_ajaran ?? '-' }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                                @if($pendaftar->status == 'diterima')
                                    <span class="badge bg-warning text-dark">Diterima</span>
                                @elseif($pendaftar->status == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($pendaftar->status) }}</span>
                                @endif
                            </span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Tanggal Daftar</span>
                            <span class="info-value">{{ $pendaftar->created_at->format('d/m/Y') }}</span>
                        </div>
                        
                        <div class="action-section">
                            @if($pendaftar->status == 'diterima')
                                <a href="{{ route('tu.ppdb.assign.form', $pendaftar->id) }}" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-user-plus me-2"></i>Assign Rombel
                                </a>
                            @else
                                <div class="text-center text-muted small">
                                    <i class="fas fa-check-circle me-1"></i>Sudah diproses
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h5>Tidak ada pendaftar</h5>
                        <p class="mb-0">Belum ada pendaftar untuk jurusan dan jalur ini</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection