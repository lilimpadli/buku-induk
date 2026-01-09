@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Siswa</h3>
        <a href="{{ route('kurikulum.data-siswa.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Siswa
        </a>
    </div>

    <div class="mb-3">
        @php $currentTingkat = request()->query('tingkat', ''); @endphp
        <div class="btn-group" role="group">
            <a href="{{ request()->url() }}?tingkat=X" class="btn btn-sm {{ $currentTingkat == 'X' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas X</a>
            <a href="{{ request()->url() }}?tingkat=XI" class="btn btn-sm {{ $currentTingkat == 'XI' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas XI</a>
            <a href="{{ request()->url() }}?tingkat=XII" class="btn btn-sm {{ $currentTingkat == 'XII' ? 'btn-primary' : 'btn-outline-secondary' }}">Kelas XII</a>
            <a href="{{ route('kurikulum.siswa.index') }}" class="btn btn-sm btn-outline-secondary">Semua</a>
        </div>
    </div>

    <div class="card mb-3" style="border: 1px solid #E2E8F0; border-radius: 8px;">
        <div class="card-body" style="background-color: #F8FAFC;">
            <form method="GET" action="{{ route('kurikulum.siswa.index') }}" class="row g-2">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text" style="background:white;border:1px solid #E2E8F0;"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari nama, NIS, atau NISN..." value="{{ $search ?? '' }}" style="border:1px solid #E2E8F0;">
                    </div>
                </div>

                <div class="col-md-4">
                    <select name="rombel" class="form-select" style="border:1px solid #E2E8F0;">
                        <option value="">-- Semua Rombel --</option>
                        @foreach(($allRombels ?? collect()) as $r)
                            @php
                                $rombelNama = $r->nama ?? null;
                                $tingkatVal = optional($r->kelas)->tingkat ?? null;
                                $rombelWithoutTingkat = $rombelNama ? preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama) : null;
                                $rombelWithoutTingkat = $rombelWithoutTingkat ? trim($rombelWithoutTingkat) : null;
                                $formattedRombel = $rombelWithoutTingkat ? preg_replace('/(\D+)(\d+)/', '$1 $2', $rombelWithoutTingkat) : ($rombelNama ?? '');
                            @endphp
                            <option value="{{ $r->id }}" {{ (isset($filterRombel) && $filterRombel == $r->id) ? 'selected' : '' }}>
                                {{ $tingkatVal ? $tingkatVal . ' ' . $formattedRombel : $formattedRombel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex">
                    <button type="submit" class="btn btn-primary me-2">Cari</button>
                    <a href="{{ route('kurikulum.siswa.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama Lengkap</th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswas as $siswa)
                            <tr>
                                    <td>{{ $siswa->nis }}</td>
                                    <td>{{ $siswa->nama_lengkap }}</td>
                                    <td>
                                        @php
                                            $rombel = $siswa->rombel ?? null;
                                            $rombelNama = $rombel->nama ?? null;
                                            $tingkatVal = optional($rombel->kelas)->tingkat ?? null;
                                            // Remove any existing tingkat tokens (X, XI, XII) from rombel name to avoid duplication
                                            $rombelWithoutTingkat = $rombelNama ? preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama) : null;
                                            $rombelWithoutTingkat = $rombelWithoutTingkat ? trim($rombelWithoutTingkat) : null;
                                            // Insert space between letters and trailing digits, e.g. RPL1 -> RPL 1
                                            $formatted = $rombelWithoutTingkat ? preg_replace('/(\D+)(\d+)/', '$1 $2', $rombelWithoutTingkat) : null;
                                        @endphp

                                        @if($rombel)
                                            @if($tingkatVal)
                                                {{ $tingkatVal }} {{ $formatted }}
                                            @else
                                                {{ $formatted }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $siswa->jenis_kelamin }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('kurikulum.data-siswa.show', $siswa->id) }}" class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('kurikulum.data-siswa.edit', $siswa->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('kurikulum.data-siswa.destroy', $siswa->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                {{ $siswas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
