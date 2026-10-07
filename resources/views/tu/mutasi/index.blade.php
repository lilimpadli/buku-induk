@extends('layouts.app')

@section('title', 'Mutasi Siswa')

@section('content')
<style>
    :root {
        --primary: #4F46E5;
        --primary-dark: #4338CA;
        --secondary: #7C3AED;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
    }

    body { background: linear-gradient(180deg, #F8FAFF 0%, #EEF2FF 100%); }

    .hero-banner {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 28px;
        padding: 32px;
        margin-bottom: 28px;
        box-shadow: 0 18px 35px rgba(15,23,42,.12);
        color: white;
        position: relative;
        overflow: hidden;
    }
    .hero-banner::before,
    .hero-banner::after {
        content: ''; position: absolute; border-radius: 50%;
        background: rgba(255,255,255,.08); pointer-events: none;
    }
    .hero-banner::before { width: 260px; height: 260px; top: -110px; right: -70px; }
    .hero-banner::after { width: 180px; height: 180px; bottom: -70px; left: -50px; }

    .hero-content {
        position: relative; z-index: 2;
        display: flex; justify-content: space-between; align-items: center;
        gap: 20px; flex-wrap: wrap;
    }
    .hero-title { font-size: 32px; font-weight: 800; margin: 0 0 6px; }
    .hero-subtitle { font-size: 14px; opacity: .85; margin: 0; }

    /* ============================================
       TOMBOL HERO — VARIASI WARNA
       ============================================ */
    .btn-hero {
        background: white; color: var(--primary);
        border: none; border-radius: 14px;
        padding: 12px 22px; font-weight: 700; font-size: 14px;
        display: inline-flex; align-items: center; gap: 8px;
        text-decoration: none; transition: all .25s; cursor: pointer;
        box-shadow: 0 6px 18px rgba(0,0,0,.15);
    }
    .btn-hero:hover { transform: translateY(-2px); color: var(--primary); }

    .btn-hero.btn-outline {
        background: rgba(255,255,255,.15); color: white;
        border: 1px solid rgba(255,255,255,.3);
    }
    .btn-hero.btn-outline:hover { background: rgba(255,255,255,.25); color: white; }

    .btn-hero.btn-green {
        background: linear-gradient(135deg, #34D399, #10B981);
        color: white;
    }
    .btn-hero.btn-green:hover {
        background: linear-gradient(135deg, #10B981, #059669);
        color: white;
        transform: translateY(-2px);
    }

    .btn-hero.btn-cyan {
        background: linear-gradient(135deg, #38BDF8, #0EA5E9);
        color: white;
    }
    .btn-hero.btn-cyan:hover {
        background: linear-gradient(135deg, #0EA5E9, #0284C7);
        color: white;
        transform: translateY(-2px);
    }

    /* AKSI MASSAL */
    .card-modern {
        background: white; border-radius: 22px;
        border: 1px solid #EEF2FF;
        box-shadow: 0 10px 25px rgba(15,23,42,.08);
        padding: 28px; margin-bottom: 24px;
    }

    .section-title {
        font-size: 18px; font-weight: 800; color: #1E293B;
        margin: 0 0 8px;
    }
    .section-desc {
        font-size: 13px; color: #64748B; margin: 0 0 20px;
    }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 14px;
    }

    .action-card {
        background: white;
        border: 2px solid #E2E8F0;
        border-radius: 16px;
        padding: 20px 16px;
        text-align: center;
        cursor: pointer;
        transition: all .25s;
        display: flex; flex-direction: column;
        align-items: center; gap: 10px;
        font-weight: 700; font-size: 14px;
        color: #334155;
    }

    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(15,23,42,.1);
    }
    .action-card i { font-size: 24px; }

    .action-card.lulus { border-color: #A7F3D0; }
    .action-card.lulus:hover { background: linear-gradient(135deg, #D1FAE5, #A7F3D0); border-color: #10B981; color: #059669; }
    .action-card.lulus i { color: #10B981; }

    .action-card.naik { border-color: #C7D2FE; }
    .action-card.naik:hover { background: linear-gradient(135deg, #E0E7FF, #C7D2FE); border-color: #4F46E5; color: #4338CA; }
    .action-card.naik i { color: #4F46E5; }

    .action-card.pindah { border-color: #BFDBFE; }
    .action-card.pindah:hover { background: linear-gradient(135deg, #DBEAFE, #BFDBFE); border-color: #2563EB; color: #1D4ED8; }
    .action-card.pindah i { color: #2563EB; }

    .action-card.keluar { border-color: #FDE68A; }
    .action-card.keluar:hover { background: linear-gradient(135deg, #FEF3C7, #FDE68A); border-color: #F59E0B; color: #B45309; }
    .action-card.keluar i { color: #F59E0B; }

    .action-card.meninggal { border-color: #FECACA; }
    .action-card.meninggal:hover { background: linear-gradient(135deg, #FEE2E2, #FECACA); border-color: #EF4444; color: #DC2626; }
    .action-card.meninggal i { color: #EF4444; }

    /* LIST SISWA */
    .student-row {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 18px;
        background: #F8FAFF;
        border: 1px solid #EEF2FF;
        border-radius: 14px;
        margin-bottom: 10px;
        transition: all .2s;
    }
    .student-row:hover { background: #EEF2FF; border-color: #C7D2FE; }
    .student-row input[type="checkbox"] {
        width: 20px; height: 20px;
        accent-color: var(--primary);
        cursor: pointer;
    }
    .student-info { flex: 1; }
    .student-name { font-weight: 700; color: #1E293B; font-size: 14px; }
    .student-meta { font-size: 12px; color: #64748B; margin-top: 2px; }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .hero-title { font-size: 22px; }
        .action-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    <!-- HERO -->
    <div class="hero-banner">
        <div class="hero-content">
            <div>
                <h1 class="hero-title">
                    <i class="fas fa-exchange-alt me-2"></i> Mutasi Siswa
                </h1>
                <p class="hero-subtitle">
                    Kelola mutasi siswa berdasarkan jurusan dan status akademik
                </p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('tu.mutasi.laporan-surat') }}" class="btn-hero btn-outline">
                    <i class="fas fa-envelope-open-text"></i> Laporan Surat
                </a>
                <a href="{{ route('tu.mutasi.create') }}" class="btn-hero">
                    <i class="fas fa-plus"></i> Mutasi Individual
                </a>
                <a href="{{ route('tu.mutasi.masuk.create') }}" class="btn-hero btn-green">
                    <i class="fas fa-sign-in-alt"></i> Tambah Siswa Pindahan
                </a>
                <a href="{{ route('tu.mutasi.rekap') }}" class="btn-hero btn-cyan">
                    <i class="fas fa-list-alt"></i> Rekap Mutasi
                </a>
            </div>
        </div>
    </div>

    <!-- DAFTAR JURUSAN -->
    @php
        $jurusanGroups = $classes->sortBy(function($kelas) { return optional($kelas->jurusan)->nama ?? ''; })
            ->groupBy(function($kelas) { return $kelas->jurusan_id ?? 'umum'; });
    @endphp

    @if($jurusanGroups->count() > 0)
        <div class="card-modern">
            <h3 class="section-title"><i class="fas fa-graduation-cap me-2"></i> Pilih Jurusan</h3>
            <p class="section-desc">Klik jurusan untuk melihat daftar rombel dan siswa.</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
                @foreach($jurusanGroups as $jurusanId => $jurusanClasses)
                    @php
                        $jurusan = $jurusanClasses->first()->jurusan;
                        $totalSiswa = $jurusanClasses->flatMap(fn($kelas) => $kelas->rombels)->sum(fn($rombel) => $rombel->siswas->count());
                    @endphp
                    <a href="{{ route('tu.mutasi.kelas', $jurusan->id ?? 0) }}"
                       style="text-decoration: none; color: inherit;">
                        <div style="background: white; border: 1.5px solid #EEF2FF; border-radius: 18px; padding: 20px; transition: all .25s;"
                             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 30px rgba(15,23,42,.12)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <span style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700;">
                                    {{ $jurusan->kode ?? 'UMUM' }}
                                </span>
                                <span style="font-size: 24px; font-weight: 800; background: linear-gradient(135deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                    {{ $totalSiswa }}
                                </span>
                            </div>
                            <div style="font-weight: 700; color: #1E293B; margin-bottom: 4px;">
                                {{ $jurusan->nama ?? 'Umum' }}
                            </div>
                            <div style="font-size: 12px; color: #64748B;">
                                {{ $jurusanClasses->count() }} kelas · {{ $jurusanClasses->sum(fn($k) => $k->rombels->count()) }} rombel
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- AKSI MASSAL -->
    <div class="card-modern">
        <h3 class="section-title"><i class="fas fa-tasks me-2"></i> Aksi Massal untuk Siswa Terpilih</h3>
        <p class="section-desc">
            Pilih siswa, lalu pilih status mutasi yang diinginkan.
            Untuk status **Pindah** dan **Keluar Sekolah (DO)** akan dibuatkan surat mutasi otomatis.
        </p>

        <!-- Form Pilih Siswa -->
        <div style="margin-bottom: 20px;">
            <input type="text" id="searchSiswa" class="form-control"
                   placeholder="🔍 Cari nama siswa / NIS / NISN..."
                   style="border-radius: 12px; border: 1.5px solid #E2E8F0; padding: 12px 16px; margin-bottom: 12px;">

            <div style="max-height: 350px; overflow-y: auto; padding: 4px;" id="siswaListContainer">
                @foreach($allStudents as $siswa)
                    <div class="student-row" data-nama="{{ strtolower($siswa['nama_lengkap']) }}" data-nis="{{ $siswa['nis'] }}">
                        <input type="checkbox" class="siswa-checkbox" value="{{ $siswa['id'] }}">
                        <div class="student-info">
                            <div class="student-name">{{ $siswa['nama_lengkap'] }}</div>
                            <div class="student-meta">
                                NIS: {{ $siswa['nis'] }} · Rombel: {{ $siswa['rombel_name'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 12px; font-size: 13px; color: #64748B;">
                <label style="cursor: pointer;">
                    <input type="checkbox" id="selectAll" style="accent-color: var(--primary); margin-right: 6px;">
                    <strong>Pilih semua yang tampil</strong>
                </label>
                <span id="selectedCount" style="margin-left: 16px; font-weight: 700; color: var(--primary);">
                    0 siswa terpilih
                </span>
            </div>
        </div>

        <!-- Tombol Status -->
        <div class="action-grid">
            <button type="button" class="action-card lulus" onclick="handleAction('lulus')">
                <i class="fas fa-graduation-cap"></i>
                <div>Lulus Siswa</div>
                <small style="font-weight: 500; font-size: 11px; color: #94A3B8;">Keluar dari sistem</small>
            </button>

            <button type="button" class="action-card naik" onclick="handleAction('naik_kelas')">
                <i class="fas fa-arrow-up"></i>
                <div>Naik Kelas</div>
                <small style="font-weight: 500; font-size: 11px; color: #94A3B8;">Pindah ke kelas berikutnya</small>
            </button>

            <button type="button" class="action-card pindah" onclick="openModalPindah()">
                <i class="fas fa-paper-plane"></i>
                <div>Pindah Sekolah</div>
                <small style="font-weight: 500; font-size: 11px; color: #94A3B8;">Buat surat pindah</small>
            </button>

            <button type="button" class="action-card keluar" onclick="openModalDO()">
                <i class="fas fa-sign-out-alt"></i>
                <div>Keluar Sekolah</div>
                <small style="font-weight: 500; font-size: 11px; color: #94A3B8;">Buat surat DO</small>
            </button>

            <button type="button" class="action-card meninggal" onclick="handleAction('meninggal')">
                <i class="fas fa-heart-broken"></i>
                <div>Meninggal</div>
                <small style="font-weight: 500; font-size: 11px; color: #94A3B8;">Data tetap ada di rombel</small>
            </button>
        </div>
    </div>

</div>

<!-- ============================================ -->
<!-- MODAL PINDAH -->
<!-- ============================================ -->
<div class="modal fade" id="modalPindah" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <form id="formPindah">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #3B82F6, #2563EB); color: white; border-radius: 20px 20px 0 0; padding: 20px 24px;">
                    <h5 class="modal-title" style="font-weight: 800;">
                        <i class="fas fa-paper-plane"></i> Form Surat Pindah Sekolah
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 24px;">
                    <div id="pindahSiswaList" class="mb-3"></div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Mutasi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mutasi" class="form-control" value="{{ date('Y-m-d') }}" required style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sekolah Tujuan <span class="text-danger">*</span></label>
                            <input type="text" name="tujuan_pindah" class="form-control" placeholder="Contoh: SMA Negeri 1 Lumbung" required style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Alasan Pindah <span class="text-danger">*</span></label>
                            <input type="text" name="alasan_pindah" class="form-control" placeholder="Contoh: Permintaan Orang Tua" required style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" placeholder="Opsional" style="border-radius: 10px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #EEF2FF; padding: 16px 24px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnPindah">
                        <i class="fas fa-save"></i> Proses Surat Pindah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL DO -->
<!-- ============================================ -->
<div class="modal fade" id="modalDO" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <form id="formDO">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #F59E0B, #D97706); color: white; border-radius: 20px 20px 0 0; padding: 20px 24px;">
                    <h5 class="modal-title" style="font-weight: 800;">
                        <i class="fas fa-sign-out-alt"></i> Form Surat Keluar (DO)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 24px;">
                    <div id="doSiswaList" class="mb-3"></div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Mutasi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mutasi" class="form-control" value="{{ date('Y-m-d') }}" required style="border-radius: 10px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Alasan DO <span class="text-danger">*</span></label>
                            <input type="text" name="alasan_do" class="form-control" placeholder="Contoh: Mengundurkan diri" required style="border-radius: 10px;">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional" style="border-radius: 10px;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #EEF2FF; padding: 16px 24px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning" id="btnDO">
                        <i class="fas fa-save"></i> Proses Surat DO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL SUKSES -->
<!-- ============================================ -->
<div class="modal fade" id="modalSukses" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; text-align: center;">
            <div class="modal-body" style="padding: 40px 24px;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #D1FAE5, #A7F3D0); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="fas fa-check" style="font-size: 36px; color: #059669;"></i>
                </div>
                <h4 class="fw-bold mb-2">Berhasil!</h4>
                <p class="text-muted mb-4" id="suksesMessage">Proses mutasi berhasil</p>
                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <a href="#" id="btnLihatSurat" class="btn btn-primary" target="_blank">
                        <i class="fas fa-file-alt"></i> Lihat Surat
                    </a>
                    <a href="{{ route('tu.mutasi.laporan-surat') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-list"></i> Laporan Surat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// ==========================================================
// SEARCH & SELECT
// ==========================================================
document.getElementById('searchSiswa').addEventListener('keyup', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.student-row').forEach(row => {
        const match = row.dataset.nama.includes(q) || row.dataset.nis.includes(q);
        row.style.display = match ? 'flex' : 'none';
    });
});

document.getElementById('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.student-row').forEach(row => {
        if (row.style.display !== 'none') {
            row.querySelector('.siswa-checkbox').checked = this.checked;
        }
    });
    updateCount();
});

document.querySelectorAll('.siswa-checkbox').forEach(cb => {
    cb.addEventListener('change', updateCount);
});

function updateCount() {
    const count = document.querySelectorAll('.siswa-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = count + ' siswa terpilih';
}

function getSelectedIds() {
    return Array.from(document.querySelectorAll('.siswa-checkbox:checked')).map(cb => cb.value);
}

// ==========================================================
// HANDLE AKSI (LULUS / NAIK / MENINGGAL)
// ==========================================================
function handleAction(action) {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        alert('Pilih minimal 1 siswa terlebih dahulu!');
        return;
    }

    const actionLabel = {
        'lulus': 'LULUSKAN',
        'naik_kelas': 'NAIK KELAS',
        'meninggal': 'TANDAI MENINGGAL'
    }[action] || action.toUpperCase();

    if (!confirm('Yakin ingin ' + actionLabel + ' ' + ids.length + ' siswa terpilih?')) return;

    fetch('{{ route("tu.mutasi.bulk") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            siswa_ids: ids,
            status: action
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => alert('Error: ' + err.message));
}

// ==========================================================
// MODAL PINDAH
// ==========================================================
function openModalPindah() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        alert('Pilih minimal 1 siswa terlebih dahulu!');
        return;
    }

    const params = ids.map(id => 'siswa_ids[]=' + id).join('&');
    fetch('{{ route("tu.mutasi.form-pindah") }}?' + params)
        .then(res => res.json())
        .then(data => {
            if (!data.success) { alert('Gagal ambil data'); return; }

            let html = '<div class="alert alert-info" style="border-radius: 12px;"><strong>' + data.siswas.length + ' siswa terpilih:</strong><ul class="mb-0 mt-2">';
            data.siswas.forEach(s => {
                html += '<li>' + s.nama + ' (' + s.kelas + ')</li>';
            });
            html += '</ul></div>';

            document.getElementById('pindahSiswaList').innerHTML = html;

            const form = document.getElementById('formPindah');
            form.querySelectorAll('input[name="siswa_ids[]"]').forEach(el => el.remove());
            ids.forEach(id => {
                const inp = document.createElement('input');
                inp.type = 'hidden';
                inp.name = 'siswa_ids[]';
                inp.value = id;
                form.appendChild(inp);
            });

            new bootstrap.Modal(document.getElementById('modalPindah')).show();
        });
}

document.getElementById('formPindah').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnPindah');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

    fetch('{{ route("tu.mutasi.simpan-pindah") }}', {
        method: 'POST',
        body: new FormData(this),
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save"></i> Proses Surat Pindah';

        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('modalPindah')).hide();
            document.getElementById('suksesMessage').textContent = data.message;
            document.getElementById('btnLihatSurat').href = data.surat_url;
            new bootstrap.Modal(document.getElementById('modalSukses')).show();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save"></i> Proses Surat Pindah';
        alert('Error: ' + err.message);
    });
});

// ==========================================================
// MODAL DO
// ==========================================================
function openModalDO() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        alert('Pilih minimal 1 siswa terlebih dahulu!');
        return;
    }

    const params = ids.map(id => 'siswa_ids[]=' + id).join('&');
    fetch('{{ route("tu.mutasi.form-do") }}?' + params)
        .then(res => res.json())
        .then(data => {
            if (!data.success) { alert('Gagal ambil data'); return; }

            let html = '<div class="alert alert-warning" style="border-radius: 12px;"><strong>' + data.siswas.length + ' siswa terpilih:</strong><ul class="mb-0 mt-2">';
            data.siswas.forEach(s => {
                html += '<li>' + s.nama + ' (' + s.kelas + ')</li>';
            });
            html += '</ul></div>';

            document.getElementById('doSiswaList').innerHTML = html;

            const form = document.getElementById('formDO');
            form.querySelectorAll('input[name="siswa_ids[]"]').forEach(el => el.remove());
            ids.forEach(id => {
                const inp = document.createElement('input');
                inp.type = 'hidden';
                inp.name = 'siswa_ids[]';
                inp.value = id;
                form.appendChild(inp);
            });

            new bootstrap.Modal(document.getElementById('modalDO')).show();
        });
}

document.getElementById('formDO').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnDO');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

    fetch('{{ route("tu.mutasi.simpan-do") }}', {
        method: 'POST',
        body: new FormData(this),
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save"></i> Proses Surat DO';

        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('modalDO')).hide();
            document.getElementById('suksesMessage').textContent = data.message;
            document.getElementById('btnLihatSurat').href = data.surat_url;
            new bootstrap.Modal(document.getElementById('modalSukses')).show();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save"></i> Proses Surat DO';
        alert('Error: ' + err.message);
    });
});
</script>

@endsection