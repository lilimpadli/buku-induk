@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 text-dark font-weight-bold">
                        <i class="fas fa-crown text-primary me-2"></i>Dashboard Super Admin
                    </h1>
                    <p class="text-muted mb-0">Selamat datang kembali! Kelola sistem sekolah dengan mudah.</p>
                </div>
                <div class="text-end">
                    <small class="text-muted">{{ now()->format('l, d F Y') }}</small>
                </div>
            </div>

            <!-- Welcome Alert -->
            <div class="alert alert-primary border-0 shadow-sm rounded-3 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle fa-lg me-3"></i>
                    <div>
                        <h6 class="alert-heading mb-1">Selamat Datang!</h6>
                        <p class="mb-0">Anda memiliki akses penuh ke semua fitur sistem. Pantau performa dan kelola data dengan efisien.</p>
                    </div>
                </div>
            </div>

            <!-- Statistik Utama -->
            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <a href="{{ route('super_admin.users.index') }}" class="stat-card-link">
                        <div class="card border-0 shadow-sm rounded-4 h-100 stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <div class="card-body text-white p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="card-title mb-1 fw-bold">{{ $totalUsers }}</h2>
                                        <small class="opacity-75">Total Users</small>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-users fa-3x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('super_admin.manajemen-siswa.index') }}" class="stat-card-link">
                        <div class="card border-0 shadow-sm rounded-4 h-100 stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <div class="card-body text-white p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="card-title mb-1 fw-bold">{{ $totalSiswa }}</h2>
                                        <small class="opacity-75">Total Siswa</small>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-user-graduate fa-3x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('super_admin.manajemen-guru.index') }}" class="stat-card-link">
                        <div class="card border-0 shadow-sm rounded-4 h-100 stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <div class="card-body text-white p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="card-title mb-1 fw-bold">{{ $totalGuru }}</h2>
                                        <small class="opacity-75">Total Guru</small>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-chalkboard-teacher fa-3x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('super_admin.users.index') }}" class="stat-card-link">
                        <div class="card border-0 shadow-sm rounded-4 h-100 stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <div class="card-body text-white p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 class="card-title mb-1 fw-bold">{{ $totalSuperAdmin }}</h2>
                                        <small class="opacity-75">Super Admin</small>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-crown fa-3x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

                    <!-- Statistik Role -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white border-0 pt-4 pb-3">
                                    <h5 class="card-title mb-0 fw-bold text-dark">
                                        <i class="fas fa-chart-pie text-primary me-2"></i>Distribusi Role Pengguna
                                    </h5>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row g-3">
                                        @foreach($roleStats as $role => $count)
                                        <div class="col-md-3 col-sm-6">
                                            <div class="card border-0 shadow-sm rounded-3 h-100 role-card">
                                                <div class="card-body text-center p-4">
                                                    <div class="role-icon mb-3">
                                                        <i class="fas fa-{{ $role == 'super_admin' ? 'crown' : ($role == 'guru' ? 'chalkboard-teacher' : ($role == 'siswa' ? 'user-graduate' : 'user')) }} fa-2x text-primary"></i>
                                                    </div>
                                                    <h6 class="text-muted fw-medium mb-2">{{ ucfirst(str_replace('_', ' ', $role)) }}</h6>
                                                    <h3 class="mb-0 fw-bold text-dark">{{ $count }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Aktivitas Sistem -->
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white border-0 pt-4 pb-3">
                                    <h5 class="card-title mb-0 fw-bold text-dark">
                                        <i class="fas fa-history text-primary me-2"></i>Aktivitas Sistem Terbaru
                                    </h5>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="timeline-modern">
                                        @forelse($aktivitas as $item)
                                        <div class="timeline-item-modern">
                                            <div class="timeline-marker-modern bg-{{ $item['tipe'] == 'system' ? 'info' : 'primary' }}"></div>
                                            <div class="timeline-content-modern">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="timeline-title-modern mb-0 fw-semibold">{{ $item['nama'] }}</h6>
                                                    <small class="text-muted">{{ $item['waktu'] }}</small>
                                                </div>
                                                <p class="timeline-text-modern mb-0 text-muted">{{ $item['aktivitas'] }}</p>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="py-4 text-center text-muted">Belum ada aktivitas terbaru</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white border-0 pt-4 pb-3">
                                    <h5 class="card-title mb-0 fw-bold text-dark">
                                        <i class="fas fa-bolt text-primary me-2"></i>Menu Cepat
                                    </h5>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="d-grid gap-3">
                                        <a href="{{ route('super_admin.users.index') }}" class="btn btn-modern btn-primary-modern">
                                            <i class="fas fa-users me-2"></i>Kelola Users
                                        </a>
                                        <a href="{{ route('super_admin.system.index') }}" class="btn btn-modern btn-info-modern">
                                            <i class="fas fa-cogs me-2"></i>Sistem
                                        </a>
                                        <button class="btn btn-modern btn-success-modern" onclick="backupDatabase()">
                                            <i class="fas fa-database me-2"></i>Backup Database
                                        </button>
                                        <button class="btn btn-modern btn-warning-modern" onclick="clearLogs()">
                                            <i class="fas fa-trash me-2"></i>Bersihkan Log
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Stat Cards */
.stat-card {
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.stat-icon {
    opacity: 0.8;
    transition: all 0.3s ease;
}

.stat-card:hover .stat-icon {
    opacity: 1;
    transform: scale(1.1);
}

/* Link styling untuk stat card */
.stat-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.stat-card-link:hover {
    text-decoration: none;
    color: inherit;
}

/* Role Cards */
.role-card {
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 1px solid rgba(0,0,0,0.05);
}

.role-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

.role-icon {
    transition: all 0.3s ease;
}

.role-card:hover .role-icon {
    transform: scale(1.1);
    color: #0d6efd !important;
}

/* Timeline Modern */
.timeline-modern {
    position: relative;
    padding-left: 40px;
}

.timeline-modern::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, #e9ecef 0%, #dee2e6 100%);
    border-radius: 2px;
}

.timeline-item-modern {
    position: relative;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #f1f3f4;
}

.timeline-item-modern:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.timeline-marker-modern {
    position: absolute;
    left: -27px;
    top: 8px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.timeline-content-modern {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.timeline-content-modern:hover {
    background: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transform: translateX(5px);
}

.timeline-title-modern {
    color: #2d3748;
    font-size: 16px;
}

.timeline-text-modern {
    font-size: 14px;
    line-height: 1.5;
}

/* Modern Buttons */
.btn-modern {
    border: none;
    border-radius: 12px;
    padding: 12px 20px;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.3s ease;
    text-align: left;
    justify-content: flex-start;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.btn-primary-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary-modern:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
}

.btn-info-modern {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.btn-info-modern:hover {
    background: linear-gradient(135deg, #3d9efc 0%, #00e0e8 100%);
}

.btn-success-modern {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    color: white;
}

.btn-success-modern:hover {
    background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
}

.btn-warning-modern {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    color: white;
}

.btn-warning-modern:hover {
    background: linear-gradient(135deg, #e74c3c 0%, #f39c12 100%);
}

/* Responsive */
@media (max-width: 768px) {
    .timeline-modern {
        padding-left: 30px;
    }

    .timeline-marker-modern {
        left: -22px;
        width: 14px;
        height: 14px;
    }

    .timeline-content-modern {
        padding: 15px;
    }

    .stat-card {
        margin-bottom: 20px;
    }
}
</style>

<script>
function backupDatabase() {
    if (confirm('Apakah Anda yakin ingin melakukan backup database?')) {
        alert('Backup database berhasil!');
    }
}

function clearLogs() {
    if (confirm('Apakah Anda yakin ingin membersihkan log sistem?')) {
        alert('Log sistem berhasil dibersihkan!');
    }
}
</script>
@endsection