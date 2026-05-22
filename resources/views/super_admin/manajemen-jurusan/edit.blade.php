@extends('layouts.app')

@section('title', 'Edit Jurusan')

@section('content')
<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="page-header mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-edit"></i>
                    Edit Jurusan
                </h1>

                <p class="page-subtitle mb-0">
                    Perbarui informasi jurusan agar tetap konsisten dan terstruktur di seluruh sistem akademik.
                </p>
            </div>

            <div class="header-badge">
                <i class="fas fa-graduation-cap"></i>
                {{ $jurusan->nama }}
            </div>
        </div>
    </div>

    <!-- CARD -->
    <div class="modern-card">

        <div class="card-header-modern">
            <div>
                <h4 class="mb-1 fw-bold">Form Edit Jurusan</h4>
                <p class="text-muted mb-0">
                    Pastikan kode dan nama jurusan sesuai standar sekolah.
                </p>
            </div>
        </div>

        <div class="card-body-modern">

            @if ($errors->any())
                <div class="alert-modern danger mb-4">
                    <div class="d-flex align-items-start gap-3">
                        <i class="fas fa-exclamation-circle mt-1"></i>

                        <div>
                            <div class="fw-bold mb-1">
                                Periksa kembali data formulir
                            </div>

                            <ul class="mb-0 ps-3 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('super_admin.manajemen-jurusan.update', $jurusan->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row g-4">

                    <!-- KODE -->
                    <div class="col-12">
                        <label for="kode" class="form-label-modern">
                            Kode Jurusan
                        </label>

                        <div class="input-wrapper">
                            <i class="fas fa-code input-icon"></i>

                            <input type="text"
                                   id="kode"
                                   name="kode"
                                   class="form-control-modern @error('kode') is-invalid @enderror"
                                   value="{{ old('kode', $jurusan->kode) }}"
                                   placeholder="Contoh: RPL"
                                   required>
                        </div>

                        @error('kode')
                            <div class="invalid-text">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- NAMA -->
                    <div class="col-12">
                        <label for="nama" class="form-label-modern">
                            Nama Jurusan
                        </label>

                        <div class="input-wrapper">
                            <i class="fas fa-layer-group input-icon"></i>

                            <input type="text"
                                   id="nama"
                                   name="nama"
                                   class="form-control-modern @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $jurusan->nama) }}"
                                   placeholder="Masukkan nama jurusan"
                                   required>
                        </div>

                        @error('nama')
                            <div class="invalid-text">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- ACTION -->
                    <div class="col-12">
                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-3 pt-2">

                            <a href="{{ route('super_admin.manajemen-jurusan.index') }}"
                               class="btn-modern btn-secondary-modern">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>

                            <button type="submit"
                                    class="btn-modern btn-primary-modern">
                                <i class="fas fa-save"></i>
                                Update Jurusan
                            </button>

                        </div>
                    </div>

                </div>

            </form>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
:root{
    --primary-blue:#2F53FF;
    --secondary-blue:#7C3AED;
    --light-bg:#F4F7FE;
    --soft-gray:#E9EEF7;
    --text-dark:#1E293B;
    --text-muted:#64748B;

    --shadow-light:0 10px 30px rgba(15,23,42,0.06);
    --shadow-medium:0 20px 50px rgba(15,23,42,0.10);
    --shadow-hover:0 22px 55px rgba(47,83,255,0.14);
}

body{
    background: var(--light-bg);
}

/* HEADER */
.page-header{
    background: linear-gradient(135deg,var(--primary-blue) 0%,var(--secondary-blue) 100%);
    border-radius: 30px;
    padding: 34px;
    color: white;
    box-shadow: var(--shadow-medium);
}

.page-title{
    font-size: 2rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 10px;
}

.page-subtitle{
    color: rgba(255,255,255,.88);
    font-size: .98rem;
    line-height: 1.7;
    max-width: 650px;
}

.header-badge{
    background: rgba(255,255,255,.14);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.18);
    padding: 14px 20px;
    border-radius: 18px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    white-space: nowrap;
}

/* CARD */
.modern-card{
    background: white;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: var(--shadow-light);
    animation: fadeInUp .45s ease both;
}

.card-header-modern{
    padding: 28px 32px;
    border-bottom: 1px solid #EEF2F7;
    background: linear-gradient(180deg,#F8FBFF 0%,#FFFFFF 100%);
}

.card-body-modern{
    padding: 32px;
}

/* ALERT */
.alert-modern{
    border-radius: 20px;
    padding: 18px 20px;
    border: none;
    font-size: .95rem;
}

.alert-modern.danger{
    background: #FEF2F2;
    color: #991B1B;
    border-left: 5px solid #EF4444;
}

/* FORM */
.form-label-modern{
    font-size: .95rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 10px;
    display: block;
}

.input-wrapper{
    position: relative;
}

.input-icon{
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: .95rem;
}

.form-control-modern{
    width: 100%;
    border-radius: 20px;
    border: 2px solid var(--soft-gray);
    padding: 15px 18px 15px 50px;
    background: #FBFDFF;
    transition: .3s ease;
    font-size: .95rem;
    color: var(--text-dark);
}

.form-control-modern:focus{
    outline: none;
    border-color: var(--primary-blue);
    background: white;
    box-shadow: 0 0 0 5px rgba(47,83,255,.08);
}

.form-control-modern.is-invalid{
    border-color: #EF4444;
    background: #FFF5F5;
}

.invalid-text{
    margin-top: 8px;
    color: #DC2626;
    font-size: .85rem;
    font-weight: 500;
}

/* BUTTON */
.btn-modern{
    border: none;
    border-radius: 18px;
    padding: 13px 22px;
    font-size: .95rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: .3s ease;
    text-decoration: none;
}

.btn-modern:hover{
    transform: translateY(-2px);
}

.btn-primary-modern{
    background: linear-gradient(135deg,#2F53FF 0%,#7C3AED 100%);
    color: white;
    box-shadow: 0 16px 30px rgba(47,83,255,.18);
}

.btn-primary-modern:hover{
    color: white;
    box-shadow: var(--shadow-hover);
}

.btn-secondary-modern{
    background: #F1F5F9;
    color: #334155;
    border: 1px solid #E2E8F0;
}

.btn-secondary-modern:hover{
    background: #E2E8F0;
    color: #1E293B;
}

/* ANIMATION */
@keyframes fadeInUp{
    from{
        opacity: 0;
        transform: translateY(18px);
    }
    to{
        opacity: 1;
        transform: translateY(0);
    }
}

/* MOBILE */
@media(max-width:768px){

    .page-header{
        padding: 24px;
        border-radius: 24px;
    }

    .page-title{
        font-size: 1.55rem;
    }

    .card-header-modern,
    .card-body-modern{
        padding: 22px;
    }

    .btn-modern{
        width: 100%;
    }

    .header-badge{
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush