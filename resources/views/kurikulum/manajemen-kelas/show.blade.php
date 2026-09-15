@extends('layouts.app')

@section('title', 'Detail Rombel - ' . $rombel->nama)

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: #f7fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    main {
        padding: 20px 15px !important;
        overflow-x: auto !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 10px !important;
        overflow-x: auto !important;
    }

    /* ============ HEADER ============ */
    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.8rem 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: 0 15px 35px -8px rgba(139, 92, 246, 0.45);
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .page-header::before,
    .page-header::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.12);
        pointer-events: none;
    }

    .page-header::before {
        top: -60px;
        right: -40px;
        width: 220px;
        height: 220px;
    }

    .page-header::after {
        bottom: -90px;
        right: 120px;
        width: 160px;
        height: 160px;
        background: rgba(255,255,255,0.08);
    }

    .page-header h3 {
        font-weight: 700;
        letter-spacing: -0.3px;
        position: relative;
        z-index: 1;
        margin-bottom: 0.25rem;
        font-size: 1.4rem;
    }

    .page-header h3 i {
        background: rgba(255,255,255,0.2);
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        margin-right: 8px;
    }

    .page-header .text-muted {
        color: rgba(255,255,255,0.85) !important;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .btn-header-back {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 1.5px solid rgba(255,255,255,0.3);
        color: white;
        font-weight: 600;
        padding: 0.55rem 1.3rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 0.88rem;
        position: relative;
        z-index: 2;
    }

    .btn-header-back:hover {
        background: white;
        color: #6366f1;
        border-color: white;
        transform: translateY(-2px);
    }

    .btn-header-export {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.55rem 1.3rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 0.88rem;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
        position: relative;
        z-index: 2;
    }

    .btn-header-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.5);
        color: white;
    }

    /* ============ INFO CARD ============ */
    .info-card {
        border-radius: var(--border-radius);
        border: 1px solid #eef0f4;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        background: white;
        margin-bottom: 1.5rem;
        width: 100%;
        transition: var(--transition);
    }

    .info-card:hover {
        box-shadow: var(--card-hover-shadow);
    }

    .info-card .card-header {
        background: linear-gradient(to bottom, #ffffff 0%, #fafbfd 100%);
        border-bottom: 1px solid #eef0f4;
        padding: 1.1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 1rem;
    }

    .info-card .card-header h5 i {
        color: #667eea;
        margin-right: 6px;
    }

    .info-card .card-body {
        padding: 1.5rem;
    }

    /* ============ INFO ROW ============ */
    .info-row {
        display: flex;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
        align-items: center;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        width: 200px;
        font-weight: 600;
        color: #64748B;
        font-size: 0.88rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label i {
        color: #94a3b8;
        font-size: 14px;
        width: 18px;
        text-align: center;
    }

    .info-value {
        flex: 1;
        color: #1E293B;
        font-size: 0.92rem;
        font-weight: 500;
    }

    /* ============ BADGES ============ */
    .badge-tingkat {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .badge-tingkat.x {
        background: linear-gradient(135deg, #DBEAFE 0%, #BFDBFE 100%);
        color: #1E40AF;
        box-shadow: 0 2px 8px rgba(59,130,246,0.15);
    }

    .badge-tingkat.xi {
        background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
        color: #B45309;
        box-shadow: 0 2px 8px rgba(245,158,11,0.15);
    }

    .badge-tingkat.xii {
        background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
        color: #047857;
        box-shadow: 0 2px 8px rgba(16,185,129,0.15);
    }

    .badge-jurusan {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(139,92,246,0.25);
    }

    .badge-count {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
        color: #B45309;
        box-shadow: 0 2px 8px rgba(245,158,11,0.15);
    }

    .badge-gender {
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .badge-gender.laki {
        background: linear-gradient(135deg, #DBEAFE 0%, #BFDBFE 100%);
        color: #1E40AF;
    }

    .badge-gender.perempuan {
        background: linear-gradient(135deg, #FCE7F3 0%, #FBCFE8 100%);
        color: #BE185D;
    }

    /* ============ WALI KELAS ============ */
    .wali-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .wali-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(139, 92, 246, 0.3);
    }

    .wali-name {
        font-weight: 700;
        color: #1e293b;
        font-size: 0.95rem;
    }

    .wali-sub {
        font-size: 0.78rem;
        color: #94a3b8;
    }

    /* ============ TABLE ============ */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        min-width: 600px;
        margin-bottom: 0;
        font-size: 0.88rem;
    }

    .table th {
        font-weight: 700;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748B;
        padding: 0.9rem 0.85rem;
        white-space: nowrap;
        background-color: #F8FAFC;
        border-bottom: 2px solid #eef0f4 !important;
    }

    .table td {
        padding: 0.85rem 0.85rem;
        vertical-align: middle;
        border-color: #f1f5f9;
        color: #334155;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8faff;
    }

    /* ============ STUDENT AVATAR ============ */
    .student-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .student-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--primary-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(139, 92, 246, 0.25);
    }

    .student-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .student-name {
        font-weight: 700;
        color: #1e293b;
        font-size: 0.92rem;
        margin-bottom: 2px;
    }

    /* ============ EMPTY STATE ============ */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #CBD5E1;
        display: block;
        margin-bottom: 0.75rem;
        animation: floatY 3s ease-in-out infinite;
    }

    @keyframes floatY {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    /* ============ ACTION FOOTER ============ */
    .action-footer {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .action-footer .btn-action {
        padding: 0.65rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.88rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .btn-action-edit {
        background: linear-gradient(135deg, #F59E0B 0%, #FBBF24 100%);
        color: white;
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
    }

    .btn-action-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(245, 158, 11, 0.5);
        color: white;
    }

    .btn-action-delete {
        background: linear-gradient(135deg, #EF4444 0%, #F87171 100%);
        color: white;
        box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);
    }

    .btn-action-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(239, 68, 68, 0.5);
        color: white;
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 768px) {
        .page-header { padding: 1.3rem 1.2rem; }
        .page-header h3 { font-size: 1.05rem; }
        .info-card .card-body { padding: 1rem 1.2rem; }

        .info-row {
            flex-direction: column;
            align-items: flex-start;
            padding: 0.6rem 0;
        }

        .info-label {
            width: 100%;
            font-size: 0.78rem;
            margin-bottom: 4px;
        }

        .info-value { font-size: 0.88rem; width: 100%; }

        .table { min-width: 500px; font-size: 0.78rem; }
        .table th, .table td { padding: 0.55rem 0.6rem; }

        .btn-header-back, .btn-header-export {
            width: 100%;
            justify-content: center;
        }

        .action-footer .btn-action {
            flex: 1;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .table { min-width: 450px; font-size: 0.72rem; }
        .badge-tingkat, .badge-jurusan, .badge-gender, .badge-count {
            font-size: 0.65rem;
            padding: 3px 10px;
        }
        .student-avatar { width: 32px; height: 32px; font-size: 12px; }
        .wali-avatar { width: 34px; height: 34px; font-size: 14px; }
    }
</style>

<div class="container-fluid px-3 px-md-4">
    <!-- HEADER -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h3><i class="fas fa-users"></i> Detail Rombel</h3>
                <div class="text-muted">{{ $rombel->nama }}</div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                @if(Route::has('kurikulum.kelas.export'))
                    <a href="{{ route('kurikulum.kelas.export', $rombel->id) }}" class="btn-header-export">
                        <i class="fas fa-file-excel"></i> Export
                    </a>
                @endif
                <a href="{{ route('kurikulum.kelas.index') }}" class="btn-header-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- INFO ROMBEL -->
    <div class="info-card">
        <div class="card-header">
            <h5><i class="fas fa-id-card"></i> Informasi Rombel</h5>
        </div>
        <div class="card-body">
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-users"></i> Nama Rombel
                </div>
                <div class="info-value">
                    <strong style="font-size:1rem; color:#1e293b;">{{ $rombel->nama }}</strong>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-layer-group"></i> Tingkat
                </div>
                <div class="info-value">
                    @php
                        $tingkat = strtoupper($rombel->kelas->tingkat ?? '');
                        $tingkatClass = match($tingkat) {
                            'X' => 'x',
                            'XI' => 'xi',
                            'XII' => 'xii',
                            default => 'x'
                        };
                    @endphp
                    <span class="badge-tingkat {{ $tingkatClass }}">
                        <i class="fas fa-graduation-cap"></i>
                        Kelas {{ $rombel->kelas->tingkat ?? '-' }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-building"></i> Jurusan
                </div>
                <div class="info-value">
                    <span class="badge-jurusan">
                        <i class="fas fa-tag"></i>
                        {{ optional($rombel->kelas->jurusan)->nama ?? '-' }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-user-tie"></i> Wali Kelas
                </div>
                <div class="info-value">
                    @if($rombel->guru)
                        <div class="wali-info">
                            <div class="wali-avatar">
                                {{ strtoupper(substr($rombel->guru->nama, 0, 1)) }}
                            </div>
                            <div>
                                <div class="wali-name">{{ $rombel->guru->nama }}</div>
                                @if($rombel->guru->nip)
                                    <div class="wali-sub">NIP: {{ $rombel->guru->nip }}</div>
                                @endif
                            </div>
                        </div>
                    @else
                        <span class="text-muted fst-italic">
                            <i class="fas fa-user-slash me-1"></i> Belum ditentukan
                        </span>
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-user-graduate"></i> Total Siswa
                </div>
                <div class="info-value">
                    <span class="badge-count">
                        <i class="fas fa-users"></i>
                        {{ $rombel->siswa->count() }} Siswa
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- DAFTAR SISWA -->
    <div class="info-card">
        <div class="card-header">
            <h5><i class="fas fa-user-graduate"></i> Daftar Siswa</h5>
            <span class="badge bg-primary ms-auto">{{ $rombel->siswa->count() }} Siswa</span>
        </div>
        <div class="card-body p-0">
            @if($rombel->siswa->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th width="6%">No</th>
                                <th>Nama Siswa</th>
                                <th width="15%">NIS</th>
                                <th width="18%">Jenis Kelamin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rombel->siswa as $key => $siswa)
                                <tr>
                                    <td class="fw-semibold text-secondary">{{ $key + 1 }}</td>
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-avatar">
                                                @if($siswa->user && $siswa->user->photo)
                                                    <img src="{{ asset('storage/' . $siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}">
                                                @else
                                                    {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="student-name">{{ $siswa->nama_lengkap }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-family:monospace; font-weight:600; color:#475569;">
                                            {{ $siswa->nis ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $gender = strtolower($siswa->jenis_kelamin ?? '');
                                            $isLaki = str_contains($gender, 'laki') || $gender == 'l';
                                        @endphp
                                        <span class="badge-gender {{ $isLaki ? 'laki' : 'perempuan' }}">
                                            <i class="fas fa-{{ $isLaki ? 'mars' : 'venus' }}"></i>
                                            {{ $siswa->jenis_kelamin ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h5 class="fw-bold text-muted mt-2">Belum Ada Siswa</h5>
                    <p class="text-muted mb-0">Belum ada siswa yang terdaftar di rombel ini.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="action-footer">
        @if(Route::has('kurikulum.kelas.edit'))
            <a href="{{ route('kurikulum.kelas.edit', $rombel->id) }}" class="btn-action btn-action-edit">
                <i class="fas fa-pen"></i> Edit Rombel
            </a>
        @endif

        @if(Route::has('kurikulum.kelas.destroy'))
            <form action="{{ route('kurikulum.kelas.destroy', $rombel->id) }}" 
                  method="POST" 
                  onsubmit="return confirmDelete(event, '{{ addslashes($rombel->nama) }}')"
                  style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-action btn-action-delete">
                    <i class="fas fa-trash"></i> Hapus Rombel
                </button>
            </form>
        @endif
    </div>
</div>

<script>
    function confirmDelete(e, nama) {
        e.preventDefault();
        if (confirm('Yakin ingin menghapus rombel "' + nama + '"?\n\nTindakan ini tidak bisa dibatalkan!')) {
            e.target.submit();
        }
        return false;
    }
</script>
@endsection