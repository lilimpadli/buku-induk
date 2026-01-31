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

    /* Table Styles */
    .custom-table {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .custom-table thead {
        background-color: #f8f9fa;
    }

    .custom-table th {
        font-weight: 600;
        color: var(--text-primary);
        border-bottom: 2px solid #e9ecef;
    }

    .custom-table td {
        vertical-align: middle;
    }

    .custom-table tbody tr {
        transition: var(--transition);
    }

    .custom-table tbody tr:hover {
        background-color: #f8f9fa;
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
                <h2 class="mb-1">Dashboard Tata Usaha 👋</h2>
                <div class="text-muted">Kelola data siswa, wali kelas, dan kelas — cepat, informatif, dan responsif</div>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay: 0.1s;">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon primary me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Siswa</div>
                            <div class="h4 mb-0">{{ number_format($totalSiswa ?? 0) }}</div>
                        </div>
                    </div>
                    <div class="mt-3 small text-muted">Jumlah siswa aktif di sekolah</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay: 0.2s;">
            <div class="card stat-card success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon success me-3">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Wali Kelas</div>
                            <div class="h4 mb-0">{{ number_format($totalWaliKelas ?? 0) }}</div>
                        </div>
                    </div>
                    <div class="mt-3 small text-muted">Jumlah wali kelas aktif</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay: 0.3s;">
            <div class="card stat-card info h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon info me-3">
                            <i class="fas fa-school"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Kelas</div>
                            <div class="h4 mb-0">{{ number_format($totalKelas ?? 0) }}</div>
                        </div>
                    </div>
                    <div class="mt-3 small text-muted">Jumlah kelas di sekolah</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay: 0.4s;">
            <div class="card stat-card warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon warning me-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Nilai Terinput</div>
                            <div class="h4 mb-0">{{ number_format($totalNilai ?? 0) }}</div>
                        </div>
                    </div>
                    <div class="mt-3 small text-muted">Total nilai yang telah diinput</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Siswa Baru -->
        <div class="col-xl-6 fade-in" style="animation-delay: 0.5s;">
            <div class="card shadow-sm h-100" style="border-radius: var(--border-radius);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">Siswa Terbaru</h5>
                        <a href="{{ route('tu.siswa.index') }}" class="btn btn-sm btn-outline-gradient">Lihat semua</a>
                    </div>

                    @if(!empty($siswaBaru) && $siswaBaru->count() > 0)
                        <div class="student-list">
                            @foreach($siswaBaru as $siswa)
                                <div class="student-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($siswa->foto)
                                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="" class="student-avatar">
                                        @else
                                            <div class="student-avatar-placeholder" style="background: var(--primary-gradient);">
                                                {{ strtoupper(substr($siswa->nama_lengkap,0,1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight:600;">{{ $siswa->nama_lengkap }}</div>
                                            <div class="small text-muted">NIS: {{ $siswa->nis ?? '-' }} • {{ $siswa->kelas ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('tu.siswa.detail', $siswa->id) }}" class="btn btn-sm btn-outline-gradient">Detail</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-user-graduate fa-3x mb-3"></i>
                            <p>Belum ada siswa baru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Siswa PPDB Terbaru -->
        <div class="col-xl-6 fade-in" style="animation-delay: 0.6s;">
            <div class="card shadow-sm h-100" style="border-radius: var(--border-radius);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">Siswa PPDB Terbaru</h5>
                        <a href="{{ route('tu.ppdb.index') }}" class="btn btn-sm btn-outline-gradient">Lihat semua</a>
                    </div>

                    @if(!empty($ppdbTerbaru) && $ppdbTerbaru->count() > 0)
                        <div class="student-list">
                            @foreach($ppdbTerbaru as $p)
                                <div class="student-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="student-avatar-placeholder" style="background: var(--success-gradient);">
                                            {{ strtoupper(substr($p->nama_lengkap,0,1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight:600;">{{ $p->nama_lengkap }}</div>
                                            <div class="small text-muted">Jurusan: {{ optional($p->jurusan)->nama ?? '-' }} • Status: {{ ucfirst($p->status ?? '-') }}</div>
                                        </div>
                                    </div>
                                    <div>
                                        @if($p->status == 'pending')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($p->status == 'diterima')
                                            <span class="badge bg-success">Diterima</span>
                                        @elseif($p->status == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($p->status ?? '-') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-user-plus fa-3x mb-3"></i>
                            <p>Belum ada pendaftar PPDB baru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ringkasan Wali Kelas -->
        <div class="col-xl-6 fade-in" style="animation-delay: 0.7s;">
            <div class="card shadow-sm h-100" style="border-radius: var(--border-radius);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">Ringkasan Wali Kelas</h5>
                        <a href="{{ route('tu.wali-kelas') }}" class="btn btn-sm btn-outline-gradient">Lihat semua</a>
                    </div>

                    @if(!empty($waliKelasLimit) && $waliKelasLimit->count() > 0)
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Nomor Induk</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($waliKelasLimit as $wk)
                                        <tr>
                                            <td>{{ $wk->name }}</td>
                                            <td>{{ $wk->nomor_induk }}</td>
                                            <td>{{ $wk->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-chalkboard-teacher fa-3x mb-3"></i>
                            <p>Belum ada data wali kelas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ringkasan Kelas -->
        <div class="col-xl-6 fade-in" style="animation-delay: 0.8s;">
            <div class="card shadow-sm h-100" style="border-radius: var(--border-radius);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">Ringkasan Kelas</h5>
                        <a href="{{ route('tu.kelas.index') }}" class="btn btn-sm btn-outline-gradient">Lihat semua</a>
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
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-school fa-3x mb-3"></i>
                            <p>Belum ada data kelas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Card -->
    <div class="row mt-4">
        <div class="col-12 fade-in" style="animation-delay: 0.9s;">
            <div class="card quick-actions-card">
                <div class="card-body">
                    <h5 class="mb-4">Aksi Cepat</h5>
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <a href="{{ route('tu.siswa.index') }}" class="btn action-btn btn-outline-primary w-100">
                                <i class="fas fa-users"></i> Kelola Siswa
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('tu.wali-kelas') }}" class="btn action-btn btn-outline-success w-100">
                                <i class="fas fa-chalkboard-teacher"></i> Kelola Wali Kelas
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('tu.kelas.index') }}" class="btn action-btn btn-outline-info w-100">
                                <i class="fas fa-school"></i> Kelola Kelas
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('tu.ppdb.index') }}" class="btn action-btn btn-gradient w-100">
                                <i class="fas fa-user-plus"></i> Kelola PPDB
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection