@extends('layouts.app')

@section('title', 'Daftar Guru')

@section('content')
<style>
    /* ===================== STYLE DAFTAR GURU ===================== */
    
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

    h3.mb-3 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 25px !important;
    }

    h3.mb-3::before {
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
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    /* List Group Styles */
    .list-group {
        border-radius: 16px;
    }

    .list-group-flush > .list-group-item {
        border-width: 0 0 1px;
        border-color: #E2E8F0;
        padding: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .list-group-flush > .list-group-item:last-child {
        border-bottom: none;
    }

    .list-group-flush > .list-group-item::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        transform: scaleY(0);
        transition: transform 0.3s ease;
        border-radius: 0 4px 4px 0;
    }

    .list-group-flush > .list-group-item:hover {
        background-color: rgba(47, 83, 255, 0.03);
        padding-left: 25px;
    }

    .list-group-flush > .list-group-item:hover::before {
        transform: scaleY(1);
    }

    /* Teacher Info */
    .teacher-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .teacher-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 24px;
        flex-shrink: 0;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .list-group-item:hover .teacher-avatar {
        transform: scale(1.1);
    }

    .teacher-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .teacher-details {
        flex-grow: 1;
    }

    .teacher-details strong {
        font-size: 18px;
        font-weight: 600;
        color: #1E293B;
        display: block;
        margin-bottom: 4px;
    }

    .teacher-details small {
        color: #64748B;
        font-size: 14px;
        display: block;
        margin-bottom: 2px;
    }

    .teacher-classes {
        margin-top: 8px;
    }

    .teacher-classes .badge {
        margin-right: 5px;
        margin-bottom: 5px;
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 20px;
        background-color: rgba(47, 83, 255, 0.1);
        color: var(--primary-color);
    }

    .teacher-actions {
        margin-left: auto;
        display: flex;
        align-items: center;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748B;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .empty-state h5 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .list-group-item {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        h3.mb-3 {
            font-size: 24px;
        }
        
        .list-group-flush > .list-group-item {
            padding: 15px;
        }
        
        .teacher-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .teacher-actions {
            margin-left: 0;
            margin-top: 10px;
            width: 100%;
        }
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-3">Daftar Guru</h3>
        <div>
            <a href="{{ route('kurikulum.guru.importForm') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-file-import"></i> Import Excel
            </a>
            <a href="{{ route('kurikulum.guru.manage.create') }}" class="btn btn-primary">Tambah Guru</a>
        </div>
    </div>

    <!-- FILTER CARD -->
    <div class="card mb-3" style="border-radius: 16px; border: none; box-shadow: var(--card-shadow);">
        <div class="card-body" style="background-color: #F8FAFC;">
            <form method="GET" action="{{ route('kurikulum.guru.index') }}" class="row g-3 align-items-end">
                <!-- Search -->
                <div class="col-md-5">
                    <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Cari Guru</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:white;border:1px solid #E2E8F0;"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Nama, NIP, atau email..." value="{{ $search ?? '' }}" style="border:1px solid #E2E8F0;">
                    </div>
                </div>

                <!-- Filter Jurusan -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Jurusan</label>
                    <select name="jurusan" class="form-select" style="border:1px solid #E2E8F0;">
                        <option value="">-- Semua Jurusan --</option>
                        @foreach(($allJurusans ?? collect()) as $j)
                            <option value="{{ $j->id }}" {{ (isset($jurusan_id) && $jurusan_id == $j->id) ? 'selected' : '' }}>
                                {{ $j->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('kurikulum.guru.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        @if($gurus->count() > 0)
            <div class="list-group list-group-flush">
                @forelse($gurus as $g)
                    <div class="list-group-item">
                        <div class="teacher-info">
                            <div class="teacher-avatar">
                                @if($g->foto)
                                    <img src="{{ asset('storage/' . $g->foto) }}" alt="{{ $g->nama }}">
                                @else
                                    {{ strtoupper(substr($g->nama, 0, 1)) }}
                                @endif
                            </div>
                            <div class="teacher-details">
                                <strong>{{ $g->nama }}</strong>
                             
                                
                                @if($g->rombels && $g->rombels->count())
                                    <div class="teacher-classes">
                                       
                                        @foreach($g->rombels as $r)
                                            @php
                                                $kelas = $r->kelas;
                                            @endphp
                                            <span class="badge">
                                                {{ $kelas?->tingkat ? $kelas->tingkat . ' - ' . ($kelas->jurusan->nama ?? '') : '-' }} / {{ $r->nama }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="teacher-actions">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('kurikulum.guru.manage.show', $g->id) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kurikulum.guru.manage.edit', $g->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kurikulum.guru.manage.destroy', $g->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus guru ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <h5>Belum ada guru</h5>
                        <p>Belum ada data guru yang tersedia.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="d-flex justify-content-center mt-3 p-3">
                {{ $gurus->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-chalkboard-teacher"></i>
                <h5>Belum ada guru</h5>
                <p>Belum ada data guru yang tersedia.</p>
            </div>
        @endif
    </div>
</div>
@endsection