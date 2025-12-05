@extends('layouts.app')

@section('content')
<div class="container">

<h4>Input Ekstrakurikuler – {{ $siswa->nama_lengkap }}</h4>

<form action="{{ route('walikelas.rapor.ekstra.simpan', $siswa->id) }}" method="POST">
@csrf

<div class="mb-3">
    <label>Nama Ekstrakurikuler</label>
    <input type="text" name="nama_ekstra" class="form-control" required>
</div>

<div class="mb-3">
    <label>Predikat</label>
    <select name="predikat" class="form-control">
        <option>A</option>
        <option>B</option>
        <option>C</option>
    </select>
</div>

<div class="mb-3">
    <label>Keterangan</label>
    <textarea name="keterangan" class="form-control"></textarea>
</div>

<button class="btn btn-primary">Simpan</button>

</form>

</div>
@endsection
