@extends('layouts.app')

@section('title', 'Edit Akun Siswa')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Edit Akun Siswa</h3>
        <a href="{{ route('kurikulum.siswa.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('kurikulum.data-siswa.update', $siswa->id) }}">
                @csrf
                @method('PUT')

                @include('kurikulum.siswa._form')

                <div class="mt-4 d-flex justify-content-end">
                    <a href="{{ route('tu.siswa.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // reuse same dependent selects script from create
    document.addEventListener('DOMContentLoaded', function () {
        const jurusanSelect = document.querySelector('select[name="jurusan_id"]');
        const kelasSelect = document.getElementById('kelasSelect');
        const rombelSelect = document.getElementById('rombelSelect');

        function filterKelas() {
            const jurusanId = jurusanSelect ? jurusanSelect.value : '';
            Array.from(kelasSelect.options).forEach(opt => {
                if (!opt.value) return;
                const match = !jurusanId || opt.dataset.jurusan == jurusanId;
                opt.style.display = match ? '' : 'none';
            });
            if (kelasSelect.selectedOptions.length && kelasSelect.selectedOptions[0].style.display === 'none') {
                kelasSelect.value = '';
            }
            filterRombel();
        }

        function filterRombel() {
            const kelasId = kelasSelect ? kelasSelect.value : '';
            Array.from(rombelSelect.options).forEach(opt => {
                if (!opt.value) return;
                const dataKelas = opt.dataset.kelas || '';
                const match = !kelasId || dataKelas == kelasId;
                opt.style.display = match ? '' : 'none';
            });
            if (rombelSelect.selectedOptions.length && rombelSelect.selectedOptions[0].style.display === 'none') {
                rombelSelect.value = '';
            }
        }

        if (jurusanSelect) jurusanSelect.addEventListener('change', filterKelas);
        if (kelasSelect) kelasSelect.addEventListener('change', filterRombel);

        filterKelas();
    });
</script>

@endsection
