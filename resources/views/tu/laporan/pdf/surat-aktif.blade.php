@extends('layouts.app')

@section('title', 'Surat Keterangan Aktif - ' . ($siswa->nama_lengkap ?? 'Siswa'))

@section('content')

<style>
    @page {
        size: A4 portrait;
        margin: 2.5cm;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-size: 12pt;
        color: #000;
        margin: 0;
        padding: 0;
        line-height: 1.7;
        background: #e5e7eb;
    }
    
    .print-wrapper {
        font-family: 'Times New Roman', Times, serif;
        width: 210mm;
        min-height: 297mm;
        margin: 20px auto;
        padding: 0;
        background: white;
        box-shadow: 0 0 10px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 2.5cm;
    }

    /* TOMBOL KEMBALI & PRINT */
    .controls {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .controls .btn {
        border-radius: 6px;
        font-weight: 600;
        padding: 6px 14px;
        font-size: 9pt;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid #d1d5db;
        font-family: system-ui, -apple-system, sans-serif;
    }

    .btn-secondary {
        background: white;
        color: #111827;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
        border-color: #2563eb;
    }

    .btn-primary:hover { background: #1d4ed8; }
    .btn-secondary:hover { background: #f3f4f6; }

    /* ============================================
       KOP SURAT - TANPA BORDER KOTAK
       ============================================ */
    .kop-surat {
        width: 100%;
        margin-bottom: 15px;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
    }

    .kop-surat .logo-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .kop-surat .logo {
        width: 140px;
        height: auto;
        flex-shrink: 0;
    }

    .kop-surat .logo img {
        width: 100%;
        height: auto;
        display: block;
    }

    .kop-surat .kop-text {
        flex: 1;
        text-align: center;
margin-right: 60px;
    }

    .kop-surat .kop-text .pemda {
        font-size: 14pt;
        font-weight: normal;
        margin: 0;
        line-height: 1.0;
    }

    .kop-surat .kop-text .dinas {
        font-size: 14pt;
        font-weight: normal;
        margin: 0;
        line-height: 1.0;
    }

    .kop-surat .kop-text .cabang {
        font-size: 14pt;
        font-weight: normal;
        margin: 0;
        line-height: 1.0;
    }

    .kop-surat .kop-text .sekolah {
        font-size: 16pt;
        font-weight: bold;
        letter-spacing: 1px;
        margin: 0;
        line-height: 1.0;
    }

    .kop-surat .kop-text .alamat {
        font-size: 9pt;
        margin: 2px 0;
        line-height: 1.0;
    }

    .kop-surat .kop-text .email {
        font-size: 9pt;
        margin: 1px 0;
        line-height: 1.0;
    }

    /* ============================================
       JUDUL SURAT
       ============================================ */
    .title-surat {
        text-align: center;
        font-size: 13pt;
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 0.5px;
        text-decoration: underline;
        letter-spacing: 1px;
    }

    .nomor-surat {
        text-align: center;
        font-size: 12pt;
        margin-top: 0px;
        margin-bottom: 45px;
        line-height: 0.5;
    }

    /* ============================================
       ISI SURAT
       ============================================ */
    .content {
    margin-top: 12px;
    font-size: 12pt;
    line-height: 1.0;
}

.content p {
    text-align: justify;
    margin: 0 0 10px 0;
    text-indent: 40px;
    line-height: 1.3;
    margin-bottom: 50px;
}

.content p.no-indent {
    text-indent: 0;
    margin-top: 0;
    margin-bottom: 0px;

}
    .info-table {
        width: 100%;
        margin-top: 5px;
        margin-bottom: 20px;
        border-collapse: collapse;
        border: none;
        margin-left: 50px;
    }

    .info-table td {
        vertical-align: top;
        padding: 2px 0;
        border: none;
    }

    .info-table .label {
        width: 160px;
        font-weight: normal;
        padding-right: 5px;
    }

    .info-table .colon {
        width: 20px;
        text-align: center;
    }

    /* ============================================
       TANDA TANGAN
       ============================================ */
    .signature {
        width: 100%;
        display: flex;
        justify-content: flex-end;
    }

    .signature-box {
        text-align: center;
        width: 250px;
        margin-bottom: 30px;
    }

    .signature .place-date {
        text-align: left;
        font-size: 12pt;
        padding-left: 5px;
    }

    .signature .jabatan {
        text-align: center;
        font-size: 12pt;
        margin-bottom: 170px;
    }

    .signature .nama-ttd {
        margin-top: 5px;
        font-weight: bold;
        text-decoration: underline;
        font-size: 12pt;
    }

    .signature .nip {
        font-size: 11pt;
        margin-top: 2px;
    }

/* ============================================
   RESPONSIVE & PRINT
   ============================================ */
@media print {
    /* Mencegah browser menghilangkan background-image atau warna saat print */
    *, *::before, *::after {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    /* Sembunyikan navigasi & komponen layout yang spesifik saja */
    nav, header, footer, .navbar, .sidebar, .main-header,
    .main-sidebar, .controls, .mobile-header, .user-info,
    .user-panel, .profile-image, .user-avatar, .img-circle,
    .user-image, .dropdown-menu, .logout-section,
    .sidebar-header, .sidebar-content, .brand, .brand-text,
    .sidebar-overlay, #sidebarOverlay, #sidebarBackdrop {
        display: none !important;
    }

    /* Sembunyikan HANYA foto profil yang menggunakan class spesifik ini */
    img.profile-image, 
    img.user-avatar, 
    img.user-image {
        display: none !important;
    }

    /* Pastikan gambar dokumen/konten utama tetap terlihat fleksibel */
    img {
        max-width: 100% !important;
        display: inline-block !important;
    }

    body {
        background: white !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .no-indent-print {
        margin-bottom: 70px !important;
    }

    .print-wrapper {
        width: 100% !important;
        margin: 0 !important;
        padding: 2.5cm !important;
        box-shadow: none !important;
        min-height: auto !important;
    }

    .container-fluid, .row {
        margin: 0 !important;
        padding: 0 !important;
    }

    main {
        margin: 0 !important;
        padding: 0 !important;
        max-width: 100% !important;
    }

    .kop-surat {
        border-bottom: 2px solid #000 !important;
    }

}
</style>

<div class="print-wrapper">
    <div>
        <!-- TOMBOL KEMBALI & PRINT -->
        <div class="controls">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="button" class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>

        <!-- ==========================================
             KOP SURAT - TANPA BORDER KOTAK
             ========================================== -->
        <div class="kop-surat">
            <div class="logo-wrapper">
                <div class="logo">
                    <img src="{{ asset('images/Logo Jawa Barat.jpeg') }}" alt="Logo Jawa Barat.png" onerror="this.style.display='none'">
                </div>
                <div class="kop-text">
                    <p class="pemda">PEMERINTAH DAERAH PROVINSI JAWA BARAT</p>
                    <p class="dinas">DINAS PENDIDIKAN</p>
                    <p class="cabang">CABANG DINAS PENDIDIKAN WILAYAH XIII</p>
                    <p class="sekolah">SMK NEGERI 1 KAWALI</p>
                    <p class="alamat">Jalan Talagasari No. 35 Telp. (0265) 791727 Fax. (0265) 2797676</p>
                    <p class="email">e-mail : smkn1kawali@gmail.com</p>
                    <p class="alamat">Kawali - 46253</p>
                </div>
            </div>
        </div>

        <!-- ==========================================
             JUDUL SURAT
             ========================================== -->
        <div class="title-surat">SURAT KETERANGAN</div>
        <div class="nomor-surat">No. {{ $nomorSuratText ?? '421.7/001/SMK.1.KW/' . date('Y') }}</div>

        <!-- ==========================================
             ISI SURAT
             ========================================== -->
        <div class="content">
            <p class="no-indent" style="margin-bottom: 25px;">Yang bertandatangan di bawah ini, Kepala SMK Negeri 1 Kawali Kabupaten Ciamis, menerangkan dengan sesungguhnya bahwa :</p>

            <table class="info-table">
                <tr>
                    <td class="label">Nama</td>
                    <td class="colon">:</td>
                    <td>{{ strtoupper($siswa->nama_lengkap ?? $siswa->nama_siswa ?? 'ANDRI HERMAWAN') }}</td>
                </tr>
                <tr>
                    <td class="label">Tempat, Tanggal Lahir</td>
                    <td class="colon">:</td>
                    <td>
                        @php
                            $tempat = $siswa->tempat_lahir ? strtoupper($siswa->tempat_lahir) : 'CIAMIS';
                            $tanggalLahir = $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '07 Mei 2009';
                        @endphp
                        {{ $tempat }}, {{ $tanggalLahir }}
                    </td>
                </tr>
                <tr>
                    <td class="label">NISN</td>
                    <td class="colon">:</td>
                    <td>{{ $siswa->nisn ?? '0097179539' }}</td>
                </tr>
                <tr>
                    <td class="label">NIS</td>
                    <td class="colon">:</td>
                    <td>{{ $siswa->nis ?? '242510042' }}</td>
                </tr>
                <tr>
                    <td class="label">Kelas</td>
                    <td class="colon">:</td>
                    <td>{{ optional($siswa->rombel)->nama ?? 'X DPIB 2' }}</td>
                </tr>
                <tr>
                    <td class="label">Paket Keahlian</td>
                    <td class="colon">:</td>
                    <td>{{ strtoupper(optional(optional(optional($siswa->rombel)->kelas)->jurusan)->nama ?? 'Desain Pemodelan Dan Informasi Bangunan') }}</td>
                </tr>
            </table>

            <p class="no-indent">Siswa tersebut di atas benar-benar siswa SMK Negeri 1 Kawali kelas {{ optional($siswa->rombel->kelas)->tingkat ?? 'X' }} Tahun Pelajaran {{ $tahunPelajaran ?? '2024/2025' }}.</p>

            <p class="no-indent no-indent-print">Demikian Surat Keterangan ini dibuat untuk digunakan sebagaimana mestinya.</p>
        </div>
    </div>

    <!-- ==========================================
         TANDA TANGAN
         ========================================== -->
    <div>
        <div class="signature">
            <div class="signature-box">
                <div class="place-date">Kawali, {{ $tanggal ?? '17 Februari 2025' }}</div>
                <div class="jabatan">KEPALA SMK NEGERI 1 KAWALI</div>
                <div style="height:50px;"></div>
            </div>
        </div>

        
    </div>
</div>

@endsection