@extends('layouts.app')

@section('title', 'Surat Pindah - ' . ($mutasi->siswa->nama_lengkap ?? 'Siswa'))

@section('content')

<style>
    @page { size: A4 portrait; margin: 2.5cm; }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-size: 12pt; color: #000; line-height: 1.5; background: #e5e7eb; }

    .print-wrapper {
        font-family: 'Times New Roman', Times, serif;
        width: 210mm;
        min-height: 297mm;
        margin: 20px auto;
        padding: 2.5cm;
        background: white;
        box-shadow: 0 0 10px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .controls { display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; }
    .controls .btn {
        border-radius: 6px; font-weight: 600; padding: 8px 16px; font-size: 10pt;
        display: inline-flex; align-items: center; gap: 6px;
        text-decoration: none; border: 1px solid #d1d5db;
        font-family: system-ui, sans-serif; cursor: pointer;
    }
    .btn-secondary { background: white; color: #111827; }
    .btn-primary { background: #2563eb; color: white; border-color: #2563eb; }
    .btn-warning { background: #F59E0B; color: white; border-color: #F59E0B; }
    .btn-warning:hover { background: #D97706; color: white; }

    /* KOP */
    .kop-surat {
        width: 100%;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    /* JUDUL */
    .title-surat {
        text-align: center;
        font-size: 13pt;
        font-weight: bold;
        margin-bottom: 4px;
        text-decoration: underline;
        letter-spacing: 1px;
    }
    .nomor-surat {
        text-align: center;
        font-size: 12pt;
        margin-bottom: 40px;
    }

    /* ISI */
    .content { font-size: 12pt; line-height: 1.6; }
    .content p { text-align: justify; margin-bottom: 15px; }
    .content p.indent { text-indent: 40px; }

    .info-table {
        width: 100%;
        margin: 15px 0 25px 40px;
        border-collapse: collapse;
    }
    .info-table td {
        vertical-align: top;
        padding: 4px 0;
        line-height: 1.5;
    }
    .info-table .label { width: 180px; }
    .info-table .colon { width: 20px; text-align: center; }

    /* TTD */
    .signature {
        width: 100%;
        display: flex;
        justify-content: flex-end;
        margin-top: 40px;
    }
    .signature-box {
        text-align: center;
        width: 380px;
    }
    .signature .place-date {
        text-align: left;
        font-size: 12pt;
        margin-bottom: 2px;
        margin-left: 100px;
    }
    .signature .jabatan {
        text-align: center;
        font-size: 12pt;
        margin-bottom: 0;
    }

    /* TTE IMAGE — DIPERBESAR */
    .tte-image {
        display: block;
        margin: 4px auto;
        max-width: 340px;
        width: 100%;
        height: auto;
        object-fit: contain;
    }

    /* MODAL */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        font-family: system-ui, sans-serif;
    }
    .modal-overlay.active { display: flex; }

    .modal-card {
        background: white;
        border-radius: 16px;
        width: 90%;
        max-width: 480px;
        padding: 28px;
        box-shadow: 0 20px 60px rgba(0,0,0,.3);
        animation: slideDown .3s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-title {
        font-size: 18px;
        font-weight: 800;
        color: #111827;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .modal-desc {
        font-size: 13px;
        color: #6B7280;
        margin-bottom: 20px;
    }
    .modal-label {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }
    .modal-input {
        width: 100%;
        border: 1.5px solid #dbe3ff;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 14px;
        font-family: system-ui, sans-serif;
        transition: all .2s;
    }
    .modal-input:focus {
        outline: none;
        border-color: #2563EB;
        box-shadow: 0 0 0 4px rgba(37,99,235,.1);
    }
    .modal-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
    }
    .modal-actions .btn {
        font-family: system-ui, sans-serif;
    }

    @media print {
        *, *::before, *::after { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        nav, header, footer, .navbar, .sidebar, .main-header, .main-sidebar, .controls,
        .mobile-header, .user-info, .dropdown-menu, .logout-section, .sidebar-header, .sidebar-content,
        .modal-overlay { display: none !important; }
        body { background: white !important; }
        .print-wrapper { width: 100% !important; margin: 0 !important; padding: 2.5cm !important; box-shadow: none !important; min-height: auto !important; }
        main { margin: 0 !important; padding: 0 !important; max-width: 100% !important; }
    }
</style>

<div class="print-wrapper">
    <div>
        <!-- TOMBOL -->
        <div class="controls">
            <a href="{{ route('tu.mutasi.laporan-surat') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="button" class="btn btn-warning" onclick="openModalNomor()">
                <i class="fas fa-edit"></i> Edit Nomor Surat
            </button>
            <button type="button" class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>

        <!-- KOP SURAT -->
        <table class="kop-surat">
            <tr>
                <td style="width: 120px; vertical-align: middle; padding-right: 12px;">
                    <img src="{{ asset('images/Logo Jawa Barat.jpeg') }}" alt="Logo"
                         style="width: 100px; height: auto; display: block;"
                         onerror="this.style.display='none'">
                </td>
                <td style="vertical-align: middle; text-align: center; line-height: 1.15;">
                    <div style="font-size: 14pt; font-weight: normal;">PEMERINTAH DAERAH PROVINSI JAWA BARAT</div>
                    <div style="font-size: 14pt; font-weight: normal;">DINAS PENDIDIKAN</div>
                    <div style="font-size: 14pt; font-weight: normal;">CABANG DINAS PENDIDIKAN WILAYAH XIII</div>
                    <div style="font-size: 16pt; font-weight: bold; letter-spacing: 1px;">SMK NEGERI 1 KAWALI</div>
                    <div style="font-size: 9pt; margin-top: 2px;">Jalan Talagasari No. 35 Telp. (0265) 791727 Fax. (0265) 2797676</div>
                    <div style="font-size: 9pt;">e-mail : smkn1kawali@gmail.com</div>
                    <div style="font-size: 9pt;">Kawali - 46253</div>
                </td>
            </tr>
        </table>

        <!-- JUDUL -->
        <div class="title-surat">SURAT KETERANGAN KELUAR / PINDAH SISWA</div>
        <div class="nomor-surat">
            No. <span id="nomorSuratText">{{ $mutasi->no_sk_keluar ?? '-' }}</span>
        </div>

        <!-- ISI -->
        <div class="content">
            <p>Yang bertandatangan di bawah ini, Kepala SMK Negeri 1 Kawali Kabupaten Ciamis menerangkan dengan sesungguhnya bahwa :</p>

            <table class="info-table">
                <tr>
                    <td class="label">Nama</td>
                    <td class="colon">:</td>
                    <td>{{ strtoupper($mutasi->siswa->nama_lengkap ?? '-') }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td class="colon">:</td>
                    <td>{{ $mutasi->siswa->jenisKelamin->nama ?? $mutasi->siswa->jenis_kelamin ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Agama</td>
                    <td class="colon">:</td>
                    <td>{{ $mutasi->siswa->agama->nama ?? $mutasi->siswa->agama_lainnya ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">NIS/NISN</td>
                    <td class="colon">:</td>
                    <td>{{ $mutasi->siswa->nis ?? '-' }} / {{ $mutasi->siswa->nisn ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tempat, Tanggal Lahir</td>
                    <td class="colon">:</td>
                    <td>
                        {{ $mutasi->siswa->tempat_lahir ?? '-' }},
                        {{ $mutasi->siswa->tanggal_lahir ? \Carbon\Carbon::parse($mutasi->siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Kelas</td>
                    <td class="colon">:</td>
                    <td>{{ $rombel->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Program Keahlian</td>
                    <td class="colon">:</td>
                    <td>{{ $rombel->kelas->jurusan->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Nama Orang Tua / Wali</td>
                    <td class="colon">:</td>
                    <td>{{ $mutasi->siswa->nama_ayah ?? $mutasi->siswa->nama_wali ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Keluar / Pindah</td>
                    <td class="colon">:</td>
                    <td>Pindah</td>
                </tr>
                <tr>
                    <td class="label">Alasan Pindah</td>
                    <td class="colon">:</td>
                    <td>{{ $mutasi->alasan_pindah ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Keterangan</td>
                    <td class="colon">:</td>
                    <td>Pindah ke {{ $mutasi->tujuan_pindah ?? '-' }}</td>
                </tr>
            </table>

            <p>Demikian Surat Keterangan ini dibuat, untuk digunakan sebagaimana mestinya.</p>
        </div>
    </div>

    <!-- TTD -->
    <div>
        <div class="signature">
            <div class="signature-box">
                <div class="place-date">Kawali, {{ $mutasi->tanggal_mutasi ? \Carbon\Carbon::parse($mutasi->tanggal_mutasi)->translatedFormat('d F Y') : '-' }}</div>
                {{-- TTE IMAGE --}}
                @php
                    $ttePath = public_path('images/tte-kepsek.png');
                    $tteSrc = file_exists($ttePath)
                        ? 'data:image/png;base64,' . base64_encode(file_get_contents($ttePath))
                        : null;
                @endphp
                @if($tteSrc)
                    <img src="{{ $tteSrc }}" alt="TTE Kepala Sekolah" class="tte-image">
                @else
                    <div style="height: 110px;"></div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT NOMOR SURAT -->
<div class="modal-overlay" id="modalNomor">
    <div class="modal-card">
        <div class="modal-title">
            <i class="fas fa-edit" style="color:#2563EB;"></i>
            Edit Nomor Surat
        </div>
        <div class="modal-desc">Masukkan nomor surat sesuai format yang berlaku.</div>

        <form id="formNomorSurat">
            <label class="modal-label">Nomor Surat</label>
            <input type="text" name="no_sk_keluar" id="inputNoSurat"
                   class="modal-input"
                   value="{{ $mutasi->no_sk_keluar ?? '' }}"
                   placeholder="cth: 421.7/001/SMK.1.KW/2026"
                   required>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModalNomor()">Batal</button>
                <button type="submit" class="btn btn-primary" id="btnSubmitNomor">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const CSRF = '{{ csrf_token() }}';
    const UPDATE_URL = '{{ route("tu.mutasi.surat.update-nomor", ["id" => $mutasi->id]) }}';

    function openModalNomor() {
        document.getElementById('modalNomor').classList.add('active');
        document.getElementById('inputNoSurat').focus();
    }

    function closeModalNomor() {
        document.getElementById('modalNomor').classList.remove('active');
    }

    document.getElementById('formNomorSurat').addEventListener('submit', function(e) {
        e.preventDefault();

        const btn = document.getElementById('btnSubmitNomor');
        const value = document.getElementById('inputNoSurat').value.trim();

        if (!value) {
            alert('Nomor surat tidak boleh kosong.');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

        fetch(UPDATE_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ no_sk_keluar: value })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save"></i> Simpan';

            if (data.success) {
                document.getElementById('nomorSuratText').textContent = data.no_sk_keluar;
                closeModalNomor();
            } else {
                alert('Gagal: ' + data.message);
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save"></i> Simpan';
            alert('Error: ' + err.message);
        });
    });

    document.getElementById('modalNomor').addEventListener('click', function(e) {
        if (e.target === this) closeModalNomor();
    });
</script>

@endsection