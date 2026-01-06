@extends('layouts.app')

@section('title', 'Data Alumni')

@section('content')
<div class="container py-3">
    <h3>Data Alumni</h3>

    @if($siswas->isEmpty())
        <p>Tidak ada alumni.</p>
    @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswas as $i => $siswa)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $siswa->nama_lengkap }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td><a href="{{ route('tu.alumni.show', $siswa->id) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
