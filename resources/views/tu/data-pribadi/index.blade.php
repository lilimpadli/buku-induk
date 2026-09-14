@extends('layouts.app')

@section('title', 'Data Pribadi Saya')

@section('content')
<style>
:root{
    --primary:#2563EB;
    --primary-dark:#1D4ED8;
    --secondary:#7C3AED;
    --success:#10B981;
    --bg:#F4F7FE;
    --card:#FFFFFF;
    --text:#0F172A;
    --muted:#64748B;
    --border:#E2E8F0;
    --shadow-sm:0 2px 8px rgba(15,23,42,.06);
    --shadow-md:0 8px 24px rgba(15,23,42,.08);
    --radius:20px;
    --ease:cubic-bezier(0.4,0,0.2,1);
}

body{
    background:
        radial-gradient(circle at 0% 0%, rgba(37,99,235,.05) 0%, transparent 40%),
        radial-gradient(circle at 100% 100%, rgba(124,58,237,.05) 0%, transparent 40%),
        linear-gradient(180deg,#F8FAFF 0%,#F4F7FE 100%);
    min-height:100vh;
}

.container{max-width:1100px;}

/* ================= PROFILE CARD ================= */

.profile-card{
    background:white;
    border-radius:var(--radius);
    box-shadow:var(--shadow-md);
    overflow:hidden;
    margin-bottom:24px;
    animation:slideUp .5s var(--ease) both;
}

@keyframes slideUp{
    from{opacity:0;transform:translateY(16px);}
    to{opacity:1;transform:translateY(0);}
}

/* ================= HEADER KOMPAK ================= */
.profile-header{
    background:linear-gradient(135deg,#2563EB 0%,#4F46E5 50%,#7C3AED 100%);
    padding:20px 28px 18px;
    text-align:center;
    color:white;
    position:relative;
    overflow:hidden;
}

.profile-header::before{
    content:'';
    position:absolute;
    width:200px;
    height:200px;
    background:rgba(255,255,255,.05);
    border-radius:50%;
    top:-80px;
    right:-60px;
}

.profile-header::after{
    content:'';
    position:absolute;
    width:140px;
    height:140px;
    background:rgba(255,255,255,.04);
    border-radius:50%;
    bottom:-60px;
    left:-40px;
}

/* Avatar */
.profile-avatar{
    position:relative;
    z-index:2;
    width:85px;
    height:85px;
    margin:0 auto 10px;
    border-radius:50%;
    overflow:hidden;
    border:3px solid rgba(255,255,255,.3);
    box-shadow:0 8px 25px rgba(0,0,0,.2);
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
    font-size:32px;
    font-weight:700;
    background:rgba(255,255,255,.15);
    backdrop-filter:blur(8px);
    color:white;
}

/* Nama & Info */
.profile-name{
    position:relative;
    z-index:2;
    font-size:1.25rem;
    font-weight:700;
    margin-bottom:2px;
}

.profile-role{
    position:relative;
    z-index:2;
    font-size:.8rem;
    opacity:.85;
    margin-bottom:10px;
}

/* Statistik */
.profile-stats{
    position:relative;
    z-index:2;
    display:flex;
    justify-content:center;
    gap:10px;
    flex-wrap:wrap;
    margin-bottom:12px;
}

.stat-item{
    background:rgba(255,255,255,.1);
    backdrop-filter:blur(10px);
    padding:6px 16px;
    border-radius:999px;
    border:1px solid rgba(255,255,255,.12);
    font-size:.75rem;
}

.stat-item strong{
    font-weight:700;
    font-size:.85rem;
}

/* Tombol Edit */
.edit-btn{
    position:relative;
    z-index:2;
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:rgba(255,255,255,.15);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,.2);
    color:white;
    padding:7px 18px;
    border-radius:999px;
    font-size:.8rem;
    font-weight:600;
    text-decoration:none;
    transition:all .3s var(--ease);
}

.edit-btn:hover{
    background:rgba(255,255,255,.25);
    color:white;
    transform:translateY(-2px);
    box-shadow:0 8px 25px rgba(0,0,0,.15);
}

/* ================= INFO CARD ================= */

.info-card{
    background:white;
    border-radius:var(--radius);
    padding:20px 22px 18px;
    box-shadow:var(--shadow-sm);
    border:1px solid var(--border);
    transition:all .3s var(--ease);
    height:100%;
    min-height:200px;
}

.info-card:hover{
    box-shadow:var(--shadow-md);
    transform:translateY(-3px);
}

.info-card-title{
    font-size:.9rem;
    font-weight:700;
    color:var(--text);
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:16px;
    padding-bottom:10px;
    border-bottom:1px solid var(--border);
}

.info-card-title i{
    color:var(--primary);
    font-size:1rem;
}

.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
}

.info-item{
    background:#F8FAFC;
    border-radius:12px;
    padding:10px 14px;
    border:1px solid #EEF2FF;
    transition:all .2s var(--ease);
}

.info-item:hover{
    background:white;
    border-color:#DBEAFE;
}

.info-label{
    font-size:9px;
    text-transform:uppercase;
    letter-spacing:.05em;
    color:var(--muted);
    font-weight:600;
}

.info-value{
    font-size:.85rem;
    font-weight:600;
    color:var(--text);
    margin-top:2px;
}

/* ================= ADDRESS ================= */

.address-section{
    background:white;
    border-radius:var(--radius);
    padding:18px 22px;
    box-shadow:var(--shadow-sm);
    border:1px solid var(--border);
    transition:all .3s var(--ease);
}

.address-section:hover{
    box-shadow:var(--shadow-md);
    transform:translateY(-3px);
}

.address-title{
    font-size:.9rem;
    font-weight:700;
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:12px;
    padding-bottom:10px;
    border-bottom:1px solid var(--border);
}

.address-title i{
    color:var(--primary);
}

.address-content{
    background:#F8FAFC;
    border-radius:12px;
    padding:14px 18px;
    border-left:3px solid var(--primary);
    font-size:.85rem;
    color:var(--text);
    line-height:1.7;
}

/* ================= ALERT ================= */

.alert-custom{
    border:none;
    border-radius:14px;
    padding:12px 18px;
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:20px;
    border-left:4px solid;
    animation:slideUp .4s var(--ease) both;
}

.alert-success{
    background:#ECFDF5;
    color:#065F46;
    border-left-color:var(--success);
}

.alert-danger{
    background:#FEF2F2;
    color:#991B1B;
    border-left-color:#EF4444;
}

/* ================= MOBILE ================= */

@media(max-width:768px){
    .profile-header{padding:16px 18px 14px;}
    .profile-avatar{width:70px;height:70px;}
    .profile-name{font-size:1.05rem;}
    .info-grid{grid-template-columns:1fr;}
    .info-card{padding:16px;min-height:auto;}
    .address-section{padding:14px 16px;}
    .stat-item{font-size:.7rem;padding:4px 12px;}
}
</style>

<div class="container mt-4">

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert-custom alert-success">
            <i class="fas fa-check-circle"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-custom alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <!-- ================= PROFILE CARD ================= -->
    <div class="profile-card">

        <div class="profile-header">

            <!-- Avatar -->
            <div class="profile-avatar">
                @if(isset($user) && $user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil">
                @else
                    <div class="profile-avatar-placeholder">
                        {{ $guru && $guru->nama ? strtoupper(substr($guru->nama, 0, 1)) : strtoupper(substr($user->name ?? 'TU', 0, 1)) }}
                    </div>
                @endif
            </div>

            <!-- Nama -->
            <div class="profile-name">{{ optional($guru)->nama ?? $user->name ?? '-' }}</div>
            <div class="profile-role">
                <i class="fas fa-id-card"></i>
                NIP: {{ optional($guru)->nip ?: ($user->nomor_induk ?? '-') }}
            </div>

            <!-- Statistik -->
            <div class="profile-stats">
                <span class="stat-item">
                    <i class="fas fa-calendar-alt"></i>
                    <strong>{{ optional($guru)->tanggal_lahir ? \Carbon\Carbon::parse(optional($guru)->tanggal_lahir)->age : '-' }}</strong> Tahun
                </span>
                <span class="stat-item">
                    <i class="fas fa-venus-mars"></i>
                    <strong>{{ optional($guru)->jenis_kelamin == 'L' ? 'Laki-laki' : (optional($guru)->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</strong>
                </span>
            </div>

            <!-- Tombol Edit -->
            <a href="{{ route('tu.data-pribadi.edit') }}" class="edit-btn">
                <i class="fas fa-edit"></i> Edit Profil
            </a>

        </div>

    </div>

    <!-- ================= INFO GRID ================= -->
    <div class="row g-3">

        <!-- Informasi Pribadi -->
        <div class="col-md-6">
            <div class="info-card">
                <div class="info-card-title">
                    <i class="fas fa-user-circle"></i> Informasi Pribadi
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">{{ optional($guru)->nama ?? $user->name ?? '-' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">NIP</div>
                        <div class="info-value">{{ optional($guru)->nip ?: ($user->nomor_induk ?? '-') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ optional($guru)->email ?? $user->email ?? '-' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Telepon</div>
                        <div class="info-value">{{ optional($guru)->telepon ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Lainnya -->
        <div class="col-md-6">
            <div class="info-card">
                <div class="info-card-title">
                    <i class="fas fa-address-card"></i> Data Lainnya
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Tempat Lahir</div>
                        <div class="info-value">{{ optional($guru)->tempat_lahir ?? '-' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tanggal Lahir</div>
                        <div class="info-value">
                            {{ optional($guru)->tanggal_lahir ? \Carbon\Carbon::parse(optional($guru)->tanggal_lahir)->format('d F Y') : '-' }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Jenis Kelamin</div>
                        <div class="info-value">
                            {{ optional($guru)->jenis_kelamin == 'L' ? 'Laki-laki' : (optional($guru)->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Umur</div>
                        <div class="info-value">
                            {{ optional($guru)->tanggal_lahir ? \Carbon\Carbon::parse(optional($guru)->tanggal_lahir)->age . ' tahun' : '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ================= ALAMAT ================= -->
    <div class="address-section mt-3">
        <div class="address-title">
            <i class="fas fa-map-marker-alt"></i> Alamat Lengkap
        </div>
        <div class="address-content">
            {{ optional($guru)->alamat ?? '-' }}
        </div>
    </div>

</div>
@endsection