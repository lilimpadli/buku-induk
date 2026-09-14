@extends('layouts.app')

@section('title', 'Dashboard TU Kepegawaian')

@section('content')

{{-- ════════════════════════════════════════════════════════════
     CSS — REFINED MINIMAL PRO
══════════════════════════════════════════════════════════════ --}}
@once
<style>
    /* ── Halaman ── */
    .mn-page {
        background:
            radial-gradient(1000px 400px at 90% -10%, rgba(79, 70, 229, .06), transparent),
            radial-gradient(800px 350px at -10% 10%, rgba(16, 185, 129, .05), transparent),
            #f6f7f9;
        min-height: 100vh;
    }

    /* ── Animasi masuk halus ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-item {
        animation: fadeUp .5s ease both;
    }

    .fade-item:nth-child(2) { animation-delay: .06s; }
    .fade-item:nth-child(3) { animation-delay: .12s; }
    .fade-item:nth-child(4) { animation-delay: .18s; }

    /* ── Kartu dasar ── */
    .mn-card {
        background: #ffffff;
        border: 1px solid #e8eaf0;
        border-radius: 18px;
    }

    /* ── Kartu statistik ── */
    .mn-stat {
        position: relative;
        display: block;
        height: 100%;
        padding: 1.4rem 1.5rem 1.4rem 1.8rem;
        overflow: hidden;
        text-decoration: none !important;
        transition: border-color .25s ease, transform .25s ease, box-shadow .25s ease;
    }

    .mn-stat::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4.5px;
        background: var(--ac, #334155);
        border-radius: 0 4px 4px 0;
    }

    /* Lingkaran dekoratif di pojok */
    .mn-stat::after {
        content: '';
        position: absolute;
        right: -34px;
        top: -34px;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: var(--ac-soft, rgba(51, 65, 85, .06));
        transition: transform .35s ease;
    }

    .mn-stat:hover::after {
        transform: scale(1.35);
    }

    .mn-stat:hover {
        transform: translateY(-4px);
    }

    /* Hover shadow + border per warna aksen */
    .st-indigo:hover  { border-color: #c7d2fe; box-shadow: 0 16px 32px -10px rgba(79, 70, 229, .30); }
    .st-emerald:hover { border-color: #a7f3d0; box-shadow: 0 16px 32px -10px rgba(16, 185, 129, .30); }
    .st-orange:hover  { border-color: #fed7aa; box-shadow: 0 16px 32px -10px rgba(249, 115, 22, .30); }
    .st-blue:hover    { border-color: #bfdbfe; box-shadow: 0 16px 32px -10px rgba(59, 130, 246, .30); }

    .mn-stat .label {
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: 1.1px;
        text-transform: uppercase;
        color: #8b93a3;
        position: relative;
        z-index: 1;
    }

    .mn-stat .ico {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .mn-stat .num {
        font-size: 2.5rem;
        font-weight: 800;
        color: #111827;
        line-height: 1;
        letter-spacing: -1.5px;
        font-variant-numeric: tabular-nums;
        position: relative;
        z-index: 1;
    }

    .mn-stat .sub {
        font-size: .76rem;
        color: #9ca3af;
        position: relative;
        z-index: 1;
    }

    /* Panah muncul saat hover */
    .go-arrow {
        opacity: 0;
        transform: translateX(-4px);
        transition: opacity .2s ease, transform .2s ease;
    }

    .mn-stat:hover .go-arrow {
        opacity: 1;
        transform: translateX(0);
    }

    /* ── Header ── */
    .eyebrow {
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: 1.6px;
        color: #9aa1af;
        text-transform: uppercase;
    }

    .head-mark {
        display: inline-block;
        width: 44px;
        height: 5px;
        border-radius: 99px;
        background: linear-gradient(90deg, #4f46e5, #10b981);
        vertical-align: middle;
    }

    .date-chip {
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        background: #ffffff;
        border: 1px solid #e8eaf0;
        border-radius: 12px;
        padding: .6rem 1.1rem;
        font-size: .78rem;
        font-weight: 600;
        color: #4b5563;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .04);
    }

    .live-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, .18);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50%      { opacity: .35; }
    }

    /* ── Rekap: baris bar horizontal ── */
    .rp-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: .85rem .6rem;
        text-decoration: none !important;
        transition: background .15s ease, transform .15s ease;
        border-radius: 12px;
    }

    a.rp-row:hover {
        background: #f7f8fb;
        transform: translateX(3px);
    }

    .rp-row + .rp-row {
        border-top: 1px dashed #eef0f5;
    }

    .rp-label {
        width: 120px;
        flex-shrink: 0;
        font-size: .84rem;
        font-weight: 600;
        color: #374151;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .rp-dot {
        width: 8px;
        height: 8px;
        border-radius: 3px;
        flex-shrink: 0;
    }

    .rp-bar {
        flex: 1;
        height: 9px;
        background: #eef0f5;
        border-radius: 99px;
        overflow: hidden;
    }

    .rp-bar > div {
        height: 100%;
        border-radius: 99px;
        transition: width .7s cubic-bezier(.22, 1, .36, 1);
    }

    .rp-num {
        width: 44px;
        flex-shrink: 0;
        text-align: right;
        font-weight: 800;
        font-size: 1.02rem;
        color: #111827;
        font-variant-numeric: tabular-nums;
    }

    .rp-pct {
        width: 48px;
        flex-shrink: 0;
        text-align: right;
        font-size: .68rem;
        font-weight: 700;
        color: #9ca3af;
    }

    /* ── Badge kotak ── */
    .bd {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .67rem;
        font-weight: 700;
        padding: .32em .7em;
        border-radius: 7px;
        white-space: nowrap;
    }

    .bd.violet { background: #eef2ff; color: #4f46e5; }
    .bd.cyan   { background: #ecfeff; color: #0e7490; }
    .bd.amber  { background: #fffbeb; color: #b45309; }
    .bd.slate  { background: #f3f4f6; color: #6b7280; }
    .bd.rose   { background: #fff1f2; color: #e11d48; }

    /* ── List guru terbaru ── */
    .gb-row {
        display: flex;
        align-items: center;
        gap: 1.05rem;
        padding: .95rem .6rem;
        border-radius: 12px;
        transition: background .15s ease, transform .15s ease;
    }

    .gb-row:hover {
        background: #f7f8fb;
        transform: translateX(3px);
    }

    .gb-row + .gb-row {
        border-top: 1px solid #f0f2f6;
    }

    .gb-idx {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        flex-shrink: 0;
        font-weight: 800;
        font-size: .78rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gb-idx.c1 { background: #eef2ff; color: #4f46e5; }
    .gb-idx.c2 { background: #ecfeff; color: #0e7490; }
    .gb-idx.c3 { background: #fdf4ff; color: #a21caf; }
    .gb-idx.c4 { background: #fff7ed; color: #c2410c; }
    .gb-idx.c5 { background: #ecfdf5; color: #059669; }

    .gb-name {
        font-weight: 700;
        color: #111827;
        font-size: .92rem;
    }

    .gb-sub {
        font-size: .74rem;
        color: #9ca3af;
    }

    .gb-date {
        font-size: .74rem;
        color: #9ca3af;
        font-weight: 600;
        white-space: nowrap;
    }

    /* ── Ikon judul section ── */
    .sec-ico {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .85rem;
        flex-shrink: 0;
    }

    /* ── Tombol ── */
    .btn-glow-dark {
        background: #111827;
        color: #fff;
        border: none;
        transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
    }

    .btn-glow-dark:hover {
        background: #1f2937;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px -6px rgba(17, 24, 39, .4);
    }
</style>
@endonce

{{-- ════════════════════════════════════════════════════════════
     PHP — PERSIAPAN DATA
══════════════════════════════════════════════════════════════ --}}
@php
    // ── Rekap guru ──
    $guruTotal = (int) ($totalGuru ?? 0);
    $guruPNS   = (int) ($totalGuruPNS ?? 0);
    $guruPPPK  = (int) ($totalGuruPPPK ?? 0);
    $guruParuh = (int) ($totalGuruPPPKParuh ?? 0);
    $guruLain  = max(0, $guruTotal - ($guruPNS + $guruPPPK + $guruParuh));

    // ── Rekap pegawai ──
    $tuTotal = (int) ($totalPegawai ?? 0);
    $tuPNS   = (int) ($totalTUPNS ?? 0);
    $tuPPPK  = (int) ($totalTUPPPK ?? 0);
    $tuParuh = (int) ($totalTUPPKParuh ?? 0);
    $tuLain  = max(0, $tuTotal - ($tuPNS + $tuPPPK + $tuParuh));

    // ── Kartu statistik utama ──
    $totalPersonel = (int) ($totalStaffAktif ?? 0);
    $tuAkademik    = (int) ($totalTU ?? 0);
    $tuKepegawaian = (int) ($totalTUKepegawaian ?? 0);

    // ── Persentase bar rekap ──
    $pct = fn($bagian, $total) => $total > 0 ? round(($bagian / $total) * 100) : 0;

    // ── Warna bar per status (gradient) ──
    $warnaStatus = [
        'total'            => 'linear-gradient(90deg,#334155,#64748b)',
        'PNS'              => 'linear-gradient(90deg,#4f46e5,#818cf8)',
        'PPPK'             => 'linear-gradient(90deg,#0891b2,#22d3ee)',
        'PPPK Paruh Waktu' => 'linear-gradient(90deg,#d97706,#fbbf24)',
        'Lainnya'          => 'linear-gradient(90deg,#cbd5e1,#e2e8f0)',
    ];

    // ── Titik warna solid (untuk legend) ──
    $dotStatus = [
        'total'            => '#334155',
        'PNS'              => '#4f46e5',
        'PPPK'             => '#0891b2',
        'PPPK Paruh Waktu' => '#f59e0b',
        'Lainnya'          => '#cbd5e1',
    ];

    // ── Helper badge status ──
    $badgeStatus = function (?string $status) {
        return match (strtolower(trim($status ?? ''))) {
            'pns'              => 'violet',
            'pppk'             => 'cyan',
            'pppk paruh waktu' => 'amber',
            default            => 'slate',
        };
    };
@endphp

<div class="container-fluid px-4 py-4 mn-page">

    {{-- ══════════════════════════════════════════════════════════
         SECTION 1 — HEADER
    ═══════════════════════════════════════════════════════════ --}}
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <div class="eyebrow mb-2">Beranda / Kepegawaian</div>
            <h3 class="fw-bold text-dark mb-1">
                Dashboard Kepegawaian <span class="head-mark ms-2"></span>
            </h3>
            <p class="text-muted small mb-0">Kelola &amp; pantau data guru dan tenaga kependidikan</p>
        </div>

        <span class="date-chip">
            <span class="live-dot"></span>
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </span>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 2 — KARTU STATISTIK UTAMA
         1. Total Personel | 2. Guru
         3. Pegawai TU     | 4. Struktur TU
    ═══════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">

        {{-- 2A. Total Personel — indigo --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="mn-card mn-stat st-indigo fade-item"
                 style="--ac:#4f46e5; --ac-soft:rgba(79,70,229,.07);">

                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="label">Total Personel</span>
                    <span class="ico" style="background:linear-gradient(135deg,#eef2ff,#e0e7ff);color:#4f46e5;">
                        <i class="fas fa-people-group"></i>
                    </span>
                </div>

                <div class="num mb-2">{{ $totalPersonel }}</div>
                <div class="sub">
                    <strong class="text-dark">{{ $guruTotal }}</strong> guru
                    &nbsp;+&nbsp;
                    <strong class="text-dark">{{ $tuTotal }}</strong> pegawai
                </div>
            </div>
        </div>

        {{-- 2B. Guru — emerald --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('tu_kepegawaian.guru.index') }}"
               class="mn-card mn-stat st-emerald fade-item"
               style="--ac:#10b981; --ac-soft:rgba(16,185,129,.07);">

                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="label">Guru</span>
                    <span class="ico" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);color:#059669;">
                        <i class="fas fa-chalkboard-user"></i>
                    </span>
                </div>

                <div class="num mb-2">{{ $guruTotal }}</div>
                <div class="sub">
                    Kelola data guru
                    <i class="fas fa-arrow-right go-arrow ms-1" style="font-size:.65rem;color:#059669;"></i>
                </div>
            </a>
        </div>

        {{-- 2C. Pegawai TU — orange --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('tu_kepegawaian.tu.index') }}"
               class="mn-card mn-stat st-orange fade-item"
               style="--ac:#f97316; --ac-soft:rgba(249,115,22,.07);">

                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="label">Pegawai TU</span>
                    <span class="ico" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);color:#ea580c;">
                        <i class="fas fa-briefcase"></i>
                    </span>
                </div>

                <div class="num mb-2">{{ $tuTotal }}</div>
                <div class="sub">
                    Kelola data pegawai
                    <i class="fas fa-arrow-right go-arrow ms-1" style="font-size:.65rem;color:#ea580c;"></i>
                </div>
            </a>
        </div>

        {{-- 2D. Struktur TU — blue --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('tu_kepegawaian.tu.index', ['role' => 'tu']) }}"
               class="mn-card mn-stat st-blue fade-item"
               style="--ac:#3b82f6; --ac-soft:rgba(59,130,246,.07);">

                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="label">Struktur TU</span>
                    <span class="ico" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#2563eb;">
                        <i class="fas fa-sitemap"></i>
                    </span>
                </div>

                <div class="d-flex align-items-center gap-3 mb-2">
                    <div>
                        <div class="num" style="font-size:1.95rem;">{{ $tuAkademik }}</div>
                        <small class="sub">
                            <span class="rp-dot d-inline-block" style="background:#4f46e5;"></span> Akademik
                        </small>
                    </div>
                    <div style="width:1px;height:40px;background:#eceef3;"></div>
                    <div>
                        <div class="num" style="font-size:1.95rem;">{{ $tuKepegawaian }}</div>
                        <small class="sub">
                            <span class="rp-dot d-inline-block" style="background:#3b82f6;"></span> Kepegawaian
                        </small>
                    </div>
                </div>

                <div class="sub">
                    Kelola struktur
                    <i class="fas fa-arrow-right go-arrow ms-1" style="font-size:.65rem;color:#2563eb;"></i>
                </div>
            </a>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 3 — REKAP GURU & PEGAWAI (BARIS BAR HORIZONTAL)
    ═══════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">

        {{-- ===== REKAP GURU ===== --}}
        <div class="col-12 col-lg-6">
            <div class="mn-card h-100">
                <div class="d-flex justify-content-between align-items-center p-4 pb-2">
                    <div class="d-flex align-items-center gap-3">
                        <span class="sec-ico" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);color:#2563eb;">
                            <i class="fas fa-chalkboard-user"></i>
                        </span>
                        <div>
                            <div class="fw-bold text-dark">Rekap Data Guru</div>
                            <small class="text-muted">status kepegawaian · {{ $guruTotal }} orang</small>
                        </div>
                    </div>
                    <a href="{{ route('tu_kepegawaian.guru.index') }}" class="btn btn-sm btn-glow-dark rounded-3 px-3">
                        Kelola <i class="fas fa-arrow-right ms-1" style="font-size:.65rem;"></i>
                    </a>
                </div>

                <div class="px-3 pb-3">

                    {{-- Total --}}
                    <div class="rp-row">
                        <span class="rp-label fw-bold">
                            <span class="rp-dot" style="background:{{ $dotStatus['total'] }};"></span> Total
                        </span>
                        <div class="rp-bar"><div style="width:100%;background:{{ $warnaStatus['total'] }};"></div></div>
                        <span class="rp-num">{{ $guruTotal }}</span>
                        <span class="rp-pct">100%</span>
                    </div>

                    {{-- PNS --}}
                    <a href="{{ route('tu_kepegawaian.guru.index', ['status_kepegawaian' => 'PNS']) }}" class="rp-row">
                        <span class="rp-label">
                            <span class="rp-dot" style="background:{{ $dotStatus['PNS'] }};"></span> PNS
                        </span>
                        <div class="rp-bar"><div style="width:{{ $pct($guruPNS, $guruTotal) }}%;background:{{ $warnaStatus['PNS'] }};"></div></div>
                        <span class="rp-num">{{ $guruPNS }}</span>
                        <span class="rp-pct">{{ $pct($guruPNS, $guruTotal) }}%</span>
                    </a>

                    {{-- PPPK --}}
                    <a href="{{ route('tu_kepegawaian.guru.index', ['status_kepegawaian' => 'PPPK']) }}" class="rp-row">
                        <span class="rp-label">
                            <span class="rp-dot" style="background:{{ $dotStatus['PPPK'] }};"></span> PPPK
                        </span>
                        <div class="rp-bar"><div style="width:{{ $pct($guruPPPK, $guruTotal) }}%;background:{{ $warnaStatus['PPPK'] }};"></div></div>
                        <span class="rp-num">{{ $guruPPPK }}</span>
                        <span class="rp-pct">{{ $pct($guruPPPK, $guruTotal) }}%</span>
                    </a>

                    {{-- PPPK Paruh Waktu --}}
                    <a href="{{ route('tu_kepegawaian.guru.index', ['status_kepegawaian' => 'PPPK Paruh Waktu']) }}" class="rp-row">
                        <span class="rp-label">
                            <span class="rp-dot" style="background:{{ $dotStatus['PPPK Paruh Waktu'] }};"></span> PPPK P. Waktu
                        </span>
                        <div class="rp-bar"><div style="width:{{ $pct($guruParuh, $guruTotal) }}%;background:{{ $warnaStatus['PPPK Paruh Waktu'] }};"></div></div>
                        <span class="rp-num">{{ $guruParuh }}</span>
                        <span class="rp-pct">{{ $pct($guruParuh, $guruTotal) }}%</span>
                    </a>

                    {{-- Lainnya --}}
                    @if ($guruLain > 0)
                        <div class="rp-row">
                            <span class="rp-label">
                                <span class="rp-dot" style="background:{{ $dotStatus['Lainnya'] }};"></span> Lainnya
                            </span>
                            <div class="rp-bar"><div style="width:{{ $pct($guruLain, $guruTotal) }}%;background:{{ $warnaStatus['Lainnya'] }};"></div></div>
                            <span class="rp-num">{{ $guruLain }}</span>
                            <span class="rp-pct">{{ $pct($guruLain, $guruTotal) }}%</span>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ===== REKAP PEGAWAI ===== --}}
        <div class="col-12 col-lg-6">
            <div class="mn-card h-100">
                <div class="d-flex justify-content-between align-items-center p-4 pb-2">
                    <div class="d-flex align-items-center gap-3">
                        <span class="sec-ico" style="background:linear-gradient(135deg,#f0fdfa,#ccfbf1);color:#0d9488;">
                            <i class="fas fa-briefcase"></i>
                        </span>
                        <div>
                            <div class="fw-bold text-dark">Rekap Data Pegawai</div>
                            <small class="text-muted">status kepegawaian · {{ $tuTotal }} orang</small>
                        </div>
                    </div>
                    <a href="{{ route('tu_kepegawaian.tu.index') }}" class="btn btn-sm btn-glow-dark rounded-3 px-3">
                        Kelola <i class="fas fa-arrow-right ms-1" style="font-size:.65rem;"></i>
                    </a>
                </div>

                <div class="px-3 pb-3">

                    {{-- Total --}}
                    <div class="rp-row">
                        <span class="rp-label fw-bold">
                            <span class="rp-dot" style="background:{{ $dotStatus['total'] }};"></span> Total
                        </span>
                        <div class="rp-bar"><div style="width:100%;background:{{ $warnaStatus['total'] }};"></div></div>
                        <span class="rp-num">{{ $tuTotal }}</span>
                        <span class="rp-pct">100%</span>
                    </div>

                    {{-- PNS --}}
                    <a href="{{ route('tu_kepegawaian.tu.index', ['status_kepegawaian' => 'PNS']) }}" class="rp-row">
                        <span class="rp-label">
                            <span class="rp-dot" style="background:{{ $dotStatus['PNS'] }};"></span> PNS
                        </span>
                        <div class="rp-bar"><div style="width:{{ $pct($tuPNS, $tuTotal) }}%;background:{{ $warnaStatus['PNS'] }};"></div></div>
                        <span class="rp-num">{{ $tuPNS }}</span>
                        <span class="rp-pct">{{ $pct($tuPNS, $tuTotal) }}%</span>
                    </a>

                    {{-- PPPK --}}
                    <a href="{{ route('tu_kepegawaian.tu.index', ['status_kepegawaian' => 'PPPK']) }}" class="rp-row">
                        <span class="rp-label">
                            <span class="rp-dot" style="background:{{ $dotStatus['PPPK'] }};"></span> PPPK
                        </span>
                        <div class="rp-bar"><div style="width:{{ $pct($tuPPPK, $tuTotal) }}%;background:{{ $warnaStatus['PPPK'] }};"></div></div>
                        <span class="rp-num">{{ $tuPPPK }}</span>
                        <span class="rp-pct">{{ $pct($tuPPPK, $tuTotal) }}%</span>
                    </a>

                    {{-- PPPK Paruh Waktu --}}
                    <a href="{{ route('tu_kepegawaian.tu.index', ['status_kepegawaian' => 'PPPK Paruh Waktu']) }}" class="rp-row">
                        <span class="rp-label">
                            <span class="rp-dot" style="background:{{ $dotStatus['PPPK Paruh Waktu'] }};"></span> PPPK P. Waktu
                        </span>
                        <div class="rp-bar"><div style="width:{{ $pct($tuParuh, $tuTotal) }}%;background:{{ $warnaStatus['PPPK Paruh Waktu'] }};"></div></div>
                        <span class="rp-num">{{ $tuParuh }}</span>
                        <span class="rp-pct">{{ $pct($tuParuh, $tuTotal) }}%</span>
                    </a>

                    {{-- Lainnya --}}
                    @if ($tuLain > 0)
                        <div class="rp-row">
                            <span class="rp-label">
                                <span class="rp-dot" style="background:{{ $dotStatus['Lainnya'] }};"></span> Lainnya
                            </span>
                            <div class="rp-bar"><div style="width:{{ $pct($tuLain, $tuTotal) }}%;background:{{ $warnaStatus['Lainnya'] }};"></div></div>
                            <span class="rp-num">{{ $tuLain }}</span>
                            <span class="rp-pct">{{ $pct($tuLain, $tuTotal) }}%</span>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 4 — GURU TERBARU (LIST BERNOMOR)
    ═══════════════════════════════════════════════════════════ --}}
    <div class="row g-3">
        <div class="col-12">
            <div class="mn-card">

                <div class="d-flex justify-content-between align-items-center p-4 pb-2">
                    <div class="d-flex align-items-center gap-3">
                        <span class="sec-ico" style="background:linear-gradient(135deg,#f3f4f6,#e5e7eb);color:#4b5563;">
                            <i class="fas fa-clock-rotate-left"></i>
                        </span>
                        <div>
                            <div class="fw-bold text-dark">Guru Terbaru Ditambahkan</div>
                            <small class="text-muted">5 data terakhir</small>
                        </div>
                    </div>
                    <a href="{{ route('tu_kepegawaian.guru.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
                        Lihat Semua <i class="fas fa-arrow-right ms-1" style="font-size:.65rem;"></i>
                    </a>
                </div>

                <div class="px-3 pb-3">

                    @forelse ($guruBaru ?? [] as $g)
                        @php
                            $inisial = strtoupper(substr(trim($g->nama ?? '?'), 0, 1));
                            $bd = $badgeStatus($g->status_kepegawaian);
                            $idxColor = 'c' . (($loop->index % 5) + 1);
                        @endphp

                        <div class="gb-row">
                            <div class="gb-idx {{ $idxColor }}">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </div>

                            <div class="flex-grow-1">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <span class="gb-name">{{ $g->nama }}</span>
                                    <span class="bd {{ $bd }}">{{ $g->status_kepegawaian ?: 'Belum diisi' }}</span>

                                    @if ($g->jenis_kelamin === 'L')
                                        <span class="bd violet"><i class="fas fa-mars" style="font-size:.6rem;"></i> Laki-laki</span>
                                    @elseif ($g->jenis_kelamin === 'P')
                                        <span class="bd rose"><i class="fas fa-venus" style="font-size:.6rem;"></i> Perempuan</span>
                                    @endif
                                </div>

                                <div class="gb-sub mt-1">
                                    NIP: {{ $g->nip ?: '—' }} · {{ $g->pendidikan ?: 'Pendidikan belum diisi' }}
                                </div>
                            </div>

                            <div class="gb-date">
                                <i class="far fa-clock me-1"></i>{{ optional($g->created_at)->translatedFormat('d M Y') ?? '—' }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-inbox d-block mb-2 fa-2x" style="opacity:.25;"></i>
                            Belum ada data guru.
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>

</div>

@endsection