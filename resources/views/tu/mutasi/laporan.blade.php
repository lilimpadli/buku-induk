@extends('layouts.app')

@section('title', 'Laporan Mutasi Siswa')

@section('content')
<style>
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --info-color: #3B82F6;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
    }

    h1.h3 {
        font-size: clamp(18px, 4vw, 24px);
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 0;
    }

    h1.h3::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 70%;
        background: linear-gradient(to bottom, var(--danger-color), #DC2626);
        border-radius: 3px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        gap: 15px;
        flex-wrap: wrap;
    }

    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-body {
        padding: 20px;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 10px 20px;
        font-size: clamp(13px, 2.5vw, 14px);
        white-space: nowrap;
    }

    .btn-primary {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(47, 83, 255, 0.3);
    }

    .form-label {
        font-size: clamp(12px, 2.5vw, 14px);
        color: #64748B;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        padding: 10px 15px;
        transition: all 0.3s ease;
        font-size: clamp(13px, 2.5vw, 14px);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
    }

    .report-header {
        text-align: center;
        margin-bottom: 2rem;
        border-bottom: 3px solid #333;
        padding-bottom: 20px;
    }

    .report-header h3 {
        font-size: clamp(18px, 4vw, 24px);
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .report-header p {
        font-size: clamp(12px, 2.5vw, 14px);
        margin-bottom: 0.25rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 2rem;
    }

    .stat-card {
        text-align: center;
        padding: 15px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .stat-card h4 {
        font-size: clamp(20px, 5vw, 32px);
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .stat-card p {
        font-size: clamp(11px, 2.3vw, 13px);
        color: #64748B;
        margin: 0;
    }

    .table {
        margin-bottom: 0;
        font-size: clamp(12px, 2.5vw, 14px);
    }

    .table thead th {
        font-weight: 600;
        color: #1E293B;
        border-bottom: 2px solid #E2E8F0;
        padding: 12px 10px;
        vertical-align: middle;
        text-align: center;
        white-space: nowrap;
        background-color: #F8FAFC;
    }

    .table tbody td {
        padding: 12px 10px;
        vertical-align: middle;
        border-color: #F1F5F9;
    }

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
    }

    .detail-row {
        background-color: #f0f8ff;
    }

    .sk-row {
        background-color: #fff8dc;
    }

    .report-footer {
        margin-top: 50px;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 30px;
    }

    .signature-box {
        text-align: center;
        min-width: 200px;
    }

    .signature-box p:first-child {
        margin-bottom: 60px;
    }

    .signature-box p:last-child {
        margin-bottom: 0;
        font-weight: bold;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #64748B;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    /* Mobile Card View for Statistics */
    .stats-mobile {
        display: none;
    }

    /* Mobile Styles */
    @media (max-width: 767px) {
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }

        h1.h3 {
            font-size: 16px;
            padding-left: 12px;
        }

        h1.h3 i {
            display: none;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .page-header .btn {
            width: 100%;
        }

        .card-body {
            padding: 15px;
        }

        .form-label {
            margin-bottom: 0.4rem;
        }

        .form-control, .form-select {
            padding: 8px 12px;
        }

        .report-header {
            margin-bottom: 1.5rem;
            padding-bottom: 15px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            padding: 12px 8px;
        }

        .stat-card h4 {
            margin-bottom: 0.3rem;
        }

        /* Hide table on mobile, show cards */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            min-width: 700px;
            font-size: 11px;
        }

        .table thead th,
        .table tbody td {
            padding: 8px 6px;
        }

        .report-footer {
            margin-top: 30px;
            flex-direction: column;
            gap: 20px;
        }

        .signature-box {
            min-width: auto;
        }

        .signature-box p:first-child {
            margin-bottom: 40px;
        }

        /* Filter form adjustments */
        .col-md-4,
        .col-md-3,
        .col-md-2 {
            margin-bottom: 0.75rem;
        }
    }

    /* Tablet Styles */
    @media (min-width: 768px) and (max-width: 991px) {
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }

        h1.h3 {
            font-size: 20px;
        }

        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .table {
            font-size: 13px;
        }

        .table thead th,
        .table tbody td {
            padding: 10px 8px;
        }
    }

    /* Desktop Styles */
    @media (min-width: 992px) {
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
        }

        .card-body {
            padding: 24px;
        }

        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    /* Large Desktop */
    @media (min-width: 1200px) {
        .container-fluid {
            max-width: 1140px;
        }
    }

    /* Extra Large Screens */
    @media (min-width: 1400px) {
        .container-fluid {
            max-width: 1320px;
        }
    }

    /* Print Styles */
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

        .page-header {
            display: none;
        }

        .table {
            font-size: 11pt;
        }

        .report-header {
            border-bottom: 2px solid #000;
        }

        .stat-card {
            box-shadow: none;
            border: 1px solid #ddd;
        }

        @page {
            margin: 2cm;
        }
    }
</style>

<div class="container-fluid mt-4">
    <div class="page-header no-print">
        <h1 class="h3">
            <i class="fas fa-file-pdf text-danger"></i> Laporan Mutasi Siswa
        </h1>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print me-1"></i> Cetak/Unduh PDF
        </button>
    </div>

    <!-- Filter Laporan -->
    <div class="card mb-4 no-print">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4 col-12">
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
                <div class="col-md-3 col-12">
                    <label class="form-label">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="col-md-3 col-12">
                    <label class="form-label">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-md-2 col-12 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Laporan -->
    <div class="card">
        <div class="card-body">
            <!-- Header Laporan -->
            <div class="report-header">
                <h3>SMK TEKNOLOGI INFORMATIKA</h3>
                <p>Laporan Data Mutasi Siswa</p>
                <p class="text-muted">
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
            <div class="stats-grid">
                <div class="stat-card">
                    <h4 class="text-primary">{{ count($mutasis) }}</h4>
                    <p>Total Mutasi</p>
                </div>
                <div class="stat-card">
                    <h4 class="text-info">{{ $mutasis->where('status', 'pindah')->count() }}</h4>
                    <p>Pindah Sekolah</p>
                </div>
                <div class="stat-card">
                    <h4 class="text-warning">{{ $mutasis->where('status', 'do')->count() }}</h4>
                    <p>Putus Sekolah</p>
                </div>
                <div class="stat-card">
                    <h4 class="text-success">{{ $mutasis->where('status', 'lulus')->count() }}</h4>
                    <p>Lulus</p>
                </div>
            </div>

            <!-- Tabel Detail -->
            <div class="table-responsive">
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
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center"><strong>{{ $mutasi->siswa->nis }}</strong></td>
                                <td>{{ $mutasi->siswa->nama_lengkap }}</td>
                                <td class="text-center">
                                    <strong>{{ $mutasi->status_label }}</strong>
                                </td>
                                <td class="text-center">{{ $mutasi->tanggal_mutasi->format('d M Y') }}</td>
                                <td>{{ Str::limit($mutasi->keterangan ?? '-', 40) }}</td>
                            </tr>

                            <!-- Detail berdasarkan status -->
                            @if($mutasi->status === 'pindah' && ($mutasi->alasan_pindah || $mutasi->tujuan_pindah))
                                <tr class="detail-row">
                                    <td colspan="6">
                                        <small>
                                            <strong>Alasan Pindah:</strong> {{ $mutasi->alasan_pindah ?? '-' }}<br>
                                            <strong>Sekolah Tujuan:</strong> {{ $mutasi->tujuan_pindah ?? '-' }}
                                        </small>
                                    </td>
                                </tr>
                            @endif

                            @if(in_array($mutasi->status, ['pindah', 'do', 'meninggal']) && ($mutasi->no_sk_keluar || $mutasi->tanggal_sk_keluar))
                                <tr class="sk-row">
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
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p class="mt-3 mb-0">Tidak ada data mutasi siswa untuk periode ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Laporan -->
            <div class="report-footer">
                <div class="signature-box">
                    <p>Mengetahui,</p>
                    <p>Kepala Sekolah</p>
                </div>
                <div class="signature-box">
                    <p>Ciamis, {{ now()->format('d F Y') }}</p>
                    <p>TU/Admin</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection