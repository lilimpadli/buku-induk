@extends('layouts.app')

@section('title', 'Detail Mutasi Siswa')

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
        margin-bottom: 1.5rem;
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

    .card-header {
        border-radius: 16px 16px 0 0 !important;
        padding: 15px 20px;
        border: none;
    }

    .card-header h5,
    .card-header h6 {
        margin: 0;
        font-size: clamp(14px, 3vw, 18px);
        font-weight: 600;
    }

    .card-body {
        padding: 20px;
    }

    .form-label {
        font-size: clamp(12px, 2.5vw, 14px);
        color: #64748B;
        margin-bottom: 0.5rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-control-plaintext {
        font-size: clamp(13px, 2.8vw, 15px);
        color: #1E293B;
        padding: 0.5rem 0;
        word-wrap: break-word;
    }

    .badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: clamp(12px, 2.5vw, 14px);
        font-weight: 600;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 10px 20px;
        font-size: clamp(13px, 2.5vw, 14px);
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

    .btn-warning {
        background-color: var(--warning-color);
        border: none;
        color: white;
    }

    .btn-warning:hover {
        background-color: #D97706;
        transform: translateY(-2px);
        color: white;
    }

    .btn-danger {
        background-color: var(--danger-color);
        border: none;
    }

    .btn-danger:hover {
        background-color: #DC2626;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: #64748B;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #475569;
        transform: translateY(-2px);
    }

    .btn-info {
        background-color: var(--info-color);
        border: none;
    }

    hr {
        margin: 1.5rem 0;
        border-top: 1px solid #E2E8F0;
    }

    .section-title {
        font-size: clamp(14px, 3vw, 16px);
        font-weight: 600;
        margin-bottom: 1rem;
        color: #1E293B;
    }

    .section-title i {
        margin-right: 8px;
    }

    .info-item {
        margin-bottom: 1rem;
    }

    .info-item p {
        margin: 0;
        font-size: clamp(12px, 2.5vw, 14px);
    }

    .info-item strong {
        display: block;
        color: #64748B;
        font-size: clamp(11px, 2.3vw, 12px);
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Mobile Styles */
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
            margin-bottom: 1rem;
        }

        .card-header {
            padding: 12px 15px;
        }

        .card-body {
            padding: 15px;
        }

        .row.mb-4 {
            margin-bottom: 1rem !important;
        }

        .form-label {
            margin-bottom: 4px;
        }

        .form-control-plaintext {
            padding: 4px 0;
            margin-bottom: 0.5rem;
        }

        hr {
            margin: 1rem 0;
        }

        .section-title {
            margin-bottom: 0.75rem;
        }

        .badge {
            padding: 6px 12px;
            display: inline-block;
        }

        .action-buttons {
            flex-direction: column;
            gap: 8px;
        }

        .action-buttons .btn,
        .action-buttons form {
            width: 100%;
        }

        .action-buttons form .btn {
            width: 100%;
        }

        /* Sidebar cards */
        .col-lg-4 .card {
            margin-bottom: 15px;
        }

        .info-item {
            margin-bottom: 0.75rem;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }
    }

    /* Tablet Styles */
    @media (min-width: 768px) and (max-width: 991px) {
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }

        h1.h3 {
            font-size: 20px;
        }

        .card-body {
            padding: 18px;
        }

        .action-buttons {
            flex-wrap: wrap;
        }

        .action-buttons .btn {
            flex: 0 0 auto;
        }
    }

    /* Desktop Styles */
    @media (min-width: 992px) {
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
        }

        .card-body {
            padding: 24px;
        }

        .action-buttons .btn {
            margin-right: 0;
        }

        .action-buttons form {
            display: inline-block;
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
        .card-body {
            padding: 12px;
        }

        .row.mb-4 {
            margin-bottom: 0.75rem !important;
        }
    }

    /* Print Styles */
    @media print {
        body {
            background-color: white;
        }

        .page-header,
        .action-buttons,
        .btn {
            display: none !important;
        }

        .card {
            box-shadow: none;
            border: 1px solid #ddd;
            page-break-inside: avoid;
        }

        .card-header {
            background-color: #f8f9fa !important;
            color: #000 !important;
        }

        @page {
            margin: 2cm;
        }
    }
</style>

<div class="container-fluid mt-4">
    <div class="page-header">
        <h1 class="h3">
            <i class="fas fa-eye text-primary"></i> Detail Data Mutasi Siswa
        </h1>
    </div>

    <div class="row">
        <!-- Kartu Utama -->
        <div class="col-lg-8 col-12">
            <!-- Tombol Aksi - DIPINDAH KE ATAS -->
            <div class="card">
                <div class="card-body">
                    <div class="action-buttons">
                        <a href="{{ route('tu.mutasi.edit', $mutasi) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit Data
                        </a>
                        <a href="{{ route('tu.mutasi.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                        <form action="{{ route('tu.mutasi.destroy', $mutasi) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data mutasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i> Hapus Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Card Informasi Mutasi -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Informasi Mutasi</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 col-12">
                            <label class="form-label">NIS Siswa</label>
                            <p class="form-control-plaintext">{{ $mutasi->siswa->nis }}</p>
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="form-label">NISN Siswa</label>
                            <p class="form-control-plaintext">{{ $mutasi->siswa->nisn ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap Siswa</label>
                            <p class="form-control-plaintext">{{ $mutasi->siswa->nama_lengkap }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6 col-12">
                            <label class="form-label">Status Mutasi</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-{{ $mutasi->status_color }}">
                                    {{ $mutasi->status_label }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="form-label">Tanggal Mutasi</label>
                            <p class="form-control-plaintext">{{ $mutasi->tanggal_mutasi->format('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <p class="form-control-plaintext">
                                {!! $mutasi->keterangan ?? '<em class="text-muted">Tidak ada keterangan</em>' !!}
                            </p>
                        </div>
                    </div>

                    <!-- Data Spesifik Sesuai Status -->
                    @if($mutasi->status === 'pindah')
                        <hr>
                        <h5 class="section-title">
                            <i class="fas fa-arrow-right text-info"></i> Data Pindah Sekolah
                        </h5>
                        <div class="row mb-4">
                            <div class="col-md-6 col-12">
                                <label class="form-label">Alasan Pindah</label>
                                <p class="form-control-plaintext">{{ $mutasi->alasan_pindah ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Sekolah Tujuan</label>
                                <p class="form-control-plaintext">{{ $mutasi->tujuan_pindah ?? '-' }}</p>
                            </div>
                        </div>
                    @endif

                    @if(in_array($mutasi->status, ['pindah', 'do', 'meninggal']))
                        <hr>
                        <h5 class="section-title">
                            <i class="fas fa-file-contract text-warning"></i> Surat Keputusan Keluar
                        </h5>
                        <div class="row mb-4">
                            <div class="col-md-6 col-12">
                                <label class="form-label">Nomor SK Keluar</label>
                                <p class="form-control-plaintext">{{ $mutasi->no_sk_keluar ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Tanggal SK Keluar</label>
                                <p class="form-control-plaintext">
                                    {{ $mutasi->tanggal_sk_keluar ? $mutasi->tanggal_sk_keluar->format('d F Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4 col-12">
            <!-- Kartu Data Siswa -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h6>Data Siswa</h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <strong>Jenis Kelamin:</strong>
                        <p>{{ $mutasi->siswa->jenis_kelamin }}</p>
                    </div>
                    <div class="info-item">
                        <strong>Tempat Lahir:</strong>
                        <p>{{ $mutasi->siswa->tempat_lahir }}</p>
                    </div>
                    <div class="info-item">
                        <strong>Tanggal Lahir:</strong>
                        <p>{{ $mutasi->siswa->tanggal_lahir ? (\Carbon\Carbon::parse($mutasi->siswa->tanggal_lahir)->format('d F Y')) : '-' }}</p>
                    </div>
                    <div class="info-item">
                        <strong>Agama:</strong>
                        <p>{{ $mutasi->siswa->agama ?? '-' }}</p>
                    </div>
                    <div class="info-item">
                        <strong>Alamat:</strong>
                        <p>{{ Str::limit($mutasi->siswa->alamat ?? '-', 50) }}</p>
                    </div>
                </div>
            </div>

            <!-- Kartu Timeline -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h6>Timeline Sistem</h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <strong>Dibuat:</strong>
                        <p class="text-muted">{{ $mutasi->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="info-item">
                        <strong>Terakhir Diubah:</strong>
                        <p class="text-muted">{{ $mutasi->updated_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection