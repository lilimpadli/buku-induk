@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Tambah Kelas Baru</h3>
        <a href="{{ route('tu.kelas') }}" class="btn btn-secondary">Kembali</a>
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