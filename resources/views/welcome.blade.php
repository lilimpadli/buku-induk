<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Induk Siswa - SMK Negeri 1 Kawali</title>
    <link rel="icon" href="{{ asset('images/bg.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/bg.png') }}">

    <!-- External CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        :root {
            --primary-blue: #0056b3;
            --light-blue: #e6f2ff;
            --accent-red: #e53935;
            --accent-yellow: #fdd835;
            --accent-orange: #ff9800;
            --accent-green: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* NAVBAR STYLES */
        .navbar-custom {
            background: linear-gradient(135deg, #0056b3 0%, #003d82 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            padding: 15px 0;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            animation: float 3s ease-in-out infinite;
            border: 3px solid rgba(255,255,255,0.9);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .school-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        .school-location {
            font-size: 0.85rem;
            color: #b3d9ff;
            margin: 0;
        }

        .navbar-custom .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 15px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-custom .nav-link:hover {
            color: var(--accent-yellow) !important;
            transform: translateY(-2px);
        }

        .navbar-custom .nav-link.active {
            color: var(--accent-yellow) !important;
        }

        /* HERO SECTION STYLES */
        .hero-section {
            background: linear-gradient(135deg, #0056b3 0%, #003d82 50%, #001f3f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: -50%;
            right: -20%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 8s ease-in-out infinite;
        }

        .hero-section::after {
            content: "";
            position: absolute;
            bottom: -30%;
            left: -15%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,215,0,0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 10s ease-in-out infinite reverse;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .welcome-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            padding: 10px 25px;
            border-radius: 50px;
            color: white;
            font-size: 0.95rem;
            margin-bottom: 20px;
            animation: slideInDown 1s ease;
        }

        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .welcome-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 20px;
            line-height: 1.2;
            text-shadow: 0 4px 10px rgba(0,0,0,0.3);
            animation: slideInLeft 1s ease;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .welcome-sub {
            font-size: 1.3rem;
            color: #d4e8ff;
            margin-bottom: 30px;
            animation: slideInLeft 1s ease 0.2s backwards;
        }

        .btn-custom {
            padding: 15px 35px;
            font-weight: 600;
            border-radius: 50px;
            margin-right: 15px;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            border: none;
            position: relative;
            overflow: hidden;
            animation: slideInUp 1s ease 0.4s backwards;
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn-login {
            background: linear-gradient(135deg, #fdd835 0%, #ff9800 100%);
            color: #003d82;
            box-shadow: 0 5px 20px rgba(255,152,0,0.4);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255,152,0,0.6);
            color: #003d82;
        }

        /* SECTION STYLES */
        .info-section {
            padding: 80px 0;
            background: linear-gradient(to bottom, white 0%, #f8f9fa 100%);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, var(--accent-red), var(--accent-orange));
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 50px;
        }

        .info-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            height: 100%;
            border: 2px solid transparent;
        }

        .info-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
            border-color: var(--primary-blue);
        }

        .info-card-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #0056b3 0%, #003d82 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .info-card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 15px;
        }

        .info-card-text {
            font-size: 1rem;
            color: #555;
            line-height: 1.8;
        }

        /* FITUR SECTION */
        .feature-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #0056b3 0%, #003d82 100%);
            position: relative;
            overflow: hidden;
        }

        .feature-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.3;
        }

        .feature-content {
            position: relative;
            z-index: 2;
        }

        .feature-title {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 0 3px 10px rgba(0,0,0,0.3);
        }

        .feature-subtitle {
            font-size: 1.3rem;
            color: #d4e8ff;
            text-align: center;
            margin-bottom: 60px;
        }

        .feature-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            border-left: 5px solid var(--accent-orange);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateX(10px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #0056b3 0%, #003d82 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .feature-card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 10px;
        }

        .feature-card-text {
            font-size: 0.95rem;
            color: #555;
            line-height: 1.7;
        }

        /* ROLE SECTION */
        .role-section {
            padding: 80px 0;
            background: white;
        }

        .role-card {
            background: linear-gradient(135deg, #f8f9fa 0%, white 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            text-align: center;
        }

        .role-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-color: var(--primary-blue);
        }

        .role-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #0056b3 0%, #003d82 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 15px;
            box-shadow: 0 5px 15px rgba(0,86,179,0.3);
        }

        .role-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 8px;
        }

        .role-desc {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.6;
        }

        /* FOOTER STYLES */
        .footer {
            background: linear-gradient(135deg, #003d82 0%, #001f3f 100%);
            color: white;
            padding: 60px 0 30px;
            margin-top: 0;
        }

        .footer-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-text {
            color: #b3d9ff;
            line-height: 1.8;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-link {
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-link:hover {
            background: var(--accent-yellow);
            color: var(--primary-blue);
            transform: translateY(-5px);
        }

        /* RESPONSIVE STYLES */
        @media (max-width: 768px) {
            .welcome-title {
                font-size: 2.2rem;
            }

            .feature-title {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/biskaone.jpeg') }}?v={{ filemtime(public_path('images/biskaone.jpeg')) }}" class="logo rounded-circle" alt="BISKAONE" style="border-radius:50% !important; width:70px; height:70px; object-fit:cover; display:block;" onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'%3E%3Ccircle cx=\'50\' cy=\'50\' r=\'45\' fill=\'%23fdd835\'/%3E%3Ctext x=\'50\' y=\'65\' font-size=\'50\' font-weight=\'bold\' text-anchor=\'middle\' fill=\'%230056b3\'%3ESMK%3C/text%3E%3C/svg%3E'">
                <div>
                    <h5 class="school-name">SMKN 1 KAWALI</h5>
                    <p class="school-location">KAB. CIAMIS</p>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="background: white;">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#akses">Akses</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section" id="home">
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="welcome-badge">
                        <i class="fas fa-graduation-cap me-2"></i>Selamat Datang
                    </span>

                    <h1 class="welcome-title">
                        Buku Induk Siswa<br>
                        SMK Negeri 1 Kawali
                    </h1>

                    <p class="welcome-sub">
                        Sistem informasi modern untuk pengelolaan data siswa secara lengkap, akurat, dan terstruktur.
                    </p>

                    <div class="mt-4">
                        <a href="{{ route('login') }}" class="btn btn-custom btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Sistem
                        </a>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="text-center" style="animation: float 3s ease-in-out infinite;">
                        <i class="fas fa-school" style="font-size: 15rem; color: rgba(255,255,255,0.1);"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- INFO CARDS SECTION -->
    <section class="info-section" id="tentang">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Tentang Sistem</h2>
                <p class="section-subtitle">Platform digital terpadu untuk administrasi sekolah modern</p>
            </div>

            <div class="row align-items-start g-4">
                <div class="col-md-4 mb-4">
                    <div class="info-card">
                        <div class="info-card-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <h3 class="info-card-title">Data Terstruktur</h3>
                        <p class="info-card-text">
                            Sistem menyimpan data siswa secara lengkap mulai dari identitas, riwayat akademik, hingga perkembangan selama masa pendidikan.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="info-card">
                        <div class="info-card-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="info-card-title">Keamanan Data</h3>
                        <p class="info-card-text">
                            Dilengkapi dengan sistem keamanan berlapis untuk menjaga kerahasiaan dan integritas data siswa.
                        </p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="info-card">
                        <div class="info-card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="info-card-title">Akses 24/7</h3>
                        <p class="info-card-text">
                            Akses informasi kapan saja dan di mana saja melalui platform digital yang responsif dan mudah digunakan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FITUR SECTION -->
    <section class="feature-section" id="fitur">
        <div class="container feature-content">
            <h2 class="feature-title">
                <i class="fas fa-cogs me-3"></i>
                Fitur Unggulan
            </h2>
            <p class="feature-subtitle">Berbagai fitur untuk mempermudah pengelolaan data siswa</p>

            <div class="row align-items-stretch g-4">
                <div class="col-lg-4 mb-4 d-flex">
                    <div class="feature-card flex-fill">
                        <div class="feature-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <h3 class="feature-card-title">Buku Induk Digital</h3>
                        <p class="feature-card-text">
                            Data lengkap siswa mulai dari identitas pribadi, data orang tua, riwayat pendidikan, hingga prestasi akademik.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 mb-4 d-flex">
                    <div class="feature-card flex-fill">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-card-title">Nilai Raport</h3>
                        <p class="feature-card-text">
                            Pencatatan nilai raport per semester dengan kategorisasi mata pelajaran umum dan kejuruan.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 mb-4 d-flex">
                    <div class="feature-card flex-fill">
                        <div class="feature-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <h3 class="feature-card-title">Mutasi Siswa</h3>
                        <p class="feature-card-text">
                            Pencatatan riwayat mutasi siswa masuk dan keluar, termasuk siswa pindahan dan lulusan.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 mb-4 d-flex">
                    <div class="feature-card flex-fill">
                        <div class="feature-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3 class="feature-card-title">Data Alumni</h3>
                        <p class="feature-card-text">
                            Pencatatan data siswa yang telah lulus beserta riwayat akademik dan pencapaian mereka.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 mb-4 d-flex">
                    <div class="feature-card flex-fill">
                        <div class="feature-icon">
                            <i class="fas fa-print"></i>
                        </div>
                        <h3 class="feature-card-title">Cetak Dokumen</h3>
                        <p class="feature-card-text">
                            Cetak buku induk, raport, surat keterangan aktif, biodata siswa, dan dokumen lainnya secara instan.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 mb-4 d-flex">
                    <div class="feature-card flex-fill">
                        <div class="feature-icon">
                            <i class="fas fa-file-import"></i>
                        </div>
                        <h3 class="feature-card-title">Import & Export</h3>
                        <p class="feature-card-text">
                            Import data siswa dan nilai dari Excel, serta export data ke berbagai format dokumen.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ROLE SECTION -->
    <section class="role-section" id="akses">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Akses Multi Role</h2>
                <p class="section-subtitle">Sistem dapat diakses oleh berbagai pengguna sesuai dengan perannya</p>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="role-card">
                        <div class="role-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="role-name">Super Admin</div>
                        <div class="role-desc">Kelola seluruh sistem, user, dan konfigurasi</div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="role-card">
                        <div class="role-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div class="role-name">TU Kesiswaan</div>
                        <div class="role-desc">Kelola data siswa, buku induk, mutasi, dan alumni</div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="role-card">
                        <div class="role-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="role-name">TU Kepegawaian</div>
                        <div class="role-desc">Kelola data guru, pegawai, dan kepegawaian</div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="role-card">
                        <div class="role-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="role-name">Kurikulum</div>
                        <div class="role-desc">Kelola kurikulum, kelas, dan mata pelajaran</div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="role-card">
                        <div class="role-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="role-name">Wali Kelas & Guru</div>
                        <div class="role-desc">Input nilai raport dan kelola data siswa kelas</div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="role-card">
                        <div class="role-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="role-name">Siswa</div>
                        <div class="role-desc">Lihat data pribadi dan nilai akademik sendiri</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5 class="footer-title">
                        <i class="fas fa-school me-2"></i>
                        SMK Negeri 1 Kawali
                    </h5>
                    <p class="footer-text">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Jl. Talagasari, No. 35, Kawali Mukti, Kawali, Kabupaten Ciamis, Jawa Barat
                    </p>
                    <p class="footer-text">
                        <i class="fas fa-phone me-2"></i>
                        (0265) 791727
                    </p>
                    <p class="footer-text">
                        <i class="fas fa-globe me-2"></i>
                        <a href="http://www.smkn1kawali.sch.id" style="color: #b3d9ff; text-decoration: none;">
                            www.smkn1kawali.sch.id
                        </a>
                    </p>

                    <div class="social-links">
                        <a href="#" class="social-link" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link" title="TikTok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="#" class="social-link" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="social-link" title="Facebook">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <h5 class="footer-title">
                        <i class="fas fa-info-circle me-2"></i>
                        Tentang Buku Induk
                    </h5>
                    <div class="footer-text">
                        <p class="mb-2"><strong>Buku Induk Digital</strong></p>
                        <p class="mb-3">
                            Sistem pengelolaan data siswa yang lengkap dan terintegrasi, mencakup data pribadi, akademik, dan riwayat pendidikan.
                        </p>

                        <p class="mb-2"><strong>Dikembangkan Untuk:</strong></p>
                        <p class="mb-0">
                            <i class="fas fa-users me-2"></i>
                            SMK Negeri 1 Kawali<br>
                            Kabupaten Ciamis, Jawa Barat
                        </p>
                    </div>
                </div>
            </div>

            <hr style="border-color: rgba(255,255,255,0.2); margin: 30px 0;">

            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="footer-text mb-0">
                        &copy; {{ date('Y') }} SMK Negeri 1 Kawali | Sistem Buku Induk Digital
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- External JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Active nav link on scroll
        window.addEventListener('scroll', () => {
            let current = '';
            const sections = document.querySelectorAll('section[id]');

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>