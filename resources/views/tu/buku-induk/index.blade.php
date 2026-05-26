@extends('layouts.app')

@section('title', 'Daftar Buku Induk Siswa')

@section('content')
<style>
/* ================= GLOBAL ================= */

body{
    background:#f8fafc;
    font-family:'Segoe UI', sans-serif;
    color:#334155;
    line-height:1.6;
}

/* ================= HEADER ================= */

.header-section{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:32px;
    gap:20px;
    flex-wrap:wrap;
}

.header-section h1{
    font-weight:700;
    color:#1e293b;
    margin:0;
    display:flex;
    align-items:center;
    gap:12px;
    font-size:24px;
}

.header-section h1 i{
    color:#3b82f6;
    font-size:28px;
}

/* ================= CARD ================= */

.card{
    border:none;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 4px 20px rgba(0,0,0,0.08);
    background:#fff;
    transition:all 0.3s ease;
}

.card:hover{
    box-shadow:0 8px 30px rgba(0,0,0,0.12);
}

.card-body{
    padding:24px;
}

/* ================= FORM ================= */

.form-control,
.form-select{
    height:48px;
    border-radius:12px;
    border:1px solid #e2e8f0;
    font-size:14px;
    transition:all 0.3s ease;
}

.form-control:focus,
.form-select:focus{
    box-shadow:0 0 0 3px rgba(59,130,246,0.1);
    border-color:#3b82f6;
    outline:none;
}

.btn{
    border-radius:12px;
    font-weight:600;
    padding:12px 24px;
    transition:all 0.3s ease;
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.btn-primary{
    background:#3b82f6;
    border:none;
    color:white;
}

.btn-primary:hover{
    background:#2563eb;
    transform:translateY(-1px);
    box-shadow:0 4px 12px rgba(59,130,246,0.3);
}

.btn-secondary{
    border:none;
    color:#64748b;
}

.btn-secondary:hover{
    background:#f1f5f9;
    color:#334155;
}

/* ================= TABLE ================= */

.table-responsive{
    overflow-x:auto;
    margin:0;
    border-radius:12px;
}

.table{
    width:100%;
    margin-bottom:0;
    border-collapse:collapse;
    background:#fff;
}

.table thead th{
    background:#f8fafc;
    font-weight:600;
    font-size:14px;
    padding:16px 12px;
    text-align:center;
    vertical-align:middle;
    border-bottom:2px solid #e2e8f0;
    white-space:nowrap;
    color:#334155;
    position:sticky;
    top:0;
    z-index:10;
}

.table tbody td{
    padding:16px 12px;
    vertical-align:middle;
    border-bottom:1px solid #f1f5f9;
    font-size:14px;
    color:#475569;
}

/* Hover */

.table tbody tr{
    transition:background-color 0.2s ease;
}

.table tbody tr:hover{
    background:#f0f9ff;
}

/* Width Kolom */

.table th:nth-child(1),
.table td:nth-child(1){
    width:60px;
    text-align:center;
}

.table th:nth-child(2),
.table td:nth-child(2){
    width:80px;
    text-align:center;
}

.table th:nth-child(3),
.table td:nth-child(3){
    width:100px;
}

.table th:nth-child(4),
.table td:nth-child(4){
    width:120px;
}

.table th:nth-child(5),
.table td:nth-child(5){
    min-width:200px;
}

.table th:nth-child(6),
.table td:nth-child(6),
.table th:nth-child(7),
.table td:nth-child(7),
.table th:nth-child(8),
.table td:nth-child(8),
.table th:nth-child(9),
.table td:nth-child(9){
    text-align:center;
}

/* ================= AVATAR ================= */

.student-avatar{
    width:48px;
    height:48px;
    border-radius:50%;
    overflow:hidden;
    background:linear-gradient(135deg,#3b82f6,#6366f1);
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    margin:auto;
    font-size:18px;
    box-shadow:0 2px 8px rgba(59,130,246,0.2);
    transition:all 0.3s ease;
}

.student-avatar:hover{
    transform:scale(1.1);
    box-shadow:0 4px 12px rgba(59,130,246,0.3);
}

.student-avatar img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* ================= BADGE ================= */

.badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    gap:4px;
}

/* ================= EMPTY STATE ================= */

.empty-state{
    text-align:center;
    padding:60px 20px;
    color:#64748b;
}

.empty-state i{
    font-size:48px;
    margin-bottom:16px;
    color:#cbd5e1;
}

.empty-state h5{
    color:#475569;
    margin-bottom:8px;
    font-weight:600;
}

.empty-state p{
    color:#94a3b8;
    margin:0;
}

/* ================= MOBILE CARD VIEW ================= */

.mobile-card-view{
    display:none;
}

.student-card{
    background:#fff;
    border-radius:16px;
    padding:20px;
    margin-bottom:20px;
    box-shadow:0 2px 12px rgba(0,0,0,0.06);
    transition:all 0.3s ease;
}

.student-card:hover{
    transform:translateY(-2px);
    box-shadow:0 4px 20px rgba(0,0,0,0.1);
}

.student-card-header{
    display:flex;
    align-items:center;
    gap:16px;
    margin-bottom:20px;
}

.student-card-avatar{
    width:56px;
    height:56px;
    border-radius:50%;
    overflow:hidden;
    background:linear-gradient(135deg,#3b82f6,#6366f1);
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:20px;
    box-shadow:0 2px 8px rgba(59,130,246,0.2);
}

.student-card-avatar img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.student-card-info{
    flex:1;
    min-width:0;
}

.student-card-name{
    font-size:16px;
    font-weight:700;
    color:#1e293b;
    margin-bottom:4px;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.student-card-nis{
    font-size:13px;
    color:#64748b;
}

.student-card-body{
    margin-bottom:20px;
}

.student-card-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 0;
    border-bottom:1px solid #f1f5f9;
}

.student-card-row:last-child{
    border-bottom:none;
}

.student-card-label{
    font-size:13px;
    color:#64748b;
    font-weight:500;
}

.student-card-value{
    font-size:14px;
    font-weight:600;
    display:flex;
    align-items:center;
    gap:4px;
}

.student-card-actions{
    display:flex;
    gap:12px;
    margin-top:20px;
}

.student-card-actions .btn{
    flex:1;
    padding:10px 16px;
    font-size:14px;
}

/* ================= PAGINATION ================= */

.pagination{
    justify-content:center;
    margin-top:24px;
    margin-bottom:0;
}

.page-link{
    border:none;
    margin:0 4px;
    border-radius:8px;
    color:#3b82f6;
    padding:10px 16px;
    transition:all 0.2s ease;
}

.page-link:hover{
    background:#f0f9ff;
    color:#2563eb;
}

.page-item.active .page-link{
    background:#3b82f6;
    border-color:#3b82f6;
    color:white;
}

/* ================= MOBILE ================= */

@media (max-width:767px){
    .table-responsive{
        display:none !important;
    }

    .mobile-card-view{
        display:block;
    }

    .header-section{
        flex-direction:column;
        align-items:stretch;
        gap:16px;
    }

    .header-section h1{
        font-size:20px;
        justify-content:center;
    }

    .card-body{
        padding:20px;
    }

    .form-control,
    .form-select{
        font-size:14px;
    }

    .btn{
        font-size:14px;
        padding:10px 20px;
    }

    .empty-state{
        padding:40px 16px;
    }

    .empty-state i{
        font-size:36px;
    }

    .student-card{
        padding:16px;
    }

    .student-card-header{
        gap:12px;
    }

    .student-card-avatar{
        width:48px;
        height:48px;
    }

    .student-card-actions{
        gap:8px;
    }

    .student-card-actions .btn{
        padding:8px 12px;
        font-size:13px;
    }
}

/* ================= DESKTOP ================= */

@media (min-width:768px){
    .mobile-card-view{
        display:none !important;
    }
}

/* ================= LOADING ANIMATION ================= */

@keyframes pulse {
    0%{opacity:1}
    50%{opacity:.5}
    100%{opacity:1}
}

.loading-row td{
    animation:pulse 1.5s infinite;
}

/* ================= TOOLTIP ================= */

[data-bs-toggle="tooltip"]{
    cursor:help;
}

/* ================= SEARCH HINT ================= */

.search-hint{
    font-size:12px;
    color:#64748b;
    margin-top:4px;
}

/* ================= FILTER SECTION ================= */

.filter-section{
    background:#f8fafc;
    border-radius:12px;
    padding:20px;
    margin-bottom:24px;
}

.filter-title{
    font-size:16px;
    font-weight:600;
    color:#334155;
    margin-bottom:16px;
    display:flex;
    align-items:center;
    gap:8px;
}

.filter-title i{
    color:#3b82f6;
}

/* ================= ACTION BUTTONS ================= */

.action-buttons{
    display:flex;
    gap:12px;
    margin-top:20px;
}

.action-buttons .btn{
    flex:1;
}

/* ================= RESPONSIVE TABLE ================= */

@media (max-width:576px){
    .table th,
    .table td{
        font-size:12px;
        padding:8px 6px;
    }

    .table th:nth-child(5),
    .table td:nth-child(5){
        min-width:150px;
    }
}
</style>

<div class="container mt-4">
    <div class="header-section">
        <h1 class="h3 mb-0">
            <i class="fas fa-book text-primary"></i> Daftar Buku Induk Siswa
        </h1>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-title">
            <i class="fas fa-filter"></i> Filter Pencarian
        </div>
        <form method="GET" class="row g-3">
            <div class="col-md-4 col-12">
                <label class="form-label small text-muted mb-1">Cari Siswa</label>
                <input type="text" name="search" class="form-control" placeholder="Nama, NIS, atau NISN..." 
                    value="{{ request('search') }}">
                <div class="search-hint">Ketik minimal 3 karakter untuk pencarian</div>
            </div>
            <div class="col-md-4 col-12">
                <label class="form-label small text-muted mb-1">Jurusan</label>
                <select name="jurusan_id" class="form-select">
                    <option value="">-- Semua Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-12">
                <label class="form-label small text-muted mb-1">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Desktop Table View -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>NIS</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th>Rombel</th>
                            <th>Status Terakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $index => $siswa)
                            <tr>
                                <td>{{ $siswas->firstItem() + $index }}</td>
                                <td>
                                    <div class="student-avatar" data-bs-toggle="tooltip" title="{{ $siswa->nama_lengkap }}">
                                        @if($siswa->user && $siswa->user->photo)
                                            <img src="{{ Storage::url($siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}">
                                        @else
                                            {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                        @endif
                                    </div>
                                </td>
                                <td><strong>{{ $siswa->nis }}</strong></td>
                                <td>{{ $siswa->nisn ?? '-' }}</td>
                                <td>{{ $siswa->nama_lengkap }}</td>
                                <td>
                                    @if($siswa->jenis_kelamin == 'Laki-laki')
                                        <span class="badge bg-info text-white">
                                            <i class="fas fa-mars"></i> Laki-laki
                                        </span>
                                    @elseif($siswa->jenis_kelamin == 'Perempuan')
                                        <span class="badge bg-danger text-white">
                                            <i class="fas fa-venus"></i> Perempuan
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($siswa->rombel)
                                        <span class="badge bg-primary">{{ $siswa->rombel->nama }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $terminalStatuses = ['pindah', 'do', 'meninggal'];
                                    @endphp
                                    @if($siswa->mutasiTerakhir && in_array($siswa->mutasiTerakhir->status, $terminalStatuses))
                                        <span class="badge bg-{{ $siswa->mutasiTerakhir->status_color }} text-white">
                                            {{ $siswa->mutasiTerakhir->status_label }}
                                        </span>
                                    @else
                                        <span class="badge bg-success text-white">Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('tu.buku-induk.show', $siswa) }}" class="btn btn-outline-primary" 
                                            data-bs-toggle="tooltip" title="Lihat Buku Induk">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('tu.buku-induk.cetak', $siswa) }}" target="_blank" class="btn btn-outline-success" 
                                            data-bs-toggle="tooltip" title="Cetak">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h5>Tidak ada data siswa</h5>
                                        <p>Belum ada siswa yang terdaftar atau tidak ada hasil pencarian.</p>
                                        <a href="{{ route('tu.siswa.index') }}" class="btn btn-primary mt-3">
                                            <i class="fas fa-plus"></i> Tambah Siswa
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($siswas->hasPages())
            <div class="p-4">
                {{ $siswas->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>

    <!-- Mobile Card View -->
    <div class="mobile-card-view">
        @forelse($siswas as $siswa)
            <div class="student-card">
                <div class="student-card-header">
                    <div class="student-card-avatar">
                        @if($siswa->user && $siswa->user->photo)
                            <img src="{{ Storage::url($siswa->user->photo) }}" alt="{{ $siswa->nama_lengkap }}">
                        @else
                            {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                        @endif
                    </div>
                    <div class="student-card-info">
                        <div class="student-card-name">{{ $siswa->nama_lengkap }}</div>
                        <div class="student-card-nis">NIS: {{ $siswa->nis }} | NISN: {{ $siswa->nisn ?? '-' }}</div>
                    </div>
                </div>

                <div class="student-card-body">
                    <div class="student-card-row">
                        <span class="student-card-label">Jenis Kelamin</span>
                        <span class="student-card-value">
                            @if($siswa->jenis_kelamin == 'Laki-laki')
                                <span class="badge bg-info text-white">
                                    <i class="fas fa-mars"></i> Laki-laki
                                </span>
                            @elseif($siswa->jenis_kelamin == 'Perempuan')
                                <span class="badge bg-danger text-white">
                                    <i class="fas fa-venus"></i> Perempuan
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </span>
                    </div>

                    <div class="student-card-row">
                        <span class="student-card-label">Rombel</span>
                        <span class="student-card-value">
                            @if($siswa->rombel)
                                <span class="badge bg-primary">{{ $siswa->rombel->nama }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </span>
                    </div>

                    <div class="student-card-row">
                        <span class="student-card-label">Status</span>
                        <span class="student-card-value">
                            @php
                                $terminalStatuses = ['pindah', 'do', 'meninggal'];
                            @endphp
                            @if($siswa->mutasiTerakhir && in_array($siswa->mutasiTerakhir->status, $terminalStatuses))
                                <span class="badge bg-{{ $siswa->mutasiTerakhir->status_color }} text-white">
                                    {{ $siswa->mutasiTerakhir->status_label }}
                                </span>
                            @else
                                <span class="badge bg-success text-white">Aktif</span>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="student-card-actions">
                    <a href="{{ route('tu.buku-induk.show', $siswa) }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Lihat
                    </a>
                    <a href="{{ route('tu.buku-induk.cetak', $siswa) }}" target="_blank" class="btn btn-success">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h5>Tidak ada data siswa</h5>
                <p>Belum ada siswa yang terdaftar atau tidak ada hasil pencarian.</p>
                <a href="{{ route('tu.siswa.index') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus"></i> Tambah Siswa
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination for mobile -->
    @if($siswas->hasPages())
        <div class="mobile-card-view">
            <div class="p-4">
                {{ $siswas->links('pagination::bootstrap-4') }}
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Add smooth scroll behavior for pagination
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            if (!this.classList.contains('disabled')) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Auto-hide search hint when typing
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const hint = this.nextElementSibling;
            if (hint && hint.classList.contains('search-hint')) {
                if (this.value.length >= 3) {
                    hint.style.display = 'none';
                } else {
                    hint.style.display = 'block';
                }
            }
        });
    }
});
</script>
@endpush
@endsection