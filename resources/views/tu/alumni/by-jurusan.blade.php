@extends('layouts.app')

@section('title', 'Alumni - ' . ($namaJurusan ?? 'Jurusan'))

@section('content')
<style>
    :root {
        --primary: #4F46E5;
        --primary-dark: #4338CA;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --border-radius: 12px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--gray-50);
        color: var(--gray-800);
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    /* Header Section */
    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 32px 0;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.3; }
    }

    .page-header h1 {
        font-size: clamp(24px, 4vw, 36px);
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .page-header .subtitle {
        font-size: clamp(14px, 2.5vw, 18px);
        opacity: 0.9;
        margin-top: 8px;
        position: relative;
        z-index: 1;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        transform: translateY(-2px);
    }

    /* Filter Section */
    .filter-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
    }

    .filter-section:hover {
        box-shadow: var(--shadow-lg);
    }

    .filter-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-title i {
        color: var(--primary);
    }

    .filter-form {
        display: flex;
        gap: 12px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .form-group {
        flex: 1;
        min-width: 200px;
    }

    .form-label {
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-select {
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 14px;
        transition: var(--transition);
        background: white;
        width: 100%;
    }

    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 20px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .btn-secondary {
        background: var(--gray-200);
        color: var(--gray-700);
    }

    .btn-secondary:hover {
        background: var(--gray-300);
        transform: translateY(-2px);
    }

    .btn-sm {
        padding: 6px 14px;
        font-size: 13px;
    }

    /* Alumni Cards Container */
    .alumni-container {
        display: grid;
        gap: 24px;
    }

    .rombel-section {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--gray-200);
        position: relative;
    }

    .rombel-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary), var(--primary-dark));
    }

    .rombel-header {
        background: linear-gradient(135deg, var(--gray-50), var(--gray-100));
        padding: 16px 24px;
        border-bottom: 1px solid var(--gray-200);
        cursor: pointer;
        transition: var(--transition);
    }

    .rombel-header:hover {
        background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
    }

    .rombel-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .rombel-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .rombel-title h5 {
        font-size: 18px;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0;
    }

    .rombel-badge {
        background: var(--primary);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Table */
    .table-responsive {
        border-radius: 0 0 var(--border-radius) var(--border-radius);
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: var(--gray-50);
        color: var(--gray-700);
        font-weight: 600;
        font-size: 13px;
        padding: 12px 16px;
        border: none;
        border-bottom: 2px solid var(--gray-200);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        border-color: var(--gray-200);
        font-size: 14px;
    }

    .table tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.04);
    }

    /* Student Info */
    .student-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }

    .student-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .student-name {
        font-weight: 600;
        color: var(--gray-800);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .empty-state-icon {
        font-size: 48px;
        color: var(--gray-300);
        margin-bottom: 20px;
    }

    .empty-state-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 8px;
    }

    .empty-state-description {
        font-size: 14px;
        color: var(--gray-500);
        margin-bottom: 24px;
    }

    .empty-state-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Responsive */
    @media (max-width: 767px) {
        .page-header { padding: 24px 0; }
        .filter-section { padding: 16px; }
        .filter-form { flex-direction: column; gap: 12px; }
        .form-group { width: 100%; }
        .rombel-header { padding: 12px 16px; }
        .rombel-title h5 { font-size: 15px; }
        .table thead th { font-size: 11px; padding: 8px 10px; }
        .table tbody td { font-size: 12px; padding: 8px 10px; }
        .student-avatar { width: 32px; height: 32px; font-size: 12px; }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
            <div>
                <h1 class="mb-2">📋 Alumni {{ $namaJurusan ?? 'Jurusan' }}</h1>
                <p class="subtitle mb-0">Tahun Ajaran: {{ $tahun ?? 'Semua Tahun' }}</p>
            </div>
            <a href="{{ route('tu.alumni.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="container">

    <!-- Filter Section -->
    <div class="filter-section fade-in">
        <h3 class="filter-title">
            <i class="fas fa-filter"></i>
            Filter Tahun Ajaran
        </h3>
        <form method="GET" action="{{ route('tu.alumni.by-jurusan', ['jurusanId' => $jurusanId ?? 0]) }}" class="filter-form">
            <div class="form-group">
                <label for="tahun" class="form-label">Pilih Tahun Ajaran</label>
                <select name="tahun" class="form-select" id="tahun">
                    <option value="Semua Tahun" {{ ($tahun ?? 'Semua Tahun') === 'Semua Tahun' ? 'selected' : '' }}>Semua Tahun Ajaran</option>
                    @forelse($tahunAjaranList ?? [] as $t)
                        <option value="{{ $t }}" {{ ($tahun ?? '') === $t ? 'selected' : '' }}>
                            Tahun Ajaran {{ $t }}
                        </option>
                    @empty
                        <option value="">Belum ada data</option>
                    @endforelse
                </select>
            </div>
            <div class="form-group" style="flex:0 0 auto;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
            @if(($tahun ?? '') && ($tahun ?? '') !== 'Semua Tahun')
                <div class="form-group" style="flex:0 0 auto;">
                    <a href="{{ route('tu.alumni.by-jurusan', ['jurusanId' => $jurusanId ?? 0]) }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Alumni Container -->
    @php
        // Pastikan groupedAlumni selalu array
        if (!isset($groupedAlumni) || is_null($groupedAlumni)) {
            $groupedAlumni = [];
        }
    @endphp

    @if(!empty($groupedAlumni) && count($groupedAlumni) > 0)
        <div class="alumni-container">
            @foreach($groupedAlumni as $compositeKey => $groupData)
                <div class="rombel-section fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="rombel-header" onclick="toggleCollapse(this)">
                        <div class="rombel-header-content">
                            <div class="rombel-title">
                                <i class="fas fa-chevron-down collapse-icon" style="transition: transform 0.3s ease;"></i>
                                <h5>{{ $groupData['display_name'] ?? 'Kelas - Rombel' }}</h5>
                            </div>
                            <span class="rombel-badge">
                                <i class="fas fa-users"></i>
                                {{ count($groupData['students'] ?? []) }} Siswa
                            </span>
                        </div>
                    </div>

                    <div class="rombel-body" style="display: block;">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:50px;">#</th>
                                        <th>Nama Siswa</th>
                                        <th style="width:15%;">NIS</th>
                                        <th style="width:15%;">NISN</th>
                                        <th style="width:15%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($groupData['students'] ?? [] as $index => $siswa)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="student-info">
                                                    @if($siswa->foto)
                                                        <div class="student-avatar">
                                                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                                                        </div>
                                                    @else
                                                        <div class="student-avatar">
                                                            {{ strtoupper(substr($siswa->nama_lengkap ?? 'U', 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <span class="student-name">{{ $siswa->nama_lengkap ?? 'Tidak Diketahui' }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $siswa->nis ?? '-' }}</td>
                                            <td>{{ $siswa->nisn ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('tu.alumni.show', $siswa->id ?? 0) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state fade-in">
            <div class="empty-state-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h3 class="empty-state-title">Tidak Ada Data Alumni</h3>
            <p class="empty-state-description">
                Tidak ada alumni untuk jurusan {{ $namaJurusan ?? 'ini' }} pada tahun ajaran {{ $tahun ?? 'yang dipilih' }}.
            </p>
            <div class="empty-state-actions">
                <a href="{{ route('tu.alumni.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
                @if(($tahun ?? '') && ($tahun ?? '') !== 'Semua Tahun')
                    <a href="{{ route('tu.alumni.by-jurusan', ['jurusanId' => $jurusanId ?? 0]) }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Tampilkan Semua Tahun
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
function toggleCollapse(element) {
    const body = element.nextElementSibling;
    const icon = element.querySelector('.collapse-icon');
    
    if (body.style.display === 'none') {
        body.style.display = 'block';
        icon.style.transform = 'rotate(0deg)';
    } else {
        body.style.display = 'none';
        icon.style.transform = 'rotate(-90deg)';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Auto submit filter on change
    const select = document.getElementById('tahun');
    if (select) {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    }
});
</script>

@endsection