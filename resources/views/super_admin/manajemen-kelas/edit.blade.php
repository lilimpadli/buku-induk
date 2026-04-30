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

    h3.mb-3 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 10px !important;
    }

    h3.mb-3::before {
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

    /* Form Styles */
    .form-label {
        font-weight: 600;
        color: #374151;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
    }
    
    /* Button Styles */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 83, 255, 0.4);
        color: white;
    }

    .btn-light {
        background-color: #F1F5F9;
        border: none;
        color: #475569;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        background-color: #E2E8F0;
        transform: translateY(-2px);
        color: #334155;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        h3.mb-3 {
            font-size: 24px;
        }
        .text-muted {
            margin-left: 0;
            margin-bottom: 20px;
        }
    }
</style>

<div class="container-fluid mt-4">

    <!-- JUDUL -->
    <h3 class="fw-bold mb-3">Edit Rombel</h3>
    <p class="text-muted mb-4">
        Perbarui data rombel yang ada.
    </p>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <form action="{{ route('tu.kelas.update', $rombel->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <!-- Tingkat -->
                    <div class="col-md-6 mb-3">
                        <label for="tingkat" class="form-label">Tingkat</label>
                        <select name="tingkat" id="tingkat" class="form-select" required>
                            <option value="">Pilih Tingkat</option>
                            @foreach($tingkats as $t)
                                <option value="{{ $t }}" {{ $t == $rombel->kelas->tingkat ? 'selected' : '' }}>
                                    Kelas {{ $t }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Konsentrasi Keahlian -->
                    <div class="col-md-6 mb-3">
                        <label for="jurusan_id" class="form-label">Konsentrasi Keahlian</label>
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

                <div class="row mb-4">
                    <!-- Nama Rombel -->
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama Rombel</label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh: RPL 1, TKJ 2"
                            value="{{ old('nama', $rombel->nama) }}" required>
                    </div>

                    <!-- Wali Kelas -->
                    <div class="col-md-6 mb-3">
                        <label for="guru_id" class="form-label">Wali Kelas</label>
                        <select name="guru_id" id="guru_id" class="form-select" required>
                            <option value="">Pilih Wali Kelas</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ $guru->id == $rombel->guru_id ? 'selected' : '' }}>
                                    {{ $guru->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <a href="{{ route('tu.kelas.index') }}" class="btn btn-light">
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