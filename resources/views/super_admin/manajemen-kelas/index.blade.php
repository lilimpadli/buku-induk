@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('content')
<div class="container-fluid">
    <!-- HEADER -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-school"></i>
                    Manajemen Kelas
                </h1>
                <p class="page-subtitle">
                    Kelola rombel, kelas, wali kelas, dan cetak data siswa dengan tampilan dashboard modern.
                </p>
            </div>
            <div class="header-actions d-flex gap-2 align-items-center">
                <a href="{{ route('super_admin.manajemen-kelas.create') }}" class="btn-modern btn-primary-modern">
                    <i class="fas fa-plus"></i>
                    Tambah Kelas
                </a>
                <div class="mobile-menu-toggle">
                    <button class="btn-modern btn-secondary-modern" onclick="toggleMobileMenu()">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="mobile-dropdown" id="mobileMenuDropdown">
                        <a href="{{ route('super_admin.manajemen-kelas.create') }}">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Kelas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER -->
    <div class="filter-card">
        <div class="card-body">
            <form method="GET" class="row g-4 align-items-end" action="{{ route('super_admin.manajemen-kelas.index') }}">
                <div class="col-lg-5 col-md-6">
                    <label for="search" class="form-label">Cari</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" id="search" name="search" class="form-control" value="{{ $search }}" placeholder="Nama rombel, tingkat, jurusan, wali kelas">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="jurusan" class="form-label">Filter Jurusan</label>
                    <select id="jurusan" name="jurusan" class="form-select">
                        <option value="">Semua Jurusan</option>
                        @foreach($allJurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ $jurusan->id == $jurusan_id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-12">
                    <button type="submit" class="btn-modern btn-primary-modern w-100 justify-content-center">
                        <i class="fas fa-filter"></i>
                        Terapkan
                    </button>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        </div>
    </div>

    <!-- TABLE -->
    <div class="data-table-card">
        @if($rombels->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle table-modern mb-0">
                    <thead>
                        <tr>
                            <th style="width: 48px;">#</th>
                            <th>Nama Rombel</th>
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Wali Kelas</th>
                            <th>Jumlah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rombels as $rombel)
                            <tr>
                                <td>{{ $loop->iteration + ($rombels->currentPage() - 1) * $rombels->perPage() }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $rombel->nama }}</div>
                                </td>
                                <td>
                                    <span class="status-badge">{{ $rombel->kelas->tingkat ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="status-badge jurusan-badge" data-jurusan-code="{{ optional($rombel->kelas->jurusan)->kode ?? '' }}">{{ optional($rombel->kelas->jurusan)->nama ?? '-' }}</span>
                                </td>
                                <td>{{ optional($rombel->guru)->nama ?? '-' }}</td>
                                <td>
                                    <span class="pill-badge">{{ $rombel->siswa->count() }} siswa</span>
                                </td>
                                <td>
                                    <div class="action-buttons justify-content-center">
                                        <a href="{{ route('super_admin.manajemen-kelas.show', $rombel->id) }}" class="btn-modern btn-sm btn-action-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('super_admin.manajemen-kelas.edit', $rombel->id) }}" class="btn-modern btn-sm btn-action-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('super_admin.manajemen-kelas.export', $rombel->id) }}" class="btn-modern btn-sm btn-action-success" title="Cetak">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <form action="{{ route('super_admin.manajemen-kelas.destroy', $rombel->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-modern btn-sm btn-action-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus rombel ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-container">
                {{ $rombels->links('pagination::bootstrap-4') }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-layer-group"></i>
                <h5>Belum ada rombel</h5>
                <p>Tambahkan kelas baru untuk mulai mengelola data rombel sekolah.</p>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
:root {
    --primary-blue: #2F53FF;
    --secondary-blue: #7C3AED;
    --accent-cyan: #00D4FF;
    --accent-pink: #FF4D6D;
    --accent-green: #43E97B;
    --light-bg: #F4F7FE;
    --soft-gray: #E9EEF7;
    --text-dark: #1E293B;
    --text-muted: #64748B;
    --shadow-light: 0 4px 18px rgba(15,23,42,0.06);
    --shadow-medium: 0 12px 30px rgba(15,23,42,0.08);
    --shadow-hover: 0 16px 40px rgba(47,83,255,0.16);
    --radius: 24px;
}

body {
    font-family: 'Poppins', sans-serif;
    background: var(--light-bg);
}

.page-header {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
    border-radius: 30px;
    padding: 32px 32px 28px;
    margin-bottom: 28px;
    color: white;
    box-shadow: var(--shadow-medium);
    animation: fadeInUp .45s ease both;
}

.page-title {
    font-size: 2.25rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 10px;
}

.page-subtitle {
    opacity: .88;
    margin: 0;
    font-size: 1rem;
    max-width: 620px;
    line-height: 1.7;
}

.btn-modern {
    border: none;
    border-radius: 18px;
    padding: 12px 20px;
    font-size: 14px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: transform .3s ease, box-shadow .3s ease, background .3s ease;
    text-decoration: none;
    color: white;
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
    color: white;
}

.btn-modern.btn-sm {
    width: 42px;
    height: 42px;
    padding: 0;
    font-size: 14px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-modern.btn-sm i {
    width: 18px;
    height: 18px;
}

.btn-primary-modern {
    background: linear-gradient(135deg, #2F53FF 0%, #7C3AED 100%);
}

.btn-secondary-modern {
    background: linear-gradient(135deg, #4F46E5 0%, #22D3EE 100%);
}

.btn-action-info {
    background: linear-gradient(135deg,#06B6D4,#3B82F6);
}

.btn-action-warning {
    background: linear-gradient(135deg,#F59E0B,#F97316);
}

.btn-action-success {
    background: linear-gradient(135deg,#22C55E,#14B8A6);
}

.btn-action-danger {
    background: linear-gradient(135deg,#EF4444,#DC2626);
}

.filter-card,
.data-table-card {
    background: white;
    border-radius: 24px;
    box-shadow: var(--shadow-light);
    margin-bottom: 28px;
    overflow: hidden;
}

.filter-card .card-body,
.data-table-card .card-body {
    padding: 28px;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 10px;
}

.form-control,
.form-select {
    border-radius: 14px;
    border: 2px solid var(--soft-gray);
    padding: 12px 16px;
    transition: .3s ease;
    box-shadow: none;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 4px rgba(47,83,255,.1);
}

.input-group {
    border-radius: 16px;
    overflow: hidden;
    border: 2px solid var(--soft-gray);
    display: flex;
    align-items: center;
    background: white;
}

.input-group .form-control {
    border: none;
    box-shadow: none;
}

.input-group-text {
    border: none;
    background: white;
    color: var(--text-muted);
    padding: 0 16px;
}

.data-table-card {
    animation: fadeInUp .45s ease both;
}

.table-modern {
    width: 100%;
    min-width: 100%;
    border-collapse: separate;
    border-spacing: 0 0.85rem;
}

.table-modern thead th {
    background: #EFF6FF;
    border: none;
    padding: 22px 20px;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--text-muted);
    font-weight: 700;
}

.table-modern tbody td {
    padding: 20px;
    vertical-align: middle;
    border: none;
    background: white;
}

.table-modern tbody tr {
    transition: transform .3s ease, box-shadow .3s ease, background .3s ease;
    box-shadow: 0 8px 20px rgba(15,23,42,0.04);
    border-radius: 24px;
}

.table-modern tbody tr:hover {
    transform: translateY(-1px);
    background: #F8FBFF;
    box-shadow: 0 18px 35px rgba(47,83,255,0.08);
}

.table-modern tbody tr td:first-child {
    width: 48px;
}

.status-badge {
    background: linear-gradient(135deg, #2F53FF 0%, #22D3EE 100%);
    color: white;
    border-radius: 999px;
    padding: 8px 14px;
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    margin: 3px 0;
    box-shadow: 0 10px 25px rgba(47,83,255,0.12);
    transition: transform .3s ease, box-shadow .3s ease;
}

.pill-badge {
    background: rgba(47,83,255,.08);
    color: var(--text-dark);
    border-radius: 999px;
    padding: 8px 14px;
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
}

.action-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
}

.empty-state {
    padding: 80px 20px;
    text-align: center;
}

.empty-state i {
    font-size: 60px;
    margin-bottom: 16px;
    color: var(--primary-blue);
    opacity: .3;
}

.empty-state h5 {
    font-weight: 700;
    margin-bottom: 8px;
}

.empty-state p {
    color: var(--text-muted);
}

.pagination-container {
    padding: 24px;
}

.pagination {
    justify-content: center;
}

.page-link {
    border: none;
    border-radius: 12px !important;
    margin: 0 4px;
    color: var(--text-dark);
    transition: all .3s ease;
}

.page-link:hover {
    background: rgba(47,83,255,0.08);
}

.page-item.active .page-link {
    background: linear-gradient(135deg,var(--primary-blue),var(--secondary-blue));
    color: white;
}

.mobile-menu-toggle {
    display: none;
    position: relative;
}

.mobile-dropdown {
    display: none;
    position: absolute;
    top: 55px;
    right: 0;
    background: white;
    min-width: 220px;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-medium);
    z-index: 100;
}

.mobile-dropdown.show {
    display: block;
}

.mobile-dropdown a {
    display: block;
    padding: 14px 18px;
    text-decoration: none;
    color: var(--text-dark);
    border-bottom: 1px solid #EEF2F7;
}

.mobile-dropdown a:hover {
    background: #F8FAFC;
}

@media(max-width:768px) {
    .page-header {
        padding: 24px;
    }

    .page-title {
        font-size: 24px;
    }

    .filter-card .card-body,
    .data-table-card .card-body {
        padding: 20px;
    }

    .table-modern thead {
        display: none;
    }

    .table,
    .table tbody,
    .table tr,
    .table td {
        display: block;
        width: 100%;
    }

    .table tr {
        margin-bottom: 16px;
        border-bottom: 1px solid #E5E7EB;
    }

    .table td {
        padding: 14px 18px;
    }

    .action-buttons {
        justify-content: flex-start;
    }

    .header-actions > a {
        display: none;
    }

    .mobile-menu-toggle {
        display: block;
    }
}
</style>
@endpush
@endsection
