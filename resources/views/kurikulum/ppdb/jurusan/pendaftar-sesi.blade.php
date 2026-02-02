@extends('layouts.app')

@section('title', 'PPDB - Pendaftar ' . $jurusan->nama . ' - Sesi ' . $sesi->tahun_ajaran)

@section('content')
<style>
    /* ===================== STYLE PPDB PENDAFTAR SESI - RESPONSIVE ===================== */
    
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
        padding: 1.5rem;
        border-bottom: none;
    }

    .card-header h5 {
        font-weight: 600;
        margin-bottom: 0.25rem;
        font-size: 20px;
    }

    .card-header small {
        opacity: 0.9;
        font-size: 14px;
    }

    .card-header .btn {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .card-header .btn:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Alert Styles */
    .alert {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    }

    .alert-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: #065f46;
    }

    /* Table Styles - Desktop */
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
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #E2E8F0;
        padding: 1rem;
        white-space: nowrap;
    }

    .table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #F1F5F9;
    }

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
        transform: scale(1.01);
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #334155;
        font-size: 14px;
    }

    /* Badge Styles */
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 12px;
        letter-spacing: 0.3px;
    }

    .bg-warning {
        background-color: #FEF3C7 !important;
        color: #92400E !important;
    }

    .bg-success {
        background-color: #D1FAE5 !important;
        color: #065F46 !important;
    }

    .bg-secondary {
        background-color: #F1F5F9 !important;
        color: #475569 !important;
    }

    /* Button Styles */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 83, 255, 0.4);
    }

    .btn-sm {
        font-size: 13px;
        padding: 6px 12px;
    }

    /* Mobile Card View */
    .mobile-card-view {
        display: none;
    }

    .registrant-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid #E2E8F0;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .registrant-card:hover {
        box-shadow: var(--card-shadow);
        transform: translateY(-2px);
    }

    .registrant-card-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #F1F5F9;
    }

    .registrant-name {
        font-weight: 600;
        font-size: 16px;
        color: #1E293B;
        margin-bottom: 0.25rem;
    }

    .registrant-nisn {
        font-size: 13px;
        color: #64748B;
    }

    .registrant-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-label {
        font-size: 12px;
        color: #64748B;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .detail-value {
        font-size: 14px;
        color: #1E293B;
        font-weight: 500;
    }

    .registrant-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #F1F5F9;
    }

    .registrant-actions .btn {
        flex: 1;
        justify-content: center;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #64748B;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h5 {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #475569;
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

    .registrant-card {
        animation: fadeIn 0.4s ease-out;
    }

    /* ===================== RESPONSIVE STYLES ===================== */

    /* Tablet (max-width: 991px) */
    @media (max-width: 991px) {
        .card-header h5 {
            font-size: 18px;
        }

        .card-header small {
            font-size: 13px;
        }

        .table thead th,
        .table tbody td {
            font-size: 13px;
            padding: 0.75rem;
        }
    }

    /* Mobile (max-width: 767px) */
    @media (max-width: 767px) {
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Card Header */
        .card-header {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 1rem;
            padding: 1.25rem;
        }

        .card-header h5 {
            font-size: 17px;
        }

        .card-header small {
            font-size: 13px;
            display: block;
            margin-bottom: 0.5rem;
        }

        .card-header .btn {
            width: 100%;
            justify-content: center;
        }

        .card-body {
            padding: 1rem;
        }

        /* Hide table, show mobile cards */
        .table-responsive {
            display: none !important;
        }

        .mobile-card-view {
            display: block;
        }

        /* Registrant Details Grid */
        .registrant-details {
            grid-template-columns: 1fr;
        }

        .detail-item {
            padding-bottom: 0.5rem;
        }
    }

    /* Small Mobile (max-width: 480px) */
    @media (max-width: 480px) {
        .card-header {
            padding: 1rem;
        }

        .card-header h5 {
            font-size: 16px;
        }

        .card-header small {
            font-size: 12px;
        }

        .registrant-card {
            padding: 1rem;
        }

        .registrant-name {
            font-size: 15px;
        }

        .registrant-nisn {
            font-size: 12px;
        }

        .detail-label {
            font-size: 11px;
        }

        .detail-value {
            font-size: 13px;
        }

        .btn-sm {
            font-size: 12px;
            padding: 6px 10px;
        }
    }

    /* Desktop (min-width: 1200px) */
    @media (min-width: 1200px) {
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
        }

        .card-header h5 {
            font-size: 22px;
        }

        .table thead th,
        .table tbody td {
            padding: 1.25rem;
            font-size: 15px;
        }
    }

    /* Print Styles */
    @media print {
        .card-header .btn,
        .registrant-actions,
        .alert {
            display: none !important;
        }

        .card {
            box-shadow: none;
            border: 1px solid #ddd;
        }

        .card-header {
            background: #f5f5f5 !important;
            color: #000 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .table tbody tr {
            page-break-inside: avoid;
        }

        .mobile-card-view {
            display: none !important;
        }

        .table-responsive {
            display: block !important;
        }
    }
</style>

<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Pendaftar Jurusan: {{ $jurusan->nama }}</h5>
                <small class="text-muted">Sesi: {{ $sesi->tahun_ajaran }}</small>
            </div>
            <div>
                <a href="{{ route('kurikulum.ppdb.jurusan.show', $jurusan->id) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! session('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Desktop Table View -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>NISN</th>
                            <th>Jenis Kelamin</th>
                            <th>Jalur</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendaftars as $pendaftar)
                            <tr>
                                <td>{{ $pendaftar->nama_lengkap }}</td>
                                <td>{{ $pendaftar->nisn ?? '-' }}</td>
                                <td>{{ $pendaftar->jenis_kelamin }}</td>
                                <td>{{ optional($pendaftar->jalur)->nama_jalur ?? '-' }}</td>
                                <td>
                                    @if($pendaftar->status == 'diterima')
                                        <span class="badge bg-warning">Diterima</span>
                                    @elseif($pendaftar->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $pendaftar->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $pendaftar->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($pendaftar->status == 'diterima')
                                        <a href="{{ route('kurikulum.ppdb.assign.form', $pendaftar->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-user-plus"></i> Assign Rombel
                                        </a>
                                    @else
                                        <span class="text-muted">Sudah diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="empty-state">
                                        <i class="fas fa-users"></i>
                                        <h5>Tidak Ada Pendaftar</h5>
                                        <p>Belum ada pendaftar untuk jurusan dan sesi ini</p>
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
                    <div class="registrant-card">
                        <div class="registrant-card-header">
                            <div>
                                <div class="registrant-name">{{ $pendaftar->nama_lengkap }}</div>
                                <div class="registrant-nisn">NISN: {{ $pendaftar->nisn ?? '-' }}</div>
                            </div>
                            <div>
                                @if($pendaftar->status == 'diterima')
                                    <span class="badge bg-warning">Diterima</span>
                                @elseif($pendaftar->status == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">{{ $pendaftar->status }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="registrant-details">
                            <div class="detail-item">
                                <div class="detail-label">Jenis Kelamin</div>
                                <div class="detail-value">{{ $pendaftar->jenis_kelamin }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Jalur</div>
                                <div class="detail-value">{{ optional($pendaftar->jalur)->nama_jalur ?? '-' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Tanggal Daftar</div>
                                <div class="detail-value">{{ $pendaftar->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>

                        @if($pendaftar->status == 'diterima')
                            <div class="registrant-actions">
                                <a href="{{ route('kurikulum.ppdb.assign.form', $pendaftar->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user-plus"></i> Assign Rombel
                                </a>
                            </div>
                        @else
                            <div class="registrant-actions">
                                <span class="text-muted text-center w-100">Sudah diproses</span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <h5>Tidak Ada Pendaftar</h5>
                        <p>Belum ada pendaftar untuk jurusan dan sesi ini</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection