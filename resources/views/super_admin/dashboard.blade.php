@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-crown text-warning"></i> Dashboard Super Admin
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        Selamat datang di Dashboard Super Admin. Anda memiliki akses penuh ke semua fitur sistem.
                    </div>

                    <!-- Statistik Utama -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title mb-0">{{ $totalUsers }}</h5>
                                            <small>Total Users</small>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-users fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title mb-0">{{ $totalSiswa }}</h5>
                                            <small>Total Siswa</small>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-user-graduate fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title mb-0">{{ $totalGuru }}</h5>
                                            <small>Total Guru</small>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title mb-0">{{ $totalSuperAdmin }}</h5>
                                            <small>Super Admin</small>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-crown fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Role -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Distribusi Role Pengguna</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($roleStats as $role => $count)
                                        <div class="col-md-3 mb-3">
                                            <div class="card border">
                                                <div class="card-body text-center">
                                                    <h6 class="text-muted">{{ ucfirst(str_replace('_', ' ', $role)) }}</h6>
                                                    <h4 class="mb-0">{{ $count }}</h4>
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
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Aktivitas Sistem Terbaru</h5>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        @foreach($aktivitas as $item)
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-{{ $item['tipe'] == 'system' ? 'info' : 'primary' }}"></div>
                                            <div class="timeline-content">
                                                <h6 class="timeline-title">{{ $item['nama'] }}</h6>
                                                <p class="timeline-text">{{ $item['aktivitas'] }}</p>
                                                <small class="text-muted">{{ $item['waktu'] }}</small>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Menu Cepat</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('super_admin.users.index') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-users"></i> Kelola Users
                                        </a>
                                        <a href="{{ route('super_admin.system.index') }}" class="btn btn-outline-info">
                                            <i class="fas fa-cogs"></i> Sistem
                                        </a>
                                        <button class="btn btn-outline-success" onclick="backupDatabase()">
                                            <i class="fas fa-database"></i> Backup Database
                                        </button>
                                        <button class="btn btn-outline-warning" onclick="clearLogs()">
                                            <i class="fas fa-trash"></i> Bersihkan Log
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
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
}

.timeline-title {
    margin-bottom: 5px;
    font-weight: bold;
}

.timeline-text {
    margin-bottom: 5px;
    color: #6c757d;
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