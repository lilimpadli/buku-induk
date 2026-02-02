@extends('layouts.app')

@section('title', 'Detail Guru: ' . $guru->nama)

@section('content')
<style>
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    h3 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 1.5rem !important;
    }

    h3::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 3px;
    }

    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .info-row {
        display: flex;
        padding: 15px;
        background-color: rgba(47, 83, 255, 0.03);
        border-radius: 8px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .info-row:hover {
        background-color: rgba(47, 83, 255, 0.06);
        transform: translateX(5px);
    }

    .info-label {
        font-weight: 600;
        color: #64748B;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        min-width: 150px;
        flex-shrink: 0;
    }

    .info-value {
        color: #1E293B;
        font-weight: 500;
        flex: 1;
    }

    .btn-back {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 600;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 83, 255, 0.4);
        color: white;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        font-weight: 600;
        color: #475569;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #E2E8F0;
        padding: 15px 20px;
        background-color: #F8FAFC;
    }

    .table tbody td {
        padding: 15px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #F1F5F9;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #64748B;
    }

    .empty-state i {
        opacity: 0.5;
    }

    /* Card Section Headers */
    .card-section-header {
        padding: 20px;
        border-bottom: 2px solid #F1F5F9;
    }

    .card-section-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 18px;
    }

    /* Badge Styles */
    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 13px;
    }

    /* ===================== RESPONSIVE STYLES ===================== */

    /* Tablet (768px - 991px) */
    @media (max-width: 991px) {
        h3 {
            font-size: 24px;
        }

        .info-label {
            min-width: 130px;
            font-size: 12px;
        }

        .table thead th {
            font-size: 13px;
            padding: 12px 15px;
        }

        .table tbody td {
            padding: 12px 15px;
        }
    }

    /* Mobile (max 767px) */
    @media (max-width: 767px) {
        .container {
            padding-left: 12px;
            padding-right: 12px;
        }

        h3 {
            font-size: 20px;
            padding-left: 12px;
        }

        h3::before {
            width: 4px;
        }

        /* Header Section */
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start !important;
        }

        .btn-back {
            width: 100%;
            justify-content: center;
            padding: 12px 20px;
            font-size: 14px;
        }

        /* Card Styling */
        .card {
            border-radius: 12px;
            margin-bottom: 16px;
        }

        .card-body {
            padding: 16px !important;
        }

        .card-section-header {
            padding: 16px;
        }

        .card-section-header h5 {
            font-size: 16px;
        }

        /* Info Rows - Stack on Mobile */
        .info-row {
            flex-direction: column;
            padding: 12px;
            gap: 6px;
        }

        .info-label {
            min-width: 100%;
            font-size: 11px;
            margin-bottom: 4px;
            color: #64748B;
        }

        .info-value {
            font-size: 14px;
            padding-left: 0;
        }

        /* Table Responsive */
        .table-responsive {
            border-radius: 0;
            margin: 0;
        }

        .table {
            font-size: 13px;
        }

        .table thead th {
            font-size: 11px;
            padding: 10px 8px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 10px 8px;
            font-size: 13px;
        }

        /* Hide some columns on very small screens */
        .table thead th:nth-child(3),
        .table tbody td:nth-child(3) {
            display: none;
        }

        /* Empty State */
        .empty-state {
            padding: 30px 15px;
        }

        .empty-state i {
            font-size: 2.5rem !important;
        }

        .empty-state p {
            font-size: 14px;
            margin: 0;
        }

        /* Badge sizing */
        .badge {
            padding: 4px 10px;
            font-size: 12px;
        }
    }

    /* Mobile Small (max 575px) */
    @media (max-width: 575px) {
        h3 {
            font-size: 18px;
        }

        .card-section-header h5 {
            font-size: 15px;
        }

        .info-row {
            padding: 10px;
        }

        .info-label {
            font-size: 10px;
        }

        .info-value {
            font-size: 13px;
        }

        .table {
            font-size: 12px;
        }

        .table thead th {
            font-size: 10px;
            padding: 8px 6px;
        }

        .table tbody td {
            padding: 8px 6px;
            font-size: 12px;
        }

        /* Show only essential columns */
        .table thead th:nth-child(2),
        .table tbody td:nth-child(2) {
            display: none;
        }
    }

    /* Desktop Large (1200px+) */
    @media (min-width: 1200px) {
        .container {
            max-width: 1140px;
        }

        h3 {
            font-size: 30px;
        }

        .info-label {
            min-width: 180px;
            font-size: 14px;
        }

        .info-value {
            font-size: 16px;
        }

        .card-section-header h5 {
            font-size: 20px;
        }
    }

    /* Utility Classes for Responsive */
    @media (max-width: 767px) {
        .mobile-stack {
            flex-direction: column !important;
        }

        .mobile-full-width {
            width: 100% !important;
        }

        .mobile-text-center {
            text-align: center !important;
        }

        .mobile-hidden {
            display: none !important;
        }
    }

    /* Animation */
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
        animation: fadeIn 0.5s ease-out;
    }

    .info-row {
        animation: fadeIn 0.3s ease-out;
    }
</style>

<div class="container mt-4">
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Guru</h3>
        <a href="{{ route('kurikulum.guru.manage.index') }}" class="btn-back">
            <i class="fa fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- DATA DIRI GURU -->
    <div class="card">
        <div class="card-section-header">
            <h5>Informasi Pribadi</h5>
        </div>
        <div class="card-body">
            <div class="info-row">
                <div class="info-label">Nama Lengkap</div>
                <div class="info-value">{{ $guru->nama }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">NIP</div>
                <div class="info-value">{{ $guru->nip ?? '-' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">NIK / Nomor Induk</div>
                <div class="info-value">{{ optional($guru->user)->nomor_induk ?? '-' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $guru->email ?? '-' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Telepon</div>
                <div class="info-value">{{ $guru->telepon ?? '-' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Jenis Kelamin</div>
                <div class="info-value">
                    @if($guru->jenis_kelamin === 'L')
                        <span class="badge bg-info">Laki-laki</span>
                    @elseif($guru->jenis_kelamin === 'P')
                        <span class="badge bg-danger">Perempuan</span>
                    @else
                        -
                    @endif
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Tempat Lahir</div>
                <div class="info-value">{{ $guru->tempat_lahir ?? '-' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Tanggal Lahir</div>
                <div class="info-value">
                    @if($guru->tanggal_lahir)
                        {{ \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Alamat</div>
                <div class="info-value">{{ $guru->alamat ?? '-' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Jurusan</div>
                <div class="info-value">{{ optional($guru->jurusan)->nama ?? '-' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Role / Jabatan</div>
                <div class="info-value">
                    @php
                        $role = optional($guru->user)->role ?? '-';
                        $roleLabel = [
                            'guru' => 'Guru',
                            'walikelas' => 'Wali Kelas',
                            'kaprog' => 'Kaprog',
                            'tu' => 'TU',
                            'kurikulum' => 'Kurikulum'
                        ][$role] ?? ucfirst($role);
                    @endphp
                    <span class="badge bg-primary">{{ $roleLabel }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ROMBEL YANG DIAMPU -->
    <div class="card">
        <div class="card-section-header">
            <h5>Rombel yang Diampu</h5>
        </div>
        <div class="card-body p-0">
            @if($guru->rombels && $guru->rombels->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Rombel</th>
                                <th>Tingkat</th>
                                <th>Jurusan</th>
                                <th class="text-center">Siswa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guru->rombels as $rombel)
                                <tr>
                                    <td>
                                        <strong>{{ $rombel->nama }}</strong>
                                    </td>
                                    <td>{{ optional($rombel->kelas)->tingkat ?? '-' }}</td>
                                    <td>{{ optional(optional($rombel->kelas)->jurusan)->nama ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">
                                            {{ $rombel->siswa_count ?? $rombel->siswa->count() }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>Belum ada rombel yang diampu.</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection