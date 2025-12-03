@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">Daftar Siswa</h3>

    <div class="card shadow">
        <div class="list-group list-group-flush">
            @foreach ($siswa as $s)
                <a href="{{ route('walikelas.siswa.show', $s->id) }}"
                   class="list-group-item list-group-item-action">
                    <strong>{{ $s->nama_lengkap }}</strong>
                    <br>
                    <small>NISN: {{ $s->nisn }}</small>
                </a>
            @endforeach
        </div>
    </div>

</div>
@endsection
