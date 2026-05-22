@extends('layouts.app')

@section('title', 'Edit Akun Siswa')

@section('content')

<style>
:root{
    --primary:#3B82F6;
    --primary-dark:#2563EB;
    --secondary:#6366F1;
    --success:#10B981;
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

/* ================= CARD ================= */

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

/* ================= ALERT ================= */

.alert-modern{
    border:none;
    border-radius:20px;
    padding:18px 20px;
    margin-bottom:24px;
    box-shadow:var(--shadow-sm);
}

.alert-danger-modern{
    background:rgba(239,68,68,.08);
    color:#B91C1C;
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
    position:relative;
    z-index:5;
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
                    <i class="fas fa-user-edit"></i>
                    Edit Akun Siswa
                </h1>

                <p class="page-subtitle">
                    Perbarui data akun siswa dengan tampilan dashboard modern dan profesional.
                </p>

            </div>

            <!-- BUTTON KEMBALI FIX -->
            <div style="position:relative; z-index:20;">
                <a href="{{ route('super_admin.manajemen-siswa.index') }}"
                   class="btn-modern btn-light-modern">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>
            </div>

        </div>

    </div>

    <!-- ERROR -->
    @if ($errors->any())

        <div class="alert-modern alert-danger-modern">

            <div class="fw-bold mb-2">
                <i class="fas fa-exclamation-circle me-2"></i>
                Terjadi Kesalahan
            </div>

            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    <!-- FORM -->
    <div class="row justify-content-center">

        <div class="col-xl-10">

            <div class="form-card">

                <div class="card-body">

                    <form method="POST"
                          action="{{ route('super_admin.manajemen-siswa.update', $siswa->id) }}">

                        @csrf
                        @method('PUT')

                        @include('super_admin.manajemen-siswa._form')

                        <!-- BUTTON -->
                        <div class="d-flex justify-content-end gap-3 mt-4 action-wrapper">

                            <a href="{{ route('super_admin.manajemen-siswa.index') }}"
                               class="btn-modern btn-light-modern">

                                <i class="fas fa-times"></i>
                                Batal

                            </a>

                            <button type="submit"
                                    class="btn-modern btn-primary-modern">

                                <i class="fas fa-save"></i>
                                Simpan Perubahan

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const jurusanSelect = document.querySelector('select[name="jurusan_id"]');
    const kelasSelect = document.getElementById('kelasSelect');
    const rombelSelect = document.getElementById('rombelSelect');

    function filterKelas() {

        const jurusanId = jurusanSelect ? jurusanSelect.value : '';

        Array.from(kelasSelect.options).forEach(opt => {

            if (!opt.value) return;

            const match = !jurusanId || opt.dataset.jurusan == jurusanId;

            opt.style.display = match ? '' : 'none';

        });

        if (
            kelasSelect.selectedOptions.length &&
            kelasSelect.selectedOptions[0].style.display === 'none'
        ) {
            kelasSelect.value = '';
        }

        filterRombel();
    }

    function filterRombel() {

        const kelasId = kelasSelect ? kelasSelect.value : '';

        Array.from(rombelSelect.options).forEach(opt => {

            if (!opt.value) return;

            const dataKelas = opt.dataset.kelas || '';

            const match = !kelasId || dataKelas == kelasId;

            opt.style.display = match ? '' : 'none';

        });

        if (
            rombelSelect.selectedOptions.length &&
            rombelSelect.selectedOptions[0].style.display === 'none'
        ) {
            rombelSelect.value = '';
        }
    }

    if (jurusanSelect) {
        jurusanSelect.addEventListener('change', filterKelas);
    }

    if (kelasSelect) {
        kelasSelect.addEventListener('change', filterRombel);
    }

    filterKelas();
});
</script>

@endsection