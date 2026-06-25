<!DOCTYPE html>
<html>
<head>
    <title>Buku Induk - {{ $siswa->nama_lengkap }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12px; line-height: 1.5; color: #000; }
        .page-break { page-break-after: always; }
        .text-center { text-align: center; }
        .header { margin-bottom: 25px; border-bottom: 3px double #000; padding-bottom: 5px; }
        .title-doc { font-size: 16px; font-weight: bold; margin: 0; }
        .subtitle-doc { font-size: 14px; font-weight: bold; margin: 5px 0 0 0; }
        
        /* Biodata Table */
        .table-biodata { width: 100%; margin-bottom: 20px; }
        .table-biodata td { padding: 4px; vertical-align: top; }
        .section-title { font-weight: bold; font-size: 13px; padding-top: 10px; padding-bottom: 5px; }
        
        /* Table Nilai */
        .table-border { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table-border th, .table-border td { border: 1px solid #000; padding: 6px; font-size: 11px; }
        .table-border th { background-color: #f2f2f2; font-weight: bold; }

        /* ========================================== */
        /* TAMBAHAN STYLE UNTUK AREA FOOTER RESMI    */
        /* ========================================== */
        .footer-section {
            width: 100%;
            margin-top: 40px;
        }
        .table-footer {
            width: 100%;
            border: none !important;
        }
        .table-footer td {
            border: none !important;
            padding: 5px;
            vertical-align: top;
        }
        .box-foto {
            width: 3cm;
            height: 4cm;
            border: 1px solid #000 !important;
            text-align: center;
            line-height: 4cm;
            font-size: 11px;
            margin: 10px auto 0 auto;
        }
        .box-ttd-siswa {
            width: 5.5cm;
            height: 1.8cm;
            border: 1px solid #000 !important;
            margin-top: 8px;
        }
        .text-space {
            margin-top: 55px;
            display: block;
        }
    </style>
</head>
<body>

    <div class="header text-center">
        <h2 class="title-doc">LEMBAR BUKU INDUK PESERTA DIDIK</h2>
        <h3 class="subtitle-doc">SMKN 1 KAWALI</h3>
    </div>

    <table class="table-biodata">
        <tr>
            <td colspan="3" class="section-title">A. IDENTITAS PESERTA DIDIK</td>
        </tr>
        <tr>
            <td style="width: 35%;">1. Nama Lengkap</td>
            <td style="width: 2%;">:</td>
            <td style="width: 63%; font-weight: bold;">{{ $siswa->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>2. Nomor Induk Siswa (NIS)</td>
            <td>:</td>
            <td>{{ $siswa->nis }}</td>
        </tr>
        <tr>
            <td>3. NISN</td>
            <td>:</td>
            <td>{{ $siswa->nisn ?? '-' }}</td>
        </tr>
        <tr>
            <td>4. Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $siswa->jenis_kelamin }}</td>
        </tr>
        <tr>
            <td>5. Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}</td>
        </tr>
        <tr>
            <td>6. Agama</td>
            <td>:</td>
            <td>{{ $siswa->agama }}</td>
        </tr>
        <tr>
            <td>7. Alamat Tempat Tinggal</td>
            <td>:</td>
            <td>RT {{ $siswa->rt }} / RW {{ $siswa->rw }}, Dusun {{ $siswa->dusun }}, Kel. {{ $siswa->kelurahan }}, Kec. {{ $siswa->kecamatan }}</td>
        </tr>

        <tr>
            <td colspan="3" class="section-title" style="padding-top: 20px;">B. KETERANGAN ORANG TUA / WALI</td>
        </tr>
        <tr>
            <td>1. Nama Ayah Kandung</td>
            <td>:</td>
            <td>{{ $siswa->ayah->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>2. Pekerjaan Ayah</td>
            <td>:</td>
            <td>{{ $siswa->ayah->pekerjaan ?? '-' }}</td>
        </tr>
        <tr>
            <td>3. Nama Ibu Kandung</td>
            <td>:</td>
            <td>{{ $siswa->ibu->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>4. Pekerjaan Ibu</td>
            <td>:</td>
            <td>{{ $siswa->ibu->pekerjaan ?? '-' }}</td>
        </tr>
    </table>

    <div class="page-break"></div>


    <div class="text-center">
        <h3 class="title-doc" style="font-size: 14px;">LAMPIRAN PRESTASI BELAJAR (TRANSKRIP BUKU INDUK)</h3>
        <p style="margin-top: 5px;">Nama Siswa: <strong>{{ $siswa->nama_lengkap }}</strong> | NIS: <strong>{{ $siswa->nis }}</strong></p>
    </div>

    @php 
        $totalTahun = isset($nilaiByKelompok['tahunAjaranList']) ? count($nilaiByKelompok['tahunAjaranList']) : 0;
        $totalColspan = 1 + ($totalTahun * 2);
    @endphp

    <table class="table-border">
        <thead>
            <tr>
                <th rowspan="2" style="vertical-align: middle; text-align: left;">MATA PELAJARAN</th>
                @if($totalTahun > 0)
                    @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                        <th colspan="2" class="text-center">{{ $tahunAjaran }}</th>
                    @endforeach
                @endif
            </tr>
            <tr>
                @if($totalTahun > 0)
                    @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                        <th class="text-center" style="width: 65px;">Semester 1</th>
                        <th class="text-center" style="width: 65px;">Semester 2</th>
                    @endforeach
                @endif
            </tr>
        </thead>
        <tbody>
            @if(isset($nilaiByKelompok['byKelompok']) && count($nilaiByKelompok['byKelompok']) > 0)
                @foreach($nilaiByKelompok['byKelompok'] as $kelompok => $mapelGroup)
                    <tr style="background-color: #f9f9f9; font-weight: bold;">
                        <td colspan="{{ $totalColspan }}" style="text-align: left;">
                            @if($kelompok === 'A') A. KELOMPOK MATA PELAJARAN UMUM
                            @elseif($kelompok === 'B') B. KELOMPOK MATA PELAJARAN KEAHLIAN
                            @else KELOMPOK {{ strtoupper($kelompok) }} @endif
                        </td>
                    </tr>
                    @foreach($mapelGroup as $mapelNama => $mapelData)
                        <tr>
                            <td style="text-align: left;">{{ $mapelData['nama'] }}</td>
                            @foreach($nilaiByKelompok['tahunAjaranList'] as $tahunAjaran)
                                <td class="text-center">{{ $mapelData['nilai'][$tahunAjaran][1] ?? '-' }}</td>
                                <td class="text-center">{{ $mapelData['nilai'][$tahunAjaran][2] ?? '-' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="{{ $totalColspan }}">Data nilai belum terekam.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer-section">
        <table class="table-footer">
            <tr>
                <td style="width: 40%; text-align: left;">
                    <p>Mengetahui/Menyetujui,<br>Orang Tua / Wali Siswa</p>
                    <span class="text-space"></span>
                    <p>__________________________</p>
                    
                    <p style="margin-top: 20px; margin-bottom: 5px;">Cap Jempol & Tanda Tangan Siswa :</p>
                    <div class="box-ttd-siswa"></div>
                </td>

                <td style="width: 25%; text-align: center;">
                    <div class="box-foto">
                        Pas Foto 3 x 4
                    </div>
                </td>

                <td style="width: 35%; text-align: right;">
                    <p>Ciamis, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Kepala Sekolah,</p>
                    <span class="text-space"></span>
                    <p style="font-weight: bold; margin-bottom: 0; text-decoration: underline;">Drs. H. Maman, M.Pd.</p>
                    <p style="margin-top: 0;">NIP. 19740325 200003 1 002</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>