@extends('layouts.app')

@section('title', 'PPDB - Detail Jurusan: ' . $jurusan->nama)

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Jurusan: {{ $jurusan->nama }}</h5>
            <div>
                <a href="{{ route('tu.ppdb.jurusan.pendaftar', $jurusan->id) }}" class="btn btn-sm btn-success me-2">
                    <i class="fas fa-list"></i> Lihat Isinya
                </a>
                <a href="{{ route('tu.ppdb.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Jurusan
                </a>
            </div>
        </div>
        <div class="card-body">
            <p class="mb-4">{{ $jurusan->deskripsi ?? 'Jurusan ini siap menerima pendaftar PPDB' }}</p>

            <!-- Sesi PPDB -->
            <div class="mb-5">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-calendar-alt"></i> Sesi PPDB
                </h6>
                <div class="row">
                    @forelse ($sesis as $sesi)
                        <div class="col-md-4 mb-3">
                            @if($sesi->ppdb_count > 0)
                                <a href="{{ route('tu.ppdb.jurusan.sesi.pendaftar', [$jurusan->id, $sesi->id]) }}" class="text-decoration-none">
                                    <div class="card border-primary h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $sesi->tahun_ajaran }}</h6>
                                            <p class="card-text small text-muted">
                                                Periode: {{ $sesi->periode_mulai }} - {{ $sesi->periode_selesai }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-{{ $sesi->status == 'aktif' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($sesi->status) }}
                                                </span>
                                                <small class="text-muted">{{ $sesi->ppdb_count ?? 0 }} pendaftar</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @else
                                <div class="card border-secondary h-100 opacity-50">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $sesi->tahun_ajaran }}</h6>
                                        <p class="card-text small text-muted">
                                            Periode: {{ $sesi->periode_mulai }} - {{ $sesi->periode_selesai }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-{{ $sesi->status == 'aktif' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($sesi->status) }}
                                            </span>
                                            <small class="text-muted">{{ $sesi->ppdb_count ?? 0 }} pendaftar</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                Tidak ada sesi PPDB untuk jurusan ini
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Jalur PPDB -->
            <div>
                <h6 class="text-primary mb-3">
                    <i class="fas fa-road"></i> Jalur PPDB
                </h6>
                <div class="row">
                    @forelse ($jalurs as $jalur)
                        <div class="col-md-6 mb-3">
                            @if($jalur->ppdb_count > 0)
                                <a href="{{ route('tu.ppdb.jurusan.jalur.pendaftar', [$jurusan->id, $jalur->id]) }}" class="text-decoration-none">
                                    <div class="card border-info h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $jalur->nama_jalur }}</h6>
                                            <p class="card-text small">{{ $jalur->deskripsi ?? 'Jalur PPDB ini tersedia untuk pendaftaran' }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-info">{{ $jalur->kuota }} kuota</span>
                                                <small class="text-muted">{{ $jalur->ppdb_count ?? 0 }} pendaftar</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @else
                                <div class="card border-secondary h-100 opacity-50">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $jalur->nama_jalur }}</h6>
                                        <p class="card-text small">{{ $jalur->deskripsi ?? 'Jalur PPDB ini tersedia untuk pendaftaran' }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-secondary">{{ $jalur->kuota }} kuota</span>
                                            <small class="text-muted">{{ $jalur->ppdb_count ?? 0 }} pendaftar</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                Tidak ada jalur PPDB untuk jurusan ini
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection