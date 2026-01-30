@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
<style>
    /* ===================== STYLE DETAIL KELAS ===================== */
    
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

    .container {
        max-width: 1200px;
    }

    /* Card Styles */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-body.d-flex {
        padding: 1.25rem;
    }

    /* Section Headers */
    h5.mb-0 {
        font-size: 20px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 0 !important;
        position: relative;
        padding-left: 15px;
    }

    h5.mb-0::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
    }

    h6.card-title {
        font-size: 18px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 1rem;
        position: relative;
        padding-left: 15px;
    }

    h6.card-title::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
    }

    /* Table Styles */
    .table {
        margin-bottom: 0;
    }

    .table-sm {
        font-size: 14px;
    }

    .table thead th {
        border-bottom: 2px solid #E2E8F0;
        color: #475569;
        font-weight: 600;
        padding: 12px 15px;
    }

    .table td, .table th {
        border-color: #E2E8F0;
        padding: 12px 15px;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.03);
    }

    /* Button Styles */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .btn-secondary {
        background-color: #64748B;
        border-color: #64748B;
    }

    .btn-secondary:hover {
        background-color: #475569;
        border-color: #475569;
    }

    .btn-sm {
        padding: 0.4rem 1rem;
        font-size: 14px;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 16px;
        border: none;
    }

    .modal-header {
        border-bottom: 1px solid #E2E8F0;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid #E2E8F0;
        padding: 1.5rem;
    }

    /* Table in Modal */
    .modal-body .table-sm th {
        width: 30%;
        color: #475569;
        font-weight: 600;
    }

    .modal-body .table-sm td {
        color: #334155;
    }

    /* Text Styles */
    .text-muted {
        color: #64748B !important;
        font-size: 14px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }
        
        .card-body.d-flex {
            padding: 1rem;
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        h5.mb-0 {
            font-size: 18px;
            margin-bottom: 0.5rem !important;
        }
        
        .btn {
            padding: 0.4rem 1rem;
            font-size: 14px;
        }
        
        .table thead th,
        .table td, .table th {
            padding: 8px 10px;
            font-size: 13px;
        }
        
        .modal-body .table-sm th {
            width: 40%;
        }
    }
</style>

<div class="container mt-4">
    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">{{ $rombel->nama }}</h5>
                <small class="text-muted">Kelas: {{ $rombel->kelas->tingkat ?? '-' }} - Jurusan: {{ $rombel->kelas->jurusan->nama ?? '-' }}</small>
            </div>
            <div>
                <a href="{{ route('kaprog.export.rombel', $rombel->id) }}" class="btn btn-success btn-sm me-2" title="Export siswa rombel ini">
                    <i class="fas fa-file-excel me-1"></i> Export Rombel
                </a>
                
                <a href="{{ route('kaprog.kelas.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="card mb-3" style="border: 1px solid #E2E8F0; border-radius: 8px;">
        <div class="card-body" style="background-color: #F8FAFC;">
            <form method="GET" action="{{ route('kaprog.kelas.show', $rombel->id) }}" class="row g-3">
                <!-- Search Box -->
                <div class="col-md-7">
                    <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Cari Siswa</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: white; border: 1px solid #E2E8F0;">
                            <i class="bi bi-search"></i>
                        </span>
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control" 
                            placeholder="Nama, NIS, atau NISN..." 
                            value="{{ $search }}"
                            style="border: 1px solid #E2E8F0;"
                        >
                    </div>
                </div>

                <!-- Filter Jenis Kelamin -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="color: #475569; font-size: 14px;">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" style="border: 1px solid #E2E8F0;">
                        <option value="">-- Semua --</option>
                        <option value="Laki-laki" {{ $filterJenisKelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $filterJenisKelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-md-2 d-flex gap-2 align-items-end">
                    <button type="submit" class="btn btn-primary flex-grow-1" style="background: linear-gradient(to right, #2F53FF, #6366F1); border: none;">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('kaprog.kelas.show', $rombel->id) }}" class="btn btn-secondary flex-grow-1" style="background-color: #E2E8F0; color: #475569; border: none;">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Students Table -->
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Daftar Siswa ({{ $siswa->count() }})</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>NIS</th>
                            <th>Rombel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $i => $s)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $s->nama_lengkap }}</td>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->rombel->nama ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('kaprog.siswa.show', $s->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    <i class="fas fa-user-slash me-2"></i>Tidak ada siswa di kelas ini.
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