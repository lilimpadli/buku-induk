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
            padding: 10px;
            color: #000;
            line-height: 1.4;
        }
        .container {
            max-width: 210mm;
            margin: 0 auto;
            background-color: white;
            padding: 15px;
            height: 297mm;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .buku-induk-header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #333;
        }
        .buku-induk-header h1 {
            font-size: 16px;
            margin-bottom: 2px;
            font-weight: bold;
        }
        .buku-induk-header h2 {
            font-size: 13px;
            font-weight: normal;
        }
        .buku-induk-header p {
            font-size: 11px;
            margin: 2px 0;
        }

        /* --- MAIN LAYOUT: TWO COLUMNS --- */
        .main-content-wrapper {
            display: flex;
            gap: 15px;
            flex-grow: 1; /* Mengisi sisa ruang tinggi halaman */
        }
        .nilai-column {
            flex: 3; /* Kolom nilai lebih lebar */
            display: flex;
            flex-direction: column;
        }
        .data-column {
            flex: 2; /* Kolom data lebih sempit */
            display: flex;
            flex-direction: column;
        }
        /* --- END OF MAIN LAYOUT --- */

        /* --- Right Column: Student Data (VERTICAL) --- */
        .data-section {
            margin-bottom: 12px;
        }
        .data-section-title {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 11px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 2px;
        }
        .data-row {
            display: flex;
            margin-bottom: 4px;
            align-items: flex-end; /* Sejajarkan label dengan garis bawah */
        }
        .data-label {
            width: 130px; /* Lebar label yang konsisten */
            font-weight: bold;
            padding-right: 8px;
            flex-shrink: 0;
            font-size: 10px;
        }
        .data-value {
            flex: 1;
            border-bottom: 1px solid #000;
            min-height: 14px; /* Tinggi garis bawah */
            font-size: 10px;
            padding-bottom: 1px; /* Beri jarak ke garis bawah */
        }
        
        /* --- Photo & Side Info Table --- */
        .photo-info-container {
            text-align: center;
            margin-bottom: 15px;
        }
        .photo-box {
            width: 100px;
            height: 130px;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
        }
        .photo-box img {
            width: 98px;
            height: 128px;
            object-fit: cover;
        }
        .side-table {
            width: 100%;
            font-size: 9px;
            text-align: left;
        }
        .side-table td {
            padding: 2px 4px;
            vertical-align: top;
        }
        .side-table td.label {
            font-weight: 700;
            width: 45%;
        }
        .side-table td.sep {
            width: 4%;
        }
        .side-table td.value {
            width: 51%;
        }

        /* --- Left Column: Grades Table (PANJANG) --- */
        .hasil-prestasi-title {
            text-align: center;
            font-weight: 700;
            margin: 0 0 6px;
            font-size: 13px;
        }
        .table-responsive {
            flex-grow: 1; /* Membuat tabel mengisi sisa ruang vertikal */
            overflow: hidden; /* Sembunyikan overflow */
            display: flex;
            flex-direction: column;
        }
        .buku-induk-table {
            width: 100%;
            height: 100%; /* Mengisi tinggi container */
            border-collapse: collapse;
            font-size: 9px;
            table-layout: fixed; /* Membantu kontrol lebar kolom */
        }
        .buku-induk-table th, .buku-induk-table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }
        .buku-induk-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .buku-induk-table td:first-child {
            text-align: left;
            font-weight: normal;
        }
        .buku-induk-table th:first-child {
            text-align: center;
        }
        .buku-induk-table tbody tr.group-row td {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        /* --- Signature --- */
        .signature-section {
            margin-top: auto; /* Dorong ke bawah kolom */
            padding-top: 15px;
            display: flex;
            justify-content: space-around;
            font-size: 10px;
        }
        .signature-box {
            text-align: center;
            width: 90px;
        }
        .signature-box p {
            margin: 0;
            font-size: 9px;
            line-height: 1.3;
        }
        .signature-line {
            border-top: 1px solid #000;
            height: 20px;
            margin-top: 15px;
        }

        @media print {
            body {
                padding: 5mm;
            }
            .container {
                box-shadow: none;
                height: auto;
                overflow: visible;
                page-break-after: always;
            }
            .main-content-wrapper {
                flex-direction: row; /* Pertahankan dua kolom saat print */
            }
            .buku-induk-table {
                font-size: 8pt;
            }
            .data-label, .data-value {
                font-size: 8pt;
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
            <p>TEKNOLOGI INFORMATIKA</p>
            <p>PENGEMBANGAN PERANGKAT LUNAK DAN GIM</p>
            <p>KONSENTRASI KEAHLIAN: {{ $siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan ? $siswa->rombel->kelas->jurusan->nama : 'REKAYASA PERANGKAT LUNAK' }}</p>
        </div>

        <div class="main-content-wrapper">
            <!-- KOLOM KIRI: TABEL NILAI (DIPANJANGKAN) -->
            <div class="nilai-column">
                <div class="hasil-prestasi-title">HASIL PRESTASI PEMBELAJARAN</div>
                <div class="table-responsive">
                    <table class="buku-induk-table">
                        <thead>
                            <tr>
                                <th rowspan="3" style="width: 35%;">MATA PELAJARAN</th>
                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                    <th colspan="2" class="text-center">{{ $tahunAjaran }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                    <th style="width: 10%;">1</th>
                                    <th style="width: 10%;">2</th>
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
                                    <tr class="group-row">
                                        <td colspan="{{ 1 + (count($nilaiByKelompok['tahunAjaranList']) * 2) }}">
                                            @if($kelompok === 'A')
                                                A. KELOMPOK MATA PELAJARAN UMUM
                                            @elseif($kelompok === 'B')
                                                B. KELOMPOK MATA PELAJARAN KEJURUAN
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
                                    <td>-</td>
                                    @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                        <td>-</td>
                                        <td>-</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>-</td>
                                    @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                        <td>-</td>
                                        <td>-</td>
                                    @endforeach
                                </tr>
                            @endif
                            
                            {{-- TAMBAHKAN BANYAK BARIS KOSONG DI SINI --}}
                            @for ($i = 0; $i < 35; $i++)
                                <tr>
                                    <td>&nbsp;</td>
                                    @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    @endforeach
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- KOLOM KANAN: DATA SISWA (VERTICAL) -->
            <div class="data-column">
                <!-- Photo & Info Table -->
                <div class="photo-info-container">
                    <div class="photo-box">
                        @if(isset($siswa->user) && isset($siswa->user->photo))
                            <img src="{{ asset('storage/' . $siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}" onerror="this.style.display='none'">
                        @else
                            <span style="font-size: 10px; color: #999;">Photo</span>
                        @endif
                    </div>
                    <table class="side-table">
                        <tr>
                            <td class="label">NIS / NISN</td>
                            <td class="sep">:</td>
                            <td class="value">{{ $siswa->nis }} / {{ $siswa->nisn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Nama Lengkap</td>
                            <td class="sep">:</td>
                            <td class="value">{{ $siswa->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="label">Jenis Kelamin</td>
                            <td class="sep">:</td>
                            <td class="value">{{ $siswa->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tempat/Tgl.Lahir</td>
                            <td class="sep">:</td>
                            <td class="value">{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Agama</td>
                            <td class="sep">:</td>
                            <td class="value">{{ $siswa->agama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Alamat</td>
                            <td class="sep">:</td>
                            <td class="value" style="white-space:normal;">{{ $siswa->alamat ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Form Data (VERTICAL) - Tanpa Judul A dan B -->
                <div class="data-section">
                    <div class="data-row">
                        <div class="data-label">NIS / NISN</div>
                        <div class="data-value">{{ $siswa->nis }} / {{ $siswa->nisn ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Nama Lengkap</div>
                        <div class="data-value">{{ $siswa->nama_lengkap }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Jenis Kelamin</div>
                        <div class="data-value">{{ $siswa->jenis_kelamin == 'L' ? 'L' : 'P' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Tempat/Tgl.Lahir</div>
                        <div class="data-value">{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Warganegara</div>
                        <div class="data-value">{{ $siswa->kewarganegaraan ?? 'WNI' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Agama</div>
                        <div class="data-value">{{ $siswa->agama ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Alamat Siswa</div>
                        <div class="data-value">{{ $siswa->alamat ?? '-' }}</div>
                    </div>
                </div>

                <div class="data-section">
                    <div class="data-row">
                        <div class="data-label">Nama Orang Tua</div>
                        <div class="data-value"></div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">a. Ayah</div>
                        <div class="data-value">{{ $siswa->nama_ayah ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">b. Ibu</div>
                        <div class="data-value">{{ $siswa->nama_ibu ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">c. Pekerjaan Ayah</div>
                        <div class="data-value">{{ $siswa->pekerjaan_ayah ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">d. Alamat Rumah</div>
                        <div class="data-value">{{ $siswa->alamat ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Nama Wali</div>
                        <div class="data-value">{{ $siswa->nama_wali ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">a. Pekerjaan</div>
                        <div class="data-value">{{ $siswa->pekerjaan_wali ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">b. Alamat Rumah</div>
                        <div class="data-value">{{ $siswa->alamat_wali ?? '-' }}</div>
                    </div>
                </div>

                <div class="data-section">
                    <div class="data-section-title">Diterima menjadi Siswa</div>
                    <div class="data-row">
                        <div class="data-label">a. Mulai Tanggal</div>
                        <div class="data-value">{{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->format('d F Y') : '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">b. Asal sekolah</div>
                        <div class="data-value">{{ $siswa->sekolah_asal ?? '-' }}</div>
                    </div>
                </div>

                <div class="data-section">
                    <div class="data-section-title">Meninggalkan Sekolah</div>
                    <div class="data-row">
                        <div class="data-label">a. Tanggal</div>
                        <div class="data-value">
                            @if($siswa->mutasiTerakhir)
                                {{ $siswa->mutasiTerakhir->tanggal_mutasi ? \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_mutasi)->format('d F Y') : '-' }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">b. Alasan</div>
                        <div class="data-value">
                            @if($siswa->mutasiTerakhir)
                                {{ $siswa->mutasiTerakhir->alasan_pindah ?? '-' }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>

                <div class="data-section">
                    <div class="data-section-title">Lulus/Tamat</div>
                    <div class="data-row">
                        <div class="data-label">a. Nomor Ijazah</div>
                        <div class="data-value">-</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">b. Tanggal Ijazah</div>
                        <div class="data-value">-</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">c. Nomor Transkip</div>
                        <div class="data-value">-</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">d. Tanggal Transip</div>
                        <div class="data-value">-</div>
                    </div>
                </div>

                <div class="data-section">
                    <div class="data-section-title">Praktek Kerja Industri</div>
                    <div class="data-row">
                        <div class="data-label">a. Nilai</div>
                        <div class="data-value">-</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">b. Nomor Sertifikat</div>
                        <div class="data-value">-</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">c. Nama Industri</div>
                        <div class="data-value">-</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">d. Alamat</div>
                        <div class="data-value">-</div>
                    </div>
                </div>
                
                <!-- Signature -->
                <div class="signature-section">
                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <p>Tanda Tangan</p>
                    </div>
                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <p>Tanda Tangan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>