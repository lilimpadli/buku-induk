@extends('layouts.app')

@section('content')

<style>
    /* ===================== STYLE DASHBOARD SISWA ===================== */
    
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

    /* Header Styles */
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
        font-size: 1.75rem;
    }

    .dashboard-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        position: relative;
        z-index: 1;
    }

    /* Card Styles */
    .stat-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        position: relative;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    .stat-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: var(--primary-gradient);
    }

    .stat-card.success::before {
        background: var(--success-gradient);
    }

    .stat-card.danger::before {
        background: var(--danger-gradient);
    }

    .stat-card.info::before {
        background: var(--info-gradient);
    }

    .stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1);
    }

    .stat-icon.primary {
        background: var(--primary-gradient);
    }

    .stat-icon.success {
        background: var(--success-gradient);
    }

    .stat-icon.danger {
        background: var(--danger-gradient);
    }

    .stat-icon.info {
        background: var(--info-gradient);
    }

    /* Button Styles */
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 2px solid;
        border-image: var(--primary-gradient) 1;
        color: #667eea;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        transform: translateY(-2px);
    }

    /* Profile Card */
    .profile-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        height: 100%;
    }

    .profile-card:hover {
        box-shadow: var(--card-hover-shadow);
        transform: translateY(-3px);
    }

    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        object-fit: cover;
    }

    .profile-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
        font-size: 54px;
        border: 5px solid white;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Action Button */
    .action-btn {
        border-radius: 10px;
        padding: 0.6rem 1.2rem;
        margin-bottom: 8px;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
        
        .stat-icon {
            width: 56px;
            height: 56px;
            font-size: 20px;
        }
        
        .profile-image, .profile-placeholder {
            width: 120px;
            height: 120px;
            font-size: 44px;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="dashboard-header fade-in">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2 class="mb-1">Selamat Datang, {{ $siswa->nama_lengkap ?? Auth::user()->name }}! 👋</h2>
                <div class="text-muted">
                    Kelas kamu: 
                    @if($siswa && $siswa->rombel)
                        @php
                            $rombelDisplay = $siswa->rombel->nama ?? '';
                            if(!empty($rombelDisplay)){
                                if(preg_match('/^([a-zA-Z]+)\s*([0-9]+)$/', $rombelDisplay, $m)){
                                    $rombelDisplay = strtoupper($m[1]) . ' ' . $m[2];
                                } else {
                                    $rombelDisplay = ucwords(strtolower($rombelDisplay));
                                }
                            }
                        @endphp
                        {{ $rombelDisplay ?: '-' }}
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('siswa.dataDiri.edit') }}" class="btn btn-gradient">Edit Profil</a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6 col-md-6 fade-in" style="animation-delay: 0.1s;">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon primary me-3">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Wali Kelas</div>
                            <div class="h5 mb-0">{{ $siswa && $siswa->rombel && $siswa->rombel->guru ? $siswa->rombel->guru->nama : 'Belum ditentukan' }}</div>
                        </div>
                    </div>
                    <div class="mt-3 small text-muted">Guru pengampu kelas Anda</div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 fade-in" style="animation-delay: 0.2s;">
            <div class="card stat-card success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon success me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Status Profil</div>
                            @if(isset($missing) && count($missing) > 0)
                                <div class="h5 mb-0 text-warning">{{ count($missing) }} Field Kosong</div>
                            @else
                                <div class="h5 mb-0 text-success">Lengkap</div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-3 small text-muted">
                        @if(isset($missing) && count($missing) > 0)
                            Masih ada {{ count($missing) }} field yang perlu diisi
                        @else
                            Semua data penting sudah terisi
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Profile Card - Left Side (Bigger) -->
        <div class="col-xl-8 fade-in" style="animation-delay: 0.5s;">
            <div class="card profile-card h-100">
                <div class="card-body text-center p-5">
                    @if($siswa && $siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" class="profile-image mb-4" alt="Foto Siswa">
                    @else
                        <div class="profile-placeholder bg-gradient mb-4 mx-auto" style="background: var(--primary-gradient);">
                            {{ $siswa ? strtoupper(substr($siswa->nama_lengkap,0,1)) : 'S' }}
                        </div>
                    @endif
                    
                    <h3 class="mb-2">{{ $siswa->nama_lengkap ?? 'Belum Lengkap' }}</h3>
                    <p class="text-muted mb-4">NIS: {{ $siswa->nis ?? '-' }} • NISN: {{ $siswa->nisn ?? '-' }}</p>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-gradient w-100" data-bs-toggle="modal" data-bs-target="#editNamaModal">
                                <i class="fas fa-user me-2"></i> Edit Nama
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-gradient w-100" data-bs-toggle="modal" data-bs-target="#editEmailModal">
                                <i class="fas fa-envelope me-2"></i> Edit Email
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-gradient w-100" data-bs-toggle="modal" data-bs-target="#editFotoModal">
                                <i class="fas fa-camera me-2"></i> Edit Foto
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-gradient w-100" data-bs-toggle="modal" data-bs-target="#editPasswordModal">
                                <i class="fas fa-key me-2"></i> Ubah Password
                            </button>
                        </div>
                        @if($siswa && $siswa->foto)
                        <div class="col-md-12">
                            <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#confirmDeleteFotoModal">
                                <i class="fas fa-trash me-2"></i> Hapus Foto
                            </button>
                        </div>
                        @endif
                    </div>
                    
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('siswa.dataDiri.exportPDF') }}" class="btn btn-gradient px-4" target="_blank">
                            <i class="fas fa-download me-2"></i> Unduh Data Diri
                        </a>
                        <a href="{{ route('siswa.dataDiri.edit') }}" class="btn btn-outline-gradient px-4">
                            <i class="fas fa-edit me-2"></i> Lengkapi Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <!-- Kontak Orang Tua - Right Side -->
            <div class="card shadow-sm mb-4 fade-in" style="animation-delay: 0.6s; border-radius: var(--border-radius);">
                <div class="card-body">
                    <h5 class="mb-4">Kontak Orang Tua</h5>

                    <div class="mb-4">
                        <div class="card border-0 bg-light mb-3">
                            <div class="card-body">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-user-tie me-2"></i>Data Ayah
                                </h6>
                                <table class="table table-borderless table-sm mb-0">
                                    <tbody>
                                        <tr>
                                            <th width="40%">Nama</th>
                                            <td>{{ $siswa->ayah->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Telepon</th>
                                            <td>{{ $siswa->ayah->telepon ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan</th>
                                            <td>{{ $siswa->ayah->pekerjaan ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="text-danger mb-3">
                                    <i class="fas fa-user me-2"></i>Data Ibu
                                </h6>
                                <table class="table table-borderless table-sm mb-0">
                                    <tbody>
                                        <tr>
                                            <th width="40%">Nama</th>
                                            <td>{{ $siswa->ibu->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Telepon</th>
                                            <td>{{ $siswa->ibu->telepon ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan</th>
                                            <td>{{ $siswa->ibu->pekerjaan ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('siswa.dataDiri.edit') }}" class="btn btn-gradient w-100">
                        <i class="fas fa-edit me-2"></i>Edit Kontak Orang Tua
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Nama -->
<div class="modal fade" id="editNamaModal" tabindex="-1" aria-labelledby="editNamaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNamaModalLabel">Edit Nama Lengkap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.updateProfile') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $siswa->nama_lengkap ?? '' }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Email -->
<div class="modal fade" id="editEmailModal" tabindex="-1" aria-labelledby="editEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmailModalLabel">Edit Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.updateEmail') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <div class="form-text">Masukkan password saat ini untuk mengubah email</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Foto -->
<div class="modal fade" id="editFotoModal" tabindex="-1" aria-labelledby="editFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFotoModalLabel">Ganti Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.uploadPhoto') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="foto" class="form-label">Pilih Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                        <div class="form-text">Format: JPG, JPEG, PNG. Maksimal: 2MB</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Foto -->
<div class="modal fade" id="confirmDeleteFotoModal" tabindex="-1" aria-labelledby="confirmDeleteFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteFotoModalLabel">Hapus Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.profile.photo.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus foto profil? Tindakan ini tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Password -->
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPasswordModalLabel">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.updatePassword') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-text">Minimal 8 karakter</div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection