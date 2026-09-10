@extends('layouts.app')

@section('title', 'Alumni - ' . ($siswa->nama_lengkap ?? 'Detail'))

@section('content')
<style>
    :root {
        --primary: #4F46E5;
        --primary-dark: #4338CA;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --border-radius: 12px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--gray-50);
        color: var(--gray-800);
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 32px 0;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.3; }
    }

    .page-header h1 {
        font-size: clamp(24px, 4vw, 36px);
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .page-header .subtitle {
        font-size: clamp(14px, 2.5vw, 18px);
        opacity: 0.9;
        margin-top: 8px;
        position: relative;
        z-index: 1;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        transform: translateY(-2px);
    }

    .btn-primary-custom {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .btn-primary-custom:hover {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        transform: translateY(-2px);
    }

    /* Card */
    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        background: white;
        overflow: hidden;
    }

    .card:hover {
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        background: linear-gradient(135deg, var(--gray-50), var(--gray-100));
        border-bottom: 1px solid var(--gray-200);
        padding: 16px 20px;
        font-weight: 600;
        color: var(--gray-800);
    }

    .card-header h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
    }

    .card-body {
        padding: 20px;
    }

    /* Profile */
    .profile-avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary);
        box-shadow: var(--shadow-lg);
    }

    .profile-avatar-placeholder {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 700;
        color: white;
        border: 4px solid var(--primary);
        box-shadow: var(--shadow-lg);
        margin: 0 auto;
    }

    .badge-custom {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-primary-custom {
        background: var(--primary);
        color: white;
    }

    .badge-success-custom {
        background: #10B981;
        color: white;
    }

    .badge-info-custom {
        background: #3B82F6;
        color: white;
    }

    .badge-secondary-custom {
        background: var(--gray-400);
        color: white;
    }

    /* Info List */
    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-list li {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid var(--gray-100);
    }

    .info-list li:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: var(--gray-600);
        font-size: 14px;
    }

    .info-value {
        color: var(--gray-800);
        font-size: 14px;
        text-align: right;
    }

    /* Responsive */
    @media (max-width: 767px) {
        .page-header { padding: 24px 0; }
        .profile-avatar { width: 100px; height: 100px; }
        .profile-avatar-placeholder { width: 100px; height: 100px; font-size: 36px; }
        .info-list li { flex-direction: column; align-items: flex-start; gap: 4px; }
        .info-value { text-align: left; }
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
            <div>
                <h1 class="mb-2">📋 Detail Alumni</h1>
                <p class="subtitle mb-0">Data alumni lengkap untuk siswa terpilih.</p>
            </div>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <a href="{{ route('tu.alumni.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('tu.alumni.buku-induk.show', $siswa->id) }}" class="btn-primary-custom">
                    <i class="fas fa-book"></i> Buku Induk
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- Kolom Kiri: Foto & Info Ringkas -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <!-- Foto -->
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" class="profile-avatar" alt="{{ $siswa->nama_lengkap }}">
                    @else
                        <div class="profile-avatar-placeholder">
                            {{ strtoupper(substr($siswa->nama_lengkap ?? 'U', 0, 1)) }}
                        </div>
                    @endif

                    <!-- Nama -->
                    <h4 class="mt-3 mb-1 fw-bold">{{ $siswa->nama_lengkap ?? 'Tidak Diketahui' }}</h4>
                    <p class="text-muted mb-2">NIS: {{ $siswa->nis ?? '-' }}</p>
                    <p class="text-muted mb-3">NISN: {{ $siswa->nisn ?? '-' }}</p>

                    <!-- Badges -->
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <span class="badge-custom badge-primary-custom">
                            <i class="fas fa-graduation-cap"></i> Alumni
                        </span>
                        <span class="badge-custom badge-success-custom">
                            <i class="fas fa-check-circle"></i> Lulus
                        </span>
                    </div>

                    <hr>

                    <!-- Info Ringkas -->
                    <div class="text-start">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Rombel</span>
                            <span class="fw-semibold">{{ $siswa->rombel->nama ?? 'Tidak tersedia' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Kelas</span>
                            <span class="fw-semibold">{{ optional(optional($siswa->rombel)->kelas)->tingkat ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span class="text-muted">Jurusan</span>
                            <span class="fw-semibold">{{ optional(optional(optional($siswa->rombel)->kelas)->jurusan)->nama ?? 'Tidak tersedia' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Detail Informasi -->
        <div class="col-lg-8">
            <div class="row g-3">

                <!-- Informasi Pribadi -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-user" style="color:var(--primary);"></i> Informasi Pribadi</h5>
                        </div>
                        <div class="card-body">
                            <ul class="info-list">
                                <li>
                                    <span class="info-label">Tempat, Tanggal Lahir</span>
                                    <span class="info-value">
                                        {{ $siswa->tempat_lahir ?? '-' }},
                                        {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') : '-' }}
                                    </span>
                                </li>
                                <li>
                                    <span class="info-label">Jenis Kelamin</span>
                                    <span class="info-value">{{ $siswa->jenisKelamin->nama ?? $siswa->jenis_kelamin ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label">Agama</span>
                                    <span class="info-value">{{ $siswa->agama->nama ?? $siswa->agama_lainnya ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label">Alamat</span>
                                    <span class="info-value">{{ $siswa->alamat ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label">Nomor Telepon</span>
                                    <span class="info-value">{{ $siswa->no_hp ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label">Status</span>
                                    <span class="info-value">
                                        <span class="badge-custom badge-success-custom" style="font-size:12px; padding:4px 12px;">
                                            <i class="fas fa-check-circle"></i> Lulus
                                        </span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Ayah -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-user-tie" style="color:var(--primary);"></i> Ayah</h5>
                        </div>
                        <div class="card-body">
                            <ul class="info-list">
                                <li>
                                    <span class="info-label">Nama</span>
                                    <span class="info-value">{{ optional($siswa->ayah)->nama ?? $siswa->nama_ayah ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label">Pekerjaan</span>
                                    <span class="info-value">{{ optional($siswa->ayah)->pekerjaan ?? $siswa->pekerjaan_ayah ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label">Telepon</span>
                                    <span class="info-value">{{ optional($siswa->ayah)->telepon ?? $siswa->telepon_ayah ?? '-' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Ibu -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-user-tie" style="color:var(--primary);"></i> Ibu</h5>
                        </div>
                        <div class="card-body">
                            <ul class="info-list">
                                <li>
                                    <span class="info-label">Nama</span>
                                    <span class="info-value">{{ optional($siswa->ibu)->nama ?? $siswa->nama_ibu ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label">Pekerjaan</span>
                                    <span class="info-value">{{ optional($siswa->ibu)->pekerjaan ?? $siswa->pekerjaan_ibu ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label">Telepon</span>
                                    <span class="info-value">{{ optional($siswa->ibu)->telepon ?? $siswa->telepon_ibu ?? '-' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Wali (jika ada) -->
                @if(($siswa->wali_id ?? null) || ($siswa->nama_wali ?? null))
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-user-tie" style="color:var(--primary);"></i> Wali</h5>
                        </div>
                        <div class="card-body">
                            <ul class="info-list">
                                <li>
                                    <span class="info-label">Nama</span>
                                    <span class="info-value">{{ optional($siswa->wali)->nama ?? $siswa->nama_wali ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label">Pekerjaan</span>
                                    <span class="info-value">{{ optional($siswa->wali)->pekerjaan ?? $siswa->pekerjaan_wali ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label">Telepon</span>
                                    <span class="info-value">{{ optional($siswa->wali)->telepon ?? $siswa->telepon_wali ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label">Alamat</span>
                                    <span class="info-value">{{ optional($siswa->wali)->alamat ?? $siswa->alamat_wali ?? '-' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Tombol Aksi -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <a href="{{ route('tu.alumni.buku-induk.show', $siswa->id) }}" class="btn btn-primary">
                                    <i class="fas fa-book"></i> Buku Induk
                                </a>
                                <a href="{{ route('tu.alumni.raport.list', $siswa->id) }}" class="btn btn-info text-white">
                                    <i class="fas fa-file-alt"></i> Raport
                                </a>
                                <a href="{{ route('tu.alumni.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection