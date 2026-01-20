@extends('layouts.app')

@section('title', 'Tambah Guru')

@section('content')
<div class="container mt-4">

    {{-- ================= JUDUL HALAMAN (POJOK KIRI) ================= --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Tambah Guru</h3>
        <p class="text-muted mb-0">
            Tambahkan data guru baru ke dalam sistem
        </p>
    </div>

    {{-- ================= CARD FORM ================= --}}
    <div class="card shadow-sm">
        <div class="card-body">

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
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control"
                               value="{{ old('nama') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">NIP (Login)</label>
                        <input type="text" name="nomor_induk" class="form-control"
                               value="{{ old('nomor_induk') }}" required>
                    </div>
                </div>

                {{-- ================= AKUN ================= --}}
                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label">Email (opsional)</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-control" required>
                            @foreach($roles as $key => $label)
                                <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>

                {{-- ================= PENUGASAN ================= --}}
                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label">Jurusan</label>
                        <select id="jurusanSelect" name="jurusan_id" class="form-control">
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>
                                    {{ $j->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Kelas</label>
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

                    <div class="col-md-4">
                        <label class="form-label">Rombel (Wali Kelas)</label>
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
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('kurikulum.guru.manage.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button class="btn btn-primary">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

{{-- ================= CSS SAMAKAN TINGGI ================= --}}
@push('styles')
<style>
    .form-control {
        height: 44px;
    }
</style>
@endpush

{{-- ================= SCRIPT (TETAP) ================= --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const jurusan = document.getElementById('jurusanSelect');
    const kelas   = document.getElementById('kelasSelect');
    const rombel  = document.getElementById('rombelSelect');

    const kelasAll  = @json($kelasArr);
    const rombelAll = @json($rombelArr);

    function renderKelas(jurusanId) {
        kelas.innerHTML = '';
        kelas.appendChild(new Option('-- Pilih Kelas --', ''));

        const jurusanText = jurusan.options[jurusan.selectedIndex]?.text || '';

        kelasAll.forEach(item => {
            if (!jurusanId || item.jurusan == jurusanId || item.text.includes(jurusanText)) {
                kelas.appendChild(new Option(item.text, item.value));
            }
        });
    }

    function renderRombel(kelasId) {
        rombel.innerHTML = '';
        rombel.appendChild(new Option('-- Tidak sebagai wali --', ''));

        rombelAll.forEach(item => {
            if (!kelasId || item.kelas == kelasId) {
                rombel.appendChild(new Option(item.text, item.value));
            }
        });
    }

    jurusan.addEventListener('change', () => {
        renderKelas(jurusan.value);
        kelas.value = '';
        renderRombel('');
    });

    kelas.addEventListener('change', () => {
        renderRombel(kelas.value);
        rombel.value = '';
    });

    renderKelas(jurusan.value);
    renderRombel(kelas.value);
});
</script>
@endpush
