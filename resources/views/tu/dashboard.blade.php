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
        --bg-light: #eef3fb;
        --border-radius: 20px;
        --card-shadow: 0 18px 40px rgba(35, 60, 110, 0.08);
        --card-hover-shadow: 0 22px 50px rgba(35, 60, 110, 0.12);
        --transition: all 0.25s ease;
    }

    body{
        background:var(--bg);
        font-family:'Segoe UI',sans-serif;
        color:var(--text);
    }

    .dashboard-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.92), rgba(118, 75, 162, 0.95));
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
        top: -40px;
        right: -40px;
        width: 260px;
        height: 260px;
        background: rgba(255, 255, 255, 0.12);
        border-radius: 50%;
    }

    .dashboard-header::after {
        content: "";
        position: absolute;
        bottom: -30px;
        left: -20px;
        width: 180px;
        height: 180px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .dashboard-header h2{
        font-size:30px;
        font-weight:700;
        margin-bottom:6px;
        position:relative;
        z-index:2;
    }

    .dashboard-header .text-muted {
        color: rgba(255, 255, 255, 0.85) !important;
        position: relative;
        z-index: 1;
    }

    .stat-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        min-height: 190px;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-hover-shadow);
    }

    .stat-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 7px;
        background: var(--primary-gradient);
    }

    .stat-card.success::before { background: var(--success-gradient); }
    .stat-card.danger::before { background: var(--danger-gradient); }
    .stat-card.info::before { background: var(--info-gradient); }
    .stat-card.warning::before { background: var(--warning-gradient); }

    .card-body {
        padding: 1.5rem;
    }

    .stat-icon {
        width: 62px;
        height: 62px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
        box-shadow: 0 15px 30px rgba(102, 126, 234, 0.16);
        transition: var(--transition);
    }

    .stat-card:hover .stat-icon { transform: translateY(-2px) scale(1.05); }

    .stat-icon.primary { background: var(--primary-gradient); }
    .stat-icon.success { background: var(--success-gradient); }
    .stat-icon.danger { background: var(--danger-gradient); }
    .stat-icon.info { background: var(--info-gradient); }
    .stat-icon.warning { background: var(--warning-gradient); }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.2rem;
        border-radius: 12px;
        transition: var(--transition);
        box-shadow: 0 10px 24px rgba(102, 126, 234, 0.22);
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(102, 126, 234, 0.28);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 2px solid transparent;
        border-image: var(--primary-gradient) 1;
        color: #4f6ad5;
        font-weight: 600;
        padding: 0.75rem 1.2rem;
        border-radius: 12px;
        transition: var(--transition);
    }

    .student-item:hover{
        background:#FAFBFF;
    }

    .student-list {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
        background: #ffffff;
    }

    .student-item {
        border: none;
        border-radius: 16px !important;
        margin-bottom: 14px;
        padding: 18px;
        transition: var(--transition);
        background-color: #ffffff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
    }

    .student-item:last-child { margin-bottom: 0; }

    .student-item:hover {
        transform: translateX(4px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    }

    .student-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #eef3fb;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
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
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }

    .custom-table {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.04);
        background: #ffffff;
    }

    .custom-table thead { background-color: #f6f8fb; }
    .custom-table th {
        font-weight: 700;
        color: #3b4a6b;
        border-bottom: 2px solid #eaeff7;
    }

    .custom-table td { vertical-align: middle; }
    .custom-table tbody tr {
        transition: var(--transition);
    }

    .custom-table tbody tr:hover { background-color: #f2f6ff; }

    .quick-actions-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        background: #ffffff;
    }

    .quick-actions-card .card-body { padding: 1.75rem; }

    .action-btn {
        border-radius: 16px;
        padding: 14px 18px;
        margin-bottom: 10px;
        font-weight: 700;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 62px;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
    }

    .badge {
        font-weight: 600;
        letter-spacing: 0.02em;
        padding: 0.55em 0.8em;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in { animation: fadeIn 0.55s ease-out; }

    @media (max-width: 992px) {
        .dashboard-header { padding: 1.5rem 1.25rem; }
        .stat-card { min-height: 170px; }
    }

    @media (max-width: 768px) {
        .dashboard-header h2 { font-size: 1.5rem; }
        .stat-icon { width: 52px; height: 52px; font-size: 20px; }
        .student-avatar, .student-avatar-placeholder { width: 48px; height: 48px; }
        .action-btn { min-height: 56px; padding: 12px 14px; }
        .card-body { padding: 1.25rem; }
    }
</style>

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="dashboard-header">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h2 class="mb-1">Dashboard TU KESISWAAN  👋</h2>
                <div class="text-muted">Kelola data siswa, wali kelas, dan kelas — cepat, informatif, dan responsif</div>
            </div>
            <div class="d-flex gap-2">

        </div>

    </div>

    <!-- STATISTIK -->
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card dashboard-card stat-card">

                <div class="card-body">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon bg-primary-gradient">
                            <i class="fas fa-users"></i>
                        </div>

                        <div>
                            <div class="stat-title">Total Siswa</div>

                            <div class="stat-value">
                                {{ number_format($totalSiswa ?? 0) }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card dashboard-card stat-card">

                <div class="card-body">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon bg-success-gradient">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>

                        <div>
                            <div class="stat-title">Wali Kelas</div>

                            <div class="stat-value">
                                {{ number_format($totalWaliKelas ?? 0) }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card dashboard-card stat-card">

                <div class="card-body">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon bg-info-gradient">
                            <i class="fas fa-school"></i>
                        </div>

                        <div>
                            <div class="stat-title">Total Kelas</div>

                            <div class="stat-value">
                                {{ number_format($totalKelas ?? 0) }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card dashboard-card stat-card">

                <div class="card-body">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon bg-warning-gradient">
                            <i class="fas fa-chart-line"></i>
                        </div>

                        <div>
                            <div class="stat-title">Nilai Terinput</div>

                            <div class="stat-value">
                                {{ number_format($totalNilai ?? 0) }}
                            </div>
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

            <div class="card dashboard-card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div class="section-title">
                            Siswa Terbaru
                        </div>

                        <a href="{{ route('tu.siswa.index') }}"
                        class="btn-outline-custom">
                            Lihat Semua
                        </a>

                    </div>

                    @if(!empty($siswaBaru) && $siswaBaru->count() > 0)

                        @foreach($siswaBaru as $siswa)

                            <div class="student-item">

                                <div class="student-left">

                                    @if($siswa->foto)

                                        <div class="student-avatar">
                                            <img src="{{ asset('storage/' . $siswa->foto) }}">
                                        </div>

                                    @else

                                        <div class="student-avatar">
                                            {{ strtoupper(substr($siswa->nama_lengkap,0,1)) }}
                                        </div>

                                    @endif

                                    <div>

                                        <div class="student-name">
                                            {{ $siswa->nama_lengkap }}
                                        </div>

                                        <div class="student-info">
                                            NIS : {{ $siswa->nis ?? '-' }}
                                            •
                                            {{ $siswa->kelas ?? '-' }}
                                        </div>

                                    </div>

                                </div>

                                <a href="{{ route('tu.siswa.detail', $siswa->id) }}"
                                class="btn-primary-custom">
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

            <div class="card dashboard-card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div class="section-title">
                            Ringkasan Kelas
                        </div>

                        <a href="{{ route('tu.kelas.index') }}"
                        class="btn-outline-custom">
                            Lihat Semua
                        </a>

                    </div>

                    @if(!empty($kelasLimit) && $kelasLimit->count() > 0)

                        <div class="table-responsive">

                            <table class="table">

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

        <!-- RINGKASAN WALI KELAS -->
        <div class="col-12">

            <div class="card dashboard-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div class="section-title">
                            Ringkasan Wali Kelas
                        </div>

                        <a href="{{ route('tu.wali-kelas') }}"
                        class="btn-outline-custom">
                            Lihat Semua
                        </a>

                    </div>

                    @if(!empty($waliKelasLimit) && $waliKelasLimit->count() > 0)

                        <div class="table-responsive">

                            <table class="table">

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

                        <div class="empty-state">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <p>Belum ada data wali kelas.</p>
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

    <!-- QUICK ACTION -->
    <div class="row mt-4">

        <div class="col-12">

            <div class="card dashboard-card">

                <div class="card-body">

                    <div class="section-title mb-4">
                        Aksi Cepat
                    </div>

                    <div class="row g-3">

                        <div class="col-lg-4 col-md-6">

                            <a href="{{ route('tu.siswa.index') }}"
                            class="quick-btn btn btn-outline-primary w-100">

                                <i class="fas fa-users"></i>
                                Kelola Siswa

                            </a>

                        </div>

                        <div class="col-lg-4 col-md-6">

                            <a href="{{ route('tu.kelas.index') }}"
                            class="quick-btn btn btn-outline-info w-100">

                                <i class="fas fa-school"></i>
                                Kelola Kelas

                            </a>

                        </div>

                        <div class="col-lg-4 col-md-12">

                            <a href="{{ route('tu.wali-kelas') }}"
                            class="quick-btn btn btn-outline-success w-100">

                                <i class="fas fa-chalkboard-teacher"></i>
                                Kelola Wali Kelas

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection