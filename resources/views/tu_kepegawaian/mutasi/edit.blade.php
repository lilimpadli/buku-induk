@extends('layouts.app')

@section('title', 'Edit Mutasi Pegawai')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h4 class="fw-bold mb-4">Edit Mutasi Pegawai</h4>
            
            {{-- Form Update --}}
            <form action="{{ url('/tu_kepegawaian/mutasi/' . $mutasi->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Input Hidden untuk mempertahankan guru_id agar validasi tidak error --}}
                <input type="hidden" name="guru_id" value="{{ $mutasi->guru_id }}">

                <div class="mb-3">
                    <label class="form-label">Jenis Mutasi</label>
                    <select name="jenis" class="form-select" required>
                        <option value="Masuk" {{ $mutasi->jenis == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                        <option value="Keluar" {{ $mutasi->jenis == 'Keluar' ? 'selected' : '' }}>Keluar</option>
                        <option value="Meninggal" {{ $mutasi->jenis == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                        <option value="Pindah Tugas" {{ $mutasi->jenis == 'Pindah Tugas' ? 'selected' : '' }}>Pindah Tugas</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ $mutasi->tanggal }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ $mutasi->keterangan }}</textarea>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Data</button>
                    <a href="{{ url('/tu_kepegawaian/mutasi') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection