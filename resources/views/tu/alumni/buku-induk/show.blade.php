@extends('layouts.app')

@section('title', 'Buku Induk Alumni - ' . $siswa->nama_lengkap)

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
    }
    
    .buku-induk-photo {
        width: 150px;
        height: 200px;
        border: 1px solid #ddd;
        object-fit: cover;
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
</style>

<div class="container-fluid buku-induk-container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-book text-primary"></i> Buku Induk Alumni
            </h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('tu.alumni.show', $siswa->id) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('tu.alumni.buku-induk.cetak', $siswa->id) }}" target="_blank" class="btn btn-primary btn-sm">
                <i class="fas fa-print"></i> Cetak
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Header -->
            <div class="buku-induk-header">
                <h3 class="mb-2" style="font-weight: bold;">BUKU INDUK SISWA </h3>
                <h4 class="mb-1">SMKN 1 KAWALI</h4>
                <p class="mb-0 text-muted"></p>
                <p class="text-muted" style="font-size: 0.9rem;">KONSENTRASI KEAHLIAN: {{ $siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan ? $siswa->rombel->kelas->jurusan->nama : 'REKAYASA PERANGKAT LUNAK' }}</p>
            </div>

            <!-- Info Siswa -->
            <div class="row mb-4">
                <div class="col-md-9">
                    <!-- Data Pribadi -->
                    <div class="buku-induk-section">
                        <h5>A. DATA PRIBADI SISWA</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
                                <p><strong>NISN:</strong> {{ $siswa->nisn ?? '-' }}</p>
                                <p><strong>Nama Lengkap:</strong> {{ $siswa->nama_lengkap }}</p>
                                <p><strong>Jenis Kelamin:</strong> {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <p><strong>Nama Ayah:</strong> {{ $siswa->nama_ayah ?? '-' }}</p>
                                <p><strong>Pekerjaan Ayah:</strong> {{ $siswa->pekerjaan_ayah ?? '-' }}</p>
                                <p><strong>Nama Ibu:</strong> {{ $siswa->nama_ibu ?? '-' }}</p>
                                <p><strong>Pekerjaan Ibu:</strong> {{ $siswa->pekerjaan_ibu ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <p><strong>Sekolah Asal:</strong> {{ $siswa->sekolah_asal ?? '-' }}</p>
                                <p><strong>Tanggal Diterima:</strong> {{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->format('d F Y') : '-' }}</p>
                                <p><strong>Status Keluarga:</strong> {{ $siswa->status_keluarga ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                @if($siswa->mutasiTerakhir)
                                    <p><strong>Status:</strong> <span class="badge bg-{{ $siswa->mutasiTerakhir->status == 'Lulus' ? 'success' : 'warning' }}">{{ $siswa->mutasiTerakhir->status }}</span></p>
                                    <p><strong>Tahun Ajaran:</strong> {{ $siswa->mutasiTerakhir->tahun_ajaran ?? '-' }}</p>
                                    <p><strong>Semester:</strong> {{ $siswa->mutasiTerakhir->semester ?? '-' }}</p>
                                    <p><strong>Catatan:</strong> {{ $siswa->mutasiTerakhir->catatan ?? '-' }}</p>
                                @else
                                    <p><strong>Status:</strong> <span class="badge bg-secondary">Belum Ada Data</span></p>
                                    <p><strong>Tahun Ajaran:</strong> -</p>
                                    <p><strong>Semester:</strong> -</p>
                                    <p><strong>Catatan:</strong> -</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if($siswa->mutasiTerakhir)
                                    <p><em class="text-muted">Detail status kenaikan kelas</em></p>
                                @else
                                    <p><em class="text-muted">Alumni ini belum memiliki data status kenaikan</em></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photo -->
                <div class="col-md-3">
                    <div class="text-center">
                        @if($siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}" class="buku-induk-photo">
                        @else
                            <div class="buku-induk-photo d-flex align-items-center justify-content-center bg-light">
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
                    <table class="table table-sm table-bordered buku-induk-table" style="font-size: 11px;">
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
