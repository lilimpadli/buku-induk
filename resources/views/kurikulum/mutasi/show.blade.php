@extends('layouts.app')

@section('title', 'Detail Mutasi Siswa')

@section('content')
<style>
    /* ===================== STYLE DETAIL MUTASI SISWA ===================== */
    
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
        margin-bottom: 20px;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-header {
        border-bottom: 2px solid rgba(255,255,255,0.1);
        padding: 16px 20px;
        font-weight: 600;
    }

    .card-header h5,
    .card-header h6 {
        margin-bottom: 0;
    }

    .card-body {
        padding: 20px;
    }

    /* Form Labels */
    .form-label {
        color: #64748B;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .form-control-plaintext {
        color: #1E293B;
        font-size: 15px;
        font-weight: 500;
        padding-left: 0;
        padding-top: 0;
        min-height: auto;
    }

    /* Section Title */
    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #E2E8F0;
    }

    .section-title i {
        font-size: 20px;
    }

    /* Badge Styles */
    .badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    /* Button Styles */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        padding: 10px 20px;
    }

    .btn-primary {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
    }

    .btn-primary:hover {
        background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(47, 83, 255, 0.3);
    }

    .btn-warning {
        background-color: var(--warning-color);
        color: white;
    }

    .btn-warning:hover {
        background-color: #D97706;
        transform: translateY(-2px);
        color: white;
    }

    .btn-secondary {
        background-color: #64748B;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #475569;
        transform: translateY(-2px);
        color: white;
    }

    .btn-danger {
        background-color: var(--danger-color);
        color: white;
    }

    .btn-danger:hover {
        background-color: #DC2626;
        transform: translateY(-2px);
        color: white;
    }

    .btn i {
        margin-right: 6px;
    }

    /* Info Item */
    .info-item {
        margin-bottom: 20px;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-item p {
        margin-bottom: 0;
    }

    /* Sidebar Card */
    .sidebar-card p {
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #F1F5F9;
    }

    .sidebar-card p:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    /* Action Buttons Container */
    .action-buttons-container {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* ===================== RESPONSIVE STYLES ===================== */

    /* Tablet (768px - 991px) */
    @media (max-width: 991px) {
        h1.h3 {
            font-size: 24px;
        }

        .card-body {
            padding: 16px;
        }

        .badge {
            font-size: 13px;
            padding: 6px 12px;
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

        /* Row restructure */
        .row.mb-4 {
            margin-bottom: 1rem !important;
        }

        /* Card adjustments */
        .card {
            margin-bottom: 16px;
            border-radius: 12px;
        }

        .card-header {
            padding: 14px 16px;
        }

        .card-header h5 {
            font-size: 16px;
        }

        .card-header h6 {
            font-size: 15px;
        }

        .card-body {
            padding: 16px;
        }

        /* Form elements */
        .form-label {
            font-size: 12px;
            margin-bottom: 6px;
        }

        .form-control-plaintext {
            font-size: 14px;
        }

        .info-item {
            margin-bottom: 16px;
        }

        /* Section Title */
        .section-title {
            font-size: 15px;
            margin-bottom: 16px;
        }

        .section-title i {
            font-size: 18px;
        }

        /* Badge */
        .badge {
            font-size: 12px;
            padding: 6px 12px;
        }

        /* Buttons */
        .btn {
            font-size: 14px;
            padding: 10px 16px;
        }

        .action-buttons-container {
            flex-direction: column;
            gap: 8px;
        }

        .action-buttons-container .btn,
        .action-buttons-container form {
            width: 100%;
        }

        .action-buttons-container form .btn {
            width: 100%;
        }

        /* Sidebar on mobile appears after main content */
        .col-lg-4 {
            order: 2;
        }

        .col-lg-8 {
            order: 1;
        }

        /* Sidebar Cards */
        .sidebar-card p {
            font-size: 14px;
            margin-bottom: 10px;
            padding-bottom: 10px;
        }

        .sidebar-card strong {
            display: block;
            margin-bottom: 4px;
            font-size: 12px;
            color: #64748B;
        }

        /* HR separator */
        hr {
            margin: 20px 0;
        }
    }

    /* Mobile Small (max 575px) */
    @media (max-width: 575px) {
        h1.h3 {
            font-size: 16px;
        }

        .card-header h5 {
            font-size: 15px;
        }

        .card-header h6 {
            font-size: 14px;
        }

        .form-control-plaintext {
            font-size: 13px;
        }

        .btn {
            font-size: 13px;
            padding: 9px 14px;
        }

        .badge {
            font-size: 11px;
            padding: 5px 10px;
        }
    }

    /* Desktop (min 768px) */
    @media (min-width: 768px) {
        .menu-toggle {
            display: none;
        }

        /* Ensure proper column layout */
        .col-lg-8 {
            order: 1;
        }

        .col-lg-4 {
            order: 2;
        }
    }

    /* Desktop Large (1200px+) */
    @media (min-width: 1200px) {
        h1.h3 {
            font-size: 30px;
        }

        .card-body {
            padding: 24px;
        }

        .form-control-plaintext {
            font-size: 16px;
        }

        .badge {
            font-size: 15px;
            padding: 9px 18px;
        }
    }

    /* Custom utility classes */
    .text-muted {
        color: #64748B !important;
    }

    .fw-bold {
        font-weight: 600 !important;
    }
</style>

<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                
                <h1 class="h3">
                    <i class="fas fa-eye text-primary"></i> Detail Data Mutasi Siswa
                </h1>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Kartu Utama -->
        <div class="col-lg-8">
            <!-- Tombol Aksi -->
            <div class="card">
                <div class="card-body">
                    <div class="action-buttons-container">
                        <a href="{{ route('kurikulum.mutasi.edit', $mutasi) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Data
                        </a>
                        <a href="{{ route('kurikulum.mutasi.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                        <form action="{{ route('kurikulum.mutasi.destroy', $mutasi) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data mutasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Informasi Mutasi</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="info-item">
                                <label class="form-label">NIS Siswa</label>
                                <p class="form-control-plaintext">{{ $mutasi->siswa->nis }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="info-item">
                                <label class="form-label">NISN Siswa</label>
                                <p class="form-control-plaintext">{{ $mutasi->siswa->nisn ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="info-item">
                                <label class="form-label">Nama Lengkap Siswa</label>
                                <p class="form-control-plaintext">{{ $mutasi->siswa->nama_lengkap }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="info-item">
                                <label class="form-label">Status Mutasi</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-{{ $mutasi->status_color }}">
                                        {{ $mutasi->status_label }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="info-item">
                                <label class="form-label">Tanggal Mutasi</label>
                                <p class="form-control-plaintext">{{ $mutasi->tanggal_mutasi->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="info-item">
                                <label class="form-label">Keterangan</label>
                                <p class="form-control-plaintext">
                                    @if($mutasi->keterangan)
                                        {{ $mutasi->keterangan }}
                                    @else
                                        <em class="text-muted">Tidak ada keterangan</em>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Spesifik Sesuai Status -->
                    @if($mutasi->status === 'pindah')
                        <hr>
                        <h5 class="section-title">
                            <i class="fas fa-arrow-right text-info"></i> 
                            <span>Data Pindah Sekolah</span>
                        </h5>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="info-item">
                                    <label class="form-label">Alasan Pindah</label>
                                    <p class="form-control-plaintext">{{ $mutasi->alasan_pindah ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="info-item">
                                    <label class="form-label">Sekolah Tujuan</label>
                                    <p class="form-control-plaintext">{{ $mutasi->tujuan_pindah ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(in_array($mutasi->status, ['pindah', 'do', 'meninggal']))
                        <hr>
                        <h5 class="section-title">
                            <i class="fas fa-file-contract text-warning"></i> 
                            <span>Surat Keputusan Keluar</span>
                        </h5>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="info-item">
                                    <label class="form-label">Nomor SK Keluar</label>
                                    <p class="form-control-plaintext">{{ $mutasi->no_sk_keluar ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="info-item">
                                    <label class="form-label">Tanggal SK Keluar</label>
                                    <p class="form-control-plaintext">
                                        {{ $mutasi->tanggal_sk_keluar ? $mutasi->tanggal_sk_keluar->format('d F Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Kartu Data Siswa -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6>Data Siswa</h6>
                </div>
                <div class="card-body sidebar-card">
                    <p>
                        <strong>Jenis Kelamin:</strong><br>
                        {{ $mutasi->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($mutasi->siswa->jenis_kelamin == 'P' ? 'Perempuan' : $mutasi->siswa->jenis_kelamin) }}
                    </p>
                    <p>
                        <strong>Tempat Lahir:</strong><br>
                        {{ $mutasi->siswa->tempat_lahir ?? '-' }}
                    </p>
                    <p>
                        <strong>Tanggal Lahir:</strong><br>
                        {{ $mutasi->siswa->tanggal_lahir ? (\Carbon\Carbon::parse($mutasi->siswa->tanggal_lahir)->format('d F Y')) : '-' }}
                    </p>
                    <p>
                        <strong>Agama:</strong><br>
                        {{ $mutasi->siswa->agama ?? '-' }}
                    </p>
                    <p>
                        <strong>Alamat:</strong><br>
                        {{ $mutasi->siswa->alamat ?? '-' }}
                    </p>
                </div>
            </div>

            <!-- Kartu Timeline -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h6>Timeline Sistem</h6>
                </div>
                <div class="card-body sidebar-card">
                    <p>
                        <strong>Dibuat:</strong><br>
                        <small class="text-muted">{{ $mutasi->created_at->format('d F Y, H:i') }}</small>
                    </p>
                    <p>
                        <strong>Terakhir Diubah:</strong><br>
                        <small class="text-muted">{{ $mutasi->updated_at->format('d F Y, H:i') }}</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection