@extends('layouts.app')

@section('title', 'Input Nilai Raport')

@section('content')
<style>
    /* ===================== STYLE INPUT NILAI RAPORT ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    h3 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 10px !important;
    }

    h3::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 3px;
    }

    h3.mb-0 {
        font-size: 28px;
        color: #1E293B;
        position: relative;
        padding-left: 15px;
        margin-bottom: 0 !important;
    }

    h3.mb-0::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 3px;
    }

    p {
        color: #64748B;
        margin-left: 20px;
        margin-bottom: 25px;
    }

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    /* List Group Styles */
    .list-group {
        border-radius: 16px;
    }

    .list-group-flush > .list-group-item {
        border-width: 0 0 1px;
        border-color: #E2E8F0;
        padding: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .list-group-flush > .list-group-item:last-child {
        border-bottom: none;
    }

    .list-group-flush > .list-group-item::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        transform: scaleY(0);
        transition: transform 0.3s ease;
        border-radius: 0 4px 4px 0;
    }

    .list-group-flush > .list-group-item:hover {
        background-color: rgba(47, 83, 255, 0.03);
        padding-left: 25px;
    }

    .list-group-flush > .list-group-item:hover::before {
        transform: scaleY(1);
    }

    .list-group-item-action {
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }

    .list-group-item-action:hover {
        color: var(--primary-color);
    }

    /* Student Info */
    .student-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .student-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 20px;
        flex-shrink: 0;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .list-group-item:hover .student-avatar {
        transform: scale(1.1);
    }

    .student-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .student-details {
        flex: 1;
    }

    .student-details strong {
        font-size: 16px;
        font-weight: 600;
        color: #1E293B;
        display: block;
        margin-bottom: 4px;
    }

    .student-details small {
        color: #64748B;
        font-size: 14px;
        display: block;
    }

    /* Badge Styles */
    .badge {
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        transition: all 0.3s ease;
    }

    .list-group-item:hover .badge {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(47, 83, 255, 0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748B;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .empty-state h5 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .list-group-item {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        h3.mb-0 {
            font-size: 24px;
        }
        
        p {
            margin-left: 0;
            margin-bottom: 20px;
        }
        
        .list-group-flush > .list-group-item {
            padding: 15px;
        }
        
        .student-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .badge {
            align-self: flex-start;
            margin-top: 10px;
        }
    }

    /* Rombel Header */
    .rombel-header {
        font-size: 18px;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 15px;
        padding: 10px 20px;
        background: linear-gradient(135deg, rgba(47, 83, 255, 0.1), rgba(99, 102, 241, 0.1));
        border-radius: 12px;
        border-left: 4px solid var(--primary-color);
    }

    .rombel-section {
        margin-bottom: 30px;
    }

    .rombel-section:last-child {
        margin-bottom: 0;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 12px;
        border: none;
    }

    .modal-header {
        border-radius: 12px 12px 0 0;
    }

    .modal-footer {
        border-radius: 0 0 12px 12px;
    }

    .form-label {
        font-weight: 600;
        color: #1E293B;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border-color: #E2E8F0;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(47, 83, 255, 0.1);
    }

    .btn-outline-success:hover, .btn-outline-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Input Nilai Raport</h3>
            <p class="text-muted mb-0" style="font-size: 14px; margin-top: 4px;">Pilih siswa untuk menginput nilai raport</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Terjadi Kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search & Action Bar -->
    <div class="mb-4">
        <div class="row g-2 mb-3">
            <div class="col-lg-6">
                <form method="GET" class="d-flex gap-2" action="">
                    <input type="text" name="q" value="{{ request('q', $search ?? '') }}" class="form-control" placeholder="Cari nama / NIS / NISN">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="btn btn-outline-secondary">Reset</a>
                </form>
            </div>
            <div class="col-lg-6 d-flex gap-2 justify-content-lg-end">
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#downloadTemplateModal">
                    <i class="fas fa-download"></i> Download Template
                </button>
                <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#importLegerModal">
                    <i class="fas fa-upload"></i> Import Leger
                </button>
            </div>
        </div>
    </div>

    <div class="card shadow">
        @if($siswas->count() > 0)
            @foreach($siswas as $rombel => $siswaList)
                <div class="rombel-section mb-4">
                    <h5 class="rombel-header">{{ $rombel }}</h5>
                    <div class="list-group list-group-flush">
                        @foreach ($siswaList as $siswa)
                            <a href="{{ route('walikelas.input_nilai_raport.create', $siswa->id) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div class="student-info">
                                    <div class="student-avatar">
                                        @if($siswa->foto)
                                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                                        @else
                                            {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="student-details">
                                        <strong>{{ $siswa->nama_lengkap }}</strong>
                                        <small>NIS: {{ $siswa->nis }} | NISN: {{ $siswa->nisn }}</small>
                                    </div>
                                </div>
                                <span class="badge bg-primary">Input Nilai</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-clipboard-list"></i>
                <h5>Tidak ada siswa</h5>
                <p>Belum ada siswa yang terdaftar di kelas Anda.</p>
            </div>
        @endif
    </div>

    <!-- Pagination Links -->
    @if(isset($queryResults) && $queryResults instanceof \Illuminate\Pagination\LengthAwarePaginator && $queryResults->hasPages())
        <div class="p-3">
            {{ $queryResults->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>

<!-- Modal Download Template -->
<div class="modal fade" id="downloadTemplateModal" tabindex="-1" aria-labelledby="downloadTemplateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title" id="downloadTemplateLabel">
                    <i class="fas fa-download text-success me-2"></i>Download Template Leger
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Panduan:</strong> Download template untuk rombel tertentu, isi data nilai siswa, kemudian import kembali.
                </div>
                <form id="downloadTemplateForm" method="POST" action="{{ route('walikelas.input_nilai_raport.download_template') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="templateRombel" class="form-label">Pilih Rombel</label>
                        <select name="rombel_id" id="templateRombel" class="form-select" required>
                            <option value="">-- Pilih Rombel --</option>
                            @forelse($siswas as $rombelName => $siswaList)
                                @php
                                    $rombelObj = $siswaList->first()->rombel;
                                @endphp
                                <option value="{{ $rombelObj->id }}">{{ $rombelName }} ({{ $siswaList->count() }} siswa)</option>
                            @empty
                                <option value="" disabled>Tidak ada rombel</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="templateSemester" class="form-label">Semester</label>
                        <select name="semester" id="templateSemester" class="form-select">
                            <option value="1">Semester 1</option>
                            <option value="2" selected>Semester 2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="templateTahunAjaran" class="form-label">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" id="templateTahunAjaran" class="form-control" placeholder="Cth: 2024/2025" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="downloadTemplateForm" class="btn btn-success">
                    <i class="fas fa-download me-2"></i>Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import Leger -->
<div class="modal fade" id="importLegerModal" tabindex="-1" aria-labelledby="importLegerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title" id="importLegerLabel">
                    <i class="fas fa-upload text-info me-2"></i>Import Data Leger
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Panduan:</strong> Upload file Excel yang sudah diisi dengan data nilai siswa.
                </div>
                <form id="importLegerForm" method="POST" action="{{ route('walikelas.input_nilai_raport.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="importRombel" class="form-label">Pilih Rombel</label>
                        <select name="rombel_id" id="importRombel" class="form-select" required>
                            <option value="">-- Pilih Rombel --</option>
                            @forelse($siswas as $rombelName => $siswaList)
                                @php
                                    $rombelObj = $siswaList->first()->rombel;
                                @endphp
                                <option value="{{ $rombelObj->id }}">{{ $rombelName }}</option>
                            @empty
                                <option value="" disabled>Tidak ada rombel</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="importSemester" class="form-label">Semester</label>
                        <select name="semester" id="importSemester" class="form-select">
                            <option value="1">Semester 1</option>
                            <option value="2" selected>Semester 2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="importTahunAjaran" class="form-label">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" id="importTahunAjaran" class="form-control" placeholder="Cth: 2024/2025" required>
                    </div>
                    <div class="mb-3">
                        <label for="excelFile" class="form-label">File Excel</label>
                        <input type="file" name="file" id="excelFile" class="form-control" accept=".xlsx,.xls,.csv" required>
                        <small class="form-text text-muted">Format: .xlsx, .xls, atau .csv</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="importLegerForm" class="btn btn-info">
                    <i class="fas fa-upload me-2"></i>Import
                </button>
            </div>
        </div>
    </div>
</div>
@endsection