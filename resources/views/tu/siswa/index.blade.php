@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('content')

<style>
:root{
    --primary:#4F46E5;
    --primary-light:#6366F1;
    --secondary:#7C3AED;

    --success:#10B981;
    --warning:#F59E0B;
    --danger:#EF4444;
    --info:#3B82F6;

    --bg:#F4F7FE;
    --card:#FFFFFF;
    --border:#E5E7EB;

    --text:#111827;
    --text-light:#6B7280;

    --shadow-sm:0 2px 8px rgba(15,23,42,.05);
    --shadow-md:0 10px 25px rgba(15,23,42,.08);
    --shadow-lg:0 18px 35px rgba(15,23,42,.12);

    --radius:20px;
    --transition:all .25s ease;
}

body{
    background:linear-gradient(180deg,#f8faff 0%,#eef2ff 100%);
}

/* ================= HEADER ================= */

.page-header{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    border-radius:28px;
    padding:32px;
    margin-bottom:24px;
    position:relative;
    overflow:hidden;
    box-shadow:var(--shadow-lg);
}

.page-header::before{
    content:'';
    position:absolute;
    width:240px;
    height:240px;
    background:rgba(255,255,255,.08);
    border-radius:50%;
    top:-80px;
    right:-70px;
}

.page-header::after{
    content:'';
    position:absolute;
    width:180px;
    height:180px;
    background:rgba(255,255,255,.05);
    border-radius:50%;
    bottom:-60px;
    left:-40px;
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

.header-right{
    display:flex;
    align-items:center;
    gap:16px;
    flex-wrap:wrap;
}

.stat-card{
    background:rgba(255,255,255,.14);
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,.15);
    border-radius:18px;
    padding:16px 20px;
    color:white;
    min-width:120px;
}

.stat-number{
    font-size:24px;
    font-weight:700;
}

.stat-label{
    font-size:12px;
    opacity:.9;
}

/* ================= BUTTON ================= */

.btn-modern{
    border:1px solid rgba(148,163,184,.18);
    border-radius:16px;
    padding:12px 20px;
    font-weight:700;
    color:var(--text);
    background:#ffffff;
    box-shadow:var(--shadow-sm);
    transition:transform .2s ease, box-shadow .2s ease, background .2s ease, color .2s ease;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    text-decoration:none;
    white-space:nowrap;
}

.btn-modern:hover{
    transform:translateY(-2px);
    box-shadow:var(--shadow-md);
    background:#f8fafc;
}

.btn-modern:active,
.btn-modern:focus-visible{
    transform:scale(.98);
    box-shadow:0 8px 16px rgba(15,23,42,.12);
}

.btn-primary-modern{
    background:#ffffff;
    color:var(--primary);
    border-color:rgba(79,70,229,.15);
}

.btn-success-modern{
    background:#ffffff;
    color:var(--success);
    border-color:rgba(16,185,129,.15);
}

.btn-warning-modern{
    background:#ffffff;
    color:var(--warning);
    border-color:rgba(245,158,11,.15);
}

.btn-info-modern{
    background:#ffffff;
    color:var(--info);
    border-color:rgba(59,130,246,.15);
}

.btn-outline-modern{
    background:#ffffff;
    color:var(--primary);
    border:1px solid rgba(148,163,184,.25);
}

.btn-outline-modern:hover{
    background:var(--primary);
    color:white;
}

/* ================= FILTER ================= */

.glass-card{
    background:rgba(255,255,255,.92);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,.8);
    border-radius:24px;
    box-shadow:var(--shadow-md);
    margin-bottom:24px;
    overflow:hidden;
}

.card-header-modern{
    padding:22px 24px;
    border-bottom:1px solid #eef2ff;
}

.card-title-modern{
    margin:0;
    font-size:18px;
    font-weight:700;
    color:var(--text);
    display:flex;
    align-items:center;
    gap:10px;
}

.card-body-modern{
    padding:24px;
}

.filter-grid{
    display:grid;
    grid-template-columns:2fr 1fr auto;
    gap:16px;
}

.form-control-modern,
.form-select-modern{
    border:1.5px solid #dbe3ff;
    background:#f9fbff;
    border-radius:14px;
    padding:13px 16px;
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

/* ================= FILTER PILL ================= */

.class-filter{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    margin-bottom:24px;
}

.filter-pill{
    padding:10px 18px;
    border-radius:999px;
    background:white;
    color:var(--text-light);
    border:1px solid #e5e7eb;
    font-size:14px;
    font-weight:600;
    text-decoration:none;
    transition:var(--transition);
}

.filter-pill:hover{
    background:var(--primary);
    color:white;
    transform:translateY(-2px);
}

.filter-pill.active{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    color:white;
    border:none;
    box-shadow:0 10px 20px rgba(79,70,229,.18);
}

/* ================= TABLE ================= */

.table-card{
    background:white;
    border-radius:24px;
    overflow:hidden;
    box-shadow:var(--shadow-md);
    border:1px solid #eef2ff;
}

.table-responsive{
    overflow-x:auto;
}

.table-modern{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
    min-width:1000px;
}

.table-modern thead{
    background:#f8faff;
}

.table-modern thead th{
    padding:18px 20px;
    font-size:13px;
    font-weight:700;
    color:#64748B;
    text-transform:uppercase;
    letter-spacing:.4px;
    border-bottom:1px solid #eef2ff;
    white-space:nowrap;
}

.table-modern tbody tr{
    transition:var(--transition);
}

.table-modern tbody tr:hover{
    background:#f8faff;
}

.table-modern tbody td{
    padding:18px 20px;
    border-bottom:1px solid #f1f5f9;
    vertical-align:middle;
}

.student-info{
    display:flex;
    align-items:center;
    gap:14px;
}

.student-avatar{
    width:52px;
    height:52px;
    border-radius:50%;
    overflow:hidden;
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-weight:700;
    font-size:18px;
    flex-shrink:0;
}

.student-avatar img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.student-name{
    font-size:15px;
    font-weight:700;
    color:var(--text);
    text-decoration:none;
}

.student-name:hover{
    color:var(--primary);
}

.student-sub{
    font-size:13px;
    color:var(--text-light);
    margin-top:2px;
}

.badge-modern{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:8px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.badge-class{
    background:rgba(79,70,229,.1);
    color:var(--primary);
}

.badge-gender-male{
    background:#e0f2fe;
    color:#0284c7;
}

.badge-gender-female{
    background:#fce7f3;
    color:#db2777;
}

.badge-gender-other{
    background:#f1f5f9;
    color:#475569;
}

/* ================= ACTION ================= */

.action-group{
    display:flex;
    gap:8px;
}

.action-btn{
    width:38px;
    height:38px;
    border:none;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    transition:var(--transition);
    cursor:pointer;
    text-decoration:none;
}

.action-btn:hover{
    transform:translateY(-2px);
}

.btn-detail{
    background:linear-gradient(135deg,#3B82F6,#60A5FA);
}

.btn-edit{
    background:linear-gradient(135deg,#F59E0B,#FBBF24);
}

.btn-delete{
    background:linear-gradient(135deg,#EF4444,#F87171);
}

/* ================= EMPTY ================= */

.empty-state{
    text-align:center;
    padding:90px 20px;
}

.empty-icon{
    font-size:80px;
    color:#c7d2fe;
    margin-bottom:18px;
}

.empty-title{
    font-size:28px;
    font-weight:700;
    color:var(--text);
}

.empty-description{
    margin-top:8px;
    color:var(--text-light);
}

/* ================= PAGINATION ================= */

.pagination-wrapper{
    margin-top:26px;
    display:flex;
    justify-content:center;
}

.pagination{
    gap:8px;
}

.pagination .page-item{
    list-style:none;
}

.pagination .page-link{
    min-width:44px;
    height:44px;
    border:none !important;
    border-radius:14px !important;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:600;
    color:var(--primary);
    background:white;
    box-shadow:0 3px 10px rgba(15,23,42,.05);
    transition:var(--transition);
}

.pagination .page-link:hover{
    background:var(--primary);
    color:white;
    transform:translateY(-2px);
}

.pagination .page-item.active .page-link{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    color:white;
}

.pagination .page-item.disabled .page-link{
    background:#f1f5f9;
    color:#94A3B8;
    cursor:not-allowed;
    box-shadow:none;
}

/* ================= ALERT ================= */

.alert-modern{
    border:none;
    border-radius:18px;
    padding:18px 22px;
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:20px;
    box-shadow:var(--shadow-sm);
}

.alert-success-modern{
    background:#ecfdf5;
    color:#059669;
}

/* ================= TOOLTIP ================= */

[tooltip] {
    position: relative;
    cursor: pointer;
}

[tooltip]:before {
    content: attr(tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(-8px);
    background: #1f2937;
    color: white;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: all 0.2s ease;
    z-index: 1000;
}

[tooltip]:hover:before {
    opacity: 1;
    transform: translateX(-50%) translateY(-12px);
}

/* ================= RESPONSIVE ================= */

@media(max-width:768px){

    .page-header{
        padding:24px;
    }

    .page-title{
        font-size:28px;
    }

    .filter-grid{
        grid-template-columns:1fr;
    }

    .header-content{
        align-items:flex-start;
    }

    .header-right{
        width:100%;
    }

}

</style>

<div class="container-fluid px-3 px-md-4 py-4">

    <!-- HEADER -->
    <div class="page-header">

        <div class="header-content">

            <div>
                <h1 class="page-title">Daftar Siswa</h1>

                <div class="page-subtitle">
                    Kelola seluruh data siswa dengan tampilan modern & rapi
                </div>
            </div>

            <div class="header-right">

                <div class="stat-card">
                    <div class="stat-number">{{ $siswas->total() }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>

                <a href="{{ route('tu.siswa.export', collect(request()->query())->except('page')->toArray()) }}"
                   class="btn-modern btn-success-modern">
                    <i class="fas fa-file-excel"></i>
                    Export Excel
                </a>

                <a href="{{ route('tu.siswa.template') }}"
                   class="btn-modern btn-warning-modern">
                    <i class="fas fa-download"></i>
                    Download Template
                </a>

                <button type="button"
                        class="btn-modern btn-info-modern"
                        data-bs-toggle="modal"
                        data-bs-target="#importModal">
                    <i class="fas fa-file-import"></i>
                    Import Excel
                </button>

                <a href="{{ route('tu.siswa.create') }}"
                   class="btn-modern btn-primary-modern">
                    <i class="fas fa-plus"></i>
                    Tambah Siswa
                </a>

            </div>

        </div>

    </div>
<!-- FILTER TINGKAT -->
<div class="class-filter">
    <a href="{{ request()->url() }}?tingkat=X{{ request()->getQueryString() ? '&' . http_build_query(array_diff_key(request()->query(), ['tingkat' => ''])) : '' }}"
       class="filter-pill {{ $currentTingkat == 'X' ? 'active' : '' }}">
        <i class="fas fa-layer-group"></i> Kelas X
    </a>
    <a href="{{ request()->url() }}?tingkat=XI{{ request()->getQueryString() ? '&' . http_build_query(array_diff_key(request()->query(), ['tingkat' => ''])) : '' }}"
       class="filter-pill {{ $currentTingkat == 'XI' ? 'active' : '' }}">
        <i class="fas fa-layer-group"></i> Kelas XI
    </a>
    <a href="{{ request()->url() }}?tingkat=XII{{ request()->getQueryString() ? '&' . http_build_query(array_diff_key(request()->query(), ['tingkat' => ''])) : '' }}"
       class="filter-pill {{ $currentTingkat == 'XII' ? 'active' : '' }}">
        <i class="fas fa-layer-group"></i> Kelas XII
    </a>
    <a href="{{ route('tu.siswa.index') }}"
       class="filter-pill {{ !$currentTingkat ? 'active' : '' }}">
        <i class="fas fa-globe"></i> Semua
    </a>
</div>

<!-- FILTER -->
<div class="glass-card">
    <div class="card-header-modern">
        <h5 class="card-title-modern">
            <i class="fas fa-filter"></i> Filter Data
        </h5>
    </div>

    <div class="card-body-modern">
        <!-- FORM FILTER UTAMA -->
        <form method="GET" action="{{ route('tu.siswa.index') }}">
            <div class="filter-grid">
                <input type="text"
                       name="search"
                       value="{{ $search ?? '' }}"
                       class="form-control-modern"
                       placeholder="Cari nama / NIS / NISN">

                <select name="rombel" class="form-select-modern">
                    <option value="">Semua Rombel</option>
                    @foreach(($allRombels ?? collect()) as $r)
                        @php
                            $rombelNama = $r->nama ?? null;
                            $tingkatVal = optional($r->kelas)->tingkat ?? null;
                            $rombelWithoutTingkat = $rombelNama
                                ? preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama)
                                : null;
                            $rombelWithoutTingkat = $rombelWithoutTingkat
                                ? trim($rombelWithoutTingkat)
                                : null;
                            $formattedRombel = $rombelWithoutTingkat
                                ? preg_replace('/(\D+)(\d+)/', '$1 $2', $rombelWithoutTingkat)
                                : ($rombelNama ?? '');
                        @endphp
                        <option value="{{ $r->id }}"
                            {{ (isset($filterRombel) && $filterRombel == $r->id) ? 'selected' : '' }}>
                            {{ $tingkatVal ? $tingkatVal . ' ' . $formattedRombel : $formattedRombel }}
                        </option>
                    @endforeach
                </select>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-modern btn-outline-modern">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('tu.siswa.index') }}" class="btn-modern btn-outline-modern">
                        <i class="fas fa-rotate-right"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- FORM EXPORT PER KELAS -->
        <form method="GET" action="{{ route('tu.siswa.exportByKelas') }}" style="margin-top: 16px;">
            <div class="filter-grid">
                <select name="rombel" class="form-select-modern" required>
                    <option value="">Pilih Kelas untuk Export</option>
                    @foreach(($allRombels ?? collect()) as $r)
                        @php
                            $rombelNama = $r->nama ?? null;
                            $tingkatVal = optional($r->kelas)->tingkat ?? null;
                            $rombelWithoutTingkat = $rombelNama
                                ? preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama)
                                : null;
                            $rombelWithoutTingkat = $rombelWithoutTingkat
                                ? trim($rombelWithoutTingkat)
                                : null;
                            $formattedRombel = $rombelWithoutTingkat
                                ? preg_replace('/(\D+)(\d+)/', '$1 $2', $rombelWithoutTingkat)
                                : ($rombelNama ?? '');
                        @endphp
                        <option value="{{ $r->id }}">
                            {{ $tingkatVal ? $tingkatVal . ' ' . $formattedRombel : $formattedRombel }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn-modern btn-success-modern">
                    <i class="fas fa-file-excel"></i> Export Per Kelas
                </button>
            </div>
        </form>

        <!-- FORM EXPORT PER JURUSAN -->
        <form method="GET" action="{{ route('tu.siswa.exportByJurusan') }}" style="margin-top: 16px;">
            <div class="filter-grid">
                <select name="jurusan" class="form-select-modern" required>
                    <option value="">Pilih Jurusan untuk Export</option>
                    @foreach(($allJurusans ?? collect()) as $j)
                        <option value="{{ $j->id }}">{{ $j->nama }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn-modern btn-success-modern">
                    <i class="fas fa-file-excel"></i> Export Per Jurusan
                </button>
            </div>
        </form>

        <!-- FORM EXPORT SISWA AKTIF -->
        <form method="GET" action="{{ route('tu.siswa.exportAktif') }}" style="margin-top: 16px;">
            <div class="filter-grid">
                <button type="submit" class="btn-modern btn-success-modern" style="grid-column: 1 / -1;">
                    <i class="fas fa-file-excel"></i> Export Siswa Aktif
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ALERT -->
@if(session('success'))
    <div class="alert-modern alert-success-modern">
        <i class="fas fa-circle-check"></i>
        {{ session('success') }}
    </div>
@endif
    <!-- TABLE -->
    @if($siswas->count() > 0)

        <div class="table-card">

            <div class="table-responsive">

                <table class="table-modern">

                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>NIS</th>
                            <th>NISN</th>
                            <th>Jenis Kelamin</th>
                            <th>Kelas</th>
                            <th width="140">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($siswas as $siswa)

                        @php
                            $rombel = $siswa->rombel ?? null;
                            $rombelNama = $rombel ? ($rombel->nama ?? null) : null;
                            $tingkatVal = $rombel && $rombel->kelas ? ($rombel->kelas->tingkat ?? null) : null;

                            $rombelWithoutTingkat = $rombelNama
                                ? preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama)
                                : null;

                            $rombelWithoutTingkat = $rombelWithoutTingkat
                                ? trim($rombelWithoutTingkat)
                                : null;

                            $formatted = $rombelWithoutTingkat
                                ? preg_replace('/(\D+)(\d+)/', '$1 $2', $rombelWithoutTingkat)
                                : null;
                                
                            // Gender icon and badge class
                            $gender = strtolower($siswa->jenis_kelamin);
                            $genderIcon = '';
                            $genderClass = '';
                            
                            if($gender == 'laki-laki' || $gender == 'laki laki' || $gender == 'laki'){
                                $genderIcon = '<i class="fas fa-mars"></i>';
                                $genderClass = 'badge-gender-male';
                            } elseif($gender == 'perempuan'){
                                $genderIcon = '<i class="fas fa-venus"></i>';
                                $genderClass = 'badge-gender-female';
                            } else {
                                $genderIcon = '<i class="fas fa-genderless"></i>';
                                $genderClass = 'badge-gender-other';
                            }
                        @endphp

                        <tr>

                            <td>

                                <div class="student-info">

                                    <div class="student-avatar">

                                        @if($siswa->foto)
                                            <img src="{{ asset('storage/' . $siswa->foto) }}"
                                                 alt="{{ $siswa->nama_lengkap }}">
                                        @else
                                            {{ strtoupper(substr($siswa->nama_lengkap,0,1)) }}
                                        @endif

                                    </div>

                                    <div>
                                        <a href="{{ route('tu.siswa.detail',$siswa->id) }}"
                                           class="student-name">
                                            {{ $siswa->nama_lengkap }}
                                        </a>

                                        <div class="student-sub">
                                            <i class="fas fa-id-card"></i> {{ $siswa->nis ?? '-' }}
                                        </div>
                                    </div>

                                </div>

                            </td>

                            <td>
                                <strong>{{ $siswa->nis }}</strong>
                            </td>

                            <td>{{ $siswa->nisn ?? '-' }}</td>

                            <td>
                                <span class="badge-modern {!! $genderClass !!}">
                                    {!! $genderIcon !!}
                                    {{ $siswa->jenis_kelamin }}
                                </span>
                            </td>

                            <td>

                                @if($rombel)
                                    <span class="badge-modern badge-class">
                                        <i class="fas fa-graduation-cap"></i>

                                        @if($tingkatVal)
                                            {{ $tingkatVal }} {{ $formatted }}
                                        @else
                                            {{ $formatted }}
                                        @endif
                                    </span>
                                @else
                                    <span class="badge-modern badge-class">
                                        <i class="fas fa-question"></i>
                                        Belum Ada Kelas
                                    </span>
                                @endif

                            </td>

                            <td>

                                <div class="action-group">

                                    <a href="{{ route('tu.siswa.detail',$siswa->id) }}"
                                       class="action-btn btn-detail"
                                       tooltip="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('tu.siswa.edit',$siswa->id) }}"
                                       class="action-btn btn-edit"
                                       tooltip="Edit Siswa">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <form action="{{ route('tu.siswa.destroy',$siswa->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus siswa {{ $siswa->nama_lengkap }}?')"
                                          style="display: inline-block;">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="action-btn btn-delete"
                                                tooltip="Hapus Siswa">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        <!-- PAGINATION -->
        <div class="pagination-wrapper">

            {{ $siswas->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-4') }}

        </div>

    @else

        <div class="glass-card">

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>

                <div class="empty-title">
                    Belum Ada Data Siswa
                </div>

                <div class="empty-description">
                    Tambahkan data siswa untuk mulai mengelola informasi sekolah.
                </div>

                <a href="{{ route('tu.siswa.create') }}"
                   class="btn-modern btn-outline-modern mt-4">
                    <i class="fas fa-plus"></i>
                    Tambah Siswa
                </a>

            </div>

        </div>

    @endif

</div>
<div class="modal fade" id="importModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('tu.siswa.import') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">
                        Import Data Siswa
                    </h5>
                </div>

                <div class="modal-body">

                    <input type="file"
                           name="file"
                           class="form-control"
                           accept=".xlsx,.xls"
                           required>

                    <small class="text-muted">
                        Upload file template yang sudah diisi.
                    </small>

                </div>

                <div class="modal-footer">
                    <button type="submit"
                            class="btn btn-success">
                        Import
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection