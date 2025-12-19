@extends('layouts.app')

@section('title', 'Detail Wali Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Wali Kelas</h3>
        <a href="{{ route('tu.wali-kelas') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama Lengkap</th>
                            <td>{{ $waliKelas->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Induk</th>
                            <td>{{ $waliKelas->user->nomor_induk }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $waliKelas->user->email }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Kelas</th>
                            <td>{{ $waliKelas->kelas->tingkat }}</td>
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td>{{ $waliKelas->jurusan->nama }}</td>
                        </tr>
                        <tr>
                            <th>Rombel</th>
                            <td>{{ $waliKelas->rombel->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <td>{{ $waliKelas->tahun_ajaran }}</td>
                        </tr>
                        <tr>
                            <th>Semester</th>
                            <td>{{ $waliKelas->semester }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-{{ $waliKelas->status == 'Aktif' ? 'success' : 'danger' }}">
                                    {{ $waliKelas->status }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('tu.wali-kelas.edit', $waliKelas->id) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('tu.wali-kelas.destroy', $waliKelas->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection