@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Pegawai</h2>
    <a href="{{ route('pegawai.create') }}" class="btn btn-primary mb-3">Tambah Pegawai</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP/NUPTK</th>
                <th>Jabatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawais as $index => $pegawai)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pegawai->nama_lengkap }}</td>
                <td>{{ $pegawai->nip_nuptk }}</td>
                <td>{{ $pegawai->jabatan }}</td>
                <td>
                    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection