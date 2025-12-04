@extends('layouts.app')

@section('title', 'Input Info Rapor')

@section('content')
<div class="container mt-4">
    <h3>Info Rapor - {{ $siswa->nama }}</h3>

    <form action="{{ route('walikelas.rapor.info.simpan', $siswa->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Wali Kelas</label>
            <input type="text" name="wali_kelas" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nama Kepala Sekolah</label>
            <input type="text" name="kepala_sekolah" class="form-control" required>
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
