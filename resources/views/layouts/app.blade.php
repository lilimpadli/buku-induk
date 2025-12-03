<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #EBF0FF;
        }

        .sidebar .nav-link {
            border-radius: 8px;
            margin-bottom: 5px;
            padding: 10px 15px;
            color: #333;
        }

        .sidebar .nav-link:hover {
            background-color: #d7e0ff;
        }

        .sidebar .nav-link.active {
            background-color: #2F53FF !important;
            color: #fff !important;
        }

        .content-wrapper {
            background: #f8f9fa;
            padding: 30px;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- =============== SIDEBAR =============== -->
        <nav class="col-md-3 col-lg-2 sidebar d-flex flex-column p-3">

            <!-- PROFILE -->
            <div class="text-center mb-4">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                     class="rounded-circle mb-2" width="70" height="70">

                <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
            </div>

            <!-- MENU -->
            <ul class="nav flex-column mb-auto">

                @if(Auth::user()->role === 'kaprog')

                    <li class="nav-item">
                        <a href="{{ route('kaprog.dashboard') }}"
                           class="nav-link {{ request()->routeIs('kaprog.dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-gauge me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('kaprog.raport.siswa') }}"
                           class="nav-link {{ request()->routeIs('kaprog.raport.siswa') ? 'active' : '' }}">
                            <i class="fa-solid fa-file-lines me-2"></i> View raport
                        </a>
                    </li>

                @endif

            </ul>

            <!-- LOGOUT -->
            <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </button>
            </form>

        </nav>

        <!-- =============== MAIN CONTENT =============== -->
        <main class="col-md-9 ms-sm-auto col-lg-10 content-wrapper">
            @yield('content')
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
