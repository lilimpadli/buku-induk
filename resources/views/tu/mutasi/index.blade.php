@extends('layouts.app')

@section('title', 'Mutasi Siswa')

@section('content')
<style>
    :root {
        --primary: #3b82f6;
        --primary-dark: #2563eb;
        --success: #10b981;
        --success-dark: #059669;
        --warning: #f59e0b;
        --warning-dark: #d97706;
        --danger: #ef4444;
        --danger-dark: #dc2626;
        --info: #3b82f6;
        --gray-50: #f8fbff;
        --gray-100: #eef4ff;
        --gray-200: #dbeafe;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1f2937;
        --gray-900: #0f172a;
        --shadow-sm: 0 4px 12px rgba(15, 23, 42, 0.06);
        --shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        --shadow-md: 0 24px 60px rgba(15, 23, 42, 0.1);
        --shadow-lg: 0 32px 90px rgba(15, 23, 42, 0.12);
        --shadow-xl: 0 36px 100px rgba(15, 23, 42, 0.14);
    }

    body {
        background: linear-gradient(180deg, #f8fbff 0%, #eef4ff 100%);
        color: var(--gray-900);
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        min-height: 100vh;
    }

    .container-fluid {
        padding-top: 24px;
        padding-bottom: 32px;
    }

    .page-header {
        position: relative;
        overflow: hidden;
        padding: 32px 34px;
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(236, 246, 255, 0.95));
        box-shadow: 0 28px 80px rgba(59, 130, 246, 0.12);
        margin-bottom: 36px;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 24px;
        align-items: center;
    }

    .page-header::before,
    .page-header::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        opacity: 0.8;
    }

    .page-header::before {
        width: 180px;
        height: 180px;
        top: -48px;
        right: -40px;
        background: rgba(59, 130, 246, 0.18);
        filter: blur(20px);
    }

    .page-header::after {
        width: 220px;
        height: 220px;
        bottom: -72px;
        left: -56px;
        background: rgba(14, 165, 233, 0.14);
        filter: blur(30px);
    }

    .hero-copy {
        max-width: 720px;
    }

    .hero-title {
        font-size: clamp(32px, 5vw, 42px);
        line-height: 1.02;
        font-weight: 800;
        margin: 0;
        color: var(--gray-900);
    }

    .hero-subtitle {
        margin-top: 12px;
        color: var(--gray-600);
        font-size: 15px;
        line-height: 1.7;
        max-width: 720px;
    }

    .hero-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .hero-actions .btn {
        min-width: 230px;
        border-radius: 18px;
        box-shadow: 0 18px 40px rgba(59, 130, 246, 0.18);
    }

    .jurusan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .jurusan-card {
        position: relative;
        background: #ffffff;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, 0.16);
        box-shadow: var(--shadow);
        transition: transform 0.32s ease, box-shadow 0.32s ease, border-color 0.32s ease;
        display: flex;
        flex-direction: column;
    }

    .jurusan-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(59, 130, 246, 0.24);
    }

    .jurusan-card::before {
        content: '';
        position: absolute;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        top: -30px;
        right: -30px;
        background: rgba(59, 130, 246, 0.12);
        pointer-events: none;
    }

    .jurusan-card::after {
        content: '';
        position: absolute;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        bottom: -20px;
        left: -20px;
        background: rgba(14, 165, 233, 0.08);
        pointer-events: none;
    }

    .jurusan-card-header {
        position: relative;
        padding: 28px 26px 22px;
        background: linear-gradient(180deg, #f8fbff 0%, #eef4ff 100%);
        display: grid;
        gap: 18px;
    }

    .jurusan-card-badge-top {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 16px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.03em;
        color: white;
        text-transform: uppercase;
        width: fit-content;
        box-shadow: 0 18px 40px rgba(59, 130, 246, 0.14);
        background: var(--primary);
    }

    .jurusan-card-header-icon {
        width: 68px;
        height: 68px;
        border-radius: 22px;
        display: grid;
        place-items: center;
        font-size: 24px;
        color: #ffffff;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.95), rgba(96, 165, 250, 0.75));
        box-shadow: 0 18px 40px rgba(59, 130, 246, 0.16);
    }

    .jurusan-card-title {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        color: var(--gray-900);
        line-height: 1.2;
    }

    .jurusan-card-subtitle {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: var(--gray-600);
        font-weight: 600;
    }

    .jurusan-card-headline {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: flex-start;
    }

    .jurusan-card-headline-left {
        display: grid;
        gap: 14px;
    }

    .jurusan-card-stats {
        display: grid;
        gap: 10px;
        justify-items: end;
    }

    .jurusan-card-siswa {
        font-size: 32px;
        font-weight: 800;
        color: #1e3a8a;
        line-height: 1;
    }

    .jurusan-card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 12px;
    }

    .jurusan-card-meta span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 16px;
        font-size: 13px;
        font-weight: 600;
        color: #1d4ed8;
        background: rgba(59, 130, 246, 0.08);
    }

    .jurusan-card-body {
        padding: 24px 26px 26px;
        flex: 1;
    }

    .jurusan-card-description {
        color: var(--gray-600);
        margin: 0;
        line-height: 1.75;
        font-size: 15px;
    }

    .jurusan-card-footer {
        padding: 20px 24px 24px;
        border-top: 1px solid rgba(148, 163, 184, 0.16);
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        background: #f8fbff;
    }

    .btn {
        border-radius: 14px;
        font-weight: 700;
        padding: 12px 20px;
        transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 16px 36px rgba(59, 130, 246, 0.12);
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-outline-primary {
        background: transparent;
        color: var(--primary);
        border: 2px solid rgba(59, 130, 246, 0.35);
        box-shadow: none;
    }

    .btn-outline-primary:hover {
        background: var(--primary);
        color: white;
        box-shadow: 0 18px 40px rgba(59, 130, 246, 0.18);
    }

    .btn-outline-secondary {
        background: rgba(255, 255, 255, 0.95);
        color: var(--gray-700);
        border: 2px solid rgba(148, 163, 184, 0.32);
        box-shadow: none;
    }

    .btn-outline-secondary:hover {
        background: #f1f5f9;
        border-color: rgba(148, 163, 184, 0.45);
    }

    .dropdown-toggle {
        background: rgba(255, 255, 255, 0.95);
        color: var(--gray-700);
        border: 1px solid rgba(148, 163, 184, 0.3);
        padding: 10px 18px;
        border-radius: 14px;
        font-weight: 600;
    }

    .dropdown-toggle:hover {
        background: #eff6ff;
        border-color: rgba(59, 130, 246, 0.4);
    }

    .dropdown-menu {
        border: 1px solid rgba(148, 163, 184, 0.22);
        box-shadow: var(--shadow-sm);
        border-radius: 16px;
        padding: 10px;
    }

    .dropdown-item {
        padding: 12px 16px;
        border-radius: 12px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--gray-700);
    }

    .dropdown-item:hover {
        background: rgba(59, 130, 246, 0.08);
        color: var(--primary);
    }

    .dropdown-item i {
        font-size: 16px;
        width: 22px;
        text-align: center;
    }

    .empty-state {
        grid-column: 1 / -1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 64px 28px;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: var(--shadow-sm);
    }

    .empty-state i {
        font-size: 82px;
        margin-bottom: 24px;
        color: rgba(59, 130, 246, 0.3);
    }

    .empty-state h3 {
        font-size: 24px;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 10px;
    }

    .empty-state p {
        color: var(--gray-500);
        margin: 0;
        max-width: 420px;
        line-height: 1.8;
    }

    .modal-content {
        border: none;
        border-radius: 18px;
        box-shadow: var(--shadow-xl);
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        padding: 26px 28px;
        position: relative;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .modal-header .btn-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }

    .modal-title {
        font-weight: 800;
        font-size: 22px;
    }

    .modal-body {
        padding: 30px 30px 28px;
    }

    .form-check-input {
        width: 22px;
        height: 22px;
        border-radius: 8px;
        accent-color: var(--primary);
    }

    .form-check-label {
        font-size: 15px;
        color: var(--gray-800);
        font-weight: 600;
    }

    .siswa-checkbox-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-height: 420px;
        overflow-y: auto;
        padding: 6px 0;
    }

    .siswa-item {
        display: flex;
        align-items: center;
        padding: 16px 18px;
        background: rgba(59, 130, 246, 0.04);
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.25);
        transition: transform 0.2s ease, border-color 0.2s ease, background 0.2s ease;
    }

    .siswa-item:hover {
        background: rgba(59, 130, 246, 0.08);
        border-color: rgba(59, 130, 246, 0.22);
        transform: translateX(4px);
    }

    .siswa-item input[type="checkbox"] {
        margin-right: 16px;
        width: 22px;
        height: 22px;
        cursor: pointer;
    }

    .siswa-info {
        flex: 1;
    }

    .siswa-nama {
        font-weight: 700;
        color: var(--gray-900);
        font-size: 15px;
        margin-bottom: 3px;
    }

    .siswa-nis {
        font-size: 13px;
        color: var(--gray-500);
    }

    .mutasi-options {
        margin-top: 28px;
        padding-top: 28px;
        border-top: 1px solid rgba(148, 163, 184, 0.18);
    }

    .mutasi-options label {
        display: block;
        margin-bottom: 18px;
        font-weight: 700;
        color: var(--gray-700);
        font-size: 15px;
    }

    .mutasi-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 14px;
    }

    .btn-mutasi {
        padding: 14px 22px;
        border-radius: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 14px;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
    }

    .btn-mutasi:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 44px rgba(15, 23, 42, 0.12);
    }

    .btn-mutasi-naik {
        background: var(--success);
        color: white;
    }

    .btn-mutasi-lulus {
        background: var(--primary);
        color: white;
    }

    .btn-mutasi-do {
        background: var(--warning);
        color: white;
    }

    .btn-mutasi-pindah {
        background: #8b5cf6;
        color: white;
    }

    .btn-mutasi-meninggal {
        background: var(--danger);
        color: white;
        grid-column: 1 / -1;
    }

    .class-student-item {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 18px;
        background: rgba(59, 130, 246, 0.04);
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.24);
        margin-bottom: 12px;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }

    .class-student-item:hover {
        background: rgba(59, 130, 246, 0.08);
        border-color: rgba(59, 130, 246, 0.22);
        transform: translateX(4px);
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .loading {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    @media (max-width: 767px) {
        .container-fluid {
            padding-left: 14px;
            padding-right: 14px;
        }

        .page-header {
            grid-template-columns: 1fr;
            padding: 26px 20px;
        }

        .hero-actions {
            justify-content: stretch;
        }

        .hero-actions .btn {
            width: 100%;
            min-width: auto;
        }

        .jurusan-grid {
            grid-template-columns: 1fr;
            gap: 18px;
        }

        .jurusan-card {
            margin-bottom: 16px;
        }

        .jurusan-card-header {
            padding: 22px 20px 18px;
        }

        .jurusan-card-title {
            font-size: 18px;
        }

        .jurusan-card-body {
            padding: 20px 20px 22px;
        }

        .jurusan-card-footer {
            padding: 18px 20px 20px;
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .mutasi-buttons {
            grid-template-columns: 1fr;
        }

        .btn-mutasi-meninggal {
            grid-column: 1;
        }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .jurusan-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }

    @media print {
        body {
            background-color: white;
        }

        .page-header,
        .jurusan-card-footer,
        .modal {
            display: none !important;
        }

        .jurusan-card {
            box-shadow: none;
            border: 1px solid #cbd5e1;
            break-inside: avoid;
        }

        @page {
            margin: 2cm;
        }
    }

    .siswa-checkbox-group::-webkit-scrollbar {
        width: 8px;
    }

    .siswa-checkbox-group::-webkit-scrollbar-track {
        background: var(--gray-100);
        border-radius: 4px;
    }

    .siswa-checkbox-group::-webkit-scrollbar-thumb {
        background: var(--gray-300);
        border-radius: 4px;
    }

    .siswa-checkbox-group::-webkit-scrollbar-thumb:hover {
        background: var(--gray-400);
    }

    .fade-in {
        animation: fadeIn 0.35s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .jurusan-rpl,
    .jurusan-pplg {
        --jurusan-gradient: linear-gradient(135deg,#F59E0B,#FCD34D);
    }

    .jurusan-mp {
        --jurusan-gradient: linear-gradient(135deg,#7F1D1D,#991B1B);
    }

    .jurusan-ak,
    .jurusan-akl {
        --jurusan-gradient: linear-gradient(135deg,#F97316,#FB923C);
    }

    .jurusan-tjkt {
        --jurusan-gradient: linear-gradient(135deg,#38BDF8,#7DD3FC);
    }

    .jurusan-tkro,
    .jurusan-to {
        --jurusan-gradient: linear-gradient(135deg,#1D4ED8,#3B82F6);
    }

    .jurusan-dpib {
        --jurusan-gradient: linear-gradient(135deg,#6B7280,#9CA3AF);
    }

    .jurusan-sp,
    .jurusan-sk {
        --jurusan-gradient: linear-gradient(135deg,#0F172A,#374151);
    }

    .jurusan-umum {
        --jurusan-gradient: linear-gradient(135deg,#3b82f6,#60a5fa);
    }

    .jurusan-card-badge-top {
        background: var(--jurusan-gradient);
    }

    .jurusan-card-header-icon {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.9), rgba(96, 165, 250, 0.65));
    }
</style>

    <div class="container-fluid">
        <div class="page-header">
            <div class="hero-copy">
                <h1 class="hero-title">Mutasi Siswa</h1>
                <p class="hero-subtitle">Kelola mutasi siswa berdasarkan jurusan dan status akademik</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('tu.mutasi.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Mutasi Individual
                </a>
            </div>
        </div>

        @php
            $jurusanGroups = $classes->sortBy(function($kelas) { return optional($kelas->jurusan)->nama ?? ''; })
                ->groupBy(function($kelas) { return $kelas->jurusan_id ?? 'umum'; });
        @endphp

        <div class="jurusan-grid">
            @forelse($jurusanGroups as $jurusanId => $jurusanClasses)
                @php
                    $jurusan = $jurusanClasses->first()->jurusan;
                    $totalRombel = $jurusanClasses->sum(fn($kelas) => $kelas->rombels->count());
                    $totalSiswa = $jurusanClasses->flatMap(fn($kelas) => $kelas->rombels)->sum(fn($rombel) => $rombel->siswas->count());
                @endphp
                <div class="jurusan-card fade-in jurusan-{{ strtolower(optional($jurusan)->kode ?? 'umum') }}">
                    <div class="jurusan-card-header">
                        <span class="jurusan-card-badge-top">{{ optional($jurusan)->kode ?? 'Umum' }}</span>
                        <div class="jurusan-card-headline">
                            <div class="jurusan-card-headline-left">
                                <div class="jurusan-card-header-icon">
                                    <i class="fas fa-school"></i>
                                </div>
                                <div>
                                    <h3 class="jurusan-card-title">{{ optional($jurusan)->nama ?? 'Umum' }}</h3>
                                    <span class="jurusan-card-subtitle">Kode: {{ optional($jurusan)->kode ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="jurusan-card-stats">
                                <div class="jurusan-card-siswa">{{ $totalSiswa }} siswa</div>
                                <div class="jurusan-card-meta">
                                    <span><i class="fas fa-layer-group"></i> {{ $jurusanClasses->count() }} kelas</span>
                                    <span><i class="fas fa-chalkboard-teacher"></i> {{ $totalRombel }} rombel</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="jurusan-card-body">
                        <p class="jurusan-card-description">
                            Terdiri dari {{ $jurusanClasses->count() }} kelas dengan {{ $totalRombel }} rombel aktif.
                            Kelas ini berfokus pada {{ optional($jurusan)->deskripsi ?? 'berbagai bidang studi' }}.
                        </p>
                    </div>
                    <div class="jurusan-card-footer">
                        <a href="{{ optional($jurusan)->id ? route('tu.mutasi.kelas', $jurusan->id) : route('tu.mutasi.index') }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-info-circle"></i> Detail
                        </a>
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i> Lebih
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ optional($jurusan)->id ? route('tu.mutasi.kelas', $jurusan->id) : route('tu.mutasi.index') }}">
                                    <i class="fas fa-search"></i> Lihat Kelas
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('tu.siswa.create', ['jurusan_id' => optional($jurusan)->id]) }}">
                                    <i class="fas fa-user-plus"></i> Tambah Siswa
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Tidak ada jurusan tersedia</h3>
                    <p>Silakan tambahkan jurusan terlebih dahulu untuk melanjutkan.</p>
                    <a href="{{ route('tu.jurusan.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus"></i> Tambah Jurusan
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal untuk Pilih Siswa -->
    <div class="modal fade" id="siswaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Siswa untuk Mutasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAllSiswa">
                            <label class="form-check-label" for="selectAllSiswa">
                                <strong>Pilih Semua Siswa</strong>
                            </label>
                        </div>
                    </div>

                    <div class="siswa-checkbox-group" id="siswaList"></div>

                    <div class="mutasi-options" id="mutasiOptions">
                        <label>Pilih Jenis Mutasi:</label>
                        <div class="mutasi-buttons">
                            <button type="button" class="btn-mutasi btn-mutasi-naik" id="btnNaikKelas" style="display: none;">
                                <i class="fas fa-arrow-up"></i> Naik Kelas
                            </button>
                            <button type="button" class="btn-mutasi btn-mutasi-lulus" id="btnLulus" style="display: none;">
                                <i class="fas fa-graduation-cap"></i> Lulus
                            </button>
                            <button type="button" class="btn-mutasi btn-mutasi-do" id="btnDO" style="display: none;">
                                <i class="fas fa-ban"></i> Putus Sekolah
                            </button>
                            <button type="button" class="btn-mutasi btn-mutasi-pindah" id="btnPindah" style="display: none;">
                                <i class="fas fa-map-marker"></i> Pindah Sekolah
                            </button>
                            <button type="button" class="btn-mutasi btn-mutasi-meninggal" id="btnMeninggal" style="display: none;">
                                <i class="fas fa-cross"></i> Meninggal Dunia
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Daftar Siswa Kelas -->
    <div class="modal fade" id="classStudentsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="classStudentsModalLabel">Daftar Siswa Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3"><strong>Jumlah siswa:</strong> <span id="classStudentsCount">0 siswa</span></p>
                    <div class="siswa-checkbox-group" id="classStudentsList"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentKelasId = null;
        let currentMutasiType = null;

        function openSiswaModal(button, mutasiType) {
            const kelasCard = button.closest('.jurusan-card');
            currentKelasId = kelasCard.dataset.kelasId;
            currentMutasiType = mutasiType;

            const kelasName = kelasCard.dataset.kelasName;

            // Get siswa list from pre-built data
            const siswas = @json($allStudents);
            const kelasStudents = siswas.filter(s => parseInt(s.kelas_id) === parseInt(currentKelasId));

            // Build siswa list HTML
            let siswaHTML = '';
            kelasStudents.forEach(siswa => {
                siswaHTML += `
                    <div class="siswa-item fade-in">
                        <input type="checkbox" class="form-check-input siswa-checkbox" value="${siswa.id}">
                        <div class="siswa-info">
                            <div class="siswa-nama">${siswa.nama_lengkap}</div>
                            <div class="siswa-nis">NIS: ${siswa.nis} | Rombel: ${siswa.rombel_name}</div>
                        </div>
                    </div>
                `;
            });

            document.getElementById('siswaList').innerHTML = siswaHTML;
            document.getElementById('selectAllSiswa').checked = false;
            document.getElementById('selectAllSiswa').indeterminate = false;

            // Show/hide buttons based on mutasi type
            document.getElementById('btnNaikKelas').style.display = mutasiType === 'naik_kelas' ? 'block' : 'none';
            document.getElementById('btnLulus').style.display = mutasiType === 'lulus' ? 'block' : 'none';
            document.getElementById('btnDO').style.display = mutasiType === 'lainnya' ? 'block' : 'none';
            document.getElementById('btnPindah').style.display = mutasiType === 'lainnya' ? 'block' : 'none';
            document.getElementById('btnMeninggal').style.display = mutasiType === 'lainnya' ? 'block' : 'none';

            // Update modal title
            const modalTitle = document.querySelector('#siswaModal .modal-title');
            modalTitle.textContent = `Pilih Siswa - ${kelasName} (${mutasiType.replace(/_/g, ' ').toUpperCase()})`;

            const modal = new bootstrap.Modal(document.getElementById('siswaModal'));
            modal.show();

            // Setup event listeners
            setupCheckboxListeners();
        }

        function openClassStudents(button) {
            const kelasCard = button.closest('.jurusan-card');
            const kelasId = kelasCard.dataset.kelasId;
            const kelasName = kelasCard.dataset.kelasName;
            const siswas = @json($allStudents);
            const kelasStudents = siswas.filter(s => parseInt(s.kelas_id) === parseInt(kelasId));

            let studentHtml = '';
            if (kelasStudents.length === 0) {
                studentHtml = '<p class="text-muted">Belum ada siswa di kelas ini.</p>';
            } else {
                kelasStudents.forEach(siswa => {
                    studentHtml += `
                        <div class="class-student-item fade-in">
                            <div class="siswa-nama">${siswa.nama_lengkap}</div>
                            <div class="siswa-nis">NIS: ${siswa.nis}</div>
                            <div class="text-muted">Rombel: ${siswa.rombel_name}</div>
                        </div>
                    `;
                });
            }

            document.getElementById('classStudentsModalLabel').textContent = `Siswa Kelas ${kelasName}`;
            document.getElementById('classStudentsCount').textContent = `${kelasStudents.length} siswa`;
            document.getElementById('classStudentsList').innerHTML = studentHtml;

            const modal = new bootstrap.Modal(document.getElementById('classStudentsModal'));
            modal.show();
        }

        function setupCheckboxListeners() {
            const selectAllCheckbox = document.getElementById('selectAllSiswa');
            const siswaCheckboxes = document.querySelectorAll('.siswa-checkbox');

            selectAllCheckbox.addEventListener('change', function() {
                siswaCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            siswaCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(siswaCheckboxes).every(cb => cb.checked);
                    const someChecked = Array.from(siswaCheckboxes).some(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = someChecked && !allChecked;
                });
            });
        }

        // Button listeners for mutasi actions
        document.getElementById('btnNaikKelas').addEventListener('click', () => executeMutasi('naik_kelas'));
        document.getElementById('btnLulus').addEventListener('click', () => executeMutasi('lulus'));
        document.getElementById('btnDO').addEventListener('click', () => executeMutasi('do'));
        document.getElementById('btnPindah').addEventListener('click', () => executeMutasi('pindah'));
        document.getElementById('btnMeninggal').addEventListener('click', () => executeMutasi('meninggal'));

        function executeMutasi(status) {
            const siswaCheckboxes = document.querySelectorAll('.siswa-checkbox:checked');
            const siswaIds = Array.from(siswaCheckboxes).map(cb => cb.value);

            if (siswaIds.length === 0) {
                showToast('Pilih minimal 1 siswa', 'warning');
                return;
            }

            if (status === 'pindah') {
                // For pindah, ask for additional info
                showPindahForm(siswaIds);
            } else {
                // For other mutations
                submitBulkMutasi(siswaIds, status);
            }
        }

        function showPindahForm(siswaIds) {
            const alasan = prompt('Masukkan alasan pindah sekolah:');
            if (!alasan) return;
            
            const tujuan = prompt('Masukkan nama sekolah tujuan:');
            if (!tujuan) return;

            submitBulkMutasi(siswaIds, 'pindah', { alasan_pindah: alasan, tujuan_pindah: tujuan });
        }

        function submitBulkMutasi(siswaIds, status, additionalData = {}) {
            const payload = {
                siswa_ids: siswaIds,
                status: status,
                kelas_id: currentKelasId,
                ...additionalData
            };

            // Show loading state
            const submitButton = event.target;
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            submitButton.disabled = true;

            fetch('{{ route("tu.mutasi.bulk") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast('Error: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan', 'danger');
            })
            .finally(() => {
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : type === 'danger' ? 'times-circle' : 'info-circle'} me-2"></i>
                    ${message}
                </div>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            // Add ripple effect to buttons
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => ripple.remove(), 600);
                });
            });
        });
    </script>
</div>
@endsection