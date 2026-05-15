@extends('layouts.app')

@section('title', 'Data Jurusan')

@section('content')
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

/* ================= HEADER ================= */
.page-header {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
    border-radius: 30px;
    padding: 36px 36px 32px;
    margin-bottom: 30px;
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
    max-width: 640px;
    line-height: 1.7;
}

/* ================= BUTTON ================= */
.btn-modern {
    border: none;
    border-radius: 18px;
    padding: 12px 20px;
    font-size: 14px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: transform .3s ease, box-shadow .3s ease, background .3s ease;
    text-decoration: none;
    color: white;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
    color: white;
}

.btn-primary-modern {
    background: linear-gradient(135deg, #2F53FF 0%, #7C3AED 100%);
}

.btn-secondary-modern {
    background: linear-gradient(135deg, #4F46E5 0%, #22D3EE 100%);
}

/* ================= FILTER ================= */
.filter-card {
    background: white;
    border-radius: 24px;
    box-shadow: var(--shadow-light);
    margin-bottom: 28px;
    overflow: hidden;
}

.filter-card .card-body {
    padding: 28px;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 8px;
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

.input-group-text {
    border-radius: 14px 0 0 14px;
    border: 2px solid var(--soft-gray);
    background: white;
}

/* ================= TABLE ================= */
.data-table-card {
    background: white;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: var(--shadow-light);
    animation: fadeInUp .45s ease both;
}

.table {
    margin-bottom: 0;
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
    padding: 22px 20px;
    vertical-align: middle;
    border-top: 1px solid #EEF2F7;
    background: white;
}

.table-modern tbody tr {
    transition: transform .3s ease, box-shadow .3s ease, background .3s ease;
}

.table-modern tbody tr:hover {
    transform: translateY(-1px);
    background: #F8FBFF;
    box-shadow: 0 18px 35px rgba(47,83,255,0.08);
}

.table-modern td:first-child,
.table-modern th:first-child {
    width: 35%;
}

.table-modern td:last-child {
    width: 24%;
}

.status-badge {
    background: linear-gradient(135deg, #2F53FF 0%, #22D3EE 100%);
    color: white;
    border-radius: 999px;
    padding: 8px 14px;
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    margin: 3px 3px 3px 0;
    box-shadow: 0 10px 25px rgba(47,83,255,0.12);
    transition: transform .3s ease, box-shadow .3s ease;
}

.status-badge:hover {
    transform: translateY(-1px);
}

.jurusan-badge {
    color: #fff;
    border-radius: 999px;
    padding: 8px 14px;
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    margin: 3px 0;
    box-shadow: 0 10px 25px rgba(15,23,42,0.12);
    transition: transform .3s ease, box-shadow .3s ease, filter .3s ease;
    background: linear-gradient(135deg, #2563EB 0%, #38BDF8 100%);
    text-shadow: 0 1px 4px rgba(0,0,0,0.12);
}

.jurusan-badge:hover {
    transform: translateY(-1px);
}

.jurusan-badge[data-jurusan-code="RPL" i],
.jurusan-badge[data-jurusan-code="PPLG" i] {
    background: linear-gradient(135deg, #F59E0B 0%, #FCD34D 100%);
}

.jurusan-badge[data-jurusan-code="MP" i] {
    background: linear-gradient(135deg, #7F1D1D 0%, #991B1B 100%);
}

.jurusan-badge[data-jurusan-code="AK" i],
.jurusan-badge[data-jurusan-code="AKL" i] {
    background: linear-gradient(135deg, #F97316 0%, #FB923C 100%);
}

.jurusan-badge[data-jurusan-code="TJKT" i] {
    background: linear-gradient(135deg, #38BDF8 0%, #7DD3FC 100%);
}

.jurusan-badge[data-jurusan-code="TKRO" i],
.jurusan-badge[data-jurusan-code="TO" i] {
    background: linear-gradient(135deg, #1D4ED8 0%, #3B82F6 100%);
}

.jurusan-badge[data-jurusan-code="DPIB" i] {
    background: linear-gradient(135deg, #6B7280 0%, #9CA3AF 100%);
}

.jurusan-badge[data-jurusan-code="SP" i],
.jurusan-badge[data-jurusan-code="SK" i] {
    background: linear-gradient(135deg, #0F172A 0%, #374151 100%);
}

/* ================= ACTION ================= */
.action-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.action-btn {
    width: 44px;
    height: 44px;
    border-radius: 16px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform .3s ease, box-shadow .3s ease, background .3s ease;
    color: white;
    font-size: 0.95rem;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.action-btn.view {
    background: linear-gradient(135deg,#06B6D4,#3B82F6);
}

.action-btn.edit {
    background: linear-gradient(135deg,#F59E0B,#F97316);
}

.action-btn.delete {
    background: linear-gradient(135deg,#EF4444,#DC2626);
}

/* ================= EMPTY ================= */
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

/* ================= PAGINATION ================= */
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
}

.page-item.active .page-link {
    background: linear-gradient(135deg,var(--primary-blue),var(--secondary-blue));
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(18px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ================= MOBILE ================= */
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

/* ================= RESPONSIVE ================= */
@media(max-width:768px) {
    .page-header {
        padding: 24px;
    }

    .page-title {
        font-size: 24px;
    }

    .filter-card .card-body {
        padding: 20px;
    }

    .table thead {
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
        justify-content: start;
    }

    .header-actions > a {
        display: none;
    }

    .mobile-menu-toggle {
        display: block;
    }
}
</style>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h1 class="page-title">
                    <i class="fas fa-graduation-cap"></i>
                    Manajemen Jurusan
                </h1>

                <p class="page-subtitle">
                    Kelola daftar jurusan sekolah dengan antarmuka premium dan konsisten.
                </p>
            </div>

            <div class="header-actions d-flex gap-2 align-items-center">

                <a href="{{ route('super_admin.manajemen-jurusan.create') }}"
                   class="btn-modern btn-primary-modern">
                    <i class="fas fa-plus"></i>
                    Tambah Jurusan
                </a>

                <div class="mobile-menu-toggle">

                    <button class="btn-modern btn-secondary-modern"
                            onclick="toggleMobileMenu()">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>

                    <div class="mobile-dropdown" id="mobileMenuDropdown">
                        <a href="{{ route('super_admin.manajemen-jurusan.create') }}">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Jurusan
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- FILTER -->
    <div class="filter-card">
        <div class="card-body">
            <form method="GET"
                  action="{{ route('super_admin.manajemen-jurusan.index') }}"
                  class="row g-4 align-items-end">

                <div class="col-lg-6 col-md-8">
                    <label class="form-label">Cari Jurusan</label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>

                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Nama atau kode jurusan"
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-lg-2 col-md-4">
                    <button type="submit"
                            class="btn-modern btn-primary-modern w-100 justify-content-center">
                        <i class="fas fa-search"></i>
                        Cari
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- TABLE -->
    <div class="data-table-card">

        @if($jurusans->count() > 0)

            <div class="table-responsive">

                <table class="table align-middle table-modern">

                    <thead>
                        <tr>
                            <th>Jurusan</th>
                            <th>Kode</th>
                            <th>Total Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($jurusans as $jurusan)
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ $jurusan->nama }}
                                    </div>
                                </td>

                                <td>
                                    <span class="status-badge jurusan-badge" data-jurusan-code="{{ $jurusan->kode ?? '' }}">
                                        {{ $jurusan->kode ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="text-muted">
                                        {{ $jurusan->kelas->count() }} kelas
                                    </span>
                                </td>

                                <td>
                                    <div class="action-buttons">

                                        <a href="{{ route('super_admin.manajemen-jurusan.show', $jurusan->id) }}"
                                           class="action-btn view"
                                           title="Detail Jurusan">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('super_admin.manajemen-jurusan.edit', $jurusan->id) }}"
                                           class="action-btn edit"
                                           title="Edit Jurusan">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('super_admin.manajemen-jurusan.destroy', $jurusan->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="action-btn delete"
                                                    title="Hapus Jurusan">
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
                {{ $jurusans->links('pagination::bootstrap-4') }}
            </div>

        @else

            <div class="empty-state">
                <i class="fas fa-graduation-cap"></i>

                <h5>Belum ada data jurusan</h5>

                <p>
                    Silakan tambahkan jurusan terlebih dahulu untuk mulai mengelola data.
                </p>
            </div>

        @endif

    </div>

</div>

<script>
function toggleMobileMenu() {
    const dropdown = document.getElementById('mobileMenuDropdown');
    dropdown.classList.toggle('show');
}

document.addEventListener('click', function(event) {
    const toggle = document.querySelector('.mobile-menu-toggle');
    const dropdown = document.getElementById('mobileMenuDropdown');
    if (toggle && dropdown && !toggle.contains(event.target)) {
        dropdown.classList.remove('show');
    }
});
</script>

@endsection