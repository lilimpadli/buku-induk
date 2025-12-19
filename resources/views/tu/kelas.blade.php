@extends('layouts.app')

@extends('layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Kelas</h3>
        <a href="{{ route('tu.kelas.create') }}" class="btn btn-primary">Tambah Kelas</a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Rombel</th>
                            <th>Wali Kelas</th>
                            <th>Tahun Ajaran / Semester</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $k->tingkat }}</td>
                                <td>{{ optional($k->jurusan)->nama }}</td>
                                <td>
                                    @if(!empty($k->rombels) && $k->rombels->isNotEmpty())
                                        @foreach($k->rombels as $r)
                                            <span class="badge bg-secondary me-1">{{ $r->nama }}</span>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($k->waliKelas) && $k->waliKelas->isNotEmpty())
                                        @foreach($k->waliKelas as $wk)
                                            <div>
                                                <strong>{{ optional($wk->user)->name }}</strong>
                                                <div class="text-muted">{{ optional($wk->user)->nomor_induk }}</div>
                                            </div>
                                        @endforeach
                                    @else
                                        <em class="text-muted">Belum ada wali kelas</em>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($k->waliKelas) && $k->waliKelas->isNotEmpty())
                                        @foreach($k->waliKelas as $wk)
                                            <div>{{ $wk->tahun_ajaran }} / {{ $wk->semester }}</div>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('tu.kelas.detail', $k->id) }}" class="btn btn-sm btn-info">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data kelas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection