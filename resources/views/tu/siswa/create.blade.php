@extends('layouts.app')

@section('title', 'Tambah Akun Siswa')

@section('content')

<style>
:root{
    --primary:#4F46E5;
    --primary-light:#6366F1;
    --secondary:#7C3AED;

    --success:#10B981;
    --warning:#F59E0B;
    --danger:#EF4444;

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

/* ================= BUTTON ================= */

.btn-modern{
    border:none;
    border-radius:16px;
    padding:13px 22px;
    font-weight:700;
    transition:var(--transition);
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
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

.btn-save{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    color:white;
    box-shadow:0 10px 24px rgba(79,70,229,.24);
}

.btn-save:hover{
    box-shadow:0 14px 28px rgba(79,70,229,.35);
}

.btn-cancel{
    background:#fff;
    color:var(--text);
    border:1px solid #dbe3ff;
}

.btn-cancel:hover{
    background:#f8faff;
}

/* ================= CARD ================= */

.form-card{
    background:rgba(255,255,255,.92);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,.8);
    border-radius:28px;
    overflow:hidden;
    box-shadow:var(--shadow-md);
}

.form-header{
    padding:28px 30px;
    border-bottom:1px solid #eef2ff;
    background:linear-gradient(135deg,rgba(79,70,229,.05),rgba(124,58,237,.05));
}

.form-title{
    margin:0;
    font-size:22px;
    font-weight:800;
    color:var(--text);
    display:flex;
    align-items:center;
    gap:12px;
}

.form-body{
    padding:32px;
}

/* ================= ALERT ================= */

.alert-modern{
    border:none;
    border-radius:20px;
    padding:18px 22px;
    margin-bottom:24px;
    display:flex;
    align-items:flex-start;
    gap:14px;
    box-shadow:var(--shadow-sm);
}

.alert-danger-modern{
    background:#FEF2F2;
    color:#DC2626;
}

.alert-danger-modern ul{
    margin:0;
    padding-left:18px;
}

/* ================= FORM ================= */

.form-section{
    margin-bottom:34px;
}

.section-title{
    font-size:17px;
    font-weight:800;
    color:var(--text);
    margin-bottom:20px;
    display:flex;
    align-items:center;
    gap:10px;
    padding-bottom:12px;
    border-bottom:1px solid #eef2ff;
}

.form-label{
    font-weight:700;
    color:var(--text);
    margin-bottom:10px;
    display:block;
    font-size:14px;
}

.required{
    color:var(--danger);
}

.form-control-modern,
.form-select-modern{
    width:100%;
    border:1.5px solid #dbe3ff;
    background:#f9fbff;
    border-radius:16px;
    padding:14px 16px;
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

.form-control-modern::placeholder{
    color:#9CA3AF;
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:22px;
}

.form-actions{
    margin-top:10px;
    padding-top:28px;
    border-top:1px solid #eef2ff;
    display:flex;
    justify-content:flex-end;
    gap:14px;
    flex-wrap:wrap;
}

/* ================= TOAST ================= */

.toast-modern{
    position:fixed;
    top:24px;
    right:24px;
    z-index:9999;
    background:white;
    border-radius:18px;
    padding:16px 18px;
    box-shadow:var(--shadow-lg);
    display:flex;
    align-items:center;
    gap:12px;
    min-width:320px;
    animation:slideIn .3s ease;
}

.toast-error{
    border-left:5px solid var(--danger);
}

.toast-success{
    border-left:5px solid var(--success);
}

@keyframes slideIn{
    from{
        opacity:0;
        transform:translateX(30px);
    }
    to{
        opacity:1;
        transform:translateX(0);
    }
}

@keyframes slideOut{
    from{
        opacity:1;
        transform:translateX(0);
    }
    to{
        opacity:0;
        transform:translateX(30px);
    }
}

/* ================= LOADING ================= */

.spinner{
    width:16px;
    height:16px;
    border:2px solid rgba(255,255,255,.35);
    border-top-color:white;
    border-radius:50%;
    animation:spin .7s linear infinite;
}

@keyframes spin{
    to{
        transform:rotate(360deg);
    }
}

/* ================= RESPONSIVE ================= */

@media(max-width:768px){

    .page-header{
        padding:26px;
    }

    .page-title{
        font-size:28px;
    }

    .form-body{
        padding:22px;
    }

    .form-grid{
        grid-template-columns:1fr;
    }

    .form-actions{
        flex-direction:column-reverse;
    }

    .btn-modern{
        width:100%;
    }

    .toast-modern{
        left:20px;
        right:20px;
        min-width:auto;
    }
}
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    <!-- HEADER -->
    <div class="page-header">

        <div class="header-content">

            <div>
                <h1 class="page-title">Tambah Data Siswa</h1>

                <div class="page-subtitle">
                   Lengkapi data pribadi dan informasi siswa
                </div>
            </div>

            <a href="{{ route('tu.siswa.index') }}" class="btn-modern btn-back">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>

        </div>

    </div>

    <!-- ERROR -->
    @if ($errors->any())
        <div class="alert-modern alert-danger-modern">

            <i class="fas fa-circle-exclamation mt-1"></i>

            <div>
                <div class="fw-bold mb-1">
                    Terdapat kesalahan pada form
                </div>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    @endif

    <!-- FORM -->
    <div class="form-card">

        <div class="form-header">
            <h4 class="form-title">
                <i class="fas fa-user-plus"></i>
                Form Tambah Siswa
            </h4>
        </div>

        <div class="form-body">

            <form method="POST"
                  action="{{ route('tu.siswa.store') }}"
                  id="createForm">

                @csrf

                @include('tu.siswa._form')

                <!-- ACTION -->
                <div class="form-actions">

                    <a href="{{ route('tu.siswa.index') }}"
                       class="btn-modern btn-cancel">
                        <i class="fas fa-xmark"></i>
                        Batal
                    </a>

                    <button type="submit"
                            class="btn-modern btn-save"
                            id="submitBtn">

                        <i class="fas fa-floppy-disk"></i>
                        Simpan Data

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const form = document.getElementById('createForm');
    const submitBtn = document.getElementById('submitBtn');

    const jurusanSelect = document.querySelector('select[name="jurusan_id"]');
    const kelasSelect = document.getElementById('kelasSelect');
    const rombelSelect = document.getElementById('rombelSelect');

    /* ================= FILTER KELAS ================= */

    function filterKelas(){

        const jurusanId = jurusanSelect ? jurusanSelect.value : '';

        Array.from(kelasSelect.options).forEach(opt => {

            if(!opt.value) return;

            const match = !jurusanId || opt.dataset.jurusan == jurusanId;

            opt.hidden = !match;

        });

        const selected = kelasSelect.selectedOptions[0];

        if(selected && selected.hidden){
            kelasSelect.value = '';
            filterRombel();
        }
    }

    /* ================= FILTER ROMBEL ================= */

    function filterRombel(){

        const kelasId = kelasSelect ? kelasSelect.value : '';

        Array.from(rombelSelect.options).forEach(opt => {

            if(!opt.value) return;

            const match = !kelasId || opt.dataset.kelas == kelasId;

            opt.hidden = !match;

        });

        const selected = rombelSelect.selectedOptions[0];

        if(selected && selected.hidden){
            rombelSelect.value = '';
        }
    }

    if(jurusanSelect){
        jurusanSelect.addEventListener('change', filterKelas);
    }

    if(kelasSelect){
        kelasSelect.addEventListener('change', filterRombel);
    }

    filterKelas();

    /* ================= SUBMIT ================= */

    if(form){

        form.addEventListener('submit', function(e){

            const requiredFields = form.querySelectorAll('[required]');

            let valid = true;

            requiredFields.forEach(field => {

                if(!field.value.trim()){

                    valid = false;
                    field.style.borderColor = '#EF4444';

                }else{

                    field.style.borderColor = '';

                }

            });

            if(!valid){

                e.preventDefault();

                showToast(
                    'Mohon lengkapi semua field wajib diisi',
                    'error'
                );

                return;
            }

            submitBtn.disabled = true;

            submitBtn.innerHTML = `
                <span class="spinner"></span>
                Menyimpan...
            `;
        });

    }

    /* ================= TOAST ================= */

    function showToast(message, type = 'success'){

        const toast = document.createElement('div');

        toast.className = `toast-modern toast-${type}`;

        toast.innerHTML = `
            <i class="fas fa-${
                type === 'error'
                    ? 'circle-xmark'
                    : 'circle-check'
            }"></i>

            <div>${message}</div>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {

            toast.style.animation = 'slideOut .3s ease forwards';

            setTimeout(() => {
                toast.remove();
            }, 300);

        }, 3000);
    }

});
</script>

@endsection