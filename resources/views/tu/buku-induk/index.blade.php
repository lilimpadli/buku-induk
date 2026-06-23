@extends('layouts.app')

@section('title', 'Buku Induk Siswa')

@section('content')
<style>
    :root {
        --primary: #4F46E5;
        --primary-dark: #4338CA;
        --secondary: #7C3AED;
        --success: #10B981;
        --warning: #F59E0B;
        --danger: #EF4444;
        --info: #3B82F6;
        --dark: #1F2937;
        --gray: #6B7280;
        --light: #F9FAFB;
    }

    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Bubble Animations */
    @keyframes bubbleFloat1 {
        0% { transform: translate(0, 0) scale(1); opacity: 0.3; }
        50% { transform: translate(30px, -20px) scale(1.2); opacity: 0.5; }
        100% { transform: translate(-20px, -40px) scale(0.8); opacity: 0; }
    }

    @keyframes bubbleFloat2 {
        0% { transform: translate(0, 0) scale(1); opacity: 0.4; }
        50% { transform: translate(-25px, -30px) scale(1.3); opacity: 0.6; }
        100% { transform: translate(20px, -50px) scale(0.7); opacity: 0; }
    }

    @keyframes bubbleFloat3 {
        0% { transform: translate(0, 0) scale(1); opacity: 0.2; }
        50% { transform: translate(40px, -15px) scale(1.1); opacity: 0.4; }
        100% { transform: translate(-30px, -60px) scale(0.9); opacity: 0; }
    }

    @keyframes bubbleFloat4 {
        0% { transform: translate(0, 0) scale(1); opacity: 0.35; }
        50% { transform: translate(-35px, -25px) scale(1.25); opacity: 0.55; }
        100% { transform: translate(25px, -45px) scale(0.75); opacity: 0; }
    }

    @keyframes rotateSlow {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .fade-in-up {
        animation: fadeInUp 0.5s ease forwards;
    }

    /* Hero Banner */
    .hero-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 28px;
        padding: 32px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .bubble {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(4px);
        pointer-events: none;
    }

    .bubble-1 { width: 80px; height: 80px; top: 20%; right: 15%; animation: bubbleFloat1 8s ease-in-out infinite; }
    .bubble-2 { width: 120px; height: 120px; bottom: 10%; left: 5%; animation: bubbleFloat2 10s ease-in-out infinite; animation-delay: 1s; }
    .bubble-3 { width: 60px; height: 60px; top: 60%; right: 25%; animation: bubbleFloat3 7s ease-in-out infinite; animation-delay: 2s; }
    .bubble-4 { width: 40px; height: 40px; bottom: 30%; right: 40%; animation: bubbleFloat4 6s ease-in-out infinite; animation-delay: 0.5s; }
    .bubble-5 { width: 100px; height: 100px; top: -30px; left: 20%; animation: bubbleFloat2 12s ease-in-out infinite; animation-delay: 3s; }
    .bubble-6 { width: 50px; height: 50px; bottom: 15%; right: 10%; animation: bubbleFloat1 5s ease-in-out infinite; animation-delay: 1.5s; }

    .rotating-orb {
        position: absolute;
        width: 150px;
        height: 150px;
        right: -50px;
        top: -50px;
        background: radial-gradient(circle, rgba(255,255,255,0.2), rgba(255,255,255,0));
        border-radius: 50%;
        animation: rotateSlow 20s linear infinite;
    }

    .hero-title {
        font-size: 28px;
        font-weight: 800;
        color: white;
        margin-bottom: 8px;
        position: relative;
        z-index: 2;
    }

    .hero-subtitle {
        color: rgba(255,255,255,0.85);
        font-size: 14px;
        position: relative;
        z-index: 2;
    }

    .hero-stats {
        display: flex;
        gap: 24px;
        margin-top: 20px;
        position: relative;
        z-index: 2;
    }

    .hero-stat {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 12px 24px;
        text-align: center;
        min-width: 110px;
        transition: all 0.3s ease;
    }

    .hero-stat:hover {
        transform: translateY(-3px);
        background: rgba(255,255,255,0.25);
    }

    .hero-stat-value {
        font-size: 28px;
        font-weight: 800;
        color: white;
    }

    .hero-stat-label {
        font-size: 11px;
        color: rgba(255,255,255,0.7);
        margin-top: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Filter Card */
    .filter-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #eef2ff;
        padding: 24px;
        margin-bottom: 28px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .filter-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
    }

    .filter-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }

    .filter-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-title i {
        color: var(--primary);
        font-size: 18px;
    }

    .form-control-modern,
    .form-select-modern {
        height: 48px;
        border-radius: 14px;
        border: 1.5px solid #e2e8f0;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control-modern:focus,
    .form-select-modern:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        outline: none;
    }

    .btn-modern {
        border-radius: 14px;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-modern-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        color: white;
    }

    .btn-modern-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79,70,229,0.3);
    }

    /* Table Container */
    .table-container {
        background: white;
        border-radius: 20px;
        border: 1px solid #eef2ff;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .table-container:hover {
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    }

    .table-modern {
        width: 100%;
        border-collapse: collapse;
    }

    .table-modern thead th {
        background: #f8faff;
        padding: 16px;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #eef2ff;
    }

    .table-modern tbody td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #334155;
    }

    .table-modern tbody tr:hover {
        background: #f8faff;
    }

    /* Avatar */
    .student-avatar-modern {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .student-avatar-modern img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 14px;
    }

    .student-avatar-modern:hover {
        transform: scale(1.05);
    }

    /* Badges */
    .badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-male { background: linear-gradient(135deg, #e0f2fe, #bae6fd); color: #0284c7; }
    .badge-female { background: linear-gradient(135deg, #fce7f3, #fbcfe8); color: #db2777; }
    .badge-active { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #059669; }
    .badge-rombel { background: #f1f5f9; color: #475569; }
    .badge-inactive { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #dc2626; }

    /* Action Buttons */
    .action-group {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
    }

    .action-btn-view { background: rgba(59,130,246,0.1); color: #3b82f6; }
    .action-btn-view:hover { background: #3b82f6; color: white; transform: translateY(-2px); }
    .action-btn-edit { background: rgba(245,158,11,0.1); color: #f59e0b; }
    .action-btn-edit:hover { background: #f59e0b; color: white; transform: translateY(-2px); }
    .action-btn-print { background: rgba(16,185,129,0.1); color: #10b981; }
    .action-btn-print:hover { background: #10b981; color: white; transform: translateY(-2px); }

    /* Empty State */
    .empty-state-modern {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .empty-icon i {
        font-size: 40px;
        color: #94a3b8;
    }

    .empty-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .empty-description {
        color: var(--gray);
        font-size: 14px;
    }

    /* Pagination Modern - FIXED */
    .pagination-modern {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 24px;
        padding: 20px;
        flex-wrap: wrap;
    }

    .pagination-modern .page-item {
        list-style: none;
    }

    .pagination-modern .page-link {
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        color: var(--gray);
        transition: all 0.2s ease;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        background: white;
    }

    .pagination-modern .page-link:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .pagination-modern .active .page-link {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
    }

    .pagination-modern .disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f1f5f9;
    }

    /* Mobile Card View */
    .mobile-card-view {
        display: none;
    }

    .student-card-modern {
        background: white;
        border-radius: 20px;
        border: 1px solid #eef2ff;
        padding: 20px;
        margin-bottom: 16px;
        transition: all 0.3s ease;
    }

    .student-card-modern:hover {
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table-responsive-desktop { display: none; }
        .mobile-card-view { display: block; }
        .hero-banner { padding: 24px; }
        .hero-title { font-size: 22px; }
        .hero-stats { flex-wrap: wrap; gap: 12px; }
        .hero-stat { min-width: calc(50% - 12px); padding: 10px; }
        .hero-stat-value { font-size: 20px; }
        .filter-card { padding: 16px; }
    }

    @media (min-width: 769px) {
        .mobile-card-view { display: none; }
        .table-responsive-desktop { display: block; }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">
    
    <!-- Hero Banner -->
    <div class="hero-banner fade-in-up">
        <div class="bubble bubble-1"></div>
        <div class="bubble bubble-2"></div>
        <div class="bubble bubble-3"></div>
        <div class="bubble bubble-4"></div>
        <div class="bubble bubble-5"></div>
        <div class="bubble bubble-6"></div>
        <div class="rotating-orb"></div>
        
        <div class="row align-items-center">
            <div class="col-md-12">
                <h1 class="hero-title">
                    <i class="fas fa-book-open me-2"></i> Buku Induk Siswa
                </h1>
                <p class="hero-subtitle">
                    Kelola dan lihat data lengkap buku induk seluruh siswa
                </p>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ $siswas->total() }}</div>
                        <div class="hero-stat-label">Total Siswa</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ $siswas->count() }}</div>
                        <div class="hero-stat-label">Halaman Ini</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card fade-in-up" style="animation-delay: 0.1s">
        <div class="filter-title">
            <i class="fas fa-sliders-h"></i> Filter Data
        </div>
        <form method="GET" class="row g-3">
            <div class="col-md-5 col-12">
                <input type="text" name="search" class="form-control-modern w-100" 
                    placeholder="🔍 Cari nama, NIS, atau NISN..." 
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-5 col-12">
                <select name="jurusan_id" class="form-select-modern w-100">
                    <option value="">-- Semua Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-12">
                <button type="submit" class="btn btn-modern-primary w-100">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Desktop Table View -->
    <div class="table-container fade-in-up" style="animation-delay: 0.2s">
        <div class="table-responsive-desktop">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>NIS / NISN</th>
                        <th>Jenis Kelamin</th>
                        <th>Rombel</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $index => $siswa)
                    <tr>
                        <td>{{ $siswas->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="student-avatar-modern">
                                    @if($siswa->user && $siswa->user->photo)
                                        <img src="{{ Storage::url($siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}">
                                    @else
                                        {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $siswa->nama_lengkap }}</div>
                                    <small class="text-muted">{{ $siswa->nis ?? '-' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>{{ $siswa->nis ?? '-' }}</div>
                            <small class="text-muted">{{ $siswa->nisn ?? '-' }}</small>
                        </td>
                        <td>
                            @if($siswa->jenis_kelamin == 'Laki-laki')
                                <span class="badge-modern badge-male"><i class="fas fa-mars"></i> Laki-laki</span>
                            @elseif($siswa->jenis_kelamin == 'Perempuan')
                                <span class="badge-modern badge-female"><i class="fas fa-venus"></i> Perempuan</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($siswa->rombel)
                                <span class="badge-modern badge-rombel"><i class="fas fa-users"></i> {{ $siswa->rombel->nama }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $terminalStatuses = ['pindah', 'do', 'meninggal', 'lulus'];
                                $isTerminal = $siswa->mutasiTerakhir && in_array(strtolower($siswa->mutasiTerakhir->status ?? ''), $terminalStatuses);
                            @endphp
                            @if($isTerminal)
                                <span class="badge-modern badge-inactive">
                                    <i class="fas fa-exclamation-circle"></i> {{ ucfirst($siswa->mutasiTerakhir->status ?? 'Lulus') }}
                                </span>
                            @else
                                <span class="badge-modern badge-active">
                                    <i class="fas fa-check-circle"></i> Aktif
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('tu.buku-induk.show', $siswa) }}" 
                                   class="action-btn action-btn-view" data-bs-toggle="tooltip" title="Lihat Buku Induk">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('tu.buku-induk.edit', $siswa->id) }}" 
                                   class="action-btn action-btn-edit" data-bs-toggle="tooltip" title="Edit Data Siswa">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{ route('tu.buku-induk.cetak', $siswa) }}" 
                                   target="_blank" class="action-btn action-btn-print" data-bs-toggle="tooltip" title="Cetak Buku Induk">
                                    <i class="fas fa-print"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-state-modern">
                                <div class="empty-icon">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div class="empty-title">Belum Ada Data</div>
                                <div class="empty-description">
                                    Belum ada siswa yang terdaftar di buku induk
                                </div>
                                <a href="{{ route('tu.siswa.create') }}" class="btn btn-modern-primary mt-3">
                                    <i class="fas fa-plus"></i> Tambah Siswa
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="mobile-card-view">
            @forelse($siswas as $siswa)
            <div class="student-card-modern">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="student-avatar-modern">
                        @if($siswa->user && $siswa->user->photo)
                            <img src="{{ Storage::url($siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}">
                        @else
                            {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark fs-6">{{ $siswa->nama_lengkap }}</div>
                        <small class="text-muted">NIS: {{ $siswa->nis ?? '-' }}</small>
                    </div>
                </div>
                
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <small class="text-muted d-block">NISN</small>
                        <span class="fw-medium">{{ $siswa->nisn ?? '-' }}</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Jenis Kelamin</small>
                        @if($siswa->jenis_kelamin == 'Laki-laki')
                            <span class="badge-modern badge-male"><i class="fas fa-mars"></i> Laki-laki</span>
                        @elseif($siswa->jenis_kelamin == 'Perempuan')
                            <span class="badge-modern badge-female"><i class="fas fa-venus"></i> Perempuan</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Rombel</small>
                        @if($siswa->rombel)
                            <span class="badge-modern badge-rombel">{{ $siswa->rombel->nama }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Status</small>
                        @php
                            $terminalStatuses = ['pindah', 'do', 'meninggal', 'lulus'];
                            $isTerminal = $siswa->mutasiTerakhir && in_array(strtolower($siswa->mutasiTerakhir->status ?? ''), $terminalStatuses);
                        @endphp
                        @if($isTerminal)
                            <span class="badge-modern badge-inactive">
                                {{ ucfirst($siswa->mutasiTerakhir->status ?? 'Lulus') }}
                            </span>
                        @else
                            <span class="badge-modern badge-active">Aktif</span>
                        @endif
                    </div>
                </div>
                
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('tu.buku-induk.show', $siswa) }}" class="btn btn-modern-primary flex-grow-1">
                        <i class="fas fa-eye"></i> Lihat
                    </a>
                    <a href="{{ route('tu.buku-induk.edit', $siswa->id) }}" class="btn btn-modern-outline">
                        <i class="fas fa-pen"></i>
                    </a>
                    <a href="{{ route('tu.buku-induk.cetak', $siswa) }}" target="_blank" class="btn btn-modern-outline">
                        <i class="fas fa-print"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-state-modern">
                <div class="empty-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="empty-title">Belum Ada Data</div>
                <div class="empty-description">Belum ada siswa yang terdaftar di buku induk</div>
            </div>
            @endforelse
        </div>

        <!-- Pagination - FIXED -->
        @if($siswas->hasPages())
        <div class="pagination-modern">
            {{ $siswas->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Override pagination style to fix Previous/Next text size
        const paginationLinks = document.querySelectorAll('.pagination-modern .page-link');
        paginationLinks.forEach(link => {
            if (link.textContent.trim() === '&laquo; Previous' || link.textContent.trim() === 'Previous') {
                link.textContent = '← Prev';
            }
            if (link.textContent.trim() === 'Next &raquo;' || link.textContent.trim() === 'Next') {
                link.textContent = 'Next →';
            }
        });

        // Smooth scroll to top on pagination click
        document.querySelectorAll('.pagination-modern a, .pagination a').forEach(link => {
            link.addEventListener('click', function(e) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush

@endsection