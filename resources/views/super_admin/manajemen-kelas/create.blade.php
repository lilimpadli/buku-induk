@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Tambah Kelas Baru</h3>
            <p class="text-muted mb-0">Tambahkan rombel baru beserta tingkat, jurusan, dan wali kelas.</p>
        </div>
        <a href="{{ route('super_admin.manajemen-kelas.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0">Form Tambah Kelas</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('super_admin.manajemen-kelas.store') }}" method="POST">
                @csrf

                <div class="row gy-3">
                    <div class="col-md-6">
                        <label for="tingkat" class="form-label">Tingkat</label>
                        <select id="tingkat" name="tingkat" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Tingkat --</option>
                            @foreach($tingkats as $t)
                                <option value="{{ $t }}" {{ old('tingkat') == $t ? 'selected' : '' }}>Kelas {{ $t }}</option>
                            @endforeach
                        </select>
                        @error('tingkat')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="jurusan_id" class="form-label">Konsentrasi Keahlian</label>
                        <select id="jurusan_id" name="jurusan_id" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Jurusan --</option>
                            @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                            @endforeach
                        </select>
                        @error('jurusan_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama Rombel</label>
                        <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Contoh: RPL 1" required>
                        @error('nama')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="guru_id" class="form-label">Wali Kelas</label>
                        <select id="guru_id" name="guru_id" class="form-select">
                            <option value="">-- Pilih Wali Kelas --</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>{{ $guru->nama }}</option>
                            @endforeach
                        </select>
                        @error('guru_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('super_admin.manajemen-kelas.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection