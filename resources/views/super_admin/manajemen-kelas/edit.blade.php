@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')

<style>
:root{
    --primary:#3B82F6;
    --primary-dark:#2563EB;
    --secondary:#6366F1;

    --success:#10B981;
    --danger:#EF4444;
    --warning:#F59E0B;

    --bg:#F4F7FE;
    --card:#FFFFFF;
    --border:#E2E8F0;

    --text:#0F172A;
    --muted:#64748B;

    --shadow-sm:0 4px 20px rgba(15,23,42,.05);
    --shadow-md:0 12px 32px rgba(15,23,42,.08);
    --shadow-hover:0 18px 40px rgba(59,130,246,.14);

    --radius-xl:30px;
    --radius-lg:22px;
    --radius-md:16px;
}

body{
    background:var(--bg);
    font-family:'Poppins',sans-serif;
}

/* ================= HEADER ================= */

.page-header{
    position:relative;
    overflow:hidden;
    background:linear-gradient(135deg,#2563EB 0%,#4F46E5 55%,#7C3AED 100%);
    border-radius:32px;
    padding:38px;
    margin-bottom:28px;
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
    max-width:700px;
    opacity:.92;
    line-height:1.8;
    font-size:.96rem;
}

/* ================= CARD ================= */

.form-card{
    background:var(--card);
    border-radius:var(--radius-xl);
    border:1px solid rgba(226,232,240,.7);
    box-shadow:var(--shadow-sm);
    overflow:hidden;
    transition:.3s ease;
}

.form-card:hover{
    box-shadow:var(--shadow-hover);
}

.form-card .card-body{
    padding:34px;
}

/* ================= SECTION ================= */

.section-title{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:24px;
}

.section-title .icon{
    width:46px;
    height:46px;
    border-radius:16px;
    background:rgba(59,130,246,.1);
    color:var(--primary);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
}

.section-title h5{
    margin:0;
    font-size:1rem;
    font-weight:700;
    color:var(--text);
}

.section-title p{
    margin:2px 0 0;
    color:var(--muted);
    font-size:.88rem;
}

/* ================= FORM ================= */

.form-label{
    font-size:13px;
    font-weight:700;
    color:var(--text);
    margin-bottom:10px;
}

.form-control,
.form-select{
    border:2px solid var(--border);
    border-radius:18px;
    padding:13px 16px;
    font-size:14px;
    box-shadow:none;
    transition:all .3s ease;
    background:white;
}

.form-control:focus,
.form-select:focus{
    border-color:var(--primary);
    box-shadow:0 0 0 5px rgba(59,130,246,.10);
}

.form-text{
    color:var(--muted);
    font-size:12px;
    margin-top:8px;
}

/* ================= ALERT ================= */

.alert{
    border:none;
    border-radius:18px;
    padding:16px 18px;
    box-shadow:var(--shadow-sm);
}

.alert-danger{
    background:#FEF2F2;
    color:#991B1B;
}

.alert-success{
    background:#ECFDF5;
    color:#065F46;
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

/* ================= RESPONSIVE ================= */

@media(max-width:768px){

    .page-header{
        padding:28px 22px;
        border-radius:26px;
    }

    .page-title{
        font-size:1.6rem;
    }

    .page-title i{
        width:50px;
        height:50px;
        border-radius:16px;
        font-size:1.1rem;
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
                <i class="fas fa-pen"></i>
                Edit Rombel
            </h1>

            <p class="page-subtitle">
                Perbarui informasi rombel dengan tampilan dashboard modern, clean, dan profesional.
            </p>

        </div>

        <a href="{{ route('super_admin.manajemen-kelas.index') }}"
           class="btn-modern btn-light-modern">

            <i class="fas fa-arrow-left"></i>
            Kembali

        </a>

    </div>

</div>

<!-- CARD -->
<div class="row justify-content-center">

    <div class="col-xl-8 col-lg-10">

        <div class="form-card">

            <div class="card-body">

                <!-- ALERT -->
                @if($errors->any())
                    <div class="alert alert-danger mb-4">

                        <div class="fw-semibold mb-2">
                            <i class="fas fa-circle-exclamation me-2"></i>
                            Terjadi Kesalahan
                        </div>

                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>

                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success mb-4">
                        <i class="fas fa-circle-check me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- TITLE -->
                <div class="section-title">

                    <div class="icon">
                        <i class="fas fa-school"></i>
                    </div>

                    <div>
                        <h5>Form Edit Rombel</h5>
                        <p>Lengkapi data rombel dengan benar.</p>
                    </div>

                </div>

                <!-- FORM -->
                <form action="{{ route('super_admin.manajemen-kelas.update', $rombel->id) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <!-- TINGKAT -->
                        <div class="col-md-6">

                            <label for="tingkat" class="form-label">
                                Tingkat
                                <span class="text-danger">*</span>
                            </label>

                            <select name="tingkat"
                                    id="tingkat"
                                    class="form-select"
                                    required>

                                <option value="">Pilih Tingkat</option>

                                <option value="10"
                                    {{ $rombel->kelas->tingkat == '10' ? 'selected' : '' }}>
                                    Kelas 10
                                </option>

                                <option value="11"
                                    {{ $rombel->kelas->tingkat == '11' ? 'selected' : '' }}>
                                    Kelas 11
                                </option>

                                <option value="12"
                                    {{ $rombel->kelas->tingkat == '12' ? 'selected' : '' }}>
                                    Kelas 12
                                </option>

                            </select>

                        </div>

                        <!-- JURUSAN -->
                        <div class="col-md-6">

                            <label for="jurusan_id" class="form-label">
                                Konsentrasi Keahlian
                                <span class="text-danger">*</span>
                            </label>

                            <select name="jurusan_id"
                                    id="jurusan_id"
                                    class="form-select"
                                    required>

                                <option value="">
                                    Pilih Konsentrasi Keahlian
                                </option>

                                @foreach($jurusans as $j)

                                    <option value="{{ $j->id }}"
                                        {{ $j->id == $rombel->kelas->jurusan_id ? 'selected' : '' }}>

                                        {{ $j->nama }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <!-- NAMA ROMBEL -->
                        <div class="col-md-6">

                            <label for="nama" class="form-label">
                                Nama Rombel
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="nama"
                                   id="nama"
                                   class="form-control"
                                   placeholder="Contoh: XI RPL 1"
                                   value="{{ old('nama', $rombel->nama) }}"
                                   required>

                            <div class="form-text">
                                Contoh format: X RPL 1, XI TKJ 2, XII AKL 1
                            </div>

                        </div>

                        <!-- WALI KELAS -->
                        <div class="col-md-6">

                            <label for="guru_id" class="form-label">
                                Wali Kelas
                            </label>

                            <select name="guru_id"
                                    id="guru_id"
                                    class="form-select">

                                <option value="">
                                    -- Pilih Wali Kelas --
                                </option>

                                @foreach($gurus as $guru)

                                    <option value="{{ $guru->id }}"
                                        {{ $guru->id == $rombel->guru_id ? 'selected' : '' }}>

                                        {{ $guru->nama }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <!-- ACTION -->
                    <div class="d-flex justify-content-end gap-3 mt-5 action-wrapper">

                        <a href="{{ route('super_admin.manajemen-kelas.index') }}"
                           class="btn-modern btn-light-modern">

                            <i class="fas fa-xmark"></i>
                            Batal

                        </a>

                        <button type="submit"
                                class="btn-modern btn-primary-modern">

                            <i class="fas fa-floppy-disk"></i>
                            Simpan Perubahan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


</div>

@endsection
