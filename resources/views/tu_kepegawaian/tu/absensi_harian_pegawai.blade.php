<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Hadir Harian Pegawai</title>
    <style>
        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }

        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 10pt; 
            padding: 0;
            width: 100%;
            background-color: #fff;
        }

        .page {
            width: 100%;
            page-break-after: always;
            page-break-inside: avoid;
            padding-top: 15px;
        }

        .page:first-of-type {
            padding-top: 0 !important;
        }

        .page:last-of-type {
            page-break-after: avoid !important;
        }

        .kop { 
            width: 100%;
            border-bottom: 3px double #000; 
            padding-bottom: 5px; 
            margin-bottom: 12px; 
        }
        
        .kop table {
            width: 100%;
            border-collapse: collapse;
            border: none !important;
        }

        .kop table td {
            border: none !important;
            padding: 0;
            vertical-align: middle;
        }

        .kop img { 
            width: 65px; 
            height: auto; 
            display: block;
            margin: 0 auto;
        }

        .kop .pemda { font-size: 10pt; font-weight: normal; }
        .kop .dinas { font-size: 11pt; font-weight: bold; }
        .kop .cabang { font-size: 10pt; }
        .kop .sekolah { font-size: 14pt; font-weight: bold; letter-spacing: 1px; }
        .kop .alamat { font-size: 8pt; }

        .judul { 
            text-align: center; 
            font-weight: bold; 
            font-size: 13pt; 
            text-transform: uppercase; 
            margin: 10px 0 10px 0; 
            width: 100%;
        }

        .info-unit { 
            font-size: 10pt; 
            margin-bottom: 10px; 
            width: 100%;
        }
        .info-row { display: flex; margin-bottom: 2px; }
        .info-label { width: 100px; font-weight: normal; flex-shrink: 0; }

        table.tabel-utama {
            width: 100%;
            margin: 0 auto 10px auto;
            border-collapse: collapse;
            font-size: 8.5pt;
            table-layout: fixed;
        }

        table.tabel-utama thead th {
            border: 1px solid #000;
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            padding: 3px;
            vertical-align: middle;
        }

        .tanggal-header {
            border: 1px solid #000;
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            font-size: 7pt;
            padding: 2px 0;
        }

        table.tabel-utama tbody td {
            border: 1px solid #000;
            padding: 2px;
            vertical-align: middle;
        }
        
        .col-no { text-align: center; }
        
        .col-nama-nip { 
            padding: 3px 5px !important; 
            vertical-align: middle; 
            word-wrap: break-word; 
        }

        .nama-text { 
            font-weight: bold; 
            font-size: 8.5pt; 
            line-height: 1.1;
            color: #000;
        }
        .nip-text { 
            font-family: 'Courier New', monospace; 
            font-size: 7.5pt; 
            color: #333; 
            margin-top: 1px;
        }

        .cell-tanggal {
            height: 26px;
            padding: 0 !important;
        }

        .footer { 
            margin-top: 15px; 
            text-align: right; 
            font-size: 10pt; 
            width: 100%; 
            page-break-inside: avoid;
        }
        .ttd-container { 
            display: inline-block; 
            text-align: left; 
            line-height: 1.3;
            padding-right: 30px;
        }
        .nama-kepala { 
            text-decoration: underline; 
            font-weight: bold; 
        }

        /* =========================================================
           TOMBOL PREMIUM (TIDAK MENGUBAH LAYOUT DOKUMEN)
           ========================================================= */
        .no-print { display: block; }
        
        .toolbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin-bottom: 15px;
        }

        .btn-premium {
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .15s ease;
        }

        .btn-premium-print {
            background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
            color: #fff;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        }

        .btn-premium-print:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4); }

        .btn-premium-close {
            background: #fff;
            color: #EF4444;
            border: 1px solid #EF4444;
        }

        .btn-premium-close:hover { background: #FEF2F2; }

        /* KUNCI UKURAN F4 LANDSCAPE (330mm x 210mm) */
        @media print {
            @page { 
                size: 330mm 210mm landscape; 
                margin: 10mm; 
            }
            
            body {
                padding: 0 !important; 
                margin: 0 !important;
                width: 100% !important;
            }

            .toolbar, .no-print { 
                display: none !important; 
            }
        }
    </style>
</head>
<body>

    <!-- TOMBOL PREMIUM -->
    <div class="no-print toolbar">
        <button type="button" class="btn-premium btn-premium-print" onclick="window.print()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Cetak / Print
        </button>
        <button type="button" class="btn-premium btn-premium-close" onclick="window.close()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            Tutup Tab
        </button>
    </div>

    @php
    // SET 14 PEGAWAI PER HALAMAN (PAS UNTUK LANDSCAPE F4)
    $pegawaisChunked = $pegawais->chunk(14);
    $globalNo = 1;
    @endphp

    @forelse($pegawaisChunked as $chunk)
        <div class="page">
            
            <!-- KOP SURAT, JUDUL, & INFO UNIT HANYA MUNCUL 1 KALI DI HALAMAN PERTAMA -->
            @if($loop->first)
                <div class="kop">
                    <table>
                        <tr>
                            <td style="width: 12%; text-align: center;">
                                <img src="{{ asset('images/logoJabar.png') }}" onerror="this.style.display='none'">
                            </td>
                            <td style="width: 76%; text-align: center;">
                                <div class="pemda">PEMERINTAH DAERAH PROVINSI JAWA BARAT</div>
                                <div class="dinas">DINAS PENDIDIKAN</div>
                                <div class="cabang">CABANG DINAS PENDIDIKAN WILAYAH XIII</div>
                                <div class="sekolah">SMK NEGERI 1 KAWALI</div>
                                <div class="alamat">
                                    Jalan Talagasari No.35 Tel. (0265) 791 727 Email : smkn1kawali@gmail.com website : smkn1kawali.sch.id
                                </div>
                            </td>
                            <td style="width: 12%;"></td>
                        </tr>
                    </table>
                </div>

                <div class="judul">
                    DAFTAR HADIR PEGAWAI / TU
                </div>

                <div class="info-unit">
                    <div class="info-row">
                        <div class="info-label">UNIT KERJA</div>
                        <div>: SMK N 1 KAWALI</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">BULAN</div>
                        <div>: {{ strtoupper($bulan ?? date('F')) }} {{ $tahun ?? date('Y') }}</div>
                    </div>
                </div>
            @endif

            <!-- TABEL UTAMA -->
            <table class="tabel-utama">
                <thead>
                    <tr>
                        <th class="col-no" rowspan="2" style="width: 4%;">No.</th>
                        <th class="col-nama" rowspan="2" style="width: 25%;">N A M A / NIP</th>
                        <th colspan="31" style="width: 71%;">TANGGAL</th>
                    </tr>
                    <tr>
                        @for($i = 1; $i <= 31; $i++)
                            <th class="tanggal-header">{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($chunk as $pegawai)
                        <tr>
                            <td class="col-no">{{ $globalNo++ }}</td>
                            <td class="col-nama-nip">
                                <div class="nama-text">{{ strtoupper($pegawai->nama) }}</div>
                                <div class="nip-text">NIP. {{ $pegawai->nip ?? '-' }}</div>
                            </td>
                            @for($i = 1; $i <= 31; $i++)
                                <td class="cell-tanggal"></td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- TANDA TANGAN HANYA DI HALAMAN TERAKHIR -->
            @if($loop->last)
                <div class="footer">
                    <div class="ttd-container">
                        Kawali,<br>
                        Kepala SMK Negeri 1 Kawali<br><br><br><br>
                        <span class="nama-kepala">DEDE FAJRIADI, S.Pd., M.Pd</span><br>
                        NIP. 19840222 200901 1 005
                    </div>
                </div>
            @endif
        </div>
    @empty
        <div class="page">
            <table class="tabel-utama">
                <tbody>
                    <tr>
                        <td style="text-align: center; padding: 15px;">Tidak ada data pegawai</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforelse

</body>
</html>