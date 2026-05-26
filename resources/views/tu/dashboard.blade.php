@extends('layouts.app')

@section('title', 'Dashboard Tata Usaha')

@section('content')

<style>
    /* ===================== DASHBOARD STYLES ===================== */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --danger-gradient: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --text-primary: #283046;
        --text-secondary: #67748a;
        --bg-light: #f8fafc;
        --bg-card: #ffffff;
        --border-radius: 16px;
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--text-primary);
    }

    /* Header */
    .dashboard-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2.5rem 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.25);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .dashboard-header::after {
        content: "";
        position: absolute;
        bottom: -30px;
        left: -30px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .dashboard-header h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .dashboard-header .text-muted {
        color: rgba(255, 255, 255, 0.9) !important;
        font-size: 1rem;
        position: relative;
        z-index: 1;
    }

    /* Stat Cards */
    .stat-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        background: var(--bg-card);
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .stat-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
    }

    .stat-card.primary::before { background: var(--primary-gradient); }
    .stat-card.success::before { background: var(--success-gradient); }
    .stat-card.info::before { background: var(--info-gradient); }
    .stat-card.warning::before { background: var(--warning-gradient); }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .stat-icon.primary { background: var(--primary-gradient); }
    .stat-icon.success { background: var(--success-gradient); }
    .stat-icon.info { background: var(--info-gradient); }
    .stat-icon.warning { background: var(--warning-gradient); }

    .stat-title {
        font-size: 0.875rem;
        color: var(--text-secondary);
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .stat-value {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
    }

    /* Student Items */
    .student-item {
        border: none;
        border-radius: 12px;
        margin-bottom: 1rem;
        padding: 1.25rem;
        transition: var(--transition);
        background: var(--bg-card);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .student-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        background: #f8fafc;
    }

    .student-left {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
    }

    .student-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .student-avatar-placeholder {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
        font-size: 18px;
        background: var(--primary-gradient);
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .student-name {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .student-info {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    /* Buttons */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-outline-custom {
        background: transparent;
        border: 2px solid #e2e8f0;
        color: var(--text-primary);
        font-weight: 600;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    .btn-outline-custom:hover {
        background: #f1f5f9;
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Section Title */
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title::before {
        content: "";
        width: 4px;
        height: 24px;
        background: var(--primary-gradient);
        border-radius: 2px;
    }

    /* Tables */
    .custom-table {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background: var(--bg-card);
    }

    .custom-table thead {
        background-color: #f8fafc;
    }

    .custom-table th {
        font-weight: 600;
        color: var(--text-primary);
        border-bottom: 2px solid #e2e8f0;
        padding: 1rem;
        font-size: 0.875rem;
    }

    .custom-table td {
        vertical-align: middle;
        padding: 1rem;
        font-size: 0.875rem;
    }

    .custom-table tbody tr {
        transition: var(--transition);
    }

    .custom-table tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Quick Actions */
    .quick-actions-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        background: var(--bg-card);
    }

    .action-btn {
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        min-height: 80px;
        text-decoration: none;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    }

    .action-btn i {
        font-size: 1.5rem;
    }

    .action-btn.primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .action-btn.info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
    .action-btn.success { background: linear-gradient(135deg, #13B497 0%, #59D4A4 100%); color: white; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
        display: block;
    }

    .empty-state p {
        color: var(--text-secondary);
        font-weight: 500;
        margin: 0;
        font-size: 1rem;
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
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .student-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .student-left {
            width: 100%;
        }

        .action-btn {
            min-height: 70px;
            padding: 1rem;
        }
    }
</style>

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="dashboard-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="mb-1">Dashboard TU KESISWAAN 👋</h2>
                <div class="text-muted">Kelola data siswa, wali kelas, dan kelas — cepat, informatif, dan responsif</div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-light btn-sm" style="border-radius: 8px; font-weight: 500;">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>

    <!-- STATISTIK -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card primary">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="stat-title">Total Siswa</div>
                            <div class="stat-value">{{ number_format($totalSiswa ?? 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card success">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon success">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div>
                            <div class="stat-title">Wali Kelas</div>
                            <div class="stat-value">{{ number_format($totalWaliKelas ?? 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card info">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon info">
                            <i class="fas fa-school"></i>
                        </div>
                        <div>
                            <div class="stat-title">Total Kelas</div>
                            <div class="stat-value">{{ number_format($totalKelas ?? 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card warning">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon warning">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="stat-title">Nilai Terinput</div>
                            <div class="stat-value">{{ number_format($totalNilai ?? 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="row g-4">
        <!-- SISWA TERBARU -->
        <div class="col-xl-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="section-title">Siswa Terbaru</div>
                        <a href="{{ route('tu.siswa.index') }}" class="btn-outline-custom">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    @if(!empty($siswaBaru) && $siswaBaru->count() > 0)
                        @foreach($siswaBaru as $siswa)
                            <div class="student-item">
                                <div class="student-left">
                                    @if($siswa->foto)
                                        <div class="student-avatar">
                                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                                        </div>
                                    @else
                                        <div class="student-avatar-placeholder">
                                            {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="student-name">{{ $siswa->nama_lengkap }}</div>
                                        <div class="student-info">
                                            NIS: {{ $siswa->nis ?? '-' }} • {{ $siswa->kelas ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('tu.siswa.detail', $siswa->id) }}" class="btn-gradient">
                                    Detail
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-user-graduate"></i>
                            <p>Belum ada siswa terbaru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- RINGKASAN KELAS -->
        <div class="col-xl-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="section-title">Ringkasan Kelas</div>
                        <a href="{{ route('tu.kelas.index') }}" class="btn-outline-custom">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    @if(!empty($kelasLimit) && $kelasLimit->count() > 0)
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>Tingkat</th>
                                        <th>Jurusan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelasLimit as $k)
                                        <tr>
                                            <td>{{ $k->tingkat }}</td>
                                            <td>{{ $k->jurusan->nama ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-school"></i>
                            <p>Belum ada data kelas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>   

       
    

</div>

@endsection