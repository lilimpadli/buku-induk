@extends('layouts.app')

@section('title', 'Edit KKM')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --warning-gradient: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
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
        background: var(--warning-gradient);
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

    .info-field {
        background: #F8FAFC;
        padding: 10px 15px;
        border-radius: 10px;
        border-left: 4px solid #667eea;
        word-break: break-word;
    }

    .btn-update {
        background: var(--warning-gradient);
        border: none;
        padding: 8px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.5);
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

    .form-control {
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: #F59E0B;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    @media (max-width: 768px) {
        .btn-update, .btn-cancel {
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
            <h5><i class="fas fa-edit me-2"></i> Edit KKM</h5>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kurikulum.kkm.update', $kkm->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-book text-primary me-1"></i> Mata Pelajaran
                        </label>
                        <div class="info-field">
                            <i class="fas fa-graduation-cap me-2 text-muted"></i>
                            {{ $kkm->mataPelajaran->nama ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-school text-primary me-1"></i> Kelas
                        </label>
                        <div class="info-field">
                            <i class="fas fa-users me-2 text-muted"></i>
                            @php
                                $rombel = $kkm->kelas->rombels->first();
                            @endphp
                            {{ $rombel->nama ?? 'Kelas ID: ' . $kkm->kelas_id }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-calendar-alt text-primary me-1"></i> Tahun Ajaran
                        </label>
                        <div class="info-field">
                            <i class="fas fa-calendar me-2 text-muted"></i>
                            {{ $kkm->tahunAjaran->tahun ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nilai_kkm" class="form-label fw-semibold">
                            <i class="fas fa-percent text-primary me-1"></i> Nilai KKM <span class="text-danger">*</span>
                        </label>
                        <input type="number" step="0.01" name="nilai_kkm" id="nilai_kkm" class="form-control @error('nilai_kkm') is-invalid @enderror" value="{{ old('nilai_kkm', $kkm->nilai_kkm) }}" required>
                        <small class="text-muted">Minimal 0, maksimal 100</small>
                        @error('nilai_kkm')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 pt-2 border-top">
                    <button type="submit" class="btn btn-update text-white">
                        <i class="fas fa-save me-2"></i> Update
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