@extends('layouts.app')

@section('title', 'Tambah Tugas Tambahan')

@section('content')
<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="mb-4">
        <a href="{{ route('tu_kepegawaian.tugas_tambahan.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <h3 class="mt-3 mb-0">Tambah Tugas Tambahan</h3>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tu_kepegawaian.tugas_tambahan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="guru_id" class="form-label">Nama Guru <span class="text-danger">*</span></label>
                    <div class="row g-2">
                        <div class="col-md-8">
                            <select name="guru_id" id="guru_id" class="form-select @error('guru_id') is-invalid @enderror" required onchange="autoFillTipeFromRole()">
                                <option value="">Pilih Guru...</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}" data-role="{{ $guru->user?->role ?? '' }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->nama }} ({{ $guru->nip ?? 'Tanpa NIP' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="guru_role" class="form-control" placeholder="Role" disabled readonly>
                            <small class="text-muted">Role otomatis terisi dari data guru</small>
                        </div>
                    </div>
                    @error('guru_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tipe_tugas" class="form-label">Tipe Tugas Tambahan</label>
                    <select name="tipe_tugas" id="tipe_tugas" class="form-select @error('tipe_tugas') is-invalid @enderror">
                        <option value="">Otomatis dari Role (Recommended)</option>
                        @foreach($tipeOptions as $key => $label)
                            <option value="{{ $key }}" {{ old('tipe_tugas') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Kosongkan untuk otomatis menggunakan role guru. Atau pilih manual jika perlu override.</small>
                    @error('tipe_tugas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror" 
                           placeholder="Contoh: 2025/2026" value="{{ old('tahun_ajaran') }}">
                    <small class="text-muted">Opsional. Untuk tracking tahun ajaran aktif</small>
                    @error('tahun_ajaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Tugas Tambahan
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

@section('scripts')
<script>
function autoFillTipeFromRole() {
    const guruSelect = document.getElementById('guru_id');
    const selectedOption = guruSelect.options[guruSelect.selectedIndex];
    const role = selectedOption.getAttribute('data-role');
    const roleInput = document.getElementById('guru_role');
    const tipeSelect = document.getElementById('tipe_tugas');
    
    if (role) {
        roleInput.value = role;
        // Don't override manual selection, just show what role is
        if (!tipeSelect.value) {
            // Auto-fill adalah optional, user bisa override
            console.log('Guru role: ' + role);
        }
    } else {
        roleInput.value = '-';
    }
}

// Run on page load if guru already selected
document.addEventListener('DOMContentLoaded', function() {
    autoFillTipeFromRole();
});
</script>
@endsection
