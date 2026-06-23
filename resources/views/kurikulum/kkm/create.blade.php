@extends('layouts.app')

@section('title', 'Tambah KKM')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        box-sizing: border-box;
    }

    .container-fluid {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        padding: 0 20px;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 0 12px;
        }
    }

    .form-card {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--card-shadow);
        border: none;
        width: 100%;
    }

    .form-card .card-header {
        background: var(--primary-gradient);
        padding: 1rem 1.5rem;
        color: white;
    }

    .form-card .card-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: clamp(1rem, 4vw, 1.2rem);
    }

    .form-card .card-body {
        padding: 2rem;
    }

    @media (max-width: 768px) {
        .form-card .card-body {
            padding: 1.2rem;
        }
    }

    .btn-save {
        background: var(--success-gradient);
        border: none;
        padding: 8px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(19, 180, 151, 0.5);
        color: white;
    }

    .btn-cancel {
        background: #64748B;
        border: none;
        padding: 8px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-cancel:hover {
        background: #475569;
        transform: translateY(-2px);
        color: white;
    }

    .form-label {
        font-size: 0.85rem;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        transition: var(--transition);
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    @media (max-width: 768px) {
        .btn-save, .btn-cancel {
            width: 100%;
            margin-bottom: 8px;
        }
        
        .border-top {
            text-align: center;
        }
        
        .form-label {
            font-size: 0.8rem;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="card form-card">
        <div class="card-header">
            <h5><i class="fas fa-plus-circle me-2"></i> Tambah KKM Baru</h5>
        </div>
        <div class="card-body">
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {!! session('warning') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kurikulum.kkm.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="mata_pelajaran_id" class="form-label fw-semibold">
                            <i class="fas fa-book text-primary me-1"></i> Mata Pelajaran <span class="text-danger">*</span>
                        </label>
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-select @error('mata_pelajaran_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mataPelajarans as $mapel)
                                <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kelas_id" class="form-label fw-semibold">
                            <i class="fas fa-school text-primary me-1"></i> Kelas <span class="text-danger">*</span>
                        </label>
                        <select name="kelas_id" id="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($rombels as $rombel)
                                <option value="{{ $rombel->kelas_id }}" {{ old('kelas_id') == $rombel->kelas_id ? 'selected' : '' }}>
                                    {{ $rombel->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tahun_ajaran_id" class="form-label fw-semibold">
                            <i class="fas fa-calendar-alt text-primary me-1"></i> Tahun Ajaran <span class="text-danger">*</span>
                        </label>
                        <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select @error('tahun_ajaran_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach($tahunAjarans as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nilai_kkm" class="form-label fw-semibold">
                            <i class="fas fa-percent text-primary me-1"></i> Nilai KKM <span class="text-danger">*</span>
                        </label>
                        <input type="number" step="0.01" name="nilai_kkm" id="nilai_kkm" class="form-control @error('nilai_kkm') is-invalid @enderror" value="{{ old('nilai_kkm', 75) }}" required>
                        <small class="text-muted">Minimal 0, maksimal 100</small>
                        @error('nilai_kkm')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 pt-2 border-top">
                    <button type="submit" class="btn btn-save text-white">
                        <i class="fas fa-save me-2"></i> Simpan
                    </button>
                    <a href="{{ route('kurikulum.kkm.index') }}" class="btn btn-cancel text-white">
                        <i class="fas fa-arrow-left me-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection