@extends('layouts.app')

@section('title', 'Tambah Data Mutasi')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    .card-custom {
        border: none;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.06);
    }
    .form-label-custom {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        margin-bottom: 6px;
    }
    .form-control-custom {
        padding: 12px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        background: #f8fafc;
        transition: all 0.2s ease;
        outline: none;
    }
    .form-control-custom:focus {
        background: #ffffff;
        border-color: #4F46E5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
    }
    .btn-premium {
        padding: 10px 22px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-premium-primary {
        background: #4F46E5;
        color: #fff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }
    .btn-premium-primary:hover {
        background: #4338CA;
        transform: translateY(-2px);
        color: #fff;
    }
    .btn-premium-outline {
        background: transparent;
        color: #475569;
        border: 1.5px solid #E2E8F0;
    }
    .btn-premium-outline:hover {
        background: #F1F5F9;
        border-color: #94A3B8;
    }
</style>

<div class="container-fluid px-4 mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1"><i class="fas fa-plus-circle text-primary me-2"></i> Tambah Data Mutasi</h4>
                    <p class="text-muted small mb-0">Catat mutasi guru atau pegawai baru.</p>
                </div>
                <a href="{{ route('tu_kepegawaian.mutasi.index') }}" class="btn btn-outline-secondary btn-sm px-4 rounded-pill shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Card Form -->
            <div class="card card-custom">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('tu_kepegawaian.mutasi.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label-custom"><i class="fas fa-user me-1 text-primary"></i> Pilih Guru / Pegawai <span class="text-danger">*</span></label>
                                    <select name="entitas_id" class="form-select form-control-custom" required>
                                        <option value="">-- Pilih --</option>
                                        <optgroup label="Data Guru">
                                            @foreach($gurus as $g)
                                                <option value="guru-{{ $g->id }}" {{ old('entitas_id') == 'guru-'.$g->id ? 'selected' : '' }}>
                                                    {{ $g->nama }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Data Pegawai">
                                            @foreach($pegawais as $p)
                                                <option value="pegawai-{{ $p->id }}" {{ old('entitas_id') == 'pegawai-'.$p->id ? 'selected' : '' }}>
                                                    {{ $p->nama }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    <div class="form-text text-muted small">Pilih guru atau pegawai yang akan dicatat mutasinya.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label-custom"><i class="fas fa-exchange-alt me-1 text-primary"></i> Jenis Mutasi <span class="text-danger">*</span></label>
                                    <select name="jenis_mutasi" class="form-select form-control-custom" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach(['Masuk', 'Keluar', 'Pindah Tugas', 'Pensiun', 'Wafat', 'Diberhentikan', 'Alih Tugas'] as $opsi)
                                            <option value="{{ $opsi }}" {{ old('jenis_mutasi') == $opsi ? 'selected' : '' }}>
                                                {{ $opsi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-4">
                                    <label class="form-label-custom"><i class="fas fa-calendar-alt me-1 text-primary"></i> Tanggal Mutasi <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal" class="form-control form-control-custom" value="{{ old('tanggal') }}" required>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="d-flex flex-wrap gap-2 justify-content-end border-top pt-4">
                                    <a href="{{ route('tu_kepegawaian.mutasi.index') }}" class="btn-premium btn-premium-outline">
                                        Batal
                                    </a>
                                    <button type="submit" class="btn-premium btn-premium-primary">
                                        <i class="fas fa-save me-2"></i> Simpan Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection