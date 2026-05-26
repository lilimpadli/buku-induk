@extends('layouts.app')

@section('title', 'Buku Induk - ' . $siswa->nama_lengkap)

@section('content')
<style>
    :root {
        --primary-color: #3b82f6;
        --secondary-color: #6366f1;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --light-bg: #f8fafc;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
    }

    body {
        background-color: var(--light-bg);
        color: var(--text-primary);
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    .buku-induk-container {
        line-height: 1.6;
    }

    /* Header Styles */
    .buku-induk-header {
        text-align: center;
        margin-bottom: 40px;
        padding: 30px 20px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .buku-induk-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.3; }
    }

    .buku-induk-header h3 {
        font-size: clamp(24px, 5vw, 32px);
        font-weight: 700;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }

    .buku-induk-header h4 {
        font-size: clamp(18px, 4vw, 24px);
        font-weight: 600;
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
    }

    .buku-induk-header p {
        font-size: clamp(14px, 3vw, 16px);
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }

    /* Section Styles */
    .buku-induk-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .buku-induk-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px -1px rgba(0, 0, 0, 0.1), 0 4px 8px -1px rgba(0, 0, 0, 0.06);
    }

    .buku-induk-section h5 {
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--border-color);
        font-size: clamp(16px, 3.5vw, 20px);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .buku-induk-section h5::before {
        content: '';
        width: 4px;
        height: 24px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .buku-induk-section p {
        font-size: clamp(14px, 3vw, 16px);
        margin-bottom: 12px;
        color: var(--text-primary);
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .buku-induk-section p strong {
        min-width: 140px;
        font-weight: 600;
        color: var(--text-secondary);
        flex-shrink: 0;
    }

    /* Photo Styles */
    .photo-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        margin-bottom: 25px;
    }

    .buku-induk-photo {
        width: 100%;
        max-width: 180px;
        height: auto;
        aspect-ratio: 3/4;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .buku-induk-photo:hover {
        transform: scale(1.05);
    }

    /* Table Styles */
    .nilai-table-container {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: var(--card-shadow);
        margin-bottom: 25px;
    }

    .nilai-table-container h5 {
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--border-color);
        font-size: clamp(16px, 3.5vw, 20px);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .nilai-table-container h5::before {
        content: '';
        width: 4px;
        height: 24px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .buku-induk-table {
        font-size: clamp(12px, 2.5vw, 14px);
        border-collapse: collapse;
        width: 100%;
    }

    .buku-induk-table th {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        font-weight: 600;
        text-align: center;
        padding: 12px 8px;
        border: 1px solid var(--border-color);
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .buku-induk-table td {
        vertical-align: middle;
        padding: 10px 8px;
        border: 1px solid var(--border-color);
        transition: background-color 0.2s ease;
    }

    .buku-induk-table tr:hover td {
        background-color: #f8fafc;
    }

    .buku-induk-table tr.header-row {
        background: #f8fafc;
        font-weight: 600;
    }

    /* Badge Styles */
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        gap: 20px;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: clamp(24px, 5vw, 32px);
        margin: 0;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: var(--primary-color);
        font-size: 28px;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-secondary {
        background-color: var(--text-secondary);
        color: white;
    }

    .btn-secondary:hover {
        background-color: #475569;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(59, 130, 246, 0.3);
    }

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }

    .card-body {
        padding: 0;
    }

    /* Mobile Styles */
    @media (max-width: 767px) {
        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
            gap: 16px;
        }

        .action-buttons {
            width: 100%;
            justify-content: center;
        }

        .action-buttons .btn {
            flex: 1;
            font-size: 14px;
            padding: 12px 16px;
            justify-content: center;
        }

        .page-title i {
            display: none;
        }

        .buku-induk-header {
            margin-bottom: 20px;
            padding: 20px 15px;
        }

        .buku-induk-section {
            padding: 20px;
            margin-bottom: 20px;
        }

        .buku-induk-section h5 {
            margin-bottom: 15px;
            padding-bottom: 10px;
        }

        .buku-induk-section p {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .buku-induk-section p strong {
            min-width: auto;
            display: block;
            margin-bottom: 4px;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .photo-container {
            order: -1;
            margin-bottom: 20px;
        }

        .buku-induk-photo {
            max-width: 140px;
        }

        .nilai-table-container {
            padding: 20px;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 15px;
        }

        .buku-induk-table {
            min-width: 700px;
            font-size: 11px;
        }

        .buku-induk-table th,
        .buku-induk-table td {
            padding: 8px 6px;
        }

        /* Landscape orientation */
        @media (max-width: 767px) and (orientation: landscape) {
            .buku-induk-photo {
                max-width: 100px;
            }

            .buku-induk-section {
                padding: 15px;
            }

            .buku-induk-section p {
                margin-bottom: 8px;
            }
        }
    }

    /* Tablet Styles */
    @media (min-width: 768px) and (max-width: 991px) {
        .container-fluid {
            padding-left: 20px;
            padding-right: 20px;
        }

        .card-body {
            padding: 0;
        }

        .buku-induk-section {
            padding: 25px;
        }

        .buku-induk-section p strong {
            min-width: 120px;
        }

        .buku-induk-table {
            font-size: 12px;
        }
    }

    /* Desktop Styles */
    @media (min-width: 992px) {
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 30px;
            padding-right: 30px;
        }

        .card-body {
            padding: 0;
        }

        .buku-induk-section {
            padding: 30px;
        }

        .buku-induk-section p strong {
            min-width: 160px;
        }

        .buku-induk-table th,
        .buku-induk-table td {
            padding: 12px 10px;
        }
    }

    /* Large Desktop */
    @media (min-width: 1400px) {
        .container-fluid {
            max-width: 1320px;
            padding-left: 40px;
            padding-right: 40px;
        }
    }

    /* Print Styles */
    @media print {
        body {
            background-color: white;
        }

        .page-header,
        .action-buttons,
        .btn {
            display: none !important;
        }

        .card {
            box-shadow: none;
            border: 1px solid var(--border-color);
        }

        .buku-induk-section {
            box-shadow: none;
            border: 1px solid var(--border-color);
            page-break-inside: avoid;
        }

        .nilai-table-container {
            box-shadow: none;
            border: 1px solid var(--border-color);
            page-break-inside: avoid;
        }

        .buku-induk-table {
            font-size: 10pt;
        }

        .buku-induk-table th,
        .buku-induk-table td {
            padding: 8px;
        }

        @page {
            margin: 2cm;
        }
    }

    /* Loading Animation */
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .loading {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }
</style>

<div class="container-fluid buku-induk-container mt-4">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-book"></i> Buku Induk Siswa
        </h1>
        <div class="action-buttons">
            <a href="{{ route('tu.buku-induk.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('tu.buku-induk.cetak', $siswa) }}" target="_blank" class="btn btn-primary">
                <i class="fas fa-print"></i> Cetak
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Header -->
            <div class="buku-induk-header">
                <h3 class="mb-2">BUKU INDUK SISWA</h3>
                <h4 class="mb-1">SMKN 1 KAWALI</h4>
                <p class="mb-0 text-white opacity-90"></p>
                <p class="text-white opacity-90">KONSENTRASI KEAHLIAN: {{ $siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan ? $siswa->rombel->kelas->jurusan->nama : 'REKAYASA PERANGKAT LUNAK' }}</p>
            </div>

            <!-- Info Siswa -->
            <div class="row mb-4">
                <!-- Photo -->
                <div class="col-md-3">
                    <div class="photo-container">
                        @if(isset($siswa->user) && isset($siswa->user->photo))
                            <img src="{{ asset('storage/' . $siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}" class="buku-induk-photo">
                        @else
                            <div class="buku-induk-photo d-flex align-items-center justify-content-center bg-light">
                                <i class="fas fa-user text-muted fa-3x"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Data Siswa -->
                <div class="col-md-9">
                    <!-- Data Pribadi -->
                    <div class="buku-induk-section">
                        <h5>A. DATA PRIBADI SISWA</h5>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
                                <p><strong>NISN:</strong> {{ $siswa->nisn ?? '-' }}</p>
                                <p><strong>Nama Lengkap:</strong> {{ $siswa->nama_lengkap }}</p>
                                <p><strong>Jenis Kelamin:</strong> {{ $siswa->jenis_kelamin }}</p>
                            </div>
                            <div class="col-md-6 col-12">
                                <p><strong>Tempat Lahir:</strong> {{ $siswa->tempat_lahir ?? '-' }}</p>
                                <p><strong>Tanggal Lahir:</strong> {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}</p>
                                <p><strong>Agama:</strong> {{ $siswa->agama ?? '-' }}</p>
                                <p><strong>Kewarganegaraan:</strong> {{ $siswa->kewarganegaraan ?? '-' }}</p>
                                <p><strong>Alamat:</strong> {{ $siswa->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="buku-induk-section">
                        <h5>B. DATA ORANG TUA / WALI</h5>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <p><strong>Nama Ayah:</strong> {{ $siswa->ayah->nama ?? '-' }}</p>
                                <p><strong>Pekerjaan Ayah:</strong> {{ $siswa->ayah->pekerjaan ?? '-' }}</p>
                                <p><strong>Nama Ibu:</strong> {{ $siswa->ibu->nama ?? '-' }}</p>
                                <p><strong>Pekerjaan Ibu:</strong> {{ $siswa->ibu->pekerjaan ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 col-12">
                                <p><strong>Alamat Orang Tua:</strong> {{ $siswa->ayah->alamat ?? $siswa->ibu->alamat ?? '-' }}</p>
                                <p><strong>Nama Wali:</strong> {{ $siswa->wali->nama ?? '-' }}</p>
                                <p><strong>Pekerjaan Wali:</strong> {{ $siswa->wali->pekerjaan ?? '-' }}</p>
                                <p><strong>Alamat Wali:</strong> {{ $siswa->wali->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pendaftaran -->
                    <div class="buku-induk-section">
                        <h5>C. DATA PENDAFTARAN</h5>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <p><strong>Sekolah Asal:</strong> {{ $siswa->sekolah_asal ?? '-' }}</p>
                                <p><strong>Tanggal Diterima:</strong> {{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->format('d F Y') : '-' }}</p>
                                <p><strong>Status Keluarga:</strong> {{ $siswa->status_keluarga ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 col-12">
                                <p><strong>Anak Ke-:</strong> {{ $siswa->anak_ke ?? '-' }}</p>
                                <p><strong>No. HP:</strong> {{ $siswa->no_hp ?? '-' }}</p>
                                <p><strong>Catatan Wali Kelas:</strong> {{ $siswa->catatan_wali_kelas ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Mutasi -->
                    <div class="buku-induk-section">
                        <h5>D. STATUS MUTASI</h5>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                @if($siswa->mutasiTerakhir)
                                    <p><strong>Status:</strong> <span class="badge bg-{{ $siswa->mutasiTerakhir->status_color }}">{{ $siswa->mutasiTerakhir->status_label }}</span></p>
                                    <p><strong>Tanggal Mutasi:</strong> {{ $siswa->mutasiTerakhir->tanggal_mutasi ? \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_mutasi)->format('d F Y') : '-' }}</p>
                                    <p><strong>Keterangan:</strong> {{ $siswa->mutasiTerakhir->keterangan ?? '-' }}</p>
                                @else
                                    <p><strong>Status:</strong> <span class="badge bg-success">Aktif</span></p>
                                    <p><strong>Tanggal Mutasi:</strong> -</p>
                                    <p><strong>Keterangan:</strong> -</p>
                                @endif
                            </div>
                            <div class="col-md-6 col-12">
                                @if($siswa->mutasiTerakhir)
                                    <p><strong>Alasan Pindah:</strong> {{ $siswa->mutasiTerakhir->alasan_pindah ?? '-' }}</p>
                                    <p><strong>Sekolah Tujuan:</strong> {{ $siswa->mutasiTerakhir->tujuan_pindah ?? '-' }}</p>
                                    <p><strong>No. SK Keluar:</strong> {{ $siswa->mutasiTerakhir->no_sk_keluar ?? '-' }}</p>
                                    <p><strong>Tanggal SK Keluar:</strong> {{ $siswa->mutasiTerakhir->tanggal_sk_keluar ? \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_sk_keluar)->format('d F Y') : '-' }}</p>
                                @else
                                    <p><strong>Alasan Pindah:</strong> -</p>
                                    <p><strong>Sekolah Tujuan:</strong> -</p>
                                    <p><strong>No. SK Keluar:</strong> -</p>
                                    <p><strong>Tanggal SK Keluar:</strong> -</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nilai Raport -->
            <div class="nilai-table-container">
                <h5>E. HASIL PRESTASI PEMBELAJARAN</h5>
                <div class="table-responsive">
                    <table class="table table-bordered buku-induk-table">
                        <thead>
                            <tr>
                                <th rowspan="3" style="vertical-align: middle; width: 30%;">MATA PELAJARAN</th>
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
                                    <tr class="header-row">
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
                                <tr class="header-row">
                                    <td colspan="{{ 1 + (count($nilaiByKelompok['tahunAjaranList']) * 2) }}">A. KELOMPOK MATA PELAJARAN UMUM</td>
                                </tr>
                                <tr>
                                    <td>-</td>
                                    @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                    @endforeach
                                </tr>
                                <tr class="header-row">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add print functionality
    const printButton = document.querySelector('a[href*="cetak"]');
    if (printButton) {
        printButton.addEventListener('click', function(e) {
            if (window.matchMedia('print').matches) {
                // We're in print mode, add print-specific styles
                document.body.classList.add('printing');
            }
        });
    }

    // Add table row hover effect
    const tableRows = document.querySelectorAll('.buku-induk-table tbody tr:not(.header-row)');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8fafc';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });

    // Responsive table handling
    if (window.innerWidth < 768) {
        const table = document.querySelector('.buku-induk-table');
        if (table) {
            table.style.fontSize = '11px';
        }
    }
});
</script>
@endpush
@endsection