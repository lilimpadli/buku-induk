@extends('layouts.app')

@section('title', 'Detail Guru: ' . $guru->nama)

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
    .stagger-5 { animation-delay: .30s; }

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
        display: flex; align-items: center; gap: 7px;
        font-size: 11px; text-transform: uppercase; letter-spacing: 0.07em;
        color: var(--text-muted); font-weight: 700; margin-bottom: 7px;
    }
    .info-label i { color: var(--primary); font-size: 11px; }
    .info-value { font-size: 14px; color: var(--text-heading); font-weight: 600; word-break: break-word; }
    .info-empty { color: #CBD5E1; font-weight: 500; }
    .link-premium { color: var(--primary); text-decoration: none; font-weight: 600; }
    .link-premium:hover { text-decoration: underline; }

    /* ==========================================
       KOTAK TUGAS TAMBAHAN (GAYA AMBER)
       ========================================== */
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
        display: flex; align-items: center; gap: 7px;
        font-size: 11px; text-transform: uppercase; letter-spacing: 0.07em;
        color: #B45309; font-weight: 700; margin-bottom: 8px;
    }
    .tugas-label i { font-size: 11px; }
    .tugas-value {
        font-size: 15px;
        color: #92400E;
        font-weight: 700;
        word-break: break-word;
    }
    .tugas-sub {
        font-size: 12px;
        color: #B45309;
        opacity: .75;
        margin-top: 4px;
    }

    .empty-state { text-align: center; padding: 56px 24px; }
    .empty-state i { font-size: 44px; color: #CBD5E1; margin-bottom: 14px; }
    .empty-state h5 { font-weight: 700; color: var(--text-heading); }
    .empty-state p { color: var(--text-muted); font-size: 14px; }

    @media (max-width: 768px) {
        .app-container { padding: 16px; }
        .header-premium { flex-direction: column; align-items: flex-start; }
        .profile-banner, .section-body, .section-header { padding-left: 16px; padding-right: 16px; }
    }
</style>

{{-- ════════════════════════════════════════════════════════════
     PERSIAPAN DATA TUGAS TAMBAHAN
     Prioritas: tabel relasi tugas_tambahans.
     Fallback : kolom gurus.tugas_tambahan (hasil import Excel)
══════════════════════════════════════════════════════════════ --}}
@php
    $daftarTugas = collect();

    if (isset($tugasTambahan) && $tugasTambahan->count()) {
        $daftarTugas = $tugasTambahan;
    } elseif (!empty($guru->tugas_tambahan)) {
        // Buat item fallback dari kolom gurus.tugas_tambahan
        $daftarTugas = collect([
            (object) [
                'jabatan'  => $guru->tugas_tambahan,
                'nama_tugas' => $guru->tugas_tambahan,
                'instansi' => null,
                'mulai'    => null,
            ],
        ]);
    }
@endphp

<div class="app-container">

    {{-- HEADER --}}
    <div class="header-premium">
        <div class="header-title-wrap">
            <div class="header-icon"><i class="fas fa-chalkboard-user"></i></div>
            <div>
                <h1 class="header-title">Detail Guru</h1>
                <p class="header-subtitle">Informasi lengkap data diri dan kepegawaian guru</p>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('tu_kepegawaian.guru.index') }}" class="btn-premium btn-premium-ghost">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('tu_kepegawaian.guru.edit', $guru->id) }}" class="btn-premium btn-premium-primary">
                <i class="fas fa-edit"></i> Edit Data
            </a>
        </div>
    </div>

    @php
        $val = function ($v) { return ($v !== null && $v !== '') ? $v : '—'; };

        $statusColors = [
            'PNS' => 'badge-blue',
            'PPPK' => 'badge-cyan',
            'PPPK Paruh Waktu' => 'badge-cyan',
            'Non-ASN' => 'badge-yellow',
            'Guru Tetap Yayasan' => 'badge-green',
            'Guru Tidak Tetap' => 'badge-purple',
        ];
        $kepegawaianBadge = $statusColors[$guru->status_kepegawaian] ?? 'badge-gray';

        $statusAktifRaw = $guru->status_aktif ?? $guru->status_keaktifan ?? 'Aktif';
        $statusAktifKey = strtolower(trim($statusAktifRaw));
        $aktifBadge = 'badge-green'; $aktifIcon = 'fa-user-check';
        if (strpos($statusAktifKey, 'keluar') !== false || strpos($statusAktifKey, 'non') !== false) {
            $aktifBadge = 'badge-red'; $aktifIcon = 'fa-user-slash';
        } elseif (strpos($statusAktifKey, 'cuti') !== false) {
            $aktifBadge = 'badge-yellow'; $aktifIcon = 'fa-plane-departure';
        } elseif (strpos($statusAktifKey, 'mutasi') !== false) {
            $aktifBadge = 'badge-purple'; $aktifIcon = 'fa-exchange-alt';
        } elseif (strpos($statusAktifKey, 'pensiun') !== false) {
            $aktifBadge = 'badge-gray'; $aktifIcon = 'fa-chair';
        }

        $ttl = trim(($guru->tempat_lahir ?? '') . ($guru->tempat_lahir && $guru->tanggal_lahir ? ', ' : '') . ($guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->translatedFormat('d F Y') : ''));
    @endphp

    {{-- KARTU PROFIL --}}
    <div class="card-premium mb-4">
        <div class="profile-banner">
            <div class="avatar-premium">{{ strtoupper(substr($guru->nama, 0, 1)) }}</div>
            <div class="flex-grow-1">
                <h2 class="profile-name">{{ $guru->nama }}</h2>
                <div class="profile-meta">
                    <span><i class="fas fa-id-card text-primary"></i> NIP: {{ $val($guru->nip) }}</span>
                    <span><i class="fas fa-id-badge text-primary"></i> NUPTK: {{ $val($guru->nuptk) }}</span>
                    <span><i class="fas fa-graduation-cap text-primary"></i> {{ $val($guru->pendidikan) }}</span>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @if (!empty($guru->status_kepegawaian))
                        <span class="badge-pill {{ $kepegawaianBadge }}"><i class="fas fa-briefcase"></i> {{ $guru->status_kepegawaian }}</span>
                    @endif
                    <span class="badge-pill {{ $aktifBadge }}"><i class="fas {{ $aktifIcon }}"></i> {{ $statusAktifRaw }}</span>
                    @if (!empty($guru->serdik))
                        <span class="badge-pill badge-green"><i class="fas fa-certificate"></i> Tersertifikasi</span>
                    @else
                        <span class="badge-pill badge-gray"><i class="fas fa-certificate"></i> Belum Serdik</span>
                    @endif

                    {{-- TUGAS TAMBAHAN (badge ringkas di profil) --}}
                    @foreach ($daftarTugas as $t)
                        <span class="badge-pill badge-yellow">
                            <i class="fas fa-award"></i> {{ $t->jabatan ?? $t->nama_tugas ?? 'Tugas Tambahan' }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Identitas --}}
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-fingerprint"></i> NIK</span>
                        <div class="info-value">{{ $val($guru->nik) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-id-badge"></i> NUPTK</span>
                        <div class="info-value">{{ $val($guru->nuptk) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-hashtag"></i> NIP</span>
                        <div class="info-value">{{ $val($guru->nip) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-venus-mars"></i> Jenis Kelamin</span>
                        <div class="info-value">
                            @if ($guru->jenis_kelamin === 'L')
                                <span class="badge-pill badge-blue"><i class="fas fa-mars"></i> Laki-laki</span>
                            @elseif ($guru->jenis_kelamin === 'P')
                                <span class="badge-pill badge-red"><i class="fas fa-venus"></i> Perempuan</span>
                            @else
                                <span class="info-empty">—</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-cake-candles"></i> Tempat, Tanggal Lahir</span>
                        <div class="info-value">{{ $val($ttl) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-graduation-cap"></i> Pendidikan Terakhir</span>
                        <div class="info-value">{{ $val($guru->pendidikan) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KONTAK --}}
    <div class="card-premium mb-4 stagger-1">
        <div class="section-header">
            <div class="section-icon"><i class="fas fa-address-book"></i></div>
            <div>
                <h2 class="section-title">Informasi Kontak</h2>
                <p class="section-desc">Nomor telepon dan email yang dapat dihubungi</p>
            </div>
        </div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-phone-alt"></i> No. HP / WhatsApp</span>
                        <div class="info-value">
                            @if (!empty($guru->telepon) || !empty($guru->no_hp))
                                <a href="tel:{{ $guru->telepon ?? $guru->no_hp }}" class="link-premium">{{ $guru->telepon ?? $guru->no_hp }}</a>
                            @else
                                <span class="info-empty">—</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-envelope"></i> Email Pribadi</span>
                        <div class="info-value">
                            @if (!empty($guru->email_pribadi))
                                <a href="mailto:{{ $guru->email_pribadi }}" class="link-premium">{{ $guru->email_pribadi }}</a>
                            @else
                                <span class="info-empty">—</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-at"></i> Email Resmi / Sekolah</span>
                        <div class="info-value">
                            @if (!empty($guru->email_resmi))
                                <a href="mailto:{{ $guru->email_resmi }}" class="link-premium">{{ $guru->email_resmi }}</a>
                            @else
                                <span class="info-empty">—</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ALAMAT --}}
    <div class="card-premium mb-4 stagger-2">
        <div class="section-header">
            <div class="section-icon"><i class="fas fa-map-marked-alt"></i></div>
            <div>
                <h2 class="section-title">Alamat Domisili</h2>
                <p class="section-desc">Informasi domisili dan wilayah tempat tinggal</p>
            </div>
        </div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-12">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-road"></i> Alamat Jalan / Kampung</span>
                        <div class="info-value">{{ $val($guru->alamat_jalan) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-map-pin"></i> Dusun</span>
                        <div class="info-value">{{ $val($guru->dusun) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-home"></i> Desa / Kelurahan</span>
                        <div class="info-value">{{ $val($guru->desa) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-city"></i> Kecamatan</span>
                        <div class="info-value">{{ $val($guru->kecamatan) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-sort-numeric-down"></i> RT / RW</span>
                        <div class="info-value">RT {{ $val($guru->rt) }} / RW {{ $val($guru->rw) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-mail-bulk"></i> Kode Pos</span>
                        <div class="info-value">{{ $val($guru->kode_pos) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-certificate"></i> Serdik (Sertifikasi)</span>
                        <div class="info-value">
                            @if (!empty($guru->serdik))
                                <span class="badge-pill badge-green">Sudah</span>
                                <span class="ms-2" style="font-weight: 500; color: var(--text-muted); font-size: 13px;">{{ $guru->serdik }}</span>
                            @else
                                <span class="badge-pill badge-gray">Belum</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         TUGAS TAMBAHAN — GAYA KOTAK AMBER (SESUAI SCREENSHOT)
    ═══════════════════════════════════════════════════════════ --}}
    <div class="card-premium stagger-3">
        <div class="section-header">
            <div class="section-icon" style="background: #FEF3C7; color: #B45309;">
                <i class="fas fa-award"></i>
            </div>
            <div>
                <h2 class="section-title">Tugas Tambahan</h2>
                <p class="section-desc">Tugas tambahan yang diemban guru ini</p>
            </div>
            @if ($daftarTugas->count())
                <span class="badge-pill badge-yellow ms-auto">
                    <i class="fas fa-list"></i> {{ $daftarTugas->count() }} Tugas
                </span>
            @endif
        </div>

        @if ($daftarTugas->count())
            <div class="section-body">
                <div class="row g-3">
                    @foreach ($daftarTugas as $t)
                        @php
                            $namaTugas = $t->jabatan ?? $t->nama_tugas ?? $t->nama ?? '—';
                        @endphp
                        <div class="col-12">
                            <div class="tugas-box">
                                <span class="tugas-label">
                                    <i class="fas fa-award"></i> Tugas Tambahan
                                </span>
                                <div class="tugas-value">{{ $namaTugas }}</div>

                                {{-- Info tambahan kalau datanya ada (dari tabel relasi) --}}
                                @if (!empty($t->instansi) || !empty($t->mulai))
                                    <div class="tugas-sub">
                                        @if (!empty($t->instansi))
                                            <i class="fas fa-building me-1"></i>{{ $t->instansi }}
                                        @endif
                                        @if (!empty($t->mulai))
                                            &nbsp;·&nbsp;<i class="far fa-calendar me-1"></i>Sejak {{ \Carbon\Carbon::parse($t->mulai)->translatedFormat('d F Y') }}
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-clipboard-list d-block"></i>
                <h5>Belum ada tugas tambahan</h5>
                <p class="mb-0">Guru ini belum memiliki tugas tambahan yang tercatat.</p>
            </div>
        @endif
    </div>
</div>
@endsection