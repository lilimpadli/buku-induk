@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('content')
<style>
:root {
    --primary-color: #4f46e5;
    --secondary-color: #2563eb;
    --light-bg: #f8fafc;
    --soft-gray: #e2e8f0;
    --text-dark: #0f172a;
    --text-muted: #64748b;
    --shadow-light: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
    --shadow-medium: 0 10px 15px -3px rgba(0,0,0,0.07), 0 4px 6px -2px rgba(0,0,0,0.04);
    --shadow-hover: 0 20px 25px -5px rgba(79, 70, 229, 0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
    --radius: 16px;
}

body {
    font-family: 'Inter', sans-serif;
    background: var(--light-bg);
    color: var(--text-dark);
}

.page-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border-radius: var(--radius);
    padding: 28px 32px;
    margin-bottom: 24px;
    color: white;
    box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.25);
    position: relative;
    overflow: hidden;
    animation: fadeInUp .45s ease both;
}

.page-header::after {
    content: "";
    position: absolute;
    top: -50%;
    right: -20px;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    pointer-events: none;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 8px;
    letter-spacing: -0.5px;
    position: relative;
    z-index: 1;
}

.page-title i {
    background: rgba(255,255,255,0.2);
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.page-subtitle {
    opacity: .9;
    margin: 0;
    font-size: 0.95rem;
    max-width: 680px;
    line-height: 1.6;
    position: relative;
    z-index: 1;
}

.btn-modern {
    border: none;
    border-radius: 10px;
    padding: 10px 18px;
    font-size: 0.9rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    color: white;
    letter-spacing: 0.2px;
}

.btn-primary-modern {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(79, 70, 229, 0.35);
    color: white;
}

.btn-modern.btn-sm {
    width: 42px;
    height: 42px;
    padding: 0;
    font-size: 0.95rem;
    border-radius: 12px;
}

.btn-secondary-modern {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    box-shadow: 0 4px 12px rgba(30, 41, 59, 0.2);
}

.toolbar-card {
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow-light);
    border: 1px solid #f1f5f9;
    padding: 16px 20px;
    margin-bottom: 24px;
}

.toolbar-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.toolbar-actions {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.toolbar-select {
    min-width: 240px;
    max-width: 320px;
    width: 100%;
    min-height: 44px;
    border-radius: 10px;
    padding: 10px 14px;
}

.btn-pill {
    border-radius: 8px;
    padding: 10px 18px;
    min-height: 42px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    color: var(--text-muted);
    font-weight: 600;
    font-size: 0.88rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-pill:hover {
    background: #f1f5f9;
    color: var(--text-dark);
    border-color: #cbd5e1;
    text-decoration: none;
}

.btn-pill.active,
.btn-pill.active:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border-color: transparent;
    box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
}

.toolbar-pill-group {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
}

@media(max-width:768px) {
    .toolbar-row {
        flex-direction: column;
        align-items: stretch;
    }
    .toolbar-actions,
    .toolbar-pill-group {
        justify-content: flex-start;
        width: 100%;
    }
    .toolbar-select {
        min-width: 100%;
    }
}

.filter-card,
.data-table-card {
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow-light);
    border: 1px solid #f1f5f9;
    margin-bottom: 24px;
    overflow: hidden;
}

.filter-card .card-body,
.data-table-card .card-body {
    padding: 24px;
}

.form-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 8px;
}

.form-control,
.form-select {
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    padding: 10px 14px;
    transition: all 0.2s ease;
    box-shadow: none;
    font-size: 0.9rem;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
}

.input-group {
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    display: flex;
    align-items: center;
    background: white;
    overflow: hidden;
}

.input-group:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
}

.input-group .form-control {
    border: none;
    box-shadow: none;
}

.input-group-text {
    border: none;
    background: white;
    color: var(--text-muted);
    padding: 0 14px;
}

.table-modern {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 12px;
}

.table-modern thead th {
    background: transparent;
    border: none;
    padding: 0 20px 12px;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    font-weight: 700;
}

.table-modern tbody td {
    padding: 18px 20px;
    vertical-align: middle;
    border: none;
    background: white;
}

.table-modern tbody tr {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 2px 8px rgba(15,23,42,0.04);
}

.table-modern tbody tr:hover {
    transform: translateY(-1px);
    box-shadow: 0 12px 24px rgba(79, 70, 229, 0.08);
}

.table-modern tbody td:first-child {
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
}

.table-modern tbody td:last-child {
    border-top-right-radius: 12px;
    border-bottom-right-radius: 12px;
}

.student-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 15px;
    flex-shrink: 0;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(79, 70, 229, 0.2);
}

.student-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.status-badge {
    background: #eef2ff;
    color: #4338ca;
    border-radius: 8px;
    padding: 6px 12px;
    display: inline-block;
    font-size: 0.8rem;
    font-weight: 600;
    margin: 3px 0;
    border: 1px solid #e0e7ff;
}

.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: center;
}

.action-btn {
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    border: none;
    color: white;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.action-btn.view {
    background: linear-gradient(135deg, #0ea5e9, #2563eb);
}

.action-btn.edit {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.action-btn.delete {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.empty-state {
    padding: 60px 20px;
    text-align: center;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    color: var(--primary-color);
    opacity: .2;
}

.empty-state h5 {
    font-weight: 700;
    margin-bottom: 8px;
    color: var(--text-dark);
}

.empty-state p {
    color: var(--text-muted);
}

.pagination-container {
    padding: 20px 24px 24px;
}

.pagination {
    justify-content: center;
}

.page-link {
    border: none;
    border-radius: 8px !important;
    margin: 0 3px;
    color: var(--text-dark);
    transition: all 0.2s ease;
    font-weight: 600;
    padding: 0.5rem 0.85rem;
}

.page-link:hover {
    background: #eef2ff;
    color: var(--primary-color);
}

.page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(15px);
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
        font-size: 1.5rem;
    }
    .filter-card .card-body,
    .data-table-card .card-body {
        padding: 16px;
    }
    .table-modern thead {
        display: none;
    }
    .table, .table tbody, .table tr, .table td {
        display: block;
        width: 100%;
    }
    .table tr {
        margin-bottom: 16px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .table td {
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .table td:last-child {
        border-bottom: none;
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
                    <i class="fas fa-user-graduate"></i>
                    Daftar Siswa
                </h1>
                <p class="page-subtitle">
                    Kelola data siswa dengan tampilan dashboard modern dan konsisten.
                </p>
            </div>
            <a href="{{ route('super_admin.manajemen-siswa.create') }}" class="btn-modern btn-primary-modern">
                <i class="fas fa-plus"></i>
                Tambah Siswa
            </a>
        </div>
    </div>

    <div class="toolbar-card">
        <div class="toolbar-row">
            <div class="toolbar-actions">
                <select id="exportJurusan" class="form-select toolbar-select">
                    <option value="">-- Pilih Jurusan untuk Export --</option>
                    @foreach(($allJurusans ?? collect()) as $j)
                        <option value="{{ $j->id }}">{{ $j->nama }}</option>
                    @endforeach
                </select>

                <button id="btnExportJurusan" type="button" class="btn-modern btn-secondary-modern btn-sm" title="Export Jurusan">
                    <i class="fas fa-file-download"></i>
                </button>
                <button id="btnExportAngkatan" type="button" class="btn-modern btn-secondary-modern btn-sm" title="Export Per Angkatan">
                    <i class="fas fa-file-export"></i>
                </button>
                <button type="button" id="btnImportSiswa" class="btn-modern btn-primary-modern btn-sm" title="Import Siswa">
                    <i class="fas fa-upload"></i>
                </button>
                <a href="{{ route('tu.siswa.template.download') }}" class="btn-modern btn-primary-modern btn-sm" title="Download Template">
                    <i class="fas fa-download"></i>
                </a>
                <input type="file" id="importFile" accept=".xlsx,.xls,.csv" style="display:none">
            </div>

            @php $currentTingkat = request()->query('tingkat', ''); @endphp
            <div class="toolbar-pill-group" role="group">
                <a href="{{ request()->url() }}?tingkat=X" class="btn-pill {{ $currentTingkat == 'X' ? 'active' : '' }}">
                    Kelas X
                </a>
                <a href="{{ request()->url() }}?tingkat=XI" class="btn-pill {{ $currentTingkat == 'XI' ? 'active' : '' }}">
                    Kelas XI
                </a>
                <a href="{{ request()->url() }}?tingkat=XII" class="btn-pill {{ $currentTingkat == 'XII' ? 'active' : '' }}">
                    Kelas XII
                </a>
                <a href="{{ route('super_admin.manajemen-siswa.index') }}" class="btn-pill {{ empty($currentTingkat) ? 'active' : '' }}">
                    Semua
                </a>
            </div>
        </div>
    </div>

    <div class="filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('super_admin.manajemen-siswa.index') }}" class="row g-4 align-items-end">
                <div class="col-12 col-md-5">
                    <label class="form-label">Cari nama / NIS / NISN</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Cari nama / NIS / NISN">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Rombel</label>
                    <select name="rombel" class="form-select">
                        <option value="">-- Semua Rombel --</option>
                        @foreach(($allRombels ?? collect()) as $r)
                            @php
                                $rombelNama = $r->nama ?? null;
                                $tingkatVal = optional($r->kelas)->tingkat ?? null;
                                $rombelWithoutTingkat = $rombelNama ? preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama) : null;
                                $rombelWithoutTingkat = $rombelWithoutTingkat ? trim($rombelWithoutTingkat) : null;
                                $formattedRombel = $rombelWithoutTingkat ? preg_replace('/(\D+)(\d+)/', '$1 $2', $rombelWithoutTingkat) : ($rombelNama ?? '');
                            @endphp
                            <option value="{{ $r->id }}" {{ (isset($filterRombel) && $filterRombel == $r->id) ? 'selected' : '' }}>
                                {{ $tingkatVal ? $tingkatVal . ' ' . $formattedRombel : $formattedRombel }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3 d-grid gap-2">
                    <button class="btn-modern btn-primary-modern w-100" type="submit">
                        <i class="fas fa-filter"></i>
                        Filter
                    </button>
                    <a href="{{ route('super_admin.manajemen-siswa.index') }}" class="btn-modern btn-secondary-modern w-100">
                        <i class="fas fa-redo"></i>
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="data-table-card">
        <div class="card-body">
            @if($siswas->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle table-modern mb-0">
                        <thead>
                            <tr>
                                <th style="width: 48px;">#</th>
                                <th>Nama Siswa</th>
                                <th>Rombel</th>
                                <th>Informasi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswas as $siswa)
                                @php
                                    $rombel = $siswa->rombel ?? null;
                                    $rombelNama = $rombel ? ($rombel->nama ?? null) : null;
                                    $tingkatVal = $rombel && $rombel->kelas ? ($rombel->kelas->tingkat ?? null) : null;
                                    // PERBAIKAN: ganti $rombelNombre menjadi $rombelNama
                                    $rombelWithoutTingkat = $rombelNama ? preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama) : null;
                                    $rombelWithoutTingkat = $rombelWithoutTingkat ? trim($rombelWithoutTingkat) : null;
                                    $formatted = $rombelWithoutTingkat ? preg_replace('/(\D+)(\d+)/', '$1 $2', $rombelWithoutTingkat) : null;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration + ($siswas->currentPage() - 1) * $siswas->perPage() }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="student-avatar">
                                                @if($siswa->foto)
                                                    <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                                                @else
                                                    {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $siswa->nama_lengkap }}</div>
                                                <div class="text-muted small">NIS: {{ $siswa->nis }} | NISN: {{ $siswa->nisn }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($rombel)
                                            <span class="status-badge">
                                                @if($tingkatVal)
                                                    {{ $tingkatVal }} {{ $formatted }}
                                                @else
                                                    {{ $formatted }}
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-muted small">
                                            Jenis Kelamin: {{ $siswa->jenis_kelamin }}<br>
                                            {{ optional($siswa->rombel)->nama ? 'Rombel: ' . optional($siswa->rombel)->nama : '' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons justify-content-center">
                                            <a href="{{ route('super_admin.manajemen-siswa.show', $siswa->id) }}" class="action-btn view" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('super_admin.manajemen-siswa.edit', $siswa->id) }}" class="action-btn edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('super_admin.manajemen-siswa.destroy', $siswa->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete" title="Hapus">
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
                    @if(method_exists($siswas, 'links'))
                        {{ $siswas->links('pagination::bootstrap-4') }}
                    @endif
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-user-graduate"></i>
                    <h5>Tidak ada data siswa</h5>
                    <p>Belum ada siswa yang terdaftar.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const select = document.getElementById('exportJurusan');
    const btnJ = document.getElementById('btnExportJurusan');
    const btnA = document.getElementById('btnExportAngkatan');
    const btnImport = document.getElementById('btnImportSiswa');
    const importFile = document.getElementById('importFile');
    const baseJurusan = "{{ url('super_admin/manajemen-siswa/export/jurusan') }}";
    const baseAngkatan = "{{ url('super_admin/manajemen-siswa/export/angkatan') }}";
    const importUrl = "{{ route('super_admin.manajemen-siswa.import') }}";

    function getId(){ return select ? select.value : null; }

    if(btnJ){
        btnJ.addEventListener('click', function(e){
            e.preventDefault();
            const id = getId();
            if(!id){ alert('Pilih jurusan terlebih dahulu'); return; }
            window.location = baseJurusan + '/' + id;
        });
    }

    if(btnA){
        btnA.addEventListener('click', function(e){
            e.preventDefault();
            const id = getId();
            if(!id){ alert('Pilih jurusan terlebih dahulu'); return; }
            window.location = baseAngkatan + '/' + id;
        });
    }

    if(btnImport){
        btnImport.addEventListener('click', function(e){
            e.preventDefault();
            importFile.click();
        });
    }

    if(importFile){
        importFile.addEventListener('change', function(e){
            if(!this.files || this.files.length === 0) return;

            const formData = new FormData();
            formData.append('file', this.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            const originalBtnText = btnImport.innerHTML;
            btnImport.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Proses...';
            btnImport.disabled = true;

            fetch(importUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btnImport.innerHTML = originalBtnText;
                btnImport.disabled = false;

                if(data.success){
                    let successHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    successHtml += '<i class="fas fa-check-circle me-2"></i>' + (data.message || 'Import berhasil');
                    successHtml += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    successHtml += '</div>';

                    const alertContainer = document.createElement('div');
                    alertContainer.innerHTML = successHtml;
                    document.querySelector('.container-fluid').insertBefore(alertContainer.firstElementChild, document.querySelector('.data-table-card'));

                    setTimeout(() => location.reload(), 2000);
                } else {
                    let errorHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    errorHtml += '<i class="fas fa-times-circle me-2"></i>';
                    errorHtml += '<strong>Error:</strong> ' + (data.message || 'Import gagal');
                    errorHtml += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    errorHtml += '</div>';

                    const alertContainer = document.createElement('div');
                    alertContainer.innerHTML = errorHtml;
                    document.querySelector('.container-fluid').insertBefore(alertContainer.firstElementChild, document.querySelector('.data-table-card'));
                }
            })
            .catch(error => {
                btnImport.innerHTML = originalBtnText;
                btnImport.disabled = false;

                let errorHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                errorHtml += '<i class="fas fa-exclamation-circle me-2"></i>';
                errorHtml += 'Terjadi kesalahan: ' + error.message;
                errorHtml += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                errorHtml += '</div>';

                const alertContainer = document.createElement('div');
                alertContainer.innerHTML = errorHtml;
                document.querySelector('.container-fluid').insertBefore(alertContainer.firstElementChild, document.querySelector('.data-table-card'));
            });

            this.value = '';
        });
    }
});
</script>
@endsection