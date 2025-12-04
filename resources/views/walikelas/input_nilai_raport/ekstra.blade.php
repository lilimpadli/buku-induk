@extends('layouts.app')

@section('title', 'Input Ekstrakurikuler')

@section('content')
<div class="container mt-4">
    <h3>Ekstrakurikuler - {{ $siswa->nama }}</h3>

    <form action="{{ route('walikelas.rapor.ekstra.simpan', $siswa->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Kegiatan Ekstrakurikuler</label>
            <input type="text" name="kegiatan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <input type="text" name="keterangan" class="form-control" required>
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
