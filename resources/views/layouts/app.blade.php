<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Aplikasi Buku Induk</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS (opsional, jika Anda ingin menambahkan style sendiri) -->
    <style>
        .sidebar .list-group-item.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- SIDEBAR -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4>{{ Auth::user()->name }}</h4>
                        <small class="text-muted">Role: {{ ucfirst(Auth::user()->role) }}</small>
                    </div>

                    <div class="list-group list-group-flush">
                        
                        {{-- ========================
                             ROLE: SISWA
                        ========================= --}}
                        @if(Auth::user()->role == 'siswa')
                            <a href="{{ route('siswa.dashboard') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                            <a href="{{ route('siswa.dataDiri') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-user me-2"></i> Data Diri
                            </a>
                            <a href="{{ route('siswa.raport') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-file-alt me-2"></i> Lihat Raport
                            </a>
                            <a href="{{ route('siswa.catatan') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-sticky-note me-2"></i> Catatan Wali Kelas
                            </a>
                        @endif

                        {{-- ========================
                             ROLE: WALI KELAS
                        ========================= --}}
                        @if(Auth::user()->role == 'walikelas')
                            <a href="{{ route('walikelas.dashboard') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                           <a href="{{ route('walikelas.siswa.index') }}" class="list-group-item list-group-item-action">
    <i class="fas fa-users me-2"></i> Data Siswa
</a>

                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fas fa-clipboard-check me-2"></i> Penilaian
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fas fa-comment-dots me-2"></i> Catatan Siswa
                            </a>
                        @endif

                        {{-- ... Tambahkan role lainnya di sini dengan pola yang sama ... --}}
                        
                    </div>

                    <hr>

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

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>