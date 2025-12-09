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
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $k)
                            <tr>
                                <td>{{ $k->tingkat }}</td>
                                <td>{{ $k->jurusan->nama }}</td>
                                <td>
                                    <a href="{{ route('tu.kelas.detail', $k->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('tu.kelas.edit', $k->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('tu.kelas.destroy', $k->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection