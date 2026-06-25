@extends('layouts.app')

@section('title', 'Profil Guru')

@section('content')
<style>
    /* ===================== STYLE PROFIL GURU ===================== */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: #f7fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Page Header */
    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
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

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        position: relative;
        z-index: 1;
    }

    /* Card Styles */
    .profile-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: var(--transition);
        height: 100%;
    }

    .profile-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .profile-card .card-body {
        padding: 1.5rem;
    }

    /* Profile Avatar */
    .profile-avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        transition: var(--transition);
    }

    .profile-avatar:hover {
        transform: scale(1.05);
    }

    .profile-avatar-placeholder {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 700;
        background: var(--primary-gradient);
        color: white;
        border: 4px solid white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        margin: 0 auto;
    }

    /* Info Row */
    .info-row {
        display: flex;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .info-label {
        width: 140px;
        font-weight: 600;
        color: #4a5568;
    }

    .info-value {
        flex: 1;
        color: #2d3748;
    }

    /* Section Header */
    .section-header {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #667eea;
        display: inline-block;
    }

    .section-header i {
        color: #667eea;
        margin-right: 8px;
    }

    /* Divider */
    .section-divider {
        margin: 1.5rem 0;
        border-top: 1px solid #e2e8f0;
    }

    /* Button */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    /* Alert */
    .alert {
        border-radius: 12px;
        border: none;
        font-size: 0.875rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .alert-success {
        background-color: rgba(19, 180, 151, 0.1);
        color: #13B497;
        border-left: 4px solid #13B497;
    }

    .alert-danger {
        background-color: rgba(240, 83, 108, 0.1);
        color: #F0536C;
        border-left: 4px solid #F0536C;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem 1rem;
        }
        
        .page-header h3 {
            font-size: 1.5rem;
        }
        
        .profile-card .card-body {
            padding: 1.25rem;
        }
        
        .info-row {
            flex-direction: column;
        }
        
        .info-label {
            width: 100%;
            margin-bottom: 5px;
        }
        
        .profile-avatar, .profile-avatar-placeholder {
            width: 120px;
            height: 120px;
            font-size: 40px;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="page-header fade-in">
        <div>
            <h3 class="mb-1">👤 Profil Guru</h3>
            <div class="text-muted">Informasi lengkap profil Anda</div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Kolom Kiri - Profil -->
        <div class="col-lg-4 fade-in" style="animation-delay: 0.1s;">
            <div class="profile-card text-center">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if(isset($user) && $user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="profile-avatar mb-3">
                    @else
                        <div class="profile-avatar-placeholder mb-3">
                            {{ $guru && $guru->nama ? strtoupper(substr($guru->nama, 0, 1)) : 'G' }}
                        </div>
                    @endif

                    <h5 class="fw-bold mb-1">{{ $guru->nama ?? '-' }}</h5>
                    <div class="mb-3">
                        <span class="badge bg-primary px-3 py-2">
                            <i class="fas fa-id-card me-1"></i> NIP: {{ $guru->nip ?? '-' }}
                        </span>
                    </div>

                    <div class="text-start mt-3">
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-envelope me-2 text-primary"></i> Email</div>
                            <div class="info-value">{{ $guru->email ?? '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Tempat Lahir</div>
                            <div class="info-value">{{ $guru->tempat_lahir ?? '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-calendar-alt me-2 text-primary"></i> Tanggal Lahir</div>
                            <div class="info-value">{{ $guru->tanggal_lahir ?? '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-venus-mars me-2 text-primary"></i> Jenis Kelamin</div>
                            <div class="info-value">
                                <span class="badge {{ $guru->jenis_kelamin == 'L' ? 'bg-primary' : 'bg-danger' }}">
                                    {{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : ($guru->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                                </span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-home me-2 text-primary"></i> Alamat</div>
                            <div class="info-value">{{ $guru->alamat ?? '-' }}</div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <a href="{{ route('walikelas.data_diri.edit') }}" class="btn btn-gradient w-100">
                        <i class="fas fa-edit"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan - Detail Informasi (SEMUA DALAM SATU CARD) -->
        <div class="col-lg-8 fade-in" style="animation-delay: 0.2s;">
            <div class="profile-card">
                <div class="card-body">
                    <!-- Informasi Lengkap -->
                    <h5 class="section-header">
                        <i class="fas fa-info-circle"></i> Informasi Lengkap
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Nama Lengkap</div>
                                <div class="info-value"><strong>{{ $guru->nama ?? '-' }}</strong></div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">NIP</div>
                                <div class="info-value">{{ $guru->nip ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $guru->email ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Tempat Lahir</div>
                                <div class="info-value">{{ $guru->tempat_lahir ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Tanggal Lahir</div>
                                <div class="info-value">{{ $guru->tanggal_lahir ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Jenis Kelamin</div>
                                <div class="info-value">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : ($guru->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Alamat</div>
                                <div class="info-value">{{ $guru->alamat ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="section-divider"></div>

                    <!-- Status Akun -->
                    <h5 class="section-header">
                        <i class="fas fa-shield-alt"></i> Status Akun
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Role</div>
                                <div class="info-value">
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-user-tie me-1"></i> Wali Kelas
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Status</div>
                                <div class="info-value">
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Aktif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="section-divider"></div>

                    <!-- Informasi Kelas -->
                    <h5 class="section-header">
                        <i class="fas fa-chalkboard-user"></i> Informasi Kelas
                    </h5>

                    @php
                        $rombel = \App\Models\Rombel::where('guru_id', $guru->id ?? 0)->first();
                    @endphp

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label"><i class="fas fa-graduation-cap me-2 text-primary"></i> Kelas / Rombel</div>
                                <div class="info-value">
                                    @if($rombel)
                                        <span class="badge bg-primary px-3 py-2">
                                            <i class="fas fa-school me-1"></i> {{ $rombel->nama }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label"><i class="fas fa-users me-2 text-primary"></i> Jumlah Siswa</div>
                                <div class="info-value">
                                    @if($rombel)
                                        <span class="badge bg-info text-dark px-3 py-2">
                                            <i class="fas fa-user-graduate me-1"></i> 
                                            {{ \App\Models\DataSiswa::where('rombel_id', $rombel->id)->count() }} Siswa
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection