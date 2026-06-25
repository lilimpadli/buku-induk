@extends('layouts.app')

@section('title', 'Manajemen KKM')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A4 100%);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        box-sizing: border-box;
    }

    .container-fluid {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        padding: 0 20px;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 0 12px;
        }
    }

    .header-card {
        background: var(--primary-gradient);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .header-card::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(80px, -80px);
    }

    .header-card h3 {
        margin: 0;
        font-weight: 700;
        font-size: clamp(1.2rem, 5vw, 1.6rem);
        position: relative;
        z-index: 1;
    }

    .header-card p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
        font-size: clamp(0.8rem, 4vw, 0.95rem);
        position: relative;
        z-index: 1;
    }

    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        transition: var(--transition);
        white-space: nowrap;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .table-card {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--card-shadow);
        width: 100%;
    }

    .table-card .card-header {
        background: white;
        border-bottom: 1px solid #E2E8F0;
        padding: 1rem 1.5rem;
    }

    .table-card .card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #1E293B;
        font-size: clamp(0.9rem, 4vw, 1.1rem);
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        min-width: 500px;
        margin-bottom: 0;
    }

    .table th {
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748B;
        padding: 1rem;
        white-space: nowrap;
        background-color: #F8FAFC;
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
        font-size: 14px;
        word-break: break-word;
    }

    .badge-kkm {
        background: var(--primary-gradient);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-kelas {
        background: #64748B;
        color: white;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        display: inline-block;
        white-space: nowrap;
    }

    .btn-edit {
        background: #F59E0B;
        border: none;
        color: white;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        transition: var(--transition);
    }

    .btn-edit:hover {
        background: #D97706;
        transform: translateY(-1px);
        color: white;
    }

    .btn-delete {
        background: #EF4444;
        border: none;
        color: white;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        transition: var(--transition);
    }

    .btn-delete:hover {
        background: #DC2626;
        transform: translateY(-1px);
        color: white;
    }

    /* Mobile Fix */
    @media (max-width: 768px) {
        .table-card .card-header {
            flex-direction: column;
            gap: 12px;
            align-items: flex-start !important;
        }
        
        .table-card .card-header .btn-gradient {
            width: 100%;
            text-align: center;
        }
        
        .table th,
        .table td {
            padding: 0.7rem;
            font-size: 12px;
        }
        
        .badge-kkm, .badge-kelas {
            font-size: 10px;
            padding: 3px 8px;
        }
        
        .btn-edit, .btn-delete {
            padding: 4px 8px;
            font-size: 10px;
        }
        
        .header-card {
            padding: 1rem;
        }
    }

    @media (max-width: 576px) {
        .table th,
        .table td {
            padding: 0.5rem;
            font-size: 10px;
        }
        
        .btn-edit i, .btn-delete i {
            margin-right: 2px;
        }
    }
</style>

<div class="container-fluid px-4">
    <div class="header-card">
        <h3><i class="fas fa-chart-line me-2"></i> Manajemen KKM</h3>
        <p>Kelola Kriteria Ketuntasan Minimal untuk setiap mata pelajaran</p>
    </div>

    <div class="card table-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-table me-2 text-primary"></i> Daftar KKM</h5>
            <a href="{{ route('kurikulum.kkm.create') }}" class="btn btn-gradient btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah KKM
            </a>
        </div>
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3" id="successAlert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th width="12%">KKM</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kkmList as $key => $kkm)
                        <tr>
                            <td>{{ $key + $kkmList->firstItem() }}</td>
                            <td><span class="fw-semibold">{{ $kkm->mataPelajaran->nama ?? '-' }}</span></td>
                            <td>
                                <span class="badge-kelas">
                                    @php
                                        $rombel = $kkm->kelas->rombels->first();
                                    @endphp
                                    {{ $rombel->nama ?? 'Kelas ID: ' . $kkm->kelas_id }}
                                </span>
                            </td>
                            <td>{{ $kkm->tahunAjaran->tahun ?? '-' }}</td>
                            <td><span class="badge-kkm">{{ $kkm->nilai_kkm }}</span></td>
                            <td>
                                <a href="{{ route('kurikulum.kkm.edit', $kkm->id) }}" class="btn btn-edit btn-sm">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('kurikulum.kkm.destroy', $kkm->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('Yakin ingin menghapus KKM ini?')">
                                        <i class="fas fa-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <span class="text-muted">Belum ada data KKM. Silakan tambah data baru.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $kkmList->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        let alert = document.getElementById('successAlert');
        if(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500);
        }
    }, 3000);
</script>
@endsection