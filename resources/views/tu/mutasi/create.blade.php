@extends('layouts.app')

@section('title', 'Tambah Mutasi Siswa')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        height: auto;
        padding: 0.375rem 0.75rem;
    }
    
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
@endpush

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
                    <!-- Pilih Kelas -->
                    <div class="col-md-6">
                        <label for="filter_kelas" class="form-label">
                            <i class="fas fa-chalkboard"></i> Kelas
                        </label>
                        <select id="filter_kelas" class="form-select">
                            <option value="">-- Tampilkan Semua Kelas --</option>
                            @foreach($classes as $kelas)
                                <option value="{{ $kelas->id }}">
                                    {{ $kelas->tingkat }} {{ $kelas->jurusan->nama ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih kelas untuk menampilkan siswa terkait.</small>
                    </div>

                    <!-- Pilih Siswa -->
                    <div class="col-md-6">
                        <label for="siswa_id" class="form-label">
                            <i class="fas fa-user"></i> Siswa <span class="text-danger">*</span>
                        </label>
                        <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}"
                                    data-kelas-id="{{ optional(optional($siswa->rombel)->kelas)->id ?? '' }}"
                                    data-kelas-name="{{ trim((optional(optional($siswa->rombel)->kelas)->tingkat ?? '') . ' ' . (optional(optional($siswa->rombel)->kelas)->jurusan->nama ?? '')) }}"
                                    data-rombel-name="{{ $siswa->rombel->nama ?? '' }}"
                                    {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                    {{ $siswa->nis }} - {{ $siswa->nama_lengkap }}
                                    @if($siswa->rombel)
                                        ({{ $siswa->rombel->nama }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="alert alert-light border" id="studentClassInfo" style="display: none;">
                            <strong>Kelas Saat Ini:</strong>
                            <span id="currentKelasText">-</span>
                            <br>
                            <strong>Rombel:</strong>
                            <span id="currentRombelText">-</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

    function updateStudentClassInfo() {
        const siswaSelect = document.getElementById('siswa_id');
        const selectedOption = siswaSelect.options[siswaSelect.selectedIndex];
        const infoBox = document.getElementById('studentClassInfo');
        const currentKelasText = document.getElementById('currentKelasText');
        const currentRombelText = document.getElementById('currentRombelText');

        if (selectedOption && selectedOption.value) {
            currentKelasText.textContent = selectedOption.dataset.kelasName || '-';
            currentRombelText.textContent = selectedOption.dataset.rombelName || '-';
            infoBox.style.display = 'block';
        } else {
            currentKelasText.textContent = '-';
            currentRombelText.textContent = '-';
            infoBox.style.display = 'none';
        }
    }

    function filterStudentsByClass() {
        const kelasId = document.getElementById('filter_kelas').value;
        const siswaSelect = document.getElementById('siswa_id');
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = '-- Pilih Siswa --';

        siswaSelect.innerHTML = '';
        siswaSelect.appendChild(placeholder);

        allStudentOptions.forEach(item => {
            if (!kelasId || item.kelasId === kelasId) {
                const option = document.createElement('option');
                option.value = item.value;
                option.textContent = item.text;
                option.dataset.kelasId = item.kelasId;
                option.dataset.kelasName = item.kelasName;
                option.dataset.rombelName = item.rombelName;
                if (item.value === selectedSiswaId) {
                    option.selected = true;
                }
                siswaSelect.appendChild(option);
            }
        });

        siswaSelect.value = selectedSiswaId || '';
        $('#siswa_id').trigger('change.select2');
        updateStudentClassInfo();
    }

    let allStudentOptions = [];
    let selectedSiswaId = '';

    document.addEventListener('DOMContentLoaded', function() {
        const siswaSelect = document.getElementById('siswa_id');
        const kelasFilter = document.getElementById('filter_kelas');

        allStudentOptions = Array.from(siswaSelect.options).map(option => ({
            value: option.value,
            text: option.textContent,
            kelasId: option.dataset.kelasId || '',
            kelasName: option.dataset.kelasName || '',
            rombelName: option.dataset.rombelName || ''
        }));

        selectedSiswaId = siswaSelect.value;

        $('#siswa_id').select2({
            placeholder: '-- Pilih atau Ketik Nama Siswa --',
            allowClear: true,
            width: '100%'
        });

        kelasFilter.addEventListener('change', () => {
            selectedSiswaId = siswaSelect.value;
            filterStudentsByClass();
        });

        $('#siswa_id').on('change', function() {
            selectedSiswaId = this.value;
            updateStudentClassInfo();
        });

        updateStatusFields();
        updateStudentClassInfo();
        
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
