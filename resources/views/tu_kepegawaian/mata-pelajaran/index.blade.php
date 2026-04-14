@extends('layouts.app')

@section('title', 'Daftar Mata Pelajaran TU Kepegawaian')

@section('content')
<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Daftar Mata Pelajaran TU Kepegawaian</h3>
        <a href="{{ route('tu_kepegawaian.mata-pelajaran.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Mata Pelajaran
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tu_kepegawaian.mata-pelajaran.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Cari Mata Pelajaran</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama mata pelajaran..." value="{{ $search ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kurikulum</label>
                    <select name="kurikulum_id" class="form-select">
                        <option value="">Semua Kurikulum</option>
                        @foreach($kurikulums as $k)
                            <option value="{{ $k->id }}" {{ (isset($kurikulum_id) && $kurikulum_id == $k->id) ? 'selected' : '' }}>{{ $k->nama_kurikulum }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kelompok</label>
                    <select name="kelompok" class="form-select">
                        <option value="">Semua</option>
                        <option value="A" {{ (isset($kelompok) && $kelompok == 'A') ? 'selected' : '' }}>A</option>
                        <option value="B" {{ (isset($kelompok) && $kelompok == 'B') ? 'selected' : '' }}>B</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-secondary">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kelompok</th>
                            <th>Urutan</th>
                            <th>Kurikulum</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mataPelajarans as $mapel)
                            <tr>
                                <td>{{ $loop->iteration + ($mataPelajarans->currentPage() - 1) * $mataPelajarans->perPage() }}</td>
                                <td>{{ $mapel->nama }}</td>
                                <td>
                                    <span class="badge bg-{{ $mapel->kelompok == 'A' ? 'primary' : 'success' }}">
                                        {{ $mapel->kelompok }}
                                    </span>
                                </td>
                                <td>{{ $mapel->urutan ?? '-' }}</td>
                                <td>
                                    @if($mapel->kurikulums->count() > 0)
                                        @foreach($mapel->kurikulums as $kurikulum)
                                            <span class="badge bg-info">{{ $kurikulum->nama_kurikulum }}</span>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($mapel->jurusans->count() > 0)
                                        @foreach($mapel->jurusans as $jurusan)
                                            <span class="badge bg-warning text-dark">{{ $jurusan->nama }}</span>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('tu_kepegawaian.mata-pelajaran.show', $mapel->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('tu_kepegawaian.mata-pelajaran.edit', $mapel->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form method="POST" action="{{ route('tu_kepegawaian.mata-pelajaran.destroy', $mapel->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus mata pelajaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data mata pelajaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($mataPelajarans->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $mataPelajarans->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection