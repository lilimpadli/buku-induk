@extends('layouts.app')

@section('title', 'Data Alumni')

@section('content')

<style>
    :root {
        --primary: #4F46E5;
        --primary-light: #6366F1;
        --secondary: #7C3AED;
        --success: #10B981;
        --warning: #F59E0B;
        --danger: #EF4444;
        --info: #3B82F6;
        --gray-50: #F8FAFC;
        --gray-100: #F1F5F9;
        --gray-200: #E2E8F0;
        --gray-500: #64748B;
        --gray-700: #334155;
        --gray-800: #1E293B;
        --shadow-sm: 0 2px 8px rgba(15,23,42,.05);
        --shadow-md: 0 10px 25px rgba(15,23,42,.08);
        --shadow-lg: 0 18px 35px rgba(15,23,42,.12);
    }

    body { background: linear-gradient(180deg, #F8FAFF 0%, #EEF2FF 100%); }

    .hero-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 28px;
        padding: 40px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .hero-banner::before,
    .hero-banner::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
        pointer-events: none;
    }

    .hero-banner::before {
        width: 300px; height: 300px;
        top: -120px; right: -80px;
    }

    .hero-banner::after {
        width: 200px; height: 200px;
        bottom: -80px; left: -60px;
        background: rgba(255,255,255,.05);
    }

    .hero-content {
        position: relative; z-index: 2;
        display: flex; justify-content: space-between;
        align-items: center; gap: 24px; flex-wrap: wrap;
    }

    .hero-title {
        font-size: 36px; font-weight: 800;
        color: white; margin: 0 0 8px 0;
        letter-spacing: -0.5px;
    }

    .hero-subtitle {
        color: rgba(255,255,255,.85);
        font-size: 15px; margin: 0;
    }

    .hero-stats {
        display: flex; gap: 16px; margin-top: 24px; flex-wrap: wrap;
    }

    .hero-stat {
        background: rgba(255,255,255,.15);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 16px;
        padding: 14px 22px;
        min-width: 120px;
        color: white;
    }

    .hero-stat-value {
        font-size: 26px; font-weight: 800; line-height: 1.1;
    }

    .hero-stat-label {
        font-size: 11px; opacity: .85;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-top: 4px;
    }

    .hero-actions {
        display: flex; gap: 10px; flex-wrap: wrap;
    }

    .btn-hero {
        background: white;
        color: var(--primary);
        border: none;
        border-radius: 14px;
        padding: 12px 22px;
        font-weight: 700;
        font-size: 14px;
        display: inline-flex; align-items: center; gap: 8px;
        text-decoration: none;
        transition: all .25s ease;
        box-shadow: 0 6px 18px rgba(79,70,229,.15);
        cursor: pointer;
    }

    .btn-hero:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(79,70,229,.25);
        color: var(--primary);
    }

    .btn-hero.btn-hero-success { color: var(--success); }
    .btn-hero.btn-hero-danger { color: var(--danger); }
    .btn-hero.btn-hero-warning { color: var(--warning); }

    .filter-card {
        background: white;
        border-radius: 24px;
        padding: 24px;
        margin-bottom: 28px;
        border: 1px solid #EEF2FF;
        box-shadow: var(--shadow-md);
    }

    .filter-title {
        font-size: 16px; font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 18px;
        display: flex; align-items: center; gap: 10px;
    }

    .filter-title i { color: var(--primary); }

    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 14px;
    }

    .form-control-modern,
    .form-select-modern {
        width: 100%; height: 46px;
        border-radius: 12px;
        border: 1.5px solid #E2E8F0;
        padding: 0 16px;
        font-size: 14px;
        background: #F8FAFF;
        transition: all .2s;
    }

    .form-control-modern:focus,
    .form-select-modern:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(79,70,229,.08);
    }

    .alumni-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .alumni-card {
        background: white;
        border-radius: 22px;
        border: 1px solid #EEF2FF;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: all .3s cubic-bezier(.4,0,.2,1);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .alumni-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
    }

    .alumni-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(79,70,229,.3);
    }

    .card-head {
        padding: 20px 22px 16px;
        border-bottom: 1px solid #F1F5F9;
    }

    .badge-tahun {
        display: inline-flex; align-items: center; gap: 6px;
        background: linear-gradient(135deg, #EEF2FF, #E0E7FF);
        color: var(--primary);
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 12px; font-weight: 700;
        margin-bottom: 10px;
    }

    .card-jurusan {
        font-size: 18px; font-weight: 800;
        color: var(--gray-800);
        margin: 0 0 6px;
        line-height: 1.3;
    }

    .card-sub {
        font-size: 13px; color: var(--gray-500);
        display: flex; align-items: center; gap: 6px;
    }

    .card-body-modern {
        padding: 18px 22px;
        flex: 1;
    }

    .stat-block {
        text-align: center;
        margin-bottom: 16px;
    }

    .stat-num {
        font-size: 40px; font-weight: 800;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
    }

    .stat-lbl {
        font-size: 12px; color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-top: 6px;
    }

    .preview-list {
        background: #F8FAFF;
        border-radius: 14px;
        padding: 12px 14px;
        margin-top: 14px;
    }

    .preview-title {
        font-size: 11px; font-weight: 700;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 8px;
    }

    .preview-item {
        display: flex; align-items: center; gap: 8px;
        padding: 6px 0;
        border-bottom: 1px dashed #E2E8F0;
        font-size: 13px;
        color: var(--gray-700);
    }

    .preview-item:last-child { border-bottom: none; }

    .preview-item strong {
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 600;
    }

    .preview-more {
        font-size: 12px; color: var(--primary);
        font-weight: 700;
        text-align: center;
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid #E2E8F0;
    }

    .card-foot {
        padding: 14px 22px 18px;
        background: #FAFBFF;
        border-top: 1px solid #F1F5F9;
    }

    .btn-detail {
        width: 100%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 18px;
        font-weight: 700;
        font-size: 14px;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        text-decoration: none;
        transition: all .25s;
        cursor: pointer;
    }

    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79,70,229,.3);
        color: white;
    }

    .empty-state {
        background: white;
        border-radius: 24px;
        padding: 70px 24px;
        text-align: center;
        box-shadow: var(--shadow-md);
    }

    .empty-icon {
        width: 90px; height: 90px;
        background: linear-gradient(135deg, #EEF2FF, #E0E7FF);
        color: var(--primary);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 22px;
        font-size: 40px;
    }

    .empty-title {
        font-size: 22px; font-weight: 800;
        color: var(--gray-800);
        margin-bottom: 8px;
    }

    .empty-desc {
        font-size: 14px; color: var(--gray-500);
        max-width: 400px;
        margin: 0 auto 24px;
    }

    @media (max-width: 992px) {
        .filter-grid { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 768px) {
        .hero-banner { padding: 26px; }
        .hero-title { font-size: 26px; }
        .filter-grid { grid-template-columns: 1fr; }
        .alumni-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    @if(session('success') || session('warning') || session('error') || session('import_errors'))
    <div class="mb-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('import_errors'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> Beberapa baris tidak berhasil diimport:
                <ul class="mb-0 mt-2">
                    @foreach(session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
    @endif

    <div class="hero-banner">
        <div class="hero-content">
            <div>
                <h1 class="hero-title">
                    <i class="fas fa-user-graduate me-2"></i> Data Alumni
                </h1>
                <p class="hero-subtitle">
                    Lacak dan kelola data lulusan SMKN 1 Kawali
                </p>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ $totalAlumni }}</div>
                        <div class="hero-stat-label">Total Alumni</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ $totalJurusan }}</div>
                        <div class="hero-stat-label">Jurusan</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">{{ $totalTahun }}</div>
                        <div class="hero-stat-label">Tahun Lulus</div>
                    </div>
                </div>
            </div>
            <div class="hero-actions">
                <button type="button" class="btn-hero btn-hero-warning" data-bs-toggle="modal" data-bs-target="#importNilaiAlumniModal">
                    <i class="fas fa-file-import"></i> Import Nilai
                </button>
                <a href="{{ route('tu.alumni.export.excel', request()->query()) }}" class="btn-hero btn-hero-success">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
                <a href="{{ route('tu.alumni.export.pdf', request()->query()) }}" class="btn-hero btn-hero-danger">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
        </div>
    </div>

    <div class="filter-card">
        <div class="filter-title">
            <i class="fas fa-sliders-h"></i> Filter Pencarian
        </div>
        <form method="GET" action="{{ route('tu.alumni.index') }}">
            <div class="filter-grid">
                <input type="text" name="search" class="form-control-modern"
                       placeholder="Cari nama / NIS / NISN..."
                       value="{{ $search }}">

                <select name="tahun_ajaran" class="form-select-modern">
                    <option value="">-- Semua Tahun --</option>
                    @foreach($tahunAjaranList as $th)
                        <option value="{{ $th }}" {{ $tahunSearch == $th ? 'selected' : '' }}>
                            Tahun {{ $th }}
                        </option>
                    @endforeach
                </select>

                <select name="jurusan_id" class="form-select-modern">
                    <option value="">-- Semua Jurusan --</option>
                    @foreach($allJurusan as $j)
                        <option value="{{ $j->id }}" {{ $jurusanSearch == $j->id ? 'selected' : '' }}>
                            {{ $j->nama }}
                        </option>
                    @endforeach
                </select>

                <div style="display: flex; gap: 8px;">
                    <select name="sort" class="form-select-modern" style="flex: 1;">
                        <option value="tahun_desc" {{ $sortBy == 'tahun_desc' ? 'selected' : '' }}>Tahun Terbaru</option>
                        <option value="tahun_asc"  {{ $sortBy == 'tahun_asc'  ? 'selected' : '' }}>Tahun Terlama</option>
                        <option value="nama_asc"   {{ $sortBy == 'nama_asc'   ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="nama_desc"  {{ $sortBy == 'nama_desc'  ? 'selected' : '' }}>Nama Z-A</option>
                    </select>
                    <button type="submit" class="btn-hero" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 0 20px;">
                        <i class="fas fa-search"></i>
                    </button>
                    @if($search || $tahunSearch || $jurusanSearch || $sortBy != 'tahun_desc')
                        <a href="{{ route('tu.alumni.index') }}" class="btn-hero" style="padding: 0 16px;">
                            <i class="fas fa-rotate-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    @if(count($groupedCards) > 0)
        <div class="alumni-grid">
            @foreach($groupedCards as $card)
                <div class="alumni-card">
                    <div class="card-head">
                        <span class="badge-tahun">
                            <i class="fas fa-calendar-alt"></i>
                            Lulus {{ $card['tahun'] }}
                        </span>
                        <h3 class="card-jurusan">{{ $card['jurusan'] }}</h3>
                        <div class="card-sub">
                            <i class="fas fa-school"></i> SMKN 1 Kawali
                        </div>
                    </div>

                    <div class="card-body-modern">
                        <div class="stat-block">
                            <div class="stat-num">{{ $card['count'] }}</div>
                            <div class="stat-lbl">Alumni</div>
                        </div>

                        @if(!empty($card['siswa']))
                            <div class="preview-list">
                                <div class="preview-title">Contoh Alumni</div>
                                @foreach(array_slice($card['siswa'], 0, 5) as $s)
                                    <div class="preview-item">
                                        <i class="fas fa-user-circle" style="color: #94A3B8;"></i>
                                        <strong>{{ $s['nama'] }}</strong>
                                        <span style="color: #94A3B8; font-size: 11px;">{{ $s['nis'] }}</span>
                                    </div>
                                @endforeach
                                @if($card['count'] > 5)
                                    <div class="preview-more">
                                        + {{ $card['count'] - 5 }} alumni lainnya
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="card-foot">
                        @if($card['jurusan_id'])
                            <a href="{{ route('tu.alumni.by-jurusan', ['jurusanId' => $card['jurusan_id']]) }}?tahun={{ urlencode($card['tahun']) }}"
                               class="btn-detail">
                                <i class="fas fa-eye"></i> Lihat Semua Alumni
                            </a>
                        @else
                            <button class="btn-detail" disabled style="background: #E2E8F0; cursor: not-allowed;">
                                <i class="fas fa-exclamation-triangle"></i> Jurusan Belum Teridentifikasi
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h3 class="empty-title">Belum Ada Data Alumni</h3>
            <p class="empty-desc">
                @if($search || $tahunSearch || $jurusanSearch)
                    Tidak ada alumni yang cocok dengan filter kamu. Coba ubah kata kunci atau reset filter.
                @else
                    Data alumni akan muncul setelah siswa lulus dan tercatat sebagai alumni.
                @endif
            </p>
            @if($search || $tahunSearch || $jurusanSearch)
                <a href="{{ route('tu.alumni.index') }}" class="btn-hero" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white;">
                    <i class="fas fa-rotate-right"></i> Reset Filter
                </a>
            @else
                <a href="{{ route('tu.siswa.index') }}" class="btn-hero" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white;">
                    <i class="fas fa-users"></i> Kelola Siswa
                </a>
            @endif
        </div>
    @endif

</div>

<!-- MODAL IMPORT NILAI ALUMNI -->
<div class="modal fade" id="importNilaiAlumniModal" tabindex="-1" aria-labelledby="importNilaiAlumniModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid #F1F5F9; padding: 20px 24px;">
                <h5 class="modal-title" id="importNilaiAlumniModalLabel" style="font-weight: 700;">
                    <i class="fas fa-file-import me-2" style="color: var(--primary);"></i> Import Nilai Rapor Alumni
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tu.alumni.import.nilai') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="padding: 24px;">
                    <p class="text-muted" style="font-size: 13px;">
                        Pilih file Excel (.xlsx / .xls / .csv) berisi nilai rapor alumni.
                        Pastikan format kolom: <b>B=NIS, C=NISN, F=Semester, G=Tahun Ajaran, H+=Nama Mapel</b>.
                    </p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size: 13px;">Semester (default)</label>
                        <select name="semester" class="form-select" required>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size: 13px;">Tahun Ajaran (default)</label>
                        <input type="text" name="tahun_ajaran" class="form-control" value="2022/2023" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size: 13px;">File Excel</label>
                        <input class="form-control" type="file" name="file" accept=".xlsx,.xls,.csv" required>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #F1F5F9; padding: 16px 24px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; font-weight: 700; border-radius: 10px; padding: 10px 24px;">
                        <i class="fas fa-cloud-upload-alt me-2"></i> Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection