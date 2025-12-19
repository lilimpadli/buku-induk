@extends('layouts.app')

@section('title', 'Raport Siswa - ' . $siswa->nama_lengkap)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Raport Siswa: {{ $siswa->nama_lengkap }}</h4>
                    <p class="mb-0">NIS: {{ $siswa->nis }}</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Semester</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($raports as $raport)
                                <tr>
                                    <td>{{ $raport->semester }}</td>
                                    <td>{{ $raport->tahun_ajaran }}</td>
                                    <td>
                                        <a href="{{ route('kurikulum.rapor.detail', [$siswa->id, $raport->semester, str_replace('/', '-', $raport->tahun_ajaran)]) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data raport.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('kurikulum.rapor.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection