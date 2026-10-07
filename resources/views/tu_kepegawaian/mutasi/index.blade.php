@extends('layouts.app')

@section('title', 'Data Mutasi Guru & Pegawai')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    :root {
        --primary: #4F46E5;
        --primary-light: #EEF2FF;
        --primary-dark: #4338CA;
        --success: #10B981;
        --danger: #EF4444;
        --info: #0EA5E9;
        --info-light: #E0F2FE;
        --text-heading: #0F172A;
        --text-body: #334155;
        --text-muted: #94A3B8;
        --border: #E2E8F0;
        --shadow-card: 0 4px 20px -4px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 12px 40px -8px rgba(0, 0, 0, 0.08);
    }

    body { background: #F8FAFC; font-family: 'Inter', system-ui, sans-serif; }

    .app-container { max-width: 1440px; margin: 0 auto; padding: 28px 36px; }

    .card-premium {
        background: #FFFFFF;
        border-radius: 24px;
        border: 1px solid rgba(226, 232, 240, 0.5);
        box-shadow: var(--shadow-card);
        transition: all 0.25s ease;
    }
    .card-premium:hover { box-shadow: var(--shadow-hover); }

    .header-premium { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 32px; }
    .header-title-wrap { display: flex; align-items: center; gap: 16px; }
    .header-icon { width: 48px; height: 48px; background: var(--primary-light); color: var(--primary); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
    .header-title { font-size: 26px; font-weight: 800; letter-spacing: -0.03em; color: var(--text-heading); margin: 0 0 2px 0; }
    .header-subtitle { font-size: 14px; color: var(--text-muted); font-weight: 500; margin: 0; }
    .header-actions { display: flex; flex-wrap: wrap; gap: 10px; }

    .btn-premium { padding: 10px 22px; border-radius: 100px; font-weight: 600; font-size: 14px; transition: all 0.25s ease; display: inline-flex; align-items: center; gap: 8px; border: none; text-decoration: none; cursor: pointer; }
    .btn-premium-primary { background: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25); }
    .btn-premium-primary:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79, 70, 229, 0.35); color: #fff; }

    .table-container { overflow-x: auto; padding: 0; }
    .table-premium { width: 100%; border-collapse: collapse; font-size: 14px; }
    .table-premium thead th {
        padding: 14px 20px; text-align: left; font-weight: 600; font-size: 12px;
        text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-muted);
        background: #FAFBFC; border-bottom: 1px solid var(--border);
    }
    .table-premium tbody td { padding: 16px 20px; border-bottom: 1px solid #F1F5F9; color: var(--text-body); }
    .table-premium tbody tr { transition: background 0.15s; }
    .table-premium tbody tr:hover { background: #F8FAFC; }
    .table-premium tbody tr:last-child td { border-bottom: none; }

    .data-name { font-weight: 600; color: var(--text-heading); }
    .data-email { display: flex; align-items: center; gap: 4px; font-size: 13px; color: var(--text-muted); }

    .badge-pill { display: inline-flex; align-items: center; padding: 4px 14px; border-radius: 100px; font-size: 12px; font-weight: 600; }
    .badge-blue { background: #EEF2FF; color: #4F46E5; }
    .badge-cyan { background: #ECFEFF; color: #0891B2; }
    .badge-yellow { background: #FEF3C7; color: #B45309; }
    .badge-green { background: #D1FAE5; color: #047857; }
    .badge-gray { background: #F1F5F9; color: #475569; }
    .badge-purple { background: #F3E8FF; color: #7E22CE; }
    .badge-red { background: #FEE2E2; color: #DC2626; }
    .badge-orange { background: #FFF7ED; color: #C2410C; }

    .action-btn-group { display: flex; align-items: center; justify-content: center; gap: 8px; }
    .action-btn {
        width: 34px; height: 34px; border: none; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all 0.2s ease; cursor: pointer; text-decoration: none;
    }
    .action-btn-edit { background: #EEF2FF; color: var(--primary); }
    .action-btn-edit:hover { background: var(--primary); color: #fff; transform: scale(1.05); }
    .action-btn-show { background: var(--info-light); color: var(--info); }
    .action-btn-show:hover { background: var(--info); color: #fff; transform: scale(1.05); box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3); }
    .action-btn-delete { background: #FEF2F2; color: var(--danger); }
    .action-btn-delete:hover { background: var(--danger); color: #fff; transform: scale(1.05); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }

    .stat-card { transition: all 0.3s ease; border: none; background: #fff; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); border-radius: 16px; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important; }
    .icon-box { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 14px; margin: 0 auto 12px; }

    /* ===== MODAL EDIT PILIHAN ===== */
    .modal-edit-option {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 18px 22px;
        border: 2px solid #E2E8F0;
        border-radius: 16px;
        background: #fff;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .modal-edit-option:hover {
        border-color: var(--primary);
        background: #F8FAFC;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -8px rgba(79, 70, 229, 0.25);
    }
    .modal-edit-option-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .modal-edit-option-title {
        font-weight: 700;
        font-size: 15px;
        color: var(--text-heading);
        margin-bottom: 2px;
    }
    .modal-edit-option-desc {
        font-size: 13px;
        color: var(--text-muted);
        margin: 0;
    }

    @media (max-width: 768px) {
        .app-container { padding: 16px; }
        .header-premium { flex-direction: column; align-items: flex-start; }
        .header-actions { width: 100%; flex-direction: column; }
        .header-actions .btn-premium { width: 100%; justify-content: center; }
    }
</style>

<div class="app-container">

    {{-- HEADER --}}
    <div class="header-premium">
        <div class="header-title-wrap">
            <div class="header-icon"><i class="fas fa-exchange-alt"></i></div>
            <div>
                <h1 class="header-title">Data Mutasi</h1>
                <p class="header-subtitle">Kelola rekam jejak mutasi guru dan pegawai secara sistematis.</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('tu_kepegawaian.mutasi.create') }}" class="btn-premium btn-premium-primary">
                <i class="fas fa-plus me-2"></i> Tambah Data
            </a>
        </div>
    </div>

    {{-- STATISTIK CARDS --}}
    <div class="row g-3 mb-5">
        @php
            $stats = [
                'Masuk' => ['icon' => 'fa-door-open', 'color' => 'text-success', 'bg' => 'bg-success-subtle'],
                'Keluar' => ['icon' => 'fa-door-closed', 'color' => 'text-danger', 'bg' => 'bg-danger-subtle'],
                'Pindah Tugas' => ['icon' => 'fa-truck-moving', 'color' => 'text-primary', 'bg' => 'bg-primary-subtle'],
                'Pensiun' => ['icon' => 'fa-user-clock', 'color' => 'text-secondary', 'bg' => 'bg-secondary-subtle'],
                'Wafat' => ['icon' => 'fa-ribbon', 'color' => 'text-dark', 'bg' => 'bg-dark-subtle'],
                'Diberhentikan' => ['icon' => 'fa-user-slash', 'color' => 'text-warning', 'bg' => 'bg-warning-subtle'],
                'Alih Tugas' => ['icon' => 'fa-retweet', 'color' => 'text-info', 'bg' => 'bg-info-subtle']
            ];
        @endphp

        @foreach($stats as $status => $data)
        <div class="col">
            <div class="card stat-card">
                <div class="card-body p-3 text-center">
                    <div class="icon-box {{ $data['bg'] }} {{ $data['color'] }}">
                        <i class="fas {{ $data['icon'] }}"></i>
                    </div>
                    <div class="h4 fw-bolder text-dark mb-0">{{ \App\Models\Mutasi::where('jenis', $status)->count() }}</div>
                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.6rem;">{{ $status }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- TABLE --}}
    <div class="card-premium">
        <div class="d-flex flex-wrap align-items-center justify-content-between p-3 border-bottom border-light">
            <div class="d-flex align-items-center gap-3">
                <span class="fw-bold text-secondary small">Tampilkan</span>
                <form method="GET" action="{{ route('tu_kepegawaian.mutasi.index') }}" id="perPageForm">
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
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">
                    {{ $mutasis->total() ?? $mutasis->count() }}
                </span>
            </div>
        </div>

        <div class="table-container">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th style="min-width: 200px;">Identitas</th>
                        <th>NIK / NUPTK</th>
                        <th>NIP</th>
                        <th>Status Kepegawaian</th>
                        <th class="text-center">JK</th>
                        <th class="text-center">Status Mutasi</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mutasis as $m)
                        @php
                            $status = strtolower(str_replace(' ', '-', $m->status_kepegawaian ?? ''));
                            $class = 'badge-gray';
                            if($status == 'pns') $class = 'badge-blue';
                            elseif($status == 'pppk' || $status == 'pppk-paruh-waktu') $class = 'badge-cyan';
                            elseif($status == 'non-asn') $class = 'badge-yellow';

                            $badgeMutasi = match (strtolower(trim($m->jenis ?? ''))) {
                                'masuk'             => 'badge-green',
                                'keluar'            => 'badge-red',
                                'pindah tugas'      => 'badge-orange',
                                'pensiun'           => 'badge-gray',
                                'wafat'             => 'badge-gray',
                                'diberhentikan'     => 'badge-red',
                                'alih tugas'        => 'badge-cyan',
                                default             => 'badge-gray',
                            };
                        @endphp
                        <tr>
                            <td class="fw-bold text-secondary" style="font-size: 13px;">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <div class="data-name">{{ $m->nama_entitas ?? '-' }}</div>
                                <div class="data-email">
                                    <i class="fas fa-envelope text-secondary"></i> {{ $m->email ?? '-' }}
                                </div>
                            </td>
                            <td class="text-secondary">
                                <div class="fw-bold">{{ $m->nik ?? '-' }}</div>
                                <div class="text-muted small">NUPTK: {{ $m->nuptk ?? '-' }}</div>
                            </td>
                            <td class="text-secondary fw-semibold" style="font-family: monospace; font-size: 13px;">{{ $m->nip ?? '-' }}</td>
                            <td>
                                <span class="badge-pill {{ $class }}">
                                    {{ $m->status_kepegawaian ?? '-' }}
                                </span>
                            </td>
                            <td class="text-center fw-bold text-secondary">{{ $m->jenis_kelamin ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge-pill {{ $badgeMutasi }}">
                                    {{ $m->jenis ?? '-' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="action-btn-group">
                                    {{-- TOMBOL DETAIL (MATA) --}}
                                    <a href="{{ route('tu_kepegawaian.mutasi.show', $m->id) }}" class="action-btn action-btn-show" data-bs-toggle="tooltip" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- TOMBOL EDIT — BUKA MODAL --}}
                                    <button type="button"
                                            class="action-btn action-btn-edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editChoiceModal"
                                            data-mutasi-id="{{ $m->id }}"
                                            data-mutasi-nama="{{ $m->nama_entitas }}"
                                            title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    {{-- TOMBOL HAPUS --}}
                                    <form action="{{ route('tu_kepegawaian.mutasi.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data mutasi {{ $m->nama_entitas }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn action-btn-delete" data-bs-toggle="tooltip" title="Hapus Data">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fs-1 text-muted mb-3"></i>
                                    <h5 class="fw-bold">Belum ada data mutasi</h5>
                                    <p class="text-muted">Data mutasi akan muncul setelah Anda menambahkan data melalui tombol "Tambah Data".</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($mutasis, 'links') && $mutasis->count() > 0)
            <div class="pagination-modern">
                <div class="text-secondary fw-semibold small">
                    Menampilkan <span class="text-dark fw-bold">{{ $mutasis->firstItem() ?? 0 }}</span> -
                    <span class="text-dark fw-bold">{{ $mutasis->lastItem() ?? 0 }}</span>
                    dari <span class="text-dark fw-bold">{{ $mutasis->total() }}</span>
                </div>
                <div>
                    {{ $mutasis->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>
</div>

{{-- MODAL PILIH EDIT --}}
<div class="modal fade" id="editChoiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <div class="modal-header border-0 pt-4 px-4 pb-2">
                <div>
                    <h5 class="fw-bold mb-1">Pilih Aksi Edit</h5>
                    <p class="text-muted small mb-0" id="editModalSubtitle">—</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <div class="d-flex flex-column gap-3">
                    {{-- Pilihan 1: Edit Mutasi --}}
                    <a href="#" id="editMutasiLink" class="modal-edit-option">
                        <div class="modal-edit-option-icon" style="background: #EEF2FF; color: #4F46E5;">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="modal-edit-option-title">Edit Mutasi</div>
                            <p class="modal-edit-option-desc">Ubah jenis & tanggal mutasi saja</p>
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </a>

                    {{-- Pilihan 2: Edit Data Mutasi --}}
                    <a href="#" id="editDataMutasiLink" class="modal-edit-option">
                        <div class="modal-edit-option-icon" style="background: #FEF3C7; color: #B45309;">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="modal-edit-option-title">Edit Data Mutasi</div>
                            <p class="modal-edit-option-desc">Ubah semua data (nama, NIP, alamat, dll)</p>
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const perPageSelect = document.getElementById('perPageSelect');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                const form = document.getElementById('perPageForm');
                if (form) form.submit();
            });
        }
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));

        // Modal Edit — isi link sesuai data yang diklik
        const editChoiceModal = document.getElementById('editChoiceModal');
        if (editChoiceModal) {
            editChoiceModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const mutasiId = button.getAttribute('data-mutasi-id');
                const mutasiNama = button.getAttribute('data-mutasi-nama');

                document.getElementById('editModalSubtitle').textContent = mutasiNama || '—';
                document.getElementById('editMutasiLink').href = `/tu_kepegawaian/mutasi/${mutasiId}/edit`;
                document.getElementById('editDataMutasiLink').href = `/tu_kepegawaian/mutasi/${mutasiId}/edit-data`;
            });
        }
    });
</script>
@endpush
@endsection