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
        body {
            background: #f6f7fb;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #EBF0FF;
            padding-top: 15px;
            border-right: 1px solid #d9dffc;
        }

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
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="rounded-circle mb-2"
                            width="70" height="70">

                        <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                        <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                    </div>

                    <!-- MENU -->
                    <div class="list-group list-group-flush">

                        {{-- ======================== ROLE: SISWA ======================== --}}
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

                            {{-- Input Nilai Raport --}}
                            <a href="{{ route('walikelas.input_nilai_raport.index') }}"
                                class="list-group-item list-group-item-action {{ request()->routeIs('walikelas.rapor.nilai.*') ? 'active' : '' }}">
                                <i class="fas fa-clipboard-check me-2"></i> Input Nilai Raport
                            </a>

                            {{-- Lihat / Cetak Raport --}}
                            <a href="{{ route('walikelas.nilai_raport.index') }}"
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

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('tu') ? 'active' : '' }}"
                                    href="{{ route('tu.dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('tu/siswa*') ? 'active' : '' }}"
                                    href="{{ route('tu.siswa') }}">
                                    <i class="fas fa-users"></i> Data Siswa
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('tu/wali-kelas*') ? 'active' : '' }}"
                                    href="{{ route('tu.wali-kelas') }}">
                                    <i class="fas fa-chalkboard-teacher"></i> Wali Kelas
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('tu/laporan-nilai*') ? 'active' : '' }}"
                                    href="{{ route('tu.laporan.nilai') }}">
                                    <i class="fas fa-chart-line"></i> Laporan Nilai
                                </a>
                            </li>

                            {{-- ================= Tambah Wali Kelas (Menu Baru) ================= --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('tu/kelas') ? 'active' : '' }}"
                                    href="{{ route('tu.kelas') }}">
                                    <i class="fas fa-plus-circle"></i> Manejemen Kelas
                                </a>
                            </li>

                        @endif




                        {{-- ======================== ROLE: KURIKULUM ======================== --}}
                        @if(Auth::user()->role == 'kurikulum')

                            <a href="{{ route('kurikulum.dashboard') }}"
                                class="list-group-item list-group-item-action {{ request()->routeIs('kurikulum.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-gauge me-2"></i> Dashboard
                            </a>

                            <a href="{{ route('kurikulum.siswa.index') }}"
                                class="list-group-item list-group-item-action {{ request()->routeIs('kurikulum.siswa*') ? 'active' : '' }}">
                                <i class="fa fa-users me-2"></i> Manajemen Siswa
                            </a>

    {{-- Input Nilai Raport --}}
    <a href="{{ route('walikelas.input_nilai_raport.index') }}"
       class="list-group-item list-group-item-action 
       {{ request()->routeIs('walikelas.rapor.nilai.*') ? 'active' : '' }}">
        <i class="fas fa-clipboard-check me-2"></i> Input Nilai Raport
    </a>

    {{-- Lihat / Cetak Raport --}}
    <a href="{{ route('walikelas.nilai_raport.index') }}"
       class="list-group-item list-group-item-action 
       {{ request()->routeIs('walikelas.rapor.cetak') ? 'active' : '' }}">
        <i class="fas fa-file-lines me-2"></i> Lihat Nilai Raport
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