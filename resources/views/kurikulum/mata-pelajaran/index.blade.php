@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Mata Pelajaran</h5>
            <a href="{{ route('kurikulum.mata-pelajaran.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-3 d-flex gap-2 align-items-center">
                <form method="GET" class="d-flex align-items-center gap-2" action="{{ route('kurikulum.mata-pelajaran.index') }}">
                    <select name="jurusan" class="form-select" style="width:220px">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id }}" {{ (string)($jurusan ?? '') === (string)$j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                        @endforeach
                    </select>

                    <div class="btn-group" role="group" aria-label="Tingkat filter">
                        <a href="{{ route('kurikulum.mata-pelajaran.index', array_filter(['jurusan' => $jurusan])) }}" class="btn {{ empty($tingkat) ? 'btn-primary' : 'btn-outline-secondary' }}">Semua</a>
                        <a href="{{ route('kurikulum.mata-pelajaran.index', array_merge(array_filter(['jurusan' => $jurusan]), ['tingkat' => 10])) }}" class="btn {{ (string)($tingkat ?? '') === '10' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas 10</a>
                        <a href="{{ route('kurikulum.mata-pelajaran.index', array_merge(array_filter(['jurusan' => $jurusan]), ['tingkat' => 11])) }}" class="btn {{ (string)($tingkat ?? '') === '11' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas 11</a>
                        <a href="{{ route('kurikulum.mata-pelajaran.index', array_merge(array_filter(['jurusan' => $jurusan]), ['tingkat' => 12])) }}" class="btn {{ (string)($tingkat ?? '') === '12' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas 12</a>
                    </div>

                    <button class="btn btn-primary" type="submit">Terapkan</button>
                    <a href="{{ route('kurikulum.mata-pelajaran.index') }}" class="btn btn-outline-secondary">Reset</a>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kelompok</th>
                            <th>Jurusan</th>
                            <th>Tingkat</th>
                            <th>Urutan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mapels as $m)
                        <tr>
                            <td>{{ $m->nama }}</td>
                            <td>{{ $m->kelompok }}</td>
                            <td>{{ optional($m->jurusan)->nama ?? '-' }}</td>
                            <td>{{ ($m->tingkats ?? collect())->pluck('tingkat')->implode(', ') }}</td>
                            <td>{{ $m->urutan }}</td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <a href="{{ route('kurikulum.mata-pelajaran.edit', $m->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('kurikulum.mata-pelajaran.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus mata pelajaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center">Belum ada mata pelajaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection