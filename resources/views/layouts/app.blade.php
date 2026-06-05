 <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Aplikasi Buku Induk</title>
    <link rel="icon" href="{{ asset('images/bg.png') }}?v={{ filemtime(public_path('images/bg.png')) }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/bg.png') }}?v={{ filemtime(public_path('images/bg.png')) }}">
    <meta name="theme-color" content="#2F53FF">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    @stack('styles')

    <style>
        /* Layout */
        :root{
            --sidebar-bg: #ffffff;
            --accent: #2F53FF;
            --muted: #6b7280;
        }

        html,
        body {
            overflow-x: hidden;
        }

        body {
            background: #f6f7fb;
            transition: var(--transition, 0.2s) ease;
            font-family: 'Poppins', sans-serif;
        }

        /* Mobile Header */
        .mobile-header {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 12px 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            z-index: 1030;
            align-items: center;
            justify-content: space-between;
        }

        .mobile-header .hamburger {
            background: none;
            border: none;
            font-size: 24px;
            color: #1f2937;
            cursor: pointer;
            padding: 8px;
        }

        .mobile-header .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mobile-header .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Sidebar Desktop */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: var(--sidebar-bg);
            padding: 0;
            border-right: 1px solid rgba(47,83,255,0.06);
            width: 280px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            border-bottom: 1px solid #f0f0f0;
            background: white;
        }

        .sidebar-close {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--accent);
            cursor: pointer;
            padding: 4px 8px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .brand .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-text .title {
            font-weight: 700;
            font-size: 16px;
            color: var(--accent);
            line-height: 1.2;
        }

        .brand-text small {
            font-size: 12px;
            color: var(--muted);
        }

        .sidebar-content {
            padding: 14px 14px;
        }

        .user-mini {
            display: none;
        }

        .nav-section-title {
            padding: 8px 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--muted);
            letter-spacing: 0.05em;
            margin-top: 16px;
            margin-bottom: 4px;
        }

        .sidebar .nav-link {
            color: #374151;
            padding: 10px 14px;
            border-radius: 12px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 15px;
            transition: transform .25s ease, box-shadow .25s ease, background .25s ease, color .25s ease;
            background: transparent;
        }

        .sidebar .nav-link i {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar .nav-link:hover {
            transform: translateX(6px);
            background: linear-gradient(90deg, rgba(47,83,255,0.06), rgba(124,58,237,0.04));
            color: var(--accent);
            text-decoration: none;
            box-shadow: 0 8px 22px rgba(15,23,42,0.06);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #2F53FF 0%, #7C3AED 100%);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 12px 30px rgba(47,83,255,0.16);
            border-left: none;
            border-radius: 12px;
        }

        /* Dropdown in sidebar */
        .sidebar .dropdown-menu {
            background: #f9fafb;
            border: none;
            box-shadow: none;
            padding: 4px 0;
            margin-left: 28px;
            border-radius: 8px;
        }

        .sidebar .dropdown-item {
            padding: 10px 16px;
            font-size: 14px;
            color: #4b5563;
            border-radius: 6px;
            margin: 2px 8px;
        }

        .sidebar .dropdown-item:hover {
            background: rgba(47,83,255,0.08);
            color: var(--accent);
        }

        .sidebar .dropdown-item.active {
            background: rgba(47,83,255,0.15);
            color: var(--accent);
            font-weight: 600;
        }

        .sidebar .dropdown-item i {
            width: 18px;
            margin-right: 8px;
        }

        .logout-section {
            padding: 16px;
            border-top: 1px solid #f0f0f0;
            margin-top: auto;
        }

        /* Main Content */
        main {
            background: #f8f9fa;
            padding: 40px 50px;
            margin-left: 280px;
            max-width: calc(100% - 280px);
            min-height: 100vh;
            box-sizing: border-box;
            overflow-x: hidden;
            transition: margin-left .3s ease;
        }

        .container-fluid {
            overflow-x: hidden;
        }

        .container-fluid > .row {
            margin-left: 0;
            margin-right: 0;
        }

        /* Mobile Styles */
        @media (max-width: 991px) {
            .mobile-header {
                display: flex;
            }

            .sidebar {
                transform: translateX(-100%);
                width: 80%;
                max-width: 320px;
                z-index: 1040;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-close {
                display: block;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1035;
            }

            .sidebar-overlay.show {
                display: block;
            }

            main {
                margin-left: 0;
                padding-top: 80px;
                padding-left: 16px;
                padding-right: 16px;
            }

            /* Keep collapsed styling behavior for small screens when sidebar-collapsed is set */
            body.sidebar-collapsed .sidebar{
                left: -100%;
            }
        }

        /* Desktop - hide mobile elements */
        @media (min-width: 992px) {
            .mobile-header {
                display: none !important;
            }
            
            .sidebar-close {
                display: none !important;
            }

            .sidebar-overlay {
                display: none !important;
            }
        }

        /* Pagination fixes */
        .pagination .page-link svg,
        .pagination .page-link i,
        .pagination svg,
        .pagination i,
        .page-link .bi,
        .pagination .page-item .page-link > * {
            display: inline-block !important;
            width: auto !important;
            height: auto !important;
            max-width: 1.2em !important;
            max-height: 1.2em !important;
            font-size: 1rem !important;
            line-height: 1 !important;
            vertical-align: -0.125em !important;
        }

        .pagination .page-link,
        .pagination .page-item a,
        .pagination .page-item button {
            padding: .375rem .6rem !important;
            min-width: 2.2rem !important;
        }

        /* Icon size controls */
        main svg,
        main i.fas,
        main i.far,
        main i.fad,
        main i.fal,
        main i.fab,
        main .bi {
            max-width: 1.5rem !important;
            max-height: 1.5rem !important;
            width: auto !important;
            height: auto !important;
            font-size: 1rem !important;
        }

        main .empty-state i,
        .empty-state i {
            font-size: 2rem !important;
            max-width: 2rem !important;
            max-height: 2rem !important;
            display: inline-block !important;
        }
    </style>
</head>

<body>

    <!-- Mobile Header -->
    <div class="mobile-header">
        <button class="hamburger" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="user-info">
            @auth
                <span class="d-none d-sm-inline">{{ Auth::user()->nama_lengkap ?? Auth::user()->name ?? '' }}</span>
                @if(isset(Auth::user()->photo) && Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}?v={{ time() }}" alt="Profile">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_lengkap ?? Auth::user()->name ?? '') }}&size=80" alt="Profile">
                @endif
            @endauth
        </div>
    </div>

    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="container-fluid">
        <div class="row">

            <!-- =============== SIDEBAR =============== -->
            @unless(View::hasSection('noSidebar'))
            <nav class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <div class="brand">
                        <div class="logo">
                            <img src="{{ asset('images/biskaone.jpeg') }}?v={{ filemtime(public_path('images/biskaone.jpeg')) }}" alt="BISKAONE" onerror="this.style.display='none'">
                        </div>
                        <div class="brand-text">
                            <div class="title">Buku Induk</div>
                            <small>Sekolah</small>
                        </div>
                    </div>
                    <button class="sidebar-close" id="sidebarClose">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>

                <div class="sidebar-content">
                    @auth
                        <!-- MENU -->
                        <nav class="nav flex-column">

                            {{-- ROLE: SISWA --}}
                            @if(Auth::user()->normalized_role == 'siswa')
                                <a href="{{ route('siswa.dashboard') }}" class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> <span>Dashboard</span>
                                </a>

                                <div class="nav-section-title">DATA</div>


                                <a href="{{ route('siswa.bukuInduk.show') }}" class="nav-link {{ request()->routeIs('siswa.bukuInduk*') ? 'active' : '' }}">
                                    <i class="fas fa-book"></i> <span>Buku Induk</span>
                                </a>
                            @endif

                            {{-- ROLE: GURU --}}
                            @if(Auth::user()->normalized_role == 'guru')
                                <a href="{{ route('guru.dashboard') }}" class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> <span>Dashboard</span>
                                </a>

                                <div class="nav-section-title">DATA</div>

                                <a href="{{ route('guru.profile.index') }}" class="nav-link {{ request()->routeIs('guru.profile.*') ? 'active' : '' }}">
                                    <i class="fas fa-user"></i> <span>Data Pribadi </span>
                                </a>
                            @endif

                            {{-- ROLE: WALI KELAS --}}
                            @if(Auth::user()->normalized_role == 'walikelas')
                                <a href="{{ route('walikelas.dashboard') }}" class="nav-link {{ request()->routeIs('walikelas.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> <span>Dashboard</span>
                                </a>

                                <div class="nav-section-title">DATA</div>

                                <a href="{{ route('walikelas.data_diri.profile') }}" class="nav-link {{ request()->routeIs('walikelas.data_diri.profile') ? 'active' : '' }}">
                                    <i class="fas fa-user"></i> <span>Data Pribadi</span>
                                </a>

                                <a href="{{ route('walikelas.siswa.index') }}" class="nav-link {{ request()->routeIs('walikelas.siswa.*') ? 'active' : '' }}">
                                    <i class="fas fa-users"></i> <span>Data Siswa</span>
                                </a>

                                {{-- TAMBAHKAN INI: MENU ABSENSI --}}
                                <div class="nav-section-title">ABSENSI</div>

                                <a href="{{ route('walikelas.absensi.index') }}" class="nav-link {{ request()->routeIs('walikelas.absensi.index') ? 'active' : '' }}">
                                    <i class="fas fa-calendar-check"></i> <span>Input Absensi</span>
                                </a>

                                <a href="{{ route('walikelas.absensi.rekap') }}" class="nav-link {{ request()->routeIs('walikelas.absensi.rekap') ? 'active' : '' }}">
                                    <i class="fas fa-chart-simple"></i> <span>Rekap Absensi</span>
                                </a>
                                {{-- SAMPAI SINI --}}

                                <div class="nav-section-title">NILAI</div>

                                <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="nav-link {{ request()->routeIs('walikelas.input_nilai_raport.index') ? 'active' : '' }}">
                                    <i class="fas fa-clipboard"></i> <span>Input Nilai Raport</span>
                                </a>

                                <a href="{{ route('walikelas.nilai_raport.index') }}" class="nav-link {{ request()->routeIs('walikelas.nilai_raport.index') ? 'active' : '' }}">
                                    <i class="fas fa-file-alt"></i> <span>Lihat Nilai Raport</span>
                                </a>
                            @endif

                            {{-- ROLE: KAPROG --}}
                            @if(Auth::user()->normalized_role == 'kaprog')
                                <a href="{{ route('kaprog.dashboard') }}" class="nav-link {{ request()->routeIs('kaprog.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> <span>Dashboard</span>
                                </a>

                                <div class="nav-section-title">DATA</div>

                                <a href="{{ route('kaprog.datapribadi.index') }}" class="nav-link {{ request()->routeIs('kaprog.datapribadi*') ? 'active' : '' }}">
                                    <i class="fas fa-user"></i> <span>Data Diri</span>
                                </a>

                                <a href="{{ route('kaprog.siswa.index') }}" class="nav-link {{ request()->routeIs('kaprog.siswa.*') ? 'active' : '' }}">
                                    <i class="fas fa-users"></i> <span>Data Siswa</span>
                                </a>

                                <a href="{{ route('kaprog.kelas.index') }}" class="nav-link {{ request()->routeIs('kaprog.kelas.*') ? 'active' : '' }}">
                                    <i class="fas fa-chalkboard"></i> <span>Data Kelas</span>
                                </a>

                                <a href="{{ route('kaprog.guru.index') }}" class="nav-link {{ request()->routeIs('kaprog.guru.*') ? 'active' : '' }}">
                                    <i class="fas fa-user-tie"></i> <span>Guru</span>
                                </a>
                            @endif

                            {{-- ROLE: TU --}}
                            @if(Auth::user()->normalized_role == 'tu')
                                <a href="{{ route('tu.dashboard') }}" class="nav-link {{ request()->routeIs('tu.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> <span>Dashboard</span>
                                </a>

                                <div class="nav-section-title">DATA</div>

                                <a href="{{ route('tu.data-pribadi.index') }}" class="nav-link {{ request()->routeIs('tu.data-pribadi*') ? 'active' : '' }}">
                                    <i class="fas fa-id-card"></i> <span>Data Pribadi</span>
                                </a>

                                <a href="{{ route('tu.siswa.index') }}" class="nav-link {{ request()->routeIs('tu.siswa*') ? 'active' : '' }}">
                                    <i class="fas fa-users"></i> <span>Data Siswa</span>
                                </a>

                               
                                <a href="{{ route('tu.kelas.index') }}" class="nav-link {{ request()->routeIs('tu.kelas*') ? 'active' : '' }}">
                                    <i class="fas fa-school"></i> <span>Manajemen Kelas</span>
                                </a>

                               

                                <div class="nav-section-title">BUKU INDUK</div>

                                <a href="{{ route('tu.buku-induk.index') }}" class="nav-link {{ request()->routeIs('tu.buku-induk*') ? 'active' : '' }}">
                                    <i class="fas fa-book"></i> <span>Buku Induk</span>
                                </a>

                                <a href="{{ route('tu.mutasi.index') }}" class="nav-link {{ request()->routeIs('tu.mutasi*') ? 'active' : '' }}">
                                    <i class="fas fa-exchange-alt"></i> <span>Mutasi Siswa</span>
                                </a>

                                <div class="nav-section-title">MANAJEMEN LULUSAN</div>

                                <a href="{{ route('tu.alumni.index') }}" class="nav-link {{ request()->routeIs('tu.alumni*') ? 'active' : '' }}">
                                    <i class="fas fa-user-graduate"></i> <span>Data Alumni</span>
                                </a>
                            @endif

                            {{-- ROLE: TU KEPEGAWAIAN --}}
                            @if(Auth::user()->normalized_role == 'tu_kepegawaian')
                                <a href="{{ route('tu_kepegawaian.dashboard') }}" class="nav-link {{ request()->routeIs('tu_kepegawaian.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> <span>Dashboard</span>
                                </a>

                                <div class="nav-section-title">KEPEGAWAIAN</div>

                                <a href="{{ route('tu_kepegawaian.guru.index') }}" class="nav-link {{ request()->routeIs('tu_kepegawaian.guru*') ? 'active' : '' }}">
                                    <i class="fas fa-chalkboard-teacher"></i> <span>Data Guru</span>
                                </a>

                                <a href="{{ route('tu_kepegawaian.tu.index') }}" class="nav-link {{ request()->routeIs('tu_kepegawaian.tu*') ? 'active' : '' }}">
                                    <i class="fas fa-user-tie"></i> <span>Data TU</span>
                                </a>

                                <a href="{{ route('tu_kepegawaian.tugas_tambahan.index') }}" class="nav-link {{ request()->routeIs('tu_kepegawaian.tugas_tambahan*') ? 'active' : '' }}">
                                    <i class="fas fa-tasks"></i> <span>Tugas Tambahan</span>
                                </a>
                            @endif

                            {{-- ROLE: SUPER ADMIN --}}
                            @if(Auth::user()->normalized_role == 'super_admin')
                                <a href="{{ route('super_admin.dashboard') }}" class="nav-link {{ request()->routeIs('super_admin.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> <span>Dashboard</span>
                                </a>

                                <div class="nav-section-title">KELOLA</div>

                                <a href="{{ route('super_admin.users.index') }}" class="nav-link {{ request()->routeIs('super_admin.users*') ? 'active' : '' }}">
                                    <i class="fas fa-users"></i> <span>Users</span>
                                </a>

                                <div class="nav-section-title">SISTEM</div>

                                <a href="{{ route('super_admin.system.index') }}" class="nav-link {{ request()->routeIs('super_admin.system*') ? 'active' : '' }}">
                                    <i class="fas fa-cogs"></i> <span>System</span>
                                </a>

                                <div class="nav-section-title">MANAJEMEN</div>

                                <a href="{{ route('super_admin.manajemen-guru.index') }}" class="nav-link {{ request()->routeIs('super_admin.manajemen-guru*') ? 'active' : '' }}">
                                    <i class="fas fa-chalkboard-teacher"></i> <span>Manajemen Guru</span>
                                </a>

                                <a href="{{ route('super_admin.manajemen-jurusan.index') }}" class="nav-link {{ request()->routeIs('super_admin.manajemen-jurusan*') ? 'active' : '' }}">
                                    <i class="fas fa-graduation-cap"></i> <span>Manajemen Jurusan</span>
                                </a>

                                <a href="{{ route('super_admin.manajemen-kelas.index') }}" class="nav-link {{ request()->routeIs('super_admin.manajemen-kelas*') ? 'active' : '' }}">
                                    <i class="fas fa-school"></i> <span>Manajemen Kelas</span>
                                </a>

                                <a href="{{ route('super_admin.manajemen-kurikulum.index') }}" class="nav-link {{ request()->routeIs('super_admin.manajemen-kurikulum*') ? 'active' : '' }}">
                                    <i class="fas fa-book"></i> <span>Manajemen Kurikulum</span>
                                </a>

                                <a href="{{ route('super_admin.manajemen-siswa.index') }}" class="nav-link {{ request()->routeIs('super_admin.manajemen-siswa*') ? 'active' : '' }}">
                                    <i class="fas fa-user-graduate"></i> <span>Manajemen Siswa</span>
                                </a>
                            @endif

                            {{-- ROLE: KURIKULUM --}}
                            @if(Auth::user()->normalized_role == 'kurikulum')
                                <a href="{{ route('kurikulum.dashboard') }}" class="nav-link {{ request()->routeIs('kurikulum.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> <span>Dashboard</span>
                                </a>

                                <div class="nav-section-title">DATA</div>

                                <a href="{{ route('kurikulum.data-pribadi.index') }}" class="nav-link {{ request()->routeIs('kurikulum.data-pribadi*') ? 'active' : '' }}">
                                    <i class="fas fa-id-card"></i> <span>Data Pribadi</span>
                                </a>

                                <a href="{{ route('kurikulum.kelas.index') }}" class="nav-link {{ request()->routeIs('kurikulum.kelas*') ? 'active' : '' }}">
                                    <i class="fas fa-school"></i> <span>Manajemen Kelas</span>
                                </a>

                                <a href="{{ route('kurikulum.kurikulum.index') }}" class="nav-link {{ request()->routeIs('kurikulum.kurikulum*') ? 'active' : '' }}">
                                    <i class="fas fa-graduation-cap"></i> <span>Manajemen Kurikulum</span>
                                </a>

                                <a href="{{ route('kurikulum.jurusan.index') }}" class="nav-link {{ request()->routeIs('kurikulum.jurusan*') ? 'active' : '' }}">
                                    <i class="fas fa-graduation-cap"></i> <span>Manajemen Jurusan</span>
                                </a>

                                <a href="{{ route('kurikulum.guru.index') }}" class="nav-link {{ request()->routeIs('kurikulum.guru*') ? 'active' : '' }}">
                                    <i class="fas fa-chalkboard-teacher"></i> <span>Manajemen Guru</span>
                                </a>

                                <a href="{{ route('kurikulum.mata-pelajaran.index') }}" class="nav-link {{ request()->routeIs('kurikulum.mata-pelajaran*') ? 'active' : '' }}">
                                    <i class="fas fa-book-open"></i> <span>Manajemen Mata Pelajaran</span>
                                </a>

                                {{-- KURIKULUM: CRUD BIDANG/PROGRAM/KONSENTRASI KEAHLIAN --}}
                                <div class="nav-section-title">KEAHLIAN</div>
                                <a href="{{ route('kurikulum.bidang-keahlian.index') }}" class="nav-link {{ request()->routeIs('kurikulum.bidang-keahlian*') ? 'active' : '' }}">
                                    <i class="fas fa-layer-group"></i> <span>Bidang Keahlian</span>
                                </a>
                               
                                <a href="{{ route('kurikulum.program-keahlian.index') }}" class="nav-link {{ request()->routeIs('kurikulum.program-keahlian*') ? 'active' : '' }}">
                                    <i class="fas fa-cube"></i> <span>Program Keahlian</span>
                                </a>

                                 <a href="{{ route('kurikulum.konsentrasi-keahlian.index') }}" class="nav-link {{ request()->routeIs('kurikulum.konsentrasi-keahlian*') ? 'active' : '' }}">
                                    <i class="fas fa-cubes"></i> <span>Konsentrasi Keahlian</span>
                                </a>
                            @endif

                        </nav>
                    @endauth
                </div>

                <div class="logout-section">
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </nav>
            @endunless

            <!-- MAIN CONTENT -->
            <main class="col">
                @include('partials._alerts')
                @yield('content')
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Toggle sidebar
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.add('show');
                    sidebarOverlay.classList.add('show');
                    document.body.style.overflow = 'hidden';
                });
            }

            // Close sidebar
            function closeSidebar() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.style.overflow = '';
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }

            // Initialize Bootstrap dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });

            // On resize, ensure overlay is closed when moving to desktop and re-apply collapsed state
            window.addEventListener('resize', function(){
                if (window.innerWidth > 991) {
                    // close overlay if open
                    if (document.body.classList.contains('show-sidebar')) {
                        document.body.classList.remove('show-sidebar');
                        if (sidebarBackdrop) sidebarBackdrop.classList.remove('visible');
                    }
                    // re-apply saved collapsed state
                    applySavedSidebarState();
                }
            });
        });
    </script>

    <!-- Backdrop for mobile sidebar -->
    <div id="sidebarBackdrop" class="sidebar-backdrop" aria-hidden="true"></div>

    @stack('scripts')

</body>

</html>