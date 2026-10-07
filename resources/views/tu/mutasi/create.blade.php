@extends('layouts.app')

@section('title', 'Tambah Mutasi Siswa')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* ============================================
       SELECT2 CUSTOM STYLE
       ============================================ */
    .select2-container--default .select2-selection--single {
        border: 1.5px solid #dbe3ff;
        background: #f9fbff;
        border-radius: 16px;
        height: auto;
        padding: 8px 14px;
        min-height: 48px;
        display: flex;
        align-items: center;
        transition: all .25s ease;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5;
        color: #111827;
        padding: 0;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
        top: 0;
        right: 10px;
    }

    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #4F46E5;
        background: white;
        box-shadow: 0 0 0 4px rgba(79,70,229,.08);
        outline: none;
    }

    .select2-dropdown {
        border: 1.5px solid #dbe3ff;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(15,23,42,.08);
        overflow: hidden;
    }

    .select2-results__option--highlighted[aria-selected] {
        background: linear-gradient(135deg, #4F46E5, #7C3AED) !important;
        color: white !important;
    }
</style>
@endpush

@section('content')

<style>
:root{
    --primary:#4F46E5;
    --primary-light:#6366F1;
    --secondary:#7C3AED;

    --success:#10B981;
    --warning:#F59E0B;
    --danger:#EF4444;
    --info:#0EA5E9;

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
        radial-gradient(circle at top right, rgba(99,102,241,.10), transparent 20%),
        radial-gradient(circle at bottom left, rgba(124,58,237,.10), transparent 25%),
        linear-gradient(180deg,#f8faff 0%,#eef2ff 100%);
}

/* ================= PAGE HEADER ================= */

.page-header{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
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
    font-size:14px;
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
    color:var(--primary);
}

.btn-save{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    color:white;
    box-shadow:0 10px 24px rgba(79,70,229,.24);
}

.btn-save:hover{
    box-shadow:0 14px 28px rgba(79,70,229,.35);
    color:white;
}

.btn-cancel{
    background:#fff;
    color:var(--text);
    border:1.5px solid #dbe3ff;
}

.btn-cancel:hover{
    background:#f8faff;
    color:var(--text);
}

/* ================= CARD ================= */

.form-card{
    background:rgba(255,255,255,.92);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,.8);
    border-radius:28px;
    overflow:hidden;
    box-shadow:var(--shadow-md);
}

.form-header{
    padding:28px 30px;
    border-bottom:1px solid #eef2ff;
    background:linear-gradient(135deg,rgba(79,70,229,.05),rgba(124,58,237,.05));
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

.alert-info-modern{
    background:linear-gradient(135deg,#E0E7FF,#C7D2FE);
    color:#3730A3;
    border-left:4px solid #4F46E5;
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

.form-actions{
    margin-top:10px;
    padding-top:28px;
    border-top:1px solid #eef2ff;
    display:flex;
    justify-content:flex-end;
    gap:14px;
    flex-wrap:wrap;
}

/* ================= INFO BOX (Kelas Saat Ini) ================= */

.info-box{
    background:linear-gradient(135deg,#DBEAFE,#BFDBFE);
    border:1px solid #93C5FD;
    border-radius:20px;
    padding:20px 24px;
    margin-bottom:24px;
    color:#1E40AF;
    box-shadow:var(--shadow-sm);
}

.info-box-title{
    font-weight:800;
    font-size:14px;
    margin-bottom:10px;
    display:flex;
    align-items:center;
    gap:8px;
}

.info-box-row{
    display:flex;
    gap:10px;
    font-size:13px;
    margin-bottom:4px;
}

.info-box-row strong{
    min-width:100px;
    font-weight:700;
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
    .page-title{ font-size:26px; }
    .form-body{ padding:22px; }
    .form-grid,
    .form-grid-2{
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
                    <i class="fas fa-plus-circle me-2"></i>
                    Tambah Data Mutasi
                </h1>
                <div class="page-subtitle">
                    Input mutasi individual — pindah, DO, meninggal, lulus, atau naik kelas
                </div>
            </div>
            <a href="{{ route('tu.mutasi.index') }}" class="btn-modern btn-back">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    {{-- ================= ERROR VALIDATION ================= --}}
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
    <div class="form-card">
        <div class="form-header">
            <h4 class="form-title">
                <i class="fas fa-exchange-alt text-primary"></i>
                Form Mutasi Individual
            </h4>
        </div>

        <div class="form-body">
            <form action="{{ route('tu.mutasi.store') }}" method="POST" id="mutasiForm" novalidate>
                @csrf

                {{-- ========== SECTION: PILIH SISWA ========== --}}
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-user text-primary"></i>
                        Pilih Siswa
                    </div>

                    <div class="form-grid-2">
                        <div>
                            <label for="filter_kelas" class="form-label">
                                <i class="fas fa-chalkboard"></i> Filter Kelas
                            </label>
                            <select id="filter_kelas" class="form-select-modern">
                                <option value="">-- Semua Kelas --</option>
                                @foreach($classes as $kelas)
                                    <option value="{{ $kelas->id }}">
                                        {{ $kelas->tingkat }} {{ $kelas->jurusan->nama ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted" style="font-size:12px;">Filter untuk mempersempit pencarian siswa.</small>
                        </div>

                        <div>
                            <label for="siswa_id" class="form-label">
                                <i class="fas fa-user"></i> Siswa <span class="required">*</span>
                            </label>
                            <select name="siswa_id" id="siswa_id"
                                    class="form-select-modern @error('siswa_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->id }}"
                                        data-kelas-id="{{ optional(optional($siswa->rombel)->kelas)->id ?? '' }}"
                                        data-kelas-name="{{ trim((optional(optional($siswa->rombel)->kelas)->tingkat ?? '') . ' ' . (optional(optional($siswa->rombel)->kelas)->jurusan->nama ?? '')) }}"
                                        data-rombel-name="{{ $siswa->rombel->nama ?? '' }}"
                                        {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                        {{ $siswa->nis }} - {{ $siswa->nama_lengkap }}
                                        @if($siswa->rombel)
                                            ({{ $siswa->rombel->nama }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('siswa_id')
                                <div class="text-danger mt-1" style="font-size:12px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Info Kelas Saat Ini --}}
                    <div id="studentClassInfo" class="info-box mt-3" style="display: none;">
                        <div class="info-box-title">
                            <i class="fas fa-info-circle"></i>
                            Kelas Saat Ini
                        </div>
                        <div class="info-box-row">
                            <strong>Kelas:</strong>
                            <span id="currentKelasText">-</span>
                        </div>
                        <div class="info-box-row">
                            <strong>Rombel:</strong>
                            <span id="currentRombelText">-</span>
                        </div>
                    </div>
                </div>

                {{-- ========== SECTION: DETAIL MUTASI ========== --}}
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-exchange-alt text-primary"></i>
                        Detail Mutasi
                    </div>

                    <div class="form-grid-2">
                        <div>
                            <label for="status" class="form-label">
                                <i class="fas fa-tag"></i> Status Mutasi <span class="required">*</span>
                            </label>
                            <select name="status" id="status"
                                    class="form-select-modern @error('status') is-invalid @enderror"
                                    required onchange="updateStatusFields()">
                                <option value="">-- Pilih Status --</option>
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="text-danger mt-1" style="font-size:12px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_mutasi" class="form-label">
                                <i class="fas fa-calendar-alt"></i> Tanggal Mutasi <span class="required">*</span>
                            </label>
                            <input type="date" name="tanggal_mutasi" id="tanggal_mutasi"
                                   class="form-control-modern @error('tanggal_mutasi') is-invalid @enderror"
                                   value="{{ old('tanggal_mutasi', now()->format('Y-m-d')) }}" required>
                            @error('tanggal_mutasi')
                                <div class="text-danger mt-1" style="font-size:12px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="keterangan" class="form-label">
                            <i class="fas fa-comment"></i> Keterangan
                        </label>
                        <textarea name="keterangan" id="keterangan" rows="2"
                                  class="form-control-modern @error('keterangan') is-invalid @enderror"
                                  placeholder="Catatan tambahan (opsional)...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="text-danger mt-1" style="font-size:12px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- ========== SECTION: DATA PINDAH (Dinamis) ========== --}}
                <div id="pindahFields" class="form-section" style="display: none;">
                    <div class="section-title">
                        <i class="fas fa-arrow-right text-info"></i>
                        Data Pindah Sekolah
                    </div>

                    <div class="form-grid-2">
                        <div>
                            <label for="alasan_pindah" class="form-label">Alasan Pindah</label>
                            <input type="text" name="alasan_pindah" id="alasan_pindah"
                                   class="form-control-modern @error('alasan_pindah') is-invalid @enderror"
                                   value="{{ old('alasan_pindah') }}"
                                   placeholder="Contoh: Pindah ke kota lain">
                            @error('alasan_pindah')
                                <div class="text-danger mt-1" style="font-size:12px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="tujuan_pindah" class="form-label">Sekolah Tujuan</label>
                            <input type="text" name="tujuan_pindah" id="tujuan_pindah"
                                   class="form-control-modern @error('tujuan_pindah') is-invalid @enderror"
                                   value="{{ old('tujuan_pindah') }}"
                                   placeholder="Nama sekolah tujuan">
                            @error('tujuan_pindah')
                                <div class="text-danger mt-1" style="font-size:12px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ========== SECTION: SK KELUAR (Dinamis) ========== --}}
                <div id="skFields" class="form-section" style="display: none;">
                    <div class="section-title">
                        <i class="fas fa-file-contract text-warning"></i>
                        Surat Keputusan Keluar
                    </div>

                    <div class="form-grid-2">
                        <div>
                            <label for="no_sk_keluar" class="form-label">Nomor SK Keluar</label>
                            <input type="text" name="no_sk_keluar" id="no_sk_keluar"
                                   class="form-control-modern @error('no_sk_keluar') is-invalid @enderror"
                                   value="{{ old('no_sk_keluar') }}"
                                   placeholder="Contoh: 001/SK/2026">
                            @error('no_sk_keluar')
                                <div class="text-danger mt-1" style="font-size:12px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_sk_keluar" class="form-label">Tanggal SK Keluar</label>
                            <input type="date" name="tanggal_sk_keluar" id="tanggal_sk_keluar"
                                   class="form-control-modern @error('tanggal_sk_keluar') is-invalid @enderror"
                                   value="{{ old('tanggal_sk_keluar') }}">
                            @error('tanggal_sk_keluar')
                                <div class="text-danger mt-1" style="font-size:12px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ========== FORM ACTIONS ========== --}}
                <div class="form-actions">
                    <a href="{{ route('tu.mutasi.index') }}" class="btn-modern btn-cancel">
                        <i class="fas fa-xmark"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn-modern btn-save" id="submitBtn">
                        <i class="fas fa-floppy-disk"></i>
                        Simpan Mutasi
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    function updateStatusFields() {
        const status = document.getElementById('status').value;
        const pindahFields = document.getElementById('pindahFields');
        const skFields = document.getElementById('skFields');

        pindahFields.style.display = 'none';
        skFields.style.display = 'none';

        if (status === 'pindah') {
            pindahFields.style.display = 'block';
            skFields.style.display = 'block';
        } else if (['do', 'meninggal'].includes(status)) {
            skFields.style.display = 'block';
        }
    }

    function updateStudentClassInfo() {
        const infoBox = document.getElementById('studentClassInfo');
        const currentKelasText = document.getElementById('currentKelasText');
        const currentRombelText = document.getElementById('currentRombelText');

        if (window.jQuery && $('#siswa_id').data('select2')) {
            const data = $('#siswa_id').select2('data')[0];
            if (data && data.id) {
                currentKelasText.textContent = data.kelasName || '-';
                currentRombelText.textContent = data.rombelName || '-';
                infoBox.style.display = 'block';
                return;
            }
        }

        const siswaSelect = document.getElementById('siswa_id');
        const selectedOption = siswaSelect.options[siswaSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            currentKelasText.textContent = selectedOption.dataset.kelasName || '-';
            currentRombelText.textContent = selectedOption.dataset.rombelName || '-';
            infoBox.style.display = 'block';
        } else {
            currentKelasText.textContent = '-';
            currentRombelText.textContent = '-';
            infoBox.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const kelasFilter = document.getElementById('filter_kelas');

        // ================= SELECT2 INIT =================
        $('#siswa_id').select2({
            placeholder: '-- Pilih atau Ketik Nama Siswa --',
            allowClear: true,
            width: '100%',
            ajax: {
                url: '{{ route("tu.mutasi.search") }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        kelas_id: document.getElementById('filter_kelas').value
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text,
                                kelasId: item.kelasId,
                                kelasName: item.kelasName,
                                rombelName: item.rombelName
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 2,
            templateResult: function(item) { return item.text; },
            templateSelection: function(item) { return item.text || item.id; }
        });

        kelasFilter.addEventListener('change', () => {
            $('#siswa_id').val(null).trigger('change');
            updateStudentClassInfo();
        });

        $('#siswa_id').on('change', function() {
            updateStudentClassInfo();
        });

        updateStatusFields();
        updateStudentClassInfo();

        // ================= SUBMIT VALIDATION =================
        const form = document.getElementById('mutasiForm');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.style.borderColor = '#EF4444';
                } else {
                    field.style.borderColor = '';
                }
            });

            if (!valid) {
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

        // ================= TOAST =================
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast-modern toast-${type}`;
            toast.innerHTML = `
                <i class="fas fa-${
                    type === 'error' ? 'circle-xmark' : 'circle-check'
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

        window.showToast = showToast;
    });
</script>
@endpush

@endsection