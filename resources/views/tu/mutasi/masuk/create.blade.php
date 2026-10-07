@extends('layouts.app')

@section('title', 'Tambah Siswa Pindahan')

@section('content')

<style>
:root{
    --primary:#4F46E5;
    --primary-light:#6366F1;
    --secondary:#7C3AED;

    --success:#10B981;
    --warning:#F59E0B;
    --danger:#EF4444;

    --bg:#F4F7FE;
    --card:#FFFFFF;
    --border:#E5E7EB;

    --text:#111827;
    --text-light:#6B7280;

    --shadow-sm:0 2px 8px rgba(15,23,42,.05);
    --shadow-md:0 10px 25px rgba(15,23,42,.08);
    --shadow-lg:0 20px 40px rgba(15,23,42,.12);

    --radius:22px;
    --transition:all .25s ease;
}

body{
    background:
        radial-gradient(circle at top right, rgba(16,185,129,.10), transparent 20%),
        radial-gradient(circle at bottom left, rgba(5,150,105,.10), transparent 25%),
        linear-gradient(180deg,#f8faff 0%,#eef2ff 100%);
}

/* ================= PAGE HEADER ================= */

.page-header{
    background:linear-gradient(135deg,#10B981,#059669);
    border-radius:28px;
    padding:34px;
    margin-bottom:28px;
    position:relative;
    overflow:hidden;
    box-shadow:var(--shadow-lg);
}

.page-header::before{
    content:'';
    position:absolute;
    right:-80px;
    top:-80px;
    width:240px;
    height:240px;
    background:rgba(255,255,255,.08);
    border-radius:50%;
}

.page-header::after{
    content:'';
    position:absolute;
    left:-50px;
    bottom:-50px;
    width:180px;
    height:180px;
    background:rgba(255,255,255,.06);
    border-radius:50%;
}

.header-content{
    position:relative;
    z-index:2;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    flex-wrap:wrap;
}

.page-title{
    color:white;
    font-size:34px;
    font-weight:800;
    margin:0;
}

.page-subtitle{
    color:rgba(255,255,255,.85);
    margin-top:8px;
    font-size:14px;
}

/* ================= BUTTON ================= */

.btn-modern{
    border:none;
    border-radius:16px;
    padding:13px 22px;
    font-weight:700;
    transition:var(--transition);
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    cursor:pointer;
}

.btn-modern:hover{
    transform:translateY(-2px);
}

.btn-back{
    background:rgba(255,255,255,.14);
    color:white;
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,.2);
}

.btn-back:hover{
    background:white;
    color:#059669;
}

.btn-save{
    background:linear-gradient(135deg,#10B981,#059669);
    color:white;
    box-shadow:0 10px 24px rgba(16,185,129,.24);
}

.btn-save:hover{
    box-shadow:0 14px 28px rgba(16,185,129,.35);
    color:white;
}

.btn-cancel{
    background:#fff;
    color:var(--text);
    border:1px solid #dbe3ff;
}

.btn-cancel:hover{
    background:#f8faff;
}

/* ================= CARD ================= */

.form-card{
    background:rgba(255,255,255,.92);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,.8);
    border-radius:28px;
    overflow:hidden;
    box-shadow:var(--shadow-md);
    margin-bottom:24px;
}

.form-header{
    padding:28px 30px;
    border-bottom:1px solid #eef2ff;
    background:linear-gradient(135deg,rgba(16,185,129,.05),rgba(5,150,105,.05));
}

.form-title{
    margin:0;
    font-size:22px;
    font-weight:800;
    color:var(--text);
    display:flex;
    align-items:center;
    gap:12px;
}

.form-body{
    padding:32px;
}

/* ================= ALERT ================= */

.alert-modern{
    border:none;
    border-radius:20px;
    padding:18px 22px;
    margin-bottom:24px;
    display:flex;
    align-items:flex-start;
    gap:14px;
    box-shadow:var(--shadow-sm);
}

.alert-danger-modern{
    background:#FEF2F2;
    color:#DC2626;
}

.alert-danger-modern ul{
    margin:0;
    padding-left:18px;
}

/* ================= FORM ================= */

.form-section{
    margin-bottom:34px;
}

.section-title{
    font-size:17px;
    font-weight:800;
    color:var(--text);
    margin-bottom:20px;
    display:flex;
    align-items:center;
    gap:10px;
    padding-bottom:12px;
    border-bottom:1px solid #eef2ff;
}

.form-label{
    font-weight:700;
    color:var(--text);
    margin-bottom:10px;
    display:block;
    font-size:14px;
}

.required{
    color:var(--danger);
}

.form-control-modern,
.form-select-modern{
    width:100%;
    border:1.5px solid #dbe3ff;
    background:#f9fbff;
    border-radius:16px;
    padding:14px 16px;
    font-size:14px;
    transition:var(--transition);
}

.form-control-modern:focus,
.form-select-modern:focus{
    outline:none;
    border-color:var(--primary);
    background:white;
    box-shadow:0 0 0 4px rgba(79,70,229,.08);
}

.form-control-modern::placeholder{
    color:#9CA3AF;
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:22px;
}

.form-grid-2{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:22px;
}

.form-grid-3{
    display:grid;
    grid-template-columns:1fr 1fr 1fr;
    gap:22px;
}

.form-actions{
    margin-top:10px;
    padding-top:28px;
    border-top:1px solid #eef2ff;
    display:flex;
    justify-content:flex-end;
    gap:14px;
    flex-wrap:wrap;
}

/* ================= INFO BOX ================= */

.info-box{
    background:linear-gradient(135deg,#FEF3C7,#FDE68A);
    border:1px solid #FCD34D;
    border-radius:20px;
    padding:18px 22px;
    font-size:13px;
    color:#92400E;
    line-height:1.8;
    box-shadow:var(--shadow-sm);
}

.info-box strong{ color:#78350F; }
.info-box code{
    background:rgba(255,255,255,.6);
    padding:2px 8px;
    border-radius:6px;
    font-weight:700;
    color:#B45309;
}

/* ================= TOAST ================= */

.toast-modern{
    position:fixed;
    top:24px;
    right:24px;
    z-index:9999;
    background:white;
    border-radius:18px;
    padding:16px 18px;
    box-shadow:var(--shadow-lg);
    display:flex;
    align-items:center;
    gap:12px;
    min-width:320px;
    animation:slideIn .3s ease;
}

.toast-error{ border-left:5px solid var(--danger); }
.toast-success{ border-left:5px solid var(--success); }

@keyframes slideIn{
    from{ opacity:0; transform:translateX(30px); }
    to{ opacity:1; transform:translateX(0); }
}

@keyframes slideOut{
    from{ opacity:1; transform:translateX(0); }
    to{ opacity:0; transform:translateX(30px); }
}

/* ================= LOADING ================= */

.spinner{
    width:16px;
    height:16px;
    border:2px solid rgba(255,255,255,.35);
    border-top-color:white;
    border-radius:50%;
    animation:spin .7s linear infinite;
}

@keyframes spin{
    to{ transform:rotate(360deg); }
}

/* ================= RESPONSIVE ================= */

@media(max-width:768px){
    .page-header{ padding:26px; }
    .page-title{ font-size:28px; }
    .form-body{ padding:22px; }
    .form-grid,
    .form-grid-2,
    .form-grid-3{
        grid-template-columns:1fr;
    }
    .form-actions{ flex-direction:column-reverse; }
    .btn-modern{ width:100%; }
    .toast-modern{
        left:20px;
        right:20px;
        min-width:auto;
    }
}
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    {{-- ================= HEADER ================= --}}
    <div class="page-header">
        <div class="header-content">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Tambah Siswa Pindahan
                </h1>
                <div class="page-subtitle">
                    Input data siswa pindahan dari sekolah lain. Siswa langsung aktif di rombel tujuan.
                </div>
            </div>
            <a href="{{ route('tu.mutasi.index') }}" class="btn-modern btn-back">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    {{-- ================= ERROR SESSION ================= --}}
    @if (session('error'))
        <div class="alert-modern alert-danger-modern">
            <i class="fas fa-circle-exclamation mt-1"></i>
            <div>
                <div class="fw-bold mb-1">Terjadi kesalahan</div>
                {!! session('error') !!}
            </div>
        </div>
    @endif

    {{-- ================= VALIDATION ERRORS ================= --}}
    @if ($errors->any())
        <div class="alert-modern alert-danger-modern">
            <i class="fas fa-circle-exclamation mt-1"></i>
            <div>
                <div class="fw-bold mb-1">Terdapat kesalahan pada form</div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- ================= FORM ================= --}}
    <form action="{{ route('tu.mutasi.masuk.store') }}"
          method="POST"
          id="createMasukForm">
        @csrf

        <div class="row g-4">
            {{-- ================================================== --}}
            {{-- KOLOM KIRI: DATA SISWA --}}
            {{-- ================================================== --}}
            <div class="col-lg-8">

                {{-- DATA SISWA --}}
                <div class="form-card">
                    <div class="form-header">
                        <h4 class="form-title">
                            <i class="fas fa-user text-primary"></i>
                            Data Siswa
                        </h4>
                    </div>
                    <div class="form-body">

                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-id-card text-primary"></i>
                                Identitas Siswa
                            </div>

                            <div class="form-grid">
                                <div>
                                    <label class="form-label">
                                        Nama Lengkap <span class="required">*</span>
                                    </label>
                                    <input type="text" name="nama_lengkap"
                                           class="form-control-modern @error('nama_lengkap') is-invalid @enderror"
                                           value="{{ old('nama_lengkap') }}" required
                                           placeholder="cth: Ahmad Rizki Pratama">
                                </div>

                                <div>
                                    <label class="form-label">
                                        NIS <span class="required">*</span>
                                    </label>
                                    <input type="text" name="nis"
                                           class="form-control-modern @error('nis') is-invalid @enderror"
                                           value="{{ old('nis') }}" required
                                           placeholder="Nomor induk baru">
                                </div>

                                <div>
                                    <label class="form-label">NISN</label>
                                    <input type="text" name="nisn"
                                           class="form-control-modern @error('nisn') is-invalid @enderror"
                                           value="{{ old('nisn') }}"
                                           placeholder="10 digit">
                                </div>

                                <div>
                                    <label class="form-label">
                                        Jenis Kelamin <span class="required">*</span>
                                    </label>
                                    <select name="jenis_kelamin_id"
                                            class="form-select-modern @error('jenis_kelamin_id') is-invalid @enderror"
                                            required>
                                        <option value="">-- Pilih --</option>
                                        @foreach($jenisKelamins as $jk)
                                            <option value="{{ $jk->id }}" {{ old('jenis_kelamin_id') == $jk->id ? 'selected' : '' }}>
                                                {{ $jk->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Agama</label>
                                    <select name="agama_id" class="form-select-modern">
                                        <option value="">-- Pilih --</option>
                                        @foreach($agamas as $agama)
                                            <option value="{{ $agama->id }}" {{ old('agama_id') == $agama->id ? 'selected' : '' }}>
                                                {{ $agama->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">No. HP</label>
                                    <input type="text" name="no_hp"
                                           class="form-control-modern"
                                           value="{{ old('no_hp') }}"
                                           placeholder="08xxxxxxxxxx">
                                </div>

                                <div>
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir"
                                           class="form-control-modern"
                                           value="{{ old('tempat_lahir') }}"
                                           placeholder="cth: Ciamis">
                                </div>

                                <div>
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir"
                                           class="form-control-modern"
                                           value="{{ old('tanggal_lahir') }}">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ALAMAT --}}
                <div class="form-card">
                    <div class="form-header">
                        <h4 class="form-title">
                            <i class="fas fa-home text-primary"></i>
                            Alamat
                            <small class="fw-normal text-muted ms-2" style="font-size:13px;">(Opsional)</small>
                        </h4>
                    </div>
                    <div class="form-body">

                        <div class="form-section" style="margin-bottom:0;">
                            <div class="form-grid-2">
                                <div>
                                    <label class="form-label">RT</label>
                                    <input type="text" name="rt" class="form-control-modern"
                                           value="{{ old('rt') }}" placeholder="001">
                                </div>
                                <div>
                                    <label class="form-label">RW</label>
                                    <input type="text" name="rw" class="form-control-modern"
                                           value="{{ old('rw') }}" placeholder="005">
                                </div>
                            </div>

                            <div class="form-grid" style="margin-top:22px;">
                                <div>
                                    <label class="form-label">Dusun</label>
                                    <input type="text" name="dusun" class="form-control-modern"
                                           value="{{ old('dusun') }}">
                                </div>
                                <div>
                                    <label class="form-label">Kelurahan/Desa</label>
                                    <input type="text" name="kelurahan" class="form-control-modern"
                                           value="{{ old('kelurahan') }}">
                                </div>
                                <div>
                                    <label class="form-label">Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control-modern"
                                           value="{{ old('kecamatan') }}">
                                </div>
                                <div>
                                    <label class="form-label">Kode Pos</label>
                                    <input type="text" name="kode_pos" class="form-control-modern"
                                           value="{{ old('kode_pos') }}" placeholder="46253">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- DATA ORANG TUA --}}
                <div class="form-card">
                    <div class="form-header">
                        <h4 class="form-title">
                            <i class="fas fa-users text-primary"></i>
                            Data Orang Tua
                            <small class="fw-normal text-muted ms-2" style="font-size:13px;">(Opsional)</small>
                        </h4>
                    </div>
                    <div class="form-body">

                        <div class="form-section" style="margin-bottom:0;">
                            <div class="form-grid-3">
                                <div>
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" name="nama_ayah" class="form-control-modern"
                                           value="{{ old('nama_ayah') }}">
                                </div>
                                <div>
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" name="nama_ibu" class="form-control-modern"
                                           value="{{ old('nama_ibu') }}">
                                </div>
                                <div>
                                    <label class="form-label">Nama Wali</label>
                                    <input type="text" name="nama_wali" class="form-control-modern"
                                           value="{{ old('nama_wali') }}">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- ================================================== --}}
            {{-- KOLOM KANAN: DATA MUTASI --}}
            {{-- ================================================== --}}
            <div class="col-lg-4">

                <div class="form-card" style="position:sticky; top:20px;">
                    <div class="form-header">
                        <h4 class="form-title">
                            <i class="fas fa-exchange-alt text-success"></i>
                            Data Mutasi Masuk
                        </h4>
                    </div>
                    <div class="form-body">

                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-graduation-cap text-success"></i>
                                Tujuan & Asal
                            </div>

                            <div style="margin-bottom:22px;">
                                <label class="form-label">
                                    Rombel Tujuan <span class="required">*</span>
                                </label>
                                <select name="rombel_id"
                                        class="form-select-modern @error('rombel_id') is-invalid @enderror"
                                        required>
                                    <option value="">-- Pilih Rombel --</option>
                                    @foreach($rombels as $rombel)
                                        <option value="{{ $rombel->id }}" {{ old('rombel_id') == $rombel->id ? 'selected' : '' }}>
                                            {{ $rombel->nama }}
                                            @if($rombel->kelas && $rombel->kelas->jurusan)
                                                — {{ $rombel->kelas->jurusan->nama }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="margin-bottom:22px;">
                                <label class="form-label">
                                    Sekolah Asal <span class="required">*</span>
                                </label>
                                <input type="text" name="sekolah_asal"
                                       class="form-control-modern @error('sekolah_asal') is-invalid @enderror"
                                       value="{{ old('sekolah_asal') }}" required
                                       placeholder="cth: SMPN 1 Kawali">
                            </div>

                            <div style="margin-bottom:22px;">
                                <label class="form-label">NIS di Sekolah Asal</label>
                                <input type="text" name="nis_dari_sekolah_asal"
                                       class="form-control-modern"
                                       value="{{ old('nis_dari_sekolah_asal') }}"
                                       placeholder="Opsional">
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="section-title">
                                <i class="fas fa-calendar-alt text-success"></i>
                                Detail Mutasi
                            </div>

                            <div style="margin-bottom:22px;">
                                <label class="form-label">
                                    Tanggal Masuk <span class="required">*</span>
                                </label>
                                <input type="date" name="tanggal_mutasi"
                                       class="form-control-modern @error('tanggal_mutasi') is-invalid @enderror"
                                       value="{{ old('tanggal_mutasi', date('Y-m-d')) }}" required>
                            </div>

                            <div style="margin-bottom:22px;">
                                <label class="form-label">Alasan Pindah</label>
                                <input type="text" name="alasan_pindah"
                                       class="form-control-modern"
                                       value="{{ old('alasan_pindah') }}"
                                       placeholder="cth: Ikut orang tua">
                            </div>

                            <div style="margin-bottom:22px;">
                                <label class="form-label">No. Surat Masuk</label>
                                <input type="text" name="no_surat_masuk"
                                       class="form-control-modern"
                                       value="{{ old('no_surat_masuk') }}"
                                       placeholder="cth: 421.7/123/SMK.1.KW/2026">
                            </div>

                            <div style="margin-bottom:22px;">
                                <label class="form-label">Tanggal Surat Masuk</label>
                                <input type="date" name="tanggal_surat_masuk"
                                       class="form-control-modern"
                                       value="{{ old('tanggal_surat_masuk') }}">
                            </div>

                            <div style="margin-bottom:0;">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control-modern"
                                          rows="2"
                                          placeholder="Opsional">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="info-box mt-3">
                    <i class="fas fa-info-circle me-1"></i>
                    <strong>Info Penting:</strong><br>
                    • Password default: <code>{NIS}123</code><br>
                    • Email default: <code>{NIS}@siswa.local</code><br>
                    • Siswa langsung aktif di rombel tujuan
                </div>

            </div>
        </div>

        {{-- ================= FORM ACTIONS ================= --}}
        <div class="form-card">
            <div class="form-body">
                <div class="form-actions" style="border-top:none; padding-top:0; margin-top:0;">
                    <a href="{{ route('tu.mutasi.index') }}" class="btn-modern btn-cancel">
                        <i class="fas fa-xmark"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn-modern btn-save" id="submitBtn">
                        <i class="fas fa-floppy-disk"></i>
                        Simpan Siswa Pindahan
                    </button>
                </div>
            </div>
        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const form = document.getElementById('createMasukForm');
    const submitBtn = document.getElementById('submitBtn');

    /* ================= SUBMIT VALIDATION ================= */
    if(form){

        form.addEventListener('submit', function(e){

            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;

            requiredFields.forEach(field => {
                if(!field.value.trim()){
                    valid = false;
                    field.style.borderColor = '#EF4444';
                }else{
                    field.style.borderColor = '';
                }
            });

            if(!valid){
                e.preventDefault();
                showToast('Mohon lengkapi semua field wajib diisi', 'error');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="spinner"></span>
                Menyimpan...
            `;
        });
    }

    /* ================= TOAST ================= */
    function showToast(message, type = 'success'){

        const toast = document.createElement('div');
        toast.className = `toast-modern toast-${type}`;

        toast.innerHTML = `
            <i class="fas fa-${
                type === 'error'
                    ? 'circle-xmark'
                    : 'circle-check'
            }"></i>
            <div>${message}</div>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut .3s ease forwards';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

});
</script>

@endsection