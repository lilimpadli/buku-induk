@extends('layouts.app')

@section('title', 'Edit Kurikulum TU Kepegawaian')

@section('content')

<style>
:root{
    --primary:#3B82F6;
    --secondary:#6366F1;
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
}

body{
    font-family:'Poppins',sans-serif;
    background:var(--bg);
}

/* HEADER */

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

.page-title{
    position:relative;
    z-index:2;
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
    position:relative;
    z-index:2;
    margin:0;
    opacity:.9;
    line-height:1.8;
}

/* CARD */

.form-card{
    background:var(--card);
    border-radius:var(--radius-xl);
    border:1px solid rgba(226,232,240,.7);
    box-shadow:var(--shadow-sm);
    overflow:hidden;
}

.form-card .card-body{
    padding:34px;
}

/* FORM */

.form-label{
    font-size:13px;
    font-weight:700;
    color:var(--text);
    margin-bottom:10px;
}

.form-control{
    border:2px solid var(--border);
    border-radius:18px;
    padding:14px 18px;
    font-size:14px;
    transition:.3s ease;
}

.form-control:focus{
    border-color:#3B82F6;
    box-shadow:0 0 0 5px rgba(59,130,246,.10);
}

/* BUTTON */

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
    transition:.3s ease;
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

.invalid-feedback{
    display:block;
    margin-top:6px;
    font-size:13px;
}

@media(max-width:768px){

    .page-header{
        padding:28px 24px;
        border-radius:24px;
    }

    .page-title{
        font-size:1.6rem;
    }

    .form-card .card-body{
        padding:24px 20px;
    }

    .action-wrapper{
        flex-direction:column;
    }

    .action-wrapper .btn-modern{
        width:100%;
    }
}
</style>

<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">

    <!-- HEADER -->
    <div class="page-header">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <h1 class="page-title">
                    <i class="fas fa-edit"></i>
                    Edit Kurikulum
                </h1>

                <p class="page-subtitle">
                    Perbarui data kurikulum dengan tampilan modern dan profesional.
                </p>

            </div>

            <a href="{{ route('super_admin.manajemen-kurikulum.index') }}"
               class="btn-modern btn-light-modern">

                <i class="fas fa-arrow-left"></i>
                Kembali

            </a>

        </div>

    </div>

    <!-- FORM -->
    <div class="row justify-content-center">

        <div class="col-lg-7 col-md-9">

            <div class="form-card">

                <div class="card-body">

                    <form action="{{ route('super_admin.manajemen-kurikulum.update', $kurikulum->id) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="mb-4">

                            <label for="nama_kurikulum" class="form-label">
                                Nama Kurikulum
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   id="nama_kurikulum"
                                   name="nama_kurikulum"
                                   class="form-control @error('nama_kurikulum') is-invalid @enderror"
                                   placeholder="Masukkan nama kurikulum"
                                   value="{{ old('nama_kurikulum', $kurikulum->nama_kurikulum) }}"
                                   required>

                            @error('nama_kurikulum')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <!-- BUTTON -->
                        <div class="d-flex justify-content-end gap-3 mt-4 action-wrapper">

                            <a href="{{ route('super_admin.manajemen-kurikulum.index') }}"
                               class="btn-modern btn-light-modern">

                                <i class="fas fa-times"></i>
                                Batal

                            </a>

                            <button type="submit"
                                    class="btn-modern btn-primary-modern">

                                <i class="fas fa-save"></i>
                                Update Kurikulum

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection