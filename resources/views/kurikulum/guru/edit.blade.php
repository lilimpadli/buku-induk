@extends('layouts.app')

@section('title', 'Edit Guru')

@section('content')
<div class="container mt-4">
    <h3>Edit Guru — {{ $guru->nama }}</h3>

    <form action="{{ route('kurikulum.guru.manage.update', $guru->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- ERROR --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- WARNING --}}
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ================= DATA GURU ================= --}}
        <div class="row">
            <div class="col-md-6">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control"
                       value="{{ old('nama', $guru->nama) }}" required>
            </div>

            <div class="col-md-6">
                <label>NIP (Login)</label>
                <input type="text" name="nomor_induk" class="form-control"
                       value="{{ old('nomor_induk', $guru->nip) }}" required>
            </div>
        </div>

        {{-- ================= PENUGASAN ================= --}}
        <div class="row mt-3">

            {{-- JURUSAN --}}
            <div class="col-md-4">
                <label>Jurusan</label>
                <select id="jurusanSelect" name="jurusan_id" class="form-control">
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id }}"
                            {{ old('jurusan_id', $guru->jurusan_id) == $j->id ? 'selected' : '' }}>
                            {{ $j->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- KELAS --}}
            <div class="col-md-4">
                <label>Kelas</label>
                <select id="kelasSelect" name="kelas_id" class="form-control">
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

            {{-- ROMBEL --}}
            <div class="col-md-4">
                <label>Rombel (Wali Kelas)</label>
                <select id="rombelSelect" name="rombel_id" class="form-control">
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
        <div class="row mt-3">
            <div class="col-md-4">
                <label>Email (opsional)</label>
                <input type="email" name="email" id="emailInput" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $guru->email) }}">
                @error('email')
                    <div class="invalid-feedback d-block">
                        <strong>⚠️ {{ $message }}</strong>
                    </div>
                @enderror
                <small class="form-text text-muted" id="emailStatus"></small>
            </div>

            <div class="col-md-4">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    @foreach($roles as $key => $label)
                        <option value="{{ $key }}"
                            {{ old('role', $guru->user->role ?? '') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Password (kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control">
            </div>
        </div>

        {{-- ================= BUTTON ================= --}}
        <div class="mt-4">
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('kurikulum.guru.manage.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
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
