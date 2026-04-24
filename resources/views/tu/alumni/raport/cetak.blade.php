<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Alumni - {{ $siswa->nama_lengkap }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background-color: #fff;
            line-height: 1.4;
        }

        .container {
            max-width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 15mm;
            background-color: white;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #000;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .header h2 {
            font-size: 14px;
            margin-bottom: 3px;
            font-weight: normal;
        }

        .header p {
            font-size: 12px;
            margin: 3px 0;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        table tbody tr:nth-child(odd) {
            background-color: #fafafa;
        }

        .text-center {
            text-align: center;
        }

        .table-half {
            width: 50%;
            margin-bottom: 20px;
        }

        .info-section {
            margin-bottom: 15px;
        }

        .info-item {
            margin-bottom: 5px;
            font-size: 11px;
        }

        .info-item strong {
            font-weight: bold;
        }

        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
        }

        .signature-box {
            text-align: center;
            width: 150px;
        }

        .signature-line {
            border-top: 1px solid #000;
            height: 60px;
            margin-top: 10px;
        }

        .signature-name {
            margin-top: 10px;
            font-size: 10px;
            font-weight: bold;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm;
            }

            body {
                margin: 0;
                padding: 0;
            }

            .container {
                box-shadow: none;
                max-width: 100%;
                min-height: 100%;
                padding: 15mm;
                margin: 0;
            }

            table {
                page-break-inside: avoid;
            }

            .section-title {
                page-break-after: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>LAPORAN HASIL BELAJAR (RAPOR)</h1>
            <h2>SMK NEGERI 1 KAWALI</h2>
            <p style="font-size: 10px;">TAHUN PELAJARAN {{ $tahun }}</p>
        </div>

        <!-- Identitas Siswa -->
        <div class="section-title">IDENTITAS PESERTA DIDIK</div>
        <table>
            <tr>
                <td style="width: 35%; font-weight: bold;">Nama Peserta Didik</td>
                <td>{{ strtoupper($siswa->nama_lengkap) }}</td>
                <td style="width: 20%; font-weight: bold;">Kelas</td>
                <td style="width: 30%;">{{ $nilaiRaports->first()?->rombel?->nama ?? ($kelasHistory ? 'Kelas ' . $kelasHistory->tingkat . ' ' . $kelasHistory->jurusan->nama : '-') }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">NISN</td>
                <td>{{ $siswa->nisn ?? '-' }}</td>
                <td style="font-weight: bold;">Semester</td>
                <td>{{ $semester }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Sekolah</td>
                <td colspan="3">SMK NEGERI 1 KAWALI</td>
            </tr>
        </table>

        <!-- A. Kelompok Mata Pelajaran Umum -->
        <div class="section-title">A. KELOMPOK MATA PELAJARAN UMUM</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 50%">Mata Pelajaran</th>
                    <th style="width: 15%" class="text-center">Nilai Akhir</th>
                    <th style="width: 30%">Capaian Kompetensi</th>
                </tr>
            </thead>
            <tbody>
                @php $groupA = $nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'A'); @endphp
                @if($groupA->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                @else
                    @foreach($groupA as $n)
                        <tr>
                            <td class="text-center">{{ $n->mapel->urutan ?? '-' }}</td>
                            <td>{{ $n->mapel->nama ?? '-' }}</td>
                            <td class="text-center">{{ $n->nilai_akhir ?? '-' }}</td>
                            <td>{{ $n->deskripsi ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- B. Kelompok Mata Pelajaran Kejuruan -->
        <div class="section-title">B. KELOMPOK MATA PELAJARAN KEJURUAN</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 50%">Mata Pelajaran</th>
                    <th style="width: 15%" class="text-center">Nilai Akhir</th>
                    <th style="width: 30%">Capaian Kompetensi</th>
                </tr>
            </thead>
            <tbody>
                @php $groupB = $nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'B'); @endphp
                @if($groupB->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                @else
                    @foreach($groupB as $n)
                        <tr>
                            <td class="text-center">{{ $n->mapel->urutan ?? '-' }}</td>
                            <td>{{ $n->mapel->nama ?? '-' }}</td>
                            <td class="text-center">{{ $n->nilai_akhir ?? '-' }}</td>
                            <td>{{ $n->deskripsi ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- C. Kegiatan Ekstrakurikuler -->
        <div class="section-title">C. KEGIATAN EKSTRAKURIKULER</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 50%">Nama Ekstrakurikuler</th>
                    <th style="width: 20%" class="text-center">Predikat</th>
                    <th style="width: 25%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ekstra as $i => $e)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $e->nama_ekstra ?? '-' }}</td>
                        <td class="text-center">{{ $e->predikat ?? '-' }}</td>
                        <td>{{ $e->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- D. Ketidakhadiran -->
        <div class="section-title">D. KETIDAKHADIRAN</div>
        <table class="table-half">
            <tr>
                <td style="font-weight: bold; width: 50%">Sakit</td>
                <td class="text-center">{{ $kehadiran->sakit ?? 0 }} hari</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Izin</td>
                <td class="text-center">{{ $kehadiran->izin ?? 0 }} hari</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Tanpa Keterangan</td>
                <td class="text-center">{{ $kehadiran->tanpa_keterangan ?? 0 }} hari</td>
            </tr>
        </table>

        <!-- E. Kenaikan Kelas (hanya untuk semester genap) -->
        @if(strtolower($semester) !== 'ganjil')
            <div class="section-title">E. KENAIKAN KELAS</div>
            <div class="info-section">
                <div class="info-item">
                    <strong>Status:</strong> {{ $kenaikan->status ?? 'Belum Ditentukan' }}
                </div>
                @if(isset($kenaikan->rombelTujuan))
                    <div class="info-item">
                        <strong>Ke Kelas:</strong> {{ $kenaikan->rombelTujuan->nama ?? '-' }}
                    </div>
                @endif
                <div class="info-item">
                    <strong>Catatan:</strong> {{ $kenaikan->catatan ?? '-' }}
                </div>
            </div>
        @endif

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <p style="font-size: 10px; margin-bottom: 5px;">Orang Tua/Wali</p>
                <div class="signature-line"></div>
                <div class="signature-name">(_________________)</div>
            </div>

            <div class="signature-box">
                <p style="font-size: 10px; margin-bottom: 5px;">Wali Kelas</p>
                <div class="signature-line"></div>
                <div class="signature-name">(_________________)</div>
            </div>

            <div class="signature-box">
                <p style="font-size: 10px; margin-bottom: 5px;">Kepala Sekolah</p>
                <div class="signature-line"></div>
                <div class="signature-name">(_________________)</div>
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
