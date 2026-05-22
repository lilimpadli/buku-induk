@extends('layouts.app')

@section('title', 'Tambah Guru')

@push('styles')

<style>
:root{
    --primary-blue:#4facfe;
    --secondary-blue:#00f2fe;
    --light-bg:#F4F7FE;
    --text-dark:#1E293B;
    --text-muted:#64748B;
    --soft-gray:#E2E8F0;

    --shadow-light:0 6px 24px rgba(15,23,42,.06);
    --shadow-medium:0 14px 40px rgba(15,23,42,.08);

    --radius:26px;
}

body{
    background:var(--light-bg);
    font-family:'Poppins',sans-serif;
}

/* ================= HEADER ================= */

.page-header{
    background:linear-gradient(135deg,var(--primary-blue) 0%,var(--secondary-blue) 100%);
    border-radius:30px;
    padding:34px;
    color:white;
    margin-bottom:28px;
    box-shadow:var(--shadow-medium);
}

.page-title{
    font-size:2rem;
    font-weight:800;
    margin-bottom:8px;
}

.page-subtitle{
    margin:0;
    opacity:.9;
    line-height:1.7;
}

/* ================= CARD ================= */

.form-card{
    background:#fff;
    border:none;
    border-radius:30px;
    overflow:hidden;
    box-shadow:var(--shadow-light);
}

.form-card .card-body{
    padding:32px;
}

/* ================= SECTION ================= */

.form-section{
    margin-bottom:34px;
}

.section-title{
    font-size:1rem;
    font-weight:700;
    color:var(--text-dark);
    margin-bottom:18px;
    display:flex;
    align-items:center;
    gap:10px;
}

/* ================= FORM ================= */

.form-label{
    font-size:14px;
    font-weight:600;
    color:var(--text-dark);
    margin-bottom:8px;
}

.form-control,
.form-select{
    border-radius:16px;
    border:2px solid #E2E8F0;
    min-height:52px;
    padding:12px 16px;
    font-size:14px;
    transition:.25s ease;
    box-shadow:none;
}

.form-control:focus,
.form-select:focus{
    border-color:var(--primary-blue);
    box-shadow:0 0 0 4px rgba(79,172,254,.12);
}

.form-text{
    margin-top:6px;
}

/* ================= BUTTON ================= */

.btn-modern{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    border:none;
    border-radius:999px;
    padding:13px 22px;
    min-height:50px;
    font-size:14px;
    font-weight:700;
    color:white;
    text-decoration:none;
    transition:.25s ease;
}

.btn-modern:hover{
    transform:translateY(-1px);
    color:white;
}

.btn-primary-modern{
    background:linear-gradient(135deg,var(--primary-blue),var(--secondary-blue));
    box-shadow:0 12px 28px rgba(79,172,254,.22);
}

.btn-secondary-modern{
    background:#E2E8F0;
    color:#334155;
}

.btn-secondary-modern:hover{
    color:#334155;
    background:#CBD5E1;
}

/* ================= ALERT ================= */

.alert-modern{
    border:none;
    border-radius:20px;
    padding:18px 20px;
    margin-bottom:24px;
}

.alert-danger-modern{
    background:#FEF2F2;
    color:#991B1B;
}

.alert-warning-modern{
    background:#FFF7ED;
    color:#9A3412;
}

/* ================= HIDDEN ================= */

#kelasDiv.hidden,
#rombelDiv.hidden{
    display:none !important;
}

/* ================= MOBILE ================= */

@media(max-width:768px){

    .page-header{
        padding:24px;
    }

    .page-title{
        font-size:1.5rem;
    }

    .form-card .card-body{
        padding:22px;
    }

}
</style>

@endpush

@section('content')

<div class="container-fluid py-4">

```
<!-- HEADER -->
<div class="page-header">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">

        <div>
            <h1 class="page-title">
                <i class="fas fa-user-plus"></i>
                Tambah Guru
            </h1>

            <p class="page-subtitle">
                Tambahkan data guru baru beserta akun dan penugasannya.
            </p>
        </div>

        <a href="{{ route('super_admin.manajemen-guru.index') }}"
           class="btn-modern btn-secondary-modern">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

    </div>
</div>

<div class="form-card">
    <div class="card-body">

        {{-- ERROR --}}
        @if($errors->any())
            <div class="alert-modern alert-danger-modern">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- WARNING --}}
        @if(session('warning'))
            <div class="alert-modern alert-warning-modern">
                {{ session('warning') }}
            </div>
        @endif

        <form action="{{ route('super_admin.manajemen-guru.store') }}" method="POST">
            @csrf

            <!-- DATA GURU -->
            <div class="form-section">

                <div class="section-title">
                    <i class="fas fa-id-card"></i>
                    Data Guru
                </div>

                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label">Nama Guru</label>

                        <input type="text"
                               name="nama"
                               class="form-control"
                               value="{{ old('nama') }}"
                               placeholder="Masukkan nama guru"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">NIP / Nomor Induk</label>

                        <input type="text"
                               name="nomor_induk"
                               class="form-control"
                               value="{{ old('nomor_induk') }}"
                               placeholder="Masukkan nomor induk"
                               required>
                    </div>

                </div>

            </div>

            <!-- AKUN -->
            <div class="form-section">

                <div class="section-title">
                    <i class="fas fa-user-shield"></i>
                    Informasi Akun
                </div>

                <div class="row g-4">

                    <div class="col-md-4">
                        <label class="form-label">Email</label>

                        <input type="email"
                               name="email"
                               id="emailInput"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="contoh@email.com">

                        @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                        <small id="emailStatus" class="form-text"></small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Role</label>

                        <select id="roleSelect"
                                name="role"
                                class="form-select"
                                required>

                            <option value="">-- Pilih Role --</option>

                            @foreach($roles as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('role') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Password</label>

                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Masukkan password"
                               required>
                    </div>

                </div>

            </div>

            <!-- PENUGASAN -->
            <div class="form-section">

                <div class="section-title">
                    <i class="fas fa-school"></i>
                    Penugasan Guru
                </div>

                <div class="row g-4">

                    <!-- JURUSAN -->
                    <div class="col-md-4" id="jurusanDiv">

                        <label class="form-label">Jurusan</label>

                        <select id="jurusanSelect"
                                name="jurusan_id"
                                class="form-select">

                            <option value="">-- Pilih Jurusan --</option>

                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}"
                                    {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>
                                    {{ $j->nama }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <!-- KELAS -->
                    <div class="col-md-4" id="kelasDiv">

                        <label class="form-label">Kelas</label>

                        <select id="kelasSelect"
                                name="kelas_id"
                                class="form-select">

                            <option value="">-- Pilih Kelas --</option>

                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}"
                                    data-jurusan="{{ $k->jurusan_id }}"
                                    {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->tingkat }} - {{ $k->jurusan->nama }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <!-- ROMBEL -->
                    <div class="col-md-4" id="rombelDiv">

                        <label class="form-label">Rombel</label>

                        <select id="rombelSelect"
                                name="rombel_id"
                                class="form-select">

                            <option value="">-- Tidak sebagai wali --</option>

                            @foreach($rombels as $r)
                                <option value="{{ $r->id }}"
                                    data-kelas="{{ $r->kelas_id }}"
                                    {{ old('rombel_id') == $r->id ? 'selected' : '' }}>
                                    {{ $r->nama }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                </div>

            </div>

            <!-- BUTTON -->
            <div class="d-flex flex-wrap gap-3">

                <button type="submit"
                        class="btn-modern btn-primary-modern">
                    <i class="fas fa-save"></i>
                    Simpan Guru
                </button>

                <a href="{{ route('super_admin.manajemen-guru.index') }}"
                   class="btn-modern btn-secondary-modern">
                    <i class="fas fa-times"></i>
                    Batal
                </a>

            </div>

        </form>

    </div>
</div>
```

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

    const roleSelect = document.getElementById('roleSelect');
    const jurusanDiv = document.getElementById('jurusanDiv');
    const kelasDiv = document.getElementById('kelasDiv');
    const rombelDiv = document.getElementById('rombelDiv');

    function updateAssignmentFields() {

        const role = roleSelect.value;

        const isWaliKelas = (role === 'walikelas');

        const showJurusan =
            role === 'guru' ||
            role === 'kaprog' ||
            role === 'kepala_jurusan' ||
            role === 'walikelas';

        showJurusan
            ? jurusanDiv.classList.remove('hidden')
            : jurusanDiv.classList.add('hidden');

        isWaliKelas
            ? kelasDiv.classList.remove('hidden')
            : kelasDiv.classList.add('hidden');

        isWaliKelas
            ? rombelDiv.classList.remove('hidden')
            : rombelDiv.classList.add('hidden');
    }

    roleSelect.addEventListener('change', updateAssignmentFields);

    function renderKelas(jurusanId) {

        kelas.innerHTML = '';

        const placeholder = document.createElement('option');

        placeholder.value = '';
        placeholder.text = '-- Pilih Kelas --';

        kelas.appendChild(placeholder);

        const jurusanText =
            jurusan.options[jurusan.selectedIndex]?.text || '';

        kelasAll.forEach(item => {

            const matchesId =
                jurusanId &&
                String(item.jurusan) == String(jurusanId);

            const matchesText =
                jurusanText &&
                item.text.indexOf(jurusanText) !== -1;

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

            if (!kelasId || item.kelas === kelasId) {

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

    const oldKelas = '{{ old('kelas_id') }}';

    if (
        oldKelas &&
        Array.from(kelas.options).some(o => o.value === oldKelas)
    ) {
        kelas.value = oldKelas;
    }

    renderRombel(kelas.value);

    const oldRombel = '{{ old('rombel_id') }}';

    if (
        oldRombel &&
        Array.from(rombel.options).some(o => o.value === oldRombel)
    ) {
        rombel.value = oldRombel;
    }

    updateAssignmentFields();

    // EMAIL CHECK
    const emailInput = document.getElementById('emailInput');
    const emailStatus = document.getElementById('emailStatus');

    if (emailInput) {

        emailInput.addEventListener('blur', async function() {

            const email = this.value.trim();

            if (email === '') {

                emailStatus.textContent = '';

                emailInput.classList.remove('is-invalid', 'is-valid');

                return;
            }

            try {

                const response = await fetch('{{ route('api.check-email') }}', {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },

                    body: JSON.stringify({ email: email })
                });

                const data = await response.json();

                if (data.exists) {

                    emailInput.classList.add('is-invalid');
                    emailInput.classList.remove('is-valid');

                    emailStatus.textContent =
                        '❌ Email sudah terdaftar';

                    emailStatus.className =
                        'form-text text-danger';

                } else {

                    emailInput.classList.add('is-valid');
                    emailInput.classList.remove('is-invalid');

                    emailStatus.textContent =
                        '✓ Email tersedia';

                    emailStatus.className =
                        'form-text text-success';
                }

            } catch (error) {
                console.error(error);
            }

        });

    }

});
</script>

@endpush
