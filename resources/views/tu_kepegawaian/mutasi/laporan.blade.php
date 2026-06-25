@extends('layouts.app')

@section('title', 'Laporan Mutasi Pegawai')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold">Laporan Mutasi Pegawai</h4>
                <button onclick="window.print()" class="btn btn-success">
                    <i class="fas fa-print me-1"></i> Cetak Laporan
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mutasis as $mutasi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mutasi->pegawai->nama ?? 'N/A' }}</td>
                            <td>{{ $mutasi->jenis }}</td>
                            <td>{{ \Carbon\Carbon::parse($mutasi->tanggal)->format('d M Y') }}</td>
                            <td>{{ $mutasi->keterangan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Data tidak ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection