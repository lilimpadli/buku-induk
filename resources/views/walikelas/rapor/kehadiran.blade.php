@extends('layouts.app')

@section('content')
<div class="container">

<h4>Input Kehadiran – {{ $siswa->nama_lengkap }}</h4>

<form action="{{ route('walikelas.rapor.kehadiran.simpan', $siswa->id) }}" method="POST">
@csrf

<div class="row">
    <div class="col-md-4">
        <label>Sakit</label>
        <input type="number" name="sakit" class="form-control" value="{{ $data->sakit ?? 0 }}">
    </div>
    <div class="col-md-4">
        <label>Izin</label>
        <input type="number" name="izin" class="form-control" value="{{ $data->izin ?? 0 }}">
    </div>
    <div class="col-md-4">
        <label>Tanpa Keterangan</label>
        <input type="number" name="tanpa_keterangan" class="form-control" value="{{ $data->tanpa_keterangan ?? 0 }}">
    </div>
</div>

<div class="mt-3">
    <label>Semester</label>
    <select name="semester" class="form-control">
        <option>Ganjil</option>
        <option>Genap</option>
    </select>
</div>

<div class="mt-3">
    <label>Tahun Ajaran</label>
    <input type="text" name="tahun_ajaran" class="form-control" required placeholder="2024/2025">
</div>

<button class="btn btn-primary mt-3">Simpan</button>

</form>

</div>
@endsection
