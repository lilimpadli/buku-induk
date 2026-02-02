@extends('layouts.app')

@section('title', 'Detail Rombel: ' . $rombel->nama)

@section('content')
<style>
    /* ===================== STYLE DETAIL ROMBEL ===================== */
    
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

    h2.fw-bold {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 5px !important;
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

    .rombel-subtitle {
        color: #64748B !important;
        margin-left: 15px;
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
        background-color: transparent;
        border-bottom: 1px solid #E2E8F0;
        padding: 20px 24px 15px;
    }

    .card-body {
        padding: 20px 24px;
    }

    /* Info Card Styles */
    .info-card .info-item {
        padding: 15px;
        border-radius: 12px;
        background-color: rgba(47, 83, 255, 0.03);
        transition: all 0.3s ease;
        height: 100%;
    }

    .info-card .info-item:hover {
        background-color: rgba(47, 83, 255, 0.06);
        transform: translateY(-3px);
    }

    .info-card .info-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748B;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-card .info-value {
        font-size: 16px;
        color: #1E293B;
        margin-bottom: 0;
        font-weight: 600;
    }

    /* Button Styles */
    .btn-outline-secondary {
        border-color: #E2E8F0;
        color: #475569;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        padding: 8px 16px;
    }

    .btn-outline-secondary:hover {
        background-color: #F1F5F9;
        transform: translateY(-2px);
        color: #334155;
    }

    /* Table Styles */
    .table {
        margin-bottom: 0;
    }

    .table thead th {
        font-weight: 600;
        color: #475569;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #E2E8F0;
        padding: 15px 20px;
    }

    .table tbody td {
        padding: 15px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #F1F5F9;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table-responsive {
        border-radius: 0 0 16px 16px;
    }

    .student-avatar {
        flex-shrink: 0;
    }

    .student-avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
    }

    .student-avatar-initial {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
    }

    /* Empty State */
    .empty-state {
        color: #64748B;
        font-weight: 500;
        padding: 40px 20px !important;
    }

    .empty-state i {
        color: #94a3b8;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .table thead th,
        .table tbody td {
            padding: 12px 15px;
        }
    }

    @media (max-width: 768px) {
        h2.fw-bold {
            font-size: 24px;
            padding-left: 12px;
        }

        h2.fw-bold::before {
            width: 4px;
        }
        
        .rombel-subtitle {
            margin-left: 12px;
            font-size: 0.9rem;
        }
        
        .btn-outline-secondary {
            font-size: 0.875rem;
            padding: 6px 12px;
        }

        .card-header {
            padding: 15px 20px 12px;
        }

        .card-header h5 {
            font-size: 1.1rem;
        }

        .card-body {
            padding: 15px 20px;
        }
        
        .info-card .info-item {
            margin-bottom: 12px;
            padding: 12px;
        }

        .info-card .info-label {
            font-size: 12px;
            margin-bottom: 6px;
        }

        .info-card .info-value {
            font-size: 15px;
        }
        
        .table thead th {
            font-size: 12px;
            padding: 10px 12px;
        }

        .table tbody td {
            padding: 10px 12px;
            font-size: 0.875rem;
        }

        .student-avatar {
            margin-right: 10px !important;
        }

        .student-avatar-circle,
        .student-avatar-initial {
            width: 32px;
            height: 32px;
            font-size: 13px;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.5rem;
        }
    }

    @media (max-width: 576px) {
        h2.fw-bold {
            font-size: 20px;
            padding-left: 10px;
        }

        .rombel-subtitle {
            margin-left: 10px;
            font-size: 0.85rem;
        }

        .header-section {
            margin-bottom: 1rem !important;
        }

        .btn-outline-secondary {
            width: 100%;
            margin-top: 0.75rem;
            font-size: 0.8rem;
            padding: 8px 12px;
        }

        .card-header {
            padding: 12px 15px 10px;
        }

        .card-header h5 {
            font-size: 1rem;
        }

        .card-body {
            padding: 12px 15px;
        }

        .info-card .info-item {
            padding: 10px;
            margin-bottom: 10px;
        }

        .info-card .info-label {
            font-size: 11px;
        }

        .info-card .info-value {
            font-size: 14px;
        }

        /* Mobile: Hide some table columns */
        .table thead th:nth-child(3),
        .table tbody td:nth-child(3) {
            display: none;
        }

        .table thead th {
            font-size: 11px;
            padding: 8px 10px;
        }

        .table tbody td {
            padding: 8px 10px;
            font-size: 0.8rem;
        }

        .student-avatar {
            margin-right: 8px !important;
        }

        .student-avatar-circle,
        .student-avatar-initial {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }

        .badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.4rem;
        }

        .badge i {
            display: none;
        }

        .empty-state {
            padding: 30px 15px !important;
        }

        .empty-state i {
            font-size: 1.5rem !important;
        }

        .empty-state p {
            font-size: 0.875rem;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">

    <!-- JUDUL DAN TOMBOL KEMBALI -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 header-section">
        <div class="flex-grow-1">
            <h2 class="fw-bold mb-1">Detail Rombel</h2>
            <p class="rombel-subtitle mb-0">{{ $rombel->nama }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tu.kelas.export', $rombel->id) }}" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i> Export Rombel
            </a>
            <a href="{{ request()->header('referer') ?: route('tu.kelas.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <!-- INFO ROMBEL -->
    <div class="card shadow-sm border-0 mb-3 mb-md-4 info-card">
        <div class="card-body">
            <div class="row g-2 g-md-3">
                <div class="col-12 col-md-4">
                    <div class="info-item">
                        <p class="info-label mb-1">
                            <i class="fas fa-layer-group me-1 me-md-2"></i> Tingkat
                        </p>
                        <h6 class="info-value">{{ $rombel->kelas->tingkat ?? '-' }}</h6>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="info-item">
                        <p class="info-label mb-1">
                            <i class="fas fa-graduation-cap me-1 me-md-2"></i> Jurusan
                        </p>
                        <h6 class="info-value">{{ $rombel->kelas->jurusan->nama ?? '-' }}</h6>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="info-item">
                        <p class="info-label mb-1">
                            <i class="fas fa-user-tie me-1 me-md-2"></i> Wali Kelas
                        </p>
                        <h6 class="info-value">{{ $rombel->guru->nama ?? '-' }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DAFTAR SISWA -->
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-users me-2"></i>
                Daftar Siswa
                <span class="badge bg-primary ms-2">{{ $rombel->siswa->count() }}</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">NO</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rombel->siswa as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="student-avatar me-2 me-md-3">
                                            @if($siswa->foto)
                                                <img src="{{ asset('storage/' . $siswa->foto) }}" 
                                                     alt="{{ $siswa->nama_lengkap }}" 
                                                     class="student-avatar-circle">
                                            @else
                                                <div class="student-avatar-initial">
                                                    {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <span class="student-name">{{ $siswa->nama_lengkap }}</span>
                                    </div>
                                </td>
                                <td>{{ $siswa->nis }}</td>
                                <td>
                                    <span class="badge {{ $siswa->jenis_kelamin == 'L' ? 'bg-info' : 'bg-danger' }} bg-opacity-10 text-dark">
                                        <i class="fas fa-{{ $siswa->jenis_kelamin == 'L' ? 'mars' : 'venus' }} me-1"></i>
                                        <span class="d-none d-sm-inline">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                        <span class="d-sm-none">{{ $siswa->jenis_kelamin }}</span>
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center empty-state">
                                    <i class="fas fa-user-graduate fa-2x mb-3"></i>
                                    <p class="mb-0">Belum ada siswa di rombel ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection