@extends('layouts.app')

@section('title', 'Tambah Ruang Kelas')

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
                <h3><i class="fas fa-plus-circle me-2"></i> Tambah Ruang Kelas</h3>
                <div class="text-muted">Tambahkan data ruang kelas baru</div>
            </div>
            <div class="mt-2 mt-sm-0">
                <a href="{{ route('kurikulum.ruang-kelas.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card form-card">
        <div class="card-body">
            <form action="{{ route('kurikulum.ruang-kelas.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kode_ruang" class="form-label">Kode Ruang <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('kode_ruang') is-invalid @enderror"
                               id="kode_ruang"
                               name="kode_ruang"
                               placeholder="Contoh: R-101"
                               value="{{ old('kode_ruang') }}">
                        @error('kode_ruang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="text-muted-small">Kode unik untuk ruang kelas</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_ruang" class="form-label">Nama Ruang <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('nama_ruang') is-invalid @enderror"
                               id="nama_ruang"
                               name="nama_ruang"
                               placeholder="Contoh: Ruang Kelas 1A"
                               value="{{ old('nama_ruang') }}">
                        @error('nama_ruang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="gedung" class="form-label">Gedung</label>
                        <input type="text"
                               class="form-control @error('gedung') is-invalid @enderror"
                               id="gedung"
                               name="gedung"
                               placeholder="Contoh: A, B, C"
                               value="{{ old('gedung') }}">
                        @error('gedung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="lantai" class="form-label">Lantai</label>
                        <input type="text"
                               class="form-control @error('lantai') is-invalid @enderror"
                               id="lantai"
                               name="lantai"
                               placeholder="Contoh: 1, 2, 3"
                               value="{{ old('lantai') }}">
                        @error('lantai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="kapasitas" class="form-label">Kapasitas <span class="text-danger">*</span></label>
                        <input type="number"
                               class="form-control @error('kapasitas') is-invalid @enderror"
                               id="kapasitas"
                               name="kapasitas"
                               placeholder="Jumlah siswa"
                               value="{{ old('kapasitas', 30) }}">
                        @error('kapasitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jenis_ruang" class="form-label">Jenis Ruang <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_ruang') is-invalid @enderror" id="jenis_ruang" name="jenis_ruang">
                            <option value="kelas" {{ old('jenis_ruang') == 'kelas' ? 'selected' : '' }}>Kelas</option>
                            <option value="laboratorium" {{ old('jenis_ruang') == 'laboratorium' ? 'selected' : '' }}>Laboratorium</option>
                            <option value="workshop" {{ old('jenis_ruang') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                            <option value="ruang_guru" {{ old('jenis_ruang') == 'ruang_guru' ? 'selected' : '' }}>Ruang Guru</option>
                            <option value="ruang_rapat" {{ old('jenis_ruang') == 'ruang_rapat' ? 'selected' : '' }}>Ruang Rapat</option>
                            <option value="ruang_kepala" {{ old('jenis_ruang') == 'ruang_kepala' ? 'selected' : '' }}>Ruang Kepala Sekolah</option>
                            <option value="ruang_tu" {{ old('jenis_ruang') == 'ruang_tu' ? 'selected' : '' }}>Ruang TU</option>
                            <option value="perpustakaan" {{ old('jenis_ruang') == 'perpustakaan' ? 'selected' : '' }}>Perpustakaan</option>
                            <option value="lainnya" {{ old('jenis_ruang') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis_ruang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="is_active" class="form-label">Status Aktif</label>
                        <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="fasilitas" class="form-label">Fasilitas</label>
                    <textarea class="form-control @error('fasilitas') is-invalid @enderror"
                              id="fasilitas"
                              name="fasilitas"
                              rows="2"
                              placeholder="Contoh: AC, Proyektor, Whiteboard, Kursi 30">{{ old('fasilitas') }}</textarea>
                    @error('fasilitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                              id="keterangan"
                              name="keterangan"
                              rows="2"
                              placeholder="Masukkan keterangan (opsional)">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn-gradient">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('kurikulum.ruang-kelas.index') }}" class="btn-secondary-custom">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection