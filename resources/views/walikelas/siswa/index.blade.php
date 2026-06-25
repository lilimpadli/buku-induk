@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('content')
<style>
    /* ===================== STYLE DAFTAR SISWA (SESUAI DASHBOARD) ===================== */
    
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --danger-gradient: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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

    /* Header Styles - SAMA DENGAN DASHBOARD */
    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(100px, -100px);
        pointer-events: none;
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        position: relative;
        z-index: 1;
    }

    /* Stat Cards */
    .stat-mini-card {
        background: white;
        border-radius: 12px;
        padding: 12px 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 12px;
        transition: var(--transition);
    }

    .stat-mini-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .stat-mini-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-mini-icon.primary { background: rgba(102, 126, 234, 0.1); color: #667eea; }
    .stat-mini-icon.success { background: rgba(19, 180, 151, 0.1); color: #13B497; }
    .stat-mini-icon.danger { background: rgba(245, 87, 108, 0.1); color: #f5576c; }

    .stat-mini-info h4 {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .stat-mini-info p {
        margin: 0;
        font-size: 12px;
        color: #64748b;
    }

    /* Filter Card */
    .filter-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        margin-bottom: 2rem;
        overflow: hidden;
        transition: var(--transition);
    }

    .filter-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-hover-shadow);
    }

    .filter-card .card-body {
        padding: 1.5rem;
    }

    /* Button Styles - SAMA DENGAN DASHBOARD */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        cursor: pointer;
        position: relative;
        z-index: 10;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        transition: var(--transition);
        cursor: pointer;
        position: relative;
        z-index: 10;
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }

    /* Action Button */
    .btn-action-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        background: #f1f5f9;
        color: #64748b;
        margin-left: 8px;
        cursor: pointer;
    }

    .btn-action-icon:hover {
        transform: translateY(-3px);
    }

    .btn-action-icon.detail:hover {
        background: var(--primary-gradient);
        color: white;
    }

    .btn-action-icon.nilai:hover {
        background: var(--success-gradient);
        color: white;
    }

    .btn-action-icon.raport:hover {
        background: var(--info-gradient);
        color: white;
    }

    /* List Group Styles - SAMA DENGAN DASHBOARD */
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
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .student-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background-color: #f8f9fa;
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
        background: var(--primary-gradient);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .student-details strong {
        font-size: 16px;
        font-weight: 600;
        color: #1E293B;
        display: block;
        margin-bottom: 4px;
    }

    .student-details small {
        color: #64748B;
        font-size: 13px;
    }

    .student-class {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Action Buttons Container */
    .action-buttons-container {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Empty State - SAMA DENGAN DASHBOARD */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #718096;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
        color: #667eea;
    }

    .empty-state h5 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    /* Animations - SAMA DENGAN DASHBOARD */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 1.5rem;
    }

    .page-link {
        border-radius: 8px;
        margin: 0 3px;
        color: #667eea;
        border: none;
        padding: 0.5rem 1rem;
        transition: var(--transition);
    }

    .page-link:hover {
        background: var(--primary-gradient);
        color: white;
        transform: translateY(-2px);
    }

    .page-item.active .page-link {
        background: var(--primary-gradient);
        border: none;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem 1rem;
        }
        
        .page-header h3 {
            font-size: 1.5rem;
        }
        
        .student-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
        
        .student-info {
            width: 100%;
        }
        
        .student-class {
            align-self: flex-start;
        }
        
        .filter-form {
            flex-direction: column;
        }
        
        .filter-form .btn {
            width: 100%;
        }
        
        .action-buttons-container {
            width: 100%;
            justify-content: flex-start;
            margin-top: 8px;
        }

        .stats-row {
            flex-direction: column;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header - SAMA DENGAN DASHBOARD -->
    <div class="page-header fade-in">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3 class="mb-1">
                    <i class="fas fa-users me-2"></i> Daftar Siswa
                </h3>
                <div class="text-muted">Kelola data siswa di kelas Anda</div>
            </div>
            <div class="d-flex gap-2 mt-2 mt-sm-0">
                <a href="{{ route('walikelas.siswa.exportExcel') }}" class="btn btn-gradient" style="cursor: pointer; z-index: 100;">
                    <i class="fas fa-file-excel me-2"></i> Export Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Singkat - TAMBAHAN BARU -->
    @php
        $totalSiswa = isset($siswa) ? $siswa->total() : 0;
        $lakiCount = isset($siswa) ? $siswa->where('jenis_kelamin', 'Laki-laki')->count() : 0;
        $perempuanCount = isset($siswa) ? $siswa->where('jenis_kelamin', 'Perempuan')->count() : 0;
    @endphp
    <div class="row g-3 mb-4 stats-row fade-in">
        <div class="col-md-4">
            <div class="stat-mini-card">
                <div class="stat-mini-icon primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-mini-info">
                    <h4>{{ $totalSiswa }}</h4>
                    <p>Total Siswa</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-mini-card">
                <div class="stat-mini-icon success">
                    <i class="fas fa-male"></i>
                </div>
                <div class="stat-mini-info">
                    <h4>{{ $lakiCount }}</h4>
                    <p>Laki-laki</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-mini-card">
                <div class="stat-mini-icon danger">
                    <i class="fas fa-female"></i>
                </div>
                <div class="stat-mini-info">
                    <h4>{{ $perempuanCount }}</h4>
                    <p>Perempuan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card filter-card fade-in">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end filter-form" id="filterForm">
                <div class="col-md-5">
                    <label class="form-label fw-semibold text-muted small">
                        <i class="fas fa-search me-1"></i> Cari Siswa
                    </label>
                    <input type="text" name="q" value="{{ request('q', $search ?? '') }}" 
                           class="form-control" 
                           placeholder="Nama / NIS / NISN"
                           id="searchInput">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small">
                        <i class="fas fa-venus-mars me-1"></i> Jenis Kelamin
                    </label>
                    <select name="jenis_kelamin" class="form-select" id="genderSelect">
                        <option value="">Semua</option>
                        <option value="Laki-laki" {{ (request('jenis_kelamin', $jenisKelamin ?? '') == 'Laki-laki') ? 'selected' : '' }}>
                            Laki-laki
                        </option>
                        <option value="Perempuan" {{ (request('jenis_kelamin', $jenisKelamin ?? '') == 'Perempuan') ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button class="btn btn-gradient px-4" type="submit">
                            <i class="fas fa-filter me-2"></i> Filter
                        </button>
                        <a href="{{ route('walikelas.siswa.index') }}" class="btn btn-outline-gradient">
                            <i class="fas fa-undo-alt me-2"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Student List Card -->
    <div class="card shadow-sm fade-in" style="border-radius: var(--border-radius); overflow: hidden;">
        <div class="card-body p-0">
            @if(isset($siswa) && $siswa->count() > 0)
                <div class="student-list">
                    @foreach($siswa as $s)
                        <div class="student-item">
                            <div class="student-info">
                                @if($s->foto)
                                    <img src="{{ asset('storage/' . $s->foto) }}" alt="{{ $s->nama_lengkap }}" class="student-avatar">
                                @else
                                    <div class="student-avatar-placeholder">
                                        {{ strtoupper(substr($s->nama_lengkap, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="student-details">
                                    <strong>{{ $s->nama_lengkap }}</strong>
                                    <small>NIS: {{ $s->nis ?? '-' }} • NISN: {{ $s->nisn ?? '-' }}</small>
                                </div>
                            </div>
                            <div class="action-buttons-container">
                                @if($s->rombel)
                                    <span class="student-class">
                                        <i class="fas fa-graduation-cap me-1"></i> {{ $s->rombel->nama }}
                                    </span>
                                @endif
                                <div class="d-flex">
                                    <a href="{{ route('walikelas.siswa.show', $s->id) }}" 
                                       class="btn-action-icon detail" 
                                       title="Detail Siswa">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('walikelas.input_nilai_raport.create', $s->id) }}" 
                                       class="btn-action-icon nilai" 
                                       title="Input Nilai Raport">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="{{ route('walikelas.nilai_raport.list', $s->id) }}" 
                                       class="btn-action-icon raport" 
                                       title="Lihat Nilai Raport">
                                        <i class="fas fa-chart-bar"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($siswa instanceof \Illuminate\Pagination\LengthAwarePaginator && $siswa->hasPages())
                    <div class="p-3 border-top">
                        {{ $siswa->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-user-graduate fa-3x mb-3"></i>
                    <h5>Tidak ada data siswa</h5>
                    <p class="text-muted">Belum ada siswa yang terdaftar di kelas Anda.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Fix untuk memastikan semua tombol bisa diklik
    document.addEventListener('DOMContentLoaded', function() {
        // Semua tombol dan link
        const allClickable = document.querySelectorAll('a, button, .btn, .btn-gradient, .btn-outline-gradient, .btn-action-icon');
        allClickable.forEach(el => {
            el.style.pointerEvents = 'auto';
            el.style.cursor = 'pointer';
        });
        
        // Khusus export excel
        const exportBtn = document.querySelector('a[href*="exportExcel"]');
        if (exportBtn) {
            exportBtn.addEventListener('click', function(e) {
                console.log('Export Excel clicked');
            });
        }
    });
</script>
@endsection