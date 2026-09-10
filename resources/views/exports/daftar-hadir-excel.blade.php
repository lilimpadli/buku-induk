<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        /* ==========================================
               CSS UTAMA
               ========================================== */
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 9pt;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* ==========================================
               BORDER
               ========================================== */
        .border {
            border: 1px solid #000;
        }

        .border-none {
            border: none;
        }

        /* ==========================================
               ALIGNMENT
               ========================================== */
        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .vertical-middle {
            vertical-align: middle;
        }

        .vertical-bottom {
            vertical-align: bottom;
        }

        /* ==========================================
               FONT
               ========================================== */
        .bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }

        .font-6 {
            font-size: 6pt;
        }

        .font-7 {
            font-size: 7pt;
        }

        .font-8 {
            font-size: 8pt;
        }

        .font-9 {
            font-size: 9pt;
        }

        .font-10 {
            font-size: 10pt;
        }

        .font-12 {
            font-size: 12pt;
        }

        .font-13 {
            font-size: 13pt;
        }

        .font-14 {
            font-size: 14pt;
        }

        .font-16 {
            font-size: 16pt;
        }

        /* ==========================================
               BACKGROUND
               ========================================== */
        .bg-white {
            background: #FFFFFF;
        }

        /* ==========================================
               PADDING
               ========================================== */
        .p-1 {
            padding: 1px 2px;
        }

        .p-2 {
            padding: 2px 4px;
        }

        .p-3 {
            padding: 3px 6px;
        }

        .p-4 {
            padding: 4px 8px;
        }

        .p-6 {
            padding: 6px 0;
        }

        .pl-5 {
            padding-left: 5px;
        }

        .pl-60 {
            padding-left: 60px;
        }

        .pl-80 {
            padding-left: 80px;
        }

        /* ==========================================
               SPACER / MARGIN
               ========================================== */
        .h-3 {
            height: 3px;
        }

        .h-4 {
            height: 4px;
        }

        .h-10 {
            height: 10px;
        }

        .h-15 {
            height: 15px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .pt-10 {
            padding-top: 10px;
        }

        /* ==========================================
               WIDTH
               ========================================== */
        .w-45 {
            width: 45px;
        }

        .w-80 {
            width: 80px;
        }

        .w-4 {
            width: 4%;
        }

        .w-5 {
            width: 5%;
        }

        .w-6 {
            width: 6%;
        }

        .w-8 {
            width: 8%;
        }

        .w-10 {
            width: 10%;
        }

        .w-12 {
            width: 12%;
        }

        .w-28 {
            width: 28%;
        }

        /* ==========================================
               LOGO - PERBAIKAN!
               ========================================== */
        .logo-img {
            width: 35px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        /* ==========================================
               CELL LOGO - PERBAIKAN!
               ========================================== */
        .cell-logo {
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            width: 65px;
            padding: 4px 2px;
        }

        .cell-header {
            border: 1px solid #000;
            font-weight: bold;
            text-align: center;
            background: #FFFFFF;
            padding: 1px 2px;
            font-size: 8pt;
        }

        .cell-data {
            border: 1px solid #000;
            text-align: center;
            padding: 1px 2px;
            font-size: 8pt;
        }

        .cell-data-left {
            border: 1px solid #000;
            text-align: left;
            padding: 1px 2px 1px 4px;
            font-size: 8pt;
        }

        .cell-total {
            border: 1px solid #000;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            padding: 1px 2px;
            font-size: 8pt;
        }

        .cell-total-label {
            border: 1px solid #000;
            font-weight: bold;
            text-align: center;
            padding: 1px 2px;
            font-size: 8pt;
        }

        .cell-kop {
            border: 1px solid #000;
            text-align: center;
            padding: 2px 4px;
        }

        .cell-kop-title {
            border: 1px solid #000;
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            padding: 2px 4px;
        }

        .cell-kop-judul {
            border: 1px solid #000;
            font-size: 13pt;
            font-weight: bold;
            text-align: center;
            padding: 4px 0;
        }

        .cell-info {
            border: none;
            font-weight: bold;
            padding: 1px 2px;
        }

        .cell-info-value {
            border: none;
            padding: 1px 2px;
        }

        .cell-spacer {
            border: none;
            height: 4px;
        }

        .cell-spacer-lg {
            border: none;
            height: 15px;
        }

        .cell-signature {
            border: none;
            text-align: center;
            vertical-align: bottom;
            padding-top: 10px;
        }
    </style>
</head>
<body>

<table>

    <!-- ==========================================
         KOP SURAT - PERBAIKAN!
         ========================================== -->
    <tr>
        <td colspan="3" rowspan="3" class="cell-logo">
            <img src="{{ public_path('images/smkn1-kawali-logo.png') }}" alt="Logo" class="logo-img">
        </td>
        <td colspan="15" class="cell-kop-title">
            SMK NEGERI 1 KAWALI
        </td>
    </tr>
    <tr>
        <td colspan="15" class="cell-kop font-9">
            Jalan Talagasari No. 35 Telp. (0265) 791727 Kawali 46253 Kab. Ciamis
        </td>
    </tr>
    <tr>
        <td colspan="15" class="cell-kop font-8">
            Email : smkn1kawali@gmail.com - Website : http://www.smkn1kawali.sch.id
        </td>
    </tr>
    <tr>
        <td colspan="18" class="cell-kop-judul">
            DAFTAR HADIR SISWA
        </td>
    </tr>

    <!-- SPACER -->
    <tr><td colspan="18" class="cell-spacer"></td></tr>

    <!-- ==========================================
         INFO KELAS
         ========================================== -->
    <tr>
        <td colspan="3" class="cell-info">Konsentrasi Keahlian</td>
        <td colspan="6" class="cell-info-value">: {{ $rombel->konsentrasiKeahlian->nama_konsentrasi ?? '-' }}</td>
        <td colspan="3" class="cell-info">Mata Pelajaran</td>
        <td colspan="6" class="cell-info-value">: ................................................................</td>
    </tr>
    <tr>
        <td colspan="3" class="cell-info">Kelas</td>
        <td colspan="6" class="cell-info-value">: {{ $rombel->nama ?? '-' }}</td>
        <td colspan="3" class="cell-info">Smt/Thn.Pel.</td>
        <td colspan="6" class="cell-info-value">: {{ optional($semester)->semester_name ?? 'Ganjil' }} / {{ optional($tahunAjaran)->tahun ?? '2024/2025' }}</td>
    </tr>

    <!-- SPACER -->
    <tr><td colspan="18" class="cell-spacer"></td></tr>

    <!-- ==========================================
         HEADER TABEL ABSENSI
         ========================================== -->
    <thead>
        <tr>
            <th colspan="3" class="cell-header">NOMOR</th>
            <th rowspan="2" class="cell-header w-28">NAMA</th>
            <th rowspan="2" class="cell-header w-5">JK</th>
            <th colspan="8" class="cell-header">TANGGAL</th>
            <th colspan="3" class="cell-header">JUMLAH KEHADIRAN</th>
            <th rowspan="2" class="cell-header w-8">% KEHADIRAN</th>
            <th rowspan="2" class="cell-header w-10">KET</th>
        </tr>
        <tr>
            <th class="cell-header w-5">Urt</th>
            <th class="cell-header w-12">NISN</th>
            <th class="cell-header w-10">NIS</th>

            @for($day = 1; $day <= 8; $day++)
                <th class="cell-header w-6 font-6"></th>
            @endfor

            <th class="cell-header w-5">S</th>
            <th class="cell-header w-5">I</th>
            <th class="cell-header w-5">A</th>
        </tr>
    </thead>

    <!-- ==========================================
         DATA SISWA
         ========================================== -->
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

                $totalS = 0; $totalI = 0; $totalA = 0; $totalHadir = 0; $keterangan = '';
                if ($siswaItem->absensi && $siswaItem->absensi->isNotEmpty()) {
                    foreach ($siswaItem->absensi as $absen) {
                        $status = strtolower($absen->status ?? '');
                        if (in_array($status, ['s', 'sakit'])) { $totalS++; }
                        elseif (in_array($status, ['i', 'izin'])) { $totalI++; }
                        elseif (in_array($status, ['a', 'alpha', 'alpa'])) { $totalA++; }
                        else { $totalHadir++; }
                    }
                    $lastAbsen = $siswaItem->absensi->sortByDesc('tanggal')->first();
                    $keterangan = $lastAbsen->keterangan ?? '';
                }

                $jumlahAbsen = $totalS + $totalI + $totalA + $totalHadir;
                $persenKehadiran = $jumlahAbsen > 0 ? round(($totalHadir / $jumlahAbsen) * 100) : '';

                $jk = '';
                if (!empty($siswaItem->jenis_kelamin)) {
                    $jkValue = strtolower($siswaItem->jenis_kelamin);
                    if (in_array($jkValue, ['l', 'laki', 'laki-laki'])) { $jk = 'L'; }
                    elseif (in_array($jkValue, ['p', 'perempuan'])) { $jk = 'P'; }
                } elseif (isset($siswaItem->jenis_kelamin_id)) {
                    $jk = $siswaItem->jenis_kelamin_id == 1 ? 'L' : 'P';
                }
            @endphp
            <tr>
                <td class="cell-data">{{ $index + 1 }}</td>
                <td class="cell-data">{{ $siswaItem->nisn ?? '-' }}</td>
                <td class="cell-data">{{ $siswaItem->nis ?? '-' }}</td>
                <td class="cell-data-left">{{ strtoupper($siswaItem->nama_lengkap ?? $siswaItem->nama_siswa ?? '') }}</td>
                <td class="cell-data">{{ $jk }}</td>

                @for($day = 1; $day <= 8; $day++)
                    @php
                        $display = '';
                        if(isset($absensiByDate[$day])){
                            $status = strtolower($absensiByDate[$day]->status ?? '');
                            if(in_array($status, ['s', 'sakit'])) $display = 'S';
                            elseif(in_array($status, ['i', 'izin'])) $display = 'I';
                            elseif(in_array($status, ['a', 'alpha', 'alpa'])) $display = 'A';
                            else $display = '✓';
                        }
                    @endphp
                    <td class="cell-data">{{ $display }}</td>
                @endfor

                <td class="cell-data">{{ $totalS ?: '' }}</td>
                <td class="cell-data">{{ $totalI ?: '' }}</td>
                <td class="cell-data">{{ $totalA ?: '' }}</td>
                <td class="cell-data">{{ $persenKehadiran !== '' ? $persenKehadiran.'%' : '' }}</td>
                <td class="cell-data">{{ $keterangan }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="18" class="cell-data" style="padding: 10px;">Data siswa tidak ditemukan.</td>
            </tr>
        @endforelse

        <!-- ==========================================
             TOTAL JUMLAH SISWA L / P
             ========================================== -->
        <tr>
            <td colspan="4" rowspan="2" class="cell-total">JUMLAH</td>
            <td class="cell-total-label">L</td>
            <td class="cell-total-label">{{ $jumlahLaki ?? 0 }}</td>
            <td colspan="12" rowspan="2" class="border"></td>
        </tr>
        <tr>
            <td class="cell-total-label">P</td>
            <td class="cell-total-label">{{ $jumlahPerempuan ?? 0 }}</td>
        </tr>
    </tbody>

    <!-- ==========================================
         SPACER
         ========================================== -->
    <tr><td colspan="18" class="cell-spacer-lg"></td></tr>

    <!-- ==========================================
         TANDA TANGAN
         ========================================== -->
    <tr>
        <td colspan="9" class="cell-signature">
            <div class="bold text-left pl-60">Mengetahui,</div>
            <div class="text-center">Kepala SMK Negeri 1 Kawali,</div>
            <br><br><br>
            <div class="bold underline text-center">DEDE FAJRIADI, S.Pd., M.Pd.</div>
            <div class="font-7 text-center">NIP. 19840222 200901 1 005</div>
        </td>
        <td colspan="9" class="cell-signature">
            <div class="bold text-left pl-80">Ciamis, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</div>
            <div class="text-center">Guru Mata Pelajaran,</div>
            <br><br><br>
            <div class="bold underline text-center">____________________</div>
            <div class="font-7 text-center">NIP.</div>
        </td>
    </tr>

</table>

</body>
</html>