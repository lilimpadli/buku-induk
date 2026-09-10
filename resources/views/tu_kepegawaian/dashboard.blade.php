@extends('layouts.app')

@section('title', 'Dashboard TU Kepegawaian')

@section('content')

@once
<style>
    .stat-card, .rekap-item { transition: transform .2s ease, box-shadow .2s ease; }
    .stat-card:hover, .rekap-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 .75rem 1.5rem rgba(0,0,0,.09) !important;
    }
    .icon-box { width: 54px; height: 54px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .label-sm { font-size: .72rem; letter-spacing: .5px; }
    .card-title-sm { font-size: .8rem; letter-spacing: .5px; }
    .rekap-num { font-size: 1.5rem; }
    .avatar-initial {
        width: 40px; height: 40px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .85rem; flex-shrink: 0;
    }
</style>
@endonce

@php
    // ═══ REKAP GURU ═══
    $guruTotal  = (int) ($totalGuru ?? 0);
    $guruPNS    = (int) ($totalGuruPNS ?? 0);
    $guruPPPK   = (int) ($totalGuruPPPK ?? 0);
    $guruParuh  = (int) ($totalGuruPPPKParuh ?? 0);
    $guruLain   = max(0, $guruTotal - ($guruPNS + $guruPPPK + $guruParuh));

    $persenGuruPNS   = $guruTotal > 0 ? round(($guruPNS  / $guruTotal) * 100) : 0;
    $persenGuruPPPK  = $guruTotal > 0 ? round(($guruPPPK / $guruTotal) * 100) : 0;
    $persenGuruParuh = $guruTotal > 0 ? round(($guruParuh / $guruTotal) * 100) : 0;

    // ═══ REKAP PEGAWAI ═══
    $tuTotal  = (int) ($totalPegawai ?? 0);
    $tuPNS    = (int) ($totalTUPNS ?? 0);
    $tuPPPK   = (int) ($totalTUPPPK ?? 0);
    $tuParuh  = (int) ($totalTUPPKParuh ?? 0);
    $tuLain   = max(0, $tuTotal - ($tuPNS + $tuPPPK + $tuParuh));

    $persenTUPNS   = $tuTotal > 0 ? round(($tuPNS  / $tuTotal) * 100) : 0;
    $persenTUPPPK  = $tuTotal > 0 ? round(($tuPPPK / $tuTotal) * 100) : 0;
    $persenTUPPKParuh = $tuTotal > 0 ? round(($tuParuh / $tuTotal) * 100) : 0;

    // Warna badge status
    $badgeStatus = function (?string $status) {
        return match (strtolower(trim($status ?? ''))) {
            'pns'               => 'primary',
            'pppk'              => 'info',
            'pppk paruh waktu'  => 'warning',
            default             => 'secondary',
        };
    };
@endphp

<div class="container-fluid px-4 py-4" style="background-color: #f4f6f9; min-height: 100vh;">

    {{-- ==========================================================
         HEADER UTAMA
    ========================================================== --}}
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Dashboard Kepegawaian</h4>
            <p class="text-muted small mb-0">
                <i class="fas fa-sitemap text-primary me-1"></i>
                Sistem Informasi Pengelolaan Data Guru dan Tenaga Kependidikan
            </p>
        </div>
        <div class="mt-3 mt-lg-0 bg-white px-3 py-2 rounded-3 border shadow-sm text-secondary small fw-medium d-inline-flex align-items-center">
            <i class="far fa-calendar-alt text-primary me-2"></i>
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    {{-- ==========================================================
         KARTU STATISTIK UTAMA
    ========================================================== --}}
    <div class="row g-3 g-xl-4 mb-4">

        {{-- Total Guru --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('tu_kepegawaian.guru.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 stat-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <span class="text-secondary label-sm text-uppercase fw-semibold d-block mb-1">Total Guru</span>
                                <h2 class="fw-bold text-dark mb-0">{{ $guruTotal }}</h2>
                            </div>
                            <div class="icon-box rounded-3 text-white" style="background: linear-gradient(135deg, #0d6efd, #4d9aff);">
                                <i class="fas fa-chalkboard-teacher fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- TU Akademik --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('tu_kepegawaian.tu.index', ['role' => 'tu']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 stat-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <span class="text-secondary label-sm text-uppercase fw-semibold d-block mb-1">TU Akademik</span>
                                <h2 class="fw-bold text-dark mb-0">{{ $totalTU ?? 0 }}</h2>
                            </div>
                            <div class="icon-box rounded-3 text-white" style="background: linear-gradient(135deg, #198754, #47c78a);">
                                <i class="fas fa-user-graduate fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- TU Kepegawaian --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('tu_kepegawaian.tu.index', ['role' => 'tu_kepegawaian']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 stat-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <span class="text-secondary label-sm text-uppercase fw-semibold d-block mb-1">TU Kepegawaian</span>
                                <h2 class="fw-bold text-dark mb-0">{{ $totalTUKepegawaian ?? 0 }}</h2>
                            </div>
                            <div class="icon-box rounded-3 text-white" style="background: linear-gradient(135deg, #0aa2c0, #0dcaf0);">
                                <i class="fas fa-users-cog fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Total Personel --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 stat-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <span class="text-secondary label-sm text-uppercase fw-semibold d-block mb-1">Total Personel</span>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalStaffAktif ?? 0 }}</h2>
                            <small class="text-muted">{{ $guruTotal }} guru + {{ $tuTotal }} pegawai</small>
                        </div>
                        <div class="icon-box rounded-3 text-white" style="background: linear-gradient(135deg, #f59f00, #fcc419);">
                            <i class="fas fa-user-tie fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==========================================================
         REKAP GURU & PEGAWAI — BERSEBELAHAN
    ========================================================== --}}
    <div class="row g-3 g-xl-4 mb-4">

        {{-- ===== REKAP DATA GURU (KIRI) ===== --}}
        <div class="col-12 col-lg-6 d-flex">
            <div class="card border-0 shadow-sm rounded-4 bg-white w-100">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0 text-uppercase card-title-sm">
                        <i class="fas fa-chalkboard-teacher text-primary me-2"></i> Rekap Data Guru
                    </h6>
                    <a href="{{ route('tu_kepegawaian.guru.index') }}" class="btn btn-sm btn-outline-primary rounded-3 px-3">
                        Kelola <i class="fas fa-arrow-right ms-1" style="font-size:.7rem;"></i>
                    </a>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="row g-3">

                        {{-- Total --}}
                        <div class="col-6">
                            <a href="{{ route('tu_kepegawaian.guru.index') }}" class="text-decoration-none rekap-item d-block h-100">
                                <div class="p-3 rounded-3 border h-100 bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-secondary label-sm text-uppercase fw-semibold">Total</span>
                                        <i class="fas fa-users text-secondary"></i>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-2 rekap-num">{{ $guruTotal }}</h3>
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-secondary" style="width: 100%"></div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- PNS --}}
                        <div class="col-6">
                            <a href="{{ route('tu_kepegawaian.guru.index', ['status_kepegawaian' => 'PNS']) }}" class="text-decoration-none rekap-item d-block h-100">
                                <div class="p-3 rounded-3 border h-100 bg-primary bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-secondary label-sm text-uppercase fw-semibold">PNS</span>
                                        <span class="badge bg-white border text-primary fw-semibold">{{ $persenGuruPNS }}%</span>
                                    </div>
                                    <h3 class="fw-bold text-primary mb-2 rekap-num">{{ $guruPNS }}</h3>
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-primary" style="width: {{ $persenGuruPNS }}%"></div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- PPPK --}}
                        <div class="col-6">
                            <a href="{{ route('tu_kepegawaian.guru.index', ['status_kepegawaian' => 'PPPK']) }}" class="text-decoration-none rekap-item d-block h-100">
                                <div class="p-3 rounded-3 border h-100 bg-info bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-secondary label-sm text-uppercase fw-semibold">PPPK</span>
                                        <span class="badge bg-white border text-info fw-semibold">{{ $persenGuruPPPK }}%</span>
                                    </div>
                                    <h3 class="fw-bold text-info mb-2 rekap-num">{{ $guruPPPK }}</h3>
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-info" style="width: {{ $persenGuruPPPK }}%"></div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- PPPK Paruh Waktu --}}
                        <div class="col-6">
                            <a href="{{ route('tu_kepegawaian.guru.index', ['status_kepegawaian' => 'PPPK Paruh Waktu']) }}" class="text-decoration-none rekap-item d-block h-100">
                                <div class="p-3 rounded-3 border h-100 bg-warning bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-secondary label-sm text-uppercase fw-semibold">PPPK P.Waktu</span>
                                        <span class="badge bg-white border text-warning fw-semibold">{{ $persenGuruParuh }}%</span>
                                    </div>
                                    <h3 class="fw-bold text-warning mb-2 rekap-num">{{ $guruParuh }}</h3>
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-warning" style="width: {{ $persenGuruParuh }}%"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    @if ($guruLain > 0)
                        <div class="alert alert-light border small text-muted mt-3 mb-0 py-2 px-3 rounded-3">
                            <i class="fas fa-info-circle text-primary me-1"></i>
                            <strong>{{ $guruLain }} guru</strong> berstatus lain / belum diisi.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===== REKAP DATA PEGAWAI (KANAN) ===== --}}
        <div class="col-12 col-lg-6 d-flex">
            <div class="card border-0 shadow-sm rounded-4 bg-white w-100">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0 text-uppercase card-title-sm">
                        <i class="fas fa-users-cog text-success me-2"></i> Rekap Pegawai (TU)
                    </h6>
                    <a href="{{ route('tu_kepegawaian.tu.index') }}" class="btn btn-sm btn-outline-success rounded-3 px-3">
                        Kelola <i class="fas fa-arrow-right ms-1" style="font-size:.7rem;"></i>
                    </a>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="row g-3">

                        {{-- Total --}}
                        <div class="col-6">
                            <a href="{{ route('tu_kepegawaian.tu.index') }}" class="text-decoration-none rekap-item d-block h-100">
                                <div class="p-3 rounded-3 border h-100 bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-secondary label-sm text-uppercase fw-semibold">Total</span>
                                        <i class="fas fa-users text-secondary"></i>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-2 rekap-num">{{ $tuTotal }}</h3>
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-secondary" style="width: 100%"></div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- PNS --}}
                        <div class="col-6">
                            <a href="{{ route('tu_kepegawaian.tu.index', ['status_kepegawaian' => 'PNS']) }}" class="text-decoration-none rekap-item d-block h-100">
                                <div class="p-3 rounded-3 border h-100 bg-success bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-secondary label-sm text-uppercase fw-semibold">PNS</span>
                                        <span class="badge bg-white border text-success fw-semibold">{{ $persenTUPNS }}%</span>
                                    </div>
                                    <h3 class="fw-bold text-success mb-2 rekap-num">{{ $tuPNS }}</h3>
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" style="width: {{ $persenTUPNS }}%"></div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- PPPK --}}
                        <div class="col-6">
                            <a href="{{ route('tu_kepegawaian.tu.index', ['status_kepegawaian' => 'PPPK']) }}" class="text-decoration-none rekap-item d-block h-100">
                                <div class="p-3 rounded-3 border h-100 bg-info bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-secondary label-sm text-uppercase fw-semibold">PPPK</span>
                                        <span class="badge bg-white border text-info fw-semibold">{{ $persenTUPPPK }}%</span>
                                    </div>
                                    <h3 class="fw-bold text-info mb-2 rekap-num">{{ $tuPPPK }}</h3>
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-info" style="width: {{ $persenTUPPPK }}%"></div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- PPPK Paruh Waktu --}}
                        <div class="col-6">
                            <a href="{{ route('tu_kepegawaian.tu.index', ['status_kepegawaian' => 'PPPK Paruh Waktu']) }}" class="text-decoration-none rekap-item d-block h-100">
                                <div class="p-3 rounded-3 border h-100 bg-warning bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-secondary label-sm text-uppercase fw-semibold">PPPK P.Waktu</span>
                                        <span class="badge bg-white border text-warning fw-semibold">{{ $persenTUPPKParuh }}%</span>
                                    </div>
                                    <h3 class="fw-bold text-warning mb-2 rekap-num">{{ $tuParuh }}</h3>
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-warning" style="width: {{ $persenTUPPKParuh }}%"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    @if ($tuLain > 0)
                        <div class="alert alert-light border small text-muted mt-3 mb-0 py-2 px-3 rounded-3">
                            <i class="fas fa-info-circle text-success me-1"></i>
                            <strong>{{ $tuLain }} pegawai</strong> berstatus lain / belum diisi.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ==========================================================
         GRAFIK — ANTI DOBEL HITUNG
         Bar  : perbandingan Guru vs Pegawai per status
         Donat: komposisi status Guru saja (totalnya = kartu Total Guru)
    ========================================================== --}}
    <div class="row g-3 g-xl-4 mb-4">

        {{-- Grafik Batang: Guru vs Pegawai per Status --}}
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0 text-uppercase card-title-sm">
                        <i class="fas fa-chart-bar text-primary me-2"></i> Perbandingan Status Kepegawaian
                    </h6>
                    <span class="badge bg-light text-secondary border px-2 py-1">
                        <i class="fas fa-circle text-success me-1" style="font-size:.5rem;"></i> Live
                    </span>
                </div>
                <div class="card-body p-4">
                    <div style="height: 280px; position: relative;">
                        <canvas id="statusBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Donat: Komposisi Status Guru --}}
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h6 class="fw-bold text-dark mb-0 text-uppercase card-title-sm">
                        <i class="fas fa-chart-pie text-success me-2"></i> Komposisi Status Guru
                    </h6>
                </div>
                <div class="card-body p-4 d-flex align-items-center justify-content-center">
                    <div style="height: 280px; width: 100%; position: relative;">
                        <canvas id="guruDoughnutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==========================================================
         GURU TERBARU (DATA ASLI)
    ========================================================== --}}
    <div class="row g-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0 text-uppercase card-title-sm">
                        <i class="fas fa-clock-rotate-left text-secondary me-2"></i> Guru Terbaru Ditambahkan
                    </h6>
                    <a href="{{ route('tu_kepegawaian.guru.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
                        Lihat Semua <i class="fas fa-arrow-right ms-1" style="font-size:.7rem;"></i>
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-secondary" style="font-size: .72rem; letter-spacing: .5px; text-transform: uppercase;">
                                    <th class="py-3 ps-3">Nama Guru</th>
                                    <th class="py-3">NIP</th>
                                    <th class="py-3">Jenis Kelamin</th>
                                    <th class="py-3">Status Kepegawaian</th>
                                    <th class="py-3 text-end pe-3">Ditambahkan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($guruBaru ?? [] as $g)
                                    @php
                                        $inisial = strtoupper(substr(trim($g->nama ?? '?'), 0, 1));
                                        $warnaBadge = $badgeStatus($g->status_kepegawaian);
                                    @endphp
                                    <tr class="border-bottom">
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-initial bg-primary bg-opacity-10 text-primary">{{ $inisial }}</div>
                                                <div>
                                                    <div class="fw-semibold text-dark">{{ $g->nama }}</div>
                                                    <small class="text-muted">{{ $g->pendidikan ? 'Pendidikan: ' . $g->pendidikan : 'Pendidikan belum diisi' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted small">{{ $g->nip ?: '-' }}</td>
                                        <td>
                                            @if ($g->jenis_kelamin === 'L')
                                                <span class="badge bg-primary bg-opacity-10 text-primary">Laki-laki</span>
                                            @elseif ($g->jenis_kelamin === 'P')
                                                <span class="badge bg-danger bg-opacity-10 text-danger">Perempuan</span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $warnaBadge }} bg-opacity-10 text-{{ $warnaBadge }}">
                                                {{ $g->status_kepegawaian ?: 'Belum diisi' }}
                                            </span>
                                        </td>
                                        <td class="text-end text-muted small pe-3">
                                            {{ optional($g->created_at)->translatedFormat('d M Y') ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox d-block mb-2 fa-2x text-secondary bg-opacity-25"></i>
                                            Belum ada data guru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ==================== SCRIPT CHART ==================== --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // ═══ Data dari controller ═══
        const guruTotal = {{ $guruTotal }};
        const guruPNS   = {{ $guruPNS }};
        const guruPPPK  = {{ $guruPPPK }};
        const guruParuh = {{ $guruParuh }};
        const guruLain  = {{ $guruLain }};

        const tuPNS   = {{ $tuPNS }};
        const tuPPPK  = {{ $tuPPPK }};
        const tuParuh = {{ $tuParuh }};

        const tooltipStyle = {
            backgroundColor: 'rgba(33,37,41,.95)',
            padding: 10,
            cornerRadius: 8,
        };

        // ---------- GRAFIK BATANG: Guru vs Pegawai per status ----------
        const ctxBar = document.getElementById('statusBarChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['PNS', 'PPPK', 'PPPK Paruh Waktu'],
                datasets: [
                    {
                        label: 'Guru',
                        data: [guruPNS, guruPPPK, guruParuh],
                        backgroundColor: 'rgba(13, 110, 253, .85)',
                        borderRadius: 8,
                        maxBarThickness: 45
                    },
                    {
                        label: 'Pegawai (TU)',
                        data: [tuPNS, tuPPPK, tuParuh],
                        backgroundColor: 'rgba(25, 135, 84, .85)',
                        borderRadius: 8,
                        maxBarThickness: 45
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: { usePointStyle: true, boxWidth: 10, font: { size: 11 } }
                    },
                    tooltip: {
                        ...tooltipStyle,
                        callbacks: { label: (c) => ` ${c.dataset.label}: ${c.parsed.y} orang` }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, color: '#6c757d' },
                        grid: { color: '#eef1f5' }
                    },
                    x: {
                        ticks: { color: '#495057', font: { weight: '600' } },
                        grid: { display: false }
                    }
                }
            }
        });

        // ---------- PLUGIN TEKS DI TENGAH DONAT ----------
        const centerTextPlugin = {
            id: 'centerText',
            afterDraw(chart) {
                const meta = chart.getDatasetMeta(0);
                if (!meta.data.length) return;
                const { x, y } = meta.data[0];
                const ctx = chart.ctx;
                ctx.save();
                ctx.textAlign = 'center';
                ctx.font = '700 24px sans-serif';
                ctx.fillStyle = '#212529';
                ctx.fillText(guruTotal, x, y);
                ctx.font = '12px sans-serif';
                ctx.fillStyle = '#6c757d';
                ctx.fillText('Total Guru', x, y + 18);
                ctx.restore();
            }
        };

        // ---------- DONAT: Komposisi status Guru (jumlanya = Total Guru) ----------
        const ctxDoughnut = document.getElementById('guruDoughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['PNS', 'PPPK', 'PPPK Paruh Waktu', 'Lainnya'],
                datasets: [{
                    data: [guruPNS, guruPPPK, guruParuh, guruLain],
                    backgroundColor: ['#0d6efd', '#0dcaf0', '#ffc107', '#adb5bd'],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, padding: 14, usePointStyle: true, font: { size: 11 } }
                    },
                    tooltip: {
                        ...tooltipStyle,
                        callbacks: {
                            label: (c) => {
                                const total = c.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = total > 0 ? Math.round((c.parsed / total) * 100) : 0;
                                return ` ${c.label}: ${c.parsed} orang (${pct}%)`;
                            }
                        }
                    }
                }
            },
            plugins: [centerTextPlugin]
        });
    });
</script>
@endpush
@endsection