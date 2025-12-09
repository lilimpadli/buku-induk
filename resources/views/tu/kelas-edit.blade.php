@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Edit Kelas: {{ $kelas->tingkat }} - {{ $kelas->jurusan->nama }}</h3>
        <a href="{{ route('tu.kelas.detail', $kelas->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0">Form Edit Kelas</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('tu.kelas.update', $kelas->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Tingkat --}}
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="mb-1">Tingkat Kelas</label>
                            <select name="tingkat" class="form-select @error('tingkat') is-invalid @enderror" required>
                                <option value="X"  {{ $kelas->tingkat == 'X'  ? 'selected' : '' }}>X</option>
                                <option value="XI" {{ $kelas->tingkat == 'XI' ? 'selected' : '' }}>XI</option>
                                <option value="XII"{{ $kelas->tingkat == 'XII'? 'selected' : '' }}>XII</option>
                            </select>
                            @error('tingkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Jurusan --}}
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="mb-1">Jurusan</label>
                            <select name="jurusan_id" class="form-select @error('jurusan_id') is-invalid @enderror" required>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}"
                                        {{ $kelas->jurusan_id == $jurusan->id ? 'selected' : '' }}>
                                        {{ $jurusan->nama }} ({{ $jurusan->kode }})
                                    </option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Kelas
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
