@extends('layouts.app')

@section('title', 'Data Pribadi Saya')

@section('content')
<style>
:root{
    --primary:#2563EB;
    --secondary:#7C3AED;
    --success:#10B981;

    --bg:#F4F7FE;
    --card:#FFFFFF;

    --text:#0F172A;
    --muted:#64748B;

    --shadow-sm:0 8px 24px rgba(15,23,42,.05);
    --shadow-md:0 14px 35px rgba(15,23,42,.08);
    --shadow-lg:0 25px 60px rgba(59,130,246,.15);

    --radius-xl:32px;
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

.container{
    max-width:1200px;
}

/* ================= PROFILE CARD ================= */

.profile-card{
    overflow:hidden;
    border:none;
    border-radius:32px;
    background:white;
    box-shadow:var(--shadow-sm);
    margin-bottom:30px;
}

.profile-header{
    position:relative;
    overflow:hidden;

    background:linear-gradient(
        135deg,
        #2563EB 0%,
        #4F46E5 50%,
        #7C3AED 100%
    );

    padding:45px;
    text-align:center;
    color:white;
}

.profile-header::before{
    content:'';
    position:absolute;
    width:320px;
    height:320px;
    border-radius:50%;
    background:rgba(255,255,255,.08);
    top:-120px;
    right:-80px;
}

.profile-header::after{
    content:'';
    position:absolute;
    width:220px;
    height:220px;
    border-radius:50%;
    background:rgba(255,255,255,.05);
    bottom:-90px;
    left:-70px;
}

.profile-avatar{
    position:relative;
    z-index:2;

    width:150px;
    height:150px;

    margin:auto;
    margin-bottom:20px;

    border-radius:50%;
    overflow:hidden;

    border:5px solid rgba(255,255,255,.3);

    box-shadow:
        0 15px 40px rgba(0,0,0,.15),
        0 0 40px rgba(255,255,255,.15);

    transition:.35s ease;
}

.profile-avatar:hover{
    transform:scale(1.05);
}

.profile-avatar img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.profile-avatar-placeholder{
    width:100%;
    height:100%;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:52px;
    font-weight:800;

    background:rgba(255,255,255,.15);
    backdrop-filter:blur(10px);
}

.profile-name{
    position:relative;
    z-index:2;

    font-size:2rem;
    font-weight:800;
    margin-bottom:8px;
}

.profile-info{
    position:relative;
    z-index:2;

    opacity:.9;
    margin-bottom:6px;
}

.profile-stats{
    position:relative;
    z-index:2;

    display:flex;
    justify-content:center;
    gap:20px;

    margin-top:25px;
    margin-bottom:25px;
}

.stat-item{
    background:rgba(255,255,255,.12);
    backdrop-filter:blur(12px);

    padding:14px 20px;
    border-radius:18px;

    min-width:130px;
}

.stat-value{
    display:block;
    font-size:1.4rem;
    font-weight:800;
}

.stat-label{
    font-size:.8rem;
    opacity:.85;
}

.edit-profile-btn{
    position:relative;
    z-index:2;

    display:inline-flex;
    align-items:center;
    gap:10px;

    border:none;
    border-radius:18px;

    padding:12px 22px;

    font-weight:600;
    text-decoration:none;

    color:white;

    background:rgba(255,255,255,.15);

    backdrop-filter:blur(12px);

    transition:.3s ease;
}

.edit-profile-btn:hover{
    color:white;
    transform:translateY(-3px);
    background:rgba(255,255,255,.22);
}

/* ================= INFO CARD ================= */

.info-card,
.address-section{
    background:white;

    border:none;
    border-radius:28px;

    padding:28px;

    box-shadow:var(--shadow-sm);

    transition:.35s ease;

    margin-bottom:24px;
}

.info-card:hover,
.address-section:hover{
    transform:translateY(-4px);
    box-shadow:var(--shadow-lg);
}

.info-card-title,
.address-title{
    font-size:1.15rem;
    font-weight:700;

    color:var(--text);

    display:flex;
    align-items:center;
    gap:12px;

    margin-bottom:20px;
}

.info-card-title::before,
.address-title::before{
    content:'';

    width:5px;
    height:24px;

    border-radius:999px;

    background:linear-gradient(
        180deg,
        #2563EB,
        #7C3AED
    );
}

/* ================= DETAIL ================= */

.detail-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:18px;
}

.detail-item{
    background:#F8FAFC;

    border:1px solid #EEF2FF;

    border-radius:18px;

    padding:18px;

    transition:.3s ease;
}

.detail-item:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(59,130,246,.08);
}

.detail-label{
    font-size:11px;
    text-transform:uppercase;
    letter-spacing:.08em;

    color:var(--muted);

    margin-bottom:6px;

    font-weight:700;
}

.detail-value{
    color:var(--text);
    font-weight:600;
}

/* ================= ADDRESS ================= */

.address-content{
    background:#F8FAFC;

    border-radius:20px;

    padding:20px;

    line-height:1.8;

    color:var(--text);
}

/* ================= ALERT ================= */

.alert{
    border:none;
    border-radius:18px;

    padding:18px 22px;

    box-shadow:var(--shadow-sm);
}

.alert-success{
    background:#ECFDF5;
    color:#065F46;
}

.alert-danger{
    background:#FEF2F2;
    color:#991B1B;
}

/* ================= MOBILE ================= */

@media(max-width:768px){

    .profile-header{
        padding:30px 20px;
    }

    .profile-avatar{
        width:120px;
        height:120px;
    }

    .profile-name{
        font-size:1.5rem;
    }

    .profile-stats{
        flex-direction:column;
        align-items:center;
    }

    .detail-grid{
        grid-template-columns:1fr;
    }

}
</style>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle alert-icon"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle alert-icon"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                @if(isset($user) && $user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil">
                @else
                    <div class="profile-avatar-placeholder">
                        {{ $guru && $guru->nama ? strtoupper(substr($guru->nama, 0, 1)) : 'TU' }}
                    </div>
                @endif
            </div>
            
            <h2 class="profile-name">{{ $guru->nama ?? '-' }}</h2>
            <p class="profile-info">NIP: {{ $guru->nip ?: ($user->nomor_induk ?? '-') }}</p>
            <p class="profile-info">{{ $user->username ?? '-' }}</p>
            
            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-value">{{ optional($guru)->tanggal_lahir ? \Carbon\Carbon::parse(optional($guru)->tanggal_lahir)->age : '-' }}</span>
                    <span class="stat-label">Tahun</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ optional($guru)->jenis_kelamin == 'L' ? 'Laki-laki' : (optional($guru)->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</span>
                    <span class="stat-label">Jenis Kelamin</span>
                </div>
            </div>
            
            <a href="{{ route('tu.data-pribadi.edit') }}" class="edit-profile-btn">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row">
        <div class="col-lg-6">
            <div class="info-card">
                <h3 class="info-card-title">Informasi Pribadi</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Nama</div>
                        <div class="detail-value">{{ $guru->nama ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">NIP</div>
                        <div class="detail-value">{{ $guru->nip ?: ($user->nomor_induk ?? '-') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">{{ $guru->email ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Telepon</div>
                        <div class="detail-value">{{ $guru->telepon ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="info-card">
                <h3 class="info-card-title">Data Lainnya</h3>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Tempat Lahir</div>
                        <div class="detail-value">{{ optional($guru)->tempat_lahir ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tanggal Lahir</div>
                        <div class="detail-value">{{ optional($guru)->tanggal_lahir ? \Carbon\Carbon::parse(optional($guru)->tanggal_lahir)->format('d F Y') : '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Jenis Kelamin</div>
                        <div class="detail-value">
                            {{ optional($guru)->jenis_kelamin == 'L' ? 'Laki-laki' : (optional($guru)->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Umur</div>
                        <div class="detail-value">{{ optional($guru)->tanggal_lahir ? \Carbon\Carbon::parse(optional($guru)->tanggal_lahir)->age . ' tahun' : '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Section -->
    <div class="address-section">
        <h3 class="address-title">
            <i class="fas fa-map-marker-alt"></i>
            Alamat Lengkap
        </h3>
        <div class="address-content">
            {{ optional($guru)->alamat ?? '-' }}
        </div>
    </div>
</div>
@endsection