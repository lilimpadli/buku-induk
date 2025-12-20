<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB - Pendaftaran Siswa Baru</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: var(--dark-color);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 60px 0;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .hero-title {
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            font-weight: 400;
            opacity: 0.9;
        }
        
        .main-card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: -40px;
            background: white;
        }
        
        .form-section {
            padding: 40px;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }
        
        .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(76, 201, 240, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
        }
        
        .info-card {
            border-radius: 20px;
            border: none;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        
        .info-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .info-card .card-body {
            padding: 30px;
            text-align: center;
        }
        
        .info-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
        }
        
        .info-card:nth-child(1) .info-icon {
            background: rgba(76, 201, 240, 0.15);
            color: var(--accent-color);
        }
        
        .info-card:nth-child(2) .info-icon {
            background: rgba(72, 187, 120, 0.15);
            color: #48bb78;
        }
        
        .info-card:nth-child(3) .info-icon {
            background: rgba(246, 173, 85, 0.15);
            color: #f6ad55;
        }
        
        .info-card h5 {
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--secondary-color);
        }
        
        .info-card p {
            color: #6c757d;
            line-height: 1.6;
        }
        
        .footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 30px 0;
            margin-top: 80px;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .form-section {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="hero-title">Pendaftaran Siswa Baru</h1>
            <p class="hero-subtitle">Silakan pilih sesi dan jalur pendaftaran untuk melanjutkan</p>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Form Card -->
                <div class="card main-card">
                    <div class="form-section">
                        <form method="GET" action="{{ route('ppdb.create') }}">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Pilih Sesi PPDB</label>
                                    <select name="sesi" class="form-select form-select-lg" required>
                                        <option value="">-- Pilih Sesi --</option>
                                        @foreach($sesis as $sesi)
                                            <option value="{{ $sesi->id }}">{{ $sesi->tahun_ajaran }} - {{ $sesi->nama_sesi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pilih Jalur PPDB</label>
                                    <select name="jalur" class="form-select form-select-lg" required>
                                        <option value="">-- Pilih Jalur --</option>
                                        @foreach($jalurs as $jalur)
                                            <option value="{{ $jalur->id }}">{{ $jalur->nama_jalur }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-arrow-right me-2"></i> Lanjut ke Formulir Pendaftaran
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Info Cards -->
                <div class="row mt-5 g-4">
                    <div class="col-md-4">
                        <div class="card info-card">
                            <div class="card-body">
                                <div class="info-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h5>Persyaratan Pendaftaran</h5>
                                <p>Siapkan dokumen seperti KK, Akta Lahir, dan Ijazah/SKL untuk melengkapi pendaftaran.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card info-card">
                            <div class="card-body">
                                <div class="info-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <h5>Jadwal Pendaftaran</h5>
                                <p>Pantau terus jadwal pendaftaran untuk setiap sesi dan jalur yang tersedia.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card info-card">
                            <div class="card-body">
                                <div class="info-icon">
                                    <i class="fas fa-question-circle"></i>
                                </div>
                                <h5>Bantuan</h5>
                                <p>Hubungi admin sekolah jika mengalami kesulitan dalam proses pendaftaran.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} PPDB Online. All rights reserved.</p>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>