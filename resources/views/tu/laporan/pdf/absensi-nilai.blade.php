<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi & Nilai Siswa</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 20mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            background: white;
        }

        .print-wrapper {
            max-width: 210mm;
            margin: 0 auto;
            padding: 0;
        }

        /* KOP SURAT */
        .kop-surat {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .kop-surat .sekolah {
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 0;
        }

        .kop-surat .alamat {
            font-size: 8pt;
            margin: 2px 0;
        }

        .kop-surat .email-web {
            font-size: 7pt;
            margin: 1px 0;
        }

        /* JUDUL */
        .judul {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 8px 0 12px 0;
            text-decoration: underline;
        }

        /* INFO SISWA */
        .info-siswa {
            margin-bottom: 15px;
            padding: 8px 10px;
            border: 1px solid #000;
            background: #f9f9f9;
        }

        .info-siswa table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-siswa td {
            padding: 3px 5px;
            vertical-align: top;
            font-size: 9pt;
        }

        .info-siswa .label {
            width: 120px;
            font-weight: bold;
        }

        /* TABEL NILAI */
        .tabel-nilai {
            margin-top: 15px;
            margin-bottom: 20px;
        }

        .tabel-nilai .caption {
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 5px;
            text-align: center;
        }

        /* TABEL ABSENSI */
        .tabel-absensi {
            margin-top: 15px;
            margin-bottom: 20px;
        }

        .tabel-absensi .caption {
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 5px;
            text-align: center;
        }

        /* STYLE TABEL UMUM */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #e0e0e0;
            border: 1px solid #000;
            padding: 4px 5px;
            text-align: center;
            font-weight: bold;
            font-size: 9pt;
        }

        table td {
            border: 1px solid #000;
            padding: 3px 5px;
            text-align: center;
            font-size: 9pt;
        }

        .text-left {
            text-align: left;
            padding-left: 10px;
        }

        /* TANDA TANGAN */
        .signatures {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            padding: 0 10px;
        }

        .signature-box {
            text-align: center;
            width: 45%;
        }

        .signature-box .label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            font-size: 9pt;
        }

        .signature-box .jabatan {
            font-size: 9pt;
        }

        .signature-box .nama {
            margin-top: 40px;
            font-weight: bold;
            text-decoration: underline;
            font-size: 10pt;
        }

        .signature-box .nip {
            font-size: 8pt;
            margin-top: 2px;
        }

        .signature-box .tempat-tanggal {
            font-size: 8pt;
            margin-bottom: 5px;
        }

        /* FOOTER */
        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 7pt;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

        /* CONTROLS */
        .controls {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .controls .btn {
            border-radius: 8px;
            font-weight: 700;
            padding: 8px 16px;
            font-size: 10pt;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid #d1d5db;
            background: white;
            color: #111827;
        }

        .controls .btn-primary {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .controls .btn-primary:hover {
            background: #1d4ed8;
        }

        .controls .btn-secondary:hover {
            background: #f3f4f6;
        }

        @media print {
            body { background: white; }
            .controls { display: none !important; }
            .print-wrapper { max-width: 100%; margin: 0; padding: 0; }
            .kop-surat .sekolah { font-size: 14pt; }
            .judul { font-size: 12pt; }
            .info-siswa td { font-size: 8pt; }
            table th, table td { font-size: 8pt; }
            .signature-box .nama { margin-top: 30px; }
        }
    </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4 py-3 print-wrapper">
    <!-- CONTROLS -->
    <div class="controls">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button type="button" class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Print
        </button>
    </div>

    <div class="print-sheet">
        <!-- KOP SURAT -->
        <div class="kop-surat">
            <div class="sekolah">SMK NEGERI 1 KAWALI</div>
            <div class="alamat">Jalan Tangerang No. 50 Telp. (0361) 711727 Kawali 46333</div>
            <div class="email-web">Email: smknegeri@yahoo.com - Website: http://www.smknegeri.tk</div>
        </div>

        <!-- JUDUL -->
        <div class="judul">LAPORAN ABSENSI &amp; NILAI SISWA</div>

        <!-- INFO SISWA -->
        <div class="info-siswa">
            <table>
                <tr>
                    <td class="label">NIS / NISN</td>
                    <td>: {{ $siswa->nis ?? '-' }}</td>
                    <td class="label" style="width:100px;">Kelas</td>
                    <td>: {{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Nama Siswa</td>
                    <td>: {{ $siswa->nama_siswa ?? '-' }}</td>
                    <td class="label">Jurusan</td>
                    <td>: {{ $siswa->jurusan->nama_jurusan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tempat, Tgl Lahir</td>
                    <td>: {{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? date('d-m-Y', strtotime($siswa->tanggal_lahir)) : '-' }}</td>
                    <td class="label">Tahun Ajaran</td>
                    <td>: {{ $siswa->tahun_ajaran ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td>: {{ $siswa->jenis_kelamin ?? '-' }}</td>
                    <td class="label">Semester</td>
                    <td>: {{ $siswa->semester ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- TABEL NILAI PER SEMESTER -->
        @foreach($nilaiPerSemester as $semester => $nilai)
        <div class="tabel-nilai">
            <div class="caption">NILAI RAPORT SEMESTER {{ $semester }}</div>
            <table>
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:30%;">Mata Pelajaran</th>
                        <th style="width:12%;">KKM</th>
                        <th style="width:15%;">Nilai</th>
                        <th style="width:18%;">Predikat</th>
                        <th style="width:20%;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilai as $index => $n)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $n->mata_pelajaran ?? '-' }}</td>
                        <td>{{ $n->kkm ?? '-' }}</td>
                        <td>{{ $n->nilai ?? '-' }}</td>
                        <td>{{ $n->predikat ?? '-' }}</td>
                        <td>{{ $n->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:10px;">Belum ada data nilai untuk semester ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endforeach

        <!-- TABEL ABSENSI -->
        <div class="tabel-absensi">
            <div class="caption">REKAPITULASI ABSENSI SISWA</div>
            <table>
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:18%;">Tanggal</th>
                        <th style="width:15%;">Jam</th>
                        <th style="width:20%;">Keterangan</th>
                        <th style="width:22%;">Status</th>
                        <th style="width:20%;">Keterangan Lain</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa->absensi->sortBy('tanggal') as $index => $absen)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $absen->tanggal ? date('d-m-Y', strtotime($absen->tanggal)) : '-' }}</td>
                        <td>{{ $absen->jam ?? '-' }}</td>
                        <td>{{ $absen->keterangan ?? '-' }}</td>
                        <td>{{ $absen->status ?? '-' }}</td>
                        <td>{{ $absen->keterangan_lain ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:10px;">Belum ada data absensi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- TANDA TANGAN -->
        <div class="signatures">
            <div class="signature-box">
                <span class="label">Mengetahui,</span>
                <div class="jabatan">Kepala SMK Negeri 1 Kawali,</div>
                <div class="tempat-tanggal">Kawali, {{ date('d F Y') }}</div>
                <div class="nama">{{ $kepalaSekolah->nama ?? 'DEDE FAIRIADI, S.Pd., M.Pd.' }}</div>
                <div class="nip">NIP. {{ $kepalaSekolah->nip ?? '19640222 20090 1 1 005' }}</div>
            </div>
            <div class="signature-box">
                <span class="label">&nbsp;</span>
                <div class="jabatan">Guru Mata Pelajaran,</div>
                <div class="tempat-tanggal">&nbsp;</div>
                <div class="nama">{{ optional($guruMapel)->nama ?? '____________________' }}</div>
                <div class="nip">NIP. {{ optional($guruMapel)->nip ?? '____________________' }}</div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            Dicetak pada: {{ date('d-m-Y H:i:s') }}
        </div>
    </div>
</div>

</body>
</html>