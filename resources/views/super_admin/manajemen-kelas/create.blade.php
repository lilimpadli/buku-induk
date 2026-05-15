@extends('layouts.app')


@section('title', 'Form Tambah Kelas')

@section('content')
<div class="container-fluid" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-lg-6 col-md-8">

            <!-- KONTAINER FORM (GAYA MODAL) -->
            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">

                    <!-- JUDUL FORM -->
                    <h4 class="fw-bold text-center mb-1">Form Tambah Kelas</h4>
                    <p class="text-muted text-center mb-4">Isi data untuk menambah kelas baru.</p>

                    <form action="{{ route('super_admin.manajemen-kelas.store') }}"method="POST">
                        @csrf

                        <!-- TINGKAT -->
                        <div class="mb-3">
                            <label for="tingkat" class="form-label fw-semibold">TINGKAT <span class="text-danger">*</span></label>
                            <select name="tingkat" id="tingkat" class="form-control form-control-lg" required>
                                <option value="" disabled selected>-- Pilih Tingkat --</option>
                                <option value="10">Kelas 10</option>
                                <option value="11">Kelas 11</option>
                                <option value="12">Kelas 12</option>
                            </select>
                            @error('tingkat')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- KONSENTRASI KEAHLIAN -->
                        <div class="mb-3">
                            <label for="jurusan_id" class="form-label fw-semibold">KONSENTRASI KEAHLIAN <span class="text-danger">*</span></label>
                            <select name="jurusan_id" id="jurusan_id" class="form-control form-control-lg" required>
                                <option value="" disabled selected>-- Pilih Konsentrasi Keahlian --</option>
                                @foreach($jurusans as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- NAMA KELAS -->
                        <div class="mb-4">
                            <label for="nama" class="form-label fw-semibold">NAMA KELAS <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control form-control-lg" placeholder="Contoh: XI RPL 1"
                                value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- WALI KELAS -->
                        <div class="mb-4">
                            <label for="guru_id" class="form-label fw-semibold">Wali Kelas</label>
                            <select name="guru_id" id="guru_id" class="form-control form-control-lg">
                                <option value="" disabled selected>-- Pilih Wali Kelas --</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                                @endforeach
                            </select>
                            @error('guru_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- TOMBOL AKSI -->
                        <div class="d-flex justify-content-between gap-2 mt-4">
                            <a href="{{ route('super_admin.manajemen-kelas.index') }}" class="btn btn-light btn-lg flex-fill">Tutup</a>
                            <button type="submit" class="btn btn-primary btn-lg flex-fill">Simpan Data</button>
                        </div>

                    </form>

                </div>
            </div>

=======
@section('title', 'Tambah Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Tambah Kelas Baru</h3>
            <p class="text-muted mb-0">
                Tambahkan rombel baru beserta tingkat, jurusan, dan wali kelas.
            </p>
        </div>

        <a href="{{ route('super_admin.manajemen-kelas.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0">Form Tambah Kelas</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('super_admin.manajemen-kelas.store') }}"
                  method="POST">
                @csrf

                <div class="row gy-3">

                    {{-- Tingkat --}}
                    <div class="col-md-6">
                        <label for="tingkat" class="form-label">
                            Tingkat
                        </label>

                        <select id="tingkat"
                                name="tingkat"
                                class="form-select"
                                required>

                            <option value="" disabled selected>
                                -- Pilih Tingkat --
                            </option>

                            @foreach($tingkats as $t)
                                <option value="{{ $t }}"
                                    {{ old('tingkat') == $t ? 'selected' : '' }}>
                                    Kelas {{ $t }}
                                </option>
                            @endforeach
                        </select>

                        @error('tingkat')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Jurusan --}}
                    <div class="col-md-6">
                        <label for="jurusan_id" class="form-label">
                            Konsentrasi Keahlian
                        </label>

                        <select id="jurusan_id"
                                name="jurusan_id"
                                class="form-select"
                                required>

                            <option value="" disabled selected>
                                -- Pilih Jurusan --
                            </option>

                            @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}"
                                    {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama }}
                                </option>
                            @endforeach
                        </select>

                        @error('jurusan_id')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Nama Rombel --}}
                    <div class="col-md-6">
                        <label for="nama" class="form-label">
                            Nama Rombel
                        </label>

                        <input type="text"
                               id="nama"
                               name="nama"
                               class="form-control"
                               value="{{ old('nama') }}"
                               placeholder="Contoh: RPL 1"
                               required>

                        @error('nama')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Wali Kelas --}}
                    <div class="col-md-6">
                        <label for="guru_id" class="form-label">
                            Wali Kelas
                        </label>

                        <select id="guru_id"
                                name="guru_id"
                                class="form-select">

                            <option value="">
                                -- Pilih Wali Kelas --
                            </option>

                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}"
                                    {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama }}
                                </option>
                            @endforeach
                        </select>

                        @error('guru_id')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('super_admin.manajemen-kelas.index') }}"
                       class="btn btn-light">
                        Batal
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        Simpan Data
                    </button>
                </div>

            </form>
>>>>>>> 6a0be41238e52c22ffdce7aa5fc2d91d7abadbc0
        </div>
    </div>
</div>
@endsection