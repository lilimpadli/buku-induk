@extends('layouts.app')

@section('title', 'Detail Alumni')

@section('content')
<div class="container py-3">
    <h3>Detail Alumni: {{ $siswa->nama_lengkap }}</h3>

    <ul class="list-group">
        <li class="list-group-item"><strong>NIS:</strong> {{ $siswa->nis }}</li>
        <li class="list-group-item"><strong>NISN:</strong> {{ $siswa->nisn }}</li>
        <li class="list-group-item"><strong>Tempat, Tanggal Lahir:</strong> {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}</li>
        <li class="list-group-item"><strong>Alamat:</strong> {{ $siswa->alamat }}</li>
        <li class="list-group-item"><strong>Rombel:</strong> {{ optional($siswa->rombel)->nama ?? '-' }}</li>
    </ul>
</div>
@endsection
