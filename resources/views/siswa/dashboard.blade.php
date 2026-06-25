@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<style>
    /* Global Dashboard Reset & Typography */
    .dashboard-wrapper {
        background-color: #f8fafc;
        min-height: 100vh;
        padding: 30px 20px;
    }
    
    /* Hero Banner Modern */
    .hero-banner {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
        border: none;
        border-radius: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.2);
    }
    .hero-circle-1 {
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }
    .hero-circle-2 {
        position: absolute;
        bottom: -80px;
        right: 150px;
        width: 180px;
        height: 180px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    /* Mini Stat Cards */
    .stat-card {
        border: none;
        border-radius: 16px;
        background: #ffffff;
        padding: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        display: flex;
        align-items: center;
        gap: 16px;
        border-left: 5px solid transparent;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    /* Rombak Total Navigasi Cepat Dokumen (Premium Panel) */
    .nav-panel-card {
        border: none;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    }
    .quick-nav-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        text-decoration: none !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .quick-nav-item:hover {
        background: #f8fafc;
        border-color: #3b82f6;
        transform: translateY(-3px);
        box-shadow: 0 12px 20px -5px rgba(59, 130, 246, 0.15);
    }
    .nav-item-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .nav-item-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        transition: all 0.2s;
    }
    .quick-nav-item:hover .nav-item-icon {
        transform: scale(1.08);
    }
    .nav-item-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }
    .nav-item-desc {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 0;
    }
    .nav-item-arrow {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        transition: all 0.2s;
    }
    .quick-nav-item:hover .nav-item-arrow {
        background: #3b82f6;
        color: #ffffff;
        transform: translateX(4px);
    }

    /* Info List Styling */
    .info-grid {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    }
    .data-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
    }
    .data-row:last-child {
        border-bottom: none;
    }
</style>

<div class="dashboard-wrapper">
    <div class="card hero-banner text-white mb-4">
        <div class="hero-circle-1"></div>
        <div class="hero-circle-2"></div>
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-white text-primary fw-bold mb-3 px-3 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-graduation-cap me-1"></i> {{ $siswa->rombel->kelas->nama ?? 'Kelas Aktif' }}
                    </span>
                    <h1 class="fw-bold mb-2" style="letter-spacing: -0.5px;">Selamat Datang, {{ $siswa->nama_lengkap }}!</h1>
                    <p class="text-white-50 mb-0 fs-6">Sistem monitoring Buku Induk Digital. Seluruh arsip identitas, data wali, serta rekam jejak akumulasi nilai rapor Anda tertata aman di sini.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card" style="border-left-color: #3b82f6;">
                <div class="stat-icon" style="background: #eff6ff; color: #3b82f6;">
                    <i class="fas fa-fingerprint"></i>
                </div>
                <div>
                    <small class="text-muted d-block uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">NOMOR INDUK SISWA</style></small>
                    <span class="fw-bold text-dark fs-5">{{ $siswa->nis }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card" style="border-left-color: #10b981;">
                <div class="stat-icon" style="background: #ecfdf5; color: #10b981;">
                    <i class="fas fa-passport"></i>
                </div>
                <div>
                    <small class="text-muted d-block uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">NOMOR NISN NASIONAL</small>
                    <span class="fw-bold text-dark fs-5">{{ $siswa->nisn ?? '-' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card" style="border-left-color: #8b5cf6;">
                <div class="stat-icon" style="background: #f5f3ff; color: #8b5cf6;">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <small class="text-muted d-block uppercase fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">STATUS KESISWAAN</small>
                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded fw-bold" style="font-size: 12px;">Siswa Aktif</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card info-grid h-100 border-0">
                <div class="card-body p-0">
                    <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-user-check text-primary me-2"></i>Berkas Utama Terverifikasi
                        </h5>
                    </div>
                    
                    <div class="data-row">
                        <span class="text-muted fw-medium">Nama Lengkap</span>
                        <span class="fw-bold text-dark">{{ $siswa->nama_lengkap }}</span>
                    </div>
                    <div class="data-row">
                        <span class="text-muted fw-medium">Jenis Kelamin</span>
                        <span class="text-secondary">{{ $siswa->jenis_kelamin }}</span>
                    </div>
                    <div class="data-row">
                        <span class="text-muted fw-medium">Tempat, Tanggal Lahir</span>
                        <span class="text-dark">{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}</span>
                    </div>
                    <div class="data-row">
                        <span class="text-muted fw-medium">Agama</span>
                        <span class="text-dark">{{ $siswa->agama }}</span>
                    </div>
                    <div class="data-row">
                        <span class="text-muted fw-medium">Asal Sekolah</span>
                        <span class="text-dark text-truncate" style="max-width: 220px;">{{ $siswa->sekolah_asal ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card nav-panel-card h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="fas fa-folder-open text-warning me-2"></i>Akses Lembar Buku Induk
                    </h5>
                    
                    <div class="d-flex flex-column gap-3">
                        <a href="{{ route('siswa.bukuInduk.show', ['tab' => 'biodata']) }}" class="quick-nav-item">
                            <div class="nav-item-left">
                                <div class="nav-item-icon" style="background: #eff6ff; color: #2563eb;">
                                    <i class="fas fa-id-badge"></i>
                                </div>
                                <div>
                                    <h6 class="nav-item-title">Lembar Profil & Biodata</h6>
                                    <p class="nav-item-desc">Informasi detail identitas fisik & domisili rumah</p>
                                </div>
                            </div>
                            <div class="nav-item-arrow">
                                <i class="fas fa-arrow-right small"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('siswa.bukuInduk.show', ['tab' => 'keluarga']) }}" class="quick-nav-item">
                            <div class="nav-item-left">
                                <div class="nav-item-icon" style="background: #fef2f2; color: #dc2626;">
                                    <i class="fas fa-users-cog"></i>
                                </div>
                                <div>
                                    <h6 class="nav-item-title">Data Orang Tua / Wali</h6>
                                    <p class="nav-item-desc">Detail pekerjaan, nama, dan kontak penanggung jawab</p>
                                </div>
                            </div>
                            <div class="nav-item-arrow">
                                <i class="fas fa-arrow-right small"></i>
                            </div>
                        </a>

                        <a href="{{ route('siswa.bukuInduk.show', ['tab' => 'nilai']) }}" class="quick-nav-item">
                            <div class="nav-item-left">
                                <div class="nav-item-icon" style="background: #f0fdf4; color: #16a34a;">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <div>
                                    <h6 class="nav-item-title">Transkrip Nilai Akademik</h6>
                                    <p class="nav-item-desc font-sans">Rekapitulasi nilai capaian belajar mapel per semester</p>
                                </div>
                            </div>
                            <div class="nav-item-arrow">
                                <i class="fas fa-arrow-right small"></i>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection