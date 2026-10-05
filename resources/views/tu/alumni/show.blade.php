@extends('layouts.app')

@section('title', 'Alumni - ' . ($siswa->nama_lengkap ?? 'Detail'))

@section('content')

<style>
    :root {
        --primary: #4F46E5;
        --primary-light: #6366F1;
        --secondary: #7C3AED;
        --success: #10B981;
        --warning: #F59E0B;
        --danger: #EF4444;
        --info: #3B82F6;
    }

    body { background: linear-gradient(180deg, #F8FAFF 0%, #EEF2FF 100%); }

    /* HERO */
    .hero-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 28px;
        padding: 40px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 18px 35px rgba(15,23,42,.12);
    }

    .hero-banner::before,
    .hero-banner::after {
        content: ''; position: absolute; border-radius: 50%;
        background: rgba(255,255,255,.08); pointer-events: none;
    }
    .hero-banner::before { width: 300px; height: 300px; top: -120px; right: -80px; }
    .hero-banner::after { width: 200px; height: 200px; bottom: -80px; left: -60px; background: rgba(255,255,255,.05); }

    .hero-content {
        position: relative; z-index: 2;
        display: flex; justify-content: space-between;
        align-items: center; gap: 24px; flex-wrap: wrap;
    }

    .hero-title {
        font-size: 32px; font-weight: 800;
        color: white; margin: 0 0 8px; letter-spacing: -.5px;
    }
    .hero-subtitle { color: rgba(255,255,255,.85); font-size: 15px; margin: 0; }

    .hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    .btn-hero {
        background: rgba(255,255,255,.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,.25);
        color: white; border-radius: 14px;
        padding: 12px 22px; font-weight: 700; font-size: 14px;
        display: inline-flex; align-items: center; gap: 8px;
        text-decoration: none; transition: all .25s; cursor: pointer;
    }
    .btn-hero:hover { background: white; color: var(--primary); border-color: white; transform: translateY(-2px); }

    .btn-hero.btn-hero-primary {
        background: white; color: var(--primary); border-color: white;
        box-shadow: 0 6px 18px rgba(0,0,0,.15);
    }
    .btn-hero.btn-hero-primary:hover { background: rgba(255,255,255,.9); color: var(--primary); }

    /* CARD */
    .card-modern {
        background: white; border-radius: 22px;
        border: 1px solid #EEF2FF;
        box-shadow: 0 10px 25px rgba(15,23,42,.08);
        overflow: hidden; transition: all .25s;
        margin-bottom: 20px;
    }

    .card-modern:hover { box-shadow: 0 15px 35px rgba(15,23,42,.12); }

    .card-header-modern {
        padding: 18px 22px;
        background: linear-gradient(135deg, #F8FAFF 0%, #EEF2FF 100%);
        border-bottom: 1px solid #EEF2FF;
        display: flex; align-items: center; gap: 10px;
        font-weight: 700; color: #1E293B; font-size: 15px;
    }
    .card-header-modern i { color: var(--primary); font-size: 16px; }

    .card-body-modern { padding: 22px; }

    /* PROFILE */
    .profile-wrapper {
        background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%);
        border-radius: 22px;
        padding: 32px 22px;
        text-align: center;
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
        border: 1px solid #EEF2FF;
    }

    .profile-wrapper::before {
        content: ''; position: absolute;
        width: 160px; height: 160px; border-radius: 50%;
        background: rgba(255,255,255,.5);
        top: -60px; right: -50px;
    }

    .profile-avatar {
        width: 130px; height: 130px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid white;
        box-shadow: 0 10px 25px rgba(79,70,229,.25);
        position: relative; z-index: 1;
    }

    .profile-avatar-placeholder {
        width: 130px; height: 130px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 48px; font-weight: 800;
        border: 5px solid white;
        box-shadow: 0 10px 25px rgba(79,70,229,.25);
        position: relative; z-index: 1;
    }

    .profile-name {
        font-size: 22px; font-weight: 800;
        color: #1E293B; margin: 16px 0 4px;
        position: relative; z-index: 1;
    }

    .profile-nis {
        color: #64748B; font-size: 14px;
        position: relative; z-index: 1;
        margin-bottom: 14px;
    }

    .profile-badges {
        display: flex; gap: 8px; justify-content: center;
        flex-wrap: wrap;
        position: relative; z-index: 1;
    }

    .badge-modern {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 14px; border-radius: 20px;
        font-size: 12px; font-weight: 700;
    }

    .badge-modern.badge-primary { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; box-shadow: 0 4px 12px rgba(79,70,229,.25); }
    .badge-modern.badge-success { background: linear-gradient(135deg, #D1FAE5, #A7F3D0); color: #059669; }
    .badge-modern.badge-info { background: linear-gradient(135deg, #DBEAFE, #BFDBFE); color: #2563EB; }

    /* INFO LIST */
    .info-list-modern { list-style: none; padding: 0; margin: 0; }

    .info-list-modern li {
        display: flex; justify-content: space-between;
        align-items: center; gap: 12px;
        padding: 12px 0;
        border-bottom: 1px dashed #EEF2FF;
    }

    .info-list-modern li:last-child { border-bottom: none; }

    .info-label {
        font-size: 13px; color: #64748B; font-weight: 600;
        display: flex; align-items: center; gap: 8px;
        flex-shrink: 0;
    }
    .info-label i { color: var(--primary); width: 16px; text-align: center; }

    .info-value {
        font-size: 14px; color: #1E293B; font-weight: 600;
        text-align: right;
        word-break: break-word;
    }

    /* QUICK STATS */
    .quick-stats {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 12px; margin-top: 20px;
    }

    .quick-stat {
        background: #F8FAFF;
        border: 1px solid #EEF2FF;
        border-radius: 14px;
        padding: 14px;
        text-align: center;
    }

    .quick-stat-value {
        font-size: 20px; font-weight: 800;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.1;
    }

    .quick-stat-label {
        font-size: 11px; color: #64748B;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-top: 4px;
    }

    /* ACTION BUTTONS */
    .action-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 10px;
    }

    .btn-action {
        background: white;
        border: 1.5px solid #E2E8F0;
        border-radius: 12px;
        padding: 14px 12px;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        font-weight: 700; font-size: 13px;
        color: #334155; text-decoration: none;
        transition: all .25s; cursor: pointer;
    }
    .btn-action:hover { border-color: var(--primary); color: var(--primary); transform: translateY(-2px); }

    .btn-action.btn-action-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white; border: none;
    }
    .btn-action.btn-action-primary:hover {
        box-shadow: 0 8px 20px rgba(79,70,229,.3); color: white;
    }

    @media (max-width: 768px) {
        .hero-banner { padding: 26px; }
        .hero-title { font-size: 24px; }
        .action-grid { grid-template-columns: 1fr; }
        .info-list-modern li { flex-direction: column; align-items: flex-start; gap: 4px; }
        .info-value { text-align: left; }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    <!-- HERO -->
    <div class="hero-banner">
        <div class="hero-content">
            <div>
                <h1 class="hero-title">
                    <i class="fas fa-user-graduate me-2"></i> Detail Alumni
                </h1>
                <p class="hero-subtitle">
                    Informasi lengkap data alumni
                </p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('tu.alumni.index') }}" class="btn-hero">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('tu.alumni.buku-induk.show', $siswa->id) }}" class="btn-hero btn-hero-primary">
                    <i class="fas fa-book"></i> Buku Induk
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- KOLOM KIRI -->
        <div class="col-lg-4">

            <!-- PROFILE CARD -->
            <div class="profile-wrapper">
                @if($siswa->foto)
                    <img src="{{ asset('storage/' . $siswa->foto) }}" class="profile-avatar" alt="{{ $siswa->nama_lengkap }}">
                @else
                    <div class="profile-avatar-placeholder">
                        {{ strtoupper(substr($siswa->nama_lengkap ?? 'U', 0, 1)) }}
                    </div>
                @endif

                <h4 class="profile-name">{{ $siswa->nama_lengkap ?? 'Tidak Diketahui' }}</h4>
                <p class="profile-nis">
                    NIS: {{ $siswa->nis ?? '-' }} &middot; NISN: {{ $siswa->nisn ?? '-' }}
                </p>

                <div class="profile-badges">
                    <span class="badge-modern badge-primary">
                        <i class="fas fa-graduation-cap"></i> Alumni
                    </span>
                    <span class="badge-modern badge-success">
                        <i class="fas fa-check-circle"></i> Lulus
                    </span>
                </div>
            </div>

            <!-- QUICK STATS -->
            <div class="card-modern">
                <div class="card-body-modern">
                    <div class="quick-stats">
                        <div class="quick-stat">
                            <div class="quick-stat-value">{{ $siswa->tanggal_lulus ? \Carbon\Carbon::parse($siswa->tanggal_lulus)->format('Y') : '-' }}</div>
                            <div class="quick-stat-label">Tahun Lulus</div>
                        </div>
                        <div class="quick-stat">
                            <div class="quick-stat-value">{{ $siswa->rombel->kelas->tingkat ?? 'XII' }}</div>
                            <div class="quick-stat-label">Tingkat</div>
                        </div>
                    </div>

                    <hr style="border-top: 1px dashed #EEF2FF; margin: 16px 0;">

                    <ul class="info-list-modern" style="margin: 0;">
                        <li>
                            <span class="info-label"><i class="fas fa-users"></i> Rombel</span>
                            <span class="info-value">{{ $siswa->rombel->nama ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="info-label"><i class="fas fa-graduation-cap"></i> Jurusan</span>
                            <span class="info-value">{{ $siswa->rombel->kelas->jurusan->nama ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="info-label"><i class="fas fa-calendar-alt"></i> Tgl Lulus</span>
                            <span class="info-value">{{ $siswa->tanggal_lulus ? \Carbon\Carbon::parse($siswa->tanggal_lulus)->format('d M Y') : '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- KOLOM KANAN -->
        <div class="col-lg-8">

            <!-- DATA PRIBADI -->
            <div class="card-modern">
                <div class="card-header-modern">
                    <i class="fas fa-user"></i> Informasi Pribadi
                </div>
                <div class="card-body-modern">
                    <ul class="info-list-modern">
                        <li>
                            <span class="info-label"><i class="fas fa-map-marker-alt"></i> Tempat, Tgl Lahir</span>
                            <span class="info-value">
                                {{ $siswa->tempat_lahir ?? '-' }},
                                {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') : '-' }}
                            </span>
                        </li>
                        <li>
                            <span class="info-label"><i class="fas fa-venus-mars"></i> Jenis Kelamin</span>
                            <span class="info-value">{{ $siswa->jenisKelamin->nama ?? $siswa->jenis_kelamin ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="info-label"><i class="fas fa-pray"></i> Agama</span>
                            <span class="info-value">{{ $siswa->agama->nama ?? $siswa->agama_lainnya ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="info-label"><i class="fas fa-home"></i> Alamat</span>
                            <span class="info-value">{{ $siswa->alamat_lengkap ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="info-label"><i class="fas fa-phone"></i> Telepon</span>
                            <span class="info-value">{{ $siswa->no_hp ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- ORANG TUA -->
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card-modern">
                        <div class="card-header-modern">
                            <i class="fas fa-user-tie"></i> Data Ayah
                        </div>
                        <div class="card-body-modern">
                            <ul class="info-list-modern">
                                <li>
                                    <span class="info-label"><i class="fas fa-user"></i> Nama</span>
                                    <span class="info-value">{{ optional($siswa->ayah)->nama ?? $siswa->nama_ayah ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label"><i class="fas fa-briefcase"></i> Pekerjaan</span>
                                    <span class="info-value">{{ optional($siswa->ayah)->pekerjaan ?? $siswa->pekerjaan_ayah ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label"><i class="fas fa-phone"></i> Telepon</span>
                                    <span class="info-value">{{ optional($siswa->ayah)->telepon ?? $siswa->telepon_ayah ?? '-' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-modern">
                        <div class="card-header-modern">
                            <i class="fas fa-user-tie"></i> Data Ibu
                        </div>
                        <div class="card-body-modern">
                            <ul class="info-list-modern">
                                <li>
                                    <span class="info-label"><i class="fas fa-user"></i> Nama</span>
                                    <span class="info-value">{{ optional($siswa->ibu)->nama ?? $siswa->nama_ibu ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label"><i class="fas fa-briefcase"></i> Pekerjaan</span>
                                    <span class="info-value">{{ optional($siswa->ibu)->pekerjaan ?? $siswa->pekerjaan_ibu ?? '-' }}</span>
                                </li>
                                <li>
                                    <span class="info-label"><i class="fas fa-phone"></i> Telepon</span>
                                    <span class="info-value">{{ optional($siswa->ibu)->telepon ?? $siswa->telepon_ibu ?? '-' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- WALI -->
            @if(($siswa->wali_id ?? null) || ($siswa->nama_wali ?? null))
            <div class="card-modern">
                <div class="card-header-modern">
                    <i class="fas fa-user-shield"></i> Data Wali
                </div>
                <div class="card-body-modern">
                    <ul class="info-list-modern">
                        <li>
                            <span class="info-label"><i class="fas fa-user"></i> Nama</span>
                            <span class="info-value">{{ optional($siswa->wali)->nama ?? $siswa->nama_wali ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="info-label"><i class="fas fa-briefcase"></i> Pekerjaan</span>
                            <span class="info-value">{{ optional($siswa->wali)->pekerjaan ?? $siswa->pekerjaan_wali ?? '-' }}</span>
                        </li>
                        <li>
                            <span class="info-label"><i class="fas fa-phone"></i> Telepon</span>
                            <span class="info-value">{{ optional($siswa->wali)->telepon ?? $siswa->telepon_wali ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            @endif

            <!-- AKSI -->
            <div class="card-modern">
                <div class="card-header-modern">
                    <i class="fas fa-bolt"></i> Aksi Cepat
                </div>
                <div class="card-body-modern">
                    <div class="action-grid">
                        <a href="{{ route('tu.alumni.buku-induk.show', $siswa->id) }}" class="btn-action btn-action-primary">
                            <i class="fas fa-book"></i> Buku Induk
                        </a>
                        <!-- <a href="{{ route('tu.alumni.raport.list', $siswa->id) }}" class="btn-action">
                            <i class="fas fa-file-alt"></i> Raport
                        </a> -->
                        <a href="{{ route('tu.alumni.index') }}" class="btn-action">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection