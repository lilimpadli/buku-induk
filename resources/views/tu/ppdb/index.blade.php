@extends('layouts.app')

@section('title', 'PPDB - Daftar Jurusan')

@section('content')
<div class="container-fluid">
    <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Jurusan PPDB</h5>
            <a href="{{ route('ppdb.create') }}" class="btn btn-sm btn-outline-primary">
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

            <!-- Tahap sections removed — showing jurusan only -->

            <div class="row">
                @forelse ($jurusans as $jurusan)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $jurusan->nama }}</h5>
                                <p class="card-text">{{ $jurusan->deskripsi ?? 'Jurusan ini siap menerima pendaftar PPDB' }}</p>
                                <a href="{{ route('tu.ppdb.jurusan.show', $jurusan->id) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            Tidak ada jurusan yang tersedia
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection