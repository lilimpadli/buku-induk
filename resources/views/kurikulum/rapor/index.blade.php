@extends('layouts.app')

@section('title', 'Daftar Siswa - Kurikulum')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Daftar Siswa</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama Lengkap</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswas as $siswa)
                                <tr>
                                    <td>{{ $siswa->nis }}</td>
                                    <td>{{ $siswa->nama_lengkap }}</td>
                                    <td>{{ $siswa->rombel->nama ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('kurikulum.rapor.show', $siswa->id) }}" class="btn btn-sm btn-primary">Lihat Raport</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data siswa.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection