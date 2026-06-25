@extends('layouts.app')

@section('title', 'Manajemen Jam Pelajaran')

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

    .table-card {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
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
        min-width: 600px;
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

    .badge-waktu {
        background: #DBEAFE;
        color: #1E40AF;
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

    .action-buttons form {
        margin: 0;
        padding: 0;
        display: inline;
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
            min-width: 480px;
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
    }
</style>

<div class="container-fluid px-4">
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3><i class="fas fa-clock me-2"></i> Manajemen Jam Pelajaran</h3>
                <div class="text-muted">Kelola jam pelajaran yang tersedia di sekolah</div>
            </div>
            <div class="mt-2 mt-sm-0">
                <a href="{{ route('kurikulum.jam-pelajaran.create') }}" class="btn-gradient">
                    <i class="fas fa-plus"></i> Tambah Jam Pelajaran
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

    <div class="card table-card">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Daftar Jam Pelajaran</h5>
            <span class="badge bg-primary">{{ $jamPelajarans->count() }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th width="18%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jamPelajarans as $key => $jam)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="fw-semibold">{{ $jam->kode_jam }}</span></td>
                            <td><span class="badge-waktu">{{ date('H:i', strtotime($jam->jam_mulai)) }}</span></td>
                            <td><span class="badge-waktu">{{ date('H:i', strtotime($jam->jam_selesai)) }}</span></td>
                            <td class="text-center">{{ $jam->urutan }}</td>
                            <td>
                                <span class="badge-status {{ $jam->is_active ? 'active' : 'inactive' }}">
                                    {{ $jam->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>{{ $jam->keterangan ?? '-' }}</td>
                            <td>
                                <div class="action-buttons">
                                    <form action="{{ route('kurikulum.jam-pelajaran.toggle', $jam->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="{{ $jam->is_active ? 'btn-toggle' : 'btn-toggle-off' }}" title="{{ $jam->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas {{ $jam->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('kurikulum.jam-pelajaran.edit', $jam->id) }}" class="btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kurikulum.jam-pelajaran.destroy', $jam->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jam pelajaran ini?')">
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
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-clock"></i>
                                    <h5 class="fw-bold text-muted">Belum ada data jam pelajaran</h5>
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
@endsection