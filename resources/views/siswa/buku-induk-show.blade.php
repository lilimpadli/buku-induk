@extends('layouts.app')

@section('title', 'Buku Induk - ' . $siswa->nama_lengkap)

@section('content')
<style>
    /* CSS Variables untuk konsistensi */
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --info-color: #3B82F6;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --border-radius: 12px;
        --transition: all 0.3s ease;
    }

    /* Base Styles */
    body {
        background-color: var(--light-bg);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
        color: #1F2937;
    }

    /* Header Styles */
    .buku-induk-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 2rem;
        border-radius: var(--border-radius);
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .buku-induk-header::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 20s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(-30px, -30px) rotate(180deg); }
    }

    .buku-induk-header h3 {
        font-size: clamp(20px, 4vw, 28px);
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .buku-induk-header h4 {
        font-size: clamp(16px, 3.5vw, 22px);
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .buku-induk-header p {
        font-size: clamp(12px, 2.5vw, 14px);
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }

    /* Card Styles */
    .card {
        border-radius: var(--border-radius);
        border: 1px solid #E5E7EB;
        box-shadow: var(--card-shadow);
        background: white;
        transition: var(--transition);
    }

    .card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: #F9FAFB;
        border-bottom: 1px solid #E5E7EB;
        padding: 1.5rem;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .card-body {
        padding: 2rem;
    }

    /* Section Styles */
    .info-section {
        background: #F9FAFB;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #E5E7EB;
        transition: var(--transition);
    }

    .info-section:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .info-section h5 {
        font-size: clamp(14px, 3vw, 18px);
        font-weight: 700;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
        color: var(--primary-color);
        display: flex;
            align-items: center;
        gap: 0.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-label {
        font-size: clamp(11px, 2vw, 13px);
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: clamp(13px, 2.5vw, 15px);
        color: #1F2937;
        word-wrap: break-word;
    }

    /* Photo Styles */
    .photo-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        background: #F9FAFB;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        border: 1px solid #E5E7EB;
    }

    .photo-wrapper {
        position: relative;
        width: 150px;
        height: 200px;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .photo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #E5E7EB, #D1D5DB);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #6B7280;
    }

    .photo-placeholder i {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .photo-label {
        font-size: 13px;
        font-weight: 600;
        color: #6B7280;
    }

    /* Badge Styles */
    .badge-custom {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        transition: var(--transition);
    }

    .badge-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: var(--border-radius);
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }

    .table-custom {
        font-size: clamp(10px, 2vw, 12px);
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom th {
        background: #F3F4F6;
        font-weight: 700;
        text-align: center;
        padding: 1rem 0.5rem;
        border: 1px solid #E5E7EB;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table-custom td {
        padding: 0.75rem 0.5rem;
        border: 1px solid #E5E7EB;
        vertical-align: middle;
    }

    .table-custom tr:nth-child(even) {
        background: #F9FAFB;
    }

    .table-custom tr:hover {
        background: #F3F4F6;
    }

    /* Button Styles */
    .btn-custom {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(47, 83, 255, 0.3);
        color: white;
    }

    .btn-secondary-custom {
        background: #6B7280;
        color: white;
    }

    .btn-secondary-custom:hover {
        background: #4B5563;
        transform: translateY(-2px);
        color: white;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: clamp(20px, 4vw, 28px);
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    /* Loading Spinner */
    .spinner-custom {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 2px solid #F3F4F6;
        border-radius: 50%;
        border-top-color: var(--primary-color);
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Mobile Styles */
    @media (max-width: 767px) {
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .page-title {
            font-size: 1.5rem;
            justify-content: center;
        }

        .action-buttons {
            width: 100%;
            justify-content: center;
        }

        .btn-custom {
            flex: 1;
            justify-content: center;
            font-size: 0.875rem;
            padding: 0.625rem 1.25rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .photo-container {
            order: -1;
            margin-bottom: 1.5rem;
        }

        .table-custom {
            font-size: 0.75rem;
        }

        .table-custom th,
        .table-custom td {
            padding: 0.5rem 0.25rem;
        }

        .info-section {
            padding: 1rem;
        }

        .info-section h5 {
            font-size: 1rem;
        }
    }

    /* Print Styles */
    @media print {
        body {
            background: white;
        }

        .page-header,
        .action-buttons,
        .btn-custom {
            display: none !important;
        }

        .card {
            box-shadow: none;
            border: 1px solid #E5E7EB;
        }

        .info-section {
            break-inside: avoid;
        }

        .table-custom {
            font-size: 10pt;
        }

        @page {
            margin: 2cm;
        }
    }

    /* Accessibility */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

<div class="container-fluid mt-4">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-book"></i>
            Buku Induk Siswa
        </h1>
        <div class="action-buttons">
            <a href="{{ route('siswa.dashboard') }}" class="btn-custom btn-secondary-custom">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            <a href="{{ route('siswa.bukuInduk.cetak') }}" target="_blank" class="btn-custom btn-primary-custom">
                <i class="fas fa-print"></i>
                Cetak
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card">
        <!-- Header -->
        <div class="buku-induk-header">
            <h3>BUKU INDUK SISWA</h3>
            <h4>SMKN 1 KAWALI</h4>
            <p>KONSENTRASI KEAHLIAN: {{ $siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan ? $siswa->rombel->kelas->jurusan->nama : 'REKAYASA PERANGKAT LUNAK' }}</p>
        </div>

        <div class="card-body">
            <!-- Photo Section -->
            <div class="row mb-4">
                <div class="col-lg-3">
                    <div class="photo-container">
                        <div class="photo-wrapper">
                            @if(isset($siswa->user) && isset($siswa->user->photo))
                                <img src="{{ asset('storage/' . $siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}" loading="lazy">
                            @else
                                <div class="photo-placeholder">
                                    <i class="fas fa-user"></i>
                                    <span>Tidak ada foto</span>
                                </div>
                            @endif
                        </div>
                        <span class="photo-label">Foto Profil</span>
                    </div>
                </div>

                <div class="col-lg-9">
                    <!-- Data Pribadi -->
                    <div class="info-section">
                        <h5>
                            <i class="fas fa-user"></i>
                            A. DATA PRIBADI SISWA
                        </h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">NIS</span>
                                <span class="info-value">{{ $siswa->nis }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">NISN</span>
                                <span class="info-value">{{ $siswa->nisn ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Nama Lengkap</span>
                                <span class="info-value">{{ $siswa->nama_lengkap }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Jenis Kelamin</span>
                                <span class="info-value">{{ $siswa->jenis_kelamin }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Tempat Lahir</span>
                                <span class="info-value">{{ $siswa->tempat_lahir ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Tanggal Lahir</span>
                                <span class="info-value">{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Agama</span>
                                <span class="info-value">{{ $siswa->agama ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Kewarganegaraan</span>
                                <span class="info-value">{{ $siswa->kewarganegaraan ?? '-' }}</span>
                            </div>
                            <div class="info-item" style="grid-column: 1 / -1;">
                                <span class="info-label">Alamat</span>
                                <span class="info-value">
                                    {{ $siswa->dusun ? 'Dusun ' . $siswa->dusun : '' }}
                                    {{ $siswa->rt ? ', RT ' . $siswa->rt : '' }}
                                    {{ $siswa->rw ? ', RW ' . $siswa->rw : '' }}
                                    {{ $siswa->kelurahan ? ', ' . $siswa->kelurahan : '' }}
                                    {{ $siswa->kecamatan ? ', ' . $siswa->kecamatan : '' }}
                                    {{ $siswa->kode_pos ? ', ' . $siswa->kode_pos : '' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="info-section">
                        <h5>
                            <i class="fas fa-users"></i>
                            B. DATA ORANG TUA / WALI
                        </h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Nama Ayah</span>
                                <span class="info-value">{{ $siswa->ayah->nama ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Pekerjaan Ayah</span>
                                <span class="info-value">{{ $siswa->ayah->pekerjaan ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Nama Ibu</span>
                                <span class="info-value">{{ $siswa->ibu->nama ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Pekerjaan Ibu</span>
                                <span class="info-value">{{ $siswa->ibu->pekerjaan ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Alamat Orang Tua</span>
                                <span class="info-value">{{ $siswa->ayah->alamat ?? $siswa->ibu->alamat ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Nama Wali</span>
                                <span class="info-value">{{ $siswa->wali->nama ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Pekerjaan Wali</span>
                                <span class="info-value">{{ $siswa->wali->pekerjaan ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Alamat Wali</span>
                                <span class="info-value">{{ $siswa->wali->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pendaftaran -->
                    <div class="info-section">
                        <h5>
                            <i class="fas fa-file-alt"></i>
                            C. DATA PENDAFTARAN
                        </h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Sekolah Asal</span>
                                <span class="info-value">{{ $siswa->sekolah_asal ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Tanggal Diterima</span>
                                <span class="info-value">{{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->translatedFormat('d F Y') : '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Status Keluarga</span>
                                <span class="info-value">{{ $siswa->status_keluarga ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Anak Ke-</span>
                                <span class="info-value">{{ $siswa->anak_ke ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">No. HP</span>
                                <span class="info-value">{{ $siswa->no_hp ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Catatan Wali Kelas</span>
                                <span class="info-value">{{ $siswa->catatan_wali_kelas ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Status Mutasi -->
                    <div class="info-section">
                        <h5>
                            <i class="fas fa-exchange-alt"></i>
                            D. STATUS MUTASI
                        </h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Status</span>
                                <span>
                                    @if($siswa->mutasiTerakhir)
                                        <span class="badge-custom" style="background-color: {{ $siswa->mutasiTerakhir->status_color }}; color: white;">
                                            {{ $siswa->mutasiTerakhir->status_label }}
                                        </span>
                                    @else
                                        <span class="badge-custom" style="background-color: var(--success-color); color: white;">
                                            Aktif
                                        </span>
                                    @endif
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Tanggal Mutasi</span>
                                <span class="info-value">
                                    {{ $siswa->mutasiTerakhir && $siswa->mutasiTerakhir->tanggal_mutasi 
                                        ? \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_mutasi)->translatedFormat('d F Y') 
                                        : '-' }}
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Alasan Pindah</span>
                                <span class="info-value">{{ $siswa->mutasiTerakhir->alasan_pindah ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Sekolah Tujuan</span>
                                <span class="info-value">{{ $siswa->mutasiTerakhir->tujuan_pindah ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">No. SK Keluar</span>
                                <span class="info-value">{{ $siswa->mutasiTerakhir->no_sk_keluar ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Tanggal SK Keluar</span>
                                <span class="info-value">
                                    {{ $siswa->mutasiTerakhir && $siswa->mutasiTerakhir->tanggal_sk_keluar 
                                        ? \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_sk_keluar)->translatedFormat('d F Y') 
                                        : '-' }}
                                </span>
                            </div>
                            <div class="info-item" style="grid-column: 1 / -1;">
                                <span class="info-label">Keterangan</span>
                                <span class="info-value">{{ $siswa->mutasiTerakhir->keterangan ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nilai Raport -->
            <div class="info-section">
                <h5>
                    <i class="fas fa-chart-line"></i>
                    E. HASIL PRESTASI PEMBELAJARAN
                </h5>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th style="width: 30%;">MATA PELAJARAN</th>
                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                    <th colspan="2" class="text-center">{{ $tahunAjaran }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                    <th class="text-center" style="width: 50px;">1</th>
                                    <th class="text-center" style="width: 50px;">2</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                    <th class="text-center">NILAI</th>
                                    <th class="text-center">NILAI</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($nilaiByKelompok['byKelompok']) > 0)
                                @foreach($nilaiByKelompok['byKelompok'] as $kelompok => $mapelGroup)
                                    <tr style="background-color: #F3F4F6; font-weight: 700;">
                                        <td colspan="{{ 1 + (count($nilaiByKelompok['tahunAjaranList']) * 2) }}">
                                            @if($kelompok === 'A')
                                                A. KELOMPOK MATA PELAJARAN UMUM
                                            @elseif($kelompok === 'B')
                                                B. KELOMPOK MATA PELAJARAN KEAHLIAN
                                            @else
                                                {{ strtoupper($kelompok) }}
                                            @endif
                                        </td>
                                    </tr>
                                    @foreach($mapelGroup as $mapelNama => $mapelData)
                                        <tr>
                                            <td>{{ $mapelData['nama'] }}</td>
                                            @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                                <td class="text-center">{{ $mapelData['nilai'][$tahunAjaran][1] ?? '-' }}</td>
                                                <td class="text-center">{{ $mapelData['nilai'][$tahunAjaran][2] ?? '-' }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            @else
                                <tr style="background-color: #F3F4F6; font-weight: 700;">
                                    <td colspan="{{ 1 + (count($nilaiByKelompok['tahunAjaranList']) * 2) }}">A. KELOMPOK MATA PELAJARAN UMUM</td>
                                </tr>
                                <tr>
                                    <td>-</td>
                                    @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                    @endforeach
                                </tr>
                                <tr style="background-color: #F3F4F6; font-weight: 700;">
                                    <td colspan="{{ 1 + (count($nilaiByKelompok['tahunAjaranList']) * 2) }}">B. KELOMPOK MATA PELAJARAN KEAHLIAN</td>
                                </tr>
                                <tr>
                                    <td>-</td>
                                    @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                    @endforeach
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection