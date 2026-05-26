@extends('layouts.app')

@section('title', 'Alumni - ' . $namaJurusan)

@section('content')
<style>
    :root {
        --primary: #3b82f6;
        --primary-dark: #2563eb;
        --success: #10b981;
        --success-dark: #059669;
        --warning: #f59e0b;
        --warning-dark: #d97706;
        --danger: #ef4444;
        --danger-dark: #dc2626;
        --info: #3b82f6;
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
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
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

    /* Navigation Bar */
    .nav-bar {
        background: white;
        border-radius: var(--border-radius);
        padding: 16px 24px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-md);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .nav-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--gray-800);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nav-title i {
        color: var(--primary);
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

    .form-select,
    .form-control {
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 14px;
        transition: var(--transition);
        background: white;
    }

    .form-select:focus,
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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
        position: relative;
        overflow: hidden;
    }

    .btn::before {
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

    .btn:active::before {
        width: 300px;
        height: 300px;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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
        padding: 8px 16px;
        font-size: 13px;
    }

    /* Alumni Cards Container */
    .alumni-container {
        display: grid;
        gap: 24px;
    }

    /* Rombel Section */
    .rombel-section {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--gray-200);
    }

    .rombel-section:hover {
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
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
        padding: 20px 24px;
        border-bottom: 1px solid var(--gray-200);
        cursor: pointer;
        position: relative;
        transition: var(--transition);
    }

    .rombel-header:hover {
        background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
    }

    .rombell-header-content {
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
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .collapse-icon {
        transition: transform 0.3s ease;
        color: var(--primary);
    }

    .collapse-icon.rotate {
        transform: rotate(180deg);
    }

    /* Desktop Table */
    .desktop-view {
        display: block;
    }

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
        font-size: 14px;
        padding: 16px;
        border: none;
        border-bottom: 2px solid var(--gray-200);
    }

    .table tbody td {
        padding: 16px;
        vertical-align: middle;
        border-color: var(--gray-200);
        font-size: 14px;
    }

    .table tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.04);
    }

    /* Student Avatar */
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
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
        transition: var(--transition);
    }

    .student-avatar:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .student-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .student-name {
        font-weight: 600;
        color: var(--gray-800);
    }

    .student-meta {
        font-size: 13px;
        color: var(--gray-500);
    }

    /* Mobile View */
    .mobile-view {
        display: none;
    }

    .mobile-card {
        padding: 16px 20px;
        border-bottom: 1px solid var(--gray-200);
        transition: var(--transition);
    }

    .mobile-card:last-child {
        border-bottom: none;
    }

    .mobile-card:hover {
        background-color: var(--gray-50);
    }

    .mobile-card-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 12px;
    }

    .mobile-card-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        overflow: hidden;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
        flex-shrink: 0;
    }

    .mobile-card-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mobile-card-info {
        flex: 1;
        min-width: 0;
    }

    .mobile-card-name {
        font-weight: 700;
        color: var(--gray-800);
        font-size: 16px;
        margin-bottom: 4px;
    }

    .mobile-card-meta {
        font-size: 13px;
        color: var(--gray-500);
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .mobile-card-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .mobile-card-meta-label {
        font-weight: 600;
        color: var(--gray-600);
        font-size: 12px;
    }

    .mobile-card-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 12px;
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

    /* Responsive Design */
    @media (max-width: 767px) {
        .page-header {
            padding: 24px 0;
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 24px;
        }

        .nav-bar {
            padding: 12px 16px;
        }

        .filter-section {
            padding: 16px;
            margin-bottom: 20px;
        }

        .filter-form {
            flex-direction: column;
            gap: 12px;
        }

        .form-group {
            width: 100%;
        }

        .desktop-view {
            display: none;
        }

        .mobile-view {
            display: block;
        }

        .rombel-section {
            margin-bottom: 16px;
        }

        .mobile-card {
            padding: 14px 16px;
        }

        .mobile-card-avatar {
            width: 40px;
            height: 40px;
        }

        .mobile-card-name {
            font-size: 15px;
        }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .rombel-section {
            margin-bottom: 20px;
        }
    }

    /* Print Styles */
    @media print {
        body {
            background-color: white;
        }

        .page-header,
        .nav-bar,
        .filter-section {
            display: none !important;
        }

        .rombel-section {
            box-shadow: none;
            border: 1px solid var(--gray-300);
            break-inside: avoid;
        }

        @page {
            margin: 2cm;
        }
    }

    /* Animation Classes */
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="mb-2">Alumni {{ $namaJurusan }}</h1>
        <p class="subtitle mb-0">Tahun Ajaran: {{ $tahun }}</p>
    </div>
</div>

<div class="container">
    <!-- Navigation Bar -->
    <div class="nav-bar fade-in">
        <div class="nav-title">
            <i class="bi bi-arrow-left"></i>
            <span>Data Alumni</span>
        </div>
        <a href="{{ route('tu.alumni.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Filter Section -->
    <div class="filter-section fade-in">
        <h3 class="filter-title">
            <i class="bi bi-funnel"></i>
            Filter Tahun Ajaran
        </h3>
        <form method="GET" action="{{ route('tu.alumni.by-jurusan', ['jurusanId' => $jurusanId]) }}" class="filter-form">
            <div class="form-group">
                <label for="tahun" class="form-label">Pilih Tahun Ajaran</label>
                <select name="tahun" class="form-select" id="tahun" onchange="this.form.submit();">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    <option value="Semua Tahun" {{ $tahun === 'Semua Tahun' ? 'selected' : '' }}>Semua Tahun Ajaran</option>
                    @forelse($tahunAjaranList as $t)
                        <option value="{{ $t }}" {{ $tahun === $t ? 'selected' : '' }}>
                            Tahun Ajaran {{ $t }}
                        </option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
            @if($tahun && $tahun !== 'Semua Tahun')
                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <a href="{{ route('tu.alumni.by-jurusan', ['jurusanId' => $jurusanId]) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Alumni Container -->
    @if(count($groupedAlumni) > 0)
        <div class="alumni-container">
            <!-- Desktop View -->
            <div class="desktop-view">
                @foreach($groupedAlumni as $compositeKey => $groupData)
                    <div class="rombel-section fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <div class="rombel-header" data-bs-toggle="collapse" data-bs-target="#rombel-{{ $loop->index }}">
                            <div class="rombell-header-content">
                                <div class="rombel-title">
                                    <i class="bi bi-chevron-down collapse-icon"></i>
                                    <h5>{{ $groupData['display_name'] }}</h5>
                                </div>
                                <span class="rombel-badge">
                                    <i class="bi bi-people"></i>
                                    {{ count($groupData['students']) }} Siswa
                                </span>
                            </div>
                        </div>

                        <div id="rombel-{{ $loop->index }}" class="collapse show">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">#</th>
                                            <th style="width: 40%">Nama Siswa</th>
                                            <th style="width: 20%">NIS</th>
                                            <th style="width: 20%">NISN</th>
                                            <th style="width: 20%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($groupData['students'] as $index => $data)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="student-info">
                                                        @if($data['siswa']->foto)
                                                            <div class="student-avatar">
                                                                <img src="{{ asset('storage/' . $data['siswa']->foto) }}" alt="{{ $data['siswa']->nama_lengkap }}">
                                                            </div>
                                                        @else
                                                            <div class="student-avatar">
                                                                {{ strtoupper(substr($data['siswa']->nama_lengkap, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="student-name">{{ $data['siswa']->nama_lengkap }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="student-meta">{{ $data['siswa']->nis }}</div>
                                                </td>
                                                <td>
                                                    <div class="student-meta">{{ $data['siswa']->nisn }}</div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('tu.alumni.show', $data['siswa']->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> Detail
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

            <!-- Mobile View -->
            <div class="mobile-view">
                @foreach($groupedAlumni as $compositeKey => $groupData)
                    <div class="rombel-section fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <div class="rombel-header" data-bs-toggle="collapse" data-bs-target="#rombel-mobile-{{ $loop->index }}">
                            <div class="rombell-header-content">
                                <div class="rombel-title">
                                    <i class="bi bi-chevron-down collapse-icon"></i>
                                    <h5>{{ $groupData['display_name'] }}</h5>
                                </div>
                                <span class="rombel-badge">
                                    <i class="bi bi-people"></i>
                                    {{ count($groupData['students']) }}
                                </span>
                            </div>
                        </div>

                        <div id="rombel-mobile-{{ $loop->index }}" class="collapse show">
                            @foreach($groupData['students'] as $index => $data)
                                <div class="mobile-card">
                                    <div class="mobile-card-header">
                                        @if($data['siswa']->foto)
                                            <div class="mobile-card-avatar">
                                                <img src="{{ asset('storage/' . $data['siswa']->foto) }}" alt="{{ $data['siswa']->nama_lengkap }}">
                                            </div>
                                        @else
                                            <div class="mobile-card-avatar">
                                                {{ strtoupper(substr($data['siswa']->nama_lengkap, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="mobile-card-info">
                                            <div class="mobile-card-name">{{ $data['siswa']->nama_lengkap }}</div>
                                            <div class="mobile-card-meta">
                                                <div class="mobile-card-meta-item">
                                                    <span class="mobile-card-meta-label">NIS:</span>
                                                    <span>{{ $data['siswa']->nis }}</span>
                                                </div>
                                                <div class="mobile-card-meta-item">
                                                    <span class="mobile-card-meta-label">NISN:</span>
                                                    <span>{{ $data['siswa']->nisn }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mobile-card-actions">
                                        <a href="{{ route('tu.alumni.show', $data['siswa']->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="empty-state fade-in">
            <div class="empty-state-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h3 class="empty-state-title">Tidak Ada Data Alumni</h3>
            <p class="empty-state-description">
                Tidak ada alumni untuk jurusan {{ $namaJurusan }} pada tahun ajaran {{ $tahun }}.
            </p>
            <div class="empty-state-actions">
                <a href="{{ route('tu.alumni.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>
                @if($tahun !== 'Semua Tahun')
                    <a href="{{ route('tu.alumni.by-jurusan', ['jurusanId' => $jurusanId]) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Tampilkan Semua Tahun
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced collapse animation for chevron icon
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(header => {
            const icon = header.querySelector('.collapse-icon');
            const target = document.querySelector(header.dataset.bsTarget);
            
            if (target) {
                target.addEventListener('show.bs.collapse', () => {
                    icon.classList.add('rotate');
                });
                target.addEventListener('hide.bs.collapse', () => {
                    icon.classList.remove('rotate');
                });
            }
        });

        // Add ripple effect to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection