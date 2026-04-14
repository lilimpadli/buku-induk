@extends('layouts.app')

@section('title', 'Daftar Kurikulum TU Kepegawaian')

@section('content')
<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Daftar Kurikulum TU Kepegawaian</h3>
        <a href="{{ route('tu_kepegawaian.kurikulum.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Kurikulum
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
            <form method="GET" action="{{ route('tu_kepegawaian.kurikulum.index') }}" class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Cari Kurikulum</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama kurikulum..." value="{{ $search ?? '' }}">
                </div>
                <div class="col-md-4 d-grid">
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
                            <th>Nama Kurikulum</th>
                            <th>Jumlah Mata Pelajaran</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kurikulum as $k)
                            <tr>
                                <td>{{ $loop->iteration + ($kurikulum->currentPage() - 1) * $kurikulum->perPage() }}</td>
                                <td>{{ $k->nama_kurikulum }}</td>
                                <td>{{ $k->mata_pelajarans_count }}</td>
                                <td>{{ $k->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('tu_kepegawaian.kurikulum.show', $k->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('tu_kepegawaian.kurikulum.edit', $k->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form method="POST" action="{{ route('tu_kepegawaian.kurikulum.destroy', $k->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kurikulum ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data kurikulum</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($kurikulum->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $kurikulum->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection