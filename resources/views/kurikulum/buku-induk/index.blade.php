@extends('layouts.app')

@section('title', 'Buku Induk Siswa')

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

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.4rem 1rem;
        border-radius: 8px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        white-space: nowrap;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 1px solid #667eea;
        color: #667eea;
        font-weight: 600;
        padding: 0.3rem 0.8rem;
        border-radius: 8px;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        white-space: nowrap;
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
    }

    .btn-detail {
        background: #667eea;
        border: none;
        color: white;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.65rem;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        white-space: nowrap;
    }

    .btn-detail:hover {
        background: #5a67d8;
        color: white;
    }

    .btn-print {
        background: #13B497;
        border: none;
        color: white;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.65rem;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        white-space: nowrap;
    }

    .btn-print:hover {
        background: #0e9a7e;
        color: white;
    }

    .filter-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: var(--transition);
        width: 100%;
    }

    .filter-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .filter-card .card-body {
        padding: 1rem 1.5rem;
    }

    .filter-card .form-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: #64748B;
        margin-bottom: 2px;
    }

    .filter-card .form-control,
    .filter-card .form-select {
        font-size: 0.8rem;
        padding: 0.3rem 0.7rem;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        height: 36px;
    }

    .filter-card .input-group-text {
        font-size: 0.8rem;
        padding: 0.3rem 0.7rem;
        background: white;
        border: 1px solid #E2E8F0;
    }

    .table-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        width: 100%;
    }

    .table-card .card-header {
        background: white;
        border-bottom: 1px solid #E2E8F0;
        padding: 0.7rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .table-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 0.95rem;
    }

    .table-card .card-header h5 i {
        color: #667eea;
        margin-right: 6px;
    }

    .table-card .card-header .badge {
        font-size: 0.7rem;
        padding: 3px 10px;
        white-space: nowrap;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        min-width: 650px;
        margin-bottom: 0;
        font-size: 0.85rem;
    }

    .table th {
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #64748B;
        padding: 0.6rem 0.8rem;
        white-space: nowrap;
        background-color: #F8FAFC;
        border-bottom: none;
    }

    .table td {
        padding: 0.6rem 0.8rem;
        vertical-align: middle;
        border-color: #E2E8F0;
    }

    .table tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.03);
    }

    .badge-gender {
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.6rem;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-gender.laki {
        background: #DBEAFE;
        color: #2563EB;
    }

    .badge-gender.perempuan {
        background: #FCE7F3;
        color: #DB2777;
    }

    .badge-rombel {
        background: #13B497;
        color: white;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.6rem;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: nowrap;
        white-space: nowrap;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #CBD5E1;
        display: block;
        margin-bottom: 0.5rem;
    }

    .pagination-wrapper {
        padding: 0.6rem 1.5rem;
        border-top: 1px solid #E2E8F0;
    }

    .student-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--primary-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
    }

    .student-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    @media (max-width: 992px) {
        .filter-card .row {
            gap: 8px;
        }
        .filter-card .col-md-4,
        .filter-card .col-md-3 {
            width: 100%;
        }
        .filter-card .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1rem;
        }
        .page-header h3 {
            font-size: 1.05rem;
        }
        .page-header .text-muted {
            font-size: 0.75rem;
        }

        .table-card .card-header {
            flex-wrap: wrap;
        }

        .table {
            min-width: 550px;
            font-size: 0.75rem;
        }
        .table th,
        .table td {
            padding: 0.4rem 0.5rem;
        }
        .btn-detail,
        .btn-print {
            padding: 2px 6px;
            font-size: 0.55rem;
        }
        .action-buttons {
            flex-wrap: wrap;
            gap: 3px;
        }
        .student-avatar {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }
    }

    @media (max-width: 576px) {
        .table {
            min-width: 450px;
            font-size: 0.65rem;
        }
        .table th,
        .table td {
            padding: 0.3rem 0.4rem;
        }
        .btn-detail,
        .btn-print {
            padding: 1px 5px;
            font-size: 0.5rem;
        }
        .badge-gender,
        .badge-rombel {
            font-size: 0.5rem;
            padding: 1px 6px;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-book me-2"></i> Buku Induk Siswa</h3>
                <div class="text-muted">Data lengkap peserta didik</div>
            </div>
        </div>
    </div>

    <div class="card filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('kurikulum.buku-induk.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label"><i class="fas fa-search me-1"></i> Cari</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Nama / NIS / NISN" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-building me-1"></i> Jurusan</label>
                    <select name="jurusan_id" class="form-select">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-venus-mars me-1"></i> Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="">Semua</option>
                        <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn-gradient" style="flex:1; justify-content:center; padding:0.3rem 0.8rem; font-size:0.75rem;">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                        <a href="{{ route('kurikulum.buku-induk.index') }}" class="btn-outline-gradient" style="flex:1; justify-content:center; padding:0.3rem 0.8rem; font-size:0.75rem;">
                            <i class="fas fa-undo-alt"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card table-card">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Daftar Siswa</h5>
            <span class="badge bg-primary">{{ $siswas->total() }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Foto</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Rombel</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $key => $s)
                        <tr>
                            <td>{{ $siswas->firstItem() + $key }}</td>
                            <td>
                                <div class="student-avatar">
                                    @if($s->user && $s->user->photo)
                                        <img src="{{ asset('storage/' . $s->user->photo) }}" alt="{{ $s->nama_lengkap }}">
                                    @else
                                        {{ strtoupper(substr($s->nama_lengkap, 0, 1)) }}
                                    @endif
                                </div>
                            </td>
                            <td>{{ $s->nis ?? '-' }}</td>
                            <td><span class="fw-semibold">{{ $s->nama_lengkap }}</span></td>
                            <td>
                                <span class="badge-gender {{ strtolower($s->jenis_kelamin) == 'laki-laki' ? 'laki' : 'perempuan' }}">
                                    {{ $s->jenis_kelamin ?? '-' }}
                                </span>
                            </td>
                            <td><span class="badge-rombel">{{ optional($s->rombel)->nama ?? '-' }}</span></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('kurikulum.buku-induk.show', $s->id) }}" class="btn-detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kurikulum.buku-induk.cetak', $s->id) }}" target="_blank" class="btn-print">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-book"></i>
                                    <h5 class="fw-bold text-muted">Belum ada data siswa</h5>
                                    <p class="text-muted">Silakan tambah data siswa terlebih dahulu.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($siswas->hasPages())
            <div class="pagination-wrapper">
                {{ $siswas->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        let alert = document.getElementById('successAlert');
        if(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() { alert.remove(); }, 500);
        }
    }, 3000);
</script>
@endsection