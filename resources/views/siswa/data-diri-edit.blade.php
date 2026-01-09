@extends('layouts.app')

@section('title', 'Edit Data Diri Siswa')

@section('content')
<style>
    /* ===================== STYLE EDIT DATA DIRI SISWA ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    h3.mb-4 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 25px !important;
    }

    h3.mb-4::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 3px;
    }

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-body {
        padding: 2rem;
    }

    /* Progress Bar */
    .progress {
        background-color: #E2E8F0;
        border-radius: 10px;
        height: 8px !important;
    }

    .progress-bar {
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        border-radius: 10px;
    }

    .step-label {
        font-weight: 500;
        color: #94A3B8;
        transition: color 0.3s;
    }

    .step-label.active {
        color: var(--primary-color);
        font-weight: 600;
    }

    /* Form Styles */
    h5.mb-3 {
        font-size: 18px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 20px !important;
        position: relative;
        padding-left: 15px;
    }

    h5.mb-3::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
    }

    h6.border-bottom {
        font-size: 16px;
        color: #1E293B;
        font-weight: 600;
        padding-bottom: 10px;
        margin-bottom: 15px;
        border-bottom: 2px solid #E2E8F0;
        position: relative;
    }

    h6.border-bottom::after {
        content: "";
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 60px;
        height: 2px;
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border-radius: 1px;
    }

    .form-label {
        color: #475569;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        padding: 10px 12px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
    }

    .form-control.is-invalid {
        border-color: var(--danger-color);
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .btn-success {
        background-color: var(--success-color);
        border-color: var(--success-color);
    }

    .btn-success:hover {
        background-color: #059669;
        border-color: #059669;
    }

    .btn-outline-secondary {
        color: #64748B;
        border-color: #E2E8F0;
    }

    .btn-outline-secondary:hover {
        background-color: #F1F5F9;
        border-color: #CBD5E1;
    }

    .btn-secondary {
        background-color: #64748B;
        border-color: #64748B;
    }

    .btn-secondary:hover {
        background-color: #475569;
        border-color: #475569;
    }

    /* Image Styles */
    .rounded {
        border-radius: 12px;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Error Messages */
    .text-danger.small {
        font-size: 12px;
        margin-top: 5px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }
        
        h3.mb-4 {
            font-size: 24px;
        }
        
        .btn {
            padding: 0.4rem 1rem;
            font-size: 14px;
        }
    }
</style>

<div class="container mt-3">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-9">
            <h3 class="mb-4">Edit Data Diri</h3>

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

                    <form method="POST" action="{{ route('siswa.dataDiri.update') }}" enctype="multipart/form-data" id="multiStepForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="step" id="stepInput" value="1">

                        <!-- ========== STEP 1: DATA SISWA ========== -->
                        <div id="step1" class="step-form">
                            <h5 class="mb-3 fw-semibold">Identitas Siswa</h5>
                            <div class="row g-3">
                                <!-- Nama Lengkap, NIS, NISN -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" class="form-control step1-field" value="{{ $siswa->nama_lengkap ?? old('nama_lengkap') }}" required>
                                    @error('nama_lengkap')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">NIS</label>
                                    <input type="text" value="{{ $siswa->nis }}" class="form-control" disabled>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">NISN <span class="text-danger">*</span></label>
                                    <input type="text" name="nisn" class="form-control step1-field" value="{{ $siswa->nisn ?? old('nisn') }}" required>
                                    @error('nisn')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <!-- TTL dan Jenis Kelamin -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" class="form-control step1-field" value="{{ $siswa->tempat_lahir ?? old('tempat_lahir') }}" required>
                                    @error('tempat_lahir')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control step1-field" value="{{ $siswa->tanggal_lahir ?? old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-select step1-field" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki" {{ ($siswa->jenis_kelamin ?? old('jenis_kelamin')) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ ($siswa->jenis_kelamin ?? old('jenis_kelamin')) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <!-- Agama, Status Keluarga, Anak Ke -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Agama <span class="text-danger">*</span></label>
                                    <input type="text" name="agama" class="form-control step1-field" value="{{ $siswa->agama ?? old('agama') }}" required>
                                    @error('agama')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Status Keluarga <span class="text-danger">*</span></label>
                                    <select name="status_keluarga" class="form-select step1-field" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Anak Kandung" {{ ($siswa->status_keluarga ?? old('status_keluarga')) == 'Anak Kandung' ? 'selected' : '' }}>Anak Kandung</option>
                                        <option value="Anak Tiri" {{ ($siswa->status_keluarga ?? old('status_keluarga')) == 'Anak Tiri' ? 'selected' : '' }}>Anak Tiri</option>
                                        <option value="Anak Angkat" {{ ($siswa->status_keluarga ?? old('status_keluarga')) == 'Anak Angkat' ? 'selected' : '' }}>Anak Angkat</option>
                                    </select>
                                    @error('status_keluarga')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Anak ke <span class="text-danger">*</span></label>
                                    <input type="number" name="anak_ke" class="form-control step1-field" value="{{ $siswa->anak_ke ?? old('anak_ke') }}" required>
                                    @error('anak_ke')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <!-- Alamat, No HP -->
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control step1-field" rows="3" required>{{ $siswa->alamat ?? old('alamat') }}</textarea>
                                    @error('alamat')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">No HP <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp" class="form-control step1-field" value="{{ $siswa->no_hp ?? old('no_hp') }}" required>
                                    @error('no_hp')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <!-- Sekolah Asal, Kelas, Tanggal Diterima -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Sekolah Asal <span class="text-danger">*</span></label>
                                    <input type="text" name="sekolah_asal" class="form-control step1-field" value="{{ $siswa->sekolah_asal ?? old('sekolah_asal') }}" required>
                                    @error('sekolah_asal')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Tanggal Diterima <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_diterima" class="form-control step1-field" value="{{ $siswa->tanggal_diterima ?? old('tanggal_diterima') }}" required>
                                    @error('tanggal_diterima')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <!-- Foto -->
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Foto Siswa</label>
                                    @if ($siswa->foto)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $siswa->foto) }}" width="100" class="rounded">
                                        </div>
                                    @endif
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
                                    <input type="text" name="nama_ayah" class="form-control" value="{{ $siswa->ayah->nama ?? old('nama_ayah') }}" required>
                                    @error('nama_ayah')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Pekerjaan Ayah <span class="text-danger">*</span></label>
                                    <input type="text" name="pekerjaan_ayah" class="form-control" value="{{ $siswa->ayah->pekerjaan ?? old('pekerjaan_ayah') }}" required>
                                    @error('pekerjaan_ayah')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Telepon Ayah</label>
                                    <input type="text" name="telepon_ayah" class="form-control" value="{{ $siswa->ayah->telepon ?? old('telepon_ayah') }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Alamat Ayah <span class="text-danger">*</span></label>
                                    <textarea name="alamat_ayah" class="form-control" rows="2" required>{{ $siswa->ayah->alamat ?? old('alamat_ayah') }}</textarea>
                                    @error('alamat_ayah')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <!-- Data Ibu -->
                                <div class="col-12 mt-3">
                                    <h6 class="border-bottom pb-2 fw-semibold text-primary">👩 Data Ibu</h6>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Nama Ibu <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_ibu" class="form-control" value="{{ $siswa->ibu->nama ?? old('nama_ibu') }}" required>
                                    @error('nama_ibu')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Pekerjaan Ibu <span class="text-danger">*</span></label>
                                    <input type="text" name="pekerjaan_ibu" class="form-control" value="{{ $siswa->ibu->pekerjaan ?? old('pekerjaan_ibu') }}" required>
                                    @error('pekerjaan_ibu')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Telepon Ibu</label>
                                    <input type="text" name="telepon_ibu" class="form-control" value="{{ $siswa->ibu->telepon ?? old('telepon_ibu') }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Alamat Ibu <span class="text-danger">*</span></label>
                                    <textarea name="alamat_ibu" class="form-control" rows="2" required>{{ $siswa->ibu->alamat ?? old('alamat_ibu') }}</textarea>
                                    @error('alamat_ibu')<div class="text-danger small">{{ $message }}</div>@enderror
                                </div>

                                <!-- Data Wali -->
                                <div class="col-12 mt-3">
                                    <h6 class="border-bottom pb-2 fw-semibold text-primary">🧑‍💼 Data Wali (Opsional)</h6>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Nama Wali</label>
                                    <input type="text" name="nama_wali" class="form-control" value="{{ $siswa->wali->nama ?? old('nama_wali') }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Pekerjaan Wali</label>
                                    <input type="text" name="pekerjaan_wali" class="form-control" value="{{ $siswa->wali->pekerjaan ?? old('pekerjaan_wali') }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Telepon Wali</label>
                                    <input type="text" name="telepon_wali" class="form-control" value="{{ $siswa->wali->telepon ?? old('telepon_wali') }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Alamat Wali</label>
                                    <textarea name="alamat_wali" class="form-control" rows="2">{{ $siswa->wali->alamat ?? old('alamat_wali') }}</textarea>
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
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

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