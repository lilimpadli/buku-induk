@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('content')
<style>
    /* ===================== MODERN STYLES DAFTAR SISWA ===================== */
    
    :root {
        --primary-color: #4F46E5;
        --primary-light: #6366F1;
        --secondary-color: #7C3AED;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --info-color: #3B82F6;
        --light-bg: #F9FAFB;
        --card-bg: #FFFFFF;
        --text-primary: #111827;
        --text-secondary: #6B7280;
        --border-color: #E5E7EB;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background: linear-gradient(135deg, #F9FAFB 0%, #F3F4F6 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        min-height: 100vh;
    }

    /* Header Styles */
    .page-header {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .page-title::after {
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
        margin-top: 8px;
    }

    /* Action Bar Styles */
    .action-bar {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
    }

    .action-section {
        display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

    .btn-modern {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: var(--transition);
        border: none;
        display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            white-space: nowrap;
        }

    .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

    .btn-primary-modern {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
        }

    .btn-outline-modern {
        background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

    .btn-outline-modern:hover {
            background: var(--primary-color);
            color: white;
        }

    /* Filter Section */
    .filter-section {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
    }

    .filter-title {
        font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

    .filter-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

    @media (min-width: 768px) {
        .filter-grid {
            grid-template-columns: 2fr 1fr auto;
        }
    }

    .form-control-modern {
        padding: 12px 16px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            transition: var(--transition);
        }

    .form-control-modern:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

    .form-select-modern {
            padding: 12px 16px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            transition: var(--transition);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B7280' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 40px;
        }

    .form-select-modern:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

    /* Class Filter Pills */
    .class-filter {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

    .filter-pill {
            padding: 8px 20px;
            border-radius: 24px;
            font-weight: 500;
            transition: var(--transition);
            text-decoration: none;
            color: var(--text-secondary);
            border: 2px solid transparent;
            background: var(--light-bg);
        }

    .filter-pill:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

    .filter-pill.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

    /* Student Card Styles */
    .student-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: var(--transition);
            margin-bottom: 16px;
        }

    .student-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

    .student-content {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
        }

    .student-content::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

    .student-card:hover .student-content::before {
            opacity: 1;
        }

    /* Avatar Styles */
    .student-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 24px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

    .student-card:hover .student-avatar {
            transform: scale(1.1) rotate(5deg);
        }

    .student-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

    /* Student Info */
    .student-info {
            flex: 1;
            min-width: 0;
        }

    .student-name {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

    .student-details {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 8px;
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

    .student-detail-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

    .student-detail-item i {
            color: var(--primary-color);
            font-size: 12px;
        }

    .student-class-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(99, 102, 241, 0.1));
            color: var(--primary-color);
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            border: 1px solid rgba(79, 70, 229, 0.2);
        }

    /* Action Buttons */
    .student-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

    .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            font-size: 16px;
            position: relative;
            overflow: hidden;
        }

    .action-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

    .action-btn:active::before {
            width: 100px;
            height: 100px;
        }

    .btn-info-modern {
            background: linear-gradient(135deg, var(--info-color), #60A5FA);
            color: white;
        }

    .btn-warning-modern {
            background: linear-gradient(135deg, var(--warning-color), #FCD34D);
            color: white;
        }

    .btn-danger-modern {
            background: linear-gradient(135deg, var(--danger-color), #F87171);
            color: white;
        }

    .action-btn:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

    /* Empty State */
    .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
        }

    .empty-icon {
            font-size: 80px;
            color: var(--primary-color);
            opacity: 0.2;
            margin-bottom: 24px;
            animation: float 3s ease-in-out infinite;
        }

    @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

    .empty-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

    .empty-description {
            color: var(--text-secondary);
            font-size: 16px;
        }

    /* Pagination */
    .pagination-container {
            padding: 24px;
            display: flex;
            justify-content: center;
        }

    .pagination-modern {
            display: flex;
            gap: 4px;
            background: var(--card-bg);
            padding: 8px;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
        }

    .page-link-modern {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: var(--text-secondary);
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

    .page-link-modern:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

    .page-link-modern.active {
            background: var(--primary-color);
            color: white;
        }

    /* Alert Styles */
    .alert-modern {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            box-shadow: var(--shadow-sm);
        }

    .alert-success-modern {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(34, 197, 94, 0.1));
            color: #059669;
        }

    .alert-danger-modern {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(248, 113, 113, 0.1));
            color: #DC2626;
        }

    /* Loading Spinner */
    .spinner-modern {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

    @keyframes spin {
            to { transform: rotate(360deg); }
        }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 20px;
        }

        .page-title {
            font-size: 24px;
        }

        .action-section {
            justify-content: center;
        }

        .student-content {
            padding: 16px;
            gap: 12px;
        }

        .student-avatar {
            width: 56px;
            height: 56px;
            font-size: 20px;
        }

        .student-name {
            font-size: 16px;
        }

        .student-details {
            font-size: 12px;
            gap: 12px;
        }

        .student-actions {
            gap: 4px;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            font-size: 14px;
        }

        .empty-state {
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 60px;
        }
    }

    /* Hide duplicate pagination */
    nav + nav,
    .pagination + .pagination {
        display: none;
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Daftar Siswa</h1>
        </div>
        <a href="{{ route('tu.siswa.create') }}" class="btn-modern btn-primary-modern">
            <i class="fas fa-plus"></i>
            Tambah Siswa
        </a>
    </div>

    <!-- Export/Import Actions -->
    <div class="action-bar">
        <div class="action-section">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex flex-column">
                    <label class="text-muted small mb-1">Export Data</label>
                    <div class="d-flex gap-2">
                        <select id="exportJurusan" class="form-select-modern" style="width: 200px;">
                            <option value="">Pilih Jurusan</option>
                            @foreach(($allJurusans ?? collect()) as $j)
                                <option value="{{ $j->id }}">{{ $j->nama }}</option>
                            @endforeach
                        </select>
                        <button id="btnExportJurusan" class="btn-modern btn-outline-modern">
                            <i class="fas fa-file-export"></i> Export
                        </button>
                        <button id="btnExportAngkatan" class="btn-modern btn-outline-modern">
                            <i class="fas fa-file-export"></i> Export Per Angkatan
                        </button>
                    </div>
                </div>

                <div class="vr"></div>

                <div class="d-flex flex-column">
                    <label class="text-muted small mb-1">Import Data</label>
                    <div class="d-flex gap-2">
                        <a href="{{ route('tu.siswa.template.download') }}" class="btn-modern btn-outline-modern">
                            <i class="fas fa-download"></i> Template
                        </a>
                        <button id="btnImportSiswa" class="btn-modern btn-primary-modern">
                            <i class="fas fa-upload"></i> Import Siswa
                        </button>
                        <input type="file" id="importFile" name="import_file" accept=".xlsx,.xls,.csv" style="display: none;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Class Filter -->
    <div class="class-filter">
        <a href="{{ request()->url() }}?tingkat=X" class="filter-pill {{ $currentTingkat == 'X' ? 'active' : '' }}">
            Kelas X
        </a>
        <a href="{{ request()->url() }}?tingkat=XI" class="filter-pill {{ $currentTingkat == 'XI' ? 'active' : '' }}">
            Kelas XI
        </a>
        <a href="{{ request()->url() }}?tingkat=XII" class="filter-pill {{ $currentTingkat == 'XII' ? 'active' : '' }}">
            Kelas XII
        </a>
        <a href="{{ route('tu.siswa.index') }}" class="filter-pill {{ !$currentTingkat ? 'active' : '' }}">
            Semua Kelas
        </a>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-title">
            <i class="fas fa-filter"></i> Filter Data
        </div>
        <form method="GET" action="{{ route('tu.siswa.index') }}">
            <div class="filter-grid">
                <div>
                    <input type="text" name="search" value="{{ $search ?? '' }}" 
                           class="form-control-modern w-100" 
                           placeholder="Cari nama / NIS / NISN">
                </div>
                <div>
                    <select name="rombel" class="form-select-modern w-100">
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
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-modern btn-primary-modern">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('tu.siswa.index') }}" class="btn-modern btn-outline-modern">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert-modern alert-success-modern">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Student List -->
    @if($siswas->count() > 0)
        <div id="studentList">
            @foreach ($siswas as $siswa)
                <div class="student-card">
                    <div class="student-content">
                        <div class="student-avatar">
                            @if($siswa->foto)
                                <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                            @else
                                {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                            @endif
                        </div>
                        
                        <div class="student-info">
                            <a href="{{ route('tu.siswa.detail', $siswa->id) }}" class="student-name text-decoration-none">
                                {{ $siswa->nama_lengkap }}
                            </a>
                            
                            <div class="student-details">
                                <div class="student-detail-item">
                                    <i class="fas fa-id-card"></i>
                                    <span>NIS: {{ $siswa->nis }}</span>
                                </div>
                                <div class="student-detail-item">
                                    <i class="fas fa-id-badge"></i>
                                    <span>NISN: {{ $siswa->nisn }}</span>
                                </div>
                                <div class="student-detail-item">
                                    <i class="fas fa-venus-mars"></i>
                                    <span>{{ $siswa->jenis_kelamin }}</span>
                                </div>
                            </div>
                            
                            @php
                                $rombel = $siswa->rombel ?? null;
                                $rombelNama = $rombel ? ($rombel->nama ?? null) : null;
                                $tingkatVal = $rombel && $rombel->kelas ? ($rombel->kelas->tingkat ?? null) : null;
                                $rombelWithoutTingkat = $rombelNama ? preg_replace('/\b(X|XI|XII)\b/iu', '', $rombelNama) : null;
                                $rombelWithoutTingkat = $rombelWithoutTingkat ? trim($rombelWithoutTingkat) : null;
                                $formatted = $rombelWithoutTingkat ? preg_replace('/(\D+)(\d+)/', '$1 $2', $rombelWithoutTingkat) : null;
                            @endphp
                            
                            @if($rombel)
                                <div class="student-class-badge">
                                    <i class="fas fa-graduation-cap"></i>
                                    <span>
                                        @if($tingkatVal)
                                            {{ $tingkatVal }} {{ $formatted }}
                                        @else
                                            {{ $formatted }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="student-actions">
                            <a href="{{ route('tu.siswa.detail', $siswa->id) }}" class="action-btn btn-info-modern" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('tu.siswa.edit', $siswa->id) }}" class="action-btn btn-warning-modern" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('tu.siswa.destroy', $siswa->id) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-danger-modern" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="pagination-container">
            @if(method_exists($siswas, 'links'))
                <div class="pagination-modern">
                    {{ $siswas->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <i class="fas fa-user-graduate empty-icon"></i>
            <h2 class="empty-title">Belum ada data siswa</h2>
            <p class="empty-description">Silakan tambahkan siswa baru untuk memulai</p>
            <a href="{{ route('tu.siswa.create') }}" class="btn-modern btn-primary-modern mt-4">
                <i class="fas fa-plus"></i> Tambah Siswa Pertama
            </a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const select = document.getElementById('exportJurusan');
    const btnJ = document.getElementById('btnExportJurusan');
    const btnA = document.getElementById('btnExportAngkatan');
    const btnImport = document.getElementById('btnImportSiswa');
    const importFile = document.getElementById('importFile');
    const baseJurusan = "{{ url('tu/siswa/export/jurusan') }}";
    const baseAngkatan = "{{ url('tu/siswa/export/angkatan') }}";
    const importUrl = "{{ route('tu.siswa.import') }}";

    function getId(){ return select ? select.value : null; }

    // Export functionality
    if(btnJ){
        btnJ.addEventListener('click', function(e){
            e.preventDefault();
            const id = getId();
            if(!id){ 
                showToast('Pilih jurusan terlebih dahulu', 'warning');
                return; 
            }
            this.innerHTML = '<span class="spinner-modern"></span> Exporting...';
            this.disabled = true;
            
            window.location = baseJurusan + '/' + id;
            
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-file-export"></i> Export';
                this.disabled = false;
            }, 1000);
        });
    }

    if(btnA){
        btnA.addEventListener('click', function(e){
            e.preventDefault();
            const id = getId();
            if(!id){ 
                showToast('Pilih jurusan terlebih dahulu', 'warning');
                return; 
            }
            this.innerHTML = '<span class="spinner-modern"></span> Exporting...';
            this.disabled = true;
            
            window.location = baseAngkatan + '/' + id;
            
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-file-export"></i> Export Per Angkatan';
                this.disabled = false;
            }, 1000);
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
            const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2);
            
            showToast(`Mengupload file: ${fileName} (${fileSize} MB)`, 'info');

            const formData = new FormData();
            formData.append('file', this.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            // Show loading
            const originalBtnText = btnImport.innerHTML;
            btnImport.innerHTML = '<span class="spinner-modern"></span> Mengimpor...';
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
                    let message = data.message || 'Import berhasil';
                    
                    if(data.warnings && data.warnings.length > 0) {
                        let warningHtml = `<div class="alert-modern alert-warning-modern">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>${message}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;
                        
                        insertAlert(warningHtml);
                        showToast('Import berhasil dengan beberapa peringatan', 'warning');
                    } else {
                        showToast(message, 'success');
                    }

                    setTimeout(() => location.reload(), 2000);
                } else {
                    let errorHtml = `<div class="alert-modern alert-danger-modern">
                        <i class="fas fa-times-circle"></i>
                        <span>${data.message || 'Import gagal'}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    
                    insertAlert(errorHtml);
                    showToast('Import gagal', 'error');
                }
            })
            .catch(error => {
                btnImport.innerHTML = originalBtnText;
                btnImport.disabled = false;
                
                let errorHtml = `<div class="alert-modern alert-danger-modern">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Terjadi kesalahan: ${error.message}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
                
                insertAlert(errorHtml);
                showToast('Terjadi kesalahan saat mengupload', 'error');
            });

            // Reset file input
            this.value = '';
        });
    }

    // Helper functions
    function insertAlert(html) {
        const alertContainer = document.createElement('div');
        alertContainer.innerHTML = html;
        document.querySelector('.container-fluid').insertBefore(alertContainer.firstElementChild, document.querySelector('.student-card, .empty-state, .pagination-container'));
    }

    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `alert-modern alert-${type}-modern position-fixed top-0 start-50 translate-middle-x mt-3 z-50`;
        toast.style.animation = 'slideIn 0.3s ease-out';
        toast.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : type === 'error' ? 'times-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-in';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
});

// Add slide animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(-50%) translateY(-100%); opacity: 0; }
        to { transform: translateX(-50%) translateY(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(-50%) translateY(0); opacity: 1; }
        to { transform: translateX(-50%) translateY(-100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
@endsection