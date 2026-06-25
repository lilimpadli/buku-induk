@extends('layouts.app')

@section('title', 'Tambah User')

@push('styles')
<style>
.page-header{
    background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
    border-radius: 28px;
    padding: 30px 28px;
    color: white;
    box-shadow: 0 24px 48px rgba(47,83,255,0.14);
    margin-bottom: 28px;
}

.page-title{
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 8px;
}

.page-subtitle{
    color: rgba(255,255,255,0.88);
    margin: 0;
    font-size: 0.98rem;
    line-height: 1.7;
}

.card-modern{
    background: #ffffff;
    border-radius: 28px;
    box-shadow: 0 24px 60px rgba(15,23,42,0.08);
    border: none;
    overflow: hidden;
}

.card-modern .card-body{
    padding: 28px;
}

.form-group{
    margin-bottom: 24px;
}

.form-label{
    display: block;
    font-weight: 700;
    font-size: 0.95rem;
    color: #475569;
    margin-bottom: 10px;
}

.form-control{
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    transition: border-color .25s ease, box-shadow .25s ease;
    font-family: inherit;
}

.form-control:focus{
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102,126,234,0.1);
}

.form-control.is-invalid{
    border-color: #ef4444;
}

.invalid-feedback{
    display: block;
    color: #ef4444;
    font-size: 0.85rem;
    margin-top: 8px;
    font-weight: 600;
}

.btn-modern{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border: none;
    border-radius: 999px;
    padding: 12px 28px;
    min-height: 48px;
    font-weight: 700;
    color: white;
    transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
    cursor: pointer;
    font-size: 1rem;
}

.btn-modern:hover{
    transform: translateY(-1px);
    box-shadow: 0 18px 40px rgba(47,83,255,0.15);
    text-decoration: none;
    color: white;
}

.btn-primary-modern{
    background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
}

.btn-secondary-modern{
    background: #94a3b8;
}

.btn-secondary-modern:hover{
    box-shadow: 0 18px 40px rgba(148,163,184,0.15);
}

.form-row{
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

@media (max-width: 768px) {
    .form-row{
        grid-template-columns: 1fr;
    }
    
    .page-title{
        font-size: 1.5rem;
    }
}

.btn-group{
    display: flex;
    gap: 12px;
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid #e2e8f0;
}

.btn-group a{
    text-decoration: none;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah User Baru</h1>
            <p class="page-subtitle">Buat akun pengguna baru untuk sistem.</p>
        </div>
    </div>

    <div class="card-modern" style="max-width: 600px; margin: 0 auto;">
        <div class="card-body">
            <form action="{{ route('super_admin.users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nomor_induk" class="form-label">Nomor Induk (Opsional)</label>
                        <input type="text" id="nomor_induk" name="nomor_induk" class="form-control @error('nomor_induk') is-invalid @enderror" 
                               value="{{ old('nomor_induk') }}">
                        @error('nomor_induk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               class="form-control @error('password_confirmation') is-invalid @enderror" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Role/Peran</label>
                    <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="kurikulum" {{ old('role') === 'kurikulum' ? 'selected' : '' }}>Kurikulum</option>
                        <option value="kaprog" {{ old('role') === 'kaprog' ? 'selected' : '' }}>Kaprog</option>
                        <option value="walikelas" {{ old('role') === 'walikelas' ? 'selected' : '' }}>Wali Kelas</option>
                        <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="tu" {{ old('role') === 'tu' ? 'selected' : '' }}>TU</option>
                        <option value="tu_kepegawaian" {{ old('role') === 'tu_kepegawaian' ? 'selected' : '' }}>TU Kepegawaian</option>
                        <option value="siswa" {{ old('role') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-modern btn-primary-modern">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                    <a href="{{ route('super_admin.users.index') }}" class="btn-modern btn-secondary-modern">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
