@extends('layouts.app')

@section('title', 'Data Pribadi')

@section('content')
<style>
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

    main {
        padding: 20px 15px !important;
        overflow-x: auto !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 10px !important;
        overflow-x: auto !important;
    }

    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
        width: 100%;
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
        pointer-events: none;
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1.3rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .btn-edit {
        background: #F59E0B;
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-edit:hover {
        background: #D97706;
        transform: translateY(-2px);
        color: white;
    }

    .profile-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        width: 100%;
        background: white;
    }

    .profile-card .card-body {
        padding: 1.5rem;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .profile-avatar-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
        font-size: 40px;
        background: var(--primary-gradient);
        margin: 0 auto;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .info-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        width: 100%;
        background: white;
        margin-bottom: 1.5rem;
    }

    .info-card .card-header {
        background: white;
        border-bottom: 1px solid #E2E8F0;
        padding: 0.8rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 1rem;
    }

    .info-card .card-header h5 i {
        color: #667eea;
        margin-right: 6px;
    }

    .info-card .card-body {
        padding: 1.2rem 1.5rem;
    }

    .info-row {
        display: flex;
        padding: 0.5rem 0;
        border-bottom: 1px solid #F1F5F9;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        width: 180px;
        font-weight: 600;
        color: #64748B;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .info-value {
        flex: 1;
        color: #1E293B;
        font-size: 0.9rem;
    }

    .badge-gender {
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-gender.laki {
        background: #DBEAFE;
        color: #2563EB;
    }

    .badge-gender.perempuan {
        background: #FCE7F3;
        color: #DB2777;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1rem;
        }
        .page-header h3 {
            font-size: 1.1rem;
        }
        .page-header .text-muted {
            font-size: 0.75rem;
        }

        .info-row {
            flex-direction: column;
            padding: 0.6rem 0;
        }

        .info-label {
            width: 100%;
            font-size: 0.75rem;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 0.85rem;
        }

        .profile-avatar,
        .profile-avatar-placeholder {
            width: 100px;
            height: 100px;
            font-size: 32px;
        }

        .profile-card .card-body {
            padding: 1rem;
        }

        .info-card .card-header {
            padding: 0.6rem 1rem;
        }

        .info-card .card-body {
            padding: 0.8rem 1rem;
        }

        .btn-edit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-user me-2"></i> Data Pribadi</h3>
                <div class="text-muted">Informasi profil Anda</div>
            </div>
            <div>
                <a href="{{ route('kurikulum.data-pribadi.edit') }}" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="border-radius:10px; padding:0.8rem 1.2rem; font-size:0.9rem;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-3">
        <!-- Profile -->
        <div class="col-md-4">
            <div class="profile-card">
                <div class="card-body text-center">
                    @if(isset($user) && $user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto" class="profile-avatar">
                    @else
                        <div class="profile-avatar-placeholder">
                            {{ $guru && $guru->nama ? strtoupper(substr($guru->nama, 0, 1)) : 'K' }}
                        </div>
                    @endif

                    <h5 class="mt-3 fw-bold">{{ $guru->nama ?? '-' }}</h5>
                    <p class="text-muted mb-1" style="font-size:0.85rem;">NIP: {{ $guru->nip ?? '-' }}</p>
                    <p class="text-muted small">{{ $user->username ?? '-' }}</p>
                </div>
            </div>

            <div class="info-card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle"></i> Ringkasan</h5>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label">Tempat, Tgl Lahir</div>
                        <div class="info-value">
                            {{ $guru && $guru->tempat_lahir ? $guru->tempat_lahir : '-' }},
                            {{ $guru && $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d-m-Y') : '-' }}
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Jenis Kelamin</div>
                        <div class="info-value">
                            @php
                                $gender = $guru->jenis_kelamin ?? '';
                            @endphp
                            @if($gender == 'L')
                                <span class="badge-gender laki"><i class="fas fa-male me-1"></i> Laki-laki</span>
                            @elseif($gender == 'P')
                                <span class="badge-gender perempuan"><i class="fas fa-female me-1"></i> Perempuan</span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Alamat</div>
                        <div class="info-value">{{ $guru && $guru->alamat ? $guru->alamat : '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail -->
        <div class="col-md-8">
            <div class="info-card">
                <div class="card-header">
                    <h5><i class="fas fa-id-card"></i> Detail Profil</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Nama</div>
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
                                <div class="info-label">Telepon</div>
                                <div class="info-value">{{ $guru->telepon ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">Tempat Lahir</div>
                                <div class="info-value">{{ $guru->tempat_lahir ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Tanggal Lahir</div>
                                <div class="info-value">
                                    {{ $guru && $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Jenis Kelamin</div>
                                <div class="info-value">
                                    @if($guru && $guru->jenis_kelamin == 'L')
                                        <span class="badge-gender laki">Laki-laki</span>
                                    @elseif($guru && $guru->jenis_kelamin == 'P')
                                        <span class="badge-gender perempuan">Perempuan</span>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Umur</div>
                                <div class="info-value">
                                    {{ $guru && $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->age . ' tahun' : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="info-row">
                        <div class="info-label">Alamat Lengkap</div>
                        <div class="info-value">{{ $guru && $guru->alamat ? $guru->alamat : '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection