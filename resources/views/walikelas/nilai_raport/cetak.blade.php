<!DOCTYPE html>
<html>
<head>
    <title>Cetak Rapor</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 6px; }
    </style>
</head>
<body>

<h3>RAPOR SISWA</h3>
<p><strong>Nama:</strong> {{ $siswa->nama }}</p>
<p><strong>Kelas:</strong> {{ $siswa->kelas }}</p>
<p><strong>Semester:</strong> {{ $semester }}</p>
<p><strong>Tahun Ajaran:</strong> {{ $tahun }}</p>

<h4>Nilai Pelajaran</h4>
<table>
    <thead>
        <tr>
            <th>Mata Pelajaran</th>
            <th>Nilai</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($nilai as $n)
            <tr>
                <td>{{ $n->mapel->nama }}</td>
                <td>{{ $n->nilai_akhir }}</td>
                <td>{{ $n->deskripsi }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
