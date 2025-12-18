<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMK Negeri 1 Kawali - Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0056b3;
            --light-blue: #e6f2ff;
            --accent-red: #e53935;
            --accent-yellow: #fdd835;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* ========================== */
        /*        HERO FULL BG        */
        /* ========================== */
        .hero-section {
            background-image: url("{{ asset('images/hero-illustration.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;  
            display: flex;
            align-items: center;
            padding: 120px 0;
            position: relative;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right,
                rgba(0, 86, 179, 0.85) 0%,
                rgba(0, 86, 179, 0.45) 40%, 
                rgba(0, 86, 179, 0.15) 70%,
                rgba(0, 0, 0, 0) 100%
            );
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .welcome-title {
            font-size: 3rem;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
            text-shadow: 0 3px 6px rgba(0,0,0,0.4);
        }

        .welcome-sub {
            font-size: 1.2rem;
            color: #eaf3ff;
            margin-bottom: 20px;
        }

        .btn-custom {
            padding: 12px 26px;
            font-weight: 600;
            border-radius: 50px;
            margin-right: 12px;
            transition: transform 0.18s ease;
            font-size: 1.05rem;
        }

        .btn-login {
            background-color: var(--primary-blue);
            color: white;
        }

        .btn-login:hover {
            background-color: #004494;
            transform: translateY(-2px);
        }

        /* NAVBAR */
        .navbar-custom {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .navbar-custom .nav-link {
            color: #495057;
            font-weight: 500;
            margin: 0 10px;
        }

        .navbar-custom .nav-link.active {
            color: var(--primary-blue);
            font-weight: 600;
        }

        /* ABOUT SECTION (ESTETIK BARU) */
        .about-section {
            padding: 80px 0;
        }

        .section-title {
            font-weight: 600;
            color: var(--primary-blue);
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 15px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100px;
            height: 3px;
            background-color: var(--accent-red);
        }

        .school-image {
            border-radius: 12px;
            width: 100%;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        /* FOOTER */
        .footer {
            background-color: var(--primary-blue);
            color: white;
            padding: 30px 0;
            margin-top: 50px;
        }

    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/smkn1-kawali-logo.png') }}" class="logo" style="width: 90px;">
                <div>
                    <h5 class="school-name">SMKN 1 KAWALI</h5>
                    <p class="school-location">KAB. CIAMIS</p>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/tentang') }}">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('ppdb.index') }}">PPDB</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="container hero-content">
            <div class="row">
                <div class="col-lg-7 text-center text-lg-start">

                    <p class="welcome-sub">Selamat datang di website</p>

                    <h1 class="welcome-title">
                        Buku Induk Siswa <br> SMK Negeri 1 Kawali
                    </h1>

                    <p class="welcome-sub">
                        Sistem informasi untuk pengelolaan data siswa secara lengkap, akurat, dan terstruktur.
                    </p>

                    <div class="mt-4">
                        <a href="{{ route('login') }}" class="btn btn-custom btn-login">Login</a>
                       <a href="{{ route('ppdb.index') }}" class="btn btn-custom btn-login">PPDB</a>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT (ESTETIK) -->
    <section class="about-section">
        <div class="container">
            <h2 class="section-title">Tentang</h2>

            <div class="row align-items-center">

                <div class="col-lg-6">
                    <p style="font-size: 1.05rem; line-height: 1.75; color: #444;">
                        <strong>Buku Induk Siswa</strong> adalah sistem informasi modern yang dirancang untuk
                        memudahkan pengelolaan data siswa secara lengkap, rapi, dan terstruktur. Platform ini membantu sekolah
                        menyimpan berbagai informasi penting mulai dari data identitas siswa, riwayat akademik, catatan kehadiran,
                        hingga perkembangan siswa selama masa pendidikan.
                    </p>

                    <p style="font-size: 1.05rem; line-height: 1.75; color: #444;">
                        Website ini hadir untuk meningkatkan efisiensi administrasi sekolah, menjaga keamanan data,
                        serta mempermudah pencarian informasi kapan saja dan di mana saja. Dengan tampilan yang bersih dan mudah digunakan,
                        sistem ini mendukung pengelolaan data siswa secara lebih profesional dan terorganisir.
                    </p>
                </div>

                <div class="col-lg-6">
                    <img src="{{ asset('images/gedung-kawali.jpg') }}" class="school-image" alt="Gedung SMKN 1 Kawali">
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>SMK Negeri 1 Kawali</h5>
                    <p>Jl. Pendidikan No. 123, Kawali, Kabupaten Ciamis</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; 2025 SMK Negeri 1 Kawali</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
