@extends('layouts.app')

@section('title', 'Rekap Absensi Siswa')

@section('content')
<style>
    /* ===================== STYLE REKAP ABSENSI ===================== */
    
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --danger-gradient: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --card-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        --card-hover-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --bg-light: #f5f7fb;
        --border-radius: 20px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f5 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Header */
    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.25rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.85rem;
        position: relative;
        z-index: 1;
    }

    .page-header .d-flex {
        position: relative;
        z-index: 10;
    }

    /* Tombol */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 500;
        padding: 0.5rem 1.25rem;
        border-radius: 10px;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 1.5px solid #ffffff;
        color: white;
        font-weight: 500;
        padding: 0.5rem 1.25rem;
        border-radius: 10px;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-outline-gradient:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        transform: translateY(-2px);
    }

    .btn-excel {
        background: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        border: none;
        color: white;
        font-weight: 500;
        padding: 0.5rem 1.25rem;
        border-radius: 10px;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-excel:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(19, 180, 151, 0.4);
        color: white;
    }

    .btn-outline-secondary {
        background: transparent;
        border: 1.5px solid #cbd5e1;
        color: #475569;
        font-weight: 500;
        padding: 0.5rem 1.25rem;
        border-radius: 10px;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-outline-secondary:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        transform: translateY(-2px);
    }

    /* Average Card */
    .average-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        color: white;
        text-align: center;
        box-shadow: var(--card-shadow);
    }

    .average-card .value {
        font-size: 48px;
        font-weight: 700;
    }

    .average-card .label {
        font-size: 14px;
        opacity: 0.9;
        margin-top: 4px;
    }

    .average-card .progress {
        height: 8px;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 10px;
        max-width: 300px;
        margin: 12px auto 0;
    }

    .average-card .progress-bar {
        background: white;
        border-radius: 10px;
    }

    /* Summary Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1rem 1rem;
        text-align: center;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-hover-shadow);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 1.25rem;
        color: white;
    }

    .stat-card.hadir .stat-icon { background: linear-gradient(135deg, #13B497, #34d399); }
    .stat-card.sakit .stat-icon { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .stat-card.izin .stat-icon { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
    .stat-card.alpha .stat-icon { background: linear-gradient(135deg, #ef4444, #f87171); }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }

    .stat-label {
        font-size: 12px;
        color: #64748b;
        margin-top: 4px;
    }

    /* Filter Card */
    .filter-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
    }

    /* Table */
    .table-container {
        background: white;
        border-radius: var(--border-radius);
        overflow-x: auto;
        box-shadow: var(--card-shadow);
    }

    .rekap-table {
        width: 100%;
        border-collapse: collapse;
    }

    .rekap-table thead th {
        background: #f8fafc;
        padding: 1rem;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
        text-align: center;
    }

    .rekap-table tbody td {
        padding: 0.875rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        text-align: center;
    }

    .rekap-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .student-name {
        font-weight: 600;
        color: #1e293b;
        text-align: left !important;
    }

    /* Progress Bar di Tabel */
    .progress {
        height: 28px;
        border-radius: 20px;
        background-color: #e2e8f0;
        overflow: hidden;
        margin: 0 auto;
        max-width: 120px;
    }

    .progress-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 11px;
        border-radius: 20px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
        color: #667eea;
    }

    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeInUp 0.4s ease forwards;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header { padding: 1.25rem; }
        .page-header h3 { font-size: 1.25rem; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
        .page-header .d-flex { flex-wrap: wrap; justify-content: center; margin-top: 10px; }
        .rekap-table thead th { font-size: 10px; padding: 0.5rem; }
        .rekap-table tbody td { padding: 0.5rem; font-size: 11px; }
        .progress { height: 22px; max-width: 70px; }
        .progress-bar { font-size: 9px; }
    }
</style>

<div class="container-fluid py-3">
    <!-- HEADER -->
    <div class="page-header fade-in">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3 class="mb-1">
                    <i class="fas fa-chart-line me-2"></i> Rekap Absensi Siswa
                </h3>
                <div class="text-muted">
                    <i class="fas fa-info-circle me-1"></i> Ringkasan kehadiran per siswa
                </div>
            </div>
            <div class="d-flex gap-2 mt-2 mt-sm-0">
                <a href="{{ route('walikelas.absensi.index') }}" class="btn btn-outline-gradient">
                    <i class="fas fa-calendar-check me-2"></i> Input Absensi
                </a>
                <a href="{{ route('walikelas.absensi.rekap') }}" class="btn btn-outline-gradient">
                    <i class="fas fa-sync-alt me-2"></i> Refresh
                </a>
                <a href="{{ route('walikelas.absensi.export-excel') }}?{{ http_build_query(request()->query()) }}" class="btn-excel">
                    <i class="fas fa-file-excel me-2"></i> Export Excel
                </a>
                <button onclick="window.print()" class="btn btn-gradient">
                    <i class="fas fa-print me-2"></i> Cetak
                </button>
            </div>
        </div>
    </div>

    @if(isset($rekap) && count($rekap) > 0)
        @php
            $totalHadir = collect($rekap)->sum('hadir');
            $totalSakit = collect($rekap)->sum('sakit');
            $totalIzin = collect($rekap)->sum('izin');
            $totalAlpha = collect($rekap)->sum('alpha');
            $grandTotal = $totalHadir + $totalSakit + $totalIzin + $totalAlpha;
            $avgKehadiran = $grandTotal > 0 ? round(($totalHadir / $grandTotal) * 100, 1) : 0;
        @endphp

        <!-- RATA-RATA KEHADIRAN KELAS -->
        <div class="average-card fade-in">
            <div class="value">{{ $avgKehadiran }}%</div>
            <div class="label">Rata-rata Kehadiran Kelas</div>
            <div class="progress">
                <div class="progress-bar" style="width: {{ $avgKehadiran }}%;"></div>
            </div>
        </div>

        <!-- STATISTIK 4 CARD -->
        <div class="stats-grid fade-in">
            <div class="stat-card hadir">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $totalHadir }}</div>
                <div class="stat-label">Total Hadir</div>
            </div>
            <div class="stat-card sakit">
                <div class="stat-icon">
                    <i class="fas fa-thermometer-half"></i>
                </div>
                <div class="stat-value">{{ $totalSakit }}</div>
                <div class="stat-label">Total Sakit</div>
            </div>
            <div class="stat-card izin">
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-value">{{ $totalIzin }}</div>
                <div class="stat-label">Total Izin</div>
            </div>
            <div class="stat-card alpha">
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-value">{{ $totalAlpha }}</div>
                <div class="stat-label">Total Alpha</div>
            </div>
        </div>

        <!-- FILTER -->
        <div class="filter-card fade-in">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small">
                        <i class="fas fa-calendar-alt me-1"></i> Bulan
                    </label>
                    <select name="bulan" class="form-select">
                        <option value="all">Semua Bulan</option>
                        @foreach(range(1,12) as $b)
                        <option value="{{ $b }}" {{ ($bulan ?? 'all') == $b ? 'selected' : '' }}>
                            {{ Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small">
                        <i class="fas fa-layer-group me-1"></i> Semester
                    </label>
                    <select name="semester" class="form-select">
                        <option value="1" {{ ($semester ?? 1) == 1 ? 'selected' : '' }}>Semester 1 (Juli - Desember)</option>
                        <option value="2" {{ ($semester ?? 1) == 2 ? 'selected' : '' }}>Semester 2 (Januari - Juni)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button class="btn btn-gradient px-4" type="submit">
                            <i class="fas fa-filter me-2"></i> Filter
                        </button>
                        <a href="{{ route('walikelas.absensi.rekap') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo-alt me-2"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- TABEL REKAP -->
        <div class="table-container fade-in">
            <table class="rekap-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th class="text-start">Nama Siswa</th>
                        <th width="80">Hadir</th>
                        <th width="80">Sakit</th>
                        <th width="80">Izin</th>
                        <th width="80">Alpha</th>
                        <th width="80">Total</th>
                        <th width="140">Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekap as $index => $r)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="student-name">{{ $r->siswa->nama_lengkap }}</td>
                        <td class="text-success fw-semibold">{{ $r->hadir }}</td>
                        <td class="text-warning">{{ $r->sakit }}</td>
                        <td class="text-info">{{ $r->izin }}</td>
                        <td class="text-danger">{{ $r->alpha }}</td>
                        <td class="fw-semibold">{{ $r->total }}</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: {{ $r->persentase }}%">
                                    {{ $r->persentase }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot style="background: #f8fafc; font-weight: 600;">
                    <tr>
                        <td colspan="2" class="text-end">Total</td>
                        <td class="text-center text-success">{{ $totalHadir }}</td>
                        <td class="text-center text-warning">{{ $totalSakit }}</td>
                        <td class="text-center text-info">{{ $totalIzin }}</td>
                        <td class="text-center text-danger">{{ $totalAlpha }}</td>
                        <td class="text-center">{{ $grandTotal }}</td>
                        <td class="text-center">{{ $avgKehadiran }}%</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Keterangan -->
        <div class="mt-3 text-muted small text-center">
            <i class="fas fa-info-circle me-1"></i> 
            Persentase kehadiran = (Jumlah Hadir / Total Pertemuan) × 100%
        </div>

    @else
        <div class="empty-state fade-in">
            <i class="fas fa-chart-line fa-3x mb-3"></i>
            <h5>Belum Ada Data Absensi</h5>
            <p class="text-muted">Belum ada data absensi untuk periode yang dipilih.</p>
            <a href="{{ route('walikelas.absensi.index') }}" class="btn btn-gradient mt-3">
                <i class="fas fa-calendar-check me-2"></i> Input Absensi Sekarang
            </a>
        </div>
    @endif
</div>

<style>
    @media print {
        .sidebar, .mobile-header, .btn, .filter-card, .btn-outline-gradient, .page-header .btn, .btn-excel, .btn-outline-secondary {
            display: none !important;
        }
        main {
            margin: 0 !important;
            padding: 0 !important;
        }
        .page-header, .average-card {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .stat-card {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .progress-bar {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const allBtns = document.querySelectorAll('.btn, .btn-excel, .btn-outline-gradient, .btn-outline-secondary');
        allBtns.forEach(btn => {
            btn.style.pointerEvents = 'auto';
            btn.style.cursor = 'pointer';
        });
    });
</script>
@endsection