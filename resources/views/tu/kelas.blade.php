@extends('layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Kelas</h3>
        <div>
            <a href="{{ route('tu.kelas.create') }}" class="btn btn-primary me-2">
                <i class="fas fa-plus"></i> Tambah Kelas
            </a>
            <a href="{{ route('tu.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
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
                                    <a href="{{ route('tu.kelas.detail', $k->id) }}" class="btn btn-sm btn-info">Detail</a>
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