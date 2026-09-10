@extends('layouts.app')

@section('title', 'Buku Induk Alumni - ' . ($siswa->nama_lengkap ?? 'Siswa'))

@section('content')
<style>
    :root {
        --primary: #4F46E5;
        --primary-dark: #4338CA;
    }

    .buku-induk-container {
        font-family: 'Times New Roman', Times, serif;
        line-height: 1.6;
    }

    .buku-induk-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #333;
    }

    .buku-induk-header h2 {
        font-weight: bold;
        font-size: 24px;
    }

    .buku-induk-header h4 {
        font-size: 18px;
    }

    .buku-induk-photo {
        width: 150px;
        height: 200px;
        border: 1px solid #ddd;
        object-fit: cover;
    }

    .buku-induk-section {
        margin-bottom: 25px;
    }

    .buku-induk-section h5 {
        font-weight: bold;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #ddd;
        color: var(--primary);
    }

    .info-item {
        margin-bottom: 6px;
        font-size: 14px;
    }

    .info-item strong {
        font-weight: 600;
        min-width: 140px;
        display: inline-block;
    }

    .table-buku-induk {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
    }

    .table-buku-induk th,
    .table-buku-induk td {
        border: 1px solid #000;
        padding: 6px 8px;
        text-align: center;
    }

    .table-buku-induk th {
        background-color: #f0f0f0;
        font-weight: bold;
    }

    .table-buku-induk td:first-child {
        text-align: left;
    }

    .badge-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-lulus {
        background: #10B981;
        color: white;
    }

    .badge-belum {
        background: #F59E0B;
        color: white;
    }

    .btn-print {
        background: var(--primary);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-print:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        color: white;
    }

    .btn-back {
        background: #e2e8f0;
        color: #1e293b;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back:hover {
        background: #cbd5e1;
        transform: translateY(-2px);
        color: #1e293b;
    }

    @media (max-width: 768px) {
        .info-item strong {
            min-width: 100px;
            font-size: 13px;
        }
        .info-item {
            font-size: 13px;
        }
        .table-buku-induk {
            font-size: 10px;
        }
        .buku-induk-photo {
            width: 100px;
            height: 133px;
        }
    }
</style>

<div class="container-fluid py-4 buku-induk-container">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="mb-0">
            <i class="fas fa-book text-primary"></i> Buku Induk Alumni
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('tu.alumni.show', $siswa->id) }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('tu.alumni.buku-induk.cetak', $siswa->id) }}" target="_blank" class="btn-print">
                <i class="fas fa-print"></i> Cetak PDF
            </a>
        </div>
    </div>

    <!-- Card -->
    <div class="card shadow-sm">
        <div class="card-body">

            <!-- Header Buku Induk -->
            <div class="buku-induk-header">
                <h2>BUKU INDUK SISWA ALUMNI</h2>
                <h4>SMK NEGERI 1 KAWALI</h4>
                <p class="text-muted" style="font-size: 14px;">
                    Konsentrasi Keahlian: 
                    {{ $siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan 
                        ? $siswa->rombel->kelas->jurusan->nama 
                        : 'Tidak tersedia' }}
                </p>
            </div>

            <!-- Data Pribadi -->
            <div class="row">
                <div class="col-md-9">
                    <!-- A. Data Pribadi -->
                    <div class="buku-induk-section">
                        <h5>A. DATA PRIBADI SISWA</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item"><strong>NIS:</strong> {{ $siswa->nis ?? '-' }}</div>
                                <div class="info-item"><strong>NISN:</strong> {{ $siswa->nisn ?? '-' }}</div>
                                <div class="info-item"><strong>Nama Lengkap:</strong> {{ $siswa->nama_lengkap ?? '-' }}</div>
                                <div class="info-item"><strong>Jenis Kelamin:</strong> 
                                    {{ $siswa->jenisKelamin->nama ?? $siswa->jenis_kelamin ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item"><strong>Tempat Lahir:</strong> {{ $siswa->tempat_lahir ?? '-' }}</div>
                                <div class="info-item"><strong>Tanggal Lahir:</strong> 
                                    {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}
                                </div>
                                <div class="info-item"><strong>Agama:</strong> 
                                    {{ $siswa->agama->nama ?? $siswa->agama_lainnya ?? '-' }}
                                </div>
                                <div class="info-item"><strong>Alamat:</strong> {{ $siswa->alamat ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- B. Orang Tua -->
                    <div class="buku-induk-section">
                        <h5>B. DATA ORANG TUA / WALI</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item"><strong>Nama Ayah:</strong> {{ $siswa->ayah->nama ?? $siswa->nama_ayah ?? '-' }}</div>
                                <div class="info-item"><strong>Pekerjaan Ayah:</strong> {{ $siswa->ayah->pekerjaan ?? $siswa->pekerjaan_ayah ?? '-' }}</div>
                                <div class="info-item"><strong>Nama Ibu:</strong> {{ $siswa->ibu->nama ?? $siswa->nama_ibu ?? '-' }}</div>
                                <div class="info-item"><strong>Pekerjaan Ibu:</strong> {{ $siswa->ibu->pekerjaan ?? $siswa->pekerjaan_ibu ?? '-' }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item"><strong>Nama Wali:</strong> {{ $siswa->wali->nama ?? $siswa->nama_wali ?? '-' }}</div>
                                <div class="info-item"><strong>Pekerjaan Wali:</strong> {{ $siswa->wali->pekerjaan ?? $siswa->pekerjaan_wali ?? '-' }}</div>
                                <div class="info-item"><strong>Alamat Wali:</strong> {{ $siswa->wali->alamat ?? $siswa->alamat_wali ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- C. Status Mutasi -->
                    <div class="buku-induk-section">
                        <h5>C. STATUS MUTASI</h5>
                        @if($siswa->mutasiTerakhir)
                            <div class="info-item">
                                <strong>Status:</strong> 
                                <span class="badge-status badge-lulus">LULUS</span>
                            </div>
                            <div class="info-item"><strong>Tahun Ajaran:</strong> {{ $siswa->mutasiTerakhir->tahun_ajaran ?? '-' }}</div>
                            <div class="info-item"><strong>Semester:</strong> {{ $siswa->mutasiTerakhir->semester ?? '-' }}</div>
                            <div class="info-item"><strong>Catatan:</strong> {{ $siswa->mutasiTerakhir->catatan ?? '-' }}</div>
                        @else
                            <div class="info-item">
                                <strong>Status:</strong> 
                                <span class="badge-status badge-belum">Belum Ada Data</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Photo -->
                <div class="col-md-3 text-center">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto" class="buku-induk-photo">
                    @else
                        <div class="buku-induk-photo d-flex align-items-center justify-content-center bg-light" style="border: 1px solid #ddd;">
                            <span class="text-muted">Tidak ada foto</span>
                        </div>
                    @endif
                    <p class="mt-2 text-muted" style="font-size: 12px;">Foto Siswa</p>
                </div>
            </div>

            <!-- Nilai Raport -->
            <div class="buku-induk-section">
                <h5>D. HASIL PRESTASI PEMBELAJARAN</h5>
                <div class="table-responsive">
                    <table class="table-buku-induk">
                        <thead>
                            <tr>
                                <th rowspan="3" style="width: 35%;">MATA PELAJARAN</th>
                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                    <th colspan="2" class="text-center">{{ $tahunAjaran }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                    <th style="width: 8%;">1</th>
                                    <th style="width: 8%;">2</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                    <th>NILAI</th>
                                    <th>NILAI</th>
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
                                                <td>{{ $mapelData['nilai'][$tahunAjaran][1] ?? '-' }}</td>
                                                <td>{{ $mapelData['nilai'][$tahunAjaran][2] ?? '-' }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="{{ 1 + (count($nilaiByKelompok['tahunAjaranList']) * 2) }}" class="text-center">Belum ada data nilai</td>
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