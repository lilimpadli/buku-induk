<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 4px; vertical-align: top; }
        .title { text-align: center; font-size: 18px; margin-bottom: 20px; }
        .photo { width: 100px; height: 130px; object-fit: cover; }
    </style>
</head>
<body>

<div class="title"><b>KETERANGAN TENTANG DIRI PESERTA DIDIK</b></div>

<table>
    <tr><td>1. Nama Peserta Didik</td><td>: {{ $siswa->nama_lengkap }}</td></tr>
    <tr><td>2. NIS / NISN</td><td>: {{ $siswa->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</td></tr>
    <tr><td>3. Tempat, Tanggal Lahir</td><td>: {{ $siswa->tempat_lahir ?? '-' }}, {{ optional(\Carbon\Carbon::parse($siswa->tanggal_lahir))->translatedFormat('d F Y') ?? '-' }}</td></tr>
    <tr><td>4. Jenis Kelamin</td><td>: {{ $siswa->jenis_kelamin ?? '-' }}</td></tr>
    <tr><td>5. Agama</td><td>: {{ $siswa->agama ?? '-' }}</td></tr>
    <tr><td>6. Status dalam Keluarga</td><td>: {{ $siswa->status_keluarga ?? '-' }}</td></tr>
    <tr><td>7. Anak Ke</td><td>: {{ $siswa->anak_ke ?? '-' }}</td></tr>
    <tr><td>8. Alamat</td><td>: {{ $siswa->alamat ?? '-' }}</td></tr>

    <tr><td>9. Nomor Telepon</td><td>: {{ $siswa->no_hp ?? '-' }}</td></tr>
    <tr><td>10. Sekolah Asal</td><td>: {{ $siswa->sekolah_asal ?? '-' }}</td></tr>
    <tr><td>11. Diterima di kelas</td><td>: {{ $siswa->rombel->nama ?? ($siswa->kelas ?? '-') }}</td></tr>
    <tr><td>12. Tanggal Diterima</td><td>: {{ optional(\Carbon\Carbon::parse($siswa->tanggal_diterima))->translatedFormat('d F Y') ?? '-' }}</td></tr>

    <tr><td>13. Nama Ayah</td><td>: {{ $siswa->ayah->nama ?? '-' }}</td></tr>
    <tr><td>Pekerjaan Ayah</td><td>: {{ $siswa->ayah->pekerjaan ?? '-' }}</td></tr>
    <tr><td>Telepon Ayah</td><td>: {{ $siswa->ayah->telepon ?? '-' }}</td></tr>

    <tr><td>14. Nama Ibu</td><td>: {{ $siswa->ibu->nama ?? '-' }}</td></tr>
    <tr><td>Pekerjaan Ibu</td><td>: {{ $siswa->ibu->pekerjaan ?? '-' }}</td></tr>
    <tr><td>Telepon Ibu</td><td>: {{ $siswa->ibu->telepon ?? '-' }}</td></tr>

    <tr><td>15. Nama Wali</td><td>: {{ $siswa->wali->nama ?? '-' }}</td></tr>
    <tr><td>Alamat Wali</td><td>: {{ $siswa->wali->alamat ?? '-' }}</td></tr>
    <tr><td>Telepon Wali</td><td>: {{ $siswa->wali->telepon ?? '-' }}</td></tr>
    <tr><td>Pekerjaan Wali</td><td>: {{ $siswa->wali->pekerjaan ?? '-' }}</td></tr>
</table>

<br><br>

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

</body>
</html>
