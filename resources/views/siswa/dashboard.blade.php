@extends('layouts.app')

@section('content')

<style>
    /* ===================== STYLE DASHBOARD SISWA ===================== */
    
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --danger-gradient: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --bg-light: #f7fafc;
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--text-primary);
    }

    /* Header Styles */
    .dashboard-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(100px, -100px);
    }

    .dashboard-header h2 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
        font-size: 1.75rem;
    }

    .dashboard-header .text-muted {
        color: rgba(255, 255, 255, 0.9) !important;
        position: relative;
        z-index: 1;
        font-weight: 500;
    }

    .dashboard-header .btn-gradient {
        position: relative;
        z-index: 1;
    }

    /* Card Styles */
    .stat-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        height: 100%;
        background: white;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    .stat-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: var(--primary-gradient);
    }

    .stat-card.success::before {
        background: var(--success-gradient);
    }

    .stat-card.danger::before {
        background: var(--danger-gradient);
    }

    .stat-card.info::before {
        background: var(--info-gradient);
    }

    .stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
        flex-shrink: 0;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1);
    }

    .stat-icon.primary {
        background: var(--primary-gradient);
    }

    .stat-icon.success {
        background: var(--success-gradient);
    }

    .stat-icon.danger {
        background: var(--danger-gradient);
    }

    .stat-icon.info {
        background: var(--info-gradient);
    }

    /* Button Styles */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }

    /* Profile Card */
    .profile-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        height: 100%;
        background: white;
        transition: var(--transition);
    }

    .profile-card:hover {
        box-shadow: var(--card-hover-shadow);
        transform: translateY(-3px);
    }

    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        object-fit: cover;
    }

    .profile-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
        font-size: 54px;
        border: 5px solid white;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    /* Parent Contact Card */
    .parent-contact-card {
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        border: none;
        background: white;
        transition: var(--transition);
    }

    .parent-contact-card:hover {
        box-shadow: var(--card-hover-shadow);
        transform: translateY(-3px);
    }

    .parent-data-card {
        border-radius: 12px;
        border: none;
        background: #f8f9fa;
        padding: 1rem;
        margin-bottom: 0.75rem;
    }

    .parent-data-card h6 {
        font-weight: 700;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* =============== MOBILE OPTIMIZATIONS =============== */
    @media (max-width: 768px) {
        /* General mobile adjustments */
        body {
            font-size: 14px;
        }

        .container-fluid {
            padding: 0.75rem !important;
        }

        /* Mobile Header */
        .dashboard-header {
            padding: 1.25rem;
            border-radius: 16px;
            margin-bottom: 1rem;
        }

        .dashboard-header::before {
            width: 180px;
            height: 180px;
            transform: translate(80px, -80px);
        }
        
        .dashboard-header h2 {
            font-size: 1.3rem;
            margin-bottom: 0.4rem;
            line-height: 1.3;
        }

        .dashboard-header .text-muted {
            font-size: 0.9rem;
        }

        .dashboard-header .d-flex {
            flex-direction: column;
            gap: 0.75rem;
        }

        .dashboard-header .btn-gradient {
            width: 100%;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
        }

        /* Stat Cards Mobile */
        .stat-card {
            border-radius: 14px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .stat-card .card-body {
            padding: 1rem;
        }
        
        .stat-icon {
            width: 52px;
            height: 52px;
            font-size: 20px;
            border-radius: 12px;
        }

        .stat-card .h5 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .stat-card .small {
            font-size: 0.75rem;
        }

        .stat-card .text-muted.small {
            font-size: 0.7rem;
        }

        /* Profile Card Mobile */
        .profile-card {
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .profile-card .card-body {
            padding: 1.5rem 1rem;
        }
        
        .profile-image, .profile-placeholder {
            width: 100px;
            height: 100px;
            font-size: 38px;
            border-width: 4px;
            margin-bottom: 1rem;
        }

        .profile-card h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .profile-card .text-muted {
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }

        /* Mobile Buttons Grid */
        .profile-card .row.g-2 {
            gap: 0.5rem;
        }

        .profile-card .btn-outline-gradient,
        .profile-card .btn-outline-danger {
            padding: 0.65rem 1rem;
            font-size: 0.85rem;
            border-radius: 10px;
            font-weight: 600;
        }

        .profile-card .btn-outline-gradient i,
        .profile-card .btn-outline-danger i {
            font-size: 0.85rem;
        }

        /* Action buttons at bottom */
        .profile-card .d-flex.gap-3 {
            flex-direction: column;
            gap: 0.6rem !important;
        }

        .profile-card .d-flex.gap-3 .btn {
            width: 100%;
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* Parent Contact Card Mobile */
        .parent-contact-card {
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .parent-contact-card .card-body {
            padding: 1.25rem;
        }

        .parent-contact-card h5 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .parent-data-card {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 0.75rem;
        }

        .parent-data-card h6 {
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
        }

        .parent-data-card .table {
            font-size: 0.8rem;
            margin-bottom: 0;
        }

        .parent-data-card .table th {
            font-weight: 600;
            color: #4a5568;
            padding: 0.4rem 0;
        }

        .parent-data-card .table td {
            padding: 0.4rem 0;
            color: #2d3748;
        }

        .parent-contact-card .btn-gradient {
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* Modal Mobile */
        .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100% - 1rem);
        }

        .modal-content {
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-body {
            padding: 1.25rem;
        }

        .modal-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid #e5e7eb;
        }

        .modal-title {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .modal .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
        }

        .modal .form-control {
            font-size: 0.9rem;
            padding: 0.6rem 0.75rem;
            border-radius: 8px;
        }

        .modal .form-text {
            font-size: 0.75rem;
            margin-top: 0.3rem;
        }

        .modal .btn {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 8px;
        }

        /* Spacing adjustments */
        .row.g-3 {
            gap: 0.75rem;
        }

        .mb-3 {
            margin-bottom: 0.75rem !important;
        }

        .mb-4 {
            margin-bottom: 1rem !important;
        }
    }

    /* Extra small devices */
    @media (max-width: 400px) {
        .dashboard-header h2 {
            font-size: 1.15rem;
        }

        .dashboard-header .text-muted {
            font-size: 0.85rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            font-size: 18px;
        }

        .stat-card .h5 {
            font-size: 0.95rem;
        }

        .profile-image, .profile-placeholder {
            width: 90px;
            height: 90px;
            font-size: 34px;
        }

        .profile-card h3 {
            font-size: 1.1rem;
        }

        .btn-gradient, .btn-outline-gradient {
            font-size: 0.8rem;
            padding: 0.6rem 0.9rem;
        }
    }

    /* Landscape mobile optimization */
    @media (max-width: 768px) and (orientation: landscape) {
        .dashboard-header {
            padding: 1rem;
        }

        .profile-image, .profile-placeholder {
            width: 80px;
            height: 80px;
            font-size: 32px;
        }

        .modal-dialog {
            max-height: 90vh;
            overflow-y: auto;
        }
    }

    /* Desktop styles preserved */
    @media (min-width: 769px) {
        /* Keep original desktop styles */
        .stat-card:hover {
            transform: translateY(-5px);
        }

        .profile-card:hover {
            transform: translateY(-3px);
        }

        .parent-contact-card:hover {
            transform: translateY(-3px);
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="dashboard-header fade-in">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2 class="mb-1">Selamat Datang, {{ $siswa->nama_lengkap ?? Auth::user()->name }}! 👋</h2>
                <div class="text-muted">
                    Kelas kamu: 
                    @if($siswa && $siswa->rombel)
                        @php
                            $rombelDisplay = $siswa->rombel->nama ?? '';
                            if(!empty($rombelDisplay)){
                                if(preg_match('/^([a-zA-Z]+)\s*([0-9]+)$/', $rombelDisplay, $m)){
                                    $rombelDisplay = strtoupper($m[1]) . ' ' . $m[2];
                                } else {
                                    $rombelDisplay = ucwords(strtolower($rombelDisplay));
                                }
                            }
                        @endphp
                        {{ $rombelDisplay ?: '-' }}
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('siswa.dataDiri.edit') }}" class="btn btn-gradient">
                    <i class="fas fa-edit me-1"></i>
                    <span class="d-none d-sm-inline">Edit Profil</span>
                    <span class="d-inline d-sm-none">Edit</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-3">
        <div class="col-lg-6 col-md-6 fade-in" style="animation-delay: 0.1s;">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon primary me-3">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-muted small mb-1">Wali Kelas</div>
                            <div class="h5 mb-0">{{ $siswa && $siswa->rombel && $siswa->rombel->guru ? $siswa->rombel->guru->nama : 'Belum ditentukan' }}</div>
                        </div>
                    </div>
                    <div class="mt-2 small text-muted">Guru pengampu kelas Anda</div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 fade-in" style="animation-delay: 0.2s;">
            <div class="card stat-card success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon success me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-muted small mb-1">Status Profil</div>
                            @if(isset($missing) && count($missing) > 0)
                                <div class="h5 mb-0 text-warning">{{ count($missing) }} Field Kosong</div>
                            @else
                                <div class="h5 mb-0 text-success">Lengkap</div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-2 small text-muted">
                        @if(isset($missing) && count($missing) > 0)
                            Masih ada {{ count($missing) }} field yang perlu diisi
                        @else
                            Semua data penting sudah terisi
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-3">
        <!-- Profile Card -->
        <div class="col-xl-8 fade-in" style="animation-delay: 0.5s;">
            <div class="card profile-card h-100">
                <div class="card-body text-center">
                    @if($siswa && $siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" class="profile-image mb-3" alt="Foto Siswa">
                    @else
                        <div class="profile-placeholder bg-gradient mb-3 mx-auto" style="background: var(--primary-gradient);">
                            {{ $siswa ? strtoupper(substr($siswa->nama_lengkap,0,1)) : 'S' }}
                        </div>
                    @endif
                    
                    <h3 class="mb-2">{{ $siswa->nama_lengkap ?? 'Belum Lengkap' }}</h3>
                    <p class="text-muted mb-3">NIS: {{ $siswa->nis ?? '-' }} • NISN: {{ $siswa->nisn ?? '-' }}</p>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-gradient w-100" data-bs-toggle="modal" data-bs-target="#editNamaModal">
                                <i class="fas fa-user me-1"></i> Edit Nama
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-gradient w-100" data-bs-toggle="modal" data-bs-target="#editEmailModal">
                                <i class="fas fa-envelope me-1"></i> Edit Email
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-gradient w-100" data-bs-toggle="modal" data-bs-target="#editFotoModal">
                                <i class="fas fa-camera me-1"></i> Edit Foto
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-gradient w-100" data-bs-toggle="modal" data-bs-target="#editPasswordModal">
                                <i class="fas fa-key me-1"></i> Password
                            </button>
                        </div>
                        @if($siswa && $siswa->foto)
                        <div class="col-12">
                            <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#confirmDeleteFotoModal">
                                <i class="fas fa-trash me-1"></i> Hapus Foto
                            </button>
                        </div>
                        @endif
                    </div>
                    
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('siswa.dataDiri.exportPDF') }}" class="btn btn-gradient" target="_blank">
                            <i class="fas fa-download me-1"></i> Unduh Data
                        </a>
                        <a href="{{ route('siswa.dataDiri.edit') }}" class="btn btn-outline-gradient">
                            <i class="fas fa-edit me-1"></i> Lengkapi Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parent Contact Card -->
        <div class="col-xl-4">
            <div class="card parent-contact-card shadow-sm fade-in" style="animation-delay: 0.6s;">
                <div class="card-body">
                    <h5 class="mb-3">Kontak Orang Tua</h5>

                    <div class="mb-3">
                        <div class="parent-data-card">
                            <h6 class="text-primary">
                                <i class="fas fa-user-tie"></i>Data Ayah
                            </h6>
                            <table class="table table-borderless table-sm mb-0">
                                <tbody>
                                    <tr>
                                        <th width="40%">Nama</th>
                                        <td>{{ $siswa->ayah->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon</th>
                                        <td>{{ $siswa->ayah->telepon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pekerjaan</th>
                                        <td>{{ $siswa->ayah->pekerjaan ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="parent-data-card">
                            <h6 class="text-danger">
                                <i class="fas fa-user"></i>Data Ibu
                            </h6>
                            <table class="table table-borderless table-sm mb-0">
                                <tbody>
                                    <tr>
                                        <th width="40%">Nama</th>
                                        <td>{{ $siswa->ibu->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon</th>
                                        <td>{{ $siswa->ibu->telepon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pekerjaan</th>
                                        <td>{{ $siswa->ibu->pekerjaan ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <a href="{{ route('siswa.dataDiri.edit') }}" class="btn btn-gradient w-100">
                        <i class="fas fa-edit me-1"></i>Edit Kontak Orang Tua
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Nama -->
<div class="modal fade" id="editNamaModal" tabindex="-1" aria-labelledby="editNamaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNamaModalLabel">Edit Nama Lengkap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.updateProfile') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $siswa->nama_lengkap ?? '' }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Email -->
<div class="modal fade" id="editEmailModal" tabindex="-1" aria-labelledby="editEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmailModalLabel">Edit Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.updateEmail') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <div class="form-text">Masukkan password saat ini untuk mengubah email</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Foto -->
<div class="modal fade" id="editFotoModal" tabindex="-1" aria-labelledby="editFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFotoModalLabel">Ganti Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.uploadPhoto') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="foto" class="form-label">Pilih Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                        <div class="form-text">Format: JPG, JPEG, PNG. Maksimal: 2MB</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Foto -->
<div class="modal fade" id="confirmDeleteFotoModal" tabindex="-1" aria-labelledby="confirmDeleteFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteFotoModalLabel">Hapus Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.profile.photo.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus foto profil? Tindakan ini tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Password -->
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPasswordModalLabel">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.updatePassword') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-text">Minimal 8 karakter</div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection