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

            <div class="mb-3">
                <div class="btn-group" role="group" aria-label="Tingkat filter">
                    <a href="{{ route('kurikulum.mata-pelajaran.index') }}" class="btn {{ empty($tingkat) ? 'btn-primary' : 'btn-outline-secondary' }}">Semua</a>
                    <a href="{{ route('kurikulum.mata-pelajaran.index', ['tingkat' => 10]) }}" class="btn {{ (string)($tingkat ?? '') === '10' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas 10</a>
                    <a href="{{ route('kurikulum.mata-pelajaran.index', ['tingkat' => 11]) }}" class="btn {{ (string)($tingkat ?? '') === '11' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas 11</a>
                    <a href="{{ route('kurikulum.mata-pelajaran.index', ['tingkat' => 12]) }}" class="btn {{ (string)($tingkat ?? '') === '12' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas 12</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kelompok</th>
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
                            <td>{{ ($m->tingkats ?? collect())->pluck('tingkat')->implode(', ') }}</td>
                            <td>{{ $m->urutan }}</td>
                            <td>
                                <a href="{{ route('kurikulum.mata-pelajaran.edit', $m->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('kurikulum.mata-pelajaran.destroy', $m->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Hapus mata pelajaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
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
