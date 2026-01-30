<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Raport Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; margin: 10px; }
        .header { text-align: center; margin-bottom: 15px; }
        .title { font-size: 14px; font-weight: bold; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; font-size: 10px; page-break-inside: avoid; }
        table, th, td { border: 1px solid black; padding: 3px; }
        th { background-color: #f2f2f2; text-align: center; }
        .section-title { font-weight: bold; margin-top: 8px; margin-bottom: 3px; font-size: 11px; }
        .signature { margin-top: 20px; text-align: center; page-break-before: always; }
        tbody tr { height: 18px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">RAPOR PESERTA DIDIK</div>
        <div style="font-size: 10px;">SMK NEGERI 1 X</div>
    </div>

    <table style="margin-bottom: 15px;">
        <tr>
            <th width="20%">Nama Peserta Didik</th>
            <td width="30%">{{ strtoupper($siswa->nama_lengkap) }}</td>
            <th width="20%">Kelas</th>
            <td width="30%">{{ $siswa->rombel->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>NISN</th>
            <td>{{ $siswa->nisn }}</td>
            <th>Semester</th>
            <td>{{ $semester }}</td>
        </tr>
        <tr>
            <th>Tahun Pelajaran</th>
            <td>{{ $tahun }}</td>
            <th></th>
            <td></td>
        </tr>
    </table>

    <div class="section-title">A. Kelompok Mata Pelajaran Umum</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="40%">Mata Pelajaran</th>
                <th width="12%">Nilai</th>
                <th width="43%">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilai->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'A') as $n)
                <tr>
                    <td>{{ $n->mapel->urutan }}</td>
                    <td>{{ $n->mapel->nama }}</td>
                    <td style="text-align: center;">{{ $n->nilai_akhir }}</td>
                    <td>{{ $n->deskripsi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">B. Kelompok Mata Pelajaran Kejuruan</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="40%">Mata Pelajaran</th>
                <th width="12%">Nilai</th>
                <th width="43%">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilai->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'B') as $n)
                <tr>
                    <td>{{ $n->mapel->urutan }}</td>
                    <td>{{ $n->mapel->nama }}</td>
                    <td style="text-align: center;">{{ $n->nilai_akhir }}</td>
                    <td>{{ $n->deskripsi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">C. Kegiatan Ekstrakurikuler</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Ekstrakurikuler</th>
                <th width="12%">Predikat</th>
                <th width="48%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ekstra as $i => $e)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $e->nama_ekstra }}</td>
                    <td style="text-align: center;">{{ $e->predikat ?? '-' }}</td>
                    <td>{{ $e->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">D. Ketidakhadiran</div>
    <table style="width: 40%; margin-bottom: 20px;">
        <tr>
            <th width="40%">Sakit</th>
            <td>{{ $kehadiran->sakit ?? 0 }} hari</td>
        </tr>
        <tr>
            <th>Izin</th>
            <td>{{ $kehadiran->izin ?? 0 }} hari</td>
        </tr>
        <tr>
            <th>Tanpa Keterangan</th>
            <td>{{ $kehadiran->tanpa_keterangan ?? 0 }} hari</td>
        </tr>
    </table>

    <div class="signature">
        <div style="display: flex; justify-content: space-between; font-size: 10px;">
            <div style="width: 45%; text-align: center;">
                <p style="margin: 5px 0;">Wali Kelas</p>
                <br><br>
                <b style="font-size: 9px;">{{ $info->wali_kelas ?? '-' }}</b><br>
                <span style="font-size: 9px;">NIP. {{ $info->nip_wali ?? '-' }}</span>
            </div>
            <div style="width: 45%; text-align: center;">
                <p style="margin: 5px 0;">Kepala Sekolah</p>
                <br><br>
                <b style="font-size: 9px;">{{ $info->kepala_sekolah ?? '-' }}</b><br>
                <span style="font-size: 9px;">NIP. {{ $info->nip_kepsek ?? '-' }}</span>
            </div>
        </div>
    </div>
</body>
</html>