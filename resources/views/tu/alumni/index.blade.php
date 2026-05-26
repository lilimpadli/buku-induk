@extends('layouts.app')

@section('title', 'Data Alumni')

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
        padding: 48px 0;
        margin-bottom: 48px;
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
        font-size: clamp(28px, 5vw, 48px);
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .page-header .subtitle {
        font-size: clamp(16px, 3vw, 20px);
        opacity: 0.9;
        margin-top: 8px;
        position: relative;
        z-index: 1;
    }

    /* Search Section */
    .search-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 32px;
        margin-bottom: 40px;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
    }

    .search-section:hover {
        box-shadow: var(--shadow-lg);
    }

    .search-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .search-title i {
        color: var(--primary);
    }

    .search-form {
        display: flex;
        gap: 16px;
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
        padding: 12px 16px;
        font-size: 15px;
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
        padding: 12px 24px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 15px;
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

    /* Alumni Cards Grid */
    .alumni-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .alumni-card {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        position: relative;
        border: 1px solid var(--gray-200);
        display: flex;
            flex-direction: column;
        }

        .alumni-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary);
        }

        .alumni-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary), var(--primary-dark));
        }

        .alumni-card-header {
            padding: 24px;
            background: linear-gradient(135deg, var(--gray-50), var(--gray-100));
            border-bottom: 1px solid var(--gray-200);
        }

        .alumni-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .alumni-badge i {
            font-size: 14px;
        }

        .alumni-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .alumni-subtitle {
            font-size: 14px;
            color: var(--gray-500);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .alumni-subtitle i {
            color: var(--gray-400);
        }

        .alumni-card-body {
            padding: 24px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .alumni-stats {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
            display: flex;
            align-items: baseline;
            justify-content: center;
            gap: 4px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--gray-500);
            margin-top: 4px;
        }

        .alumni-description {
            text-align: center;
            color: var(--gray-600);
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .alumni-card-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--gray-200);
            background: var(--gray-50);
        }

        .btn-alumni {
            width: 100%;
            padding: 12px 20px;
            font-size: 15px;
            border-radius: 10px;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-alumni-primary {
            background: var(--primary);
            color: white;
        }

        .btn-alumni-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-alumni-secondary {
            background: var(--gray-200);
            color: var(--gray-700);
            cursor: not-allowed;
        }

        /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .empty-state-icon {
        font-size: 64px;
        color: var(--gray-300);
        margin-bottom: 24px;
    }

    .empty-state-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 12px;
    }

    .empty-state-description {
        font-size: 16px;
        color: var(--gray-500);
        margin-bottom: 32px;
    }

    .empty-state-actions {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Responsive Design */
        @media (max-width: 767px) {
            .page-header {
                padding: 32px 0;
                margin-bottom: 32px;
            }

            .page-header h1 {
                font-size: 28px;
            }

            .search-section {
                padding: 20px;
                margin-bottom: 24px;
            }

            .search-form {
                flex-direction: column;
                gap: 12px;
            }

            .form-group {
                width: 100%;
            }

            .alumni-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .alumni-card {
                margin-bottom: 16px;
            }

            .stat-number {
                font-size: 28px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .alumni-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
            }
        }

        /* Loading Animation */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .loading {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        /* Print Styles */
        @media print {
            body {
                background-color: white;
            }

            .page-header,
            .search-section {
                display: none !important;
            }

            .alumni-card {
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
            <h1 class="mb-2">Data Alumni</h1>
            <p class="subtitle mb-0">Melacak prestasi dan perkembangan alumni SMKN 1 Kawali</p>
        </div>
    </div>

    <div class="container">
        <!-- Search Section -->
        <div class="search-section fade-in">
            <h3 class="search-title">
                <i class="bi bi-funnel"></i>
                Filter Pencarian
            </h3>
            <form method="GET" action="{{ route('tu.alumni.index') }}" class="search-form">
                <div class="form-group">
                    <label for="tahunAjaranSelect" class="form-label">Tahun Ajaran</label>
                    <select name="tahun_ajaran" class="form-select" id="tahunAjaranSelect">
                        <option value="">-- Semua Tahun Ajaran --</option>
                        @foreach($tahunAjaranList as $tahun)
                            <option value="{{ $tahun }}" {{ $tahunSearch == $tahun ? 'selected' : '' }}>
                                Tahun Ajaran {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                        Cari
                    </button>
                </div>
                @if($tahunSearch)
                    <div class="form-group">
                        <label class="form-label">&nbsp;</label>
                        <a href="{{ route('tu.alumni.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                            Reset
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Alumni Cards Grid -->
        @if(empty($allJurusanCards))
            <div class="empty-state fade-in">
                <div class="empty-state-icon">
                    <i class="bi bi-inbox"></i>
                </div>
                <h3 class="empty-state-title">Belum Ada Data Alumni</h3>
                <p class="empty-state-description">
                    Saat ini belum ada data alumni yang terdaftar. 
                    Data alumni akan muncul setelah siswa lulus dan terdaftar sebagai alumni.
                </p>
                <div class="empty-state-actions">
                    <a href="{{ route('tu.siswa.index') }}" class="btn btn-primary">
                        <i class="bi bi-people"></i>
                        Kelola Siswa
                    </a>
                    <a href="{{ route('tu.alumni.create') }}" class="btn btn-secondary">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Alumni Manual
                    </a>
                </div>
            </div>
        @else
            <div class="alumni-grid">
                @foreach($allJurusanCards as $cardKey => $card)
                    <div class="alumni-card fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <div class="alumni-card-header">
                            <div class="alumni-badge">
                                <i class="bi bi-mortarboard"></i>
                                {{ $card['tahun'] }}
                            </div>
                            <h3 class="alumni-title">{{ $card['jurusan'] }}</h3>
                            <div class="alumni-subtitle">
                                <i class="bi bi-building"></i>
                                SMKN 1 Kawali
                            </div>
                        </div>
                        <div class="alumni-card-body">
                            <div class="alumni-stats">
                                <div class="stat-item">
                                    <div class="stat-number">{{ $card['count'] }}</div>
                                    <div class="stat-label">Alumni</div>
                                </div>
                            </div>
                            <p class="alumni-description">
                                {{ $card['jurusan'] }} tahun ajaran {{ $card['tahun'] }} 
                                telah melahirkan {{ $card['count'] }} lulusan siap bersaing di dunia kerja.
                            </p>
                        </div>
                        <div class="alumni-card-footer">
                            @if($card['count'] > 0)
                                <a href="{{ route('tu.alumni.by-jurusan', ['jurusanId' => $card['jurusan_id']]) }}?tahun={{ urlencode($card['tahun']) }}" 
                                   class="btn-alumni btn-alumni-primary">
                                    <i class="bi bi-eye"></i>
                                    Lihat Detail Alumni
                                </a>
                            @else
                                <button class="btn-alumni btn-alumni-secondary" disabled>
                                    <i class="bi bi-lock"></i>
                                    Tidak Ada Data
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            // Animate numbers on scroll
            const animateValue = (element, start, end, duration) => {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    element.textContent = Math.floor(progress * (end - start) + start);
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            };

            // Observe elements for animation
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const statNumber = entry.target.querySelector('.stat-number');
                        if (statNumber && !statNumber.classList.contains('animated')) {
                            const finalValue = parseInt(statNumber.textContent);
                            animateValue(statNumber, 0, finalValue, 1000);
                            statNumber.classList.add('animated');
                        }
                    }
                });
            }, observerOptions);

            // Observe all alumni cards
            document.querySelectorAll('.alumni-card').forEach(card => {
                observer.observe(card);
            });
        });
    </script>
    @endpush
</div>
@endsection