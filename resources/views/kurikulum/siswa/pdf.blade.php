<!DOCTYPE html>
<html>
<head>
    <style>
        @page { size: A4; margin: 30px; }
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 30px; }
        .title { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; line-height: 1.6; }
        td { padding: 2px 0; vertical-align: top; }
        .label { width: 35%; font-weight: bold; }
        .colon { width: 2%; text-align: center; }
        .value { width: 63%; }
        .photo { width: 100px; height: 130px; object-fit: cover; }
        .footer { margin-top: 35px; position: relative; width: 100%; }
        .ttd { position: absolute; right: 0; top: 0; text-align: left; line-height: 1.6; margin-top: 48px; }
    </style>
</head>
<body>
    <div class="title">KETERANGAN TENTANG DIRI PESERTA DIDIK</div>

    <table>
        <tr><td class="label">1. Nama Peserta Didik (Lengkap)</td><td class="colon">:</td><td class="value">{{ $siswa->nama_lengkap }}</td></tr>
        <tr><td class="label">2. Nomor Induk / NISN</td><td class="colon">:</td><td class="value">{{ $siswa->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</td></tr>
        <tr><td class="label">3. Tempat, Tanggal Lahir</td><td class="colon">:</td><td class="value">{{ $siswa->tempat_lahir ?? '-' }}, {{ optional(\Carbon\Carbon::parse($siswa->tanggal_lahir))->translatedFormat('d F Y') ?? '-' }}</td></tr>
        <tr><td class="label">4. Jenis Kelamin</td><td class="colon">:</td><td class="value">{{ $siswa->jenis_kelamin ?? '-' }}</td></tr>
        <tr><td class="label">5. Agama</td><td class="colon">:</td><td class="value">{{ $siswa->agama ?? '-' }}</td></tr>
        <tr><td class="label">6. Kewarganegaraan</td><td class="colon">:</td><td class="value">{{ $siswa->kewarganegaraan ?? '-' }}</td></tr>
        <tr><td class="label">7. Alamat</td><td class="colon">:</td><td class="value">{{ $siswa->alamat ?? '-' }}</td></tr>
        <tr><td class="label">8. No HP</td><td class="colon">:</td><td class="value">{{ $siswa->no_hp ?? '-' }}</td></tr>
        <tr><td class="label">9. Sekolah Asal</td><td class="colon">:</td><td class="value">{{ $siswa->sekolah_asal ?? '-' }}</td></tr>
        <tr><td class="label">10. Kelas / Rombel</td><td class="colon">:</td><td class="value">{{ optional($siswa->rombel)->nama ?? '-' }}</td></tr>
        <tr><td class="label">11. Nama Ayah</td><td class="colon">:</td><td class="value">{{ $siswa->ayah->nama ?? '-' }}</td></tr>
        <tr><td class="label">12. Pekerjaan Ayah</td><td class="colon">:</td><td class="value">{{ $siswa->ayah->pekerjaan ?? '-' }}</td></tr>
        <tr><td class="label">13. Nama Ibu</td><td class="colon">:</td><td class="value">{{ $siswa->ibu->nama ?? '-' }}</td></tr>
        <tr><td class="label">14. Pekerjaan Ibu</td><td class="colon">:</td><td class="value">{{ $siswa->ibu->pekerjaan ?? '-' }}</td></tr>
        <tr><td class="label">15. Nama Wali</td><td class="colon">:</td><td class="value">{{ $siswa->wali->nama ?? '-' }}</td></tr>
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