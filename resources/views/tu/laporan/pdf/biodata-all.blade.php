<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Biodata Seluruh Siswa</title>
    <style>
        /* ============================================
           UKURAN KERTAS F4 (FOLIO) 215mm x 330mm
           ============================================ */
        @page {
            size: 215mm 330mm portrait;
            margin: 10mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            color: #000;
            margin: 0;
            padding: 0;
            background: white;
        }

        /* ============================================
           KOP SURAT - SEPERTI REFERENSI
           ============================================ */
        .kop {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .kop .school-name {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .kop .school-address {
            font-size: 10pt;
            margin: 2px 0;
            line-height: 1.4;
        }

        .kop .school-contact {
            font-size: 9pt;
            margin: 2px 0;
        }

        /* ============================================
           TITLE & INFO
           ============================================ */
        .title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 8px;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .info-rombel {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 10px;
            font-weight: bold;
        }

        /* ============================================
           TABEL BIODATA
           ============================================ */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            table-layout: fixed;
            font-size: 10pt;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 5px 6px;
            vertical-align: middle;
            word-wrap: break-word;
            overflow: hidden;
        }

        table th {
            background-color: #e6e6e6;
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        thead {
            display: table-header-group;
        }
        
        tr {
            page-break-inside: avoid;
        }

        .col-no { width: 5%; }
        .col-nis { width: 13%; }
        .col-nama { width: 32%; }
        .col-jk { width: 6%; }
        .col-tempat { width: 30%; }
        .col-rombel { width: 14%; }

        .text-center { text-align: center; }
        .text-left { text-align: left; }

        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 9pt;
            font-style: italic;
        }

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
                background: #e6e6e6 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .kop {
                page-break-after: avoid;
            }
        }
    </style>
</head>
<body>
    <!-- ============================================
         KOP SURAT
         ============================================ -->
    <div class="kop">
        <div class="school-name">SMK NEGERI 1 KAWALI</div>
        <div class="school-address">Jalan Talagasari No. 35 Telp. (0265) 791727 Kawali 46253 Kab. Ciamis</div>
        <div class="school-contact">Email : smkn1kawali@gmail.com - Website : http://www.smkn1kawali.sch.id</div>
    </div>

    <div class="title">BIODATA LENGKAP SISWA</div>

    <!-- TAMPILKAN TAHUN AJARAN & ROMBEL -->
    <div class="info-rombel">
        Tahun Ajaran: {{ $tahunAjaran ?? '-' }}
        @if(isset($rombel))
            &nbsp;&nbsp;|&nbsp;&nbsp;Rombel: {{ $rombel->nama ?? '-' }}
        @endif
    </div>

    <!-- ============================================
         TABEL BIODATA
         ============================================ -->
    <table>
        <thead>
            <tr>
                <th class="text-center col-no">No</th>
                <th class="text-center col-nis">NIS</th>
                <th class="text-left col-nama">Nama Lengkap</th>
                <th class="text-center col-jk">JK</th>
                <th class="text-left col-tempat">Tempat / Tgl Lahir</th>
                <th class="text-center col-rombel">Rombel</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa as $index => $s)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $s->nis ?? '-' }}</td>
                    <td class="text-left">{{ strtoupper($s->nama_lengkap ?? '-') }}</td>
                    <td class="text-center">
                        @php
                            $jk = $s->jenis_kelamin ?? '';
                            if (str_contains(strtolower($jk), 'laki')) {
                                echo 'L';
                            } elseif (str_contains(strtolower($jk), 'perempuan')) {
                                echo 'P';
                            } else {
                                echo substr($jk, 0, 1) ?: '-';
                            }
                        @endphp
                    </td>
                    <td class="text-left">
                        {{ strtoupper($s->tempat_lahir ?? '-') }} / 
                        {{ $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                    </td>
                    <td class="text-center">{{ $s->rombel->nama ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="6">Tidak ada data siswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}
    </div>
</body>
</html>