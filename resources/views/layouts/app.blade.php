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

    <style>
        .sidebar .list-group-item.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white !important;
        }

        body {
            background: #f6f7fb;
        }

        /* Sidebar */
        .sidebar {
            min-height: 100vh;
            background-color: #EBF0FF;
            padding-top: 15px;
            border-right: 1px solid #d9dffc;
        }

        .sidebar .nav-link,
        .sidebar .list-group-item {
            border-radius: 8px;
            margin-bottom: 6px;
            padding: 10px 15px;
            color: #333;
            border: none;
        }

        .sidebar .list-group-item:hover {
            background-color: #d7e0ff;
        }

        .sidebar .list-group-item.active {
            background-color: #2F53FF !important;
            color: white !important;
            font-weight: 600;
        }

        .content-wrapper,
        main {
            background: #f8f9fa;
            padding: 35px 40px;
            min-height: 100vh;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- =============== SIDEBAR =============== -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="position-sticky pt-3">

                <!-- PROFILE -->
                <div class="text-center mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                         class="rounded-circle mb-2" width="70" height="70">

                    <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                    <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                </div>

                <!-- MENU -->
                <div class="list-group list-group-flush">

                    {{-- ======================== ROLE: SISWA ======================== --}}
                    @if(Auth::user()->role == 'siswa')

                        <a href="{{ route('siswa.dashboard') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>

                        <a href="{{ route('siswa.dataDiri') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('siswa.dataDiri*') ? 'active' : '' }}">
                            <i class="fas fa-user me-2"></i> Data Diri
                        </a>

                        <a href="{{ route('siswa.raport') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('siswa.raport') ? 'active' : '' }}">
                            <i class="fas fa-file-alt me-2"></i> Lihat Raport
                        </a>

                        <a href="{{ route('siswa.catatan') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('siswa.catatan') ? 'active' : '' }}">
                            <i class="fas fa-sticky-note me-2"></i> Catatan Wali Kelas
                        </a>

                    @endif


                    {{-- ======================== ROLE: WALI KELAS ======================== --}}
                    @if(Auth::user()->role == 'walikelas')

                        <a href="{{ route('walikelas.dashboard') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('walikelas.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>

                        <a href="{{ route('walikelas.siswa.index') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('walikelas.siswa.*') ? 'active' : '' }}">
                            <i class="fas fa-users me-2"></i> Data Siswa
                        </a>

                        <a href="{{ route('walikelas.siswa.index') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('walikelas.rapor.nilai.*') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-check me-2"></i> Input Nilai Raport
                        </a>

                        <a href="{{ route('walikelas.siswa.index') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('walikelas.rapor.cetak') ? 'active' : '' }}">
                            <i class="fas fa-file-lines me-2"></i> Lihat Nilai Raport
                        </a>

                    @endif


                    {{-- ======================== ROLE: KAPROG ======================== --}}
                    @if(Auth::user()->role == 'kaprog')

                        <a href="{{ route('kaprog.dashboard') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('kaprog.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-gauge me-2"></i> Dashboard
                        </a>

                        <a href="{{ route('kaprog.raport.siswa') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('kaprog.raport.*') ? 'active' : '' }}">
                            <i class="fas fa-file-lines me-2"></i> View Raport
                        </a>

                    @endif


                    {{-- ======================== ROLE: TU ======================== --}}
                    @if(Auth::user()->role == 'tu')

                        <a href="{{ route('tu.dashboard') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('tu.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-gauge me-2"></i> Dashboard
                        </a>

                    @endif


                    {{-- ======================== ROLE: KURIKULUM ======================== --}}
                    @if(Auth::user()->role == 'kurikulum')

                        <a href="{{ route('kurikulum.dashboard')}}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('kurikulum.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-gauge me-2"></i> Dashboard
                        </a>

                        <a href="{{ route('kurikulum.siswa.index') }}"
                           class="list-group-item list-group-item-action {{ request()->routeIs('kurikulum.siswa*') ? 'active' : '' }}">
                            <i class="fa fa-users me-2"></i> Manajemen Siswa
                        </a>

                        <a href=""
                           class="list-group-item list-group-item-action {{ request()->routeIs('kurikulum.kelas*') ? 'active' : '' }}">
                            <i class="fa fa-building me-2"></i> Manajemen Kelas
                        </a>

                        <a href=""
                           class="list-group-item list-group-item-action {{ request()->routeIs('kurikulum.akun') ? 'active' : '' }}">
                            <i class="fa fa-user-cog me-2"></i> Manajemen Akun
                        </a>

                        <a href=""
                           class="list-group-item list-group-item-action {{ request()->routeIs('kurikulum.raport*') ? 'active' : '' }}">
                            <i class="fa fa-file-alt me-2"></i> View Raport
                        </a>

                    @endif

                </div>

                <hr>

                <!-- LOGOUT -->
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>

            </div>
        </nav>

        <!-- MAIN CONTENT -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @yield('content')
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
