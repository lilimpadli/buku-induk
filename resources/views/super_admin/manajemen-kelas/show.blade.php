@extends('layouts.app')

@section('title', 'Detail Rombel - ' . $rombel->nama)

@section('content')

<style>
:root{
    --primary:#3B82F6;
    --primary-dark:#2563EB;
    --secondary:#6366F1;
    --success:#10B981;
    --danger:#EF4444;
    --info:#06B6D4;

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
    z-index:1;
}

.page-header *{
    position:relative;
    z-index:2;
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
    pointer-events:none;
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
    pointer-events:none;
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
    max-width:680px;
    opacity:.9;
    line-height:1.8;
}

/* ================= BUTTON ================= */

.btn-modern{
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

.btn-primary-modern{
    background:linear-gradient(135deg,#2563EB,#7C3AED);
    color:white;
    box-shadow:var(--shadow-sm);
}

.btn-primary-modern:hover{
    color:white;
    box-shadow:var(--shadow-hover);
}

.btn-light-modern{
    background:#EEF2FF;
    color:#4338CA;
}

.btn-light-modern:hover{
    background:#E0E7FF;
    color:#4338CA;
}

/* ================= CARD ================= */

.info-card,
.student-card{
    background:var(--card);
    border-radius:var(--radius-xl);
    border:1px solid rgba(226,232,240,.7);
    box-shadow:var(--shadow-sm);
    overflow:hidden;
}

.info-card{
    margin-bottom:28px;
}

.info-card .card-body,
.student-card .card-body{
    padding:30px;
}

/* ================= INFO ITEM ================= */

.info-item{
    background:#F8FAFF;
    border:1px solid #EEF2FF;
    border-radius:22px;
    padding:24px;
    height:100%;
    transition:.3s ease;
}

.info-item:hover{
    transform:translateY(-3px);
    box-shadow:var(--shadow-hover);
}

.info-icon{
    width:52px;
    height:52px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:16px;
    color:white;
    font-size:1.1rem;
}

.info-icon.level{
    background:linear-gradient(135deg,#3B82F6,#6366F1);
}

.info-icon.major{
    background:linear-gradient(135deg,#8B5CF6,#7C3AED);
}

.info-icon.teacher{
    background:linear-gradient(135deg,#10B981,#14B8A6);
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
    font-size:18px;
    font-weight:700;
    color:var(--text);
    margin:0;
}

/* ================= TABLE ================= */

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

.table-modern tbody tr{
    transition:.3s ease;
}

.table-modern tbody tr:hover{
    transform:translateY(-2px);
}

.table-modern tbody td{
    border:none;
    background:white;
    padding:20px;
    vertical-align:middle;
    box-shadow:0 8px 20px rgba(15,23,42,.04);
}

.table-modern tbody td:first-child{
    border-radius:20px 0 0 20px;
}

.table-modern tbody td:last-child{
    border-radius:0 20px 20px 0;
}

/* ================= STUDENT ================= */

.student-wrapper{
    display:flex;
    align-items:center;
    gap:14px;
}

.student-avatar{
    width:46px;
    height:46px;
    border-radius:16px;
    object-fit:cover;
    flex-shrink:0;
}

.student-initial{
    width:46px;
    height:46px;
    border-radius:16px;
    background:linear-gradient(135deg,#2563EB,#7C3AED);
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-weight:700;
    font-size:15px;
    flex-shrink:0;
}

.student-name{
    font-weight:700;
    color:var(--text);
}

.badge-gender{
    padding:10px 16px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.badge-male{
    background:rgba(59,130,246,.12);
    color:#2563EB;
}

.badge-female{
    background:rgba(239,68,68,.12);
    color:#DC2626;
}

/* ================= EMPTY ================= */

.empty-state{
    text-align:center;
    padding:80px 20px !important;
}

.empty-state i{
    width:90px;
    height:90px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto auto 20px;
    border-radius:30px;
    background:rgba(59,130,246,.08);
    color:#3B82F6;
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

    .info-card .card-body,
    .student-card .card-body{
        padding:20px;
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
        padding:14px 18px;
        position:relative;
    }

    .table-modern tbody td::before{
        content:attr(data-label);
        position:absolute;
        left:18px;
        font-weight:700;
        color:var(--text);
    }

    .student-wrapper{
        justify-content:flex-end;
    }

    .header-action{
        width:100%;
    }

    .header-action .btn-modern{
        width:100%;
    }
}
</style>

<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">

<div class="page-header">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

        <div>

            <h1 class="page-title">
                <i class="fas fa-school"></i>
                Detail Rombel
            </h1>

            <p class="page-subtitle">
                Informasi lengkap rombel, wali kelas, jurusan, dan daftar siswa.
            </p>

        </div>

        <div class="d-flex gap-2 flex-wrap header-action">

            <a href="{{ route('super_admin.manajemen-kelas.export', $rombel->id) }}"
               class="btn-modern btn-primary-modern">

                <i class="fas fa-file-export"></i>
                Export Rombel

            </a>

            <a href="{{ url()->previous() }}"
               class="btn-modern btn-light-modern">

                <i class="fas fa-arrow-left"></i>
                Kembali

            </a>

        </div>

    </div>

</div>

<!-- INFO -->
<div class="info-card">

    <div class="card-body">

        <div class="row g-4">

            <div class="col-lg-4 col-md-6">

                <div class="info-item">

                    <div class="info-icon level">
                        <i class="fas fa-layer-group"></i>
                    </div>

                    <div class="info-label">Tingkat</div>

                    <h5 class="info-value">
                        {{ $rombel->kelas->tingkat ?? '-' }}
                    </h5>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="info-item">

                    <div class="info-icon major">
                        <i class="fas fa-graduation-cap"></i>
                    </div>

                    <div class="info-label">Jurusan</div>

                    <h5 class="info-value">
                        {{ $rombel->kelas->jurusan->nama ?? '-' }}
                    </h5>

                </div>

            </div>

            <div class="col-lg-4 col-md-12">

                <div class="info-item">

                    <div class="info-icon teacher">
                        <i class="fas fa-user-tie"></i>
                    </div>

                    <div class="info-label">Wali Kelas</div>

                    <h5 class="info-value">
                        {{ $rombel->guru->nama ?? '-' }}
                    </h5>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- SISWA -->
<div class="student-card">

    <div class="card-body">

        <div class="mb-4">

            <h4 class="fw-bold mb-1">
                Daftar Siswa
            </h4>

            <p class="text-muted mb-0">
                Total {{ $rombel->siswa->count() }} siswa dalam rombel ini.
            </p>

        </div>

        <div class="table-responsive">

            <table class="table table-modern align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($rombel->siswa as $siswa)

                    <tr>

                        <td data-label="No">
                            {{ $loop->iteration }}
                        </td>

                        <td data-label="Nama">

                            <div class="student-wrapper">

                                @if($siswa->foto)

                                <img src="{{ asset('storage/' . $siswa->foto) }}"
                                     alt="{{ $siswa->nama_lengkap }}"
                                     class="student-avatar">

                                @else

                                <div class="student-initial">
                                    {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                </div>

                                @endif

                                <div class="student-name">
                                    {{ $siswa->nama_lengkap }}
                                </div>

                            </div>

                        </td>

                        <td data-label="NIS">
                            {{ $siswa->nis }}
                        </td>

                        <td data-label="Jenis Kelamin">

                            <span class="badge-gender {{ $siswa->jenis_kelamin == 'L' ? 'badge-male' : 'badge-female' }}">

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

                                <h5>Belum Ada Siswa</h5>

                                <p>
                                    Belum ada data siswa yang dimasukkan ke rombel ini.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

@endsection