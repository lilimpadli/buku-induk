@extends('layouts.app')

@section('content')

<style>
    /* CSS Variables untuk konsistensi */
    :root {
        --primary-color: #667eea;
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --danger-gradient: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --bg-light: #f7fafc;
        --bg-white: #ffffff;
        --border-radius: 12px;
        --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.07);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Reset dan base styles */
    * {
        box-sizing: border-box;
    }

    body {
        background-color: var(--bg-light);
        color: var(--text-primary);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
    }

    /* Utility classes */
    .gradient-text {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .card-hover {
        transition: var(--transition);
        cursor: pointer;
    }

    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    /* Header improvements */
    .dashboard-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 20s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(-30px, -30px) rotate(180deg); }
    }

    .dashboard-header h2 {
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .dashboard-header .subtitle {
        opacity: 0.9;
        font-size: 1rem;
        position: relative;
        z-index: 1;
    }

    /* Card improvements */
    .stat-card {
        background: var(--bg-white);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid #e5e7eb;
    }

    .stat-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .stat-card .icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 1rem;
        transition: var(--transition);
    }

    .stat-card:hover .icon-wrapper {
        transform: scale(1.05);
    }

    /* Profile card improvements */
    .profile-card {
        background: var(--bg-white);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        text-align: center;
        border: 1px solid #e5e7eb;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        overflow: hidden;
        border: 4px solid white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        position: relative;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-avatar .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 48px;
        font-weight: 700;
    }

    /* Button improvements */
    .btn-gradient {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-outline {
        background: transparent;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-outline:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: var(--danger-gradient);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
    }

    /* Parent contact card improvements */
    .parent-card {
        background: var(--bg-white);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid #e5e7eb;
    }

    .parent-section {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .parent-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .parent-section h6 {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .parent-info {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
    }

    .parent-info p {
        margin: 0.5rem 0;
        font-size: 0.95rem;
    }

    .parent-info strong {
        color: var(--text-primary);
    }

    /* Modal improvements */
    .modal-content {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        border-bottom: 1px solid #e5e7eb;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid #e5e7eb;
        padding: 1.5rem;
    }

    .form-control {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.75rem;
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    /* Animations */
    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem;
        }

        .dashboard-header h2 {
            font-size: 1.5rem;
        }

        .stat-card {
            padding: 1.25rem;
        }

        .profile-card {
            padding: 1.5rem;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
        }

        .profile-avatar .avatar-placeholder {
            font-size: 40px;
        }

        .btn-gradient, .btn-outline {
            padding: 0.625rem 1.25rem;
            font-size: 0.9rem;
        }
    }

    /* Loading spinner */
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 2px;
    }

    /* Toast notification */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
    }

    .toast {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 300px;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .toast.success {
        border-left: 4px solid #13B497;
    }

    .toast.error {
        border-left: 4px solid #F5576C;
    }

    .toast.warning {
        border-left: 4px solid #fa709a;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-secondary);
    }

    .empty-state svg {
        width: 64px;
        height: 64px;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
</style>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="dashboard-header fade-in">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h2 class="mb-2">Selamat Datang, {{ $siswa->nama_lengkap ?? Auth::user()->name }}! 👋</h2>
                <p class="subtitle mb-0">
                    Kelas: 
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
                </p>
            </div>
           
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row g-3 mb-4">
        <div class="col-lg-6 col-md-6 fade-in">
            <div class="stat-card card-hover">
                <div class="icon-wrapper" style="background: var(--primary-gradient);">
                    <i class="fas fa-chalkboard-teacher text-white"></i>
                </div>
                <h5 class="text-muted mb-1">Wali Kelas</h5>
                <h4 class="mb-2">{{ $siswa && $siswa->rombel && $siswa->rombel->guru ? $siswa->rombel->guru->nama : 'Belum ditentukan' }}</h4>
                <p class="text-muted small mb-0">Guru pengampu kelas Anda</p>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 fade-in">
            <div class="stat-card card-hover">
                <div class="icon-wrapper" style="background: var(--success-gradient);">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
                <h5 class="text-muted mb-1">Status Profil</h5>
                <h4 class="mb-2">
                    @if(isset($missing) && count($missing) > 0)
                        <span class="text-warning">{{ count($missing) }} Field Kosong</span>
                    @else
                        <span class="text-success">Lengkap</span>
                    @endif
                </h4>
                <p class="text-muted small mb-0">
                    @if(isset($missing) && count($missing) > 0)
                        Masih ada {{ count($missing) }} field yang perlu diisi
                    @else
                        Semua data penting sudah terisi
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-lg-8 fade-in">
            <div class="profile-card card-hover">
                <div class="profile-avatar">
                    @if($siswa && $siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Profil">
                    @else
                        <div class="avatar-placeholder">
                            {{ $siswa ? strtoupper(substr($siswa->nama_lengkap,0,1)) : 'S' }}
                        </div>
                    @endif
                </div>

                <h3 class="mb-2">{{ $siswa->nama_lengkap ?? 'Belum Lengkap' }}</h3>
                <p class="text-muted mb-4">NIS: {{ $siswa->nis ?? '-' }} • NISN: {{ $siswa->nisn ?? '-' }}</p>

                <!-- Action Buttons -->
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('siswa.dataDiri.exportPDF') }}" class="btn btn-gradient" target="_blank">
                        <i class="fas fa-download"></i> Unduh Data
                    </a>
                    
                </div>
            </div>
        </div>

        <!-- Parent Contact Card -->
        <div class="col-lg-4 fade-in">
            <div class="parent-card">
                <h5 class="mb-4">Kontak Orang Tua</h5>

                <div class="parent-section">
                    <h6 class="text-primary">
                        <i class="fas fa-user-tie"></i> Data Ayah
                    </h6>
                    <div class="parent-info">
                        <p><strong>Nama:</strong> {{ $siswa->ayah->nama ?? '-' }}</p>
                        <p><strong>Telepon:</strong> {{ $siswa->ayah->telepon ?? '-' }}</p>
                        <p><strong>Pekerjaan:</strong> {{ $siswa->ayah->pekerjaan ?? '-' }}</p>
                    </div>
                </div>

                <div class="parent-section">
                    <h6 class="text-danger">
                        <i class="fas fa-user"></i> Data Ibu
                    </h6>
                    <div class="parent-info">
                        <p><strong>Nama:</strong> {{ $siswa->ibu->nama ?? '-' }}</p>
                        <p><strong>Telepon:</strong> {{ $siswa->ibu->telepon ?? '-' }}</p>
                        <p><strong>Pekerjaan:</strong> {{ $siswa->ibu->pekerjaan ?? '-' }}</p>
                    </div>
                </div>

               
            </div>
        </div>
    </div>
</div>

<!-- Modal Templates -->
<div id="modalContainer"></div>

<script>
    // Modal Functions
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    }

    // Toast Notification
    function showToast(message, type = 'success') {
        const toastContainer = document.getElementById('toastContainer');
        const toastId = 'toast-' + Date.now();
        
        const toastHTML = `
            <div id="${toastId}" class="toast ${type}">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <div class="flex-grow-1">${message}</div>
                <button type="button" class="btn-close" onclick="closeToast('${toastId}')"></button>
            </div>
        `;
        
        toastContainer.insertAdjacentHTML('beforeend', toastHTML);
        
        setTimeout(() => {
            closeToast(toastId);
        }, 5000);
    }

    function closeToast(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.remove();
        }
    }

    // Form Submission Handler
    document.addEventListener('submit', function(e) {
        const form = e.target;
        const submitButton = form.querySelector('button[type="submit"]');
        
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
        }
        
        // Handle form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const action = form.action;
            const method = form.method;
            
            fetch(action, {
                method: method,
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    // Close modal if exists
                    const modal = form.closest('.modal');
                    if (modal) {
                        bootstrap.Modal.getInstance(modal).hide();
                    }
                    // Reload page or update content as needed
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showToast(data.message || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                showToast('Terjadi kesalahan jaringan', 'error');
            })
            .finally(() => {
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = submitButton.dataset.originalText || 'Simpan';
                }
            });
        });
    });

    // Store original button text
    document.querySelectorAll('button[type="submit"]').forEach(button => {
        button.dataset.originalText = button.innerHTML;
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

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
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                               value="{{ $siswa->nama_lengkap ?? '' }}" required autofocus>
                        <div class="form-text">Masukkan nama lengkap sesuai KTP</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editNamaModal')">Batal</button>
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
                        <label for="email" class="form-label">Email Baru</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ Auth::user()->email }}" required>
                        <div class="form-text">Gunakan email yang aktif untuk notifikasi</div>
                    </div>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <div class="form-text">Masukkan password saat ini untuk mengubah email</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editEmailModal')">Batal</button>
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
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Foto yang diunggah akan digunakan sebagai foto profil Anda.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editFotoModal')">Batal</button>
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
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Peringatan!</strong> Anda yakin ingin menghapus foto profil?
                </div>
                <p class="mb-0">Tindakan ini tidak dapat dikembalikan. Foto Anda akan diganti dengan avatar default.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('confirmDeleteFotoModal')">Batal</button>
                <form action="{{ route('siswa.profile.photo.delete') }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Foto</button>
                </form>
            </div>
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
                        <div class="form-text">Masukkan password saat ini</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-text">Minimal 8 karakter, kombinasi huruf dan angka</div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        <div class="form-text">Ulangi password baru</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editPasswordModal')">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection