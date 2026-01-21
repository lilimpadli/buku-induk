@extends('layouts.app')

@section('title', 'Daftar Buku Induk Siswa')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-book text-primary"></i> Daftar Buku Induk Siswa
            </h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('tu.siswa.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, NIS, atau NISN siswa..." 
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Siswa -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Status Terakhir</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $index => $siswa)
                        <tr>
                            <td>{{ $siswas->firstItem() + $index }}</td>
                            <td><strong>{{ $siswa->nis }}</strong></td>
                            <td>{{ $siswa->nisn ?? '-' }}</td>
                            <td>{{ $siswa->nama_lengkap }}</td>
                            <td>
                                @if($siswa->jenis_kelamin == 'L')
                                    <span class="badge bg-info">Laki-laki</span>
                                @elseif($siswa->jenis_kelamin == 'P')
                                    <span class="badge bg-danger">Perempuan</span>
                                @else
                                    {{ $siswa->jenis_kelamin }}
                                @endif
                            </td>
                            <td>
                                @if($siswa->mutasiTerakhir)
                                    <span class="badge bg-{{ $siswa->mutasiTerakhir->status_color }}">
                                        {{ $siswa->mutasiTerakhir->status_label }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('tu.buku-induk.show', $siswa) }}" class="btn btn-outline-primary" 
                                        data-bs-toggle="tooltip" title="Lihat Buku Induk">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tu.buku-induk.cetak', $siswa) }}" target="_blank" class="btn btn-outline-success" 
                                        data-bs-toggle="tooltip" title="Cetak">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox" style="font-size: 3rem;"></i>
                                    <p class="mt-3">Belum ada data siswa</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($siswas->hasPages())
            <div class="card-footer">
                {{ $siswas->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
@endsection
       