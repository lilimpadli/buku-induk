@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<style>
    /* ===================== STYLE DATA KELAS ===================== */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        --bg-light: #f7fafc;
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* ===== PAGE TITLE BAR ===== */
    .page-title-bar {
        background: var(--primary-gradient);
        color: white;
        padding: 1.75rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        overflow: hidden;
    }

    .page-title-bar::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 260px;
        height: 260px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        transform: translate(90px, -90px);
    }

    .page-title-bar .title-inner {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .page-title-bar h1 {
        font-weight: 700;
        font-size: 1.6rem;
        margin-bottom: 0.2rem;
    }

    .page-title-bar .subtitle {
        color: rgba(255, 255, 255, 0.75);
        font-size: 13px;
        margin-bottom: 0;
    }

    .btn-add {
        background: rgba(255, 255, 255, 0.2);
        border: 1.5px solid rgba(255, 255, 255, 0.45);
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.1rem;
        border-radius: 10px;
        font-size: 13.5px;
        white-space: nowrap;
        flex-shrink: 0;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-add:hover {
        background: rgba(255, 255, 255, 0.35);
        border-color: white;
        color: white;
    }

    /* ===== FILTER BAR ===== */
    .filter-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        background: white;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .filter-card .card-body {
        padding: 1.25rem 1.5rem;
    }

    .filter-label {
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 0.4rem;
        display: block;
    }

    .filter-input {
        border: 1.5px solid #E2E8F0;
        border-radius: 10px;
        padding: 0.55rem 0.9rem;
        font-size: 14px;
        color: #334155;
        transition: var(--transition);
        width: 100%;
        background: #FAFBFC;
    }

    .filter-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.12);
        background: white;
        outline: none;
    }

    .filter-input::placeholder { color: #94A3B8; }

    .input-icon-wrap {
        position: relative;
    }

    .input-icon-wrap .icon-left {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
        font-size: 14px;
        pointer-events: none;
    }

    .input-icon-wrap .filter-input {
        padding-left: 2.1rem;
    }

    .btn-filter-primary {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.55rem 1.2rem;
        border-radius: 10px;
        font-size: 14px;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-filter-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.35);
    }

    .btn-filter-reset {
        background: #F1F5F9;
        border: 1.5px solid #E2E8F0;
        color: #64748B;
        font-weight: 600;
        padding: 0.55rem 1.2rem;
        border-radius: 10px;
        font-size: 14px;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-filter-reset:hover {
        background: #E8ECF0;
        color: #475569;
    }

    /* ===== PAGINATION INFO ===== */
    .pagination-info {
        font-size: 13px;
        color: #94A3B8;
        margin-bottom: 1rem;
    }

    /* ===== ROMBEL CARDS ===== */
    .rombel-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        background: white;
        overflow: hidden;
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .rombel-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--card-hover-shadow);
    }

    .rombel-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: var(--primary-gradient);
    }

    .rombel-card.card-highlighted {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .rombel-card.card-highlighted::before {
        background: rgba(255,255,255,0.3);
    }

    .rombel-card-body {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .rombel-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 1rem;
    }

    .rombel-card-title {
        font-weight: 700;
        font-size: 1.05rem;
        color: #1E293B;
        margin-bottom: 0;
    }

    .card-highlighted .rombel-card-title { color: white; }

    .rombel-id-badge {
        background: rgba(100, 116, 139, 0.12);
        color: #475569;
        font-weight: 600;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 6px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .card-highlighted .rombel-id-badge {
        background: rgba(255,255,255,0.2);
        color: rgba(255,255,255,0.9);
    }

    .rombel-meta-row {
        font-size: 13.5px;
        color: #64748B;
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rombel-meta-row i {
        width: 14px;
        text-align: center;
        color: #94A3B8;
        flex-shrink: 0;
    }

    .card-highlighted .rombel-meta-row { color: rgba(255,255,255,0.7); }
    .card-highlighted .rombel-meta-row i { color: rgba(255,255,255,0.5); }

    .rombel-card-footer {
        margin-top: auto;
        padding-top: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
    }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 0.45rem 0.9rem;
        border-radius: 8px;
        border: 1.5px solid #E2E8F0;
        color: #667eea;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-detail:hover {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }

    .card-highlighted .btn-detail {
        border-color: rgba(255,255,255,0.4);
        color: white;
        background: rgba(255,255,255,0.15);
    }

    .card-highlighted .btn-detail:hover {
        background: rgba(255,255,255,0.3);
        border-color: white;
        color: white;
    }

    /* ===== DROPDOWN ===== */
    .btn-more {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1.5px solid #E2E8F0;
        background: white;
        color: #64748B;
        font-size: 13px;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-more:hover {
        border-color: #667eea;
        color: #667eea;
        background: rgba(102, 126, 234, 0.06);
    }

    .card-highlighted .btn-more {
        border-color: rgba(255,255,255,0.4);
        background: rgba(255,255,255,0.15);
        color: white;
    }

    .card-highlighted .btn-more:hover {
        background: rgba(255,255,255,0.3);
        border-color: white;
    }

    .dropdown-menu {
        border-radius: 12px;
        border: none;
        box-shadow: var(--card-hover-shadow);
        padding: 6px;
        min-width: 160px;
    }

    .dropdown-item {
        border-radius: 8px;
        padding: 0.55rem 0.85rem;
        font-size: 14px;
        font-weight: 500;
        color: #334155;
        transition: background 0.15s ease, color 0.15s ease;
    }

    .dropdown-item:hover {
        background-color: rgba(102, 126, 234, 0.08);
        color: #667eea;
    }

    .dropdown-item.text-danger { color: #EF4444; }
    .dropdown-item.text-danger:hover {
        background-color: rgba(239, 68, 68, 0.08);
        color: #EF4444;
    }

    .dropdown-divider {
        margin: 4px 0;
        border-color: #E2E8F0;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
    }

    .empty-state i {
        font-size: 2.5rem;
        color: #94A3B8;
        margin-bottom: 0.75rem;
        display: block;
    }

    .empty-state p {
        color: #64748B;
        font-size: 15px;
        margin-bottom: 0;
    }

    /* ===== PAGINATION ===== */
    .pagination { margin-bottom: 0; }

    .page-link {
        border: none;
        margin: 0 2px;
        border-radius: 8px;
        color: #64748B;
        font-weight: 600;
        font-size: 14px;
        padding: 0.45rem 0.75rem;
        transition: var(--transition);
    }

    .page-link:hover {
        background-color: rgba(102, 126, 234, 0.08);
        color: #667eea;
    }

    .page-item.active .page-link {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
    }

    .page-item.disabled .page-link {
        color: #CBD5E1;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .rombel-card {
        animation: fadeIn 0.45s ease-out both;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 767.98px) {
        .page-title-bar {
            padding: 1.25rem 1rem;
        }

        .page-title-bar h1 {
            font-size: 1.3rem;
        }

        .page-title-bar .subtitle {
            font-size: 12px;
        }

        .btn-add {
            padding: 0.4rem 0.8rem;
            font-size: 13px;
        }

        .filter-card .card-body {
            padding: 1rem;
        }

        .filter-actions {
            flex-direction: column;
        }

        .filter-actions .btn-filter-primary,
        .filter-actions .btn-filter-reset {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 mt-3">

    {{-- PAGE TITLE BAR --}}
    <div class="page-title-bar">
        <div class="title-inner">
            <div>
                <h1>Data Rombel</h1>
                <p class="subtitle">Kelola rombel belajar per kelas dan jurusan</p>
            </div>
            <a href="{{ route('kurikulum.kelas.create') }}" class="btn-add">
                <i class="fas fa-plus"></i> Tambah Rombel
            </a>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="filter-card">
        <div class="card-body">
            <form action="{{ route('kurikulum.kelas.index') }}" method="GET">
                <div class="row g-3 align-items-end">

                    {{-- Search --}}
                    <div class="col-12 col-md-5">
                        <label class="filter-label">Cari Rombel</label>
                        <div class="input-icon-wrap">
                            <i class="bi bi-search icon-left"></i>
                            <input type="text" name="search" class="filter-input" placeholder="Nama rombel, tingkat, jurusan..." value="{{ $search ?? '' }}">
                        </div>
                    </div>

                    {{-- Filter Jurusan --}}
                    <div class="col-12 col-md-4">
                        <label class="filter-label">Jurusan</label>
                        <select name="jurusan" class="filter-input">
                            <option value="">-- Semua Jurusan --</option>
                            @foreach(($allJurusans ?? collect()) as $j)
                                <option value="{{ $j->id }}" {{ (isset($jurusan_id) && $jurusan_id == $j->id) ? 'selected' : '' }}>
                                    {{ $j->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-12 col-md-3">
                        <div class="d-flex gap-2 filter-actions">
                            <button type="submit" class="btn-filter-primary">
                                <i class="bi bi-search"></i> Cari
                            </button>
                            <a href="{{ route('kurikulum.kelas.index') }}" class="btn-filter-reset">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- PAGINATION INFO --}}
    @if($rombels->total() > 0)
        <p class="pagination-info">
            Menampilkan {{ $rombels->firstItem() }}–{{ $rombels->lastItem() }} dari {{ $rombels->total() }} rombel
        </p>
    @endif

    {{-- ROMBEL CARDS --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
        @forelse($rombels as $index => $rombel)
            <div class="col">
                <div class="rombel-card {{ $rombel->id == 5 ? 'card-highlighted' : '' }}" style="animation-delay: {{ $index * 0.06 }}s;">
                    <div class="rombel-card-body">

                        {{-- Top: Nama + ID Badge --}}
                        <div class="rombel-card-top">
                            <h5 class="rombel-card-title">{{ $rombel->nama }}</h5>
                            <span class="rombel-id-badge">ID: {{ $rombel->id }}</span>
                        </div>

                        {{-- Meta Info --}}
                        <div class="rombel-meta-row">
                            <i class="fas fa-school"></i>
                            {{ $rombel->kelas->tingkat ?? '-' }} {{ $rombel->kelas->jurusan->nama ?? '-' }}
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <div class="d-flex gap-2">
                                <a href="{{ route('kurikulum.kelas.show', $rombel->id) }}" 
                                   class="btn {{ $rombel->id == 5 ? 'btn-light' : 'btn-outline-primary' }} btn-sm">
                                    <i class="fas fa-info-circle me-1"></i> Detail
                                </a>

                                <a href="{{ route('kurikulum.kelas.export', $rombel->id) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-file-excel me-1"></i> Export
                                </a>
                            </div>
                            
                            <div class="dropdown">
                                <button class="btn-more dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="display:inline-flex;">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('kurikulum.kelas.edit', $rombel->id) }}">
                                            <i class="fas fa-pen me-2"></i> Edit
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('kurikulum.kelas.destroy', $rombel->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus rombel ini?')">
                                                <i class="fas fa-trash me-2"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-layer-group"></i>
                    <p>Tidak ada data rombel yang ditemukan.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($rombels->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $rombels->links('pagination::bootstrap-4') }}
        </div>
    @endif

</div>

@endsection