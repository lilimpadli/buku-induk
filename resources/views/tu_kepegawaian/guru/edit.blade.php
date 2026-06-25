@extends('layouts.app')

@section('title', 'Ubah Guru TU Kepegawaian')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Ubah Guru</h3>
        <a href="{{ route('tu_kepegawaian.guru.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tu_kepegawaian.guru.update', $guru->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <!-- Nama -->
            <div class="col-md-6">
                <label class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $guru->nama) }}" class="form-control" required>
            </div>

            <!-- Nomor Induk -->
            <div class="col-md-6">
                <label class="form-label">Nomor Induk <span class="text-danger">*</span></label>
                <input type="text" name="nomor_induk" value="{{ old('nomor_induk', optional($guru->user)->nomor_induk) }}" class="form-control" required>
            </div>

            <!-- NIP -->
            <div class="col-md-6">
                <label class="form-label">NIP <span class="text-danger">*</span></label>
                <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}" class="form-control" required>
            </div>

            <!-- Email -->
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $guru->email) }}" class="form-control">
            </div>

            <!-- Status Kepegawaian -->
            <div class="col-md-6">
                <label class="form-label">Status Kepegawaian</label>
                <select name="status_kepegawaian" class="form-select">
                    <option value="">Pilih Status Kepegawaian</option>
                    <option value="PNS" {{ old('status_kepegawaian', $guru->status_kepegawaian) == 'PNS' ? 'selected' : '' }}>PNS</option>
                    <option value="PPPK" {{ old('status_kepegawaian', $guru->status_kepegawaian) == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                    <option value="Honorer" {{ old('status_kepegawaian', $guru->status_kepegawaian) == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                    <option value="Guru Tetap Yayasan" {{ old('status_kepegawaian', $guru->status_kepegawaian) == 'Guru Tetap Yayasan' ? 'selected' : '' }}>Guru Tetap Yayasan</option>
                    <option value="Guru Tidak Tetap" {{ old('status_kepegawaian', $guru->status_kepegawaian) == 'Guru Tidak Tetap' ? 'selected' : '' }}>Guru Tidak Tetap</option>
                </select>
            </div>

            <!-- Pendidikan -->
            <div class="col-md-6">
                <label class="form-label">Pendidikan Terakhir</label>
                <select name="pendidikan" class="form-select">
                    <option value="">Pilih Pendidikan</option>
                    <option value="S1" {{ old('pendidikan', $guru->pendidikan) == 'S1' ? 'selected' : '' }}>S1</option>
                    <option value="S2" {{ old('pendidikan', $guru->pendidikan) == 'S2' ? 'selected' : '' }}>S2</option>
                    <option value="S3" {{ old('pendidikan', $guru->pendidikan) == 'S3' ? 'selected' : '' }}>S3</option>
                    <option value="D4" {{ old('pendidikan', $guru->pendidikan) == 'D4' ? 'selected' : '' }}>D4</option>
                    <option value="D3" {{ old('pendidikan', $guru->pendidikan) == 'D3' ? 'selected' : '' }}>D3</option>
                </select>
            </div>

            <!-- Gelar Depan -->
            <div class="col-md-6">
                <label class="form-label">Gelar Depan</label>
                <input type="text" name="gelar_depan" value="{{ old('gelar_depan', $guru->gelar_depan) }}" class="form-control" placeholder="Contoh: Dr., Prof., Ir.">
            </div>

            <!-- Gelar Belakang -->
            <div class="col-md-6">
                <label class="form-label">Gelar Belakang</label>
                <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang', $guru->gelar_belakang) }}" class="form-control" placeholder="Contoh: M.Pd., S.Pd., M.Kom.">
            </div>

            <!-- Telepon -->
            <div class="col-md-6">
                <label class="form-label">Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon', $guru->telepon) }}" class="form-control">
            </div>

            <!-- Jenis Kelamin -->
            <div class="col-md-6">
                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Role -->
            <div class="col-md-6">
                <label class="form-label">Role <span class="text-danger">*</span></label>
                <select name="role" class="form-select" required>
                    <option value="">Pilih Role</option>
                    @foreach($roles as $key => $label)
                        <option value="{{ $key }}" {{ old('role', optional($guru->user)->role) == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Jurusan -->
            <div class="col-md-6">
                <label class="form-label">Jurusan</label>
                <select name="jurusan_id" class="form-select">
                    <option value="">Pilih Jurusan</option>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id }}" {{ old('jurusan_id', $guru->jurusan_id) == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tempat Lahir -->
            <div class="col-md-6">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $guru->tempat_lahir) }}" class="form-control">
            </div>

            <!-- Tanggal Lahir -->
            <div class="col-md-6">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('Y-m-d') : '') }}" class="form-control">
            </div>

            <!-- Alamat -->
            <div class="col-12">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $guru->alamat) }}</textarea>
            </div>

            <!-- Password -->
            <div class="col-md-6">
                <label class="form-label">Password baru</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
            </div>
            <div class="col-md-6">
                <label class="form-label">Ulangi Password baru</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Kosongkan jika tidak diubah">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('tu_kepegawaian.guru.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection