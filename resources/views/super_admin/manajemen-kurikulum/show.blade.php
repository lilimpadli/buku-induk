@extends('layouts.app')

@section('title', 'Detail Kurikulum')

@section('content')

<style>
:root{
    --primary:#3B82F6;
    --primary-dark:#2563EB;
    --secondary:#6366F1;
    --success:#10B981;
    --warning:#F59E0B;
    --danger:#EF4444;

    --bg:#F4F7FE;
    --card:#FFFFFF;
    --border:#E2E8F0;

    --text:#0F172A;
    --muted:#64748B;

    --shadow-sm:0 4px 20px rgba(15,23,42,.05);
    --shadow-md:0 12px 32px rgba(15,23,42,.08);
    --shadow-hover:0 18px 40px rgba(59,130,246,.15);

    --radius-xl:30px;
    --radius-lg:22px;
    --radius-md:16px;
}

body{
    font-family:'Poppins',sans-serif;
    background:var(--bg);
}

/* ================= HEADER ================= */

.page-header{
    position:relative;
    overflow:hidden;
    background:linear-gradient(135deg,#2563EB 0%, #4F46E5 55%, #7C3AED 100%);
    border-radius:32px;
    padding:38px;
    margin-bottom:30px;
    color:white;
    box-shadow:var(--shadow-md);
}

.page-header::before{
    content:'';
    position:absolute;
    width:280px;
    height:280px;
    border-radius:50%;
    background:rgba(255,255,255,.08);
    top:-120px;
    right:-90px;
}

.page-header::after{
    content:'';
    position:absolute;
    width:220px;
    height:220px;
    border-radius:50%;
    background:rgba(255,255,255,.05);
    bottom:-120px;
    left:-80px;
}

.page-header > *{
    position:relative;
    z-index:2;
}

.page-title{
    display:flex;
    align-items:center;
    gap:16px;
    font-size:2rem;
    font-weight:800;
    margin-bottom:10px;
}

.page-title i{
    width:58px;
    height:58px;
    border-radius:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:rgba(255,255,255,.15);
    backdrop-filter:blur(10px);
    font-size:1.3rem;
}

.page-subtitle{
    margin:0;
    opacity:.9;
    line-height:1.8;
    max-width:700px;
}

/* ================= BUTTON ================= */

.header-actions{
    position:relative;
    z-index:10;
}

.btn-modern{
    position:relative;
    z-index:20;
    border:none;
    border-radius:18px;
    padding:13px 22px;
    font-size:14px;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    text-decoration:none;
    transition:all .3s ease;
    cursor:pointer;
}

.btn-modern:hover{
    transform:translateY(-2px);
}

.btn-edit{
    background:linear-gradient(135deg,#F59E0B,#F97316);
    color:white;
    box-shadow:var(--shadow-sm);
}

.btn-edit:hover{
    color:white;
    box-shadow:0 18px 40px rgba(249,115,22,.18);
}

.btn-back{
    background:#EEF2FF;
    color:#4338CA;
}

.btn-back:hover{
    background:#E0E7FF;
    color:#4338CA;
}

/* ================= CARD ================= */

.dashboard-card{
    background:var(--card);
    border-radius:var(--radius-xl);
    border:1px solid rgba(226,232,240,.7);
    box-shadow:var(--shadow-sm);
    overflow:hidden;
    height:100%;
}

.dashboard-card .card-body{
    padding:32px;
}

.section-title{
    font-size:18px;
    font-weight:700;
    color:var(--text);
    margin-bottom:28px;
}

/* ================= INFO ================= */

.info-list{
    display:flex;
    flex-direction:column;
    gap:18px;
}

.info-item{
    background:#F8FAFF;
    border:1px solid #EEF2FF;
    border-radius:20px;
    padding:22px;
}

.info-label{
    font-size:12px;
    font-weight:700;
    color:var(--muted);
    text-transform:uppercase;
    letter-spacing:.08em;
    margin-bottom:8px;
}

.info-value{
    font-size:16px;
    font-weight:700;
    color:var(--text);
    margin:0;
}

/* ================= STATS ================= */

.stats-card{
    text-align:center;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    min-height:100%;
}

.stats-icon{
    width:74px;
    height:74px;
    border-radius:24px;
    background:linear-gradient(135deg,#3B82F6,#6366F1);
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:1.7rem;
    margin-bottom:20px;
}

.stats-number{
    font-size:2.8rem;
    font-weight:800;
    color:var(--primary);
    line-height:1;
    margin-bottom:10px;
}

.stats-label{
    color:var(--muted);
    font-weight:600;
    margin:0;
}

/* ================= TABLE ================= */

.table-card{
    margin-top:30px;
}

.table-modern{
    margin:0;
    border-collapse:separate;
    border-spacing:0 14px;
}

.table-modern thead th{
    border:none;
    background:#EFF6FF;
    color:var(--muted);
    padding:18px 20px;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.08em;
}

.table-modern thead th:first-child{
    border-radius:18px 0 0 18px;
}

.table-modern thead th:last-child{
    border-radius:0 18px 18px 0;
}

.table-modern tbody td{
    border:none;
    background:white;
    padding:18px 20px;
    vertical-align:middle;
    box-shadow:0 8px 20px rgba(15,23,42,.04);
}

.table-modern tbody td:first-child{
    border-radius:18px 0 0 18px;
}

.table-modern tbody td:last-child{
    border-radius:0 18px 18px 0;
}

.table-modern tbody tr{
    transition:.3s ease;
}

.table-modern tbody tr:hover{
    transform:translateY(-2px);
}

.badge-modern{
    padding:10px 16px;
    border-radius:999px;
    background:rgba(59,130,246,.10);
    color:#2563EB;
    font-size:12px;
    font-weight:700;
}

/* ================= EMPTY ================= */

.empty-state{
    text-align:center;
    padding:70px 20px;
}

.empty-state i{
    width:90px;
    height:90px;
    border-radius:28px;
    background:rgba(59,130,246,.08);
    color:#3B82F6;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto auto 20px;
    font-size:2rem;
}

.empty-state h5{
    font-weight:700;
    color:var(--text);
    margin-bottom:10px;
}

.empty-state p{
    color:var(--muted);
    margin:0;
}

/* ================= RESPONSIVE ================= */

@media(max-width:768px){

    .page-header{
        padding:28px 24px;
        border-radius:26px;
    }

    .page-title{
        font-size:1.6rem;
    }

    .page-title i{
        width:52px;
        height:52px;
        border-radius:18px;
    }

    .header-actions{
        width:100%;
    }

    .header-actions .btn-modern{
        width:100%;
    }

    .dashboard-card .card-body{
        padding:22px;
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

    .table-modern tbody tr{
        margin-bottom:16px;
    }

    .table-modern tbody td{
        border-radius:0 !important;
        text-align:right;
        position:relative;
        padding:14px 18px;
    }

    .table-modern tbody td::before{
        content:attr(data-label);
        position:absolute;
        left:18px;
        font-weight:700;
        color:var(--text);
    }
}
</style>

<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">

    <!-- HEADER -->
    <div class="page-header">

        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

            <div>

                <h1 class="page-title">
                    <i class="fas fa-book-open"></i>
                    Detail Kurikulum
                </h1>

                <p class="page-subtitle">
                    Informasi lengkap kurikulum beserta daftar mata pelajaran yang terhubung.
                </p>

            </div>

            <div class="d-flex gap-2 flex-wrap header-actions">

                <a href="{{ route('super_admin.manajemen-kurikulum.edit', $kurikulum->id) }}"
                   class="btn-modern btn-edit">

                    <i class="fas fa-edit"></i>
                    Edit

                </a>

                <a href="{{ url()->previous() }}"
                   class="btn-modern btn-back">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

            </div>

        </div>

    </div>

    <!-- CONTENT -->
    <div class="row g-4">

        <!-- INFO -->
        <div class="col-lg-8">

            <div class="dashboard-card">

                <div class="card-body">

                    <h4 class="section-title">
                        Informasi Kurikulum
                    </h4>

                    <div class="info-list">

                        <div class="info-item">

                            <div class="info-label">
                                Nama Kurikulum
                            </div>

                            <h5 class="info-value">
                                {{ $kurikulum->nama_kurikulum }}
                            </h5>

                        </div>

                        <div class="info-item">

                            <div class="info-label">
                                Dibuat Pada
                            </div>

                            <h5 class="info-value">
                                {{ $kurikulum->created_at->format('d F Y H:i') }}
                            </h5>

                        </div>

                        <div class="info-item">

                            <div class="info-label">
                                Terakhir Diubah
                            </div>

                            <h5 class="info-value">
                                {{ $kurikulum->updated_at->format('d F Y H:i') }}
                            </h5>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- STATS -->
        <div class="col-lg-4">

            <div class="dashboard-card">

                <div class="card-body stats-card">

                    <div class="stats-icon">
                        <i class="fas fa-book"></i>
                    </div>

                    <div class="stats-number">
                        {{ $kurikulum->mataPelajarans->count() }}
                    </div>

                    <p class="stats-label">
                        Mata Pelajaran
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- TABLE MAPEL -->
    <div class="dashboard-card table-card">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">

                <div>

                    <h4 class="section-title mb-1">
                        Mata Pelajaran
                    </h4>

                    <p class="text-muted mb-0">
                        Daftar mata pelajaran yang ada dalam kurikulum ini.
                    </p>

                </div>

            </div>

            @if($kurikulum->mataPelajarans->count() > 0)

                <div class="table-responsive">

                    <table class="table table-modern align-middle">

                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kelompok</th>
                                <th>Urutan</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($kurikulum->mataPelajarans as $mapel)

                                <tr>

                                    <td data-label="Nama">
                                        <strong>{{ $mapel->nama }}</strong>
                                    </td>

                                    <td data-label="Kelompok">

                                        <span class="badge-modern">
                                            {{ $mapel->kelompok }}
                                        </span>

                                    </td>

                                    <td data-label="Urutan">
                                        {{ $mapel->urutan ?? '-' }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="empty-state">

                    <i class="fas fa-book-open"></i>

                    <h5>
                        Belum Ada Mata Pelajaran
                    </h5>

                    <p>
                        Kurikulum ini belum memiliki mata pelajaran yang ditambahkan.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection