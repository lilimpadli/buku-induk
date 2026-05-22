@extends('layouts.app')

@section('title', 'Detail Jurusan - ' . $jurusan->nama)

@section('content')

<style>
:root{
    --primary-blue:#2F53FF;
    --secondary-blue:#7C3AED;
    --accent-cyan:#22D3EE;
    --light-bg:#F4F7FE;
    --text-dark:#1E293B;
    --text-muted:#64748B;

    --shadow-light:0 8px 24px rgba(15,23,42,0.06);
    --shadow-medium:0 16px 40px rgba(15,23,42,0.08);
    --shadow-hover:0 18px 45px rgba(47,83,255,0.14);

    --radius-xl:28px;
    --radius-lg:20px;
}

body{
    background:var(--light-bg);
    font-family:'Poppins',sans-serif;
}

/* ================= HEADER ================= */

.page-header{
    background:linear-gradient(135deg,var(--primary-blue) 0%,var(--secondary-blue) 100%);
    border-radius:32px;
    padding:36px;
    margin-bottom:28px;
    color:white;
    box-shadow:var(--shadow-medium);
    position:relative;
    overflow:hidden;
}

.page-header::before{
    content:'';
    position:absolute;
    top:-80px;
    right:-60px;
    width:220px;
    height:220px;
    background:rgba(255,255,255,.08);
    border-radius:50%;
}

.page-title{
    font-size:2.2rem;
    font-weight:800;
    margin-bottom:8px;
    position:relative;
    z-index:2;
}

.page-subtitle{
    margin:0;
    opacity:.9;
    max-width:650px;
    line-height:1.7;
    position:relative;
    z-index:2;
}

/* ================= CARD ================= */

.modern-card{
    background:white;
    border:none;
    border-radius:var(--radius-xl);
    box-shadow:var(--shadow-light);
    overflow:hidden;
    margin-bottom:26px;
    transition:.3s ease;
    animation:fadeInUp .4s ease;
}

.modern-card:hover{
    transform:translateY(-2px);
    box-shadow:var(--shadow-hover);
}

.modern-card .card-body{
    padding:32px;
}

.section-title{
    font-size:1.1rem;
    font-weight:700;
    color:var(--text-dark);
    margin-bottom:22px;
    padding-bottom:14px;
    border-bottom:2px solid #EEF2F7;
}

/* ================= INFO BOX ================= */

.info-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:20px;
}

.info-item{
    background:#F8FBFF;
    border-radius:20px;
    padding:20px;
    border:1px solid #EEF2F7;
    transition:.3s ease;
}

.info-item:hover{
    border-color:#DCE7FF;
    transform:translateY(-1px);
}

.info-label{
    font-size:.82rem;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.08em;
    color:var(--text-muted);
    margin-bottom:8px;
}

.info-value{
    font-size:1rem;
    font-weight:700;
    color:var(--text-dark);
}

/* ================= BADGE ================= */

.jurusan-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:9px 16px;
    border-radius:999px;
    color:#fff;
    font-size:.8rem;
    font-weight:700;
    box-shadow:0 10px 24px rgba(15,23,42,0.12);
    background:linear-gradient(135deg,#2563EB 0%,#38BDF8 100%);
}

.jurusan-badge[data-jurusan-code="RPL" i],
.jurusan-badge[data-jurusan-code="PPLG" i]{
    background:linear-gradient(135deg,#F59E0B 0%,#FCD34D 100%);
}

.jurusan-badge[data-jurusan-code="MP" i]{
    background:linear-gradient(135deg,#7F1D1D 0%,#991B1B 100%);
}

.jurusan-badge[data-jurusan-code="AK" i],
.jurusan-badge[data-jurusan-code="AKL" i]{
    background:linear-gradient(135deg,#F97316 0%,#FB923C 100%);
}

.jurusan-badge[data-jurusan-code="TJKT" i]{
    background:linear-gradient(135deg,#38BDF8 0%,#7DD3FC 100%);
}

.jurusan-badge[data-jurusan-code="TKRO" i],
.jurusan-badge[data-jurusan-code="TO" i]{
    background:linear-gradient(135deg,#1D4ED8 0%,#3B82F6 100%);
}

.jurusan-badge[data-jurusan-code="DPIB" i]{
    background:linear-gradient(135deg,#6B7280 0%,#9CA3AF 100%);
}

.jurusan-badge[data-jurusan-code="SP" i],
.jurusan-badge[data-jurusan-code="SK" i]{
    background:linear-gradient(135deg,#0F172A 0%,#374151 100%);
}

/* ================= STATS ================= */

.stats-card{
    background:linear-gradient(135deg,#2F53FF 0%,#7C3AED 100%);
    border-radius:24px;
    padding:24px;
    color:white;
    height:100%;
    position:relative;
    overflow:hidden;
}

.stats-card::before{
    content:'';
    position:absolute;
    right:-30px;
    bottom:-30px;
    width:120px;
    height:120px;
    background:rgba(255,255,255,.08);
    border-radius:50%;
}

.stats-label{
    font-size:.85rem;
    opacity:.85;
    margin-bottom:8px;
}

.stats-value{
    font-size:2.1rem;
    font-weight:800;
    line-height:1;
}

/* ================= TABLE ================= */

.table-wrapper{
    border-radius:22px;
    overflow:hidden;
    border:1px solid #EEF2F7;
}

.table-modern{
    margin-bottom:0;
}

.table-modern thead th{
    background:#F8FAFC;
    border:none;
    padding:20px;
    font-size:.78rem;
    text-transform:uppercase;
    letter-spacing:.08em;
    color:var(--text-muted);
    font-weight:700;
}

.table-modern tbody td{
    padding:18px 20px;
    vertical-align:middle;
    border-top:1px solid #EEF2F7;
    color:var(--text-dark);
    font-size:.95rem;
}

.table-modern tbody tr{
    transition:.3s ease;
}

.table-modern tbody tr:hover{
    background:#F8FBFF;
}

.kelas-pill{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 14px;
    border-radius:999px;
    background:#EEF4FF;
    color:#2F53FF;
    font-weight:700;
    font-size:.82rem;
}

/* ================= BUTTON ================= */

.action-buttons{
    display:flex;
    gap:14px;
    flex-wrap:wrap;
    margin-top:10px;
}

.btn-modern{
    border:none;
    border-radius:18px;
    padding:12px 22px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    font-weight:700;
    font-size:.92rem;
    transition:.3s ease;
    text-decoration:none;
}

.btn-modern:hover{
    transform:translateY(-2px);
}

.btn-secondary-modern{
    background:#E2E8F0;
    color:#334155;
}

.btn-secondary-modern:hover{
    background:#CBD5E1;
    color:#1E293B;
}

.btn-primary-modern{
    background:linear-gradient(135deg,var(--primary-blue) 0%,var(--secondary-blue) 100%);
    color:white;
    box-shadow:0 12px 24px rgba(47,83,255,.18);
}

.btn-primary-modern:hover{
    color:white;
}

/* ================= EMPTY ================= */

.empty-state{
    padding:40px 20px !important;
    text-align:center;
    color:var(--text-muted);
}

/* ================= ANIMATION ================= */

@keyframes fadeInUp{
    from{
        opacity:0;
        transform:translateY(16px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* ================= RESPONSIVE ================= */

@media(max-width:768px){

    .page-header{
        padding:26px;
        border-radius:24px;
    }

    .page-title{
        font-size:1.7rem;
    }

    .modern-card .card-body{
        padding:22px;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

    .table-modern thead{
        display:none;
    }

    .table-modern,
    .table-modern tbody,
    .table-modern tr,
    .table-modern td{
        display:block;
        width:100%;
    }

    .table-modern tr{
        padding:14px;
        border-bottom:1px solid #EEF2F7;
    }

    .table-modern td{
        border:none;
        display:flex;
        justify-content:space-between;
        gap:20px;
        padding:10px 0;
    }

    .table-modern td::before{
        font-weight:700;
        color:var(--text-muted);
        font-size:.75rem;
        text-transform:uppercase;
    }

    .table-modern td:nth-child(1)::before{
        content:'No';
    }

    .table-modern td:nth-child(2)::before{
        content:'Tingkat';
    }

    .table-modern td:nth-child(3)::before{
        content:'Nama Kelas';
    }

    .table-modern td:nth-child(4)::before{
        content:'Rombel';
    }

    .action-buttons{
        flex-direction:column;
    }

    .btn-modern{
        width:100%;
    }
}
</style>

<div class="container-fluid">

<!-- HEADER -->
<div class="page-header">
    <h1 class="page-title">
        Detail Jurusan
    </h1>

    <p class="page-subtitle">
        Informasi lengkap jurusan beserta daftar kelas yang tersedia di dalamnya.
    </p>
</div>

<!-- INFO -->
<div class="modern-card">
    <div class="card-body">

        <div class="row g-4 align-items-stretch">

            <div class="col-lg-8">
                <div class="section-title">
                    Informasi Jurusan
                </div>

                <div class="info-grid">

                    <div class="info-item">
                        <div class="info-label">ID Jurusan</div>
                        <div class="info-value">
                            #{{ $jurusan->id }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Kode Jurusan</div>

                        <div class="info-value">
                            <span class="jurusan-badge"
                                  data-jurusan-code="{{ $jurusan->kode ?? '' }}">
                                {{ $jurusan->kode }}
                            </span>
                        </div>
                    </div>

                    <div class="info-item" style="grid-column: span 2;">
                        <div class="info-label">Nama Jurusan</div>
                        <div class="info-value">
                            {{ $jurusan->nama }}
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="stats-card">
                    <div class="stats-label">
                        Total Kelas
                    </div>

                    <div class="stats-value">
                        {{ $jurusan->kelas->count() }}
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- TABLE -->
<div class="modern-card">
    <div class="card-body">

        <div class="section-title">
            Daftar Kelas
        </div>

        <div class="table-wrapper">

            <div class="table-responsive">
                <table class="table table-modern align-middle">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tingkat</th>
                            <th>Nama Kelas</th>
                            <th>Total Rombel</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($jurusan->kelas as $kelas)
                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <span class="kelas-pill">
                                        {{ $kelas->tingkat }}
                                    </span>
                                </td>

                                <td>
                                    {{ $kelas->tingkat }} {{ $jurusan->nama }}
                                </td>

                                <td>
                                    {{ $kelas->rombels->count() }} rombel
                                </td>

                            </tr>
                        @empty

                            <tr>
                                <td colspan="4" class="empty-state">
                                    Belum ada kelas di jurusan ini.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

    </div>
</div>

<!-- BUTTON -->
<div class="action-buttons">

    <a href="{{ route('super_admin.manajemen-jurusan.index') }}"
       class="btn-modern btn-secondary-modern">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>

    <a href="{{ route('super_admin.manajemen-jurusan.edit', $jurusan->id) }}"
       class="btn-modern btn-primary-modern">
        <i class="fas fa-edit"></i>
        Edit Jurusan
    </a>

</div>


</div>

@endsection
