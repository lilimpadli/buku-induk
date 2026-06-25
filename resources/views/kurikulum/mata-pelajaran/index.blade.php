@extends('layouts.app')

@section('title', 'Manajemen Mata Pelajaran')

@section('content')
<style>
    /* ===================== ROOT ===================== */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: #f7fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* ===== OVERRIDE LAYOUT ===== */
    main {
        padding: 15px 10px !important;
        overflow-x: auto !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 5px !important;
        overflow-x: auto !important;
    }

    /* ===== HEADER ===== */
    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1rem 1.2rem;
        border-radius: var(--border-radius);
        margin-bottom: 1rem;
        box-shadow: var(--card-shadow);
        width: 100%;
    }

    .page-header h3 {
        font-weight: 700;
        margin: 0;
        font-size: 1.1rem;
    }

    .page-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.75rem;
        margin: 0;
    }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-size: 0.75rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-outline-gradient {
        background: transparent;
        border: 1px solid #667eea;
        color: #667eea;
        font-weight: 600;
        padding: 0.3rem 0.8rem;
        border-radius: 8px;
        font-size: 0.75rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .btn-outline-gradient:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
    }

    .btn-edit {
        background: #F59E0B;
        border: none;
        color: white;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.65rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        white-space: nowrap;
    }

    .btn-edit:hover {
        background: #D97706;
        color: white;
    }

    .btn-delete {
        background: #EF4444;
        border: none;
        color: white;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.65rem;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: #DC2626;
        color: white;
    }

    /* ===== FILTER ===== */
    .filter-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        margin-bottom: 1rem;
        width: 100%;
    }

    .filter-card .card-body {
        padding: 0.8rem 1rem;
    }

    .filter-card .form-select {
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        border-radius: 6px;
        border: 1px solid #E2E8F0;
        min-width: 100px;
    }

    .filter-card .form-label {
        font-size: 0.65rem;
        font-weight: 600;
        color: #64748B;
        margin-bottom: 2px;
    }

    /* ===== TABLE ===== */
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
        padding: 0.5rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 5px;
    }

    .table-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1E293B;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .table-card .card-header h5 i {
        color: #667eea;
        margin-right: 6px;
    }

    .table-card .card-header .badge {
        font-size: 0.6rem;
        padding: 2px 8px;
        white-space: nowrap;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        min-width: 550px;
        margin-bottom: 0;
        font-size: 0.7rem;
    }

    .table th {
        font-weight: 600;
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #64748B;
        padding: 0.4rem 0.5rem;
        white-space: nowrap;
        background-color: #F8FAFC;
        border-bottom: none;
    }

    .table td {
        padding: 0.4rem 0.5rem;
        vertical-align: middle;
        border-color: #E2E8F0;
    }

    .table tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.03);
    }

    /* ===== BADGE ===== */
    .badge-kelompok {
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.6rem;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-kelompok.a {
        background: #D1FAE5;
        color: #059669;
    }

    .badge-kelompok.b {
        background: #DBEAFE;
        color: #2563EB;
    }

    .badge-kurikulum {
        background: #E2E8F0;
        color: #475569;
        padding: 1px 8px;
        border-radius: 10px;
        font-size: 0.55rem;
        font-weight: 500;
        display: inline-block;
        margin: 1px;
        white-space: nowrap;
    }

    .badge-jurusan {
        background: #FEF3C7;
        color: #D97706;
        padding: 1px 8px;
        border-radius: 10px;
        font-size: 0.55rem;
        font-weight: 500;
        display: inline-block;
        margin: 1px;
        white-space: nowrap;
    }

    .badge-tingkat {
        background: #667eea;
        color: white;
        padding: 1px 8px;
        border-radius: 10px;
        font-size: 0.55rem;
        font-weight: 500;
        display: inline-block;
        margin: 1px;
        white-space: nowrap;
    }

    /* ===== ACTION ===== */
    .action-buttons {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: nowrap;
        white-space: nowrap;
    }

    .action-buttons form {
        margin: 0;
        padding: 0;
        display: inline;
    }

    /* ===== EMPTY ===== */
    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
    }

    .empty-state i {
        font-size: 2rem;
        color: #CBD5E1;
        display: block;
        margin-bottom: 0.5rem;
    }

    .empty-state h5 {
        font-size: 0.9rem;
    }

    /* ===== PAGINATION ===== */
    .pagination-wrapper {
        padding: 0.5rem 1rem;
        border-top: 1px solid #E2E8F0;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .filter-card .row {
            gap: 8px;
        }
        .filter-card .col-md-3,
        .filter-card .col-md-4,
        .filter-card .col-md-5 {
            width: 100%;
        }
        .filter-card .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 0.8rem 1rem;
        }
        .page-header h3 {
            font-size: 0.95rem;
        }
        .table-card .card-header {
            flex-wrap: wrap;
        }
        .table-card .card-header .btn-gradient {
            width: 100%;
            justify-content: center;
        }
        .table {
            min-width: 480px;
            font-size: 0.6rem;
        }
        .table th,
        .table td {
            padding: 0.3rem 0.4rem;
        }
        .btn-edit,
        .btn-delete {
            padding: 2px 6px;
            font-size: 0.5rem;
        }
        .badge-kelompok {
            font-size: 0.5rem;
            padding: 1px 6px;
        }
        .badge-kurikulum,
        .badge-jurusan,
        .badge-tingkat {
            font-size: 0.45rem;
            padding: 1px 5px;
        }
        .action-buttons {
            flex-wrap: wrap;
            gap: 3px;
        }
    }

    @media (max-width: 576px) {
        .table {
            min-width: 400px;
            font-size: 0.55rem;
        }
        .table th,
        .table td {
            padding: 0.2rem 0.3rem;
        }
        .btn-edit,
        .btn-delete {
            padding: 1px 5px;
            font-size: 0.45rem;
        }
        .action-buttons {
            gap: 2px;
        }
    }
</style>

<div class="container-fluid px-4">
    <!-- Header -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-book-open me-1"></i> Manajemen Mata Pelajaran</h3>
                <div class="text-muted">Kelola data mata pelajaran</div>
            </div>
            <div>
                <a href="{{ route('kurikulum.mata-pelajaran.create') }}" class="btn-gradient">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card filter-card">
        <div class="card-body">
            <form method="GET" class="row g-1 g-md-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label">Filter</label>
                    <div class="d-flex gap-1 flex-wrap">
                        <select name="jurusan" class="form-select" style="flex:1; min-width:100px;">
                            <option value="">Semua Jurusan</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}" {{ (string)($jurusan ?? '') === (string)$j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                            @endforeach
                        </select>
                        <select name="tingkat" class="form-select" style="flex:1; min-width:80px;">
                            <option value="">Semua Tingkat</option>
                            <option value="10" {{ (string)($tingkat ?? '') === '10' ? 'selected' : '' }}>10</option>
                            <option value="11" {{ (string)($tingkat ?? '') === '11' ? 'selected' : '' }}>11</option>
                            <option value="12" {{ (string)($tingkat ?? '') === '12' ? 'selected' : '' }}>12</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="d-flex gap-1 flex-wrap">
                        <button type="submit" class="btn-gradient">Terapkan</button>
                        <a href="{{ route('kurikulum.mata-pelajaran.index') }}" class="btn-outline-gradient">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card table-card">
        <div class="card-header">
            <h5><i class="fas fa-table"></i> Daftar Mata Pelajaran</h5>
            <span class="badge bg-primary">{{ $mapels->count() }}</span>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success m-2" id="successAlert" style="font-size:0.75rem; padding:0.4rem 0.8rem;">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Kelompok</th>
                            <th>Kurikulum</th>
                            <th>Jurusan</th>
                            <th>Tingkat</th>
                            <th width="18%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mapels as $key => $m)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><span class="fw-semibold">{{ $m->nama }}</span></td>
                            <td>
                                <span class="badge-kelompok {{ strtolower($m->kelompok) }}">
                                    {{ $m->kelompok }}
                                </span>
                            </td>
                            <td>
                                @if($m->kurikulums->count() > 0)
                                    @foreach($m->kurikulums as $kurikulum)
                                        <span class="badge-kurikulum">{{ $kurikulum->nama_kurikulum }}</span>
                                    @endforeach
                                @else
                                    <span style="font-size:0.5rem; color:#94A3B8;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($m->jurusans->count() > 0)
                                    @foreach($m->jurusans as $jurusan)
                                        <span class="badge-jurusan">{{ $jurusan->nama }}</span>
                                    @endforeach
                                @else
                                    <span style="font-size:0.5rem; color:#94A3B8;">-</span>
                                @endif
                            </td>
                            <td>
                                @php $tingkats = $m->tingkats->pluck('tingkat')->toArray(); @endphp
                                @if(count($tingkats) > 0)
                                    @foreach($tingkats as $t)
                                        <span class="badge-tingkat">{{ $t }}</span>
                                    @endforeach
                                @else
                                    <span style="font-size:0.5rem; color:#94A3B8;">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('kurikulum.mata-pelajaran.edit', $m->id) }}" class="btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kurikulum.mata-pelajaran.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-book"></i>
                                    <h5 class="text-muted">Belum ada data</h5>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($mapels, 'links'))
            <div class="pagination-wrapper">
                {{ $mapels->appends(request()->query())->links() }}
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