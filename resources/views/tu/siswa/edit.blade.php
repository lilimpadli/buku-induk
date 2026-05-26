@extends('layouts.app')

@section('title', 'Edit Akun Siswa')

@section('content')
<style>
    /* ===================== MODERN STYLES EDIT SISWA ===================== */
    
    :root {
        --primary-color: #4F46E5;
        --primary-light: #6366F1;
        --secondary-color: #7C3AED;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --info-color: #3B82F6;
        --light-bg: #F9FAFB;
        --card-bg: #FFFFFF;
        --text-primary: #111827;
        --text-secondary: #6B7280;
        --border-color: #E5E7EB;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background: linear-gradient(135deg, #F9FAFB 0%, #F3F4F6 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        min-height: 100vh;
    }

    /* Header Styles */
    .page-header {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .page-title::after {
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
        margin-top: 8px;
    }

    /* Card Styles */
    .card-modern {
        background: var(--card-bg);
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: var(--transition);
    }

    .card-modern:hover {
        box-shadow: var(--shadow-lg);
    }

    .card-header-modern {
        padding: 24px 32px;
        border-bottom: 1px solid var(--border-color);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(124, 58, 237, 0.05));
    }

    .card-body-modern {
        padding: 32px;
    }

    /* Form Styles */
    .form-label-modern {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 8px;
        display: flex;
            align-items: center;
            gap: 8px;
        }

    .form-control-modern {
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        transition: var(--transition);
        background: var(--card-bg);
    }

    .form-control-modern:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

    .form-select-modern {
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        transition: var(--transition);
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 40px;
        background-color: var(--card-bg);
    }

    .form-select-modern:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

    /* Form Row */
    .form-row-modern {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-bottom: 24px;
    }

    /* Alert Styles */
    .alert-modern {
        border-radius: 12px;
        border: none;
        padding: 20px 24px;
        margin-bottom: 24px;
        display: flex;
            align-items: flex-start;
            gap: 12px;
            box-shadow: var(--shadow-sm);
        }

    .alert-icon-modern {
        font-size: 20px;
            margin-top: 2px;
        }

    .alert-content-modern {
            flex: 1;
        }

    .alert-title-modern {
            font-weight: 600;
            margin-bottom: 4px;
        }

    .alert-message-modern {
            color: var(--text-secondary);
            font-size: 14px;
        }

    .alert-danger-modern {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.05), rgba(248, 113, 113, 0.05));
            color: #DC2626;
        }

    /* Button Styles */
    .btn-modern {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 500;
        transition: var(--transition);
        border: none;
        display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            white-space: nowrap;
        }

    .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

    .btn-primary-modern {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
        }

    .btn-secondary-modern {
            background: var(--light-bg);
            color: var(--text-primary);
            border: 2px solid var(--border-color);
        }

    .btn-secondary-modern:hover {
            background: var(--border-color);
            color: var(--text-primary);
        }

    /* Action Buttons */
    .action-buttons-modern {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

    /* Loading Spinner */
    .spinner-modern {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

    @keyframes spin {
            to { transform: rotate(360deg); }
        }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 20px;
        }

        .page-title {
            font-size: 24px;
        }

        .card-body-modern {
            padding: 20px;
        }

        .form-row-modern {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .action-buttons-modern {
            flex-direction: column;
        }

        .btn-modern {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container mt-4">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Akun Siswa</h1>
        </div>
        <a href="{{ route('tu.siswa.index') }}" class="btn-modern btn-secondary-modern">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="alert-modern alert-danger-modern">
            <i class="fas fa-exclamation-circle alert-icon-modern"></i>
            <div class="alert-content-modern">
                <div class="alert-title-modern">Terjadi kesalahan</div>
                <div class="alert-message-modern">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Form Card -->
    <div class="card-modern">
        <div class="card-header-modern">
            <h3 class="h4 mb-0">Form Edit Data Siswa</h3>
        </div>
        <div class="card-body-modern">
            <form method="POST" action="{{ route('tu.siswa.update', $siswa->id) }}" id="editForm">
                @csrf
                @method('PUT')

                @include('tu.siswa._form')

                <!-- Action Buttons -->
                <div class="action-buttons-modern">
                    <a href="{{ route('tu.siswa.index') }}" class="btn-modern btn-secondary-modern">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn-modern btn-primary-modern" id="submitBtn">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Form submission handling
    const form = document.getElementById('editForm');
    const submitBtn = document.getElementById('submitBtn');

    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            // Validate required fields
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#EF4444';
                    isValid = false;
                } else {
                    field.style.borderColor = '';
                }
            });

            if (!isValid) {
                e.preventDefault();
                showToast('Mohon lengkapi semua field yang wajib diisi', 'error');
                return;
            }

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-modern"></span> Menyimpan...';
        });
    }

    // Dependent selects script
    const jurusanSelect = document.querySelector('select[name="jurusan_id"]');
    const kelasSelect = document.getElementById('kelasSelect');
    const rombelSelect = document.getElementById('rombelSelect');

    function filterKelas() {
        const jurusanId = jurusanSelect ? jurusanSelect.value : '';
        
        // Update kelas options
        Array.from(kelasSelect.options).forEach(opt => {
            if (!opt.value) return;
            const match = !jurusanId || opt.dataset.jurusan == jurusanId;
            opt.style.display = match ? '' : 'none';
        });
        
        // Reset selection if current option is hidden
        if (kelasSelect.selectedOptions.length && kelasSelect.selectedOptions[0].style.display === 'none') {
            kelasSelect.value = '';
            filterRombel();
        }
    }

    function filterRombel() {
        const kelasId = kelasSelect ? kelasSelect.value : '';
        
        // Update rombel options
        Array.from(rombelSelect.options).forEach(opt => {
            if (!opt.value) return;
            const dataKelas = opt.dataset.kelas || '';
            const match = !kelasId || dataKelas == kelasId;
            opt.style.display = match ? '' : 'none';
        });
        
        // Reset selection if current option is hidden
        if (rombelSelect.selectedOptions.length && rombelSelect.selectedOptions[0].style.display === 'none') {
            rombelSelect.value = '';
        }
    }

    // Add event listeners
    if (jurusanSelect) jurusanSelect.addEventListener('change', filterKelas);
    if (kelasSelect) kelasSelect.addEventListener('change', filterRombel);

    // Initialize filters
    filterKelas();

    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `alert-modern alert-${type}-modern position-fixed top-0 start-50 translate-middle-x mt-3 z-50`;
        toast.style.animation = 'slideIn 0.3s ease-out';
        
        const icon = type === 'success' ? 'check-circle' : 
                     type === 'warning' ? 'exclamation-triangle' : 
                     type === 'error' ? 'times-circle' : 'info-circle';
        
        toast.innerHTML = `
            <i class="fas fa-${icon} alert-icon-modern"></i>
            <div class="alert-content-modern">
                <div class="alert-message-modern">${message}</div>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-in';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Add slide animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(-50%) translateY(-100%); opacity: 0; }
            to { transform: translateX(-50%) translateY(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(-50%) translateY(0); opacity: 1; }
            to { transform: translateX(-50%) translateY(-100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection