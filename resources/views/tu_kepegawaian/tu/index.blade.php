@extends('layouts.app')

@section('title', 'Daftar Pegawai / TU')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    :root {
        --primary: #4F46E5;
        --primary-light: #EEF2FF;
        --primary-dark: #4338CA;
        --success: #10B981;
        --danger: #EF4444;
        --bg-body: #F8FAFC;
        --card-bg: #FFFFFF;
        --text-heading: #0F172A;
        --text-body: #334155;
        --text-muted: #94A3B8;
        --border: #E2E8F0;
        --shadow-card: 0 4px 20px -4px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 12px 40px -8px rgba(0, 0, 0, 0.08);
    }

    .card-premium {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid rgba(226, 232, 240, 0.5);
        box-shadow: var(--shadow-card);
        transition: all 0.25s ease;
    }
    .card-premium:hover { box-shadow: var(--shadow-hover); }

    .header-premium {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 32px;
    }
    .header-title-wrap { display: flex; align-items: center; gap: 16px; }
    .header-icon {
        width: 48px;
        height: 48px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    .header-title {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--text-heading);
        margin: 0 0 2px 0;
    }
    .header-subtitle {
        font-size: 14px;
        color: var(--text-muted);
        font-weight: 500;
        margin: 0;
    }
    .header-actions { display: flex; flex-wrap: wrap; gap: 10px; }

    .btn-premium {
        padding: 10px 22px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-premium-primary { background: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25); }
    .btn-premium-primary:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79, 70, 229, 0.35); color: #fff; }
    .btn-premium-success { background: var(--success); color: #fff; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25); }
    .btn-premium-success:hover { background: #059669; transform: translateY(-2px); color: #fff; }
    .btn-premium-ghost { background: #F1F5F9; color: var(--text-body); }
    .btn-premium-ghost:hover { background: #E2E8F0; transform: translateY(-2px); }
    .btn-premium-danger-ghost { background: #FEF2F2; color: #EF4444; }
    .btn-premium-danger-ghost:hover { background: #FEE2E2; transform: translateY(-2px); }

    /* --- Filter --- */
    .filter-wrapper { padding: 20px 24px; display: flex; flex-wrap: wrap; align-items: flex-end; gap: 12px 20px; }
    .filter-item { flex: 1 1 160px; min-width: 140px; }
    .filter-item-large { flex: 2 1 240px; }
    .filter-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-body); margin-bottom: 6px; letter-spacing: 0.02em; }
    .filter-control { width: 100%; padding: 10px 14px; background: #FAFBFC; border: 1px solid var(--border); border-radius: 12px; font-size: 14px; color: var(--text-heading); transition: 0.2s; outline: none; }
    .filter-control:focus { background: #fff; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.06); }
    .filter-actions { display: flex; gap: 10px; }

    /* ==========================================
       TABEL — RAPI & KOMPAK (SAMA DGN DATA GURU)
       ========================================== */
    .table-container { overflow-x: auto; padding: 0; }
    .table-premium { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    .table-premium thead th {
        padding: 13px 16px;
        text-align: left;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: var(--text-muted);
        background: #FAFBFC;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
        vertical-align: middle;
    }
    .table-premium tbody td {
        padding: 13px 16px;
        border-bottom: 1px solid #F1F5F9;
        color: var(--text-body);
        vertical-align: middle;
    }
    .table-premium tbody tr { transition: background 0.15s; }
    .table-premium tbody tr:hover { background: #F8FAFC; }
    .table-premium tbody tr:last-child td { border-bottom: none; }
    .table-premium th.text-center,
    .table-premium td.text-center { text-align: center; }

    .data-name {
        font-weight: 700;
        color: var(--text-heading);
        font-size: 14px;
        line-height: 1.3;
    }
    .data-email {
        display: inline-block;
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        vertical-align: middle;
        font-size: 12px;
        color: var(--text-muted);
    }
    .data-email i { font-size: 10px; }

    /* Identitas nomor: ringkas 2 baris dengan tag label */
    .num-line {
        display: flex;
        align-items: center;
        gap: 6px;
        line-height: 1.5;
        white-space: nowrap;
    }
    .num-line .tag {
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .06em;
        color: var(--text-muted);
        background: #F1F5F9;
        border-radius: 5px;
        padding: 1.5px 6px;
        flex-shrink: 0;
        min-width: 44px;
        text-align: center;
    }
    .num-line .val {
        font-family: monospace;
        font-size: 12.5px;
        color: var(--text-body);
        font-weight: 600;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .nip-val {
        font-family: monospace;
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-body);
        white-space: nowrap;
    }

    /* ==========================================
       BADGE — ANTI PATAH BARIS
       ========================================== */
    .badge-pill {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
        line-height: 1.4;
    }
    .badge-blue { background: #EEF2FF; color: #4F46E5; }
    .badge-cyan { background: #ECFEFF; color: #0891B2; }
    .badge-yellow { background: #FEF3C7; color: #B45309; }
    .badge-green { background: #D1FAE5; color: #047857; }
    .badge-gray { background: #F1F5F9; color: #475569; }
    .badge-purple { background: #F3E8FF; color: #7E22CE; }
    .badge-outline-green { border: 1px solid #A7F3D0; color: #047857; background: transparent; }
    .badge-outline-gray { border: 1px solid #E2E8F0; color: #64748B; background: transparent; }

    /* JK: chip kecil ikon + huruf */
    .jk-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        width: 40px;
        padding: 4px 0;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 700;
    }
    .jk-l { background: #EEF2FF; color: #4F46E5; }
    .jk-p { background: #FDF2F8; color: #DB2777; }

    /* Indikator kosong */
    .mark-no {
        color: #CBD5E1;
        font-weight: 600;
        font-size: 13px;
    }

    .action-btn-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .action-btn {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
        font-size: 12.5px;
    }
    .action-btn-view { background: #EEF2FF; color: var(--primary); }
    .action-btn-view:hover { background: var(--primary); color: #fff; transform: scale(1.05); }
    .action-btn-edit { background: #EEF2FF; color: var(--primary); }
    .action-btn-edit:hover { background: var(--primary); color: #fff; transform: scale(1.05); }
    .action-btn-delete { background: #FEF2F2; color: var(--danger); }
    .action-btn-delete:hover { background: var(--danger); color: #fff; transform: scale(1.05); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }

    .pagination-modern { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; padding: 16px 24px 24px; border-top: 1px solid #F1F5F9; }
    .pagination-modern .page-link { border: none; border-radius: 10px; padding: 8px 14px; font-weight: 600; font-size: 13px; color: var(--text-body); transition: 0.2s; }
    .pagination-modern .page-link:hover { background: #F1F5F9; color: var(--primary); }
    .pagination-modern .page-item.active .page-link { background: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25); }

    @media (max-width: 768px) {
        .header-premium { flex-direction: column; align-items: flex-start; }
        .header-actions { width: 100%; flex-direction: column; }
        .header-actions .btn-premium { width: 100%; justify-content: center; }
        .filter-wrapper { flex-direction: column; gap: 12px; padding: 16px; }
        .filter-actions { flex-direction: column; }
        .filter-actions .btn-premium { width: 100%; justify-content: center; }
        .pagination-modern { flex-direction: column; align-items: center; }
        .data-email { max-width: 130px; }
    }
</style>

@php
    $isPaginated = method_exists($pegawais, 'perPage');
    $offset      = $isPaginated ? ($pegawais->currentPage() - 1) * $pegawais->perPage() : 0;
    $totalData   = method_exists($pegawais, 'total') ? $pegawais->total() : $pegawais->count();
@endphp

<div class="app-container">

    <!-- HEADER -->
    <div class="header-premium">
        <div class="header-title-wrap">
            <div class="header-icon"><i class="fas fa-users-cog"></i></div>
            <div>
                <h1 class="header-title">Data Pegawai / TU</h1>
                <p class="header-subtitle">Manajemen terpusat tenaga usaha</p>
            </div>
        </div>
        <div class="header-actions">
            <!-- FITUR CETAK (DROPDOWN) -->
            <div class="btn-group">
                <button type="button" class="btn-premium btn-premium-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-print"></i> Cetak
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('tu_kepegawaian.tu.absensi_harian_pegawai') }}" target="_blank">
                            <i class="fas fa-calendar-alt"></i> Absensi Harian
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('tu_kepegawaian.tu.absensi_kegiatan_pegawai') }}" target="_blank">
                            <i class="fas fa-users"></i> Absensi Kegiatan
                        </a>
                    </li>
                </ul>
            </div>

            <button type="button" class="btn-premium btn-premium-success" data-bs-toggle="modal" data-bs-target="#importTuModal"><i class="fas fa-file-import"></i> Import</button>
            <button type="button" class="btn-premium btn-premium-ghost" data-bs-toggle="modal" data-bs-target="#templateTuModal"><i class="fas fa-download"></i> Template</button>
            <a href="{{ route('tu_kepegawaian.tu.create') }}" class="btn-premium btn-premium-primary"><i class="fas fa-plus"></i> Tambah</a>
        </div>
    </div>

    <!-- FILTER -->
    <div class="card-premium mb-4">
        <form method="GET" action="{{ route('tu_kepegawaian.tu.index') }}" id="filterForm">
            <div class="filter-wrapper d-flex flex-wrap align-items-end gap-3 p-4 bg-white rounded-4 border border-light">
                @if(request()->filled('per_page'))
                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                @endif

                <div class="filter-item filter-item-large">
                    <label class="filter-label"><i class="fas fa-search me-1 text-primary"></i> Cari Data</label>
                    <input type="text" name="search" class="filter-control" value="{{ request('search') }}" placeholder="Nama, NIP, NIK, atau Email..." autocomplete="off">
                </div>

                <div class="filter-item">
                    <label class="filter-label"><i class="fas fa-user-tie me-1 text-primary"></i> Status</label>
                    <select name="status_kepegawaian" class="filter-control">
                        <option value="">Semua</option>
                        <option value="PNS" {{ request('status_kepegawaian') == 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="PPPK" {{ request('status_kepegawaian') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                        <option value="PPPK Paruh Waktu" {{ request('status_kepegawaian') == 'PPPK Paruh Waktu' ? 'selected' : '' }}>PPPK Paruh Waktu</option>
                        <option value="Honorer" {{ request('status_kepegawaian') == 'Honorer' ? 'selected' : '' }}>Honorer</option>
                        <option value="Guru Tetap Yayasan" {{ request('status_kepegawaian') == 'Guru Tetap Yayasan' ? 'selected' : '' }}>GTY</option>
                        <option value="Guru Tidak Tetap" {{ request('status_kepegawaian') == 'Guru Tidak Tetap' ? 'selected' : '' }}>GTT</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label class="filter-label"><i class="fas fa-venus-mars me-1 text-primary"></i> Gender</label>
                    <select name="jenis_kelamin" class="filter-control">
                        <option value="">Semua</option>
                        <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label class="filter-label"><i class="fas fa-graduation-cap me-1 text-primary"></i> Pendidikan</label>
                    <select name="pendidikan" class="filter-control">
                        <option value="">Semua</option>
                        <option value="S3" {{ request('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                        <option value="S2" {{ request('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S1" {{ request('pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="D4" {{ request('pendidikan') == 'D4' ? 'selected' : '' }}>D4</option>
                        <option value="D3" {{ request('pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn-premium btn-premium-primary"><i class="fas fa-sliders-h"></i> Filter</button>
                    <a href="{{ route('tu_kepegawaian.tu.index') }}" class="btn-premium btn-premium-danger-ghost"><i class="fas fa-undo-alt"></i> Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- TABLE -->
    <div class="card-premium">
        <div class="d-flex flex-wrap align-items-center justify-content-between p-3 border-bottom border-light">
            <div class="d-flex align-items-center gap-3">
                <span class="fw-bold text-secondary small">Tampilkan</span>
                <form method="GET" action="{{ route('tu_kepegawaian.tu.index') }}" id="perPageForm">
                    @foreach(['search', 'status_kepegawaian', 'jenis_kelamin', 'pendidikan'] as $key)
                        @if(request()->filled($key))
                            <input type="hidden" name="{{ $key }}" value="{{ request($key) }}">
                        @endif
                    @endforeach
                    <select name="per_page" class="form-select border-0 bg-light fw-bold" style="border-radius: 10px; padding: 5px 30px 5px 12px;" id="perPageSelect">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 || !request('per_page') ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Semua</option>
                    </select>
                </form>
            </div>
            <div class="text-muted small fw-semibold">
                <i class="fas fa-database text-primary me-1"></i>
                Total:
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">{{ $totalData }}</span>
            </div>
        </div>

        <div class="table-container">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th style="width: 46px;" class="text-center">#</th>
                        <th style="min-width: 210px;">Identitas</th>
                        <th>NIK / NUPTK</th>
                        <th>NIP</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 70px;">JK</th>
                        <th style="min-width: 150px;">Tugas Tambahan</th>
                        <th class="text-center" style="width: 128px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pegawais as $pegawai)
                        <tr>
                            {{-- Nomor urut --}}
                            <td class="text-center fw-bold text-secondary" style="font-size: 12.5px;">
                                {{ $loop->iteration + $offset }}
                            </td>

                            {{-- Identitas: nama + email terpotong rapi --}}
                            <td>
                                <div class="data-name">{{ $pegawai->nama }}</div>
                                @if (!empty($pegawai->email))
                                    <span class="data-email" title="{{ $pegawai->email }}">
                                        <i class="fas fa-envelope me-1"></i>{{ $pegawai->email }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>

                            {{-- NIK / NUPTK: 2 baris ringkas dengan tag label --}}
                            <td>
                                <div class="num-line">
                                    <span class="tag">NIK</span>
                                    <span class="val">{{ $pegawai->nik ?? '—' }}</span>
                                </div>
                                <div class="num-line">
                                    <span class="tag">NUPTK</span>
                                    <span class="val">{{ $pegawai->nuptk ?? '—' }}</span>
                                </div>
                            </td>

                            {{-- NIP --}}
                            <td>
                                <span class="nip-val">{{ $pegawai->nip ?? '—' }}</span>
                            </td>

                            {{-- Status: badge anti patah --}}
                            <td>
                                @php
                                    $st = strtolower(str_replace(' ', '-', $pegawai->status_kepegawaian ?? ''));
                                    $stClass = 'badge-gray';
                                    if ($st == 'pns') $stClass = 'badge-blue';
                                    elseif ($st == 'pppk' || $st == 'pppk-paruh-waktu') $stClass = 'badge-cyan';
                                    elseif ($st == 'honorer') $stClass = 'badge-yellow';
                                    elseif ($st == 'guru-tetap-yayasan') $stClass = 'badge-green';
                                    elseif ($st == 'guru-tidak-tetap') $stClass = 'badge-purple';
                                @endphp
                                <span class="badge-pill {{ $stClass }}">
                                    {{ $pegawai->status_kepegawaian ?? '—' }}
                                </span>
                            </td>

                            {{-- JK: chip ikon --}}
                            <td class="text-center">
                                @if ($pegawai->jenis_kelamin === 'L')
                                    <span class="jk-chip jk-l" title="Laki-laki"><i class="fas fa-mars"></i> L</span>
                                @elseif ($pegawai->jenis_kelamin === 'P')
                                    <span class="jk-chip jk-p" title="Perempuan"><i class="fas fa-venus"></i> P</span>
                                @else
                                    <span class="mark-no">—</span>
                                @endif
                            </td>

                            {{-- Tugas Tambahan: badge amber anti patah --}}
                            <td>
                                @if(!empty($pegawai->tugas_tambahan))
                                    <span class="badge-pill badge-yellow">
                                        <i class="fas fa-award me-1" style="font-size:10px;"></i>{{ $pegawai->tugas_tambahan }}
                                    </span>
                                @else
                                    <span class="mark-no">—</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center">
                                <div class="action-btn-group">
                                    <a href="{{ route('tu_kepegawaian.tu.show', $pegawai->id) }}" class="action-btn action-btn-view" data-bs-toggle="tooltip" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('tu_kepegawaian.tu.edit', $pegawai->id) }}" class="action-btn action-btn-edit" data-bs-toggle="tooltip" title="Edit Data"><i class="fas fa-edit"></i></a>
                                    <button type="button" class="action-btn action-btn-delete" onclick="confirmDeleteTu({{ $pegawai->id }}, '{{ addslashes($pegawai->nama) }}')" data-bs-toggle="tooltip" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fs-1 text-muted mb-3"></i>
                                    <h5 class="fw-bold">Tidak ada data</h5>
                                    <p class="text-muted">Coba sesuaikan filter atau tambah data baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($pegawais, 'links') && $totalData > 0)
            <div class="pagination-modern">
                <div class="text-secondary fw-semibold small">
                    Menampilkan <span class="text-dark fw-bold">{{ $pegawais->firstItem() ?? 0 }}</span> -
                    <span class="text-dark fw-bold">{{ $pegawais->lastItem() ?? 0 }}</span>
                    dari <span class="text-dark fw-bold">{{ $pegawais->total() }}</span>
                </div>
                <div>{{ $pegawais->appends(request()->except('page'))->links('pagination::bootstrap-4') }}</div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Template -->
<div class="modal fade" id="templateTuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold"><i class="fas fa-download text-success me-2"></i> Download Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tu_kepegawaian.tu.template') }}" method="GET">
                <div class="modal-body px-4">
                    <p class="text-secondary mb-3">Pilih kolom yang ingin disertakan:</p>
                    <div class="row g-3">
                        @php
                            $fields = [
                                'nama'=>'Nama',
                                'nip'=>'Nomor Induk (NIP)',
                                'nik'=>'NIK',
                                'nuptk'=>'NUPTK',
                                'jenis_kelamin'=>'Jenis Kelamin',
                                'tempat_lahir'=>'Tempat Lahir',
                                'tanggal_lahir'=>'Tanggal Lahir',
                                'status_kepegawaian'=>'Status Kepegawaian',
                                'tugas_tambahan'=>'Tugas Tambahan',
                                'email'=>'Email',
                                'no_hp'=>'No HP',
                                'alamat'=>'Alamat'
                            ];
                        @endphp
                        @foreach($fields as $key => $label)
                            <div class="col-md-6 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fields[]" value="{{ $key }}" id="tplTu_{{ $key }}" checked style="width: 18px; height: 18px; margin-top: 3px;">
                                    <label class="form-check-label fw-semibold text-secondary ms-2" for="tplTu_{{ $key }}">
                                        {{ $label }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-semibold"><i class="fas fa-download me-2"></i> Download</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importTuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold"><i class="fas fa-file-upload text-success me-2"></i> Import Data TU</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tu_kepegawaian.tu.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary small text-uppercase">File Excel</label>
                        <input type="file" name="file" class="form-control" required accept=".xlsx, .xls, .csv" style="border-radius: 12px; border: 2px dashed #CBD5E1; padding: 12px;">
                    </div>
                    <div>
                        <label class="form-label fw-bold text-secondary small text-uppercase">Kolom Import</label>
                        <div class="row g-3">
                            @php
                                $importFields = [
                                    'nama'=>'Nama',
                                    'nip'=>'Nomor Induk (NIP)',
                                    'nik'=>'NIK',
                                    'nuptk'=>'NUPTK',
                                    'jenis_kelamin'=>'Jenis Kelamin',
                                    'tempat_lahir'=>'Tempat Lahir',
                                    'tanggal_lahir'=>'Tanggal Lahir',
                                    'status_kepegawaian'=>'Status Kepegawaian',
                                    'tugas_tambahan'=>'Tugas Tambahan',
                                    'email'=>'Email',
                                    'no_hp'=>'No HP',
                                    'alamat'=>'Alamat'
                                ];
                            @endphp
                            @foreach($importFields as $key => $label)
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="selected_columns[]" value="{{ $key }}" id="impTu_{{ $key }}" checked style="width: 18px; height: 18px; margin-top: 3px;">
                                        <label class="form-check-label fw-semibold text-secondary ms-2" for="impTu_{{ $key }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-text text-secondary mt-3"><i class="fas fa-info-circle text-info me-1"></i> Pastikan urutan kolom dan format tanggal (YYYY-MM-DD) di Excel sesuai template.</div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-semibold"><i class="fas fa-cloud-upload-alt me-2"></i> Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- FORM DELETE -->
<form id="deleteTuForm" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
            Toast.fire({ icon: 'success', title: `{!! session('success') !!}` });
        @endif
        @if(session('error'))
            const ToastError = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 4000, timerProgressBar: true });
            ToastError.fire({ icon: 'error', title: `{!! session('error') !!}` });
        @endif

        const perPageSelect = document.getElementById('perPageSelect');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                const form = document.getElementById('perPageForm');
                if (form) {
                    let pageInput = form.querySelector('input[name="page"]');
                    if (!pageInput) {
                        pageInput = document.createElement('input');
                        pageInput.type = 'hidden';
                        pageInput.name = 'page';
                        form.appendChild(pageInput);
                    }
                    pageInput.value = 1;
                    form.submit();
                }
            });
        }

        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
    });

    function confirmDeleteTu(id, nama) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            html: `Anda akan menghapus data <b>"${nama}"</b>. Tindakan ini <b>tidak bisa dibatalkan</b>!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#64748B',
            confirmButtonText: '<i class="fas fa-trash-alt me-2"></i> Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteTuForm').action = `/tu_kepegawaian/tu/${id}`;
                document.getElementById('deleteTuForm').submit();
            }
        });
    }
</script>
@endpush
@endsection