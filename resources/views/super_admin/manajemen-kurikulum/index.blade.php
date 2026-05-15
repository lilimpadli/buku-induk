@extends('layouts.app')

@section('title', 'Daftar Kurikulum TU Kepegawaian')

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
    max-width: 680px;
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

.table-modern {
    width: 100%;
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

.table-modern th,
.table-modern td {
    border: none;
    padding: 18px 20px;
}

.action-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
}

.action-btn {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    border: none;
    color: white;
    transition: transform .3s ease, box-shadow .3s ease, background .3s ease;
    box-shadow: var(--shadow-light);
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

.empty-state {
    padding: 70px 20px;
    text-align: center;
}

.empty-state i {
    font-size: 50px;
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
}
</style>

<div class="container-fluid">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-book"></i>
                    Daftar Kurikulum TU Kepegawaian
                </h1>
                <p class="page-subtitle">
                    Kelola kurikulum dengan tampilan dashboard yang modern, konsisten, dan profesional.
                </p>
            </div>
            <div class="header-actions d-flex gap-2 align-items-center">
                <a href="{{ route('super_admin.manajemen-kurikulum.create') }}" class="btn-modern btn-primary-modern">
                    <i class="fas fa-plus"></i>
                    Tambah Kurikulum
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('super_admin.manajemen-kurikulum.index') }}" class="row g-4 align-items-end">
                <div class="col-lg-8 col-md-7">
                    <label class="form-label">Cari Kurikulum</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Nama kurikulum..." value="{{ $search ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-4 col-md-5">
                    <button class="btn-modern btn-primary-modern w-100 justify-content-center" type="submit">
                        <i class="fas fa-search"></i>
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="data-table-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-modern mb-0">
                    <thead>
                        <tr>
                            <th style="width: 48px;">#</th>
                            <th>Nama Kurikulum</th>
                            <th>Jumlah Mata Pelajaran</th>
                            <th>Dibuat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kurikulum as $k)
                            <tr>
                                <td>{{ $loop->iteration + ($kurikulum->currentPage() - 1) * $kurikulum->perPage() }}</td>
                                <td><div class="fw-semibold text-dark">{{ $k->nama_kurikulum }}</div></td>
                                <td><span class="status-badge">{{ $k->mata_pelajarans_count }} mata pelajaran</span></td>
                                <td>{{ $k->created_at->format('d/m/Y') }}</td>

                                <td>
                                    <div class="action-buttons justify-content-center">
                                        <a href="{{ route('super_admin.manajemen-kurikulum.show', $k->id) }}" class="action-btn view" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('super_admin.manajemen-kurikulum.edit', $k->id) }}" class="action-btn edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('super_admin.manajemen-kurikulum.destroy', $k->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kurikulum ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            <td class="text-center">
                                <div class="d-inline-flex">

                                    {{-- Detail --}}
                                    <a href="{{ route('super_admin.manajemen-kurikulum.show', $k->id) }}"
                                    class="btn btn-info text-dark rounded-start rounded-0 border-0">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('super_admin.manajemen-kurikulum.edit', $k->id) }}"
                                    class="btn btn-warning text-dark rounded-0 border-0">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form method="POST"
                                        action="{{ route('super_admin.manajemen-kurikulum.destroy', $k->id) }}"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus kurikulum ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger rounded-end rounded-0 border-0">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-book-open"></i>
                                        <h5>Tidak ada kurikulum</h5>
                                        <p>Silakan tambahkan kurikulum baru untuk mulai mengelola data.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($kurikulum->hasPages())
                <div class="pagination-container">
                    {{ $kurikulum->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection