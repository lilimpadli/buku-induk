@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Kelas: {{ $kelas->tingkat }} - {{ optional($kelas->jurusan)->nama }}</h3>
        <a href="{{ route('kurikulum.kelas.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow mb-3">
        <div class="card-body">
            <h5>Rombels</h5>
            @if($kelas->rombels->isNotEmpty())
                <ul>
                    @foreach($kelas->rombels as $r)
                        <li>{{ $r->nama }} (Guru: {{ optional($r->guru)->nama ?? '-' }})</li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Belum ada rombel</p>
            @endif
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <h5>Daftar Siswa</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NISN</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Rombel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->nisn }}</td>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->nama_lengkap }}</td>
                                <td>{{ optional($s->rombel)->nama ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">Belum ada siswa di kelas ini</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
