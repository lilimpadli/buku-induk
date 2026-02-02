@extends('layouts.app')

@section('title', 'Raport Siswa - ' . $siswa->nama_lengkap)

@section('content')
<style>
    /* ===================== STYLE RAPORT SISWA ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .container {
        max-width: 1200px;
    }

    /* Page Title */
    h4.fw-bold {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 25px !important;
    }

    h4.fw-bold::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 3px;
    }

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
        background-color: #ffffff;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
        transform: translateY(-2px);
    }

    .card-body {
        padding: 2rem;
    }

    /* Form Styles */
    .form-label {
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
    }

    .form-select {
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        padding: 12px 15px;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
    }

    /* Button Styles */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border: none;
        box-shadow: 0 4px 6px rgba(47, 83, 255, 0.25);
    }

    .btn-primary:hover {
        box-shadow: 0 6px 8px rgba(47, 83, 255, 0.35);
    }

    /* Alert Styles */
    .alert {
        border-radius: 8px;
        border: none;
        padding: 1rem 1.5rem;
    }

    .alert-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    /* Info Card */
    .info-card {
        background: linear-gradient(135deg, rgba(47, 83, 255, 0.05), rgba(99, 102, 241, 0.05));
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .info-card h5 {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .info-card p {
        color: #64748B;
        margin-bottom: 0;
    }

    /* Form Section */
    .form-section {
        background-color: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        h4.fw-bold {
            font-size: 24px;
        }
        
        .card-body {
            padding: 1.25rem;
        }
        
        .form-label {
            font-size: 13px;
        }
        
        .form-select {
            font-size: 13px;
            padding: 8px 10px;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
            font-size: 14px;
        }
        
        .row.mb-4 {
            flex-direction: column;
        }
        
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
    
    @media (max-width: 576px) {
        h4.fw-bold {
            font-size: 20px;
            padding-left: 12px;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .info-card {
            padding: 1rem;
        }
        
        .btn {
            padding: 0.4rem 0.8rem;
            font-size: 12px;
        }
    }
</style>

<div class="container mt-4">
    <h4 class="fw-bold mb-4">Raport Siswa: {{ $siswa->nama_lengkap }}</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="info-card">
                <h5><i class="fas fa-info-circle me-2"></i>Informasi Penting</h5>
                <p>Pilih tahun ajaran dan semester yang sesuai untuk melihat raport siswa. Pastikan data yang dipilih sudah tersedia dalam sistem.</p>
            </div>
            
            <div class="form-section">
                <h5 class="fw-bold mb-4">Pilih Tahun Ajaran dan Semester</h5>
                
                <form method="GET" action="" id="raportForm">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                            <select name="tahun" id="tahun_ajaran" class="form-select" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach($raports as $r)
                                    <option value="{{ str_replace('/', '-', $r->tahun_ajaran) }}">{{ $r->tahun_ajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="semester" class="form-label">Semester</label>
                            <select name="semester" id="semester" class="form-select" required>
                                <option value="">-- Pilih Semester --</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Lihat Raport
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('raportForm').addEventListener('submit', function(e) {
    const tahun = document.getElementById('tahun_ajaran').value;
    const semester = document.getElementById('semester').value;
    if (!tahun || !semester) {
        e.preventDefault();
        
        // Create a custom alert instead of using browser alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>
            Pilih tahun ajaran dan semester terlebih dahulu.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Insert the alert at the beginning of the card body
        const cardBody = document.querySelector('.card-body');
        cardBody.insertBefore(alertDiv, cardBody.firstChild);
        
        // Auto remove the alert after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
        
        return;
    }
    this.action = '/kaprog/raport/siswa/{{ $siswa->id }}/' + semester + '/' + tahun.replace('/', '-');
});
</script>
@endpush