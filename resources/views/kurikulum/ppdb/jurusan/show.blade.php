@extends('layouts.app')

@section('title', 'PPDB - Detail Jurusan: ' . $jurusan->nama)

@section('content')
<style>
    /* ===================== STYLE PPDB DETAIL JURUSAN - RESPONSIVE ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --info-color: #0EA5E9;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
    }

    /* Main Card */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    /* Header Styles */
    .card-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 1.5rem;
        border-bottom: none;
    }

    .card-header h5 {
        font-weight: 600;
        margin-bottom: 0;
        font-size: 20px;
    }

    .card-header .btn {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        border-radius: 8px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .card-header .btn:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
    }

    .card-header .btn-success {
        background: rgba(16, 185, 129, 0.2);
        border-color: rgba(16, 185, 129, 0.4);
    }

    .card-header .btn-success:hover {
        background: rgba(16, 185, 129, 0.3);
    }

    .header-actions {
        display: flex;
        gap: 8px;
    }

    /* Card Body */
    .card-body {
        padding: 2rem;
    }

    .card-body > p {
        font-size: 15px;
        color: #64748B;
        line-height: 1.6;
    }

    /* Section Headers */
    h6.text-primary {
        font-weight: 600;
        font-size: 16px;
        color: var(--primary-color) !important;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #E2E8F0;
        margin-bottom: 1.5rem !important;
    }

    h6.text-primary i {
        margin-right: 8px;
    }

    /* Session Cards */
    .sesi-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        height: 100%;
        overflow: hidden;
    }

    .sesi-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--hover-shadow);
    }

    .sesi-card .card-title {
        font-weight: 600;
        font-size: 16px;
        color: #1E293B;
        margin-bottom: 0.75rem;
    }

    .sesi-card .card-text {
        color: #64748B;
        margin-bottom: 1rem;
    }

    .sesi-card .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 12px;
    }

    .border-primary {
        border: 2px solid var(--primary-color) !important;
    }

    .border-secondary {
        border: 2px solid #CBD5E1 !important;
    }

    .border-info {
        border: 2px solid var(--info-color) !important;
    }

    /* Nav Pills */
    .nav-pills {
        background: #F8FAFC;
        padding: 8px;
        border-radius: 12px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .nav-pills .nav-link {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        font-size: 14px;
        color: #64748B;
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link:hover {
        background: white;
        color: var(--primary-color);
        border-color: #E2E8F0;
    }

    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 8px rgba(47, 83, 255, 0.3);
    }

    /* Jalur Cards */
    .jalur-card-link {
        text-decoration: none;
        display: block;
        height: 100%;
    }

    .jalur-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        height: 100%;
    }

    .jalur-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--hover-shadow);
    }

    .jalur-card .card-title {
        font-weight: 600;
        font-size: 16px;
        color: #1E293B;
        margin-bottom: 0.75rem;
    }

    .jalur-card .card-text {
        color: #64748B;
        font-size: 14px;
        line-height: 1.5;
    }

    /* Alert Styles */
    .alert-info {
        background-color: rgba(14, 165, 233, 0.1);
        border: 1px solid rgba(14, 165, 233, 0.2);
        color: #075985;
        border-radius: 12px;
    }

    /* Opacity Helper */
    .opacity-50 {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Badge Styles */
    .bg-success {
        background-color: #D1FAE5 !important;
        color: #065F46 !important;
    }

    .bg-secondary {
        background-color: #F1F5F9 !important;
        color: #475569 !important;
    }

    .bg-info {
        background-color: #E0F2FE !important;
        color: #075985 !important;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .tab-pane {
        animation: fadeIn 0.4s ease-out;
    }

    /* ===================== RESPONSIVE STYLES ===================== */

    /* Tablet (max-width: 991px) */
    @media (max-width: 991px) {
        .card-header h5 {
            font-size: 18px;
        }

        .card-body {
            padding: 1.5rem;
        }

        h6.text-primary {
            font-size: 15px;
        }

        .nav-pills .nav-link {
            padding: 8px 16px;
            font-size: 13px;
        }
    }

    /* Mobile (max-width: 767px) */
    @media (max-width: 767px) {
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Header */
        .card-header {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 1rem;
            padding: 1.25rem;
        }

        .card-header h5 {
            font-size: 17px;
            margin-bottom: 1rem !important;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
        }

        .header-actions .btn {
            width: 100%;
            justify-content: center;
        }

        /* Card Body */
        .card-body {
            padding: 1.25rem;
        }

        .card-body > p {
            font-size: 14px;
        }

        /* Section Headers */
        h6.text-primary {
            font-size: 15px;
            margin-bottom: 1.25rem !important;
        }

        /* Nav Pills */
        .nav-pills {
            padding: 6px;
            gap: 6px;
            overflow-x: auto;
            flex-wrap: nowrap;
            scrollbar-width: thin;
        }

        .nav-pills::-webkit-scrollbar {
            height: 4px;
        }

        .nav-pills::-webkit-scrollbar-thumb {
            background-color: #CBD5E1;
            border-radius: 4px;
        }

        .nav-pills .nav-item {
            flex-shrink: 0;
        }

        .nav-pills .nav-link {
            padding: 8px 16px;
            font-size: 13px;
            white-space: nowrap;
        }

        /* Sesi Cards */
        .col-md-4 {
            margin-bottom: 1rem !important;
        }

        .sesi-card .card-body {
            padding: 1rem;
        }

        .sesi-card .card-title {
            font-size: 15px;
        }

        .sesi-card .card-text {
            font-size: 13px;
        }

        .sesi-card .btn {
            font-size: 12px;
            padding: 6px 12px;
        }

        /* Jalur Cards */
        .col-md-6 {
            margin-bottom: 1rem !important;
        }

        .jalur-card .card-body {
            padding: 1rem;
        }

        .jalur-card .card-title {
            font-size: 15px;
        }

        .jalur-card .card-text {
            font-size: 13px;
        }

        /* Badge */
        .badge {
            font-size: 11px !important;
            padding: 5px 10px !important;
        }
    }

    /* Small Mobile (max-width: 480px) */
    @media (max-width: 480px) {
        .card-header {
            padding: 1rem;
        }

        .card-header h5 {
            font-size: 16px;
        }

        .card-body {
            padding: 1rem;
        }

        .card-body > p {
            font-size: 13px;
        }

        h6.text-primary {
            font-size: 14px;
        }

        .nav-pills .nav-link {
            padding: 7px 14px;
            font-size: 12px;
        }

        .sesi-card .card-title,
        .jalur-card .card-title {
            font-size: 14px;
        }

        .sesi-card .card-text,
        .jalur-card .card-text {
            font-size: 12px;
        }
    }

    /* Desktop (min-width: 1200px) */
    @media (min-width: 1200px) {
        .container-fluid {
            max-width: 1400px;
            margin: 0 auto;
        }

        .card-header h5 {
            font-size: 22px;
        }

        .card-body {
            padding: 2.5rem;
        }

        .card-body > p {
            font-size: 16px;
        }

        h6.text-primary {
            font-size: 17px;
        }

        .nav-pills .nav-link {
            padding: 12px 24px;
            font-size: 15px;
        }

        .sesi-card .card-title,
        .jalur-card .card-title {
            font-size: 17px;
        }
    }

    /* Print Styles */
    @media print {
        .card-header .btn,
        .sesi-card .btn {
            display: none !important;
        }

        .card {
            box-shadow: none;
            border: 1px solid #ddd;
        }

        .card-header {
            background: #f5f5f5 !important;
            color: #000 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .tab-pane {
            display: block !important;
            opacity: 1 !important;
        }

        .nav-pills {
            display: none;
        }

        .sesi-card,
        .jalur-card {
            page-break-inside: avoid;
        }
    }
</style>

<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Jurusan: {{ $jurusan->nama }}</h5>
            <div class="header-actions">
                <a href="{{ route('kurikulum.ppdb.jurusan.pendaftar', $jurusan->id) }}" class="btn btn-sm btn-success">
                    <i class="fas fa-list"></i> <span class="d-none d-sm-inline">Lihat Isinya</span>
                </a>
                <a href="{{ route('kurikulum.ppdb.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> <span class="d-none d-sm-inline">Kembali</span>
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
                    @forelse ($sesis as $i => $sesi)
                        <div class="col-md-4 mb-3">
                            @if($sesi->ppdb_count > 0)
                                <div class="card border-primary sesi-card">
                                    <div class="card-body">
                                        @php 
                                            $stage = $i == 0 ? 'tahap1' : 'tahap2'; 
                                            $timeline = \App\Models\PpdbTimeline::where('stage', $stage)->first(); 
                                        @endphp
                                        <h6 class="card-title">Tahap {{ $i + 1 }}</h6>
                                        <p class="card-text small text-muted">
                                            Periode: {{ $timeline->pendaftaran ?? ($sesi->periode_mulai . ' - ' . $sesi->periode_selesai) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-{{ $sesi->status == 'aktif' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($sesi->status) }}
                                            </span>
                                            <small class="text-muted">{{ $sesi->ppdb_count ?? 0 }} pendaftar</small>
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ route('kurikulum.ppdb.jurusan.sesi.pendaftar', ['jurusanId' => $jurusan->id, 'sesiId' => $sesi->id]) }}" class="btn btn-sm btn-outline-primary w-100">
                                                Lihat Semua Pendaftar Tahap {{ $i + 1 }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card border-secondary sesi-card opacity-50">
                                    <div class="card-body">
                                        @php 
                                            $stage = $i == 0 ? 'tahap1' : 'tahap2'; 
                                            $timeline = \App\Models\PpdbTimeline::where('stage', $stage)->first(); 
                                        @endphp
                                        <h6 class="card-title">Tahap {{ $i + 1 }}</h6>
                                        <p class="card-text small text-muted">
                                            Periode: {{ $timeline->pendaftaran ?? ($sesi->periode_mulai . ' - ' . $sesi->periode_selesai) }}
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

            <!-- Jalur PPDB per Sesi (tabs) -->
            <div>
                <h6 class="text-primary mb-3">
                    <i class="fas fa-road"></i> Jalur PPDB
                </h6>

                {{-- Session pills --}}
                <ul class="nav nav-pills mb-3" id="sesiTabs" role="tablist">
                    @foreach($sesis as $i => $sesi)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($i==0) active @endif" 
                                    id="tab-{{ $sesi->id }}" 
                                    data-bs-toggle="pill" 
                                    data-bs-target="#tab-content-{{ $sesi->id }}" 
                                    type="button" 
                                    role="tab" 
                                    aria-controls="tab-content-{{ $sesi->id }}" 
                                    aria-selected="{{ $i==0 ? 'true' : 'false' }}">
                                {{ $sesi->nama_sesi ?? 'Sesi ' . ($i+1) }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($sesis as $i => $sesi)
                        <div class="tab-pane fade @if($i==0) show active @endif" 
                             id="tab-content-{{ $sesi->id }}" 
                             role="tabpanel" 
                             aria-labelledby="tab-{{ $sesi->id }}">
                            <div class="row">
                                @if(!empty($sesi->jalurs) && count($sesi->jalurs) > 0)
                                    @foreach($sesi->jalurs as $jalur)
                                        <div class="col-md-6 mb-3">
                                            @if(($jalur->ppdb_count ?? 0) > 0)
                                                <a href="{{ route('kurikulum.ppdb.jurusan.jalur.pendaftar', [$jurusan->id, $jalur->id]) }}" class="jalur-card-link">
                                                    <div class="card border-info jalur-card">
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
                                                <div class="card border-secondary jalur-card opacity-50">
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
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <div class="alert alert-info">Tidak ada jalur PPDB untuk sesi ini</div>
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