@extends('layouts.app')

@section('title', 'Detail Kurikulum')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: #f7fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    main {
        padding: 20px 15px !important;
        overflow-x: auto !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 10px !important;
        overflow-x: auto !important;
    }

    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(100px, -100px);
        pointer-events: none;
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1.3rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    .btn-edit {
        background: #F59E0B;
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-edit:hover {
        background: #D97706;
        transform: translateY(-2px);
        color: white;
    }

    .info-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        width: 100%;
        margin-bottom: 1.5rem;
    }

    .info-card .card-header {
        background: white;
        border-bottom: 1px solid #E2E8F0;
        padding: 0.8rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 1rem;
    }

    .info-card .card-header h5 i {
        color: #667eea;
        margin-right: 6px;
    }

    .info-card .card-body {
        padding: 1.2rem 1.5rem;
    }

    .info-row {
        display: flex;
        padding: 0.5rem 0;
        border-bottom: 1px solid #F1F5F9;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        width: 180px;
        font-weight: 600;
        color: #64748B;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .info-value {
        flex: 1;
        color: #1E293B;
        font-size: 0.9rem;
    }

    .stat-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        width: 100%;
        text-align: center;
        padding: 1.5rem;
        background: white;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #667eea;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #64748B;
        margin: 0;
    }

    .badge-kurikulum {
        background: var(--primary-gradient);
        color: white;
        padding: 3px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        min-width: 400px;
        margin-bottom: 0;
        font-size: 0.85rem;
    }

    .table th {
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #64748B;
        padding: 0.6rem 0.8rem;
        white-space: nowrap;
        background-color: #F8FAFC;
        border-bottom: none;
    }

    .table td {
        padding: 0.6rem 0.8rem;
        vertical-align: middle;
        border-color: #E2E8F0;
    }

    .table tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.03);
    }

    .badge-kelompok {
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.6rem;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-kelompok.a {
        background: #D1FAE5;
        color: #059669;
    }

    .badge-kelompok.b {
        background: #DBEAFE;
        color: #2563EB;
    }

    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: #94A3B8;
    }

    .empty-state i {
        font-size: 2rem;
        color: #CBD5E1;
        display: block;
        margin-bottom: 0.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1rem;
        }
        .page-header h3 {
            font-size: 1.1rem;
        }
        .page-header .text-muted {
            font-size: 0.75rem;
        }

        .info-row {
            flex-direction: column;
            padding: 0.6rem 0;
        }

        .info-label {
            width: 100%;
            font-size: 0.75rem;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 0.85rem;
        }

        .info-card .card-header {
            padding: 0.6rem 1rem;
        }

        .info-card .card-body {
            padding: 0.8rem 1rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .table {
            min-width: 350px;
            font-size: 0.75rem;
        }
        .table th,
        .table td {
            padding: 0.4rem 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }
        .action-buttons .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .stat-number {
            font-size: 1.8rem;
        }
        .table {
            min-width: 300px;
            font-size: 0.65rem;
        }
        .table th,
        .table td {
            padding: 0.3rem 0.4rem;
        }
        .badge-kurikulum {
            font-size: 0.6rem;
            padding: 2px 8px;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-book me-2"></i> Detail Kurikulum</h3>
                <div class="text-muted">Informasi lengkap kurikulum</div>
            </div>
            <div>
                <a href="{{ route('kurikulum.kurikulum.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- INFO KURIKULUM -->
        <div class="col-md-8">
            <div class="info-card">
                <div class="card-header">
                    <h5><i class="fas fa-id-card"></i> Informasi Kurikulum</h5>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label">Nama Kurikulum</div>
                        <div class="info-value"><span class="badge-kurikulum">{{ $kurikulum->nama_kurikulum }}</span></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Dibuat</div>
                        <div class="info-value">{{ $kurikulum->created_at->format('d F Y H:i') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Terakhir Diubah</div>
                        <div class="info-value">{{ $kurikulum->updated_at->format('d F Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STATISTIK -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-number">{{ $kurikulum->mataPelajarans->count() }}</div>
                <p class="stat-label">Mata Pelajaran</p>
            </div>
        </div>
    </div>

    <!-- DAFTAR MATA PELAJARAN -->
    @if($kurikulum->mataPelajarans->count() > 0)
    <div class="info-card mt-3">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Mata Pelajaran dalam Kurikulum Ini</h5>
            <span class="badge bg-primary ms-auto">{{ $kurikulum->mataPelajarans->count() }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Mata Pelajaran</th>
                            <th>Kelompok</th>
                            <th>Urutan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kurikulum->mataPelajarans as $key => $mapel)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><span class="fw-semibold">{{ $mapel->nama }}</span></td>
                                <td>
                                    <span class="badge-kelompok {{ strtolower($mapel->kelompok) }}">
                                        {{ $mapel->kelompok }}
                                    </span>
                                </td>
                                <td>{{ $mapel->urutan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="info-card mt-3">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Mata Pelajaran dalam Kurikulum Ini</h5>
        </div>
        <div class="card-body">
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Belum ada mata pelajaran yang terdaftar dalam kurikulum ini</p>
            </div>
        </div>
    </div>
    @endif

    <!-- ACTION BUTTONS -->
    <div class="action-buttons">
        <a href="{{ route('kurikulum.kurikulum.edit', $kurikulum->id) }}" class="btn-edit">
            <i class="fas fa-edit"></i> Edit Kurikulum
        </a>
    </div>
</div>
@endsection