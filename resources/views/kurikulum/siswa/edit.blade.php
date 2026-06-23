@extends('layouts.app')

@section('title', 'Ubah Password Siswa')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --warning-gradient: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    main {
        padding: 20px 15px !important;
        overflow-x: auto !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 10px !important;
        overflow-x: auto !important;
    }

    .page-header {
        background: var(--warning-gradient);
        color: white;
        padding: 1.5rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
        width: 100%;
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
        font-weight: 600;
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    .form-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        width: 100%;
    }

    .form-card .card-header {
        background: white;
        border-bottom: 1px solid #E2E8F0;
        padding: 0.8rem 1.5rem;
    }

    .form-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 1rem;
    }

    .form-card .card-header h5 i {
        color: #F59E0B;
        margin-right: 6px;
    }

    .form-card .card-body {
        padding: 1.5rem;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #1E293B;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        padding: 0.5rem 0.9rem;
        transition: var(--transition);
        font-size: 0.9rem;
    }

    .form-control:focus {
        border-color: #F59E0B;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .btn-update {
        background: var(--warning-gradient);
        border: none;
        padding: 0.5rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        color: white;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.5);
        color: white;
    }

    .btn-cancel {
        background: #64748B;
        border: none;
        padding: 0.5rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        color: white;
    }

    .btn-cancel:hover {
        background: #475569;
        transform: translateY(-2px);
        color: white;
    }

    .info-box {
        background: #F8FAFC;
        border-radius: 10px;
        padding: 1rem 1.2rem;
        border-left: 4px solid #667eea;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1rem;
        }
        .page-header h3 {
            font-size: 1.1rem;
        }
        .page-header .text-muted {
            font-size: 0.75rem;
        }

        .form-card .card-body {
            padding: 1rem;
        }

        .btn-update,
        .btn-cancel {
            width: 100%;
            margin-bottom: 8px;
            justify-content: center;
        }

        .border-top {
            text-align: center;
        }

        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .col-md-6 {
            padding-left: 8px;
            padding-right: 8px;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-key me-2"></i> Ubah Password Siswa</h3>
                <div class="text-muted">{{ $siswa->nama_lengkap }}</div>
            </div>
            <div>
                <a href="{{ route('kurikulum.siswa.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card form-card">
        <div class="card-header">
            <h5><i class="fas fa-pen"></i> Form Ubah Password</h5>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="info-box mb-4">
                <i class="fas fa-info-circle text-primary me-2"></i>
                <strong>NIS:</strong> {{ $siswa->nis }} &nbsp;|&nbsp;
                <strong>Nama:</strong> {{ $siswa->nama_lengkap }}
            </div>

            <form action="{{ route('kurikulum.siswa.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-lock text-primary me-1"></i> Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                        <small class="text-muted">Minimal 6 karakter</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-check-circle text-primary me-1"></i> Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-update">
                        <i class="fas fa-save me-2"></i> Simpan
                    </button>
                    <a href="{{ route('kurikulum.siswa.index') }}" class="btn btn-cancel">
                        <i class="fas fa-arrow-left me-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection