@extends('layouts.app')

@section('title', 'Alumni Siswa')

@section('content')
<style>
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    body {
        background-color: var(--light-bg);
    }

    .alumni-container {
        font-family: 'Times New Roman', serif;
        line-height: 1.5;
    }

    .alumni-header {
        text-align: center;
        margin-bottom: 30px;
        padding: 30px 20px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
    }

    .alumni-header h2 {
        font-size: clamp(24px, 5vw, 32px);
        font-weight: bold;
        margin-bottom: 10px;
    }

    .alumni-header p {
        font-size: clamp(14px, 3vw, 18px);
        opacity: 0.95;
        margin: 0;
    }

    .alumni-status {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        border-radius: 20px;
        margin-top: 15px;
        font-size: clamp(12px, 2.5vw, 14px);
        border: 2px solid rgba(255, 255, 255, 0.5);
    }

    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .alumni-info-card {
        margin-bottom: 25px;
    }

    .alumni-info-card .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        border: none;
        padding: 20px;
        border-radius: 16px 16px 0 0;
    }

    .alumni-info-card .card-header h5 {
        margin: 0;
        font-size: clamp(16px, 3.5vw, 20px);
        font-weight: 700;
    }

    .alumni-info-card .card-body {
        padding: 25px;
    }

    .info-row {
        display: flex;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .info-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .info-label {
        font-weight: 600;
        color: #64748B;
        min-width: 180px;
        font-size: clamp(13px, 2.5vw, 14px);
    }

    .info-value {
        flex: 1;
        color: #2d3748;
        font-size: clamp(13px, 2.5vw, 14px);
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-primary {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border: none;
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(47, 83, 255, 0.3);
        color: white;
    }

    .btn-secondary {
        background-color: #64748B;
        border: none;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #475569;
        transform: translateY(-2px);
        color: white;
    }

    .badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: clamp(11px, 2vw, 13px);
        font-weight: 600;
        display: inline-block;
    }

    .badge-success {
        background-color: #10B981;
        color: white;
    }

    .photo-section {
        text-align: center;
        margin-bottom: 20px;
    }

    .photo-box {
        width: 120px;
        height: 160px;
        margin: 0 auto 15px;
        border: 3px solid var(--primary-color);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
    }

    .photo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f0f0;
        color: #999;
        font-size: 12px;
    }

    /* Mobile Styles */
    @media (max-width: 767px) {
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }

        .alumni-header {
            padding: 20px 15px;
            margin-bottom: 20px;
        }

        .alumni-header h2 {
            font-size: 1.5rem;
        }

        .alumni-info-card .card-header {
            padding: 15px;
        }

        .alumni-info-card .card-body {
            padding: 15px;
        }

        .info-row {
            flex-direction: column;
            padding-bottom: 12px;
            margin-bottom: 12px;
        }

        .info-label {
            min-width: auto;
            margin-bottom: 5px;
            color: #64748B;
            font-size: 0.85rem;
        }

        .info-value {
            font-size: 0.9rem;
        }

        .action-buttons {
            gap: 8px;
        }

        .action-buttons .btn {
            flex: 1;
            font-size: 0.9rem;
            padding: 10px 12px;
        }

        .photo-box {
            width: 100px;
            height: 140px;
        }
    }

    /* Print Styles */
    @media print {
        body {
            background-color: white;
        }

        .alumni-header,
        .action-buttons,
        .btn {
            display: none !important;
        }

        .card {
            box-shadow: none;
            border: 1px solid #ddd;
            page-break-inside: avoid;
        }

        @page {
            margin: 2cm;
        }
    }
</style>

<div class="container-fluid alumni-container mt-4">
    <!-- Header -->
    <div class="alumni-header">
        <h2>Profil Alumni SMKN 1 KAWALI</h2>
        <p>{{ $siswa->nama_lengkap }}</p>
        <div class="alumni-status">
            <i class="fas fa-graduation-cap"></i> Lulus - Tahun {{ $siswa->mutasiTerakhir->tanggal_mutasi ? $siswa->mutasiTerakhir->tanggal_mutasi->format('Y') : now()->format('Y') }}
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <a href="{{ route('siswa.bukuInduk.show') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-book me-1"></i> Lihat Buku Induk
        </a>
    </div>

    <!-- Alumni Information Card -->
    <div class="alumni-info-card">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-user-circle me-2"></i>Informasi Alumni</h5>
            </div>
            <div class="card-body">
                <!-- Photo -->
                <div class="photo-section">
                    <div class="photo-box">
                        @if(isset($siswa->user) && isset($siswa->user->photo))
                            <img src="{{ asset('storage/' . $siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}">
                        @else
                            <div class="photo-placeholder">
                                <span>Tidak ada foto</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Data Pribadi -->
                <div class="info-row">
                    <div class="info-label">NIS / NISN</div>
                    <div class="info-value">{{ $siswa->nis }} / {{ $siswa->nisn ?? '-' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">{{ $siswa->nama_lengkap }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Jenis Kelamin</div>
                    <div class="info-value">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Tempat/Tanggal Lahir</div>
                    <div class="info-value">{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Agama</div>
                    <div class="info-value">{{ $siswa->agama ?? '-' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">{{ $siswa->alamat ?? '-' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">{{ $siswa->no_hp ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Kelulusan Card -->
    <div class="alumni-info-card">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-scroll me-2"></i>Status Kelulusan</h5>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle me-1"></i>{{ $siswa->mutasiTerakhir->status_label ?? 'Lulus' }}
                        </span>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Tanggal Lulus</div>
                    <div class="info-value">{{ $siswa->mutasiTerakhir->tanggal_mutasi ? \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_mutasi)->format('d F Y') : '-' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Nomor SK</div>
                    <div class="info-value">{{ $siswa->mutasiTerakhir->no_sk_keluar ?? '-' }}</div>
                </div>

                @if($siswa->mutasiTerakhir->tanggal_sk_keluar)
                <div class="info-row">
                    <div class="info-label">Tanggal SK</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_sk_keluar)->format('d F Y') }}</div>
                </div>
                @endif

                @if($siswa->mutasiTerakhir->keterangan)
                <div class="info-row">
                    <div class="info-label">Keterangan</div>
                    <div class="info-value">{{ $siswa->mutasiTerakhir->keterangan }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Konsentrasi Keahlian Card -->
    @if($siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan)
    <div class="alumni-info-card">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-briefcase me-2"></i>Konsentrasi Keahlian</h5>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <div class="info-label">Program Studi</div>
                    <div class="info-value">{{ $siswa->rombel->kelas->jurusan->nama }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Kelas Terakhir</div>
                    <div class="info-value">{{ $siswa->rombel->nama }}</div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
