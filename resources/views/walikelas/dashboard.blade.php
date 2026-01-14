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
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --dark-gradient: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
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
    .stat-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        height: 100%;
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

    .stat-card.warning::before {
        background: var(--warning-gradient);
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

    .stat-icon.warning {
        background: var(--warning-gradient);
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
        border: 2px solid;
        border-image: var(--primary-gradient) 1;
        color: #667eea;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        transform: translateY(-2px);
    }

    /* List Group Styles */
    .student-list {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .student-item {
        border: none;
        border-radius: 12px !important;
        margin-bottom: 12px;
        padding: 16px;
        transition: var(--transition);
        background-color: white;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .student-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .student-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f0f4f8;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .student-avatar-placeholder {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
        font-size: 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    /* Progress Bar Styles */
    .progress {
        height: 10px;
        border-radius: 10px;
        overflow: hidden;
        background-color: #e9ecef;
    }

    .progress-bar {
        transition: width 1s ease-in-out;
    }

    /* Quick Actions Card */
    .quick-actions-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }

    .quick-actions-card .card-body {
        padding: 1.5rem;
    }

    .action-btn {
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 10px;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Summary Card */
    .summary-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }

    .summary-item {
        text-align: center;
        padding: 1rem 0;
    }

    .summary-number {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem 1rem;
        }
        
        .dashboard-header h2 {
            font-size: 1.5rem;
        }
        
        .stat-icon {
            width: 56px;
            height: 56px;
            font-size: 20px;
        }
        
        .student-avatar, .student-avatar-placeholder {
            width: 48px;
            height: 48px;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="dashboard-header fade-in">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2 class="mb-1">Halo, Wali Kelas 👋</h2>
                <div class="text-muted">Ringkasan kelas dan siswa — cepat, informatif, dan responsif</div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-outline-gradient">Kelola Siswa</a>
                <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="btn btn-gradient">Input Nilai</a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6 col-md-6 fade-in" style="animation-delay: 0.1s;">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon primary me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Siswa</div>
                            <div class="h4 mb-0">{{ number_format($total ?? 0) }}</div>
                        </div>
                    </div>
                    <div class="mt-3 small text-muted">Jumlah siswa aktif di rombel Anda</div>
                    <div class="mt-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-arrow-up text-success me-1"></i>
                            <span class="text-success small">12% dari bulan lalu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 fade-in" style="animation-delay: 0.2s;">
            <div class="card stat-card danger h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon danger me-3">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Rasio Jenis Kelamin</div>
                            @php
                                $male = $byGender['Laki-laki'] ?? 0;
                                $female = $byGender['Perempuan'] ?? 0;
                                $sum = max(1, $male + $female);
                                $malePct = round($male / $sum * 100);
                                $femalePct = 100 - $malePct;
                            @endphp
                            <div class="h5 mb-0">{{ $malePct }}% / {{ $femalePct }}%</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress" style="height:10px;border-radius:8px;overflow:hidden;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $malePct }}%"></div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $femalePct }}%"></div>
                        </div>
                        <div class="mt-2 d-flex justify-content-between">
                            <span class="small text-muted"><i class="fas fa-male text-primary me-1"></i> {{ $male ?? 0 }} L</span>
                            <span class="small text-muted"><i class="fas fa-female text-danger me-1"></i> {{ $female ?? 0 }} P</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <div class="col-xl-8 fade-in" style="animation-delay: 0.5s;">
            <div class="card shadow-sm h-100" style="border-radius: var(--border-radius);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">Siswa Terbaru</h5>
                        <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-sm btn-outline-gradient">Lihat semua</a>
                    </div>

                    @if(!empty($recentGrouped) && $recentGrouped->count() > 0)
                        @foreach($recentGrouped as $rombel => $siswaList)
                            <div class="mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div style="font-weight:600;color:#374151; display: flex; align-items: center;">
                                        <i class="fas fa-graduation-cap me-2 text-primary"></i>
                                        {{ $rombel }}
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ count($siswaList) }} siswa</span>
                                </div>
                                <div class="student-list">
                                    @foreach($siswaList as $r)
                                        <div class="student-item d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-3">
                                                @if($r->foto)
                                                    <img src="{{ asset('storage/' . $r->foto) }}" alt="" class="student-avatar">
                                                @else
                                                    <div class="student-avatar-placeholder" style="background: var(--primary-gradient);">
                                                        {{ strtoupper(substr($r->nama_lengkap,0,1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <div style="font-weight:600;">{{ $r->nama_lengkap }}</div>
                                                    <div class="small text-muted">NIS: {{ $r->nis ?? '-' }} • {{ $r->created_at ? $r->created_at->format('Y-m-d') : '-' }}</div>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('walikelas.siswa.show', $r->id) }}" class="btn btn-sm btn-outline-gradient">Detail</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-user-graduate fa-3x mb-3"></i>
                            <p>Belum ada siswa baru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <!-- Quick Actions Card -->
            <div class="card quick-actions-card mb-4 fade-in" style="animation-delay: 0.6s;">
                <div class="card-body">
                    <h5 class="mb-4">Aksi Cepat</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('walikelas.siswa.index') }}" class="btn action-btn btn-outline-primary">
                            <i class="fas fa-users"></i> Kelola Siswa
                        </a>
                        <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="btn action-btn btn-gradient">
                            <i class="fas fa-pen"></i> Input Nilai Raport
                        </a>
                        <a href="{{ route('walikelas.nilai_raport.index') }}" class="btn action-btn btn-outline-success">
                            <i class="fas fa-chart-bar"></i> Lihat Nilai
                        </a>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="announcement-section">
                        <h6 class="mb-3 d-flex align-items-center">
                            <i class="fas fa-bullhorn me-2 text-warning"></i> Pengumuman
                        </h6>
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>Deadline input nilai raport semester genap: 30 Juni 2023</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Summary Card -->
            <div class="card summary-card fade-in" style="animation-delay: 0.7s;">
                <div class="card-body">
                    <h6 class="mb-4 d-flex align-items-center">
                        <i class="fas fa-chart-pie me-2 text-primary"></i> Ringkasan Rombel
                    </h6>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="summary-item">
                            <div class="summary-number">{{ number_format($total ?? 0) }}</div>
                            <div class="small text-muted">Total siswa</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-number text-primary">{{ $male ?? 0 }}</div>
                            <div class="small text-muted"><i class="fas fa-male"></i> Laki-laki</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-number text-danger">{{ $female ?? 0 }}</div>
                            <div class="small text-muted"><i class="fas fa-female"></i> Perempuan</div>
                        </div>
                    </div>
                    
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $malePct ?? 50 }}%"></div>
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $femalePct ?? 50 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection