@extends('layouts.app')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<style>
    /* ===================== DASHBOARD STYLES ===================== */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --danger-gradient: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        --border-radius: 20px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f5 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Header */
    .dashboard-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .dashboard-header::after {
        content: "";
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }

    /* FIX: Tombol di header bisa diklik */
    .dashboard-header .btn,
    .dashboard-header a {
        pointer-events: auto !important;
        cursor: pointer !important;
        position: relative;
        z-index: 100 !important;
    }

    /* Stat Cards */
    .stat-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        background: white;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
    }

    .stat-icon.primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stat-icon.success { background: linear-gradient(135deg, #13B497 0%, #59D4A4 100%); }
    .stat-icon.info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .stat-icon.danger { background: linear-gradient(135deg, #fa709a 0%, #f5576c 100%); }

    /* Chart Cards */
    .chart-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        background: white;
        height: 100%;
    }

    .chart-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-hover-shadow);
    }

    .chart-card .card-header {
        background: white;
        border-bottom: 1px solid #f0f0f0;
        padding: 1rem 1.25rem;
    }

    /* Student List */
    .student-list {
        border-radius: var(--border-radius);
    }

    .student-item {
        border-radius: 12px;
        margin-bottom: 10px;
        padding: 12px;
        transition: var(--transition);
        background: #f8fafc;
    }

    .student-item:hover {
        background: white;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        transform: translateX(3px);
    }

    .student-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
    }

    .student-avatar-placeholder {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
        font-size: 18px;
        background: var(--primary-gradient);
    }

    /* Progress Bar */
    .progress {
        height: 8px;
        border-radius: 10px;
        background: #e2e8f0;
    }

    /* Buttons */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 500;
        padding: 0.5rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 1.5px solid #ffffff;
        color: white;
        font-weight: 500;
        padding: 0.5rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
    }

    .btn-outline-gradient:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        transform: translateY(-2px);
    }

    /* Quick Actions */
    .quick-actions-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        background: white;
        overflow: hidden;
    }

    .quick-actions-card .card-header {
        background: white;
        border-bottom: 1px solid #f0f0f0;
        padding: 1.25rem 1.5rem;
    }

    .quick-actions-card .card-header h6 {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.95rem;
    }

    .action-list {
        padding: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
    }

    .action-item {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 0.875rem 1rem;
        border-radius: 12px;
        text-decoration: none;
        color: #1f2937;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    .action-item:hover {
        background: #f9fafb;
        border-color: #e5e7eb;
        transform: translateX(4px);
        text-decoration: none;
        color: #1f2937;
    }

    .action-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .action-icon.bg-primary-soft { background: #EEF2FF; color: #4F46E5; }
    .action-icon.bg-success-soft { background: #ECFDF5; color: #10B981; }
    .action-icon.bg-info-soft { background: #EFF6FF; color: #3B82F6; }
    .action-icon.bg-warning-soft { background: #FFFBEB; color: #F59E0B; }
    .action-icon.bg-secondary-soft { background: #F3F4F6; color: #6B7280; }

    .action-content {
        flex: 1;
        min-width: 0;
    }

    .action-title {
        font-weight: 600;
        font-size: 0.9rem;
        color: #1f2937;
        margin-bottom: 2px;
    }

    .action-desc {
        font-size: 0.75rem;
        color: #9ca3af;
        margin: 0;
    }

    .action-arrow {
        color: #d1d5db;
        font-size: 0.75rem;
        transition: all 0.2s ease;
    }

    .action-item:hover .action-arrow {
        color: #4F46E5;
        transform: translateX(3px);
    }

    /* Info Class */
    .info-class-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        background: white;
        overflow: hidden;
    }

    .info-class-card .card-header {
        background: white;
        border-bottom: 1px solid #f0f0f0;
        padding: 1.25rem 1.5rem;
    }

    .info-class-card .card-header h6 {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.95rem;
    }

    .info-list {
        padding: 0.5rem 1.5rem 1.25rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.875rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .info-label-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .info-label-icon.bg-primary-soft { background: #EEF2FF; color: #4F46E5; }
    .info-label-icon.bg-success-soft { background: #ECFDF5; color: #10B981; }
    .info-label-icon.bg-info-soft { background: #EFF6FF; color: #3B82F6; }

    .info-value {
        font-weight: 700;
        font-size: 1rem;
        color: #1f2937;
        padding: 0.25rem 0.75rem;
        background: #f9fafb;
        border-radius: 8px;
        border: 1px solid #f3f4f6;
    }

    .info-value.text-success {
        color: #10B981 !important;
        background: #ECFDF5;
        border-color: #D1FAE5;
    }

    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header { padding: 1.25rem; }
        .dashboard-header h2 { font-size: 1.25rem; }
        .stat-icon { width: 45px; height: 45px; font-size: 18px; }
    }

    @media (max-width: 576px) {
        .action-item { padding: 0.75rem; gap: 0.75rem; }
        .action-icon { width: 38px; height: 38px; }
        .action-title { font-size: 0.85rem; }
        .action-desc { font-size: 0.7rem; }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="dashboard-header fade-in">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h2 class="mb-1">
                    <i class="fas fa-user-check me-2"></i> Halo, {{ Auth::user()->name ?? 'Wali Kelas' }}
                </h2>
                <p class="mb-0 opacity-75">Selamat datang di dashboard Buku Induk Sekolah</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-outline-gradient" style="cursor: pointer; pointer-events: auto; z-index: 100;">
                    <i class="fas fa-users me-2"></i> Kelola Siswa
                </a>
                <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="btn btn-gradient" style="cursor: pointer; pointer-events: auto; z-index: 100;">
                    <i class="fas fa-pen me-2"></i> Input Nilai
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Row - 4 card -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3 fade-in" style="animation-delay: 0.05s;">
            <div class="stat-card p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase">Total Siswa</span>
                        <h2 class="mb-0 mt-1 fw-bold">{{ number_format($total ?? 0) }}</h2>
                    </div>
                    <div class="stat-icon primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="mt-2 small text-muted">
                    <i class="fas fa-user-graduate me-1"></i> Di kelas Anda
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3 fade-in" style="animation-delay: 0.1s;">
            <div class="stat-card p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase">Kehadiran</span>
                        <h2 class="mb-0 mt-1 fw-bold">{{ $kehadiran['persentase_kehadiran'] ?? 0 }}<span class="fs-6">%</span></h2>
                    </div>
                    <div class="stat-icon success">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <div class="mt-2 small text-muted">
                    <i class="fas fa-chart-line me-1"></i> Bulan ini
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3 fade-in" style="animation-delay: 0.15s;">
            <div class="stat-card p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase">Laki-laki</span>
                        <h2 class="mb-0 mt-1 fw-bold">{{ $byGender['Laki-laki'] ?? 0 }}</h2>
                    </div>
                    <div class="stat-icon info">
                        <i class="fas fa-male"></i>
                    </div>
                </div>
                <div class="mt-2 small text-muted">
                    <i class="fas fa-percent me-1"></i> 
                    @php $totalGender = ($byGender['Laki-laki'] ?? 0) + ($byGender['Perempuan'] ?? 0); @endphp
                    @if($totalGender > 0) {{ round(($byGender['Laki-laki'] ?? 0) / $totalGender * 100) }}% @else 0% @endif dari total
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3 fade-in" style="animation-delay: 0.2s;">
            <div class="stat-card p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase">Perempuan</span>
                        <h2 class="mb-0 mt-1 fw-bold">{{ $byGender['Perempuan'] ?? 0 }}</h2>
                    </div>
                    <div class="stat-icon danger">
                        <i class="fas fa-female"></i>
                    </div>
                </div>
                <div class="mt-2 small text-muted">
                    <i class="fas fa-percent me-1"></i>
                    @if($totalGender > 0) {{ round(($byGender['Perempuan'] ?? 0) / $totalGender * 100) }}% @else 0% @endif dari total
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row - 2 chart seimbang -->
    <div class="row g-3 mb-4">
        <div class="col-md-5 col-lg-4 fade-in" style="animation-delay: 0.25s;">
            <div class="chart-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-venus-mars me-2 text-primary"></i> Distribusi Gender</h6>
                </div>
                <div class="card-body text-center py-3">
                    <canvas id="genderChart" style="max-width: 200px; max-height: 200px; margin: 0 auto;"></canvas>
                    <div class="mt-3 d-flex justify-content-center gap-3">
                        <div>
                            <span class="badge bg-primary px-3 py-2">
                                <i class="fas fa-male me-1"></i> {{ $byGender['Laki-laki'] ?? 0 }}
                            </span>
                        </div>
                        <div>
                            <span class="badge bg-danger px-3 py-2">
                                <i class="fas fa-female me-1"></i> {{ $byGender['Perempuan'] ?? 0 }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-lg-8 fade-in" style="animation-delay: 0.3s;">
            <div class="chart-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-clipboard-list me-2 text-success"></i> Statistik Kehadiran Bulan Ini</h6>
                </div>
                <div class="card-body">
                    <canvas id="kehadiranChart" style="max-height: 200px; width: 100%;"></canvas>
                    <div class="mt-3 d-flex justify-content-center gap-3 flex-wrap">
                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Hadir: {{ $kehadiran['hadir'] ?? 0 }}</span>
                        <span class="badge bg-warning text-dark"><i class="fas fa-thermometer-half me-1"></i> Sakit: {{ $kehadiran['sakit'] ?? 0 }}</span>
                        <span class="badge bg-info"><i class="fas fa-file-alt me-1"></i> Izin: {{ $kehadiran['izin'] ?? 0 }}</span>
                        <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Alpha: {{ $kehadiran['alpha'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nilai Chart Row -->
    <div class="row g-3 mb-4">
        <div class="col-12 fade-in" style="animation-delay: 0.35s;">
            <div class="chart-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-star me-2 text-warning"></i> Rata-rata Nilai per Mata Pelajaran</h6>
                </div>
                <div class="card-body">
                    @if(count($chartData->labels ?? []) > 0)
                        <canvas id="nilaiChart" style="max-height: 260px; width: 100%;"></canvas>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-chart-line fa-2x mb-2 opacity-50"></i>
                            <p class="mb-0">Belum ada data nilai untuk ditampilkan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Students & Quick Actions Row -->
    <div class="row g-3">
        <div class="col-lg-7 fade-in" style="animation-delay: 0.4s;">
            <div class="chart-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-user-graduate me-2 text-primary"></i> Siswa Terbaru</h6>
                    <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-sm btn-outline-gradient">
                        Lihat semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-3">
                    @if(!empty($recentGrouped) && $recentGrouped->count() > 0)
                        @foreach($recentGrouped as $rombel => $siswaList)
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-graduation-cap me-1"></i> {{ $rombel }}
                                    </small>
                                    <span class="badge bg-primary rounded-pill">{{ count($siswaList) }} siswa</span>
                                </div>
                                <div class="student-list">
                                    @foreach($siswaList->take(3) as $r)
                                        <div class="student-item d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-3">
                                                @if($r->foto)
                                                    <img src="{{ asset('storage/' . $r->foto) }}" class="student-avatar">
                                                @else
                                                    <div class="student-avatar-placeholder">
                                                        {{ strtoupper(substr($r->nama_lengkap, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $r->nama_lengkap }}</div>
                                                    <div class="small text-muted">NIS: {{ $r->nis ?? '-' }}</div>
                                                </div>
                                            </div>
                                            <a href="{{ route('walikelas.siswa.show', $r->id) }}" class="btn btn-sm btn-outline-gradient">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                    @if(count($siswaList) > 3)
                                        <div class="text-center mt-2">
                                            <small class="text-muted">+{{ count($siswaList) - 3 }} siswa lainnya</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-user-graduate fa-2x mb-2 opacity-50"></i>
                            <p class="mb-0">Belum ada siswa baru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5 fade-in" style="animation-delay: 0.45s;">
            <!-- Quick Actions Card -->
            <div class="quick-actions-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-bolt me-2 text-warning"></i> Aksi Cepat</h6>
                </div>
                <div class="action-list">
                    <a href="{{ route('walikelas.siswa.index') }}" class="action-item">
                        <div class="action-icon bg-primary-soft">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="action-content">
                            <div class="action-title">Kelola Siswa</div>
                            <p class="action-desc">Data dan profil siswa kelas Anda</p>
                        </div>
                        <i class="fas fa-chevron-right action-arrow"></i>
                    </a>

                    <a href="{{ route('walikelas.absensi.index') }}" class="action-item">
                        <div class="action-icon bg-success-soft">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="action-content">
                            <div class="action-title">Input Absensi</div>
                            <p class="action-desc">Catat kehadiran harian siswa</p>
                        </div>
                        <i class="fas fa-chevron-right action-arrow"></i>
                    </a>

                    <a href="{{ route('walikelas.absensi.rekap') }}" class="action-item">
                        <div class="action-icon bg-info-soft">
                            <i class="fas fa-chart-simple"></i>
                        </div>
                        <div class="action-content">
                            <div class="action-title">Rekap Absensi</div>
                            <p class="action-desc">Lihat rekapitulasi kehadiran</p>
                        </div>
                        <i class="fas fa-chevron-right action-arrow"></i>
                    </a>

                    <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="action-item">
                        <div class="action-icon bg-warning-soft">
                            <i class="fas fa-pen"></i>
                        </div>
                        <div class="action-content">
                            <div class="action-title">Input Nilai Raport</div>
                            <p class="action-desc">Masukkan nilai akademik siswa</p>
                        </div>
                        <i class="fas fa-chevron-right action-arrow"></i>
                    </a>

                    <a href="{{ route('walikelas.nilai_raport.index') }}" class="action-item">
                        <div class="action-icon bg-secondary-soft">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="action-content">
                            <div class="action-title">Lihat Nilai Raport</div>
                            <p class="action-desc">Rekap nilai raport siswa</p>
                        </div>
                        <i class="fas fa-chevron-right action-arrow"></i>
                    </a>
                </div>
            </div>

            <!-- Informasi Kelas Card -->
            <div class="info-class-card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2 text-info"></i> Informasi Kelas</h6>
                </div>
                <div class="info-list">
                    <div class="info-item">
                        <div class="info-label">
                            <div class="info-label-icon bg-primary-soft">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <span>Total Rombel</span>
                        </div>
                        <span class="info-value">{{ $recentGrouped->count() ?? 0 }}</span>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <div class="info-label-icon bg-info-soft">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <span>Total Siswa</span>
                        </div>
                        <span class="info-value">{{ $total ?? 0 }}</span>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <div class="info-label-icon bg-success-soft">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <span>Rata-rata Kehadiran</span>
                        </div>
                        <span class="info-value text-success">{{ $kehadiran['persentase_kehadiran'] ?? 0 }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gender Chart
    const genderCtx = document.getElementById('genderChart');
    if (genderCtx) {
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $byGender['Laki-laki'] ?? 0 }}, {{ $byGender['Perempuan'] ?? 0 }}],
                    backgroundColor: ['#667eea', '#f5576c'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                cutout: '65%'
            }
        });
    }

    // Kehadiran Chart
    const kehadiranCtx = document.getElementById('kehadiranChart');
    if (kehadiranCtx) {
        new Chart(kehadiranCtx, {
            type: 'bar',
            data: {
                labels: ['Hadir', 'Sakit', 'Izin', 'Alpha'],
                datasets: [{
                    data: [{{ $kehadiran['hadir'] ?? 0 }}, {{ $kehadiran['sakit'] ?? 0 }}, {{ $kehadiran['izin'] ?? 0 }}, {{ $kehadiran['alpha'] ?? 0 }}],
                    backgroundColor: ['#13B497', '#f6d365', '#4facfe', '#f5576c'],
                    borderRadius: 8,
                    barPercentage: 0.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { drawBorder: false }, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // Nilai Chart
    const nilaiLabels = @json($chartData->labels ?? []);
    const nilaiValues = @json($chartData->values ?? []);
    const nilaiCtx = document.getElementById('nilaiChart');
    if (nilaiCtx && nilaiLabels.length > 0) {
        new Chart(nilaiCtx, {
            type: 'bar',
            data: {
                labels: nilaiLabels,
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: nilaiValues,
                    backgroundColor: 'rgba(102, 126, 234, 0.7)',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: { beginAtZero: true, max: 100, title: { display: true, text: 'Nilai' } }
                }
            }
        });
    }
});
</script>
@endsection