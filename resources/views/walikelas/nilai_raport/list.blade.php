@extends('layouts.app')

@section('title', 'Riwayat Rapor')

@section('content')
<div class="container mt-4">

    <h3>Riwayat Rapor — {{ $siswa->nama_lengkap }}</h3>
    <p class="text-muted">Pilih raport berdasarkan semester dan tahun ajaran</p>

    <div class="card shadow">
        <div class="list-group list-group-flush">

            @forelse ($raports as $r)
                <a href="{{ route('walikelas.nilai_raport.show', [
                        'siswa_id' => $siswa->id,
                        'semester' => $r->semester,
                        'tahun' => $r->tahun_ajaran
                    ]) }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between">

                    <div>
                        <strong>Semester: {{ $r->semester ?? '-' }}</strong> <br>
                        <small>Tahun Ajaran: {{ $r->tahun_ajaran ?? '-' }}</small>
                    </div>

                    <span class="badge bg-primary">Lihat Rapor</span>

                </a>
            @empty

                <div class="p-3 text-center text-muted">
                    Belum ada raport tersimpan
                </div>

            @endforelse

        </div>
    </div>

</div>
@endsection
