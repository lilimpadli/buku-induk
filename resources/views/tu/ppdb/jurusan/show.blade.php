@extends('layouts.app')

@section('title', 'PPDB - Detail Jurusan: ' . $jurusan->nama)

@section('content')
<style>
    /* PPDB Detail Jurusan Styles */
    .ppdb-detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 15px 15px 0 0;
    }

    .ppdb-detail-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        overflow: hidden;
    }

    .section-title {
        color: #667eea;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 1.25rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .section-title i {
        margin-right: 0.5rem;
    }

    .sesi-card, .jalur-card {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
        height: 100%;
    }

    .sesi-card:hover, .jalur-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .sesi-card.border-primary {
        border-color: #667eea !important;
    }

    .jalur-card.border-info {
        border-color: #06b6d4 !important;
    }

    .sesi-card .card-body, .jalur-card .card-body {
        padding: 1.25rem;
    }

    .sesi-card .card-title, .jalur-card .card-title {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }

    .nav-pills .nav-link {
        border-radius: 20px;
        padding: 0.5rem 1.25rem;
        color: #64748b;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .nav-pills .nav-link:hover {
        background-color: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .badge {
        padding: 0.4rem 0.75rem;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .jalur-link {
        text-decoration: none;
        display: block;
    }

    .jalur-link:hover .jalur-card {
        border-color: #667eea !important;
    }

    .header-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .ppdb-detail-header {
            padding: 1.25rem 1rem;
        }

        .ppdb-detail-header h5 {
            font-size: 1rem;
            margin-bottom: 0.75rem;
        }

        .header-actions {
            width: 100%;
            margin-top: 0.75rem;
        }

        .header-actions .btn {
            flex: 1;
            font-size: 0.85rem;
            padding: 0.45rem 0.75rem;
        }

        .header-actions .btn i {
            font-size: 0.85rem;
        }

        .section-title {
            font-size: 1rem;
        }

        .sesi-card .card-body, .jalur-card .card-body {
            padding: 1rem;
        }

        .sesi-card .card-title, .jalur-card .card-title {
            font-size: 0.95rem;
        }

        .sesi-card .card-text, .jalur-card .card-text {
            font-size: 0.875rem;
        }

        .nav-pills {
            overflow-x: auto;
            flex-wrap: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .nav-pills::-webkit-scrollbar {
            display: none;
        }

        .nav-pills .nav-link {
            padding: 0.45rem 1rem;
            font-size: 0.875rem;
            white-space: nowrap;
            flex-shrink: 0;
        }
    }

    @media (max-width: 576px) {
        .ppdb-detail-header {
            border-radius: 10px 10px 0 0;
            padding: 1rem 0.875rem;
        }

        .ppdb-detail-header h5 {
            font-size: 0.95rem;
        }

        .header-actions {
            flex-direction: column;
        }

        .header-actions .btn {
            width: 100%;
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }

        .header-actions .btn:not(:last-child) {
            margin-bottom: 0.5rem;
        }

        .section-title {
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .sesi-card, .jalur-card {
            border-radius: 10px;
        }

        .sesi-card .card-body, .jalur-card .card-body {
            padding: 0.875rem;
        }

        .sesi-card .card-title, .jalur-card .card-title {
            font-size: 0.9rem;
            margin-bottom: 0.6rem;
        }

        .sesi-card .card-text, .jalur-card .card-text {
            font-size: 0.825rem;
        }

        .sesi-card .btn-sm, .jalur-card .btn-sm {
            font-size: 0.8rem;
            padding: 0.4rem 0.75rem;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }

        .nav-pills .nav-link {
            padding: 0.4rem 0.85rem;
            font-size: 0.825rem;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="card ppdb-detail-card">
        <div class="ppdb-detail-header">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="flex-grow-1">
                    <h5 class="mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>
                        Detail Jurusan: {{ $jurusan->nama }}
                    </h5>
                </div>
                <div class="header-actions">
                    <a href="{{ route('tu.ppdb.jurusan.pendaftar', $jurusan->id) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-list me-1"></i>
                        <span class="d-none d-sm-inline">Lihat </span>Isinya
                    </a>
                    <a href="{{ route('tu.ppdb.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        <span class="d-none d-md-inline">Kembali</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body p-3 p-md-4">
            <p class="mb-4 text-muted">
                <i class="fas fa-info-circle me-2"></i>
                {{ $jurusan->deskripsi ?? 'Jurusan ini siap menerima pendaftar PPDB' }}
            </p>

            <!-- Sesi PPDB -->
            <div class="mb-5">
                <h6 class="section-title">
                    <i class="fas fa-calendar-alt"></i>Sesi PPDB
                </h6>
                <div class="row g-3">
                    @forelse ($sesis as $i => $sesi)
                        <div class="col-12 col-md-6 col-lg-4">
                            @if($sesi->ppdb_count > 0)
                                <div class="card sesi-card border-primary">
                                    <div class="card-body">
                                        @php 
                                            $stage = $i == 0 ? 'tahap1' : 'tahap2'; 
                                            $timeline = \App\Models\PpdbTimeline::where('stage', $stage)->first(); 
                                        @endphp
                                        <h6 class="card-title">
                                            <i class="fas fa-layer-group me-2 text-primary"></i>
                                            Tahap {{ $i + 1 }}
                                        </h6>
                                        <p class="card-text small text-muted mb-3">
                                            <i class="fas fa-clock me-1"></i>
                                            Periode: {{ $timeline->pendaftaran ?? ($sesi->periode_mulai . ' - ' . $sesi->periode_selesai) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="badge bg-{{ $sesi->status == 'aktif' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($sesi->status) }}
                                            </span>
                                            <small class="text-muted">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $sesi->ppdb_count ?? 0 }} pendaftar
                                            </small>
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ route('tu.ppdb.jurusan.sesi.pendaftar', ['jurusanId' => $jurusan->id, 'sesiId' => $sesi->id]) }}" class="btn btn-sm btn-outline-primary w-100">
                                                <i class="fas fa-eye me-1"></i>
                                                Lihat Pendaftar Tahap {{ $i + 1 }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card sesi-card border-secondary opacity-50">
                                    <div class="card-body">
                                        @php 
                                            $stage = $i == 0 ? 'tahap1' : 'tahap2'; 
                                            $timeline = \App\Models\PpdbTimeline::where('stage', $stage)->first(); 
                                        @endphp
                                        <h6 class="card-title">
                                            <i class="fas fa-layer-group me-2"></i>
                                            Tahap {{ $i + 1 }}
                                        </h6>
                                        <p class="card-text small text-muted mb-3">
                                            <i class="fas fa-clock me-1"></i>
                                            Periode: {{ $timeline->pendaftaran ?? ($sesi->periode_mulai . ' - ' . $sesi->periode_selesai) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-{{ $sesi->status == 'aktif' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($sesi->status) }}
                                            </span>
                                            <small class="text-muted">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $sesi->ppdb_count ?? 0 }} pendaftar
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i>
                                Tidak ada sesi PPDB untuk jurusan ini
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Jalur PPDB per Sesi (tabs) -->
            <div>
                <h6 class="section-title">
                    <i class="fas fa-road"></i>Jalur PPDB
                </h6>

                {{-- Session pills --}}
                <ul class="nav nav-pills mb-3" id="sesiTabs" role="tablist">
                    @foreach($sesis as $i => $sesi)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($i==0) active @endif" id="tab-{{ $sesi->id }}" data-bs-toggle="pill" data-bs-target="#tab-content-{{ $sesi->id }}" type="button" role="tab" aria-controls="tab-content-{{ $sesi->id }}" aria-selected="{{ $i==0 ? 'true' : 'false' }}">
                                <i class="fas fa-calendar-check me-1"></i>
                                {{ $sesi->nama_sesi ?? 'Sesi ' . ($i+1) }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($sesis as $i => $sesi)
                        <div class="tab-pane fade @if($i==0) show active @endif" id="tab-content-{{ $sesi->id }}" role="tabpanel" aria-labelledby="tab-{{ $sesi->id }}">
                            <div class="row g-3">
                                @if(!empty($sesi->jalurs) && count($sesi->jalurs) > 0)
                                    @foreach($sesi->jalurs as $jalur)
                                        <div class="col-12 col-md-6">
                                            @if(($jalur->ppdb_count ?? 0) > 0)
                                                <a href="{{ route('tu.ppdb.jurusan.jalur.pendaftar', [$jurusan->id, $jalur->id]) }}" class="jalur-link">
                                                    <div class="card jalur-card border-info">
                                                        <div class="card-body">
                                                            <h6 class="card-title">
                                                                <i class="fas fa-route me-2 text-info"></i>
                                                                {{ $jalur->nama_jalur }}
                                                            </h6>
                                                            <p class="card-text small text-muted mb-3">
                                                                {{ $jalur->deskripsi ?? 'Jalur PPDB ini tersedia untuk pendaftaran' }}
                                                            </p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="badge bg-info">
                                                                    <i class="fas fa-user-friends me-1"></i>
                                                                    {{ $jalur->kuota }} kuota
                                                                </span>
                                                                <small class="text-muted">
                                                                    <i class="fas fa-users me-1"></i>
                                                                    {{ $jalur->ppdb_count ?? 0 }} pendaftar
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @else
                                                <div class="card jalur-card border-secondary opacity-50">
                                                    <div class="card-body">
                                                        <h6 class="card-title">
                                                            <i class="fas fa-route me-2"></i>
                                                            {{ $jalur->nama_jalur }}
                                                        </h6>
                                                        <p class="card-text small text-muted mb-3">
                                                            {{ $jalur->deskripsi ?? 'Jalur PPDB ini tersedia untuk pendaftaran' }}
                                                        </p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="badge bg-secondary">
                                                                <i class="fas fa-user-friends me-1"></i>
                                                                {{ $jalur->kuota }} kuota
                                                            </span>
                                                            <small class="text-muted">
                                                                <i class="fas fa-users me-1"></i>
                                                                {{ $jalur->ppdb_count ?? 0 }} pendaftar
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <div class="alert alert-info text-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Tidak ada jalur PPDB untuk sesi ini
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection