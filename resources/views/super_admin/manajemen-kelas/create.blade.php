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

                    <form action="{{ route('tu.kelas.store') }}" method="POST">
                        @csrf

                        <!-- TINGKAT -->
                        <div class="mb-3">
                            <label for="tingkat" class="form-label fw-semibold">TINGKAT <span class="text-danger">*</span></label>
                            <select name="tingkat" id="tingkat" class="form-control form-control-lg" required>
                                <option value="" disabled selected>-- Pilih Tingkat --</option>
                                @foreach($tingkats as $t)
                                    <option value="{{ $t }}">Kelas {{ $t }}</option>
                                @endforeach
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
                            <input type="text" name="nama" id="nama" class="form-control form-control-lg" placeholder="Contoh: 1, 2, 3"
                                value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- WALI KELAS (DIPINDAHKAN KE BAWAH) -->
                        <div class="mb-4">
                            <label for="guru_id" class="form-label fw-semibold">Wali Kelas</label>
                            <select name="guru_id" id="guru_id" class="form-control form-control-lg" required>
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
                            <a href="{{ route('tu.kelas.index') }}" class="btn btn-light btn-lg flex-fill">Tutup</a>
                            <button type="submit" class="btn btn-primary btn-lg flex-fill">Simpan Data</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Tambah Kelas Baru</h3>
        <a href="{{ route('tu.kelas.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0">Form Tambah Kelas</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('tu.kelas.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="tingkat">Tingkat Kelas</label>
                            <select class="form-select" id="tingkat" name="tingkat" required>
                                <option value="" disabled selected>-- Pilih Tingkat --</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                            @error('tingkat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jurusan_id">Jurusan</label>
                            <select class="form-select" id="jurusan_id" name="jurusan_id" required>
                                <option value="" disabled selected>-- Pilih Jurusan --</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama }} ({{ $jurusan->kode }})</option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card shadow mt-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Daftar Jurusan Tersedia</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Jurusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jurusans as $jurusan)
                            <tr>
                                <td>{{ $jurusan->kode }}</td>
                                <td>{{ $jurusan->nama }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Tambah Kelas Baru</h3>
        <a href="{{ route('tu.kelas.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0">Form Tambah Kelas</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('tu.kelas.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="tingkat">Tingkat Kelas</label>
                            <select class="form-select" id="tingkat" name="tingkat" required>
                                <option value="" disabled selected>-- Pilih Tingkat --</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                            @error('tingkat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jurusan_id">Jurusan</label>
                            <select class="form-select" id="jurusan_id" name="jurusan_id" required>
                                <option value="" disabled selected>-- Pilih Jurusan --</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama }} ({{ $jurusan->kode }})</option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card shadow mt-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Daftar Jurusan Tersedia</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Jurusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jurusans as $jurusan)
                            <tr>
                                <td>{{ $jurusan->kode }}</td>
                                <td>{{ $jurusan->nama }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection