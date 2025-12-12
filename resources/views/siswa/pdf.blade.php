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
    <tr><td>2. NIS / NISN</td><td>: {{ $siswa->nis }} / {{ $siswa->nisn }}</td></tr>
    <tr><td>3. Tempat, Tanggal Lahir</td><td>: {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}</td></tr>
    <tr><td>4. Jenis Kelamin</td><td>: {{ $siswa->jenis_kelamin }}</td></tr>
    <tr><td>5. Agama</td><td>: {{ $siswa->agama }}</td></tr>
    <tr><td>6. Status dalam Keluarga</td><td>: {{ $siswa->status_keluarga }}</td></tr>
    <tr><td>7. Anak Ke</td><td>: {{ $siswa->anak_ke }}</td></tr>
    <tr><td>8. Alamat</td><td>: {{ $siswa->alamat }}</td></tr>

    <tr><td>9. Nomor Telepon</td><td>: {{ $siswa->no_hp }}</td></tr>
    <tr><td>10. Sekolah Asal</td><td>: {{ $siswa->sekolah_asal }}</td></tr>
    <tr><td>11. Diterima di kelas</td><td>: {{ $siswa->kelas }}</td></tr>
    <tr><td>12. Tanggal Diterima</td><td>: {{ $siswa->tanggal_diterima }}</td></tr>

    <tr><td>13. Nama Ayah</td><td>: {{ $siswa->nama_ayah }}</td></tr>
    <tr><td>Pekerjaan Ayah</td><td>: {{ $siswa->pekerjaan_ayah }}</td></tr>
    <tr><td>Telepon Ayah</td><td>: {{ $siswa->telepon_ayah }}</td></tr>

    <tr><td>14. Nama Ibu</td><td>: {{ $siswa->nama_ibu }}</td></tr>
    <tr><td>Pekerjaan Ibu</td><td>: {{ $siswa->pekerjaan_ibu }}</td></tr>
    <tr><td>Telepon Ibu</td><td>: {{ $siswa->telepon_ibu }}</td></tr>

    <tr><td>15. Nama Wali</td><td>: {{ $siswa->nama_wali }}</td></tr>
    <tr><td>Alamat Wali</td><td>: {{ $siswa->alamat_wali }}</td></tr>
    <tr><td>Telepon Wali</td><td>: {{ $siswa->telepon_wali }}</td></tr>
    <tr><td>Pekerjaan Wali</td><td>: {{ $siswa->pekerjaan_wali }}</td></tr>
</table>

<br><br>

@if($siswa->foto)
    @php $fotoPath = public_path('storage/' . $siswa->foto); @endphp
    @if(file_exists($fotoPath))
        <img src="{{ $fotoPath }}" class="photo">
    @endif
@endif

</body>
</html>
