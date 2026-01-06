@extends('layouts.app')

@section('title', $title ?? 'Mata Pelajaran')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ $title }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ $action }}" method="POST">
                @csrf
                @if(isset($method) && strtoupper($method) != 'POST')
                    @method($method)
                @endif

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $mapel->nama ?? '') }}" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelompok</label>
                    <select name="kelompok" class="form-select @error('kelompok') is-invalid @enderror" required>
                        <option value="A" {{ old('kelompok', $mapel->kelompok ?? '') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('kelompok', $mapel->kelompok ?? '') == 'B' ? 'selected' : '' }}>B</option>
                    </select>
                    @error('kelompok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jurusan (opsional)</label>
                    @php $selJur = old('jurusan_id', $mapel->jurusan_id ?? ''); @endphp
                    <select name="jurusan_id" class="form-select @error('jurusan_id') is-invalid @enderror">
                        <option value="">Semua Jurusan</option>
                        @foreach(($jurusans ?? collect()) as $j)
                            <option value="{{ $j->id }}" {{ (string)$selJur === (string)$j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                        @endforeach
                    </select>
                    @error('jurusan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', $mapel->urutan ?? '') }}">
                    @error('urutan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tingkat (centang untuk memilih: 10/11/12)</label>
                    @php
                        $sel = old('tingkat', isset($mapel) ? $mapel->tingkats->pluck('tingkat')->toArray() : []);
                    @endphp
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

                <div class="d-grid gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kurikulum.mata-pelajaran.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
