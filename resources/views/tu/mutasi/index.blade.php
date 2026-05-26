@extends('layouts.app')

@section('title', 'Mutasi Siswa')

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
    }

    body {
        background-color: var(--gray-50);
        color: var(--gray-800);
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    /* Header Styles */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        gap: 20px;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: clamp(24px, 4vw, 32px);
        font-weight: 700;
        margin: 0;
        color: var(--gray-800);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: var(--primary);
        font-size: 28px;
    }

    /* Card Styles */
    .jurusan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .jurusan-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid var(--gray-200);
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .jurusan-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
        border-color: var(--primary);
    }

    .jurusan-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary), var(--primary-dark));
    }

    .jurusan-card-header {
        padding: 24px;
        background: linear-gradient(135deg, var(--gray-50), var(--gray-100));
        border-bottom: 1px solid var(--gray-200);
    }

    .jurusan-card-title-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .jurusan-card-title {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        color: var(--gray-800);
        line-height: 1.3;
    }

    .jurusan-card-code {
        display: inline-flex;
        align-items: center;
        background: var(--gray-100);
        color: var(--gray-600);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .jurusan-card-badge {
        background: var(--primary);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .jurusan-card-badge i {
        font-size: 14px;
    }

    .jurusan-card-body {
        padding: 24px;
        flex: 1;
    }

    .jurusan-card-description {
        color: var(--gray-600);
        margin: 0;
        line-height: 1.6;
        font-size: 14px;
    }

    .jurusan-card-footer {
        padding: 20px 24px;
        border-top: 1px solid var(--gray-200);
        display: flex;
        gap: 12px;
    }

    /* Button Styles */
    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.3s ease;
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

    .btn-outline-primary {
        background: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
    }

    .btn-outline-primary:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    .btn-outline-secondary {
        background: transparent;
        color: var(--gray-600);
        border: 2px solid var(--gray-300);
    }

    .btn-outline-secondary:hover {
        background: var(--gray-100);
        border-color: var(--gray-400);
        transform: translateY(-2px);
    }

    .btn-sm {
        padding: 8px 16px;
        font-size: 13px;
    }

    /* Dropdown Styles */
    .dropdown-toggle {
        background: var(--gray-100);
        color: var(--gray-700);
        border: 1px solid var(--gray-300);
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .dropdown-toggle:hover {
        background: var(--gray-200);
        border-color: var(--gray-400);
    }

    .dropdown-menu {
        border: 1px solid var(--gray-300);
        box-shadow: var(--shadow-lg);
        border-radius: 12px;
        padding: 8px;
    }

    .dropdown-item {
        padding: 10px 16px;
        border-radius: 8px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--gray-700);
    }

    .dropdown-item:hover {
        background: var(--gray-100);
        color: var(--primary);
    }

    .dropdown-item i {
        font-size: 16px;
        width: 20px;
        text-align: center;
    }

    /* Empty State */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow);
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        color: var(--gray-300);
    }

    .empty-state h3 {
        font-size: 20px;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 8px;
    }

    .empty-state p {
        color: var(--gray-500);
        margin: 0;
    }

    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: var(--shadow-xl);
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        padding: 24px;
        position: relative;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .modal-header .btn-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    .modal-title {
        font-weight: 700;
        font-size: 20px;
    }

    .modal-body {
        padding: 24px;
    }

    /* Siswa List Styles */
    .siswa-checkbox-group {
        display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 400px;
            overflow-y: auto;
            padding: 10px 0;
        }

        .siswa-item {
            display: flex;
            align-items: center;
            padding: 16px;
            background: var(--gray-50);
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            transition: all 0.2s ease;
        }

        .siswa-item:hover {
            background: var(--gray-100);
            border-color: var(--gray-300);
            transform: translateX(4px);
        }

        .siswa-item input[type="checkbox"] {
            margin-right: 16px;
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .siswa-info {
            flex: 1;
        }

        .siswa-nama {
            font-weight: 600;
            color: var(--gray-800);
            font-size: 15px;
            margin-bottom: 4px;
        }

        .siswa-nis {
            font-size: 13px;
            color: var(--gray-500);
        }

        /* Mutasi Options */
        .mutasi-options {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--gray-200);
        }

        .mutasi-options label {
            display: block;
            margin-bottom: 16px;
            font-weight: 600;
            color: var(--gray-700);
            font-size: 15px;
        }

        .mutasi-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
        }

        .btn-mutasi {
            padding: 14px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
        }

        .btn-mutasi:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-mutasi-naik {
            background: var(--success);
            color: white;
        }

        .btn-mutasi-naik:hover {
            background: var(--success-dark);
        }

        .btn-mutasi-lulus {
            background: var(--primary);
            color: white;
        }

        .btn-mutasi-lulus:hover {
            background: var(--primary-dark);
        }

        .btn-mutasi-do {
            background: var(--warning);
            color: white;
        }

        .btn-mutasi-do:hover {
            background: var(--warning-dark);
        }

        .btn-mutasi-pindah {
            background: #8b5cf6;
            color: white;
        }

        .btn-mutasi-pindah:hover {
            background: #7c3aed;
        }

        .btn-mutasi-meninggal {
            background: var(--danger);
            color: white;
            grid-column: 1 / -1;
        }

        .btn-mutasi-meninggal:hover {
            background: var(--danger-dark);
        }

        /* Class Students Modal */
        .class-student-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 16px;
            background: var(--gray-50);
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            margin-bottom: 12px;
            transition: all 0.2s ease;
        }

        .class-student-item:hover {
            background: var(--gray-100);
            border-color: var(--gray-300);
            transform: translateX(4px);
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

        /* Responsive Design */
        @media (max-width: 767px) {
            .container-fluid {
                padding-left: 12px;
                padding-right: 12px;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
                gap: 16px;
            }

            .jurusan-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .jurusan-card {
                margin-bottom: 16px;
            }

            .jurusan-card-header {
                padding: 16px;
            }

            .jurusan-card-title {
                font-size: 18px;
            }

            .jurusan-card-body {
                padding: 16px;
            }

            .jurusan-card-footer {
                padding: 16px;
                flex-direction: column;
                gap: 8px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .mutasi-buttons {
                grid-template-columns: 1fr;
            }

            .btn-mutasi-meninggal {
                grid-column: 1;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .jurusan-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        /* Print Styles */
        @media print {
            body {
                background-color: white;
            }

            .page-header,
            .jurusan-card-footer,
            .modal {
                display: none !important;
            }

            .jurusan-card {
                box-shadow: none;
                border: 1px solid var(--gray-300);
                break-inside: avoid;
            }

            @page {
                margin: 2cm;
            }
        }

        /* Custom Scrollbar */
        .siswa-checkbox-group::-webkit-scrollbar {
            width: 8px;
        }

        .siswa-checkbox-group::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 4px;
        }

        .siswa-checkbox-group::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 4px;
        }

        .siswa-checkbox-group::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
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

    <div class="container-fluid mt-4">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-exchange-alt"></i> Mutasi Siswa
            </h1>
            <a href="{{ route('tu.mutasi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Mutasi Individual
            </a>
        </div>

        @php
            $jurusanGroups = $classes->sortBy(function($kelas) { return optional($kelas->jurusan)->nama ?? ''; })
                ->groupBy(function($kelas) { return $kelas->jurusan_id ?? 'umum'; });
        @endphp

        <div class="jurusan-grid">
            @forelse($jurusanGroups as $jurusanId => $jurusanClasses)
                @php
                    $jurusan = $jurusanClasses->first()->jurusan;
                    $totalRombel = $jurusanClasses->sum(fn($kelas) => $kelas->rombels->count());
                    $totalSiswa = $jurusanClasses->flatMap(fn($kelas) => $kelas->rombels)->sum(fn($rombel) => $rombel->siswas->count());
                @endphp
                <div class="jurusan-card fade-in">
                    <div class="jurusan-card-header">
                        <div class="jurusan-card-title-wrapper">
                            <div>
                                <h3 class="jurusan-card-title">{{ optional($jurusan)->nama ?? 'Umum' }}</h3>
                                <span class="jurusan-card-code">Kode: {{ optional($jurusan)->kode ?? '-' }}</span>
                            </div>
                            <span class="jurusan-card-badge">
                                <i class="fas fa-users"></i> {{ $totalSiswa }} siswa
                            </span>
                        </div>
                    </div>
                    <div class="jurusan-card-body">
                        <p class="jurusan-card-description">
                            Terdiri dari {{ $jurusanClasses->count() }} kelas dengan {{ $totalRombel }} rombel aktif.
                            Kelas ini berfokus pada {{ optional($jurusan)->deskripsi ?? 'berbagai bidang studi' }}.
                        </p>
                    </div>
                    <div class="jurusan-card-footer">
                        <a href="{{ optional($jurusan)->id ? route('tu.mutasi.kelas', $jurusan->id) : route('tu.mutasi.index') }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-info-circle"></i> Detail
                        </a>
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i> Lebih
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ optional($jurusan)->id ? route('tu.mutasi.kelas', $jurusan->id) : route('tu.mutasi.index') }}">
                                    <i class="fas fa-search"></i> Lihat Kelas
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('tu.siswa.create', ['jurusan_id' => optional($jurusan)->id]) }}">
                                    <i class="fas fa-user-plus"></i> Tambah Siswa
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Tidak ada jurusan tersedia</h3>
                    <p>Silakan tambahkan jurusan terlebih dahulu untuk melanjutkan.</p>
                    <a href="{{ route('tu.jurusan.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus"></i> Tambah Jurusan
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal untuk Pilih Siswa -->
    <div class="modal fade" id="siswaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Siswa untuk Mutasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAllSiswa">
                            <label class="form-check-label" for="selectAllSiswa">
                                <strong>Pilih Semua Siswa</strong>
                            </label>
                        </div>
                    </div>

                    <div class="siswa-checkbox-group" id="siswaList"></div>

                    <div class="mutasi-options" id="mutasiOptions">
                        <label>Pilih Jenis Mutasi:</label>
                        <div class="mutasi-buttons">
                            <button type="button" class="btn-mutasi btn-mutasi-naik" id="btnNaikKelas" style="display: none;">
                                <i class="fas fa-arrow-up"></i> Naik Kelas
                            </button>
                            <button type="button" class="btn-mutasi btn-mutasi-lulus" id="btnLulus" style="display: none;">
                                <i class="fas fa-graduation-cap"></i> Lulus
                            </button>
                            <button type="button" class="btn-mutasi btn-mutasi-do" id="btnDO" style="display: none;">
                                <i class="fas fa-ban"></i> Putus Sekolah
                            </button>
                            <button type="button" class="btn-mutasi btn-mutasi-pindah" id="btnPindah" style="display: none;">
                                <i class="fas fa-map-marker"></i> Pindah Sekolah
                            </button>
                            <button type="button" class="btn-mutasi btn-mutasi-meninggal" id="btnMeninggal" style="display: none;">
                                <i class="fas fa-cross"></i> Meninggal Dunia
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Daftar Siswa Kelas -->
    <div class="modal fade" id="classStudentsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="classStudentsModalLabel">Daftar Siswa Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3"><strong>Jumlah siswa:</strong> <span id="classStudentsCount">0 siswa</span></p>
                    <div class="siswa-checkbox-group" id="classStudentsList"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentKelasId = null;
        let currentMutasiType = null;

        function openSiswaModal(button, mutasiType) {
            const kelasCard = button.closest('.jurusan-card');
            currentKelasId = kelasCard.dataset.kelasId;
            currentMutasiType = mutasiType;

            const kelasName = kelasCard.dataset.kelasName;

            // Get siswa list from pre-built data
            const siswas = @json($allStudents);
            const kelasStudents = siswas.filter(s => parseInt(s.kelas_id) === parseInt(currentKelasId));

            // Build siswa list HTML
            let siswaHTML = '';
            kelasStudents.forEach(siswa => {
                siswaHTML += `
                    <div class="siswa-item fade-in">
                        <input type="checkbox" class="form-check-input siswa-checkbox" value="${siswa.id}">
                        <div class="siswa-info">
                            <div class="siswa-nama">${siswa.nama_lengkap}</div>
                            <div class="siswa-nis">NIS: ${siswa.nis} | Rombel: ${siswa.rombel_name}</div>
                        </div>
                    </div>
                `;
            });

            document.getElementById('siswaList').innerHTML = siswaHTML;
            document.getElementById('selectAllSiswa').checked = false;
            document.getElementById('selectAllSiswa').indeterminate = false;

            // Show/hide buttons based on mutasi type
            document.getElementById('btnNaikKelas').style.display = mutasiType === 'naik_kelas' ? 'block' : 'none';
            document.getElementById('btnLulus').style.display = mutasiType === 'lulus' ? 'block' : 'none';
            document.getElementById('btnDO').style.display = mutasiType === 'lainnya' ? 'block' : 'none';
            document.getElementById('btnPindah').style.display = mutasiType === 'lainnya' ? 'block' : 'none';
            document.getElementById('btnMeninggal').style.display = mutasiType === 'lainnya' ? 'block' : 'none';

            // Update modal title
            const modalTitle = document.querySelector('#siswaModal .modal-title');
            modalTitle.textContent = `Pilih Siswa - ${kelasName} (${mutasiType.replace(/_/g, ' ').toUpperCase()})`;

            const modal = new bootstrap.Modal(document.getElementById('siswaModal'));
            modal.show();

            // Setup event listeners
            setupCheckboxListeners();
        }

        function openClassStudents(button) {
            const kelasCard = button.closest('.jurusan-card');
            const kelasId = kelasCard.dataset.kelasId;
            const kelasName = kelasCard.dataset.kelasName;
            const siswas = @json($allStudents);
            const kelasStudents = siswas.filter(s => parseInt(s.kelas_id) === parseInt(kelasId));

            let studentHtml = '';
            if (kelasStudents.length === 0) {
                studentHtml = '<p class="text-muted">Belum ada siswa di kelas ini.</p>';
            } else {
                kelasStudents.forEach(siswa => {
                    studentHtml += `
                        <div class="class-student-item fade-in">
                            <div class="siswa-nama">${siswa.nama_lengkap}</div>
                            <div class="siswa-nis">NIS: ${siswa.nis}</div>
                            <div class="text-muted">Rombel: ${siswa.rombel_name}</div>
                        </div>
                    `;
                });
            }

            document.getElementById('classStudentsModalLabel').textContent = `Siswa Kelas ${kelasName}`;
            document.getElementById('classStudentsCount').textContent = `${kelasStudents.length} siswa`;
            document.getElementById('classStudentsList').innerHTML = studentHtml;

            const modal = new bootstrap.Modal(document.getElementById('classStudentsModal'));
            modal.show();
        }

        function setupCheckboxListeners() {
            const selectAllCheckbox = document.getElementById('selectAllSiswa');
            const siswaCheckboxes = document.querySelectorAll('.siswa-checkbox');

            selectAllCheckbox.addEventListener('change', function() {
                siswaCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            siswaCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(siswaCheckboxes).every(cb => cb.checked);
                    const someChecked = Array.from(siswaCheckboxes).some(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = someChecked && !allChecked;
                });
            });
        }

        // Button listeners for mutasi actions
        document.getElementById('btnNaikKelas').addEventListener('click', () => executeMutasi('naik_kelas'));
        document.getElementById('btnLulus').addEventListener('click', () => executeMutasi('lulus'));
        document.getElementById('btnDO').addEventListener('click', () => executeMutasi('do'));
        document.getElementById('btnPindah').addEventListener('click', () => executeMutasi('pindah'));
        document.getElementById('btnMeninggal').addEventListener('click', () => executeMutasi('meninggal'));

        function executeMutasi(status) {
            const siswaCheckboxes = document.querySelectorAll('.siswa-checkbox:checked');
            const siswaIds = Array.from(siswaCheckboxes).map(cb => cb.value);

            if (siswaIds.length === 0) {
                showToast('Pilih minimal 1 siswa', 'warning');
                return;
            }

            if (status === 'pindah') {
                // For pindah, ask for additional info
                showPindahForm(siswaIds);
            } else {
                // For other mutations
                submitBulkMutasi(siswaIds, status);
            }
        }

        function showPindahForm(siswaIds) {
            const alasan = prompt('Masukkan alasan pindah sekolah:');
            if (!alasan) return;
            
            const tujuan = prompt('Masukkan nama sekolah tujuan:');
            if (!tujuan) return;

            submitBulkMutasi(siswaIds, 'pindah', { alasan_pindah: alasan, tujuan_pindah: tujuan });
        }

        function submitBulkMutasi(siswaIds, status, additionalData = {}) {
            const payload = {
                siswa_ids: siswaIds,
                status: status,
                kelas_id: currentKelasId,
                ...additionalData
            };

            // Show loading state
            const submitButton = event.target;
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            submitButton.disabled = true;

            fetch('{{ route("tu.mutasi.bulk") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast('Error: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan', 'danger');
            })
            .finally(() => {
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : type === 'danger' ? 'times-circle' : 'info-circle'} me-2"></i>
                    ${message}
                </div>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Initialize tooltips
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
        });
    </script>
</div>
@endsection