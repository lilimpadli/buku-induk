@extends('layouts.app')

@section('title', 'Input Nilai Raport')

@section('content')
<div class="container mt-4">
    <h3>Input Nilai Raport</h3>
    <p>Pilih siswa untuk menginput nilai raport</p>

    <div class="card shadow">
        <div class="list-group list-group-flush">
            @foreach ($siswas as $siswa)
                <a href="{{ route('walikelas.input_nilai_raport.create', $siswa->id) }}" 
                   class="list-gro`up-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $siswa->nama_lengkap }}</strong>
                        <br>
                        <small>NIS: {{ $siswa->nis }} | NISN: {{ $siswa->nisn }} | Kelas: {{ $siswa->kelas }}</small>
                    </div>
                    <span class="badge bg-primary">Input Nilai</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection