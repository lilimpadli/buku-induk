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
    }

    h3 {
        font-size: clamp(20px, 5vw, 28px);
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
    }

    .info-row {
        display: flex;
        flex-direction: column;
        padding: 15px;
        background-color: rgba(47, 83, 255, 0.03);
        border-radius: 8px;
        margin-bottom: 10px;
        gap: 8px;
    }

    .info-label {
        font-weight: 600;
        color: #64748B;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        color: #1E293B;
        font-weight: 500;
        font-size: 15px;
        word-wrap: break-word;
    }

    .btn-back {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 14px;
        white-space: nowrap;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 83, 255, 0.4);
        color: white;
    }

    .table {
        margin-bottom: 0;
        font-size: 14px;
    }

    .table thead th {
        font-weight: 600;
        color: #475569;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #E2E8F0;
        padding: 12px 15px;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #F1F5F9;
    }

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #64748B;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        gap: 15px;
        flex-wrap: wrap;
    }

    /* Mobile Styles */
    @media (max-width: 576px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        .header-section {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-back {
            width: 100%;
            text-align: center;
            padding: 10px 16px;
        }

        .card-body {
            padding: 1rem !important;
        }

        h5 {
            font-size: 18px;
        }

        .info-row {
            padding: 12px;
        }

        .info-label {
            font-size: 11px;
        }

        .info-value {
            font-size: 14px;
        }

        .table {
            font-size: 12px;
        }

        .table thead th {
            font-size: 10px;
            padding: 10px 8px;
        }

        .table tbody td {
            padding: 10px 8px;
        }

        /* Stack table on mobile */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .badge {
            font-size: 11px;
        }
    }

    /* Tablet Styles */
    @media (min-width: 577px) and (max-width: 991px) {
        .info-row {
            flex-direction: row;
            gap: 15px;
        }

        .info-label {
            min-width: 140px;
            font-size: 13px;
        }

        .card-body {
            padding: 1.5rem !important;
        }
    }

    /* Desktop Styles */
    @media (min-width: 992px) {
        .info-row {
            flex-direction: row;
            gap: 20px;
        }

        .info-label {
            min-width: 180px;
            font-size: 13px;
        }

        .card-body.p-4 {
            padding: 2rem !important;
        }

        .btn-back {
            padding: 10px 24px;
        }
    }

    /* Extra large screens */
    @media (min-width: 1400px) {
        .container {
            max-width: 1200px;
        }
    }

    /* Print styles */
    @media print {
        .btn-back {
            display: none;
        }

        .card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>

<div class="container mt-4">
    <!-- HEADER -->
    <div class="header-section">
        <h3>Detail Guru</h3>
        <a href="{{ route('tu.guru.index') }}" class="btn-back">
            <i class="fa fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <!-- DATA DIRI GURU -->
    <div class="card">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Informasi Pribadi</h5>

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
                    {{ $roleLabel }}
                </div>
            </div>
        </div>
    </div>

    <!-- ROMBEL YANG DIAMPU -->
    <div class="card">
        <div class="card-body p-0">
            <div class="p-4">
                <h5 class="fw-bold mb-0">Rombel yang Diampu</h5>
            </div>

            @if($guru->rombels && $guru->rombels->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Rombel</th>
                                <th>Tingkat</th>
                                <th>Jurusan</th>
                                <th>Jumlah Siswa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guru->rombels as $rombel)
                                <tr>
                                    <td>{{ $rombel->nama }}</td>
                                    <td>{{ optional($rombel->kelas)->tingkat ?? '-' }}</td>
                                    <td>{{ optional(optional($rombel->kelas)->jurusan)->nama ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $rombel->siswa_count ?? $rombel->siswa->count() }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox fa-2x mb-3"></i>
                    <p>Belum ada rombel yang diampu.</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection