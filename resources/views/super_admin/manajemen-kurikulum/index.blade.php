@extends('layouts.app')

@section('title', 'Daftar Kurikulum TU Kepegawaian')

@section('content')

<style>
:root{
    --primary:#3B82F6;
    --primary-dark:#2563EB;
    --secondary:#6366F1;
    --success:#10B981;
    --warning:#F59E0B;
    --danger:#EF4444;
    --info:#06B6D4;

    --bg:#F4F7FE;
    --card:#FFFFFF;
    --border:#E8EEF7;

    --text:#0F172A;
    --muted:#64748B;

    --shadow-sm:0 4px 20px rgba(15,23,42,.05);
    --shadow-md:0 12px 32px rgba(15,23,42,.08);
    --shadow-hover:0 16px 40px rgba(59,130,246,.15);

    --radius-xl:28px;
    --radius-lg:20px;
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
    background:linear-gradient(135deg,#3B82F6 0%, #6366F1 55%, #7C3AED 100%);
    border-radius:32px;
    padding:40px;
    margin-bottom:28px;
    color:white;
    box-shadow:var(--shadow-md);
}

.page-header::before{
    content:'';
    position:absolute;
    width:300px;
    height:300px;
    background:rgba(255,255,255,.08);
    border-radius:50%;
    top:-120px;
    right:-80px;
}

.page-header::after{
    content:'';
    position:absolute;
    width:220px;
    height:220px;
    background:rgba(255,255,255,.06);
    border-radius:50%;
    bottom:-120px;
    left:-80px;
}

.page-title{
    position:relative;
    z-index:2;
    font-size:2.2rem;
    font-weight:800;
    display:flex;
    align-items:center;
    gap:16px;
    margin-bottom:12px;
}

.page-title i{
    width:60px;
    height:60px;
    border-radius:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:rgba(255,255,255,.16);
    backdrop-filter:blur(10px);
    font-size:1.4rem;
}

.page-subtitle{
    position:relative;
    z-index:2;
    font-size:.98rem;
    line-height:1.8;
    opacity:.9;
    max-width:680px;
    margin:0;
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
    color:white;
}

.btn-modern:hover{
    transform:translateY(-2px);
    box-shadow:var(--shadow-hover);
    color:white;
}

.btn-primary-modern{
    background:linear-gradient(135deg,#2563EB,#7C3AED);
}

/* ================= CARD ================= */

.filter-card,
.data-table-card{
    background:var(--card);
    border-radius:28px;
    box-shadow:var(--shadow-sm);
    border:1px solid rgba(226,232,240,.7);
    overflow:hidden;
    margin-bottom:28px;
}

.filter-card .card-body,
.data-table-card .card-body{
    padding:28px;
}

/* ================= FORM ================= */

.form-label{
    font-size:13px;
    font-weight:700;
    color:var(--text);
    margin-bottom:10px;
}

.form-control{
    border:2px solid var(--border);
    border-radius:16px;
    padding:14px 18px;
    font-size:14px;
    box-shadow:none;
    transition:all .3s ease;
}

.form-control:focus{
    border-color:#3B82F6;
    box-shadow:0 0 0 5px rgba(59,130,246,.10);
}

.input-group{
    border:2px solid var(--border);
    border-radius:18px;
    overflow:hidden;
    background:white;
}

.input-group-text{
    background:white;
    border:none;
    color:var(--muted);
    padding:0 18px;
}

.input-group .form-control{
    border:none;
}

/* ================= ALERT ================= */

.alert{
    border:none;
    border-radius:18px;
    padding:16px 20px;
    font-weight:500;
    box-shadow:var(--shadow-sm);
}

.alert-success{
    background:#ECFDF5;
    color:#065F46;
}

.alert-danger{
    background:#FEF2F2;
    color:#991B1B;
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
    padding:22px 20px;
    vertical-align:middle;
    box-shadow:0 8px 20px rgba(15,23,42,.04);
}

.table-modern tbody td:first-child{
    border-radius:20px 0 0 20px;
}

.table-modern tbody td:last-child{
    border-radius:0 20px 20px 0;
}

.kurikulum-name{
    font-weight:700;
    color:var(--text);
    font-size:15px;
}

.badge-modern{
    background:rgba(59,130,246,.10);
    color:#2563EB;
    padding:10px 16px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.date-text{
    color:var(--muted);
    font-weight:500;
}

/* ================= ACTION ================= */

.action-buttons{
    display:flex;
    gap:10px;
    justify-content:center;
}

.action-btn{
    width:44px;
    height:44px;
    border:none;
    border-radius:16px;
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:.3s ease;
    text-decoration:none;
}

.action-btn:hover{
    transform:translateY(-2px);
    box-shadow:var(--shadow-hover);
    color:white;
}

.action-btn.view{
    background:linear-gradient(135deg,#06B6D4,#3B82F6);
}

.action-btn.edit{
    background:linear-gradient(135deg,#F59E0B,#F97316);
}

.action-btn.delete{
    background:linear-gradient(135deg,#EF4444,#DC2626);
}

/* ================= EMPTY ================= */

.empty-state{
    padding:90px 20px;
    text-align:center;
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

/* ================= PAGINATION ================= */

.pagination-container{
    padding-top:18px;
}

.pagination{
    justify-content:center;
}

.page-link{
    border:none;
    border-radius:14px !important;
    margin:0 4px;
    color:var(--text);
    min-width:42px;
    height:42px;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:.3s ease;
}

.page-link:hover{
    background:rgba(59,130,246,.08);
    color:#2563EB;
}

.page-item.active .page-link{
    background:linear-gradient(135deg,#2563EB,#7C3AED);
    color:white;
}

/* ================= MOBILE ================= */

@media(max-width:768px){

    .page-header{
        padding:28px 24px;
        border-radius:26px;
    }

    .page-title{
        font-size:1.7rem;
    }

    .page-title i{
        width:52px;
        height:52px;
        border-radius:16px;
    }

    .filter-card .card-body,
    .data-table-card .card-body{
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

    .action-buttons{
        justify-content:flex-start;
    }
}
</style>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h1 class="page-title">
                    <i class="fas fa-book"></i>
                    Daftar Kurikulum TU Kepegawaian
                </h1>

                <p class="page-subtitle">
                    Kelola kurikulum dengan tampilan dashboard yang modern, rapi, dan profesional.
                </p>
            </div>

            <div>
                <a href="{{ route('super_admin.manajemen-kurikulum.create') }}"
                   class="btn-modern btn-primary-modern">
                    <i class="fas fa-plus"></i>
                    Tambah Kurikulum
                </a>
            </div>

        </div>
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- FILTER -->
    <div class="filter-card">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('super_admin.manajemen-kurikulum.index') }}"
                  class="row g-4 align-items-end">

                <div class="col-lg-8 col-md-7">

                    <label class="form-label">
                        Cari Kurikulum
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>

                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Cari nama kurikulum..."
                               value="{{ $search ?? '' }}">
                    </div>

                </div>

                <div class="col-lg-4 col-md-5">

                    <button type="submit"
                            class="btn-modern btn-primary-modern w-100">

                        <i class="fas fa-search"></i>
                        Cari Data

                    </button>

                </div>

            </form>

        </div>
    </div>

    <!-- TABLE -->
    <div class="data-table-card">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-modern align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kurikulum</th>
                            <th>Jumlah Mata Pelajaran</th>
                            <th>Tanggal Dibuat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($kurikulum as $k)

                            <tr>

                                <td data-label="#">
                                    {{ $loop->iteration + ($kurikulum->currentPage() - 1) * $kurikulum->perPage() }}
                                </td>

                                <td data-label="Nama">
                                    <div class="kurikulum-name">
                                        {{ $k->nama_kurikulum }}
                                    </div>
                                </td>

                                <td data-label="Mapel">
                                    <span class="badge-modern">
                                        <i class="fas fa-book-open"></i>
                                        {{ $k->mata_pelajarans_count }} Mata Pelajaran
                                    </span>
                                </td>

                                <td data-label="Tanggal">
                                    <span class="date-text">
                                        {{ $k->created_at->format('d M Y') }}
                                    </span>
                                </td>

                                <td data-label="Aksi">

                                    <div class="action-buttons">

                                        <a href="{{ route('super_admin.manajemen-kurikulum.show', $k->id) }}"
                                           class="action-btn view"
                                           title="Detail">

                                            <i class="fas fa-eye"></i>

                                        </a>

                                        <a href="{{ route('super_admin.manajemen-kurikulum.edit', $k->id) }}"
                                           class="action-btn edit"
                                           title="Edit">

                                            <i class="fas fa-pen"></i>

                                        </a>

                                        <form method="POST"
                                              action="{{ route('super_admin.manajemen-kurikulum.destroy', $k->id) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus kurikulum ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="action-btn delete"
                                                    title="Hapus">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5">

                                    <div class="empty-state">

                                        <i class="fas fa-book-open"></i>

                                        <h5>
                                            Belum Ada Kurikulum
                                        </h5>

                                        <p>
                                            Tambahkan data kurikulum baru untuk mulai mengelola sistem akademik.
                                        </p>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if($kurikulum->hasPages())

                <div class="pagination-container">
                    {{ $kurikulum->links('pagination::bootstrap-4') }}
                </div>

            @endif

        </div>

    </div>

</div>

@endsection