@extends('layouts.app')

@section('title', 'Riwayat Rapor')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body { background-color: #f7fafc; font-family: 'Inter', sans-serif; }

    main {
        padding: 20px 15px !important;
        overflow-x: auto !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 10px !important;
        overflow-x: auto !important;
    }

    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .page-header::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(100px, -100px);
        pointer-events: none;
    }

    .page-header h3 {
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1.3rem;
        position: relative;
        z-index: 1;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .page-header .badge-student {
        background: rgba(255, 255, 255, 0.2);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        position: relative;
        z-index: 1;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    .list-group-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        background: white;
    }

    .list-group-card .list-group-item {
        border: none;
        border-bottom: 1px solid #E2E8F0;
        padding: 1rem 1.5rem;
        transition: var(--transition);
        background: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        color: inherit;
    }

    .list-group-card .list-group-item:last-child {
        border-bottom: none;
    }

    .list-group-card .list-group-item:hover {
        background: rgba(102, 126, 234, 0.04);
        transform: translateX(5px);
    }

    .list-group-card .list-group-item .icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--primary-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .list-group-card .list-group-item .content {
        flex: 1;
        margin-left: 15px;
    }

    .list-group-card .list-group-item .content h6 {
        font-weight: 600;
        color: #1E293B;
        margin: 0;
        font-size: 0.95rem;
    }

    .list-group-card .list-group-item .content small {
        color: #64748B;
        font-size: 0.8rem;
    }

    .badge-arrow {
        background: var(--primary-gradient);
        color: white;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: var(--transition);
        white-space: nowrap;
    }

    .list-group-card .list-group-item:hover .badge-arrow {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .badge-semester {
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-semester.ganjil {
        background: #FEF3C7;
        color: #D97706;
    }

    .badge-semester.genap {
        background: #D1FAE5;
        color: #059669;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #94A3B8;
    }

    .empty-state i {
        font-size: 3rem;
        color: #CBD5E1;
        display: block;
        margin-bottom: 0.5rem;
    }

    .empty-state h5 {
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1rem;
        }
        .page-header h3 {
            font-size: 1.1rem;
        }
        .page-header .text-muted {
            font-size: 0.75rem;
        }
        .page-header .badge-student {
            font-size: 0.75rem;
            padding: 4px 12px;
        }

        .list-group-card .list-group-item {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 12px;
            padding: 1rem;
        }

        .list-group-card .list-group-item .badge-arrow {
            align-self: flex-start;
        }

        .list-group-card .list-group-item .icon-wrapper {
            width: 36px;
            height: 36px;
            font-size: 14px;
        }

        .list-group-card .list-group-item .content h6 {
            font-size: 0.85rem;
        }

        .btn-back {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-history me-2"></i> Riwayat Rapor</h3>
                <div class="text-muted">Pilih rapor berdasarkan semester dan tahun ajaran</div>
            </div>
            <span class="badge-student">
                <i class="fas fa-user me-1"></i> {{ $siswa->nama_lengkap }}
            </span>
        </div>
    </div>

    <div class="mb-3">
        <a href="{{ route('kurikulum.rapor.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Siswa
        </a>
    </div>

    <div class="list-group-card">
        @forelse ($raports as $r)
            <a href="{{ route('kurikulum.rapor.detail', [$siswa->id, $r->semester, str_replace('/', '-', $r->tahun_ajaran)]) }}" 
               class="list-group-item">
                <div class="d-flex align-items-center flex-wrap" style="flex:1;">
                    <div class="icon-wrapper">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="content">
                        <h6>Semester <span class="badge-semester {{ strtolower($r->semester) }}">{{ $r->semester }}</span></h6>
                        <small><i class="fas fa-calendar-alt me-1"></i> {{ $r->tahun_ajaran }}</small>
                    </div>
                </div>
                <span class="badge-arrow">
                    Lihat Rapor <i class="fas fa-chevron-right" style="font-size:10px;"></i>
                </span>
            </a>
        @empty
            <div class="empty-state">
                <i class="fas fa-file-alt"></i>
                <h5>Belum ada rapor</h5>
                <p>Belum ada rapor tersimpan untuk siswa ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection