@extends('layouts.app')

@section('title', 'Detail Guru')

@section('content')
<style>
    /* ===================== STYLE DETAIL GURU ===================== */
    
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: #f7fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* ===== OVERRIDE LAYOUT ===== */
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

    /* ===== HEADER ===== */
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

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
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

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    /* ===== CARD ===== */
    .info-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        width: 100%;
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

    /* ===== INFO ROW ===== */
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

    /* ===== BADGE ===== */
    .badge-role {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-role.guru {
        background: #DBEAFE;
        color: #2563EB;
    }

    .badge-role.walikelas {
        background: #D1FAE5;
        color: #059669;
    }

    .badge-role.kaprog {
        background: #FEF3C7;
        color: #D97706;
    }

    .badge-role.tu {
        background: #E2E8F0;
        color: #475569;
    }

    .badge-role.kurikulum {
        background: #FCE7F3;
        color: #DB2777;
    }

    .badge-role.super_admin {
        background: #FEE2E2;
        color: #DC2626;
    }

    .badge-gender {
        padding: 2px 10px;
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

    /* ===== TABLE ===== */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        min-width: 400px;
        margin-bottom: 0;
        font-size: 0.85rem;
    }

    .table th {
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #64748B;
        padding: 0.6rem 0.8rem;
        white-space: nowrap;
        background-color: #F8FAFC;
        border-bottom: none;
    }

    .table td {
        padding: 0.6rem 0.8rem;
        vertical-align: middle;
        border-color: #E2E8F0;
    }

    .table tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.03);
    }

    .badge-siswa {
        background: #667eea;
        color: white;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
    }

    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: #94A3B8;
    }

    .empty-state i {
        font-size: 2rem;
        color: #CBD5E1;
        display: block;
        margin-bottom: 0.5rem;
    }

    /* ===== RESPONSIVE ===== */
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

        .info-card .card-header {
            padding: 0.6rem 1rem;
        }

        .info-card .card-body {
            padding: 0.8rem 1rem;
        }

        .table {
            min-width: 350px;
            font-size: 0.75rem;
        }
        .table th,
        .table td {
            padding: 0.4rem 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .table {
            min-width: 300px;
            font-size: 0.65rem;
        }
        .table th,
        .table td {
            padding: 0.3rem 0.4rem;
        }
        .badge-siswa {
            font-size: 0.55rem;
            padding: 1px 6px;
        }
    }
</style>

<div class="container-fluid px-4">
    <!-- HEADER -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-user-tie me-2"></i> Detail Guru</h3>
                <div class="text-muted">Informasi lengkap data guru</div>
            </div>
            <div>
                <a href="{{ route('kurikulum.guru.manage.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- DATA DIRI -->
    <div class="info-card">
        <div class="card-header">
            <h5><i class="fas fa-id-card"></i> Informasi Pribadi</h5>
        </div>
        <div class="card-body">
            <div class="info-row">
                <div class="info-label">Nama Lengkap</div>
                <div class="info-value"><strong>{{ $guru->nama }}</strong></div>
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
            <div class="info-row">
                <div class="info-label">Jenis Kelamin</div>
                <div class="info-value">
                    @if($guru->jenis_kelamin === 'L')
                        <span class="badge-gender laki"><i class="fas fa-male me-1"></i> Laki-laki</span>
                    @elseif($guru->jenis_kelamin === 'P')
                        <span class="badge-gender perempuan"><i class="fas fa-female me-1"></i> Perempuan</span>
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Tempat, Tanggal Lahir</div>
                <div class="info-value">
                    {{ $guru->tempat_lahir ?? '-' }}
                    @if($guru->tanggal_lahir)
                        , {{ \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d/m/Y') }}
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Alamat</div>
                <div class="info-value">{{ $guru->alamat ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Jurusan</div>
                <div class="info-value">{{ optional($guru->jurusan)->nama ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Role / Jabatan</div>
                <div class="info-value">
                    @php
                        $role = optional($guru->user)->role ?? '-';
                        $roleClass = match($role) {
                            'guru' => 'guru',
                            'walikelas' => 'walikelas',
                            'kaprog' => 'kaprog',
                            'tu' => 'tu',
                            'kurikulum' => 'kurikulum',
                            'super_admin' => 'super_admin',
                            default => ''
                        };
                        $roleLabel = match($role) {
                            'guru' => 'Guru',
                            'walikelas' => 'Wali Kelas',
                            'kaprog' => 'Kaprog',
                            'tu' => 'TU',
                            'kurikulum' => 'Kurikulum',
                            'super_admin' => 'Super Admin',
                            default => $role
                        };
                    @endphp
                    @if($role != '-')
                        <span class="badge-role {{ $roleClass }}">{{ $roleLabel }}</span>
                    @else
                        -
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ROMBEL -->
    <div class="info-card">
        <div class="card-header">
            <h5><i class="fas fa-users"></i> Rombel yang Diampu</h5>
        </div>
        <div class="card-body p-0">
            @if($guru->rombels && $guru->rombels->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Rombel</th>
                                <th>Tingkat</th>
                                <th>Jurusan</th>
                                <th class="text-center">Siswa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guru->rombels as $key => $rombel)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><span class="fw-semibold">{{ $rombel->nama }}</span></td>
                                    <td>{{ optional($rombel->kelas)->tingkat ?? '-' }}</td>
                                    <td>{{ optional(optional($rombel->kelas)->jurusan)->nama ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge-siswa">
                                            {{ $rombel->siswa_count ?? $rombel->siswa->count() }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada rombel yang diampu.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection