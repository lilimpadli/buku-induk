@extends('layouts.app')

@section('title', 'Edit Profil Kaprog')

@section('content')
<style>
    /* ===================== SAMA STYLE DENGAN DASHBOARD ===================== */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --danger-gradient: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --bg-light: #f7fafc;
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--text-primary);
    }

    /* Header Styles (Sama dengan dashboard) */
    .dashboard-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
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

    .dashboard-header h2 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .dashboard-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        position: relative;
        z-index: 1;
    }

    /* Card Styles */
    .card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    .card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: var(--primary-gradient);
    }

    .card-body {
        padding: 2rem;
    }

    /* Form Styles */
    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control, .form-select {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 12px 16px;
        font-size: 14px;
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

    /* Alert Styles */
    .alert {
        border-radius: 12px;
        border: none;
        font-size: 14px;
        margin-bottom: 1.5rem;
        padding: 12px 18px;
    }

    .alert-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .alert-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .alert ul {
        margin-bottom: 0;
        padding-left: 20px;
    }

    /* Buttons */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        border-radius: 12px;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-secondary {
        background-color: #64748b;
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        border-radius: 12px;
        transition: var(--transition);
    }

    .btn-secondary:hover {
        background-color: #475569;
        transform: translateY(-2px);
        color: white;
    }

    hr {
        border-color: #e2e8f0;
        margin: 1.5rem 0;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem 1rem;
        }
        
        .dashboard-header h2 {
            font-size: 1.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .form-label {
            font-size: 13px;
        }
        
        .form-control, .form-select {
            padding: 10px 14px;
            font-size: 13px;
        }
        
        .btn-gradient, .btn-secondary {
            padding: 0.5rem 1.2rem;
            font-size: 14px;
        }
        
        .d-flex.justify-content-end {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .d-flex.justify-content-end .btn {
            width: 100%;
        }
    }
    
    @media (max-width: 576px) {
        .container {
            padding: 0 1rem;
        }
        
        .card-body {
            padding: 1.25rem;
        }
        
        .form-label {
            font-size: 12px;
        }
        
        .form-control, .form-select {
            padding: 8px 12px;
            font-size: 12px;
        }
        
        .btn-gradient, .btn-secondary {
            padding: 0.4rem 1rem;
            font-size: 13px;
        }
        
        .alert {
            font-size: 12px;
            padding: 10px 12px;
        }
        
        textarea.form-control {
            min-height: 80px;
        }
    }
</style>

<div class="container mt-4">
    <!-- Header (SAMA PERSIS DENGAN DASHBOARD) -->
    <div class="dashboard-header fade-in">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2 class="mb-1">Edit Profil Kaprog ✏️</h2>
                <div class="text-muted">Perbarui informasi data diri Anda</div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card fade-in" style="animation-delay: 0.1s;">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li><i class="fas fa-times-circle me-2"></i>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('kaprog.datapribadi.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama', $guru->nama ?? '') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" name="nip" class="form-control" value="{{ old('nip', $guru->nip ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $guru->email ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. HP / Telepon</label>
                                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $guru->no_hp ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $guru->tempat_lahir ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $guru->tanggal_lahir ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ (old('jenis_kelamin', $guru->jenis_kelamin ?? '')) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ (old('jenis_kelamin', $guru->jenis_kelamin ?? '')) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $guru->alamat ?? '') }}</textarea>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="photo" accept="image/*" class="form-control">
                                @if(isset($user) && $user->photo)
                                    <small class="text-muted mt-1 d-block">
                                        <i class="fas fa-image me-1"></i> Foto saat ini: 
                                        <a href="{{ asset('storage/' . $user->photo) }}" target="_blank" class="text-primary">Lihat</a>
                                    </small>
                                @endif
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control" autocomplete="new-password" placeholder="Kosongkan jika tidak ingin mengubah password">
                                <small class="text-muted">Minimal 6 karakter</small>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password" placeholder="Konfirmasi password baru">
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('kaprog.datapribadi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Batal
                            </a>
                            <button class="btn btn-gradient" type="submit">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection