@extends('layouts.app')

@section('title', 'Tambah Mutasi Pegawai')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h4 class="mb-4 fw-bold">Tambah Data Mutasi Pegawai</h4>
            
            <form action="{{ route('tu_kepegawaian.mutasi.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih Pegawai</label>
                    <select name="guru_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Pegawai --</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Jenis Mutasi</label>
                    <select name="jenis" class="form-select">
                        <option value="Masuk">Masuk</option>
                        <option value="Keluar">Keluar</option>
                        <option value="Meninggal">Meninggal</option>
                        <option value="Pindah Tugas">Pindah Tugas</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="{{ route('tu_kepegawaian.mutasi.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection