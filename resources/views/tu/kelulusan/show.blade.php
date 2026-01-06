@extends('layouts.app')

@section('title', 'Daftar Siswa Lulus')

@section('content')
<div class="container py-3">
    <h3>Daftar Siswa Lulus — Tahun Ajaran: {{ $tahun }}</h3>

    @if($items->isEmpty())
        <p>Tidak ada siswa untuk rombel ini.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>NIS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ optional($row->siswa)->nama_lengkap ?? '-' }}</td>
                        <td>{{ optional($row->siswa)->nis ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
