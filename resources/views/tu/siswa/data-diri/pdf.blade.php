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

    .container {
        max-width: 100%;
        background: white;
        padding: 30px;
        border-radius: 5px;
    }

    .title {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 25px;
        text-decoration: underline;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        line-height: 1.8;
    }

    td {
        padding: 3px 0;
        vertical-align: top;
    }

    .no {
        width: 4%;
        text-align: right;
        padding-right: 6px;
    }

    .label {
        width: 36%;
        font-weight: normal;
    }

    .colon {
        width: 2%;
        text-align: center;
    }

    .value {
        width: 58%;
        text-align: left;
    }

    .photo-box {
        float: left;
        width: 120px;
        height: 150px;
        border: 1px solid #000;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .photo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-box .no-photo {
        color: #999;
        font-size: 12px;
    }

    .footer {
        margin-top: 35px;
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .ttd {
        float: right;
        text-align: center;
        line-height: 1.8;
        margin-top: 20px;
    }

    .ttd .nama {
        margin-top: 40px;
        font-weight: bold;
        text-decoration: underline;
    }

    .ttd .nip {
        font-size: 11px;
        margin-top: 2px;
    }

    .clearfix {
        clear: both;
    }

    .text-center {
        text-align: center;
    }

    .label-bold {
        font-weight: bold;
    }

    .section-title {
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 5px;
        font-size: 13px;
        text-decoration: underline;
    }
    </style>
</head>
<body>

<div class="container">

    <div class="title">KETERANGAN TENTANG DIRI PESERTA DIDIK</div>

    <!-- FOTO -->
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
                <img src="{{ $imgData }}" alt="Foto {{ $siswa->nama_lengkap }}">
            @else
                <span class="no-photo">Tidak ada foto</span>
            @endif
        @else
            <span class="no-photo">Tidak ada foto</span>
        @endif
    </div>

    <!-- DATA SISWA -->
    <table>
        <tr>
            <td class="label">1. Nama Peserta Didik (Lengkap)</td>
            <td class="colon">:</td>
            <td class="value"><strong>{{ $siswa->nama_lengkap ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td class="label">2. Nomor Induk / NISN</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">3. Tempat, Tanggal Lahir</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="label">4. Jenis Kelamin</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->jenisKelamin->nama ?? $siswa->jenis_kelamin ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">5. Agama</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->agama->nama ?? $siswa->agama_lainnya ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">6. Status Dalam Keluarga</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->status_keluarga ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">7. Anak Ke</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->anak_ke ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">8. Alamat Peserta Didik</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">9. Nomor Telepon Rumah</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->no_hp ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">10. Sekolah Asal</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->sekolah_asal ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">11. Diterima di sekolah ini</td>
            <td class="colon">:</td>
            <td class="value"></td>
        </tr>
        <tr>
            <td class="label">&nbsp;&nbsp;&nbsp;Di kelas</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->rombel->nama ?? ($siswa->kelas ?? '-') }}</td>
        </tr>
        <tr>
            <td class="label">&nbsp;&nbsp;&nbsp;Pada tanggal</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->translatedFormat('d F Y') : '-' }}</td>
        </tr>

        <tr>
            <td class="label" style="padding-top:10px;"><strong>Nama Orang Tua</strong></td>
            <td class="colon" style="padding-top:10px;">:</td>
            <td class="value" style="padding-top:10px;"></td>
        </tr>
        <tr>
            <td class="label">&nbsp;&nbsp;&nbsp;a. Ayah</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->ayah->nama ?? $siswa->nama_ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">&nbsp;&nbsp;&nbsp;b. Ibu</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->ibu->nama ?? $siswa->nama_ibu ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">12. Alamat Orang Tua</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">&nbsp;&nbsp;&nbsp;Nomor Telepon</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->no_hp ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">13. Pekerjaan Orang Tua</td>
            <td class="colon">:</td>
            <td class="value"></td>
        </tr>
        <tr>
            <td class="label">&nbsp;&nbsp;&nbsp;a. Ayah</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->ayah->pekerjaan ?? $siswa->pekerjaan_ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">&nbsp;&nbsp;&nbsp;b. Ibu</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->ibu->pekerjaan ?? $siswa->pekerjaan_ibu ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">14. Nama Wali Peserta Didik</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->wali->nama ?? $siswa->nama_wali ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">15. Alamat Wali Peserta Didik</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->wali->alamat ?? $siswa->alamat_wali ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">&nbsp;&nbsp;&nbsp;Nomor Telepon</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->wali->telepon ?? $siswa->telepon_wali ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">16. Pekerjaan Wali Peserta Didik</td>
            <td class="colon">:</td>
            <td class="value">{{ $siswa->wali->pekerjaan ?? $siswa->pekerjaan_wali ?? '-' }}</td>
        </tr>
    </table>

    <!-- TTD -->
    <div class="footer">
        <div class="ttd">
            <div>Ciamis, {{ now()->translatedFormat('d F Y') }}</div>
            <div>Kepala Sekolah</div>
            <div class="nama">CEPY WAHYUDIN, A.Md., S.Kom., M.Kom.</div>
            <div class="nip">NIP. 19342738121894378123</div>
        </div>
        <div class="clearfix"></div>
    </div>

</div>

</body>
</html>