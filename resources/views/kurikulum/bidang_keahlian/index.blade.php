@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Daftar Bidang Keahlian</h1>
    <a href="{{ route('kurikulum.bidang-keahlian.create') }}" class="btn btn-primary mb-3">Tambah Bidang Keahlian</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Keahlian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bidang as $b)
            <tr>
                <td>{{ $b->nama_keahlian }}</td>
                <td>
                    <a href="{{ route('kurikulum.bidang-keahlian.edit', $b->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('kurikulum.bidang-keahlian.destroy', $b->id) }}" method="POST" style="display:inline-block">
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
