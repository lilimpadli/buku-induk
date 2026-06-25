@extends('layouts.app')

@section('title', 'Detail Rombel: ' . $rombel->nama)

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
        --bg: #F4F7FE;
        --card: #FFFFFF;
        --border: #E5E7EB;
        --text: #111827;
        --text-light: #6B7280;
        --shadow-sm: 0 2px 8px rgba(15,23,42,.05);
        --shadow-md: 0 10px 25px rgba(15,23,42,.08);
        --shadow-lg: 0 18px 35px rgba(15,23,42,.12);
        --radius: 20px;
        --transition: all .25s ease;
    }

    body {
        background: linear-gradient(180deg, #f8faff 0%, #eef2ff 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* ================= HEADER ================= */

    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 28px;
        padding: 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .page-header::before {
        content: '';
        position: absolute;
        width: 240px;
        height: 240px;
        background: rgba(255, 255, 255, .08);
        border-radius: 50%;
        top: -80px;
        right: -70px;
    }

    .page-header::after {
        content: '';
        position: absolute;
        width: 180px;
        height: 180px;
        background: rgba(255, 255, 255, .05);
        border-radius: 50%;
        bottom: -60px;
        left: -40px;
    }

    .header-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        flex-wrap: wrap;
    }

    .header-left {
        flex: 1;
        min-width: 250px;
    }

    .page-header h1 {
        font-size: 34px;
        font-weight: 800;
        color: white;
        margin: 0 0 8px 0;
        text-shadow: 0 2px 8px rgba(0, 0, 0, .15);
    }

    .page-header .subtitle {
        font-size: 14px;
        color: rgba(255, 255, 255, .85);
        margin: 0;
    }

    .page-header .meta {
        display: flex;
        gap: 12px;
        margin-top: 12px;
        flex-wrap: wrap;
    }

    .meta-badge {
        background: rgba(255, 255, 255, .14);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, .15);
        border-radius: 12px;
        padding: 8px 14px;
        color: white;
        font-size: 12px;
        font-weight: 600;
    }

    /* ================= ACTION BUTTONS ================= */

    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-modern {
        border: 1px solid rgba(148, 163, 184, .18);
        border-radius: 16px;
        padding: 12px 20px;
        font-weight: 700;
        color: var(--text);
        background: #ffffff;
        box-shadow: var(--shadow-sm);
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease, color .2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        white-space: nowrap;
        font-size: 14px;
        cursor: pointer;
        border: none;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        background: #f8fafc;
    }

    .btn-modern:active,
    .btn-modern:focus-visible {
        transform: scale(.98);
        box-shadow: 0 8px 16px rgba(15, 23, 42, .12);
    }

    .btn-modern-white {
        background: white;
        color: var(--primary);
    }

    .btn-modern-outline {
        background: transparent;
        color: white;
        border: 1.5px solid rgba(255, 255, 255, .3);
    }

    .btn-modern-outline:hover {
        background: rgba(255, 255, 255, .1);
        border-color: rgba(255, 255, 255, .5);
    }

    /* ================= INFO CARDS ================= */

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .info-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: var(--shadow-sm);
        transition: transform .2s ease, box-shadow .2s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, .05);
    }

    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary), var(--secondary));
    }

    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .info-label {
        font-size: 12px;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .info-value {
        font-size: 18px;
        font-weight: 700;
        color: var(--text);
        word-break: break-word;
    }

    /* ================= STUDENT TABLE ================= */

    .table-container {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, .05);
    }

    .table-header {
        padding: 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .table-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .table-title h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .student-count {
        background: var(--primary);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: var(--bg);
    }

    th {
        padding: 12px 16px;
        text-align: left;
        font-weight: 700;
        color: var(--text-light);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border);
    }

    td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border);
    }

    tbody tr {
        transition: background .2s ease;
    }

    tbody tr:hover {
        background: #f9fafb;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
        font-size: 14px;
        flex-shrink: 0;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
    }

    .student-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .student-name {
        font-weight: 600;
        color: var(--text);
        font-size: 14px;
    }

    .badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-laki {
        background: rgba(59, 130, 246, .1);
        color: #3B82F6;
    }

    .badge-perempuan {
        background: rgba(236, 72, 153, .1);
        color: #EC4899;
    }

    /* ================= EMPTY STATE ================= */

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-light);
    }

    .empty-state i {
        font-size: 48px;
        color: #CBD5E1;
        margin-bottom: 16px;
    }

    .empty-state h4 {
        font-size: 18px;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 8px 0;
    }

    .empty-state p {
        margin: 0;
        font-size: 14px;
    }

    /* ================= RESPONSIVE ================= */

    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .action-buttons {
            width: 100%;
        }

        .btn-modern {
            flex: 1;
            justify-content: center;
        }

        .page-header h1 {
            font-size: 28px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .table-header {
            flex-direction: column;
            align-items: stretch;
        }

        th, td {
            padding: 10px 12px;
            font-size: 13px;
        }

        .student-avatar {
            width: 36px;
            height: 36px;
        }
    }

    @media (max-width: 480px) {
        .page-header {
            padding: 20px;
        }

        .page-header h1 {
            font-size: 24px;
        }

        .page-header .subtitle {
            font-size: 12px;
        }

        .action-buttons {
            gap: 8px;
        }

        .btn-modern {
            padding: 10px 16px;
            font-size: 13px;
        }

        .info-value {
            font-size: 16px;
        }

        th, td {
            padding: 8px 10px;
            font-size: 12px;
        }

        .student-info {
            gap: 8px;
        }

        .student-avatar {
            width: 32px;
            height: 32px;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <h1>{{ $rombel->nama }}</h1>
                <p class="subtitle">Detail Rombel / Kelas</p>
                <div class="meta">
                    @if($rombel->kelas)
                        <span class="meta-badge">
                            <i class="fas fa-layer-group"></i> Tingkat {{ $rombel->kelas->tingkat }}
                        </span>
                    @endif
                    @if($rombel->kelas && $rombel->kelas->jurusan)
                        <span class="meta-badge">
                            <i class="fas fa-briefcase"></i> {{ $rombel->kelas->jurusan->nama }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="action-buttons">
                <a href="{{ route('tu.kelas.export', $rombel->id) }}" class="btn-modern btn-modern-white">
                    <i class="fas fa-file-excel"></i>
                    Export
                </a>
                <a href="{{ route('tu.kelas.edit', $rombel->id) }}" class="btn-modern btn-modern-outline">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <a href="{{ request()->header('referer') ?: route('tu.kelas.index') }}" class="btn-modern btn-modern-outline">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="info-grid">
        <div class="info-card">
            <p class="info-label">Nama Kelas</p>
            <p class="info-value">{{ $rombel->nama }}</p>
        </div>
        <div class="info-card">
            <p class="info-label">Jurusan</p>
            <p class="info-value">{{ $rombel->kelas->jurusan->nama ?? '-' }}</p>
        </div>
        <div class="info-card">
            <p class="info-label">Wali Kelas</p>
            <p class="info-value">{{ $rombel->guru->nama ?? '-' }}</p>
        </div>
        <div class="info-card">
            <p class="info-label">Jumlah Siswa</p>
            <p class="info-value">{{ $rombel->siswa->count() }}</p>
        </div>
    </div>

    <!-- Student Table -->
    <div class="table-container">
        <div class="table-header">
            <div class="table-title">
                <h3>Daftar Siswa</h3>
                <span class="student-count">{{ $rombel->siswa->count() }} Siswa</span>
            </div>
        </div>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
                    @forelse($rombel->siswa as $siswa)
                        <tr data-name="{{ strtolower($siswa->nama_lengkap) }}" data-nis="{{ strtolower($siswa->nis) }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">
                                        @if($siswa->foto)
                                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                                        @else
                                            {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                        @endif
                                    </div>
                                    <span class="student-name">{{ $siswa->nama_lengkap }}</span>
                                </div>
                            </td>
                            <td>{{ $siswa->nis }}</td>
                            <td>
                                <span class="badge badge-{{ $siswa->jenis_kelamin == 'L' ? 'laki' : 'perempuan' }}">
                                    <i class="fas fa-{{ $siswa->jenis_kelamin == 'L' ? 'mars' : 'venus' }}"></i>
                                    {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="fas fa-user-graduate"></i>
                                    <h4>Belum ada siswa</h4>
                                    <p>Belum ada data siswa untuk rombel ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth interaction effects to cards
        document.querySelectorAll('.info-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transition = 'transform .3s ease, box-shadow .3s ease';
            });
        });

        // Add ripple effect to modern buttons
        document.querySelectorAll('.btn-modern').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('btn-ripple');

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    });
</script>

<style>
    /* Button ripple effect */
    .btn-modern {
        position: relative;
        overflow: hidden;
    }

    .btn-ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, .5);
        transform: scale(0);
        animation: ripple-effect .6s ease-out;
        pointer-events: none;
    }

    @keyframes ripple-effect {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
</style>
@endsection