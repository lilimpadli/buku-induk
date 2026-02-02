@extends('layouts.app')

@section('title', 'Buku Induk - ' . $siswa->nama_lengkap)

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

    .buku-induk-container {
        font-family: 'Times New Roman', serif;
        line-height: 1.5;
    }
    
    .buku-induk-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #333;
    }

    .buku-induk-header h3 {
        font-size: clamp(18px, 4vw, 24px);
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .buku-induk-header h4 {
        font-size: clamp(16px, 3.5vw, 20px);
        margin-bottom: 0.5rem;
    }

    .buku-induk-header p {
        font-size: clamp(12px, 2.5vw, 14px);
    }
    
    .buku-induk-section {
        margin-bottom: 25px;
    }
    
    .buku-induk-section h5 {
        font-weight: bold;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #ddd;
        font-size: clamp(14px, 3vw, 16px);
    }

    .buku-induk-section p {
        font-size: clamp(12px, 2.5vw, 14px);
        margin-bottom: 0.75rem;
        word-wrap: break-word;
    }

    .buku-induk-section p strong {
        display: inline-block;
        min-width: 140px;
    }
    
    .buku-induk-photo {
        width: 100%;
        max-width: 150px;
        height: auto;
        aspect-ratio: 3/4;
        border: 1px solid #ddd;
        object-fit: cover;
    }
    
    .buku-induk-table {
        font-size: clamp(9px, 2vw, 11px);
    }
    
    .buku-induk-table th {
        font-weight: bold;
        background-color: #f8f9fa;
        text-align: center;
        padding: 8px 4px;
        white-space: nowrap;
    }
    
    .buku-induk-table td {
        vertical-align: middle;
        padding: 8px 4px;
    }
    
    .signature-section {
        margin-top: 50px;
        padding-top: 20px;
        border-top: 2px solid #333;
    }
    
    .signature-box {
        text-align: center;
    }
    
    .signature-line {
        border-top: 1px solid #000;
        margin-top: 30px;
        padding-top: 10px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        gap: 15px;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: clamp(18px, 4vw, 24px);
        margin: 0;
    }

    .page-title i {
        color: var(--primary-color);
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-secondary {
        background-color: #64748B;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #475569;
        transform: translateY(-2px);
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

    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: clamp(10px, 2vw, 12px);
        font-weight: 600;
    }

    /* Photo container */
    .photo-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    /* Mobile Styles */
    @media (max-width: 767px) {
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .action-buttons {
            width: 100%;
        }

        .action-buttons .btn {
            flex: 1;
            font-size: 13px;
            padding: 8px 12px;
        }

        .page-title i {
            display: none;
        }

        .card-body {
            padding: 15px;
        }

        .buku-induk-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .buku-induk-section {
            margin-bottom: 20px;
        }

        .buku-induk-section h5 {
            margin-bottom: 12px;
            padding-bottom: 6px;
        }

        .buku-induk-section p {
            margin-bottom: 0.5rem;
        }

        .buku-induk-section p strong {
            display: block;
            min-width: auto;
            margin-bottom: 2px;
            color: #64748B;
            font-size: 11px;
        }

        /* Stack columns on mobile */
        .row > div[class*='col-md'] {
            margin-bottom: 15px;
        }

        .photo-container {
            order: -1;
            margin-bottom: 25px;
        }

        .buku-induk-photo {
            max-width: 120px;
        }

        /* Table scroll on mobile */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 15px;
        }

        .buku-induk-table {
            min-width: 600px;
            font-size: 9px;
        }

        .buku-induk-table th,
        .buku-induk-table td {
            padding: 6px 3px;
        }

        .buku-induk-table th[rowspan] {
            min-width: 100px;
        }
    }

    /* Tablet Styles */
    @media (min-width: 768px) and (max-width: 991px) {
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }

        .card-body {
            padding: 20px;
        }

        .buku-induk-section p strong {
            min-width: 120px;
        }

        .buku-induk-table {
            font-size: 10px;
        }

        .buku-induk-table th,
        .buku-induk-table td {
            padding: 7px 4px;
        }
    }

    /* Desktop Styles */
    @media (min-width: 992px) {
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
        }

        .card-body {
            padding: 30px;
        }

        .buku-induk-section p strong {
            min-width: 160px;
        }

        .buku-induk-table th,
        .buku-induk-table td {
            padding: 8px 6px;
        }
    }

    /* Large Desktop */
    @media (min-width: 1400px) {
        .container-fluid {
            max-width: 1320px;
        }
    }

    /* Landscape orientation on mobile */
    @media (max-width: 767px) and (orientation: landscape) {
        .buku-induk-photo {
            max-width: 100px;
        }

        .card-body {
            padding: 12px;
        }

        .buku-induk-section {
            margin-bottom: 15px;
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
            border: 1px solid #ddd;
        }

        .buku-induk-table {
            font-size: 10pt;
        }

        .page-break {
            page-break-after: always;
        }

        @page {
            margin: 2cm;
        }
    }
</style>

<div class="container-fluid buku-induk-container mt-4">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-book"></i> Buku Induk Siswa
        </h1>
        <div class="action-buttons">
            <a href="{{ route('tu.buku-induk.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('tu.buku-induk.cetak', $siswa) }}" target="_blank" class="btn btn-primary btn-sm">
                <i class="fas fa-print me-1"></i> Cetak
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Header -->
            <div class="buku-induk-header">
                <h3 class="mb-2">BUKU INDUK SISWA</h3>
                <h4 class="mb-1">SMKN 1 KAWALI</h4>
                <p class="mb-0 text-muted"></p>
                <p class="text-muted">KONSENTRASI KEAHLIAN: {{ $siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan ? $siswa->rombel->kelas->jurusan->nama : 'REKAYASA PERANGKAT LUNAK' }}</p>
            </div>

            <!-- Info Siswa -->
            <div class="row mb-4">
                <!-- Photo - Will be reordered on mobile -->
                <div class="col-md-3 order-md-2">
                    <div class="photo-container">
                        @if(isset($siswa->user) && isset($siswa->user->photo))
                            <img src="{{ asset('storage/' . $siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}" class="buku-induk-photo">
                        @else
                            <div class="buku-induk-photo d-flex align-items-center justify-content-center bg-light">
                                <span class="text-muted" style="font-size: 12px;">Tidak ada foto</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Data Siswa -->
                <div class="col-md-9 order-md-1">
                    <!-- Data Pribadi -->
                    <div class="buku-induk-section">
                        <h5>A. DATA PRIBADI SISWA</h5>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
                                <p><strong>NISN:</strong> {{ $siswa->nisn ?? '-' }}</p>
                                <p><strong>Nama Lengkap:</strong> {{ $siswa->nama_lengkap }}</p>
                                <p><strong>Jenis Kelamin:</strong> {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div class="col-md-6 col-12">
                                <p><strong>Tempat Lahir:</strong> {{ $siswa->tempat_lahir ?? '-' }}</p>
                                <p><strong>Tanggal Lahir:</strong> {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}</p>
                                <p><strong>Agama:</strong> {{ $siswa->agama ?? '-' }}</p>
                                <p><strong>Alamat:</strong> {{ $siswa->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="buku-induk-section">
                        <h5>B. DATA ORANG TUA / WALI</h5>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <p><strong>Nama Ayah:</strong> {{ $siswa->nama_ayah ?? '-' }}</p>
                                <p><strong>Pekerjaan Ayah:</strong> {{ $siswa->pekerjaan_ayah ?? '-' }}</p>
                                <p><strong>Nama Ibu:</strong> {{ $siswa->nama_ibu ?? '-' }}</p>
                                <p><strong>Pekerjaan Ibu:</strong> {{ $siswa->pekerjaan_ibu ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 col-12">
                                <p><strong>Alamat Orang Tua:</strong> {{ $siswa->alamat ?? '-' }}</p>
                                <p><strong>Nama Wali:</strong> {{ $siswa->nama_wali ?? '-' }}</p>
                                <p><strong>Pekerjaan Wali:</strong> {{ $siswa->pekerjaan_wali ?? '-' }}</p>
                                <p><strong>Alamat Wali:</strong> {{ $siswa->alamat_wali ?? '-' }}</p>
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
            <div class="buku-induk-section">
                <h5>E. HASIL PRESTASI PEMBELAJARAN</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered buku-induk-table">
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
                                    <tr style="background-color: #f0f0f0; font-weight: bold;">
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
                                <tr style="background-color: #f0f0f0; font-weight: bold;">
                                    <td colspan="{{ 1 + (count($nilaiByKelompok['tahunAjaranList']) * 2) }}">A. KELOMPOK MATA PELAJARAN UMUM</td>
                                </tr>
                                <tr>
                                    <td>-</td>
                                    @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                    @endforeach
                                </tr>
                                <tr style="background-color: #f0f0f0; font-weight: bold;">
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