@extends('layouts.app')

@section('title', 'Nilai Raport')

@section('content')
<div class="container mt-4">
    <h3>Nilai Raport Siswa</h3>
    <p>Pilih siswa untuk melihat nilai raport</p>

    <div class="card shadow">
        <div class="list-group list-group-flush">
            @foreach ($siswas as $siswa)
                <a href="{{ route('walikelas.nilai_raport.show', $siswa->id) }}" 
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $siswa->nama_lengkap }}</strong>
                        <br>
                        <small>NIS: {{ $siswa->nis }} | NISN: {{ $siswa->nisn }} | Kelas: {{ $siswa->kelas }}</small>
                    </div>
                    <span class="badge bg-primary">Lihat Nilai</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection