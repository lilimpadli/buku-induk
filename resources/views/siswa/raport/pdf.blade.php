<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Raport Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 16px; font-weight: bold; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; padding: 5px; }
        th { background-color: #f2f2f2; text-align: center; }
        .section-title { font-weight: bold; margin-top: 15px; margin-bottom: 5px; }
        .signature { margin-top: 50px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">RAPOR PESERTA DIDIK</div>
        <div>SMK NEGERI 1 X</div>
    </div>

    <table>
        <tr>
            <th width="25%">Nama Peserta Didik</th>
            <td width="25%">{{ strtoupper($siswa->nama_lengkap) }}</td>
            <th width="25%">Kelas</th>
            <td width="25%">{{ $siswa->rombel->nama ?? '-' }}</td>
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
                <th width="15%">Nilai Akhir</th>
                <th width="40%">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'A') as $n)
                <tr>
                    <td>{{ $n->mapel->urutan }}</td>
                    <td>{{ $n->mapel->nama }}</td>
                    <td>{{ $n->nilai_akhir }}</td>
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
                <th width="15%">Nilai Akhir</th>
                <th width="40%">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilaiRaports->filter(fn($n) => $n->mapel && $n->mapel->kelompok == 'B') as $n)
                <tr>
                    <td>{{ $n->mapel->urutan }}</td>
                    <td>{{ $n->mapel->nama }}</td>
                    <td>{{ $n->nilai_akhir }}</td>
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
                <th width="30%">Nama Ekstrakurikuler</th>
                <th width="15%">Predikat</th>
                <th width="50%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ekstra as $i => $e)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $e->nama_ekstra }}</td>
                    <td>{{ $e->predikat ?? '-' }}</td>
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
    <table style="width: 50%">
        <tr>
            <th width="30%">Sakit</th>
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

    <div class="section-title">E. Kenaikan Kelas</div>
    <p><b>Status:</b> {{ $kenaikan->status ?? 'Belum Ditentukan' }}</p>
    @if(isset($kenaikan->rombelTujuan))
        <p><b>Ke Kelas:</b> {{ $kenaikan->rombelTujuan->nama }}</p>
    @endif
    <p><b>Catatan:</b> {{ $kenaikan->catatan ?? '-' }}</p>

    <div class="row">
        <div class="col-md-6 signature">
            <p>Wali Kelas</p>
            <br><br><br>
            <b>{{ $info->wali_kelas ?? '-' }}</b><br>
            NIP. {{ $info->nip_wali ?? '-' }}
        </div>
        <div class="col-md-6 signature">
            <p>Kepala Sekolah</p>
            <br><br><br>
            <b>{{ $info->kepala_sekolah ?? '-' }}</b><br>
            NIP. {{ $info->nip_kepsek ?? '-' }}
        </div>
    </div>
</body>
</html>