@extends('layouts.app')

@section('title', 'Alumni - ' . $namaJurusan)

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('tu.alumni.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="mb-4">
        <h3>Alumni {{ $namaJurusan }}</h3>
        <small class="text-muted">Tahun Ajaran: {{ $tahun }}</small>
    </div>

    <div class="card shadow-sm">
        @if(count($alumni) > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 30%">Nama Siswa</th>
                            <th style="width: 12%">NIS</th>
                            <th style="width: 12%">NISN</th>
                            <th style="width: 15%">Kelas</th>
                            <th style="width: 15%">Rombel</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumni as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($data['siswa']->foto)
                                            <img src="{{ asset('storage/' . $data['siswa']->foto) }}" class="rounded-circle" width="32" height="32" alt="{{ $data['siswa']->nama_lengkap }}" style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px; font-weight: 600;">
                                                {{ strtoupper(substr($data['siswa']->nama_lengkap, 0, 1)) }}
                                            </div>
                                        @endif
                                        <strong>{{ $data['siswa']->nama_lengkap }}</strong>
                                    </div>
                                </td>
                                <td>{{ $data['siswa']->nis }}</td>
                                <td>{{ $data['siswa']->nisn }}</td>
                                <td><span class="badge bg-secondary">{{ $data['kelas'] }}</span></td>
                                <td>{{ $data['rombel'] }}</td>
                                <td>
                                    <a href="{{ route('tu.alumni.show', $data['siswa']->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info m-0">
                <i class="bi bi-info-circle"></i> Tidak ada alumni untuk jurusan ini pada tahun ajaran {{ $tahun }}.
            </div>
        @endif
    </div>
</div>

<style>
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }

    .table {
        border-radius: 8px;
    }

    .table thead th {
        background-color: #F8FAFC;
        color: #475569;
        font-weight: 600;
        font-size: 14px;
        padding: 12px 15px;
        border: none;
    }

    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-color: #E2E8F0;
    }

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.02);
    }
</style>
@endsection
