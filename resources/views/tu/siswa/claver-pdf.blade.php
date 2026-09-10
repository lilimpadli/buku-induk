<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>BUKU INDUK SISWA (CLAVER)</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            padding: 20px;
            color: #000;
        }
        .page-title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .sub-title {
            text-align: center;
            font-size: 12pt;
            margin-bottom: 25px;
            font-weight: bold;
        }
        .claver-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .claver-table th, .claver-table td {
            border: 1.5px solid #000;
            padding: 8px 6px;
            text-align: left;
            vertical-align: middle;
            font-size: 10pt;
        }
        .claver-table th {
            background-color: #E8EAF6;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }
        .claver-table .text-center { text-align: center; }
        .claver-table .text-bold { font-weight: bold; }
        
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            margin: 20px 0 10px 0;
            padding: 8px 15px;
            background-color: #E8EAF6;
            border: 1.5px solid #000;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .page-break { page-break-after: always; }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 8pt;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        
        /* Lebar Kolom */
        .col-no { width: 5%; text-align: center; }
        .col-nama { width: 25%; }
        .col-nis { width: 15%; text-align: center; }
        .col-tanggal { width: 13.75%; text-align: center; }
        .col-naik { width: 13.75%; text-align: center; }
        .col-ket { width: 8%; text-align: center; }

        /* Warna Sel Tanggal (Match dengan Preview) */
        .cell-masuk { background-color: #FEF9C3; font-weight: 600; }
        .cell-naik-1 { background-color: #DCFCE7; font-weight: 600; }
        .cell-naik-2 { background-color: #DBEAFE; font-weight: 600; }
        .cell-naik-3 { background-color: #F3E8FF; font-weight: 600; }
    </style>
</head>
<body>

<div class="page-title">BUKU INDUK SISWA (CLAVER)</div>
<div class="sub-title">TAHUN PELAJARAN {{ $tahunAjaran }}</div>

@foreach($data as $huruf => $siswas)
    @if($loop->iteration > 1)
        <div class="page-break"></div>
        <div class="page-title">BUKU INDUK SISWA (CLAVER)</div>
        <div class="sub-title">TAHUN PELAJARAN {{ $tahunAjaran }}</div>
    @endif
    
    <div class="section-title">HURUF {{ $huruf }}</div>
    
    <table class="claver-table">
        <thead>
            <tr>
                <th rowspan="2" class="col-no">NO</th>
                <th rowspan="2" class="col-nama">NAMA SISWA</th>
                <th rowspan="2" class="col-nis">NOMOR INDUK SISWA</th>
                <th colspan="4" class="text-center text-bold">TANGGAL</th>
                <th rowspan="2" class="col-ket">KET</th>
            </tr>
            <tr>
                <th class="col-tanggal">MULAI MASUK</th>
                <th class="col-naik">NAIK KELAS 1</th>
                <th class="col-naik">NAIK KELAS 2</th>
                <th class="col-naik">NAIK KELAS 3</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $siswa)
                <tr>
                    <td class="col-no">{{ $siswa['no'] }}</td>
                    <td class="col-nama">{{ $siswa['nama_siswa'] }}</td>
                    <td class="col-nis">{{ $siswa['nomor_induk'] }}</td>
                    <td class="col-tanggal cell-masuk">{{ $siswa['tanggal_masuk'] }}</td>
                    <td class="col-naik cell-naik-1">{{ $siswa['naik_kelas_1'] ?? '' }}</td>
                    <td class="col-naik cell-naik-2">{{ $siswa['naik_kelas_2'] ?? '' }}</td>
                    <td class="col-naik cell-naik-3">{{ $siswa['naik_kelas_3'] ?? '' }}</td>
                    <td class="col-ket">{{ $siswa['keterangan'] ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach

<div class="footer">
    Dicetak pada: {{ now()->format('d F Y H:i:s') }} | {{ config('app.name') }}
</div>

</body>
</html>