@extends('layouts.app')

@section('title', 'PPDB - Daftar Jurusan')

@section('content')
<style>
    /* PPDB Jurusan Styles */
    .ppdb-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 1.5rem;
        border-radius: 15px 15px 0 0;
        margin: 0;
    }

    .ppdb-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        overflow: hidden;
    }

    .jurusan-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        overflow: hidden;
    }

    .jurusan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    }

    .jurusan-card .card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
    }

    .jurusan-card .card-title {
        color: #2d3748;
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 1rem;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 0.75rem;
    }

    .jurusan-card .card-text {
        color: #64748b;
        font-size: 0.95rem;
        flex-grow: 1;
        margin-bottom: 1.25rem;
        line-height: 1.6;
    }

    .jurusan-card .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 0.625rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .jurusan-card .btn-primary:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #64748b;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
        color: #667eea;
    }

    .empty-state h5 {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #2d3748;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    @media (max-width: 768px) {
        .ppdb-header {
            padding: 1.5rem 1rem;
        }

        .ppdb-header h5 {
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
        }

        .header-actions {
            width: 100%;
            justify-content: stretch;
        }

        .header-actions .btn {
            flex: 1;
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }

        .jurusan-card .card-body {
            padding: 1.25rem;
        }

        .jurusan-card .card-title {
            font-size: 1.1rem;
        }

        .jurusan-card .card-text {
            font-size: 0.9rem;
        }

        .empty-state {
            padding: 2rem 1rem;
        }

        .empty-state i {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 576px) {
        .ppdb-header {
            border-radius: 10px 10px 0 0;
            padding: 1.25rem 0.875rem;
        }

        .ppdb-header h5 {
            font-size: 1rem;
        }

        .header-actions .btn {
            font-size: 0.8rem;
            padding: 0.45rem 0.6rem;
        }

        .header-actions .btn i {
            font-size: 0.85rem;
        }

        .jurusan-card {
            border-radius: 10px;
        }

        .jurusan-card .card-body {
            padding: 1rem;
        }

        .jurusan-card .card-title {
            font-size: 1rem;
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
        }

        .jurusan-card .card-text {
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        .jurusan-card .btn-primary {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .empty-state {
            padding: 1.5rem 0.75rem;
        }

        .empty-state i {
            font-size: 2rem;
        }

        .empty-state h5 {
            font-size: 0.95rem;
        }

        .empty-state p {
            font-size: 0.85rem;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="card ppdb-card">
        <div class="ppdb-header">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <h5 class="mb-0">
                    <i class="fas fa-graduation-cap me-2"></i>
                    Daftar Jurusan PPDB
                </h5>
                <div class="header-actions">
                    <a href="{{ route('ppdb.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i>
                        <span class="d-none d-sm-inline">Tambah </span>Pendaftar
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body p-3 p-md-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {!! session('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-3 g-md-4">
                @forelse ($jurusans as $jurusan)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card jurusan-card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-book-reader me-2 text-primary"></i>
                                    {{ $jurusan->nama }}
                                </h5>
                                <p class="card-text">
                                    {{ $jurusan->deskripsi ?? 'Jurusan ini siap menerima pendaftar PPDB' }}
                                </p>
                                <a href="{{ route('tu.ppdb.jurusan.show', $jurusan->id) }}" class="btn btn-primary w-100">
                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h5>Tidak ada jurusan tersedia</h5>
                            <p class="mb-0">Belum ada jurusan yang terdaftar dalam sistem PPDB</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection