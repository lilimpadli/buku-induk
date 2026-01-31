@extends('layouts.app')

@section('title', 'Mutasi Siswa')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">
                <i class="fas fa-exchange-alt text-primary"></i> Data Mutasi Siswa
            </h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('tu.mutasi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Mutasi
            </a>
            <a href="{{ route('tu.mutasi.laporan') }}" class="btn btn-info">
                <i class="fas fa-file-pdf"></i> Laporan
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, NIS, atau NISN siswa..." 
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Mutasi -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Status Mutasi</th>
                        <th>Tanggal Mutasi</th>
                        <th>Keterangan</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mutasis as $index => $mutasi)
                        <tr>
                            <td>{{ $mutasis->firstItem() + $index }}</td>
                            <td><strong>{{ $mutasi->siswa->nis }}</strong></td>
                            <td>{{ $mutasi->siswa->nama_lengkap }}</td>
                            <td>
                                <span class="badge bg-{{ $mutasi->status_color }}">
                                    {{ $mutasi->status_label }}
                                </span>
                            </td>
                            <td>{{ $mutasi->tanggal_mutasi->format('d M Y') }}</td>
                            <td>
                                @if($mutasi->keterangan)
                                    <small class="text-muted">{{ Str::limit($mutasi->keterangan, 30) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('tu.mutasi.show', $mutasi) }}" class="btn btn-outline-primary" 
                                        data-bs-toggle="tooltip" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tu.mutasi.edit', $mutasi) }}" class="btn btn-outline-warning" 
                                        data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tu.mutasi.destroy', $mutasi) }}" method="POST" 
                                        style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" 
                                            data-bs-toggle="tooltip" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox" style="font-size: 3rem;"></i>
                                    <p class="mt-3">Belum ada data mutasi siswa</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($mutasis->hasPages())
            <div class="card-footer">
                {{ $mutasis->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
@endsection
