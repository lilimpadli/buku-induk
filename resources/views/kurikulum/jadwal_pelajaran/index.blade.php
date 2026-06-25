@extends('layouts.app')

@section('title', 'Manajemen Jadwal Pelajaran')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

    .btn-edit {
        background: #F59E0B;
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
        transition: var(--transition);
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

    .btn-toggle {
        background: #10B981;
        border: none;
        color: white;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.65rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 3px;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-toggle:hover {
        background: #059669;
        color: white;
    }

    .btn-toggle-off {
        background: #6B7280;
        border: none;
        color: white;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.65rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 3px;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-toggle-off:hover {
        background: #4B5563;
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

    .filter-card .form-control, .filter-card .form-select {
        font-size: 0.8rem;
        padding: 0.3rem 0.7rem;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        height: 36px;
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
        min-width: 900px;
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
        text-align: center;
    }

    .table td {
        padding: 0.6rem 0.8rem;
        vertical-align: middle;
        border-color: #E2E8F0;
        text-align: center;
    }

    .table tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.03);
    }

    .badge-status {
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.65rem;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-status.active {
        background: #D1FAE5;
        color: #065F46;
    }

    .badge-status.inactive {
        background: #FEE2E2;
        color: #991B1B;
    }

    .badge-hari {
        background: #DBEAFE;
        color: #1E40AF;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.6rem;
        font-weight: 500;
        display: inline-block;
        white-space: nowrap;
    }

    .jadwal-cell {
        background: #F8FAFC;
        border-radius: 8px;
        padding: 6px 10px;
        margin: 2px 0;
        font-size: 0.75rem;
        border-left: 3px solid #667eea;
        text-align: left;
    }

    .jadwal-cell .mapel {
        font-weight: 600;
        color: #1E293B;
    }

    .jadwal-cell .guru {
        font-size: 0.65rem;
        color: #64748B;
    }

    .jadwal-cell .ruang {
        font-size: 0.6rem;
        color: #94A3B8;
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

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: nowrap;
        white-space: nowrap;
        justify-content: center;
    }

    .action-buttons form {
        margin: 0;
        padding: 0;
        display: inline;
    }

    .hari-column {
        min-width: 120px;
    }

    .jam-column {
        min-width: 80px;
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
        .table-card .card-header .btn-gradient {
            width: 100%;
            justify-content: center;
        }

        .table {
            min-width: 700px;
            font-size: 0.75rem;
        }
        .table th,
        .table td {
            padding: 0.4rem 0.5rem;
        }
        .btn-edit,
        .btn-delete,
        .btn-toggle,
        .btn-toggle-off {
            padding: 2px 6px;
            font-size: 0.55rem;
        }
        .action-buttons {
            flex-wrap: wrap;
            gap: 3px;
        }
        .jadwal-cell {
            font-size: 0.65rem;
            padding: 4px 6px;
        }
        .jadwal-cell .guru {
            font-size: 0.55rem;
        }
        .jadwal-cell .ruang {
            font-size: 0.5rem;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-calendar-alt me-2"></i> Manajemen Jadwal Pelajaran</h3>
                <div class="text-muted">Kelola jadwal pelajaran per kelas</div>
            </div>
            <div class="mt-2 mt-sm-0">
                <a href="{{ route('kurikulum.jadwal-pelajaran.create') }}" class="btn-gradient">
                    <i class="fas fa-plus"></i> Tambah Jadwal
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- FILTER -->
    <div class="card filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('kurikulum.jadwal-pelajaran.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-calendar me-1"></i> Tahun Ajaran</label>
                    <select name="tahun_ajaran_id" class="form-select">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunAjarans as $ta)
                            <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                {{ $ta->tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-calendar-week me-1"></i> Semester</label>
                    <select name="semester_id" class="form-select">
                        <option value="">Semua Semester</option>
                        @foreach($semesters as $s)
                            <option value="{{ $s->id }}" {{ request('semester_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fas fa-users me-1"></i> Kelas</label>
                    <select name="rombel_id" class="form-select">
                        <option value="">Semua Kelas</option>
                        @foreach($rombels as $r)
                            <option value="{{ $r->id }}" {{ request('rombel_id') == $r->id ? 'selected' : '' }}>
                                {{ $r->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn-gradient" style="flex:1; justify-content:center; padding:0.3rem 0.8rem; font-size:0.75rem;">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('kurikulum.jadwal-pelajaran.index') }}" class="btn-outline-gradient" style="flex:1; justify-content:center; padding:0.3rem 0.8rem; font-size:0.75rem;">
                            <i class="fas fa-undo-alt"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL JADWAL -->
    <div class="card table-card">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Daftar Jadwal Pelajaran</h5>
            <span class="badge bg-primary">{{ $jadwals->count() }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th class="hari-column">Hari</th>
                            <th class="jam-column">Jam Ke</th>
                            <th>Jam</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                            <th>Ruang</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals as $key => $jadwal)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge-hari">{{ $jadwal->hari }}</span></td>
                            <td><span class="fw-bold">{{ $jadwal->jam_ke }}</span></td>
                            <td>
                                <span class="badge-hari">
                                    {{ $jadwal->jamPelajaran ? date('H:i', strtotime($jadwal->jamPelajaran->jam_mulai)) . ' - ' . date('H:i', strtotime($jadwal->jamPelajaran->jam_selesai)) : '-' }}
                                </span>
                            </td>
                            <td>{{ $jadwal->rombel?->nama ?? '-' }}</td>
                            <td class="text-start">{{ $jadwal->mataPelajaran?->nama ?? '-' }}</td>
                            <td>{{ $jadwal->guru?->nama ?? '-' }}</td>
                            <td>{{ $jadwal->ruangKelas?->nama_ruang ?? '-' }}</td>
                            <td>
                                <span class="badge-status {{ $jadwal->is_active ? 'active' : 'inactive' }}">
                                    {{ $jadwal->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <form action="{{ route('kurikulum.jadwal-pelajaran.toggle', $jadwal->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="{{ $jadwal->is_active ? 'btn-toggle' : 'btn-toggle-off' }}" title="{{ $jadwal->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas {{ $jadwal->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('kurikulum.jadwal-pelajaran.edit', $jadwal->id) }}" class="btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kurikulum.jadwal-pelajaran.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
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
                            <td colspan="10">
                                <div class="empty-state">
                                    <i class="fas fa-calendar-alt"></i>
                                    <h5 class="fw-bold text-muted">Belum ada data jadwal pelajaran</h5>
                                    <p class="text-muted">Silakan tambah data baru melalui tombol di atas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        let alert = document.querySelector('.alert');
        if(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() { alert.remove(); }, 500);
        }
    }, 3000);
</script>
@endsection