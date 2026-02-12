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

    /* Header Actions */
    .header-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        position: relative;
    }

    .header-actions .btn {
        white-space: nowrap;
    }

    /* Mobile Menu Dropdown */
    .mobile-menu-toggle {
        display: none;
        position: relative;
    }

    .mobile-menu-toggle .btn {
        width: 40px;
        height: 40px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    .mobile-dropdown {
        display: none;
        position: absolute;
        right: 0;
        top: 48px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        min-width: 200px;
        z-index: 1000;
        overflow: hidden;
    }

    .mobile-dropdown.show {
        display: block;
    }

    .mobile-dropdown a {
        display: block;
        padding: 12px 16px;
        color: #1E293B;
        text-decoration: none;
        border-bottom: 1px solid #E2E8F0;
        transition: background-color 0.2s;
    }

    .mobile-dropdown a:last-child {
        border-bottom: none;
    }

    .mobile-dropdown a:hover {
        background-color: #F8FAFC;
    }

    .mobile-dropdown a i {
        margin-right: 8px;
        width: 20px;
        display: inline-block;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .list-group-item {
        animation: fadeIn 0.5s ease-out;
    }

    /* ===================== RESPONSIVE STYLES ===================== */
    
    /* Tablet (768px - 991px) */
    @media (max-width: 991px) {
        h3.mb-3 {
            font-size: 26px;
        }

        .teacher-avatar {
            width: 55px;
            height: 55px;
            font-size: 22px;
        }

        .teacher-details strong {
            font-size: 16px;
        }
    }

    /* Mobile Large (576px - 767px) */
    @media (max-width: 767px) {
        .container {
            padding-left: 12px;
            padding-right: 12px;
        }

        h3.mb-3 {
            font-size: 20px;
            padding-left: 12px;
        }

        h3.mb-3::before {
            width: 4px;
        }

        /* Header with mobile menu */
        .d-flex.justify-content-between {
            align-items: center;
        }

        .d-flex.justify-content-between h3 {
            margin-bottom: 0 !important;
            flex: 1;
        }

        /* Hide desktop menu, show mobile menu */
        .header-actions > a,
        .header-actions > .btn {
            display: none !important;
        }

        .mobile-menu-toggle {
            display: block;
        }

        /* Filter Card */
        .card-body {
            padding: 12px !important;
        }

        .form-label {
            font-size: 12px !important;
            margin-bottom: 6px;
            font-weight: 600 !important;
        }

        .form-control, .form-select {
            font-size: 14px;
            padding: 10px 12px;
            height: auto;
        }

        .input-group-text {
            padding: 10px 12px;
        }

        /* Ensure form fields take full width */
        .row.g-3 > div {
            padding-left: 8px;
            padding-right: 8px;
        }

        /* Filter Buttons */
        .col-md-2 {
            width: 100%;
        }

        .col-md-2.d-flex {
            margin-top: 8px;
            gap: 8px !important;
        }

        .col-md-2.d-flex .btn {
            font-size: 14px;
            padding: 10px 16px;
        }

        /* List Items */
        .list-group-flush > .list-group-item {
            padding: 15px 12px;
        }

        .list-group-flush > .list-group-item:hover {
            padding-left: 16px;
        }

        .teacher-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .teacher-avatar {
            width: 50px;
            height: 50px;
            font-size: 20px;
            border-width: 2px;
        }

        .teacher-details {
            width: 100%;
        }

        .teacher-details strong {
            font-size: 16px;
        }

        .teacher-details small {
            font-size: 13px;
        }

        .teacher-classes .badge {
            font-size: 11px;
            padding: 4px 8px;
        }

        .teacher-actions {
            margin-left: 0;
            margin-top: 8px;
            width: 100%;
            justify-content: center;
        }

        .teacher-actions .btn-group {
            width: 100%;
        }

        .teacher-actions .btn-group .btn {
            flex: 1;
        }

        /* Empty State */
        .empty-state {
            padding: 40px 15px;
        }

        .empty-state i {
            font-size: 40px;
        }

        .empty-state h5 {
            font-size: 16px;
        }

        .empty-state p {
            font-size: 14px;
        }
    }

    /* Mobile Small (max 575px) */
    @media (max-width: 575px) {
        h3.mb-3 {
            font-size: 18px;
        }

        .teacher-details strong {
            font-size: 15px;
        }

        .teacher-details small {
            font-size: 12px;
        }

        .btn-sm {
            font-size: 12px;
            padding: 5px 10px;
        }
    }

    /* Desktop Large (1200px+) */
    @media (min-width: 1200px) {
        .container {
            max-width: 1140px;
        }

        h3.mb-3 {
            font-size: 30px;
        }

        .teacher-avatar {
            width: 65px;
            height: 65px;
            font-size: 26px;
        }

        .teacher-details strong {
            font-size: 19px;
        }

        .list-group-flush > .list-group-item {
            padding: 24px;
        }
    }

    /* Improve button group on mobile */
    @media (max-width: 767px) {
        .btn-group {
            display: flex;
            width: 100%;
        }

        .btn-group .btn {
            border-radius: 6px !important;
            margin: 0 2px;
        }

        .btn-group .btn:first-child {
            margin-left: 0;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .btn-group form {
            flex: 1;
            display: flex;
        }

        .btn-group form button {
            width: 100%;
        }
    }

    /* Pagination responsive */
    @media (max-width: 575px) {
        .pagination {
            font-size: 14px;
        }

        .pagination .page-link {
            padding: 6px 10px;
        }
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-3">Daftar Guru</h3>
        
        <!-- Desktop Menu -->
        <div class="header-actions">
            <a href="{{ route('kurikulum.guru.export', request()->only(['search','jurusan'])) }}" class="btn btn-outline-primary">
                <i class="fas fa-file-export"></i> Export
            </a>
            <a href="{{ route('kurikulum.guru.importForm') }}" class="btn btn-outline-secondary">
                <i class="fas fa-file-import"></i> Import
            </a>
            <a href="{{ route('kurikulum.guru.manage.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Guru
            </a>
            
            <!-- Mobile Menu Toggle -->
            <div class="mobile-menu-toggle">
                <button class="btn btn-outline-secondary" type="button" onclick="toggleMobileMenu()">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <div class="mobile-dropdown" id="mobileMenuDropdown">
                    <a href="{{ route('kurikulum.guru.export', request()->only(['search','jurusan'])) }}">
                        <i class="fas fa-file-export"></i> Export Excel
                    </a>
                    <a href="{{ route('kurikulum.guru.importForm') }}">
                        <i class="fas fa-file-import"></i> Import Excel
                    </a>
                    <a href="{{ route('kurikulum.guru.manage.create') }}">
                        <i class="fas fa-plus"></i> Tambah Guru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER CARD -->
    <div class="card mb-3" style="border-radius: 16px; border: none; box-shadow: var(--card-shadow);">
        <div class="card-body" style="background-color: #F8FAFC;">
            <form method="GET" action="{{ route('kurikulum.guru.index') }}" class="row g-3 align-items-end">
                <!-- Search -->
                <div class="col-md-4 col-12">
                    <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Cari Guru</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:white;border:1px solid #E2E8F0;"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Nama, NIP, email..." value="{{ $search ?? '' }}" style="border:1px solid #E2E8F0;">
                    </div>
                </div>

                <!-- Filter Jurusan -->
                <div class="col-md-3 col-sm-6 col-12">
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

                <!-- Filter Role -->
                <div class="col-md-3 col-sm-6 col-12">
                    <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Role</label>
                    <select name="role" class="form-select" style="border:1px solid #E2E8F0;">
                        <option value="">-- Semua Role --</option>
                        <option value="tu" {{ (isset($role) && $role == 'tu') ? 'selected' : '' }}>Tu</option>
                        <option value="kurikulum" {{ (isset($role) && $role == 'kurikulum') ? 'selected' : '' }}>Kurikulum</option>
                        @foreach(($allRoles ?? collect()) as $r)
                            <option value="{{ $r }}" {{ (isset($role) && $role == $r) ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $r)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-md-2 col-12 d-flex gap-2">
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
                                <small>{{ $g->nip }}</small>
                                @if($g->user?->role)
                                    <small style="color: #2F53FF; font-weight: 500;">
                                        Role: {{ ucfirst(str_replace('_', ' ', $g->user->role)) }}
                                    </small>
                                @endif
                                
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
                {{ $gurus->links('pagination::bootstrap-4') }}
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

<script>
function toggleMobileMenu() {
    const dropdown = document.getElementById('mobileMenuDropdown');
    dropdown.classList.toggle('show');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const toggle = document.querySelector('.mobile-menu-toggle');
    const dropdown = document.getElementById('mobileMenuDropdown');
    
    if (toggle && dropdown && !toggle.contains(event.target)) {
        dropdown.classList.remove('show');
    }
});
</script>
@endsection