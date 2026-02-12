@extends('layouts.app')

@section('title', 'Alumni - ' . $namaJurusan)

@section('content')
<style>
    /* ===================== STYLE ALUMNI BY JURUSAN ===================== */
    
    :root {
        --primary-color: #2F53FF;
        --secondary-color: #6366F1;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --danger-color: #EF4444;
        --info-color: #3B82F6;
        --light-bg: #F8FAFC;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Header Styles */
    .page-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .menu-toggle {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .menu-toggle:hover {
        background: var(--light-bg);
        border-color: var(--primary-color);
    }

    .menu-toggle i {
        color: #64748B;
        font-size: 18px;
    }

    h3 {
        font-size: 24px;
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 0;
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

    /* Button Styles */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 10px 20px;
    }

    .btn-secondary {
        background-color: #64748B;
        border: none;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #475569;
        transform: translateY(-2px);
        color: white;
    }

    .btn-outline-primary {
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
        background: white;
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: white;
    }

    /* Table Styles */
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }

    .table {
        border-radius: 8px;
        margin-bottom: 0;
    }

    .table thead th {
        background-color: #F8FAFC;
        color: #475569;
        font-weight: 600;
        font-size: 14px;
        padding: 15px;
        border: none;
        text-align: center;
        vertical-align: middle;
    }

    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        border-color: #E2E8F0;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        position: relative;
    }

    .table tbody tr::before {
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

    .table tbody tr:hover {
        background-color: rgba(47, 83, 255, 0.02);
    }

    .table tbody tr:hover::before {
        transform: scaleY(1);
    }

    /* Align specific columns */
    .table tbody td:nth-child(1),
    .table tbody td:nth-child(3),
    .table tbody td:nth-child(4),
    .table tbody td:nth-child(5),
    .table tbody td:nth-child(6),
    .table tbody td:nth-child(7) {
        text-align: center;
    }

    .table tbody td:nth-child(2) {
        text-align: left;
    }

    /* Avatar Styles */
    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .student-avatar-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Badge Styles */
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Alert Styles */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 20px;
    }

    .alert-info {
        background-color: #EFF6FF;
        color: #1E40AF;
    }

    /* Card List View for Mobile */
    .card-list-view {
        display: none;
    }

    .alumni-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary-color);
    }

    .alumni-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateX(4px);
    }

    .alumni-card-header {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
        align-items: center;
    }

    .alumni-card-avatar {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        flex-shrink: 0;
    }

    .alumni-avatar-placeholder {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        font-weight: 700;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        flex-shrink: 0;
    }

    .alumni-card-title {
        flex: 1;
    }

    .alumni-card-title h6 {
        font-size: 16px;
        font-weight: 600;
        color: #1E293B;
        margin-bottom: 4px;
    }

    .alumni-card-title small {
        color: #64748B;
        font-size: 13px;
    }

    .alumni-card-body {
        display: grid;
        gap: 8px;
        margin-bottom: 12px;
    }

    .alumni-info-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        border-bottom: 1px solid #F1F5F9;
    }

    .alumni-info-row:last-child {
        border-bottom: none;
    }

    .alumni-info-label {
        color: #64748B;
        font-size: 12px;
        font-weight: 600;
    }

    .alumni-info-value {
        color: #1E293B;
        font-size: 14px;
        font-weight: 500;
        text-align: right;
    }

    .alumni-card-actions {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #F1F5F9;
    }

    /* ===================== RESPONSIVE STYLES ===================== */

    /* Tablet (768px - 991px) */
    @media (max-width: 991px) {
        h3 {
            font-size: 20px;
        }

        .table thead th {
            font-size: 12px;
            padding: 12px 8px;
        }

        .table tbody td {
            font-size: 13px;
            padding: 12px 8px;
        }

        .student-avatar,
        .student-avatar-placeholder {
            width: 36px;
            height: 36px;
            font-size: 14px;
        }
    }

    /* Mobile (max 767px) */
    @media (max-width: 767px) {
        .container {
            padding-left: 12px;
            padding-right: 12px;
        }

        /* Header Section */
        .page-header {
            gap: 10px;
            margin-bottom: 15px;
        }

        .menu-toggle {
            width: 36px;
            height: 36px;
        }

        .menu-toggle i {
            font-size: 16px;
        }

        h3 {
            font-size: 18px;
        }

        .mb-4 {
            margin-bottom: 1rem !important;
        }

        /* Back button */
        .btn-secondary {
            font-size: 14px;
            padding: 8px 16px;
        }

        /* Title section */
        small.text-muted {
            font-size: 12px;
        }

        /* Hide Table, Show Card List */
        .table-responsive {
            display: none !important;
        }

        .card-list-view {
            display: block;
            padding: 12px;
        }

        .badge {
            font-size: 11px;
            padding: 4px 10px;
        }

        .alumni-card-actions .btn {
            width: 100%;
            font-size: 13px;
        }

        /* Alert */
        .alert {
            padding: 16px;
            font-size: 14px;
        }

        .alert i {
            font-size: 16px;
        }
    }

    /* Mobile Small (max 575px) */
    @media (max-width: 575px) {
        h3 {
            font-size: 16px;
        }

        .alumni-card-avatar,
        .alumni-avatar-placeholder {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .alumni-card-title h6 {
            font-size: 15px;
        }

        .alumni-info-label {
            font-size: 11px;
        }

        .alumni-info-value {
            font-size: 13px;
        }

        .alumni-card-actions .btn {
            font-size: 12px;
            padding: 8px 12px;
        }
    }

    /* Desktop (min 768px) - Show table */
    @media (min-width: 768px) {
        .card-list-view {
            display: none !important;
        }

        .table-responsive {
            display: block !important;
        }

        .menu-toggle {
            display: none;
        }
    }

    /* Desktop Large (1200px+) */
    @media (min-width: 1200px) {
        h3 {
            font-size: 26px;
        }

        .table thead th {
            font-size: 15px;
            padding: 18px;
        }

        .table tbody td {
            font-size: 15px;
            padding: 18px;
        }

        .student-avatar,
        .student-avatar-placeholder {
            width: 45px;
            height: 45px;
            font-size: 18px;
        }
    }
</style>

<div class="container py-4">
    <!-- Back Button & Filter -->
    <div class="mb-4">
        <div class="row align-items-end gap-2">
            <div class="col-auto">
                <a href="{{ route('kurikulum.alumni.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="col-auto">
                <form method="GET" action="{{ route('kurikulum.alumni.by-jurusan', ['jurusanId' => $jurusanId]) }}" class="d-flex gap-2">
                    <select name="tahun" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit();">
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        <option value="Semua Tahun" {{ $tahun === 'Semua Tahun' ? 'selected' : '' }}>Semua Tahun Ajaran</option>
                        @forelse($tahunAjaranList as $t)
                            <option value="{{ $t }}" {{ $tahun === $t ? 'selected' : '' }}>
                                Tahun Ajaran {{ $t }}
                            </option>
                        @empty
                        @endforelse
                    </select>
                </form>
            </div>
        </div>
    </div>

    <!-- Title Section -->
    <div class="mb-4">
        <h3>Alumni {{ $namaJurusan }}</h3>
        <small class="text-muted">Tahun Ajaran: {{ $tahun }}</small>
    </div>

    <!-- Data Card -->
    <div class="card shadow-sm">
        @if(count($alumni) > 0)
            <!-- Desktop/Tablet View: Table -->
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 30%">Nama Siswa</th>
                            <th style="width: 12%">NIS</th>
                            <th style="width: 12%">NISN</th>
                            <th style="width: 15%">Kelas</th>
                            <th style="width: 15%">Rombel</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumni as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($data['siswa']->foto)
                                            <img src="{{ asset('storage/' . $data['siswa']->foto) }}" class="student-avatar" alt="{{ $data['siswa']->nama_lengkap }}">
                                        @else
                                            <div class="student-avatar-placeholder">
                                                {{ strtoupper(substr($data['siswa']->nama_lengkap, 0, 1)) }}
                                            </div>
                                        @endif
                                        <strong>{{ $data['siswa']->nama_lengkap }}</strong>
                                    </div>
                                </td>
                                <td>{{ $data['siswa']->nis }}</td>
                                <td>{{ $data['siswa']->nisn }}</td>
                                <td><span class="badge bg-secondary">{{ $data['kelas'] }}</span></td>
                                <td>{{ $data['rombel'] }}</td>
                                <td>
                                    <a href="{{ route('kurikulum.alumni.show', $data['siswa']->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile View: Card List -->
            <div class="card-list-view">
                @foreach($alumni as $index => $data)
                    <div class="alumni-card">
                        <div class="alumni-card-header">
                            @if($data['siswa']->foto)
                                <img src="{{ asset('storage/' . $data['siswa']->foto) }}" class="alumni-card-avatar" alt="{{ $data['siswa']->nama_lengkap }}">
                            @else
                                <div class="alumni-avatar-placeholder">
                                    {{ strtoupper(substr($data['siswa']->nama_lengkap, 0, 1)) }}
                                </div>
                            @endif
                            <div class="alumni-card-title">
                                <h6>{{ $data['siswa']->nama_lengkap }}</h6>
                                <small>{{ $data['siswa']->nis }} • {{ $data['siswa']->nisn }}</small>
                            </div>
                        </div>
                        
                        <div class="alumni-card-body">
                            <div class="alumni-info-row">
                                <span class="alumni-info-label">Kelas</span>
                                <span class="alumni-info-value">
                                    <span class="badge bg-secondary">{{ $data['kelas'] }}</span>
                                </span>
                            </div>
                            
                            <div class="alumni-info-row">
                                <span class="alumni-info-label">Rombel</span>
                                <span class="alumni-info-value">{{ $data['rombel'] }}</span>
                            </div>
                        </div>
                        
                        <div class="alumni-card-actions">
                            <a href="{{ route('kurikulum.alumni.show', $data['siswa']->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info m-0">
                <i class="bi bi-info-circle me-2"></i> Tidak ada alumni untuk jurusan ini pada tahun ajaran {{ $tahun }}.
            </div>
        @endif
    </div>
</div>
@endsection