{{-- resources/views/tu/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard Tata Usaha')

@section('content')

<style>
:root{
    --primary:#3B82F6;
    --secondary:#6366F1;
    --success:#10B981;
    --warning:#F59E0B;
    --danger:#EF4444;

    --bg:#F4F7FE;
    --card:#FFFFFF;

    --text:#0F172A;
    --muted:#64748B;

    --shadow-sm:0 8px 25px rgba(15,23,42,.05);
    --shadow-md:0 15px 40px rgba(15,23,42,.08);
    --shadow-lg:0 25px 60px rgba(59,130,246,.15);

    --radius-xl:30px;
    --radius-lg:24px;
}

body{
    font-family:'Poppins',sans-serif;
    background:linear-gradient(
        180deg,
        #F8FAFF 0%,
        #F4F7FE 100%
    );
}

/* ================= HEADER ================= */

.page-header{
    position:relative;
    overflow:hidden;

    background:linear-gradient(
        135deg,
        #2563EB 0%,
        #4F46E5 55%,
        #7C3AED 100%
    );

    border-radius:32px;
    padding:40px;
    margin-bottom:32px;

    color:white;
    box-shadow:var(--shadow-md);
}

.page-header::before{
    content:'';
    position:absolute;

    width:320px;
    height:320px;

    border-radius:50%;
    background:rgba(255,255,255,.08);

    top:-120px;
    right:-90px;
}

.page-header::after{
    content:'';
    position:absolute;

    width:250px;
    height:250px;

    border-radius:50%;
    background:rgba(255,255,255,.05);

    bottom:-130px;
    left:-80px;
}

.page-title{
    position:relative;
    z-index:2;

    font-size:2.2rem;
    font-weight:800;

    display:flex;
    align-items:center;
    gap:18px;

    margin-bottom:10px;
}

.page-title i{
    width:62px;
    height:62px;

    border-radius:20px;

    background:rgba(255,255,255,.15);
    backdrop-filter:blur(10px);

    display:flex;
    align-items:center;
    justify-content:center;
}

.page-subtitle{
    position:relative;
    z-index:2;

    margin:0;
    opacity:.92;
    font-size:15px;
}

/* ================= STATS ================= */

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:22px;
    margin-bottom:32px;
}

.stat-card{
    position:relative;
    overflow:hidden;

    border-radius:28px;
    padding:26px;

    color:white;

    transition:.35s ease;
    box-shadow:var(--shadow-sm);

    animation:floating 4s ease-in-out infinite;
}

.stat-card:hover{
    transform:translateY(-8px);
    box-shadow:var(--shadow-lg);
}

.stat-card::before{
    content:'';

    position:absolute;

    width:180px;
    height:180px;

    border-radius:50%;

    background:rgba(255,255,255,.12);

    top:-70px;
    right:-50px;
}

.stat-card::after{
    content:'';

    position:absolute;

    width:120px;
    height:120px;

    border-radius:50%;

    background:rgba(255,255,255,.08);

    bottom:-40px;
    right:20px;
}

.stat-card.primary{
    background:linear-gradient(
        135deg,
        #2563EB,
        #60A5FA
    );
}

.stat-card.success{
    background:linear-gradient(
        135deg,
        #059669,
        #34D399
    );
}

.stat-card.warning{
    background:linear-gradient(
        135deg,
        #D97706,
        #FBBF24
    );
}

.stat-card.danger{
    background:linear-gradient(
        135deg,
        #DC2626,
        #F87171
    );
}

.stat-icon{
    position:relative;
    z-index:2;

    width:65px;
    height:65px;

    border-radius:22px;

    background:rgba(255,255,255,.18);

    backdrop-filter:blur(8px);

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:1.5rem;

    margin-bottom:18px;
}

.stat-number{
    position:relative;
    z-index:2;

    font-size:2.3rem;
    font-weight:800;
}

.stat-label{
    position:relative;
    z-index:2;

    margin-top:8px;
    opacity:.95;
}

/* ================= DASHBOARD CARD ================= */

.dashboard-card{
    background:white;
    border-radius:32px;
    padding:32px;

    box-shadow:var(--shadow-sm);
    border:1px solid rgba(226,232,240,.6);
}

.card-header-modern{
    margin-bottom:26px;
}

.card-header-modern h3{
    font-size:1.4rem;
    font-weight:700;
    color:var(--text);
}

.card-header-modern p{
    margin-top:6px;
    color:var(--muted);
}

/* ================= MENU ================= */

.menu-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:20px;
}

.menu-item{
    position:relative;
    overflow:hidden;

    text-decoration:none;

    background:white;

    border:1px solid #E8EEF7;
    border-radius:24px;

    padding:24px;

    transition:.35s ease;

    color:var(--text);
}

.menu-item::before{
    content:'';

    position:absolute;

    inset:0;

    opacity:0;

    transition:.35s ease;

    background:linear-gradient(
        135deg,
        #2563EB,
        #7C3AED
    );
}

.menu-item:hover::before{
    opacity:1;
}

.menu-item>*{
    position:relative;
    z-index:2;
}

.menu-item i{
    width:60px;
    height:60px;

    border-radius:18px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#EFF6FF;
    color:#2563EB;

    font-size:1.4rem;

    margin-bottom:15px;
}

.menu-item h6{
    font-size:1rem;
    font-weight:700;
    margin-bottom:8px;
}

.menu-item span{
    color:var(--muted);
    font-size:.88rem;
    line-height:1.6;
}

.menu-item:hover{
    transform:translateY(-8px);
    box-shadow:var(--shadow-lg);
}

.menu-item:hover h6,
.menu-item:hover span,
.menu-item:hover i{
    color:white;
}

.menu-item:hover i{
    background:rgba(255,255,255,.15);
}

/* ================= FLOATING ================= */

@keyframes floating{

    0%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(-4px);
    }

    100%{
        transform:translateY(0);
    }

}

/* ================= MOBILE ================= */

@media(max-width:768px){

    .page-header{
        padding:28px;
    }

    .page-title{
        font-size:1.7rem;
    }

    .dashboard-card{
        padding:22px;
    }

    .menu-grid{
        grid-template-columns:1fr;
    }

}
</style>

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="page-header">

        <h1 class="page-title">
            <i class="fas fa-building"></i>
            Dashboard Tata Usaha
        </h1>

        <p class="page-subtitle">
            Selamat datang, <strong>{{ Auth::user()->name }}</strong>
        </p>

    </div>

    <!-- STATISTIK -->
    <div class="stats-grid">

        <div class="stat-card primary">
            <div class="stat-icon">
                <i class="fas fa-user-graduate"></i>
            </div>

            <div class="stat-number">
                {{ $totalSiswa ?? 0 }}
            </div>

            <div class="stat-label">
                Total Siswa
            </div>
        </div>

        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>

            <div class="stat-number">
                {{ $totalAdministrasi ?? 0 }}
            </div>

            <div class="stat-label">
                Administrasi
            </div>
        </div>

        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-random"></i>
            </div>

            <div class="stat-number">
                {{ $totalMutasi ?? 0 }}
            </div>

            <div class="stat-label">
                Mutasi
            </div>
        </div>

        <div class="stat-card danger">
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>

            <div class="stat-number">
                {{ $totalAlumni ?? 0 }}
            </div>

            <div class="stat-label">
                Alumni
            </div>
        </div>

    </div>

    <!-- MENU -->
    <div class="dashboard-card">

        <div class="card-header-modern">
            <h3>Menu Tata Usaha</h3>
            <p>Akses cepat ke seluruh fitur utama Tata Usaha</p>
        </div>

        <div class="menu-grid">

            <a href="{{ route('tu.siswa.index') }}" class="menu-item">
                <i class="fas fa-user-graduate"></i>
                <h6>Data Siswa</h6>
                <span>Kelola seluruh data siswa sekolah</span>
            </a>

            <a href="{{ route('tu.buku-induk.index') }}" class="menu-item">
                <i class="fas fa-book"></i>
                <h6>Administrasi</h6>
                <span>Kelola buku induk dan administrasi siswa</span>
            </a>

            <a href="{{ route('tu.mutasi.index') }}" class="menu-item">
                <i class="fas fa-random"></i>
                <h6>Mutasi</h6>
                <span>Kelola data mutasi masuk dan keluar</span>
            </a>

            <a href="{{ route('tu.alumni.index') }}" class="menu-item">
                <i class="fas fa-user-check"></i>
                <h6>Alumni</h6>
                <span>Kelola data alumni sekolah</span>
            </a>

        </div>

    </div>

</div>

@endsection