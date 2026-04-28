@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Daftar Program Keahlian</h1>
    <a href="{{ route('kurikulum.program-keahlian.create') }}" class="btn btn-primary mb-3">Tambah Program Keahlian</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jurusans as $jurusan)
            <tr>
                <td>{{ $jurusan->kode }}</td>
                <td>{{ $jurusan->nama }}</td>
                <td>
                    <a href="{{ route('kurikulum.program-keahlian.edit', $jurusan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('kurikulum.program-keahlian.destroy', $jurusan->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
