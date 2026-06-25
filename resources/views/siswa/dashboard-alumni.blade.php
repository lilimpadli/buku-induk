@extends('layouts.app')

@section('content')

<style>
    /* CSS Variables untuk konsistensi */
    :root {
        --primary-color: #667eea;
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --bg-light: #f7fafc;
        --bg-white: #ffffff;
        --border-radius: 12px;
        --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.07);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--bg-light);
        color: var(--text-primary);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
    }

    .dashboard-header {
        background: var(--success-gradient);
        color: white;
        padding: 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 20s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(-30px, -30px) rotate(180deg); }
    }

    .dashboard-header h2 {
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .dashboard-header .subtitle {
        opacity: 0.9;
        font-size: 1rem;
        position: relative;
        z-index: 1;
    }

    .stat-card {
        background: var(--bg-white);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid #e5e7eb;
    }

    .stat-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .stat-card .icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 1rem;
        transition: var(--transition);
    }

    .stat-card:hover .icon-wrapper {
        transform: scale(1.05);
    }

    .profile-card {
        background: var(--bg-white);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        text-align: center;
        border: 1px solid #e5e7eb;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        overflow: hidden;
        border: 4px solid white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        position: relative;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-avatar .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 48px;
        font-weight: 700;
    }

    .btn-gradient {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .alumni-badge {
        display: inline-block;
        background: var(--success-gradient);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .info-item {
        background: #f8f9fa;
        padding: 1.25rem;
        border-radius: 8px;
        border-left: 4px solid var(--primary-color);
    }

    .info-item h6 {
        color: var(--text-secondary);
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-item p {
        color: var(--text-primary);
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem;
        }

        .dashboard-header h2 {
            font-size: 1.5rem;
        }

        .stat-card {
            padding: 1.25rem;
        }

        .profile-card {
            padding: 1.5rem;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
        }

        .profile-avatar .avatar-placeholder {
            font-size: 40px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    .card-hover {
        transition: var(--transition);
        cursor: pointer;
    }

    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }
</style>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="dashboard-header fade-in">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h2 class="mb-2">Selamat Datang, {{ $siswa->nama_lengkap ?? Auth::user()->name }}! 🎓</h2>
                <p class="subtitle mb-0">Status: Anda telah lulus dari sekolah kami</p>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row g-3 mb-4">
        <div class="col-lg-6 col-md-6 fade-in">
            <div class="stat-card card-hover">
                <div class="icon-wrapper" style="background: var(--success-gradient);">
                    <i class="fas fa-graduation-cap text-white"></i>
                </div>
                <h5 class="text-muted mb-1">Status Alumni</h5>
                <h4 class="mb-2"><span class="text-success">Lulus</span></h4>
                <p class="text-muted small mb-0">Anda telah menyelesaikan pendidikan di sekolah kami</p>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 fade-in">
            <div class="stat-card card-hover">
                <div class="icon-wrapper" style="background: var(--info-gradient);">
                    <i class="fas fa-calendar text-white"></i>
                </div>
                <h5 class="text-muted mb-1">Tanggal Kelulusan</h5>
                <h4 class="mb-2">
                    @if($siswa && $siswa->mutasiTerakhir)
                        {{ \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_mutasi)->format('d M Y') }}
                    @else
                        -
                    @endif
                </h4>
                <p class="text-muted small mb-0">Tanggal resmi kelulusan</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-lg-8 fade-in">
            <div class="profile-card card-hover">
                <div class="alumni-badge">
                    <i class="fas fa-star"></i> Alumni 2024/2025
                </div>

                <div class="profile-avatar">
                    @if($siswa && $siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Profil">
                    @else
                        <div class="avatar-placeholder">
                            {{ $siswa ? strtoupper(substr($siswa->nama_lengkap,0,1)) : 'A' }}
                        </div>
                    @endif
                </div>

                <h3 class="mb-2">{{ $siswa->nama_lengkap ?? 'Belum Lengkap' }}</h3>
                <p class="text-muted mb-4">NIS: {{ $siswa->nis ?? '-' }} • NISN: {{ $siswa->nisn ?? '-' }}</p>

                <!-- Alumni Info Grid -->
                <div class="info-grid">
                    <div class="info-item">
                        <h6>Asal Sekolah</h6>
                        <p>
                            @if($siswa && $siswa->rombel && $siswa->rombel->kelas)
                                {{ $siswa->rombel->kelas->tingkat ?? '-' }} 
                                @if($siswa->rombel->kelas->jurusan)
                                    - {{ $siswa->rombel->kelas->jurusan->nama }}
                                @endif
                            @else
                                -
                            @endif
                        </p>
                    </div>

                    <div class="info-item">
                        <h6>Tempat Lahir</h6>
                        <p>{{ $siswa->tempat_lahir ?? '-' }}</p>
                    </div>

                    <div class="info-item">
                        <h6>Tanggal Lahir</h6>
                        <p>{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') : '-' }}</p>
                    </div>

                    <div class="info-item">
                        <h6>Jenis Kelamin</h6>
                        <p>{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' ?? '-' }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3 justify-content-center mt-4">
                    <a href="{{ route('siswa.dataDiri.exportPDF') }}" class="btn btn-gradient" target="_blank">
                        <i class="fas fa-download"></i> Unduh Data
                    </a>
                    <a href="{{ route('siswa.dataDiri') }}" class="btn btn-gradient">
                        <i class="fas fa-user-circle"></i> Lihat Profil Lengkap
                    </a>
                </div>
            </div>
        </div>

        <!-- Alumni Info Card -->
        <div class="col-lg-4 fade-in">
            <div class="stat-card">
                <h5 class="mb-4">Informasi Alumni</h5>

                <div style="background: #E0F2FE; border-left: 4px solid #0284C7; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <p style="margin: 0; color: #075985; font-size: 0.9rem;">
                        <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                        <strong>Selamat atas kelulusan Anda!</strong> Anda telah resmi menjadi alumni dari sekolah kami.
                    </p>
                </div>

                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e7eb;">
                    <h6 style="font-weight: 700; margin-bottom: 1rem; color: var(--text-primary);">Status Kelulusan</h6>
                    <div style="background: #F0FDF4; padding: 1rem; border-radius: 8px; text-align: center;">
                        <div style="font-size: 2rem; color: #16A34A; margin-bottom: 0.5rem;">✓</div>
                        <p style="margin: 0; color: #166534; font-weight: 600;">
                            Anda telah dinyatakan LULUS
                        </p>
                        @if($siswa && $siswa->mutasiTerakhir && $siswa->mutasiTerakhir->tanggal_mutasi)
                            <p style="margin: 0.5rem 0 0 0; color: #16A34A; font-size: 0.9rem;">
                                Tanggal: {{ \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_mutasi)->format('d F Y') }}
                            </p>
                        @endif
                    </div>
                </div>

                @if($siswa && $siswa->mutasiTerakhir && $siswa->mutasiTerakhir->keterangan)
                    <div style="margin-top: 1.5rem; padding: 1rem; background: #FEF3C7; border-radius: 8px; border-left: 4px solid #F59E0B;">
                        <h6 style="font-weight: 700; color: #92400E; margin-bottom: 0.5rem;">Keterangan</h6>
                        <p style="margin: 0; color: #78350F; font-size: 0.9rem;">
                            {{ $siswa->mutasiTerakhir->keterangan }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
