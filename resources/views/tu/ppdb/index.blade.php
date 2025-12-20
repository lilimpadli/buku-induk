@extends('layouts.app')

@section('title', 'PPDB - Daftar Pendaftar')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Pendaftar PPDB</h5>
            <a href="{{ route('ppdb.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-plus"></i> Tambah Pendaftar Baru
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! session('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>NISN</th>
                            <th>Jalur</th>
                            <th>Sesi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ppdbs as $ppdb)
                            <tr>
                                <td>{{ $ppdb->nama_lengkap }}</td>
                                <td>{{ $ppdb->nisn ?? '-' }}</td>
                                <td>{{ optional($ppdb->jalur)->nama_jalur ?? '-' }}</td>
                                <td>{{ optional($ppdb->sesi)->tahun_ajaran ?? '-' }}</td>
                                <td>
                                    @if($ppdb->status == 'diterima')
                                        <span class="badge bg-warning">Diterima</span>
                                    @elseif($ppdb->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $ppdb->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ppdb->status == 'diterima')
                                        <a href="{{ route('tu.ppdb.assign.form', $ppdb->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-user-plus"></i> Assign Rombel
                                        </a>
                                    @else
                                        <span class="text-muted">Sudah diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data pendaftar</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection