<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Aplikasi Buku Induk</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        /* Layout */
        :root{
            --sidebar-bg: linear-gradient(180deg,#eef2ff,#f8fafc);
            --accent: #2F53FF;
            --muted: #6b7280;
        }

        body {
            background: #f6f7fb;
            transition: var(--transition, 0.2s) ease;
        }

        .sidebar {
            min-height: 100vh;
            background: var(--sidebar-bg);
            padding: 1.25rem 0.75rem;
            border-right: 1px solid rgba(47,83,255,0.06);
            width: 260px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 6px 10px 6px;
            margin-bottom: 6px;
        }

        .brand {
            display:flex; align-items:center; gap:10px;
        }

        .brand .logo {
            width:40px; height:40px; border-radius:8px;
            background: var(--accent); display:inline-flex; align-items:center; justify-content:center; color:#fff; font-weight:700;
        }

        .sidebar-search{ padding:0 6px 10px 6px; }

        .sidebar .nav-link{
            color: #0f172a; padding:10px 12px; border-radius:8px; margin-bottom:6px; display:flex; align-items:center; gap:10px;
        }

        .sidebar .nav-link:hover{ background: rgba(47,83,255,0.08); color: var(--accent); text-decoration:none; }

        .sidebar .nav-link.active{ background: var(--accent); color:#fff; font-weight:600; }

        .user-mini { text-align:center; padding:12px 6px; }

        /* collapsed body state */
        body.sidebar-collapsed .sidebar{ width:64px; }
        body.sidebar-collapsed .sidebar .nav-link span.label{ display:none; }
        body.sidebar-collapsed .sidebar .sidebar-header .brand span.title{ display:none; }

        main {
            background: #f8f9fa;
            padding: 30px 28px;
            min-height: 100vh;
            transition: margin-left .2s ease;
        }

        @media (max-width: 991px){
            .sidebar{ position:static; width:100%; }
            body.sidebar-collapsed .sidebar{ width:100%; }
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- =============== SIDEBAR =============== -->
            @unless(View::hasSection('noSidebar'))
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div>
                    <div class="sidebar-header">
                        <div class="brand">
                            <div class="logo">BI</div>
                            <div>
                                <div class="title" style="font-weight:700;">Buku Induk</div>
                                <small class="text-muted">Sekolah</small>
                            </div>
                        </div>
                        <button id="sidebarToggle" class="btn btn-sm btn-outline-secondary" title="Toggle sidebar"><i class="fas fa-angle-left"></i></button>
                    </div>

                    <div class="sidebar-search">
                        <input class="form-control form-control-sm" placeholder="Cari menu..." id="sidebarSearch">
                    </div>

                    @auth
                        <div class="user-mini">
                            @if(isset(Auth::user()->photo) && Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="rounded-circle mb-2" width="64" height="64" style="object-fit:cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_lengkap ?? Auth::user()->name ?? '') }}&size=64" class="rounded-circle mb-2" width="64" height="64">
                            @endif
                            <div style="font-weight:600;">{{ Auth::user()->nama_lengkap ?? Auth::user()->name ?? '-' }}</div>
                            <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                        </div>

                        <div class="px-2">
                            <!-- MENU -->
                            <nav class="nav flex-column">

                                {{-- ROLE: SISWA --}}
                                @if(Auth::user()->role == 'siswa')
                                    <a href="{{ route('siswa.dashboard') }}" class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Dashboard">
                                        <i class="fas fa-tachometer-alt"></i> <span class="label ms-2">Dashboard</span>
                                    </a>

                                    <a href="{{ route('siswa.dataDiri') }}" class="nav-link {{ request()->routeIs('siswa.dataDiri*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Data Diri">
                                        <i class="fas fa-user"></i> <span class="label ms-2">Data Diri</span>
                                    </a>

                                    <a href="{{ route('siswa.raport') }}" class="nav-link {{ request()->routeIs('siswa.raport') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Lihat Raport">
                                        <i class="fas fa-file-alt"></i> <span class="label ms-2">Lihat Raport</span>
                                    </a>
                                @endif

                                {{-- ROLE: WALI KELAS --}}
                                @if(Auth::user()->role == 'walikelas')
                                    <a href="{{ route('walikelas.dashboard') }}" class="nav-link {{ request()->routeIs('walikelas.dashboard') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Dashboard">
                                        <i class="fas fa-tachometer-alt"></i> <span class="label ms-2">Dashboard</span>
                                    </a>

                                    <a href="{{ route('walikelas.data_diri.profile') }}" class="nav-link {{ request()->routeIs('walikelas.data_diri.profile') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Data Diri">
                                        <i class="fas fa-user"></i> <span class="label ms-2">Data Diri</span>
                                    </a>

                                    <a href="{{ route('walikelas.siswa.index') }}" class="nav-link {{ request()->routeIs('walikelas.siswa.*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Data Siswa">
                                        <i class="fas fa-users"></i> <span class="label ms-2">Data Siswa</span>
                                    </a>

                                    <a href="{{ route('walikelas.input_nilai_raport.index') }}" class="nav-link {{ request()->routeIs('walikelas.input_nilai_raport.index') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Input Nilai Raport">
                                        <i class="fas fa-clipboard-check"></i> <span class="label ms-2">Input Nilai Raport</span>
                                    </a>

                                    <a href="{{ route('walikelas.nilai_raport.index') }}" class="nav-link {{ request()->routeIs('walikelas.nilai_raport.index') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Lihat Nilai Raport">
                                        <i class="fas fa-file-lines"></i> <span class="label ms-2">Lihat Nilai Raport</span>
                                    </a>
                                @endif

                                {{-- ROLE: KAPROG --}}
                                @if(Auth::user()->role == 'kaprog')
                                    <a href="{{ route('kaprog.dashboard') }}" class="nav-link {{ request()->routeIs('kaprog.dashboard') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Dashboard">
                                        <i class="fas fa-gauge"></i> <span class="label ms-2">Dashboard</span>
                                    </a>

                                    <a href="{{ route('kaprog.datapribadi.index') }}" class="nav-link {{ request()->routeIs('kaprog.raport.*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Data Diri">
                                        <i class="fas fa-id-card"></i> <span class="label ms-2">Data Diri</span>
                                    </a>

                                    <a href="{{ route('kaprog.kelas.index') }}" class="nav-link {{ request()->routeIs('kaprog.raport.*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Data Kelas">
                                        <i class="fas fa-chalkboard"></i> <span class="label ms-2">Data Kelas</span>
                                    </a>

                                    <a href="{{ route('kaprog.guru.index') }}" class="nav-link {{ request()->routeIs('kaprog.raport.*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Guru">
                                        <i class="fas fa-user-tie"></i> <span class="label ms-2">Guru</span>
                                    </a>
                                @endif

                                {{-- ROLE: TU --}}
                                @if(Auth::user()->role == 'tu')
                                    <a href="{{ route('tu.dashboard') }}" class="nav-link {{ request()->routeIs('tu.dashboard') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Dashboard">
                                        <i class="fas fa-gauge"></i> <span class="label ms-2">Dashboard</span>
                                    </a>

                                    <a class="nav-link {{ request()->is('tu/siswa*') ? 'active' : '' }}" href="{{ route('tu.siswa') }}" data-bs-toggle="tooltip" title="Data Siswa">
                                        <i class="fas fa-users"></i> <span class="label ms-2">Data Siswa</span>
                                    </a>

<a class="nav-link {{ request()->is('tu/siswa*') ? 'active' : '' }}" href="{{ route('tu.ppdb.index') }}" data-bs-toggle="tooltip" title="Data Siswa">
                                        <i class="fas fa-users"></i> <span class="label ms-2">ppdb</span>
                                    </a>


                                    <a class="nav-link {{ request()->is('tu/wali-kelas*') ? 'active' : '' }}" href="{{ route('tu.wali-kelas') }}" data-bs-toggle="tooltip" title="Wali Kelas">
                                        <i class="fas fa-chalkboard-teacher"></i> <span class="label ms-2">Wali Kelas</span>
                                    </a>

                                    <a class="nav-link {{ request()->is('tu/laporan-nilai*') ? 'active' : '' }}" href="{{ route('tu.laporan.nilai') }}" data-bs-toggle="tooltip" title="Laporan Nilai">
                                        <i class="fas fa-chart-line"></i> <span class="label ms-2">Laporan Nilai</span>
                                    </a>

                                    <a class="nav-link {{ request()->is('tu/kelas') ? 'active' : '' }}" href="{{ route('tu.kelas') }}" data-bs-toggle="tooltip" title="Manajemen Kelas">
                                        <i class="fas fa-plus-circle"></i> <span class="label ms-2">Manajemen Kelas</span>
                                    </a>
                                @endif

                                {{-- ROLE: KURIKULUM --}}
                                @if(Auth::user()->role == 'kurikulum')
                                    <a href="{{ route('kurikulum.dashboard') }}" class="nav-link {{ request()->routeIs('kurikulum.dashboard') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Dashboard">
                                        <i class="fas fa-gauge"></i> <span class="label ms-2">Dashboard</span>
                                    </a>

                                    <a href="{{ route('kurikulum.kelas.index') }}" class="nav-link {{ request()->routeIs('kurikulum.kelas*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Manajemen Kelas">
                                        <i class="fas fa-school"></i> <span class="label ms-2">Manajemen Kelas</span>
                                    </a>

                                     <a href="{{ route('kurikulum.siswa.index') }}" class="nav-link {{ request()->routeIs('kurikulum.siswa*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Manajemen Siswa">
                                        <i class="fas fa-users"></i> <span class="label ms-2">Manajemen Siswa</span>

                                    <a href="{{ route('kurikulum.rapor.index') }}" class="nav-link {{ request()->routeIs('kurikulum.rapor*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Lihat Nilai Raport">
                                        <i class="fas fa-file-lines"></i> <span class="label ms-2">Lihat Nilai Raport</span>
                                    </a>
                                @endif

                            </nav>

                            <hr>

                            <!-- LOGOUT -->
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    @endauth

                    @guest
                        <div class="text-center mb-4">
                            <img src="https://ui-avatars.com/api/?name=Guest" class="rounded-circle mb-2" width="64" height="64">
                            <h5 class="mb-0">Tamu</h5>
                            <small class="text-muted">Silakan login</small>
                        </div>

                        <div class="px-2">
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                            <a href="{{ route('ppdb.index') }}" class="nav-link">PPDB</a>
                        </div>
                    @endguest
                </div>
            </nav>
            @endunless

            <!-- MAIN CONTENT -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // sidebar toggle
        document.addEventListener('DOMContentLoaded', function(){
            const toggle = document.getElementById('sidebarToggle');
            if (! toggle) return;
            toggle.addEventListener('click', function(){
                document.body.classList.toggle('sidebar-collapsed');
                // rotate icon
                this.querySelector('i').classList.toggle('fa-angle-right');
            });

            // simple search filter for nav links
            const search = document.getElementById('sidebarSearch');
            if (search) {
                search.addEventListener('input', function(){
                    const q = this.value.toLowerCase();
                    document.querySelectorAll('.sidebar .nav-link').forEach(function(a){
                        const txt = a.textContent.toLowerCase();
                        a.style.display = txt.includes(q) ? '' : 'none';
                    });
                });
            }
        });
    </script>

    @stack('scripts')

</body>

</html>