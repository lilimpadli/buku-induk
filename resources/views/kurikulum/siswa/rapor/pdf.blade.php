<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapor Peserta Didik</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            background: #ffffff;
            margin: 0;
            padding: 20px;
        }

        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .header-sub {
            text-align: center;
            font-size: 12px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #555;
            padding: 6px 8px;
            vertical-align: top;
        }

        th {
            background: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .no-border td {
            border: none;
            padding: 3px 0;
        }

        .no-border {
            border: none;
        }

        .section-bar {
            margin: 15px 0 5px;
            background: #f2f2f2;
            padding: 6px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #555;
        }

        .ttd-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .page-break {
            page-break-before: always;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .signature {
            margin-top: 40px;
        }

        .signature table {
            border: none;
        }

        .signature td {
            border: none;
            text-align: center;
            padding: 10px 20px;
            vertical-align: bottom;
        }

        .signature .line {
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 35px;
        }

        .signature .nip {
            font-size: 10px;
            color: #555;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .badge-kkm {
            background: #667eea;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
        }

        .predikat-a { color: #059669; font-weight: bold; }
        .predikat-b { color: #2563EB; font-weight: bold; }
        .predikat-c { color: #D97706; font-weight: bold; }
        .predikat-d { color: #DC2626; font-weight: bold; }

        @media print {
            body { padding: 15px; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body>

<!-- ================= HALAMAN 1 : NILAI RAPOR ================= -->

<!-- JUDUL -->
<div class="header-title">RAPOR PESERTA DIDIK</div>
<div class="header-sub">SMK NEGERI 1 KAWALI</div>

<!-- IDENTITAS SISWA -->
<table class="no-border" style="width:100%; margin-bottom:15px;">
    <tr>
        <td style="width:18%; font-weight:bold;">Nama Peserta Didik</td>
        <td style="width:32%;">: <b>{{ strtoupper($siswa->nama_lengkap) }}</b></td>
        <td style="width:18%; font-weight:bold;">Kelas</td>
        <td style="width:32%;">: {{ $rombelRaport->nama ?? $siswa->rombel->nama ?? '-' }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;">NIS / NISN</td>
        <td>: {{ $siswa->nis ?? '-' }} / {{ $siswa->nisn }}</td>
        <td style="font-weight:bold;">Semester</td>
        <td>: {{ $semester }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Sekolah</td>
        <td>: {{ $info->nama_sekolah ?? 'SMK NEGERI 1 KAWALI' }}</td>
        <td style="font-weight:bold;">Tahun Pelajaran</td>
        <td>: {{ $tahun }}</td>
    </tr>
</table>

<!-- MAPEL UMUM -->
<div class="section-bar">A. Kelompok Mata Pelajaran Umum</div>
<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="38%">Mata Pelajaran</th>
            <th width="10%">Nilai</th>
            <th width="47%">Capaian Kompetensi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $groupA = $nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'A');
        @endphp
        @if($groupA->isEmpty())
            <tr>
                <td colspan="4" class="text-center" style="padding:20px;">Tidak ada data</td>
            </tr>
        @else
            @foreach($groupA as $n)
            <tr>
                <td class="text-center">{{ $n->mapel->urutan }}</td>
                <td class="text-left">{{ $n->mapel->nama }}</td>
                <td class="text-center"><b>{{ $n->nilai_akhir }}</b></td>
                <td>{{ $n->deskripsi }}</td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>

<!-- MAPEL KEJURUAN -->
<div class="section-bar">B. Kelompok Mata Pelajaran Kejuruan</div>
<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="38%">Mata Pelajaran</th>
            <th width="10%">Nilai</th>
            <th width="47%">Capaian Kompetensi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $groupB = $nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'B');
        @endphp
        @if($groupB->isEmpty())
            <tr>
                <td colspan="4" class="text-center" style="padding:20px;">Tidak ada data</td>
            </tr>
        @else
            @foreach($groupB as $n)
            <tr>
                <td class="text-center">{{ $n->mapel->urutan }}</td>
                <td class="text-left">{{ $n->mapel->nama }}</td>
                <td class="text-center"><b>{{ $n->nilai_akhir }}</b></td>
                <td>{{ $n->deskripsi }}</td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>

<!-- ================= HALAMAN 2 ================= -->
<div class="page-break"></div>

<!-- JUDUL HALAMAN 2 -->
<div class="header-title" style="font-size:14px;">RAPOR PESERTA DIDIK</div>
<div class="header-sub" style="font-size:11px;">SMK NEGERI 1 KAWALI</div>

<!-- IDENTITAS SISWA (HALAMAN 2) -->
<table class="no-border" style="width:100%; margin-bottom:15px;">
    <tr>
        <td style="width:18%; font-weight:bold;">Nama Peserta Didik</td>
        <td style="width:32%;">: <b>{{ strtoupper($siswa->nama_lengkap) }}</b></td>
        <td style="width:18%; font-weight:bold;">Kelas</td>
        <td style="width:32%;">: {{ $rombelRaport->nama ?? $siswa->rombel->nama ?? '-' }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;">NIS / NISN</td>
        <td>: {{ $siswa->nis ?? '-' }} / {{ $siswa->nisn }}</td>
        <td style="font-weight:bold;">Semester</td>
        <td>: {{ $semester }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Tahun Pelajaran</td>
        <td colspan="3">: {{ $tahun }}</td>
    </tr>
</table>

<!-- EKSTRAKURIKULER -->
<div class="section-bar">C. Kegiatan Ekstrakurikuler</div>
<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="40%">Nama Ekstrakurikuler</th>
            <th width="20%">Predikat</th>
            <th width="35%">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ekstra as $i => $e)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td class="text-left">{{ $e->nama_ekstra }}</td>
            <td class="text-center">{{ $e->predikat ?? '-' }}</td>
            <td>{{ $e->keterangan ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center" style="padding:20px;">Tidak ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- KETIDAKHADIRAN -->
<div class="section-bar">D. Ketidakhadiran</div>
<table style="width:60%; margin:0 auto;">
    <thead>
        <tr>
            <th>Sakit</th>
            <th>Izin</th>
            <th>Tanpa Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center"><b>{{ $kehadiran->sakit ?? 0 }}</b> hari</td>
            <td class="text-center"><b>{{ $kehadiran->izin ?? 0 }}</b> hari</td>
            <td class="text-center"><b>{{ $kehadiran->tanpa_keterangan ?? 0 }}</b> hari</td>
        </tr>
    </tbody>
</table>

<!-- KENAIKAN KELAS -->
@if(strtolower($semester) !== 'ganjil')
<div class="section-bar">E. Kenaikan Kelas</div>
<table style="width:80%; margin:0 auto;">
    <tr>
        <td style="width:30%; font-weight:bold;">Status</td>
        <td style="width:70%;">{{ $kenaikan->status ?? 'Belum Ditentukan' }}</td>
    </tr>
    @if(isset($kenaikan->rombelTujuan))
    <tr>
        <td style="font-weight:bold;">Ke Kelas</td>
        <td>{{ $kenaikan->rombelTujuan->nama }}</td>
    </tr>
    @endif
    <tr>
        <td style="font-weight:bold;">Catatan</td>
        <td>{{ $kenaikan->catatan ?? '-' }}</td>
    </tr>
</table>
@endif

<!-- TANDA TANGAN -->
<div class="signature">
    <table style="width:100%; border:none;">
        <tr>
            <td style="width:33%; border:none; text-align:center; vertical-align:bottom;">
                <div><b>Wali Kelas</b></div>
                <div class="line" style="margin-top:35px;">{{ $info->wali_kelas ?? '___________________' }}</div>
                <div class="nip">NIP. {{ $info->nip_wali ?? '___________________' }}</div>
            </td>
            <td style="width:33%; border:none; text-align:center; vertical-align:bottom;">
                <div><b>Mengetahui,</b></div>
                <div><b>Kepala Sekolah</b></div>
                <div class="line" style="margin-top:35px;">{{ $info->kepala_sekolah ?? '___________________' }}</div>
                <div class="nip">NIP. {{ $info->nip_kepsek ?? '___________________' }}</div>
            </td>
            <td style="width:33%; border:none; text-align:center; vertical-align:bottom;">
                <div><b>Orang Tua / Wali</b></div>
                <div class="line" style="margin-top:35px;">___________________</div>
            </td>
        </tr>
    </table>
</div>

<!-- FOOTER -->
<div class="footer">
    Dicetak pada: {{ date('d-m-Y H:i') }} &nbsp;|&nbsp; {{ $info->tanggal_rapor ?? '' }}
</div>

</body>
</html>