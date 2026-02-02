@extends('layouts.app')

@section('title', 'Detail Rombel: ' . $rombel->nama)

@section('content')
<style>
    /* ===================== STYLE DETAIL ROMBEL ===================== */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        --bg-light: #f7fafc;
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* ===== PAGE TITLE BAR ===== */
    .page-title-bar {
        background: var(--primary-gradient);
        color: white;
        padding: 1.75rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .page-title-bar::before {
        content: "";
        position: absolute;
        top: 0; right: 0;
        width: 260px; height: 260px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        transform: translate(90px, -90px);
    }

    .page-title-bar .title-inner {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .page-title-bar h1 {
        font-weight: 700;
        font-size: 1.6rem;
        margin-bottom: 0.2rem;
    }

    .page-title-bar .subtitle {
        color: rgba(255, 255, 255, 0.75);
        font-size: 13px;
        margin-bottom: 0;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        border: 1.5px solid rgba(255, 255, 255, 0.45);
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.1rem;
        border-radius: 10px;
        font-size: 13.5px;
        white-space: nowrap;
        flex-shrink: 0;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.35);
        border-color: white;
        color: white;
    }

    /* ===== INFO CARD ===== */
    .info-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        background: white;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .info-card-body {
        padding: 1.5rem;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .info-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: rgba(102, 126, 234, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        font-size: 18px;
        flex-shrink: 0;
    }

    .info-label {
        color: #94A3B8;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 0.2rem;
    }

    .info-value {
        color: #1E293B;
        font-size: 15px;
        font-weight: 700;
    }

    /* ===== SECTION CARD (TABLE) ===== */
    .section-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        background: white;
    }

    .section-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #E2E8F0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
    }

    .section-card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 1.05rem;
    }

    .total-badge {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        font-weight: 700;
        font-size: 12px;
        padding: 0.3rem 0.7rem;
        border-radius: 6px;
    }

    /* Desktop Table */
    .section-card .table { margin-bottom: 0; }

    .section-card thead { background-color: #F8FAFC; }

    .section-card th {
        color: #94A3B8;
        font-weight: 600;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        padding: 0.9rem 1.2rem;
    }

    .section-card td {
        padding: 0.85rem 1.2rem;
        border-color: #E2E8F0;
        font-size: 14px;
        color: #334155;
        vertical-align: middle;
    }

    .section-card tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.03);
    }

    .td-no {
        color: #94A3B8;
        font-weight: 600;
        font-size: 13px;
    }

    .badge-gender {
        display: inline-block;
        font-size: 12px;
        font-weight: 600;
        padding: 0.25rem 0.65rem;
        border-radius: 6px;
    }

    .badge-gender.laki {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .badge-gender.perempuan {
        background: rgba(236, 72, 153, 0.1);
        color: #EC4899;
    }

    /* ===== MOBILE CARD LIST ===== */
    .mobile-item {
        padding: 14px 16px;
        border-bottom: 1px solid #E2E8F0;
        transition: background 0.2s ease;
    }

    .mobile-item:last-child { border-bottom: none; }
    .mobile-item:active { background-color: rgba(102, 126, 234, 0.04); }

    .mobile-item .mobile-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .mobile-item .mobile-name {
        font-weight: 600;
        color: #1E293B;
        font-size: 15px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        min-width: 0;
    }

    .mobile-item .mobile-meta {
        margin-top: 6px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: #64748B;
    }

    .mobile-item .mobile-meta .meta-label {
        color: #94A3B8;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-weight: 600;
    }

    .mobile-empty {
        padding: 2.5rem 1rem;
        text-align: center;
        color: #94A3B8;
    }

    .mobile-empty i {
        font-size: 1.8rem;
        display: block;
        margin-bottom: 0.5rem;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fade-in   { animation: fadeIn 0.5s ease-out; }
    .fade-in-1 { animation: fadeIn 0.5s ease-out 0.1s both; }
    .fade-in-2 { animation: fadeIn 0.5s ease-out 0.2s both; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 767.98px) {
        .page-title-bar {
            padding: 1.25rem 1rem;
        }

        .page-title-bar h1 {
            font-size: 1.3rem;
        }

        .page-title-bar .subtitle {
            font-size: 12px;
        }

        .btn-back {
            padding: 0.4rem 0.8rem;
            font-size: 13px;
        }

        .info-card-body {
            grid-template-columns: 1fr;
            gap: 1rem;
            padding: 1rem;
        }

        .section-card-header {
            padding: 1rem;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 mt-3">

    {{-- PAGE TITLE BAR --}}
    <div class="page-title-bar fade-in">
        <div class="title-inner">
            <div>
                <h1>Detail Rombel</h1>
                <p class="subtitle">{{ $rombel->nama }}</p>
            </div>
            <a href="{{ request()->header('referer') ?: route('kurikulum.kelas.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                <span class="d-none d-sm-inline">Kembali</span>
            </a>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('kurikulum.kelas.export', $rombel->id) }}" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i> Export Rombel
            </a>
            <a href="{{ request()->header('referer') ?: route('kurikulum.kelas.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    {{-- INFO ROMBEL --}}
    <div class="info-card fade-in-1">
        <div class="info-card-body">

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <p class="info-label">Tingkat</p>
                    <p class="info-value">{{ $rombel->kelas->tingkat ?? '-' }}</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <p class="info-label">Jurusan</p>
                    <p class="info-value">{{ $rombel->kelas->jurusan->nama ?? '-' }}</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div>
                    <p class="info-label">Wali Kelas</p>
                    <p class="info-value">{{ $rombel->guru->nama ?? '-' }}</p>
                </div>
            </div>

        </div>
    </div>

    {{-- DAFTAR SISWA --}}
    <div class="section-card fade-in-2">
        <div class="section-card-header">
            <h5>Daftar Siswa</h5>
            <span class="total-badge">
                <i class="fas fa-users me-1"></i>
                {{ count($rombel->siswa) }} Siswa
            </span>
        </div>

        {{-- DESKTOP TABLE --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 56px;">No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rombel->siswa as $siswa)
                        <tr>
                            <td class="td-no">{{ $loop->iteration }}</td>
                            <td class="fw-medium">{{ $siswa->nama_lengkap }}</td>
                            <td class="text-muted">{{ $siswa->nis }}</td>
                            <td>
                                @php
                                    $gender = strtolower($siswa->jenis_kelamin ?? '');
                                    $isLaki = str_contains($gender, 'laki');
                                @endphp
                                <span class="badge-gender {{ $isLaki ? 'laki' : 'perempuan' }}">
                                    {{ $siswa->jenis_kelamin ?? '-' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-users fa-2x mb-2 d-block" style="color:#CBD5E1;"></i>
                                Belum ada siswa di rombel ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARD LIST --}}
        <div class="d-md-none">
            @forelse($rombel->siswa as $siswa)
                @php
                    $gender = strtolower($siswa->jenis_kelamin ?? '');
                    $isLaki = str_contains($gender, 'laki');
                @endphp
                <div class="mobile-item">
                    <div class="mobile-top">
                        <div class="mobile-name">{{ $siswa->nama_lengkap }}</div>
                        <span class="badge-gender {{ $isLaki ? 'laki' : 'perempuan' }} flex-shrink-0">
                            {{ $siswa->jenis_kelamin ?? '-' }}
                        </span>
                    </div>
                    <div class="mobile-meta">
                        <span><span class="meta-label">NIS</span> {{ $siswa->nis }}</span>
                        <span><span class="meta-label">No</span> {{ $loop->iteration }}</span>
                    </div>
                </div>
            @empty
                <div class="mobile-empty">
                    <i class="fas fa-users"></i>
                    Belum ada siswa di rombel ini.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection