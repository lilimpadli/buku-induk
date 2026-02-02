@extends('layouts.app')

@section('title','Dashboard Kurikulum')

@section('content')

<style>
    /* ===================== DASHBOARD KURIKULUM STYLES ===================== */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        --bg-light: #f7fafc;
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* ===== HEADER ===== */
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

    .dashboard-header h1 {
        font-weight: 700;
        margin-bottom: 0.25rem;
        position: relative;
        z-index: 1;
        font-size: 1.75rem;
    }

    .dashboard-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        position: relative;
        z-index: 1;
        margin-bottom: 0;
    }

    /* ===== STAT CARDS ===== */
    .stat-card {
        border-radius: 20px;
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        height: 100%;
        background: white;
        padding: 1.5rem;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--card-hover-shadow);
    }

    .stat-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
    }

    .stat-card:nth-child(1)::before { background: var(--primary-gradient); }
    .stat-card:nth-child(2)::before { background: var(--success-gradient); }
    .stat-card:nth-child(3)::before { background: var(--warning-gradient); }

    .stat-card-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        margin-right: 1rem;
        flex-shrink: 0;
        transition: var(--transition);
    }

    .stat-card:hover .stat-icon { transform: scale(1.15); }

    .stat-card:nth-child(1) .stat-icon { background: var(--primary-gradient); }
    .stat-card:nth-child(2) .stat-icon { background: var(--success-gradient); }
    .stat-card:nth-child(3) .stat-icon { background: var(--warning-gradient); }

    .stat-title {
        color: #64748B;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 0.1rem;
    }

    .stat-label {
        color: #94A3B8;
        font-size: 12px;
        margin-bottom: 0;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-top: 0.5rem;
        margin-bottom: 0;
    }

    /* ===== ACTIVITY CARD (DESKTOP TABLE) ===== */
    .activity-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .activity-card .card-body {
        padding: 0 !important;
    }

    .activity-card .table {
        margin-bottom: 0;
    }

    .activity-card thead {
        background-color: #F8FAFC;
    }

    .activity-card th {
        color: #94A3B8;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        padding: 1.2rem;
    }

    .activity-card td {
        padding: 1.2rem;
        border-color: #E2E8F0;
    }

    .activity-card tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.02);
    }

    .card-header-custom {
        padding: 1.5rem;
        border-bottom: 1px solid #E2E8F0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header-custom h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 1.1rem;
    }

    .card-header-custom a {
        color: #667eea;
        font-weight: 600;
        text-decoration: none;
        font-size: 14px;
    }

    /* ===== STATUS BADGES ===== */
    .badge-status {
        font-size: 12px;
        font-weight: 600;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    .badge-processed {
        background-color: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .badge-accepted {
        background-color: rgba(19, 180, 151, 0.1);
        color: #13B497;
    }

    .badge-rejected {
        background-color: rgba(245, 87, 108, 0.1);
        color: #F5576C;
    }

    /* ===== MOBILE CARD LIST ===== */
    .mobile-ppdb-card {
        padding: 14px 16px;
        border-bottom: 1px solid #E2E8F0;
        transition: background 0.2s ease;
    }

    .mobile-ppdb-card:last-child {
        border-bottom: none;
    }

    .mobile-ppdb-card:active {
        background-color: rgba(102, 126, 234, 0.04);
    }

    .mobile-ppdb-card .mobile-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .mobile-ppdb-card .mobile-name {
        font-weight: 600;
        color: #1E293B;
        font-size: 15px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        min-width: 0;
    }

    .mobile-ppdb-card .mobile-meta {
        margin-top: 8px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 13px;
        color: #64748B;
    }

    .mobile-ppdb-card .mobile-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .mobile-ppdb-card .mobile-meta .meta-label {
        color: #94A3B8;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-weight: 600;
    }

    .mobile-ppdb-empty {
        padding: 2.5rem 1rem;
        text-align: center;
        color: #94A3B8;
    }

    .mobile-ppdb-empty i {
        font-size: 1.8rem;
        display: block;
        margin-bottom: 0.5rem;
    }

    /* ===== FOOTER LINK ===== */
    .activity-footer {
        text-align: center;
        padding: 0.85rem 1rem;
        border-top: 1px solid #E2E8F0;
    }

    .activity-footer a {
        color: #667eea;
        font-weight: 600;
        text-decoration: none;
        font-size: 14px;
    }

    .activity-footer a:hover {
        text-decoration: underline;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 767.98px) {
        .dashboard-header {
            padding: 1.25rem 1rem;
        }

        .dashboard-header h1 {
            font-size: 1.35rem;
        }

        .dashboard-header .text-muted {
            font-size: 13px;
        }

        .stat-card {
            padding: 1.1rem 1rem;
        }

        .stat-card-header {
            margin-bottom: 0.75rem;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            font-size: 20px;
            margin-right: 0.75rem;
        }

        .stat-value {
            font-size: 2rem;
            margin-top: 0.25rem;
        }

        .card-header-custom {
            padding: 1rem 1rem;
        }

        .activity-card {
            margin-bottom: 1.5rem;
        }
    }
</style>

{{-- HEADER --}}
<div class="dashboard-header fade-in">
    <h1>Selamat Datang, Kurikulum! 👋</h1>
    <p class="text-muted">Monitoring pembelajaran calon siswa baru tahun ajaran 2024/2025</p>
</div>

{{-- STATISTIK --}}
<div class="stats-row mb-4 d-grid gap-3 gap-md-4" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); animation: fadeIn 0.6s ease-out 0.1s both;">

    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fas fa-chalkboard-user"></i>
            </div>
            <div>
                <p class="stat-title">Total Guru</p>
                <p class="stat-label">Staff Pengajar Aktif</p>
            </div>
        </div>
        <h2 class="stat-value">{{ $totalGuru ?? 0 }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="stat-title">Total Siswa</p>
                <p class="stat-label">Siswa Terdaftar</p>
            </div>
        </div>
        <h2 class="stat-value">{{ $totalSiswa ?? 0 }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <p class="stat-title">Status PPDB</p>
                <p class="stat-label">Data Terverifikasi</p>
            </div>
        </div>
        <h2 class="stat-value">{{ $totalKelas ?? 0 }}</h2>
    </div>

</div>

{{-- AKTIVITAS TERBARU --}}
<div class="activity-card card fade-in" style="animation-delay: 0.2s;">
    <div class="card-header-custom">
        <h5>Peserta PPDB Terbaru</h5>
    </div>

    {{-- DESKTOP TABLE --}}
    <div class="table-responsive d-none d-md-block">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Calon Siswa</th>
                    <th>Status</th>
                    <th>Jurusan Pilihan</th>
                    <th>Tgl Daftar</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($aktivitas as $a)
                <tr>
                    <td>
                        <div class="fw-medium">{{ $a['nama'] ?? 'Data tidak tersedia' }}</div>
                    </td>
                    <td>
                        @php
                            $status = strtoupper($a['aktivitas'] ?? 'PROCESSED');
                            $badgeClass = match($status) {
                                'PROCESSED' => 'badge-processed',
                                'ACCEPTED'  => 'badge-accepted',
                                'REJECTED'  => 'badge-rejected',
                                default     => 'badge-processed'
                            };
                        @endphp
                        <span class="badge-status {{ $badgeClass }}">{{ $status }}</span>
                    </td>
                    <td>{{ $a['kelas'] ?? '-' }}</td>
                    <td class="text-muted">{{ $a['waktu'] ?? '-' }}</td>
                    <td><a href="#" class="link-primary"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        Tidak ada data peserta PPDB.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARD LIST --}}
    <div class="d-md-none">
        @forelse ($aktivitas as $a)
            @php
                $status = strtoupper($a['aktivitas'] ?? 'PROCESSED');
                $badgeClass = match($status) {
                    'PROCESSED' => 'badge-processed',
                    'ACCEPTED'  => 'badge-accepted',
                    'REJECTED'  => 'badge-rejected',
                    default     => 'badge-processed'
                };
            @endphp

            <div class="mobile-ppdb-card">
                <div class="mobile-top-row">
                    <div class="mobile-name">{{ $a['nama'] ?? 'Data tidak tersedia' }}</div>
                    <span class="badge-status {{ $badgeClass }} flex-shrink-0">{{ $status }}</span>
                </div>
                <div class="mobile-meta">
                    <span>
                        <span class="meta-label">Jurusan</span>
                        {{ $a['kelas'] ?? '-' }}
                    </span>
                    <span>
                        <span class="meta-label">Daftar</span>
                        {{ $a['waktu'] ?? '-' }}
                    </span>
                    <a href="#" class="link-primary ms-auto" style="font-size: 15px;">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="mobile-ppdb-empty">
                <i class="fas fa-inbox"></i>
                Tidak ada data peserta PPDB.
            </div>
        @endforelse
    </div>

    <div class="activity-footer">
        <a href="{{ route('kurikulum.siswa.index') }}">Lihat Semua Pendaftar</a>
    </div>
</div>

{{-- INFORMASI SEKOLAH --}}

@endsection