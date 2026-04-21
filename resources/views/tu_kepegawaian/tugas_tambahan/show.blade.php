@extends('layouts.app')

@section('title', 'Detail Tugas Tambahan')

@section('content')
<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="mb-4">
        <a href="{{ route('tu_kepegawaian.tugas_tambahan.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <h3 class="mt-3 mb-0">Detail Tugas Tambahan</h3>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Tugas Tambahan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Nama Guru</label>
                        </div>
                        <div class="col-md-8">
                            <p>{{ $tugasTambahan->guru->nama ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">User</label>
                        </div>
                        <div class="col-md-8">
                            <p>{{ $tugasTambahan->guru->user?->name ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">NIP</label>
                        </div>
                        <div class="col-md-8">
                            <p>{{ $tugasTambahan->guru->nip ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Tipe Tugas Tambahan</label>
                        </div>
                        <div class="col-md-8">
                            <p>
                                <span class="badge bg-info">{{ \App\Models\TugasTambahan::getTipeLabel($tugasTambahan->tipe_tugas) }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Tahun Ajaran</label>
                        </div>
                        <div class="col-md-8">
                            <p>{{ $tugasTambahan->tahun_ajaran ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Dibuat Pada</label>
                        </div>
                        <div class="col-md-8">
                            <p>{{ $tugasTambahan->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Diubah Pada</label>
                        </div>
                        <div class="col-md-8">
                            <p>{{ $tugasTambahan->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('tu_kepegawaian.tugas_tambahan.edit', $tugasTambahan->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <form action="{{ route('tu_kepegawaian.tugas_tambahan.destroy', $tugasTambahan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tugas tambahan ini? Tindakan ini tidak dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Guru</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Nama Lengkap:</strong><br>
                        {{ $tugasTambahan->guru->nama ?? '-' }}
                    </p>
                    <p class="mb-2">
                        <strong>Email:</strong><br>
                        {{ $tugasTambahan->guru->email ?? '-' }}
                    </p>
                    <p class="mb-2">
                        <strong>Jurusan:</strong><br>
                        {{ optional($tugasTambahan->guru->jurusan)->nama ?? '-' }}
                    </p>
                    <p class="mb-0">
                        <strong>Tempat Lahir:</strong><br>
                        {{ $tugasTambahan->guru->tempat_lahir ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
