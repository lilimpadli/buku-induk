<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Aplikasi Buku Induk</title>
    <link rel="icon" href="{{ asset('images/bg.png') }}?v={{ filemtime(public_path('images/bg.png')) }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/bg.png') }}?v={{ filemtime(public_path('images/bg.png')) }}">
    <meta name="theme-color" content="#2F53FF">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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

        body {
            background: #f6f7fb;
            transition: var(--transition, 0.2s) ease;
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
            padding: 16px 12px;
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
            color: #4b5563;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 18px;
        }

        .sidebar .nav-link:hover {
            background: rgba(47,83,255,0.08);
            color: var(--accent);
            text-decoration: none;
        }

        .sidebar .nav-link.active {
            background: var(--accent);
            color: #fff;
            font-weight: 600;
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
            padding: 30px 28px;
            margin-left: 280px;
            min-height: 100vh;
            transition: margin-left .3s ease;
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
                            @if(Auth::user()->role == 'siswa')
                                <a href="{{ route('siswa.dashboard') }}" class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> <span>Dashboard</span>
                                </a>

                                <div class="nav-section-title">DATA</div>

                                <a href="{{ route('siswa.dataDiri') }}" class="nav-link {{ request()->routeIs('siswa.dataDiri*') ? 'active' : '' }}">
                                    <i class="fas fa-user"></i> <span>Data Pribadi Siswa</span>
                                </a>

                                <a href="{{ route('siswa.raport') }}" class="nav-link {{ request()->routeIs('siswa.raport') ? 'active' : '' }}">
                                    <i class="fas fa-clipboard"></i> <span>Raport</span>
                                </a>
                            @endif

                            {{-- ROLE: GURU --}}
                            @if(Auth::user()->role == 'guru')
                                <a href="{{ route('guru.dashboard') }}" class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> <span>Dashboard</span>
                                </a>

                                <div class="nav-section-title">DATA</div>

                                <a href="{{ route('guru.profile.index') }}" class="nav-link {{ request()->routeIs('guru.profile.*') ? 'active' : '' }}">
                                    <i class="fas fa-user"></i> <span>Data Pribadi Siswa</span>
                                </a>
                            @endif

                            {{-- ROLE: WALI KELAS --}}
                            @if(Auth::user()->role == 'walikelas')
                                <a href="{{ route('walikelas.dashboard') }}" class="nav-link {{ request()->routeIs('walikelas.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> <span>Dashboard</span>
                                </a>

                                <div class="nav-section-title">DATA</div>

                                <a href="{{ route('walikelas.data_diri.profile') }}" class="nav-link {{ request()->routeIs('walikelas.data_diri.profile') ? 'active' : '' }}">
                                    <i class="fas fa-user"></i> <span>Data Pribadi Siswa</span>
                                </a>

                                <a href="{{ route('walikelas.siswa.index') }}" class="nav-link {{ request()->routeIs('walikelas.siswa.*') ? 'active' : '' }}">
                                    <i class="fas fa-calendar-check"></i> <span>Data Siswa</span>
                                </a>

                                <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="nav-link {{ request()->routeIs('walikelas.input_nilai_raport.index') ? 'active' : '' }}">
                                    <i class="fas fa-clipboard"></i> <span>Input Nilai Raport</span>
                                </a>

                                <a href="{{ route('walikelas.nilai_raport.index') }}" class="nav-link {{ request()->routeIs('walikelas.nilai_raport.index') ? 'active' : '' }}">
                                    <i class="fas fa-file-alt"></i> <span>Lihat Nilai Raport</span>
                                </a>
                            @endif

                            {{-- ROLE: KAPROG --}}
                            @if(Auth::user()->role == 'kaprog')
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
                            @if(Auth::user()->role == 'tu')
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

                                <a href="{{ route('tu.ppdb.index') }}" class="nav-link {{ request()->routeIs('tu.ppdb*') ? 'active' : '' }}">
                                    <i class="fas fa-user-plus"></i> <span>PPDB</span>
                                </a>

                                <a href="{{ route('tu.kelas.index') }}" class="nav-link {{ request()->routeIs('tu.kelas*') ? 'active' : '' }}">
                                    <i class="fas fa-school"></i> <span>Manajemen Kelas</span>
                                </a>

                                <a href="{{ route('tu.guru.index') }}" class="nav-link {{ request()->routeIs('tu.guru*') ? 'active' : '' }}">
                                    <i class="fas fa-chalkboard-teacher"></i> <span>Data Guru</span>
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

                            {{-- ROLE: KURIKULUM --}}
                            @if(Auth::user()->role == 'kurikulum')
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

                                <a href="{{ route('kurikulum.siswa.index') }}" class="nav-link {{ request()->routeIs('kurikulum.siswa*') ? 'active' : '' }}">
                                    <i class="fas fa-users"></i> <span>Manajemen Siswa</span>
                                </a>

                                @php
                                    $ppdbActive = request()->is('kurikulum/ppdb*') || request()->routeIs('kurikulum.ppdb.*');
                                @endphp
                                <div class="dropdown">
                                    <a class="nav-link dropdown-toggle {{ $ppdbActive ? 'active' : '' }}" href="#" id="ppdbDropdownKurikulum" role="button" data-bs-toggle="dropdown" aria-expanded="{{ $ppdbActive ? 'true' : 'false' }}">
                                        <i class="fas fa-user-plus"></i> <span>PPDB</span>
                                    </a>
                                    <ul class="dropdown-menu {{ $ppdbActive ? 'show' : '' }}" aria-labelledby="ppdbDropdownKurikulum">
                                        <li><a class="dropdown-item {{ request()->routeIs('kurikulum.ppdb.index') ? 'active' : '' }}" href="{{ route('kurikulum.ppdb.index') }}"><i class="fas fa-list"></i> Data PPDB</a></li>
                                        <li><a class="dropdown-item {{ request()->routeIs('kurikulum.ppdb.timeline') ? 'active' : '' }}" href="{{ route('kurikulum.ppdb.timeline') }}"><i class="fas fa-clock"></i> Timeline PPDB</a></li>
                                    </ul>
                                </div>

                                <a href="{{ route('kurikulum.jurusan.index') }}" class="nav-link {{ request()->routeIs('kurikulum.jurusan*') ? 'active' : '' }}">
                                    <i class="fas fa-graduation-cap"></i> <span>Manajemen Jurusan</span>
                                </a>

                                <a href="{{ route('kurikulum.guru.index') }}" class="nav-link {{ request()->routeIs('kurikulum.guru*') ? 'active' : '' }}">
                                    <i class="fas fa-chalkboard-teacher"></i> <span>Manajemen Guru</span>
                                </a>

                                <a href="{{ route('kurikulum.mata-pelajaran.index') }}" class="nav-link {{ request()->routeIs('kurikulum.mata-pelajaran*') ? 'active' : '' }}">
                                    <i class="fas fa-book-open"></i> <span>Manajemen Mata Pelajaran</span>
                                </a>

                                <div class="nav-section-title">BUKU INDUK</div>

                                <a href="{{ route('kurikulum.buku-induk.index') }}" class="nav-link {{ request()->routeIs('kurikulum.buku-induk*') ? 'active' : '' }}">
                                    <i class="fas fa-book"></i> <span>Buku Induk</span>
                                </a>

                                <a href="{{ route('kurikulum.mutasi.index') }}" class="nav-link {{ request()->routeIs('kurikulum.mutasi*') ? 'active' : '' }}">
                                    <i class="fas fa-exchange-alt"></i> <span>Mutasi Siswa</span>
                                </a>

                                <div class="nav-section-title">MANAJEMEN LULUSAN</div>

                                <a href="{{ route('kurikulum.alumni.index') }}" class="nav-link {{ request()->routeIs('kurikulum.alumni*') ? 'active' : '' }}">
                                    <i class="fas fa-user-graduate"></i> <span>Data Alumni</span>
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
            <main>
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