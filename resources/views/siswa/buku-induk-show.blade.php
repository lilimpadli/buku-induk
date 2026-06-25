@extends('layouts.app')

@section('title', 'Buku Induk - ' . $siswa->nama_lengkap)

@section('content')
<style>
    .buku-induk-wrap { font-family: 'Times New Roman', serif; line-height: 1.6; color: #1e293b; }
    .card-document { border: 1px solid #cbd5e1; border-radius: 12px; background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .doc-header { text-align: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 3px double #334155; }
    .data-label { font-weight: bold; min-width: 160px; display: inline-block; color: #475569; }
    .photo-frame { width: 100%; max-width: 140px; height: auto; aspect-ratio: 3/4; border: 2px solid #cbd5e1; p: 2px; object-fit: cover; }
    .table-matrix th { background-color: #f8fafc; font-weight: bold; text-align: center; vertical-align: middle; border-color: #cbd5e1; }
    .table-matrix td { border-color: #cbd5e1; vertical-align: middle; }
</style>

@php $currentTab = request()->get('tab', 'biodata'); @endphp

<div class="container-fluid buku-induk-wrap mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">
            @if($currentTab == 'biodata')
                <i class="fas fa-user text-primary me-2"></i>Lembar Profil & Biodata Siswa
            @elseif($currentTab == 'keluarga')
                <i class="fas fa-users text-primary me-2"></i>Lembar Data Orang Tua / Wali
            @elseif($currentTab == 'nilai')
                <i class="fas fa-graduation-cap text-primary me-2"></i>Lembar Nilai Akademik
            @endif
        </h3>
        <div>
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-sm btn-outline-secondary me-2"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
            <a href="{{ route('siswa.bukuInduk.cetak') }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print me-1"></i> Cetak Dokumen</a>
        </div>
    </div>

    <div class="card card-document">
        <div class="card-body p-4 p-md-5">
            
            <div class="doc-header">
                <h4 class="mb-1 fw-bold text-dark">BUKU INDUK PESERTA DIDIK</h4>
                <h5 class="mb-1 fw-bold text-dark">SMKN 1 KAWALI</h5>
                <small class="text-muted text-uppercase">Konsentrasi Keahlian: {{ $siswa->rombel->kelas->jurusan->nama ?? 'Rekayasa Perangkat Lunak' }}</small>
            </div>

            {{-- TAB 1: BIODATA --}}
            @if($currentTab == 'biodata')
                <div class="row g-4">
                    <div class="col-md-9">
                        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">A. IDENTITAS DIRI SISWA</h5>
                        <p><span class="data-label">1. NIS / NISN</span>: {{ $siswa->nis }} / {{ $siswa->nisn ?? '-' }}</p>
                        <p><span class="data-label">2. Nama Lengkap</span>: <strong class="text-dark">{{ $siswa->nama_lengkap }}</strong></p>
                        <p><span class="data-label">3. Jenis Kelamin</span>: {{ $siswa->jenis_kelamin }}</p>
                        <p><span class="data-label">4. Tempat, Tgl Lahir</span>: {{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir }}</p>
                        <p><span class="data-label">5. Agama</span>: {{ $siswa->agama ?? '-' }}</p>
                        <p><span class="data-label">6. Alamat Rumah</span>: Dusun {{ $siswa->dusun ?? '-' }}, RT {{ $siswa->rt ?? '0' }} / RW {{ $siswa->rw ?? '0' }}, Kel. {{ $siswa->kelurahan ?? '-' }}, Kec. {{ $siswa->kecamatan ?? '-' }}</p>
                        <p><span class="data-label">7. Sekolah Asal</span>: {{ $siswa->sekolah_asal ?? '-' }}</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <span class="d-block small text-muted mb-2 fw-bold">FOTO RESMI</span>
                        @if(isset($siswa->user) && isset($siswa->user->photo))
                            <img src="{{ asset('storage/' . $siswa->user->photo) }}" alt="Foto" class="photo-frame rounded shadow-sm">
                        @else
                            <div class="photo-frame bg-light border d-flex align-items-center justify-content-center mx-auto rounded text-muted" style="min-height: 160px;">
                                <small>Belum Ada Foto</small>
                            </div>
                        @endif
                    </div>
                </div>

            {{-- TAB 2: KELUARGA --}}
            @elseif($currentTab == 'keluarga')
                <h5 class="fw-bold text-primary mb-4 border-bottom pb-2">B. KETERANGAN ORANG TUA / WALI</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border">
                            <h6 class="fw-bold mb-3 text-dark"><i class="fas fa-user-tie text-muted me-2"></i>Data Ayah Kandung</h6>
                            <p class="mb-2"><span class="data-label" style="min-width: 110px;">Nama Ayah</span>: {{ $siswa->ayah->nama ?? '-' }}</p>
                            <p class="mb-0"><span class="data-label" style="min-width: 110px;">Pekerjaan</span>: {{ $siswa->ayah->pekerjaan ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border">
                            <h6 class="fw-bold mb-3 text-dark"><i class="fas fa-user text-muted me-2"></i>Data Ibu Kandung</h6>
                            <p class="mb-2"><span class="data-label" style="min-width: 110px;">Nama Ibu</span>: {{ $siswa->ibu->nama ?? '-' }}</p>
                            <p class="mb-0"><span class="data-label" style="min-width: 110px;">Pekerjaan</span>: {{ $siswa->ibu->pekerjaan ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded border">
                            <h6 class="fw-bold mb-3 text-dark"><i class="fas fa-user-friends text-muted me-2"></i>Data Wali (Jika Ada)</h6>
                            <p class="mb-2"><span class="data-label" style="min-width: 110px;">Nama Wali</span>: {{ $siswa->wali->nama ?? '-' }}</p>
                            <p class="mb-2"><span class="data-label" style="min-width: 110px;">Pekerjaan</span>: {{ $siswa->wali->pekerjaan ?? '-' }}</p>
                            <p class="mb-0"><span class="data-label" style="min-width: 110px;">Alamat Wali</span>: {{ $siswa->wali->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

            {{-- TAB 3: TRANSKRIP NILAI --}}
            @elseif($currentTab == 'nilai')
                <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">E. HASIL PRESTASI BELAJAR (TRANSKRIP RESMI)</h5>
                
                @php 
                    // 1. Ambil list urutan key asli dari database
                    $originalKeys = isset($nilaiByKelompok['tahunAjaranList']) ? array_values($nilaiByKelompok['tahunAjaranList']) : [];
                    
                    // 2. Deteksi nama kelas secara dinamis untuk menentukan header Tahun Ajaran
                    $namaKelas = strtoupper($siswa->rombel->kelas->nama ?? 'XI');
                    
                    // Fallback default (untuk Kelas 11)
                    $tahunMasuk = 2024; 
                    
                    if (str_contains($namaKelas, 'XII') || str_contains($namaKelas, '12')) {
                        $tahunMasuk = 2023; // Kelas 12 -> 2023/2024, 2024/2025, 2025/2026
                    } elseif (str_contains($namaKelas, 'X') && !str_contains($namaKelas, 'XI') && !str_contains($namaKelas, 'XII') || str_contains($namaKelas, '10')) {
                        $tahunMasuk = 2025; // Kelas 10 -> 2025/2026, 2026/2027, 2027/2028
                    } else {
                        $tahunMasuk = 2024; // Kelas 11 -> 2024/2025, 2025/2026, 2026/2027
                    }
                    
                    // 3. Susun rentang tahun ajaran rapi untuk header tabel
                    $tahunTampilList = [
                        $tahunMasuk . '/' . ($tahunMasuk + 1),
                        ($tahunMasuk + 1) . '/' . ($tahunMasuk + 2),
                        ($tahunMasuk + 2) . '/' . ($tahunMasuk + 3),
                    ];
                    
                    $totalTahun = count($tahunTampilList);
                    $totalColspan = 1 + ($totalTahun * 2);
                @endphp
                
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-matrix mb-0">
                        <thead>
                            <tr>
                                <th rowspan="3" style="width: 40%; text-align: left;">MATA PELAJARAN</th>
                                @foreach($tahunTampilList as $tahunTampil)
                                    <th colspan="2">{{ $tahunTampil }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($tahunTampilList as $tahunTampil)
                                    <th style="width: 75px;">Sms 1</th>
                                    <th style="width: 75px;">Sms 2</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($tahunTampilList as $tahunTampil)
                                    <th>NILAI</th>
                                    <th>NILAI</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($nilaiByKelompok['byKelompok']) && count($nilaiByKelompok['byKelompok']) > 0)
                                @foreach($nilaiByKelompok['byKelompok'] as $kelompok => $mapelGroup)
                                    <tr style="background-color: #f1f5f9; font-weight: bold;">
                                        <td colspan="{{ $totalColspan }}" class="text-dark text-start">
                                            @if($kelompok === 'A') A. KELOMPOK MATA PELAJARAN UMUM
                                            @elseif($kelompok === 'B') B. KELOMPOK MATA PELAJARAN KEAHLIAN
                                            @else KELOMPOK {{ strtoupper($kelompok) }} @endif
                                        </td>
                                    </tr>
                                    @foreach($mapelGroup as $mapelNama => $mapelData)
                                        <tr>
                                            <td class="text-start ps-3">{{ $mapelData['nama'] }}</td>
                                            
                                            {{-- Loop berdasarkan indeks (0, 1, 2) agar sinkron dengan data array DB --}}
                                            @foreach($tahunTampilList as $index => $tahunTampil)
                                                @php
                                                    $keyAsliDb = $originalKeys[$index] ?? 'KOSONG';
                                                @endphp
                                                <td class="text-center fw-bold text-primary">{{ $mapelData['nilai'][$keyAsliDb][1] ?? '-' }}</td>
                                                <td class="text-center fw-bold text-primary">{{ $mapelData['nilai'][$keyAsliDb][2] ?? '-' }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center text-muted py-4" colspan="{{ $totalColspan }}">Belum ada transkrip nilai resmi yang terekam.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection