@extends('layouts.app')

@section('title', 'Nilai Raport')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Daftar Nilai Raport Siswa</h3>
    </div>

    <p class="text-muted">Klik salah satu siswa untuk melihat nilai raport.</p>

    <div class="card shadow">
        <div class="list-group list-group-flush">

            @forelse ($siswas as $siswa)
                <a href="{{ route('walikelas.nilai_raport.show', $siswa->id) }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">

                    <div class="d-flex align-items-center">

                        {{-- Avatar --}}
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_lengkap) }}&background=0D8ABC&color=fff&size=40"
                             class="rounded-circle me-3" width="40" height="40">

                        <div>
                            <strong class="d-block">{{ $siswa->nama_lengkap }}</strong>
                            <small class="text-muted">
                                NIS: {{ $siswa->nis }} •
                                NISN: {{ $siswa->nisn }} •
                                Kelas: {{ $siswa->kelas }}
                            </small>
                        </div>

                    </div>

                    <span class="badge bg-primary px-3 py-2">Lihat Nilai</span>
                </a>

            @empty
                <div class="list-group-item py-3 text-center text-muted">
                    <em>Belum ada data siswa.</em>
                </div>
            @endforelse

        </div>
    </div>

</div>
@endsection
