<!DOCTYPE html>
<html>
<head>
    <style>
        @page { size: A4; margin: 30px; }
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 30px; }
        .title { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; line-height: 1.6; }
        td { padding: 4px 0; vertical-align: top; }
        .label { width: 30%; font-weight: bold; }
        .colon { width: 2%; text-align: center; }
        .value { width: 68%; }
        .section-title { font-size: 14px; font-weight: bold; margin-top: 20px; margin-bottom: 10px; border-bottom: 1px solid #000; padding-bottom: 5px; }
        .photo { width: 100px; height: 130px; object-fit: cover; }
        .footer { margin-top: 40px; }
        .ttd { text-align: right; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="title">DATA LENGKAP PESERTA DIDIK</div>

    <div class="section-title">A. Identitas Siswa</div>
    <table>
        <tr><td class="label">Nama Lengkap</td><td class="colon">:</td><td class="value">{{ $siswa->nama_lengkap }}</td></tr>
        <tr><td class="label">NIS / NISN</td><td class="colon">:</td><td class="value">{{ $siswa->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</td></tr>
        <tr><td class="label">Tempat, Tanggal Lahir</td><td class="colon">:</td><td class="value">{{ $siswa->tempat_lahir ?? '-' }}, {{ optional(\Carbon\Carbon::parse($siswa->tanggal_lahir))->translatedFormat('d F Y') ?? '-' }}</td></tr>
        <tr><td class="label">Jenis Kelamin</td><td class="colon">:</td><td class="value">{{ $siswa->jenis_kelamin ?? '-' }}</td></tr>
        <tr><td class="label">Agama</td><td class="colon">:</td><td class="value">{{ $siswa->agama ?? '-' }}</td></tr>
        <tr><td class="label">Alamat</td><td class="colon">:</td><td class="value">{{ $siswa->alamat ?? '-' }}</td></tr>
        <tr><td class="label">No HP</td><td class="colon">:</td><td class="value">{{ $siswa->no_hp ?? '-' }}</td></tr>
        <tr><td class="label">Kelas / Rombel</td><td class="colon">:</td><td class="value">{{ optional($siswa->rombel)->nama ?? '-' }}</td></tr>
    </table>

    <div class="section-title">B. Data Orang Tua</div>
    <table>
        <tr><td class="label">Nama Ayah</td><td class="colon">:</td><td class="value">{{ $siswa->ayah->nama ?? '-' }}</td></tr>
        <tr><td class="label">Pekerjaan Ayah</td><td class="colon">:</td><td class="value">{{ $siswa->ayah->pekerjaan ?? '-' }}</td></tr>
        <tr><td class="label">Telepon Ayah</td><td class="colon">:</td><td class="value">{{ $siswa->ayah->telepon ?? '-' }}</td></tr>
        <tr><td class="label">Nama Ibu</td><td class="colon">:</td><td class="value">{{ $siswa->ibu->nama ?? '-' }}</td></tr>
        <tr><td class="label">Pekerjaan Ibu</td><td class="colon">:</td><td class="value">{{ $siswa->ibu->pekerjaan ?? '-' }}</td></tr>
        <tr><td class="label">Telepon Ibu</td><td class="colon">:</td><td class="value">{{ $siswa->ibu->telepon ?? '-' }}</td></tr>
    </table>

    <div class="section-title">C. Data Wali</div>
    <table>
        <tr><td class="label">Nama Wali</td><td class="colon">:</td><td class="value">{{ $siswa->wali->nama ?? '-' }}</td></tr>
        <tr><td class="label">Pekerjaan Wali</td><td class="colon">:</td><td class="value">{{ $siswa->wali->pekerjaan ?? '-' }}</td></tr>
        <tr><td class="label">Telepon Wali</td><td class="colon">:</td><td class="value">{{ $siswa->wali->telepon ?? '-' }}</td></tr>
    </table>

    <div class="footer">
        <div class="ttd">
            Ciamis, {{ date('d F Y') }}<br>
            Kepala Sekolah<br><br><br>
            <b>CEPY WAHYUDIN, A.Md., S.Kom., M.Kom.</b><br>
            NIP. 19342738121894378123
        </div>
    </div>
</body>
</html>