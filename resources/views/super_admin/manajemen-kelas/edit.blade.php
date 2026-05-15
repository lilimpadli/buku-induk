@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<style>
    /* ===================== STYLE EDIT KELAS ===================== */
    
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

    .page-header {
        margin-bottom: 1.5rem;
    }

    h3 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 5px !important;
    }

    h3::before {
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
    
    .text-muted {
        color: #64748B !important;
        margin-left: 15px;
    }

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        padding: 16px 24px;
        border-bottom: none;
    }

    .card-header h5 {
        color: white;
        font-weight: 600;
        margin: 0;
        font-size: 18px;
    }

    .card-header h5 i {
        margin-right: 8px;
    }

    /* Form Styles */
    .form-label {
        font-weight: 600;
        color: #374151;
        font-size: 13px;
        margin-bottom: 6px;
    }

    .form-label i {
        color: var(--primary-color);
        width: 18px;
    }

    .form-control, .form-select {
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
        outline: none;
    }
    
    /* Button Styles */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        border-radius: 10px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 83, 255, 0.4);
        color: white;
    }

    .btn-secondary {
        background-color: #64748B;
        border: none;
        border-radius: 10px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #475569;
        transform: translateY(-2px);
    }
    
    /* Divider */
    .section-divider {
        border-top: 1px solid #E2E8F0;
        margin: 20px 0;
        position: relative;
    }
    
    .section-divider span {
        background: white;
        padding: 0 12px;
        position: absolute;
        top: -12px;
        left: 15px;
        font-size: 12px;
        font-weight: 600;
        color: #94A3B8;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        h3 {
            font-size: 22px;
        }
        .card-header {
            padding: 12px 20px;
        }
        .btn-primary, .btn-secondary {
            width: 100%;
            margin-top: 8px;
        }
        .d-flex.gap-2 {
            flex-direction: column;
        }
        .text-muted {
            margin-left: 0;
            margin-bottom: 15px;
        }
    }
</style>

<div class="container-fluid mt-4">

    <!-- PAGE HEADER -->
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-0">Edit Rombel</h3>
            <p class="text-muted mt-1">Perbarui data rombel yang ada.</p>
        </div>
    </div>

    <!-- MAIN CARD -->
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-edit"></i> Form Edit Rombel
            </h5>
        </div>
        <div class="card-body p-4">

            <form action="{{ route('super_admin.manajemen-kelas.update', $rombel->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ERROR MESSAGES --}}
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- SUCCESS MESSAGES --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="section-divider">
                    <span>INFORMASI ROMBEL</span>
                </div>

                <div class="row g-3">
                    <!-- Tingkat -->
                    <div class="col-md-6">
                        <label for="tingkat" class="form-label">
                            <i class="fas fa-layer-group"></i> Tingkat <span class="text-danger">*</span>
                        </label>
                        <select name="tingkat" id="tingkat" class="form-select" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="10" {{ $rombel->kelas->tingkat == '10' ? 'selected' : '' }}>Kelas 10</option>
                            <option value="11" {{ $rombel->kelas->tingkat == '11' ? 'selected' : '' }}>Kelas 11</option>
                            <option value="12" {{ $rombel->kelas->tingkat == '12' ? 'selected' : '' }}>Kelas 12</option>
                        </select>
                    </div>

                    <!-- Konsentrasi Keahlian -->
                    <div class="col-md-6">
                        <label for="jurusan_id" class="form-label">
                            <i class="fas fa-building"></i> Konsentrasi Keahlian <span class="text-danger">*</span>
                        </label>
                        <select name="jurusan_id" id="jurusan_id" class="form-select" required>
                            <option value="">Pilih Konsentrasi Keahlian</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}" {{ $j->id == $rombel->kelas->jurusan_id ? 'selected' : '' }}>
                                    {{ $j->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <!-- Nama Rombel -->
                    <div class="col-md-6">
                        <label for="nama" class="form-label">
                            <i class="fas fa-tag"></i> Nama Rombel <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" class="form-control" 
                            placeholder="Contoh: X RPL 1, XI TKJ 2, XII DPIB 1"
                            value="{{ old('nama', $rombel->nama) }}" required>
                        <small class="form-text text-muted">Contoh: X RPL 1, XI TKJ 2, XII DPIB 1</small>
                    </div>

                    <!-- Wali Kelas -->
                    <div class="col-md-6">
                        <label for="guru_id" class="form-label">
                            <i class="fas fa-chalkboard-user"></i> Wali Kelas
                        </label>
                        <select name="guru_id" id="guru_id" class="form-select">
                            <option value="">-- Pilih Wali Kelas --</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ $guru->id == $rombel->guru_id ? 'selected' : '' }}>
                                    {{ $guru->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="section-divider mt-4"></div>

                <!-- BUTTON ACTIONS -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('super_admin.manajemen-kelas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection