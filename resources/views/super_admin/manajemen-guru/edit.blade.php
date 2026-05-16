@extends('layouts.app')

@section('title', 'Edit Guru')

@section('content')
<style>
    /* ===================== STYLE EDIT GURU ===================== */
    
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

    .page-header {
        margin-bottom: 1.5rem;
    }

    h3 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 5px !important;
    }

    h3::before {
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
    
    .text-muted {
        color: #64748B !important;
        margin-left: 15px;
        margin-bottom: 0;
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

    .card-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        padding: 16px 24px;
        border-bottom: none;
    }

    .card-header h5 {
        color: white;
        font-weight: 600;
        margin: 0;
        font-size: 18px;
    }

    .card-header h5 i {
        margin-right: 8px;
    }

    /* Form Styles */
    .form-label {
        font-weight: 600;
        color: #374151;
        font-size: 13px;
        margin-bottom: 6px;
    }

    .form-label i {
        color: var(--primary-color);
        width: 18px;
    }

    .form-control, .form-select {
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
        outline: none;
    }
    
    .form-control.is-valid {
        border-color: var(--success-color);
        background-image: none;
    }
    
    .form-control.is-invalid {
        border-color: var(--danger-color);
        background-image: none;
    }
    
    /* Button Styles */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        border-radius: 10px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 83, 255, 0.4);
        color: white;
    }

    .btn-secondary {
        background-color: #64748B;
        border: none;
        border-radius: 10px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #475569;
        transform: translateY(-2px);
    }
    
    /* Alert Styles */
    .alert {
        border-radius: 10px;
        border: none;
    }
    
    /* Divider */
    .section-divider {
        border-top: 1px solid #E2E8F0;
        margin: 20px 0;
        position: relative;
    }
    
    .section-divider span {
        background: white;
        padding: 0 12px;
        position: absolute;
        top: -12px;
        left: 15px;
        font-size: 12px;
        font-weight: 600;
        color: #94A3B8;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        h3 {
            font-size: 22px;
        }
        .card-header {
            padding: 12px 20px;
        }
        .btn-primary, .btn-secondary {
            width: 100%;
            margin-top: 8px;
        }
        .d-flex.gap-2 {
            flex-direction: column;
        }
    }
</style>

<div class="container-fluid mt-4">

    <!-- PAGE HEADER -->
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-0">Edit Guru</h3>
            <p class="text-muted mt-1">Perbarui data guru: <strong>{{ $guru->nama }}</strong></p>
        </div>
    </div>

    <!-- MAIN CARD -->
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-user-edit"></i> Form Edit Guru
            </h5>
        </div>
        <div class="card-body p-4">

            <form action="{{ route('super_admin.manajemen-guru.update', $guru->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ERROR --}}
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- WARNING --}}
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- ================= DATA GURU ================= --}}
                <div class="section-divider">
                    <span>DATA GURU</span>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-user"></i> Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" class="form-control"
                               value="{{ old('nama', $guru->nama) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-id-card"></i> NIP (Login) <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nomor_induk" class="form-control"
                               value="{{ old('nomor_induk', $guru->nip) }}" required>
                    </div>
                </div>

                {{-- ================= PENUGASAN ================= --}}
                <div class="section-divider mt-4">
                    <span>PENUGASAN</span>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-building"></i> Jurusan
                        </label>
                        <select id="jurusanSelect" name="jurusan_id" class="form-select">
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}"
                                    {{ old('jurusan_id', $guru->jurusan_id) == $j->id ? 'selected' : '' }}>
                                    {{ $j->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-school"></i> Kelas
                        </label>
                        <select id="kelasSelect" name="kelas_id" class="form-select">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}"
                                    data-jurusan="{{ $k->jurusan_id }}"
                                    {{ old('kelas_id', $guru->kelas_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->tingkat }} - {{ $k->jurusan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-users"></i> Rombel (Wali Kelas)
                        </label>
                        <select id="rombelSelect" name="rombel_id" class="form-select">
                            <option value="">-- Tidak sebagai wali --</option>
                            @foreach($rombels as $r)
                                <option value="{{ $r->id }}"
                                    data-kelas="{{ $r->kelas_id }}"
                                    {{ old('rombel_id', $guru->rombel_id) == $r->id ? 'selected' : '' }}>
                                    {{ $r->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- ================= ROLE & PASSWORD ================= --}}
                <div class="section-divider mt-4">
                    <span>AKUN & AKSES</span>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-envelope"></i> Email (opsional)
                        </label>
                        <input type="email" name="email" id="emailInput" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $guru->email) }}">
                        @error('email')
                            <div class="invalid-feedback d-block">
                                <strong>⚠️ {{ $message }}</strong>
                            </div>
                        @enderror
                        <small id="emailStatus" class="form-text text-muted"></small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-user-tag"></i> Role <span class="text-danger">*</span>
                        </label>
                        <select name="role" class="form-select" required>
                            @foreach($roles as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('role', $guru->user->role ?? '') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                        <small class="form-text text-muted">Minimal 8 karakter</small>
                    </div>
                </div>

                <div class="section-divider mt-4"></div>

                {{-- ================= BUTTON ================= --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('super_admin.manajemen-guru.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const jurusan = document.getElementById('jurusanSelect');
    const kelas   = document.getElementById('kelasSelect');
    const rombel  = document.getElementById('rombelSelect');

    const kelasAll = @json($kelasArr);
    const rombelAll = @json($rombelArr);

    function renderKelas(jurusanId) {
        kelas.innerHTML = '';
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.text = '-- Pilih Kelas --';
        kelas.appendChild(placeholder);

        const jurusanText = jurusan.options[jurusan.selectedIndex]?.text || '';

        kelasAll.forEach(item => {
            if (item.value === '') return;
            const matchesId = jurusanId && String(item.jurusan) == String(jurusanId);
            const matchesText = jurusanText && item.text.indexOf(jurusanText) !== -1;
            if (!jurusanId || matchesId || matchesText) {
                const o = document.createElement('option');
                o.value = item.value;
                o.text = item.text;
                kelas.appendChild(o);
            }
        });
    }

    function renderRombel(kelasId) {
        rombel.innerHTML = '';
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.text = '-- Tidak sebagai wali --';
        rombel.appendChild(placeholder);

        rombelAll.forEach(item => {
            if (item.value === '') return;
            if (!kelasId || item.kelas == kelasId) {
                const o = document.createElement('option');
                o.value = item.value;
                o.text = item.text;
                rombel.appendChild(o);
            }
        });
    }

    jurusan.addEventListener('change', function () {
        renderKelas(jurusan.value);
        kelas.value = '';
        renderRombel('');
    });

    kelas.addEventListener('change', function () {
        renderRombel(kelas.value);
        rombel.value = '';
    });

    // init and preserve selections
    renderKelas(jurusan.value);
    const oldKelas = '{{ old('kelas_id', $guru->kelas_id) }}';
    if (oldKelas && Array.from(kelas.options).some(o => o.value === oldKelas)) {
        kelas.value = oldKelas;
    }
    renderRombel(kelas.value);
    const oldRombel = '{{ old('rombel_id', $guru->rombel_id) }}';
    if (oldRombel && Array.from(rombel.options).some(o => o.value === oldRombel)) {
        rombel.value = oldRombel;
    }

    // Email validation - check if email already exists (excluding current user)
    const emailInput = document.getElementById('emailInput');
    const emailStatus = document.getElementById('emailStatus');
    const currentEmail = '{{ $guru->email }}';
    
    if (emailInput) {
        emailInput.addEventListener('blur', async function() {
            const email = this.value.trim();
            
            if (email === '' || email === currentEmail) {
                emailStatus.textContent = '';
                emailInput.classList.remove('is-invalid', 'is-valid');
                return;
            }
            
            try {
                const response = await fetch('{{ route('api.check-email') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ email: email, userId: {{ $guru->user_id ?? 'null' }} })
                });
                
                const data = await response.json();
                
                if (data.exists) {
                    emailInput.classList.add('is-invalid');
                    emailInput.classList.remove('is-valid');
                    emailStatus.textContent = '❌ Email sudah terdaftar';
                    emailStatus.className = 'form-text text-danger';
                } else {
                    emailInput.classList.add('is-valid');
                    emailInput.classList.remove('is-invalid');
                    emailStatus.textContent = '✓ Email tersedia';
                    emailStatus.className = 'form-text text-success';
                }
            } catch (error) {
                console.error('Error checking email:', error);
            }
        });
    }

});
</script>
@endpush