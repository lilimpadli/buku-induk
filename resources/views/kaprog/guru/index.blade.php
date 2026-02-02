@extends('layouts.app')

@section('content')
<style>
    /* ===================== STYLE GURU JURUSAN ===================== */
    
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
        padding-top: 2rem;
    }

    h3 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 1.5rem !important;
    }

    h3::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 3px;
    }

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
        transform: translateY(-5px);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-size: 18px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 0.75rem;
        position: relative;
        padding-left: 15px;
    }

    .card-title::before {
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

    .card-text {
        color: #475569;
        font-size: 14px;
        line-height: 1.5;
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

    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .btn-sm {
        padding: 0.4rem 1rem;
        font-size: 14px;
    }

    /* Text Styles */
    .text-muted {
        color: #64748B !important;
        font-size: 13px;
    }

    .fw-semibold {
        font-weight: 600;
        color: #334155;
    }

    /* List Styles */
    ul {
        padding-left: 1.2rem;
        margin-bottom: 1rem;
    }

    ul li {
        margin-bottom: 0.5rem;
        position: relative;
        padding-left: 0.5rem;
    }

    ul li::before {
        content: "•";
        position: absolute;
        left: -0.8rem;
        color: var(--primary-color);
        font-weight: bold;
    }

    /* Alert Styles */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
    }

    .alert-info {
        background-color: rgba(59, 130, 246, 0.1);
        color: var(--primary-color);
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
        .container {
            max-width: 100%;
            padding: 1.5rem 1rem;
        }
        
        h3 {
            font-size: 24px;
        }
        
        .d-flex {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .form-control {
            font-size: 14px;
            padding: 8px 10px;
        }
        
        .btn {
            padding: 0.4rem 0.8rem;
            font-size: 13px;
        }
        
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        .card-body {
            padding: 1.25rem;
        }
        
        .card-title {
            font-size: 16px;
        }
        
        .card-text {
            font-size: 13px;
        }
    }
    
    @media (max-width: 576px) {
        h3 {
            font-size: 20px;
        }
        
        .card {
            margin-bottom: 1rem;
        }
        
        .card-body {
            padding: 1rem;
        }
    }
</style>

<div class="container">
    <h3>Guru - Jurusan: {{ $jurusan->nama }}</h3>

    <div class="row mt-3">
        <div class="col-12 mb-3">
            <form method="GET" action="{{ route('kaprog.guru.index') }}" class="d-flex">
                <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control me-2" placeholder="Cari nama, NIP, atau email...">
                <button type="submit" class="btn btn-primary btn-sm me-2">Cari</button>
                <a href="{{ route('kaprog.guru.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </form>
        </div>

        
        @forelse($gurus as $g)
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">

                        <h5 class="card-title mb-1">
                            {{ $g->nama }}
                            <small class="text-muted">({{ $g->nip }})</small>
                        </h5>

                        <p class="card-text mb-2">
                            {{ $g->email }} <br>
                            @if(optional($g->user)->role)
                                <small class="text-muted">
                                    Role: {{ $g->user->role }}
                                </small>
                            @endif
                        </p>

                        <p class="mb-1 fw-semibold">
                            Rombel yang diampu (jurusan ini):
                        </p>

                        @php
                            $jurusan = $jurusan ?? null;
                            $rombelList = $g->rombels
                                ->filter(fn ($r) => optional($r->kelas)->jurusan_id == optional($jurusan)->id);
                        @endphp

                        <ul class="mb-3">
                            @forelse($rombelList as $r)
                                <li>
                                    <strong>{{ $r->nama }}</strong>
                                     Kelas {{ optional($r->kelas)->tingkat ?? '-' }}

                                    <br>
                                    <small class="text-muted">
                                        Jumlah siswa: {{ $r->siswa_count ?? ($r->siswa->count() ?? 0) }}
                                    </small>
                                </li>
                            @empty
                                <li class="text-muted">
                                    <em>Tidak ada rombel yang diampu.</em>
                                </li>
                            @endforelse
                        </ul>

                        <a href="{{ route('kaprog.guru.show', $g->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            Detail Guru
                        </a>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle fa-2x me-3"></i>
                        <div>
                            <h5 class="mb-1">Belum ada guru di jurusan ini</h5>
                            <p class="mb-0">Silakan tambahkan guru untuk jurusan {{ $jurusan->nama }}.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection