@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<style>
    /* ===================== STYLE DATA KELAS ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .container {
        max-width: 1200px;
    }

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card.shadow-sm {
        box-shadow: var(--card-shadow);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-body.d-flex {
        padding: 1.25rem;
    }

    /* Section Headers */
    h5.mb-0 {
        font-size: 20px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 0 !important;
        position: relative;
        padding-left: 15px;
    }

    h5.mb-0::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
    }

    h6.mb-1, h6.mb-0 {
        font-size: 16px;
        color: #475569;
        font-weight: 600;
        margin-bottom: 0.25rem !important;
    }

    h6.mb-1 strong, h6.mb-0 strong {
        color: #1E293B;
    }

    /* Class Cards */
    .card.shadow-sm.p-3 {
        border-radius: 12px;
        transition: all 0.3s ease;
        height: 100%;
    }

    .card.shadow-sm.p-3:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
    }

    .card.shadow-sm.p-3 h5 {
        font-size: 18px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .card.shadow-sm.p-3 .text-muted.small {
        color: #64748B;
        font-size: 13px;
        margin-bottom: 0.25rem;
    }

    /* Button Styles */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .btn-sm {
        padding: 0.4rem 1rem;
        font-size: 14px;
    }

    .rounded-pill {
        border-radius: 20px;
    }

    /* Text Styles */
    .text-muted {
        color: #64748B !important;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }
        
        .card-body.d-flex {
            padding: 1rem;
        }
        
        h5.mb-0 {
            font-size: 18px;
        }
        
        h6.mb-1, h6.mb-0 {
            font-size: 15px;
        }
        
        .btn {
            padding: 0.4rem 1rem;
            font-size: 14px;
        }
    }
</style>

<div class="container mt-4">
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Kelas</h5>
        </div>
    </div>

    <div class="row g-3">
        @if(isset($jurusan) && isset($rombels))
            <div class="col-12 mb-3">
                <h6>Jurusan: <strong>{{ $jurusan->nama }}</strong></h6>
            </div>
            @foreach($rombels as $r)
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">{{ $r->nama }}</h5>
                                <div class="text-muted small">Kelas: {{ $r->kelas->tingkat ?? '-' }}</div>
                                <div class="text-muted small">Siswa: {{ $r->siswa()->count() }}</div>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('kaprog.kelas.show', $r->id) }}" class="btn btn-sm btn-primary rounded-pill me-2">Detail</a>
                                <a href="{{ route('kaprog.export.rombel', $r->id) }}" class="btn btn-sm btn-success rounded-pill" title="Export Excel">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @elseif(isset($jurusans))
            @foreach($jurusans as $jr)
                <div class="col-12 mb-2">
                    <h6 class="mb-1">Jurusan: <strong>{{ $jr->nama }}</strong></h6>
                </div>

                @foreach($jr->kelas as $k)
                    @foreach($k->rombels as $r)
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card shadow-sm p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $r->nama }}</h5>
                                        <div class="text-muted small">Kelas: {{ $k->tingkat }}</div>
                                        <div class="text-muted small">Siswa: {{ $r->siswa()->count() }}</div>
                                    </div>

                                    <div class="text-end">
                                        <a href="{{ route('kaprog.kelas.show', $r->id) }}" class="btn btn-sm btn-primary rounded-pill">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @endforeach
        @else
            <div class="col-12">
                <div class="card shadow-sm p-4 text-center">
                    <div class="text-muted">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <h5>Tidak ada data kelas</h5>
                        <p>Belum ada data kelas yang tersedia.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection