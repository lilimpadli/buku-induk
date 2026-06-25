@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $siswa->nama_lengkap)

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
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .tab-pane { animation: fadeIn 0.3s ease; }
    
    /* Header Gradient */
    .hero-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 28px;
        position: relative;
        overflow: hidden;
    }
    .hero-gradient::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
        top: -100px;
        right: -80px;
    }
    .hero-gradient::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        bottom: -60px;
        left: -40px;
    }
    
    /* Avatar */
    .student-avatar-lg {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255,255,255,0.3);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: bold;
        color: white;
        transition: transform 0.3s ease;
    }
    .student-avatar-lg:hover {
        transform: scale(1.05);
    }
    
    /* Action Buttons - Glassmorphism */
    .action-buttons {
        display: flex;
        gap: 12px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        padding: 8px 16px;
        border-radius: 60px;
        border: 1px solid rgba(255,255,255,0.2);
    }
    .action-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        background: rgba(255,255,255,0.2);
        color: white;
        font-size: 16px;
        text-decoration: none;
    }
    .action-icon:hover {
        background: white;
        transform: translateY(-2px);
        text-decoration: none;
    }
    .action-icon.edit:hover { color: #F59E0B; }
    .action-icon.pdf:hover { color: #EF4444; }
    .action-icon.back:hover { color: #4F46E5; }
    
    /* Stats Cards Modern */
    .stat-card-modern {
        background: white;
        border-radius: 20px;
        transition: all 0.3s ease;
        border: 1px solid #eef2ff;
        overflow: hidden;
    }
    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .stat-card-inner {
        padding: 18px 20px;
    }
    .stat-icon-modern {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .stat-value {
        font-size: 20px;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 4px;
    }
    .stat-label-modern {
        font-size: 12px;
        color: var(--gray);
        font-weight: 500;
    }
    
    /* Nav Tabs Modern */
    .nav-tabs-modern {
        border-bottom: 2px solid #eef2ff;
        gap: 4px;
        background: white;
        padding: 0 8px;
        border-radius: 60px;
        display: inline-flex;
        flex-wrap: wrap;
    }
    .nav-tabs-modern .nav-link {
        border: none;
        color: var(--gray);
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s ease;
        border-radius: 40px;
        font-size: 14px;
    }
    .nav-tabs-modern .nav-link:hover {
        color: var(--primary);
        background: #f3f4f6;
    }
    .nav-tabs-modern .nav-link.active {
        color: white;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        box-shadow: 0 4px 12px rgba(79,70,229,0.3);
    }
    
    /* Card Modern */
    .card-modern {
        background: white;
        border-radius: 24px;
        border: 1px solid #eef2ff;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .card-modern:hover {
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }
    .card-header-modern {
        background: linear-gradient(135deg, rgba(79,70,229,0.05), rgba(124,58,237,0.05));
        padding: 18px 24px;
        border-bottom: 1px solid #eef2ff;
    }
    
    /* Table Modern - RAPI */
    .table-modern {
        width: 100%;
        border-collapse: collapse;
    }
    .table-modern tr {
        border-bottom: 1px solid #f1f5f9;
    }
    .table-modern tr:last-child {
        border-bottom: none;
    }
    .table-modern th,
    .table-modern td {
        padding: 14px 16px;
        vertical-align: middle;
    }
    .table-modern th {
        width: 35%;
        font-weight: 700;
        color: var(--dark);
        background-color: #fafcff;
    }
    .table-modern td {
        color: #1f2937;
        font-weight: 500;
    }
    
    /* Gender Badge Modern */
    .gender-modern {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 40px;
        font-size: 12px;
        font-weight: 600;
    }
    .gender-male {
        background: linear-gradient(135deg, #e0f2fe, #bae6fd);
        color: #0284c7;
    }
    .gender-female {
        background: linear-gradient(135deg, #fce7f3, #fbcfe8);
        color: #db2777;
    }
    
    /* Status Badge */
    .status-badge {
        padding: 6px 16px;
        border-radius: 40px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    /* Progress Bar Custom */
    .progress-custom {
        height: 8px;
        border-radius: 10px;
        background: #eef2ff;
    }
    .progress-custom .progress-bar {
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 10px;
    }
    
    /* Tooltip */
    [data-tooltip] {
        position: relative;
        cursor: pointer;
    }
    [data-tooltip]:before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(-8px);
        background: #1f2937;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: all 0.2s ease;
        z-index: 1000;
        font-weight: normal;
    }
    [data-tooltip]:hover:before {
        opacity: 1;
        transform: translateX(-50%) translateY(-12px);
    }
    
    /* Loading */
    .btn-loading {
        pointer-events: none;
        opacity: 0.6;
    }
    
    @media (max-width: 768px) {
        .action-buttons { padding: 6px 12px; gap: 8px; }
        .action-icon { width: 34px; height: 34px; font-size: 14px; }
        .nav-tabs-modern .nav-link { padding: 8px 16px; font-size: 12px; }
        .stat-value { font-size: 18px; }
        .stat-icon-modern { width: 40px; height: 40px; font-size: 20px; }
        .table-modern th, .table-modern td { padding: 10px 12px; }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">
    
    <!-- Hero Header -->
    <div class="hero-gradient mb-4">
        <div class="p-4" style="position: relative; z-index: 2;">
            <div class="row align-items-center">
                <div class="col-auto">
                    @php
                        $avatarUrl = $siswa->foto ? asset('storage/' . $siswa->foto) : null;
                        $initial = strtoupper(substr($siswa->nama_lengkap, 0, 1));
                    @endphp
                    @if($siswa->foto)
                        <img src="{{ $avatarUrl }}" alt="{{ $siswa->nama_lengkap }}" class="student-avatar-lg">
                    @else
                        <div class="student-avatar-lg">
                            {{ $initial }}
                        </div>
                    @endif
                </div>
                <div class="col">
                    <h1 class="text-white mb-1 fw-bold" style="font-size: clamp(1.5rem, 4vw, 2rem);">{{ $siswa->nama_lengkap }}</h1>
                    <div class="d-flex flex-wrap gap-3 mt-2">
                        <span class="text-white-50"><i class="fas fa-id-card me-1"></i> NIS: {{ $siswa->nis }}</span>
                        @if($siswa->nisn)
                            <span class="text-white-50"><i class="fas fa-qrcode me-1"></i> NISN: {{ $siswa->nisn }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-auto">
                    <div class="action-buttons">
                        <a href="{{ route('tu.siswa.edit', $siswa->id) }}" class="action-icon edit" data-tooltip="Edit Data Siswa">
                            <i class="fas fa-pen"></i>
                        </a>
                        <a href="{{ route('tu.siswa.exportPDF', $siswa->id) }}" class="action-icon pdf" id="btnExportPDF" data-tooltip="Export PDF">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                        <a href="{{ route('tu.siswa.index') }}" class="action-icon back" data-tooltip="Kembali ke Daftar">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Message -->
    @if(session('success') || session('error'))
        <div class="alert alert-{{ session('success') ? 'success' : 'danger' }} alert-dismissible fade show shadow-sm mb-4" role="alert" style="border-radius: 16px;">
            <i class="fas fa-{{ session('success') ? 'check-circle' : 'exclamation-circle' }} me-2"></i>
            {{ session('success') ?? session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards Modern -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card-modern">
                <div class="stat-card-inner">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-modern bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <div class="stat-value">
                                @php
                                    $statusMutasi = $siswa->mutasiTerakhir->status ?? 'aktif';
                                @endphp
                                @if($statusMutasi == 'aktif')
                                    <span class="status-badge bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                @elseif($statusMutasi == 'lulus')
                                    <span class="status-badge bg-primary bg-opacity-10 text-primary">
                                        <i class="fas fa-trophy"></i> Lulus
                                    </span>
                                @elseif($statusMutasi == 'pindah')
                                    <span class="status-badge bg-warning bg-opacity-10 text-warning">
                                        <i class="fas fa-exchange-alt"></i> Pindah
                                    </span>
                                @else
                                    <span class="status-badge bg-secondary bg-opacity-10 text-secondary">
                                        {{ $statusMutasi }}
                                    </span>
                                @endif
                            </div>
                            <div class="stat-label-modern">Status Siswa</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card-modern">
                <div class="stat-card-inner">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-modern bg-success bg-opacity-10 text-success">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="stat-value">
                                {{ $siswa->rombel->kelas->tingkat ?? '-' }}
                            </div>
                            <div class="stat-label-modern">Tingkat</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card-modern">
                <div class="stat-card-inner">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-modern bg-info bg-opacity-10 text-info">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <div class="stat-value">
                                {{ $siswa->rombel->kelas->jurusan->nama ?? '-' }}
                            </div>
                            <div class="stat-label-modern">Jurusan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card-modern">
                <div class="stat-card-inner">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-modern bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $siswa->rombel->nama ?? '-' }}</div>
                            <div class="stat-label-modern">Rombel</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs Modern -->
    <div class="d-flex justify-content-center mb-4">
        <ul class="nav nav-tabs-modern" id="siswaTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pribadi">
                    <i class="fas fa-user me-2"></i>Data Pribadi
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#akademik">
                    <i class="fas fa-graduation-cap me-2"></i>Akademik
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ortu">
                    <i class="fas fa-users me-2"></i>Orang Tua
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#alamat">
                    <i class="fas fa-map-marker-alt me-2"></i>Alamat
                </button>
            </li>
        </ul>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        
        <!-- TAB DATA PRIBADI -->
        <div class="tab-pane fade show active" id="pribadi">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Informasi Pribadi
                    </h5>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table-modern">
                                <tbody>
                                    <tr><th>NIS</th><td>{{ $siswa->nis ?? '-' }}</td></tr>
                                    <tr><th>NISN</th><td>{{ $siswa->nisn ?? '-' }}</td></tr>
                                    <tr><th>Nama Lengkap</th><td class="fw-bold text-primary">{{ $siswa->nama_lengkap }}</td></tr>
                                    <tr><th>Tempat, Tanggal Lahir</th><td>{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') : '-' }}</td></tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>
                                            @php $gender = strtolower($siswa->jenis_kelamin ?? ''); @endphp
                                            @if(str_contains($gender, 'laki'))
                                                <span class="gender-modern gender-male"><i class="fas fa-mars"></i> Laki-laki</span>
                                            @elseif(str_contains($gender, 'perempuan'))
                                                <span class="gender-modern gender-female"><i class="fas fa-venus"></i> Perempuan</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $siswa->jenis_kelamin ?? '-' }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table-modern">
                                <tbody>
                                    <tr><th>Agama</th><td>{{ $siswa->agama ?? '-' }}</td></tr>
                                    <tr><th>Kewarganegaraan</th><td>{{ $siswa->kewarganegaraan ?? '-' }}</td></tr>
                                    <tr><th>Sekolah Asal</th><td>{{ $siswa->sekolah_asal ?? '-' }}</td></tr>
                                    <tr><th>Tanggal Diterima</th><td>{{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->format('d-m-Y') : '-' }}</td></tr>
                                    <tr><th>No. HP</th><td>{{ $siswa->no_hp ?? '-' }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB AKADEMIK -->
        <div class="tab-pane fade" id="akademik">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-graduation-cap me-2"></i>Informasi Akademik
                    </h5>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table-modern">
                                <tbody>
                                    <tr><th>Tingkat</th><td>{{ $siswa->rombel->kelas->tingkat ?? '-' }}</td></tr>
                                    <tr><th>Jurusan</th><td>{{ $siswa->rombel->kelas->jurusan->nama ?? '-' }}</td></tr>
                                    <tr><th>Rombel</th><td class="fw-bold">{{ $siswa->rombel->nama ?? '-' }}</td></tr>
                                    <tr><th>Wali Kelas</th><td>{{ $siswa->rombel->guru->nama ?? '-' }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table-modern">
                                <tbody>
                                    <tr><th>Tahun Ajaran</th><td>{{ session('tahun_ajaran') ?? date('Y') . '/' . (date('Y')+1) }}</td></tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if($statusMutasi == 'aktif')
                                                <span class="status-badge bg-success bg-opacity-10 text-success"><i class="fas fa-check-circle"></i> Aktif</span>
                                            @elseif($statusMutasi == 'lulus')
                                                <span class="status-badge bg-primary bg-opacity-10 text-primary"><i class="fas fa-trophy"></i> Lulus</span>
                                            @elseif($statusMutasi == 'pindah')
                                                <span class="status-badge bg-warning bg-opacity-10 text-warning"><i class="fas fa-exchange-alt"></i> Pindah</span>
                                            @else
                                                <span class="status-badge bg-secondary bg-opacity-10 text-secondary">{{ $statusMutasi }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @php
                        $kelengkapan = 0;
                        $totalFields = 9;
                        $fields = ['nis', 'nisn', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'no_hp', 'rombel_id'];
                        foreach($fields as $f) if(!empty($siswa->$f)) $kelengkapan++;
                        $persen = round(($kelengkapan / $totalFields) * 100);
                    @endphp
                    
                    <div class="mt-4 p-3 bg-light rounded-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small text-muted">Kelengkapan Data</span>
                            <span class="small fw-bold">{{ $persen }}%</span>
                        </div>
                        <div class="progress progress-custom">
                            <div class="progress-bar" style="width: {{ $persen }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB ORANG TUA -->
        <div class="tab-pane fade" id="ortu">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-users me-2"></i>Data Orang Tua & Wali
                    </h5>
                </div>
                <div class="p-4">
                    <!-- Ayah -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-male text-primary me-2"></i>Data Ayah</h6>
                        <div class="bg-light rounded-3 p-3">
                            <table class="table-modern mb-0">
                                <tbody>
                                    <tr><th style="width: 120px">Nama</th><td>{{ $siswa->ayah->nama ?? '-' }}</td></tr>
                                    <tr><th>Pekerjaan</th><td>{{ $siswa->ayah->pekerjaan ?? '-' }}</td></tr>
                                    <tr><th>Telepon</th><td>{{ $siswa->ayah->telepon ?? '-' }}</td></tr>
                                    <tr><th>Alamat</th><td>{{ $siswa->ayah->alamat ?? '-' }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Ibu -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-female text-pink me-2" style="color: #db2777;"></i>Data Ibu</h6>
                        <div class="bg-light rounded-3 p-3">
                            <table class="table-modern mb-0">
                                <tbody>
                                    <tr><th style="width: 120px">Nama</th><td>{{ $siswa->ibu->nama ?? '-' }}</td></tr>
                                    <tr><th>Pekerjaan</th><td>{{ $siswa->ibu->pekerjaan ?? '-' }}</td></tr>
                                    <tr><th>Telepon</th><td>{{ $siswa->ibu->telepon ?? '-' }}</td></tr>
                                    <tr><th>Alamat</th><td>{{ $siswa->ibu->alamat ?? '-' }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Wali -->
                    @if($siswa->wali)
                    <div>
                        <h6 class="fw-bold mb-3"><i class="fas fa-user-shield text-secondary me-2"></i>Data Wali</h6>
                        <div class="bg-light rounded-3 p-3">
                            <table class="table-modern mb-0">
                                <tbody>
                                    <tr><th style="width: 120px">Nama</th><td>{{ $siswa->wali->nama ?? '-' }}</td></tr>
                                    <tr><th>Pekerjaan</th><td>{{ $siswa->wali->pekerjaan ?? '-' }}</td></tr>
                                    <tr><th>Telepon</th><td>{{ $siswa->wali->telepon ?? '-' }}</td></tr>
                                    <tr><th>Alamat</th><td>{{ $siswa->wali->alamat ?? '-' }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- TAB ALAMAT -->
        <div class="tab-pane fade" id="alamat">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-map-marker-alt me-2"></i>Alamat Lengkap
                    </h5>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table-modern">
                                <tbody>
                                    <tr><th>Dusun</th><td>{{ $siswa->dusun ?? '-' }}</td></tr>
                                    <tr><th>RT / RW</th><td>{{ $siswa->rt ?? '-' }} / {{ $siswa->rw ?? '-' }}</td></tr>
                                    <tr><th>Kelurahan/Desa</th><td>{{ $siswa->kelurahan ?? '-' }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table-modern">
                                <tbody>
                                    <tr><th>Kecamatan</th><td>{{ $siswa->kecamatan ?? '-' }}</td></tr>
                                    <tr><th>Kode Pos</th><td>{{ $siswa->kode_pos ?? '-' }}</td></tr>
                                    <tr>
                                        <th>Alamat Lengkap</th>
                                        <td class="text-break">
                                            {{ 
                                                collect([
                                                    $siswa->dusun ? 'Dusun ' . $siswa->dusun : '',
                                                    $siswa->rt || $siswa->rw ? 'RT/RW ' . ($siswa->rt ?? '-') . '/' . ($siswa->rw ?? '-') : '',
                                                    $siswa->kelurahan,
                                                    $siswa->kecamatan,
                                                    $siswa->kode_pos ? 'Kode Pos ' . $siswa->kode_pos : ''
                                                ])->filter()->join(', ')
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const exportBtn = document.getElementById('btnExportPDF');
        if (exportBtn) {
            exportBtn.addEventListener('click', function(e) {
                const btn = this;
                const originalIcon = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i>';
                btn.classList.add('btn-loading');
                setTimeout(function() {
                    btn.innerHTML = originalIcon;
                    btn.classList.remove('btn-loading');
                }, 2000);
            });
        }
    });
</script>
@endsection