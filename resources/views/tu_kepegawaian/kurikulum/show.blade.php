@extends('layouts.app')

@section('title', 'Detail Kurikulum TU Kepegawaian')

@section('content')
<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Detail Kurikulum</h3>
        <div>
            <a href="{{ route('tu_kepegawaian.kurikulum.edit', $kurikulum->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('tu_kepegawaian.kurikulum.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Kurikulum</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Nama Kurikulum</th>
                            <td>: {{ $kurikulum->nama_kurikulum }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>: {{ $kurikulum->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diubah</th>
                            <td>: {{ $kurikulum->updated_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistik</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h2 class="text-primary">{{ $kurikulum->mataPelajarans->count() }}</h2>
                        <p class="mb-0">Mata Pelajaran</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($kurikulum->mataPelajarans->count() > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Mata Pelajaran dalam Kurikulum Ini</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kelompok</th>
                            <th>Urutan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kurikulum->mataPelajarans as $mapel)
                            <tr>
                                <td>{{ $mapel->nama }}</td>
                                <td>{{ $mapel->kelompok }}</td>
                                <td>{{ $mapel->urutan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection