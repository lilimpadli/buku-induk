@extends('layouts.app')

@section('title', 'Daftar Buku Induk Siswa')

@section('content')
<style>
/* ================= GLOBAL ================= */

body{
    background:#f8fafc;
    font-family:'Segoe UI', sans-serif;
}

/* ================= HEADER ================= */

.header-section{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
    gap:10px;
    flex-wrap:wrap;
}

.header-section h1{
    font-weight:700;
    color:#1e293b;
    margin:0;
}

/* ================= CARD ================= */

.card{
    border:none;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.06);
    background:#fff;
}

.card-body{
    padding:16px;
}

/* ================= FORM ================= */

.form-control,
.form-select{
    height:45px;
    border-radius:10px;
    border:1px solid #dbe2ea;
    font-size:14px;
}

.form-control:focus,
.form-select:focus{
    box-shadow:none;
    border-color:#2F53FF;
}

.btn{
    border-radius:10px;
    font-weight:600;
}

.btn-primary{
    background:#2F53FF;
    border:none;
}

.btn-primary:hover{
    background:#2446e6;
}

.btn-secondary{
    border:none;
}

/* ================= TABLE ================= */

.table-responsive{
    overflow-x:auto;
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
    padding:14px 10px;
    text-align:center;
    vertical-align:middle;
    border-bottom:1px solid #e2e8f0;
    white-space:nowrap;
    color:#334155;
}

.table tbody td{
    padding:14px 10px;
    vertical-align:middle;
    border-bottom:1px solid #f1f5f9;
    font-size:14px;
    color:#1e293b;
}

/* Hover */

.table tbody tr:hover{
    background:#f8fbff;
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
    width:130px;
}

.table th:nth-child(4),
.table td:nth-child(4){
    width:140px;
}

.table th:nth-child(5),
.table td:nth-child(5){
    min-width:220px;
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
    width:45px;
    height:45px;
    border-radius:50%;
    overflow:hidden;
    background:linear-gradient(135deg,#2F53FF,#6366F1);
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    margin:auto;
    font-size:18px;
}

.student-avatar img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* ================= BADGE ================= */

.badge{
    padding:6px 10px;
    border-radius:20px;
    font-size:11px;
    font-weight:600;
}

/* ================= EMPTY STATE ================= */

.empty-state{
    text-align:center;
    padding:40px 20px;
    color:#64748b;
}

.empty-state i{
    font-size:40px;
    margin-bottom:10px;
}

/* ================= MOBILE CARD ================= */

.mobile-card-view{
    display:none;
}

.student-card{
    background:#fff;
    border-radius:14px;
    padding:15px;
    margin-bottom:15px;
    box-shadow:0 2px 10px rgba(0,0,0,.06);
}

.student-card-header{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:15px;
}

.student-card-avatar{
    width:55px;
    height:55px;
    border-radius:50%;
    overflow:hidden;
    background:linear-gradient(135deg,#2F53FF,#6366F1);
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:20px;
}

.student-card-avatar img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.student-card-info{
    flex:1;
}

.student-card-name{
    font-size:16px;
    font-weight:700;
    color:#1e293b;
}

.student-card-nis{
    font-size:13px;
    color:#64748b;
}

.student-card-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:8px 0;
    border-bottom:1px solid #f1f5f9;
}

.student-card-label{
    font-size:13px;
    color:#64748b;
}

.student-card-value{
    font-size:14px;
    font-weight:600;
}

.student-card-actions{
    display:flex;
    gap:10px;
    margin-top:15px;
}

.student-card-actions .btn{
    flex:1;
}

/* ================= PAGINATION ================= */

.pagination{
    justify-content:center;
    margin-bottom:0;
}

.page-link{
    border:none;
    margin:0 3px;
    border-radius:8px;
    color:#2F53FF;
}

.page-item.active .page-link{
    background:#2F53FF;
    border-color:#2F53FF;
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
    }

    .header-section .btn{
        width:100%;
    }

    .card-body{
        padding:12px;
    }

    .form-control,
    .form-select{
        font-size:13px;
    }

    .btn{
        font-size:14px;
    }
}

/* ================= DESKTOP ================= */

@media (min-width:768px){

    .mobile-card-view{
        display:none !important;
    }
}
</style>

<div class="container mt-4">
    <div class="header-section">
        <h1 class="h3 mb-0">
            <i class="fas fa-book text-primary"></i> Daftar Buku Induk Siswa
        </h1>
        <a href="{{ route('tu.siswa.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4 col-12">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, NIS, atau NISN siswa..." 
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-4 col-12">
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
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="card shadow">
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
                                <span class="badge bg-info">Laki-laki</span>
                                @elseif($siswa->jenis_kelamin == 'Perempuan')
                                <span class="badge bg-danger">Perempuan</span>
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
                                @if($siswa->mutasiTerakhir)
                                    <span class="badge bg-{{ $siswa->mutasiTerakhir->status_color }}">
                                        {{ $siswa->mutasiTerakhir->status_label }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Aktif</span>
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
                                    <p>Belum ada siswa yang terdaftar.</p>
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
            <div class="p-3">
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
                                    <span class="badge bg-info">Laki-laki</span>
                                @elseif($siswa->jenis_kelamin == 'Perempuan')
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
                            @if($siswa->mutasiTerakhir)
                                <span class="badge bg-{{ $siswa->mutasiTerakhir->status_color }}">
                                    {{ $siswa->mutasiTerakhir->status_label }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Aktif</span>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="student-card-actions">
                    <a href="{{ route('tu.buku-induk.show', $siswa) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-1"></i> Lihat
                    </a>
                    <a href="{{ route('tu.buku-induk.cetak', $siswa) }}" target="_blank" class="btn btn-success btn-sm">
                        <i class="fas fa-print me-1"></i> Cetak
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h5>Tidak ada data siswa</h5>
                <p>Belum ada siswa yang terdaftar.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination - Single location at bottom -->
    
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
@endsection