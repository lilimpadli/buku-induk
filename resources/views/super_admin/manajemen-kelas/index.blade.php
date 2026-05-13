@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('content')
<div class="container mt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h3>Manajemen Kelas</h3>
            <p class="text-muted mb-0">Kelola rombel, kelas, wali kelas, dan cetak data siswa untuk pengguna superadmin.</p>
        </div>
        <a href="{{ route('super_admin.manajemen-kelas.create') }}" class="btn btn-primary">Tambah Kelas</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" class="row gy-2 gx-2 align-items-end mb-3">
                <div class="col-sm-5">
                    <label for="search" class="form-label">Cari</label>
                    <input type="text" id="search" name="search" class="form-control" value="{{ $search }}" placeholder="Nama rombel, tingkat, jurusan, wali kelas">
                </div>
                <div class="col-sm-4">
                    <label for="jurusan" class="form-label">Filter Jurusan</label>
                    <select id="jurusan" name="jurusan" class="form-select">
                        <option value="">Semua Jurusan</option>
                        @foreach($allJurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ $jurusan->id == $jurusan_id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-success w-100">Terapkan</button>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>Nama Rombel</th>
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Wali Kelas</th>
                            <th>Jumlah Siswa</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rombels as $rombel)
                            <tr>
                                <td>{{ $loop->iteration + ($rombels->currentPage() - 1) * $rombels->perPage() }}</td>
                                <td>{{ $rombel->nama }}</td>
                                <td>{{ $rombel->kelas->tingkat ?? '-' }}</td>
                                <td>{{ optional($rombel->kelas->jurusan)->nama ?? '-' }}</td>
                                <td>{{ optional($rombel->guru)->nama ?? '-' }}</td>
                                <td>{{ $rombel->siswa->count() }}</td>

                                <td class="text-center">
    <div class="d-inline-flex">

        {{-- Detail --}}
        <a href="{{ route('super_admin.manajemen-kelas.show', $rombel->id) }}"
           class="btn btn-info text-dark rounded-start rounded-0 border-0">
            <i class="fas fa-eye"></i>
        </a>

        {{-- Edit --}}
        <a href="{{ route('super_admin.manajemen-kelas.edit', $rombel->id) }}"
           class="btn btn-warning text-dark rounded-0 border-0">
            <i class="fas fa-pen"></i>
        </a>

        {{-- Hapus --}}
        <form action="{{ route('super_admin.manajemen-kelas.destroy', $rombel->id) }}"
              method="POST"
              class="d-inline">
            @csrf
            @method('DELETE')

            <button type="submit"
                    class="btn btn-danger rounded-end rounded-0 border-0"
                    onclick="return confirm('Yakin ingin menghapus rombel ini?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>

    </div>
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada rombel. Tambahkan kelas baru untuk memulai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $rombels->links() }}
            </div>
        </div>
    </div>
</div>
@endsection