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

    @stack('styles')

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
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: var(--sidebar-bg);
            padding: 1.25rem 0.75rem;
            border-right: 1px solid rgba(47,83,255,0.06);
            width: 260px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
            overflow-y: auto;
            transition: width 0.2s ease;
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

        .user-mini { 
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align:center; 
            padding:12px 6px; 
            border-bottom: 1px solid rgba(47,83,255,0.1);
            margin-bottom: 15px;
        }

        .user-mini img {
            border: 3px solid white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .user-mini img:hover {
            transform: scale(1.05);
        }

        /* collapsed body state */
        body.sidebar-collapsed .sidebar{ width:64px; }
        body.sidebar-collapsed .sidebar .nav-link span.label{ display:none; }
        body.sidebar-collapsed .sidebar .sidebar-header .brand span.title{ display:none; }
        body.sidebar-collapsed .user-mini div { display:none; }
        body.sidebar-collapsed .user-mini small { display:none; }
        body.sidebar-collapsed .user-mini img {
            width: 40px;
            height: 40px;
        }

        main {
            background: #f8f9fa;
            padding: 30px 28px;
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left .2s ease;
        }

        body.sidebar-collapsed main {
            margin-left: 64px;
        }

        @media (max-width: 991px){
            .sidebar{ 
                position: static; 
                width:100%; 
                height: auto;
            }
            body.sidebar-collapsed .sidebar{ 
                width:100%; 
                height: auto;
            }
            main {
                margin-left: 0;
            }
        }
        /* Ensure pagination icons/chevrons keep a normal size */
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

        /* Make sure pagination links keep compact padding */
        .pagination .page-link,
        .pagination .page-item a,
        .pagination .page-item button {
            padding: .375rem .6rem !important;
            min-width: 2.2rem !important;
        }

        /* Global safety clamps for icons inside main content to prevent accidental huge icons */
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

        /* Specific override for empty-state icons which in views sometimes set large sizes */
        main .empty-state i,
        .empty-state i {
            font-size: 2rem !important;
            max-width: 2rem !important;
            max-height: 2rem !important;
            display: inline-block !important;
        }
        
        /* Perbaikan untuk dropdown menu */
        .dropdown-menu {
            border: 1px solid rgba(0,0,0,.1);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        
        .dropdown-item i {
            width: 20px;
            margin-right: 8px;
        }
        
        /* Perbaikan untuk tautan aktif */
        .sidebar .nav-link.active {
            background: var(--accent);
            color: #fff;
        }
        
        /* Perbaikan untuk judul submenu */
        .sidebar .nav-subtitle {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--muted);
            letter-spacing: 0.05em;
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
                        
                    </div>

                    <div class="sidebar-search">
                        <input class="form-control form-control-sm" placeholder="Cari menu..." id="sidebarSearch">
                    </div>

                    @auth
                        <div class="user-mini">
                            @if(isset(Auth::user()->photo) && Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}?v={{ time() }}" class="rounded-circle mb-2" width="80" height="80" style="object-fit:cover;" id="sidebarProfilePhoto">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_lengkap ?? Auth::user()->name ?? '') }}&size=80" class="rounded-circle mb-2" width="80" height="80" id="sidebarProfilePhoto">
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

                                {{-- ROLE: GURU --}}
                                @if(Auth::user()->role == 'guru')
                                    <a href="{{ route('guru.dashboard') }}" class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Dashboard">
                                        <i class="fas fa-tachometer-alt"></i> <span class="label ms-2">Dashboard</span>
                                    </a>

                                  
                                    <a href="{{ route('guru.profile') }}" class="nav-link {{ request()->routeIs('guru.profile*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Data Diri">
                                        <i class="fas fa-user"></i> <span class="label ms-2">Data Diri</span>
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

                                    <a href="{{ route('kaprog.datapribadi.index') }}" class="nav-link {{ request()->routeIs('kaprog.datapribadi*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Data Diri">
                                        <i class="fas fa-id-card"></i> <span class="label ms-2">Data Diri</span>
                                    </a>

                                    <a href="{{ route('kaprog.siswa.index') }}" class="nav-link {{ request()->routeIs('kaprog.siswa.*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Data Siswa">
                                        <i class="fas fa-users"></i> <span class="label ms-2">Data Siswa</span>
                                    </a>

                                    <a href="{{ route('kaprog.kelas.index') }}" class="nav-link {{ request()->routeIs('kaprog.kelas.*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Data Kelas">
                                        <i class="fas fa-chalkboard"></i> <span class="label ms-2">Data Kelas</span>
                                    </a>

                                    <a href="{{ route('kaprog.guru.index') }}" class="nav-link {{ request()->routeIs('kaprog.guru.*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Guru">
                                        <i class="fas fa-user-tie"></i> <span class="label ms-2">Guru</span>
                                    </a>
                                @endif

                                {{-- ROLE: TU --}}
                                @if(Auth::user()->role == 'tu')
                                    <a href="{{ route('tu.dashboard') }}" class="nav-link {{ request()->routeIs('tu.dashboard') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Dashboard">
                                        <i class="fas fa-gauge"></i> <span class="label ms-2">Dashboard</span>
                                    </a>

                                    <a class="nav-link {{ request()->routeIs('tu.siswa*') ? 'active' : '' }}" href="{{ route('tu.siswa.index') }}" data-bs-toggle="tooltip" title="Data Siswa">
                                        <i class="fas fa-users"></i> <span class="label ms-2">Data Siswa</span>
                                    </a>

                                    <a class="nav-link {{ request()->routeIs('tu.ppdb*') ? 'active' : '' }}" href="{{ route('tu.ppdb.index') }}" data-bs-toggle="tooltip" title="PPDB">
                                        <i class="fas fa-users"></i> <span class="label ms-2">PPDB</span>
                                    </a>

                                    <a class="nav-link {{ request()->routeIs('tu.kelas*') ? 'active' : '' }}" href="{{ route('tu.kelas.index') }}" data-bs-toggle="tooltip" title="Manajemen Kelas">
                                        <i class="fas fa-plus-circle"></i> <span class="label ms-2">Manajemen Kelas</span>
                                    </a>

                                    <a class="nav-link {{ request()->routeIs('tu.guru*') ? 'active' : '' }}" href="{{ route('tu.guru.index') }}" data-bs-toggle="tooltip" title="Data Guru">
                                        <i class="fas fa-plus-circle"></i> <span class="label ms-2">Data Guru</span>
                                    </a>

                                    <!-- MENU MUTASI SISWA -->
                                    <hr class="my-2">
                                    <div class="nav-subtitle">buku induk</div>
                                    <a href="{{ route('tu.buku-induk.index') }}" class="nav-link {{ request()->routeIs('tu.buku-induk*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Buku Induk">
                                        <i class="fas fa-book"></i> <span class="label ms-2">Buku Induk</span>
                                    </a>

                                    <a href="{{ route('tu.mutasi.index') }}" class="nav-link {{ request()->routeIs('tu.mutasi*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Mutasi Siswa">
                                        <i class="fas fa-exchange-alt"></i> <span class="label ms-2">Mutasi Siswa</span>
                                    </a>

                                    <!-- MENU KELULUSAN -->
                                    <hr class="my-2">
                                    <div class="nav-subtitle">MANAJEMEN LULUSAN</div>

                                    <a href="{{ route('tu.alumni.index') }}" class="nav-link {{ request()->routeIs('tu.alumni*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Data Alumni">
                                        <i class="fas fa-user-friends"></i> <span class="label ms-2">Data Alumni</span>
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
                                    </a>

                                    <!-- Dropdown Menu untuk PPDB -->
                                    <div class="dropdown">
                                        <a class="nav-link dropdown-toggle {{ request()->is('kurikulum/ppdb*') ? 'active' : '' }}" href="#" id="ppdbDropdownKurikulum" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-users"></i> <span class="label ms-2">PPDB</span>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="ppdbDropdownKurikulum">
                                            <li><a class="dropdown-item" href="{{ route('kurikulum.ppdb.index') }}"><i class="fas fa-list"></i> Data PPDB</a></li>
                                            <li><a class="dropdown-item" href="{{ route('kurikulum.ppdb.timeline') }}"><i class="fas fa-clock"></i> Timeline PPDB</a></li>
                                        </ul>
                                    </div>

                                    <a href="{{ route('kurikulum.jurusan.index') }}" class="nav-link {{ request()->routeIs('kurikulum.jurusan*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Manajemen Jurusan">
                                        <i class="fas fa-school"></i> <span class="label ms-2">Manajemen Jurusan</span>
                                    </a>

                                    <a href="{{ route('kurikulum.guru.index') }}" class="nav-link {{ request()->routeIs('kurikulum.guru*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Manajemen Guru">
                                        <i class="fas fa-user-tie"></i> <span class="label ms-2">Manajemen Guru</span>
                                    </a>

                                    <a href="{{ route('kurikulum.mata-pelajaran.index') }}" class="nav-link {{ request()->routeIs('kurikulum.mata-pelajaran*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Manajemen Mata Pelajaran">
                                        <i class="fas fa-book"></i> <span class="label ms-2">Manajemen Mata Pelajaran</span>
                                    </a>

                                    <!-- MENU BUKU INDUK -->
                                    <hr class="my-2">
                                    <div class="nav-subtitle">BUKU INDUK</div>
                                    <a href="{{ route('kurikulum.buku-induk.index') }}" class="nav-link {{ request()->routeIs('kurikulum.buku-induk*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Buku Induk">
                                        <i class="fas fa-book"></i> <span class="label ms-2">Buku Induk</span>
                                    </a>

                                    <a href="{{ route('kurikulum.mutasi.index') }}" class="nav-link {{ request()->routeIs('kurikulum.mutasi*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Mutasi Siswa">
                                        <i class="fas fa-exchange-alt"></i> <span class="label ms-2">Mutasi Siswa</span>
                                    </a>

                                    <!-- MENU KELULUSAN -->
                                    <hr class="my-2">
                                    <div class="nav-subtitle">MANAJEMEN LULUSAN</div>
                                    <a href="{{ route('kurikulum.alumni.index') }}" class="nav-link {{ request()->routeIs('kurikulum.alumni*') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Data Alumni">
                                        <i class="fas fa-user-friends"></i> <span class="label ms-2">Data Alumni</span>
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

                   
                </div>
            </nav>
            @endunless

            <!-- MAIN CONTENT -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @include('partials._alerts')
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
            
            // Inisialisasi dropdown Bootstrap
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });
        });
    </script>

    @stack('scripts')

</body>

</html>