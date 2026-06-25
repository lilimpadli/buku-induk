@extends('layouts.app')

@section('title', 'Edit Akun Siswa')

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

    --shadow-sm:0 2px 6px rgba(15,23,42,.05);
    --shadow-md:0 10px 25px rgba(15,23,42,.08);
    --shadow-lg:0 18px 35px rgba(15,23,42,.12);

    --radius:22px;
    --transition:all .25s ease;
}

body{
    background:
        radial-gradient(circle at top left, rgba(99,102,241,.12), transparent 30%),
        radial-gradient(circle at bottom right, rgba(124,58,237,.10), transparent 30%),
        linear-gradient(180deg,#f8faff 0%,#eef2ff 100%);
}

/* ================= HEADER ================= */

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
    width:240px;
    height:240px;
    border-radius:50%;
    background:rgba(255,255,255,.08);
    top:-100px;
    right:-60px;
}

.page-header::after{
    content:'';
    position:absolute;
    width:180px;
    height:180px;
    border-radius:50%;
    background:rgba(255,255,255,.05);
    bottom:-80px;
    left:-50px;
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
    font-size:36px;
    font-weight:800;
    color:white;
    margin:0;
}

.page-subtitle{
    margin-top:8px;
    color:rgba(255,255,255,.82);
    font-size:14px;
}

.header-badge{
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:12px 18px;
    border-radius:16px;
    background:rgba(255,255,255,.12);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,.14);
    color:white;
    font-weight:600;
}

/* ================= CARD ================= */

.glass-card{
    background:rgba(255,255,255,.92);
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,.7);
    border-radius:28px;
    overflow:hidden;
    box-shadow:var(--shadow-md);
}

.card-header-modern{
    padding:26px 30px;
    border-bottom:1px solid #eef2ff;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:14px;
    flex-wrap:wrap;
}

.card-title-modern{
    font-size:20px;
    font-weight:700;
    color:var(--text);
    margin:0;
    display:flex;
    align-items:center;
    gap:12px;
}

.card-subtitle{
    color:var(--text-light);
    font-size:14px;
    margin-top:4px;
}

.card-body-modern{
    padding:32px;
}

/* ================= FORM ================= */

.form-section{
    margin-bottom:34px;
}

.form-section-title{
    display:flex;
    align-items:center;
    gap:12px;
    font-size:18px;
    font-weight:700;
    color:var(--text);
    margin-bottom:24px;
}

.form-section-title .icon{
    width:42px;
    height:42px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    color:white;
    box-shadow:0 10px 20px rgba(79,70,229,.18);
}

.form-wrapper .form-label{
    font-weight:700;
    font-size:14px;
    margin-bottom:10px;
    color:var(--text);
}

.form-wrapper .form-control,
.form-wrapper .form-select{
    border:1.5px solid #dbe3ff;
    background:#f9fbff;
    border-radius:16px;
    padding:14px 16px;
    font-size:14px;
    transition:var(--transition);
    box-shadow:none;
}

.form-wrapper .form-control:focus,
.form-wrapper .form-select:focus{
    border-color:var(--primary);
    background:white;
    box-shadow:0 0 0 5px rgba(79,70,229,.08);
}

.form-wrapper .form-control::placeholder{
    color:#9CA3AF;
}

.form-note{
    font-size:12px;
    color:var(--text-light);
    margin-top:8px;
}

/* ================= ALERT ================= */

.alert-modern{
    border:none;
    border-radius:22px;
    padding:20px 24px;
    display:flex;
    gap:16px;
    align-items:flex-start;
    margin-bottom:24px;
    box-shadow:var(--shadow-sm);
}

.alert-danger-modern{
    background:#FEF2F2;
    color:#DC2626;
}

.alert-icon{
    width:42px;
    height:42px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:rgba(220,38,38,.1);
    font-size:18px;
}

.alert-title{
    font-weight:700;
    margin-bottom:6px;
}

/* ================= BUTTON ================= */

.btn-modern{
    border:none;
    border-radius:16px;
    padding:14px 22px;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    text-decoration:none;
    transition:var(--transition);
    white-space:nowrap;
}

.btn-modern:hover{
    transform:translateY(-2px);
}

.btn-primary-modern{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    color:white;
    box-shadow:0 10px 24px rgba(79,70,229,.18);
}

.btn-secondary-modern{
    background:white;
    color:var(--text);
    border:1px solid #e5e7eb;
}

.btn-secondary-modern:hover{
    background:#f9fafb;
    color:var(--primary);
}

.action-area{
    border-top:1px solid #eef2ff;
    margin-top:36px;
    padding-top:28px;
    display:flex;
    justify-content:flex-end;
    gap:14px;
    flex-wrap:wrap;
}

/* ================= LOADING ================= */

.spinner-modern{
    width:18px;
    height:18px;
    border:2px solid rgba(255,255,255,.35);
    border-top-color:white;
    border-radius:50%;
    animation:spin .8s linear infinite;
}

@keyframes spin{
    to{
        transform:rotate(360deg);
    }
}

/* ================= TOAST ================= */

.toast-modern{
    position:fixed;
    top:24px;
    right:24px;
    background:white;
    border-radius:18px;
    padding:16px 20px;
    box-shadow:var(--shadow-lg);
    display:flex;
    align-items:center;
    gap:12px;
    z-index:9999;
    min-width:280px;
    border-left:5px solid var(--danger);
    animation:slideIn .25s ease;
}

.toast-modern.success{
    border-left-color:var(--success);
}

.toast-modern.error{
    border-left-color:var(--danger);
}

@keyframes slideIn{
    from{
        opacity:0;
        transform:translateX(100%);
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
        transform:translateX(100%);
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

    .card-body-modern{
        padding:22px;
    }

    .action-area{
        flex-direction:column;
    }

    .btn-modern{
        width:100%;
    }
}
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    <!-- HEADER -->
    <div class="page-header">

        <div class="header-content">

            <div>
                <h1 class="page-title">
                    Edit Akun Siswa
                </h1>

                <div class="page-subtitle">
                    Perbarui data siswa dengan tampilan form yang lebih modern dan nyaman digunakan.
                </div>
            </div>

            <div class="header-badge">
                <i class="fas fa-user-pen"></i>
                {{ $siswa->nama_lengkap }}
            </div>

        </div>

    </div>

    <!-- ERROR -->
    @if ($errors->any())

        <div class="alert-modern alert-danger-modern">

            <div class="alert-icon">
                <i class="fas fa-circle-exclamation"></i>
            </div>

            <div>

                <div class="alert-title">
                    Terdapat kesalahan pada form
                </div>

                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        </div>

    @endif

    <!-- FORM -->
    <div class="glass-card">

        <div class="card-header-modern">

            <div>

                <h5 class="card-title-modern">
                    <i class="fas fa-file-pen text-primary"></i>
                    Form Edit Siswa
                </h5>

                <div class="card-subtitle">
                    Pastikan seluruh data yang diubah sudah benar sebelum disimpan.
                </div>

            </div>

            <a href="{{ route('tu.siswa.index') }}"
               class="btn-modern btn-secondary-modern">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>

        </div>

        <div class="card-body-modern">

            <form
                method="POST"
                action="{{ route('tu.siswa.update', $siswa->id) }}"
                id="editForm"
                class="form-wrapper"
            >

                @csrf
                @method('PUT')

                <!-- SECTION -->
                <div class="form-section">

                    <div class="form-section-title">
                        <div class="icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>

                        <div>
                            Data Siswa
                        </div>
                    </div>

                    @include('tu.siswa._form')

                </div>

                <!-- ACTION -->
                <div class="action-area">

                    <a href="{{ route('tu.siswa.index') }}"
                       class="btn-modern btn-secondary-modern">
                        <i class="fas fa-xmark"></i>
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn-modern btn-primary-modern"
                        id="submitBtn"
                    >
                        <i class="fas fa-floppy-disk"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('editForm');
    const submitBtn = document.getElementById('submitBtn');

    // ================= SUBMIT =================

    if(form){

        form.addEventListener('submit', function(e){

            let valid = true;

            const requiredFields = form.querySelectorAll('[required]');

            requiredFields.forEach(field => {

                if(!field.value.trim()){

                    field.style.borderColor = '#EF4444';
                    valid = false;

                }else{

                    field.style.borderColor = '';

                }

            });

            if(!valid){

                e.preventDefault();

                showToast(
                    'Mohon lengkapi seluruh field yang wajib diisi.',
                    'error'
                );

                return;

            }

            submitBtn.disabled = true;

            submitBtn.innerHTML = `
                <span class="spinner-modern"></span>
                Menyimpan...
            `;

        });

    }

    // ================= FILTER JURUSAN =================

    const jurusanSelect = document.querySelector('select[name="jurusan_id"]');
    const kelasSelect = document.getElementById('kelasSelect');
    const rombelSelect = document.getElementById('rombelSelect');

    function filterKelas(){

        const jurusanId = jurusanSelect ? jurusanSelect.value : '';

        Array.from(kelasSelect.options).forEach(opt => {

            if(!opt.value) return;

            const match = !jurusanId || opt.dataset.jurusan == jurusanId;

            opt.style.display = match ? '' : 'none';

        });

        if(
            kelasSelect.selectedOptions.length &&
            kelasSelect.selectedOptions[0].style.display === 'none'
        ){
            kelasSelect.value = '';
            filterRombel();
        }

    }

    function filterRombel(){

        const kelasId = kelasSelect ? kelasSelect.value : '';

        Array.from(rombelSelect.options).forEach(opt => {

            if(!opt.value) return;

            const match = !kelasId || opt.dataset.kelas == kelasId;

            opt.style.display = match ? '' : 'none';

        });

        if(
            rombelSelect.selectedOptions.length &&
            rombelSelect.selectedOptions[0].style.display === 'none'
        ){
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
    filterRombel();

    // ================= TOAST =================

    function showToast(message, type = 'success') {

        const toast = document.createElement('div');

        toast.className = `toast-modern ${type}`;

        const icon =
            type === 'success'
                ? 'fa-circle-check'
                : 'fa-circle-xmark';

        toast.innerHTML = `
            <i class="fas ${icon}"></i>
            <div>${message}</div>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {

            toast.style.animation = 'slideOut .25s ease forwards';

            setTimeout(() => {

                toast.remove();

            }, 250);

        }, 3000);
    }

});
</script>

@endsection