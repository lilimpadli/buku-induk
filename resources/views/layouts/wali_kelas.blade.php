@extends('layouts.app')

@section('title', 'Data Wali Kelas')

@section('content')

<h4 class="fw-bold mb-3">Data Wali Kelas</h4>

<div class="card shadow-sm border-0">
    <div class="card-body">

        <!-- SEARCH FILTER -->
        <form method="GET" class="row mb-3">
            <div class="col-md-4">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Cari nama guru..."
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <select name="kelas" class="form-control">
                    <option value="">-- Filter Kelas --</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}" {{ request('kelas') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    <i class="fa fa-search me-1"></i> Cari
                </button>
            </div>
        </form>

        <!-- TABLE -->
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Wali Kelas</th>
                    <th>Kelas</th>
                    <th>Jumlah Siswa</th>
                    <th style="width: 140px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($waliKelas as $i => $wali)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $wali->guru->nama }}</td>
                        <td>{{ $wali->kelas->nama_kelas }}</td>
                        <td>{{ $wali->kelas->siswa->count() }}</td>
                        <td class="text-center">
                            <a href="{{ route('kaprog.wali.detail', $wali->id) }}" 
                               class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                            </a>

                            <a href="{{ route('kaprog.wali.edit', $wali->id) }}" 
                               class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>

                            <form action="{{ route('kaprog.wali.delete', $wali->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus data ini?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data wali kelas.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

@endsection
