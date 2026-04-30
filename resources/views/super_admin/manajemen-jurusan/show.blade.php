@extends('layouts.app')

@section('title', 'Detail Jurusan - ' . $jurusan->nama)

@section('content')
<style>
    /* ===================== STYLE DETAIL JURUSAN - RESPONSIVE ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
    }

    /* Page Header */
    h2.fw-bold {
        font-size: 28px;
        color: #1E293B;
        font-weight: 700;
        margin-bottom: 0.25rem !important;
    }

    p.text-muted {
        color: #64748B !important;
        font-size: 15px;
        margin-bottom: 1.5rem !important;
    }

    /* Card Styles */
    .card {
        border-radius: 15px !important;
        border: none;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-body {
        padding: 2rem;
    }

    .card-body h5 {
        font-weight: 600;
        color: #1E293B;
        font-size: 18px;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #E2E8F0;
    }

    /* Table Styles */
    .table-borderless {
        margin-bottom: 0;
    }

    .table-borderless tr {
        transition: background-color 0.2s ease;
    }

    .table-borderless tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
    }

    .table-borderless td {
        padding: 12px 8px;
        vertical-align: top;
        font-size: 15px;
        color: #334155;
    }

    .table-borderless td:first-child {
        font-weight: 500;
        color: #64748B;
        width: 150px;
    }

    .table-borderless td:last-child {
        color: #1E293B;
        font-weight: 400;
    }

    /* Table Hover */
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }

    .table-hover thead {
        background-color: #F8FAFC;
    }

    .table-hover thead th {
        color: #475569;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #E2E8F0;
        padding: 1rem;
    }

    .table-hover tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #F1F5F9;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
        transform: scale(1.01);
    }

    .table-hover tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #334155;
        font-size: 14px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-secondary {
        background-color: #E2E8F0;
        color: #475569;
    }

    .btn-secondary:hover {
        background-color: #CBD5E1;
        color: #334155;
        transform: translateY(-2px);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 83, 255, 0.4);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #64748B;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeIn 0.4s ease-out;
    }

    .card:nth-child(1) { animation-delay: 0.05s; }
    .card:nth-child(2) { animation-delay: 0.1s; }

    /* ===================== RESPONSIVE STYLES ===================== */

    /* Tablet (max-width: 991px) */
    @media (max-width: 991px) {
        h2.fw-bold {
            font-size: 24px;
        }

        p.text-muted {
            font-size: 14px;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-body h5 {
            font-size: 17px;
        }

        .table-borderless td:first-child {
            width: 140px;
        }

        .table-hover thead th,
        .table-hover tbody td {
            font-size: 13px;
            padding: 0.75rem;
        }
    }

    /* Mobile (max-width: 767px) */
    @media (max-width: 767px) {
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Page Header */
        h2.fw-bold {
            font-size: 22px;
            margin-bottom: 0.5rem !important;
        }

        p.text-muted {
            font-size: 14px;
            margin-bottom: 1.25rem !important;
        }

        /* Card */
        .card {
            border-radius: 12px !important;
            margin-bottom: 1.25rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-body h5 {
            font-size: 16px;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
        }

        /* Info Section - Stack columns */
        .row > .col-md-6 {
            margin-bottom: 1.5rem;
        }

        .row > .col-md-6:last-child {
            margin-bottom: 0;
        }

        /* Table Borderless - Vertical Layout */
        .table-borderless tr {
            display: flex;
            flex-direction: column;
            padding: 10px 0;
            border-bottom: 1px solid #F1F5F9;
        }

        .table-borderless tr:last-child {
            border-bottom: none;
        }

        .table-borderless td {
            padding: 4px 0;
            width: 100% !important;
        }

        .table-borderless td:first-child {
            font-size: 13px;
            color: #64748B;
            margin-bottom: 4px;
        }

        .table-borderless td:last-child {
            font-size: 14px;
            color: #1E293B;
            padding-left: 0;
        }

        /* Table Hover - Responsive */
        .table-responsive {
            margin: -1rem;
            padding: 1rem;
        }

        .table-hover {
            font-size: 13px;
        }

        .table-hover thead {
            display: none; /* Hide header on mobile */
        }

        .table-hover tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 1rem;
        }

        .table-hover tbody tr:hover {
            transform: none;
        }

        .table-hover tbody td {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border: none;
        }

        .table-hover tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #64748B;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Add data-label attribute via inline styles won't work, 
           so we'll use nth-child selectors */
        .table-hover tbody td:nth-child(1)::before {
            content: "No";
        }

        .table-hover tbody td:nth-child(2)::before {
            content: "Tingkat";
        }

        .table-hover tbody td:nth-child(3)::before {
            content: "Nama Kelas";
        }

        .table-hover tbody td:nth-child(4)::before {
            content: "Total Rombel";
        }

        /* Empty state */
        .table-hover tbody tr td[colspan] {
            display: block;
            text-align: center;
            padding: 1.5rem;
        }

        .table-hover tbody tr td[colspan]::before {
            display: none;
        }

        /* Action Buttons */
        .action-buttons {
            flex-direction: column;
            gap: 8px;
            margin-top: 1.25rem;
        }

        .action-buttons .btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Small Mobile (max-width: 480px) */
    @media (max-width: 480px) {
        h2.fw-bold {
            font-size: 20px;
        }

        p.text-muted {
            font-size: 13px;
        }

        .card-body {
            padding: 1rem;
        }

        .card-body h5 {
            font-size: 15px;
            margin-bottom: 1rem;
        }

        .table-borderless td:first-child {
            font-size: 12px;
        }

        .table-borderless td:last-child {
            font-size: 13px;
        }

        .table-hover {
            font-size: 12px;
        }

        .table-hover tbody tr {
            padding: 0.875rem;
        }

        .table-hover tbody td {
            padding: 0.4rem 0;
            font-size: 13px;
        }

        .table-hover tbody td::before {
            font-size: 11px;
        }

        .btn {
            font-size: 13px;
            padding: 9px 16px;
        }
    }

    /* Desktop (min-width: 1200px) */
    @media (min-width: 1200px) {
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
        }

        h2.fw-bold {
            font-size: 30px;
        }

        p.text-muted {
            font-size: 16px;
        }

        .card-body {
            padding: 2.5rem;
        }

        .card-body h5 {
            font-size: 19px;
        }

        .table-borderless td {
            font-size: 16px;
            padding: 14px 10px;
        }

        .table-borderless td:first-child {
            width: 180px;
        }

        .table-hover thead th,
        .table-hover tbody td {
            padding: 1.25rem;
            font-size: 15px;
        }
    }

    /* Print Styles */
    @media print {
        .action-buttons {
            display: none !important;
        }

        .card {
            box-shadow: none;
            border: 1px solid #ddd;
            page-break-inside: avoid;
        }

        .card-body {
            padding: 1rem;
        }

        .table-hover tbody tr:hover {
            transform: none;
            background-color: transparent;
        }
    }
</style>

<div class="container-fluid">
    <h2 class="fw-bold mb-1">Detail Jurusan</h2>
    <p class="text-muted mb-4">{{ $jurusan->nama }}</p>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Informasi Jurusan</h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>ID Jurusan</td>
                                <td>: {{ $jurusan->id }}</td>
                            </tr>
                            <tr>
                                <td>Kode Jurusan</td>
                                <td>: {{ $jurusan->kode }}</td>
                            </tr>
                            <tr>
                                <td>Nama Jurusan</td>
                                <td>: {{ $jurusan->nama }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Statistik</h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Total Kelas</td>
                                <td>: {{ $jurusan->kelas->count() }} kelas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5>Daftar Kelas</h5>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tingkat</th>
                            <th>Nama Kelas</th>
                            <th>Total Rombel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jurusan->kelas as $kelas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kelas->tingkat }}</td>
                                <td>{{ $kelas->tingkat }} {{ $jurusan->nama }}</td>
                                <td>{{ $kelas->rombels->count() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center empty-state">
                                    Belum ada kelas di jurusan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('kurikulum.jurusan.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('kurikulum.jurusan.edit', $jurusan->id) }}" class="btn btn-primary">Edit Jurusan</a>
    </div>
</div>
@endsection