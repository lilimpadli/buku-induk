@extends('layouts.app')

@section('title', 'Edit Data Pribadi Saya')

@section('content')
<style>
    /* ===================== EDIT PROFILE STYLES ===================== */
    
    :root {
        --primary: #4F46E5;
        --primary-dark: #4338CA;
        --secondary: #10B981;
        --danger: #EF4444;
        --warning: #F59E0B;
        --info: #3B82F6;
        --dark: #1F2937;
        --gray: #6B7280;
        --light: #F9FAFB;
        --white: #FFFFFF;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --radius: 12px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--light);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--dark);
    }

    /* Header */
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: var(--white);
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 var(--radius) var(--radius);
        box-shadow: var(--shadow-lg);
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .page-header .breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
    }

    .page-header .breadcrumb-item {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
    }

    .page-header .breadcrumb-item.active {
        color: var(--white);
    }

    /* Card Styles */
    .card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        border: none;
        transition: var(--transition);
        margin-bottom: 2rem;
    }

    .card:hover {
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        background: var(--white);
        border-bottom: 1px solid #E5E7EB;
        padding: 1.5rem;
        border-radius: var(--radius) var(--radius) 0 0 !important;
    }

    .card-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title::before {
        content: "";
        width: 4px;
        height: 24px;
        background: var(--primary);
        border-radius: 2px;
    }

    .card-body {
        padding: 2rem;
    }

    /* Form Styles */
    .form-section {
        margin-bottom: 2.5rem;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #E5E7EB;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title::before {
        content: "";
        width: 3px;
        height: 18px;
        background: var(--primary);
        border-radius: 2px;
    }

    .form-label {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.5rem;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label .required {
        color: var(--danger);
        font-size: 12px;
    }

    .form-control, .form-select {
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 14px;
        transition: var(--transition);
        background: var(--white);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: var(--danger);
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23EF4444'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23EF4444' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .form-control.is-valid, .form-select.is-valid {
        border-color: var(--secondary);
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3ccircle cx='4' cy='4' r='3' fill='%2310B981'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 12px;
        color: var(--danger);
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    /* File Upload */
    .file-upload-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 2rem;
        border: 2px dashed #E5E7EB;
        border-radius: var(--radius);
        background: var(--light);
        cursor: pointer;
        transition: var(--transition);
        text-align: center;
    }

    .file-upload-label:hover {
        border-color: var(--primary);
        background: rgba(79, 70, 229, 0.05);
    }

    .file-upload-label.has-file {
        border-style: solid;
        border-color: var(--secondary);
        background: rgba(16, 185, 129, 0.05);
    }

    .file-upload-label i {
        font-size: 24px;
        color: var(--gray);
    }

    .file-upload-label.has-file i {
        color: var(--secondary);
    }

    .file-upload-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .current-photo {
        margin-top: 1rem;
        text-align: center;
    }

    .current-photo img {
        max-width: 150px;
        max-height: 150px;
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
    }

    .current-photo a {
        color: var(--primary);
        text-decoration: none;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .current-photo a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    /* Alert Styles */
    .alert {
        border-radius: var(--radius);
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 1.25rem;
    }

    .alert-danger li {
        margin-bottom: 0.25rem;
    }

    .alert-danger li:last-child {
        margin-bottom: 0;
    }

    .alert-icon {
        font-size: 20px;
        margin-top: 0.125rem;
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-primary {
        background: var(--primary);
        color: var(--white);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        color: var(--white);
    }

    .btn-secondary {
        background: #6B7280;
        color: var(--white);
    }

    .btn-secondary:hover {
        background: #4B5563;
        color: var(--white);
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #E5E7EB;
    }

    /* Password Strength */
    .password-strength {
        margin-top: 0.5rem;
        height: 4px;
        background: #E5E7EB;
        border-radius: 2px;
        overflow: hidden;
    }

    .password-strength-bar {
        height: 100%;
        width: 0;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .password-strength-text {
        font-size: 12px;
        margin-top: 0.25rem;
    }

    .strength-weak {
        background: var(--danger);
        width: 33%;
    }

    .strength-medium {
        background: var(--warning);
        width: 66%;
    }

    .strength-strong {
        background: var(--secondary);
        width: 100%;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 24px;
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.6s ease-out;
    }
</style>

<div class="container mt-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <nav aria-label="breadcrumb">
               
            </nav>
            <h1>Edit Data Pribadi Saya</h1>
            <p class="mb-0 opacity-75">Perbarui informasi profil Anda</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle alert-icon"></i>
                    <strong>Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit"></i>
                        Form Edit Data Pribadi
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('tu.data-pribadi.update') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Informasi Dasar -->
                        <div class="form-section">
                            <h4 class="section-title">Informasi Dasar</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nama" class="form-label">
                                        Nama Lengkap
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" name="nama" value="{{ old('nama', $guru->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                                           id="nip" name="nip" value="{{ old('nip', $guru->nip) }}">
                                    @error('nip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $guru->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="tel" class="form-control @error('telepon') is-invalid @enderror" 
                                           id="telepon" name="telepon" value="{{ old('telepon', $guru->telepon) }}" 
                                           placeholder="0822-xxxx-xxxx">
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Data Pribadi -->
                        <div class="form-section">
                            <h4 class="section-title">Data Pribadi</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                           id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $guru->tempat_lahir) }}">
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                           id="tanggal_lahir" name="tanggal_lahir" 
                                           value="{{ old('tanggal_lahir') ?? ($guru->tanggal_lahir && is_object($guru->tanggal_lahir) ? $guru->tanggal_lahir->format('Y-m-d') : ($guru->tanggal_lahir ?? '')) }}">
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="jenis_kelamin" class="form-label">
                                        Jenis Kelamin
                                        <span class="required">*</span>
                                    </label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                            id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                              id="alamat" name="alamat" rows="4" placeholder="Masukkan alamat lengkap...">{{ old('alamat', $guru->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Foto Profil -->
                        <div class="form-section">
                            <h4 class="section-title">Foto Profil</h4>
                            <div class="file-upload-wrapper">
                                <label for="photo" class="file-upload-label @if(old('photo') || $user->photo) has-file @endif">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <div>
                                        <strong>Klik untuk upload foto</strong>
                                        <p class="mb-0 small text-muted">Format: JPG, PNG (Max: 2MB)</p>
                                    </div>
                                </label>
                                <input type="file" id="photo" name="photo" class="file-upload-input" accept="image/*">
                            </div>
                            @if(isset($user) && $user->photo)
                                <div class="current-photo">
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil Saat Ini">
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $user->photo) }}" target="_blank">
                                            <i class="fas fa-expand"></i> Lihat foto asli
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Keamanan -->
                        <div class="form-section">
                            <h4 class="section-title">Keamanan</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <div class="password-strength-wrapper">
                                        <input type="password" id="password" name="password" class="form-control" 
                                               autocomplete="new-password" placeholder="Kosongkan jika tidak ingin mengubah">
                                        <div class="password-strength">
                                            <div class="password-strength-bar"></div>
                                        </div>
                                        <div class="password-strength-text">Ketik password untuk melihat kekuatannya</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" 
                                           class="form-control" autocomplete="new-password" placeholder="Konfirmasi password baru">
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Biarkan kosong jika tidak ingin mengubah password.
                            </small>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="{{ route('tu.data-pribadi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });

    // Password strength checker
    const passwordInput = document.getElementById('password');
    const strengthBar = document.querySelector('.password-strength-bar');
    const strengthText = document.querySelector('.password-strength-text');

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            strengthBar.className = 'password-strength-bar';
            
            if (strength === 0) {
                strengthText.textContent = 'Ketik password untuk melihat kekuatannya';
                strengthText.className = 'password-strength-text';
            } else if (strength === 1) {
                strengthBar.classList.add('strength-weak');
                strengthText.textContent = 'Password lemah';
                strengthText.className = 'password-strength-text text-danger';
            } else if (strength === 2) {
                strengthBar.classList.add('strength-medium');
                strengthText.textContent = 'Password sedang';
                strengthText.className = 'password-strength-text text-warning';
            } else if (strength >= 3) {
                strengthBar.classList.add('strength-strong');
                strengthText.textContent = 'Password kuat';
                strengthText.className = 'password-strength-text text-success';
            }
        });
    }

    // File upload preview
    const fileInput = document.getElementById('photo');
    const fileLabel = document.querySelector('.file-upload-label');

    if (fileInput && fileLabel) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    fileLabel.innerHTML = `
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>${this.files[0].name}</strong>
                            <p class="mb-0 small text-muted">Klik untuk ganti foto</p>
                        </div>
                    `;
                    fileLabel.classList.add('has-file');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
</script>
@endsection