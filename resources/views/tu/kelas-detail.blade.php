@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Kelas: {{ $kelas->tingkat }} - {{ $kelas->jurusan->nama }}</h3>
        <div>
            <a href="{{ route('tu.kelas.edit', $kelas->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('tu.kelas') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    {{-- Informasi Kelas --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Informasi Kelas</h5>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%">Tingkat</td>
                            <td>: {{ $kelas->tingkat }}</td>
                        </tr>
                        <tr>
                            <td>Jurusan</td>
                            <td>: {{ $kelas->jurusan->nama }} ({{ $kelas->jurusan->kode }})</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%">ID Kelas</td>
                            <td>: {{ $kelas->id }}</td>
                        </tr>
                        <tr>
                            <td>Dibuat</td>
                            <td>: {{ $kelas->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- DAFTAR ROMBEL --}}
    <div class="card shadow">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Rombel</h5>
            <span class="badge bg-primary">
                Total {{ $kelas->rombels->sum(fn($r) => $r->siswa->count()) }} Siswa
            </span>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Rombel</th>
                            <th>Jumlah Siswa</th>
                            <th>Wali Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas->rombels as $rombel)
                        <tr>
                            <td>{{ $rombel->nama }}</td>
                            <td>{{ $rombel->siswa->count() }} siswa</td>
                            <td>{{ $rombel->waliKelas->name ?? '-' }}</td>
                            <td>
                                <button 
                                    class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalRombel{{ $rombel->id }}">
                                    <i class="fas fa-users"></i> Lihat Siswa
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>


{{-- ========================= --}}
{{-- MODAL SEMUA ROMBEL        --}}
{{-- ========================= --}}
@foreach ($kelas->rombels as $rombel)
<div class="modal fade" id="modalRombel{{ $rombel->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Siswa Rombel: {{ $rombel->nama }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                @if ($rombel->siswa->count() == 0)
                    <p class="text-muted text-center">Tidak ada siswa di rombel ini.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rombel->siswa as $siswa)
                            <tr>
                                <td>{{ $siswa->nis }}</td>
                                <td>{{ $siswa->nama_lengkap }}</td>
                                <td>{{ $siswa->jenis_kelamin }}</td>
                                <td>
                                    <a href="{{ route('tu.siswa.detail', $siswa->id) }}" class="btn btn-sm btn-info">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
@endforeach


@endsection
