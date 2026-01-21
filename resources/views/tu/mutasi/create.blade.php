@extends('layouts.app')

@section('title', 'Tambah Mutasi Siswa')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-plus-circle text-primary"></i> Tambah Data Mutasi Siswa
            </h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tu.mutasi.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="row mb-4">
                    <!-- Pilih Siswa -->
                    <div class="col-md-6">
                        <label for="siswa_id" class="form-label">
                            <i class="fas fa-user"></i> Siswa <span class="text-danger">*</span>
                        </label>
                        <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                    {{ $siswa->nis }} - {{ $siswa->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Mutasi -->
                    <div class="col-md-6">
                        <label for="status" class="form-label">
                            <i class="fas fa-exchange-alt"></i> Status Mutasi <span class="text-danger">*</span>
                        </label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required onchange="updateStatusFields()">
                            <option value="">-- Pilih Status --</option>
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <!-- Tanggal Mutasi -->
                    <div class="col-md-6">
                        <label for="tanggal_mutasi" class="form-label">
                            <i class="fas fa-calendar-alt"></i> Tanggal Mutasi <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_mutasi" id="tanggal_mutasi" 
                            class="form-control @error('tanggal_mutasi') is-invalid @enderror" 
                            value="{{ old('tanggal_mutasi', now()->format('Y-m-d')) }}" required>
                        @error('tanggal_mutasi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="col-md-6">
                        <label for="keterangan" class="form-label">
                            <i class="fas fa-comment"></i> Keterangan
                        </label>
                        <textarea name="keterangan" id="keterangan" rows="1" 
                            class="form-control @error('keterangan') is-invalid @enderror"
                            placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Fields Dinamis untuk Status PINDAH -->
                <div id="pindahFields" style="display: none;">
                    <h5 class="mb-3">
                        <i class="fas fa-arrow-right text-info"></i> Data Pindah Sekolah
                    </h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="alasan_pindah" class="form-label">Alasan Pindah</label>
                            <input type="text" name="alasan_pindah" id="alasan_pindah" 
                                class="form-control @error('alasan_pindah') is-invalid @enderror"
                                value="{{ old('alasan_pindah') }}" placeholder="Contoh: Pindah ke kota lain">
                            @error('alasan_pindah')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tujuan_pindah" class="form-label">Sekolah Tujuan</label>
                            <input type="text" name="tujuan_pindah" id="tujuan_pindah" 
                                class="form-control @error('tujuan_pindah') is-invalid @enderror"
                                value="{{ old('tujuan_pindah') }}" placeholder="Nama sekolah tujuan">
                            @error('tujuan_pindah')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Fields Dinamis untuk Surat Keputusan -->
                <div id="skFields" style="display: none;">
                    <h5 class="mb-3">
                        <i class="fas fa-file-contract text-warning"></i> Surat Keputusan Keluar
                    </h5>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="no_sk_keluar" class="form-label">Nomor SK Keluar</label>
                            <input type="text" name="no_sk_keluar" id="no_sk_keluar" 
                                class="form-control @error('no_sk_keluar') is-invalid @enderror"
                                value="{{ old('no_sk_keluar') }}" placeholder="Contoh: 001/SK/2026">
                            @error('no_sk_keluar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_sk_keluar" class="form-label">Tanggal SK Keluar</label>
                            <input type="date" name="tanggal_sk_keluar" id="tanggal_sk_keluar" 
                                class="form-control @error('tanggal_sk_keluar') is-invalid @enderror"
                                value="{{ old('tanggal_sk_keluar') }}">
                            @error('tanggal_sk_keluar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="row mt-5">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Mutasi
                        </button>
                        <a href="{{ route('tu.mutasi.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateStatusFields() {
        const status = document.getElementById('status').value;
        const pindahFields = document.getElementById('pindahFields');
        const skFields = document.getElementById('skFields');

        // Reset tampilan
        pindahFields.style.display = 'none';
        skFields.style.display = 'none';

        // Tampilkan field sesuai status
        if (status === 'pindah') {
            pindahFields.style.display = 'block';
            skFields.style.display = 'block';
        } else if (['do', 'meninggal'].includes(status)) {
            skFields.style.display = 'block';
        }
    }

    // Jalankan saat halaman dimuat jika ada nilai yang dipilih
    document.addEventListener('DOMContentLoaded', function() {
        updateStatusFields();
        
        // Inisialisasi form validation
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
</script>
@endpush
@endsection
