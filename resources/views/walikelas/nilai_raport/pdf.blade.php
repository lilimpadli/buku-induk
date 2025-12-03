<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; vertical-align: top; }
        .no-border td, .no-border th { border: none; }
        .title { font-size: 16px; font-weight: bold; text-align: center; margin-bottom: 10px; }
    </style>
</head>

<body>

<div class="title">RAPOR PESERTA DIDIK</div>

<table class="no-border">
    <tr>
        <th width="30%">Nama Peserta Didik</th>
        <td>: {{ $siswa->nama_lengkap }}</td>
    </tr>
    <tr>
        <th>Nomor Induk / NISN</th>
        <td>: {{ $siswa->nis }} / {{ $siswa->nisn }}</td>
    </tr>
    <tr>
        <th>Kelas</th>
        <td>: {{ $siswa->kelas }}</td>
    </tr>
    <tr>
        <th>Semester</th>
        <td>: {{ $nilaiRaports->first()->semester }}</td>
    </tr>
    <tr>
        <th>Tahun Ajaran</th>
        <td>: {{ $nilaiRaports->first()->tahun_ajaran }}</td>
    </tr>
</table>

<h4 style="margin-top: 20px;">A. Nilai Akademik</h4>

<table>
    <thead>
        <tr>
            <th width="30">No</th>
            <th width="200">Mata Pelajaran</th>
            <th width="80">Nilai</th>
            <th>Deskripsi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($nilaiRaports as $i => $nilai)
        <tr>
            <td style="text-align: center">{{ $i + 1 }}</td>
            <td>{{ $nilai->mata_pelajaran }}</td>
            <td style="text-align: center; font-weight: bold">{{ $nilai->nilai_pengetahuan }}</td>
            <td style="text-align: justify">{{ $nilai->deskripsi_pengetahuan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
