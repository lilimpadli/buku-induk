@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">View Data Siswa</h3>
    <p class="text-muted">Kelola data siswa dengan mudah. Anda dapat melihat informasi lengkap siswa.</p>

    <div class="card shadow mb-4 p-3">
        <div class="d-flex align-items-center">

            <img src="https://ui-avatars.com/api/?name={{ urlencode($s->nama_lengkap) }}"
                 class="rounded-circle me-3" width="70">

            <div>
                <h5 class="mb-0">{{ $s->nama_lengkap }}</h5>
                <small>NIS: {{ $s->nis }}</small><br>
                <small>NISN: {{ $s->nisn }}</small><br>
                <small>Kelas: {{ $s->kelas }}</small>
            </div>
        </div>
    </div>

    <div class="card shadow p-3">
        <h5 class="mb-3">Informasi Pribadi Siswa</h5>

        <table class="table table-bordered">
            <tr>
                <th>Nama Lengkap</th>
                <td>{{ $s->nama_lengkap }}</td>

                <th>Jenis Kelamin</th>
                <td>{{ $s->jenis_kelamin }}</td>
            </tr>

            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $s->tanggal_lahir }}</td>

                <th>Agama</th>
                <td>{{ $s->agama }}</td>
            </tr>

            <tr>
                <th>Alamat</th>
                <td colspan="3">{{ $s->alamat }}</td>
            </tr>

            <tr>
                <th>Nama Ayah</th>
                <td>{{ $s->nama_ayah }}</td>

                <th>Nama Ibu</th>
                <td>{{ $s->nama_ibu }}</td>
            </tr>

            <tr>
                <th>Pekerjaan Ayah</th>
                <td>{{ $s->pekerjaan_ayah }}</td>

                <th>Pekerjaan Ibu</th>
                <td>{{ $s->pekerjaan_ibu }}</td>
            </tr>

            <tr>
                <th>Nama Wali</th>
                <td>{{ $s->nama_wali }}</td>

                <th>Pekerjaan Wali</th>
                <td>{{ $s->pekerjaan_wali }}</td>
            </tr>

        </table>
    </div>

</div>
@endsection
