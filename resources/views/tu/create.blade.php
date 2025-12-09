@extends('layouts.app')
//tambah kelas//

@section('title', 'Tambah Wali Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Tambah Wali Kelas Baru</h3>
        <a href="{{ route('tu.wali-kelas') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0">Form Tambah Wali Kelas</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('tu.wali-kelas.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nomor_induk">Nomor Induk</label>
                            <input type="text" class="form-control" id="nomor_induk" name="nomor_induk" value="{{ old('nomor_induk') }}" required>
                            @error('nomor_induk')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="kelas_id">Kelas</label>
                            <select class="form-select" id="kelas_id" name="kelas_id" required>
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->tingkat }} - {{ $k->jurusan->nama }}</option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="role">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="wali_kelas" selected>Wali Kelas</option>
                                <option value="guru">Guru</option>
                            </select>
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection