@extends('layouts.app')

@section('title', 'Data Mutasi Guru & Pegawai')

@section('content')
<style>
    /* ==========================================================
       PREMIUM DESIGN 2.0 - SAMA SEPERTI DATA GURU & PEGAWAI
       ========================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    :root {
        --primary: #4F46E5;
        --primary-light: #EEF2FF;
        --primary-dark: #4338CA;
        --success: #10B981;
        --danger: #EF4444;
        --bg-body: #F8FAFC;
        --card-bg: #FFFFFF;
        --text-heading: #0F172A;
        --text-body: #334155;
        --text-muted: #94A3B8;
        --border: #E2E8F0;
        --shadow-card: 0 4px 20px -4px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 12px 40px -8px rgba(0, 0, 0, 0.08);
    }

    body {
        background: var(--bg-body);
        font-family: 'Inter', system-ui, sans-serif;
    }

    .app-container {
        max-width: 1440px;
        margin: 0 auto;
        padding: 28px 36px;
    }

    .card-premium {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid rgba(226, 232, 240, 0.5);
        box-shadow: var(--shadow-card);
        transition: all 0.25s ease;
    }
    .card-premium:hover {
        box-shadow: var(--shadow-hover);
    }

    .header-premium {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 32px;
    }
    .header-title-wrap {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .header-icon {
        width: 48px;
        height: 48px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    .header-title {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--text-heading);
        margin: 0 0 2px 0;
    }
    .header-subtitle {
        font-size: 14px;
        color: var(--text-muted);
        font-weight: 500;
        margin: 0;
    }
    .header-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .btn-premium {
        padding: 10px 22px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-premium-primary {
        background: var(--primary);
        color: #fff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }
    .btn-premium-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.35);
        color: #fff;
    }

    /* --- Table --- */
    .table-container {
        overflow-x: auto;
        padding: 0;
    }
    .table-premium {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    .table-premium thead th {
        padding: 14px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        background: #FAFBFC;
        border-bottom: 1px solid var(--border);
    }
    .table-premium tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid #F1F5F9;
        color: var(--text-body);
    }
    .table-premium tbody tr {
        transition: background 0.15s;
    }
    .table-premium tbody tr:hover {
        background: #F8FAFC;
    }
    .table-premium tbody tr:last-child td {
        border-bottom: none;
    }

    .data-name {
        font-weight: 600;
        color: var(--text-heading);
    }

    /* --- Badges --- */
    .badge-pill {
        display: inline-flex;
        align-items: center;
        padding: 4px 14px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-success-pill { background: #D1FAE5; color: #047857; }
    .badge-danger-pill { background: #FEE2E2; color: #DC2626; }
    .badge-primary-pill { background: #EEF2FF; color: #4F46E5; }
    .badge-secondary-pill { background: #F1F5F9; color: #475569; }
    .badge-dark-pill { background: #E2E8F0; color: #1E293B; }
    .badge-warning-pill { background: #FEF3C7; color: #B45309; }
    .badge-info-pill { background: #ECFEFF; color: #0891B2; }

    .badge-status {
        background: #eef2f7;
        color: #4a5568;
        padding: 4px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    /* --- Stat Cards --- */
    .stat-card {
        transition: all 0.3s ease;
        border: none;
        background: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border-radius: 16px;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    .icon-box {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        margin: 0 auto 12px;
    }

    /* --- Pagination --- */
    .pagination-modern {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 16px 24px 24px;
        border-top: 1px solid #F1F5F9;
    }
    .pagination-modern .page-link {
        border: none;
        border-radius: 10px;
        padding: 8px 14px;
        font-weight: 600;
        font-size: 13px;
        color: var(--text-body);
        transition: 0.2s;
    }
    .pagination-modern .page-link:hover {
        background: #F1F5F9;
        color: var(--primary);
    }
    .pagination-modern .page-item.active .page-link {
        background: var(--primary);
        color: #fff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    @media (max-width: 768px) {
        .app-container { padding: 16px; }
        .header-premium { flex-direction: column; align-items: flex-start; }
        .header-actions { width: 100%; flex-direction: column; }
        .header-actions .btn-premium { width: 100%; justify-content: center; }
    }
</style>

<div class="app-container">
    <!-- Header -->
    <div class="header-premium">
        <div class="header-title-wrap">
            <div class="header-icon"><i class="fas fa-exchange-alt"></i></div>
            <div>
                <h1 class="header-title">Data Mutasi</h1>
                <p class="header-subtitle">Kelola rekam jejak mutasi guru dan pegawai secara sistematis.</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('tu_kepegawaian.mutasi.create') }}" class="btn-premium btn-premium-primary">
                <i class="fas fa-plus me-2"></i> Tambah Data
            </a>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-3 mb-5">
        @php
            $stats = [
                'Masuk' => ['icon' => 'fa-door-open', 'color' => 'text-success', 'bg' => 'bg-success-subtle'],
                'Keluar' => ['icon' => 'fa-door-closed', 'color' => 'text-danger', 'bg' => 'bg-danger-subtle'],
                'Pindah Tugas' => ['icon' => 'fa-truck-moving', 'color' => 'text-primary', 'bg' => 'bg-primary-subtle'],
                'Pensiun' => ['icon' => 'fa-user-clock', 'color' => 'text-secondary', 'bg' => 'bg-secondary-subtle'],
                'Wafat' => ['icon' => 'fa-ribbon', 'color' => 'text-dark', 'bg' => 'bg-dark-subtle'],
                'Diberhentikan' => ['icon' => 'fa-user-slash', 'color' => 'text-warning', 'bg' => 'bg-warning-subtle'],
                'Alih Tugas' => ['icon' => 'fa-retweet', 'color' => 'text-info', 'bg' => 'bg-info-subtle']
            ];
        @endphp

        @foreach($stats as $status => $data)
        <div class="col">
            <div class="card stat-card">
                <div class="card-body p-3 text-center">
                    <div class="icon-box {{ $data['bg'] }} {{ $data['color'] }}">
                        <i class="fas {{ $data['icon'] }}"></i>
                    </div>
                    <div class="h4 fw-bolder text-dark mb-0">{{ \App\Models\Mutasi::where('jenis', $status)->count() }}</div>
                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.6rem;">{{ $status }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Table -->
    <div class="card-premium">
        <div class="table-container">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Nama Lengkap</th>
                        <th>Status</th>
                        <th>Jenis Mutasi</th>
                        <th>Tanggal</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mutasis as $m)
                    <tr>
                        <td class="fw-bold text-center text-secondary" style="font-size: 13px;">{{ $loop->iteration }}</td>
                        <td>
                            <div class="data-name">{{ $m->nama_entitas ?? '-' }}</div>
                        </td>
                        <td>
                            @php
                                $isGuru = \App\Models\Guru::where('nama', $m->nama_entitas)->exists();
                            @endphp
                            <span class="badge-status">{{ $isGuru ? 'GURU' : 'PEGAWAI' }}</span>
                        </td>
                        <td>
                            @php
                                $badgeClass = 'badge-secondary-pill';
                                if($m->jenis == 'Masuk') $badgeClass = 'badge-success-pill';
                                elseif($m->jenis == 'Keluar') $badgeClass = 'badge-danger-pill';
                                elseif($m->jenis == 'Pindah Tugas') $badgeClass = 'badge-primary-pill';
                                elseif($m->jenis == 'Pensiun') $badgeClass = 'badge-secondary-pill';
                                elseif($m->jenis == 'Wafat') $badgeClass = 'badge-dark-pill';
                                elseif($m->jenis == 'Diberhentikan') $badgeClass = 'badge-warning-pill';
                                elseif($m->jenis == 'Alih Tugas') $badgeClass = 'badge-info-pill';
                            @endphp
                            <span class="badge-pill {{ $badgeClass }}">{{ $m->jenis }}</span>
                        </td>
                        <td class="text-secondary">{{ \Carbon\Carbon::parse($m->tanggal)->format('d F Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('tu_kepegawaian.mutasi.edit', $m->id) }}" class="btn btn-sm btn-outline-warning border-0 fw-bold p-1"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('tu_kepegawaian.mutasi.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0 fw-bold p-1"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data mutasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection