@extends('layouts.app')

@section('title', 'Edit Guru')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --warning-gradient: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: #f7fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    main {
        padding: 20px 15px !important;
        overflow-x: auto !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 10px !important;
        overflow-x: auto !important;
    }

    .page-header {
        background: var(--warning-gradient);
        color: white;
        padding: 1.5rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
        width: 100%;
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

    .form-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        width: 100%;
    }

    .form-card .card-header {
        background: white;
        border-bottom: 1px solid #E2E8F0;
        padding: 0.8rem 1.5rem;
    }

    .form-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 1rem;
    }

    .form-card .card-header h5 i {
        color: #F59E0B;
        margin-right: 6px;
    }

    .form-card .card-body {
        padding: 1.5rem;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #1E293B;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        padding: 0.5rem 0.9rem;
        transition: var(--transition);
        font-size: 0.9rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #F59E0B;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .btn-update {
        background: var(--warning-gradient);
        border: none;
        padding: 0.5rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        color: white;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.5);
        color: white;
    }

    .btn-cancel {
        background: #64748B;
        border: none;
        padding: 0.5rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        color: white;
    }

    .btn-cancel:hover {
        background: #475569;
        transform: translateY(-2px);
        color: white;
    }

    .hidden {
        display: none !important;
    }

    .invalid-feedback {
        font-size: 0.8rem;
    }

    .form-text {
        font-size: 0.75rem;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1rem;
        }
        .page-header h3 {
            font-size: 1.1rem;
        }
        .page-header .text-muted {
            font-size: 0.75rem;
        }

        .form-card .card-body {
            padding: 1rem;
        }

        .btn-update,
        .btn-cancel {
            width: 100%;
            margin-bottom: 8px;
            justify-content: center;
        }

        .border-top {
            text-align: center;
        }

        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .col-md-6 {
            padding-left: 8px;
            padding-right: 8px;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <h3><i class="fas fa-user-edit me-2"></i> Edit Guru</h3>
        <div class="text-muted">Perbarui data guru — {{ $guru->nama }}</div>
    </div>

    <div class="card form-card">
        <div class="card-header">
            <h5><i class="fas fa-pen"></i> Form Edit Guru</h5>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('kurikulum.guru.manage.update', $guru->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-user text-primary me-1"></i> Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $guru->nama) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-id-card text-primary me-1"></i> NIP (Login) <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_induk" class="form-control" value="{{ old('nomor_induk', $guru->nip) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-envelope text-primary me-1"></i> Email</label>
                        <input type="email" name="email" id="emailInput" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $guru->email) }}">
                        @error('email')
                            <div class="invalid-feedback d-block"><strong>⚠️ {{ $message }}</strong></div>
                        @enderror
                        <small class="form-text text-muted" id="emailStatus"></small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-user-tag text-primary me-1"></i> Role <span class="text-danger">*</span></label>
                        <select id="roleSelect" name="role" class="form-select" required>
                            @foreach($roles as $key => $label)
                                <option value="{{ $key }}" {{ old('role', $guru->user->role ?? '') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-lock text-primary me-1"></i> Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                        <small class="form-text text-muted">Isi hanya jika ingin mengganti password</small>
                    </div>
                </div>

                <div class="row" id="assignmentFields">
                    <div class="col-md-4 mb-3" id="jurusanDiv">
                        <label class="form-label"><i class="fas fa-building text-primary me-1"></i> Jurusan</label>
                        <select id="jurusanSelect" name="jurusan_id" class="form-select">
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}" {{ old('jurusan_id', $guru->jurusan_id) == $j->id ? 'selected' : '' }}>
                                    {{ $j->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3" id="kelasDiv">
                        <label class="form-label"><i class="fas fa-school text-primary me-1"></i> Kelas</label>
                        <select id="kelasSelect" name="kelas_id" class="form-select">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" data-jurusan="{{ $k->jurusan_id }}" {{ old('kelas_id', $guru->kelas_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->tingkat }} - {{ $k->jurusan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3" id="rombelDiv">
                        <label class="form-label"><i class="fas fa-users text-primary me-1"></i> Rombel (Wali Kelas)</label>
                        <select id="rombelSelect" name="rombel_id" class="form-select">
                            <option value="">-- Tidak sebagai wali --</option>
                            @foreach($rombels as $r)
                                <option value="{{ $r->id }}" data-kelas="{{ $r->kelas_id }}" {{ old('rombel_id', $guru->rombel_id) == $r->id ? 'selected' : '' }}>
                                    {{ $r->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-update">
                        <i class="fas fa-save me-2"></i> Update
                    </button>
                    <a href="{{ route('kurikulum.guru.manage.index') }}" class="btn btn-cancel">
                        <i class="fas fa-arrow-left me-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const jurusan = document.getElementById('jurusanSelect');
    const kelas   = document.getElementById('kelasSelect');
    const rombel  = document.getElementById('rombelSelect');
    const roleSelect = document.getElementById('roleSelect');
    const jurusanDiv = document.getElementById('jurusanDiv');
    const kelasDiv = document.getElementById('kelasDiv');
    const rombelDiv = document.getElementById('rombelDiv');

    const kelasAll = @json($kelasArr);
    const rombelAll = @json($rombelArr);

    function updateAssignmentFields() {
        const role = roleSelect.value;
        const isWaliKelas = (role === 'walikelas');
        const showJurusan = (role === 'guru' || role === 'kaprog' || role === 'kepala_jurusan' || role === 'walikelas');
        
        jurusanDiv.classList.toggle('hidden', !showJurusan);
        kelasDiv.classList.toggle('hidden', !isWaliKelas);
        rombelDiv.classList.toggle('hidden', !isWaliKelas);
    }

    roleSelect.addEventListener('change', updateAssignmentFields);

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
    updateAssignmentFields();

    // Email validation
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
                    body: JSON.stringify({ email: email, userId: {{ $guru->user_id }} })
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
@endsection