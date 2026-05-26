@extends('layouts.app')

@section('title', 'Detail Rombel: ' . $rombel->nama)

@section('content')
<style>
    :root {
        --primary: #3B82F6;
        --primary-dark: #2563EB;
        --secondary: #8B5CF6;
        --success: #10B981;
        --info: #06B6D4;
        --warning: #F59E0B;
        --danger: #EF4444;
        --dark: #1E293B;
        --gray: #64748B;
        --light: #F8FAFC;
        --white: #FFFFFF;
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --transition: all 0.3s ease;
    }

    body {
        background-color: var(--light);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Header Section */
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: var(--shadow-lg);
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
        transform: rotate(45deg);
    }

    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .page-header .subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: white;
        color: var(--primary);
        box-shadow: var(--shadow);
    }

    .btn-primary:hover {
        background: var(--white);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-secondary {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
    }

    .btn-secondary:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-2px);
    }

    /* Info Cards */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary), var(--secondary));
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .info-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .info-card:nth-child(1) .info-icon {
        background: rgba(59, 130, 246, 0.1);
        color: var(--primary);
    }

    .info-card:nth-child(2) .info-icon {
        background: rgba(139, 92, 246, 0.1);
        color: var(--secondary);
    }

    .info-card:nth-child(3) .info-icon {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .info-label {
        font-size: 0.875rem;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .info-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark);
    }

    /* Student Table */
    .table-container {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .table-header {
        padding: 1.5rem;
        border-bottom: 1px solid #E2E8F0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .table-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .table-title h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .student-count {
        background: var(--primary);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .search-box {
        position: relative;
        width: 100%;
        max-width: 300px;
    }

    .search-box input {
        width: 100%;
        padding: 0.5rem 2.5rem 0.5rem 1rem;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: var(--transition);
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .search-box i {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #F8FAFC;
    }

    th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--gray);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #E2E8F0;
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid #F1F5F9;
    }

    tbody tr {
        transition: var(--transition);
    }

    tbody tr:hover {
        background: #F8FAFC;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            margin-right: 0.75rem;
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .student-info {
            display: flex;
            align-items: center;
        }

        .student-name {
            font-weight: 600;
            color: var(--dark);
        }

        .badge {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .badge-laki {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
        }

        .badge-perempuan {
            background: rgba(236, 72, 153, 0.1);
            color: #EC4899;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray);
        }

        .empty-state i {
            font-size: 3rem;
            color: #CBD5E1;
            margin-bottom: 1rem;
        }

        .empty-state h4 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        /* Loading State */
        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .loading.active {
            display: block;
        }

        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .table-header {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                max-width: 100%;
            }

            th, td {
                padding: 0.75rem 0.5rem;
                font-size: 0.875rem;
            }

            .student-avatar {
                width: 32px;
                height: 32px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .page-header h1 {
                font-size: 1.5rem;
            }

            .page-header .subtitle {
                font-size: 1rem;
            }

            .info-card {
                padding: 1rem;
            }

            .info-value {
                font-size: 1.125rem;
            }

            th, td {
                padding: 0.5rem;
            }

            .table-header {
                padding: 1rem;
            }
        }
</style>

<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Detail Rombel</h1>
        <p class="subtitle">{{ $rombel->nama }}</p>
        <div class="action-buttons">
            <a href="{{ route('tu.kelas.export', $rombel->id) }}" class="btn btn-primary">
                <i class="fas fa-file-excel"></i>
                Export Excel
            </a>
            <a href="{{ request()->header('referer') ?: route('tu.kelas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="info-grid">
        <div class="info-card">
            <div class="info-icon">
                <i class="fas fa-layer-group"></i>
            </div>
            <p class="info-label">Tingkat Kelas</p>
            <p class="info-value">{{ $rombel->kelas->tingkat ?? '-' }}</p>
        </div>
        <div class="info-card">
            <div class="info-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <p class="info-label">Jurusan</p>
            <p class="info-value">{{ $rombel->kelas->jurusan->nama ?? '-' }}</p>
        </div>
        <div class="info-card">
            <div class="info-icon">
                <i class="fas fa-user-tie"></i>
            </div>
            <p class="info-label">Wali Kelas</p>
            <p class="info-value">{{ $rombel->guru->nama ?? '-' }}</p>
        </div>
    </div>

    <!-- Student Table -->
    <div class="table-container">
        <div class="table-header">
            <div class="table-title">
                <h3>Daftar Siswa</h3>
                <span class="student-count">{{ $rombel->siswa->count() }} Siswa</span>
            </div>
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari siswa...">
                <i class="fas fa-search"></i>
            </div>
        </div>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
                    @forelse($rombel->siswa as $siswa)
                        <tr data-name="{{ strtolower($siswa->nama_lengkap) }}" data-nis="{{ strtolower($siswa->nis) }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">
                                        @if($siswa->foto)
                                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                                        @else
                                            <div style="background: linear-gradient(135deg, var(--primary), var(--secondary));">
                                                {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <span class="student-name">{{ $siswa->nama_lengkap }}</span>
                                </div>
                            </td>
                            <td>{{ $siswa->nis }}</td>
                            <td>
                                <span class="badge badge-{{ $siswa->jenis_kelamin == 'L' ? 'laki' : 'perempuan' }}">
                                    <i class="fas fa-{{ $siswa->jenis_kelamin == 'L' ? 'mars' : 'venus' }}"></i>
                                    {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">
                                <i class="fas fa-user-graduate"></i>
                                <h4>Belum ada siswa</h4>
                                <p>Belum ada data siswa untuk rombel ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="loading" id="loadingState">
            <div class="spinner"></div>
        </div>
    </div>
</div>

<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#studentTableBody tr');
        
        rows.forEach(row => {
            const name = row.dataset.name;
            const nis = row.dataset.nis;
            
            if (name.includes(searchTerm) || nis.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Add click animation to buttons
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
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
</script>

<style>
    /* Ripple effect for buttons */
    .btn {
        position: relative;
        overflow: hidden;
    }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Loading spinner animation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection