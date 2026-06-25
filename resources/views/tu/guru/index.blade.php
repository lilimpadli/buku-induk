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

    /* Filter Card */
    .filter-card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
    }

    .filter-card .card-body {
        background-color: #F8FAFC;
        padding: 1.25rem;
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

    .list-group-flush > .list-group-item:hover::before {
        transform: scaleY(1);
    }

    /* Teacher Info */
    .teacher-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
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
        flex: 1;
        min-width: 0;
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
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .teacher-classes .badge {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 20px;
        background-color: rgba(47, 83, 255, 0.1);
        color: var(--primary-color);
        font-weight: 500;
    }

    .teacher-actions {
        flex-shrink: 0;
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

    /* Form Controls */
    .form-control, .form-select {
        border: 1px solid #E2E8F0;
        border-radius: 8px;
    }

    .input-group-text {
        background: white;
        border: 1px solid #E2E8F0;
        border-right: none;
    }

    .input-group .form-control {
        border-left: none;
    }

    /* Responsive */
    @media (max-width: 992px) {
        h3.mb-3 {
            font-size: 26px;
        }

        .teacher-avatar {
            width: 55px;
            height: 55px;
            font-size: 22px;
        }

        .teacher-details strong {
            font-size: 17px;
        }
    }

    @media (max-width: 768px) {
        h3.mb-3 {
            font-size: 24px;
            padding-left: 12px;
        }

        h3.mb-3::before {
            width: 4px;
        }

        .filter-card .card-body {
            padding: 1rem;
        }

        .form-label {
            font-size: 13px !important;
            margin-bottom: 0.4rem !important;
        }
        
        .list-group-flush > .list-group-item {
            padding: 15px;
        }

        .list-group-flush > .list-group-item:hover {
            padding-left: 20px;
        }
        
        .teacher-info {
            gap: 12px;
        }

        .teacher-avatar {
            width: 50px;
            height: 50px;
            font-size: 20px;
            border-width: 2px;
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

        .teacher-actions .btn {
            font-size: 0.875rem;
            padding: 0.4rem 0.75rem;
        }

        .empty-state {
            padding: 40px 15px;
        }

        .empty-state i {
            font-size: 40px;
        }
    }

    @media (max-width: 576px) {
        h3.mb-3 {
            font-size: 20px;
            padding-left: 10px;
        }

        .filter-card .card-body {
            padding: 0.875rem;
        }

        .form-label {
            font-size: 12px !important;
        }

        .form-control, .form-select {
            font-size: 0.875rem;
            padding: 6px 10px;
        }

        .input-group-text {
            padding: 6px 10px;
            font-size: 0.875rem;
        }

        .btn {
            font-size: 0.875rem;
            padding: 6px 12px;
        }

        .list-group-flush > .list-group-item {
            padding: 12px;
        }

        .list-group-flush > .list-group-item:hover {
            padding-left: 17px;
        }
        
        .teacher-info {
            gap: 10px;
        }

        .teacher-avatar {
            width: 45px;
            height: 45px;
            font-size: 18px;
        }

        .teacher-details strong {
            font-size: 15px;
        }

        .teacher-details small {
            font-size: 12px;
        }

        .teacher-classes {
            margin-top: 6px;
        }

        .teacher-classes .badge {
            font-size: 10px;
            padding: 3px 7px;
        }

        .teacher-actions {
            width: 100%;
            order: 3;
        }

        .teacher-actions .btn {
            width: 100%;
            font-size: 0.8rem;
            padding: 0.45rem 0.75rem;
        }

        .empty-state {
            padding: 30px 12px;
        }

        .empty-state i {
            font-size: 36px;
        }

        .empty-state h5 {
            font-size: 1rem;
        }

        .empty-state p {
            font-size: 0.875rem;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-3">Daftar Guru</h3>
        <a href="{{ route('tu.guru.export') }}" class="btn btn-success btn-sm">
            <i class="fas fa-file-excel me-1"></i> Export Guru (2 Halaman)
        </a>
    </div>

    <!-- FILTER CARD -->
    <div class="card filter-card mb-3 mb-md-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tu.guru.index') }}" class="row g-2 g-md-3 align-items-end">
                <!-- Search -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Cari Guru</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Nama, NIP, atau email..." value="{{ $search ?? '' }}">
                    </div>
                </div>

                <!-- Filter Role -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Role</label>
                    <select name="role" class="form-select" style="border:1px solid #E2E8F0;">
                        <option value="">-- Semua Role --</option>
                        @foreach($roleOptions as $key => $label)
                            <option value="{{ $key }}" {{ (isset($role_filter) && $role_filter == $key) ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Jurusan -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Jurusan</label>
                    <select name="jurusan" class="form-select">
                        <option value="">-- Semua Jurusan --</option>
                        @foreach(($allJurusans ?? collect()) as $j)
                            <option value="{{ $j->id }}" {{ (isset($jurusan_id) && $jurusan_id == $j->id) ? 'selected' : '' }}>
                                {{ $j->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('tu.guru.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        @if($gurus->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 4%;">#</th>
                            <th style="width: 18%;">Nama</th>
                            <th style="width: 12%;">NIP</th>
                            <th style="width: 16%;">Status Kepegawaian</th>
                            <th style="width: 12%;">Pendidikan</th>
                            <th style="width: 14%;">Gelar Depan</th>
                            <th style="width: 14%;">Gelar Belakang</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $u)
                            <tr>
                                <td>{{ $loop->iteration + ($gurus->currentPage() - 1) * $gurus->perPage() }}</td>
                                <td>{{ $u->name ?? '-' }}</td>
                                <td>{{ optional($u->guru)->nip ?? '-' }}</td>
                                <td>{{ optional($u->guru)->status_kepegawaian ?? '-' }}</td>
                                <td>{{ optional($u->guru)->pendidikan ?? '-' }}</td>
                                <td>{{ optional($u->guru)->gelar_depan ?? '-' }}</td>
                                <td>{{ optional($u->guru)->gelar_belakang ?? '-' }}</td>
                                <td>
                                    @if($u->guru)
                                        <a href="{{ route('tu.guru.show', $u->guru->id) }}" class="btn btn-sm btn-primary">
                                            Detail
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">Data guru tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
@endsection