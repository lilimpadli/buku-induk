@extends('layouts.app')

@section('title', 'Detail Mutasi Siswa')

@section('content')
<style>
    :root {
        --page-bg: linear-gradient(180deg, #f8fbff 0%, #eef4ff 100%);
        --card-bg: #ffffff;
        --card-border: #eef2ff;
        --card-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        --card-hover: 0 20px 45px rgba(15, 23, 42, 0.12);
        --text-primary: #0f172a;
        --text-secondary: #64748b;
        --label-color: #64748b;
        --badge-radius: 999px;
    }

    body {
        background: var(--page-bg);
        min-height: 100vh;
    }

    .page-container {
        padding-top: 1.75rem;
        padding-bottom: 2rem;
    }

    .hero-card {
        position: relative;
        overflow: hidden;
        border-radius: 24px;
        background: linear-gradient(135deg, rgba(173, 216, 255, 0.96), rgba(235, 224, 255, 0.95));
        border: 1px solid rgba(238, 242, 255, 0.9);
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hero-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-hover);
    }

    .hero-bubbles {
        position: absolute;
        inset: 0;
        pointer-events: none;
    }

    .hero-bubbles .bubble {
        position: absolute;
        border-radius: 50%;
        opacity: 0.25;
        background: rgba(255, 255, 255, 0.8);
        filter: blur(3px);
    }

    .hero-bubbles .bubble-1 {
        width: 140px;
        height: 140px;
        top: -20px;
        left: -20px;
    }

    .hero-bubbles .bubble-2 {
        width: 96px;
        height: 96px;
        top: 30px;
        right: 30px;
    }

    .hero-bubbles .bubble-3 {
        width: 180px;
        height: 180px;
        bottom: -40px;
        left: 20%;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-eyebrow {
        display: inline-block;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #334155;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .hero-title {
        font-size: clamp(2rem, 3.5vw, 2.75rem);
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
        line-height: 1.05;
    }

    .hero-subtitle {
        font-size: 1rem;
        color: #475569;
        margin-bottom: 1.25rem;
    }

    .hero-meta {
        gap: 1rem;
    }

    .hero-meta .meta-card {
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(226, 232, 240, 0.9);
        padding: 1rem 1.1rem;
        min-height: 96px;
    }

    .meta-label {
        display: block;
        font-size: 0.82rem;
        color: var(--label-color);
        font-weight: 600;
        margin-bottom: 0.35rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }

    .meta-value {
        font-size: 1.05rem;
        color: var(--text-primary);
        font-weight: 700;
    }

    .dashboard-card,
    .profile-card,
    .timeline-card,
    .action-card,
    .details-card {
        border-radius: 24px;
        border: 1px solid var(--card-border);
        background: var(--card-bg);
        box-shadow: var(--card-shadow);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .dashboard-card:hover,
    .profile-card:hover,
    .timeline-card:hover,
    .action-card:hover,
    .details-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-hover);
    }

    .dashboard-card .card-body,
    .profile-card .card-body,
    .timeline-card .card-body,
    .action-card .card-body,
    .details-card {
        padding: 1.75rem;
    }

    .card-section-title {
        margin-bottom: 1rem;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .info-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.65rem;
    }

    .info-table td {
        background: #ffffff;
        padding: 1rem 1rem;
        vertical-align: top;
        border: 1px solid #f1f5f9;
        border-radius: 14px;
    }

    .info-table td:first-child {
        width: 35%;
        color: var(--label-color);
        font-weight: 600;
    }

    .info-table td:last-child {
        color: var(--text-primary);
        font-weight: 600;
    }

    .info-table tr:hover td {
        background: #f8fbff;
    }

    .profile-avatar {
        width: 96px;
        height: 96px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #eef5ff;
        color: #1e3a8a;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 1rem;
        box-shadow: 0 16px 30px rgba(15, 23, 42, 0.08);
    }

    .profile-name {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .profile-subtitle {
        font-size: 0.95rem;
        color: #64748b;
        margin-bottom: 1.5rem;
    }

    .info-list {
        display: grid;
        gap: 0.9rem;
    }

    .info-list-item {
        display: grid;
        gap: 0.3rem;
        padding: 0.95rem 1rem;
        border-radius: 16px;
        background: #f8fbff;
        border: 1px solid #e2e8f0;
    }

    .info-list-item strong {
        font-size: 0.8rem;
        color: var(--label-color);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 700;
    }

    .info-list-item span {
        font-size: 0.95rem;
        color: var(--text-primary);
        font-weight: 600;
    }

    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 10px;
        bottom: 0;
        width: 3px;
        background: #e2e8f0;
        border-radius: 999px;
    }

    .timeline-item {
        position: relative;
        padding-left: 1rem;
        margin-bottom: 1.75rem;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -5px;
        top: 0.2rem;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #60a5fa);
        box-shadow: 0 0 0 8px rgba(99, 102, 241, 0.12);
    }

    .timeline-item .timeline-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--label-color);
        margin-bottom: 0.35rem;
    }

    .timeline-item .timeline-date {
        font-size: 0.96rem;
        color: var(--text-primary);
        font-weight: 600;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1rem;
        border-radius: var(--badge-radius);
        font-size: 0.9rem;
        font-weight: 700;
        color: #fff;
        text-transform: capitalize;
    }

    .status-lulus {
        background: linear-gradient(135deg, #10B981, #34D399);
    }

    .status-naik-kelas {
        background: linear-gradient(135deg, #3B82F6, #60A5FA);
    }

    .status-pindah {
        background: linear-gradient(135deg, #8B5CF6, #A78BFA);
    }

    .status-do {
        background: linear-gradient(135deg, #F59E0B, #FBBF24);
    }

    .status-meninggal {
        background: linear-gradient(135deg, #EF4444, #F87171);
    }

    .btn-soft {
        border-radius: 14px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.06);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }

    .btn-soft:hover {
        transform: translateY(-3px);
        border-color: #94a3b8;
        box-shadow: 0 18px 32px rgba(15, 23, 42, 0.1);
    }

    .btn-action {
        min-width: 140px;
        height: 48px;
        border-radius: 14px;
        font-weight: 700;
    }

    .action-group {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .action-group a,
    .action-group button {
        flex: 1 1 140px;
    }

    .action-group form {
        margin: 0;
        flex: 1 1 140px;
    }

    .details-card {
        border-radius: 20px;
        border: 1px solid #eef2ff;
        background: #ffffff;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.06);
        padding: 1.35rem;
    }

    .details-card h5 {
        margin-bottom: 1rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .details-card p {
        margin-bottom: 0.75rem;
        color: #475569;
        font-weight: 500;
    }

    @media (max-width: 991px) {
        .hero-meta .meta-card {
            min-height: auto;
        }

        .action-group {
            flex-direction: column;
        }
    }

    @media (max-width: 767px) {
        .hero-card {
            padding: 1.5rem;
        }

        .hero-title {
            font-size: 2rem;
        }

        .hero-meta {
            grid-template-columns: 1fr;
        }

        .hero-meta .meta-card {
            min-height: 90px;
        }
    }
</style>

@php
    $studentName = trim($mutasi->siswa->nama_lengkap ?? '');
    $initials = collect(preg_split('/\s+/', $studentName))->filter()->map(function ($segment) {
        return mb_strtoupper(mb_substr($segment, 0, 1));
    })->take(2)->join('');
    $statusClass = 'status-lulus';
    if ($mutasi->status === 'naik_kelas') {
        $statusClass = 'status-naik-kelas';
    } elseif ($mutasi->status === 'pindah') {
        $statusClass = 'status-pindah';
    } elseif ($mutasi->status === 'do') {
        $statusClass = 'status-do';
    } elseif ($mutasi->status === 'meninggal') {
        $statusClass = 'status-meninggal';
    }
@endphp

<div class="container-fluid page-container">
    <div class="hero-card p-4 p-md-5 mb-4">
        <div class="hero-bubbles">
            <span class="bubble bubble-1"></span>
            <span class="bubble bubble-2"></span>
            <span class="bubble bubble-3"></span>
        </div>

        <div class="hero-content">
            <span class="hero-eyebrow">Detail Mutasi</span>
            <h1 class="hero-title">{{ $mutasi->siswa->nama_lengkap }}</h1>
            <p class="hero-subtitle">Ringkasan mutasi siswa dan informasi penting dalam tampilan premium.</p>

            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
                <div class="row hero-meta row-cols-1 row-cols-md-3 gx-3 gy-3 w-100">
                    <div class="col">
                        <div class="meta-card">
                            <span class="meta-label">Status Mutasi</span>
                            <span class="meta-value">
                                <span class="badge-status {{ $statusClass }}">{{ $mutasi->status_label }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="meta-card">
                            <span class="meta-label">Tanggal Mutasi</span>
                            <span class="meta-value">{{ $mutasi->tanggal_mutasi->format('d F Y') }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="meta-card">
                            <span class="meta-label">NIS Siswa</span>
                            <span class="meta-value">{{ $mutasi->siswa->nis }}</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('tu.mutasi.index') }}" class="btn btn-soft btn-action align-self-center">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row gx-4">
        <div class="col-xl-8 col-12">
            <div class="dashboard-card mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
                        <div>
                            <h2 class="card-section-title">Informasi Mutasi</h2>
                            <p class="text-secondary mb-0">Semua data penting mutasi siswa dalam satu tampilan.</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="info-table">
                            <tbody>
                                <tr>
                                    <td>NIS</td>
                                    <td>{{ $mutasi->siswa->nis }}</td>
                                </tr>
                                <tr>
                                    <td>NISN</td>
                                    <td>{{ $mutasi->siswa->nisn ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Siswa</td>
                                    <td>{{ $mutasi->siswa->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <td>Status Mutasi</td>
                                    <td><span class="badge-status {{ $statusClass }}">{{ $mutasi->status_label }}</span></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Mutasi</td>
                                    <td>{{ $mutasi->tanggal_mutasi->format('d F Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="details-card mt-4">
                        <h5>Catatan Mutasi</h5>
                        <p>{!! $mutasi->keterangan ?? '<em class="text-muted">Tidak ada keterangan</em>' !!}</p>

                        @if($mutasi->status === 'pindah')
                            <div class="mt-4">
                                <h5>Data Pindah Sekolah</h5>
                                <p class="mb-2"><strong>Alasan Pindah:</strong> {{ $mutasi->alasan_pindah ?? '-' }}</p>
                                <p class="mb-0"><strong>Sekolah Tujuan:</strong> {{ $mutasi->tujuan_pindah ?? '-' }}</p>
                            </div>
                        @endif

                        @if(in_array($mutasi->status, ['pindah', 'do', 'meninggal']))
                            <div class="mt-4">
                                <h5>Surat Keputusan Keluar</h5>
                                <p class="mb-2"><strong>Nomor SK Keluar:</strong> {{ $mutasi->no_sk_keluar ?? '-' }}</p>
                                <p class="mb-0"><strong>Tanggal SK Keluar:</strong> {{ $mutasi->tanggal_sk_keluar ? $mutasi->tanggal_sk_keluar->format('d F Y') : '-' }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="action-card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-column flex-sm-row gap-3">
                        <div>
                            <h5 class="card-section-title mb-0">Aksi</h5>
                            <p class="text-secondary mb-0">Kelola mutasi siswa dengan cepat.</p>
                        </div>
                    </div>

                    <div class="action-group">
                        <a href="{{ route('tu.mutasi.edit', $mutasi) }}" class="btn btn-warning btn-action">
                            <i class="fas fa-edit me-2"></i> Edit
                        </a>
                        <form action="{{ route('tu.mutasi.destroy', $mutasi) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data mutasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-action w-100">
                                <i class="fas fa-trash me-2"></i> Hapus
                            </button>
                        </form>
                        <a href="{{ route('tu.mutasi.index') }}" class="btn btn-secondary btn-action">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-12">
            <div class="profile-card mb-4">
                <div class="card-body text-center">
                    <div class="profile-avatar">{{ $initials }}</div>
                    <div class="profile-name">{{ $mutasi->siswa->nama_lengkap }}</div>
                    <div class="profile-subtitle">NIS: {{ $mutasi->siswa->nis }}</div>

                    <div class="info-list">
                        <div class="info-list-item">
                            <strong>Jenis Kelamin</strong>
                            <span>{{ $mutasi->siswa->jenis_kelamin }}</span>
                        </div>
                        <div class="info-list-item">
                            <strong>Tempat Lahir</strong>
                            <span>{{ $mutasi->siswa->tempat_lahir }}</span>
                        </div>
                        <div class="info-list-item">
                            <strong>Tanggal Lahir</strong>
                            <span>{{ $mutasi->siswa->tanggal_lahir ? (\Carbon\Carbon::parse($mutasi->siswa->tanggal_lahir)->translatedFormat('d F Y')) : '-' }}</span>
                        </div>
                        <div class="info-list-item">
                            <strong>Agama</strong>
                            <span>{{ $mutasi->siswa->agama ?? '-' }}</span>
                        </div>
                        <div class="info-list-item">
                            <strong>Alamat</strong>
                            <span>{{ Str::limit($mutasi->siswa->alamat ?? '-', 60) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="timeline-card">
                <div class="card-body">
                    <h5 class="card-section-title">Timeline Sistem</h5>
                    <div class="timeline">
                        <div class="timeline-item">
                            <span class="timeline-label">Data dibuat</span>
                            <span class="timeline-date">{{ $mutasi->created_at->format('d F Y, H:i') }}</span>
                        </div>
                        <div class="timeline-item">
                            <span class="timeline-label">Terakhir diperbarui</span>
                            <span class="timeline-date">{{ $mutasi->updated_at->format('d F Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
