@extends('layouts.app')

@section('title', 'Buku Induk - ' . $siswa->nama_lengkap)

@section('content')
<style>
    :root {
        --primary: #4F46E5;
        --primary-light: #6366F1;
        --secondary: #7C3AED;
        --success: #10B981;
        --danger: #EF4444;
        --warning: #F59E0B;
        --info: #3B82F6;
        --bg: #F4F7FE;
        --card: #FFFFFF;
        --border: #E5E7EB;
        --text: #111827;
        --text-light: #6B7280;
        --shadow-sm: 0 2px 8px rgba(15,23,42,.05);
        --shadow-md: 0 10px 25px rgba(15,23,42,.08);
        --shadow-lg: 0 18px 35px rgba(15,23,42,.12);
        --radius: 20px;
        --transition: all .25s ease;
    }

    body {
        background: linear-gradient(180deg, #f8faff 0%, #eef2ff 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* ================= PAGE HEADER ================= */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-size: clamp(24px, 4vw, 32px);
        font-weight: 800;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
    }

    .page-title i {
        color: var(--primary);
        font-size: 28px;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-modern {
        border-radius: 14px;
        padding: 10px 22px;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: transform .2s ease, box-shadow .2s ease;
        box-shadow: var(--shadow-sm);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-modern:active {
        transform: scale(.98);
    }

    .btn-secondary {
        background: white;
        color: var(--text);
        border: 1.5px solid var(--border);
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--secondary), var(--primary));
        box-shadow: 0 8px 20px rgba(79, 70, 229, .35);
    }

    /* ================= CARD UTAMA ================= */
    .main-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,.04);
    }

    .main-card .card-body {
        padding: 0;
    }

    /* ================= HEADER BUKU INDUK ================= */
    .buku-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        padding: 32px 36px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .buku-header::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,.06);
        border-radius: 50%;
        top: -120px;
        right: -80px;
    }

    .buku-header::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,.04);
        border-radius: 50%;
        bottom: -80px;
        left: -60px;
    }

    .buku-header h2 {
        font-size: clamp(22px, 4vw, 30px);
        font-weight: 800;
        color: white;
        margin: 0 0 6px 0;
        position: relative;
        z-index: 1;
        letter-spacing: 2px;
    }

    .buku-header h4 {
        font-size: clamp(16px, 2.5vw, 22px);
        font-weight: 600;
        color: rgba(255,255,255,.9);
        margin: 0 0 4px 0;
        position: relative;
        z-index: 1;
    }

    .buku-header p {
        font-size: 14px;
        color: rgba(255,255,255,.75);
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .buku-header .jurusan-badge {
        display: inline-block;
        background: rgba(255,255,255,.15);
        backdrop-filter: blur(8px);
        padding: 6px 18px;
        border-radius: 30px;
        color: white;
        font-size: 13px;
        font-weight: 600;
        margin-top: 10px;
        border: 1px solid rgba(255,255,255,.1);
        position: relative;
        z-index: 1;
    }

    /* ================= KONTEN ================= */
    .buku-content {
        padding: 30px 36px;
    }

    /* ================= FOTO ================= */
    .foto-wrapper {
        display: flex;
            flex-direction: column;
        align-items: center;
        margin-bottom: 24px;
    }

    .foto-siswa {
        width: 160px;
        height: 210px;
        border-radius: 16px;
        object-fit: cover;
        box-shadow: 0 8px 24px rgba(0,0,0,.12);
        border: 3px solid white;
        background: #f1f5f9;
        transition: transform .3s ease;
    }

    .foto-siswa:hover {
        transform: scale(1.03);
    }

    .foto-placeholder {
        width: 160px;
        height: 210px;
        border-radius: 16px;
        background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid white;
        box-shadow: 0 8px 24px rgba(0,0,0,.08);
    }

    .foto-placeholder i {
        font-size: 56px;
        color: #94a3b8;
    }

    /* ================= SECTION ================= */
    .section-card {
        background: #fafcff;
        border-radius: 16px;
        padding: 22px 26px;
        margin-bottom: 20px;
        border: 1px solid #f1f5f9;
        transition: var(--transition);
    }

    .section-card:hover {
        border-color: rgba(79, 70, 229, .15);
        box-shadow: var(--shadow-sm);
    }

    .section-title {
        font-size: 17px;
        font-weight: 700;
        color: var(--primary);
        margin: 0 0 16px 0;
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f1f5f9;
    }

    .section-title i {
        font-size: 18px;
    }

    .section-title .badge-count {
        background: var(--primary);
        color: white;
        font-size: 11px;
        padding: 2px 10px;
        border-radius: 30px;
        font-weight: 600;
        margin-left: auto;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 8px 24px;
    }

    .info-item {
        display: flex;
        align-items: baseline;
        gap: 8px;
        padding: 6px 0;
        font-size: 14px;
        color: var(--text);
        border-bottom: 1px solid rgba(0,0,0,.03);
    }

    .info-item .label {
        font-weight: 600;
        color: var(--text-light);
        min-width: 110px;
        font-size: 13px;
        flex-shrink: 0;
    }

    .info-item .value {
        font-weight: 500;
        color: var(--text);
        word-break: break-word;
    }

    .info-item .value .badge-status {
        display: inline-block;
        padding: 3px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-status-aktif {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-status-pindah {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-status-keluar {
        background: #fee2e2;
        color: #991b1b;
    }

    /* ================= TABEL NILAI ================= */
    .nilai-container {
        background: #fafcff;
        border-radius: 16px;
        padding: 22px 26px;
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .nilai-container .section-title {
        margin-bottom: 16px;
    }

    .nilai-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .nilai-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 600px;
    }

    .nilai-table thead th {
        background: #f1f5f9;
        padding: 10px 12px;
        text-align: center;
        font-weight: 700;
        color: var(--text-light);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border: 1px solid var(--border);
    }

    .nilai-table tbody td {
        padding: 9px 12px;
        border: 1px solid var(--border);
        vertical-align: middle;
    }

    .nilai-table tbody tr:hover {
        background: #f8fafc;
    }

    .nilai-table .header-row td {
        background: #f8fafc;
        font-weight: 700;
        color: var(--text);
        font-size: 13px;
    }

    .nilai-table .mapel-name {
        font-weight: 500;
        color: var(--text);
    }

    .nilai-table .nilai-angka {
        text-align: center;
        font-weight: 600;
    }

    .nilai-table .nilai-kosong {
        text-align: center;
        color: #94a3b8;
        font-size: 12px;
    }

    /* ================= EMPTY ================= */
    .empty-nilai {
        text-align: center;
        padding: 30px 20px;
        color: var(--text-light);
    }

    .empty-nilai i {
        font-size: 40px;
        color: #cbd5e1;
        margin-bottom: 12px;
    }

    .empty-nilai h6 {
        font-weight: 600;
        color: var(--text);
        margin: 0 0 4px 0;
    }

    .empty-nilai p {
        margin: 0;
        font-size: 14px;
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .action-buttons {
            justify-content: stretch;
        }

        .action-buttons .btn-modern {
            flex: 1;
            justify-content: center;
            font-size: 13px;
        }

        .buku-content {
            padding: 20px 16px;
        }

        .buku-header {
            padding: 24px 20px;
        }

        .section-card {
            padding: 16px 18px;
        }

        .nilai-container {
            padding: 16px 18px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .info-item .label {
            min-width: 100px;
            font-size: 12px;
        }

        .info-item .value {
            font-size: 13px;
        }

        .foto-siswa,
        .foto-placeholder {
            width: 120px;
            height: 160px;
        }

        .nilai-table {
            font-size: 11px;
            min-width: 480px;
        }

        .nilai-table thead th {
            padding: 6px 8px;
            font-size: 10px;
        }

        .nilai-table tbody td {
            padding: 6px 8px;
        }
    }

    @media (max-width: 480px) {
        .buku-content {
            padding: 14px 12px;
        }

        .section-card {
            padding: 14px 14px;
        }

        .nilai-container {
            padding: 14px 14px;
        }

        .info-item {
            flex-direction: column;
            gap: 2px;
            padding: 8px 0;
        }

        .info-item .label {
            min-width: auto;
            font-size: 12px;
        }

        .foto-siswa,
        .foto-placeholder {
            width: 100px;
            height: 140px;
        }

        .btn-modern {
            font-size: 12px;
            padding: 8px 14px;
        }
    }

    /* ================= PRINT ================= */
    @media print {
        body {
            background: white !important;
        }

        .page-header,
        .action-buttons,
        .btn-modern {
            display: none !important;
        }

        .main-card {
            box-shadow: none !important;
            border: 1px solid #ddd;
        }

        .buku-header {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .section-card {
            background: white !important;
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }

        .nilai-container {
            background: white !important;
            border: 1px solid #ddd !important;
        }

        .buku-content {
            padding: 20px 24px;
        }

        .nilai-table thead th {
            background: #f1f5f9 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .nilai-table .header-row td {
            background: #f8fafc !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .foto-siswa {
            border: 2px solid #ddd;
        }

        .badge-status-aktif,
        .badge-status-pindah,
        .badge-status-keluar {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @page {
            margin: 1.5cm;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-book-open"></i> Buku Induk Siswa
        </h1>
        <div class="action-buttons">
            <a href="{{ route('tu.buku-induk.index') }}" class="btn-modern btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('tu.buku-induk.edit', $siswa->id) }}" class="btn-modern btn-secondary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('tu.buku-induk.cetak', $siswa) }}" target="_blank" class="btn-modern btn-primary">
                <i class="fas fa-print"></i> Cetak PDF
            </a>
        </div>
    </div>

    {{-- MAIN CARD --}}
    <div class="main-card">
        <div class="card-body">

            {{-- HEADER BUKU INDUK --}}
            <div class="buku-header">
                <h2>📘 BUKU INDUK SISWA</h2>
                <h4>SMKN 1 KAWALI</h4>
                <p>Konsentrasi Keahlian</p>
                <span class="jurusan-badge">
                    <i class="fas fa-graduation-cap me-2"></i>
                    {{ $siswa->rombel && $siswa->rombel->kelas && $siswa->rombel->kelas->jurusan ? $siswa->rombel->kelas->jurusan->nama : 'REKAYASA PERANGKAT LUNAK' }}
                </span>
            </div>

            {{-- KONTEN --}}
            <div class="buku-content">

                {{-- FOTO & DATA PRIBADI --}}
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="foto-wrapper">
                            @php
                                $photoPath = $siswa->user->photo ?? null;
                                $storagePhoto = null;
                                if ($photoPath) {
                                    $storagePhoto = strpos($photoPath, 'foto-siswa/') === 0 ? $photoPath : 'foto-siswa/' . basename($photoPath);
                                }
                            @endphp
                            @if($storagePhoto)
                                <img src="{{ asset('storage/' . $storagePhoto) }}" alt="{{ $siswa->nama_lengkap }}" class="foto-siswa">
                            @else
                                <div class="foto-placeholder">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                            @endif
                            <div style="margin-top: 12px; text-align: center;">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill" style="font-size: 12px; font-weight: 600;">
                                    <i class="fas fa-id-card me-1"></i> NIS: {{ $siswa->nis }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">

                        {{-- A. DATA PRIBADI --}}
                        <div class="section-card">
                            <div class="section-title">
                                <i class="fas fa-user-circle text-primary"></i>
                                A. DATA PRIBADI SISWA
                            </div>
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="label">NIS</span>
                                    <span class="value"><strong>{{ $siswa->nis }}</strong></span>
                                </div>
                                <div class="info-item">
                                    <span class="label">NISN</span>
                                    <span class="value">{{ $siswa->nisn ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Nama Lengkap</span>
                                    <span class="value"><strong>{{ $siswa->nama_lengkap }}</strong></span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Jenis Kelamin</span>
                                    <span class="value">
                                        @if($siswa->jenis_kelamin == 'L')
                                            <i class="fas fa-mars text-primary"></i> Laki-laki
                                        @else
                                            <i class="fas fa-venus text-danger"></i> Perempuan
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Tempat Lahir</span>
                                    <span class="value">{{ $siswa->tempat_lahir ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Tanggal Lahir</span>
                                    <span class="value">{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('D MMMM Y') : '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Agama</span>
                                    <span class="value">{{ $siswa->agama ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Kewarganegaraan</span>
                                    <span class="value">{{ $siswa->kewarganegaraan ?? '-' }}</span>
                                </div>
                                @php
                                    $addressParts = [];
                                    if ($siswa->dusun) {
                                        $addressParts[] = $siswa->dusun;
                                    }
                                    if ($siswa->kelurahan) {
                                        $addressParts[] = $siswa->kelurahan;
                                    }
                                    if ($siswa->kecamatan) {
                                        $addressParts[] = $siswa->kecamatan;
                                    }
                                    $rtRwParts = [];
                                    if ($siswa->rt) {
                                        $rtRwParts[] = 'RT ' . $siswa->rt;
                                    }
                                    if ($siswa->rw) {
                                        $rtRwParts[] = 'RW ' . $siswa->rw;
                                    }
                                    if (!empty($rtRwParts)) {
                                        $addressParts[] = implode(' / ', $rtRwParts);
                                    }
                                    if ($siswa->kode_pos) {
                                        $addressParts[] = 'Kode Pos ' . $siswa->kode_pos;
                                    }
                                    $alamatText = !empty($addressParts) ? implode(', ', $addressParts) : '-';
                                @endphp
                                <div class="info-item" style="grid-column: 1 / -1;">
                                    <span class="label">Alamat</span>
                                    <span class="value">{{ $alamatText }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- B. ORANG TUA --}}
                        <div class="section-card">
                            <div class="section-title">
                                <i class="fas fa-users text-success"></i>
                                B. DATA ORANG TUA / WALI
                            </div>
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="label">Nama Ayah</span>
                                    <span class="value">{{ $siswa->ayah->nama ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Pekerjaan Ayah</span>
                                    <span class="value">{{ $siswa->ayah->pekerjaan ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Nama Ibu</span>
                                    <span class="value">{{ $siswa->ibu->nama ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Pekerjaan Ibu</span>
                                    <span class="value">{{ $siswa->ibu->pekerjaan ?? '-' }}</span>
                                </div>
                                <div class="info-item" style="grid-column: 1 / -1;">
                                    <span class="label">Alamat Orang Tua</span>
                                    <span class="value">{{ $siswa->ayah->alamat ?? $siswa->ibu->alamat ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Nama Wali</span>
                                    <span class="value">{{ $siswa->wali->nama ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Pekerjaan Wali</span>
                                    <span class="value">{{ $siswa->wali->pekerjaan ?? '-' }}</span>
                                </div>
                                <div class="info-item" style="grid-column: 1 / -1;">
                                    <span class="label">Alamat Wali</span>
                                    <span class="value">{{ $siswa->wali->alamat ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- C. PENDAFTARAN --}}
                        <div class="section-card">
                            <div class="section-title">
                                <i class="fas fa-pen-fancy text-warning"></i>
                                C. DATA PENDAFTARAN
                            </div>
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="label">Sekolah Asal</span>
                                    <span class="value">{{ $siswa->sekolah_asal ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Tanggal Diterima</span>
                                    <span class="value">{{ $siswa->tanggal_diterima ? \Carbon\Carbon::parse($siswa->tanggal_diterima)->isoFormat('D MMMM Y') : '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Status Keluarga</span>
                                    <span class="value">{{ $siswa->status_keluarga ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Anak Ke-</span>
                                    <span class="value">{{ $siswa->anak_ke ?? '-' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="label">No. HP</span>
                                    <span class="value">{{ $siswa->no_hp ?? '-' }}</span>
                                </div>
                                <div class="info-item" style="grid-column: 1 / -1;">
                                    <span class="label">Catatan Wali Kelas</span>
                                    <span class="value">{{ $siswa->catatan_wali_kelas ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- D. STATUS MUTASI --}}
                        <div class="section-card">
                            <div class="section-title">
                                <i class="fas fa-exchange-alt text-danger"></i>
                                D. STATUS MUTASI
                            </div>
                            <div class="info-grid">
                                @if($siswa->mutasiTerakhir)
                                    <div class="info-item">
                                        <span class="label">Status</span>
                                        <span class="value">
                                            <span class="badge-status badge-status-{{ $siswa->mutasiTerakhir->status_color ?? 'aktif' }}">
                                                {{ $siswa->mutasiTerakhir->status_label ?? 'Aktif' }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <span class="label">Tanggal Mutasi</span>
                                        <span class="value">{{ $siswa->mutasiTerakhir->tanggal_mutasi ? \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_mutasi)->isoFormat('D MMMM Y') : '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="label">Keterangan</span>
                                        <span class="value">{{ $siswa->mutasiTerakhir->keterangan ?? '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="label">Alasan Pindah</span>
                                        <span class="value">{{ $siswa->mutasiTerakhir->alasan_pindah ?? '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="label">Sekolah Tujuan</span>
                                        <span class="value">{{ $siswa->mutasiTerakhir->tujuan_pindah ?? '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="label">No. SK Keluar</span>
                                        <span class="value">{{ $siswa->mutasiTerakhir->no_sk_keluar ?? '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="label">Tanggal SK Keluar</span>
                                        <span class="value">{{ $siswa->mutasiTerakhir->tanggal_sk_keluar ? \Carbon\Carbon::parse($siswa->mutasiTerakhir->tanggal_sk_keluar)->isoFormat('D MMMM Y') : '-' }}</span>
                                    </div>
                                @else
                                    <div class="info-item" style="grid-column: 1 / -1;">
                                        <span class="label">Status</span>
                                        <span class="value">
                                            <span class="badge-status badge-status-aktif">Aktif</span>
                                        </span>
                                    </div>
                                    <div class="info-item" style="grid-column: 1 / -1;">
                                        <span class="label">Keterangan</span>
                                        <span class="value">Siswa masih aktif di sekolah</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                {{-- E. NILAI RAPORT --}}
                <div class="nilai-container" style="margin-top: 24px;">
                    <div class="section-title">
                        <i class="fas fa-chart-bar text-info"></i>
                        E. HASIL PRESTASI PEMBELAJARAN
                        <span class="badge-count">{{ count($nilaiByKelompok['byKelompok'] ?? []) }} Kelompok</span>
                    </div>

                    <div class="nilai-wrapper">
                        <table class="nilai-table">
                            <thead>
                                <tr>
                                    <th rowspan="3" style="min-width: 180px; text-align: left;">MATA PELAJARAN</th>
                                    @foreach($nilaiByKelompok['tahunAjaranList'] ?? [] as $tahunAjaran)
                                        <th colspan="2" class="text-center">{{ $tahunAjaran }}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($nilaiByKelompok['tahunAjaranList'] ?? [] as $tahunAjaran)
                                        <th class="text-center" style="width: 45px;">1</th>
                                        <th class="text-center" style="width: 45px;">2</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($nilaiByKelompok['tahunAjaranList'] ?? [] as $tahunAjaran)
                                        <th class="text-center">Nilai</th>
                                        <th class="text-center">Nilai</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($nilaiByKelompok['byKelompok']) && count($nilaiByKelompok['byKelompok']) > 0)
                                    @foreach($nilaiByKelompok['byKelompok'] as $kelompok => $mapelGroup)
                                        <tr class="header-row">
                                            <td colspan="{{ 1 + (count($nilaiByKelompok['tahunAjaranList'] ?? []) * 2) }}">
                                                @if($kelompok === 'A')
                                                    A. KELOMPOK MATA PELAJARAN UMUM
                                                @elseif($kelompok === 'B')
                                                    B. KELOMPOK MATA PELAJARAN KEAHLIAN
                                                @else
                                                    {{ strtoupper($kelompok) }}
                                                @endif
                                            </td>
                                        </tr>
                                        @foreach($mapelGroup as $mapelNama => $mapelData)
                                            <tr>
                                                <td class="mapel-name">{{ $mapelData['nama'] ?? $mapelNama }}</td>
                                                @foreach($nilaiByKelompok['tahunAjaranList'] ?? [] as $tahunAjaran)
                                                    <td class="nilai-angka">
                                                        {{ $mapelData['nilai'][$tahunAjaran][1] ?? '-' }}
                                                    </td>
                                                    <td class="nilai-angka">
                                                        {{ $mapelData['nilai'][$tahunAjaran][2] ?? '-' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="{{ 1 + (count($nilaiByKelompok['tahunAjaranList'] ?? []) * 2) }}">
                                            <div class="empty-nilai">
                                                <i class="fas fa-file-alt"></i>
                                                <h6>Belum Ada Data Nilai</h6>
                                                <p>Data nilai raport siswa belum tersedia</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            {{-- end buku-content --}}

        </div>
        {{-- end card-body --}}
    </div>
    {{-- end main-card --}}

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hover effect for section cards
    document.querySelectorAll('.section-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'border-color 0.3s ease, box-shadow 0.3s ease';
        });
    });

    // Print button handling
    const printBtn = document.querySelector('a[href*="cetak"]');
    if (printBtn) {
        printBtn.addEventListener('click', function() {
            // Optional: add loading indicator
        });
    }
});
</script>
@endpush
@endsection