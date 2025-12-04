@extends('layouts.app')

@section('title', 'Input Kehadiran')

@section('content')
<div class="container mt-4">
    <h3>Kehadiran - {{ $siswa->nama }}</h3>

    <form action="{{ route('walikelas.rapor.kehadiran.simpan', $siswa->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Sakit</label>
            <input type="number" name="sakit" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Izin</label>
            <input type="number" name="izin" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tanpa Keterangan</label>
            <input type="number" name="alpha" class="form-control" required>
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
