<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Raport {{ $siswa->nama_lengkap }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header h3 {
            margin: 5px 0;
            font-size: 14px;
        }
        .info-siswa {
            margin-bottom: 20px;
        }
        .info-siswa table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-siswa th {
            text-align: left;
            width: 150px;
        }
        table.nilai {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.nilai th, table.nilai td {
            border: 1px solid #000;
            padding: 5px;
        }
        table.nilai th {
            background-color: #f2f2f2;
        }
        .ttd {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .ttd div {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>RAPOR PESERTA DIDIK</h1>
        <h3>Semester: {{ $nilaiRaports->first()->semester ?? '-' }} Tahun Ajaran: {{ $nilaiRaports->first()->tahun_ajaran ?? '-' }}</h3>
    </div>
    
    <div class="info-siswa">
        <table>
            <tr>
                <th>NIS</th>
                <td>: {{ $siswa->nis }}</td>
                <th>Nama Lengkap</th>
                <td>: {{ $siswa->nama_lengkap }}</td>
            </tr>
            <tr>
                <th>Kelas</th>
                <td>: {{ $siswa->kelas }}</td>
                <th></th>
                <td></td>
            </tr>
        </table>
    </div>
    
    <table class="nilai">
        <thead>
            <tr>
                <th width="30px">No</th>
                <th>Mata Pelajaran</th>
                <th width="60px">Nilai</th>
                <th>Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($nilaiRaports as $nilai)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $nilai->mata_pelajaran }}</td>
                <td>{{ $nilai->nilai_pengetahuan }}</td>
                <td>{{ $nilai->deskripsi_pengetahuan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="ttd">
        <div>
            <p>Mengetahui,</p>
            <p>Kepala Sekolah</p>
            <br><br><br><br>
            <p>(_________________________)</p>
            <p>NIP. </p>
        </div>
        <div>
            <p>{{ date('d F Y') }}</p>
            <p>Wali Kelas</p>
            <br><br><br><br>
            <p>(_________________________)</p>
            <p>NIP. </p>
        </div>
        <div>
            <p>Orang Tua/Wali</p>
            <br><br><br><br>
            <p>(_________________________)</p>
        </div>
    </div>
</body>
</html>