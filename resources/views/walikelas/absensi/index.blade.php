@extends('layouts.app')

@section('title', 'Input Absensi')

@section('content')
<style>
    /* ===================== STYLE INPUT ABSENSI ===================== */
    
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --danger-gradient: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

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

    /* FIX: Pseudo-element tidak boleh menutupi tombol */
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
        pointer-events: none;
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

    /* FIX: Tombol di header harus bisa diklik */
    .page-header .d-flex {
        position: relative;
        z-index: 10;
    }
    
    .page-header .btn,
    .page-header a {
        pointer-events: auto !important;
        cursor: pointer !important;
        position: relative;
        z-index: 11;
    }

    /* Filter Card */
    .filter-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        margin-bottom: 2rem;
        transition: var(--transition);
    }

    .filter-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        cursor: pointer;
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
        padding: 0.5rem 1rem;
        border-radius: 10px;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }

    .btn-outline-secondary {
        background: transparent;
        border: 2px solid #64748b;
        color: #64748b;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-outline-secondary:hover {
        background: #64748b;
        color: white;
        transform: translateY(-2px);
    }

    /* Student Item */
    .student-list {
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .student-item {
        border: none;
        border-radius: 12px !important;
        margin-bottom: 12px;
        padding: 16px;
        transition: var(--transition);
        background-color: white;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .student-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        background-color: #f8f9fa;
    }

    .student-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f0f4f8;
    }

    .student-avatar-placeholder {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
        font-size: 20px;
        background: var(--primary-gradient);
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .student-details strong {
        font-size: 16px;
        font-weight: 600;
        color: #1E293B;
        display: block;
        margin-bottom: 4px;
    }

    .student-details small {
        color: #64748B;
        font-size: 13px;
    }

    /* Status Button Group - TOMBOL CEPAT */
    .status-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .status-btn {
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid transparent;
        background: #f1f5f9;
        color: #475569;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .status-btn.hadir.active {
        background: #13B497;
        color: white;
        box-shadow: 0 4px 12px rgba(19, 180, 151, 0.4);
    }

    .status-btn.sakit.active {
        background: #f6d365;
        color: #7c2d12;
        box-shadow: 0 4px 12px rgba(246, 211, 101, 0.4);
    }

    .status-btn.izin.active {
        background: #4facfe;
        color: white;
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
    }

    .status-btn.alpha.active {
        background: #f5576c;
        color: white;
        box-shadow: 0 4px 12px rgba(245, 87, 108, 0.4);
    }

    .status-btn:not(.active) {
        background: #f1f5f9;
        color: #64748b;
    }

    .status-btn:not(.active):hover {
        background: #e2e8f0;
    }

    /* Quick Actions Bar */
    .quick-actions-bar {
        background: white;
        border-radius: 12px;
        padding: 12px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .quick-actions-bar .btn-sm {
        padding: 6px 14px;
        font-size: 13px;
        cursor: pointer;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #718096;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
        color: #667eea;
    }

    .empty-state h5 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .page-header { padding: 1.5rem 1rem; }
        .page-header h3 { font-size: 1.5rem; }
        .student-item { flex-direction: column; align-items: flex-start; gap: 12px; }
        .student-info { width: 100%; }
        .status-buttons { width: 100%; justify-content: flex-start; }
        .quick-actions-bar { flex-direction: column; align-items: stretch; }
        .quick-actions-bar .d-flex { justify-content: center; }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="page-header fade-in">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3 class="mb-1">
                    <i class="fas fa-users me-2"></i> Daftar Siswa
                </h3>
                <div class="text-muted">Klik tombol status di samping nama siswa untuk mengisi absensi</div>
            </div>
            <div class="d-flex gap-2 mt-2 mt-sm-0">
                <a href="{{ route('walikelas.absensi.rekap') }}" class="btn btn-outline-gradient" style="cursor: pointer; z-index: 100;">
                    <i class="fas fa-chart-bar me-2"></i> Lihat Rekap
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card filter-card fade-in">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted small">
                        <i class="fas fa-calendar-alt me-1"></i> Tanggal Absensi
                    </label>
                    <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}" id="tanggalInput">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-gradient" type="submit" id="pilihTanggalBtn">
                        <i class="fas fa-calendar-day me-2"></i> Pilih Tanggal
                    </button>
                </div>
                <div class="col-md-5 text-end">
                    <span class="text-muted">
                        <i class="fas fa-info-circle me-1"></i> Klik tombol status untuk mengisi kehadiran
                    </span>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Actions Bar -->
    <div class="quick-actions-bar fade-in">
        <div>
            <i class="fas fa-bolt text-warning me-2"></i>
            <strong>Aksi Cepat:</strong>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-outline-success" id="setAllHadir">
                <i class="fas fa-check-circle me-1"></i> Semua Hadir
            </button>
            <button type="button" class="btn btn-sm btn-outline-warning" id="setAllSakit">
                <i class="fas fa-thermometer-high me-1"></i> Semua Sakit
            </button>
            <button type="button" class="btn btn-sm btn-outline-info" id="setAllIzin">
                <i class="fas fa-file-alt me-1"></i> Semua Izin
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger" id="setAllAlpha">
                <i class="fas fa-times-circle me-1"></i> Semua Alpha
            </button>
        </div>
        <div>
            <small class="text-muted">Belum tersimpan, klik "Simpan Semua" di bawah</small>
        </div>
    </div>

    <!-- Student List Card -->
    <div class="card shadow-sm fade-in" style="border-radius: var(--border-radius); overflow: hidden;">
        <div class="card-body p-0">
            <form method="POST" action="{{ route('walikelas.absensi.store') }}" id="absensiForm">
                @csrf
                <input type="hidden" name="tanggal" value="{{ $tanggal }}" id="formTanggal">
                
                @if(isset($siswa) && $siswa->count() > 0)
                    <div class="student-list">
                        @foreach($siswa as $index => $s)
                            <div class="student-item" data-siswa-id="{{ $s->id }}">
                                <div class="student-info">
                                    @if($s->foto)
                                        <img src="{{ asset('storage/' . $s->foto) }}" alt="{{ $s->nama_lengkap }}" class="student-avatar">
                                    @else
                                        <div class="student-avatar-placeholder">
                                            {{ strtoupper(substr($s->nama_lengkap, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="student-details">
                                        <strong>{{ $s->nama_lengkap }}</strong>
                                        <small>NIS: {{ $s->nis ?? '-' }} • NISN: {{ $s->nisn ?? '-' }}</small>
                                    </div>
                                </div>
                                
                                <div class="status-buttons">
                                    @php
                                        $currentStatus = $existingAbsensi[$s->id]->status ?? 'hadir';
                                    @endphp
                                    <input type="hidden" name="absensi[{{ $s->id }}]" value="{{ $currentStatus }}" class="status-input">
                                    
                                    <button type="button" class="status-btn hadir {{ $currentStatus == 'hadir' ? 'active' : '' }}" data-status="hadir">
                                        <i class="fas fa-check-circle"></i> Hadir
                                    </button>
                                    <button type="button" class="status-btn sakit {{ $currentStatus == 'sakit' ? 'active' : '' }}" data-status="sakit">
                                        <i class="fas fa-thermometer-half"></i> Sakit
                                    </button>
                                    <button type="button" class="status-btn izin {{ $currentStatus == 'izin' ? 'active' : '' }}" data-status="izin">
                                        <i class="fas fa-file-alt"></i> Izin
                                    </button>
                                    <button type="button" class="status-btn alpha {{ $currentStatus == 'alpha' ? 'active' : '' }}" data-status="alpha">
                                        <i class="fas fa-times-circle"></i> Alpha
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <span id="savedIndicator" class="text-success" style="display: none;">
                                <i class="fas fa-check-circle"></i> Tersimpan
                            </span>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-gradient px-5" id="simpanBtn">
                                <i class="fas fa-save me-2"></i> Simpan Semua
                            </button>
                            <a href="{{ route('walikelas.absensi.rekap') }}" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-chart-bar me-2"></i> Lihat Rekap
                            </a>
                        </div>
                    </div>
                @else
                    <div class="empty-state text-center py-5">
                        <i class="fas fa-user-graduate fa-3x mb-3 text-muted"></i>
                        <h5>Tidak ada data siswa</h5>
                        <p class="text-muted">Belum ada siswa yang terdaftar di kelas Anda.</p>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update tanggal di form saat filter berubah
    const tanggalInput = document.getElementById('tanggalInput');
    const formTanggal = document.getElementById('formTanggal');
    
    if (tanggalInput && formTanggal) {
        tanggalInput.addEventListener('change', function() {
            formTanggal.value = this.value;
        });
    }
    
    // Untuk setiap siswa, handle klik tombol status
    const studentItems = document.querySelectorAll('.student-item');
    
    studentItems.forEach(item => {
        const statusBtns = item.querySelectorAll('.status-btn');
        const hiddenInput = item.querySelector('.status-input');
        
        statusBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedStatus = this.dataset.status;
                
                if (hiddenInput) {
                    hiddenInput.value = selectedStatus;
                }
                
                statusBtns.forEach(b => {
                    b.classList.remove('active');
                });
                this.classList.add('active');
                
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 100);
            });
        });
    });
    
    // Fitur "Set All"
    const setAllHadir = document.getElementById('setAllHadir');
    if (setAllHadir) {
        setAllHadir.addEventListener('click', function() { setAllStatus('hadir'); showToast('Semua siswa diset ke HADIR', 'success'); });
    }
    
    const setAllSakit = document.getElementById('setAllSakit');
    if (setAllSakit) {
        setAllSakit.addEventListener('click', function() { setAllStatus('sakit'); showToast('Semua siswa diset ke SAKIT', 'warning'); });
    }
    
    const setAllIzin = document.getElementById('setAllIzin');
    if (setAllIzin) {
        setAllIzin.addEventListener('click', function() { setAllStatus('izin'); showToast('Semua siswa diset ke IZIN', 'info'); });
    }
    
    const setAllAlpha = document.getElementById('setAllAlpha');
    if (setAllAlpha) {
        setAllAlpha.addEventListener('click', function() { setAllStatus('alpha'); showToast('Semua siswa diset ke ALPHA', 'danger'); });
    }
    
    function setAllStatus(status) {
        document.querySelectorAll('.student-item').forEach(item => {
            const hiddenInput = item.querySelector('.status-input');
            const btns = item.querySelectorAll('.status-btn');
            
            if (hiddenInput) hiddenInput.value = status;
            
            btns.forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.status === status) btn.classList.add('active');
            });
        });
    }
    
    function showToast(message, type) {
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            toastContainer.style.zIndex = '1100';
            document.body.appendChild(toastContainer);
        }
        
        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center text-bg-${type} border-0 show`;
        toastEl.role = 'alert';
        toastEl.setAttribute('data-bs-autohide', 'true');
        toastEl.setAttribute('data-bs-delay', '2000');
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : type === 'info' ? 'info-circle' : 'times-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        toastContainer.appendChild(toastEl);
        
        setTimeout(() => toastEl.remove(), 2000);
        
        if (typeof bootstrap !== 'undefined') {
            new bootstrap.Toast(toastEl).show();
        }
    }
});
</script>
@endsection