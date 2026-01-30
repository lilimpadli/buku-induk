@extends('layouts.app')

@section('title', 'Dashboard Program Keahlian')

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

    /* Table Styles */
    .table-container {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--card-shadow);
        background: white;
    }

    .table {
        margin-bottom: 0;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
    }

    .table thead th {
        background-color: #f7fafc;
        border-bottom: 2px solid #e2e8f0;
        color: var(--text-primary);
        font-weight: 600;
        padding: 12px 16px;
    }

    .table td {
        padding: 12px 16px;
        border-color: #e2e8f0;
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
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="dashboard-header fade-in">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2 class="mb-1">Halo, Program Keahlian 👋</h2>
                <div class="text-muted">Ringkasan program keahlian dan siswa — cepat, informatif, dan responsif</div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('kaprog.siswa.index') }}" class="btn btn-outline-gradient">Kelola Siswa</a>
                <a href="{{ route('kaprog.guru.index') }}" class="btn btn-gradient">Kelola Guru</a>
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
                            <div class="h4 mb-0">{{ $totalSiswa ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay: 0.2s;">
            <div class="card stat-card success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon success me-3">
                            <i class="fas fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Guru</div>
                            <div class="h4 mb-0">{{ $totalGuru ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay: 0.3s;">
            <div class="card stat-card info h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon info me-3">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Rombel</div>
                            <div class="h4 mb-0">{{ $totalRombel ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay: 0.4s;">
            <div class="card stat-card warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon warning me-3">
                            <i class="fas fa-venus-mars"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Jenis Kelamin</div>
                            @php
                                $laki = $siswas->where('jenis_kelamin', 'L')->count();
                                $perempuan = $siswas->where('jenis_kelamin', 'P')->count();
                            @endphp
                            <div class="h5 mb-0" style="font-size: 1.1rem;">{{ $laki }}L / {{ $perempuan }}P</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8 fade-in" style="animation-delay: 0.5s;">
            <div class="card shadow-sm" style="border-radius: var(--border-radius); border: none; box-shadow: var(--card-shadow);">
                <div class="card-body">
                    <h5 class="mb-4" style="font-weight: 600;">Distribusi Siswa per Angkatan</h5>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="angkatanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <!-- Quick Actions Card -->
            <div class="card shadow-sm mb-4 fade-in" style="border-radius: var(--border-radius); border: none; box-shadow: var(--card-shadow); animation-delay: 0.6s;">
                <div class="card-body">
                    <h5 class="mb-4" style="font-weight: 600;">Aksi Cepat</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('kaprog.siswa.index') }}" class="btn btn-outline-primary" style="border-radius: 10px; padding: 0.6rem 1.2rem; font-weight: 600;">
                            <i class="fas fa-users me-2"></i> Kelola Siswa
                        </a>
                        <a href="{{ route('kaprog.guru.index') }}" class="btn btn-gradient" style="border-radius: 10px; padding: 0.6rem 1.2rem;">
                            <i class="fas fa-chalkboard-user me-2"></i> Kelola Guru
                        </a>
                        <a href="{{ route('kaprog.kelas.index') }}" class="btn btn-outline-success" style="border-radius: 10px; padding: 0.6rem 1.2rem; font-weight: 600;">
                            <i class="fas fa-graduation-cap me-2"></i> Kelola Kelas
                        </a>
                        @if($jurusan)
                        <a href="{{ route('kaprog.export.jurusan', $jurusan->id) }}" class="btn btn-outline-info" style="border-radius: 10px; padding: 0.6rem 1.2rem; font-weight: 600;">
                            <i class="fas fa-file-excel me-2"></i> Export Jurusan
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student List -->
    <div class="row g-4">
        <div class="col-xl-12 fade-in" style="animation-delay: 0.7s;">
            <div class="card shadow-sm" style="border-radius: var(--border-radius); border: none; box-shadow: var(--card-shadow);">
                <div class="card-body">
                    
                        <div class="row g-2">
                            <div class="col-md-8">
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama / NIS">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-gradient w-100" type="submit">
                                    <i class="fas fa-search me-2"></i>Cari
                                </button>
                            </div>
                        </div>
                    </form>

                    @if(!empty($siswas) && $siswas->count() > 0)
                        <div class="student-list">
                            @foreach($siswas->take(10) as $s)
                                <div class="student-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="student-avatar-placeholder" style="background: var(--primary-gradient); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                            {{ strtoupper(substr($s->nama_lengkap,0,1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight:600;">{{ $s->nama_lengkap }}</div>
                                            <div class="small text-muted">NIS: {{ $s->nis ?? '-' }} • {{ $s->kelas ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-gradient lihat-btn" data-id="{{ $s->id }}">Detail</button>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-4">
                            <a href="{{ route('kaprog.siswa.index') }}" class="btn btn-gradient">
                                <i class="fas fa-list me-2"></i>Lihat Semua Siswa
                            </a>
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-user-graduate fa-3x mb-3"></i>
                            <p>Belum ada siswa untuk ditampilkan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Siswa -->
<div class="modal fade" id="modalDetailSiswa" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: var(--border-radius); border: none;">
            <div class="modal-header" style="border-bottom: 1px solid #e2e8f0;">
                <h5 class="modal-title" style="font-weight: 600;">Detail Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="detailContent">Memuat data...</div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const detailRoute = "{{ route('kaprog.siswa.detail', ['id' => '__ID__']) }}";
    
    document.querySelectorAll('.lihat-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('modalDetailSiswa'));
            modal.show();
            document.getElementById('detailContent').innerHTML = "Memuat data...";
            
            let url = detailRoute.replace('__ID__', id);
            
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('detailContent').innerHTML = `
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div style="background: var(--primary-gradient); width: 120px; height: 120px; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 48px;">
                                    ${data.nama_lengkap.charAt(0).toUpperCase()}
                                </div>
                                <h6 style="font-weight: 600;">${data.nama_lengkap}</h6>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr><th style="font-weight: 600; color: var(--text-primary);">NIS</th><td>${data.nis}</td></tr>
                                    <tr><th style="font-weight: 600; color: var(--text-primary);">Kelas</th><td>${data.kelas}</td></tr>
                                    <tr><th style="font-weight: 600; color: var(--text-primary);">Jenis Kelamin</th><td>${data.jenis_kelamin}</td></tr>
                                    <tr><th style="font-weight: 600; color: var(--text-primary);">TTL</th><td>${data.tempat_lahir}, ${data.tanggal_lahir}</td></tr>
                                    <tr><th style="font-weight: 600; color: var(--text-primary);">Alamat</th><td>${data.alamat}</td></tr>
                                    <tr><th style="font-weight: 600; color: var(--text-primary);">No HP</th><td>${data.no_hp}</td></tr>
                                </table>
                            </div>
                        </div>
                    `;
                });
        });
    });

    // Chart.js - Distribusi Siswa per Angkatan (Kelas 10, 11, 12)
    const angkatanCtx = document.getElementById('angkatanChart').getContext('2d');
    
    const angkatanChart = new Chart(angkatanCtx, {
        type: 'bar',
        data: {
            labels: ['Kelas 10', 'Kelas 11', 'Kelas 12'],
            datasets: [{
                label: 'Jumlah Siswa',
                data: [{{ $siswaKelas10 ?? 0 }}, {{ $siswaKelas11 ?? 0 }}, {{ $siswaKelas12 ?? 0 }}],
                backgroundColor: [
                    'rgba(102, 126, 234, 0.7)',
                    'rgba(19, 180, 151, 0.7)',
                    'rgba(79, 172, 254, 0.7)'
                ],
                borderColor: [
                    'rgba(102, 126, 234, 1)',
                    'rgba(19, 180, 151, 1)',
                    'rgba(79, 172, 254, 1)'
                ],
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endpush