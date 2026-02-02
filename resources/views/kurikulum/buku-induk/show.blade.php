@extends('layouts.app')

@section('title', 'Buku Induk - ' . $siswa->nama_lengkap)

@section('content')
<style>
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
    
    .buku-induk-section {
        margin-bottom: 25px;
    }
    
    .buku-induk-section h5 {
        font-weight: bold;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #ddd;
        font-size: 1rem;
    }
    
    .buku-induk-photo {
        width: 150px;
        height: 200px;
        border: 1px solid #ddd;
        object-fit: cover;
        max-width: 100%;
    }
    
    .buku-induk-table {
        font-size: 12px;
    }
    
    .buku-induk-table th {
        font-weight: bold;
        background-color: #f8f9fa;
        text-align: center;
    }
    
    .buku-induk-table td {
        vertical-align: middle;
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

    /* Info item styling */
    .info-item {
        margin-bottom: 0.75rem;
        word-wrap: break-word;
    }

    .info-item strong {
        display: inline-block;
        min-width: 140px;
        font-weight: 600;
    }

    /* Responsive styles for mobile */
    @media (max-width: 768px) {
        .buku-induk-header h3 {
            font-size: 1.25rem;
        }

        .buku-induk-header h4 {
            font-size: 1.1rem;
        }

        .buku-induk-header p {
            font-size: 0.85rem;
        }

        .buku-induk-section h5 {
            font-size: 0.95rem;
        }

        .info-item {
            font-size: 0.9rem;
        }

        .info-item strong {
            display: block;
            min-width: auto;
            margin-bottom: 0.25rem;
        }

        /* Photo section on mobile */
        .photo-mobile {
            margin-bottom: 20px;
            text-align: center;
        }

        .buku-induk-photo {
            width: 120px;
            height: 160px;
        }

        /* Table responsive */
        .table-responsive {
            font-size: 10px;
        }

        .buku-induk-table {
            font-size: 9px;
        }

        .buku-induk-table th,
        .buku-induk-table td {
            padding: 0.4rem 0.25rem;
            white-space: nowrap;
        }

        /* Button adjustments */
        .btn-sm {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .action-buttons .btn {
            flex: 1;
            min-width: 120px;
        }

        /* Card padding */
        .card-body {
            padding: 1rem;
        }

        /* Section spacing */
        .buku-induk-section {
            margin-bottom: 20px;
        }
    }

    /* Responsive styles for tablets */
    @media (min-width: 769px) and (max-width: 1024px) {
        .buku-induk-table {
            font-size: 11px;
        }

        .info-item strong {
            min-width: 130px;
        }
    }

    /* Desktop optimization */
    @media (min-width: 1025px) {
        .buku-induk-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .card-body {
            padding: 2rem;
        }
    }

    /* Print styles */
    @media print {
        .btn, 
        .action-buttons,
        .col-md-4.text-end {
            display: none !important;
        }

        .buku-induk-container {
            font-size: 12pt;
        }

        .card {
            border: none;
            box-shadow: none;
        }

        .buku-induk-table {
            font-size: 10pt;
        }

        @page {
            margin: 2cm;
        }
    }
</style>

<div class="container-fluid buku-induk-container">
    <!-- Header Section -->
    <div class="row mb-3 mb-md-4">
        <div class="col-12 col-md-8 mb-2 mb-md-0">
            <h1 class="h4 h3-md mb-0">
                <i class="fas fa-book text-primary"></i> Buku Induk Siswa
            </h1>
        </div>
        <div class="col-12 col-md-4">
            <div class="action-buttons">
                <a href="{{ route('kurikulum.buku-induk.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('kurikulum.buku-induk.cetak', $siswa) }}" target="_blank" class="btn btn-primary btn-sm">
                    <i class="fas fa-print"></i> Cetak
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Header -->
            <div class="buku-induk-header">
                <h3 class="mb-2" style="font-weight: bold;">BUKU INDUK SISWA</h3>
                <h4 class="mb-1">SMKN 1 KAWALI</h4>
                <p class="mb-0 text-muted"></p>
                <p class="text-muted" style="font-size: 0.9rem;">
                    KONSENTRASI KEAHLIAN: {{ $siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan ? $siswa->rombel->kelas->jurusan->nama : 'REKAYASA PERANGKAT LUNAK' }}
                </p>
            </div>

            <!-- Photo for Mobile (appears first on mobile) -->
            <div class="d-md-none photo-mobile">
                @if(isset($siswa->user) && isset($siswa->user->photo))
                    <img src="{{ asset('storage/' . $siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}" class="buku-induk-photo">
                @else
                    <div class="buku-induk-photo d-inline-flex align-items-center justify-content-center bg-light">
                        <span class="text-muted small">Tidak ada foto</span>
                    </div>
                @endif
            </div>

            <!-- Info Siswa -->
            <div class="row mb-4">
                <div class="col-md-9">
                    <!-- Data Pribadi -->
                    <div class="buku-induk-section">
                        <h5>A. DATA PRIBADI SISWA</h5>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <p class="info-item"><strong>NIS:</strong> {{ $siswa->nis }}</p>
                                <p class="info-item"><strong>NISN:</strong> {{ $siswa->nisn ?? '-' }}</p>
                                <p class="info-item"><strong>Nama Lengkap:</strong> {{ $siswa->nama_lengkap }}</p>
                                <p class="info-item"><strong>Jenis Kelamin:</strong> {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="info-item"><strong>Tempat Lahir:</strong> {{ $siswa->tempat_lahir ?? '-' }}</p>
                                <p class="info-item"><strong>Tanggal Lahir:</strong> {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}</p>
                                <p class="info-item"><strong>Agama:</strong> {{ $siswa->agama ?? '-' }}</p>
                                <p class="info-item"><strong>Alamat:</strong> {{ $siswa->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="buku-induk-section">
                        <h5>B. DATA ORANG TUA / WALI</h5>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <p class="info-item"><strong>Nama Ayah:</strong> {{ $siswa->nama_ayah ?? '-' }}</p>
                                <p class="info-item"><strong>Pekerjaan Ayah:</strong> {{ $siswa->pekerjaan_ayah ?? '-' }}</p>
                                <p class="info-item"><strong>Nama Ibu:</strong> {{ $siswa->nama_ibu ?? '-' }}</p>
                                <p class="info-item"><strong>Pekerjaan Ibu:</strong> {{ $siswa->pekerjaan_ibu ?? '-' }}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="info-item"><strong>Alamat Orang Tua:</strong> {{ $siswa->alamat ?? '-' }}</p>
                                <p class="info-item"><strong>Nama Wali:</strong> {{ $siswa->nama_wali ?? '-' }}</p>
                                <p class="info-item"><strong>Pekerjaan Wali:</strong> {{ $siswa->pekerjaan_wali ?? '-' }}</p>
                                <p class="info-item"><strong>Alamat Wali:</strong> {{ $siswa->alamat_wali ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pendaftaran -->
                    <div class="buku-induk-section">
                        <h5>C. DATA PENDAFTARAN</h5>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <p class="info-item"><strong>Sekolah Asal:</strong> {{ $siswa->sekolah_asal ?? '-' }}</p>
                                <p class="info-item"><strong>Tanggal Diterima:</strong> {{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->format('d F Y') : '-' }}</p>
                                <p class="info-item"><strong>Status Keluarga:</strong> {{ $siswa->status_keluarga ?? '-' }}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="info-item"><strong>Anak Ke-:</strong> {{ $siswa->anak_ke ?? '-' }}</p>
                                <p class="info-item"><strong>No. HP:</strong> {{ $siswa->no_hp ?? '-' }}</p>
                                <p class="info-item"><strong>Catatan Wali Kelas:</strong> {{ $siswa->catatan_wali_kelas ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Mutasi -->
                    <div class="buku-induk-section">
                        <h5>D. STATUS MUTASI</h5>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                @if($siswa->mutasiTerakhir)
                                    <p class="info-item"><strong>Status:</strong> <span class="badge bg-{{ $siswa->mutasiTerakhir->status_color }}">{{ $siswa->mutasiTerakhir->status_label }}</span></p>
                                    <p class="info-item"><strong>Tanggal Mutasi:</strong> {{ $siswa->mutasiTerakhir->tanggal_mutasi ? \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_mutasi)->format('d F Y') : '-' }}</p>
                                    <p class="info-item"><strong>Keterangan:</strong> {{ $siswa->mutasiTerakhir->keterangan ?? '-' }}</p>
                                @else
                                    <p class="info-item"><strong>Status:</strong> <span class="badge bg-success">Aktif</span></p>
                                    <p class="info-item"><strong>Tanggal Mutasi:</strong> -</p>
                                    <p class="info-item"><strong>Keterangan:</strong> -</p>
                                @endif
                            </div>
                            <div class="col-12 col-md-6">
                                @if($siswa->mutasiTerakhir)
                                    <p class="info-item"><strong>Alasan Pindah:</strong> {{ $siswa->mutasiTerakhir->alasan_pindah ?? '-' }}</p>
                                    <p class="info-item"><strong>Sekolah Tujuan:</strong> {{ $siswa->mutasiTerakhir->tujuan_pindah ?? '-' }}</p>
                                    <p class="info-item"><strong>No. SK Keluar:</strong> {{ $siswa->mutasiTerakhir->no_sk_keluar ?? '-' }}</p>
                                    <p class="info-item"><strong>Tanggal SK Keluar:</strong> {{ $siswa->mutasiTerakhir->tanggal_sk_keluar ? \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_sk_keluar)->format('d F Y') : '-' }}</p>
                                @else
                                    <p class="info-item"><strong>Alasan Pindah:</strong> -</p>
                                    <p class="info-item"><strong>Sekolah Tujuan:</strong> -</p>
                                    <p class="info-item"><strong>No. SK Keluar:</strong> -</p>
                                    <p class="info-item"><strong>Tanggal SK Keluar:</strong> -</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photo for Desktop -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="text-center">
                        @if(isset($siswa->user) && isset($siswa->user->photo))
                            <img src="{{ asset('storage/' . $siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}" class="buku-induk-photo">
                        @else
                            <div class="buku-induk-photo d-flex align-items-center justify-content-center bg-light mx-auto">
                                <span class="text-muted">Tidak ada foto</span>
                            </div>
                        @endif
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
                                <th rowspan="3" style="vertical-align: middle; min-width: 150px;">MATA PELAJARAN</th>
                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                    <th colspan="2" class="text-center">{{ $tahunAjaran }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                    <th class="text-center" style="min-width: 45px;">1</th>
                                    <th class="text-center" style="min-width: 45px;">2</th>
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
                                    @if(count($mapelGroup) > 0)
                                        @foreach($mapelGroup as $mapelNama => $mapelData)
                                            <tr>
                                                <td>{{ $mapelData['nama'] }}</td>
                                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                                    <td class="text-center">{{ $mapelData['nilai'][$tahunAjaran][1] ?? '-' }}</td>
                                                    <td class="text-center">{{ $mapelData['nilai'][$tahunAjaran][2] ?? '-' }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>-</td>
                                            @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                            @endforeach
                                        </tr>
                                    @endif
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