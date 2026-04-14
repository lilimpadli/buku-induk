@extends('layouts.app')

@section('title', 'Tambah Mata Pelajaran TU Kepegawaian')

@section('content')
<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Tambah Mata Pelajaran</h3>
        <a href="{{ route('tu_kepegawaian.mata-pelajaran.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Form Tambah Mata Pelajaran</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tu_kepegawaian.mata-pelajaran.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                   id="nama" name="nama"
                                   value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kelompok" class="form-label">Kelompok <span class="text-danger">*</span></label>
                                    <select class="form-select @error('kelompok') is-invalid @enderror"
                                            id="kelompok" name="kelompok" required>
                                        <option value="">Pilih Kelompok</option>
                                        <option value="A" {{ old('kelompok') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('kelompok') == 'B' ? 'selected' : '' }}>B</option>
                                    </select>
                                    @error('kelompok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="urutan" class="form-label">Urutan</label>
                                    <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                           id="urutan" name="urutan" min="1"
                                           value="{{ old('urutan') }}">
                                    @error('urutan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Nomor urut di rapor</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kurikulum</label>
                                    <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                        @foreach($kurikulums as $k)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="kurikulum_ids[]" value="{{ $k->id }}" id="kurikulum_{{ $k->id }}">
                                                <label class="form-check-label" for="kurikulum_{{ $k->id }}">
                                                    {{ $k->nama_kurikulum }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('kurikulum_ids')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jurusan</label>
                                    <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                        @foreach($jurusans as $j)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="jurusan_ids[]" value="{{ $j->id }}" id="jurusan_{{ $j->id }}">
                                                <label class="form-check-label" for="jurusan_{{ $j->id }}">
                                                    {{ $j->nama }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('jurusan_ids')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('tu_kepegawaian.mata-pelajaran.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection