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
            padding: 0;
            color: #000;
            line-height: 1.1;
        }
        .container {
            max-width: 210mm;
            margin: 0 auto;
            background-color: white;
            padding: 8mm;
            min-height: 297mm;
            overflow: hidden;
        }
        .buku-induk-header {
            text-align: center;
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 2px solid #000;
        }
        .buku-induk-header h1 {
            font-size: 14px;
            margin-bottom: 2px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .buku-induk-header h2 {
            font-size: 9px;
            margin-bottom: 2px;
            font-weight: normal;
        }

        .main-content-wrapper {
            display: flex;
            gap: 8px;
            flex-grow: 1;
            overflow: hidden;
        }

        .nilai-column {
            flex: 2.2;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .data-column {
            flex: 1.8;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .data-section {
            margin-bottom: 6px;
        }
        .data-section-title {
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 8px;
            text-decoration: underline;
        }
        .data-row {
            display: flex;
            margin-bottom: 2px;
            align-items: flex-end;
        }
        .data-label {
            width: 85px;
            font-weight: normal;
            padding-right: 4px;
            flex-shrink: 0;
            font-size: 8px;
        }
        .data-value {
            flex: 1;
            border-bottom: 0.6px dotted #000;
            min-height: 12px;
            font-size: 8px;
            padding-bottom: 1px;
        }

        .photo-box {
            width: 90px;
            height: 120px;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 6px;
            overflow: hidden;
            background: #f9f9f9;
        }
        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .photo-box .no-photo {
            font-size: 8px;
            color: #999;
        }

        .hasil-prestasi-title {
            text-align: center;
            font-weight: 700;
            margin: 0 0 6px;
            font-size: 10px;
        }

        .table-responsive {
            flex-grow: 1;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .buku-induk-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 6px;
            table-layout: fixed;
            height: 100%;
        }
        .buku-induk-table th, .buku-induk-table td {
            border: 1px solid #000;
            padding: 2px 3px;
            text-align: center;
            vertical-align: middle;
        }
        .buku-induk-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 6px;
            padding: 2px 1px;
        }
        .buku-induk-table tbody td:first-child {
            text-align: left;
            font-weight: normal;
            font-size: 6px;
            padding: 2px 4px;
            line-height: 1.1;
        }
        .buku-induk-table tbody td:not(:first-child) {
            font-size: 5.5px;
        }
        .buku-induk-table th:first-child {
            text-align: center;
        }
        .buku-induk-table tbody tr.group-row td {
            background-color: #e8e8e8;
            font-weight: bold;
            text-align: left;
            font-size: 6px;
        }

        .signature-section {
            margin-top: 8px;
            padding-top: 4px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 6px;
        }
        .signature-box {
            text-align: center;
            width: 110px;
        }
        .signature-box p {
            margin: 0;
            font-size: 8px;
            line-height: 1.2;
        }
        .signature-line {
            border-top: 1px solid #000;
            height: 30px;
            margin-top: 6px;
        }
        .stamp-box {
            width: 45px;
            height: 45px;
            border: 1px solid #000;
        }
        .signature-info {
            margin-top: 6px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .signature-box-small {
            width: 110px;
            height: 35px;
            border: 1px solid #000;
            margin-bottom: 4px;
        }

        @media print {
            @page { 
                size: A4 portrait; 
                margin: 5mm;
                -webkit-print-color-adjust: exact;
            }
            body { padding: 0; margin: 0; }
            .container {
                box-shadow: none;
                width: 210mm;
                min-height: 297mm;
                overflow: hidden;
                page-break-after: always;
                padding: 5mm;
                margin: 0;
            }
            .main-content-wrapper {
                flex-direction: row;
                height: calc(100% - 40px);
            }
            .buku-induk-table { font-size: 6pt; }
            .data-label, .data-value { font-size: 7pt; }
            .table-responsive { height: 100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="buku-induk-header">
            <h1>BUKU INDUK SISWA</h1>
            <h2>SMKN 1 KAWALI</h2>
            <h2>KONSENTRASI: {{ $siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan ? $siswa->rombel->kelas->jurusan->nama : 'REKAYASA PERANGKAT LUNAK' }}</h2>
        </div>

        <div class="main-content-wrapper">
            <div class="nilai-column">
                <div class="hasil-prestasi-title">HASIL PRESTASI PEMBELAJARAN</div>
                <div class="table-responsive">
                    <table class="buku-induk-table">
                        <thead>
                            <tr>
                                <th rowspan="3" style="width: 35%;">MATA PELAJARAN</th>
                                @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                    <th colspan="2">{{ $tahunAjaran }}</th>
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
                                    <td colspan="{{ 1 + (count($nilaiByKelompok['tahunAjaranList']) * 2) }}">Belum ada data nilai</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="data-column">
                <div class="photo-box">
                    @if(isset($siswa->user) && $siswa->user->photo)
                        <img src="{{ asset('storage/' . $siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}" onerror="this.style.display='none'">
                    @else
                        <span class="no-photo">No Photo</span>
                    @endif
                </div>

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
                        <div class="data-value">{{ substr($siswa->jenis_kelamin, 0, 1) }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Tempat/Tgl.Lahir</div>
                        <div class="data-value">{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</div>
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
                    <div class="data-section-title">Nama Orang Tua</div>
                    <div class="data-row">
                        <div class="data-label">a. Ayah</div>
                        <div class="data-value">{{ $siswa->ayah->nama ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">b. Ibu</div>
                        <div class="data-value">{{ $siswa->ibu->nama ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">c. Pekerjaan Ayah</div>
                        <div class="data-value">{{ $siswa->ayah->pekerjaan ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">d. Alamat</div>
                        <div class="data-value">{{ $siswa->ayah->alamat ?? $siswa->ibu->alamat ?? '-' }}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Nama Wali</div>
                        <div class="data-value">{{ $siswa->wali->nama ?? '-' }}</div>
                    </div>
                </div>

                <div class="data-section">
                    <div class="data-section-title">Diterima menjadi Siswa</div>
                    <div class="data-row">
                        <div class="data-label">a. Tanggal</div>
                        <div class="data-value">{{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->translatedFormat('d F Y') : '-' }}</div>
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
                        <div class="data-value">-</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">b. Alasan</div>
                        <div class="data-value">-</div>
                    </div>
                </div>

                <div class="signature-section">
                    <div class="signature-info">
                        <div class="signature-box-small"></div>
                        <p>Mengetahui</p>
                        <p>Kepala Sekolah</p>
                    </div>
                    <div class="stamp-box"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>