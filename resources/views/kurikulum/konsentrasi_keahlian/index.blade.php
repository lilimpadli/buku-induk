@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Daftar Konsentrasi Keahlian</h1>
    <a href="{{ route('kurikulum.konsentrasi-keahlian.create') }}" class="btn btn-primary mb-3">Tambah Konsentrasi Keahlian</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Konsentrasi</th>
                <th>Bidang Keahlian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($konsentrasi as $k)
            <tr>
                <td>{{ $k->nama_konsentrasi }}</td>
                <td>{{ $k->bidang->nama_keahlian ?? '-' }}</td>
                <td>
                    <a href="{{ route('kurikulum.konsentrasi-keahlian.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('kurikulum.konsentrasi-keahlian.destroy', $k->id) }}" method="POST" style="display:inline-block">
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
