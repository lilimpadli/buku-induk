{{-- resources/views/kurikulum/tahun_ajaran/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Tahun Ajaran')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

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
        margin-bottom: 0.25rem;
        font-size: 1.3rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 8px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-secondary-custom {
        background: #E2E8F0;
        border: none;
        color: #475569;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary-custom:hover {
        background: #CBD5E1;
        color: #1E293B;
    }

    .form-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }

    .form-card .card-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #334155;
        margin-bottom: 0.3rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        padding: 0.5rem 0.8rem;
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #EF4444;
    }

    .invalid-feedback {
        font-size: 0.75rem;
        color: #EF4444;
    }

    .text-muted-small {
        font-size: 0.7rem;
        color: #94A3B8;
        margin-top: 0.2rem;
    }

    .badge-current-info {
        background: #DBEAFE;
        color: #1E40AF;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1rem;
        }
        .page-header h3 {
            font-size: 1.05rem;
        }
        .form-card .card-body {
            padding: 1rem;
        }
        .btn-gradient, .btn-secondary-custom {
            width: 100%;
            justify-content: center;
        }
        .d-flex.gap-2 {
            flex-direction: column;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-edit me-2"></i> Edit Tahun Ajaran</h3>
                <div class="text-muted">Perbarui data tahun ajaran</div>
            </div>
            <div class="mt-2 mt-sm-0">
                <a href="{{ route('kurikulum.tahun-ajaran.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card form-card">
        <div class="card-body">
            <div class="mb-3">
                <span class="badge-current-info">
                    <i class="fas fa-info-circle me-1"></i> 
                    @if($tahunAjaran->is_current)
                        Tahun ini sedang berjalan
                    @else
                        Tahun ini tidak sedang berjalan
                    @endif
                </span>
            </div>

            <form action="{{ route('kurikulum.tahun-ajaran.update', $tahunAjaran->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tahun" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('tahun') is-invalid @enderror"
                               id="tahun"
                               name="tahun"
                               placeholder="Contoh: 2024/2025"
                               value="{{ old('tahun', $tahunAjaran->tahun) }}">
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="text-muted-small">Format: YYYY/YYYY (contoh: 2024/2025)</div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date"
                               class="form-control @error('tanggal_mulai') is-invalid @enderror"
                               id="tanggal_mulai"
                               name="tanggal_mulai"
                               value="{{ old('tanggal_mulai', $tahunAjaran->tanggal_mulai) }}">
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date"
                               class="form-control @error('tanggal_selesai') is-invalid @enderror"
                               id="tanggal_selesai"
                               name="tanggal_selesai"
                               value="{{ old('tanggal_selesai', $tahunAjaran->tanggal_selesai) }}">
                        @error('tanggal_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="is_active" class="form-label">Status Aktif</label>
                        <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                            <option value="0" {{ old('is_active', $tahunAjaran->is_active) == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="1" {{ old('is_active', $tahunAjaran->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="is_current" class="form-label">Tahun Ajaran Berjalan</label>
                        <select class="form-select @error('is_current') is-invalid @enderror" id="is_current" name="is_current">
                            <option value="0" {{ old('is_current', $tahunAjaran->is_current) == '0' ? 'selected' : '' }}>Tidak</option>
                            <option value="1" {{ old('is_current', $tahunAjaran->is_current) == '1' ? 'selected' : '' }}>Ya</option>
                        </select>
                        @error('is_current')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="text-muted-small">Hanya satu tahun ajaran yang bisa menjadi tahun berjalan</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                              id="keterangan"
                              name="keterangan"
                              rows="2"
                              placeholder="Masukkan keterangan (opsional)">{{ old('keterangan', $tahunAjaran->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn-gradient">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="{{ route('kurikulum.tahun-ajaran.index') }}" class="btn-secondary-custom">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        let alert = document.querySelector('.alert');
        if(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() { alert.remove(); }, 500);
        }
    }, 3000);
</script>
@endsection