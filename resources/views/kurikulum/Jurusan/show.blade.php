@extends('layouts.app')

@section('title', 'Detail Jurusan - ' . $jurusan->nama)

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-1">Detail Jurusan</h2>
    <p class="text-muted mb-4">{{ $jurusan->nama }}</p>

    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Informasi Jurusan</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td>ID Jurusan</td>
                            <td>: {{ $jurusan->id }}</td>
                        </tr>
                        <tr>
                            <td>Kode Jurusan</td>
                            <td>: {{ $jurusan->kode }}</td>
                        </tr>
                        <tr>
                            <td>Nama Jurusan</td>
                            <td>: {{ $jurusan->nama }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Statistik</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td>Total Kelas</td>
                            <td>: {{ $jurusan->kelas->count() }} kelas</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4" style="border-radius: 15px;">
        <div class="card-body">
            <h5>Daftar Kelas</h5>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tingkat</th>
                            <th>Nama Kelas</th>
                            <th>Total Rombel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jurusan->kelas as $kelas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kelas->tingkat }}</td>
                                <td>{{ $kelas->tingkat }} {{ $jurusan->nama }}</td>
                                <td>{{ $kelas->rombels->count() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada kelas di jurusan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('kurikulum.jurusan.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('kurikulum.jurusan.edit', $jurusan->id) }}" class="btn btn-primary">Edit Jurusan</a>
    </div>
</div>
@endsection