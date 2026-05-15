@extends('layouts.app')

@section('title', 'Dashboard Tata Usaha')

@section('content')

<style>
    :root{
        --primary:#4F46E5;
        --primary-hover:#4338CA;
        --success:#10B981;
        --info:#0EA5E9;
        --warning:#F59E0B;

        --bg:#F8FAFC;
        --card:#FFFFFF;
        --text:#1E293B;
        --text-light:#64748B;

        --radius:18px;

        --shadow:
        0 4px 12px rgba(15,23,42,.05);

        --shadow-hover:
        0 10px 25px rgba(15,23,42,.08);
    }

    body{
        background:var(--bg);
        font-family:'Segoe UI',sans-serif;
        color:var(--text);
    }

    /* ================= HEADER ================= */

    .dashboard-header{
        background:linear-gradient(135deg,#4F46E5,#6366F1);
        border-radius:var(--radius);
        padding:28px;
        margin-bottom:24px;
        color:white;
        position:relative;
        overflow:hidden;
        box-shadow:var(--shadow);
    }

    .dashboard-header::before{
        content:'';
        position:absolute;
        width:250px;
        height:250px;
        border-radius:50%;
        background:rgba(255,255,255,.08);
        right:-80px;
        top:-80px;
    }

    .dashboard-header h2{
        font-size:30px;
        font-weight:700;
        margin-bottom:6px;
        position:relative;
        z-index:2;
    }

    .dashboard-header p{
        margin:0;
        color:rgba(255,255,255,.8);
        position:relative;
        z-index:2;
    }

    /* ================= CARD ================= */

    .dashboard-card{
        border:none;
        border-radius:var(--radius);
        background:var(--card);
        box-shadow:var(--shadow);
        transition:.3s;
        height:100%;
    }

    .dashboard-card:hover{
        transform:translateY(-4px);
        box-shadow:var(--shadow-hover);
    }

    .dashboard-card .card-body{
        padding:22px;
    }

    /* ================= STAT CARD ================= */

    .stat-card{
        position:relative;
        overflow:hidden;
    }

    .stat-icon{
        width:60px;
        height:60px;
        border-radius:16px;
        display:flex;
        align-items:center;
        justify-content:center;
        color:white;
        font-size:24px;
        flex-shrink:0;
    }

    .bg-primary-gradient{
        background:linear-gradient(135deg,#4F46E5,#6366F1);
    }

    .bg-success-gradient{
        background:linear-gradient(135deg,#10B981,#34D399);
    }

    .bg-info-gradient{
        background:linear-gradient(135deg,#0EA5E9,#38BDF8);
    }

    .bg-warning-gradient{
        background:linear-gradient(135deg,#F59E0B,#FBBF24);
    }

    .stat-title{
        color:var(--text-light);
        font-size:14px;
        margin-bottom:4px;
    }

    .stat-value{
        font-size:28px;
        font-weight:700;
        color:var(--text);
    }

    /* ================= BUTTON ================= */

    .btn-primary-custom{
        background:linear-gradient(135deg,#4F46E5,#6366F1);
        color:white;
        border:none;
        border-radius:12px;
        padding:10px 18px;
        font-weight:600;
        transition:.3s;
        text-decoration:none;
    }

    .btn-primary-custom:hover{
        transform:translateY(-2px);
        color:white;
    }

    .btn-outline-custom{
        border:1px solid #DDE3EC;
        border-radius:12px;
        padding:9px 16px;
        color:var(--text);
        background:white;
        font-weight:600;
        transition:.3s;
        text-decoration:none;
    }

    .btn-outline-custom:hover{
        background:#F8FAFC;
        color:var(--text);
    }

    /* ================= SECTION TITLE ================= */

    .section-title{
        font-size:20px;
        font-weight:700;
    }

    /* ================= SISWA ================= */

    .student-item{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:16px;
        padding:16px;
        border:1px solid #EEF2F7;
        border-radius:16px;
        margin-bottom:14px;
        transition:.3s;
    }

    .student-item:hover{
        background:#FAFBFF;
    }

    .student-left{
        display:flex;
        align-items:center;
        gap:14px;
    }

    .student-avatar{
        width:54px;
        height:54px;
        border-radius:50%;
        background:linear-gradient(135deg,#4F46E5,#6366F1);
        color:white;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:700;
        font-size:20px;
        overflow:hidden;
        flex-shrink:0;
    }

    .student-avatar img{
        width:100%;
        height:100%;
        object-fit:cover;
    }

    .student-name{
        font-weight:700;
        margin-bottom:3px;
    }

    .student-info{
        font-size:13px;
        color:var(--text-light);
    }

    /* ================= TABLE ================= */

    .table{
        margin-bottom:0;
    }

    .table thead th{
        background:#F8FAFC;
        border-bottom:1px solid #E5E7EB;
        font-size:14px;
        font-weight:700;
        color:var(--text);
        padding:14px;
    }

    .table tbody td{
        padding:14px;
        vertical-align:middle;
        border-bottom:1px solid #F1F5F9;
        font-size:14px;
    }

    .table tbody tr:hover{
        background:#FAFBFF;
    }

    /* ================= QUICK ACTION ================= */

    .quick-btn{
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        padding:16px;
        border-radius:16px;
        font-weight:600;
        text-decoration:none;
        transition:.3s;
        border:none;
    }

    .quick-btn:hover{
        transform:translateY(-3px);
    }

    /* ================= EMPTY ================= */

    .empty-state{
        text-align:center;
        padding:40px 20px;
        color:var(--text-light);
    }

    .empty-state i{
        font-size:42px;
        margin-bottom:14px;
    }

    /* ================= RESPONSIVE ================= */

    @media(max-width:768px){

        .dashboard-header{
            padding:22px;
        }

        .dashboard-header h2{
            font-size:24px;
        }

        .student-item{
            flex-direction:column;
            align-items:flex-start;
        }

        .quick-btn{
            font-size:14px;
        }

        .stat-value{
            font-size:24px;
        }
    }
</style>

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="dashboard-header">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h2>Dashboard TU Kesiswaan 👋</h2>

                <p>
                    Kelola data siswa, wali kelas, dan kelas dengan lebih cepat dan rapi
                </p>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="btn btn-outline-light">
                    Logout
                </button>
            </form>

        </div>

    </div>

    <!-- STATISTIK -->
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card dashboard-card stat-card">

                <div class="card-body">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon bg-primary-gradient">
                            <i class="fas fa-users"></i>
                        </div>

                        <div>
                            <div class="stat-title">Total Siswa</div>

                            <div class="stat-value">
                                {{ number_format($totalSiswa ?? 0) }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card dashboard-card stat-card">

                <div class="card-body">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon bg-success-gradient">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>

                        <div>
                            <div class="stat-title">Wali Kelas</div>

                            <div class="stat-value">
                                {{ number_format($totalWaliKelas ?? 0) }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card dashboard-card stat-card">

                <div class="card-body">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon bg-info-gradient">
                            <i class="fas fa-school"></i>
                        </div>

                        <div>
                            <div class="stat-title">Total Kelas</div>

                            <div class="stat-value">
                                {{ number_format($totalKelas ?? 0) }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card dashboard-card stat-card">

                <div class="card-body">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon bg-warning-gradient">
                            <i class="fas fa-chart-line"></i>
                        </div>

                        <div>
                            <div class="stat-title">Nilai Terinput</div>

                            <div class="stat-value">
                                {{ number_format($totalNilai ?? 0) }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- CONTENT -->
    <div class="row g-4">

        <!-- SISWA TERBARU -->
        <div class="col-xl-6">

            <div class="card dashboard-card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div class="section-title">
                            Siswa Terbaru
                        </div>

                        <a href="{{ route('tu.siswa.index') }}"
                        class="btn-outline-custom">
                            Lihat Semua
                        </a>

                    </div>

                    @if(!empty($siswaBaru) && $siswaBaru->count() > 0)

                        @foreach($siswaBaru as $siswa)

                            <div class="student-item">

                                <div class="student-left">

                                    @if($siswa->foto)

                                        <div class="student-avatar">
                                            <img src="{{ asset('storage/' . $siswa->foto) }}">
                                        </div>

                                    @else

                                        <div class="student-avatar">
                                            {{ strtoupper(substr($siswa->nama_lengkap,0,1)) }}
                                        </div>

                                    @endif

                                    <div>

                                        <div class="student-name">
                                            {{ $siswa->nama_lengkap }}
                                        </div>

                                        <div class="student-info">
                                            NIS : {{ $siswa->nis ?? '-' }}
                                            •
                                            {{ $siswa->kelas ?? '-' }}
                                        </div>

                                    </div>

                                </div>

                                <a href="{{ route('tu.siswa.detail', $siswa->id) }}"
                                class="btn-primary-custom">
                                    Detail
                                </a>

                            </div>

                        @endforeach

                    @else

                        <div class="empty-state">
                            <i class="fas fa-user-graduate"></i>
                            <p>Belum ada siswa terbaru.</p>
                        </div>

                    @endif

                </div>

            </div>

        </div>

        <!-- RINGKASAN KELAS -->
        <div class="col-xl-6">

            <div class="card dashboard-card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div class="section-title">
                            Ringkasan Kelas
                        </div>

                        <a href="{{ route('tu.kelas.index') }}"
                        class="btn-outline-custom">
                            Lihat Semua
                        </a>

                    </div>

                    @if(!empty($kelasLimit) && $kelasLimit->count() > 0)

                        <div class="table-responsive">

                            <table class="table">

                                <thead>
                                    <tr>
                                        <th>Tingkat</th>
                                        <th>Jurusan</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($kelasLimit as $k)

                                        <tr>
                                            <td>{{ $k->tingkat }}</td>
                                            <td>{{ $k->jurusan->nama ?? '-' }}</td>
                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="empty-state">
                            <i class="fas fa-school"></i>
                            <p>Belum ada data kelas.</p>
                        </div>

                    @endif

                </div>

            </div>

        </div>

        <!-- RINGKASAN WALI KELAS -->
        <div class="col-12">

            <div class="card dashboard-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div class="section-title">
                            Ringkasan Wali Kelas
                        </div>

                        <a href="{{ route('tu.wali-kelas') }}"
                        class="btn-outline-custom">
                            Lihat Semua
                        </a>

                    </div>

                    @if(!empty($waliKelasLimit) && $waliKelasLimit->count() > 0)

                        <div class="table-responsive">

                            <table class="table">

                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Nomor Induk</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($waliKelasLimit as $wk)

                                        <tr>
                                            <td>{{ $wk->name }}</td>
                                            <td>{{ $wk->nomor_induk }}</td>
                                            <td>{{ $wk->email }}</td>
                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="empty-state">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <p>Belum ada data wali kelas.</p>
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

    <!-- QUICK ACTION -->
    <div class="row mt-4">

        <div class="col-12">

            <div class="card dashboard-card">

                <div class="card-body">

                    <div class="section-title mb-4">
                        Aksi Cepat
                    </div>

                    <div class="row g-3">

                        <div class="col-lg-4 col-md-6">

                            <a href="{{ route('tu.siswa.index') }}"
                            class="quick-btn btn btn-outline-primary w-100">

                                <i class="fas fa-users"></i>
                                Kelola Siswa

                            </a>

                        </div>

                        <div class="col-lg-4 col-md-6">

                            <a href="{{ route('tu.kelas.index') }}"
                            class="quick-btn btn btn-outline-info w-100">

                                <i class="fas fa-school"></i>
                                Kelola Kelas

                            </a>

                        </div>

                        <div class="col-lg-4 col-md-12">

                            <a href="{{ route('tu.wali-kelas') }}"
                            class="quick-btn btn btn-outline-success w-100">

                                <i class="fas fa-chalkboard-teacher"></i>
                                Kelola Wali Kelas

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection