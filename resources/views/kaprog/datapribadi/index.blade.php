@extends('layouts.app')

@section('title', 'Data Diri - Kaprog')

@section('content')
<style>
    /* ===================== SAMA STYLE DENGAN DASHBOARD ===================== */
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
    }

    .dashboard-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        position: relative;
        z-index: 1;
    }

    /* Card Styles */
    .card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        height: 100%;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    .card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: var(--primary-gradient);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        font-size: 1.25rem;
    }

    /* Profile */
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transition: var(--transition);
    }

    .profile-avatar:hover {
        transform: scale(1.05);
    }

    .profile-placeholder {
        background: var(--primary-gradient);
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 48px;
        font-weight: 700;
        margin: 0 auto;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transition: var(--transition);
    }

    .profile-placeholder:hover {
        transform: scale(1.05);
    }

    /* Buttons */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        display: inline-block;
        text-align: center;
        text-decoration: none;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    /* Table Info */
    .info-table {
        width: 100%;
    }

    .info-table tr {
        border-bottom: 1px solid #e2e8f0;
    }

    .info-table tr:last-child {
        border-bottom: none;
    }

    .info-table th {
        font-weight: 600;
        color: var(--text-primary);
        padding: 12px 0;
        width: 35%;
        font-size: 14px;
    }

    .info-table td {
        padding: 12px 0;
        color: var(--text-secondary);
        font-size: 14px;
    }

    /* Badge */
    .badge-custom {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-laki {
        background: #667eea;
        color: white;
    }

    .badge-perempuan {
        background: #f093fb;
        color: white;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    hr {
        border-color: #e2e8f0;
        margin: 1.5rem 0;
    }

    @media (max-width: 768px) {
        .dashboard-header { padding: 1.5rem 1rem; }
        .dashboard-header h2 { font-size: 1.5rem; }
        .profile-avatar, .profile-placeholder { width: 90px; height: 90px; font-size: 36px; }
        .card-body { padding: 1.25rem; }
        .info-table th, .info-table td { font-size: 12px; padding: 8px 0; }
        .btn-gradient { padding: 0.4rem 1rem; font-size: 13px; }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="dashboard-header fade-in">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2 class="mb-1">Data Diri Kaprog 👤</h2>
                <div class="text-muted">Informasi lengkap profil Kepala Program Keahlian</div>
            </div>
        </div>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fade-in" role="alert" style="border-radius: 12px; background: #48bb7820; color: #2f855a; border: none;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show fade-in" role="alert" style="border-radius: 12px;">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content - 2 Kolom Simetris -->
    <div class="row g-4">
        <!-- KOLOM KIRI: Profile -->
        <div class="col-lg-4 fade-in" style="animation-delay: 0.1s;">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <div class="mb-4">
                        @if(isset($user) && $user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto" class="profile-avatar">
                        @else
                            <div class="profile-placeholder">
                                {{ $guru && $guru->nama ? strtoupper(substr($guru->nama, 0, 1)) : 'K' }}
                            </div>
                        @endif
                    </div>

                    <h5 class="mb-1 fw-bold">{{ $guru->nama ?? '-' }}</h5>
                    <p class="text-muted mb-2">NIP: {{ $guru->nip ?? '-' }}</p>
                    <p class="text-muted small mb-4">{{ $guru->email ?? '' }}</p>

                    <a href="{{ route('kaprog.datapribadi.edit') }}" class="btn-gradient mt-auto">
                        <i class="fas fa-edit me-2"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: Informasi Lengkap -->
        <div class="col-lg-8 fade-in" style="animation-delay: 0.2s;">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-user-circle me-2" style="color: #667eea;"></i>
                        Informasi Lengkap
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="info-table">
                                <tr><th>Nama Lengkap</th><td>{{ $guru->nama ?? '-' }}</td></tr>
                                <tr><th>NIP</th><td>{{ $guru->nip ?? '-' }}</td></tr>
                                <tr><th>Email</th><td>{{ $guru->email ?? '-' }}</td></tr>
                                <tr><th>Tempat Lahir</th><td>{{ $guru->tempat_lahir ?? '-' }}</td></tr>
                                <tr><th>Tanggal Lahir</th><td>{{ $guru->tanggal_lahir ?? '-' }}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="info-table">
                                <tr><th>Jenis Kelamin</th>
                                    <td>
                                        @if(($guru->jenis_kelamin ?? '') == 'L')
                                            <span class="badge-custom badge-laki">Laki-laki</span>
                                        @elseif(($guru->jenis_kelamin ?? '') == 'P')
                                            <span class="badge-custom badge-perempuan">Perempuan</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                 </tr>
                                <tr><th>Alamat</th><td>{{ $guru->alamat ?? '-' }}</td></tr>
                                <tr><th>No. HP</th><td>{{ $guru->no_hp ?? '-' }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection