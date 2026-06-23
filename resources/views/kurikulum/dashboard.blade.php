@extends('layouts.app')

@section('title', 'Dashboard Kurikulum')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body { background-color: #f7fafc; font-family: 'Inter', sans-serif; }

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

    /* HEADER */
    .dashboard-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
        width: 100%;
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
        font-size: clamp(1.3rem, 3vw, 1.8rem);
        position: relative;
        z-index: 1;
    }

    .dashboard-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: clamp(0.8rem, 1.5vw, 1rem);
        position: relative;
        z-index: 1;
        margin-bottom: 0;
    }

    /* STATS */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        background: white;
        padding: 1.2rem 1.2rem;
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
        right: 0;
        height: 4px;
    }

    .stat-card:nth-child(1)::before { background: var(--primary-gradient); }
    .stat-card:nth-child(2)::before { background: var(--success-gradient); }
    .stat-card:nth-child(3)::before { background: var(--info-gradient); }
    .stat-card:nth-child(4)::before { background: var(--warning-gradient); }
    .stat-card:nth-child(5)::before { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .stat-card:nth-child(6)::before { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

    .stat-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 0.3rem;
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
        flex-shrink: 0;
    }

    .stat-card:nth-child(1) .stat-icon { background: var(--primary-gradient); }
    .stat-card:nth-child(2) .stat-icon { background: var(--success-gradient); }
    .stat-card:nth-child(3) .stat-icon { background: var(--info-gradient); }
    .stat-card:nth-child(4) .stat-icon { background: var(--warning-gradient); }
    .stat-card:nth-child(5) .stat-icon { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .stat-card:nth-child(6) .stat-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

    .stat-title {
        color: #64748B;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1E293B;
        margin: 0;
        line-height: 1.2;
    }

    /* CHART CARD */
    .chart-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        background: white;
        margin-bottom: 1.5rem;
        width: 100%;
    }

    .chart-card .card-header {
        padding: 0.8rem 1.2rem;
        border-bottom: 1px solid #E2E8F0;
        font-weight: 700;
        color: #1E293B;
        font-size: 0.95rem;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .chart-card .card-header i {
        color: #667eea;
        margin-right: 6px;
    }

    .chart-card .card-body {
        padding: 1rem 1.2rem;
    }

    .chart-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
    }

    .chart-bar .bar-label {
        width: 90px;
        font-size: 0.75rem;
        color: #475569;
        font-weight: 500;
        flex-shrink: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chart-bar .bar-track {
        flex: 1;
        height: 22px;
        background: #F1F5F9;
        border-radius: 6px;
        overflow: hidden;
        position: relative;
    }

    .chart-bar .bar-fill {
        height: 100%;
        border-radius: 6px;
        transition: width 0.8s ease;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 6px;
        font-size: 10px;
        font-weight: 600;
        color: white;
        min-width: 28px;
    }

    /* BADGE */
    .badge-gender {
        padding: 3px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
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

    /* LIST ROMBEL */
    .list-rombels {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .list-rombels .item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 6px 12px;
        background: #F8FAFC;
        border-radius: 8px;
        font-size: 0.8rem;
        transition: var(--transition);
        flex-wrap: wrap;
        gap: 4px;
    }

    .list-rombels .item:hover {
        background: #F1F5F9;
    }

    .list-rombels .item .nama {
        font-weight: 600;
        color: #1E293B;
        font-size: 0.8rem;
    }

    .list-rombels .item .detail {
        color: #64748B;
        font-size: 0.7rem;
    }

    .empty-state {
        text-align: center;
        padding: 1.5rem 1rem;
        color: #94A3B8;
        font-size: 0.85rem;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.2rem 1rem;
        }
        .dashboard-header h1 {
            font-size: 1.2rem;
        }

        .stats-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.7rem;
        }
        .stat-card {
            padding: 0.8rem;
        }
        .stat-value {
            font-size: 1.3rem;
        }
        .stat-icon {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }
        .stat-title {
            font-size: 0.6rem;
        }

        .chart-bar .bar-label {
            width: 65px;
            font-size: 0.65rem;
        }
        .chart-bar .bar-fill {
            font-size: 9px;
            min-width: 22px;
        }
        .chart-card .card-header {
            font-size: 0.85rem;
            padding: 0.6rem 1rem;
        }
        .chart-card .card-body {
            padding: 0.8rem 1rem;
        }

        .list-rombels .item {
            flex-direction: column;
            align-items: flex-start;
            gap: 2px;
        }
        .list-rombels .item .detail {
            font-size: 0.65rem;
        }

        .badge-gender {
            font-size: 0.6rem;
            padding: 2px 10px;
        }
    }

    @media (max-width: 576px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
        }
        .stat-value {
            font-size: 1.1rem;
        }
        .stat-icon {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }
        .chart-bar .bar-label {
            width: 55px;
            font-size: 0.6rem;
        }
        .chart-bar .bar-fill {
            font-size: 8px;
            min-width: 18px;
        }
    }

    @media (max-width: 450px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
        .stat-card {
            padding: 0.6rem;
        }
        .stat-value {
            font-size: 1rem;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="dashboard-header">
        <h1>Selamat Datang, Kurikulum! 👋</h1>
        <p class="text-muted">Dashboard monitoring akademik SMKN 1 Kawali</p>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div><p class="stat-title">Siswa</p></div>
            </div>
            <h2 class="stat-value">{{ number_format($totalSiswa ?? 0) }}</h2>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div><p class="stat-title">Guru</p></div>
            </div>
            <h2 class="stat-value">{{ number_format($totalGuru ?? 0) }}</h2>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon"><i class="fas fa-school"></i></div>
                <div><p class="stat-title">Kelas</p></div>
            </div>
            <h2 class="stat-value">{{ number_format($totalKelas ?? 0) }}</h2>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                <div><p class="stat-title">Rombel</p></div>
            </div>
            <h2 class="stat-value">{{ number_format($totalRombel ?? 0) }}</h2>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon"><i class="fas fa-book-open"></i></div>
                <div><p class="stat-title">Mapel</p></div>
            </div>
            <h2 class="stat-value">{{ number_format($totalMapel ?? 0) }}</h2>
        </div>
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon"><i class="fas fa-building"></i></div>
                <div><p class="stat-title">Jurusan</p></div>
            </div>
            <h2 class="stat-value">{{ number_format($totalJurusan ?? 0) }}</h2>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="chart-card">
                <div class="card-header">
                    <span><i class="fas fa-chart-pie"></i> Siswa per Tingkat</span>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <span class="bar-label">Kelas X</span>
                        <div class="bar-track">
                            <div class="bar-fill" style="width: {{ $totalSiswa > 0 ? ($siswaX / $totalSiswa * 100) : 0 }}%; background: #667eea;">
                                {{ $siswaX }}
                            </div>
                        </div>
                    </div>
                    <div class="chart-bar">
                        <span class="bar-label">Kelas XI</span>
                        <div class="bar-track">
                            <div class="bar-fill" style="width: {{ $totalSiswa > 0 ? ($siswaXI / $totalSiswa * 100) : 0 }}%; background: #13B497;">
                                {{ $siswaXI }}
                            </div>
                        </div>
                    </div>
                    <div class="chart-bar">
                        <span class="bar-label">Kelas XII</span>
                        <div class="bar-track">
                            <div class="bar-fill" style="width: {{ $totalSiswa > 0 ? ($siswaXII / $totalSiswa * 100) : 0 }}%; background: #F59E0B;">
                                {{ $siswaXII }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart-card">
                <div class="card-header">
                    <span><i class="fas fa-venus-mars"></i> Jenis Kelamin</span>
                </div>
                <div class="card-body text-center">
                    <div style="display: flex; justify-content: center; gap: 1.5rem; padding: 0.5rem 0;">
                        <div>
                            <span class="badge-gender laki"><i class="fas fa-male me-1"></i> Laki-laki</span>
                            <h3 class="mt-2" style="font-weight:800; font-size:1.8rem;">{{ number_format($siswaLaki ?? 0) }}</h3>
                        </div>
                        <div>
                            <span class="badge-gender perempuan"><i class="fas fa-female me-1"></i> Perempuan</span>
                            <h3 class="mt-2" style="font-weight:800; font-size:1.8rem;">{{ number_format($siswaPerempuan ?? 0) }}</h3>
                        </div>
                    </div>
                    <div style="width:100%; height:6px; background:#F1F5F9; border-radius:4px; overflow:hidden; display:flex;">
                        <div style="height:100%; width:{{ $totalSiswa > 0 ? ($siswaLaki / $totalSiswa * 100) : 0 }}%; background:#2563EB;"></div>
                        <div style="height:100%; width:{{ $totalSiswa > 0 ? ($siswaPerempuan / $totalSiswa * 100) : 0 }}%; background:#DB2777;"></div>
                    </div>
                    <small class="text-muted mt-2 d-block">Total: {{ number_format($totalSiswa ?? 0) }} siswa</small>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="chart-card">
                <div class="card-header">
                    <span><i class="fas fa-chart-bar"></i> Siswa per Jurusan</span>
                </div>
                <div class="card-body">
                    @foreach($jurusanData as $j)
                        <div class="chart-bar">
                            <span class="bar-label">{{ $j['nama'] }}</span>
                            <div class="bar-track">
                                <div class="bar-fill" style="width: {{ $totalSiswa > 0 ? ($j['total'] / $totalSiswa * 100) : 0 }}%; background: {{ $loop->index % 2 == 0 ? '#667eea' : '#764ba2' }};">
                                    {{ $j['total'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="chart-card">
                <div class="card-header">
                    <span><i class="fas fa-clock"></i> Rombel Terbaru</span>
                </div>
                <div class="card-body">
                    <div class="list-rombels">
                        @forelse($rombels as $r)
                            <div class="item">
                                <span class="nama">{{ $r->nama }}</span>
                                <span class="detail">
                                    {{ optional($r->kelas)->tingkat ?? '-' }}
                                    {{ optional(optional($r->kelas)->jurusan)->nama ?? '' }}
                                    <br><small>Wali: {{ optional($r->guru)->nama ?? '-' }}</small>
                                </span>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-inbox mb-2 d-block"></i>
                                Belum ada rombel
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection