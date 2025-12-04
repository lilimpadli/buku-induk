@extends('layouts.app')

@section('title', 'Daftar Wali Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Wali Kelas</h3>
        <a href="{{ route('tu.dashboard') }}" class="btn btn-secondary">Kembali</a>
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($waliKelas as $wk)
                            <tr>
                                <td>{{ $wk->name }}</td>
                                <td>{{ $wk->nomor_induk }}</td>
                                <td>{{ $wk->email }}</td>
                                <td>
                                    <a href="{{ route('tu.wali-kelas.detail', $wk->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
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