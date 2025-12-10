@extends('layouts.app')

@section('title', 'Nilai Raport')

@section('content')
<div class="container mt-4">
    <h3>Nilai Raport Siswa</h3>
    <p>Pilih siswa untuk melihat daftar raport berdasarkan semester.</p>

    <div class="card shadow">
        <div class="list-group list-group-flush">

            @foreach ($siswas as $siswa)
                <div class="list-group-item d-flex justify-content-between align-items-center">

                    <div>
                        <strong>{{ $siswa->nama_lengkap }}</strong><br>
                        <small>
                            NIS: {{ $siswa->nis }} |
                            NISN: {{ $siswa->nisn }} |
                            Kelas: {{ $siswa->kelas }}
                        </small>
                    </div>

                    <div class="text-end">

                        

                        {{-- Tombol List Raport --}}
                        <a href="{{ route('walikelas.nilai_raport.list', $siswa->id) }}"
                           class="btn btn-secondary btn-sm">
                            Semua Raport
                        </a>

                    </div>

                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
