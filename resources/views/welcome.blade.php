<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMK Negeri 1 Kawali - Buku Induk & PPDB 2025</title>
    <link rel="icon" href="{{ asset('images/bg.png') }}?v={{ filemtime(public_path('images/bg.png')) }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/bg.png') }}?v={{ filemtime(public_path('images/bg.png')) }}">
    
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
        }

        .btn-ppdb {
            background: white;
            color: var(--primary-blue);
            box-shadow: 0 5px 20px rgba(255,255,255,0.3);
        }

        .btn-ppdb:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255,255,255,0.5);
        }

        /* INFO SECTION STYLES */
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

        /* PPDB SECTION STYLES */
        .ppdb-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #0056b3 0%, #003d82 100%);
            position: relative;
            overflow: hidden;
        }

        .ppdb-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.3;
        }

        .ppdb-content {
            position: relative;
            z-index: 2;
        }

        .ppdb-title {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 0 3px 10px rgba(0,0,0,0.3);
        }

        .ppdb-subtitle {
            font-size: 1.3rem;
            color: #d4e8ff;
            text-align: center;
            margin-bottom: 60px;
        }

        .timeline-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            border-left: 5px solid var(--accent-orange);
        }

        .timeline-card:hover {
            transform: translateX(10px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
        }

        .timeline-badge {
            display: inline-block;
            background: linear-gradient(135deg, #fdd835 0%, #ff9800 100%);
            color: #003d82;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .timeline-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 10px;
        }

        .timeline-date {
            font-size: 1.2rem;
            color: var(--accent-red);
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .timeline-detail {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 10px;
            font-size: 1rem;
            color: #444;
            border-left: 3px solid var(--primary-blue);
        }

        /* PROGRAM SECTION STYLES */
        .program-section {
            padding: 80px 0;
            background: white;
        }

        .program-card {
            background: linear-gradient(135deg, #f8f9fa 0%, white 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .program-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-color: var(--primary-blue);
        }

        .program-icon {
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

        .program-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-blue);
        }

        /* DOCUMENT SECTION STYLES */
        .document-section {
            padding: 80px 0;
            background: linear-gradient(to bottom, #f8f9fa 0%, white 100%);
        }

        .document-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
        }

        .document-card:hover {
            transform: translateX(10px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .document-number {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #0056b3 0%, #003d82 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .document-text {
            font-size: 1rem;
            color: #333;
            font-weight: 500;
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

        .alert-box {
            background: linear-gradient(135deg, #ffd54f 0%, #ff9800 100%);
            color: #003d82;
            padding: 20px 30px;
            border-radius: 15px;
            font-weight: 600;
            text-align: center;
            margin-top: 40px;
            box-shadow: 0 5px 20px rgba(255,152,0,0.3);
        }

        /* RESPONSIVE STYLES */
        @media (max-width: 768px) {
            .welcome-title {
                font-size: 2.2rem;
            }
            
            .ppdb-title {
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
                <img src="{{ asset('images/biskaone.jpeg') }}?v={{ filemtime(public_path('images/biskaone.jpeg')) }}" class="logo rounded-circle" alt="BISKAONE" style="border-radius:50% !important; width:70px; height:70px; object-fit:cover; display:block;" onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'%3E%3Ccircle cx=\'50\' cy=\'50\' r=\'45\' fill=\'%23fdd835\'/%3E%3Ctext x=\'50\' y=\'65\' font-size=\'50\' font-weight=\'bold\' text-anchor=\'middle\' fill=\'%230056b3\'\%3ESMK%3C/text%3E%3C/svg%3E'">
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
                    <li class="nav-item"><a class="nav-link" href="#ppdb">PPDB</a></li>
                    <li class="nav-item"><a class="nav-link" href="#program">Program</a></li>
                    <li class="nav-item"><a class="nav-link" href="#dokumen">Dokumen</a></li>
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
                        <a href="{{ route("ppdb.index")}}" class="btn btn-custom btn-ppdb">
                            <i class="fas fa-user-plus me-2"></i> PPDB
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
    <section class="info-section">
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

   <!-- PPDB SECTION -->
<section class="ppdb-section" id="ppdb">
    <div class="container ppdb-content">
        <h2 class="ppdb-title">
            <i class="fas fa-calendar-alt me-3"></i>
            PPDB 2025/2026
        </h2>
        <p class="ppdb-subtitle">Sistem Penerimaan Murid Baru - Tahun Ajaran 2025/2026</p>

       
            <div class="row align-items-stretch g-4">
                @php
                    $ppdbData = $ppdb ?? null;
                    $t1 = $ppdbData['tahap1'] ?? null;
                    $t2 = $ppdbData['tahap2'] ?? null;
                @endphp

                <div class="col-lg-6 mb-4 d-flex">
                    <div class="timeline-card flex-fill">
                        <span class="timeline-badge">TAHAP 1</span>
                        <h3 class="timeline-title">{{ $t1['title'] ?? 'Pendaftaran Tahap 1' }} @if(!empty($t1['open'])) — Terbuka @else — Ditutup @endif</h3>
                        @if(empty($t1['open']))
                        <div class="alert alert-danger mt-3" role="alert">
                            <strong>Perhatian:</strong> Tahap 1 telah ditutup. Pendaftaran Tahap 1 saat ini tidak tersedia.
                        </div>
                        @endif
                        <div class="timeline-date">
                            <i class="fas fa-calendar-check"></i>
                            {{ $t1['pendaftaran'] ?? 'Periode belum diset' }}
                        </div>

                        @if(!empty($t1['pendaftaran']))
                        <div class="timeline-detail">
                            <i class="fas fa-check-circle me-2" style="color: var(--primary-blue);"></i>
                            <strong>Pendaftaran & Verifikasi:</strong> {{ $t1['pendaftaran'] }}
                        </div>
                        @endif

                        @if(!empty($t1['sanggah']))
                        <div class="timeline-detail">
                            <i class="fas fa-check-circle me-2" style="color: var(--primary-blue);"></i>
                            <strong>Masa Sanggah:</strong> {{ $t1['sanggah'] }}
                        </div>
                        @endif

                        @if(!empty($t1['rapat']))
                        <div class="timeline-detail">
                            <i class="fas fa-check-circle me-2" style="color: var(--primary-blue);"></i>
                            <strong>Rapat Dewan Guru:</strong> {{ $t1['rapat'] }}
                        </div>
                        @endif

                        @if(!empty($t1['pengumuman']))
                        <div class="timeline-detail">
                            <i class="fas fa-check-circle me-2" style="color: var(--primary-blue);"></i>
                            <strong>Pengumuman Hasil:</strong> {{ $t1['pengumuman'] }}
                        </div>
                        @endif

                        @if(!empty($t1['daftar_ulang']))
                        <div class="timeline-detail">
                            <i class="fas fa-check-circle me-2" style="color: var(--primary-blue);"></i>
                            <strong>Daftar Ulang:</strong> {{ $t1['daftar_ulang'] }}
                        </div>
                        @endif

                        <div class="mt-3 p-3 bg-light rounded">
                            <strong>Jalur & Kuota Tahap 1:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Domisili Terdekat: 10%</li>
                                <li>Afirmasi: 30% (KETM 25%, PDBK 5%)</li>
                                <li>Mutasi: 5% (Perpindahan 2%, Anak Guru 3%)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4 d-flex">
                    <div class="timeline-card flex-fill">
                        <span class="timeline-badge">TAHAP 2</span>
                        @php
                            $t2_open = !empty($t2['open']);
                            $t2_has_dates = !empty($t2['pendaftaran']) || !empty($t2['sanggah']) || !empty($t2['tes']) || !empty($t2['rapat']) || !empty($t2['pengumuman']) || !empty($t2['daftar_ulang']);
                        @endphp

                        <h3 class="timeline-title">
                            {{ $t2['title'] ?? 'Pendaftaran Tahap 2' }}
                            @if($t2_open) — Terbuka @elseif($t2_has_dates) — Ditutup @else — Belum Dibuka @endif
                        </h3>

                        @if(!$t2_open)
                            @if($t2_has_dates)
                                <div class="alert alert-danger mt-3" role="alert">
                                    <strong>Perhatian:</strong> Tahap 2 telah ditutup. Pendaftaran Tahap 2 saat ini tidak tersedia.
                                </div>
                            @else
                                <div class="alert alert-warning mt-3" role="alert">
                                    <strong>Info:</strong> Tahap 2 belum dibuka. Pantau pengumuman resmi untuk jadwal pembukaan Tahap 2.
                                </div>
                            @endif
                        @endif

                        @if(!empty($t2['pendaftaran']))
                        <div class="timeline-detail">
                            <i class="fas fa-check-circle me-2" style="color: var(--primary-blue);"></i>
                            <strong>Pendaftaran & Verifikasi:</strong> {{ $t2['pendaftaran'] }}
                        </div>
                        @endif

                        @if(!empty($t2['sanggah']))
                        <div class="timeline-detail">
                            <i class="fas fa-check-circle me-2" style="color: var(--primary-blue);"></i>
                            <strong>Masa Sanggah:</strong> {{ $t2['sanggah'] }}
                        </div>
                        @endif

                        @if(!empty($t2['rapat']))
                        <div class="timeline-detail">
                            <i class="fas fa-check-circle me-2" style="color: var(--primary-blue);"></i>
                            <strong>Rapat Dewan Guru:</strong> {{ $t2['rapat'] }}
                        </div>
                        @endif

                        @if(!empty($t2['pengumuman']))
                        <div class="timeline-detail">
                            <i class="fas fa-check-circle me-2" style="color: var(--primary-blue);"></i>
                            <strong>Pengumuman Hasil:</strong> {{ $t2['pengumuman'] }}
                        </div>
                        @endif

                        @if(!empty($t2['daftar_ulang']))
                        <div class="timeline-detail">
                            <i class="fas fa-check-circle me-2" style="color: var(--primary-blue);"></i>
                            <strong>Daftar Ulang:</strong> {{ $t2['daftar_ulang'] }}
                        </div>
                        @endif

                        <div class="mt-3 p-3 bg-light rounded">
                            <strong>Jalur & Kuota Tahap 1:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Domisili Terdekat: 10%</li>
                                <li>Afirmasi: 30% (KETM 25%, PDBK 5%)</li>
                                <li>Mutasi: 5% (Perpindahan 2%, Anak Guru 3%)</li>
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

        <div class="alert-box">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>PENTING:</strong> Pendaftaran dapat dilakukan secara <strong>DARING</strong> melalui 
            <a href="https://spmb.jabarprov.go.id" style="color: #003d82; text-decoration: underline;"><strong>spmb.jabarprov.go.id</strong></a>
            (08:00-20:00 WIB) atau <strong>LURING</strong> di Sekretariat SPMB SMKN 1 Kawali (08:00-14:00 WIB)
        </div>
    </div>
</section>

    <!-- PROGRAM SECTION -->
    <section class="program-section" id="program">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Program Keahlian</h2>
                <p class="section-subtitle">7 Program keahlian unggulan dengan fasilitas lengkap dan industri</p>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="program-name">Teknik Otomotif</div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <div class="program-name">Teknik Jaringan Komputer dan Telekomunikasi</div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="program-name">Pengembangan Perangkat Lunak dan Gim</div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="fas fa-palette"></i>
                        </div>
                        <div class="program-name">Desain Pemodelan dan Informasi Bangunan</div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="program-name">Manajemen Perkantoran dan Layanan Bisnis</div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div class="program-name">Akuntansi dan Keuangan Lembaga</div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="fas fa-music"></i>
                        </div>
                        <div class="program-name">Seni Pertunjukan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- DOCUMENT SECTION -->
    <section class="document-section" id="dokumen">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Dokumen Persyaratan</h2>
                <p class="section-subtitle">Dokumen yang harus dibawa saat daftar ulang</p>
            </div>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="document-card">
                        <div class="document-number">1</div>
                        <div class="document-text">Bukti di terima</div>
                    </div>

                    <div class="document-card">
                        <div class="document-number">2</div>
                        <div class="document-text">Bukti Pendaftaran</div>
                    </div>

                    <div class="document-card">
                        <div class="document-number">3</div>
                        <div class="document-text">Surat keterangan Lulus</div>
                    </div>

                    <div class="document-card">
                        <div class="document-number">4</div>
                        <div class="document-text">FC Akta Kelahiran / KIA</div>
                    </div>

                    <div class="document-card">
                        <div class="document-number">5</div>
                        <div class="document-text">FC KTP Orang Tua</div>
                    </div>

                    <div class="document-card">
                        <div class="document-number">6</div>
                        <div class="document-text">FC Kartu Keluarga</div>
                    </div>

                    <div class="document-card">
                        <div class="document-number">7</div>
                        <div class="document-text">FC Buku Rapor (Semester 1 s.d. 5)</div>
                    </div>

                    <div class="document-card">
                        <div class="document-number">8</div>
                        <div class="document-text">Surat Tanggung Jawab Mutlak Orang Tua</div>
                    </div>

                    <div class="document-card">
                        <div class="document-number">9</div>
                        <div class="document-text">Surat keterangan sehat, tidak buta warna</div>
                    </div>

                    <div class="document-card">
                        <div class="document-number">10</div>
                        <div class="document-text">Surat Keterangan tidak bertato dan bertindik</div>
                    </div>

                    <div class="document-card">
                        <div class="document-number">11</div>
                        <div class="document-text">Bukti Layanan Informasi</div>
                    </div>

                    <div class="document-card">
                        <div class="document-number">12</div>
                        <div class="document-text">Surat Memenuhi Tata Tertib</div>
                    </div>

                    <div class="alert alert-warning mt-4" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Catatan:</strong> Bagi calon murid yang tidak mendaftar ulang sesuai jadwal 
                        <strong>TANPA PEMBERITAHUAN</strong> dianggap <strong>MENGUNDURKAN DIRI</strong>
                    </div>

                    <div class="mt-4 p-4 bg-white rounded shadow-sm">
                        <h5 class="text-primary mb-3"><i class="fas fa-folder-open me-2"></i>Warna Map Dokumen</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <span class="badge" style="background: #0056b3; padding: 10px 20px; font-size: 1rem;">
                                    <i class="fas fa-file me-2"></i>BIRU - TO & DPIB
                                </span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="badge" style="background: #ffc107; padding: 10px 20px; font-size: 1rem; color: #003d82;">
                                    <i class="fas fa-file me-2"></i>KUNING - MPLB & AKL
                                </span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="badge" style="background: #28a745; padding: 10px 20px; font-size: 1rem;">
                                    <i class="fas fa-file me-2"></i>HIJAU - SP
                                </span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="badge" style="background: #dc3545; padding: 10px 20px; font-size: 1rem;">
                                    <i class="fas fa-file me-2"></i>MERAH - TJKT & PPLG
                                </span>
                            </div>
                        </div>
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
                        0851 8799 9991
                    </p>
                    <p class="footer-text">
                        <i class="fas fa-globe me-2"></i>
                        <a href="https://spmb.jabarprov.go.id" style="color: #b3d9ff; text-decoration: none;">
                            spmb.jabarprov.go.id
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
                        <i class="fas fa-clock me-2"></i>
                        Jam Operasional
                    </h5>
                    <div class="footer-text">
                        <p class="mb-2"><strong>Pendaftaran Daring:</strong></p>
                        <p class="mb-3">
                            <i class="fas fa-laptop me-2"></i>
                            https://spmb.jabarprov.go.id<br>
                            Senin - Minggu: 08:00 - 20:00 WIB
                        </p>
                        
                        <p class="mb-2"><strong>Pendaftaran Luring:</strong></p>
                        <p class="mb-0">
                            <i class="fas fa-building me-2"></i>
                            Sekretariat SPMB SMKN 1 Kawali<br>
                            Senin - Jumat: 08:00 - 14:00 WIB
                        </p>
                    </div>
                </div>
            </div>

            <hr style="border-color: rgba(255,255,255,0.2); margin: 30px 0;">

            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="footer-text mb-0">
                        &copy; 2025 SMK Negeri 1 Kawali | #TerdidikTerbaik
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