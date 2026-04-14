@extends('layouts.app')

@section('title', 'Edit Kurikulum TU Kepegawaian')

@section('content')
<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Edit Kurikulum</h3>
        <a href="{{ route('tu_kepegawaian.kurikulum.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Form Edit Kurikulum</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tu_kepegawaian.kurikulum.update', $kurikulum->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_kurikulum" class="form-label">Nama Kurikulum <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_kurikulum') is-invalid @enderror"
                                   id="nama_kurikulum" name="nama_kurikulum"
                                   value="{{ old('nama_kurikulum', $kurikulum->nama_kurikulum) }}" required>
                            @error('nama_kurikulum')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('tu_kepegawaian.kurikulum.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection