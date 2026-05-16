@extends('layouts.app')

@section('title', 'Daftar Siswa')

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
    justify-content: center;
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

.btn-modern.btn-sm {
    width: 42px;
    height: 42px;
    padding: 0;
    font-size: 14px;
    border-radius: 50%;
}

.btn-modern.btn-sm i {
    width: 18px;
    height: 18px;
}

.btn-primary-modern {
    background: linear-gradient(135deg, #2F53FF 0%, #7C3AED 100%);
}

.btn-secondary-modern {
    background: linear-gradient(135deg, #4F46E5 0%, #22D3EE 100%);
}

.btn-secondary-outline {
    background: white;
    color: var(--text-dark);
    border: 1px solid rgba(15,23,42,0.12);
}

.btn-secondary-outline:hover {
    background: #F8FAFF;
}

.toolbar-card {
    background: white;
    border-radius: 24px;
    box-shadow: var(--shadow-light);
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
    border-radius: 16px;
    padding: 12px 14px;
}

.toolbar-icon-btn {
    width: 44px;
    height: 44px;
    padding: 0;
    border-radius: 16px;
}

.btn-pill {
    border-radius: 999px;
    padding: 10px 18px;
    min-height: 44px;
    border: 1px solid rgba(47,83,255,.16);
    background: #F8FAFF;
    color: var(--text-dark);
    font-weight: 600;
    transition: all .3s ease;
}

.btn-pill:hover {
    background: #EFF6FF;
    color: var(--text-dark);
    box-shadow: var(--shadow-light);
}

.btn-pill.active,
.btn-pill.active:hover {
    background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
    color: white;
    border-color: transparent;
    box-shadow: var(--shadow-hover);
}

.toolbar-pill-group {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
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

.status-badge {
    background: linear-gradient(135deg, #2F53FF 0%, #22D3EE 100%);
    color: white;
    border-radius: 999px;
    padding: 8px 14px;
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    margin: 3px 0;
    box-shadow: 0 10px 25px rgba(47,83,255,0.12);
    transition: transform .3s ease, box-shadow .3s ease;
}

.pill-badge {
    background: rgba(47,83,255,.08);
    color: var(--text-dark);
    border-radius: 999px;
    padding: 8px 14px;
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
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

                <button id="btnExportJurusan" type="button" class="btn-modern btn-secondary-modern btn-sm toolbar-icon-btn" title="Export Jurusan">
                    <i class="fas fa-file-download"></i>
                </button>
                <button id="btnExportAngkatan" type="button" class="btn-modern btn-secondary-modern btn-sm toolbar-icon-btn" title="Export Per Angkatan">
                    <i class="fas fa-file-export"></i>
                </button>
                <button type="button" id="btnImportSiswa" class="btn-modern btn-primary-modern btn-sm toolbar-icon-btn" title="Import Siswa">
                    <i class="fas fa-upload"></i>
                </button>
                <a href="{{ route('tu.siswa.template.download') }}" class="btn-modern btn-secondary-modern btn-sm toolbar-icon-btn" title="Download Template">
                    <i class="fas fa-download"></i>
                </a>
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

    // Import functionality
    if(btnImport){
        btnImport.addEventListener('click', function(e){
            e.preventDefault();
            importFile.click();
        });
    }

    if(importFile){
        importFile.addEventListener('change', function(e){
            if(!this.files || this.files.length === 0) return;
            
            const fileName = this.files[0].name;
            const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2); // Size in MB
            
            console.log(`Uploading file: ${fileName} (${fileSize} MB)`);

            const formData = new FormData();
            formData.append('file', this.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            // Show loading indicator
            const originalBtnText = btnImport.innerHTML;
            btnImport.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Proses...';
            btnImport.disabled = true;

            fetch(importUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                // Log response info
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                btnImport.innerHTML = originalBtnText;
                btnImport.disabled = false;

                console.log('Import result:', data);

                if(data.success){
                    // Success message
                    let message = data.message || 'Import berhasil';
                    
                    if(data.warnings && data.warnings.length > 0) {
                        // Show success with warnings
                        let warningHtml = '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                        warningHtml += '<i class="fas fa-exclamation-triangle me-2"></i>';
                        warningHtml += '<strong>Peringatan:</strong> ' + message + '<br>';
                        warningHtml += '<small>';
                        data.warnings.slice(0, 5).forEach(warning => {
                            warningHtml += '• ' + warning + '<br>';
                        });
                        if(data.warning_count > 5) {
                            warningHtml += '• ... dan ' + (data.warning_count - 5) + ' peringatan lainnya';
                        }
                        warningHtml += '</small>';
                        warningHtml += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        warningHtml += '</div>';
                        
                        // Insert warning before the data table
                        const alertContainer = document.createElement('div');
                        alertContainer.innerHTML = warningHtml;
                        document.querySelector('.container-fluid').insertBefore(alertContainer.firstElementChild, document.querySelector('.data-table-card'));
                    } else {
                        // Show pure success
                        let successHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                        successHtml += '<i class="fas fa-check-circle me-2"></i>' + message;
                        successHtml += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        successHtml += '</div>';
                        
                        const alertContainer = document.createElement('div');
                        alertContainer.innerHTML = successHtml;
                        document.querySelector('.container-fluid').insertBefore(alertContainer.firstElementChild, document.querySelector('.data-table-card'));
                    }

                    // Reload page after 2 seconds
                    setTimeout(() => location.reload(), 2000);
                } else {
                    // Error message
                    let errorHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    errorHtml += '<i class="fas fa-times-circle me-2"></i>';
                    errorHtml += '<strong>Error:</strong> ' + (data.message || 'Import gagal') + '<br>';
                    if(data.errors && data.errors.length > 0) {
                        errorHtml += '<small>';
                        data.errors.slice(0, 5).forEach(error => {
                            errorHtml += '• ' + error + '<br>';
                        });
                        if(data.errors.length > 5) {
                            errorHtml += '• ... dan ' + (data.errors.length - 5) + ' error lainnya';
                        }
                        errorHtml += '</small>';
                    }
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
                
                console.error('Error:', error);
                let errorHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                errorHtml += '<i class="fas fa-exclamation-circle me-2"></i>';
                errorHtml += 'Terjadi kesalahan saat mengupload file: ' + error.message;
                errorHtml += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                errorHtml += '</div>';
                
                const alertContainer = document.createElement('div');
                alertContainer.innerHTML = errorHtml;
                document.querySelector('.container-fluid').insertBefore(alertContainer.firstElementChild, document.querySelector('.data-table-card'));
            });

            // Reset file input
            this.value = '';
        });
    }
});
</script>
@endsection