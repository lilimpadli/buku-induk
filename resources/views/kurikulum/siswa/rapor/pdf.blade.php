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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #555;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .no-border td {
            border: none;
            padding: 2px 0;
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
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>

<!-- ================= HALAMAN 1 : NILAI RAPOR ================= -->

<!-- JUDUL -->
<div style="text-align: center; font-weight: bold; font-size: 14px; margin-bottom: 20px;">
    RAPOR PESERTA DIDIK<br>
    <span style="font-size: 11px;">SMK NEGERI 1 X</span>
</div>

<!-- IDENTITAS SISWA -->
<table class="no-border">
    <tr>
        <td width="20%">Nama Peserta Didik</td>
        <td width="30%">: <b>{{ strtoupper($siswa->nama_lengkap) }}</b></td>
        <td width="20%">Kelas</td>
        <td width="30%">: {{ $rombelRaport->nama ?? '-' }}</td>
    </tr>
    <tr>
        <td>NISN</td>
        <td>: {{ $siswa->nisn }}</td>
        <td>Semester</td>
        <td>: {{ $semester }}</td>
    </tr>
    <tr>
        <td>Sekolah</td>
        <td>: {{ $info->nama_sekolah ?? 'SMK NEGERI 1 X' }}</td>
        <td>Tahun Pelajaran</td>
        <td>: {{ $tahun }}</td>
    </tr>
</table>

<!-- MAPEL UMUM -->
<div class="section-bar">A. Kelompok Mata Pelajaran Umum</div>
<table>
    <tr>
        <th width="5%">No</th>
        <th width="35%">Mata Pelajaran</th>
        <th width="10%">Nilai</th>
        <th width="50%">Capaian Kompetensi</th>
    </tr>
    @foreach($nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'A') as $n)
    <tr>
        <td align="center">{{ $n->mapel->urutan }}</td>
        <td>{{ $n->mapel->nama }}</td>
        <td align="center">{{ $n->nilai_akhir }}</td>
        <td>{{ $n->deskripsi }}</td>
    </tr>
    @endforeach
</table>

<!-- MAPEL KEJURUAN -->
<div class="section-bar">B. Kelompok Mata Pelajaran Kejuruan</div>
<table>
    <tr>
        <th width="5%">No</th>
        <th width="35%">Mata Pelajaran</th>
        <th width="10%">Nilai</th>
        <th width="50%">Capaian Kompetensi</th>
    </tr>
    @foreach($nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'B') as $n)
    <tr>
        <td align="center">{{ $n->mapel->urutan }}</td>
        <td>{{ $n->mapel->nama }}</td>
        <td align="center">{{ $n->nilai_akhir }}</td>
        <td>{{ $n->deskripsi }}</td>
    </tr>
    @endforeach
</table>

<!-- ================= HALAMAN 2 ================= -->
<div class="page-break"></div>

<!-- IDENTITAS SISWA (HALAMAN 2 - FORMAT BAWAH) -->
<table class="no-border" style="margin-bottom:15px;">
    <tr>
        <td width="25%">Nama Peserta Didik</td>
        <td width="75%">: <b>{{ strtoupper($siswa->nama_lengkap) }}</b></td>
    </tr>
    <tr>
        <td>Nomor Induk / NISN</td>
        <td>: {{ $siswa->nis }} / {{ $siswa->nisn }}</td>
    </tr>
    <tr>
        <td>Kelas</td>
        <td>: {{ $rombelRaport->nama ?? $siswa->rombel->nama ?? '-' }}</td>
    </tr>
    <tr>
        <td>Tahun Pelajaran</td>
        <td>: {{ $tahun }}</td>
    </tr>
    <tr>
        <td>Semester</td>
        <td>: {{ $semester }}</td>
    </tr>
</table>


<!-- KOKURIKULER -->
<div class="section-bar">C. Kegiatan Ekstrakurikuler</div>
<table>
    <tr>
        <th width="5%">No</th>
        <th width="40%">Ekstrakurikuler</th>
        <th width="55%">Keterangan</th>
    </tr>
    @foreach($ekstra as $i => $e)
    <tr>
        <td align="center">{{ $i+1 }}</td>
        <td>{{ $e->nama_ekstra }}</td>
        <td>{{ $e->keterangan ?? '-' }}</td>
    </tr>
    @endforeach
</table>

<!-- KETIDAKHADIRAN + CATATAN WALI KELAS -->
<div class="section-bar">D. Ketidakhadiran</div>
<table style="margin-top:5px; width: 50%;">
    <tr>
        <th width="40%">Sakit</th>
        <td>{{ $kehadiran->sakit ?? 0 }} Hari</td>
    </tr>
    <tr>
        <th>Izin</th>
        <td>{{ $kehadiran->izin ?? 0 }} Hari</td>
    </tr>
    <tr>
        <th>Tanpa Keterangan</th>
        <td>{{ $kehadiran->tanpa_keterangan ?? 0 }} Hari</td>
    </tr>
</table>

<!-- CATATAN WALI KELAS -->
<div class="section-bar" style="margin-top:20px;">Catatan Wali Kelas</div>
<table style="margin-top:5px;">
    <tr>
        <td style="height:80px;">{{ $kenaikan->catatan ?? '' }}</td>
    </tr>
</table>

<!-- TANGGAPAN ORANG TUA -->
<div class="section-bar" style="margin-top:20px;">Tanggapan Orang Tua / Wali Murid</div>
<table style="margin-top:5px;">
    <tr>
        <td style="height:80px;"></td>
    </tr>
</table>

<!-- TTD -->
<table class="no-border" style="margin-top:40px;">
    <tr>
        <td width="50%" align="center">
            Orang Tua / Wali
            <div class="ttd-line">...............................</div>
        </td>
        <td width="50%" align="center">
            Ciamis, {{ now()->format('d F Y') }}<br>
            Wali Kelas
            <div class="ttd-line">
                <b>{{ $info->wali_kelas ?? '-' }}</b><br>
                NIP. {{ $info->nip_wali ?? '-' }}
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center" style="padding-top:40px;">
            Kepala Sekolah<br><br><br>
            <b>{{ $info->kepala_sekolah ?? '-' }}</b><br>
            NIP. {{ $info->nip_kepsek ?? '-' }}
        </td>
    </tr>
</table>

</body>
</html>
