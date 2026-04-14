@extends('layouts.app')

@section('title', 'Detail Mata Pelajaran TU Kepegawaian')

@section('content')
<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Detail Mata Pelajaran</h3>
        <div>
            <a href="{{ route('tu_kepegawaian.mata-pelajaran.edit', $mataPelajaran->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('tu_kepegawaian.mata-pelajaran.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Mata Pelajaran</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Nama Mata Pelajaran</th>
                            <td>: {{ $mataPelajaran->nama }}</td>
                        </tr>
                        <tr>
                            <th>Kelompok</th>
                            <td>: <span class="badge bg-{{ $mataPelajaran->kelompok == 'A' ? 'primary' : 'success' }}">{{ $mataPelajaran->kelompok }}</span></td>
                        </tr>
                        <tr>
                            <th>Urutan</th>
                            <td>: {{ $mataPelajaran->urutan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kurikulum</th>
                            <td>:
                                @if($mataPelajaran->kurikulums->count() > 0)
                                    @foreach($mataPelajaran->kurikulums as $kurikulum)
                                        <span class="badge bg-info me-1">{{ $kurikulum->nama_kurikulum }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td>:
                                @if($mataPelajaran->jurusans->count() > 0)
                                    @foreach($mataPelajaran->jurusans as $jurusan)
                                        <span class="badge bg-warning text-dark me-1">{{ $jurusan->nama }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>: {{ $mataPelajaran->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diubah</th>
                            <td>: {{ $mataPelajaran->updated_at->format('d F Y H:i') }}</td>
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
                    <div class="text-center mb-3">
                        <h2 class="text-primary">{{ $mataPelajaran->tingkats->count() }}</h2>
                        <p class="mb-0">Tingkat</p>
                    </div>
                    <div class="text-center">
                        <h2 class="text-success">{{ $mataPelajaran->nilai->count() }}</h2>
                        <p class="mb-0">Nilai Raport</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($mataPelajaran->tingkats->count() > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Tingkat/Kelas yang Menggunakan Mata Pelajaran Ini</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tingkat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mataPelajaran->tingkats as $tingkat)
                            <tr>
                                <td>{{ $tingkat->tingkat }}</td>
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