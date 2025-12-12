@extends('layouts.app')

@section('title', 'Tambah Data Diri Siswa')

@section('content')
<div class="container mt-3">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-9">
            <h3 class="mb-4">Tambah Data Diri</h3>

            <div class="card shadow">
                <div class="card-body">
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar" id="progressBar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2 small text-muted">
                            <span class="step-label active" id="step1Label"><i class="fas fa-user me-1"></i>Langkah 1: Data Siswa</span>
                            <span class="step-label" id="step2Label"><i class="fas fa-users me-1"></i>Langkah 2: Data Orang Tua</span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('siswa.dataDiri.store') }}" enctype="multipart/form-data" id="multiStepForm">
                        @csrf
                        <input type="hidden" name="step" id="stepInput" value="1">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <!-- ========== STEP 1: DATA SISWA ========== -->
                        <div id="step1" class="step-form">
                            <h5 class="mb-3 fw-semibold">Identitas Siswa</h5>
                            <div class="row g-3">
                                <!-- Nama Lengkap, NIS, NISN -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" class="form-control step1-field" value="{{ old('nama_lengkap') }}" required>
                                    @error('nama_lengkap')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">NIS</label>
                                    <input type="text" value="{{ auth()->user()->nomor_induk }}" class="form-control" disabled>
                                    <input type="hidden" name="nis" value="{{ auth()->user()->nomor_induk }}">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">NISN <span class="text-danger">*</span></label>
                                    <input type="text" name="nisn" class="form-control step1-field" value="{{ old('nisn') }}" required>
                                    @error('nisn')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <!-- TTL dan Jenis Kelamin -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" class="form-control step1-field" value="{{ old('tempat_lahir') }}" required>
                                    @error('tempat_lahir')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control step1-field" value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-select step1-field" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <!-- Agama, Status Keluarga, Anak Ke -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Agama <span class="text-danger">*</span></label>
                                    <input type="text" name="agama" class="form-control step1-field" value="{{ old('agama') }}" required>
                                    @error('agama')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Status Keluarga <span class="text-danger">*</span></label>
                                    <input type="text" name="status_keluarga" class="form-control step1-field" placeholder="Contoh: Anak Kandung" value="{{ old('status_keluarga') }}" required>
                                    @error('status_keluarga')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Anak ke <span class="text-danger">*</span></label>
                                    <input type="number" name="anak_ke" class="form-control step1-field" value="{{ old('anak_ke') }}" required>
                                    @error('anak_ke')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <!-- Alamat, No HP -->
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control step1-field" rows="3" required>{{ old('alamat') }}</textarea>
                                    @error('alamat')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">No HP <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp" class="form-control step1-field" value="{{ old('no_hp') }}" required>
                                    @error('no_hp')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <!-- Sekolah Asal, Kelas, Tanggal Diterima -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Sekolah Asal <span class="text-danger">*</span></label>
                                    <input type="text" name="sekolah_asal" class="form-control step1-field" value="{{ old('sekolah_asal') }}" required>
                                    @error('sekolah_asal')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                                    <input type="text" name="kelas" class="form-control step1-field" placeholder="Contoh: XI MM 1" value="{{ old('kelas') }}" required>
                                    @error('kelas')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Tanggal Diterima <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_diterima" class="form-control step1-field" value="{{ old('tanggal_diterima') }}" required>
                                    @error('tanggal_diterima')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <!-- Foto -->
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Foto Siswa</label>
                                    <input type="file" name="foto" class="form-control" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG | Max: 2MB</small>
                                </div>
                            </div>
                        </div>

                        <!-- ========== STEP 2: DATA ORANG TUA / WALI ========== -->
                        <div id="step2" class="step-form" style="display: none;">
                            <h5 class="mb-3 fw-semibold">Data Orang Tua & Wali</h5>
                            <div class="row g-3">
                                <!-- Data Ayah -->
                                <div class="col-12">
                                    <h6 class="border-bottom pb-2 fw-semibold text-primary">📋 Data Ayah</h6>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Nama Ayah <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_ayah" class="form-control" value="{{ old('nama_ayah') }}" required>
                                    @error('nama_ayah')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Pekerjaan Ayah <span class="text-danger">*</span></label>
                                    <input type="text" name="pekerjaan_ayah" class="form-control" value="{{ old('pekerjaan_ayah') }}" required>
                                    @error('pekerjaan_ayah')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Telepon Ayah</label>
                                    <input type="text" name="telepon_ayah" class="form-control" value="{{ old('telepon_ayah') }}">
                                </div>

                                <!-- Data Ibu -->
                                <div class="col-12 mt-3">
                                    <h6 class="border-bottom pb-2 fw-semibold text-primary">👩 Data Ibu</h6>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Nama Ibu <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu') }}" required>
                                    @error('nama_ibu')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Pekerjaan Ibu <span class="text-danger">*</span></label>
                                    <input type="text" name="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu') }}" required>
                                    @error('pekerjaan_ibu')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Telepon Ibu</label>
                                    <input type="text" name="telepon_ibu" class="form-control" value="{{ old('telepon_ibu') }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Alamat Orang Tua</label>
                                    <textarea name="alamat_orangtua" class="form-control" rows="2">{{ old('alamat_orangtua') }}</textarea>
                                </div>

                                <!-- Data Wali -->
                                <div class="col-12 mt-3">
                                    <h6 class="border-bottom pb-2 fw-semibold text-primary">🧑‍💼 Data Wali (Opsional)</h6>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Nama Wali</label>
                                    <input type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali') }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Alamat Wali</label>
                                    <input type="text" name="alamat_wali" class="form-control" value="{{ old('alamat_wali') }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Telepon Wali</label>
                                    <input type="text" name="telepon_wali" class="form-control" value="{{ old('telepon_wali') }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Pekerjaan Wali</label>
                                    <input type="text" name="pekerjaan_wali" class="form-control" value="{{ old('pekerjaan_wali') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="mt-5 d-flex justify-content-end gap-2">
                            <a href="{{ route('siswa.dataDiri') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="button" class="btn btn-outline-secondary" id="prevBtn" style="display: none;">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-primary" id="nextBtn">
                                <i class="fas fa-arrow-right me-1"></i> Lanjut
                            </button>
                            <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
                                <i class="fas fa-save me-1"></i> Simpan Data
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .step-label {
        font-weight: 500;
        color: #999;
        transition: color 0.3s;
    }
    .step-label.active {
        color: #0056b3;
        font-weight: 600;
    }
</style>

<script>
    let currentStep = 1;
    const totalSteps = 2;

    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    const stepInput = document.getElementById('stepInput');
    const form = document.getElementById('multiStepForm');

    function showStep(step) {
        // Hide all steps
        document.getElementById('step1').style.display = step === 1 ? 'block' : 'none';
        document.getElementById('step2').style.display = step === 2 ? 'block' : 'none';

        // Update progress bar
        const progress = (step / totalSteps) * 100;
        document.querySelector('.progress-bar').style.width = progress + '%';

        // Update step labels
        document.getElementById('step1Label').classList.toggle('active', step === 1);
        document.getElementById('step2Label').classList.toggle('active', step === 2);

        // Update buttons
        prevBtn.style.display = step === 1 ? 'none' : 'block';
        nextBtn.style.display = step === 2 ? 'none' : 'block';
        submitBtn.style.display = step === 2 ? 'block' : 'none';

        stepInput.value = step;
        currentStep = step;
    }

    nextBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Validasi step 1 fields
        const step1Fields = document.querySelectorAll('.step1-field');
        let isValid = true;

        step1Fields.forEach(field => {
            // Check if field is empty
            if (!field.value || (field.tagName === 'SELECT' && field.value === '')) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (isValid && currentStep < totalSteps) {
            showStep(currentStep + 1);
            // Scroll to top
            document.querySelector('.card').scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else if (!isValid) {
            alert('Mohon isi semua field yang diperlukan pada Langkah 1');
        }
    });

    prevBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (currentStep > 1) {
            showStep(currentStep - 1);
            document.querySelector('.card').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });

    // Initialize on page load
    showStep(1);
</script>
@endsection
