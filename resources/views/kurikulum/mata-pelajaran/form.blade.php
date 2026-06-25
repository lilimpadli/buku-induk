@extends('layouts.app')

@section('title', $title ?? 'Mata Pelajaran')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(100px, -100px);
        pointer-events: none;
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        position: relative;
        z-index: 1;
    }

    .form-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        width: 100%;
    }

    .form-card .card-header {
        background: white;
        border-bottom: 1px solid #E2E8F0;
        padding: 1rem 1.5rem;
    }

    .form-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: clamp(0.9rem, 4vw, 1.1rem);
    }

    .form-card .card-header h5 i {
        color: #667eea;
        margin-right: 8px;
    }

    .form-card .card-body {
        padding: 2rem;
    }

    .btn-save {
        background: var(--primary-gradient);
        border: none;
        padding: 8px 28px;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-cancel {
        background: #64748B;
        border: none;
        padding: 8px 28px;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-cancel:hover {
        background: #475569;
        transform: translateY(-2px);
        color: white;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #1E293B;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        padding: 0.6rem 0.9rem;
        transition: var(--transition);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .checkbox-group {
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 0.8rem 1rem;
        max-height: 150px;
        overflow-y: auto;
    }

    .checkbox-group .form-check {
        padding: 4px 0;
        margin: 0;
    }

    .checkbox-group .form-check-input {
        margin-top: 0.2rem;
    }

    .checkbox-group .form-check-label {
        font-size: 0.85rem;
        font-weight: 400;
        color: #1E293B;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1.2rem 1rem;
        }
        
        .page-header h3 {
            font-size: 1.3rem;
        }

        .form-card .card-body {
            padding: 1.2rem;
        }

        .btn-save,
        .btn-cancel {
            width: 100%;
            margin-bottom: 8px;
            justify-content: center;
        }

        .border-top {
            text-align: center;
        }

        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .col-md-6 {
            padding-left: 8px;
            padding-right: 8px;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <h3><i class="fas fa-book-open me-2"></i> {{ $title }}</h3>
        <div class="text-muted">Isi form berikut untuk mengelola mata pelajaran</div>
    </div>

    <div class="card form-card">
        <div class="card-header">
            <h5><i class="fas fa-pen"></i> Form {{ $title }}</h5>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ $action }}" method="POST">
                @csrf
                @if(isset($method) && strtoupper($method) != 'POST')
                    @method($method)
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-tag text-primary me-1"></i> Nama Mata Pelajaran <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                               value="{{ old('nama', $mapel->nama ?? '') }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-layer-group text-primary me-1"></i> Kelompok <span class="text-danger">*</span>
                        </label>
                        <select name="kelompok" class="form-select @error('kelompok') is-invalid @enderror" required>
                            <option value="A" {{ old('kelompok', $mapel->kelompok ?? '') == 'A' ? 'selected' : '' }}>A (Umum)</option>
                            <option value="B" {{ old('kelompok', $mapel->kelompok ?? '') == 'B' ? 'selected' : '' }}>B (Kejuruan)</option>
                        </select>
                        @error('kelompok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-graduation-cap text-primary me-1"></i> Kurikulum
                        </label>
                        @php
                            $selKur = old('kurikulum_ids', isset($mapel) ? $mapel->kurikulums->pluck('id')->toArray() : []);
                        @endphp
                        <div class="checkbox-group">
                            @foreach(($kurikulums ?? collect()) as $k)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="kurikulum_ids[]" value="{{ $k->id }}" 
                                           id="kurikulum_{{ $k->id }}" {{ in_array($k->id, $selKur) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="kurikulum_{{ $k->id }}">
                                        {{ $k->nama_kurikulum }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('kurikulum_ids')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-building text-primary me-1"></i> Jurusan
                        </label>
                        @php
                            $selJur = old('jurusan_ids', isset($mapel) ? $mapel->jurusans->pluck('id')->toArray() : []);
                        @endphp
                        <div class="checkbox-group">
                            @foreach(($jurusans ?? collect()) as $j)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="jurusan_ids[]" value="{{ $j->id }}" 
                                           id="jurusan_{{ $j->id }}" {{ in_array($j->id, $selJur) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jurusan_{{ $j->id }}">
                                        {{ $j->nama }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('jurusan_ids')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-sort-numeric-up text-primary me-1"></i> Urutan
                        </label>
                        <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" 
                               value="{{ old('urutan', $mapel->urutan ?? '') }}">
                        @error('urutan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-layer-group text-primary me-1"></i> Tingkat (centang yang berlaku)
                        </label>
                        @php
                            $sel = old('tingkat', isset($mapel) ? $mapel->tingkats->pluck('tingkat')->toArray() : []);
                        @endphp
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tingkat[]" value="10" id="t10" {{ in_array(10, $sel) ? 'checked' : '' }}>
                                <label class="form-check-label" for="t10">Kelas 10</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tingkat[]" value="11" id="t11" {{ in_array(11, $sel) ? 'checked' : '' }}>
                                <label class="form-check-label" for="t11">Kelas 11</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tingkat[]" value="12" id="t12" {{ in_array(12, $sel) ? 'checked' : '' }}>
                                <label class="form-check-label" for="t12">Kelas 12</label>
                            </div>
                        </div>
                        @error('tingkat')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-save text-white">
                        <i class="fas fa-save me-2"></i> Simpan
                    </button>
                    <a href="{{ route('kurikulum.mata-pelajaran.index') }}" class="btn btn-cancel text-white">
                        <i class="fas fa-arrow-left me-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection