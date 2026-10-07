@extends('layouts.app')

@section('title', 'Detail Mutasi: ' . ($mutasi->nama_entitas ?? ''))

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    :root {
        --primary: #4F46E5;
        --primary-light: #EEF2FF;
        --primary-dark: #4338CA;
        --text-heading: #0F172A;
        --text-body: #334155;
        --text-muted: #94A3B8;
        --border: #E2E8F0;
        --shadow-card: 0 4px 20px -4px rgba(0, 0, 0, 0.06);
    }

    .app-container { max-width: 1440px; margin: 0 auto; padding: 28px 36px; }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }

    .card-premium {
        background: #fff;
        border-radius: 24px;
        border: 1px solid rgba(226, 232, 240, 0.5);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        animation: fadeUp .4s ease both;
    }
    .stagger-1 { animation-delay: .06s; } .stagger-2 { animation-delay: .12s; }
    .stagger-3 { animation-delay: .18s; } .stagger-4 { animation-delay: .24s; }

    .header-premium { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 28px; }
    .header-title-wrap { display: flex; align-items: center; gap: 16px; }
    .header-icon { width: 48px; height: 48px; background: var(--primary-light); color: var(--primary); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .header-title { font-size: 24px; font-weight: 800; letter-spacing: -0.03em; color: var(--text-heading); margin: 0 0 2px; }
    .header-subtitle { font-size: 14px; color: var(--text-muted); font-weight: 500; margin: 0; }

    .btn-premium { padding: 10px 22px; border-radius: 100px; font-weight: 600; font-size: 14px; transition: all .25s ease; display: inline-flex; align-items: center; gap: 8px; border: none; text-decoration: none; cursor: pointer; }
    .btn-premium-primary { background: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(79, 70, 229, .25); }
    .btn-premium-primary:hover { background: var(--primary-dark); color: #fff; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79, 70, 229, .35); }
    .btn-premium-ghost { background: #F1F5F9; color: var(--text-body); }
    .btn-premium-ghost:hover { background: #E2E8F0; color: var(--text-body); transform: translateY(-2px); }

    .profile-banner {
        display: flex; align-items: center; gap: 24px; flex-wrap: wrap;
        padding: 32px;
        background:
            radial-gradient(800px circle at 100% -200px, rgba(79, 70, 229, 0.14), transparent 60%),
            linear-gradient(135deg, #F8FAFC, #EEF2FF);
        border-bottom: 1px solid #F1F5F9;
    }
    .avatar-premium {
        width: 88px; height: 88px; flex-shrink: 0;
        background: linear-gradient(135deg, #818CF8, #4F46E5);
        color: #fff; font-size: 34px; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        border-radius: 28px;
        box-shadow: 0 10px 24px -6px rgba(79, 70, 229, 0.45);
    }
    .profile-name { font-size: 24px; font-weight: 800; letter-spacing: -0.02em; color: var(--text-heading); margin: 0; }
    .profile-meta { font-size: 13px; color: var(--text-muted); margin: 6px 0 12px; display: flex; flex-wrap: wrap; gap: 16px; }
    .profile-meta span { display: inline-flex; align-items: center; gap: 6px; }

    .badge-pill { display: inline-flex; align-items: center; gap: 6px; padding: 5px 14px; border-radius: 100px; font-size: 12px; font-weight: 600; }
    .badge-blue { background: #EEF2FF; color: #4F46E5; }
    .badge-cyan { background: #ECFEFF; color: #0891B2; }
    .badge-yellow { background: #FEF3C7; color: #B45309; }
    .badge-green { background: #D1FAE5; color: #047857; }
    .badge-gray { background: #F1F5F9; color: #475569; }
    .badge-purple { background: #F3E8FF; color: #7E22CE; }
    .badge-red { background: #FEF2F2; color: #DC2626; }
    .badge-orange { background: #FFF7ED; color: #C2410C; }

    .section-header { display: flex; align-items: center; gap: 14px; padding: 22px 28px; background: linear-gradient(135deg, #FAFBFC, #fff); border-bottom: 1px solid #F1F5F9; }
    .section-icon { width: 42px; height: 42px; flex-shrink: 0; background: var(--primary-light); color: var(--primary); border-radius: 12px; font-size: 16px; display: flex; align-items: center; justify-content: center; }
    .section-title { font-size: 16px; font-weight: 700; color: var(--text-heading); margin: 0; }
    .section-desc { font-size: 13px; color: var(--text-muted); margin: 2px 0 0; }
    .section-body { padding: 24px 28px; }

    .info-box {
        padding: 16px 18px;
        background-color: #FAFBFC;
        border: 1px solid #F1F5F9;
        border-radius: 14px;
        height: 100%;
        transition: all .2s ease;
    }
    .info-box:hover { background-color: #F1F5F9; border-color: var(--border); transform: translateY(-2px); }
    .info-label {
        display: block;
        font-size: 11px; text-transform: uppercase; letter-spacing: 0.07em;
        color: var(--text-muted); font-weight: 700; margin-bottom: 7px;
    }
    .info-value { font-size: 14px; color: var(--text-heading); font-weight: 600; word-break: break-word; }
    .info-empty { color: #CBD5E1; font-weight: 500; }
    .link-premium { color: var(--primary); text-decoration: none; font-weight: 600; }
    .link-premium:hover { text-decoration: underline; }

    .tugas-box {
        padding: 16px 20px;
        background-color: #FFFBEB;
        border: 1px solid #FDE68A;
        border-radius: 14px;
        height: 100%;
        transition: all .2s ease;
    }
    .tugas-box:hover {
        background-color: #FEF3C7;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px -6px rgba(245, 158, 11, 0.35);
    }
    .tugas-label {
        display: block;
        font-size: 11px; text-transform: uppercase; letter-spacing: 0.07em;
        color: #B45309; font-weight: 700; margin-bottom: 8px;
    }
    .tugas-value {
        font-size: 15px;
        color: #92400E;
        font-weight: 700;
        word-break: break-word;
    }

    .keterangan-box {
        padding: 16px 20px;
        background-color: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-left: 4px solid var(--primary);
        border-radius: 14px;
        height: 100%;
    }
    .keterangan-label {
        display: block;
        font-size: 11px; text-transform: uppercase; letter-spacing: 0.07em;
        color: var(--text-muted); font-weight: 700; margin-bottom: 8px;
    }
    .keterangan-value {
        font-size: 14px;
        color: var(--text-heading);
        font-weight: 500;
        line-height: 1.6;
        white-space: pre-line;
    }

    @media (max-width: 768px) {
        .app-container { padding: 16px; }
        .header-premium { flex-direction: column; align-items: flex-start; }
        .profile-banner, .section-body, .section-header { padding-left: 16px; padding-right: 16px; }
    }
</style>

@php
    $val = function ($v) { return ($v !== null && $v !== '') ? $v : '—'; };

    // Badge status kepegawaian
    $statusKey = strtolower(str_replace(' ', '-', $mutasi->status_kepegawaian ?? ''));
    $kepegawaianBadge = 'badge-gray';
    if ($statusKey == 'pns') $kepegawaianBadge = 'badge-blue';
    elseif ($statusKey == 'pppk' || $statusKey == 'pppk-paruh-waktu') $kepegawaianBadge = 'badge-cyan';
    elseif ($statusKey == 'non-asn') $kepegawaianBadge = 'badge-yellow';

    // Badge jenis mutasi
    $jenisKey = strtolower(trim($mutasi->jenis ?? ''));
    $jenisBadge = match ($jenisKey) {
        'masuk'             => 'badge-green',
        'keluar'            => 'badge-red',
        'pindah tugas'      => 'badge-orange',
        'pensiun'           => 'badge-gray',
        'wafat'             => 'badge-gray',
        'diberhentikan'     => 'badge-red',
        'alih tugas'        => 'badge-cyan',
        default             => 'badge-gray',
    };

    // Badge jenis kelamin
    $jkBadge = 'badge-gray';
    $jkLabel = '—';
    if ($mutasi->jenis_kelamin === 'L') { $jkBadge = 'badge-blue'; $jkLabel = 'Laki-laki'; }
    elseif ($mutasi->jenis_kelamin === 'P') { $jkBadge = 'badge-red'; $jkLabel = 'Perempuan'; }

    // TTL
    $ttl = trim(
        ($mutasi->tempat_lahir ?? '') .
        ($mutasi->tempat_lahir && $mutasi->tanggal_lahir ? ', ' : '') .
        ($mutasi->tanggal_lahir ? \Carbon\Carbon::parse($mutasi->tanggal_lahir)->translatedFormat('d F Y') : '')
    );

    // Tanggal mutasi
    $tanggalMutasi = $mutasi->tanggal
        ? \Carbon\Carbon::parse($mutasi->tanggal)->translatedFormat('d F Y')
        : null;
@endphp

<div class="app-container">

    {{-- HEADER --}}
    <div class="header-premium">
        <div class="header-title-wrap">
            <div class="header-icon"><i class="fas fa-exchange-alt"></i></div>
            <div>
                <h1 class="header-title">Detail Mutasi</h1>
                <p class="header-subtitle">Data lengkap {{ $mutasi->tipe_entitas ?? 'entitas' }} yang tercatat dalam mutasi</p>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('tu_kepegawaian.mutasi.index') }}" class="btn-premium btn-premium-ghost">
                <i class="fas fa-arrow-left"></i> Kembali ke Data Mutasi
            </a>
            <a href="{{ route('tu_kepegawaian.mutasi.edit', $mutasi->id) }}" class="btn-premium btn-premium-primary">
                Edit Mutasi
            </a>
        </div>
    </div>

    {{-- KARTU PROFIL --}}
    <div class="card-premium mb-4">
        <div class="profile-banner">
            <div class="avatar-premium">{{ strtoupper(substr($mutasi->nama_entitas ?? '?', 0, 1)) }}</div>
            <div class="flex-grow-1">
                <h2 class="profile-name">{{ $mutasi->nama_entitas ?? '—' }}</h2>
                <div class="profile-meta">
                    <span>NIP: {{ $val($mutasi->nip) }}</span>
                    <span>NUPTK: {{ $val($mutasi->nuptk) }}</span>
                    <span>{{ $val($mutasi->pendidikan) }}</span>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @if (!empty($mutasi->status_kepegawaian))
                        <span class="badge-pill {{ $kepegawaianBadge }}">{{ $mutasi->status_kepegawaian }}</span>
                    @endif
                    @if (!empty($mutasi->jenis))
                        <span class="badge-pill {{ $jenisBadge }}">{{ $mutasi->jenis }}</span>
                    @endif
                    @if (!empty($mutasi->tipe_entitas))
                        <span class="badge-pill badge-purple">{{ $mutasi->tipe_entitas }}</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Identitas --}}
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label">NIK</span>
                        <div class="info-value">{{ $val($mutasi->nik) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label">NUPTK</span>
                        <div class="info-value">{{ $val($mutasi->nuptk) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label">NIP</span>
                        <div class="info-value">{{ $val($mutasi->nip) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label">Jenis Kelamin</span>
                        <div class="info-value">
                            @if ($mutasi->jenis_kelamin === 'L' || $mutasi->jenis_kelamin === 'P')
                                <span class="badge-pill {{ $jkBadge }}">{{ $jkLabel }}</span>
                            @else
                                <span class="info-empty">—</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label">Tempat, Tanggal Lahir</span>
                        <div class="info-value">{{ $val($ttl) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label">Pendidikan Terakhir</span>
                        <div class="info-value">{{ $val($mutasi->pendidikan) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- INFORMASI MUTASI --}}
    <div class="card-premium mb-4 stagger-1">
        <div class="section-header">
            <div class="section-icon" style="background: #FEF3C7; color: #B45309;">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <h2 class="section-title">Informasi Mutasi</h2>
                <p class="section-desc">Detail jenis, tanggal, dan jabatan pada mutasi ini</p>
            </div>
        </div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="tugas-box">
                        <span class="tugas-label">Tipe Entitas</span>
                        <div class="tugas-value">{{ $val($mutasi->tipe_entitas) }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="tugas-box">
                        <span class="tugas-label">Jenis Mutasi</span>
                        <div class="tugas-value">{{ $val($mutasi->jenis) }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="tugas-box">
                        <span class="tugas-label">Tanggal Mutasi</span>
                        <div class="tugas-value">{{ $val($tanggalMutasi) }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="tugas-box">
                        <span class="tugas-label">Jabatan</span>
                        <div class="tugas-value">{{ $val($mutasi->jabatan) }}</div>
                    </div>
                </div>

                @if (!empty($mutasi->keterangan))
                    <div class="col-12">
                        <div class="keterangan-box">
                            <span class="keterangan-label">Keterangan</span>
                            <div class="keterangan-value">{{ $mutasi->keterangan }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- KONTAK --}}
    <div class="card-premium mb-4 stagger-2">
        <div class="section-header">
            <div class="section-icon"><i class="fas fa-address-book"></i></div>
            <div>
                <h2 class="section-title">Informasi Kontak</h2>
                <p class="section-desc">Nomor telepon dan email yang tercatat saat mutasi</p>
            </div>
        </div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label">No. HP / WhatsApp</span>
                        <div class="info-value">
                            @if (!empty($mutasi->telepon))
                                <a href="tel:{{ $mutasi->telepon }}" class="link-premium">{{ $mutasi->telepon }}</a>
                            @else
                                <span class="info-empty">—</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label">Email Pribadi</span>
                        <div class="info-value">
                            @if (!empty($mutasi->email_pribadi))
                                <a href="mailto:{{ $mutasi->email_pribadi }}" class="link-premium">{{ $mutasi->email_pribadi }}</a>
                            @elseif (!empty($mutasi->email))
                                <a href="mailto:{{ $mutasi->email }}" class="link-premium">{{ $mutasi->email }}</a>
                            @else
                                <span class="info-empty">—</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label">Email Resmi / Sekolah</span>
                        <div class="info-value">
                            @if (!empty($mutasi->email_resmi))
                                <a href="mailto:{{ $mutasi->email_resmi }}" class="link-premium">{{ $mutasi->email_resmi }}</a>
                            @else
                                <span class="info-empty">—</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ALAMAT (RAPI — 3 + 2 KOLOM) --}}
    <div class="card-premium mb-4 stagger-3">
        <div class="section-header">
            <div class="section-icon"><i class="fas fa-map-marked-alt"></i></div>
            <div>
                <h2 class="section-title">Alamat Domisili</h2>
                <p class="section-desc">Informasi domisili yang tercatat saat mutasi</p>
            </div>
        </div>
        <div class="section-body">
            <div class="row g-3">

                {{-- Baris 1: Alamat Jalan (full width) --}}
                <div class="col-12">
                    <div class="info-box">
                        <span class="info-label">Alamat Jalan / Kampung</span>
                        <div class="info-value">{{ $val($mutasi->alamat_jalan) }}</div>
                    </div>
                </div>

                {{-- Baris 2: RT/RW + Dusun + Kode Pos (3 kolom) --}}
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label">RT / RW</span>
                        <div class="info-value">RT {{ $val($mutasi->rt) }} / RW {{ $val($mutasi->rw) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label">Dusun</span>
                        <div class="info-value">{{ $val($mutasi->dusun) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label">Kode Pos</span>
                        <div class="info-value">{{ $val($mutasi->kode_pos) }}</div>
                    </div>
                </div>

                {{-- Baris 3: Desa + Kecamatan (2 kolom) --}}
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-label">Desa / Kelurahan</span>
                        <div class="info-value">{{ $val($mutasi->desa) }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-label">Kecamatan</span>
                        <div class="info-value">{{ $val($mutasi->kecamatan) }}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- TUGAS TAMBAHAN --}}
    @if (!empty($mutasi->tugas_tambahan))
        <div class="card-premium stagger-4">
            <div class="section-header">
                <div class="section-icon" style="background: #FEF3C7; color: #B45309;">
                    <i class="fas fa-award"></i>
                </div>
                <div>
                    <h2 class="section-title">Tugas Tambahan</h2>
                    <p class="section-desc">Tugas tambahan yang diemban saat mutasi</p>
                </div>
            </div>
            <div class="section-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="tugas-box">
                            <span class="tugas-label">Tugas Tambahan</span>
                            <div class="tugas-value">{{ $mutasi->tugas_tambahan }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection