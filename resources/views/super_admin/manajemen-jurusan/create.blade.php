@extends('layouts.app')

@section('title', 'Tambah Jurusan')

@section('content')

<style>
:root{
    --primary-blue:#2F53FF;
    --secondary-blue:#7C3AED;
    --light-bg:#F4F7FE;
    --soft-gray:#E9EEF7;
    --text-dark:#1E293B;
    --text-muted:#64748B;

    --shadow-light:0 10px 30px rgba(15,23,42,.06);
    --shadow-medium:0 20px 50px rgba(15,23,42,.08);
    --shadow-hover:0 18px 40px rgba(47,83,255,.16);

    --radius-xl:30px;
    --radius-lg:22px;
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
    color:white;
    margin-bottom:30px;
    box-shadow:var(--shadow-medium);
    position:relative;
    overflow:hidden;
}

.page-header::before{
    content:'';
    position:absolute;
    width:240px;
    height:240px;
    border-radius:50%;
    background:rgba(255,255,255,.08);
    top:-120px;
    right:-60px;
}

.page-title{
    font-size:2.1rem;
    font-weight:800;
    margin-bottom:10px;
    position:relative;
    z-index:2;
}

.page-subtitle{
    margin:0;
    opacity:.9;
    line-height:1.7;
    max-width:650px;
    position:relative;
    z-index:2;
}

/* ================= CARD ================= */

.dashboard-panel{
    background:white;
    border:none;
    border-radius:32px;
    overflow:hidden;
    box-shadow:var(--shadow-light);
    animation:fadeInUp .4s ease;
}

.dashboard-panel .card-header{
    padding:32px;
    border:none;
    background:linear-gradient(
        180deg,
        rgba(226,236,255,.75),
        rgba(255,255,255,.95)
    );
}

.dashboard-panel .card-body{
    padding:32px;
}

/* ================= FORM ================= */

.form-label{
    font-size:.95rem;
    font-weight:700;
    color:var(--text-dark);
    margin-bottom:.7rem;
}

.form-control-modern{
    width:100%;
    border-radius:18px;
    border:2px solid var(--soft-gray);
    background:#FBFDFF;
    min-height:58px;
    padding:0 18px;
    font-size:.95rem;
    transition:all .25s ease;
    color:var(--text-dark);
}

.form-control-modern::placeholder{
    color:#94A3B8;
}

.form-control-modern:focus{
    outline:none;
    border-color:rgba(47,83,255,.45);
    background:white;
    box-shadow:0 0 0 .18rem rgba(47,83,255,.12);
}

.form-control-modern.is-invalid{
    border-color:#EF4444;
    background:#FFF5F5;
}

.invalid-feedback{
    display:block;
    margin-top:.45rem;
    font-size:.85rem;
}

/* ================= ALERT ================= */

.alert-modern{
    border:none;
    border-radius:22px;
    padding:18px 20px;
    background:#FEF2F2;
    color:#991B1B;
    box-shadow:0 10px 24px rgba(239,68,68,.08);
}

.alert-modern ul{
    margin-bottom:0;
    padding-left:18px;
}

/* ================= INFO BOX ================= */

.info-box{
    background:#F8FBFF;
    border:1px solid #E0EAFF;
    border-radius:20px;
    padding:18px;
    margin-bottom:28px;
}

.info-box-title{
    font-size:.92rem;
    font-weight:700;
    color:var(--text-dark);
    margin-bottom:6px;
}

.info-box p{
    margin:0;
    color:var(--text-muted);
    font-size:.9rem;
    line-height:1.6;
}

/* ================= BUTTON ================= */

.btn-modern{
    border:none;
    border-radius:18px;
    padding:13px 22px;
    font-size:.92rem;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    transition:all .25s ease;
    text-decoration:none;
}

.btn-modern:hover{
    transform:translateY(-2px);
}

.btn-primary-modern{
    background:linear-gradient(135deg,#2F53FF 0%,#7C3AED 100%);
    color:white;
    box-shadow:0 14px 28px rgba(47,83,255,.18);
}

.btn-primary-modern:hover{
    color:white;
    box-shadow:var(--shadow-hover);
}

.btn-secondary-modern{
    background:#F8FAFC;
    color:#334155;
    border:1px solid rgba(148,163,184,.18);
}

.btn-secondary-modern:hover{
    background:#EEF2F7;
    color:#1E293B;
}

.button-group{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:10px;
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
        border-radius:26px;
    }

    .page-title{
        font-size:1.7rem;
    }

    .dashboard-panel .card-header,
    .dashboard-panel .card-body{
        padding:22px;
    }

    .button-group{
        flex-direction:column;
    }

    .btn-modern{
        width:100%;
    }
}
</style>

<div class="container-fluid py-4">

<!-- HEADER -->
<div class="page-header">

    <h1 class="page-title">
        Tambah Jurusan
    </h1>

    <p class="page-subtitle">
        Tambahkan jurusan baru untuk melengkapi struktur akademik sekolah dengan tampilan modern dan pengelolaan data yang lebih rapi.
    </p>

</div>

<!-- CARD -->
<div class="card dashboard-panel">

    <div class="card-header">

        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3">

            <div>
                <h4 class="fw-bold mb-2 text-dark">
                    Form Data Jurusan
                </h4>

                <p class="text-muted mb-0">
                    Pastikan kode dan nama jurusan sesuai standar sekolah.
                </p>
            </div>

            <div class="small text-muted">
                Semua field wajib diisi
            </div>

        </div>

    </div>

    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-modern mb-4">
                <strong>Periksa kembali data formulir.</strong>

                <ul class="mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="info-box">

            <div class="info-box-title">
                Tips Pengisian
            </div>

            <p>
                Gunakan kode jurusan singkat seperti RPL, TJKT, AKL, atau MP agar mudah dikenali di seluruh sistem sekolah.
            </p>

        </div>

        <form action="{{ route('super_admin.manajemen-jurusan.store') }}"
              method="POST"
              class="row g-4">

            @csrf

            <div class="col-12">

                <label for="kode" class="form-label">
                    Kode Jurusan
                </label>

                <input type="text"
                       id="kode"
                       name="kode"
                       class="form-control-modern @error('kode') is-invalid @enderror"
                       value="{{ old('kode') }}"
                       placeholder="Contoh: RPL"
                       required>

                @error('kode')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-12">

                <label for="nama" class="form-label">
                    Nama Jurusan
                </label>

                <input type="text"
                       id="nama"
                       name="nama"
                       class="form-control-modern @error('nama') is-invalid @enderror"
                       value="{{ old('nama') }}"
                       placeholder="Contoh: Rekayasa Perangkat Lunak"
                       required>

                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-12">

                <div class="button-group">

                    <a href="{{ route('super_admin.manajemen-jurusan.index') }}"
                       class="btn-modern btn-secondary-modern">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn-modern btn-primary-modern">
                        <i class="fas fa-save"></i>
                        Simpan Jurusan
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


</div>

@endsection
