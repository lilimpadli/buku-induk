<!DOCTYPE html>
<html>
<head>
    <style>
    @page {
        size: A4;
        margin: 30px;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        background: #e5e5e5;
        margin: 0;
        padding: 30px;
    }

    .title {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 25px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        line-height: 1.6;
    }

    td {
        padding: 2px 0;
        vertical-align: top;
    }

    .no {
        width: 4%;
        text-align: right;
        padding-right: 6px;
    }

    .label {
        width: 36%;
    }

    .colon {
        width: 2%;
        text-align: center;
    }

    .value {
        width: 58%;
        text-align: left;
    }

    .photo {
        width: 100px;
        height: 130px;
        object-fit: cover;
    }

    .footer {
        margin-top: 35px;
        position: relative;
        width: 100%;
    }

    .ttd {
        position: absolute;
        right: 0;
        top: 0;
        text-align: left;
        line-height: 1.6;
        margin-top: 48px; /* ≈ 3x enter */
    }
</style>
</head>
<body>

<div class="container">

    <div class="title">KETERANGAN TENTANG DIRI PESERTA DIDIK</div>

    <table>
        <tr><td class="label">1. Nama Peserta Didik (Lengkap)</td><td class="colon">:</td><td class="value">{{ $siswa->nama_lengkap }}</td></tr>
        <tr><td class="label">2. Nomor Induk / NISN</td><td class="colon">:</td><td class="value">{{ $siswa->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</td></tr>
        <tr><td class="label">3. Tempat, Tanggal Lahir</td><td class="colon">:</td><td class="value">{{ $siswa->tempat_lahir ?? '-' }}, {{ optional(\Carbon\Carbon::parse($siswa->tanggal_lahir))->translatedFormat('d F Y') ?? '-' }}</td></tr>
        <tr><td class="label">4. Jenis Kelamin</td><td class="colon">:</td><td class="value">{{ $siswa->jenis_kelamin ?? '-' }}</td></tr>
        <tr><td class="label">5. Agama</td><td class="colon">:</td><td class="value">{{ $siswa->agama ?? '-' }}</td></tr>
        <tr><td class="label">6. Status Dalam Keluarga</td><td class="colon">:</td><td class="value">{{ $siswa->status_keluarga ?? '-' }}</td></tr>
        <tr><td class="label">7. Anak Ke</td><td class="colon">:</td><td class="value">{{ $siswa->anak_ke ?? '-' }}</td></tr>
        <tr><td class="label">8. Alamat Peserta Didik</td><td class="colon">:</td><td class="value">{{ $siswa->alamat ?? '-' }}</td></tr>
        <tr><td class="label">9. Nomor Telepon Rumah</td><td class="colon">:</td><td class="value">{{ $siswa->no_hp ?? '-' }}</td></tr>
        <tr><td class="label">10. Sekolah Asal</td><td class="colon">:</td><td class="value">{{ $siswa->sekolah_asal ?? '-' }}</td></tr>

        <tr><td class="label">11. Diterima di sekolah ini</td><td class="colon">:</td><td class="value"></td></tr>
        <tr><td class="label">&nbsp;&nbsp;&nbsp;Di kelas</td><td class="colon">:</td><td class="value">{{ $siswa->rombel->nama ?? ($siswa->kelas ?? '-') }}</td></tr>
        <tr><td class="label">&nbsp;&nbsp;&nbsp;Pada tanggal</td><td class="colon">:</td><td class="value">{{ optional(\Carbon\Carbon::parse($siswa->tanggal_diterima))->translatedFormat('d F Y') ?? '-' }}</td></tr>

        <tr><td class="label">Nama Orang Tua</td><td class="colon">:</td><td class="value"></td></tr>
        <tr><td class="label">&nbsp;&nbsp;&nbsp;a. Ayah</td><td class="colon">:</td><td class="value">{{ $siswa->ayah->nama ?? '-' }}</td></tr>
        <tr><td class="label">&nbsp;&nbsp;&nbsp;b. Ibu</td><td class="colon">:</td><td class="value">{{ $siswa->ibu->nama ?? '-' }}</td></tr>

        <tr><td class="label">12. Alamat Orang Tua</td><td class="colon">:</td><td class="value">{{ $siswa->alamat ?? '-' }}</td></tr>
        <tr><td class="label">Nomor Telepon Rumah</td><td class="colon">:</td><td class="value">{{ $siswa->no_hp ?? '-' }}</td></tr>

        <tr><td class="label">13. Pekerjaan Orang Tua</td><td class="colon">:</td><td class="value"></td></tr>
        <tr><td class="label">&nbsp;&nbsp;&nbsp;a. Ayah</td><td class="colon">:</td><td class="value">{{ $siswa->ayah->pekerjaan ?? '-' }}</td></tr>
        <tr><td class="label">&nbsp;&nbsp;&nbsp;b. Ibu</td><td class="colon">:</td><td class="value">{{ $siswa->ibu->pekerjaan ?? '-' }}</td></tr>

        <tr><td class="label">14. Nama Wali Peserta Didik</td><td class="colon">:</td><td class="value">{{ $siswa->wali->nama ?? '-' }}</td></tr>
        <tr><td class="label">15. Alamat Wali Peserta Didik</td><td class="colon">:</td><td class="value">{{ $siswa->wali->alamat ?? '-' }}</td></tr>
        <tr><td class="label">Nomor Telepon Rumah</td><td class="colon">:</td><td class="value">{{ $siswa->wali->telepon ?? '-' }}</td></tr>
        <tr><td class="label">16. Pekerjaan Wali Peserta Didik</td><td class="colon">:</td><td class="value">{{ $siswa->wali->pekerjaan ?? '-' }}</td></tr>
    </table>

    <div class="footer">
        <div class="photo-box">
            @if($siswa->foto)
                @php
                    $diskPath = storage_path('app/public/' . $siswa->foto);
                    $imgData = null;
                    if (file_exists($diskPath)) {
                        $type = pathinfo($diskPath, PATHINFO_EXTENSION);
                        $data = file_get_contents($diskPath);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        $imgData = $base64;
                    }
                @endphp
                @if(!empty($imgData))
                    <img src="{{ $imgData }}" class="photo">
                @endif
            @endif
        </div>

        <div class="ttd">
            Ciamis, {{ optional(\Carbon\Carbon::parse($siswa->tanggal_diterima))->translatedFormat('d F Y') ?? '-' }}<br>
            Kepala Sekolah<br><br><br>
            <b>CEPY WAHYUDIN, A.Md., S.Kom., M.Kom.</b><br>
            NIP. 19342738121894378123
        </div>
    </div>

</div>

</body>
</html>
