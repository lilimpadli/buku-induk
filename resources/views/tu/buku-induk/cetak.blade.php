<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Induk - {{ $siswa->nama_lengkap }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #fff;
            padding: 20px;
            color: #000;
            line-height: 1.5;
        }
        .container {
            max-width: 210mm;
            margin: 0 auto;
            background-color: white;
            padding: 40px;
        }
        .buku-induk-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }
        .buku-induk-header h1 {
            font-size: 16px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .buku-induk-header h2 {
            font-size: 14px;
            font-weight: normal;
        }
        .buku-induk-header p {
            font-size: 11px;
            margin: 3px 0;
        }
        .buku-induk-section {
            margin-bottom: 25px;
        }
        .buku-induk-section h5 {
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
        }
        .info-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 11px;
        }
        .info-col {
            flex: 1;
        }
        .info-label {
            font-weight: bold;
        }
        .buku-induk-photo {
            width: 120px;
            height: 150px;
            border: 1px solid #ddd;
            object-fit: cover;
        }
        .student-info-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .student-info {
            flex: 1;
        }
        .student-photo {
            text-align: center;
        }
        .photo-label {
            font-size: 10px;
            margin-top: 5px;
        }
        .buku-induk-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        .buku-induk-table th, .buku-induk-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        .buku-induk-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .buku-induk-table td:first-child,
        .buku-induk-table th:first-child {
            text-align: left;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .signature-section {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
            font-size: 10px;
        }
        .signature-box {
            text-align: center;
            width: 130px;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            height: 30px;
            margin-bottom: 5px;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .container {
                box-shadow: none;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="buku-induk-header">
            <h1>BUKU INDUK SISWA</h1>
            <h2>SMKN 1 KAWALI</h2>
            <p>KONSENTRASI KEAHLIAN: {{ $siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan ? $siswa->rombel->kelas->jurusan->nama : 'REKAYASA PERANGKAT LUNAK' }}</p>
        </div>

        <!-- Info Siswa -->
        <div class="student-info-container">
            <div class="student-info">
                <!-- Data Pribadi -->
                <div class="buku-induk-section">
                    <h5>A. DATA PRIBADI SISWA</h5>
                    <div class="info-row">
                        <div class="info-col">
                            <p><span class="info-label">NIS:</span> {{ $siswa->nis }}</p>
                            <p><span class="info-label">NISN:</span> {{ $siswa->nisn ?? '-' }}</p>
                            <p><span class="info-label">Nama Lengkap:</span> {{ $siswa->nama_lengkap }}</p>
                            <p><span class="info-label">Jenis Kelamin:</span> {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div class="info-col">
                            <p><span class="info-label">Tempat Lahir:</span> {{ $siswa->tempat_lahir ?? '-' }}</p>
                            <p><span class="info-label">Tanggal Lahir:</span> {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}</p>
                            <p><span class="info-label">Agama:</span> {{ $siswa->agama ?? '-' }}</p>
                            <p><span class="info-label">Alamat:</span> {{ $siswa->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div class="buku-induk-section">
                    <h5>B. DATA ORANG TUA / WALI</h5>
                    <div class="info-row">
                        <div class="info-col">
                            <p><span class="info-label">Nama Ayah:</span> {{ $siswa->nama_ayah ?? '-' }}</p>
                            <p><span class="info-label">Pekerjaan Ayah:</span> {{ $siswa->pekerjaan_ayah ?? '-' }}</p>
                            <p><span class="info-label">Nama Ibu:</span> {{ $siswa->nama_ibu ?? '-' }}</p>
                            <p><span class="info-label">Pekerjaan Ibu:</span> {{ $siswa->pekerjaan_ibu ?? '-' }}</p>
                        </div>
                        <div class="info-col">
                            <p><span class="info-label">Alamat Orang Tua:</span> {{ $siswa->alamat ?? '-' }}</p>
                            <p><span class="info-label">Nama Wali:</span> {{ $siswa->nama_wali ?? '-' }}</p>
                            <p><span class="info-label">Pekerjaan Wali:</span> {{ $siswa->pekerjaan_wali ?? '-' }}</p>
                            <p><span class="info-label">Alamat Wali:</span> {{ $siswa->alamat_wali ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Data Pendaftaran -->
                <div class="buku-induk-section">
                    <h5>C. DATA PENDAFTARAN</h5>
                    <div class="info-row">
                        <div class="info-col">
                            <p><span class="info-label">Sekolah Asal:</span> {{ $siswa->sekolah_asal ?? '-' }}</p>
                            <p><span class="info-label">Tanggal Diterima:</span> {{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->format('d F Y') : '-' }}</p>
                            <p><span class="info-label">Status Keluarga:</span> {{ $siswa->status_keluarga ?? '-' }}</p>
                        </div>
                        <div class="info-col">
                            <p><span class="info-label">Anak Ke-:</span> {{ $siswa->anak_ke ?? '-' }}</p>
                            <p><span class="info-label">No. HP:</span> {{ $siswa->no_hp ?? '-' }}</p>
                            <p><span class="info-label">Catatan Wali Kelas:</span> {{ $siswa->catatan_wali_kelas ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Status Mutasi -->
                <div class="buku-induk-section">
                    <h5>D. STATUS MUTASI</h5>
                    @if($siswa->mutasiTerakhir)
                        <p><span class="info-label">Status:</span> {{ $siswa->mutasiTerakhir->status_label }}</p>
                        <p><span class="info-label">Tanggal Mutasi:</span> {{ $siswa->mutasiTerakhir->tanggal_mutasi ? \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_mutasi)->format('d F Y') : '-' }}</p>
                        <p><span class="info-label">Keterangan:</span> {{ $siswa->mutasiTerakhir->keterangan ?? '-' }}</p>
                        <p><span class="info-label">Alasan Pindah:</span> {{ $siswa->mutasiTerakhir->alasan_pindah ?? '-' }}</p>
                        <p><span class="info-label">Sekolah Tujuan:</span> {{ $siswa->mutasiTerakhir->tujuan_pindah ?? '-' }}</p>
                    @else
                        <p><em>Tidak ada data mutasi</em></p>
                    @endif
                </div>
            </div>

            <!-- Photo -->
            <div class="student-photo">
                @if(isset($siswa->user) && isset($siswa->user->photo))
                    <img src="{{ asset('storage/' . $siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}" class="buku-induk-photo">
                @else
                    <div class="buku-induk-photo" style="display: flex; align-items: center; justify-content: center; background-color: #f9f9f9; color: #999;">
                        FOTO<br>3x4
                    </div>
                @endif
                <div class="photo-label">FOTO 3x4</div>
            </div>
        </div>

        <!-- Nilai Raport -->
        <div class="buku-induk-section">
            <h5>E. HASIL PRESTASI PEMBELAJARAN</h5>
            <div class="table-responsive">
                @if(count($siswa->nilaiRaports) > 0)
                    <table class="buku-induk-table">
                        <thead>
                            <tr>
                                <th rowspan="3" style="vertical-align: middle; width: 25%;">MATA PELAJARAN</th>
                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                    <th colspan="2" class="text-center">{{ $tahunAjaran }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                    <th style="width: 35px;">1</th>
                                    <th style="width: 35px;">2</th>
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
                        </tbody>
                    </table>
                @else
                    <p><em>Tidak ada data nilai raport untuk siswa ini</em></p>
                @endif
            </div>
        </div>

        <!-- Signature -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line"></div>
                <p>Mengetahui,</p>
                <p>Orang Tua/Wali</p>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <p>Ciamis, {{ now()->format('d M Y') }}</p>
                <p>Siswa Bersangkutan</p>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <p>Wali Kelas</p>
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
