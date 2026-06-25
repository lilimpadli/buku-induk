@extends('layouts.app')

@section('title', 'Edit Profil Guru')

@section('content')
<style>
    /* ===================== STYLE EDIT PROFIL ===================== */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: #f7fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Page Header */
    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(100px, -100px);
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        position: relative;
        z-index: 1;
    }

    /* Card Styles */
    .form-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: var(--transition);
    }

    .form-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .form-card .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        font-weight: 700;
        font-size: 1.1rem;
        border-bottom: 2px solid #667eea;
        padding: 1rem 1.5rem;
    }

    .form-card .card-header i {
        color: #667eea;
        margin-right: 8px;
    }

    .form-card .card-body {
        padding: 1.5rem;
    }

    /* Form Styles */
    .form-label {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-label i {
        color: #667eea;
        margin-right: 6px;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: var(--transition);
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    /* Button Styles */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }

    /* Alert Styles */
    .alert {
        border-radius: 12px;
        border: none;
        font-size: 0.875rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background-color: rgba(19, 180, 151, 0.1);
        color: #13B497;
        border-left: 4px solid #13B497;
    }

    .alert-danger {
        background-color: rgba(240, 83, 108, 0.1);
        color: #F0536C;
        border-left: 4px solid #F0536C;
    }

    .alert ul {
        margin-bottom: 0;
        padding-left: 1.2rem;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem 1rem;
        }
        
        .page-header h3 {
            font-size: 1.5rem;
        }
        
        .form-card .card-body {
            padding: 1.25rem;
        }
        
        .btn-gradient, .btn-outline-gradient {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        .d-flex.justify-content-end {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .d-flex.justify-content-end .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="page-header fade-in">
        <div>
            <h3 class="mb-1">✏️ Edit Profil Guru</h3>
            <div class="text-muted">Perbarui informasi profil Anda</div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card fade-in">
                <div class="card-header">
                    <i class="fas fa-user-edit"></i> Form Edit Profil
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i> Terjadi kesalahan:
                            <ul class="mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('walikelas.data_diri.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-user"></i> Nama Lengkap
                                </label>
                                <input type="text" name="nama" class="form-control" 
                                       value="{{ old('nama', $guru->nama ?? '') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-id-card"></i> NIP
                                </label>
                                <input type="text" name="nip" class="form-control" 
                                       value="{{ old('nip', $guru->nip ?? '') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-envelope"></i> Email
                                </label>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ old('email', $guru->email ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-venus-mars"></i> Jenis Kelamin
                                </label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L" {{ (old('jenis_kelamin', $guru->jenis_kelamin ?? '')) == 'L' ? 'selected' : '' }}>
                                        <i class="fas fa-male"></i> Laki-laki
                                    </option>
                                    <option value="P" {{ (old('jenis_kelamin', $guru->jenis_kelamin ?? '')) == 'P' ? 'selected' : '' }}>
                                        <i class="fas fa-female"></i> Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt"></i> Tempat Lahir
                                </label>
                                <input type="text" name="tempat_lahir" class="form-control" 
                                       value="{{ old('tempat_lahir', $guru->tempat_lahir ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Tanggal Lahir
                                </label>
                                <input type="date" name="tanggal_lahir" class="form-control" 
                                       value="{{ old('tanggal_lahir', $guru->tanggal_lahir ?? '') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-home"></i> Alamat
                            </label>
                            <textarea name="alamat" class="form-control" 
                                      placeholder="Masukkan alamat lengkap">{{ old('alamat', $guru->alamat ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-camera"></i> Foto Profil
                            </label>
                            <input type="file" name="photo" accept="image/*" class="form-control">
                            @if(isset($user) && $user->photo)
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-image me-1"></i> Foto saat ini: 
                                    <a href="{{ asset('storage/' . $user->photo) }}" target="_blank" class="text-primary">Lihat foto</a>
                                </small>
                            @endif
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-lock"></i> Password Baru
                                </label>
                                <input type="password" name="password" class="form-control" 
                                       autocomplete="new-password" placeholder="Kosongkan jika tidak ingin mengubah">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-check-double"></i> Konfirmasi Password
                                </label>
                                <input type="password" name="password_confirmation" class="form-control" 
                                       autocomplete="new-password" placeholder="Konfirmasi password baru">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('walikelas.data_diri.profile') }}" class="btn btn-outline-gradient">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button class="btn btn-gradient" type="submit">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection