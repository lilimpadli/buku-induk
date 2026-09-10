@extends('layouts.app')

@section('title', 'Cetak Daftar Hadir - ' . ($rombel->nama ?? 'Rombel'))

@section('content')

<style>
    @page {
        size: F4 portrait;
        margin: 10mm;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Times New Roman', Times, serif;
        font-size: 10pt;
        color: #000;
        background: #e5e7eb;
    }
    
    .print-wrapper {
        width: 210mm;
        min-height: 297mm;
        margin: 20px auto;
        padding: 12mm 15mm;
        background: white;
        box-shadow: 0 0 10px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* TOMBOL KEMBALI & PRINT */
    .controls {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .controls .btn {
        border-radius: 6px;
        font-weight: 600;
        padding: 6px 14px;
        font-size: 9pt;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid #d1d5db;
        font-family: system-ui, -apple-system, sans-serif;
    }

    .btn-secondary {
        background: white;
        color: #111827;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
        border-color: #2563eb;
    }

    .btn-primary:hover { background: #1d4ed8; }
    .btn-secondary:hover { background: #f3f4f6; }

    /* ============================================
       KOP SURAT - TABEL DENGAN LOGO
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
        font-size: 9pt;
        margin-bottom: 8px;
        line-height: 1.5;
        font-weight: bold;
    }

    .info-kelas .left, .info-kelas .right {
        display: flex;
        flex-direction: column;
    }

    .info-kelas .label {
        font-weight: bold;
    }

    /* ============================================
       TABEL ABSENSI
       ============================================ */
    .table-container {
        width: 100%;
        margin-top: 3px;
    }

    .attendance-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 8pt;
    }

    .attendance-table th,
    .attendance-table td {
        border: 1px solid #000;
        padding: 2px 2px;
        vertical-align: middle;
        text-align: center;
        line-height: 1.15;
    }

    .attendance-table th {
        font-weight: bold;
        background: #ffffff;
        text-align: center;
        vertical-align: middle;
    }

    .attendance-table td.left {
        text-align: left;
        padding-left: 4px;
    }

    /* LEBAR KOLOM */
    .col-urt { width: 22px; }
    .col-nisn { width: 68px; }
    .col-nis { width: 58px; }
    .col-nama { width: 185px; height: 20px; }
    .col-jk { width: 24px; }
    .col-date { width: 25px; height: 18px; }
    .col-sia { width: 18px; }
    .col-persen { width: 45px; }
    .col-ket { width: 35px; }

    /* Header angka 1-8 */
    .attendance-table thead tr:nth-child(2) th {
        font-size: 6.5pt;
        padding: 1px 0;
    }

    /* ============================================
       TANDA TANGAN
       ============================================ */
    .signatures {
        margin-top: 25px;
        display: flex;
        justify-content: space-between;
        padding: 0 10px;
        page-break-inside: avoid;
    }

    .signature-box {
        text-align: center;
        width: 40%;
    }

    .signature-box .label {
        font-weight: bold;
        display: block;
        font-size: 8.5pt;
        text-align: left;
        padding-left: 50px;
    }

    .signature-box .nama {
        margin-top: 45px;
        font-weight: bold;
        text-decoration: underline;
        font-size: 9pt;
    }

    .signature-box .nip {
        font-size: 8pt;
        margin-top: 2px;
    }

    /* ============================================
       PRINT STYLE
       ============================================ */
    @media print {
        nav, header, footer, .navbar, .sidebar, .main-header,
        .main-sidebar, .controls, .mobile-header, .user-info,
        .user-panel, .profile-image, .user-avatar, .img-circle,
        .user-image, [class*="profile"], [class*="avatar"],
        [class*="user-"], .dropdown-menu, .logout-section,
        .sidebar-header, .sidebar-content, .brand, .brand-text,
        .logo, .sidebar-overlay, #sidebarOverlay, #sidebarBackdrop {
            display: none !important;
        }

        img[src*="profile"], img[src*="avatar"], img[src*="user"],
        img[src*="photo"], img[alt*="Profile"], img[alt*="profile"] {
            display: none !important;
        }

        body {
            background: white !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .print-wrapper {
            width: 100% !important;
            margin: 0 !important;
            padding: 8mm 10mm !important;
            box-shadow: none !important;
            min-height: auto !important;
        }

        .attendance-table th,
        .attendance-table td {
            padding: 2px 2px;
            font-size: 8.5pt;
        }

        .container-fluid, .row {
            margin: 0 !important;
            padding: 0 !important;
        }

        main {
            margin: 0 !important;
            padding: 0 !important;
            max-width: 100% !important;
        }
    }
</style>

<div class="print-wrapper">
    <div>
        <!-- TOMBOL KEMBALI, PRINT & EXPORT -->
        <div class="controls">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="button" class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
            <a href="{{ route('tu.kelas.export', $rombel->id) }}" class="btn btn-secondary">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>

        <!-- KOP SURAT -->
        <table class="kop-table">
            <tr>
                <td class="logo-cell" rowspan="2">
                    <img src="{{ asset('images/smkn1-kawali-logo.png') }}" alt="Logo SMKN 1 Kawali" onerror="this.style.display='none'">
                </td>
                <td class="school-cell">
                    <div class="school-name">SMK NEGERI 1 KAWALI</div>
                    <div class="school-address">Jalan Talagasari No. 35 Telp. (0265) 791727 Kawali 46253 Kab. Ciamis</div>
                    <div class="school-contact">Email : smkn1kawali@gmail.com - Website : http://www.smkn1kawali.sch.id</div>
                </td>
            </tr>
            <tr>
                <td class="judul-cell">DAFTAR HADIR SISWA</td>
            </tr>
        </table>

        <!-- INFO KELAS -->
        <div class="info-kelas">
            <div class="left">
                <div>
                    <span class="label">Konsentrasi Keahlian :</span> 
                    {{ $rombel->konsentrasiKeahlian->nama_konsentrasi ?? '-' }}
                </div>
                <div>
                    <span class="label">Kelas :</span> 
                    {{ $rombel->nama ?? '-' }}
                </div>
            </div>
            <div class="right">
                <div><span class="label">Mata Pelajaran :</span> ................................................................</div>
                <div><span class="label">Smt/Thn.Pel. <span style="padding-left: 13px;">:</span></span> {{ optional($semester)->semester_name ?? 'Ganjil' }} / {{ optional($tahunAjaran)->tahun ?? '2026/2027' }}</div>
            </div>
        </div>

        <!-- TABEL ABSENSI -->
        <div class="table-container">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th colspan="3">NOMOR</th>
                        <th rowspan="2" class="col-nama">NAMA</th>
                        <th rowspan="2" class="col-jk">JK</th>
                        <th colspan="8">TANGGAL</th>
                        <th colspan="3">JUMLAH<br>KEHADIRAN</th>
                        <th rowspan="2" class="col-persen">%<br>KEHADIRAN</th>
                        <th rowspan="2" class="col-ket">KET</th>
                    </tr>
                    <tr>
                        <th class="col-urt">Urt</th>
                        <th class="col-nisn">NISN</th>
                        <th class="col-nis">NIS</th>

                        @for($day = 1; $day <= 8; $day++)
                            <th class="col-date"></th>
                        @endfor

                        <th class="col-sia">S</th>
                        <th class="col-sia">I</th>
                        <th class="col-sia">A</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $siswaItem)
                        @php
                            $absensiByDate = [];
                            if ($siswaItem->absensi && $siswaItem->absensi->isNotEmpty()) {
                                foreach ($siswaItem->absensi as $absen) {
                                    $tanggal = (int) date('j', strtotime($absen->tanggal));
                                    $absensiByDate[$tanggal] = $absen;
                                }
                            }

                            $totalS = 0;
                            $totalI = 0;
                            $totalA = 0;
                            $totalHadir = 0;
                            $keterangan = '';

                            if ($siswaItem->absensi && $siswaItem->absensi->isNotEmpty()) {
                                foreach ($siswaItem->absensi as $absen) {
                                    $status = strtolower($absen->status ?? '');
                                    switch ($status) {
                                        case 's':
                                        case 'sakit':
                                            $totalS++;
                                            break;
                                        case 'i':
                                        case 'izin':
                                            $totalI++;
                                            break;
                                        case 'a':
                                        case 'alpha':
                                        case 'alpa':
                                            $totalA++;
                                            break;
                                        default:
                                            $totalHadir++;
                                            break;
                                    }
                                }
                                $lastAbsen = $siswaItem->absensi->sortByDesc('tanggal')->first();
                                $keterangan = $lastAbsen->keterangan ?? '';
                            }

                            $jumlahAbsen = $totalS + $totalI + $totalA + $totalHadir;
                            $persenKehadiran = $jumlahAbsen > 0 ? round(($totalHadir / $jumlahAbsen) * 100) : '';

                            // Penentuan Jenis Kelamin (L / P)
                            $jk = '';
                            if (!empty($siswaItem->jenis_kelamin)) {
                                $jkValue = strtolower($siswaItem->jenis_kelamin);
                                if (in_array($jkValue, ['l', 'laki', 'laki-laki'])) {
                                    $jk = 'L';
                                } elseif (in_array($jkValue, ['p', 'perempuan'])) {
                                    $jk = 'P';
                                }
                            } elseif (isset($siswaItem->jenis_kelamin_id)) {
                                $jk = $siswaItem->jenis_kelamin_id == 1 ? 'L' : 'P';
                            } elseif (isset($siswaItem->jenisKelamin)) {
                                $jkNama = strtolower($siswaItem->jenisKelamin->nama ?? '');
                                if (str_contains($jkNama, 'laki')) {
                                    $jk = 'L';
                                } elseif (str_contains($jkNama, 'perempuan')) {
                                    $jk = 'P';
                                }
                            }
                        @endphp

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $siswaItem->nisn ?? '-' }}</td>
                            <td>{{ $siswaItem->nis ?? '-' }}</td>
                            <td class="left">{{ strtoupper($siswaItem->nama_lengkap ?? $siswaItem->nama_siswa ?? '') }}</td>
                            <td>{{ $jk }}</td>

                            @for($day = 1; $day <= 8; $day++)
                                @php
                                    $display = '';
                                    if(isset($absensiByDate[$day])){
                                        $status = strtolower($absensiByDate[$day]->status ?? '');
                                        if(in_array($status, ['s', 'sakit'])){
                                            $display = 'S';
                                        } elseif(in_array($status, ['i', 'izin'])){
                                            $display = 'I';
                                        } elseif(in_array($status, ['a', 'alpha', 'alpa'])){
                                            $display = 'A';
                                        } else {
                                            $display = '✓';
                                        }
                                    }
                                @endphp
                                <td>{{ $display }}</td>
                            @endfor

                            <td>{{ $totalS ?: '' }}</td>
                            <td>{{ $totalI ?: '' }}</td>
                            <td>{{ $totalA ?: '' }}</td>
                            <td>{{ $persenKehadiran !== '' ? $persenKehadiran.'%' : '' }}</td>
                            <td>{{ $keterangan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="18" style="text-align:center; padding:10px;">
                                Data siswa tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse

                    <!-- TOTAL SISWA L / P -->
                    <tr>
                        <td colspan="4" rowspan="2" style="font-weight:bold; text-align:center; vertical-align:middle;">
                            JUMLAH
                        </td>
                        <td style="font-weight:bold;">L</td>
                        <td style="font-weight:bold;">{{ $jumlahLaki ?? 0 }}</td>
                        <td colspan="12" rowspan="2"></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;">P</td>
                        <td style="font-weight:bold;">{{ $jumlahPerempuan ?? 0 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- TANDA TANGAN -->
    <div>
        <div class="signatures">
            <div class="signature-box">
                <span class="label">Mengetahui,</span>
                <div>Kepala SMK Negeri 1 Kawali,</div>
                <div class="nama">DEDE FAJRIADI, S.Pd., M.Pd.</div>
                <div class="nip">NIP. 19840222 200901 1 005</div>
            </div>
            <div class="signature-box">
                <div style="font-size:8.5pt;">Ciamis, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</div>
                <div>Guru Mata Pelajaran,</div>
                <div class="nama">____________________</div>
                <div class="nip">NIP. </div>
            </div>
        </div>
    </div>
</div>

@endsection