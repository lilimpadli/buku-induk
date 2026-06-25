@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')

<style>
:root{
    --primary:#4F46E5;
    --secondary:#7C3AED;
    --success:#22C55E;
    --light:#F4F7FE;
    --border:#E2E8F0;
    --text:#0F172A;
    --muted:#64748B;
    --shadow:0 10px 30px rgba(15,23,42,.08);
    --radius:28px;
}

body{
    background: var(--light);
    font-family: 'Poppins', sans-serif;
}

.page-wrapper{
    min-height:100vh;
    padding:40px 0;
}

.form-card{
    background:#fff;
    border:none;
    border-radius:var(--radius);
    overflow:hidden;
    box-shadow:var(--shadow);
    animation:fadeUp .4s ease;
}

.form-header{
    padding:32px 36px;
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    color:#fff;
}

.form-header h3{
    font-size:30px;
    font-weight:700;
    margin-bottom:8px;
}

.form-header p{
    margin:0;
    opacity:.9;
    font-size:14px;
}

.form-body{
    padding:36px;
}

.form-label{
    font-weight:600;
    color:var(--text);
    margin-bottom:10px;
    font-size:14px;
}

.form-control,
.form-select{
    border:2px solid var(--border);
    border-radius:18px;
    padding:14px 18px;
    min-height:56px;
    font-size:15px;
    transition:.3s ease;
    box-shadow:none !important;
}

.form-control:focus,
.form-select:focus{
    border-color:var(--primary);
    box-shadow:0 0 0 4px rgba(79,70,229,.12) !important;
}

.form-control::placeholder{
    color:#94A3B8;
}

.input-icon{
    position:relative;
}

.input-icon i{
    position:absolute;
    top:50%;
    left:18px;
    transform:translateY(-50%);
    color:#94A3B8;
    font-size:15px;
}

.input-icon .form-control,
.input-icon .form-select{
    padding-left:48px;
}

.section-title{
    font-size:13px;
    font-weight:700;
    color:var(--muted);
    letter-spacing:.08em;
    margin-bottom:20px;
    text-transform:uppercase;
}

.btn-modern{
    border:none;
    border-radius:18px;
    padding:14px 22px;
    font-weight:600;
    font-size:14px;
    transition:.3s ease;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    text-decoration:none;
}

.btn-modern:hover{
    transform:translateY(-2px);
}

.btn-primary-modern{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    color:#fff;
    box-shadow:0 10px 24px rgba(79,70,229,.25);
}

.btn-primary-modern:hover{
    color:#fff;
}

.btn-light-modern{
    background:#EEF2FF;
    color:var(--primary);
}

.btn-light-modern:hover{
    background:#E0E7FF;
    color:var(--primary);
}

.form-footer{
    border-top:1px solid #EEF2F7;
    margin-top:32px;
    padding-top:28px;
}

.text-danger.small{
    margin-top:8px;
    display:block;
}

.required{
    color:#EF4444;
}

@keyframes fadeUp{
    from{
        opacity:0;
        transform:translateY(20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

@media(max-width:768px){

    .page-wrapper{
        padding:20px 0;
    }

    .form-header{
        padding:28px 24px;
    }

    .form-header h3{
        font-size:24px;
    }

    .form-body{
        padding:24px;
    }

    .btn-modern{
        width:100%;
    }

    .form-footer{
        flex-direction:column;
    }
}
</style>

<div class="container page-wrapper">

<div class="row justify-content-center">

    <div class="col-xl-7 col-lg-8">

        <div class="form-card">

            <!-- HEADER -->
            <div class="form-header">

                <h3>
                    <i class="fas fa-school me-2"></i>
                    Form Tambah Kelas
                </h3>

                <p>
                    Tambahkan rombel baru beserta tingkat, jurusan, dan wali kelas.
                </p>

            </div>

            <!-- BODY -->
            <div class="form-body">

                <div class="section-title">
                    Informasi Kelas
                </div>

                <form action="{{ route('super_admin.manajemen-kelas.store') }}"
                      method="POST">

                    @csrf

                    <div class="row g-4">

                        <!-- TINGKAT -->
                        <div class="col-md-6">

                            <label for="tingkat" class="form-label">
                                Tingkat
                                <span class="required">*</span>
                            </label>

                            <div class="input-icon">
                                <i class="fas fa-layer-group"></i>

                                <select name="tingkat"
                                        id="tingkat"
                                        class="form-select"
                                        required>

                                    <option value="" disabled selected>
                                        -- Pilih Tingkat --
                                    </option>

                                    @foreach($tingkats as $t)
                                        <option value="{{ $t }}"
                                            {{ old('tingkat') == $t ? 'selected' : '' }}>
                                            Kelas {{ $t }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            @error('tingkat')
                                <span class="text-danger small">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <!-- JURUSAN -->
                        <div class="col-md-6">

                            <label for="jurusan_id" class="form-label">
                                Konsentrasi Keahlian
                                <span class="required">*</span>
                            </label>

                            <div class="input-icon">
                                <i class="fas fa-graduation-cap"></i>

                                <select name="jurusan_id"
                                        id="jurusan_id"
                                        class="form-select"
                                        required>

                                    <option value="" disabled selected>
                                        -- Pilih Jurusan --
                                    </option>

                                    @foreach($jurusans as $jurusan)

                                        <option value="{{ $jurusan->id }}"
                                            {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>

                                            {{ $jurusan->nama }}

                                        </option>

                                    @endforeach

                                </select>
                            </div>

                            @error('jurusan_id')
                                <span class="text-danger small">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <!-- NAMA ROMBEL -->
                        <div class="col-md-6">

                            <label for="nama" class="form-label">
                                Nama Rombel
                                <span class="required">*</span>
                            </label>

                            <div class="input-icon">
                                <i class="fas fa-school"></i>

                                <input type="text"
                                       id="nama"
                                       name="nama"
                                       class="form-control"
                                       value="{{ old('nama') }}"
                                       placeholder="Contoh: XI RPL 1"
                                       required>
                            </div>

                            @error('nama')
                                <span class="text-danger small">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                        <!-- WALI KELAS -->
                        <div class="col-md-6">

                            <label for="guru_id" class="form-label">
                                Wali Kelas
                            </label>

                            <div class="input-icon">
                                <i class="fas fa-user-tie"></i>

                                <select name="guru_id"
                                        id="guru_id"
                                        class="form-select">

                                    <option value="">
                                        -- Pilih Wali Kelas --
                                    </option>

                                    @foreach($gurus as $guru)

                                        <option value="{{ $guru->id }}"
                                            {{ old('guru_id') == $guru->id ? 'selected' : '' }}>

                                            {{ $guru->nama }}

                                        </option>

                                    @endforeach

                                </select>
                            </div>

                            @error('guru_id')
                                <span class="text-danger small">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>

                    <!-- BUTTON -->
                    <div class="form-footer d-flex justify-content-end gap-3">

                        <a href="{{ route('super_admin.manajemen-kelas.index') }}"
                           class="btn-modern btn-light-modern">

                            <i class="fas fa-arrow-left"></i>
                            Kembali

                        </a>

                        <button type="submit"
                                class="btn-modern btn-primary-modern">

                            <i class="fas fa-save"></i>
                            Simpan Data

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


</div>

@endsection
