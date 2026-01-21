@extends('layouts.app')

@section('title', 'Laporan Mutasi Siswa')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-file-pdf text-danger"></i> Laporan Mutasi Siswa
            </h1>
        </div>
        <div class="col-md-4 text-end">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Cetak/Unduh PDF
            </button>
        </div>
    </div>

    <!-- Filter Laporan -->
    <div class="card mb-4 no-print">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Status Mutasi</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Laporan -->
    <div class="card">
        <div class="card-body">
            <!-- Header Laporan -->
            <div class="text-center mb-5" style="border-bottom: 3px solid #333; padding-bottom: 20px;">
                <h3 class="mb-0" style="font-weight: bold;">SMK TEKNOLOGI INFORMATIKA</h3>
                <p class="mb-0">Laporan Data Mutasi Siswa</p>
                <p class="text-muted mb-3">
                    @if(request('tanggal_dari') && request('tanggal_sampai'))
                        Periode: {{ \Carbon\Carbon::parse(request('tanggal_dari'))->format('d F Y') }} s/d {{ \Carbon\Carbon::parse(request('tanggal_sampai'))->format('d F Y') }}
                    @elseif(request('status'))
                        Status: {{ $statuses[request('status')] ?? 'Semua Status' }}
                    @else
                        Laporan Lengkap Mutasi Siswa
                    @endif
                </p>
            </div>

            <!-- Statistik -->
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="text-center">
                        <h4 class="text-primary">{{ count($mutasis) }}</h4>
                        <p class="text-muted">Total Mutasi</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h4 class="text-info">{{ $mutasis->where('status', 'pindah')->count() }}</h4>
                        <p class="text-muted">Pindah Sekolah</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h4 class="text-warning">{{ $mutasis->where('status', 'do')->count() }}</h4>
                        <p class="text-muted">Putus Sekolah</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h4 class="text-success">{{ $mutasis->where('status', 'lulus')->count() }}</h4>
                        <p class="text-muted">Lulus</p>
                    </div>
                </div>
            </div>

            <!-- Tabel Detail -->
            <div style="margin-top: 30px;">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Status Mutasi</th>
                            <th>Tanggal Mutasi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mutasis as $index => $mutasi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $mutasi->siswa->nis }}</strong></td>
                                <td>{{ $mutasi->siswa->nama_lengkap }}</td>
                                <td>
                                    <strong>{{ $mutasi->status_label }}</strong>
                                </td>
                                <td>{{ $mutasi->tanggal_mutasi->format('d F Y') }}</td>
                                <td>{{ $mutasi->keterangan ?? '-' }}</td>
                            </tr>

                            <!-- Detail berdasarkan status -->
                            @if($mutasi->status === 'pindah' && ($mutasi->alasan_pindah || $mutasi->tujuan_pindah))
                                <tr style="background-color: #f0f8ff;">
                                    <td colspan="6">
                                        <small>
                                            <strong>Alasan Pindah:</strong> {{ $mutasi->alasan_pindah ?? '-' }}<br>
                                            <strong>Sekolah Tujuan:</strong> {{ $mutasi->tujuan_pindah ?? '-' }}
                                        </small>
                                    </td>
                                </tr>
                            @endif

                            @if(in_array($mutasi->status, ['pindah', 'do', 'meninggal']) && ($mutasi->no_sk_keluar || $mutasi->tanggal_sk_keluar))
                                <tr style="background-color: #fff8dc;">
                                    <td colspan="6">
                                        <small>
                                            <strong>No. SK Keluar:</strong> {{ $mutasi->no_sk_keluar ?? '-' }}<br>
                                            <strong>Tanggal SK Keluar:</strong> {{ $mutasi->tanggal_sk_keluar ? $mutasi->tanggal_sk_keluar->format('d F Y') : '-' }}
                                        </small>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox" style="font-size: 1.5rem;"></i>
                                    <p class="mt-2">Tidak ada data mutasi siswa untuk periode ini</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Laporan -->
            <div style="margin-top: 50px; display: flex; justify-content: space-around;">
                <div style="text-align: center;">
                    <p style="margin-bottom: 60px;">Mengetahui,</p>
                    <p style="margin-bottom: 0; font-weight: bold;">Kepala Sekolah</p>
                </div>
                <div style="text-align: center;">
                    <p style="margin-bottom: 60px;">Ciamis, {{ now()->format('d F Y') }}</p>
                    <p style="margin-bottom: 0; font-weight: bold;">TU/Admin</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        
        body {
            background: white;
        }
        
        .card {
            border: none;
            box-shadow: none;
            page-break-inside: avoid;
        }
    }
</style>
@endpush
@endsection
