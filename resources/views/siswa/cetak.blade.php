<!DOCTYPE html>
<html>
<head>
    <title>Cetak Data Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; margin-bottom: 10px; }
        td { padding: 4px; vertical-align: top; }
        .judul { text-align:center; font-weight:bold; font-size:18px; margin-bottom:20px; }
        .foto { width: 120px; height: 150px; border: 1px solid #000; object-fit: cover; }
        .ttd { text-align: right; margin-top: 40px; }
    </style>
</head>
<body>

<div class="judul">KETERANGAN TENTANG DIRI PESERTA DIDIK</div>

<table>
    <tr><td width="35%">Nama Peserta Didik</td><td>: {{ $siswa->nama_lengkap }}</td></tr>
    <tr><td>Nomor Induk / NISN</td><td>: {{ $siswa->nis }} / {{ $siswa->nisn }}</td></tr>
    <tr><td>Tempat, Tanggal Lahir</td><td>: {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}</td></tr>
    <tr><td>Jenis Kelamin</td><td>: {{ $siswa->jenis_kelamin }}</td></tr>
    <tr><td>Agama</td><td>: {{ $siswa->agama }}</td></tr>
    <tr><td>Status dalam Keluarga</td><td>: {{ $siswa->status_keluarga }}</td></tr>
    <tr><td>Anak Ke</td><td>: {{ $siswa->anak_ke }}</td></tr>
    <tr><td>Alamat Peserta Didik</td><td>: {{ $siswa->alamat }}</td></tr>
    <tr><td>Nomor Telepon</td><td>: {{ $siswa->no_hp }}</td></tr>
    <tr><td>Sekolah Asal</td><td>: {{ $siswa->sekolah_asal }}</td></tr>
    <tr><td>Diterima di kelas</td><td>: {{ $siswa->kelas }}</td></tr>
    <tr><td>Pada tanggal</td><td>: {{ $siswa->tanggal_diterima }}</td></tr>

    <tr><td>Nama Ayah</td><td>: {{ $siswa->nama_ayah }}</td></tr>
    <tr><td>Pekerjaan Ayah</td><td>: {{ $siswa->pekerjaan_ayah }}</td></tr>
    <tr><td>Telepon Ayah</td><td>: {{ $siswa->telepon_ayah }}</td></tr>

    <tr><td>Nama Ibu</td><td>: {{ $siswa->nama_ibu }}</td></tr>
    <tr><td>Pekerjaan Ibu</td><td>: {{ $siswa->pekerjaan_ibu }}</td></tr>
    <tr><td>Telepon Ibu</td><td>: {{ $siswa->telepon_ibu }}</td></tr>

    <tr><td>Nama Wali</td><td>: {{ $siswa->nama_wali }}</td></tr>
    <tr><td>Alamat Wali</td><td>: {{ $siswa->alamat_wali }}</td></tr>
    <tr><td>Telepon Wali</td><td>: {{ $siswa->telepon_wali }}</td></tr>
    <tr><td>Pekerjaan Wali</td><td>: {{ $siswa->pekerjaan_wali }}</td></tr>
</table>

<br><br>

<div style="display:flex; justify-content:space-between;">
    <div>
        @if($siswa->foto)
            <img src="{{ public_path('storage/'.$siswa->foto) }}" class="foto">
        @else
            <div class="foto"></div>
        @endif
    </div>

    <div class="ttd">
        Ciamis, {{ now()->format('d F Y') }} <br>
        Kepala Sekolah <br><br><br><br>
        <u>....................................</u><br>
        NIP: ..................................
    </div>
</div>

</body>
</html>
