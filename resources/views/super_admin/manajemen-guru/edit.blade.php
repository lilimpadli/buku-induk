@extends('layouts.app')

@section('title', 'Edit Guru')

@section('content')

<style>
:root{
    --primary:#667eea;
    --secondary:#764ba2;
    --success:#10B981;
    --danger:#EF4444;
    --warning:#F59E0B;
    --dark:#1E293B;
    --text:#64748B;
    --border:#E2E8F0;
    --bg:#F8FAFC;
}

body{
    background: var(--bg);
}

.page-header{
    background: linear-gradient(135deg,var(--primary) 0%,var(--secondary) 100%);
    border-radius: 28px;
    padding: 30px;
    color: white;
    margin-bottom: 28px;
    box-shadow: 0 24px 48px rgba(102,126,234,.18);
}

.page-title{
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 6px;
}

.page-subtitle{
    margin: 0;
    color: rgba(255,255,255,.88);
    font-size: .95rem;
}

.card-modern{
    border: none;
    border-radius: 28px;
    overflow: hidden;
    background: white;
    box-shadow: 0 20px 60px rgba(15,23,42,.08);
}

.card-header-modern{
    padding: 24px 28px;
    border-bottom: 1px solid #EEF2F7;
    background: #fff;
}

.card-header-modern h5{
    margin: 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--dark);
}

.card-body-modern{
    padding: 30px;
}

.section-title{
    font-size: .82rem;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #94A3B8;
    margin-bottom: 18px;
}

.form-label{
    font-size: .9rem;
    font-weight: 700;
    color: #334155;
    margin-bottom: 8px;
}

.form-control,
.form-select{
    border: 1px solid var(--border);
    border-radius: 16px;
    min-height: 52px;
    padding: 12px 16px;
    font-size: .95rem;
    color: #334155;
    transition: all .25s ease;
}

.form-control:focus,
.form-select:focus{
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(102,126,234,.12);
}

.form-control.is-valid{
    border-color: var(--success);
}

.form-control.is-invalid{
    border-color: var(--danger);
}

.form-text{
    margin-top: 6px;
    font-size: .82rem;
}

.alert{
    border: none;
    border-radius: 18px;
    padding: 16px 18px;
}

.btn-modern{
    border: none;
    border-radius: 14px;
    padding: 12px 22px;
    font-weight: 700;
    transition: all .25s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-modern:hover{
    transform: translateY(-2px);
}

.btn-primary-modern{
    background: linear-gradient(135deg,var(--primary) 0%,var(--secondary) 100%);
    color: white;
    box-shadow: 0 14px 28px rgba(102,126,234,.22);
}

.btn-primary-modern:hover{
    color: white;
}

.btn-secondary-modern{
    background: #E2E8F0;
    color: #334155;
}

.btn-secondary-modern:hover{
    background: #CBD5E1;
    color: #0F172A;
}

.divider{
    height: 1px;
    background: #EEF2F7;
    margin: 28px 0;
}

@media(max-width:768px){

    .page-header{
        padding: 24px;
    }

    .page-title{
        font-size: 1.6rem;
    }

    .card-body-modern{
        padding: 22px;
    }

    .btn-modern{
        width: 100%;
        justify-content: center;
    }

    .button-group{
        flex-direction: column;
    }
}
</style>

<div class="container-fluid py-4">

```
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1 class="page-title">Edit Guru</h1>
            <p class="page-subtitle">
                Perbarui informasi guru dan penugasan dengan tampilan modern.
            </p>
        </div>
    </div>
</div>

<div class="card-modern">

    <div class="card-header-modern">
        <h5>
            <i class="fas fa-user-edit me-2"></i>
            Form Edit Guru
        </h5>
    </div>

    <div class="card-body-modern">

        <form action="{{ route('super_admin.manajemen-guru.update', $guru->id) }}" method="POST">
            @csrf
            @method('PUT')

            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning mb-4">
                    {{ session('warning') }}
                </div>
            @endif

            <div class="section-title">Data Guru</div>

            <div class="row g-4">

                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="{{ old('nama', $guru->nama) }}"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">NIP / Nomor Induk</label>
                    <input type="text"
                           name="nomor_induk"
                           class="form-control"
                           value="{{ old('nomor_induk', $guru->nip) }}"
                           required>
                </div>

            </div>

            <div class="divider"></div>

            <div class="section-title">Penugasan</div>

            <div class="row g-4">

                <div class="col-md-4">
                    <label class="form-label">Jurusan</label>

                    <select id="jurusanSelect"
                            name="jurusan_id"
                            class="form-select">

                        <option value="">-- Pilih Jurusan --</option>

                        @foreach($jurusans as $j)
                            <option value="{{ $j->id }}"
                                {{ old('jurusan_id', $guru->jurusan_id) == $j->id ? 'selected' : '' }}>
                                {{ $j->nama }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Kelas</label>

                    <select id="kelasSelect"
                            name="kelas_id"
                            class="form-select">

                        <option value="">-- Pilih Kelas --</option>

                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}"
                                data-jurusan="{{ $k->jurusan_id }}"
                                {{ old('kelas_id', $guru->kelas_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->tingkat }} - {{ $k->jurusan->nama }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Rombel</label>

                    <select id="rombelSelect"
                            name="rombel_id"
                            class="form-select">

                        <option value="">-- Tidak sebagai wali --</option>

                        @foreach($rombels as $r)
                            <option value="{{ $r->id }}"
                                data-kelas="{{ $r->kelas_id }}"
                                {{ old('rombel_id', $guru->rombel_id) == $r->id ? 'selected' : '' }}>
                                {{ $r->nama }}
                            </option>
                        @endforeach

                    </select>
                </div>

            </div>

            <div class="divider"></div>

            <div class="section-title">Akun & Akses</div>

            <div class="row g-4">

                <div class="col-md-4">
                    <label class="form-label">Email</label>

                    <input type="email"
                           name="email"
                           id="emailInput"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $guru->email) }}">

                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror

                    <small id="emailStatus" class="form-text text-muted"></small>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Role</label>

                    <select name="role"
                            class="form-select"
                            required>

                        @foreach($roles as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('role', $guru->user->role ?? '') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Password Baru</label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Kosongkan jika tidak diubah">

                    <small class="form-text text-muted">
                        Minimal 8 karakter
                    </small>
                </div>

            </div>

            <div class="d-flex justify-content-end gap-3 mt-5 button-group">

                <a href="{{ route('super_admin.manajemen-guru.index') }}"
                   class="btn-modern btn-secondary-modern">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
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
```

</div>

@endsection
