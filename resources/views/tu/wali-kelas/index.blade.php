@extends('layouts.app')

@section('title', 'Daftar Wali Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Wali Kelas</h3>
        <div>
            <a href="{{ route('tu.wali-kelas.create') }}" class="btn btn-primary me-2">
                <i class="fas fa-plus"></i> Tambah Wali Kelas
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
                            <th>Nama</th>
                            <th>Nomor Induk</th>
                            <th>Email</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Rombel</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($waliKelas as $wk)
                            <tr>
                                <td>{{ optional($wk->user)->name }}</td>
                                <td>{{ optional($wk->user)->nomor_induk }}</td>
                                <td>{{ optional($wk->user)->email }}</td>
                                <td>{{ optional($wk->kelas)->tingkat }}</td>
                                <td>{{ optional($wk->jurusan)->nama }}</td>
                                <td>{{ optional($wk->rombel)->nama }}</td>
                                <td>{{ $wk->tahun_ajaran }}</td>
                                <td>{{ $wk->semester }}</td>
                                <td>
                                    <span class="badge bg-{{ $wk->status == 'Aktif' ? 'success' : 'danger' }}">
                                        {{ $wk->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('tu.wali-kelas.detail', $wk->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('tu.wali-kelas.edit', $wk->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('tu.wali-kelas.destroy', $wk->id) }}" method="POST" class="d-inline">
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
            
            <div class="d-flex justify-content-center mt-3">
                {{ $waliKelas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection