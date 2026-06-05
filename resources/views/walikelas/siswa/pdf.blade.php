<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>BUKU INDUK SISWA - {{ $siswa->nama_lengkap }}</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', 'Calibri', 'Arial', serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #1a1a1a;
        }

        /* ==================== HEADER ==================== */
        .kop {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #000;
        }

        .kop .pemda {
            font-size: 10pt;
            letter-spacing: 1px;
        }

        .kop .dinas {
            font-size: 11pt;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .kop .sekolah {
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: 2px;
            margin-top: 5px;
        }

        .kop .alamat {
            font-size: 9pt;
            margin-top: 5px;
        }

        .kop .akreditasi {
            font-size: 9pt;
            font-style: italic;
            margin-top: 3px;
        }

        /* ==================== JUDUL ==================== */
        .judul-utama {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 15px 0 5px 0;
        }

        .judul-sub {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 20px;
        }

        /* ==================== FOTO ==================== */
        .foto-wrapper {
            float: right;
            width: 130px;
            margin-left: 20px;
            margin-bottom: 15px;
            text-align: center;
        }

        .foto-box {
            width: 120px;
            height: 150px;
            border: 2px solid #333;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .foto-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .foto-text {
            font-size: 8pt;
            margin-top: 5px;
            font-style: italic;
        }

        /* ==================== TABEL ==================== */
        .tabel-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .tabel-info td {
            padding: 6px 8px;
            vertical-align: top;
        }

        .tabel-info .label {
            width: 32%;
            font-weight: 600;
            background: #f0f0f0;
            border: 1px solid #ccc;
        }

        .tabel-info .colon {
            width: 3%;
            text-align: center;
            border: 1px solid #ccc;
        }

        .tabel-info .value {
            width: 65%;
            border: 1px solid #ccc;
        }

        /* ==================== SECTION ==================== */
        .section {
            margin-top: 15px;
            margin-bottom: 10px;
            clear: both;
        }

        .section-title {
            font-size: 12pt;
            font-weight: bold;
            background: #e0e0e0;
            padding: 6px 12px;
            border-left: 5px solid #2c3e66;
            margin-bottom: 10px;
        }

        /* ==================== TANDA TANGAN ==================== */
        .ttd-wrapper {
            margin-top: 35px;
            display: flex;
            justify-content: space-between;
            clear: both;
        }

        .ttd-kiri, .ttd-kanan {
            width: 45%;
            text-align: center;
        }

        .ttd-garis {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .ttd-nama {
            font-weight: bold;
            margin-top: 5px;
        }

        .ttd-jabatan {
            font-size: 10pt;
            margin-bottom: 5px;
        }

        /* ==================== CATATAN ==================== */
        .catatan-box {
            margin-top: 20px;
            border: 1px dashed #999;
            padding: 10px;
            background: #fafafa;
        }

        .catatan-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* ==================== FOOTER ==================== */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }

        /* ==================== CLEARFIX ==================== */
        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>

    <!-- ==================== KOP SEKOLAH ==================== -->
    <div class="kop">
        <div class="pemda">PEMERINTAH PROVINSI JAWA BARAT</div>
        <div class="dinas">DINAS PENDIDIKAN</div>
        <div class="sekolah">SMK NEGERI 1 CIAMIS</div>
        <div class="alamat">
            Jl. Jenderal Sudirman No. 45, Kec. Ciamis, Kab. Ciamis, Jawa Barat 46211
        </div>
        <div class="alamat">
            Telp. (0265) 123456 | Email: info@smkn1ciamis.sch.id | www.smkn1ciamis.sch.id
        </div>
        <div class="akreditasi">
            TERAKREDITASI "A" (NPSN: 12345678)
        </div>
    </div>

    <!-- ==================== JUDUL ==================== -->
    <div class="judul-utama">BUKU INDUK SISWA</div>
    <div class="judul-sub">KETERANGAN TENTANG DIRI PESERTA DIDIK</div>

    <!-- ==================== FOTO ==================== -->
    <div class="foto-wrapper">
        <div class="foto-box">
            @if($siswa->foto && file_exists(storage_path('app/public/' . $siswa->foto)))
                @php
                    $diskPath = storage_path('app/public/' . $siswa->foto);
                    $type = pathinfo($diskPath, PATHINFO_EXTENSION);
                    $data = file_get_contents($diskPath);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                @endphp
                <img src="{{ $base64 }}" alt="Foto {{ $siswa->nama_lengkap }}">
            @else
                <div style="text-align: center; color: #999;">FOTO<br>BELUM ADA</div>
            @endif
        </div>
        <div class="foto-text">Foto Peserta Didik</div>
        <div class="foto-text" style="margin-top: 5px;">(Ukuran 3x4 cm)</div>
    </div>

    <!-- ==================== DATA PRIBADI ==================== -->
    <div class="section">
        <div class="section-title">A. DATA PRIBADI SISWA</div>
        <table class="tabel-info">
            <tr><td class="label">1. Nama Lengkap</td><td class="colon">:</td><td class="value"><b>{{ strtoupper($siswa->nama_lengkap ?? '-') }}</b></td></tr>
            <tr><td class="label">2. NIS / NISN</td><td class="colon">:</td><td class="value">{{ $siswa->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</td></tr>
            <tr><td class="label">3. Tempat, Tanggal Lahir</td><td class="colon">:</td><td class="value">{{ $siswa->tempat_lahir ?? '-' }}, {{ optional(\Carbon\Carbon::parse($siswa->tanggal_lahir))->translatedFormat('d F Y') ?? '-' }}</td></tr>
            <tr><td class="label">4. Jenis Kelamin</td><td class="colon">:</td><td class="value">{{ $siswa->jenis_kelamin ?? '-' }}</td></tr>
            <tr><td class="label">5. Agama</td><td class="colon">:</td><td class="value">{{ $siswa->agama ?? '-' }}</td></tr>
            <tr><td class="label">6. Kewarganegaraan</td><td class="colon">:</td><td class="value">{{ $siswa->kewarganegaraan ?? '-' }}</td></tr>
            <tr><td class="label">7. Status Dalam Keluarga</td><td class="colon">:</td><td class="value">{{ $siswa->status_keluarga ?? '-' }}</td></tr>
            <tr><td class="label">8. Anak Ke-</td><td class="colon">:</td><td class="value">{{ $siswa->anak_ke ?? '-' }}</td></tr>
            <tr><td class="label">9. Alamat Lengkap</td><td class="colon">:</td><td class="value">
                Dusun {{ $siswa->dusun ?? '-' }}, RT/RW {{ $siswa->rt ?? '-' }}/{{ $siswa->rw ?? '-' }}<br>
                Desa/Kelurahan {{ $siswa->kelurahan ?? '-' }}, Kecamatan {{ $siswa->kecamatan ?? '-' }}<br>
                Kode Pos {{ $siswa->kode_pos ?? '-' }}
            </td></tr>
            <tr><td class="label">10. Nomor Telepon/HP</td><td class="colon">:</td><td class="value">{{ $siswa->no_hp ?? '-' }}</td></tr>
            <tr><td class="label">11. Sekolah Asal</td><td class="colon">:</td><td class="value">{{ $siswa->sekolah_asal ?? '-' }}</td></tr>
        </table>
    </div>

    <!-- ==================== DATA PENERIMAAN ==================== -->
    <div class="section">
        <div class="section-title">B. DATA PENERIMAAN</div>
        <table class="tabel-info">
            <tr><td class="label">1. Diterima di Sekolah Ini</td><td class="colon">:</td><td class="value">Pada tanggal {{ optional(\Carbon\Carbon::parse($siswa->tanggal_diterima))->translatedFormat('d F Y') ?? '-' }}</td></tr>
            <tr><td class="label">2. Ditempatkan di Kelas / Rombel</td><td class="colon">:</td><td class="value"><b>{{ $siswa->rombel->nama ?? '-' }}</b></td></tr>
        </table>
    </div>

    <!-- ==================== DATA ORANG TUA ==================== -->
    <div class="section">
        <div class="section-title">C. DATA ORANG TUA / WALI</div>
        
        <!-- AYAH -->
        <table class="tabel-info" style="margin-bottom: 10px;">
            <tr style="background: #e8e8e8;"><td colspan="3"><b>1. AYAH KANDUNG</b></td></tr>
            <tr><td class="label">a. Nama Ayah</td><td class="colon">:</td><td class="value">{{ $siswa->ayah->nama ?? '-' }}</td></tr>
            <tr><td class="label">b. Tempat, Tanggal Lahir</td><td class="colon">:</td><td class="value">{{ $siswa->ayah->tempat_lahir ?? '-' }}, {{ $siswa->ayah->tanggal_lahir ?? '-' }}</td></tr>
            <tr><td class="label">c. Pendidikan Terakhir</td><td class="colon">:</td><td class="value">{{ $siswa->ayah->pendidikan ?? '-' }}</td></tr>
            <tr><td class="label">d. Pekerjaan</td><td class="colon">:</td><td class="value">{{ $siswa->ayah->pekerjaan ?? '-' }}</td></tr>
            <tr><td class="label">e. Alamat</td><td class="colon">:</td><td class="value">{{ $siswa->ayah->alamat ?? '-' }}</td></tr>
            <tr><td class="label">f. Nomor Telepon</td><td class="colon">:</td><td class="value">{{ $siswa->ayah->telepon ?? '-' }}</td></tr>
        </table>

        <!-- IBU -->
        <table class="tabel-info" style="margin-bottom: 10px;">
            <tr style="background: #e8e8e8;"><td colspan="3"><b>2. IBU KANDUNG</b></td></tr>
            <tr><td class="label">a. Nama Ibu</td><td class="colon">:</td><td class="value">{{ $siswa->ibu->nama ?? '-' }}</td></tr>
            <tr><td class="label">b. Tempat, Tanggal Lahir</td><td class="colon">:</td><td class="value">{{ $siswa->ibu->tempat_lahir ?? '-' }}, {{ $siswa->ibu->tanggal_lahir ?? '-' }}</td></tr>
            <tr><td class="label">c. Pendidikan Terakhir</td><td class="colon">:</td><td class="value">{{ $siswa->ibu->pendidikan ?? '-' }}</td></tr>
            <tr><td class="label">d. Pekerjaan</td><td class="colon">:</td><td class="value">{{ $siswa->ibu->pekerjaan ?? '-' }}</td></tr>
            <tr><td class="label">e. Alamat</td><td class="colon">:</td><td class="value">{{ $siswa->ibu->alamat ?? '-' }}</td></tr>
            <tr><td class="label">f. Nomor Telepon</td><td class="colon">:</td><td class="value">{{ $siswa->ibu->telepon ?? '-' }}</td></tr>
        </table>

        <!-- WALI (jika ada) -->
        @if($siswa->wali && $siswa->wali->nama)
        <table class="tabel-info">
            <tr style="background: #e8e8e8;"><td colspan="3"><b>3. WALI (Jika Ada)</b></td></tr>
            <tr><td class="label">a. Nama Wali</td><td class="colon">:</td><td class="value">{{ $siswa->wali->nama ?? '-' }}</td></tr>
            <tr><td class="label">b. Pekerjaan</td><td class="colon">:</td><td class="value">{{ $siswa->wali->pekerjaan ?? '-' }}</td></tr>
            <tr><td class="label">c. Alamat</td><td class="colon">:</td><td class="value">{{ $siswa->wali->alamat ?? '-' }}</td></tr>
            <tr><td class="label">d. Nomor Telepon</td><td class="colon">:</td><td class="value">{{ $siswa->wali->telepon ?? '-' }}</td></tr>
        </table>
        @endif
    </div>

    <!-- ==================== TANDA TANGAN ==================== -->
    <div class="ttd-wrapper">
        <div class="ttd-kiri">
            <div class="ttd-jabatan">Mengetahui,</div>
            <div class="ttd-jabatan">Orang Tua/Wali</div>
            <div class="ttd-garis"></div>
            <div class="ttd-nama">
                @if($siswa->ayah && $siswa->ayah->nama)
                    ({{ $siswa->ayah->nama }})
                @else
                    (_________________________)
                @endif
            </div>
        </div>
        <div class="ttd-kanan">
            <div class="ttd-jabatan">Ciamis, {{ now()->translatedFormat('d F Y') }}</div>
            <div class="ttd-jabatan">Kepala Sekolah,</div>
            <div class="ttd-garis"></div>
            <div class="ttd-nama">CEPY WAHYUDIN, A.Md., S.Kom., M.Kom.</div>
            <div class="ttd-nama" style="font-size: 9pt; font-weight: normal;">NIP. 19342738121894378123</div>
        </div>
    </div>

    <!-- ==================== CATATAN WALI KELAS ==================== -->
    @if($siswa->catatan_wali_kelas)
    <div class="catatan-box">
        <div class="catatan-title">📝 CATATAN WALI KELAS :</div>
        <div style="font-style: italic;">{{ $siswa->catatan_wali_kelas }}</div>
    </div>
    @endif

    <div class="clearfix"></div>

    <!-- ==================== FOOTER ==================== -->
    <div class="footer">
        Dokumen ini adalah bukti resmi data diri peserta didik SMK Negeri 1 Ciamis | Dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }}
    </div>

</body>
</html>