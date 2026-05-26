@extends('layouts.app')

@section('title', 'Data Pribadi Saya')

@section('content')
<style>
    /* ===================== PROFILE PAGE STYLES ===================== */
    
    :root {
        --primary: #4F46E5;
        --primary-dark: #4338CA;
        --secondary: #10B981;
        --danger: #EF4444;
        --warning: #F59E0B;
        --info: #3B82F6;
        --dark: #1F2937;
        --gray: #6B7280;
        --light: #F9FAFB;
        --white: #FFFFFF;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--light);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--dark);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Profile Card */
    .profile-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: var(--transition);
        margin-bottom: 2rem;
    }

    .profile-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .profile-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 2rem;
        text-align: center;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .profile-header::after {
        content: "";
        position: absolute;
        bottom: -30px;
        left: -30px;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .profile-avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        border: 4px solid var(--white);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        transition: var(--transition);
        margin: 0 auto 1.5rem;
        position: relative;
        z-index: 2;
        overflow: hidden;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.2);
    }

    .profile-name {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .profile-info {
        font-size: 14px;
        opacity: 0.9;
        margin-bottom: 0.25rem;
        position: relative;
        z-index: 2;
    }

    .profile-stats {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-top: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 20px;
        font-weight: 700;
        display: block;
    }

    .stat-label {
        font-size: 12px;
        opacity: 0.8;
    }

    .edit-profile-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: var(--white);
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .edit-profile-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        color: var(--white);
        transform: translateY(-2px);
    }

    /* Info Cards */
    .info-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        padding: 1.5rem;
        transition: var(--transition);
        margin-bottom: 1.5rem;
    }

    .info-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .info-card-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-card-title::before {
        content: "";
        width: 4px;
        height: 20px;
        background: var(--primary);
        border-radius: 2px;
    }

    /* Detail Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .detail-item {
        background: var(--light);
        padding: 1rem;
        border-radius: 12px;
        transition: var(--transition);
    }

    .detail-item:hover {
        background: #F3F4F6;
        transform: translateY(-2px);
    }

    .detail-label {
        font-size: 12px;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }

    .detail-value {
        font-size: 14px;
        color: var(--dark);
        font-weight: 500;
    }

    /* Address Section */
    .address-section {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        padding: 1.5rem;
        transition: var(--transition);
    }

    .address-section:hover {
        box-shadow: var(--shadow-lg);
    }

    .address-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .address-title::before {
        content: "";
        width: 4px;
        height: 20px;
        background: var(--secondary);
        border-radius: 2px;
    }

    .address-content {
        background: var(--light);
        padding: 1rem;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.6;
    }

    /* Alerts */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
            align-items: center;
            gap: 0.75rem;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: var(--secondary);
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }

    .alert-icon {
        font-size: 20px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .profile-card,
    .info-card,
    .address-section {
        animation: fadeIn 0.6s ease-out;
    }

    .info-card:nth-child(2) { animation-delay: 0.1s; }
    .info-card:nth-child(3) { animation-delay: 0.2s; }
    .address-section { animation-delay: 0.3s; }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-stats {
            gap: 1rem;
        }
        
        .stat-value {
            font-size: 16px;
        }
        
        .detail-grid {
            grid-template-columns: 1fr;
        }
        
        .profile-header {
            padding: 1.5rem;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
        }
        
        .profile-name {
            font-size: 20px;
        }
    }
</style>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle alert-icon"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle alert-icon"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                @if(isset($user) && $user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil">
                @else
                    <div class="profile-avatar-placeholder">
                        {{ $guru && $guru->nama ? strtoupper(substr($guru->nama, 0, 1)) : 'TU' }}
                    </div>
                @endif
            </div>
            
            <h2 class="profile-name">{{ $guru->nama ?? '-' }}</h2>
            <p class="profile-info">NIP: {{ $guru->nip ?: ($user->nomor_induk ?? '-') }}</p>
            <p class="profile-info">{{ $user->username ?? '-' }}</p>
            
            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-value">{{ optional($guru)->tanggal_lahir ? \Carbon\Carbon::parse(optional($guru)->tanggal_lahir)->age : '-' }}</span>
                    <span class="stat-label">Tahun</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ optional($guru)->jenis_kelamin == 'L' ? 'Laki-laki' : (optional($guru)->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</span>
                    <span class="stat-label">Jenis Kelamin</span>
                </div>
            </div>
            
            <a href="{{ route('tu.data-pribadi.edit') }}" class="edit-profile-btn">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row">
        <div class="col-lg-6">
            <div class="info-card">
                <h3 class="info-card-title">Informasi Pribadi</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Nama</div>
                        <div class="detail-value">{{ $guru->nama ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">NIP</div>
                        <div class="detail-value">{{ $guru->nip ?: ($user->nomor_induk ?? '-') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">{{ $guru->email ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Telepon</div>
                        <div class="detail-value">{{ $guru->telepon ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="info-card">
                <h3 class="info-card-title">Data Lainnya</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Tempat Lahir</div>
                        <div class="detail-value">{{ optional($guru)->tempat_lahir ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tanggal Lahir</div>
                        <div class="detail-value">{{ optional($guru)->tanggal_lahir ? \Carbon\Carbon::parse(optional($guru)->tanggal_lahir)->format('d F Y') : '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Jenis Kelamin</div>
                        <div class="detail-value">
                            {{ optional($guru)->jenis_kelamin == 'L' ? 'Laki-laki' : (optional($guru)->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Umur</div>
                        <div class="detail-value">{{ optional($guru)->tanggal_lahir ? \Carbon\Carbon::parse(optional($guru)->tanggal_lahir)->age . ' tahun' : '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Section -->
    <div class="address-section">
        <h3 class="address-title">
            <i class="fas fa-map-marker-alt"></i>
            Alamat Lengkap
        </h3>
        <div class="address-content">
            {{ optional($guru)->alamat ?? '-' }}
        </div>
    </div>
</div>
@endsection