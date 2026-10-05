@extends('layouts.app')

@section('title', 'Tambah Data Pegawai / TU')

@section('content')
<style>
    /* ===== PREMIUM DESIGN 2.0 — FORM ===== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    :root {
        --primary: #4F46E5;
        --primary-light: #EEF2FF;
        --primary-dark: #4338CA;
        --success: #10B981;
        --danger: #EF4444;
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
    .stagger-1 { animation-delay: .06s; }
    .stagger-2 { animation-delay: .12s; }
    .stagger-3 { animation-delay: .18s; }
    .stagger-4 { animation-delay: .24s; }
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

    .alert-premium { display: flex; align-items: flex-start; gap: 14px; background-color: #FEF2F2; border: 1px solid #FECACA; border-radius: 16px; padding: 18px 22px; margin-bottom: 24px; animation: fadeUp .4s ease both; }
    .alert-premium > i { color: var(--danger); font-size: 20px; margin-top: 2px; }

    .section-header { display: flex; align-items: center; gap: 14px; padding: 22px 28px; background: linear-gradient(135deg, #FAFBFC, #fff); border-bottom: 1px solid #F1F5F9; }
    .section-icon { width: 42px; height: 42px; flex-shrink: 0; background: var(--primary-light); color: var(--primary); border-radius: 12px; font-size: 16px; display: flex; align-items: center; justify-content: center; }
    .section-icon-success { background: #D1FAE5; color: #047857; }
    .section-icon-warning { background: #FEF3C7; color: #B45309; }
    .section-icon-info { background: #E0F2FE; color: #0369A1; }
    .section-title { font-size: 16px; font-weight: 700; color: var(--text-heading); margin: 0; }
    .section-desc { font-size: 13px; color: var(--text-muted); margin: 2px 0 0; }
    .section-body { padding: 24px 28px; }

    .form-label-premium { display: flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 600; color: var(--text-body); margin-bottom: 8px; }
    .form-label-premium i { color: var(--primary); font-size: 12px; }
    .required-star { color: var(--danger); }

    .form-control-premium, .form-select-premium {
        width: 100%; padding: 12px 16px;
        background-color: #FAFBFC;
        border: 1px solid var(--border);
        border-radius: 12px; font-size: 14px; color: var(--text-heading);
        transition: border-color .2s, box-shadow .2s, background-color .2s;
        outline: none; font-family: inherit;
    }
    .form-select-premium {
        appearance: none; -webkit-appearance: none;
        padding-right: 42px; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='7' viewBox='0 0 12 7'%3E%3Cpath fill='none' stroke='%2394A3B8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
    }
    .form-control-premium:focus, .form-select-premium:focus { background-color: #fff; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(79, 70, 229, .06); }
    .form-control-premium::placeholder { color: #CBD5E1; }
    textarea.form-control-premium { resize: vertical; min-height: 76px; }
    .form-control-premium.is-invalid-premium, .form-select-premium.is-invalid-premium { border-color: var(--danger); background-color: #FEF2F2; }
    .field-error { display: flex; align-items: center; gap: 5px; color: var(--danger); font-size: 12px; font-weight: 500; margin-top: 6px; }
    .form-hint { font-size: 12px; color: var(--text-muted); margin-top: 6px; display: flex; align-items: center; gap: 5px; }

    /* Info box */
    .info-box { display: flex; align-items: flex-start; gap: 12px; background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 12px; padding: 14px 16px; margin-bottom: 20px; }
    .info-box i { color: #2563EB; font-size: 16px; margin-top: 2px; flex-shrink: 0; }
    .info-box-text { font-size: 13px; color: #1E40AF; line-height: 1.5; }
    .info-box-text strong { color: #1E3A8A; }

    .form-footer { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; padding: 20px 28px; background-color: #FAFBFC; border-top: 1px solid #F1F5F9; }
    .form-footer-note { font-size: 13px; color: var(--text-muted); display: inline-flex; align-items: center; gap: 7px; }

    @media (max-width: 768px) {
        .app-container { padding: 16px; }
        .header-premium { flex-direction: column; align-items: flex-start; }
        .section-header, .section-body, .form-footer { padding-left: 16px; padding-right: 16px; }
        .form-footer { flex-direction: column-reverse; align-items: stretch; }
        .btn-group-action { flex-direction: column; }
        .form-footer .btn-premium { justify-content: center; width: 100%; }
    }
</style>

<div class="app-container">

    {{-- HEADER --}}
    <div class="header-premium">
        <div class="header-title-wrap">
            <div class="header-icon"><i class="fas fa-user-plus"></i></div>
            <div>
                <h1 class="header-title">Tambah Data Pegawai / TU</h1>
                <p class="header-subtitle">Formulir penambahan data kepegawaian tenaga usaha</p>
            </div>
        </div>
        <a href="{{ route('tu_kepegawaian.tu.index') }}" class="btn-premium btn-premium-ghost">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- ALERT ERROR --}}
    @if ($errors->any())
        <div class="alert-premium">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <div class="fw-bold" style="color: #B91C1C;">Terdapat beberapa kesalahan input:</div>
                <ul class="mb-0 mt-2 ps-3" style="font-size: 13px; color: #DC2626;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('tu_kepegawaian.tu.store') }}" method="POST">
        @csrf

        @php
            $statusKepegawaianOptions = ['PNS', 'PPPK', 'PPPK Paruh Waktu', 'Honorer', 'Guru Tetap Yayasan', 'Guru Tidak Tetap'];
            $pendidikanOptions        = ['S3', 'S2', 'S1', 'D4', 'D3'];
        @endphp

        {{-- INFO BOX --}}
        <div class="card-premium mb-4">
            <div class="section-body">
                <div class="info-box" style="margin-bottom: 0;">
                    <i class="fas fa-info-circle"></i>
                    <div class="info-box-text">
                        <strong>Informasi:</strong> Form ini <b>hanya menyimpan data pegawai</b> ke database. Tidak ada akun login yang dibuat otomatis. Untuk pegawai yang membutuhkan akses sistem (misal TU Kepegawaian), silakan atur melalui menu <b>Super Admin → Users</b>.
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 1: IDENTITAS PEGAWAI ===== --}}
        <div class="card-premium mb-4">
            <div class="section-header">
                <div class="section-icon section-icon-info"><i class="fas fa-id-card"></i></div>
                <div>
                    <h2 class="section-title">Identitas Pegawai</h2>
                    <p class="section-desc">Data diri dan nomor identitas resmi pegawai</p>
                </div>
            </div>
            <div class="section-body">
                <div class="row g-4">
                    <div class="col-md-8">
                        <label class="form-label-premium"><i class="fas fa-user"></i> Nama Lengkap <span class="required-star">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control-premium @error('nama') is-invalid-premium @enderror" placeholder="Nama lengkap pegawai" required>
                        @error('nama')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium"><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select-premium @error('jenis_kelamin') is-invalid-premium @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium"><i class="fas fa-fingerprint"></i> NIK</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" inputmode="numeric" class="form-control-premium @error('nik') is-invalid-premium @enderror" placeholder="16 digit angka">
                        @error('nik')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium"><i class="fas fa-id-badge"></i> NUPTK</label>
                        <input type="text" name="nuptk" value="{{ old('nuptk') }}" class="form-control-premium @error('nuptk') is-invalid-premium @enderror" placeholder="Nomor Unik PTK">
                        @error('nuptk')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium"><i class="fas fa-hashtag"></i> NIP</label>
                        <input type="text" name="nip" value="{{ old('nip') }}" class="form-control-premium @error('nip') is-invalid-premium @enderror" placeholder="Nomor Induk Pegawai">
                        @error('nip')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-premium"><i class="fas fa-map-marker-alt"></i> Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-control-premium @error('tempat_lahir') is-invalid-premium @enderror" placeholder="Kota / Kabupaten kelahiran">
                        @error('tempat_lahir')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-premium"><i class="fas fa-calendar-alt"></i> Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control-premium @error('tanggal_lahir') is-invalid-premium @enderror">
                        @error('tanggal_lahir')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 2: KEPEGAWAIAN ===== --}}
        <div class="card-premium mb-4 stagger-1">
            <div class="section-header">
                <div class="section-icon section-icon-warning"><i class="fas fa-briefcase"></i></div>
                <div>
                    <h2 class="section-title">Kepegawaian & Kualifikasi</h2>
                    <p class="section-desc">Status kepegawaian, kualifikasi akademik, dan tugas tambahan</p>
                </div>
            </div>
            <div class="section-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label-premium"><i class="fas fa-building-user"></i> Status Kepegawaian</label>
                        <select name="status_kepegawaian" class="form-select-premium @error('status_kepegawaian') is-invalid-premium @enderror">
                            <option value="">-- Pilih Status Kepegawaian --</option>
                            @foreach ($statusKepegawaianOptions as $opt)
                                <option value="{{ $opt }}" {{ old('status_kepegawaian') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('status_kepegawaian')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-premium"><i class="fas fa-graduation-cap"></i> Pendidikan Terakhir</label>
                        <select name="pendidikan" class="form-select-premium @error('pendidikan') is-invalid-premium @enderror">
                            <option value="">-- Pilih Pendidikan --</option>
                            @foreach ($pendidikanOptions as $opt)
                                <option value="{{ $opt }}" {{ old('pendidikan') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('pendidikan')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label-premium"><i class="fas fa-tasks"></i> Tugas Tambahan</label>
                        <input type="text" name="tugas_tambahan" value="{{ old('tugas_tambahan') }}" class="form-control-premium @error('tugas_tambahan') is-invalid-premium @enderror" placeholder="Contoh: Bendahara Sekolah / Staf Perpustakaan">
                        @error('tugas_tambahan')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                        <div class="form-hint"><i class="fas fa-circle-info"></i> Kosongkan jika tidak ada tugas tambahan.</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 3: KONTAK ===== --}}
        <div class="card-premium mb-4 stagger-2">
            <div class="section-header">
                <div class="section-icon section-icon-success"><i class="fas fa-address-book"></i></div>
                <div>
                    <h2 class="section-title">Informasi Kontak</h2>
                    <p class="section-desc">Nomor telepon dan alamat email yang dapat dihubungi</p>
                </div>
            </div>
            <div class="section-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label-premium"><i class="fas fa-phone-alt"></i> No. HP / WhatsApp</label>
                        <input type="tel" name="no_hp" value="{{ old('no_hp') }}" class="form-control-premium @error('no_hp') is-invalid-premium @enderror" placeholder="081234567890">
                        @error('no_hp')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium"><i class="fas fa-envelope"></i> Email Pribadi</label>
                        <input type="email" name="email_pribadi" value="{{ old('email_pribadi') }}" class="form-control-premium @error('email_pribadi') is-invalid-premium @enderror" placeholder="nama@gmail.com">
                        @error('email_pribadi')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium"><i class="fas fa-at"></i> Email Resmi / Sekolah</label>
                        <input type="email" name="email_resmi" value="{{ old('email_resmi') }}" class="form-control-premium @error('email_resmi') is-invalid-premium @enderror" placeholder="nama@sekolah.sch.id">
                        @error('email_resmi')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== SECTION 4: ALAMAT ===== --}}
        <div class="card-premium mb-4 stagger-3">
            <div class="section-header">
                <div class="section-icon"><i class="fas fa-map-marked-alt"></i></div>
                <div>
                    <h2 class="section-title">Alamat Domisili</h2>
                    <p class="section-desc">Informasi domisili dan wilayah tempat tinggal saat ini</p>
                </div>
            </div>
            <div class="section-body">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label-premium"><i class="fas fa-road"></i> Alamat Jalan / Kampung</label>
                        <textarea name="alamat" rows="2" class="form-control-premium @error('alamat') is-invalid-premium @enderror" placeholder="Nama jalan, nomor rumah, dsb...">{{ old('alamat') }}</textarea>
                        @error('alamat')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium"><i class="fas fa-map-pin"></i> Dusun</label>
                        <input type="text" name="dusun" value="{{ old('dusun') }}" class="form-control-premium @error('dusun') is-invalid-premium @enderror" placeholder="Nama dusun">
                        @error('dusun')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium"><i class="fas fa-home"></i> Desa / Kelurahan</label>
                        <input type="text" name="desa" value="{{ old('desa') }}" class="form-control-premium @error('desa') is-invalid-premium @enderror" placeholder="Nama desa / kelurahan">
                        @error('desa')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium"><i class="fas fa-city"></i> Kecamatan</label>
                        <input type="text" name="kecamatan" value="{{ old('kecamatan') }}" class="form-control-premium @error('kecamatan') is-invalid-premium @enderror" placeholder="Nama kecamatan">
                        @error('kecamatan')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium"><i class="fas fa-sort-numeric-down"></i> RT</label>
                        <input type="text" name="rt" value="{{ old('rt') }}" class="form-control-premium @error('rt') is-invalid-premium @enderror" placeholder="001">
                        @error('rt')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium"><i class="fas fa-sort-numeric-down-alt"></i> RW</label>
                        <input type="text" name="rw" value="{{ old('rw') }}" class="form-control-premium @error('rw') is-invalid-premium @enderror" placeholder="002">
                        @error('rw')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium"><i class="fas fa-mail-bulk"></i> Kode Pos</label>
                        <input type="text" name="kode_pos" value="{{ old('kode_pos') }}" maxlength="5" inputmode="numeric" class="form-control-premium @error('kode_pos') is-invalid-premium @enderror" placeholder="12345">
                        @error('kode_pos')<div class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== FOOTER ===== --}}
        <div class="card-premium stagger-4">
            <div class="form-footer">
                <div class="form-footer-note">
                    <i class="fas fa-info-circle text-primary"></i>
                    Kolom bertanda <span class="required-star">*</span> wajib diisi.
                </div>
                <div class="d-flex gap-2 btn-group-action">
                    <a href="{{ route('tu_kepegawaian.tu.index') }}" class="btn-premium btn-premium-ghost">Batal</a>
                    <button type="submit" class="btn-premium btn-premium-primary">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection