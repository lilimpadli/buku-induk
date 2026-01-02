@extends('layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Kelas</h3>
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
                            <th>Jumlah Rombel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $k->tingkat }}</td>
                                <td>{{ optional($k->jurusan)->nama }}</td>
                                <td>{{ $k->rombels->count() }}</td>
                                <td>
                                    <a href="{{ route('kurikulum.kelas.show', $k->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">Belum ada kelas</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
