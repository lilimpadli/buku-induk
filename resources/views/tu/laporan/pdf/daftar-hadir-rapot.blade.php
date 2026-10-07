<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: F4 landscape;
            margin: 20px 20px 15px 20px;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* ============================================
           KOP SURAT - MENGGUNAKAN TABEL + LOGO
           ============================================ */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            border: 1px solid #000;
        }

        .kop-table td {
            border: 1px solid #000;
            padding: 4px 8px;
            vertical-align: middle;
        }

        .logo-cell {
            width: 115px;
            text-align: center;
            vertical-align: middle;
        }

        .logo-cell img {
            width: 72px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .school-cell {
            text-align: center;
            vertical-align: middle;
        }

        .school-name {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 0;
        }

        .school-address {
            font-size: 10px;
            margin: 2px 0;
        }

        .school-contact {
            font-size: 9px;
            margin: 2px 0;
        }

        .judul-cell {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            padding: 6px 8px;
            border-top: none !important;
        }

        /* ============================================
           INFO KELAS
           ============================================ */
        .info-kelas {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            margin-bottom: 10px;
            line-height: 1.8;
            font-weight: bold;
        }

        .info-kelas .left, 
        .info-kelas .right {
            display: flex;
            flex-direction: column;
        }

        .info-kelas .label {
            font-weight: bold;
        }

        /* ============================================
           TABEL
           ============================================ */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table th,
        table td {
            border: 1px solid #444;
            padding: 6px 8px;
            vertical-align: middle;
        }

        table th {
            background: #f2f2f2;
            font-size: 11px;
            text-align: center;
        }

        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .small { font-size: 10px; }
        .mt-2 { margin-top: 0.75rem; }
        .signature-cell { height: 42px; }

        /* ============================================
           PRINT STYLE
           ============================================ */
        @media print {
            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            table th {
                background: #f2f2f2 !important;
            }
        }
    </style>
</head>
<body>
    <!-- ============================================
         KOP SURAT
         ============================================ -->
    <table class="kop-table">
        <tr>
           <td class="logo-cell" rowspan="2">
                @php
                    $logoPath = public_path('images/smkn1-kawali-logo.png');
                    $logoSrc = file_exists($logoPath)
                        ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
                        : '';
                @endphp
                @if($logoSrc)
                    <img src="{{ $logoSrc }}" alt="Logo SMKN 1 Kawali">
                @endif
            </td>
            <td class="school-cell">
                <div class="school-name">SMK NEGERI 1 KAWALI</div>
                <div class="school-address">Jalan Talagasari No. 35 Telp. (0265) 791727 Kawali 46253 Kab. Ciamis</div>
                <div class="school-contact">Email : smkn1kawali@gmail.com - Website : http://www.smkn1kawali.sch.id</div>
            </td>
        </tr>
        <tr>
            <td class="judul-cell">DAFTAR HADIR PENGAMBILAN RAPOT</td>
        </tr>
    </table>

    <!-- ============================================
         INFO KELAS
         ============================================ -->
    <div class="info-kelas">
        <div class="left">
            <div>
                <span class="label">Konsentrasi Keahlian :</span> 
                {{ $rombel->konsentrasiKeahlian->nama_konsentrasi ?? $rombel->kelas->jurusan->nama ?? '-' }}
            </div>
            <div>
                <span class="label">Rombel :</span> 
                {{ $rombel->nama ?? '-' }}
            </div>
        </div>
         <div class="right">
            <div>
                <span class="label">Tahun Ajaran :</span> 
                @if(is_object($tahunAjaran))
                    {{ $tahunAjaran->tahun ?? $tahunAjaran->tahun_ajaran ?? '-' }}
                @else
                    {{ $tahunAjaran ?? '-' }}
                @endif
            </div>
        </div>
    </div>

    <!-- ============================================
         TABEL — TTD SISWA SUDAH DIHAPUS
         ============================================ -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 18%;">NIS</th>
                <th style="width: 37%;">Nama Lengkap</th>
                <th style="width: 30%;">Tanda Tangan Orang Tua</th>
                <th style="width: 10%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa as $index => $s)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $s->nis ?? '-' }}</td>
                    <td class="text-left">{{ $s->nama_lengkap ?? '-' }}</td>
                    <td class="text-center signature-cell"></td>
                    <td class="text-center"></td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="5">Tidak ada data siswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="small text-left mt-2">
        Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}
    </div>
</body>
</html>