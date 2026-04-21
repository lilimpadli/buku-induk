@extends('layouts.app')

@section('title', 'Edit Tugas Tambahan')

@section('content')
<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="mb-4">
        <a href="{{ route('tu_kepegawaian.tugas_tambahan.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <h3 class="mt-3 mb-0">Edit Tugas Tambahan</h3>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tu_kepegawaian.tugas_tambahan.update', $tugasTambahan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="guru_id" class="form-label">Nama Guru <span class="text-danger">*</span></label>
                    <select name="guru_id" id="guru_id" class="form-select @error('guru_id') is-invalid @enderror" required>
                        <option value="">Pilih Guru...</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ old('guru_id', $tugasTambahan->guru_id) == $guru->id ? 'selected' : '' }}>
                                {{ $guru->nama }} ({{ $guru->nip ?? 'Tanpa NIP' }})
                            </option>
                        @endforeach
                    </select>
                    @error('guru_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tipe_tugas" class="form-label">Tipe Tugas Tambahan <span class="text-danger">*</span></label>
                    <select name="tipe_tugas" id="tipe_tugas" class="form-select @error('tipe_tugas') is-invalid @enderror" required>
                        <option value="">Pilih Tipe Tugas...</option>
                        @foreach($tipeOptions as $key => $label)
                            <option value="{{ $key }}" {{ old('tipe_tugas', $tugasTambahan->tipe_tugas) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('tipe_tugas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror" 
                           placeholder="Contoh: 2025/2026" value="{{ old('tahun_ajaran', $tugasTambahan->tahun_ajaran) }}">
                    <small class="text-muted">Opsional. Untuk tracking tahun ajaran aktif</small>
                    @error('tahun_ajaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Perbarui Tugas Tambahan
                    </button>
                    <a href="{{ route('tu_kepegawaian.tugas_tambahan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
