@extends('layouts.app')

@section('title', 'Rekap Mutasi Siswa')

@section('content')

<style>
:root{
    --primary:#4F46E5;
    --primary-light:#6366F1;
    --secondary:#7C3AED;

    --success:#10B981;
    --warning:#F59E0B;
    --danger:#EF4444;
    --info:#0EA5E9;

    --bg:#F4F7FE;
    --card:#FFFFFF;
    --border:#E5E7EB;

    --text:#111827;
    --text-light:#6B7280;

    --shadow-sm:0 2px 8px rgba(15,23,42,.05);
    --shadow-md:0 10px 25px rgba(15,23,42,.08);
    --shadow-lg:0 20px 40px rgba(15,23,42,.12);

    --radius:22px;
    --transition:all .25s ease;
}

body{
    background:
        radial-gradient(circle at top right, rgba(99,102,241,.10), transparent 20%),
        radial-gradient(circle at bottom left, rgba(124,58,237,.10), transparent 25%),
        linear-gradient(180deg,#f8faff 0%,#eef2ff 100%);
}

/* ================= PAGE HEADER ================= */

.page-header{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    border-radius:28px;
    padding:34px;
    margin-bottom:28px;
    position:relative;
    overflow:hidden;
    box-shadow:var(--shadow-lg);
}

.page-header::before{
    content:'';
    position:absolute;
    right:-80px;
    top:-80px;
    width:240px;
    height:240px;
    background:rgba(255,255,255,.08);
    border-radius:50%;
}

.page-header::after{
    content:'';
    position:absolute;
    left:-50px;
    bottom:-50px;
    width:180px;
    height:180px;
    background:rgba(255,255,255,.06);
    border-radius:50%;
}

.header-content{
    position:relative;
    z-index:2;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    flex-wrap:wrap;
}

.page-title{
    color:white;
    font-size:34px;
    font-weight:800;
    margin:0;
}

.page-subtitle{
    color:rgba(255,255,255,.85);
    margin-top:8px;
    font-size:14px;
}

.header-actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

/* ================= BUTTON ================= */

.btn-modern{
    border:none;
    border-radius:16px;
    padding:12px 22px;
    font-weight:700;
    font-size:14px;
    transition:var(--transition);
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    cursor:pointer;
}

.btn-modern:hover{
    transform:translateY(-2px);
}

.btn-back{
    background:rgba(255,255,255,.14);
    color:white;
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,.2);
}

.btn-back:hover{
    background:white;
    color:var(--primary);
}

.btn-success-modern{
    background:linear-gradient(135deg,#34D399,#10B981);
    color:white;
    box-shadow:0 10px 24px rgba(16,185,129,.24);
}

.btn-success-modern:hover{
    color:white;
    box-shadow:0 14px 28px rgba(16,185,129,.35);
}

/* ================= STAT CARDS ================= */

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:16px;
    margin-bottom:24px;
}

.stat-card{
    background:white;
    border-radius:20px;
    padding:22px;
    border:1px solid #EEF2FF;
    box-shadow:var(--shadow-sm);
    transition:var(--transition);
    position:relative;
    overflow:hidden;
}

.stat-card:hover{
    transform:translateY(-3px);
    box-shadow:var(--shadow-md);
}

.stat-card::before{
    content:'';
    position:absolute;
    top:0; left:0; right:0;
    height:4px;
}

.stat-card.stat-green::before{ background:linear-gradient(90deg,#10B981,#34D399); }
.stat-card.stat-info::before{ background:linear-gradient(90deg,#0EA5E9,#38BDF8); }
.stat-card.stat-warning::before{ background:linear-gradient(90deg,#F59E0B,#FBBF24); }
.stat-card.stat-danger::before{ background:linear-gradient(90deg,#EF4444,#F87171); }

.stat-content{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
}

.stat-info-label{
    font-size:13px;
    color:var(--text-light);
    font-weight:600;
    margin-bottom:4px;
}

.stat-value{
    font-size:32px;
    font-weight:800;
    line-height:1;
}

.stat-green .stat-value{ color:#059669; }
.stat-info .stat-value{ color:#0284C7; }
.stat-warning .stat-value{ color:#D97706; }
.stat-danger .stat-value{ color:#DC2626; }

.stat-icon{
    width:52px;
    height:52px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    color:white;
    flex-shrink:0;
}

.stat-green .stat-icon{ background:linear-gradient(135deg,#34D399,#10B981); }
.stat-info .stat-icon{ background:linear-gradient(135deg,#38BDF8,#0EA5E9); }
.stat-warning .stat-icon{ background:linear-gradient(135deg,#FBBF24,#F59E0B); }
.stat-danger .stat-icon{ background:linear-gradient(135deg,#F87171,#EF4444); }

/* ================= FILTER CARD ================= */

.filter-card{
    background:rgba(255,255,255,.92);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,.8);
    border-radius:24px;
    padding:24px;
    box-shadow:var(--shadow-md);
    margin-bottom:24px;
}

.filter-title{
    font-size:15px;
    font-weight:800;
    color:var(--text);
    margin:0 0 18px 0;
    display:flex;
    align-items:center;
    gap:8px;
}

.filter-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:16px;
    align-items:end;
}

.form-label{
    font-weight:700;
    color:var(--text);
    margin-bottom:8px;
    display:block;
    font-size:13px;
}

.form-control-modern,
.form-select-modern{
    width:100%;
    border:1.5px solid #dbe3ff;
    background:#f9fbff;
    border-radius:14px;
    padding:11px 14px;
    font-size:14px;
    transition:var(--transition);
}

.form-control-modern:focus,
.form-select-modern:focus{
    outline:none;
    border-color:var(--primary);
    background:white;
    box-shadow:0 0 0 4px rgba(79,70,229,.08);
}

.filter-actions{
    display:flex;
    gap:10px;
}

.btn-filter{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    color:white;
    border:none;
    border-radius:14px;
    padding:11px 20px;
    font-weight:700;
    font-size:14px;
    display:inline-flex;
    align-items:center;
    gap:8px;
    transition:var(--transition);
    cursor:pointer;
    box-shadow:0 8px 18px rgba(79,70,229,.2);
}

.btn-filter:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 24px rgba(79,70,229,.3);
    color:white;
}

.btn-reset{
    background:white;
    color:var(--text);
    border:1.5px solid #dbe3ff;
    border-radius:14px;
    padding:11px 20px;
    font-weight:700;
    font-size:14px;
    display:inline-flex;
    align-items:center;
    gap:8px;
    transition:var(--transition);
    text-decoration:none;
}

.btn-reset:hover{
    background:#f8faff;
    color:var(--text);
}

/* ================= TABLE CARD ================= */

.table-card{
    background:rgba(255,255,255,.92);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,.8);
    border-radius:24px;
    overflow:hidden;
    box-shadow:var(--shadow-md);
}

.table-header{
    padding:20px 24px;
    border-bottom:1px solid #eef2ff;
    background:linear-gradient(135deg,rgba(79,70,229,.05),rgba(124,58,237,.05));
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

.table-title{
    font-size:17px;
    font-weight:800;
    color:var(--text);
    margin:0;
    display:flex;
    align-items:center;
    gap:10px;
}

.table-badge{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    color:white;
    padding:4px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:700;
}

.table-responsive{
    overflow-x:auto;
}

.table-modern{
    width:100%;
    border-collapse:collapse;
    font-size:13px;
}

.table-modern thead th{
    background:#f8faff;
    color:#334155;
    font-weight:800;
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:.5px;
    padding:14px 14px;
    text-align:left;
    border-bottom:1px solid #eef2ff;
    white-space:nowrap;
}

.table-modern tbody td{
    padding:14px 14px;
    border-bottom:1px solid #f1f5f9;
    vertical-align:middle;
    color:var(--text);
}

.table-modern tbody tr{
    transition:var(--transition);
}

.table-modern tbody tr:hover{
    background:#f8faff;
}

.table-modern tbody tr:last-child td{
    border-bottom:none;
}

/* Badges */
.badge-modern{
    display:inline-flex;
    align-items:center;
    gap:4px;
    padding:5px 12px;
    border-radius:10px;
    font-size:11px;
    font-weight:700;
    white-space:nowrap;
}

.badge-success{ background:linear-gradient(135deg,#D1FAE5,#A7F3D0); color:#065F46; }
.badge-info{ background:linear-gradient(135deg,#DBEAFE,#BFDBFE); color:#1E40AF; }
.badge-warning{ background:linear-gradient(135deg,#FEF3C7,#FDE68A); color:#92400E; }
.badge-danger{ background:linear-gradient(135deg,#FEE2E2,#FECACA); color:#991B1B; }
.badge-primary{ background:linear-gradient(135deg,#E0E7FF,#C7D2FE); color:#3730A3; }
.badge-secondary{ background:linear-gradient(135deg,#F1F5F9,#E2E8F0); color:#475569; }

.student-name{
    font-weight:700;
    color:var(--text);
    font-size:13px;
}

.student-nis{
    font-size:11px;
    color:var(--text-light);
    margin-top:2px;
}

/* Empty state */
.empty-state{
    padding:60px 20px;
    text-align:center;
    color:var(--text-light);
}

.empty-state i{
    font-size:48px;
    color:#CBD5E1;
    margin-bottom:16px;
    display:block;
}

.empty-state h5{
    font-weight:700;
    color:#334155;
    margin-bottom:6px;
}

.empty-state p{
    font-size:13px;
    margin:0;
}

/* Pagination */
.pagination-wrapper{
    padding:18px 24px;
    border-top:1px solid #eef2ff;
    background:#fafbff;
}

/* ================= RESPONSIVE ================= */

@media(max-width:768px){
    .page-header{ padding:26px; }
    .page-title{ font-size:26px; }
    .stats-grid{ grid-template-columns:1fr 1fr; }
    .filter-grid{ grid-template-columns:1fr; }
    .header-actions{ width:100%; }
    .header-actions .btn-modern{ flex:1; }
    .table-header{ padding:16px; }
    .table-modern thead th,
    .table-modern tbody td{
        padding:10px 12px;
        font-size:12px;
    }
}
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    {{-- ================= HEADER ================= --}}
    <div class="page-header">
        <div class="header-content">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-list-alt me-2"></i>
                    Rekap Mutasi Siswa
                </h1>
                <div class="page-subtitle">
                    Riwayat lengkap mutasi masuk dan keluar siswa
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('tu.mutasi.masuk.create') }}" class="btn-modern btn-success-modern">
                    <i class="fas fa-plus"></i> Tambah Siswa Pindahan
                </a>
                <a href="{{ route('tu.mutasi.index') }}" class="btn-modern btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- ================= STATISTIK ================= --}}
    <div class="stats-grid">
        <div class="stat-card stat-green">
            <div class="stat-content">
                <div>
                    <div class="stat-info-label">Mutasi Masuk</div>
                    <div class="stat-value">{{ $stats['total_masuk'] }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
            </div>
        </div>

        <div class="stat-card stat-info">
            <div class="stat-content">
                <div>
                    <div class="stat-info-label">Pindah Keluar</div>
                    <div class="stat-value">{{ $stats['total_pindah'] }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-content">
                <div>
                    <div class="stat-info-label">Putus Sekolah</div>
                    <div class="stat-value">{{ $stats['total_do'] }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-user-slash"></i>
                </div>
            </div>
        </div>

        <div class="stat-card stat-danger">
            <div class="stat-content">
                <div>
                    <div class="stat-info-label">Meninggal</div>
                    <div class="stat-value">{{ $stats['total_meninggal'] }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-heart-broken"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= FILTER ================= --}}
    <div class="filter-card">
        <h5 class="filter-title">
            <i class="fas fa-filter text-primary"></i>
            Filter Data Mutasi
        </h5>

        <form method="GET">
            <div class="filter-grid">
                <div>
                    <label class="form-label">Jenis Mutasi</label>
                    <select name="jenis" class="form-select-modern">
                        <option value="semua"  {{ $jenis === 'semua'  ? 'selected' : '' }}>Semua Jenis</option>
                        <option value="masuk"  {{ $jenis === 'masuk'  ? 'selected' : '' }}>Mutasi Masuk</option>
                        <option value="keluar" {{ $jenis === 'keluar' ? 'selected' : '' }}>Mutasi Keluar</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari"
                           class="form-control-modern"
                           value="{{ request('tanggal_dari') }}">
                </div>

                <div>
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai"
                           class="form-control-modern"
                           value="{{ request('tanggal_sampai') }}">
                </div>

                <div>
                    <label class="form-label">Cari Siswa</label>
                    <input type="text" name="search"
                           class="form-control-modern"
                           value="{{ request('search') }}"
                           placeholder="Nama / NIS / NISN">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn-filter">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('tu.mutasi.rekap') }}" class="btn-reset">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- ================= TABEL ================= --}}
    <div class="table-card">
        <div class="table-header">
            <h5 class="table-title">
                <i class="fas fa-database text-primary"></i>
                Daftar Mutasi
            </h5>
            <span class="table-badge">
                Total: {{ $mutasis->total() }} data
            </span>
        </div>

        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Rombel</th>
                        <th>Jenis</th>
                        <th>Asal / Tujuan</th>
                        <th>Alasan</th>
                        <th>No. Surat</th>
                        <th>Diproses</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mutasis as $i => $m)
                        <tr>
                            <td>
                                <strong style="color:#94A3B8;">
                                    {{ $mutasis->firstItem() + $i }}
                                </strong>
                            </td>
                            <td>
                                <div style="font-weight:600; color:#334155; font-size:12px;">
                                    {{ $m->tanggal_mutasi ? $m->tanggal_mutasi->format('d/m/Y') : '-' }}
                                </div>
                            </td>
                            <td>
                                <div class="student-name">
                                    {{ $m->siswa->nama_lengkap ?? '-' }}
                                </div>
                                <div class="student-nis">
                                    NIS: {{ $m->siswa->nis ?? '-' }}
                                </div>
                            </td>
                            <td>
                                @if($m->status === 'masuk')
                                    <span class="badge-modern badge-success">
                                        <i class="fas fa-sign-in-alt"></i>
                                        {{ $m->rombelTujuan->nama ?? '-' }}
                                    </span>
                                @else
                                    <span class="badge-modern badge-secondary">
                                        {{ $m->rombelAsal->nama ?? '-' }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge-modern badge-{{ $m->status_color }}">
                                    {{ $m->status_label }}
                                </span>
                            </td>
                            <td>
                                @if($m->status === 'masuk')
                                    <div style="font-size:12px; color:#059669; font-weight:600;">
                                        <i class="fas fa-arrow-right"></i>
                                        {{ $m->sekolah_asal ?? '-' }}
                                    </div>
                                @elseif($m->status === 'pindah')
                                    <div style="font-size:12px; color:#0284C7; font-weight:600;">
                                        <i class="fas fa-arrow-right"></i>
                                        {{ $m->tujuan_pindah ?? '-' }}
                                    </div>
                                @else
                                    <span style="color:#94A3B8;">-</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-size:12px; color:#475569; max-width:200px;">
                                    {{ $m->alasan_pindah ?? $m->keterangan ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <div style="font-size:11px; color:#475569; font-family:monospace;">
                                    {{ $m->no_surat_masuk ?? $m->no_sk_keluar ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <div style="font-size:12px; color:#64748B;">
                                    <i class="fas fa-user-circle me-1"></i>
                                    {{ $m->diprosesOleh->name ?? '-' }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <h5>Belum Ada Data Mutasi</h5>
                                    <p>Data mutasi siswa akan muncul di sini setelah diproses.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mutasis->hasPages())
            <div class="pagination-wrapper">
                {{ $mutasis->links() }}
            </div>
        @endif
    </div>

</div>

@endsection