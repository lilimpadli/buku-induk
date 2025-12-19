@extends('layouts.app')

@section('title', 'Tambah Jurusan')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Tambah Jurusan</h2>

    <div class="card shadow-sm border-0" style="border-radius: 15px; max-width: 600px;">
        <div class="card-body">
            <form action="{{ route('kurikulum.jurusan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="kode" class="form-label">Nama Singkat Jurusan</label>
                    <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode') }}" required>
                    @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Jurusan</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kurikulum.jurusan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection