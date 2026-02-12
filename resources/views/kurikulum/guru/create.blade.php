@extends('layouts.app')

@section('title', 'Tambah Guru')

@section('content')
<div class="container mt-4">
    <h3>Tambah Guru</h3>

    <form action="{{ route('kurikulum.guru.manage.store') }}" method="POST">
        @csrf

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

        {{-- ================= DATA GURU ================= --}}
        <div class="row">
            <div class="col-md-6">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control"
                       value="{{ old('nama') }}" required>
            </div>

            <div class="col-md-6">
                <label>NIP (Login)</label>
                <input type="text" name="nomor_induk" class="form-control"
                       value="{{ old('nomor_induk') }}" required>
            </div>
        </div>

        {{-- ================= AKUN ================= --}}
        <div class="row mt-3">
            <div class="col-md-4">
                <label>Email (opsional)</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}">
            </div>

            <div class="col-md-4">
                <label>Role</label>
                <select id="roleSelect" name="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $key => $label)
                        <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
        </div>

        {{-- ================= PENUGASAN ================= --}}
        <div class="row mt-3">

            {{-- JURUSAN --}}
            <div class="col-md-4" id="jurusanDiv">
                <label>Jurusan</label>
                <select id="jurusanSelect" name="jurusan_id" class="form-control">
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>
                            {{ $j->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- KELAS --}}
            <div class="col-md-4" id="kelasDiv">
                <label>Kelas</label>
                <select id="kelasSelect" name="kelas_id" class="form-control">
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

            {{-- ROMBEL --}}
            <div class="col-md-4" id="rombelDiv">
                <label>Rombel (Wali Kelas)</label>
                <select id="rombelSelect" name="rombel_id" class="form-control">
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

        {{-- ================= BUTTON ================= --}}
        <div class="mt-4">
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('kurikulum.guru.manage.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<style>
#kelasDiv.hidden, #rombelDiv.hidden {
    display: none !important;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const jurusan = document.getElementById('jurusanSelect');
    const kelas   = document.getElementById('kelasSelect');
    const rombel  = document.getElementById('rombelSelect');

    // use server-provided data to avoid DOM timing/plugin issues
    const kelasAll = @json($kelasArr);

    const rombelAll = @json($rombelArr);

    const roleSelect = document.getElementById('roleSelect');
    const jurusanDiv = document.getElementById('jurusanDiv');
    const kelasDiv = document.getElementById('kelasDiv');
    const rombelDiv = document.getElementById('rombelDiv');

    function updateAssignmentFields() {
        const role = roleSelect.value;
        console.log('Role selected:', role);

        // Role rules:
        // - walikelas: show jurusan, kelas, rombel
        // - guru, kaprog, kepala_jurusan: show jurusan only
        // - kurikulum, tu, etc: hide all assignment fields
        const isWaliKelas = (role === 'walikelas');
        const showJurusan = (role === 'guru' || role === 'kaprog' || role === 'kepala_jurusan' || role === 'walikelas');
        
        console.log('isWaliKelas:', isWaliKelas, 'showJurusan:', showJurusan);
        
        // Use class to apply strong display:none with !important
        if (showJurusan) {
            jurusanDiv.classList.remove('hidden');
        } else {
            jurusanDiv.classList.add('hidden');
        }
        
        if (isWaliKelas) {
            kelasDiv.classList.remove('hidden');
            rombelDiv.classList.remove('hidden');
        } else {
            kelasDiv.classList.add('hidden');
            rombelDiv.classList.add('hidden');
        }
        
        console.log('Jurusan hidden:', jurusanDiv.classList.contains('hidden'));
        console.log('Kelas hidden:', kelasDiv.classList.contains('hidden'));
        console.log('Rombel hidden:', rombelDiv.classList.contains('hidden'));
    }

    roleSelect.addEventListener('change', function () {
        updateAssignmentFields();
    });

    function renderKelas(jurusanId) {
        // clear and add placeholder
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
            if (!kelasId || item.kelas === kelasId) {
                const o = document.createElement('option');
                o.value = item.value;
                o.text = item.text;
                rombel.appendChild(o);
            }
        });
    }

    // handle change events
    jurusan.addEventListener('change', function () {
        renderKelas(jurusan.value);
        // clear kelas selection and rebuild rombel accordingly
        kelas.value = '';
        renderRombel('');
    });

    kelas.addEventListener('change', function () {
        renderRombel(kelas.value);
        rombel.value = '';
    });

    // init: preserve any old selections if present
    renderKelas(jurusan.value);
    // try to keep preselected kelas (if its jurusan matches)
    const oldKelas = '{{ old('kelas_id') }}';
    if (oldKelas && Array.from(kelas.options).some(o => o.value === oldKelas)) {
        kelas.value = oldKelas;
    }
    renderRombel(kelas.value);
    const oldRombel = '{{ old('rombel_id') }}';
    if (oldRombel && Array.from(rombel.options).some(o => o.value === oldRombel)) {
        rombel.value = oldRombel;
    }
    // initialize assignment fields visibility based on currently selected role
    updateAssignmentFields();
});
</script>
@endpush